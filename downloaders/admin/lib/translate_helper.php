<?php
/**
 * 翻译助手函数
 */

require_once __DIR__ . '/translate.php';

/**
 * 将多维数组扁平化为键值对
 * 例如: ["a" => ["b" => "c"]] 转换为 ["a.b" => "c"]
 */
function flattenArray($array, $prefix = '') {
    $result = [];
    
    foreach ($array as $key => $value) {
        $newKey = $prefix ? $prefix . '.' . $key : $key;
        
        if (is_array($value) && !isset($value[0])) { // 关联数组
            $result = array_merge($result, flattenArray($value, $newKey));
        } else {
            // 处理字符串值
            if (is_string($value)) {
                $result[$newKey] = $value;
            } elseif (is_array($value)) {
                // 索引数组，转换为字符串
                $result[$newKey] = json_encode($value);
            }
        }
    }
    
    return $result;
}

/**
 * 将扁平化的键值对还原为多维数组
 */
function unflattenArray($array) {
    $result = [];
    
    foreach ($array as $key => $value) {
        $keys = explode('.', $key);
        $temp = &$result;
        
        foreach ($keys as $k) {
            if (!isset($temp[$k])) {
                $temp[$k] = [];
            }
            $temp = &$temp[$k];
        }
        
        // 尝试解析JSON（处理数组值）
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $temp = $decoded;
        } else {
            $temp = $value;
        }
    }
    
    return $result;
}

/**
 * 分批翻译文本
 * @param array $texts 要翻译的文本数组
 * @param string $from 源语言
 * @param string $to 目标语言
 * @param int $maxChars 每批最大字符数（默认3900）
 * @return array 翻译后的文本数组
 */
function batchTranslate($texts, $from, $to, $maxChars = 1500) {
    $results = [];
    $batches = [];
    $currentBatch = [];
    $currentLength = 0;
    
    // 分组文本 - 使用更小的批次
    foreach ($texts as $key => $text) {
        $textLength = strlen($text);
        
        // 如果单个文本超过限制，需要特殊处理
        if ($textLength > $maxChars) {
            // 先处理当前批次
            if (!empty($currentBatch)) {
                $batches[] = $currentBatch;
                $currentBatch = [];
                $currentLength = 0;
            }
            
            // 单独处理超长文本
            $results[$key] = substr($text, 0, $maxChars - 100) . '...';
            continue;
        }
        
        // 检查是否会超过限制
        if ($currentLength + $textLength > $maxChars || count($currentBatch) >= 20) { // 限制每批最多20个项目
            // 保存当前批次
            $batches[] = $currentBatch;
            $currentBatch = [];
            $currentLength = 0;
        }
        
        $currentBatch[$key] = $text;
        $currentLength += $textLength;
    }
    
    // 添加最后一批
    if (!empty($currentBatch)) {
        $batches[] = $currentBatch;
    }
    
    echo "分为 " . count($batches) . " 个批次进行翻译...\n";
    
    // 翻译每个批次
    foreach ($batches as $batchIndex => $batch) {
        echo "处理批次 " . ($batchIndex + 1) . "/" . count($batches) . " (" . count($batch) . " 项)\n";
        
        $batchKeys = array_keys($batch);
        $batchTexts = array_values($batch);
        
        $maxRetries = 3;
        $translations = null;
        
        for ($retry = 0; $retry < $maxRetries; $retry++) {
            if ($retry > 0) {
                echo "  批次重试第 {$retry} 次...\n";
                sleep(3);
            }
            
            try {
                $translations = get_google_translation($to, $from, $batchTexts);
                
                if ($translations && is_array($translations) && count($translations) > 0) {
                    echo "  ✅ 批次翻译成功\n";
                    break;
                }
            } catch (Exception $e) {
                echo "  ❌ 批次翻译异常: " . $e->getMessage() . "\n";
            }
            
            if ($retry < $maxRetries - 1) {
                sleep(2);
            }
        }
        
        if ($translations && is_array($translations)) {
            // 将翻译结果对应回原始键
            foreach ($batchKeys as $index => $key) {
                if (isset($translations[$index])) {
                    $results[$key] = $translations[$index];
                } else {
                    $results[$key] = $batch[$key]; // 保留原文
                }
            }
        } else {
            echo "  ⚠️  批次失败，逐个翻译...\n";
            // 批次失败时降级为单个翻译
            foreach ($batch as $key => $text) {
                $translation = get_google_translation($to, $from, $text);
                if ($translation && is_array($translation) && !empty($translation[0])) {
                    $results[$key] = $translation[0];
                } else {
                    $results[$key] = $text; // 保留原文
                }
                sleep(1);
            }
        }
        
        // 批次间延迟
        if ($batchIndex < count($batches) - 1) {
            sleep(2);
        }
    }
    
    return $results;
}

