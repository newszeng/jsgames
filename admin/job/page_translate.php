<?php
/**
 * 页面翻译脚本
 * 参数: site, page, lang
 * 如果lang是all，则翻译到所有38种语言
 */
require_once '../lib/translate_helper.php';

// 获取命令行参数
if ($argc < 4) {
    echo "使用方法: php page_translate.php <site> <page> <lang>\n";
    echo "示例: php page_translate.php ytdownloader.io homepage zh\n";
    echo "     php page_translate.php ytdownloader.io homepage all\n";
    exit(1);
}

$site = $argv[1];
$page = $argv[2];
$lang = $argv[3];

// 源文件路径
$source_file = "../../i18n/{$site}/en.json";

if (!file_exists($source_file)) {
    echo "错误：源文件不存在: {$source_file}\n";
    exit(1);
}

// 读取源文件
$source_content = file_get_contents($source_file);
$source_array = json_decode($source_content, true);

if (!$source_array) {
    echo "错误：源文件JSON格式无效\n";
    exit(1);
}

// 获取要翻译的内容
$page_content = null;
if ($page === 'homepage') {
    $page_content = [
        'site_name' => $source_array['site_name'] ?? '',
        'site_description' => $source_array['site_description'] ?? '',
        'nav' => $source_array['nav'] ?? [],
        'home' => $source_array['home'] ?? [],
        'content' => $source_array['content'] ?? [],
        'instruction' => $source_array['instruction'] ?? [],
        'advantages' => $source_array['advantages'] ?? [],
        'features' => $source_array['features'] ?? [],
        'faq' => $source_array['faq'] ?? [],
        'footer' => $source_array['footer'] ?? []
    ];
} elseif ($page === 'tagpage') {
    $page_content = [
        'error' => $source_array['error'] ?? [],
        'processing' => $source_array['processing'] ?? '',
        'download_button' => $source_array['download_button'] ?? '',
        'video' => $source_array['video'] ?? '',
        'audio' => $source_array['audio'] ?? '',
        'quality' => $source_array['quality'] ?? '',
        'format' => $source_array['format'] ?? '',
        'download' => $source_array['download'] ?? '',
        'download_video' => $source_array['download_video'] ?? '',
        'download_audio' => $source_array['download_audio'] ?? '',
        'mp4' => $source_array['mp4'] ?? '',
        'mp3' => $source_array['mp3'] ?? '',
        'search_results' => $source_array['search_results'] ?? '',
        'related_searches' => $source_array['related_searches'] ?? ''
    ];
} else {
    echo "错误：不支持的页面类型: {$page}\n";
    exit(1);
}

// 确定要翻译的语言列表
$target_languages = [];
if ($lang === 'all') {
    $all_languages = getSupportedLanguages();
    foreach ($all_languages as $code => $name) {
        if ($code !== 'en') { // 跳过英语
            $target_languages[] = $code;
        }
    }
} else {
    $target_languages[] = $lang;
}

echo "开始翻译 {$page} 页面到 " . count($target_languages) . " 种语言\n";
echo "===============================\n\n";

// 记录开始时间
$start_time = microtime(true);

// 开始翻译
foreach ($target_languages as $targetLang) {
    echo "翻译到 {$targetLang}...\n";
    
    $target_file = "../../i18n/{$site}/{$targetLang}.json";
    
    // 读取现有目标文件（如果存在）
    $target_array = [];
    if (file_exists($target_file)) {
        echo "目标文件已存在，将更新相关内容\n";
        $target_content = file_get_contents($target_file);
        $target_array = json_decode($target_content, true) ?: [];
    } else {
        echo "创建新的翻译文件\n";
    }
    
    // 翻译内容
    try {
        $translated_content = translateJsonContent($page_content, 'en', $targetLang);
        
        // 合并到目标数组
        foreach ($translated_content as $key => $value) {
            $target_array[$key] = $value;
        }
        
        // 保存文件
        $json = json_encode($target_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($target_file, $json);
        
        echo "✅ 成功保存到: {$target_file}\n";
        
    } catch (Exception $e) {
        echo "❌ 翻译失败: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    
    // 避免请求过快
    if ($targetLang !== end($target_languages)) {
        sleep(2);
    }
}

// 计算总耗时
$end_time = microtime(true);
$total_time = round($end_time - $start_time, 2);

echo "===============================\n";
echo "翻译完成！\n";
echo "总耗时: {$total_time} 秒\n";

// 格式化时间显示
if ($total_time > 60) {
    $minutes = floor($total_time / 60);
    $seconds = round($total_time % 60, 2);
    echo "       ({$minutes} 分 {$seconds} 秒)\n";
}