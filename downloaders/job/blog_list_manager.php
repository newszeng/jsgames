<?php
/**
 * 高质量博客列表管理器
 * 包含查找方法、分类管理和批量处理功能
 */

class BlogListManager {
    
    private $dataFile = 'blog_database.json';
    private $categories = [
        'technology' => '科技',
        'marketing' => '营销',
        'business' => '商业',
        'lifestyle' => '生活方式',
        'food' => '美食',
        'travel' => '旅游',
        'health' => '健康',
        'finance' => '金融',
        'education' => '教育',
        'entertainment' => '娱乐'
    ];
    
    /**
     * 获取高质量博客的方法和资源
     */
    public function getQualityBlogSources() {
        return [
            'search_methods' => [
                'Google 搜索技巧' => [
                    '"leave a comment" + [你的关键词]',
                    '"post a comment" + [你的关键词]', 
                    'site:wordpress.com [关键词] "comments"',
                    '"powered by wordpress" "leave a reply" [关键词]',
                    '"commentluv enabled" [关键词]',
                    '"notify me of followup comments" [关键词]',
                    'intitle:"guest post" + [关键词]',
                    '"this blog uses commentluv" [关键词]',
                    '"comments are closed" -"comments are closed" [关键词]', // 查找开放评论的
                    'inurl:blog [关键词] "comment"'
                ],
                
                '查找 DoFollow 博客' => [
                    '"commentluv enabled" "dofollow"',
                    '"this blog uses premium commentluv"',
                    '"reward commenters" [关键词]',
                    '"top commenters" [关键词]'
                ],
                
                '按 CMS 查找' => [
                    'site:*.wordpress.com [关键词]',
                    '"powered by blogger" [关键词] comment',
                    'inurl:typepad.com [关键词]',
                    'site:medium.com [关键词]' // Medium 允许回复
                ]
            ],
            
            'blog_directories' => [
                'AllTop' => 'https://alltop.com/',
                'Blogarama' => 'https://www.blogarama.com/',
                'BlogCatalog' => 'https://blogcatalog.com/',
                'Technorati' => 'https://technorati.com/',
                'Best of the Web Blog Directory' => 'https://blogs.botw.org/'
            ],
            
            'quality_indicators' => [
                '更新频率' => '定期更新的博客更可能批准评论',
                '评论活跃度' => '已有很多评论的博客更欢迎新评论',
                'CommentLuv' => '安装此插件的博客会自动展示评论者的最新文章',
                '作者回复' => '作者经常回复评论说明重视互动',
                '社交媒体活跃' => '在社交媒体活跃的博主更重视互动',
                'Domain Authority' => '使用 Moz 或 Ahrefs 检查 DA 值',
                '相关性' => '与你内容相关的博客评论更容易通过'
            ],
            
            'tools' => [
                'Drop My Link' => '查找可以留言的相关页面',
                'Moz Link Explorer' => '查找竞争对手的反向链接',
                'Ahrefs' => '分析博客质量和流量',
                'SimilarWeb' => '查看博客流量和受众',
                'BuzzSumo' => '查找热门内容和作者'
            ]
        ];
    }
    
    /**
     * 添加博客到数据库
     */
    public function addBlog($blogData) {
        $required = ['url', 'name', 'category'];
        foreach ($required as $field) {
            if (!isset($blogData[$field])) {
                return ['success' => false, 'message' => "缺少必需字段: $field"];
            }
        }
        
        $blogs = $this->loadDatabase();
        
        // 检查是否已存在
        foreach ($blogs as $blog) {
            if ($blog['url'] === $blogData['url']) {
                return ['success' => false, 'message' => '博客已存在'];
            }
        }
        
        // 添加默认值和时间戳
        $blogData['added_at'] = date('Y-m-d H:i:s');
        $blogData['last_checked'] = null;
        $blogData['status'] = 'active';
        $blogData['comment_success_rate'] = 0;
        $blogData['notes'] = $blogData['notes'] ?? '';
        
        $blogs[] = $blogData;
        $this->saveDatabase($blogs);
        
        return ['success' => true, 'message' => '博客添加成功'];
    }
    
