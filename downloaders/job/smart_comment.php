<?php
/**
 * 智能评论发送器
 * 自动选择最佳方式：Trackback > Pingback > 普通评论
 */

require_once 'trackback.php';
require_once 'pingback.php';
require_once 'wordpress_comment.php';

class SmartCommentSender {
    
    private $trackbackSender;
    private $pingbackSender;
    private $commentSender;
    private $debug;
    
    public function __construct($debug = false) {
        $this->trackbackSender = new TrackbackSender();
        $this->pingbackSender = new PingbackSender();
        $this->commentSender = new WordPressCommentSender();
        $this->debug = $debug;
    }
    
    /**
     * 智能发送评论
     * 
     * @param array $params 参数数组，包含：
     *   - target_url: 目标文章URL (必需)
     *   - source_url: 来源URL (必需)
     *   - title: 标题
     *   - content/excerpt: 内容或摘要
     *   - author_name: 作者名
     *   - author_email: 作者邮箱
     *   - author_website: 作者网站
     *   - blog_name: 博客名称
     * @return array 结果数组
     */
    public function sendSmartComment($params) {
        // 验证必需参数
        if (!isset($params['target_url']) || !isset($params['source_url'])) {
            return [
                'success' => false,
                'method' => 'none',
                'message' => '缺少必需参数: target_url 和 source_url'
            ];
        }
        
        $targetUrl = $params['target_url'];
        $sourceUrl = $params['source_url'];
        
        // 准备默认值
        $title = $params['title'] ?? $this->generateTitle($sourceUrl);
        $content = $params['content'] ?? $params['excerpt'] ?? 'Check out this related article: ' . $sourceUrl;
        $authorName = $params['author_name'] ?? 'Guest';
        $authorEmail = $params['author_email'] ?? 'guest@example.com';
        $authorWebsite = $params['author_website'] ?? $sourceUrl;
        $blogName = $params['blog_name'] ?? $this->extractDomain($sourceUrl);
        
        $this->log("=== 智能评论发送器 ===");
        $this->log("目标 URL: $targetUrl");
        $this->log("来源 URL: $sourceUrl\n");
        
        // 1. 尝试 Trackback
        $this->log("1. 尝试 Trackback...");
        $trackbackResult = $this->tryTrackback($targetUrl, $sourceUrl, $title, $content, $blogName);
        if ($trackbackResult['success']) {
            $this->log("   ✅ Trackback 成功发送到: " . ($trackbackResult['trackback_url'] ?? 'unknown'));
            return $trackbackResult;
        }
        $this->log("   ❌ Trackback 失败: " . $trackbackResult['message'] . "\n");
        
        // 2. 尝试 Pingback
        $this->log("2. 尝试 Pingback...");
        $pingbackResult = $this->tryPingback($sourceUrl, $targetUrl);
        if ($pingbackResult['success']) {
            return $pingbackResult;
        }
        $this->log("   Pingback 失败: " . $pingbackResult['message'] . "\n");
        
        // 3. 尝试普通评论
        $this->log("3. 尝试普通评论...");
        $commentResult = $this->tryComment($targetUrl, $content, $authorName, $authorEmail, $authorWebsite);
        if ($commentResult['success']) {
            return $commentResult;
        }
        $this->log("   普通评论失败: " . $commentResult['message'] . "\n");
        
        // 所有方法都失败
        return [
            'success' => false,
            'method' => 'none',
            'message' => '所有评论方式都失败了',
            'details' => [
                'trackback' => $trackbackResult['message'],
                'pingback' => $pingbackResult['message'],
                'comment' => $commentResult['message']
            ]
        ];
    }
    