/**
 * 翻译JSON内容
 * @param array $jsonArray JSON解析后的数组
 * @param string $from 源语言
 * @param string $to 目标语言
 * @return array 翻译后的数组
 */
function translateJsonContent($jsonArray, $from, $to) {
    // 1. 扁平化数组
    $flattened = flattenArray($jsonArray);
    
    // 2. 准备需要翻译的文本（排除特殊占位符）
    $textsToTranslate = [];
    $keysToTranslate = [];
    
    foreach ($flattened as $key => $value) {
        // 跳过包含占位符的文本（如 {site_name}）
        if (strpos($value, '{') !== false && strpos($value, '}') !== false) {
            // 暂时替换占位符
            $tempValue = preg_replace('/\{[^}]+\}/', '{@}', $value);
            $textsToTranslate[$key] = $tempValue;
        } else {
            $textsToTranslate[$key] = $value;
        }
        $keysToTranslate[] = $key;
    }
    
    // 3. 批量翻译
    $translatedTexts = batchTranslate($textsToTranslate, $from, $to);
    
    // 4. 构建翻译后的扁平数组
    $translatedFlat = [];
    foreach ($flattened as $key => $originalValue) {
        if (isset($translatedTexts[$key])) {
            $translatedValue = $translatedTexts[$key];
            
            // 恢复占位符
            if (strpos($originalValue, '{') !== false && strpos($originalValue, '}') !== false) {
                preg_match_all('/\{[^}]+\}/', $originalValue, $placeholders);
                if (!empty($placeholders[0])) {
                    $translatedValue = str_replace('{@}', $placeholders[0][0], $translatedValue);
                    
                    // 如果有多个占位符
                    for ($i = 1; $i < count($placeholders[0]); $i++) {
                        $translatedValue = preg_replace('/{@}/', $placeholders[0][$i], $translatedValue, 1);
                    }
                }
            }
            
            $translatedFlat[$key] = $translatedValue;
        } else {
            $translatedFlat[$key] = $originalValue;
        }
    }
    
    // 5. 还原为多维数组
    return unflattenArray($translatedFlat);
}

/**
 * 获取支持的语言列表 (包含38种语言)
 */
function getSupportedLanguages() {
    return [
        'en' => 'English',
        'zh' => '中文',
        'ja' => '日本語',
        'ko' => '한국어',
        'es' => 'Español',
        'fr' => 'Français',
        'de' => 'Deutsch',
        'it' => 'Italiano',
        'pt' => 'Português',
        'ru' => 'Русский',
        'ar' => 'العربية',
        'hi' => 'हिन्दी',
        'th' => 'ไทย',
        'vi' => 'Tiếng Việt',
        'id' => 'Bahasa Indonesia',
        'tr' => 'Türkçe',
        'pl' => 'Polski',
        'nl' => 'Nederlands',
        'sv' => 'Svenska',
        'da' => 'Dansk',
        'no' => 'Norsk',
        'fi' => 'Suomi',
        'cs' => 'Čeština',
        'hu' => 'Magyar',
        'ro' => 'Română',
        'bg' => 'Български',
        'hr' => 'Hrvatski',
        'sk' => 'Slovenčina',
        'sl' => 'Slovenščina',
        'et' => 'Eesti',
        'lv' => 'Latviešu',
        'lt' => 'Lietuvių',
        'uk' => 'Українська',
        'el' => 'Ελληνικά',
        'he' => 'עברית',
        'fa' => 'فارسی',
        'ur' => 'اردو',
        'bn' => 'বাংলা',
        'ta' => 'தமிழ்',
        'te' => 'తెలుగు'
    ];
}