<?php
/**
 * Google Gemini翻译库
 * 基于OpenRouter API，使用Gemini 2.0 Flash模型
 * 速度快，长度限制少，可一次性翻译完整JSON
 */

class GeminiTranslator {
    private static $api_key = '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';
    private static $api_url = 'https://openrouter.ai/api/v1/chat/completions';
    private static $model = 'google/gemini-2.0-flash-001';

    /**
     * 生成Gemini响应
     */
    public static function generate($prompt, $retry = 0) {
        $ch = curl_init();

        $messages = [
            [
                "role" => "user",
                "content" => $prompt
            ]
        ];

        $post_fields = [
            "model" => self::$model,
            "messages" => $messages,
        ];
        
        $requestBody = json_encode($post_fields);
        $logFile = defined('ADMIN_PATH') ? ADMIN_PATH . '/logs/translation.log' : 'translation.log';
        error_log(date('[Y-m-d H:i:s] ') . "Request body size: " . strlen($requestBody) . " bytes", 3, $logFile);

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . self::$api_key
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => self::$api_url,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $requestBody,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_VERBOSE => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ]);

        $logFile = defined('ADMIN_PATH') ? ADMIN_PATH . '/logs/translation.log' : 'translation.log';
        $startTime = microtime(true);
        error_log(date('[Y-m-d H:i:s] ') . "About to execute curl request to " . self::$api_url, 3, $logFile);
        
        $result = curl_exec($ch);
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000); // 毫秒
        
        $curl_error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        error_log(date('[Y-m-d H:i:s] ') . "Curl execution completed in {$duration}ms. HTTP code: {$http_code}", 3, $logFile);
        if ($curl_error) {
            error_log(date('[Y-m-d H:i:s] ') . "Curl error detected: {$curl_error}", 3, $logFile);
        }
        
        curl_close($ch);

        if ($curl_error || !$result) {
            $logFile = defined('ADMIN_PATH') ? ADMIN_PATH . '/logs/translation.log' : 'translation.log';
            $errorMsg = $curl_error ?: 'Empty response from API';
            error_log(date('[Y-m-d H:i:s] ') . "Curl error (retry {$retry}): {$errorMsg}", 3, $logFile);
            
            if ($retry < 3) {
                sleep(2);
                return self::generate($prompt, $retry + 1);
            }
            throw new Exception("Gemini API请求失败: " . $errorMsg);
        }

        $response = json_decode($result, true);
        if (!$response || empty($response['choices'][0]['message']['content'])) {
            $logFile = defined('ADMIN_PATH') ? ADMIN_PATH . '/logs/translation.log' : 'translation.log';
            error_log(date('[Y-m-d H:i:s] ') . "Invalid API response (retry {$retry}): " . substr($result, 0, 500), 3, $logFile);
            
            if ($retry < 3) {
                sleep(2);
                return self::generate($prompt, $retry + 1);
            }
            throw new Exception("Gemini API响应无效: " . substr($result, 0, 200));
        }

        return $response['choices'][0]['message']['content'];
    }

    /**
     * 解析Gemini响应中的JSON
     */
    public static function parseResponse($content) {
        // 尝试直接解析JSON
        $array = json_decode($content, true);
        if ($array) {
            return $array;
        }

        // 尝试提取markdown代码块中的JSON
        if (preg_match('/```json\s*(.*?)\s*```/s', $content, $matches)) {
            $array = json_decode($matches[1], true);
            if ($array) {
                return $array;
            }
        }

        // 尝试提取普通代码块中的JSON
        if (preg_match('/```\s*(.*?)\s*```/s', $content, $matches)) {
            $array = json_decode($matches[1], true);
            if ($array) {
                return $array;
            }
        }

        throw new Exception("无法解析Gemini响应中的JSON数据");
    }
}

/**
 * 使用Gemini翻译文本
 * @param string $text 要翻译的文本
 * @param string $targetLang 目标语言
 * @param string $sourceLang 源语言（默认English）
 * @return string|false 翻译后的文本，失败返回false
 */
function translateWithGemini($text, $targetLang, $sourceLang = 'English') {
    try {
        $targetLangName = getLanguageName($targetLang);
        
        $prompt = "Translate the following text from {$sourceLang} to {$targetLangName}. Only return the translation, nothing else.\n\nText: {$text}";
        
        $response = GeminiTranslator::generate($prompt);
        return trim($response);
    } catch (Exception $e) {
        error_log("Gemini翻译错误: " . $e->getMessage());
        return false;
    }
}

/**
 * 一次性翻译整个JSON使用Gemini
 * @param array $jsonContent 要翻译的JSON内容
 * @param string $targetLang 目标语言
 * @param string $sourceLang 源语言
 * @return array|false 翻译结果
 */
