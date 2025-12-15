<?php
class Http
{
    public $url;
    public $method;
    public static $proxy = null;
    public $cookieFile;
    public $referer = '';
    public $httpCode;
    public $enableCookieFile = true;
    public $enableCookieJar = true;
    public static $enableProxy = false;
    public static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
    private $headers = [];
    private $curlOptions = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    ];
    private $curl = null;
    private static $chunkSize = 1000000;
    public $response = null;

    public function __construct($url, $method = null, $proxy = null, $cookieFile = null)
    {
        $this->url = $url;
        $this->method = $method;
        self::$proxy = $proxy;
        $this->cookieFile = $cookieFile;
        $this->headers['User-Agent'] = self::$userAgent;
        $this->curl = curl_init();
    }

    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    public function deleteHeader($name)
    {
        unset($this->headers[$name]);
    }

    public function addCurlOption($name, $value)
    {
        $this->curlOptions[$name] = $value;
    }

    private function setCurlOptions()
    {
        $this->curlOptions[CURLOPT_URL] = $this->url;
        $this->curlOptions[CURLOPT_USERAGENT] = $this->headers['User-Agent'];
        $this->curlOptions[CURLOPT_REFERER] = $this->referer;
        $headers = [];
        foreach ($this->headers as $key => $value) {
            $headers[] = $key . ':' . $value;
        }
        $this->curlOptions[CURLOPT_HTTPHEADER] = $headers;
        if ($this->cookieFile != null) {
            if ($this->enableCookieFile) {
                $this->curlOptions[CURLOPT_COOKIEFILE] = $this->cookieFile;
            }
            if ($this->enableCookieJar) {
                $this->curlOptions[CURLOPT_COOKIEJAR] = $this->cookieFile;
            }
        }
        if (self::$enableProxy && self::$proxy != null) {
            curl_setopt($this->curl, CURLOPT_PROXY, self::$proxy['ip'] . ':' . self::$proxy['port']);
            curl_setopt($this->curl, CURLOPT_PROXYTYPE, self::$proxy['type']);
            if (!empty(self::$proxy['username']) && !empty(self::$proxy['password'])) {
                curl_setopt($this->curl, CURLOPT_PROXYUSERPWD, self::$proxy['username'] . ':' . self::$proxy['password']);
            }
            curl_setopt($this->curl, CURLOPT_TIMEOUT, (int)ceil(3 * (round(self::$chunkSize / 1048576, 2) / (1 / 8))));
        }
        curl_setopt_array($this->curl, $this->curlOptions);
    }

    private function execCurl()
    {
        $this->setCurlOptions();
        $this->response = curl_exec($this->curl);
        $this->httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    public function run()
    {
        $this->execCurl();
        curl_close($this->curl);
    }

    public function getLongUrl($maxRedirects = 3)
    {
        $this->curlOptions[CURLOPT_MAXREDIRS] = $maxRedirects;
        $this->execCurl();
        $longUrl = curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL);
        curl_close($this->curl);
        return $longUrl;
    }

    public function getFileSize()
    {
        $this->curlOptions[CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
        $this->curlOptions[CURLOPT_NOBODY] = true;
        $this->setCurlOptions();
        curl_exec($this->curl);
        //$this->httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $size = -1;
        if (curl_errno($this->curl) == 0) {
            $size = curl_getinfo($this->curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        }
        curl_close($this->curl);
        return $size;
    }

    public static function forceDownload($url, $name, $extension, $size, $referer = '')
    {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        //header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . htmlspecialchars_decode(Helpers::sanitizeFilename($name, $extension)) . '"');
        header("Content-Transfer-Encoding: binary");
        header("Accept-Ranges: bytes");
        header("Content-Ranges: bytes");
        if ($size > 100) {
            header('Content-Length: ' . $size);
        } else {
            $http = new Http($url);
            $size = $http->getFileSize();
            if ($size > 100) {
                header('Content-Length: ' . $size);
            }
        }
        header('Connection: Close');
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);
        if (ob_get_length() > 0) {
            ob_clean();
        }
        flush();
        // Activate flush
        if (function_exists('apache_setenv')) {
            apache_setenv('no-gzip', 1);
        }
        @ini_set('zlib.output_compression', false);
        ini_set('implicit_flush', true);
        // CURL Process
        $ch = curl_init();
        $chunkEnd = $chunkSize = 1000000;  // 1 MB in bytes
        $tries = $count = $chunkStart = 0;
        while ($size > $chunkStart) {
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, self::$userAgent);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_REFERER, $referer);
            curl_setopt($ch, CURLOPT_RANGE, $chunkStart . '-' . $chunkEnd);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BUFFERSIZE, $chunkSize);
            //curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE, "100");
            $output = curl_exec($ch);
            $curlInfo = curl_getinfo($ch);
            if ($curlInfo['http_code'] != "206" && $curlInfo['http_code'] != '403' && $tries < 10) {
                $tries++;
                continue;
            } else {
                if ($tries === 0 && $curlInfo['http_code'] == '403') {
                    Http::forceDownloadLegacy($url, $name, $extension, $size);
                    exit;
                }
                $tries = 0;
                echo $output;
                flush();
                ob_implicit_flush(true);
                if (ob_get_length() > 0) ob_end_flush();
            }
            $chunkStart += self::$chunkSize;
            $chunkStart += ($count == 0) ? 1 : 0;
            $chunkEnd += self::$chunkSize;
            $count++;
            //sleep(10);
        }
        curl_close($ch);
        exit;
    }

    public static function forceDownloadLegacy($url, $name, $extension, $size, $contentLength = true)
    {
        $context_options = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            )
        );
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . Helpers::sanitizeFilename($name, $extension) . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: public');
        if ($contentLength) {
            if ($size > 100) {
                header('Content-Length: ' . $size);
            } else {
                $http = new Http($url);
                $size = $http->getFileSize();
                if ($size > 100) {
                    header('Content-Length: ' . $size);
                }
            }
        } else if ($contentLength === -1) {
            header('Content-Length: ' . filesize($url));
        }
        if (isset($_SERVER['HTTP_REQUEST_USER_AGENT']) && strpos($_SERVER['HTTP_REQUEST_USER_AGENT'], 'MSIE') !== FALSE) {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        }
        header('Connection: Close');
        ob_clean();
        flush();
        readfile($url, "", stream_context_create($context_options));
        exit;
    }

    public static function forceDownloadChunks($urls, $name, $extension)
    {
        $context_options = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            )
        );
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . Helpers::sanitizeFilename($name, $extension) . '"');
        header("Content-Transfer-Encoding: binary");
        header('Expires: 0');
        header('Pragma: public');
        if (isset($_SERVER['HTTP_REQUEST_USER_AGENT']) && strpos($_SERVER['HTTP_REQUEST_USER_AGENT'], 'MSIE') !== FALSE) {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        }
        header('Connection: Close');
        ob_clean();
        flush();
        foreach ($urls as $url) {
            readfile($url, "", stream_context_create($context_options));
        }
        exit;
    }

    public static function verifyCaptcha($response, $clientIp)
    {
        $privateKey = get_option('aiodl_recaptcha_private_api_key');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "secret=$privateKey&response=$response&remoteip=$clientIp",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return false;
        } else {
            $response = json_decode($response, true);
            if ($response['success'] === true) {
                return true;
            } else {
                return false;
            }
        }
    }
}


