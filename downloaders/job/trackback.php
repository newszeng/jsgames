<?php
/**
 * Trackback 发送脚本
 * Trackback 允许发送带有摘要的引用通告
 */

class TrackbackSender {
    
    /**
     * 从目标页面发现 Trackback URL
     */
    public function discoverTrackbackUrl($targetUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $targetUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Trackback Client)');
        
        $html = curl_exec($ch);
        curl_close($ch);
        
        // 方法1: 在 RDF 中查找 trackback:ping
        if (preg_match('/<rdf:Description[^>]*>.*?trackback:ping="([^"]+)".*?<\/rdf:Description>/si', $html, $matches)) {
            return html_entity_decode($matches[1]);
        }
        
        // 方法2: 在 RDF 中查找 dc:identifier 和 trackback:ping
        if (preg_match_all('/<rdf:Description.*?(?:dc:identifier="([^"]+)".*?trackback:ping="([^"]+)"|trackback:ping="([^"]+)".*?dc:identifier="([^"]+)").*?\/>/si', $html, $matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $identifier = !empty($matches[1][$i]) ? $matches[1][$i] : $matches[4][$i];
                $trackbackUrl = !empty($matches[2][$i]) ? $matches[2][$i] : $matches[3][$i];
                
                // 检查 identifier 是否匹配目标 URL
                if ($identifier === $targetUrl || strpos($targetUrl, $identifier) !== false) {
                    return html_entity_decode($trackbackUrl);
                }
            }
        }
        
        // 方法3: 查找 rel="trackback" 的链接
        if (preg_match('/<link[^>]+rel=["\']trackback["\'][^>]+href=["\']([^"\']+)["\']/', $html, $matches) ||
            preg_match('/<link[^>]+href=["\']([^"\']+)["\'][^>]+rel=["\']trackback["\']/', $html, $matches)) {
            return $matches[1];
        }
        
        // 方法4: WordPress 默认 trackback URL 格式
        $parsed = parse_url($targetUrl);
        $path = rtrim($parsed['path'], '/');
        
        // 标准格式1: 直接添加 /trackback/
        $trackbackUrl = rtrim($targetUrl, '/') . '/trackback/';
        
