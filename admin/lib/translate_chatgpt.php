<?php
/**
 * ChatGPT翻译库
 */

define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: 'your-openai-api-key-here');

/**
 * 使用ChatGPT翻译文本
 * @param string $text 要翻译的文本
 * @param string $targetLang 目标语言
 * @param string $sourceLang 源语言（默认英语）
 * @return string|false 翻译后的文本，失败返回false
 */
function translateWithChatGPT($text, $targetLang, $sourceLang = 'English') {
    $targetLangName = getLanguageName($targetLang);
    
    $systemPrompt = "You are a professional translator. Translate text from {$sourceLang} to {$targetLangName}. Only return the translation, nothing else.";
    
    $messages = [
        ['role' => 'system', 'content' => $systemPrompt],
        ['role' => 'user', 'content' => $text]
    ];
    
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => $messages,
        'temperature' => 0.3,
        'max_tokens' => 2000
    ];
    
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . OPENAI_API_KEY,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        echo "ChatGPT API错误 (HTTP {$httpCode}): {$response}\n";
        return false;
    }
    
    $result = json_decode($response, true);
    
    if (isset($result['choices'][0]['message']['content'])) {
        return trim($result['choices'][0]['message']['content']);
    }
    
    return false;
}

/**
 * 一次性翻译整个JSON使用ChatGPT
 * @param array $jsonContent 要翻译的JSON内容
 * @param string $targetLang 目标语言
 * @param string $sourceLang 源语言
 * @return array|false 翻译结果
 */
function translateJsonWithChatGPT($jsonContent, $targetLang, $sourceLang = 'English') {
    $targetLangName = getLanguageName($targetLang);
    
    $systemPrompt = "You are a professional translator. Translate the following JSON content from {$sourceLang} to {$targetLangName}. Keep the JSON structure exactly the same, only translate the text values. Preserve all placeholders like {site_name}. Return ONLY the translated JSON, nothing else.";
    
    $messages = [
        ['role' => 'system', 'content' => $systemPrompt],
        ['role' => 'user', 'content' => json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)]
    ];
    
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => $messages,
        'temperature' => 0.3,
        'max_tokens' => 4000
    ];
    
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . OPENAI_API_KEY,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        
        if (isset($result['choices'][0]['message']['content'])) {
            $translatedJson = json_decode($result['choices'][0]['message']['content'], true);
            
            if ($translatedJson) {
                return $translatedJson;
            } else {
                echo "❌ 无法解析翻译后的JSON\n";
                return false;
            }
        } else {
            echo "❌ API响应格式错误\n";
            return false;
        }
    } else {
        echo "❌ API错误 (HTTP {$httpCode}): {$response}\n";
        return false;
    }
}

/**
 * 批量翻译使用ChatGPT（改进的分批处理方式）
 * @param array $texts 要翻译的文本数组
 * @param string $targetLang 目标语言
 * @param string $sourceLang 源语言
 * @return array 翻译结果
 */
function batchTranslateWithChatGPT($texts, $targetLang, $sourceLang = 'English') {
    $results = [];
    $targetLangName = getLanguageName($targetLang);
    
    // 将文本分组，每组20个以提高效率
    $batches = array_chunk($texts, 20, true);
    
    echo "使用ChatGPT 3.5翻译，共 " . count($batches) . " 个批次\n";
    
    foreach ($batches as $batchIndex => $batch) {
        echo "处理批次 " . ($batchIndex + 1) . "/" . count($batches) . " (" . count($batch) . " 项)\n";
        
        // 构建键值对翻译请求
        $batchJson = [];
        foreach ($batch as $key => $text) {
            $batchJson[$key] = $text;
        }
        
        $systemPrompt = "You are a professional translator. You will receive a JSON object where keys are identifiers and values are text to translate. Translate from {$sourceLang} to {$targetLangName}.

CRITICAL RULES:
1. Keep ALL keys exactly as they are - NEVER translate keys
2. Only translate the string values
3. Preserve placeholders like {site_name}, {url}, etc.
4. Return ONLY valid JSON with the same key structure
5. If a value is empty or already in target language, keep it as is

Example input: {\"btn_download\": \"Download Video\", \"site_name\": \"{site_name} Downloader\"}
Example output: {\"btn_download\": \"Descargar Video\", \"site_name\": \"{site_name} Descargador\"}";
        
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => json_encode($batchJson, JSON_UNESCAPED_UNICODE)]
        ];
        
        $data = [
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
            'temperature' => 0.2,
            'max_tokens' => 3000
        ];
        
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . OPENAI_API_KEY,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $result = json_decode($response, true);
            
            if (isset($result['choices'][0]['message']['content'])) {
                $content = trim($result['choices'][0]['message']['content']);
                
                // 尝试解析JSON响应
                $translatedJson = json_decode($content, true);
                
                if ($translatedJson && is_array($translatedJson)) {
                    // 成功解析JSON，逐个检查结果
                    foreach ($batch as $key => $originalText) {
                        if (isset($translatedJson[$key])) {
                            $results[$key] = $translatedJson[$key];
                        } else {
                            $results[$key] = $originalText;
                        }
                    }
                } else {
                    echo "  ❌ JSON解析失败，保留原文\n";
                    foreach ($batch as $key => $text) {
                        $results[$key] = $text;
                    }
                }
            } else {
                echo "  ❌ API响应无内容\n";
                foreach ($batch as $key => $text) {
                    $results[$key] = $text;
                }
            }
        } else {
            echo "  ❌ API错误 (HTTP {$httpCode})\n";
            foreach ($batch as $key => $text) {
                $results[$key] = $text;
            }
        }
        
        // 避免速率限制
        if ($batchIndex < count($batches) - 1) {
            sleep(2);
        }
    }
    
    return $results;
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