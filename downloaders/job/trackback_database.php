<?php
/**
 * Trackback 数据库管理器
 * 管理和维护支持 trackback 的站点数据库
 */

class TrackbackDatabase {
    
    private $dbFile = 'trackback_sites_db.json';
    
    /**
     * 预置的高质量 trackback 站点
     */
    public function getPresetSites() {
        return [
            'educational' => [
                [
                    'url' => 'https://ctl.uaf.edu/',
                    'name' => 'UAF Center for Teaching and Learning',
                    'description' => '阿拉斯加大学费尔班克斯分校教学中心',
                    'category' => 'education',
                    'language' => 'en',
                    'trackback_status' => 'verified',
                    'last_tested' => '2024-10-16',
                    'success_rate' => 100,
                    'notes' => '教育技术相关内容，trackback 响应快速'
                ],
                [
                    'url' => 'https://sites.duke.edu/blog/',
                    'name' => 'Duke University Sites Blog',
                    'description' => '杜克大学网站博客',
                    'category' => 'education',
                    'language' => 'en',
                    'trackback_status' => 'mixed', // 部分文章关闭
                    'last_tested' => '2024-10-16',
                    'success_rate' => 60,
                    'notes' => '较新文章可能关闭 trackback'
                ]
            ],
            
            'legal' => [
                [
                    'url' => 'https://www.labrums.co.uk/blog/',
                    'name' => 'Labrums Solicitors Blog',
                    'description' => '英国律师事务所博客',
                    'category' => 'legal',
                    'language' => 'en',
                    'trackback_status' => 'verified',
                    'last_tested' => '2024-10-16',
                    'success_rate' => 90,
                    'notes' => '法律服务相关，大部分文章支持 trackback'
                ]
            ],
            
            'technology' => [
                [
                    'url' => 'https://wordpress.org/news/',
                    'name' => 'WordPress News',
                    'description' => 'WordPress 官方新闻',
                    'category' => 'technology',
                    'language' => 'en',
                    'trackback_status' => 'unknown',
                    'last_tested' => null,
                    'success_rate' => 0,
                    'notes' => '需要验证'
                ]
            ]
        ];
    }
    
    /**
     * 获取搜索目标和策略
     */
    public function getCollectionStrategies() {
        return [
            'search_targets' => [
                '教育机构博客' => [
                    'domains' => ['*.edu', '*.ac.uk', '*.edu.au'],
                    'keywords' => ['blog', 'news', 'research', 'teaching'],
                    'success_rate' => 'high',
                    'reason' => '教育机构通常更开放，支持学术交流'
                ],
                
                '个人技术博客' => [
                    'platforms' => ['WordPress.com', '自托管 WordPress'],
                    'keywords' => ['programming', 'web development', 'tech'],
                    'success_rate' => 'medium',
                    'reason' => '技术人员更了解 trackback 功能'
                ],
                
                '法律服务博客' => [
                    'domains' => ['律师事务所', '法律服务公司'],
                    'keywords' => ['legal', 'law', 'solicitor', 'attorney'],
                    'success_rate' => 'medium',
                    'reason' => '专业服务网站通常保持传统功能'
                ],
                
                '旧版 WordPress 站点' => [
                    'versions' => ['WordPress 4.x', 'WordPress 5.x'],
                    'time_range' => '2015-2020',
                    'success_rate' => 'high',
                    'reason' => '旧版本默认开启 trackback'
                ]
            ],
            
            'collection_methods' => [
                'Google 搜索' => [
                    'queries' => [
                        '"powered by wordpress" trackback site:edu',
                        'inurl:blog "trackback url" wordpress',
                        '"rdf:description" "trackback:ping"',
                        '"wp-content" trackback -comments-closed'
                    ],
                    'effectiveness' => 'high'
                ],
                
                'WordPress 目录爬取' => [
                    'sources' => [
                        'WordPress.com 博客目录',
                        'WordPress 主题展示站点',
                        'WordPress 插件作者博客'
                    ],
                    'effectiveness' => 'medium'
                ],
                
                '竞争对手分析' => [
                    'method' => '分析已知支持 trackback 站点的外链',
                    'tools' => ['Ahrefs', 'Semrush backlink analysis'],
                    'effectiveness' => 'medium'
                ]
            ]
        ];
    }
    
    /**
     * 验证站点质量标准
     */
    public function getQualityStandards() {
        return [
            'minimum_requirements' => [
                'trackback_response_time' => '< 5 seconds',
                'success_rate' => '> 50%',
                'last_post_date' => '< 2 years ago',
                'domain_authority' => '> 20 (if available)'
            ],
            
            'preferred_characteristics' => [
                'content_quality' => 'Original, well-written content',
                'update_frequency' => 'Regular updates (monthly or better)', 
                'niche_relevance' => 'Related to your industry/niche',
                'comment_activity' => 'Active comment section',
                'social_presence' => 'Active on social media'
            ],
            
            'red_flags' => [
                'spam_indicators' => 'Excessive ads, poor content quality',
                'security_issues' => 'Malware warnings, SSL problems',
                'abandoned_sites' => 'No updates for > 2 years',
                'low_quality_content' => 'Duplicate or auto-generated content'
            ]
        ];
    }
    
