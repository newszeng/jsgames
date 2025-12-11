<?php
/**
 * 开放 Trackback WordPress 站点收集器
 * 自动发现和验证支持 trackback 的 WordPress 站点
 */

require_once 'trackback.php';

class TrackbackCollector {
    
    private $foundSites = [];
    private $debug;
    
    public function __construct($debug = false) {
        $this->debug = $debug;
    }
    
    /**
     * 通过 Google 搜索查找 WordPress 站点
     */
    public function getSearchQueries() {
        return [
            // 查找明确支持 trackback 的站点
            'WordPress搜索' => [
                '"powered by wordpress" "trackback" "leave a comment"',
                'site:wordpress.com "trackback url"',
                '"wordpress" "trackback" "rdf:description"',
                'inurl:blog "trackback" "powered by wordpress"',
                '"wp-content" "trackback" site:edu',
                '"wp-content" "trackback" site:org',
                'intitle:"blog" "trackback url" wordpress',
            ],
            
            // 查找有 RDF trackback 标记的页面
            'RDF标记搜索' => [
                '"rdf:description" "trackback:ping"',
                '"trackback:ping" "dc:identifier"',
                'filetype:html "trackback:ping"',
                '"rdf about" trackback ping',
            ],
            
            // 查找特定类型的博客
            '分类博客搜索' => [
                'site:*.edu inurl:blog "trackback"',
                'site:*.org inurl:blog "trackback"',
                'site:*.com inurl:blog "powered by wordpress" "trackback"',
                '"personal blog" wordpress trackback',
                '"tech blog" wordpress trackback enabled',
            ],
            
            // 查找旧版 WordPress 站点（更可能开放 trackback）
            '旧版站点搜索' => [
                '"wordpress 4" OR "wordpress 5" "trackback"',
                '"generator" "wordpress" "trackback" 2020..2022',
                'inurl:xmlrpc.php "trackback"',
                '"wp-trackback.php"',
            ]
        ];
    }
    
    /**
     * 验证单个 URL 是否支持 trackback
     */
    public function verifyTrackback($url, $testTitle = "Test Article", $testExcerpt = "Testing trackback functionality") {
        $this->log("验证: $url");
        
        $result = [
            'url' => $url,
            'supports_trackback' => false,
            'trackback_url' => null,
            'cms' => 'unknown',
            'last_post_date' => null,
            'error' => null
        ];
        
        try {
            // 获取页面内容
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 TrackbackCollector/1.0');
            curl_setopt($ch, CURLOPT_HEADER, true);
            
            $response = curl_exec($ch);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($response, 0, $headerSize);
            $html = substr($response, $headerSize);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode !== 200) {
                $result['error'] = "HTTP $httpCode";
                return $result;
            }
            
            // 检查是否是 WordPress
            if (stripos($html, 'wp-content') !== false || 
                stripos($headers, 'x-powered-by') !== false && stripos($headers, 'WordPress') !== false ||
                preg_match('/generator.*wordpress/i', $html)) {
                $result['cms'] = 'WordPress';
            }
            
            // 查找博客文章链接
            $postUrls = $this->extractPostUrls($html, $url);
            
            if (empty($postUrls)) {
                $result['error'] = '未找到博客文章';
                return $result;
            }
            
            // 测试第一篇文章的 trackback
            foreach (array_slice($postUrls, 0, 3) as $postUrl) {
                $trackbackSender = new TrackbackSender();
                $testSourceUrl = 'https://test-trackback-site.example.com/test-' . time();
                
                $trackbackResult = $trackbackSender->sendTrackback(
                    $postUrl, 
                    $testSourceUrl, 
                    $testTitle, 
                    $testExcerpt, 
                    'Test Blog'
                );
                
                if ($trackbackResult['success']) {
                    $result['supports_trackback'] = true;
                    $result['trackback_url'] = $trackbackResult['trackback_url'] ?? null;
                    $result['test_post_url'] = $postUrl;
                    $this->log("  ✅ Trackback 可用: $postUrl");
                    break;
                } else {
                    $this->log("  ❌ Trackback 失败: " . $trackbackResult['message']);
                    $result['error'] = $trackbackResult['message'];
                }
            }
            
        } catch (Exception $e) {
            $result['error'] = '异常: ' . $e->getMessage();
        }
        