function translateJsonWithGemini($jsonContent, $targetLang, $sourceLang = 'English') {
    $logFile = defined('ADMIN_PATH') ? ADMIN_PATH . '/logs/translation.log' : 'translation.log';
    
    try {
        error_log(date('[Y-m-d H:i:s] ') . "translateJsonWithGemini called for {$sourceLang} -> {$targetLang}", 3, $logFile);
        
        $targetLangName = getLanguageName($targetLang);
        error_log(date('[Y-m-d H:i:s] ') . "Target language name: {$targetLangName}", 3, $logFile);
        
        $jsonString = json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        error_log(date('[Y-m-d H:i:s] ') . "JSON string length: " . strlen($jsonString) . " bytes", 3, $logFile);
        
        $prompt = "你现在是一名资深的多语言网站本地化与SEO语言审校专家，要求:语义准确性、语法句法本地化(比如 根据文本免费生成AI图像 应该用 AI文生图 更贴切)、自然表达、SEO友好性,符合当地的搜索习惯,不能有机器翻译痕迹、语句要通顺，易于搜索引擎理解（自然+语义相关性高）. 现在把原语言翻译到 {$targetLangName}, 保持JSON结构完全不变，只翻译文本内容。直接返回json格式，不要思考过程，不要添加```json```标记。\n\n原json:\n{$jsonString}";
        
        error_log(date('[Y-m-d H:i:s] ') . "Calling GeminiTranslator::generate", 3, $logFile);
        $response = GeminiTranslator::generate($prompt);
        
        error_log(date('[Y-m-d H:i:s] ') . "GeminiTranslator::generate returned, response length: " . strlen($response), 3, $logFile);
        
        $translatedJson = GeminiTranslator::parseResponse($response);
        error_log(date('[Y-m-d H:i:s] ') . "Translation parsing completed successfully", 3, $logFile);
        
        return $translatedJson;
    } catch (Exception $e) {
        error_log(date('[Y-m-d H:i:s] ') . "Gemini JSON翻译错误: " . $e->getMessage(), 3, $logFile);
        error_log(date('[Y-m-d H:i:s] ') . "Stack trace: " . $e->getTraceAsString(), 3, $logFile);
        return false;
    }
}

/**
 * 批量翻译使用Gemini（实际上使用一次性JSON翻译，因为Gemini处理能力强）
 * @param array $texts 要翻译的文本数组
 * @param string $targetLang 目标语言
 * @param string $sourceLang 源语言
 * @return array 翻译结果
 */
function batchTranslateWithGemini($texts, $targetLang, $sourceLang = 'English') {
    try {
        // Gemini可以处理大量文本，直接使用JSON翻译
        $translated = translateJsonWithGemini($texts, $targetLang, $sourceLang);
        
        if ($translated && is_array($translated)) {
            return $translated;
        }
        
        // 如果失败，返回原文本
        return $texts;
    } catch (Exception $e) {
        error_log("Gemini批量翻译错误: " . $e->getMessage());
        return $texts;
    }
}

/**
 * 翻译 Common 内容（使用Gemini）
 * @param array $sourceContent 源内容
 * @param string $sourceLang 源语言
 * @param string $targetLang 目标语言
 * @param string $i18nDir i18n目录路径
 * @return array 翻译结果
 */
function translateCommonContentWithGemini($sourceContent, $sourceLang, $targetLang, $i18nDir) {
    try {
        $sourceLangName = getLanguageName($sourceLang);
        $targetLangName = getLanguageName($targetLang);
        
        // 使用Gemini进行整体JSON翻译
        $translated = translateJsonWithGemini($sourceContent, $targetLang, $sourceLangName);
        
        if ($translated) {
            $targetFile = $i18nDir . '/' . $targetLang . '.json';
            $formatted = json_encode($translated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
            if (file_put_contents($targetFile, $formatted)) {
                return ['success' => true, 'message' => 'Gemini翻译完成'];
            } else {
                return ['success' => false, 'message' => '保存翻译文件失败'];
            }
        } else {
            return ['success' => false, 'message' => 'Gemini翻译API失败'];
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => '错误: ' . $e->getMessage()];
    }
}

/**
 * 获取语言名称
 */
function getLanguageName($code) {
    $languages = [
        'zh' => 'Chinese',
        'ja' => 'Japanese',
        'ko' => 'Korean',
        'es' => 'Spanish',
        'fr' => 'French',
        'de' => 'German',
        'it' => 'Italian',
        'pt' => 'Portuguese',
        'ru' => 'Russian',
        'ar' => 'Arabic',
        'hi' => 'Hindi',
        'th' => 'Thai',
        'vi' => 'Vietnamese',
        'id' => 'Indonesian',
        'tr' => 'Turkish',
        'pl' => 'Polish',
        'nl' => 'Dutch',
        'sv' => 'Swedish',
        'da' => 'Danish',
        'no' => 'Norwegian',
        'fi' => 'Finnish',
        'cs' => 'Czech',
        'hu' => 'Hungarian',
        'ro' => 'Romanian',
        'bg' => 'Bulgarian',
        'hr' => 'Croatian',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'et' => 'Estonian',
        'lv' => 'Latvian',
        'lt' => 'Lithuanian',
        'uk' => 'Ukrainian',
        'el' => 'Greek',
        'he' => 'Hebrew',
        'fa' => 'Persian',
        'ur' => 'Urdu',
        'bn' => 'Bengali',
        'ta' => 'Tamil',
        'te' => 'Telugu'
    ];
    
    return $languages[$code] ?? $code;
}