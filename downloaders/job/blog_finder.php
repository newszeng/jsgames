<?php
/**
 * 博客发现和验证工具
 * 用于查找支持评论的高质量博客
 */

class BlogFinder {
    
    private $debug;
    private $results = [];
    
    public function __construct($debug = false) {
        $this->debug = $debug;
    }
    
    /**
     * 使用 Google 搜索查找相关博客
     */
    public function findBlogsByKeyword($keyword, $niche = '', $limit = 50) {
        $searchQueries = [
            // WordPress 博客
            '"leave a comment" "' . $keyword . '" ' . $niche,
            '"post a comment" "' . $keyword . '" ' . $niche,
            'intitle:"' . $keyword . '" "comments" site:wordpress.com',
            $keyword . ' "powered by wordpress" "leave a reply"',
            
            // 查找开启了 CommentLuv 的博客（自动添加评论者链接）
            '"commentluv enabled" ' . $keyword,
            '"this blog uses commentluv" ' . $keyword,
            
            // 查找 dofollow 博客
            '"notify me of followup comments" ' . $keyword,
            '"comment" "website" "email" ' . $keyword,
        ];
        
        $this->log("搜索关键词: $keyword, 细分领域: $niche\n");
        $this->log("提示: 可以使用以下 Google 搜索命令手动查找:\n");
        
        foreach ($searchQueries as $query) {
            $this->log("  - $query\n");
        }
        
        // 返回搜索建议
        return [
            'keyword' => $keyword,
            'niche' => $niche,
            'search_queries' => $searchQueries,
            'message' => '请在 Google 中使用这些搜索查询来查找博客'
        ];
    }
    
    /**
     * 验证博客是否支持评论
     */
    public function validateBlog($url) {
        $this->log("\n检查博客: $url\n");
        
        $result = [
            'url' => $url,
            'supports_comments' => false,
            'comment_system' => 'unknown',
            'requires_moderation' => true,
            'supports_trackback' => false,
            'supports_pingback' => false,
            'cms' => 'unknown',
            'quality_indicators' => []
        ];
        
        // 获取页面内容
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
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
        
        // 检查 CMS 类型
        if (stripos($html, 'wp-content') !== false || stripos($headers, 'x-powered-by: WordPress') !== false) {
            $result['cms'] = 'WordPress';
        } elseif (stripos($html, 'blogger.com') !== false) {
            $result['cms'] = 'Blogger';
        } elseif (stripos($html, 'drupal') !== false) {
            $result['cms'] = 'Drupal';
        } elseif (stripos($html, 'joomla') !== false) {
            $result['cms'] = 'Joomla';
        }
        
        // 检查评论系统
        if (preg_match('/<form[^>]*id=["\']commentform["\']|<form[^>]*class=["\'][^"\']*comment-form/', $html)) {
            $result['supports_comments'] = true;
            $result['comment_system'] = 'native';
            $this->log("✓ 发现原生评论表单\n");
        } elseif (stripos($html, 'disqus') !== false) {
            $result['supports_comments'] = true;
            $result['comment_system'] = 'disqus';
            $this->log("✓ 使用 Disqus 评论系统\n");
        } elseif (stripos($html, 'facebook.com/plugins/comments') !== false) {
            $result['supports_comments'] = true;
            $result['comment_system'] = 'facebook';
            $this->log("✓ 使用 Facebook 评论系统\n");
        }
        
        // 检查是否需要审核
        if (preg_match('/comment.*moderat|await.*approv|held for review/i', $html)) {
            $result['requires_moderation'] = true;
            $this->log("⚠ 评论需要审核\n");
        }
        
        // 检查 Trackback/Pingback
        if (stripos($headers, 'x-pingback:') !== false) {
            $result['supports_pingback'] = true;
            $this->log("✓ 支持 Pingback\n");
        }
        
        if (preg_match('/trackback:ping|rel=["\']trackback["\']/', $html)) {
            $result['supports_trackback'] = true;
            $this->log("✓ 支持 Trackback\n");
        }
        
        // 质量指标
        $indicators = [];
        
        // 检查 CommentLuv
        if (stripos($html, 'commentluv') !== false) {
            $indicators[] = 'CommentLuv 已启用（自动显示评论者最新文章）';
        }
        
        // 检查 dofollow
        if (!preg_match('/rel=["\']nofollow["\'][^>]*comment/i', $html)) {
            $indicators[] = '可能是 dofollow 评论';
        }
        
        // 检查活跃度
        if (preg_match_all('/<time|<span[^>]*class=["\'][^"\']*date|posted on|published on/i', $html, $matches)) {
            $dateCount = count($matches[0]);
            if ($dateCount > 5) {
                $indicators[] = '博客活跃（发现 ' . $dateCount . ' 个日期标记）';
            }
        }
        
        // 检查评论数量
        if (preg_match_all('/(\d+)\s*(comment|评论|回复)/i', $html, $matches)) {
            $totalComments = array_sum($matches[1]);
            if ($totalComments > 0) {
                $indicators[] = '有评论互动（约 ' . $totalComments . ' 条评论）';
            }
        }
        
        $result['quality_indicators'] = $indicators;
        
        return $result;
    }
    