class Media
{
    public $url = null;
    public $quality = null;
    public $extension = null;
    public $size = null;
    public $formattedSize = null;
    public $videoAvailable = null;
    public $audioAvailable = null;
    public $chunked = false;
    public $cached = false;

    /**
     * Media constructor.
     * @param $url
     * @param $quality
     * @param $extension
     * @param $videoAvailable
     * @param $audioAvailable
     */
    public function __construct($url, $quality, $extension, $videoAvailable, $audioAvailable)
    {
        $this->url = $url;
        $this->quality = $quality;
        $this->extension = $extension;
        $this->videoAvailable = $videoAvailable;
        $this->audioAvailable = $audioAvailable;
    }

    public function getMediaInfo()
    {
        if ($this->size == null) {
            $http = new Http($this->url);
            $this->size = $http->getFileSize();
        }
        $this->formattedSize = Helpers::formatSize($this->size);
    }
}

// 从TikTok URL提取视频ID
function extractVideoId($url) {
    // 匹配各种TikTok URL格式
    $patterns = [
        '/tiktok\.com\/@[\w.-]+\/video\/(\d+)/',
        '/tiktok\.com\/v\/(\d+)/',
        '/tiktok\.com\/video\/(\d+)/',
        '/vm\.tiktok\.com\/(\w+)/',
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
    }
    
    return false;
}

