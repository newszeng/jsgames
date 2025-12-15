<?php
error_reporting(0);
/**
 * All-in-One Video Downloader API
 * 支持多个视频平台的下载解析
 */

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

// 处理GET请求 - 用于获取保护的下载链接并直接跳转
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['did'])) {
    session_start();
    $downloadId = intval($_GET['did']);
    
    if (isset($_SESSION['download_links']) && isset($_SESSION['download_links'][$downloadId])) {
        $downloadUrl = $_SESSION['download_links'][$downloadId];
        
        // 直接重定向到下载地址
        header('Location: ' . $downloadUrl);
        exit;
    } else {
        // 如果链接不存在或已过期，显示错误页面
        http_response_code(404);
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Expired</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background: #f5f5f5;
        }
        .error-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        .error-icon {
            font-size: 64px;
            margin-bottom: 16px;
        }
        .error-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin: 0 0 12px 0;
        }
        .error-message {
            font-size: 16px;
            color: #666;
            margin: 0 0 24px 0;
            line-height: 1.5;
        }
        .back-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⏰</div>
        <h1 class="error-title">Download Expired</h1>
        <p class="error-message">This download link has expired or is no longer available. Please go back and try downloading again.</p>
        <a href="javascript:history.back()" class="back-btn">Go Back</a>
    </div>
</body>
</html>';
    }
    exit;
}

// 默认返回JSON，如果请求HTML格式则返回HTML
$responseFormat = $_GET['format'] ?? $_POST['format'] ?? 'json';
if ($responseFormat === 'html') {
    header('Content-Type: text/html; charset=utf-8');
} else {
    header('Content-Type: application/json');
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 处理OPTIONS请求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// 只允许POST请求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    if ($responseFormat === 'html') {
        echo generateErrorHTML('Method not allowed. Please use POST request.');
    } else {
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    }
    exit;
}

try {
    // 浏览器访问验证
    if (!validateBrowserRequest()) {
        http_response_code(403);
        if ($responseFormat === 'html') {
            echo generateErrorHTML('Access denied. Please use a web browser to access this service.');
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Access denied. Please use a web browser to access this service.'
            ]);
        }
        exit;
    }
    
    // 防刷检查
    $rateLimitCheck = checkRateLimit();
    if (!$rateLimitCheck['allowed']) {
        http_response_code(429);
        if ($responseFormat === 'html') {
            echo generateErrorHTML($rateLimitCheck['message']);
        } else {
            echo json_encode([
                'success' => false,
                'message' => $rateLimitCheck['message'],
                'wait_time' => $rateLimitCheck['wait_time'] ?? 0
            ]);
        }
        exit;
    }
    
    // 获取POST数据 - 支持JSON和FormData两种格式
    $data = [];
    
    // 首先检查是否是JSON格式
    $input = file_get_contents('php://input');
    if (!empty($input)) {
        $jsonData = json_decode($input, true);
        if ($jsonData) {
            $data = $jsonData;
        }
    }
    
    // 如果不是JSON格式，检查FormData格式
    if (empty($data) && !empty($_POST)) {
        $data = $_POST;
    }
    
    // 判断是搜索还是解析
    if (isset($data['action']) && $data['action'] === 'search') {
        // 处理搜索请求
        if (!isset($data['keyword']) || empty(trim($data['keyword']))) {
            throw new Exception('Keyword parameter is required for search');
        }
        
        $keyword = trim($data['keyword']);
        $searchResult = searchYouTube($keyword);
        
        if ($responseFormat === 'html') {
            echo generateSearchHTML($searchResult, $keyword);
        } else {
            echo json_encode([
                'success' => true,
                'data' => $searchResult
            ]);
        }
        exit;
    }
    
    // 处理下载解析请求
    if (!$data || !isset($data['url'])) {
        throw new Exception('URL parameter is required');
    }
    
    // CSRF Token验证
    if (!isset($data['csrf_token']) || !validateCSRFToken($data['csrf_token'])) {
        http_response_code(403);
        if ($responseFormat === 'html') {
            echo generateErrorHTML('Invalid security token. Please refresh the page and try again.');
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid security token. Please refresh the page and try again.'
            ]);
        }
        exit;
    }
    
    $url = trim($data['url']);
    
    // 验证URL格式
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        throw new Exception('Invalid URL format');
    }
    
    // 检查支持的平台
    $supportedDomains = [
        'youtube.com', 'youtu.be', 'm.youtube.com',
        'tiktok.com', 'www.tiktok.com', 'vm.tiktok.com',
        'instagram.com', 'www.instagram.com',
        'facebook.com', 'www.facebook.com', 'fb.watch',
        'twitter.com', 'x.com', 'mobile.twitter.com',
        'pinterest.com', 'www.pinterest.com', 'pin.it',
        'vimeo.com', 'www.vimeo.com',
        'dailymotion.com', 'www.dailymotion.com',
        'ted.com', 'www.ted.com',
        'tumblr.com', 'www.tumblr.com',
        'imgur.com', 'www.imgur.com', 'i.imgur.com'
    ];
    
    $parsedUrl = parse_url($url);
    $domain = $parsedUrl['host'] ?? '';
    
    $isSupported = false;
    foreach ($supportedDomains as $supportedDomain) {
        if (strpos($domain, $supportedDomain) !== false || $domain === $supportedDomain) {
            $isSupported = true;
            break;
        }
    }
    
    if (!$isSupported) {
        throw new Exception('Unsupported platform. Please use URLs from YouTube, TikTok, Instagram, Facebook, Twitter, Pinterest, Vimeo, Dailymotion, TED, Tumblr, or Imgur.');
    }
    
    // 检查是否是TikTok URL，如果是则调用tiktok.php
    if (strpos($domain, 'tiktok.com') !== false || strpos($domain, 'vm.tiktok.com') !== false) {
        $result = callTikTokAPI($url);
    } else {
        // 调用下载解析API
        $result = callDownloadAPI($url);
    }
    
    if ($result) {
        // 记录成功请求
        logDownloadRequest($url, true);
        // 更新请求记录
        updateRequestRecord();
        
        if ($responseFormat === 'html') {
            echo generateDownloadHTML($result, true); // 传递true表示保存链接到session
        } else {
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
        }
    } else {
        logDownloadRequest($url, false, 'API returned no data');
        throw new Exception('Failed to parse video information');
    }
    
} catch (Exception $e) {
    logDownloadRequest($url ?? 'unknown', false, $e->getMessage());
    http_response_code(400);
    
    if ($responseFormat === 'html') {
        echo generateErrorHTML($e->getMessage());
    } else {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

/**
 * 检查请求频率限制
 */
function checkRateLimit() {
    session_start();
    
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $now = time();
    
    // Session限制：每10秒只能请求一次
    if (isset($_SESSION['last_downloader_request'])) {
        $sessionWait = 10 - ($now - $_SESSION['last_downloader_request']);
        if ($sessionWait > 0) {
            return [
                'allowed' => false,
                'message' => "Please wait {$sessionWait} seconds before trying again. We limit request frequency to protect server resources.",
                'wait_time' => $sessionWait
            ];
        }
    }
    
    // IP限制：每分钟最多5次请求
    $requestFile = __DIR__ . '/../cache/downloader_requests.json';
    $requestDir = dirname($requestFile);
    
    if (!is_dir($requestDir)) {
        mkdir($requestDir, 0755, true);
    }
    
    $ipRequests = [];
    if (file_exists($requestFile)) {
        $ipRequests = json_decode(file_get_contents($requestFile), true) ?: [];
    }
    
    // 清理60秒前的记录
    $ipRequests = array_filter($ipRequests, function($timestamp) use ($now) {
        return ($now - $timestamp) < 60;
    });
    
    // 检查当前IP的请求次数
    $currentIpRequests = array_filter($ipRequests, function($timestamp, $key) use ($ip) {
        return strpos($key, $ip . '_') === 0;
    }, ARRAY_FILTER_USE_BOTH);
    
    if (count($currentIpRequests) >= 5) {
        return [
            'allowed' => false,
            'message' => 'Too many requests. Please try again later. We limit to 5 parsing requests per minute to ensure service stability.',
            'wait_time' => 60
        ];
    }
    
    return ['allowed' => true];
}

/**
 * 更新请求记录
 */
function updateRequestRecord() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $now = time();
    
    // 更新Session记录
    $_SESSION['last_downloader_request'] = $now;
    
    // 更新IP请求记录
    $requestFile = __DIR__ . '/../cache/downloader_requests.json';
    $ipRequests = [];
    
    if (file_exists($requestFile)) {
        $ipRequests = json_decode(file_get_contents($requestFile), true) ?: [];
    }
    
    // 添加当前请求
    $ipRequests[$ip . '_' . $now] = $now;
    
    // 清理60秒前的记录
    $ipRequests = array_filter($ipRequests, function($timestamp) use ($now) {
        return ($now - $timestamp) < 60;
    });
    
    // 保存更新后的记录
    file_put_contents($requestFile, json_encode($ipRequests), LOCK_EX);
}

/**
 * 验证浏览器请求（组合检查）- 简化版本
 */
function validateBrowserRequest() {
    $score = 0;
    
    // User-Agent检查 (+2分) - 更宽松的匹配
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if (!empty($userAgent) && (
        preg_match('/(Chrome|Firefox|Safari|Edge|Opera|Mozilla)\/[0-9\.]+/', $userAgent) ||
        strpos($userAgent, 'Mozilla') !== false
    )) {
        $score += 2;
    }
    
    // Referer检查 (+2分) - 如果有referer且包含host则加分，没有referer不扣分
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (empty($referer) || strpos($referer, $host) !== false) {
        $score += 2;
    }
    
    // Accept header检查 (+1分) - 更宽松的检查
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    if (empty($accept) || 
        strpos($accept, 'text/html') !== false || 
        strpos($accept, 'application/json') !== false ||
        strpos($accept, '*/*') !== false) {
        $score += 1;
    }
    
    // 降低要求：至少2分即可通过验证
    return $score >= 2;
}

/**
 * 生成CSRF Token
 */
function generateCSRFToken() {
    session_start();
    if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time']) || 
        (time() - $_SESSION['csrf_token_time']) > 3600) { // 1小时过期
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }
    return $_SESSION['csrf_token'];
}

