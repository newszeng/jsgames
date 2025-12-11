<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

class TikTokAPI {
    private $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
    private $debug = false;
    
    public function __construct() {
        // Enable debug mode if requested
        $this->debug = isset($_GET['debug']) && $_GET['debug'] === '1';
        
        if (!isset($_GET['url'])) {
            $this->sendError('Missing URL parameter');
        }
        
        $url = $_GET['url'];
        $this->processRequest($url);
    }
    
    private function processRequest($url) {
        if (!$this->isValidTikTokUrl($url)) {
            $this->sendError('Invalid TikTok URL');
        }
        
        // Get the actual video URL if it's a short link
        $fullUrl = $this->resolveUrl($url);
        $this->debugLog("Resolved URL: " . $fullUrl);
        
        // Extract video ID
        $videoId = $this->extractVideoId($fullUrl);
        if (!$videoId) {
            $this->sendError('Could not extract video ID');
        }
        $this->debugLog("Video ID: " . $videoId);
        
        // Get video data from TikTok's web interface
        $data = $this->fetchVideoData($fullUrl);
        
        if (!$data) {
            $this->sendError('Failed to fetch video data');
        }
        
        echo json_encode($data);
    }
    
    private function isValidTikTokUrl($url) {
        $patterns = [
            '/tiktok\.com/',
            '/vm\.tiktok\.com/',
            '/vt\.tiktok\.com/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }
        
        return false;
    }
    
    private function resolveUrl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: ' . $this->userAgent
        ]);
        
        curl_exec($ch);
        $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        
        return $finalUrl ?: $url;
    }
    
    private function extractVideoId($url) {
        // Pattern for video URLs: /video/1234567890
        if (preg_match('/\/video\/(\d+)/', $url, $matches)) {
            return $matches[1];
        }
        
        return null;
    }
    
    private function fetchVideoData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_ENCODING, ''); // Auto-detect encoding
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: ' . $this->userAgent,
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: none'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200 || !$response) {
            $this->debugLog("HTTP Error: " . $httpCode);
            return null;
        }
        
        $this->debugLog("HTML Length: " . strlen($response));
        
        return $this->parseHtmlResponse($response);
    }
    
    private function parseHtmlResponse($html) {
        $result = [
            'status' => 'success',
            'data' => [
                'id' => '',
                'title' => '',
                'cover' => '',
                'play' => '',
                'wmplay' => '',
                'music' => '',
                'duration' => 0,
                'author' => [
                    'unique_id' => '',
                    'nickname' => '',
                    'avatar' => ''
                ],
                'statistics' => [
                    'play_count' => 0,
                    'like_count' => 0,
                    'comment_count' => 0,
                    'share_count' => 0
                ]
            ]
        ];
        
        // Method 1: Try to extract from SIGI_STATE
        if (preg_match('/<script id="SIGI_STATE" type="application\/json">(.*?)<\/script>/s', $html, $matches)) {
            $jsonData = json_decode($matches[1], true);
            $this->debugLog("Found SIGI_STATE data");
            
            if ($jsonData && isset($jsonData['ItemModule'])) {
                foreach ($jsonData['ItemModule'] as $itemId => $item) {
                    if (isset($item['video'])) {
                        $result['data'] = $this->extractFromSigiState($item);
                        return $result;
                    }
                }
            }
        }
        
        // Method 2: Try to extract from __UNIVERSAL_DATA_FOR_REHYDRATION__
        if (preg_match('/<script id="__UNIVERSAL_DATA_FOR_REHYDRATION__" type="application\/json">(.*?)<\/script>/s', $html, $matches)) {
            $jsonData = json_decode($matches[1], true);
            $this->debugLog("Found UNIVERSAL_DATA data");
            
            if ($jsonData && isset($jsonData['__DEFAULT_SCOPE__']['webapp.video-detail']['itemInfo']['itemStruct'])) {
                $item = $jsonData['__DEFAULT_SCOPE__']['webapp.video-detail']['itemInfo']['itemStruct'];
                $result['data'] = $this->extractFromUniversalData($item);
                return $result;
            }
        }
        
        // Method 3: Try to extract from window.__INITIAL_STATE__
        if (preg_match('/window\.__INITIAL_STATE__\s*=\s*({.*?});/', $html, $matches)) {
            $jsonData = json_decode($matches[1], true);
            $this->debugLog("Found INITIAL_STATE data");
            
            if ($jsonData && isset($jsonData['ItemModule'])) {
                foreach ($jsonData['ItemModule'] as $itemId => $item) {
                    if (isset($item['video'])) {
                        $result['data'] = $this->extractFromSigiState($item);
                        return $result;
                    }
                }
            }
        }
        
        $this->debugLog("No JSON data found in HTML");
        return null;
    }
    
    private function extractFromSigiState($item) {
        $data = [
            'id' => $item['id'] ?? '',
            'title' => $item['desc'] ?? '',
            'cover' => $item['video']['cover'] ?? '',
            'play' => $item['video']['playAddr'] ?? '',
            'wmplay' => $item['video']['downloadAddr'] ?? '',
            'music' => $item['music']['playUrl'] ?? '',
            'duration' => $item['video']['duration'] ?? 0,
            'author' => [
                'unique_id' => $item['author']['uniqueId'] ?? '',
                'nickname' => $item['author']['nickname'] ?? '',
                'avatar' => $item['author']['avatarLarger'] ?? ''
            ],
            'statistics' => [
                'play_count' => $item['stats']['playCount'] ?? 0,
                'like_count' => $item['stats']['diggCount'] ?? 0,
                'comment_count' => $item['stats']['commentCount'] ?? 0,
                'share_count' => $item['stats']['shareCount'] ?? 0
            ]
        ];
        
        // Handle image slideshows
        if (isset($item['imagePost']['images']) && is_array($item['imagePost']['images'])) {
            $images = [];
            foreach ($item['imagePost']['images'] as $img) {
                if (isset($img['imageURL']['urlList'][0])) {
                    $images[] = $img['imageURL']['urlList'][0];
                }
            }
            if (!empty($images)) {
                $data['images'] = $images;
            }
        }
        
        return $data;
    }
    
    private function extractFromUniversalData($item) {
        $data = [
            'id' => $item['id'] ?? '',
            'title' => $item['desc'] ?? '',
            'cover' => $item['video']['cover'] ?? '',
            'play' => $item['video']['playAddr'] ?? '',
            'wmplay' => $item['video']['downloadAddr'] ?? '',
            'music' => $item['music']['playUrl'] ?? '',
            'duration' => $item['video']['duration'] ?? 0,
            'author' => [
                'unique_id' => $item['author']['uniqueId'] ?? '',
                'nickname' => $item['author']['nickname'] ?? '',
                'avatar' => $item['author']['avatarLarger'] ?? ''
            ],
            'statistics' => [
                'play_count' => $item['stats']['playCount'] ?? 0,
                'like_count' => $item['stats']['diggCount'] ?? 0,
                'comment_count' => $item['stats']['commentCount'] ?? 0,
                'share_count' => $item['stats']['shareCount'] ?? 0
            ]
        ];
        
        // Handle image slideshows
        if (isset($item['imagePost']['images']) && is_array($item['imagePost']['images'])) {
            $images = [];
            foreach ($item['imagePost']['images'] as $img) {
                if (isset($img['imageURL']['urlList'][0])) {
                    $images[] = $img['imageURL']['urlList'][0];
                }
            }
            if (!empty($images)) {
                $data['images'] = $images;
            }
        }
        
        return $data;
    }
    
    private function debugLog($message) {
        if ($this->debug) {
            error_log("TikTok Debug: " . $message);
        }
    }
    
    private function sendError($message) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ]);
        exit;
    }
}

// Initialize the API
new TikTokAPI();