    /**
     * 添加新站点到数据库
     */
    public function addSite($siteData) {
        $sites = $this->loadDatabase();
        
        // 检查是否已存在
        foreach ($sites as $site) {
            if ($site['url'] === $siteData['url']) {
                return ['success' => false, 'message' => 'Site already exists'];
            }
        }
        
        // 添加默认字段
        $siteData['added_at'] = date('Y-m-d H:i:s');
        $siteData['trackback_count'] = 0;
        $siteData['last_trackback'] = null;
        
        $sites[] = $siteData;
        $this->saveDatabase($sites);
        
        return ['success' => true, 'message' => 'Site added successfully'];
    }
    
    /**
     * 更新站点状态
     */
    public function updateSiteStatus($url, $status, $notes = '') {
        $sites = $this->loadDatabase();
        
        foreach ($sites as &$site) {
            if ($site['url'] === $url) {
                $site['trackback_status'] = $status;
                $site['last_tested'] = date('Y-m-d H:i:s');
                if ($notes) {
                    $site['notes'] = $notes;
                }
                
                if ($status === 'success') {
                    $site['trackback_count'] = ($site['trackback_count'] ?? 0) + 1;
                    $site['last_trackback'] = date('Y-m-d H:i:s');
                }
                
                $this->saveDatabase($sites);
                return ['success' => true, 'message' => 'Site updated'];
            }
        }
        
        return ['success' => false, 'message' => 'Site not found'];
    }
    
    /**
     * 获取推荐的站点
     */
    public function getRecommendedSites($category = null, $limit = 10) {
        $sites = $this->loadDatabase();
        
        // 过滤条件
        $filtered = array_filter($sites, function($site) use ($category) {
            // 基本质量过滤
            if (isset($site['trackback_status']) && $site['trackback_status'] === 'failed') {
                return false;
            }
            
            if (isset($site['success_rate']) && $site['success_rate'] < 50) {
                return false;
            }
            
            // 分类过滤
            if ($category && isset($site['category']) && $site['category'] !== $category) {
                return false;
            }
            
            return true;
        });
        
        // 按成功率排序
        usort($filtered, function($a, $b) {
            $aRate = $a['success_rate'] ?? 0;
            $bRate = $b['success_rate'] ?? 0;
            return $bRate - $aRate;
        });
        
        return array_slice($filtered, 0, $limit);
    }
    
    /**
     * 生成收集进度报告
     */
    public function generateProgress() {
        $sites = $this->loadDatabase();
        
        $stats = [
            'total' => count($sites),
            'verified' => 0,
            'failed' => 0,
            'pending' => 0,
            'by_category' => [],
            'recent_additions' => []
        ];
        
        foreach ($sites as $site) {
            $status = $site['trackback_status'] ?? 'pending';
            
            switch ($status) {
                case 'verified':
                case 'success':
                    $stats['verified']++;
                    break;
                case 'failed':
                case 'closed':
                    $stats['failed']++;
                    break;
                default:
                    $stats['pending']++;
            }
            
            // 按分类统计
            $category = $site['category'] ?? 'uncategorized';
            if (!isset($stats['by_category'][$category])) {
                $stats['by_category'][$category] = 0;
            }
            $stats['by_category'][$category]++;
            
            // 最近添加的站点
            if (isset($site['added_at']) && 
                strtotime($site['added_at']) > strtotime('-7 days')) {
                $stats['recent_additions'][] = $site;
            }
        }
        
        return $stats;
    }
    
    private function loadDatabase() {
        if (!file_exists($this->dbFile)) {
            // 初始化数据库
            $presets = $this->getPresetSites();
            $sites = [];
            
            foreach ($presets as $category => $categoryItems) {
                $sites = array_merge($sites, $categoryItems);
            }
            
            $this->saveDatabase($sites);
            return $sites;
        }
        
        $data = json_decode(file_get_contents($this->dbFile), true);
        return $data ?: [];
    }
    
    private function saveDatabase($sites) {
        file_put_contents($this->dbFile, json_encode($sites, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}

// ============ 使用示例 ============

$db = new TrackbackDatabase();

echo "=== Trackback 站点数据库管理器 ===\n\n";

// 1. 显示收集策略
echo "1. 收集策略:\n\n";
$strategies = $db->getCollectionStrategies();

echo "【搜索目标】\n";
foreach ($strategies['search_targets'] as $target => $info) {
    echo "• $target (成功率: {$info['success_rate']})\n";
    echo "  原因: {$info['reason']}\n\n";
}

// 2. 显示质量标准
echo "2. 质量标准:\n\n";
$standards = $db->getQualityStandards();
echo "最低要求:\n";
foreach ($standards['minimum_requirements'] as $req => $value) {
    echo "• $req: $value\n";
}

// 3. 显示当前进度
echo "\n3. 当前数据库状态:\n\n";
$progress = $db->generateProgress();
echo "总站点数: {$progress['total']}\n";
echo "已验证: {$progress['verified']}\n";
echo "失败: {$progress['failed']}\n";
echo "待验证: {$progress['pending']}\n";

// 4. 推荐站点
echo "\n4. 推荐的站点:\n\n";
$recommended = $db->getRecommendedSites(null, 5);
foreach ($recommended as $site) {
    echo "• {$site['name']}: {$site['url']}\n";
    echo "  类别: {$site['category']}, 成功率: {$site['success_rate']}%\n";
    echo "  说明: {$site['description']}\n\n";
}

echo "=== 下一步行动 ===\n";
echo "1. 使用 Google 搜索上面的查询来发现新站点\n";
echo "2. 运行 trackback_collector.php 验证发现的站点\n";
echo "3. 使用 trackback.php 向验证的站点发送 trackback\n";
echo "4. 定期更新数据库，删除失效站点\n";

?>