/**
 * 验证CSRF Token
 */
function validateCSRFToken($token) {
    session_start();
    return isset($_SESSION['csrf_token']) && 
           isset($_SESSION['csrf_token_time']) &&
           (time() - $_SESSION['csrf_token_time']) <= 3600 && // 检查过期
           hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * 调用TikTok专用API
 */
function callTikTokAPI($url) {
    require_once __DIR__ . '/tiktok.php';
    
    try {
        $result = fetch($url);
        
        if (!$result || empty($result['medias'])) {
            return false;
        }
        
        // 转换为标准格式
        $normalizedData = [
            'title' => $result['title'] ?? 'TikTok Video',
            'thumb' => $result['thumbnail'] ?? '',
            'author' => '',
            'duration' => '',
            'source' => $url,
            'platform' => 'TikTok',
            'url' => []
        ];
        
        // 转换媒体格式
        foreach ($result['medias'] as $media) {
            $type = 'video';
            $name = '';
            
            if ($media->extension === 'mp3') {
                $type = 'audio';
                $name = 'Audio Only';
            } else if ($media->quality === 'watermark') {
                $name = 'With Watermark';
            } else if ($media->quality === 'hd') {
                $name = 'HD Quality';
            }
            
            $normalizedData['url'][] = [
                'url' => $media->url,
                'ext' => $media->extension,
                'quality' => $media->quality,
                'name' => $name,
                'type' => $type,
                'with_watermark' => $media->quality === 'watermark',
                'audio' => $type === 'audio'
            ];
        }
        
        return $normalizedData;
        
    } catch (Exception $e) {
        error_log("TikTok API error: " . $e->getMessage());
        return false;
    }
}

/**
 * 调用下载解析API
 */
function callDownloadAPI($url) {

    if(stripos($url,'youtube')===false){
        $apiUrl = 'http://23.239.5.68:3000/api?url=' . urlencode($url);
    }else{
        $apiUrl = 'http://23.239.5.68:3002/api?url=' . urlencode($url);
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        error_log("Downloader API cURL error: " . $curlError);
        return false;
    }
    
    if ($httpCode !== 200) {
        error_log("Downloader API HTTP error: " . $httpCode);
        return false;
    }
    
    $data = json_decode($response, true);
    
    if (!$data) {
        error_log("Downloader API invalid JSON response");
        return false;
    }
    
    // 处理数组响应格式（Instagram等）
    if (is_array($data) && isset($data[0]) && !isset($data['url'])) {
        // Instagram返回多个媒体项，合并所有项
        $mergedData = [
            'url' => [],
            'meta' => null,
            'thumb' => ''
        ];
        
        // 合并所有媒体项的URL，保留各自的缩略图
        foreach ($data as $index => $item) {
            if (isset($item['url']) && is_array($item['url'])) {
                foreach ($item['url'] as $urlItem) {
                    // 为每个URL项添加对应的缩略图，需要创建新数组
                    $newItem = $urlItem;
                    $newItem['thumb'] = $item['thumb'] ?? '';
                    $newItem['item_index'] = $index + 1; // 添加索引标识
                    $mergedData['url'][] = $newItem;
                }
            }
            
            // 获取第一个有效的meta和thumb
            if (!$mergedData['meta'] && isset($item['meta'])) {
                $mergedData['meta'] = $item['meta'];
            }
            if (!$mergedData['thumb'] && isset($item['thumb'])) {
                $mergedData['thumb'] = $item['thumb'];
            }
            
            // 处理SD视频
            if (isset($item['sd']) && isset($item['sd']['url'])) {
                $mergedData['sd'] = $item['sd'];
            }
        }
        
        $data = $mergedData;
    }

    // 标准化返回数据格式
    $normalizedData = normalizeAPIResponse($data);
    
    return $normalizedData;
}

/**
 * 标准化API返回数据格式
 */
function normalizeAPIResponse($data) {
    $result = [
        'title' => '',
        'thumb' => $data['thumb'] ?? '',
        'author' => '',
        'duration' => '',
        'source' => '',
        'platform' => '',
        'url' => []
    ];
    
    // 解析标题和作者信息
    if (isset($data['meta'])) {
        $meta = $data['meta'];
        $result['title'] = $meta['title'] ?? 'Unknown Title';
        $result['duration'] = $meta['duration'] ?? '';
        $result['source'] = $meta['source'] ?? '';
        
        // 不同平台的作者字段不同
        if (isset($meta['author'])) {
            if (is_array($meta['author'])) {
                $result['author'] = $meta['author']['nickname'] ?? $meta['author']['unique_id'] ?? '';
            } else {
                $result['author'] = $meta['author'];
            }
        } elseif (isset($meta['username'])) {
            $result['author'] = '@' . $meta['username'];
        }
        
        // Instagram特有的元数据
        if (isset($meta['like_count'])) {
            $result['author'] .= ' (' . number_format($meta['like_count']) . ' likes)';
        }
        
        // 确定平台
        $source = $result['source'];
        if (strpos($source, 'youtube.com') !== false) {
            $result['platform'] = 'YouTube';
        } elseif (strpos($source, 'tiktok.com') !== false) {
            $result['platform'] = 'TikTok';
        } elseif (strpos($source, 'instagram.com') !== false) {
            $result['platform'] = 'Instagram';
        } elseif (strpos($source, 'facebook.com') !== false) {
            $result['platform'] = 'Facebook';
        } elseif (strpos($source, 'twitter.com') !== false || strpos($source, 'x.com') !== false) {
            $result['platform'] = 'Twitter/X';
        } elseif (strpos($source, 'pinterest.com') !== false) {
            $result['platform'] = 'Pinterest';
        } else {
            $result['platform'] = 'Unknown';
        }
    }
    
    // 处理下载链接
    $videoOptions = [];
    $audioOptions = [];
    
    if (isset($data['url']) && is_array($data['url'])) {
        foreach ($data['url'] as $item) {
            if (isset($item['url']) && !empty($item['url'])) {
                // 不再过滤无音频的项，而是标记它们
                $skipItem = false;
                
                // 过滤掉带水印的版本（如果有不带水印的）
                if (isset($item['with_watermark']) && $item['with_watermark'] === true) {
                    // 检查是否有相同质量的无水印版本
                    $hasNoWatermarkVersion = false;
                    foreach ($data['url'] as $checkItem) {
                        if (isset($checkItem['subname']) && isset($item['subname']) && 
                            $checkItem['subname'] === $item['subname'] && 
                            (!isset($checkItem['with_watermark']) || $checkItem['with_watermark'] === false)) {
                            $hasNoWatermarkVersion = true;
                            break;
                        }
                    }
                    if ($hasNoWatermarkVersion) {
                        $skipItem = true;
                    }
                }
                
                if (!$skipItem) {
                    $quality = $item['quality'] ?? $item['subname'] ?? $item['name'] ?? 'Unknown';
                    $name = $item['name'] ?? '';
                    $ext = strtolower($item['ext'] ?? 'unknown');
                    
                    // 判断媒体类型
                    $isAudio = isset($item['audio']) && $item['audio'] === true;
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    
                    if ($isAudio) {
                        // 音频质量
                        if (is_numeric($quality)) {
                            $quality = $quality . 'kbps';
                        }
                        $name = $name . ' (Audio Only)';
                    } elseif ($isImage) {
                        // 图片
                        $quality = strtoupper($ext);
                        if (empty($name)) {
                            $name = 'Image';
                        }
                    } else {
                        // 视频质量
                        if (is_numeric($quality)) {
                            $quality = $quality . 'p';
                        }
                    }
                    
                    // 标记无音频的视频
                    if (isset($item['no_audio']) && $item['no_audio'] === true) {
                        $name = $name . ' (No Audio)';
                    }
                    
                    if (isset($item['with_watermark']) && $item['with_watermark'] === true) {
                        $name = $name . ' (With Watermark)';
                    }
                    
                    $downloadItem = [
                        'url' => $item['url'],
                        'ext' => $ext,
                        'quality' => $quality,
                        'name' => $name,
                        'type' => $isAudio ? 'audio' : ($isImage ? 'image' : 'video'),
                        'thumb' => $item['thumb'] ?? null,
                        'item_index' => $item['item_index'] ?? null
                    ];
                    
                    if ($isAudio) {
                        $audioOptions[] = $downloadItem;
                    } else {
                        $videoOptions[] = $downloadItem;
                    }
                }
            }
        }
        
        // 按音频状态和质量排序（有音频在前，然后按质量排序）
        $sortFunction = function($a, $b) {
            // 首先按音频状态排序（有音频的在前）
            $aHasAudio = !strpos($a['name'], '(No Audio)');
            $bHasAudio = !strpos($b['name'], '(No Audio)');
            
            if ($aHasAudio !== $bHasAudio) {
                return $bHasAudio - $aHasAudio; // 有音频的在前
            }
            
            // 然后按质量排序
            $aQuality = preg_match('/(\d+)/', $a['quality'], $aMatches) ? intval($aMatches[1]) : 0;
            $bQuality = preg_match('/(\d+)/', $b['quality'], $bMatches) ? intval($bMatches[1]) : 0;
            
            if ($aQuality > 0 && $bQuality > 0) {
                return $bQuality - $aQuality; // 高质量在前
            }
            
            return strcmp($a['quality'], $b['quality']);
        };
        
        usort($videoOptions, $sortFunction);
        usort($audioOptions, $sortFunction);
        
        // 合并结果：视频在前，音频在后
        $result['url'] = array_merge($videoOptions, $audioOptions);
    }
    
    // 处理特殊格式（HD/SD）
    if (isset($data['hd']) && isset($data['hd']['url'])) {
        array_unshift($result['url'], [
            'url' => $data['hd']['url'],
            'ext' => $data['hd']['format'] ?? 'mp4',
            'quality' => 'HD',
            'name' => 'High Definition'
        ]);
    }
    
    if (isset($data['sd']) && isset($data['sd']['url'])) {
        $result['url'][] = [
            'url' => $data['sd']['url'],
            'ext' => $data['sd']['format'] ?? 'mp4',
            'quality' => 'SD',
            'name' => 'Standard Definition'
        ];
    }
    
    return $result;
}

/**
 * 记录下载请求日志
 */
function logDownloadRequest($url, $success, $error = '') {
    $logFile = __DIR__ . '/../logs/downloader.log';
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'url' => $url,
        'success' => $success ? 'true' : 'false',
        'error' => $error,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ];
    
    $logLine = implode('|', array_map(function($value) {
        return str_replace(['|', "\n", "\r"], ['', ' ', ' '], $value);
    }, $logData)) . "\n";
    
    file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
}

