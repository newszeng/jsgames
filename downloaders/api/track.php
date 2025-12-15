<?php
// 流量统计API接口
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// 获取POST数据
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

// 根据HTTP_HOST获取当前域名
function getCurrentDomain() {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    // 移除端口号
    if (strpos($host, ':') !== false) {
        $host = explode(':', $host)[0];
    }
    return $host;
}

// 获取客户端IP
function getClientIP() {
    $ipKeys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            $ip = $_SERVER[$key];
            if (strpos($ip, ',') !== false) {
                $ip = explode(',', $ip)[0];
            }
            return trim($ip);
        }
    }
    return '0.0.0.0';
}

// 查询IP信息
function getIPInfo($ip) {

    // 调用IP API
    $apiKey = 'YztPVNfxyXJYBE3';
    $url = "https://pro.ip-api.com/json/{$ip}?key={$apiKey}";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && $response) {
        $ipInfo = json_decode($response, true);
        return $ipInfo;
    }
    
    // 默认值
    return [
        'country' => 'Unknown',
        'countryCode' => 'XX',
        'region' => 'Unknown',
        'city' => 'Unknown',
        'isp' => 'Unknown'
    ];
}

// 创建日志目录
function ensureLogDirectory($domain, $yearMonth) {
    $logDir = __DIR__ . '/../analytics/' . $domain . '/' . $yearMonth;
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    return $logDir;
}

// 写入日志
function writeLog($data, $ipInfo, $domain) {
    $yearMonth = date('Ym');
    $day = date('Ymd');
    
    $logDir = ensureLogDirectory($domain, $yearMonth);
    $logFile = $logDir . '/' . $day . '.log';
    
    // 检查是否是心跳更新
    $isHeartbeat = isset($data['isHeartbeat']) && $data['isHeartbeat'] === true;
    $sessionId = $data['sessionId'] ?? '';
    $visitorId = $data['visitorId'] ?? '';
    $url = $data['pageInfo']['url'] ?? '';
    
    // 如果是心跳，尝试更新现有记录
    if ($isHeartbeat && !empty($sessionId)) {
        // 创建会话文件来跟踪最新状态
        $sessionDir = $logDir . '/sessions';
        if (!is_dir($sessionDir)) {
            mkdir($sessionDir, 0755, true);
        }
        
        $sessionFile = $sessionDir . '/' . md5($sessionId . '_' . $url) . '.json';
        
        // 更新会话信息
        $sessionData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'visitor_id' => $visitorId,
            'session_id' => $sessionId,
            'ip' => getClientIP(),
            'country' => $ipInfo['country'] ?? 'Unknown',
            'country_code' => $ipInfo['countryCode'] ?? 'XX',
            'region' => $ipInfo['regionName'] ?? $ipInfo['region'] ?? 'Unknown',
            'city' => $ipInfo['city'] ?? 'Unknown',
            'isp' => $ipInfo['isp'] ?? 'Unknown',
            'device_type' => $data['pageInfo']['deviceType'] ?? 'unknown',
            'user_agent' => $data['pageInfo']['userAgent'] ?? '',
            'screen_resolution' => $data['pageInfo']['screenResolution'] ?? '',
            'viewport' => $data['pageInfo']['viewport'] ?? '',
            'url' => $url,
            'title' => $data['pageInfo']['title'] ?? '',
            'referrer' => $data['pageInfo']['referrer'] ?? 'direct',
            'language' => $data['pageInfo']['language'] ?? '',
            'browser_language' => $data['pageInfo']['browserLanguage'] ?? '',
            'duration' => $data['duration'] ?? 0,
            'session_page_count' => $data['sessionPageCount'] ?? 1,
            'start_time' => null,
            'last_update' => date('Y-m-d H:i:s')
        ];
        
        // 如果会话文件已存在，保留开始时间
        if (file_exists($sessionFile)) {
            $existingData = json_decode(file_get_contents($sessionFile), true);
            $sessionData['start_time'] = $existingData['start_time'] ?? $existingData['timestamp'];
        } else {
            $sessionData['start_time'] = $sessionData['timestamp'];
        }
        
        // 保存会话数据
        file_put_contents($sessionFile, json_encode($sessionData));
        
        // 心跳不写入主日志文件
        return true;
    }
    
    // 初始访问，写入日志
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'visitor_id' => $visitorId,
        'session_id' => $sessionId,
        'ip' => getClientIP(),
        'country' => $ipInfo['country'] ?? 'Unknown',
        'country_code' => $ipInfo['countryCode'] ?? 'XX',
        'region' => $ipInfo['regionName'] ?? $ipInfo['region'] ?? 'Unknown',
        'city' => $ipInfo['city'] ?? 'Unknown',
        'isp' => $ipInfo['isp'] ?? 'Unknown',
        'device_type' => $data['pageInfo']['deviceType'] ?? 'unknown',
        'user_agent' => $data['pageInfo']['userAgent'] ?? '',
        'screen_resolution' => $data['pageInfo']['screenResolution'] ?? '',
        'viewport' => $data['pageInfo']['viewport'] ?? '',
        'url' => $url,
        'title' => $data['pageInfo']['title'] ?? '',
        'referrer' => $data['pageInfo']['referrer'] ?? 'direct',
        'language' => $data['pageInfo']['language'] ?? '',
        'browser_language' => $data['pageInfo']['browserLanguage'] ?? '',
        'duration' => $data['duration'] ?? 0,
        'session_page_count' => $data['sessionPageCount'] ?? 1
    ];
    
    // 转换为日志行
    $logLine = implode('|', array_map(function($value) {
        return str_replace(['|', "\n", "\r"], ['', ' ', ' '], $value);
    }, $logData)) . "\n";
    
    // 写入文件（使用文件锁）
    $fp = fopen($logFile, 'a');
    if ($fp) {
        flock($fp, LOCK_EX);
        fwrite($fp, $logLine);
        flock($fp, LOCK_UN);
        fclose($fp);
    }
    
    // 如果是初始访问，创建会话文件
    if (!empty($sessionId)) {
        $sessionDir = $logDir . '/sessions';
        if (!is_dir($sessionDir)) {
            mkdir($sessionDir, 0755, true);
        }
        
        $sessionFile = $sessionDir . '/' . md5($sessionId . '_' . $url) . '.json';
        $sessionData = $logData;
        $sessionData['start_time'] = $sessionData['timestamp'];
        $sessionData['last_update'] = $sessionData['timestamp'];
        
        file_put_contents($sessionFile, json_encode($sessionData));
    }
    
    return true;
}

// 主处理逻辑
try {
    $domain = getCurrentDomain();
    
    if (empty($domain)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid domain']);
        exit;
    }
    
    $clientIP = getClientIP();
    $ipInfo = getIPInfo($clientIP);
    
    if (writeLog($data, $ipInfo, $domain)) {
        echo json_encode(['status' => 'success']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to write log']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
?>