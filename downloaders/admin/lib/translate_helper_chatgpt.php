<?php
/**
 * ChatGPT翻译助手函数
 */

require_once __DIR__ . '/translate_chatgpt.php';

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
 * 使用ChatGPT翻译JSON内容
 * @param array $jsonArray JSON解析后的数组
 * @param string $from 源语言
 * @param string $to 目标语言
 * @return array 翻译后的数组
 */
function translateJsonContentWithChatGPT($jsonArray, $from, $to) {
    // 1. 扁平化数组
    $flattened = flattenArray($jsonArray);
    
    // 2. 准备需要翻译的文本
    $textsToTranslate = [];
    $keysToTranslate = [];
    
    foreach ($flattened as $key => $value) {
        // 跳过空值
        if (empty($value)) {
            continue;
        }
        
        // 直接使用原值，ChatGPT可以识别占位符
        $textsToTranslate[$key] = $value;
        $keysToTranslate[] = $key;
    }
    
    // 3. 批量翻译
    echo "准备翻译 " . count($textsToTranslate) . " 个文本项目\n";
    $translatedTexts = batchTranslateWithChatGPT($textsToTranslate, $to, 'English');
    
    // 4. 构建翻译后的扁平数组
    $translatedFlat = [];
    foreach ($flattened as $key => $originalValue) {
        if (isset($translatedTexts[$key])) {
            // 直接使用翻译结果，无需处理占位符
            $translatedFlat[$key] = $translatedTexts[$key];
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