    /**
     * 批量验证博客列表
     */
    public function validateBlogList($urls) {
        $results = [];
        
        foreach ($urls as $url) {
            $result = $this->validateBlog($url);
            $results[] = $result;
            
            // 延迟避免过快请求
            if (count($urls) > 1) {
                sleep(2);
            }
        }
        
        return $results;
    }
    
    /**
     * 从文件读取博客列表
     */
    public function loadBlogList($filename) {
        if (!file_exists($filename)) {
            return [];
        }
        
        $urls = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_filter($urls, function($url) {
            return filter_var($url, FILTER_VALIDATE_URL);
        });
    }
    
    /**
     * 保存验证结果
     */
    public function saveResults($results, $filename = 'validated_blogs.json') {
        $data = [
            'generated_at' => date('Y-m-d H:i:s'),
            'total' => count($results),
            'with_comments' => count(array_filter($results, function($r) { return $r['supports_comments']; })),
            'blogs' => $results
        ];
        
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        
        $this->log("\n结果已保存到: $filename\n");
        return $filename;
    }
    
    /**
     * 生成分类报告
     */
    public function generateReport($results) {
        $report = [
            'total' => count($results),
            'with_comments' => 0,
            'by_cms' => [],
            'by_comment_system' => [],
            'with_trackback' => 0,
            'with_pingback' => 0,
            'high_quality' => []
        ];
        
        foreach ($results as $blog) {
            if ($blog['supports_comments']) {
                $report['with_comments']++;
                
                // 按 CMS 分类
                $cms = $blog['cms'];
                if (!isset($report['by_cms'][$cms])) {
                    $report['by_cms'][$cms] = [];
                }
                $report['by_cms'][$cms][] = $blog['url'];
                
                // 按评论系统分类
                $system = $blog['comment_system'];
                if (!isset($report['by_comment_system'][$system])) {
                    $report['by_comment_system'][$system] = [];
                }
                $report['by_comment_system'][$system][] = $blog['url'];
                
                // 高质量博客（有多个质量指标）
                if (count($blog['quality_indicators']) >= 2) {
                    $report['high_quality'][] = [
                        'url' => $blog['url'],
                        'indicators' => $blog['quality_indicators']
                    ];
                }
            }
            
            if ($blog['supports_trackback']) {
                $report['with_trackback']++;
            }
            
            if ($blog['supports_pingback']) {
                $report['with_pingback']++;
            }
        }
        
        return $report;
    }
    
    private function log($message) {
        if ($this->debug) {
            echo $message;
        }
    }
}

// ============ 使用示例 ============

// 创建查找器实例
$finder = new BlogFinder(true);

// 1. 生成搜索查询
echo "=== 博客搜索建议 ===\n\n";
$searchSuggestions = $finder->findBlogsByKeyword('technology', 'AI machine learning');

// 2. 验证单个博客
echo "\n\n=== 验证博客示例 ===\n";
$testUrls = [
    'https://wordpress.org/news/',
    'https://techcrunch.com/',
];

$results = [];
foreach ($testUrls as $url) {
    $result = $finder->validateBlog($url);
    $results[] = $result;
    
    if ($result['supports_comments']) {
        echo "✅ $url - 支持评论 (系统: {$result['comment_system']})\n";
    } else {
        echo "❌ $url - 不支持评论\n";
    }
}

// 3. 保存结果
$finder->saveResults($results);

// 4. 生成报告
echo "\n=== 分析报告 ===\n";
$report = $finder->generateReport($results);
echo "总计检查: {$report['total']} 个博客\n";
echo "支持评论: {$report['with_comments']} 个\n";
echo "支持 Trackback: {$report['with_trackback']} 个\n";
echo "支持 Pingback: {$report['with_pingback']} 个\n";

?>