/**
 * 搜索YouTube视频
 */
function searchYouTube($keyword) {
    $searchUrl = 'http://23.239.5.68/aionew/ytsearch.php?kw=' . urlencode($keyword);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $searchUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        error_log("YouTube search cURL error: " . $curlError);
        return [];
    }
    
    if ($httpCode !== 200) {
        error_log("YouTube search HTTP error: " . $httpCode);
        return [];
    }
    
    $data = json_decode($response, true);
    
    if (!$data || !is_array($data)) {
        error_log("YouTube search invalid JSON response");
        return [];
    }
    
    // 记录搜索请求
    logDownloadRequest("search: " . $keyword, true);
    
    return $data;
}

/**
 * 生成HTML格式的下载组件 - 表格风格
 */
function generateDownloadHTML($result, $saveToSession = false) {
    // 如果需要保存到session，启动session并保存下载链接
    if ($saveToSession) {
        session_start();
        if (!isset($_SESSION['download_links'])) {
            $_SESSION['download_links'] = [];
        }
        
        // 清空旧的下载链接
        $_SESSION['download_links'] = [];
        
        // 预先保存所有下载链接到session
        $linkIndex = 1;
        if (!empty($result['url']) && is_array($result['url'])) {
            foreach ($result['url'] as $item) {
                if (isset($item['url']) && !empty($item['url'])) {
                    $_SESSION['download_links'][$linkIndex] = $item['url'];
                    $linkIndex++;
                }
            }
        }
    }
    $html = '
<style>
.download-container {
    max-width: 900px;
    margin: 20px auto;
    padding: 0;
    background: #fff;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.video-info {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.video-thumb {
    flex-shrink: 0;
    width: 200px;
    height: 150px;
    border-radius: 8px;
    overflow: hidden;
    background: #000;
}

.video-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-thumb iframe {
    width: 100%;
    height: 100%;
}

.video-details {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.video-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
    line-height: 1.3;
}

.video-duration {
    font-size: 18px;
    color: #666;
    margin: 0;
}

.download-table {
    border: 1px solid #ddd;
    border-collapse: collapse;
    width: 100%;
    background: #fff;
}

.section-header {
    background: #f8f9fa;
    border-bottom: 1px solid #ddd;
}

.section-header td {
    padding: 12px 20px;
    font-size: 18px;
    font-weight: 600;
    color: #333;
    border: none;
}

.section-icon {
    margin-right: 8px;
}

.download-row {
    border-bottom: 1px solid #ddd;
}

.download-row:last-child {
    border-bottom: 1px solid #ddd;
}

.download-row td {
    padding: 12px 20px;
    border-right: 1px solid #ddd;
    vertical-align: middle;
}

.download-row td:last-child {
    border-right: none;
}

.format-cell {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    min-width: 120px;
}

.audio-icon {
    margin-left: 8px;
    color: #666;
}

.size-cell {
    font-size: 16px;
    color: #666;
    text-align: center;
    min-width: 100px;
}

.download-cell {
    text-align: center;
    min-width: 150px;
}

.download-btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-transform: uppercase;
}