// 备用接口函数 1
function fetchBackupAPI($videoUrl)
{
    // 备用接口 1: http://23.239.5.68:3001
    $apiUrl = 'http://23.239.5.68:3001/tiktok?url=' . urlencode($videoUrl);
    
    $http = new Http($apiUrl);
    $http->addCurlOption(CURLOPT_TIMEOUT, 30); // 30秒超时
    $http->run();
    
    if ($http->httpCode == 200) {
        $response = json_decode($http->response, true);
        
        if ($response && $response['status'] === 'success' && !empty($response['result'])) {
            $data = $response['result'];
            $result = [];
            
            // 基本信息
            $result['title'] = $data['desc'] ?? 'TikTok Video';
            $result['source'] = 'tiktok';
            $result['thumbnail'] = $data['video']['cover'][0] ?? '';
            
            // 无水印视频 (HD)
            if (!empty($data['video']['playAddr'][0])) {
                $result['medias'][] = new Media($data['video']['playAddr'][0], 'hd', 'mp4', true, true);
            }
            
            // 有水印视频
            if (!empty($data['video']['downloadAddr'][0])) {
                $result['medias'][] = new Media($data['video']['downloadAddr'][0], 'watermark', 'mp4', true, true);
            }
            
            // 音频 (MP3)
            if (!empty($data['music']['playUrl'][0])) {
                $result['medias'][] = new Media($data['music']['playUrl'][0], '128kbps', 'mp3', false, true);
            }
            
            // 额外信息
            if (!empty($data['author'])) {
                $result['author'] = $data['author']['nickname'] ?? '';
                $result['author_avatar'] = $data['author']['avatarThumb'][0] ?? '';
            }
            
            if (!empty($data['statistics'])) {
                $result['stats'] = [
                    'views' => $data['statistics']['playCount'] ?? 0,
                    'likes' => $data['statistics']['likeCount'] ?? 0,
                    'comments' => $data['statistics']['commentCount'] ?? 0,
                    'shares' => $data['statistics']['shareCount'] ?? 0
                ];
            }
            
            if (!empty($data['video']['duration'])) {
                $result['duration'] = round($data['video']['duration'] / 1000); // 转换为秒
            }
            
            return $result;
        }
    }
    
    return false;
}

