<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 设置CORS头部允许跨域请求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// 处理OPTIONS预检请求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 对称解密函数
function decryptData($encryptedData) {
    $algorithm = 'aes-256-cbc';
    $key = substr(hex2bin('a1b2c3d4e5f6789012345678901234567890123456789012345678901234abcd'), 0, 32); // 32字节密钥，与server.js中一致
    
    $parts = explode(':', $encryptedData);
    if (count($parts) !== 2) {
        throw new Exception('Invalid encrypted data format');
    }
    
    $iv = hex2bin($parts[0]);
    $encrypted = hex2bin($parts[1]);
    
    $decrypted = openssl_decrypt($encrypted, $algorithm, $key, OPENSSL_RAW_DATA, $iv);
    
    if ($decrypted === false) {
        throw new Exception('Decryption failed');
    }
    
    return $decrypted;
}

// 发送下载请求
function fetchDownloadUrl($cdnUrl, $downloadType, $quality, $key) {
    $url = "https://{$cdnUrl}/download";
    
    $data = [
        'downloadType' => $downloadType,
        'quality' => intval($quality),
        'key' => $key
    ];
    
    $headers = [
        'accept: */*',
        'accept-language: zh-CN,zh;q=0.9',
        'cache-control: no-cache',
        'content-type: application/json',
        'origin: https://yt.savetube.me',
        'pragma: no-cache',
        'priority: u=1, i',
        'referer: https://yt.savetube.me/',
        'sec-ch-ua: "Chromium";v="140", "Not=A?Brand";v="24", "Google Chrome";v="140"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "macOS"',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: cross-site',
        'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36'
    ];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_FOLLOWLOCATION => true
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        throw new Exception('CURL Error: ' . $error);
    }
    
    if ($httpCode !== 200) {
        throw new Exception('HTTP Error: ' . $httpCode);
    }
    
    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON Parse Error');
    }
    
    return $result;
}

// 主处理逻辑
try {
    // 检查参数
    if (!isset($_GET['encode'])) {
        throw new Exception('Missing encode parameter');
    }
    
    $encodedData = $_GET['encode'];
    
    // 解密参数
    $decryptedJson = decryptData($encodedData);
    $params = json_decode($decryptedJson, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON in decrypted data');
    }
    
    // 验证必要参数
    if (!isset($params['cdnUrl']) || !isset($params['downloadType']) || 
        !isset($params['quality']) || !isset($params['key'])) {
        throw new Exception('Missing required parameters');
    }
    
    // 直接返回解密后的参数给客户端
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'cdnUrl' => $params['cdnUrl'],
        'downloadType' => $params['downloadType'],
        'quality' => intval($params['quality']),
        'key' => $params['key']
    ]);
    exit;
    
} catch (Exception $e) {
    // 错误处理
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
    exit;
}