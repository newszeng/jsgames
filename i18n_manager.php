<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}
if (!defined('ADMIN_PATH')) {
    define('ADMIN_PATH', __DIR__);
}
if (!defined('I18N_PATH')) {
    define('I18N_PATH', ROOT_PATH . '/i18n');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 设置脚本执行超时时间为10分钟（600秒）
set_time_limit(600);

// 设置内存限制（如果需要处理大文件）
ini_set('memory_limit', '256M');

// 检查管理员登录
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: /admin/login.php');
    exit;
}

$message = '';
$messageType = '';

// 固定支持的语言
$allLanguages = [
    'en' => 'English', 'zh' => '中文', 'ja' => '日本語', 'ko' => '한국어',
    'es' => 'Español', 'fr' => 'Français', 'de' => 'Deutsch', 'it' => 'Italiano',
    'pt' => 'Português', 'ru' => 'Русский', 'ar' => 'العربية', 'hi' => 'हिन्दी',
    'th' => 'ไทย', 'vi' => 'Tiếng Việt', 'id' => 'Bahasa Indonesia', 'tr' => 'Türkçe',
    'pl' => 'Polski', 'nl' => 'Nederlands', 'sv' => 'Svenska', 'da' => 'Dansk'
];

// 递归获取所有目录函数
function getAllDirectories($basePath, $prefix = '') {
    $dirs = [];
    if (!is_dir($basePath)) {
        return $dirs;
    }
    
    $items = glob($basePath . '/*', GLOB_ONLYDIR);
    foreach ($items as $item) {
        $dirName = basename($item);
        if ($dirName !== '.' && $dirName !== '..') {
            $fullPath = $prefix ? $prefix . '/' . $dirName : $dirName;
            
            // 检查是否包含JSON文件或子目录
            $hasJsonFiles = !empty(glob($item . '/*.json'));
            $hasSubDirs = !empty(glob($item . '/*', GLOB_ONLYDIR));
            
            if ($hasJsonFiles) {
                $dirs[] = $fullPath;
            }
            
            // 递归获取子目录
            if ($hasSubDirs) {
                $subDirs = getAllDirectories($item, $fullPath);
                $dirs = array_merge($dirs, $subDirs);
            }
        }
    }
    
    return $dirs;
}

// 获取目录参数
$subDir = $_GET['dir'] ?? '';
if (empty($subDir)) {
    // 显示目录选择页面
    $availableDirs = getAllDirectories(I18N_PATH);
    
    // 显示目录选择页面
    include 'i18n_manager_select.php';
    exit;
}

// 验证目录安全性 - 支持多层路径
if (!preg_match('/^[a-zA-Z0-9_\/-]+$/', $subDir) || !is_dir(I18N_PATH . '/' . $subDir)) {
    $message = '无效的目录名称';
    $messageType = 'error';
    $subDir = '';
    $availableDirs = getAllDirectories(I18N_PATH);
    include 'i18n_manager_select.php';
    exit;
}

$translationsDir = I18N_PATH . '/' . $subDir;

// 获取已经翻译好的语言 - 修复统计问题
$languages = [];
if (is_dir($translationsDir)) {
    // 先获取目录中实际存在的所有语言文件
    $actualFiles = glob($translationsDir . '/*.json');
    foreach ($actualFiles as $file) {
        $langCode = pathinfo($file, PATHINFO_FILENAME);
        // 验证是否为有效的语言代码（2-3位字母）
        if (preg_match('/^[a-z]{2,3}$/', $langCode)) {
            $languages[] = $langCode;
        }
    }
    
    // 确保语言按字母顺序排序
    sort($languages);
}

if (empty($languages)) {
    $languages = ['en'];
}

// 当前编辑的语言
$currentLang = $_GET['lang'] ?? 'en';

// 加载内容
$translationFile = $translationsDir . '/' . $currentLang . '.json';
$translationContent = '';

if (file_exists($translationFile)) {
    $translationContent = file_get_contents($translationFile);
}

// 处理翻译单个语言
if (isset($_GET['translate_single'])) {
    $sourceLang = $_GET['source_lang'] ?? 'en';
    $targetLang = $_GET['translate_single'];
    
    $sourceFile = $translationsDir . '/' . $sourceLang . '.json';
    if (!file_exists($sourceFile)) {
        $message = '源语言文件未找到';
        $messageType = 'error';
    } else {
        $sourceContent = file_get_contents($sourceFile);
        $sourceArray = json_decode($sourceContent, true);
        
        if (!$sourceArray) {
            $message = '源语言文件格式错误';
            $messageType = 'error';
        } else {
            // 显示翻译进度页面
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>翻译进行中</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            </head>
            <body>
                <div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 40px; border: 2px solid #667eea; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.3); min-width: 400px; text-align: center;">
                    <h3><i class="fas fa-language"></i> 正在翻译...</h3>
                    <div style="margin: 20px 0;">
                        <div style="width: 100%; background: #f0f0f0; border-radius: 10px; overflow: hidden;">
                            <div id="progress-fill" style="width: 50%; height: 30px; background: linear-gradient(45deg, #667eea, #764ba2); transition: width 0.3s;"></div>
                        </div>
                    </div>
                    <div id="status">翻译到 <?php echo strtoupper($targetLang); ?>...</div>
                </div>
            ?>
            
            <script>
            // 创建带超时的fetch请求（20分钟超时）
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 1200000); // 20分钟
            
            fetch("/admin/i18n_manager.php?ajax_translate=1&dir=<?php echo urlencode($subDir); ?>&source_lang=<?php echo urlencode($sourceLang); ?>&target_lang=<?php echo urlencode($targetLang); ?>", {
                signal: controller.signal
            })
            .then(response => {
                clearTimeout(timeoutId);
                return response.json();
            })
            .then(data => {
                document.getElementById("progress-fill").style.width = "100%";
                if (data.success) {
                    document.getElementById("status").innerHTML = "✅ 翻译完成！";
                    setTimeout(function() {
                        window.location.href = "/admin/i18n_manager.php?dir=<?php echo urlencode($subDir); ?>&lang=<?php echo urlencode($targetLang); ?>&translated=1";
                    }, 1000);
                } else {
                    document.getElementById("status").innerHTML = "❌ 翻译失败: " + data.error;
                    setTimeout(function() {
                        window.location.href = "/admin/i18n_manager.php?dir=<?php echo urlencode($subDir); ?>&lang=<?php echo urlencode($sourceLang); ?>&error=1";
                    }, 2000);
                }
            })
            .catch(error => {
                clearTimeout(timeoutId);
                if (error.name === "AbortError") {
                    document.getElementById("status").innerHTML = "❌ 翻译超时 (20分钟)，请稍后重试";
                } else {
                    document.getElementById("status").innerHTML = "❌ 错误: " + error.message;
                }
            });
            </script>
            </body>
            </html>
            <?php
            exit;
        }
    }
}

// 处理翻译剩余语言
if (isset($_GET['translate_remaining'])) {
    $sourceLang = $_GET['translate_remaining'];
    
    $sourceFile = $translationsDir . '/' . $sourceLang . '.json';
    if (!file_exists($sourceFile)) {
        $message = '源语言文件未找到';
        $messageType = 'error';
    } else {
        // 获取需要翻译的语言（不存在文件的）
        $targetLanguages = [];
        foreach ($allLanguages as $code => $name) {
            if ($code !== $sourceLang) {
                $targetFile = $translationsDir . '/' . $code . '.json';
                if (!file_exists($targetFile)) {
                    $targetLanguages[] = $code;
                }
            }
        }
        
        if (empty($targetLanguages)) {
            $message = '所有语言都已翻译完成';
            $messageType = 'success';
        } else {
            showTranslationProgress($targetLanguages, $sourceLang, '翻译剩余语言', $subDir);
        }
    }
}

