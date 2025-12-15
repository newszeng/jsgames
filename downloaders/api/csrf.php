<?php
/**
 * CSRF Token Generation API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 处理OPTIONS请求
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// 只允许GET请求
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
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

// 简化的浏览器验证 - 只检查User-Agent
function validateSimpleBrowserRequest() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return !empty($userAgent) && (
        preg_match('/(Chrome|Firefox|Safari|Edge|Opera|Mozilla)\/[0-9\.]+/', $userAgent) ||
        strpos($userAgent, 'Mozilla') !== false ||
        strlen($userAgent) > 10  // 基本的User-Agent长度检查
    );
}

try {
    // 基础浏览器检查
    if (!validateSimpleBrowserRequest()) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Access denied. Please use a web browser.'
        ]);
        exit;
    }
    
    $token = generateCSRFToken();
    echo json_encode([
        'success' => true,
        'csrf_token' => $token
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to generate CSRF token: ' . $e->getMessage()
    ]);
}
?>