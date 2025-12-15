<?php
/**
 * Pingback 发送脚本
 * 仅用于教育和测试目的
 */

class PingbackSender {

    /**
     * 发现目标网站的 Pingback 服务器
     */
    public function discoverPingbackServer($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        // 方法1: 检查 HTTP Header 中的 X-Pingback
        if (preg_match('/X-Pingback:\s*(.+)/i', $headers, $matches)) {
            return trim($matches[1]);
        }

        // 方法2: 检查 HTML 中的 <link rel="pingback">
        if (preg_match('/<link\s+rel=["\']pingback["\']\s+href=["\'](.*?)["\']/i', $body, $matches)) {
            return $matches[1];
        }

        // 方法3: 默认尝试 WordPress 标准路径
        $parsed_url = parse_url($url);
        $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        return $base_url . '/xmlrpc.php';
    }

    /**
     * 手动构建 XML-RPC 请求
     */
    private function buildXmlRpcRequest($method, $params) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<methodCall>';
        $xml .= '<methodName>' . htmlspecialchars($method) . '</methodName>';
        $xml .= '<params>';
        
        foreach ($params as $param) {
            $xml .= '<param><value>';
            $xml .= '<string>' . htmlspecialchars($param) . '</string>';
            $xml .= '</value></param>';
        }
        
        $xml .= '</params>';
        $xml .= '</methodCall>';
        
        return $xml;
    }

    /**
     * 解析 XML-RPC 响应
     */
    private function parseXmlRpcResponse($response, $debug = false) {
        if ($debug) {
            echo "Raw response:\n";
            echo $response . "\n\n";
        }
        
        // 解析 XML
        $xml = @simplexml_load_string($response);
        
        if ($xml === false) {
            return [
                'success' => false,
                'is_fault' => false,
                'data' => null,
                'error' => '无法解析 XML 响应',
                'raw_response' => $response
            ];
        }
        
        // 检查是否是错误响应
        if (isset($xml->fault)) {
            $faultCode = 0;
            $faultString = '';
            
            foreach ($xml->fault->value->struct->member as $member) {
                if ((string)$member->name === 'faultCode') {
                    $faultCode = (int)$member->value->int;
                } elseif ((string)$member->name === 'faultString') {
                    $faultString = (string)$member->value->string;
                }
            }
            
            return [
                'success' => false,
                'is_fault' => true,
                'faultCode' => $faultCode,
                'faultString' => $faultString
            ];
        }
        
        // 成功响应
        if (isset($xml->params->param->value->string)) {
            return [
                'success' => true,
                'is_fault' => false,
                'data' => (string)$xml->params->param->value->string
            ];
        }
        
        return [
            'success' => true,
            'is_fault' => false,
            'data' => 'OK'
        ];
    }

    /**
     * 发送 Pingback XML-RPC 请求
     */
    public function sendPingback($sourceUrl, $targetUrl, $pingbackServer = null) {
        // 如果没有指定服务器，自动发现
        if (!$pingbackServer) {
            $pingbackServer = $this->discoverPingbackServer($targetUrl);
            if (!$pingbackServer) {
                return [
                    'success' => false,
                    'message' => '无法发现 Pingback 服务器'
                ];
            }
            echo "发现的 Pingback 服务器: $pingbackServer\n";
        }

        // 构建 XML-RPC 请求
        $request = $this->buildXmlRpcRequest('pingback.ping', [$sourceUrl, $targetUrl]);

        // 发送请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pingbackServer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: text/xml',
            'User-Agent: PHP Pingback Client'
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                'success' => false,
                'message' => 'CURL 错误: ' . $error
            ];
        }

        // 解析响应
        $result = $this->parseXmlRpcResponse($response);

        if ($result['is_fault']) {
            return [
                'success' => false,
                'message' => 'Pingback 失败: ' . $result['faultString'],
                'code' => $result['faultCode']
            ];
        }

        if (!$result['success']) {
            return [
                'success' => false,
                'message' => $result['error'] ?? 'Unknown error',
                'raw_response' => $result['raw_response'] ?? null
            ];
        }

        return [
            'success' => true,
            'message' => 'Pingback 发送成功',
            'response' => $result['data']
        ];
    }

    /**
     * 验证源 URL 是否包含目标链接
     */
    public function validateSourceContainsTarget($sourceUrl, $targetUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sourceUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $content = curl_exec($ch);
        curl_close($ch);

        // 检查内容中是否包含目标链接
        return strpos($content, $targetUrl) !== false;
    }

    /**
     * 从文章内容中提取所有外部链接
     */
    public function extractExternalLinks($content, $currentDomain) {
        $links = [];

        // 匹配所有 <a> 标签的 href
        preg_match_all('/<a[^>]+href=["\'](https?:\/\/[^"\']+)["\'][^>]*>/i', $content, $matches);

        foreach ($matches[1] as $url) {
            $parsed = parse_url($url);
            // 只保留外部链接
            if (isset($parsed['host']) && $parsed['host'] !== $currentDomain) {
                $links[] = $url;
            }
        }

        return array_unique($links);
    }

    /**
     * 批量发送 Pingback
     */
    public function batchSendPingbacks($sourceUrl, $articleContent, $currentDomain) {
        $links = $this->extractExternalLinks($articleContent, $currentDomain);
        $results = [];

        foreach ($links as $targetUrl) {
            echo "正在处理: {$targetUrl}\n";

            // 延迟，避免请求过快
            sleep(2);

            $result = $this->sendPingback($sourceUrl, $targetUrl);
            $results[$targetUrl] = $result;

            echo $result['success'] ? '✓ 成功' : '✗ 失败: ' . $result['message'];
            echo "\n\n";
        }

        return $results;
    }
}

// ============ 使用示例 ============

// 检查命令行参数
if ($argc > 1) {
    // 命令行模式
    if ($argc < 3) {
        echo "用法: php pingback.php <source_url> <target_url> [pingback_server]\n";
        echo "示例: php pingback.php https://y2mate.tools/ https://example.com/post\n";
        exit(1);
    }
    
    $sourceUrl = $argv[1];
    $targetUrl = $argv[2];
    $pingbackServer = isset($argv[3]) ? $argv[3] : null;
} else {
    // 默认测试
    $sourceUrl = 'https://y2mate.tools/';  // 你的文章 URL
    $targetUrl = 'https://wordpress.com/blog/2024/01/15/updates/';     // 被引用的文章 URL
    $pingbackServer = null;
}

$sender = new PingbackSender();

echo "发送 Pingback:\n";
echo "源 URL: $sourceUrl\n";
echo "目标 URL: $targetUrl\n";
if ($pingbackServer) {
    echo "指定的 Pingback 服务器: $pingbackServer\n";
}
echo "\n";

$result = $sender->sendPingback($sourceUrl, $targetUrl, $pingbackServer);

if ($result['success']) {
    echo "\n✓ Pingback 发送成功！\n";
    if (isset($result['response'])) {
        echo "响应: " . $result['response'] . "\n";
    }
} else {
    echo "\n✗ Pingback 发送失败: " . $result['message'] . "\n";
    if (isset($result['code'])) {
        echo "错误代码: " . $result['code'] . "\n";
    }
    if (isset($result['raw_response'])) {
        echo "\n原始响应:\n" . $result['raw_response'] . "\n";
    }
}


?>