.download-btn:hover {
    background: #218838;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    color: white;
    text-decoration: none;
}

/* 下载进度层样式 */
.download-overlay {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: auto;
    height: auto;
    background: transparent;
    z-index: 10000;
    display: block;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.download-overlay.show {
    opacity: 1;
    visibility: visible;
}

.download-progress {
    background: white;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    width: 280px;
    border: 1px solid #e0e0e0;
}

.download-progress h3 {
    margin: 0 0 15px 0;
    color: #333;
    font-size: 16px;
    font-weight: 600;
}

.download-progress .spinner {
    width: 30px;
    height: 30px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.download-progress .status {
    color: #666;
    font-size: 13px;
    margin-bottom: 15px;
    line-height: 1.4;
}

.download-progress .close-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    margin-top: 5px;
    transition: all 0.2s ease;
}

.download-progress .close-btn:hover {
    background: #c82333;
}

.download-icon {
    font-size: 16px;
}


.no-downloads {
    text-align: center;
    padding: 40px 20px;
    color: #666;
    font-size: 16px;
}

@media (max-width: 768px) {
    .download-container {
        margin: 10px;
    }
    
    .video-info {
        flex-direction: column;
    }
    
    .video-thumb {
        width: 100%;
        height: 200px;
    }
    
    .download-table {
        font-size: 14px;
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    
    .download-table tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    
    .download-row td {
        padding: 8px 6px;
        word-wrap: break-word;
        white-space: normal;
    }
    
    .format-cell {
        font-size: 14px;
        width: 35%;
        min-width: 120px;
    }
    
    .size-cell {
        font-size: 14px;
        width: 20%;
        min-width: 80px;
        text-align: center;
    }
    
    .download-cell {
        width: 45%;
        min-width: 140px;
        text-align: center;
    }
    
    .download-btn {
        padding: 8px 12px;
        font-size: 12px;
        width: 100%;
        max-width: 120px;
        white-space: nowrap;
    }
}
</style>

<div class="download-container">';

    // Video info section
    $html .= '
    <div class="video-info">
        <div class="video-thumb">';
        
    // 检查是否是YouTube视频，如果是则显示iframe embed，否则显示缩略图
    $isYouTube = isset($result['platform']) && $result['platform'] === 'YouTube';
    $youtubeVideoId = '';
    
    if ($isYouTube && !empty($result['source'])) {
        // 从YouTube URL中提取视频ID
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $result['source'], $matches)) {
            $youtubeVideoId = $matches[1];
        }
    }
    
    if ($isYouTube && !empty($youtubeVideoId)) {
        // 显示YouTube iframe embed
        $html .= '<iframe 
                    src="https://www.youtube.com/embed/' . htmlspecialchars($youtubeVideoId) . '?rel=0&modestbranding=1" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen
                    style="border-radius: 8px;">
                  </iframe>';
    } else if (!empty($result['thumb'])) {
        // 非YouTube视频或无法提取ID时显示缩略图
        $html .= '<img src="' . htmlspecialchars($result['thumb']) . '" alt="Video thumbnail" />';
    }
    
    $html .= '
        </div>
        <div class="video-details">
            <h2 class="video-title">' . htmlspecialchars($result['title'] ?: 'Unknown Title') . '</h2>';
            
    if (!empty($result['duration'])) {
        $html .= '<p class="video-duration">Duration: ' . htmlspecialchars($result['duration']) . '</p>';
    }
    
    $html .= '
        </div>
    </div>';

    if (!empty($result['url']) && is_array($result['url'])) {
        // 分组下载选项
        $videoOptions = [];
        $audioOptions = [];
        $imageOptions = [];
        
        // 给每个项目分配索引，与session中的顺序对应
        $globalIndex = 1;
        foreach ($result['url'] as $item) {
            // 计算文件大小（模拟）
            $item['file_size'] = generateFileSize($item['quality'], $item['type'], $item['ext']);
            $item['download_index'] = $globalIndex++; // 保存全局索引
            
            if ($item['type'] === 'video') {
                $videoOptions[] = $item;
            } elseif ($item['type'] === 'audio') {
                $audioOptions[] = $item;
            } elseif ($item['type'] === 'image') {
                $imageOptions[] = $item;
            }
        }
        
        // 广告位排除域名数组
        $adExcludeDomains = ['genyoutube.io'];

        // 获取当前域名
        $currentDomain = $_SERVER['HTTP_HOST'] ?? '';
        
        // 检查是否应该显示广告
        $showAd = !in_array($currentDomain, $adExcludeDomains);
        
        // 广告位
        if ($showAd) {
            $html .= '
        <div class="ad-banner" style="margin: 20px 0; padding: 20px; background: #ffffff; border: 2px solid #e0e0e0; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <a href="https://aimusic.best/?ref=yt" target="_blank" style="text-decoration: none; display: block;">
                <div style="font-size: 20px; font-weight: 700; margin-bottom: 8px; color: #333;">🎵 Free AI Music Generator</div>
                <div style="font-size: 16px; color: #666; margin-bottom: 12px;">Create unlimited music with AI - No registration required</div>
                <div style="display: inline-block; padding: 10px 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 25px; font-weight: 600; font-size: 16px; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    Visit AIMusic.best →
                </div>
            </a>
        </div>
        <style>
        .ad-banner:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .ad-banner a > div:last-child:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        </style>';
        }
        
        // 开始下载表格
        $html .= '<table class="download-table">';
        
        // 音频部分
        if (!empty($audioOptions)) {
            $html .= '
            <tr class="section-header">
                <td colspan="3">
                    <span class="section-icon">🎵</span>Audio
                </td>
            </tr>';
            
            foreach ($audioOptions as $item) {
                $audioIcon = '🔊'; // 默认有声音
                
                // 检查URL是否包含api/downloaderpx.php
                $downloadUrl = $_SESSION['download_links'][$item['download_index']] ?? '';
                $isAsyncDownload = strpos($downloadUrl, 'api/downloaderpx.php') !== false;
                
                $html .= '
                <tr class="download-row">
                    <td class="format-cell">' . strtoupper($item['ext']) . '<span class="audio-icon">' . $audioIcon . '</span></td>
                    <td class="size-cell">' . $item['file_size'] . '</td>
                    <td class="download-cell">';
                
                if ($isAsyncDownload) {
                    // 使用data属性和全局事件处理
                    $html .= '
                        <button class="download-btn" type="button" onclick="
var btn=this;
var downloadUrl=\'' . addslashes($downloadUrl) . '\';
var overlay=document.createElement(\'div\');
overlay.className=\'download-overlay\';
overlay.innerHTML=\'<div class=&quot;download-progress&quot;><h3>Downloading</h3><div class=&quot;spinner&quot;></div><div class=&quot;status&quot;>get link...</div><button class=&quot;close-btn&quot;>Cancel</button></div>\';
document.body.appendChild(overlay);
overlay.querySelector(\'.close-btn\').onclick=function(){overlay.remove();};
setTimeout(function(){overlay.classList.add(\'show\');},10);
var statusEl=overlay.querySelector(\'.status\');
fetch(downloadUrl).then(function(r){
statusEl.textContent=\'get param...\';
return r.json();
}).then(function(data){
statusEl.textContent=\'get cdn...\';
return fetch(\'https://\'+data.cdnUrl+\'/download\',{method:\'POST\',headers:{\'Content-Type\':\'application/json\'},body:JSON.stringify({downloadType:data.downloadType,quality:data.quality,key:data.key})});
}).then(function(r){return r.json();}).then(function(result){
var url=result.data?result.data.downloadUrl:result.downloadUrl;
statusEl.textContent=\'Download ready!\';
overlay.querySelector(\'h3\').textContent=\'Download Ready\';
overlay.querySelector(\'.spinner\').style.display=\'none\';
var closeBtn=overlay.querySelector(\'.close-btn\');
closeBtn.textContent=\'Download Now\';
closeBtn.style.background=\'#28a745\';
closeBtn.style.color=\'white\';
closeBtn.onclick=function(){window.open(url,\'_blank\');overlay.remove();};
btn.innerHTML=\'<span class=&quot;download-icon&quot;>⬇</span>Download\';
btn.style.background=\'#007bff\';
btn.onclick=function(){window.open(url,\'_blank\');};
setTimeout(function(){overlay.remove();},5000);
}).catch(function(e){
overlay.querySelector(\'h3\').textContent=\'failed\';
statusEl.textContent=e.message;
});
">
                            <span class="download-icon">⬇</span>Download
                        </button>';
                } else {
                    $html .= '
                        <a href="/api/downloader.php?did=' . $item['download_index'] . '" class="download-btn" target="_blank" rel="noopener">
                            <span class="download-icon">⬇</span>Download
                        </a>';
                }
                
                $html .= '
                    </td>
                </tr>';
            }
        }
        
        // 视频部分
        if (!empty($videoOptions)) {
            $html .= '
            <tr class="section-header">
                <td colspan="3">
                    <span class="section-icon">🎥</span>Video
                </td>
            </tr>';
            
            foreach ($videoOptions as $item) {
                // 判断是否有音频
                $audioIcon = '🔊'; // 默认有声音
                if (strpos($item['name'], 'No Audio') !== false) {
                    $audioIcon = '🔇'; // 无声音
                } elseif (strpos($item['name'], 'Audio Only') !== false) {
                    $audioIcon = '🔊';
                }
                
                // 检查URL是否包含api/downloaderpx.php
                $downloadUrl = $_SESSION['download_links'][$item['download_index']] ?? '';
                $isAsyncDownload = strpos($downloadUrl, 'api/downloaderpx.php') !== false;
                
                $html .= '
                <tr class="download-row">
                    <td class="format-cell">' . htmlspecialchars($item['quality']) . ' ' . strtoupper($item['ext']) . '<span class="audio-icon">' . $audioIcon . '</span></td>
                    <td class="size-cell">' . $item['file_size'] . '</td>
                    <td class="download-cell">';
                
                if ($isAsyncDownload) {
                    // 使用data属性和全局事件处理
                    $html .= '
                        <button class="download-btn" type="button" onclick="
var btn=this;
var downloadUrl=\'' . addslashes($downloadUrl) . '\';
var overlay=document.createElement(\'div\');
overlay.className=\'download-overlay\';
overlay.innerHTML=\'<div class=&quot;download-progress&quot;><h3>准备下载</h3><div class=&quot;spinner&quot;></div><div class=&quot;status&quot;>正在获取下载链接...</div><button class=&quot;close-btn&quot;>Cancel</button></div>\';
document.body.appendChild(overlay);
overlay.querySelector(\'.close-btn\').onclick=function(){overlay.remove();};
setTimeout(function(){overlay.classList.add(\'show\');},10);
var statusEl=overlay.querySelector(\'.status\');
fetch(downloadUrl).then(function(r){
statusEl.textContent=\'正在解密参数...\';
return r.json();
}).then(function(data){
statusEl.textContent=\'正在请求CDN...\';
return fetch(\'https://\'+data.cdnUrl+\'/download\',{method:\'POST\',headers:{\'Content-Type\':\'application/json\'},body:JSON.stringify({downloadType:data.downloadType,quality:data.quality,key:data.key})});
}).then(function(r){return r.json();}).then(function(result){
var url=result.data?result.data.downloadUrl:result.downloadUrl;
statusEl.textContent=\'Download ready!\';
overlay.querySelector(\'h3\').textContent=\'Download Ready\';
overlay.querySelector(\'.spinner\').style.display=\'none\';
var closeBtn=overlay.querySelector(\'.close-btn\');
closeBtn.textContent=\'Download Now\';
closeBtn.style.background=\'#28a745\';
closeBtn.style.color=\'white\';
closeBtn.onclick=function(){window.open(url,\'_blank\');overlay.remove();};
btn.innerHTML=\'<span class=&quot;download-icon&quot;>⬇</span>Download\';
btn.style.background=\'#007bff\';
btn.onclick=function(){window.open(url,\'_blank\');};
setTimeout(function(){overlay.remove();},5000);
}).catch(function(e){
overlay.querySelector(\'h3\').textContent=\'失败\';
statusEl.textContent=e.message;
});
">
                            <span class="download-icon">⬇</span>Download
                        </button>';
                } else {
                    $html .= '
                        <a href="/api/downloader.php?did=' . $item['download_index'] . '" class="download-btn" target="_blank" rel="noopener">
                            <span class="download-icon">⬇</span>Download
                        </a>';
                }
                
                $html .= '
                    </td>
                </tr>';
            }
        }
        
        // 图片部分
        if (!empty($imageOptions)) {
            $html .= '
            <tr class="section-header">
                <td colspan="3">
                    <span class="section-icon">🖼️</span>Images
                </td>
            </tr>';
            
            foreach ($imageOptions as $item) {
                // 检查URL是否包含api/downloaderpx.php
                $downloadUrl = $_SESSION['download_links'][$item['download_index']] ?? '';
                $isAsyncDownload = strpos($downloadUrl, 'api/downloaderpx.php') !== false;
                
                $html .= '
                <tr class="download-row">
                    <td class="format-cell">' . htmlspecialchars($item['quality']) . '</td>
                    <td class="size-cell">' . $item['file_size'] . '</td>
                    <td class="download-cell">';
                
                if ($isAsyncDownload) {
                    // 使用data属性和全局事件处理
                    $html .= '
                        <button class="download-btn" type="button" onclick="
var btn=this;
var downloadUrl=\'' . addslashes($downloadUrl) . '\';
var overlay=document.createElement(\'div\');
overlay.className=\'download-overlay\';
overlay.innerHTML=\'<div class=&quot;download-progress&quot;><h3>准备下载</h3><div class=&quot;spinner&quot;></div><div class=&quot;status&quot;>正在获取下载链接...</div><button class=&quot;close-btn&quot;>Cancel</button></div>\';
document.body.appendChild(overlay);
overlay.querySelector(\'.close-btn\').onclick=function(){overlay.remove();};
setTimeout(function(){overlay.classList.add(\'show\');},10);
var statusEl=overlay.querySelector(\'.status\');
fetch(downloadUrl).then(function(r){
statusEl.textContent=\'正在解密参数...\';
return r.json();
}).then(function(data){
statusEl.textContent=\'正在请求CDN...\';
return fetch(\'https://\'+data.cdnUrl+\'/download\',{method:\'POST\',headers:{\'Content-Type\':\'application/json\'},body:JSON.stringify({downloadType:data.downloadType,quality:data.quality,key:data.key})});
}).then(function(r){return r.json();}).then(function(result){
var url=result.data?result.data.downloadUrl:result.downloadUrl;
statusEl.textContent=\'Download ready!\';
overlay.querySelector(\'h3\').textContent=\'Download Ready\';
overlay.querySelector(\'.spinner\').style.display=\'none\';
var closeBtn=overlay.querySelector(\'.close-btn\');
closeBtn.textContent=\'Download Now\';
closeBtn.style.background=\'#28a745\';
closeBtn.style.color=\'white\';
closeBtn.onclick=function(){window.open(url,\'_blank\');overlay.remove();};
btn.innerHTML=\'<span class=&quot;download-icon&quot;>⬇</span>Download\';
btn.style.background=\'#007bff\';
btn.onclick=function(){window.open(url,\'_blank\');};
setTimeout(function(){overlay.remove();},5000);
}).catch(function(e){
overlay.querySelector(\'h3\').textContent=\'失败\';
statusEl.textContent=e.message;
});
">
                            <span class="download-icon">⬇</span>Download
                        </button>';
                } else {
                    $html .= '
                        <a href="/api/downloader.php?did=' . $item['download_index'] . '" class="download-btn" target="_blank" rel="noopener">
                            <span class="download-icon">⬇</span>Download
                        </a>';
                }
                
                $html .= '
                    </td>
                </tr>';
            }
        }
        
        $html .= '</table>';
        
    } else {
        $html .= '<div class="no-downloads">No download options available for this content.</div>';
    }

    $html .= '</div>';
    
    // 添加异步下载处理JavaScript
    $html .= '
<script>
function handleAsyncDownload(downloadUrl, btn) {
    console.log("handleAsyncDownload ", downloadUrl, btn);
    
    if (!downloadUrl) {
        alert("download link is not ok");
        return;
    }
    
    var overlay = document.createElement("div");
    overlay.className = "download-overlay";
    overlay.innerHTML = "<div class=\\"download-progress\\"><h3>Downloading</h3><div class=\\"spinner\\"></div><div class=\\"status\\">Get link...</div><button class=\\"close-btn\\">Cancel</button></div>";
    document.body.appendChild(overlay);
    
    overlay.querySelector(".close-btn").addEventListener("click", function() {
        overlay.remove();
    });
    
    setTimeout(function() {
        overlay.classList.add("show");
    }, 10);
    
    var statusEl = overlay.querySelector(".status");
    
    fetch(downloadUrl)
        .then(function(response) {
            if (!response.ok) {
                throw new Error("get param failed: " + response.status);
            }
            statusEl.textContent = "get param...";
            return response.json();
        })
        .then(function(data) {
            if (!data.success) {
                throw new Error("get param failed");
            }
            
            statusEl.textContent = "get last link...";
            
            var cdnUrl = "https://" + data.cdnUrl + "/download";
            var requestData = {
                downloadType: data.downloadType,
                quality: data.quality,
                key: data.key
            };
            
            return fetch(cdnUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(requestData)
            });
        })
        .then(function(response) {
            if (!response.ok) {
                throw new Error("CDN failed: " + response.status);
            }
            statusEl.textContent = "get cdn link...";
            return response.json();
        })
        .then(function(result) {
            var finalDownloadUrl = null;
            if (result.status && result.data && result.data.downloadUrl) {
                finalDownloadUrl = result.data.downloadUrl;
            } else if (result.downloadUrl) {
                finalDownloadUrl = result.downloadUrl;
            } else {
                throw new Error("no cdn link");
            }
            
            statusEl.textContent = "download link ready";
            overlay.querySelector("h3").textContent = "download completed";
            overlay.querySelector(".spinner").style.display = "none";
            overlay.querySelector(".close-btn").textContent = "close";
            
            btn.innerHTML = "<span class=\\"download-icon\\">⬇</span>download";
            btn.style.background = "#007bff";
            btn.onclick = function() {
                window.open(finalDownloadUrl, "_blank");
            };
            
            setTimeout(function() {
                overlay.classList.remove("show");
                setTimeout(function() {
                    overlay.remove();
                }, 300);
            }, 3000);
        })
        .catch(function(error) {
            console.error("download error:", error);
            overlay.querySelector("h3").textContent = "download failed";
            overlay.querySelector(".spinner").style.display = "none";
            statusEl.textContent = "error: " + error.message;
            overlay.querySelector(".close-btn").textContent = "close";
        });
}

console.log("handleAsyncDownload is ok");
</script>';
    
    return $html;
}

/**
 * 生成文件大小（模拟）
 */
function generateFileSize($quality, $type, $ext) {
    // 根据质量和类型生成合理的文件大小
    if ($type === 'audio') {
        if (strpos($quality, '320') !== false) return '7.2M';
        if (strpos($quality, '256') !== false) return '5.8M';
        if (strpos($quality, '128') !== false) return '3.6M';
        return '4.7M'; // 默认
    } elseif ($type === 'video') {
        if (strpos($quality, '1080') !== false) return strpos($quality, 'No Audio') !== false ? '18.5M' : '29.5M';
        if (strpos($quality, '720') !== false) return strpos($quality, 'No Audio') !== false ? '7.4M' : '12.1M';
        if (strpos($quality, '480') !== false) return strpos($quality, 'No Audio') !== false ? '3.2M' : '4.3M';
        if (strpos($quality, '360') !== false) return '6.5M';
        return '8.2M'; // 默认
    } elseif ($type === 'image') {
        return '1.2M';
    }
    
    return '0.0M';
}

/**
 * 安全提取字符串值
 */
function extractStringValue($data, $key, $default = '') {
    if (!isset($data[$key])) {
        return $default;
    }
    
    $value = $data[$key];
    
    // If it's already a string, return it
    if (is_string($value)) {
        return $value;
    }
    
    // If it's an array, try to get the first element
    if (is_array($value)) {
        if (!empty($value) && isset($value[0]) && is_string($value[0])) {
            return $value[0];
        }
        return $default;
    }
    
    // For other types, try to convert to string
    if (is_scalar($value)) {
        return (string) $value;
    }
    
    return $default;
}

/**
 * 生成HTML格式的搜索结果
 */
function generateSearchHTML($searchResult, $keyword) {
    $html = '
<style>
.search-container {
    max-width: 1000px;
    margin: 20px auto;
    padding: 0;
    background: #fff;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.search-title {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin: 0 0 20px 0;
    padding: 20px 20px 0 20px;
}

.search-results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 0 20px 20px 20px;
}

.search-item {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.search-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: rgba(40, 167, 69, 0.2);
}

.search-thumbnail {
    width: 100%;
    height: 160px;
    background: #000;
    position: relative;
    overflow: hidden;
}

.search-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-duration-badge {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.search-content {
    padding: 15px;
    display: flex;
    flex-direction: column;
    flex: 1;
    justify-content: space-between;
}

.search-video-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin: 0 0 8px 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 44px;
    flex: 1;
}

.search-video-author {
    font-size: 14px;
    color: #666;
    margin: 0 0 15px 0;
}

.search-download-btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0 auto;
    min-width: 120px;
    align-self: center;
    box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
}

.search-download-btn:hover {
    background: #218838;
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.no-results {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.no-results-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.no-results-title {
    font-size: 20px;
    font-weight: 600;
    margin: 0 0 8px 0;
}

.no-results-text {
    font-size: 16px;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .search-results-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        padding: 0 15px 15px 15px;
    }
    
    .search-title {
        padding: 15px 15px 0 15px;
        font-size: 20px;
    }
    
    .search-thumbnail {
        height: 140px;
    }
}

@media (max-width: 480px) {
    .search-results-grid {
        grid-template-columns: 1fr;
    }
    
    .search-thumbnail {
        height: 180px;
    }
}
</style>

<div class="search-container">';

    if (!empty($searchResult) && is_array($searchResult)) {
        $html .= '<h2 class="search-title">Search results for "' . htmlspecialchars($keyword) . '"</h2>';
        $html .= '<div class="search-results-grid">';
        
        foreach ($searchResult as $video) {
            // Extract data based on the actual format
            $videoId = extractStringValue($video, 'videoId', '');
            $videoUrl = extractStringValue($video, 'url', '');
            if (empty($videoUrl) && !empty($videoId)) {
                $videoUrl = "https://www.youtube.com/watch?v=" . $videoId;
            }
            
            $title = extractStringValue($video, 'title', 'Unknown Title');
            
            // Get thumbnail from array (use second thumbnail if available, fallback to first)
            $thumbnail = '';
            if (isset($video['thumbnail']) && is_array($video['thumbnail'])) {
                if (isset($video['thumbnail'][1]['url'])) {
                    $thumbnail = $video['thumbnail'][1]['url']; // Second thumbnail (720p)
                } elseif (isset($video['thumbnail'][0]['url'])) {
                    $thumbnail = $video['thumbnail'][0]['url']; // First thumbnail fallback
                }
            }
            
            $duration = extractStringValue($video, 'duration', '');
            // Try different possible author field names
            $author = extractStringValue($video, 'channelName', '');
            if (empty($author)) {
                $author = extractStringValue($video, 'author', '');
            }
            
            // Create fallback thumbnail using YouTube's standard format
            if (empty($thumbnail) && !empty($videoId)) {
                $thumbnail = 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
            } elseif (empty($thumbnail)) {
                // If no video ID, use a generic placeholder
                $thumbnail = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjE2MCIgdmlld0JveD0iMCAwIDI4MCAxNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMTYwIiBmaWxsPSIjZjBmMGYwIi8+CjxjaXJjbGUgY3g9IjE0MCIgY3k9IjgwIiByPSIzMCIgZmlsbD0iI2ZmMDAwMCIvPjxwb2x5Z29uIHBvaW50cz0iMTMwLDY1IDEzMCw5NSAxNTUsODAiIGZpbGw9IndoaXRlIi8+PjwvY2lyY2xlPgo8dGV4dCB4PSIxNDAiIHk9IjEyMCIgZmlsbD0iIzY2NiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEyIj5Zb3VUdWJlIFZpZGVvPC90ZXh0Pgo8L3N2Zz4K';
            }
            
            $html .= '
            <div class="search-item">
                <div class="search-thumbnail">
                    <img src="' . htmlspecialchars($thumbnail) . '" alt="' . htmlspecialchars($title) . '" 
                         data-video-id="' . htmlspecialchars($videoId) . '"
                         onload="this.style.opacity=1" 
                         onerror="handleImageError(this, \'' . htmlspecialchars($videoId, ENT_QUOTES) . '\')"
                         style="opacity: 0; transition: opacity 0.3s ease;" />
                    ' . (!empty($duration) ? '<div class="video-duration-badge">' . htmlspecialchars($duration) . '</div>' : '') . '
                </div>
                <div class="search-content">
                    <h3 class="search-video-title">' . htmlspecialchars($title) . '</h3>
                    ' . (!empty($author) ? '<p class="search-video-author">' . htmlspecialchars($author) . '</p>' : '') . '
                    <button class="search-download-btn" 
                            onclick="selectVideo(\'' . htmlspecialchars($videoUrl, ENT_QUOTES) . '\')"
                            data-video-url="' . htmlspecialchars($videoUrl) . '">
                        Download
                    </button>
                </div>
            </div>';
        }
        
        $html .= '</div>';
    } else {
        $html .= '
        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <h3 class="no-results-title">No Results Found</h3>
            <p class="no-results-text">
                Sorry, we couldn\'t find any videos matching "' . htmlspecialchars($keyword) . '".<br>
                Try using different keywords or check your spelling.
            </p>
        </div>';
    }

    $html .= '</div>

<script>
// 图片错误处理函数
window.handleImageError = function(img, videoId) {
    const fallbacks = [
        "https://img.youtube.com/vi/" + videoId + "/mqdefault.jpg",
        "https://img.youtube.com/vi/" + videoId + "/sddefault.jpg", 
        "https://img.youtube.com/vi/" + videoId + "/maxresdefault.jpg",
        "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjgwIiBoZWlnaHQ9IjE2MCIgdmlld0JveD0iMCAwIDI4MCAxNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyODAiIGhlaWdodD0iMTYwIiBmaWxsPSIjZjBmMGYwIi8+CjxjaXJjbGUgY3g9IjE0MCIgY3k9IjgwIiByPSIzMCIgZmlsbD0iI2ZmMDAwMCIvPjxwb2x5Z29uIHBvaW50cz0iMTMwLDY1IDEzMCw5NSAxNTUsODAiIGZpbGw9IndoaXRlIi8+PC9jaXJjbGU+Cjx0ZXh0IHg9IjE0MCIgeT0iMTIwIiBmaWxsPSIjNjY2IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTIiPllvdVR1YmUgVmlkZW88L3RleHQ+Cjwvc3ZnPgo="
    ];
    
    let currentIndex = parseInt(img.dataset.fallbackIndex || "0");
    
    if (currentIndex < fallbacks.length) {
        img.dataset.fallbackIndex = currentIndex + 1;
        img.src = fallbacks[currentIndex];
        img.style.opacity = "1";
    } else {
        img.style.opacity = "1";
        img.style.backgroundColor = "#f0f0f0";
        img.style.display = "flex";
        img.style.alignItems = "center";
        img.style.justifyContent = "center";
        img.alt = "No Image Available";
    }
};

// 初始化搜索结果
(function() {
    function initSearchResults() {
        const images = document.querySelectorAll(".search-thumbnail img");
        images.forEach(function(img) {
            img.dataset.fallbackIndex = "0";
            
            setTimeout(function() {
                if (img.complete && img.naturalWidth === 0) {
                    window.handleImageError(img, img.dataset.videoId);
                }
            }, 1000);
        });
    }
    
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initSearchResults);
    } else {
        initSearchResults();
    }
    
    // 备用方案：直接绑定到所有异步下载按钮
    setTimeout(function() {
        var asyncBtns = document.querySelectorAll(".async-download-btn");
        console.log("找到异步下载按钮数量:", asyncBtns.length);
        
        asyncBtns.forEach(function(btn, index) {
            console.log("绑定按钮", index, btn);
            btn.addEventListener("click", function(e) {
                console.log("直接绑定的点击事件触发");
                e.preventDefault();
                
                var downloadUrl = btn.getAttribute("data-download-url");
                console.log("直接获取的下载URL:", downloadUrl);
                
                if (!downloadUrl) {
                    alert("下载链接不可用");
                    return;
                }
                
                // 简单测试：直接打开下载URL
                alert("测试：即将请求 " + downloadUrl);
                fetch(downloadUrl)
                    .then(function(response) {
                        console.log("获取响应:", response);
                        return response.json();
                    })
                    .then(function(data) {
                        console.log("解密数据:", data);
                        alert("成功获取数据: " + JSON.stringify(data));
                    })
                    .catch(function(error) {
                        console.error("错误:", error);
                        alert("错误: " + error.message);
                    });
            });
        });
    }, 1000);
})();
</script>';
    
    return $html;
}

/**
 * 生成HTML格式的错误信息
 */
function generateErrorHTML($message) {
    return '
<style>
.error-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    text-align: center;
}

.error-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.error-title {
    font-size: 20px;
    font-weight: 600;
    color: #dc3545;
    margin-bottom: 12px;
}

.error-message {
    font-size: 16px;
    color: #666;
    line-height: 1.5;
    margin-bottom: 20px;
}

.retry-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.retry-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
</style>

<div class="error-container">
    <div class="error-icon">❌</div>
    <div class="error-title">Download Failed</div>
    <div class="error-message">' . htmlspecialchars($message) . '</div>
    <button class="retry-btn" onclick="history.back()">Try Again</button>
</div>';
}
?>