// 备用接口函数 2 - 使用embed页面
function fetchBackupAPI2($videoUrl)
{
    // 提取视频ID
    $videoId = extractVideoId($videoUrl);
    if (!$videoId) {
        return false;
    }
    
    // 构建embed URL
    $embedUrl = "https://www.tiktok.com/embed/{$videoId}";
    
    $http = new Http($embedUrl);
    $http->addHeader('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8');
    $http->addHeader('Accept-Language', 'en-US,en;q=0.5');
    $http->addCurlOption(CURLOPT_TIMEOUT, 30);
    $http->run();
    
    if ($http->httpCode == 200) {
        $html = $http->response;
        $result = [];
        
        // 提取视频URL从video标签
        if (preg_match('/<video[^>]+src="([^"]+)"[^>]*>/i', $html, $videoMatch)) {
            $videoUrl = html_entity_decode($videoMatch[1]);
            $result['medias'][] = new Media($videoUrl, 'watermark', 'mp4', true, true);
        }
        
        // 提取JSON数据
        if (preg_match('/<script[^>]+id="__FRONTITY_CONNECT_STATE__"[^>]*>([^<]+)<\/script>/i', $html, $jsonMatch)) {
            $jsonData = json_decode($jsonMatch[1], true);
            
            if ($jsonData && isset($jsonData['source']['data'])) {
                $routeKey = array_keys($jsonData['source']['data'])[0] ?? '';
                $videoData = $jsonData['source']['data'][$routeKey]['videoData'] ?? [];
                
                // 基本信息
                if (!empty($videoData['itemInfos'])) {
                    $itemInfo = $videoData['itemInfos'];
                    $result['title'] = $itemInfo['text'] ?? 'TikTok Video';
                    $result['source'] = 'tiktok';
                    $result['thumbnail'] = $itemInfo['covers'][0] ?? '';
                    
                    // 统计信息
                    $result['stats'] = [
                        'views' => $itemInfo['playCount'] ?? 0,
                        'likes' => $itemInfo['diggCount'] ?? 0,
                        'comments' => $itemInfo['commentCount'] ?? 0,
                        'shares' => $itemInfo['shareCount'] ?? 0
                    ];
                    
                    // 视频时长
                    if (!empty($itemInfo['video']['videoMeta']['duration'])) {
                        $result['duration'] = $itemInfo['video']['videoMeta']['duration'];
                    }
                }
                
                // 音乐信息
                if (!empty($videoData['musicInfos'])) {
                    $musicInfo = $videoData['musicInfos'];
                    if (!empty($musicInfo['playUrl'][0])) {
                        $result['medias'][] = new Media($musicInfo['playUrl'][0], '128kbps', 'mp3', false, true);
                    }
                    
                    // 音乐标题
                    if (!empty($musicInfo['musicName'])) {
                        $result['music_title'] = $musicInfo['musicName'];
                        $result['music_author'] = $musicInfo['authorName'] ?? '';
                    }
                }
                
                // 作者信息
                if (!empty($videoData['authorInfos'])) {
                    $authorInfo = $videoData['authorInfos'];
                    $result['author'] = $authorInfo['nickName'] ?? '';
                    $result['author_avatar'] = $authorInfo['covers'][0] ?? '';
                    $result['author_id'] = $authorInfo['uniqueId'] ?? '';
                    $result['author_verified'] = $authorInfo['verified'] ?? false;
                }
            }
        }
        
        // 如果成功提取到至少一个媒体文件，返回结果
        if (!empty($result['medias'])) {
            return $result;
        }
    }
    
    return false;
}

function fetch($videoUrl)
{
    // 首先尝试使用原有接口
    $http = new Http('https://www.tikwm.com/api/?url=' . $videoUrl);
    $http->run();
    $data = json_decode($http->response, true)['data'] ?? null;
    $result = [];
    
    if (!empty($data['wmplay'])) {
        $result['title'] = $data['title'] ?? 'Tiktok Video';
        $result['source'] = 'tiktok';
        $result['thumbnail'] = $data['cover'];
        $result['medias'][] = new Media($data['wmplay'], 'watermark', 'mp4', true, true);
        if (!empty($data['play'])) {
            $media = new Media($data['play'], 'hd', 'mp4', true, true);
            $result['medias'][] = $media;
        }
        if (!empty($data['music'])) {
            $result['medias'][] = new Media($data['music'], '128kbps', 'mp3', false, true);
        }
       return $result;
    }
    
    // 如果原接口失败，尝试使用备用接口1
    $backupResult = fetchBackupAPI($videoUrl);
    if ($backupResult !== false) {
        return $backupResult;
    }
    
    // 如果备用接口1也失败，尝试使用备用接口2（embed方式）
    $backupResult2 = fetchBackupAPI2($videoUrl);
    if ($backupResult2 !== false) {
        return $backupResult2;
    }
    
    // 如果都失败，返回空结果
    return $result;
}