        return $result;
    }
    
    /**
     * 从页面提取博客文章 URL
     */
    private function extractPostUrls($html, $baseUrl) {
        $urls = [];
        $baseHost = parse_url($baseUrl, PHP_URL_HOST);
        
        // 查找博客文章链接的模式
        $patterns = [
            '/<a[^>]+href=["\']([^"\']+\/\d{4}\/\d{2}\/\d{2}\/[^"\']+)["\'][^>]*>/i', // 日期格式
            '/<a[^>]+href=["\']([^"\']+\/blog\/[^"\']+)["\'][^>]*>/i', // /blog/ 路径
            '/<a[^>]+href=["\']([^"\']+\?p=\d+)["\'][^>]*>/i', // ?p=ID 格式
            '/<a[^>]+href=["\']([^"\']+\/post\/[^"\']+)["\'][^>]*>/i', // /post/ 路径
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $html, $matches)) {
                foreach ($matches[1] as $url) {
                    $fullUrl = $this->makeAbsoluteUrl($url, $baseUrl);
                    if ($fullUrl && parse_url($fullUrl, PHP_URL_HOST) === $baseHost) {
                        $urls[] = $fullUrl;
                    }
                }
            }
        }
        
        return array_unique($urls);
    }
    
    /**
     * 转换为绝对 URL
     */
    private function makeAbsoluteUrl($url, $baseUrl) {
        if (strpos($url, 'http') === 0) {
            return $url;
        }
        
        $base = parse_url($baseUrl);
        
        if ($url[0] === '/') {
            return $base['scheme'] . '://' . $base['host'] . $url;
        }
        
        return rtrim($baseUrl, '/') . '/' . ltrim($url, '/');
    }
    
    /**
     * 批量验证站点列表
     */
    public function batchVerify($urls) {
        $results = [];
        $successCount = 0;
        
        foreach ($urls as $url) {
            $result = $this->verifyTrackback($url);
            $results[] = $result;
            
            if ($result['supports_trackback']) {
                $successCount++;
                $this->foundSites[] = $result;
            }
            
            // 延迟避免被封禁
            sleep(rand(3, 8));
        }
        
        $this->log("\n=== 批量验证完成 ===");
        $this->log("总计: " . count($urls) . " 个站点");
        $this->log("支持 Trackback: $successCount 个");
        
        return $results;
    }
    
    /**
     * 从已知的 WordPress 目录获取站点
     */
    public function getWordPressSiteDirectories() {
        return [
            '教育机构' => [
                // 美国大学
                'https://blogs.harvard.edu',
                'https://blog.stanford.edu', 
                'https://blog.mit.edu',
                'https://sites.duke.edu/blog',
                'https://ctl.uaf.edu',
                'https://blog.berkeley.edu',
                
                // 其他教育机构
                'https://edublogs.org', // 教育博客平台
            ],
            
            '技术博客' => [
                'https://wordpress.org/news',
                'https://make.wordpress.org',
                'https://developer.wordpress.org/news',
            ],
            
            '个人博客示例' => [
                // 这些需要通过搜索发现
                'https://example-personal-blog.com',
                'https://myblog.wordpress.com',
            ]
        ];
    }
    
    /**
     * 保存发现的站点
     */
    public function saveFoundSites($filename = 'trackback_enabled_sites.json') {
        $data = [
            'generated_at' => date('Y-m-d H:i:s'),
            'total_found' => count($this->foundSites),
            'sites' => $this->foundSites,
            'search_tips' => $this->getSearchQueries()
        ];
        
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->log("结果保存到: $filename");
        
        return $filename;
    }
    
    /**
     * 生成站点报告
     */
    public function generateReport() {
        $report = [
            'summary' => [
                'total_sites' => count($this->foundSites),
                'by_cms' => [],
                'by_domain_type' => []
            ],
            'recommendations' => []
        ];
        
        foreach ($this->foundSites as $site) {
            // 按 CMS 分类
            $cms = $site['cms'];
            if (!isset($report['summary']['by_cms'][$cms])) {
                $report['summary']['by_cms'][$cms] = 0;
            }
            $report['summary']['by_cms'][$cms]++;
            
            // 按域名类型分类
            $domain = parse_url($site['url'], PHP_URL_HOST);
            $domainType = 'commercial';
            if (strpos($domain, '.edu') !== false) $domainType = 'educational';
            if (strpos($domain, '.org') !== false) $domainType = 'organization';
            if (strpos($domain, '.gov') !== false) $domainType = 'government';
            
            if (!isset($report['summary']['by_domain_type'][$domainType])) {
                $report['summary']['by_domain_type'][$domainType] = 0;
            }
            $report['summary']['by_domain_type'][$domainType]++;
        }
        
        return $report;
    }
    
    private function log($message) {
        if ($this->debug) {
            echo $message . "\n";
        }
    }
}

// ============ 使用示例 ============

$collector = new TrackbackCollector(true);

echo "=== WordPress Trackback 站点收集器 ===\n\n";

// 1. 显示搜索建议
echo "1. Google 搜索建议:\n\n";
$queries = $collector->getSearchQueries();
foreach ($queries as $category => $searchList) {
    echo "【$category】\n";
    foreach ($searchList as $query) {
        echo "  • $query\n";
    }
    echo "\n";
}

// 2. 测试一些已知站点
echo "2. 验证已知站点:\n\n";
$testSites = [
    'https://www.labrums.co.uk/blog/',
    'https://ctl.uaf.edu/',
];

$results = $collector->batchVerify($testSites);

// 3. 保存结果
$collector->saveFoundSites();

// 4. 生成报告
echo "\n3. 生成报告:\n";
$report = $collector->generateReport();
echo "发现支持 Trackback 的站点: " . $report['summary']['total_sites'] . " 个\n";

if (!empty($report['summary']['by_cms'])) {
    echo "\n按 CMS 分类:\n";
    foreach ($report['summary']['by_cms'] as $cms => $count) {
        echo "  $cms: $count 个\n";
    }
}

echo "\n=== 使用提示 ===\n";
echo "1. 使用上面的搜索查询在 Google 中查找更多站点\n";
echo "2. 运行 php trackback_collector.php 来批量验证站点\n";
echo "3. 结果会保存在 trackback_enabled_sites.json 文件中\n";
echo "4. 教育机构 (.edu) 网站通常更开放\n";
echo "5. 较老的 WordPress 站点更可能支持 trackback\n";

?>