        // 测试 trackback URL 是否有效
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $trackbackUrl);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Trackback Test');
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // 如果返回 200 或 405 (Method Not Allowed)，说明 URL 存在
        if ($httpCode == 200 || $httpCode == 405) {
            return $trackbackUrl;
        }
        
        // 如果 URL 以数字结尾，尝试添加 /trackback/
        if (preg_match('/\/(\d+)$/', $path)) {
            return $targetUrl . '/trackback/';
        }
        
        // 如果 URL 包含日期和标题格式
        if (preg_match('/\/\d{4}\/\d{2}\/\d{2}\/[^\/]+\/$/', $path)) {
            return $targetUrl . 'trackback/';
        }
        
        return null;
    }
    
    /**
     * 发送 Trackback
     */
    public function sendTrackback($targetUrl, $sourceUrl, $title, $excerpt, $blogName = null) {
        // 发现 Trackback URL
        $trackbackUrl = $this->discoverTrackbackUrl($targetUrl);
        
        if (!$trackbackUrl) {
            return [
                'success' => false,
                'message' => '无法发现 Trackback URL'
            ];
        }
        
        echo "发现的 Trackback URL: $trackbackUrl\n";
        
        // 如果没有提供博客名称，从 URL 提取
        if (!$blogName) {
            $parsed = parse_url($sourceUrl);
            $blogName = $parsed['host'];
        }
        
        // 准备 POST 数据
        $postData = [
            'title' => $title,
            'url' => $sourceUrl,
            'excerpt' => $excerpt,
            'blog_name' => $blogName
        ];
        
        // 发送 Trackback
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $trackbackUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'User-Agent: Trackback Client 1.0'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            return [
                'success' => false,
                'message' => 'CURL 错误: ' . $error
            ];
        }
        
        // 解析响应
        $result = $this->parseTrackbackResponse($response);
        
        if ($result['success']) {
            return [
                'success' => true,
                'message' => 'Trackback 发送成功',
                'response' => $result['message'],
                'trackback_url' => $trackbackUrl
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Trackback 失败: ' . $result['message'],
                'raw_response' => $response
            ];
        }
    }
    
    /**
     * 解析 Trackback 响应
     */
    protected function parseTrackbackResponse($response) {
        // Trackback 响应应该是 XML 格式
        $xml = @simplexml_load_string($response);
        
        if ($xml === false) {
            // 尝试修复常见的 XML 问题
            $response = trim($response);
            $response = preg_replace('/^[^<]+/', '', $response); // 移除 XML 声明前的内容
            $xml = @simplexml_load_string($response);
        }
        
        if ($xml === false) {
            return [
                'success' => false,
                'message' => '无法解析响应'
            ];
        }
        
        // 检查错误
        if (isset($xml->error)) {
            $error = (string)$xml->error;
            if ($error === '0') {
                return [
                    'success' => true,
                    'message' => isset($xml->message) ? (string)$xml->message : 'OK'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => isset($xml->message) ? (string)$xml->message : 'Unknown error'
                ];
            }
        }
        
        return [
            'success' => false,
            'message' => 'Invalid response format'
        ];
    }
    
    /**
     * 从文章内容提取摘要
     */
    public function extractExcerpt($content, $targetUrl, $maxLength = 200) {
        // 移除 HTML 标签
        $text = strip_tags($content);
        
        // 查找目标 URL 周围的文本
        $pos = strpos($text, $targetUrl);
        if ($pos !== false) {
            // 获取 URL 前后的上下文
            $start = max(0, $pos - 100);
            $excerpt = substr($text, $start, $maxLength + strlen($targetUrl));
            
            // 在单词边界处截断
            if (strlen($excerpt) >= $maxLength) {
                $excerpt = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
            }
            
            // 如果没有从开头开始，添加省略号
            if ($start > 0) {
                $excerpt = '...' . ltrim($excerpt);
            }
            
            return $excerpt;
        }
        
        // 如果找不到 URL，返回内容的前面部分
        if (strlen($text) > $maxLength) {
            return substr($text, 0, strrpos(substr($text, 0, $maxLength), ' ')) . '...';
        }
        
        return $text;
    }
}

// ============ 使用示例 ============

// 检查命令行参数
if ($argc > 1) {
    if ($argc < 5) {
        echo "用法: php trackback.php <target_url> <source_url> <title> <excerpt> [blog_name]\n";
        echo "示例: php trackback.php https://example.com/post https://myblog.com/article \"My Article Title\" \"This is an excerpt...\" \"My Blog\"\n";
        exit(1);
    }
    
    $targetUrl = $argv[1];
    $sourceUrl = $argv[2];
    $title = $argv[3];
    $excerpt = $argv[4];
    $blogName = isset($argv[5]) ? $argv[5] : null;
} else {
    // 默认测试数据
    $targetUrl = 'https://blog.andrewhuey.com/2025/10/kagi-search-and-some-ai-thoughts/';
    $sourceUrl = 'https://y2mate.tools/';
    $title = 'y2mate';
    $excerpt = 'read more about '.$targetUrl;
    $blogName = 'Y2Mate';
}

$sender = new TrackbackSender();

echo "=== 发送 Trackback ===\n";
echo "目标 URL: $targetUrl\n";
echo "源 URL: $sourceUrl\n";
echo "标题: $title\n";
echo "摘要: $excerpt\n";
echo "博客名: " . ($blogName ?: '(自动检测)') . "\n\n";

$result = $sender->sendTrackback($targetUrl, $sourceUrl, $title, $excerpt, $blogName);

if ($result['success']) {
    echo "\n✓ " . $result['message'] . "\n";
    if (isset($result['response'])) {
        echo "服务器响应: " . $result['response'] . "\n";
    }
} else {
    echo "\n✗ " . $result['message'] . "\n";
    if (isset($result['raw_response'])) {
        echo "\n原始响应:\n" . $result['raw_response'] . "\n";
    }
}

?>