    /**
     * 尝试发送 Trackback
     */
    private function tryTrackback($targetUrl, $sourceUrl, $title, $excerpt, $blogName) {
        try {
            // 先尝试原始 URL
            $result = $this->trackbackSender->sendTrackback($targetUrl, $sourceUrl, $title, $excerpt, $blogName);
            
            if ($result['success']) {
                return [
                    'success' => true,
                    'method' => 'trackback',
                    'message' => 'Trackback 发送成功',
                    'response' => $result['response'] ?? null,
                    'trackback_url' => $result['trackback_url'] ?? null
                ];
            }
            
            // 检查是否是重复错误
            if (isset($result['message']) && 
                (strpos($result['message'], 'already a ping') !== false ||
                 strpos($result['message'], 'duplicate') !== false)) {
                
                $this->log("   检测到重复 trackback，尝试使用新的源 URL...");
                
                // 使用更独特的 URL 重试
                $timestamp = time();
                $random = rand(1000, 9999);
                $retrySourceUrl = rtrim($sourceUrl, '/') . '/ref-' . $timestamp . '-' . $random;
                
                $this->log("   重试使用新 URL: $retrySourceUrl");
                $retryResult = $this->trackbackSender->sendTrackback($targetUrl, $retrySourceUrl, $title, $excerpt, $blogName);
                
                if ($retryResult['success']) {
                    return [
                        'success' => true,
                        'method' => 'trackback',
                        'message' => 'Trackback 发送成功（重试）',
                        'response' => $retryResult['response'] ?? null
                    ];
                }
            }
            
            return [
                'success' => false,
                'method' => 'trackback',
                'message' => $result['message'] ?? 'Trackback 失败'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'method' => 'trackback',
                'message' => '异常: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * 尝试发送 Pingback
     */
    private function tryPingback($sourceUrl, $targetUrl) {
        try {
            // 首先验证源页面是否包含目标链接
            $containsLink = $this->pingbackSender->validateSourceContainsTarget($sourceUrl, $targetUrl);
            if (!$containsLink) {
                return [
                    'success' => false,
                    'method' => 'pingback',
                    'message' => '源页面不包含目标链接'
                ];
            }
            
            $result = $this->pingbackSender->sendPingback($sourceUrl, $targetUrl);
            
            if ($result['success']) {
                return [
                    'success' => true,
                    'method' => 'pingback',
                    'message' => 'Pingback 发送成功',
                    'response' => $result['response'] ?? null
                ];
            }
            
            return [
                'success' => false,
                'method' => 'pingback',
                'message' => $result['message'] ?? 'Pingback 失败'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'method' => 'pingback',
                'message' => '异常: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * 尝试发送普通评论
     */
    private function tryComment($targetUrl, $comment, $authorName, $authorEmail, $authorWebsite) {
        try {
            $result = $this->commentSender->sendComment($targetUrl, $comment, $authorName, $authorEmail, $authorWebsite);
            
            if ($result['success']) {
                return [
                    'success' => true,
                    'method' => 'comment',
                    'message' => '普通评论发送成功（可能需要审核）',
                    'comment_id' => $result['comment_id'] ?? null,
                    'status' => $result['status'] ?? 'pending'
                ];
            }
            
            return [
                'success' => false,
                'method' => 'comment',
                'message' => $result['message'] ?? '评论失败'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'method' => 'comment',
                'message' => '异常: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * 批量发送评论
     */
    public function batchSend($targets, $defaultParams = []) {
        $results = [];
        
        foreach ($targets as $target) {
            // 合并参数
            if (is_string($target)) {
                $params = array_merge($defaultParams, ['target_url' => $target]);
            } else {
                $params = array_merge($defaultParams, $target);
            }
            
            $this->log("\n处理: " . $params['target_url']);
            $result = $this->sendSmartComment($params);
            $results[] = $result;
            
            // 延迟避免被识别为垃圾评论
            if (count($targets) > 1) {
                $delay = rand(5, 15);
                $this->log("等待 {$delay} 秒...\n");
                sleep($delay);
            }
        }
        
        return $results;
    }
    
    /**
     * 生成标题
     */
    private function generateTitle($url) {
        $parsed = parse_url($url);
        $path = trim($parsed['path'] ?? '', '/');
        $parts = explode('/', $path);
        $title = end($parts);
        $title = str_replace('-', ' ', $title);
        $title = str_replace('_', ' ', $title);
        return ucwords($title);
    }
    
    /**
     * 提取域名
     */
    private function extractDomain($url) {
        $parsed = parse_url($url);
        return $parsed['host'] ?? 'Unknown Site';
    }
    
    /**
     * 日志输出
     */
    private function log($message) {
        if ($this->debug) {
            echo $message . "\n";
        }
    }
}

// ============ 使用示例 ============

// 检查命令行参数
if ($argc > 1) {
    if ($argc < 3) {
        echo "用法: php smart_comment.php <target_url> <source_url> [title] [content] [author_name] [author_email]\n";
        echo "示例: php smart_comment.php https://example.com/post https://mysite.com/article\n";
        exit(1);
    }
    
    $params = [
        'target_url' => $argv[1],
        'source_url' => $argv[2],
        'title' => $argv[3] ?? null,
        'content' => $argv[4] ?? null,
        'author_name' => $argv[5] ?? null,
        'author_email' => $argv[6] ?? null
    ];
    
    // 移除 null 值
    $params = array_filter($params);
} else {
    // 默认测试
    $params = [
        'target_url' => 'https://blog.andrewhuey.com/2025/10/kagi-search-and-some-ai-thoughts/',
        'source_url' => 'https://y2mate.tools/',
        'title' => 'Y2Mate Pingback',
        'content' => 'Quite educating story, saved your site for hopes to read much more!',
        'author_name' => 'Y2Mate',
        'author_email' => 'analyst@y2mate.tools',
        'author_website' => 'https://y2mate.tools',
        'blog_name' => 'Y2Mate Blog'
    ];
}

// 创建实例并发送
$sender = new SmartCommentSender(true); // 开启调试模式
$result = $sender->sendSmartComment($params);

// 显示结果
echo "\n=== 最终结果 ===\n";
if ($result['success']) {
    echo "✅ 成功！\n";
    echo "使用方法: " . $result['method'] . "\n";
    echo "消息: " . $result['message'] . "\n";
} else {
    echo "❌ 失败！\n";
    echo "消息: " . $result['message'] . "\n";
    if (isset($result['details'])) {
        echo "\n详细信息:\n";
        foreach ($result['details'] as $method => $message) {
            echo "  - $method: $message\n";
        }
    }
}

?>