// 处理翻译所有语言
if (isset($_GET['translate_all'])) {
    $sourceLang = $_GET['translate_all'];
    
    $sourceFile = $translationsDir . '/' . $sourceLang . '.json';
    if (!file_exists($sourceFile)) {
        $message = '源语言文件未找到';
        $messageType = 'error';
    } else {
        // 获取所有需要翻译的语言（除了源语言）
        $targetLanguages = [];
        foreach ($allLanguages as $code => $name) {
            if ($code !== $sourceLang) {
                $targetLanguages[] = $code;
            }
        }
        
        showTranslationProgress($targetLanguages, $sourceLang, '翻译所有语言', $subDir);
    }
}

// 显示翻译进度页面
function showTranslationProgress($targetLanguages, $sourceLang, $title, $subDir) {
    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>翻译进行中</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></head><body>';
    echo '<div id="translation-progress" style="position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); background: white; padding: 30px; border: 2px solid #667eea; border-radius: 10px; z-index: 9999; box-shadow: 0 0 20px rgba(0,0,0,0.3); min-width: 400px; max-height: 60vh; overflow-y: auto;">';
    echo '<h3><i class="fas fa-language"></i> ' . $title . '...</h3>';
    echo '<div id="progress-info">准备翻译到 ' . count($targetLanguages) . ' 种语言</div>';
    echo '<div style="margin: 20px 0;"><div id="progress-bar" style="width: 100%; background: #f0f0f0; border-radius: 10px; overflow: hidden;"><div id="progress-fill" style="width: 0%; height: 30px; background: linear-gradient(45deg, #667eea, #764ba2); transition: width 0.3s;"></div></div></div>';
    echo '<div id="current-lang">等待开始...</div>';
    echo '<div id="remaining-count">剩余: ' . count($targetLanguages) . ' 种语言</div>';
    echo '</div>';
    
    echo '<script>
    let languages = ' . json_encode($targetLanguages) . ';
    let currentIndex = 0;
    let totalLanguages = languages.length;
    let sourceLang = "' . htmlspecialchars($sourceLang, ENT_QUOTES) . '";
    let subDir = "' . htmlspecialchars($subDir, ENT_QUOTES) . '";
    
    function translateNext() {
        if (currentIndex >= languages.length) {
            document.getElementById("current-lang").innerHTML = "✅ 翻译完成！";
            document.getElementById("remaining-count").innerHTML = "所有语言翻译完成";
            document.getElementById("progress-fill").style.width = "100%";
            setTimeout(function() {
                window.location.href = "/admin/i18n_manager.php?dir=" + encodeURIComponent(subDir) + "&lang=" + sourceLang + "&translated_all=1";
            }, 2000);
            return;
        }
        
        let targetLang = languages[currentIndex];
        let progress = Math.round(((currentIndex) / totalLanguages) * 100);
        let remaining = totalLanguages - currentIndex;
        
        document.getElementById("progress-fill").style.width = progress + "%";
        document.getElementById("current-lang").innerHTML = "🔄 正在翻译: " + targetLang.toUpperCase();
        document.getElementById("remaining-count").innerHTML = "剩余: " + remaining + " 种语言";
        
        // 创建带超时的fetch请求（20分钟超时）
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 1200000); // 20分钟
        
        fetch("/admin/i18n_manager.php?ajax_translate=1&dir=" + encodeURIComponent(subDir) + "&source_lang=" + sourceLang + "&target_lang=" + targetLang, {
            signal: controller.signal
        })
        .then(response => {
            clearTimeout(timeoutId);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById("current-lang").innerHTML = "✅ 完成: " + targetLang.toUpperCase();
            } else {
                document.getElementById("current-lang").innerHTML = "❌ 失败: " + targetLang.toUpperCase() + " - " + (data.error || data.message);
            }
            
            currentIndex++;
            setTimeout(translateNext, 1000);
        })
        .catch(error => {
            clearTimeout(timeoutId);
            if (error.name === "AbortError") {
                document.getElementById("current-lang").innerHTML = "❌ 超时: " + targetLang.toUpperCase() + " (20分钟)";
            } else {
                document.getElementById("current-lang").innerHTML = "❌ 错误: " + targetLang.toUpperCase() + " - " + error.message;
            }
            currentIndex++;
            setTimeout(translateNext, 1000);
        });
    }
    
    setTimeout(translateNext, 1000);
    </script></body></html>';
    
    exit;
}

// 处理新建语言
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_language'])) {
    $newLang = trim($_POST['new_language_code'] ?? '');
    
    if (empty($newLang)) {
        $message = '语言代码不能为空';
        $messageType = 'error';
    } elseif (!preg_match('/^[a-z]{2,3}$/', $newLang)) {
        $message = '语言代码格式错误，请使用2-3位小写字母（如: da, pt, etc）';
        $messageType = 'error';
    } else {
        $newLangFile = $translationsDir . '/' . $newLang . '.json';
        if (file_exists($newLangFile)) {
            $message = '语言文件 ' . $newLang . '.json 已存在';
            $messageType = 'error';
        } else {
            // 创建空白语言文件
            if (file_put_contents($newLangFile, '{}')) {
                $message = '成功创建语言文件 ' . $newLang . '.json';
                $messageType = 'success';
                // 重新加载语言列表
                $languages = [];
                foreach ($allLanguages as $code => $name) {
                    if (file_exists($translationsDir . '/' . $code . '.json')) {
                        $languages[] = $code;
                    }
                }
                // 跳转到新创建的语言进行编辑
                header('Location: /admin/i18n_manager.php?dir=' . urlencode($subDir) . '&lang=' . $newLang . '&created=1');
                exit;
            } else {
                $message = '创建语言文件失败，请检查权限';
                $messageType = 'error';
            }
        }
    }
}

// 处理保存
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json_content'])) {
    $content = $_POST['json_content'] ?? '';
    
    // 验证JSON
    $decoded = json_decode($content, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $message = 'JSON格式错误: ' . json_last_error_msg();
        $messageType = 'error';
    } else {
        $filePath = $translationsDir . '/' . $currentLang . '.json';
        $formatted = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        if (file_put_contents($filePath, $formatted)) {
            $message = '保存成功！';
            $messageType = 'success';
            $translationContent = $formatted;
        } else {
            $message = '保存失败';
            $messageType = 'error';
        }
    }
}

