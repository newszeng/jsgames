<?php
// 这个文件被 website_pages.php 包含，$domain 变量已经可用
require_once __DIR__ . '/lib/translate_helper_chatgpt.php';

$i18n_dir = "../i18n/{$domain}";
$languages = [];
$current_lang = $_GET['lang'] ?? 'en';

// 获取语言列表
if (is_dir($i18n_dir)) {
    $files = scandir($i18n_dir);
    foreach ($files as $file) {
        if (preg_match('/^([a-z]{2})\.json$/', $file, $matches)) {
            $languages[] = $matches[1];
        }
    }
}

// 如果没有语言文件，创建默认的
if (empty($languages)) {
    $languages = ['en'];
    @mkdir($i18n_dir, 0777, true);
    $default_content = [
    ];
    file_put_contents("{$i18n_dir}/en.json", json_encode($default_content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// 读取当前语言文件
$lang_file = "{$i18n_dir}/{$current_lang}.json";
$json_content = '';
$error = '';
$success = '';

if (file_exists($lang_file)) {
    $json_content = file_get_contents($lang_file);
} else {
    // 如果文件不存在，创建一个基于英文的副本
    $en_file = "{$i18n_dir}/en.json";
    if (file_exists($en_file)) {
        $json_content = file_get_contents($en_file);
    } else {
        $json_content = json_encode($default_content ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    file_put_contents($lang_file, $json_content);
}

// 处理删除语言包
if (isset($_GET['delete_lang'])) {
    $lang_to_delete = $_GET['delete_lang'];
    
    // 不能删除英文语言包
    if ($lang_to_delete == 'en') {
        $error = '无法删除默认的英文语言包';
    } elseif (in_array($lang_to_delete, $languages)) {
        $file_to_delete = "{$i18n_dir}/{$lang_to_delete}.json";
        
        if (file_exists($file_to_delete)) {
            unlink($file_to_delete);
            $success = "语言包 '{$lang_to_delete}' 删除成功";
            
            // 重新获取语言列表
            $languages = [];
            if (is_dir($i18n_dir)) {
                $files = scandir($i18n_dir);
                foreach ($files as $file) {
                    if (preg_match('/^([a-z]{2})\.json$/', $file, $matches)) {
                        $languages[] = $matches[1];
                    }
                }
            }
            
            // 如果当前语言被删除，切换到英文
            if ($current_lang == $lang_to_delete) {
                $current_lang = 'en';
                echo "<script>window.location.href='website_pages.php?domain={$domain}&act=homepage&lang=en&deleted=1';</script>";
                exit();
            }
        } else {
            $error = "语言文件未找到";
        }
    } else {
        $error = "语言包未找到";
    }
}

// 处理一键翻译所有语言请求
if (isset($_GET['translate_all']) || isset($_GET['translate_remaining'])) {
    $source_lang = isset($_GET['translate_all']) ? $_GET['translate_all'] : $_GET['translate_remaining'];
    $translate_mode = isset($_GET['translate_all']) ? 'all' : 'remaining';
    
    // 读取源语言文件
    $source_file = "{$i18n_dir}/{$source_lang}.json";
    if (!file_exists($source_file)) {
        $error = "源语言文件未找到";
    } else {
        $source_content = file_get_contents($source_file);
        $source_array = json_decode($source_content, true);
        
        if (!$source_array) {
            $error = "源语言文件格式错误";
        } else {
            // 获取所有支持的语言
            $all_languages = getSupportedLanguages();
            $target_languages = [];
            
            foreach ($all_languages as $code => $name) {
                if ($code !== $source_lang && $code !== 'en') { // 跳过源语言和英语
                    if ($translate_mode === 'all') {
                        // 翻译所有语言
                        $target_languages[] = $code;
                    } else {
                        // 只翻译剩余（不存在翻译文件的）语言
                        $target_file = "{$i18n_dir}/{$code}.json";
                        if (!file_exists($target_file)) {
                            $target_languages[] = $code;
                        }
                    }
                }
            }
            
            // 检查是否有需要翻译的语言
            if (empty($target_languages)) {
                echo '<!DOCTYPE html><html><head><title>翻译完成</title></head><body>';
                echo '<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border: 2px solid #28a745; border-radius: 10px; text-align: center;">';
                echo '<h3><i class="fas fa-check-circle" style="color: #28a745;"></i> 所有语言都已翻译完成！</h3>';
                echo '<p>没有需要翻译的剩余语言。</p>';
                echo '<button onclick="window.location.href=\'website_pages.php?domain=' . $domain . '&act=homepage&lang=' . $source_lang . '\'" class="btn btn-primary">返回</button>';
                echo '</div></body></html>';
                exit();
            }
            
            // 开始AJAX翻译流程
            $mode_title = $translate_mode === 'all' ? '一键翻译全部' : '翻译剩余语言';
            echo '<!DOCTYPE html><html><head><title>翻译进行中</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></head><body>';
            echo '<div id="translation-progress" style="position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); background: white; padding: 30px; border: 2px solid #007cba; border-radius: 10px; z-index: 9999; box-shadow: 0 0 20px rgba(0,0,0,0.3); min-width: 400px; max-height: 60vh; overflow-y: auto;">';
            echo '<h3><i class="fas fa-language"></i> ' . $mode_title . '进行中...</h3>';
            echo '<div id="progress-info">准备翻译到 ' . count($target_languages) . ' 种语言</div>';
            echo '<div style="margin: 20px 0;"><div id="progress-bar" style="width: 100%; background: #f0f0f0; border-radius: 10px; overflow: hidden;"><div id="progress-fill" style="width: 0%; height: 30px; background: linear-gradient(45deg, #007cba, #00a0d2); transition: width 0.3s;"></div></div></div>';
            echo '<div id="current-lang">等待开始...</div>';
            echo '<div id="remaining-count">剩余: ' . count($target_languages) . ' 种语言</div>';
            echo '</div>';
            
            echo '<script>
            let languages = ' . json_encode($target_languages) . ';
            let currentIndex = 0;
            let totalLanguages = languages.length;
            let sourceLang = "' . $source_lang . '";
            
            function translateNext() {
                if (currentIndex >= languages.length) {
                    document.getElementById("current-lang").innerHTML = "✅ 翻译完成！";
                    document.getElementById("remaining-count").innerHTML = "所有语言翻译完成";
                    setTimeout(function() {
                        window.location.href = "website_pages.php?domain=' . $domain . '&act=homepage&lang=' . $source_lang . '&translated_all=1";
                    }, 2000);
                    return;
                }
                
                let targetLang = languages[currentIndex];
                let progress = Math.round(((currentIndex) / totalLanguages) * 100);
                let remaining = totalLanguages - currentIndex;
                
                document.getElementById("progress-fill").style.width = progress + "%";
                document.getElementById("current-lang").innerHTML = "🔄 正在翻译: " + targetLang.toUpperCase();
                document.getElementById("remaining-count").innerHTML = "剩余: " + remaining + " 种语言";
                
                // 发送AJAX请求
                fetch("website_pages.php?domain=' . $domain . '&act=homepage&ajax_translate=1&source_lang=" + sourceLang + "&target_lang=" + targetLang)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("current-lang").innerHTML = "✅ 完成: " + targetLang.toUpperCase();
                    } else {
                        document.getElementById("current-lang").innerHTML = "❌ 失败: " + targetLang.toUpperCase() + " - " + data.error;
                    }
                    
                    currentIndex++;
                    setTimeout(translateNext, 1000); // 等待1秒再翻译下一个
                })
                .catch(error => {
                    document.getElementById("current-lang").innerHTML = "❌ 错误: " + targetLang.toUpperCase() + " - " + error;
                    currentIndex++;
                    setTimeout(translateNext, 1000);
                });
            }
            
            // 开始翻译
            setTimeout(translateNext, 1000);
            </script></body></html>';
            
            exit();
        }
    }
}

// 处理AJAX翻译请求
if (isset($_GET['ajax_translate'])) {
    $source_lang = $_GET['source_lang'];
    $target_lang = $_GET['target_lang'];
    
    header('Content-Type: application/json');
    
    $source_file = "{$i18n_dir}/{$source_lang}.json";
    if (!file_exists($source_file)) {
        echo json_encode(['success' => false, 'error' => '源文件不存在']);
        exit();
    }
    
    $source_content = file_get_contents($source_file);
    $source_array = json_decode($source_content, true);
    
    if (!$source_array) {
        echo json_encode(['success' => false, 'error' => '源文件格式错误']);
        exit();
    }
    
    try {
        // 执行翻译 - 使用ChatGPT一次性翻译
        $translated_array = translateJsonWithChatGPT($source_array, $target_lang, 'English');
        
        // 如果一次性翻译失败，降级到分批翻译
        if (!$translated_array) {
            $translated_array = translateJsonContentWithChatGPT($source_array, $source_lang, $target_lang);
        }
        
        if ($translated_array) {
            // 保存翻译后的内容
            $target_file = "{$i18n_dir}/{$target_lang}.json";
            file_put_contents($target_file, json_encode($translated_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => '翻译返回空结果']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    
    exit();
}

// 处理更新路由请求
if (isset($_GET['update_router'])) {
    header('Content-Type: application/json');
    
    try {
        // 获取当前所有语言
        $available_languages = [];
        if (is_dir($i18n_dir)) {
            $files = scandir($i18n_dir);
            foreach ($files as $file) {
                if (preg_match('/^([a-z]{2})\.json$/', $file, $matches)) {
                    $available_languages[] = $matches[1];
                }
            }
        }
        
        // 读取router.json文件
        $router_file = "../router/{$domain}/router.json";
        if (!file_exists($router_file)) {
            echo json_encode(['success' => false, 'error' => 'router.json文件不存在']);
            exit();
        }
        
        $router_content = file_get_contents($router_file);
        $router_data = json_decode($router_content, true);
        
        if (!$router_data) {
            echo json_encode(['success' => false, 'error' => 'router.json格式错误']);
            exit();
        }
        
        // 更新languages数组
        $router_data['languages'] = $available_languages;
        
        // 保存更新后的router.json
        $updated_content = json_encode($router_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($router_file, $updated_content);
        
        echo json_encode([
            'success' => true, 
            'languages' => $available_languages,
            'message' => '路由文件已更新，支持 ' . count($available_languages) . ' 种语言'
        ]);
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    
    exit();
}

// 处理翻译请求
if (isset($_GET['translate']) && isset($_GET['target_lang'])) {
    $source_lang = $_GET['translate'];
    $target_lang = $_GET['target_lang'];
    
    // 读取源语言文件
    $source_file = "{$i18n_dir}/{$source_lang}.json";
    if (file_exists($source_file)) {
        $source_content = file_get_contents($source_file);
        $source_array = json_decode($source_content, true);
        
        if ($source_array) {
            try {
                // 执行翻译 - 使用ChatGPT一次性翻译
                $translated_array = translateJsonWithChatGPT($source_array, $target_lang, 'English');
                
                // 如果一次性翻译失败，降级到分批翻译
                if (!$translated_array) {
                    $translated_array = translateJsonContentWithChatGPT($source_array, $source_lang, $target_lang);
                }
                
                // 保存翻译后的内容
                $target_file = "{$i18n_dir}/{$target_lang}.json";
                file_put_contents($target_file, json_encode($translated_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                
                $success = "成功将 " . strtoupper($source_lang) . " 翻译为 " . strtoupper($target_lang);
                
                // 使用JavaScript重定向
                echo "<script>window.location.href='website_pages.php?domain={$domain}&act=homepage&lang={$target_lang}&translated=1';</script>";
                exit();
            } catch (Exception $e) {
                $error = "翻译失败: " . $e->getMessage();
            }
        } else {
            $error = "源语言文件格式错误";
        }
    } else {
        $error = "源语言文件不存在";
    }
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json_content'])) {
    $new_content = $_POST['json_content'];
    
    // 验证 JSON 格式
    $test_decode = json_decode($new_content, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        // JSON 格式正确，保存文件
        file_put_contents($lang_file, $new_content);
        $json_content = $new_content;
        $success = '内容更新成功';
    } else {
        // JSON 格式错误
        $error = 'JSON格式错误: ' . json_last_error_msg();
        $json_content = $new_content; // 保留用户输入以便修正
    }
}

// 检查是否有删除成功的提示
if (isset($_GET['deleted'])) {
    $success = '语言包删除成功';
}

// 检查是否有翻译成功的提示
if (isset($_GET['translated'])) {
    $success = '翻译完成';
}
?>

<div class="form-section">
    <h4>首页内容管理 - JSON编辑器</h4>
    
    <?php if ($error): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
    </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
    </div>
    <?php endif; ?>
    
    <div class="mb-3">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-language"></i> 语言管理</label>
                <div class="input-group">
                    <select class="form-select" id="languageSelector" onchange="changeLanguage(this.value)">
                        <?php 
                        $language_names = getSupportedLanguages();
                        foreach ($languages as $lang): 
                            $lang_name = $language_names[$lang] ?? strtoupper($lang);
                        ?>
                        <option value="<?php echo $lang; ?>" <?php echo $current_lang == $lang ? 'selected' : ''; ?>>
                            <?php echo $lang_name; ?> (<?php echo strtoupper($lang); ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-outline-success" type="button" onclick="addLanguage()">
                        <i class="fas fa-plus"></i> 添加
                    </button>
                    <?php if ($current_lang != 'en'): ?>
                    <button class="btn btn-outline-danger" type="button" onclick="deleteLanguage('<?php echo $current_lang; ?>')">
                        <i class="fas fa-trash"></i> 删除
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-info-circle"></i> 语言统计</label>
                <div class="p-2 bg-light rounded">
                    <small>
                        当前支持 <strong><?php echo count($languages); ?></strong> 种语言
                        <?php if (count($languages) < 39): ?>
                        <span class="text-muted">（可支持最多38种语言）</span>
                        <?php endif; ?>
                    </small>
                </div>
                <?php if ($current_lang == 'en'): ?>
                <div class="mt-2">
                    <button type="button" class="btn btn-warning btn-sm" onclick="showTranslateModal()">
                        <i class="fas fa-language"></i> 一键翻译
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="updateRouter()">
                        <i class="fas fa-route"></i> 更新路由
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-text mt-2">
            <i class="fas fa-info-circle"></i> 
            英文 (EN) 是默认语言，不能删除。从下拉菜单选择语言进行编辑。
        </div>
    </div>
    
    <form method="post" onsubmit="return validateJSON()">
        <div class="mb-3">
            <label class="form-label">
                <i class="fas fa-code"></i> JSON内容 
                <span class="text-muted">(File: i18n/<?php echo $domain; ?>/<?php echo $current_lang; ?>.json)</span>
            </label>
            <div id="json-editor" style="height: 600px; border: 1px solid #ddd;"><?php echo htmlspecialchars($json_content); ?></div>
            <textarea name="json_content" id="json_content" style="display: none;"></textarea>
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button type="button" class="btn btn-secondary" onclick="formatJSON()">
                    <i class="fas fa-magic"></i> 格式化JSON
                </button>
                <button type="button" class="btn btn-info" onclick="validateJSONOnly()">
                    <i class="fas fa-check"></i> 验证JSON
                </button>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 保存更改
            </button>
        </div>
    </form>
    
    <!-- Prompt 提示词区域 -->
    <div class="mt-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-robot"></i> SEO文案生成提示词
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="prompt-textarea" class="form-label">
                        <i class="fas fa-magic"></i> 复制此提示词到ChatGPT生成SEO文案
                    </label>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-template"></i> 提示词模板</span>
                                <select id="prompt-template" class="form-select" onchange="onTemplateChange()">
                                    <option value="">-- 请选择模板 --</option>
                                </select>
                                <a href="prompt.php" class="btn btn-outline-info" target="_blank">
                                    <i class="fas fa-cog"></i> 管理
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i> 主关键词</span>
                                <input type="text" id="main-keyword" class="form-control" placeholder="输入主关键词...">
                                <button type="button" class="btn btn-outline-secondary" onclick="updateKeywordFromJSON()">
                                    <i class="fas fa-sync"></i> 从JSON获取
                                </button>
                            </div>
                            <small class="text-muted">选择模板和填写关键词后点击"生成提示词"</small>
                        </div>
                    </div>
                    <textarea id="prompt-textarea" class="form-control" rows="15" placeholder="请先选择提示词模板和填写主关键词，然后点击"生成提示词"按钮"></textarea>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="generatePrompt(event)">
                            <i class="fas fa-sync"></i> 生成提示词
                        </button>
                        <button type="button" class="btn btn-success" onclick="copyPrompt()">
                            <i class="fas fa-copy"></i> 复制提示词
                        </button>
                    </div>
                    <small class="text-muted">基于当前JSON内容自动生成</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ACE Editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.22.0/ace.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.22.0/mode-json.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.22.0/theme-monokai.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.22.0/ext-language_tools.min.js"></script>

<script>
// Initialize ACE editor
var editor = ace.edit("json-editor");
editor.setTheme("ace/theme/monokai");
editor.session.setMode("ace/mode/json");
editor.setOptions({
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true,
    showLineNumbers: true,
    tabSize: 2,
    useSoftTabs: true,
    wrap: true,
    showPrintMargin: false,
    fontSize: 14
});

// Validate JSON only (without saving)
function validateJSONOnly() {
    const content = editor.getValue();
    try {
        JSON.parse(content);
        alert('✅ JSON格式有效！');
    } catch (e) {
        alert('❌ JSON错误：' + e.message);
        
        // Try to highlight the error line
        const match = e.message.match(/position (\d+)/);
        if (match) {
            const position = parseInt(match[1]);
            const lines = content.substring(0, position).split('\n');
            const errorLine = lines.length;
            editor.gotoLine(errorLine);
        }
    }
}

// Format JSON
function formatJSON() {
    try {
        const content = editor.getValue();
        const parsed = JSON.parse(content);
        const formatted = JSON.stringify(parsed, null, 2);
        editor.setValue(formatted);
        editor.clearSelection();
    } catch (e) {
        alert('无法格式化：JSON格式无效\n' + e.message);
    }
}

// Change language
function changeLanguage(lang) {
    window.location.href = 'website_pages.php?domain=<?php echo $domain; ?>&act=homepage&lang=' + lang;
}

// Validate JSON before submitting
function validateJSON() {
    const content = editor.getValue();
    document.getElementById('json_content').value = content;
    
    try {
        JSON.parse(content);
        return true;
    } catch (e) {
        alert('❌ 无法保存：JSON格式无效\n\n错误：' + e.message);
        return false;
    }
}

// Add new language
function addLanguage() {
    // 获取所有支持的语言
    const allLanguages = <?php echo json_encode(getSupportedLanguages()); ?>;
    const existingLanguages = <?php echo json_encode($languages); ?>;
    
    // 过滤出未添加的语言
    const availableLanguages = {};
    for (const [code, name] of Object.entries(allLanguages)) {
        if (!existingLanguages.includes(code)) {
            availableLanguages[code] = name;
        }
    }
    
    if (Object.keys(availableLanguages).length === 0) {
        alert('所有支持的语言都已添加！');
        return;
    }
    
    // 创建选择列表
    let options = '请选择要添加的语言：\n\n';
    const codes = Object.keys(availableLanguages);
    codes.forEach((code, index) => {
        options += `${index + 1}. ${availableLanguages[code]} (${code})\n`;
    });
    
    const choice = prompt(options + '\n请输入序号或语言代码：');
    
    let lang = null;
    if (choice) {
        // 检查是否输入了序号
        const index = parseInt(choice) - 1;
        if (index >= 0 && index < codes.length) {
            lang = codes[index];
        } else if (/^[a-z]{2}$/.test(choice) && availableLanguages[choice]) {
            lang = choice;
        }
    }
    
    if (lang) {
        // Create new language file based on current content
        const currentContent = editor.getValue();
        
        // Navigate to new language with content
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'website_pages.php?domain=<?php echo $domain; ?>&act=homepage&lang=' + lang;
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'json_content';
        input.value = currentContent;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    } else if (lang) {
        alert('语言代码无效。请使用两个小写字母 (例如: en, fr, es)');
    }
}

// Delete language pack
function deleteLanguage(lang) {
    if (lang === 'en') {
        alert('❌ 无法删除默认的英文语言包');
        return;
    }
    
    const allLanguages = <?php echo json_encode(getSupportedLanguages()); ?>;
    const langName = allLanguages[lang] || lang.toUpperCase();
    
    if (confirm(`🗑️ 删除 ${langName} (${lang.toUpperCase()}) 语言包？\n\n此操作无法撤销。JSON文件将被永久删除。`)) {
        // Show loading state
        const deleteBtn = event.target.closest('button');
        const originalHtml = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        deleteBtn.disabled = true;
        
        // Navigate to delete URL
        window.location.href = `website_pages.php?domain=<?php echo $domain; ?>&act=homepage&delete_lang=${lang}`;
    }
}

// Add keyboard shortcut for saving (Ctrl+S)
editor.commands.addCommand({
    name: 'save',
    bindKey: {win: 'Ctrl-S', mac: 'Command-S'},
    exec: function(editor) {
        if (validateJSON()) {
            document.querySelector('form').submit();
        }
    }
});

// Show JSON validation status in real-time
let validationTimeout;
editor.on('change', function() {
    clearTimeout(validationTimeout);
    validationTimeout = setTimeout(function() {
        try {
            JSON.parse(editor.getValue());
            editor.session.clearAnnotations();
        } catch (e) {
            const match = e.message.match(/position (\d+)/);
            if (match) {
                const position = parseInt(match[1]);
                const lines = editor.getValue().substring(0, position).split('\n');
                const errorLine = lines.length - 1;
                
                editor.session.setAnnotations([{
                    row: errorLine,
                    column: 0,
                    text: e.message,
                    type: "error"
                }]);
            }
        }
    }, 500);
});

// 显示翻译模态框
function showTranslateModal() {
    const modal = document.getElementById('translateModal');
    if (modal) {
        modal.style.display = 'block';
    }
}

// 关闭模态框
function closeTranslateModal() {
    const modal = document.getElementById('translateModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// 执行翻译
function doTranslate() {
    const targetLang = document.getElementById('targetLanguage').value;
    if (!targetLang) {
        alert('请选择目标语言');
        return;
    }
    
    // 验证当前JSON内容
    try {
        JSON.parse(editor.getValue());
    } catch (e) {
        alert('当前JSON格式无效，请先修正');
        return;
    }
    
    // 先保存当前内容
    document.getElementById('json_content').value = editor.getValue();
    
    // 显示加载提示
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 翻译中...';
    btn.disabled = true;
    
    // 跳转到翻译URL
    window.location.href = 'website_pages.php?domain=<?php echo $domain; ?>&act=homepage&translate=<?php echo $current_lang; ?>&target_lang=' + targetLang;
}

// 执行一键翻译所有语言
function doTranslateAll() {
    // 验证当前JSON内容
    try {
        JSON.parse(editor.getValue());
    } catch (e) {
        alert('当前JSON格式无效，请先修正');
        return;
    }
    
    if (!confirm('确定要将当前内容翻译到所有38种语言吗？这可能需要较长时间（约5-10分钟）。')) {
        return;
    }
    
    // 先保存当前内容
    document.getElementById('json_content').value = editor.getValue();
    
    const btn = event.target;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 准备翻译...';
    btn.disabled = true;
    
    // 跳转到一键翻译URL
    window.location.href = 'website_pages.php?domain=<?php echo $domain; ?>&act=homepage&translate_all=<?php echo $current_lang; ?>';
}

// 执行翻译剩余语言
function doTranslateRemaining() {
    // 验证当前JSON内容
    try {
        JSON.parse(editor.getValue());
    } catch (e) {
        alert('当前JSON格式无效，请先修正');
        return;
    }
    
    if (!confirm('确定要翻译剩余的语言吗？系统会自动检测哪些语言还没有翻译文件。')) {
        return;
    }
    
    // 先保存当前内容
    document.getElementById('json_content').value = editor.getValue();
    
    const btn = event.target;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 检测剩余语言...';
    btn.disabled = true;
    
    // 跳转到翻译剩余语言URL
    window.location.href = 'website_pages.php?domain=<?php echo $domain; ?>&act=homepage&translate_remaining=<?php echo $current_lang; ?>';
}

// 更新路由配置
function updateRouter() {
    if (!confirm('确定要更新路由配置吗？系统会根据当前的语言文件自动更新router.json中的支持语言列表。')) {
        return;
    }
    
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 更新中...';
    btn.disabled = true;
    
    // 发送AJAX请求更新路由
    fetch('website_pages.php?domain=<?php echo $domain; ?>&act=homepage&update_router=1')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message + '\n\n支持的语言: ' + data.languages.join(', '));
        } else {
            alert('❌ 更新失败: ' + data.error);
        }
        
        btn.innerHTML = originalText;
        btn.disabled = false;
    })
    .catch(error => {
        alert('❌ 请求失败: ' + error);
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

// 生成提示词
async function generatePrompt(event) {
    try {
        // 检查是否选择了模板
        const templateSelect = document.getElementById('prompt-template');
        const selectedTemplateId = templateSelect.value;
        
        if (!selectedTemplateId) {
            alert('请先选择一个提示词模板');
            return;
        }
        
        // 检查主关键词
        let homeTitle = document.getElementById('main-keyword').value.trim();
        if (!homeTitle) {
            alert('请先填写主关键词');
            return;
        }
        
        const content = editor.getValue();
        const jsonData = JSON.parse(content);
        
        // 获取 site_name
        const siteName = jsonData.site_name || '站点名称';
        const currentLang = '<?php echo $current_lang; ?>';
        
        // 显示加载状态
        const promptTextarea = document.getElementById('prompt-textarea');
        promptTextarea.value = '正在生成提示词，请稍候...';
        
        // 如果是手动点击，显示加载按钮状态
        let btn = null;
        if (event && event.target) {
            btn = event.target.closest('button');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 生成中...';
                btn.disabled = true;
            }
        }
        
        // 调用 SERP API 获取搜索数据
        let searchDataText = '';
        try {
            const response = await fetch(`lib/google_serp_api.php?ajax_search=1&keywords=${encodeURIComponent(homeTitle)}&lang=${currentLang}&nums=20`);
            const searchData = await response.json();
            
            if (!searchData.error) {
                // 使用原始 JSON 数据
                searchDataText = JSON.stringify(searchData, null, 2);
            } else {
                searchDataText = '（未能获取搜索结果数据）';
            }
        } catch (error) {
            console.error('SERP API调用失败:', error);
            searchDataText = '（搜索数据获取失败）';
        }
        
        // 获取选中的模板
        const selectedOption = templateSelect.options[templateSelect.selectedIndex];
        let promptTemplate = selectedOption.getAttribute('data-template');
        
        if (!promptTemplate) {
            alert('选择的模板无效');
            return;
        }
        
        // 替换变量
        promptTemplate = promptTemplate
            .replace(/\{site_name\}/g, siteName)
            .replace(/\{main_keywords\}/g, homeTitle)
            .replace(/\{lang_json\}/g, content)
            .replace(/\{serp_json\}/g, searchDataText);

        // 更新 textarea 内容
        promptTextarea.value = promptTemplate;
        
        // 显示成功提示（仅在手动点击时）
        if (btn) {
            btn.innerHTML = '<i class="fas fa-check"></i> 已生成';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            btn.disabled = false; // 重新启用按钮
            
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-sync"></i> 生成提示词';
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
            }, 2000);
        }
        
    } catch (e) {
        alert('❌ JSON格式错误，无法生成提示词: ' + e.message);
        
        // 恢复按钮状态
        if (btn) {
            btn.innerHTML = '<i class="fas fa-sync"></i> 生成提示词';
            btn.disabled = false;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
        }
    } finally {
        // 确保按钮始终恢复（如果有任何意外情况）
        if (btn && btn.disabled) {
            setTimeout(() => {
                if (btn.disabled) {
                    btn.innerHTML = '<i class="fas fa-sync"></i> 生成提示词';
                    btn.disabled = false;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-primary');
                }
            }, 3000); // 3秒后强制恢复
        }
    }
}

// 复制提示词到剪贴板
function copyPrompt() {
    const textarea = document.getElementById('prompt-textarea');
    const content = textarea.value;
    
    if (!content.trim()) {
        alert('请先生成提示词');
        return;
    }
    
    // 复制到剪贴板
    navigator.clipboard.writeText(content).then(function() {
        // 显示成功提示
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> 已复制';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-info');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-info');
            btn.classList.add('btn-success');
        }, 2000);
    }).catch(function(err) {
        // 降级方案：选择文本
        textarea.select();
        textarea.setSelectionRange(0, 99999);
        try {
            document.execCommand('copy');
            alert('✅ 提示词已复制到剪贴板');
        } catch (err) {
            alert('❌ 复制失败，请手动选择并复制文本');
        }
    });
}

// 加载提示词模板
async function loadPromptTemplates() {
    try {
        console.log('开始加载提示词模板...');
        const response = await fetch('lib/get_prompts.php');
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const prompts = await response.json();
        console.log('加载到的提示词模板:', prompts);
        
        const select = document.getElementById('prompt-template');
        if (!select) {
            throw new Error('找不到提示词模板选择器');
        }
        
        select.innerHTML = '<option value="">-- 请选择模板 --</option>';
        
        if (!Array.isArray(prompts) || prompts.length === 0) {
            console.warn('没有找到提示词模板');
            return [];
        }
        
        prompts.forEach(prompt => {
            console.log('添加模板:', prompt.name);
            const option = document.createElement('option');
            option.value = prompt.id;
            option.textContent = prompt.name;
            option.setAttribute('data-template', prompt.template);
            
            if (prompt.is_active) {
                option.selected = true;
            }
            
            select.appendChild(option);
        });
        
        console.log('提示词模板加载完成，总数:', prompts.length);
        return prompts;
    } catch (error) {
        console.error('加载提示词模板失败:', error);
        
        // 显示错误提示
        const select = document.getElementById('prompt-template');
        if (select) {
            select.innerHTML = '<option value="">-- 加载失败，请刷新页面重试 --</option>';
        }
        
        return [];
    }
}

// 模板切换处理
function onTemplateChange() {
    const select = document.getElementById('prompt-template');
    const promptTextarea = document.getElementById('prompt-textarea');
    
    if (select.value) {
        promptTextarea.placeholder = '已选择模板，填写主关键词后点击"生成提示词"按钮';
    } else {
        promptTextarea.placeholder = '请先选择提示词模板和填写主关键词，然后点击"生成提示词"按钮';
        promptTextarea.value = '';
    }
}

// 页面加载时初始化
document.addEventListener('DOMContentLoaded', function() {
    // 延迟加载，确保编辑器已加载
    setTimeout(async function() {
        // 先尝试从JSON预填主关键词
        try {
            const content = editor.getValue();
            const jsonData = JSON.parse(content);
            const homeTitle = jsonData.home?.h1 || '';
            if (homeTitle) {
                document.getElementById('main-keyword').value = homeTitle;
            }
        } catch (e) {
            // 忽略错误
        }
        
        // 加载提示词模板
        await loadPromptTemplates();
        
        // 不再自动生成提示词，需要用户选择模板后手动生成
    }, 1000);
});

// 从JSON更新主关键词
function updateKeywordFromJSON() {
    try {
        const content = editor.getValue();
        const jsonData = JSON.parse(content);
        const homeTitle = jsonData.home?.title || '';
        
        if (homeTitle) {
            document.getElementById('main-keyword').value = homeTitle;
            // 显示成功提示
            const btn = event.target.closest('button');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success');
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');
            }, 1500);
        } else {
            alert('未能从JSON中找到 home.title 字段');
        }
    } catch (e) {
        alert('❌ JSON格式错误: ' + e.message);
    }
}

// 点击模态框外部关闭
window.onclick = function(event) {
    const modal = document.getElementById('translateModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

<style>
.ace_editor {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
}
</style>

<!-- 翻译模态框 -->
<div id="translateModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.4);">
    <div style="background-color:#fefefe; margin:5% auto; padding:20px; border:1px solid #888; width:80%; max-width:500px; border-radius:5px; max-height:85vh; overflow-y:auto;">
        <span style="color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer;" onclick="closeTranslateModal()">&times;</span>
        <h4><i class="fas fa-language"></i> 一键翻译</h4>
        <hr>
        <p>将当前英文内容翻译为其他语言</p>
        
        <div class="mb-3">
            <label for="targetLanguage" class="form-label">目标语言</label>
            <select class="form-select" id="targetLanguage">
                <option value="">-- 请选择 --</option>
                <?php 
                $supportedLanguages = getSupportedLanguages();
                foreach ($supportedLanguages as $code => $name): 
                    if ($code != 'en' && $code != $current_lang):
                ?>
                <option value="<?php echo $code; ?>"><?php echo $name; ?> (<?php echo strtoupper($code); ?>)</option>
                <?php 
                    endif;
                endforeach; 
                ?>
            </select>
        </div>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 注意：
            <ul class="mb-0 mt-2">
                <li>翻译基于 ChatGPT 3.5 API</li>
                <li>大文件会自动分批翻译</li>
                <li>占位符如 {site_name} 会被保留</li>
                <li>翻译可能需要一些时间，请耐心等待</li>
            </ul>
        </div>
        
        <div class="alert alert-warning">
            <i class="fas fa-magic"></i> <strong>批量翻译选项</strong><br>
            <small>
                • <strong>翻译全部语言</strong>: 翻译所有38种语言（会覆盖已存在的翻译）<br>
                • <strong>翻译剩余语言</strong>: 只翻译那些还没有翻译文件的语言
            </small>
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success" onclick="doTranslateAll()">
                    <i class="fas fa-globe"></i> 翻译全部语言
                </button>
                <button type="button" class="btn btn-info" onclick="doTranslateRemaining()">
                    <i class="fas fa-plus-circle"></i> 翻译剩余语言
                </button>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-secondary" onclick="closeTranslateModal()">取消</button>
                <button type="button" class="btn btn-primary" onclick="doTranslate()">
                    <i class="fas fa-language"></i> 翻译单种语言
                </button>
            </div>
        </div>
    </div>
</div>