    /**
     * 批量导入博客
     */
    public function importBlogs($csvFile) {
        if (!file_exists($csvFile)) {
            return ['success' => false, 'message' => '文件不存在'];
        }
        
        $imported = 0;
        $failed = 0;
        $errors = [];
        
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            $headers = fgetcsv($handle); // 第一行作为标题
            
            while (($data = fgetcsv($handle)) !== FALSE) {
                $blogData = array_combine($headers, $data);
                
                $result = $this->addBlog($blogData);
                if ($result['success']) {
                    $imported++;
                } else {
                    $failed++;
                    $errors[] = $blogData['url'] . ': ' . $result['message'];
                }
            }
            
            fclose($handle);
        }
        
        return [
            'success' => true,
            'imported' => $imported,
            'failed' => $failed,
            'errors' => $errors
        ];
    }
    
    /**
     * 导出博客列表
     */
    public function exportBlogs($format = 'json', $filters = []) {
        $blogs = $this->getBlogs($filters);
        
        $filename = 'blog_export_' . date('Y-m-d_H-i-s');
        
        switch ($format) {
            case 'csv':
                $filename .= '.csv';
                $fp = fopen($filename, 'w');
                
                // 写入标题
                if (count($blogs) > 0) {
                    fputcsv($fp, array_keys($blogs[0]));
                }
                
                // 写入数据
                foreach ($blogs as $blog) {
                    fputcsv($fp, $blog);
                }
                
                fclose($fp);
                break;
                
            case 'txt':
                $filename .= '.txt';
                $content = '';
                foreach ($blogs as $blog) {
                    $content .= $blog['url'] . "\n";
                }
                file_put_contents($filename, $content);
                break;
                
            default: // json
                $filename .= '.json';
                file_put_contents($filename, json_encode($blogs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        
        return $filename;
    }
    
    /**
     * 获取博客列表
     */
    public function getBlogs($filters = []) {
        $blogs = $this->loadDatabase();
        
        // 应用过滤器
        if (!empty($filters['category'])) {
            $blogs = array_filter($blogs, function($blog) use ($filters) {
                return $blog['category'] === $filters['category'];
            });
        }
        
        if (!empty($filters['status'])) {
            $blogs = array_filter($blogs, function($blog) use ($filters) {
                return $blog['status'] === $filters['status'];
            });
        }
        
        if (!empty($filters['supports_comments'])) {
            $blogs = array_filter($blogs, function($blog) use ($filters) {
                return !empty($blog['supports_comments']);
            });
        }
        
        if (!empty($filters['quality'])) {
            $blogs = array_filter($blogs, function($blog) use ($filters) {
                return $blog['comment_success_rate'] >= 50;
            });
        }
        
        return array_values($blogs);
    }
    
    /**
     * 更新博客信息
     */
    public function updateBlog($url, $updates) {
        $blogs = $this->loadDatabase();
        $found = false;
        
        foreach ($blogs as &$blog) {
            if ($blog['url'] === $url) {
                $blog = array_merge($blog, $updates);
                $blog['last_updated'] = date('Y-m-d H:i:s');
                $found = true;
                break;
            }
        }
        
        if ($found) {
            $this->saveDatabase($blogs);
            return ['success' => true, 'message' => '博客更新成功'];
        }
        
        return ['success' => false, 'message' => '博客不存在'];
    }
    
    /**
     * 生成博客统计报告
     */
    public function generateStats() {
        $blogs = $this->loadDatabase();
        
        $stats = [
            'total' => count($blogs),
            'by_category' => [],
            'by_status' => [],
            'supports_comments' => 0,
            'supports_trackback' => 0,
            'high_quality' => 0,
            'recently_checked' => 0
        ];
        
        foreach ($blogs as $blog) {
            // 按分类统计
            $category = $blog['category'];
            if (!isset($stats['by_category'][$category])) {
                $stats['by_category'][$category] = 0;
            }
            $stats['by_category'][$category]++;
            
            // 按状态统计
            $status = $blog['status'] ?? 'unknown';
            if (!isset($stats['by_status'][$status])) {
                $stats['by_status'][$status] = 0;
            }
            $stats['by_status'][$status]++;
            
            // 功能统计
            if (!empty($blog['supports_comments'])) {
                $stats['supports_comments']++;
            }
            
            if (!empty($blog['supports_trackback'])) {
                $stats['supports_trackback']++;
            }
            
            // 高质量博客（成功率超过50%）
            if (($blog['comment_success_rate'] ?? 0) >= 50) {
                $stats['high_quality']++;
            }
            
            // 最近7天检查过的
            if (!empty($blog['last_checked'])) {
                $lastChecked = strtotime($blog['last_checked']);
                if (time() - $lastChecked < 7 * 24 * 3600) {
                    $stats['recently_checked']++;
                }
            }
        }
        
        return $stats;
    }
    
    /**
     * 推荐相似博客
     */
    public function recommendSimilar($url, $limit = 5) {
        $blogs = $this->loadDatabase();
        $targetBlog = null;
        
        // 查找目标博客
        foreach ($blogs as $blog) {
            if ($blog['url'] === $url) {
                $targetBlog = $blog;
                break;
            }
        }
        
        if (!$targetBlog) {
            return [];
        }
        
        // 查找相同分类的高质量博客
        $similar = array_filter($blogs, function($blog) use ($targetBlog) {
            return $blog['url'] !== $targetBlog['url'] && 
                   $blog['category'] === $targetBlog['category'] &&
                   $blog['status'] === 'active' &&
                   ($blog['comment_success_rate'] ?? 0) >= 30;
        });
        
        // 按成功率排序
        usort($similar, function($a, $b) {
            return ($b['comment_success_rate'] ?? 0) - ($a['comment_success_rate'] ?? 0);
        });
        
        return array_slice($similar, 0, $limit);
    }
    
    private function loadDatabase() {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        
        $data = json_decode(file_get_contents($this->dataFile), true);
        return $data ?: [];
    }
    
    private function saveDatabase($data) {
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}

// ============ 使用示例 ============

$manager = new BlogListManager();

// 1. 查看高质量博客获取方法
echo "=== 高质量博客获取方法 ===\n\n";
$sources = $manager->getQualityBlogSources();

echo "Google 搜索技巧:\n";
foreach ($sources['search_methods']['Google 搜索技巧'] as $query) {
    echo "  • $query\n";
}

echo "\n博客目录:\n";
foreach ($sources['blog_directories'] as $name => $url) {
    echo "  • $name: $url\n";
}

// 2. 添加博客示例
echo "\n\n=== 添加博客示例 ===\n";
$result = $manager->addBlog([
    'url' => 'https://example-tech-blog.com',
    'name' => 'Example Tech Blog',
    'category' => 'technology',
    'supports_comments' => true,
    'comment_system' => 'wordpress',
    'quality_score' => 85,
    'notes' => '高质量科技博客，更新频繁，评论活跃'
]);

echo $result['message'] . "\n";

// 3. 生成统计
echo "\n=== 博客统计 ===\n";
$stats = $manager->generateStats();
echo "总博客数: {$stats['total']}\n";
echo "支持评论: {$stats['supports_comments']}\n";
echo "高质量博客: {$stats['high_quality']}\n";

// 4. 创建示例 CSV 文件用于导入
$sampleCsv = 'sample_blogs.csv';
$csvContent = "url,name,category,supports_comments,notes\n";
$csvContent .= "https://techcrunch.com,TechCrunch,technology,true,Major tech news site\n";
$csvContent .= "https://mashable.com,Mashable,technology,true,Tech and digital culture\n";
$csvContent .= "https://theverge.com,The Verge,technology,true,Technology news and media\n";
file_put_contents($sampleCsv, $csvContent);

echo "\n创建了示例 CSV 文件: $sampleCsv\n";

?>