// 处理AJAX翻译
if (isset($_GET['ajax_translate'])) {
    // 启用错误报告和日志记录，但不显示在页面上
    ini_set('log_errors', 1);
    ini_set('display_errors', 0);
    error_reporting(E_ALL);
    
    // 为AJAX翻译请求设置20分钟超时（大文件可能需要更长时间）
    set_time_limit(1200);
    ini_set('memory_limit', '512M');
    
    // 禁用输出缓冲，避免超时时的问题
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // 记录请求开始
    $logFile = ADMIN_PATH . '/logs/translation.log';
    if (!is_dir(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    
    $sourceLang = $_GET['source_lang'] ?? '';
    $targetLang = $_GET['target_lang'] ?? '';
    $subDir = $_GET['dir'] ?? '';
    
    error_log(date('[Y-m-d H:i:s] ') . "Translation request started: {$sourceLang} -> {$targetLang}, dir: {$subDir}", 3, $logFile);
    
    try {
        require_once ADMIN_PATH . '/lib/translate_gemini.php';
    } catch (Exception $e) {
        error_log(date('[Y-m-d H:i:s] ') . "Failed to load translate_gemini.php: " . $e->getMessage(), 3, $logFile);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => '翻译库加载失败: ' . $e->getMessage()]);
        exit;
    }
    
    // 构建翻译目录路径
    $translationsDir = I18N_PATH . '/' . $subDir;
    $sourceFile = $translationsDir . '/' . $sourceLang . '.json';
    
    error_log(date('[Y-m-d H:i:s] ') . "Looking for source file: {$sourceFile}", 3, $logFile);
    
    if (!file_exists($sourceFile)) {
        error_log(date('[Y-m-d H:i:s] ') . "Source file not found: {$sourceFile}", 3, $logFile);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Source file not found: ' . $sourceFile]);
        exit;
    }
    
    try {
        error_log(date('[Y-m-d H:i:s] ') . "Reading source file: {$sourceFile}", 3, $logFile);
        $sourceContent = file_get_contents($sourceFile);
        
        if (!$sourceContent) {
            throw new Exception('无法读取源文件');
        }
        
        error_log(date('[Y-m-d H:i:s] ') . "Source file size: " . strlen($sourceContent) . " bytes", 3, $logFile);
        
        $sourceArray = json_decode($sourceContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('源文件JSON格式错误: ' . json_last_error_msg());
        }
        
        if (!$sourceArray) {
            throw new Exception('源文件内容为空或无效');
        }
        
        error_log(date('[Y-m-d H:i:s] ') . "Starting translation with Gemini", 3, $logFile);
        
        // 记录开始时间
        $startTime = time();
        $duration = 0;
        
        // 检查翻译函数是否存在
        if (!function_exists('translateJsonWithGemini')) {
            throw new Exception('translateJsonWithGemini 函数不存在');
        }
        
        // 使用Gemini翻译
        try {
            $translatedArray = translateJsonWithGemini($sourceArray, $targetLang, $sourceLang);
            
            $duration = time() - $startTime;
            error_log(date('[Y-m-d H:i:s] ') . "Translation completed in {$duration} seconds", 3, $logFile);
        } catch (Exception $translateException) {
            $duration = time() - $startTime;
            error_log(date('[Y-m-d H:i:s] ') . "Translation function failed after {$duration}s: " . $translateException->getMessage(), 3, $logFile);
            error_log(date('[Y-m-d H:i:s] ') . "Translation function stack trace: " . $translateException->getTraceAsString(), 3, $logFile);
            throw $translateException; // 重新抛出，让外层catch处理
        }
        
        // 检查是否超时
        if ($duration > 1100) { // 接近20分钟时警告
            error_log(date('[Y-m-d H:i:s] ') . "Translation taking longer than expected for {$sourceLang} to {$targetLang}: {$duration}s", 3, $logFile);
        }
        
        if ($translatedArray && is_array($translatedArray)) {
            $targetFile = $translationsDir . '/' . $targetLang . '.json';
            
            if (!is_dir($translationsDir)) {
                error_log(date('[Y-m-d H:i:s] ') . "Creating directory: {$translationsDir}", 3, $logFile);
                mkdir($translationsDir, 0755, true);
            }
            
            error_log(date('[Y-m-d H:i:s] ') . "Saving to: {$targetFile}", 3, $logFile);
            
            $success = file_put_contents($targetFile, json_encode($translatedArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            if ($success) {
                error_log(date('[Y-m-d H:i:s] ') . "File saved successfully, size: {$success} bytes", 3, $logFile);
                $result = ['success' => true, 'message' => '翻译完成'];
                error_log(date('[Y-m-d H:i:s] ') . "Success result set, preparing response", 3, $logFile);
            } else {
                error_log(date('[Y-m-d H:i:s] ') . "Failed to save file: {$targetFile}", 3, $logFile);
                $result = ['success' => false, 'error' => '保存文件失败'];
            }
        } else {
            error_log(date('[Y-m-d H:i:s] ') . "Translation returned invalid result: " . gettype($translatedArray), 3, $logFile);
            $result = ['success' => false, 'error' => '翻译API返回空结果或格式错误'];
        }
        
    } catch (Exception $e) {
        $errorMsg = $e->getMessage();
        error_log(date('[Y-m-d H:i:s] ') . "Translation error: {$errorMsg}", 3, $logFile);
        error_log(date('[Y-m-d H:i:s] ') . "Stack trace: " . $e->getTraceAsString(), 3, $logFile);
        $result = ['success' => false, 'error' => '翻译过程出错: ' . $errorMsg];
    }
        
    error_log(date('[Y-m-d H:i:s] ') . "Preparing to send JSON response", 3, $logFile);
    header('Content-Type: application/json');
    
    // 确保 $result 变量存在
    if (!isset($result)) {
        error_log(date('[Y-m-d H:i:s] ') . "Error: \$result variable not set", 3, $logFile);
        $result = ['success' => false, 'error' => 'Internal error: result not set'];
    }
    
    error_log(date('[Y-m-d H:i:s] ') . "Result: " . json_encode($result), 3, $logFile);
    
    $jsonResponse = json_encode($result);
    if ($jsonResponse === false) {
        error_log(date('[Y-m-d H:i:s] ') . "JSON encode failed: " . json_last_error_msg(), 3, $logFile);
        echo json_encode(['success' => false, 'error' => 'JSON encoding failed']);
    } else {
        error_log(date('[Y-m-d H:i:s] ') . "Sending JSON response", 3, $logFile);
        echo $jsonResponse;
    }
    error_log(date('[Y-m-d H:i:s] ') . "Response sent, exiting", 3, $logFile);
    exit;
}

// 检查提示信息
if (isset($_GET['translated'])) {
    $message = '翻译完成';
    $messageType = 'success';
}

if (isset($_GET['translated_all'])) {
    $message = '所有语言翻译完成！';
    $messageType = 'success';
}

if (isset($_GET['error'])) {
    $message = '翻译失败，请检查 Gemini API 配置';
    $messageType = 'error';
}

if (isset($_GET['created'])) {
    $message = '语言文件创建成功！';
    $messageType = 'success';
}

// 获取目录的友好名称
function getDirFriendlyName($dirPath) {
    // 完全动态处理，不写死任何目录名称
    $parts = explode('/', $dirPath);
    $friendlyParts = [];
    
    foreach ($parts as $part) {
        // 将 kebab-case 和 snake_case 转换为友好名称
        $friendly = ucfirst(str_replace(['-', '_'], ' ', $part));
        $friendlyParts[] = $friendly;
    }
    
    return implode(' / ', $friendlyParts);
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getDirFriendlyName($subDir); ?>语言包管理 - 后台管理系统</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/static/css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/ace.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.23.4/ext-language_tools.js"></script>
    
    <!-- Bootstrap & jQuery for Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- CodeMirror for Summernote code view -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    
    <!-- Summernote - 使用稳定的CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    <style>
        #editor {
            width: 100%;
            height: 600px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .editor-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-bottom: none;
            border-radius: 8px 8px 0 0;
        }
        
        .editor-actions {
            display: flex;
            gap: 10px;
        }

        .json-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .json-status.valid {
            background: #c6f6d5;
            color: #22543d;
        }
        
        .json-status.invalid {
            background: #fed7d7;
            color: #742a2a;
        }
        
        .help-box {
            background: #edf2f7;
            border-left: 4px solid #4299e1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .help-box h4 {
            margin: 0 0 10px 0;
            color: #2d3748;
        }
        
        .help-box p {
            margin: 5px 0;
            color: #4a5568;
            font-size: 14px;
        }

        /* 翻译模态框样式 */
        .translate-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }
        
        .translate-modal.show {
            display: flex;
        }
        
        .translate-modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .translate-modal-content h3 {
            margin-top: 0;
            color: #2d3748;
        }
        
        /* Summernote 样式调整 */
        .note-editor {
            margin-bottom: 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
        }
        
        .note-editor .note-editing-area .note-editable {
            background: #fff;
            color: #374151;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .note-btn-group .note-btn {
            background: transparent;
            border: none;
            color: #4a5568;
        }
        
        .note-btn-group .note-btn:hover {
            background: #f7fafc;
        }
        
        .note-toolbar {
            background: #f8f9fa;
            border-bottom: 1px solid #e5e7eb;
        }
        
        /* 确保模态框内的Summernote正常显示 */
        .translate-modal .note-editor {
            z-index: 1051;
        }
        
        /* CodeMirror代码编辑器样式 */
        .note-editor .note-codable {
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.4;
        }
        
        .CodeMirror {
            height: auto;
            min-height: 150px;
            max-height: 300px;
            border: 1px solid #ddd;
            font-size: 13px;
        }
        
        .CodeMirror-scroll {
            min-height: 150px;
            max-height: 300px;
        }
        
        /* 代码查看按钮样式 */
        .note-btn[data-original-title="Code View"] {
            background-color: #f8f9fa;
        }
        
        .note-btn[data-original-title="Code View"]:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <?php include ADMIN_PATH . '/includes/sidebar.php'; ?>
        
        <main class="main-content">
            <header class="content-header">
                <h1><i class="fas fa-language"></i> <?php echo getDirFriendlyName($subDir); ?>语言包管理</h1>
                <div class="header-actions">
                    <a href="/admin/i18n_manager.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> 返回目录列表
                    </a>
                </div>
                <p style="margin: 10px 0 0 0; color: #6b7280; font-size: 14px;">
                    <i class="fas fa-folder"></i> 管理目录: i18n/<?php echo htmlspecialchars($subDir); ?>/
                </p>
            </header>

            <div class="content-body">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <div class="help-box">
                    <h4><i class="fas fa-info-circle"></i> 说明</h4>
                    <p>• 管理 <?php echo getDirFriendlyName($subDir); ?> 的多语言翻译内容</p>
                    <p>• 修改后会自动应用到相关页面和功能</p>
                    <p>• 支持39种语言的一键翻译功能</p>
                </div>

                <!-- Language Management -->
                <div class="card" style="margin-bottom: 1rem;">
                    <div class="card-body" style="padding: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div style="flex: 1;">
                                <strong><i class="fas fa-language"></i> 语言管理</strong>
                                <div class="language-stats" style="margin-top: 10px;">
                                    支持 <strong><?php echo count($languages); ?></strong> 种语言
                                    <span style="color: #9ca3af;">（<?php echo getDirFriendlyName($subDir); ?>）</span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="btn btn-warning btn-sm" onclick="showTranslateModal()">
                                    <i class="fas fa-language"></i> 一键翻译
                                </button>
                            </div>
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; max-height: 200px; overflow-y: auto; padding: 5px;">
                            <?php foreach ($languages as $lang): ?>
                                <a href="/admin/i18n_manager.php?dir=<?php echo urlencode($subDir); ?>&lang=<?php echo $lang; ?>" 
                                   class="btn btn-sm <?php echo $currentLang === $lang ? 'btn-primary' : 'btn-outline'; ?>"
                                   style="min-width: 100px;">
                                    <?php echo $allLanguages[$lang] ?? strtoupper($lang); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- 新建语言表单 -->
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e7eb;">
                            <form method="POST" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <input type="hidden" name="create_language" value="1">
                                <label style="font-size: 14px; color: #374151; font-weight: 500;">新建语言：</label>
                                <input type="text" name="new_language_code" 
                                       placeholder="如: da, pt, no..." 
                                       style="width: 120px; padding: 6px 10px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px;"
                                       pattern="^[a-z]{2,3}$" 
                                       title="请输入2-3位小写字母语言代码">
                                <button type="submit" class="btn btn-sm" style="background: #10b981; color: white; border: none; padding: 6px 12px;">
                                    <i class="fas fa-plus"></i> 创建
                                </button>
                            </form>
                            <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 5px;">
                                创建空白语言文件，支持的语言代码请参考现有语言
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-code"></i> 编辑 JSON 内容 - <?php echo $allLanguages[$currentLang] ?? strtoupper($currentLang); ?></h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="editForm">

                            <div class="editor-toolbar">
                                <div>
                                    <span id="jsonStatus" class="json-status valid">JSON 格式正确</span>
                                    <span style="margin-left: 15px; font-size: 12px; color: #718096;">
                                        文件: i18n/<?php echo htmlspecialchars($subDir); ?>/<?php echo $currentLang; ?>.json
                                    </span>
                                </div>
                                <div class="editor-actions">
                                    <button type="button" class="btn btn-warning" onclick="openNodeEditor()">
                                        <i class="fas fa-edit"></i> 节点编辑器
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="formatJSON()">
                                        <i class="fas fa-magic"></i> 格式化
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="validateJSON()">
                                        <i class="fas fa-check-circle"></i> 验证
                                    </button>
                                    <button type="submit" name="save" class="btn btn-primary">
                                        <i class="fas fa-save"></i> 保存
                                    </button>
                                </div>
                            </div>
                            
                            <div id="editor"><?php echo htmlspecialchars($translationContent); ?></div>
                            <input type="hidden" name="json_content" id="json_content">
                        </form>
                    </div>
                </div>

                <!-- 翻译模态框 -->
                <div id="translateModal" class="translate-modal">
                    <div class="translate-modal-content">
                        <h3><i class="fas fa-language"></i> 一键翻译</h3>
                        <p style="color: #718096; margin: 15px 0;">选择翻译方式</p>
                        
                        <div class="alert alert-info" style="font-size: 13px; margin-bottom: 20px;">
                            <i class="fas fa-info-circle"></i> 
                            现在使用 Google Gemini 翻译，速度更快，长度限制更少，支持一次性翻译大型JSON
                        </div>
                        
                        <!-- 翻译选项 -->
                        <div style="margin-bottom: 20px;">
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 600;">
                                    <input type="radio" name="translate_mode" value="single" checked onchange="toggleTargetLanguage()">
                                    翻译到指定语言
                                </label>
                                <select id="targetLanguage" class="form-control" style="margin-left: 25px; max-width: 300px;">
                                    <?php foreach ($allLanguages as $code => $name): ?>
                                        <?php if ($code !== $currentLang): ?>
                                            <option value="<?php echo $code; ?>"><?php echo $name; ?> (<?php echo strtoupper($code); ?>)</option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-weight: 600;">
                                    <input type="radio" name="translate_mode" value="remaining" onchange="toggleTargetLanguage()">
                                    翻译剩余未翻译的语言
                                </label>
                                <small style="display: block; margin-left: 25px; color: #718096;">
                                    自动检测并翻译还没有翻译文件的语言
                                </small>
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-weight: 600;">
                                    <input type="radio" name="translate_mode" value="all" onchange="toggleTargetLanguage()">
                                    翻译所有语言
                                </label>
                                <small style="display: block; margin-left: 25px; color: #718096;">
                                    重新翻译所有语言（会覆盖现有翻译）
                                </small>
                            </div>
                        </div>
                        
                        <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                            <button type="button" class="btn btn-secondary" onclick="closeTranslateModal()">
                                取消
                            </button>
                            <button type="button" class="btn btn-primary" onclick="startTranslation()">
                                <i class="fas fa-language"></i> 开始翻译
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 节点编辑器模态框 -->
                <div id="nodeEditorModal" class="translate-modal">
                    <div class="translate-modal-content" style="max-width: 800px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3><i class="fas fa-edit"></i> 节点编辑器</h3>
                            <button onclick="closeNodeEditor()" class="btn btn-sm btn-secondary">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <p style="color: #6b7280; margin: 0;">以表单形式编辑JSON数据，更便于操作</p>
                        </div>
                        
                        <div id="nodeEditorContent" style="max-height: 500px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; padding: 15px; background: #fafafa;">
                            <!-- 动态生成的表单内容 -->
                        </div>
                        
                        <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: flex-end;">
                            <button onclick="closeNodeEditor()" class="btn btn-secondary">
                                取消
                            </button>
                            <button onclick="applyNodeChanges()" class="btn btn-primary">
                                <i class="fas fa-check"></i> 应用更改
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // 初始化 ACE 编辑器
        const editor = ace.edit("editor");
        editor.setTheme("ace/theme/monokai");
        editor.session.setMode("ace/mode/json");
        editor.setOptions({
            fontSize: "14px",
            showPrintMargin: false,
            tabSize: 2,
            useSoftTabs: true
        });
        
        // 启用自动完成功能
        ace.require("ace/ext/language_tools");
        editor.setOptions({
            enableBasicAutocompletion: true,
            enableLiveAutocompletion: true
        });

        // 提交前将编辑器内容同步到表单
        document.getElementById('editForm').addEventListener('submit', function(e) {
            document.getElementById('json_content').value = editor.getValue();
        });

        // 验证 JSON
        function validateJSON(showAlert = true) {
            try {
                JSON.parse(editor.getValue());
                updateStatus(true, 'JSON 格式正确');
                if (showAlert) {
                    alert('✅ JSON 格式正确！');
                }
                return true;
            } catch (e) {
                updateStatus(false, 'JSON 格式错误: ' + e.message);
                if (showAlert) {
                    alert('❌ JSON 格式错误：\n' + e.message);
                }
                return false;
            }
        }

        // 格式化 JSON
        function formatJSON() {
            try {
                var content = editor.getValue();
                var parsed = JSON.parse(content);
                var formatted = JSON.stringify(parsed, null, 2);
                editor.setValue(formatted, -1);
                updateStatus(true, 'JSON 已格式化');
            } catch (e) {
                updateStatus(false, 'JSON 格式错误: ' + e.message);
            }
        }

        // 更新状态显示
        function updateStatus(isValid, message) {
            const statusEl = document.getElementById('jsonStatus');
            if (isValid) {
                statusEl.className = 'json-status valid';
                statusEl.textContent = message || 'JSON 格式正确';
            } else {
                statusEl.className = 'json-status invalid';
                statusEl.textContent = message || 'JSON 格式错误';
            }
        }

        // 自动验证 JSON
        editor.session.on('change', function() {
            validateJSON(false);
        });

        // 显示翻译模态框
        function showTranslateModal() {
            if (!validateJSON(false)) {
                alert('当前JSON格式无效，请先修正后再翻译');
                return;
            }
            document.getElementById('translateModal').classList.add('show');
        }

        // 关闭翻译模态框
        function closeTranslateModal() {
            document.getElementById('translateModal').classList.remove('show');
        }

        // 切换目标语言选择框
        function toggleTargetLanguage() {
            const mode = document.querySelector('input[name="translate_mode"]:checked').value;
            const targetLangSelect = document.getElementById('targetLanguage');
            targetLangSelect.disabled = (mode !== 'single');
        }

        // 开始翻译
        function startTranslation() {
            const mode = document.querySelector('input[name="translate_mode"]:checked').value;
            const sourceLang = '<?php echo $currentLang; ?>';
            const subDir = '<?php echo addslashes($subDir); ?>';
            
            // 先保存当前内容
            if (!validateJSON()) {
                alert('当前JSON格式无效，请先修正');
                return;
            }
            
            // 使用 fetch 保存内容，然后再跳转
            const formData = new FormData();
            formData.append('json_content', editor.getValue());
            
            fetch('/admin/i18n_manager.php?dir=' + encodeURIComponent(subDir) + '&lang=' + sourceLang, {
                method: 'POST',
                body: formData
            })
            .then(() => {
                // 保存成功后，根据模式跳转
                if (mode === 'single') {
                    const targetLang = document.getElementById('targetLanguage').value;
                    window.location.href = '/admin/i18n_manager.php?dir=' + encodeURIComponent(subDir) + '&translate_single=' + targetLang + '&source_lang=' + sourceLang;
                } else if (mode === 'remaining') {
                    window.location.href = '/admin/i18n_manager.php?dir=' + encodeURIComponent(subDir) + '&translate_remaining=' + sourceLang;
                } else if (mode === 'all') {
                    if (confirm('确定要重新翻译所有语言吗？这将覆盖现有的翻译内容。')) {
                        window.location.href = '/admin/i18n_manager.php?dir=' + encodeURIComponent(subDir) + '&translate_all=' + sourceLang;
                    }
                }
            })
            .catch(error => {
                alert('保存失败: ' + error);
            });
        }

        // 初始验证
        validateJSON(false);

        // 防止意外离开
        var originalContent = editor.getValue();
        window.addEventListener('beforeunload', function(e) {
            if (editor.getValue() !== originalContent) {
                e.preventDefault();
                e.returnValue = '您有未保存的更改，确定要离开吗？';
                return e.returnValue;
            }
        });

        // 保存后更新原始内容
        document.getElementById('editForm').addEventListener('submit', function() {
            originalContent = editor.getValue();
        });

        // 快捷键保存
        editor.commands.addCommand({
            name: 'save',
            bindKey: {win: 'Ctrl-S', mac: 'Command-S'},
            exec: function(editor) {
                document.getElementById('editForm').submit();
            }
        });

        // 节点编辑器功能
        let nodeEditorData = {};
        let summernoteInstances = [];
        
        // 按需加载Summernote
        function ensureSummernoteLoaded(callback) {
            if (checkDependencies()) {
                callback();
                return;
            }
            
            console.log('Loading Summernote on demand...');
            loadSummernoteBackup();
            
            // 等待加载完成
            let checkCount = 0;
            const checkInterval = setInterval(() => {
                checkCount++;
                if (checkDependencies()) {
                    clearInterval(checkInterval);
                    callback();
                } else if (checkCount > 20) { // 最多等待4秒
                    clearInterval(checkInterval);
                    console.error('Failed to load Summernote after multiple attempts');
                    callback(); // 即使失败也继续，使用普通textarea
                }
            }, 200);
        }
        
        // 打开节点编辑器
        function openNodeEditor() {
            const currentLang = '<?php echo $currentLang; ?>';
            if (!currentLang) {
                alert('请先选择要编辑的语言');
                return;
            }
            
            // 验证JSON
            if (!validateJSON(false)) {
                alert('JSON格式错误，请先修复后再使用节点编辑器');
                return;
            }
            
            try {
                // 清理之前的Summernote实例
                destroyAllSummernoteInstances();
                
                const jsonContent = editor.getValue();
                nodeEditorData = JSON.parse(jsonContent);
                
                // 检查是否需要Summernote，如果需要则确保加载
                const hasContentFields = jsonContent.toLowerCase().includes('content');
                
                if (hasContentFields) {
                    ensureSummernoteLoaded(() => {
                        // 生成表单
                        generateNodeEditor(nodeEditorData);
                        // 显示模态框
                        document.getElementById('nodeEditorModal').classList.add('show');
                    });
                } else {
                    // 不需要Summernote，直接生成表单
                    generateNodeEditor(nodeEditorData);
                    document.getElementById('nodeEditorModal').classList.add('show');
                }
                
            } catch (error) {
                alert('解析JSON失败: ' + error.message);
            }
        }
        
        // 关闭节点编辑器
        function closeNodeEditor() {
            // 销毁所有Summernote实例
            destroyAllSummernoteInstances();
            document.getElementById('nodeEditorModal').classList.remove('show');
        }
        
        // 检查依赖是否加载完成
        function checkDependencies() {
            return typeof jQuery !== 'undefined' && 
                   jQuery.fn && 
                   typeof jQuery.fn.summernote !== 'undefined' &&
                   typeof CodeMirror !== 'undefined';
        }
        
        // 检查是否需要Summernote（只在有content字段时才需要）
        function needsSummernote() {
            // 在节点编辑器打开时检查
            const nodeEditorTextareas = document.querySelectorAll('textarea[data-needs-summernote="true"]').length;
            if (nodeEditorTextareas > 0) {
                return true;
            }
            
            // 页面加载时无法预知，但我们可以检查当前JSON内容是否包含content字段
            try {
                if (typeof editor !== 'undefined' && editor.getValue) {
                    const jsonContent = editor.getValue();
                    return jsonContent.toLowerCase().includes('content') && jsonContent.length > 100;
                }
            } catch (e) {
                // 忽略错误
            }
            
            return false;
        }
        
        // 初始化Summernote编辑器
        function initializeSummernote(textareaId, retryCount = 0) {
            if (!document.getElementById(textareaId)) {
                console.warn('Textarea not found:', textareaId);
                return;
            }
            
            // 检查依赖是否加载完成
            if (!checkDependencies()) {
                if (retryCount < 10) { // 最多重试10次
                    console.warn('jQuery or Summernote not loaded yet, retrying...', retryCount + 1);
                    setTimeout(() => {
                        initializeSummernote(textareaId, retryCount + 1);
                    }, 200);
                } else {
                    console.error('Failed to load dependencies for Summernote after 10 retries');
                }
                return;
            }
            
            try {
                const $textarea = $('#' + textareaId);
                if ($textarea.length === 0) {
                    console.warn('jQuery cannot find textarea:', textareaId);
                    return;
                }
                
                $textarea.summernote({
                    height: 150,
                    minHeight: 100,
                    maxHeight: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    placeholder: '请输入内容...',
                    codemirror: {
                        mode: 'text/html',
                        htmlMode: true,
                        lineNumbers: true,
                        theme: 'default'
                    },
                    callbacks: {
                        onInit: function() {
                            // 记录实例以便后续销毁
                            summernoteInstances.push(textareaId);
                            console.log('Summernote initialized for:', textareaId);
                        },
                        onFocus: function() {
                            // 确保编辑器在模态框内正确显示
                            $(this).summernote('toolbar').css('z-index', 1052);
                        }
                    }
                });
            } catch (error) {
                console.error('Failed to initialize Summernote for:', textareaId, error);
            }
        }
        
        // 销毁所有Summernote实例
        function destroyAllSummernoteInstances() {
            // 检查jQuery是否可用
            if (typeof jQuery === 'undefined') {
                console.warn('jQuery not available for destroying Summernote instances');
                summernoteInstances = [];
                return;
            }
            
            summernoteInstances.forEach(function(instanceId) {
                try {
                    const $element = $('#' + instanceId);
                    if ($element.length && $element.data('summernote')) {
                        $element.summernote('destroy');
                        console.log('Destroyed Summernote instance:', instanceId);
                    }
                } catch (error) {
                    console.warn('Failed to destroy Summernote instance:', instanceId, error);
                }
            });
            
            // 清空实例数组
            summernoteInstances = [];
            
            // 额外清理：销毁所有可能残留的Summernote实例
            try {
                $('.summernote-textarea').each(function() {
                    const $this = $(this);
                    if ($this.data('summernote')) {
                        $this.summernote('destroy');
                    }
                });
            } catch (error) {
                console.warn('Error during additional cleanup:', error);
            }
        }
        
        // 生成节点编辑器表单 - 通用版本
        function generateNodeEditor(data) {
            const container = document.getElementById('nodeEditorContent');
            container.innerHTML = '';
            
            generateFormForObject(data, container, '', true);
            
            // 添加全局添加按钮
            addGlobalAddButton();
            
            // 等待DOM渲染完成后初始化所有Summernote
            setTimeout(() => {
                initializeAllSummernoteEditors();
            }, 300);
        }
        
        // 为节点编辑器添加全局添加按钮
        function addGlobalAddButton() {
            const container = document.getElementById('nodeEditorContent');
            if (!container) return;
            
            const addButton = document.createElement('div');
            addButton.className = 'global-add-button';
            addButton.style.cssText = 'text-align: center; margin-top: 20px; padding: 15px; border: 2px dashed #d1d5db; border-radius: 8px; background: #f9fafb;';
            
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-primary';
            button.innerHTML = '<i class="fas fa-plus"></i> 添加根节点';
            button.onclick = () => addNewNode('');
            
            addButton.appendChild(button);
            container.appendChild(addButton);
        }
        
        // 批量初始化所有需要Summernote的textarea
        function initializeAllSummernoteEditors() {
            const textareas = document.querySelectorAll('textarea[data-needs-summernote="true"]');
            console.log('Found', textareas.length, 'textareas that need Summernote');
            
            if (textareas.length === 0) {
                console.log('No textareas need Summernote, skipping initialization');
                return;
            }
            
            // 只在有需要的textarea时才检查依赖
            if (!checkDependencies()) {
                console.warn('Summernote dependencies not loaded, but needed for', textareas.length, 'textareas');
                return;
            }
            
            textareas.forEach((textarea, index) => {
                setTimeout(() => {
                    if (textarea.id) {
                        initializeSummernote(textarea.id);
                        // 移除标记，避免重复初始化
                        textarea.removeAttribute('data-needs-summernote');
                    }
                }, index * 50); // 每个编辑器间隔50ms初始化，避免冲突
            });
        }
        
        // 递归生成表单元素
        function generateFormForObject(obj, container, pathPrefix, isRoot = false) {
            Object.keys(obj).forEach(key => {
                const value = obj[key];
                const currentPath = pathPrefix ? `${pathPrefix}.${key}` : key;
                
                if (Array.isArray(value)) {
                    // 处理数组
                    const arrayGroup = createArrayGroup(key, currentPath, value);
                    container.appendChild(arrayGroup);
                } else if (typeof value === 'object' && value !== null) {
                    // 处理对象
                    const objectGroup = createObjectGroup(key, currentPath, value, isRoot && pathPrefix === '');
                    container.appendChild(objectGroup);
                } else {
                    // 处理基本类型
                    const inputGroup = createUniversalInputGroup(key, currentPath, value);
                    container.appendChild(inputGroup);
                }
            });
        }
        
        // 创建通用输入框组
        function createUniversalInputGroup(label, path, value) {
            const group = document.createElement('div');
            group.style.cssText = 'margin-bottom: 15px; position: relative;';
            group.setAttribute('data-node-path', path);
            
            // 创建标题区域
            const headerDiv = document.createElement('div');
            headerDiv.style.cssText = 'display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;';
            
            const labelEl = document.createElement('label');
            labelEl.innerHTML = `<code>${path}</code>`;
            labelEl.style.cssText = 'margin: 0; font-weight: 600; color: #374151; font-size: 12px;';
            
            // 删除按钮（小尺寸）
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'btn btn-sm btn-danger';
            deleteBtn.innerHTML = '<i class="fas fa-times"></i>';
            deleteBtn.title = '删除此字段';
            deleteBtn.style.cssText = 'padding: 2px 6px; font-size: 10px;';
            deleteBtn.onclick = () => deleteNode(path, group);
            
            headerDiv.appendChild(labelEl);
            headerDiv.appendChild(deleteBtn);
            
            const isLongText = typeof value === 'string' && value.length > 50;
            const input = document.createElement(isLongText ? 'textarea' : 'input');
            
            if (input.tagName === 'TEXTAREA') {
                input.rows = 3;
                // 只有包含 'content' 的字段才使用Summernote
                const needsSummernote = path.toLowerCase().includes('content');
                input.className = needsSummernote ? 'form-control summernote-textarea' : 'form-control';
                // 为textarea添加唯一ID
                const uniqueId = 'textarea_' + path.replace(/\./g, '_') + '_' + Math.random().toString(36).substr(2, 9);
                input.id = uniqueId;
                
                // 只对包含content的字段标记需要Summernote
                if (needsSummernote) {
                    input.setAttribute('data-needs-summernote', 'true');
                }
            } else {
                input.type = 'text';
                input.className = 'form-control';
            }
            
            input.value = String(value || '');
            input.setAttribute('data-path', path);
            
            if (input.tagName !== 'TEXTAREA') {
                input.style.cssText = 'width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;';
            } else if (!input.hasAttribute('data-needs-summernote')) {
                // 普通textarea的样式
                input.style.cssText = 'width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; resize: vertical;';
            }
            
            group.appendChild(headerDiv);
            group.appendChild(input);
            
            return group;
        }
        
        // 创建数组编辑组
        function createArrayGroup(label, path, array) {
            const group = document.createElement('div');
            group.style.cssText = 'margin-bottom: 20px; padding: 15px; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb;';
            
            const labelEl = document.createElement('label');
            labelEl.innerHTML = `<i class="fas fa-list"></i> <code>${path}</code>`;
            labelEl.style.cssText = 'display: block; margin-bottom: 10px; font-weight: 600; color: #374151;';
            
            const itemsContainer = document.createElement('div');
            itemsContainer.id = `array-${path.replace(/\./g, '-')}`;
            
            // 现有数组项
            array.forEach((item, index) => {
                const itemPath = `${path}.${index}`;
                if (typeof item === 'object') {
                    const objectItem = createObjectGroup(`[${index}]`, itemPath, item);
                    itemsContainer.appendChild(objectItem);
                } else {
                    const itemElement = createArrayItem(path, index, item);
                    itemsContainer.appendChild(itemElement);
                }
            });
            
            // 添加新项按钮
            const addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.className = 'btn btn-sm btn-outline';
            addBtn.innerHTML = '<i class="fas fa-plus"></i> 添加项目';
            addBtn.style.cssText = 'margin-top: 10px;';
            addBtn.onclick = () => addArrayItem(path, itemsContainer);
            
            group.appendChild(labelEl);
            group.appendChild(itemsContainer);
            group.appendChild(addBtn);
            
            return group;
        }
        
        // 创建对象编辑组
        function createObjectGroup(label, path, obj, isRoot = false) {
            const group = document.createElement('div');
            group.style.cssText = 'margin-bottom: 20px; padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; background: white; position: relative;';
            group.setAttribute('data-node-path', path);
            
            // 创建标题区域
            const headerDiv = document.createElement('div');
            headerDiv.style.cssText = 'display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px;';
            
            const labelEl = document.createElement('h5');
            labelEl.innerHTML = `<i class="fas fa-folder"></i> ${label}`;
            labelEl.style.cssText = 'margin: 0; color: #374151;';
            
            // 创建操作按钮组
            const actionsDiv = document.createElement('div');
            actionsDiv.style.cssText = 'display: flex; gap: 5px;';
            
            // 添加子节点按钮
            const addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.className = 'btn btn-sm btn-success';
            addBtn.innerHTML = '<i class="fas fa-plus"></i>';
            addBtn.title = '添加子节点';
            addBtn.onclick = () => addNewNode(path);
            
            // 删除节点按钮（根节点不允许删除）
            if (!isRoot) {
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'btn btn-sm btn-danger';
                deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
                deleteBtn.title = '删除此节点';
                deleteBtn.onclick = () => deleteNode(path, group);
                actionsDiv.appendChild(deleteBtn);
            }
            
            actionsDiv.appendChild(addBtn);
            
            headerDiv.appendChild(labelEl);
            headerDiv.appendChild(actionsDiv);
            
            const objectContainer = document.createElement('div');
            objectContainer.className = 'object-content';
            generateFormForObject(obj, objectContainer, path, false);
            
            group.appendChild(headerDiv);
            group.appendChild(objectContainer);
            
            return group;
        }
        
        // 创建数组项
        function createArrayItem(arrayPath, index, value) {
            const item = document.createElement('div');
            item.style.cssText = 'display: flex; gap: 10px; align-items: center; margin-bottom: 10px;';
            
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.value = String(value);
            input.setAttribute('data-path', `${arrayPath}.${index}`);
            input.style.cssText = 'flex: 1; padding: 6px 10px; border: 1px solid #d1d5db; border-radius: 4px;';
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
            removeBtn.onclick = () => item.remove();
            
            item.appendChild(input);
            item.appendChild(removeBtn);
            
            return item;
        }
        
        // 添加数组项
        function addArrayItem(arrayPath, container) {
            const existingItems = container.querySelectorAll(`input[data-path^="${arrayPath}."]`);
            const newIndex = existingItems.length;
            
            const newItem = createArrayItem(arrayPath, newIndex, '');
            container.appendChild(newItem);
        }
        
        // 应用节点更改
        function applyNodeChanges() {
            try {
                // 先同步所有Summernote的内容到对应的textarea
                summernoteInstances.forEach(function(instanceId) {
                    try {
                        if ($('#' + instanceId).length) {
                            const summernoteContent = $('#' + instanceId).summernote('code');
                            document.getElementById(instanceId).value = summernoteContent;
                        }
                    } catch (error) {
                        console.warn('Failed to sync Summernote content:', instanceId, error);
                    }
                });
                
                // 收集所有表单数据
                const inputs = document.querySelectorAll('#nodeEditorContent input, #nodeEditorContent textarea');
                const newData = {};
                
                // 重新构建数据结构
                inputs.forEach(input => {
                    const path = input.getAttribute('data-path');
                    let value = input.value;
                    
                    // 对于Summernote编辑器，获取HTML内容
                    if (input.classList.contains('summernote-textarea')) {
                        try {
                            if ($('#' + input.id).length) {
                                value = $('#' + input.id).summernote('code');
                            }
                        } catch (error) {
                            console.warn('Failed to get Summernote content:', input.id, error);
                        }
                    }
                    
                    if (path && value !== '') {
                        setNestedValue(newData, path, value);
                    }
                });
                
                // 处理数组结构
                convertObjectsToArrays(newData);
                
                // 更新编辑器内容
                const jsonString = JSON.stringify(newData, null, 2);
                editor.setValue(jsonString, -1);
                
                // 关闭模态框
                closeNodeEditor();
                
                alert('节点更改已应用到JSON编辑器');
                
            } catch (error) {
                alert('应用更改失败: ' + error.message);
            }
        }
        
        // 设置嵌套对象值
        function setNestedValue(obj, path, value) {
            const keys = path.split('.');
            let current = obj;
            
            for (let i = 0; i < keys.length - 1; i++) {
                const key = keys[i];
                if (!current[key]) {
                    current[key] = {};
                }
                current = current[key];
            }
            
            const lastKey = keys[keys.length - 1];
            current[lastKey] = value;
        }
        
        // 将数字键的对象转换为数组
        function convertObjectsToArrays(obj) {
            Object.keys(obj).forEach(key => {
                const value = obj[key];
                if (typeof value === 'object' && value !== null) {
                    const keys = Object.keys(value);
                    const isArray = keys.every(k => !isNaN(parseInt(k)));
                    
                    if (isArray && keys.length > 0) {
                        // 转换为数组
                        const array = [];
                        keys.sort((a, b) => parseInt(a) - parseInt(b)).forEach(k => {
                            array.push(value[k]);
                        });
                        obj[key] = array;
                    } else {
                        // 递归处理子对象
                        convertObjectsToArrays(value);
                    }
                }
            });
        }
        
        // 动态加载Summernote备用方案
        function loadSummernoteBackup() {
            console.log('Loading Summernote and CodeMirror backup CDN...');
            
            let loadedCount = 0;
            const totalScripts = 4;
            
            function checkAllLoaded() {
                loadedCount++;
                if (loadedCount === totalScripts) {
                    console.log('All backup dependencies loaded successfully');
                    setTimeout(() => {
                        if (needsSummernote()) {
                            initializeAllSummernoteEditors();
                        }
                    }, 200);
                }
            }
            
            // CodeMirror CSS
            const codeMirrorCSS = document.createElement('link');
            codeMirrorCSS.rel = 'stylesheet';
            codeMirrorCSS.href = 'https://unpkg.com/codemirror@5.65.2/lib/codemirror.css';
            document.head.appendChild(codeMirrorCSS);
            
            // CodeMirror JS
            const codeMirrorJS = document.createElement('script');
            codeMirrorJS.src = 'https://unpkg.com/codemirror@5.65.2/lib/codemirror.js';
            codeMirrorJS.onload = checkAllLoaded;
            document.head.appendChild(codeMirrorJS);
            
            // CodeMirror HTML Mode
            const htmlModeJS = document.createElement('script');
            htmlModeJS.src = 'https://unpkg.com/codemirror@5.65.2/mode/htmlmixed/htmlmixed.js';
            htmlModeJS.onload = checkAllLoaded;
            document.head.appendChild(htmlModeJS);
            
            // CodeMirror XML Mode (dependency for HTML mode)
            const xmlModeJS = document.createElement('script');
            xmlModeJS.src = 'https://unpkg.com/codemirror@5.65.2/mode/xml/xml.js';
            xmlModeJS.onload = checkAllLoaded;
            document.head.appendChild(xmlModeJS);
            
            // Summernote CSS
            const summernoteCSS = document.createElement('link');
            summernoteCSS.rel = 'stylesheet';
            summernoteCSS.href = 'https://unpkg.com/summernote@0.8.20/dist/summernote-bs5.min.css';
            document.head.appendChild(summernoteCSS);
            
            // Summernote JS (最后加载)
            const summernoteJS = document.createElement('script');
            summernoteJS.src = 'https://unpkg.com/summernote@0.8.20/dist/summernote-bs5.min.js';
            summernoteJS.onload = checkAllLoaded;
            summernoteJS.onerror = function() {
                console.error('Failed to load Summernote backup');
            };
            document.head.appendChild(summernoteJS);
        }
        
        // 页面加载完成后的初始化检查
        $(document).ready(function() {
            console.log('Document ready, jQuery loaded:', typeof jQuery !== 'undefined');
            console.log('Summernote loaded:', typeof $.fn.summernote !== 'undefined');
            console.log('Note: Summernote will be loaded on-demand when opening node editor with content fields');
        });
        
        // 添加新节点
        function addNewNode(parentPath) {
            const nodeName = prompt('请输入新节点的名称:', '');
            if (!nodeName) return;
            
            // 验证节点名称
            if (!/^[a-zA-Z_][a-zA-Z0-9_]*$/.test(nodeName)) {
                alert('节点名称只能包含字母、数字和下划线，且必须以字母或下划线开头');
                return;
            }
            
            const nodeType = prompt('请选择节点类型:\n1. 文本 (输入: text)\n2. 对象 (输入: object)\n3. 数组 (输入: array)', 'text');
            
            const newPath = parentPath ? `${parentPath}.${nodeName}` : nodeName;
            
            // 检查是否已存在
            const existingInput = document.querySelector(`[data-path="${newPath}"]`);
            if (existingInput) {
                alert('此节点名称已存在，请使用不同的名称');
                return;
            }
            
            let newValue;
            let newElement;
            
            switch (nodeType) {
                case 'text':
                    newValue = '';
                    newElement = createUniversalInputGroup(nodeName, newPath, newValue);
                    break;
                case 'object':
                    newValue = {};
                    newElement = createObjectGroup(nodeName, newPath, newValue, false);
                    break;
                case 'array':
                    newValue = [];
                    newElement = createArrayGroup(nodeName, newPath, newValue);
                    break;
                default:
                    alert('无效的节点类型');
                    return;
            }
            
            // 找到父容器并添加新元素
            const parentContainer = findContainerByPath(parentPath);
            if (parentContainer) {
                parentContainer.appendChild(newElement);
                
                // 如果是新添加的textarea且包含content，初始化Summernote
                if (nodeType === 'text' && nodeName.toLowerCase().includes('content')) {
                    setTimeout(() => {
                        const textarea = newElement.querySelector('textarea[data-needs-summernote="true"]');
                        if (textarea && textarea.id) {
                            initializeSummernote(textarea.id);
                        }
                    }, 100);
                }
                
                console.log('Added new node:', newPath, 'Type:', nodeType);
            } else {
                alert('无法找到父容器');
            }
        }
        
        // 删除节点
        function deleteNode(nodePath, nodeElement) {
            const nodeName = nodePath.split('.').pop();
            
            if (confirm(`确定要删除节点 "${nodeName}" 及其所有子节点吗？\n\n此操作不可撤销！`)) {
                // 销毁此节点下的所有Summernote实例
                const textareas = nodeElement.querySelectorAll('.summernote-textarea');
                textareas.forEach(textarea => {
                    if (textarea.id && summernoteInstances.includes(textarea.id)) {
                        try {
                            if (typeof jQuery !== 'undefined' && $('#' + textarea.id).length) {
                                $('#' + textarea.id).summernote('destroy');
                            }
                            summernoteInstances = summernoteInstances.filter(id => id !== textarea.id);
                        } catch (error) {
                            console.warn('Error destroying Summernote instance:', error);
                        }
                    }
                });
                
                // 从DOM中移除元素
                nodeElement.remove();
                
                console.log('Deleted node:', nodePath);
            }
        }
        
        // 根据路径查找容器
        function findContainerByPath(path) {
            if (!path) {
                // 根路径，返回主容器
                return document.getElementById('nodeEditorContent');
            }
            
            // 查找对应路径的对象容器
            const objectGroup = document.querySelector(`[data-node-path="${path}"] .object-content`);
            if (objectGroup) {
                return objectGroup;
            }
            
            // 如果找不到，返回主容器
            return document.getElementById('nodeEditorContent');
        }
    </script>
</body>
</html>