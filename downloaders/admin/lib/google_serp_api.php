<?php
require_once __DIR__ . '/config.php';

function googleSearch($keywords, $lang, $nums = 20) {
    global $config;
    
    if (empty($keywords)) {
        return json_encode(['error' => 'Keywords are required']);
    }
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $config['google_serper']['url'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => $config['google_serper']['timeout'],
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_SSL_VERIFYPEER => $config['development']['ssl_verify'],
        CURLOPT_SSL_VERIFYHOST => $config['development']['ssl_verify'] ? 2 : 0,
        CURLOPT_POSTFIELDS => json_encode([
            'q' => $keywords,
            'num' => (int)$nums,
            'hl' => $lang
        ]),
        CURLOPT_HTTPHEADER => array(
            'X-API-KEY: ' . $config['google_serper']['api_key'],
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);
    
    // Check for cURL errors
    if ($error) {
        return json_encode(['error' => 'Network error: ' . $error]);
    }
    
    // Check HTTP status
    if ($httpCode !== 200) {
        return json_encode(['error' => 'API error: HTTP ' . $httpCode . ' - ' . ($response ?: 'No response')]);
    }
    
    if ($response) {
        $arr = json_decode($response, true);
        
        // Check if JSON decode was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            return json_encode(['error' => 'Invalid JSON response: ' . json_last_error_msg()]);
        }
        
        // Check for API error in response
        if (isset($arr['error'])) {
            return json_encode(['error' => 'API error: ' . $arr['error']]);
        }
        
        $output = [
            'search_results' => $arr['organic'] ?? [],
            'related_questions' => [],
            'paa' => $arr['peopleAlsoAsk'] ?? [],
            'related_searches' => $arr['relatedSearches'] ?? [],
            'page_text' => '',
            'debug_info' => [
                'http_code' => $httpCode,
                'response_length' => strlen($response),
                'has_organic' => isset($arr['organic']),
                'organic_count' => count($arr['organic'] ?? [])
            ]
        ];

        return json_encode($output, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
    }
    
    return json_encode(['error' => 'Empty response from API']);
}

// 处理AJAX请求
if (isset($_GET['ajax_search']) && isset($_GET['keywords']) && isset($_GET['lang'])) {
    header('Content-Type: application/json');
    $keywords = $_GET['keywords'];
    $lang = $_GET['lang'];
    $nums = $_GET['nums'] ?? 20;
    
    echo googleSearch($keywords, $lang, $nums);
    exit();
}
?>