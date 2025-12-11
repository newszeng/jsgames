<?php
/**
 * WordPress 评论发送脚本
 * 支持通过 REST API 和传统方式发送评论
 */

class WordPressCommentSender {
    
    /**
     * 通过 REST API 发送评论（适用于启用了 REST API 的站点）
     */
    public function sendCommentViaAPI($postUrl, $comment, $author, $email, $website = '') {
        // 从 URL 提取域名和文章 ID
        $parsed = parse_url($postUrl);
        $domain = $parsed['scheme'] . '://' . $parsed['host'];
        
        // 尝试提取文章 ID（通常在 URL 中）
        preg_match('/\/(\d+)\/?$/', $postUrl, $matches);
        $postId = isset($matches[1]) ? $matches[1] : null;
        
        if (!$postId) {
            // 尝试通过 API 获取文章 ID
            $postId = $this->getPostIdFromUrl($postUrl);
        }
        
        if (!$postId) {
            return [
                'success' => false,
                'message' => '无法获取文章 ID'
            ];
        }
        
        // REST API 端点
        $apiUrl = $domain . '/wp-json/wp/v2/comments';
        
        // 评论数据
        $data = [
            'post' => $postId,
            'author_name' => $author,
            'author_email' => $email,
            'author_url' => $website,
            'content' => $comment,
        ];
        
        // 发送请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if ($httpCode === 201) {
            return [
                'success' => true,
                'message' => '评论发送成功',
                'comment_id' => $result['id'] ?? null,
                'status' => $result['status'] ?? 'pending'
            ];
        } else {
            return [
                'success' => false,
                'message' => $result['message'] ?? '评论发送失败',
                'code' => $httpCode
            ];
        }
    }
    
    /**
     * 通过传统表单方式发送评论
     */
    public function sendCommentViaForm($postUrl, $comment, $author, $email, $website = '') {
        // 首先获取页面内容，提取必要的表单字段
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        
        $html = curl_exec($ch);
        curl_close($ch);
        
        // 提取评论表单的 action URL
        preg_match('/<form[^>]*id=["\']commentform["\'][^>]*action=["\']([^"\']+)["\']/', $html, $matches);
        $actionUrl = isset($matches[1]) ? $matches[1] : null;
        
        if (!$actionUrl) {
            // 尝试默认的 wp-comments-post.php
            $parsed = parse_url($postUrl);
            $actionUrl = $parsed['scheme'] . '://' . $parsed['host'] . '/wp-comments-post.php';
        }
        
        // 提取文章 ID
        preg_match('/name=["\']comment_post_ID["\'][^>]*value=["\'](\d+)["\']/', $html, $matches);
        $postId = isset($matches[1]) ? $matches[1] : null;
        
        if (!$postId) {
            return [
                'success' => false,
                'message' => '无法找到文章 ID'
            ];
        }
        
        // 准备评论数据
        $postData = [
            'author' => $author,
            'email' => $email,
            'url' => $website,
            'comment' => $comment,
            'comment_post_ID' => $postId,
            'comment_parent' => 0,
        ];
        
        // 发送评论
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $actionUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
        curl_setopt($ch, CURLOPT_REFERER, $postUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        
        // 检查是否成功
        if ($httpCode === 200 || $httpCode === 302) {
            if (strpos($finalUrl, '#comment') !== false || strpos($response, 'comment-') !== false) {
                return [
                    'success' => true,
                    'message' => '评论提交成功（可能需要审核）'
                ];
            }
        }
        
        return [
            'success' => false,
            'message' => '评论提交失败',
            'code' => $httpCode
        ];
    }
    
    /**
     * 从 URL 获取文章 ID
     */
    private function getPostIdFromUrl($url) {
        // 尝试通过 oEmbed API 获取
        $parsed = parse_url($url);
        $domain = $parsed['scheme'] . '://' . $parsed['host'];
        $oembedUrl = $domain . '/wp-json/oembed/1.0/embed?url=' . urlencode($url);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $oembedUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        // 尝试从 HTML 中提取 ID
        if (isset($data['html'])) {
            preg_match('/data-postid=["\'](\d+)["\']/', $data['html'], $matches);
            if (isset($matches[1])) {
                return $matches[1];
            }
        }
        
        return null;
    }
    
    /**
     * 智能发送评论（自动选择最佳方式）
     */
    public function sendComment($postUrl, $comment, $author, $email, $website = '') {
        echo "正在发送评论到: $postUrl\n";
        echo "作者: $author\n";
        echo "评论: $comment\n\n";
        
        // 首先尝试 REST API
        echo "尝试通过 REST API 发送...\n";
        $result = $this->sendCommentViaAPI($postUrl, $comment, $author, $email, $website);
        
        if ($result['success']) {
            return $result;
        }
        
        echo "REST API 失败，尝试传统表单方式...\n";
        // 如果 API 失败，尝试表单方式
        $result = $this->sendCommentViaForm($postUrl, $comment, $author, $email, $website);
        
        return $result;
    }
}

// ============ 使用示例 ============

// 检查命令行参数
if ($argc > 1) {
    if ($argc < 5) {
        echo "用法: php wordpress_comment.php <post_url> <comment> <author> <email> [website]\n";
        echo "示例: php wordpress_comment.php https://example.com/post \"Great article!\" \"John Doe\" \"john@example.com\" \"https://john.com\"\n";
        exit(1);
    }
    
    $postUrl = $argv[1];
    $comment = $argv[2];
    $author = $argv[3];
    $email = $argv[4];
    $website = isset($argv[5]) ? $argv[5] : '';
} else {
    // 默认测试数据
    $postUrl = 'https://www.queenforaday.fr/blog-mariage/famille/famille-camille/';
    $comment = 'This is a test comment from the pingback script. Great article about MCP!';
    $author = 'Y2Mate';
    $email = 'analyst@y2mate.tools';
    $website = 'https://y2mate.tools/';
}

$sender = new WordPressCommentSender();
$result = $sender->sendComment($postUrl, $comment, $author, $email, $website);

if ($result['success']) {
    echo "\n✓ " . $result['message'] . "\n";
    if (isset($result['comment_id'])) {
        echo "评论 ID: " . $result['comment_id'] . "\n";
    }
    if (isset($result['status'])) {
        echo "状态: " . $result['status'] . "\n";
    }
} else {
    echo "\n✗ " . $result['message'] . "\n";
    if (isset($result['code'])) {
        echo "HTTP 代码: " . $result['code'] . "\n";
    }
}

?>