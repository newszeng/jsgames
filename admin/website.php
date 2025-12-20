<?php
session_start();

// 检查是否已登录
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$edit_mode = false;
$edit_data = [];

// 加载域名列表
$domains_file = 'data/domain_list.json';
$all_domains = [];
$available_domains = [];
if (file_exists($domains_file)) {
    $all_domains = json_decode(file_get_contents($domains_file), true) ?: [];
}

// 检查是否从域名管理页面跳转过来
$selected_domain = $_GET['domain'] ?? '';

// 支持的游戏类型
$supportedGameTypes = [
    'wordle' => 'Wordle - Word Guessing Game',
    'tetris' => 'Tetris - Block Puzzle Game', 
    'snake' => 'Snake - Classic Arcade Game',
    '2048' => '2048 - Number Puzzle Game',
];

// 读取网站列表
$websites = json_decode(file_get_contents('data/websites.json'), true) ?: [];

// 获取已使用的域名
$used_domains = array_map(function($site) { return $site['domain']; }, $websites);

// 获取可用的域名（未建站的）
foreach ($all_domains as $domain_data) {
    if (!in_array($domain_data['domain'], $used_domains)) {
        $available_domains[] = $domain_data['domain'];
    }
}

// 如果没有可用域名且不是编辑模式，重定向到域名管理页面
if (empty($available_domains) && !isset($_GET['edit'])) {
    header('Location: domain_list.php?need_domain=1');
    exit();
}

// 编辑模式
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_domain = $_GET['edit'];
    foreach ($websites as $site) {
        if ($site['domain'] == $edit_domain) {
            $edit_data = $site;
            break;
        }
    }
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = trim($_POST['domain'] ?? '');
    $type = $_POST['type'] ?? '';
    $theme = $_POST['theme'] ?? '';
    $status = $_POST['status'] ?? 'active';
    $site_name = trim($_POST['site_name'] ?? '');
    $tagline = trim($_POST['tagline'] ?? '');
    $analytics_id = trim($_POST['analytics_id'] ?? '');
    $adsense_id = trim($_POST['adsense_id'] ?? '');
    
    if (empty($domain) || empty($type) || empty($theme) || empty($site_name)) {
        $error = '域名、游戏类型、主题和网站名称都是必需的';
    } else {
        // 验证域名是否在可用列表中（仅在非编辑模式下）
        if (!$edit_mode && !in_array($domain, $available_domains)) {
            $error = '请选择一个有效的域名';
        } else {
            $website = [
                'domain' => $domain,
                'type' => $type,
                'theme' => $theme,
                'status' => $status,
                'site_name' => $site_name,
                'tagline' => $tagline,
                'analytics_id' => $analytics_id,
                'adsense_id' => $adsense_id,
                'created_by' => $edit_mode && isset($edit_data['created_by']) ? $edit_data['created_by'] : $_SESSION['username'],
                'created_at' => $edit_mode ? $edit_data['created_at'] : date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($edit_mode) {
                // 更新现有网站
                foreach ($websites as $key => $site) {
                    if ($site['domain'] == $edit_domain) {
                        $websites[$key] = $website;
                        break;
                    }
                }
                $success = '网站更新成功';
            } else {
                // 检查域名是否已存在
                $exists = false;
                foreach ($websites as $site) {
                    if ($site['domain'] == $domain) {
                        $exists = true;
                        break;
                    }
                }

                if ($exists) {
                    $error = '域名已存在';
                } else {
                    // 添加新网站
                    $websites[] = $website;
                    
                    // 创建必要的目录和文件
                    createWebsiteFiles($domain, $type, $theme, $site_name);
                    
                    $success = '网站添加成功';
                }
            }
            
            if (!$error) {
                file_put_contents('data/websites.json', json_encode($websites, JSON_PRETTY_PRINT));
                
                if (!$edit_mode) {
                    header('Location: index.php?added=1');
                    exit();
                } else {
                    header('Location: index.php?updated=1');
                    exit();
                }
            }
        }
    }
}

// 创建网站文件的函数
function createWebsiteFiles($domain, $type, $theme, $site_name) {
    // 1. 创建Apache配置文件
    $vhost_template = file_get_contents('vhost/tpl.conf');
    $vhost_config = str_replace('{DOMAIN}', $domain, $vhost_template);
    file_put_contents("../vhosts/{$domain}.conf", $vhost_config);
    
    // 2. 复制主题文件（使用按类型/主题的母版模板）
    $theme_source = "tpl/{$type}/{$theme}";
    $theme_dest = "../tpl/{$domain}";
    if (is_dir($theme_source)) {
        copyDirectory($theme_source, $theme_dest);
    }
    
    // 3. 复制语言包并替换 site_name
    $i18n_source = "i18n/{$type}/{$theme}";
    $i18n_dest = "../i18n/{$domain}";

    if (is_dir($i18n_source)) {
        copyDirectory($i18n_source, $i18n_dest);
        
        // 替换所有语言文件中的 site_name
        $lang_files = glob("{$i18n_dest}/*.json");
        foreach ($lang_files as $lang_file) {
            $content = file_get_contents($lang_file);
            $lang_data = json_decode($content, true);
            
            if ($lang_data !== null) {
                // 替换 site_name
                if (isset($lang_data['site_name'])) {
                    $lang_data['site_name'] = $site_name;
                }
                
                // 保存更新后的文件
                file_put_contents($lang_file, json_encode($lang_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }
    }
    
    // 4. 复制路由配置
    $router_template = file_get_contents('router/tpl.json');
    $router_config = str_replace('{SITE_NAME}', $site_name, $router_template);
    @mkdir("../router/{$domain}", 0777, true);
    file_put_contents("../router/{$domain}/router.json", $router_config);
    
    // 5. 复制静态资源（从规范母版目录）
    $static_source = "static/{$type}/{$theme}";
    $static_root = "../static/{$domain}";
    $static_dirs = ['css', 'js', 'images', 'upload'];

    if (is_dir($static_source)) {
        copyDirectory($static_source, $static_root);
    }

    // 确保基本目录存在
    foreach ($static_dirs as $dir) {
        @mkdir("{$static_root}/{$dir}", 0777, true);
    }
    
    // 6. 复制游戏文件（如果是游戏网站）
    copyGameFiles($domain, $type);
    
    // 7. 创建其他必要目录
    @mkdir("../pages/{$domain}", 0777, true);
    @mkdir("../backlinks/{$domain}", 0777, true);
    @mkdir("../navbars/{$domain}", 0777, true);
    @mkdir("../analytics/{$domain}", 0777, true);
}

// 复制游戏文件
function copyGameFiles($domain, $type) {
    // 只处理游戏类型
    if ($type !== 'wordle') {
        return;
    }
    
    // 在gameFile目录中查找匹配的游戏文件夹
    $gameFileDir = "../gameFile";
    if (!is_dir($gameFileDir)) {
        return;
    }
    
    $gameFolders = scandir($gameFileDir);
    $matchedFolder = null;
    
    foreach ($gameFolders as $folder) {
        if ($folder == '.' || $folder == '..' || !is_dir("{$gameFileDir}/{$folder}")) {
            continue;
        }
        
        // 提取文件夹名中的游戏名称（去掉数字前缀和下划线）
        $folderGameName = preg_replace('/^\d+_/', '', $folder);
        
        // 不区分大小写比较，匹配域名中的游戏名称
        if (stripos($domain, $folderGameName) !== false) {
            $matchedFolder = $folder;
            break;
        }
    }
    
    // 如果没有找到匹配的游戏文件夹，直接返回
    if (!$matchedFolder) {
        return;
    }
    
    $gameSourceDir = "{$gameFileDir}/{$matchedFolder}";
    $gameTargetDir = "../static/{$domain}";
    
    // 创建目标目录结构
    @mkdir("{$gameTargetDir}/game", 0777, true);
    @mkdir("{$gameTargetDir}/js", 0777, true);
    
    // 复制游戏文件
    copyDirectory($gameSourceDir, "{$gameTargetDir}/game");
    
    // 复制iframe-height.js
    $iframeHeightSource = "../gameFile/iframe-height.js";
    if (file_exists($iframeHeightSource)) {
        copy($iframeHeightSource, "{$gameTargetDir}/js/iframe-height.js");
    }
    
    // 复制common.js（从现有的combinations.cv复制）
    $commonJsSource = "../static/combinations.cv/js/common.js";
    if (file_exists($commonJsSource)) {
        copy($commonJsSource, "{$gameTargetDir}/js/common.js");
    }
    
    // 修改游戏index.html添加iframe-height.js引用
    $gameIndexFile = "{$gameTargetDir}/game/index.html";
    if (file_exists($gameIndexFile)) {
        $content = file_get_contents($gameIndexFile);
        
        // 检查是否已经包含iframe-height.js引用
        if (strpos($content, 'iframe-height.js') === false) {
            // 在</body>标签前添加脚本引用
            $content = str_replace('</body>', '    <script src="../js/iframe-height.js"></script>' . "\n</body>", $content);
            file_put_contents($gameIndexFile, $content);
        }
        
        // 修复游戏中的路径问题（如Dordle的dic路径）
        $folderGameName = preg_replace('/^\d+_/', '', $matchedFolder);
        fixGamePaths($content, $gameIndexFile, $folderGameName);
    }
    
    // 更新游戏模板文件
    $templateTarget = "../tpl/{$domain}";
    
    if (is_dir($templateTarget)) {
        // 如果模板目录已存在，更新其中的HTML文件
        $folderGameName = preg_replace('/^\d+_/', '', $matchedFolder);
        updateGameTemplate($templateTarget, $folderGameName, $domain);
    } else {
        // 如果模板目录不存在，从参考模板复制
        $existingGameTemplates = ['combinations.cv', 'phazle.cv', 'dordle.cv', 'spellsbee.cv', 'squares.cv'];
        $referenceTemplate = null;
        
        foreach ($existingGameTemplates as $template) {
            if (is_dir("../tpl/{$template}")) {
                $referenceTemplate = $template;
                break;
            }
        }
        
        if ($referenceTemplate) {
            @mkdir($templateTarget, 0777, true);
            copyDirectory("../tpl/{$referenceTemplate}", $templateTarget);
            
            // 更新模板中的游戏标题和域名引用
            $folderGameName = preg_replace('/^\d+_/', '', $matchedFolder);
            updateGameTemplate($templateTarget, $folderGameName, $domain);
        }
    }
}

// 修复游戏中的路径问题
function fixGamePaths($content, $gameIndexFile, $gameName) {
    $updated = false;
    
    // 修复Dordle类游戏的dic路径问题
    if (stripos($gameName, 'dordle') !== false) {
        // 查找并替换JavaScript文件中的绝对路径
        $jsDir = dirname($gameIndexFile) . '/static/js';
        if (is_dir($jsDir)) {
            $jsFiles = glob("{$jsDir}/*.js");
            foreach ($jsFiles as $jsFile) {
                $jsContent = file_get_contents($jsFile);
                $originalContent = $jsContent;
                
                // 将绝对路径/dic/替换为相对路径dic/
                $jsContent = str_replace('"/dic/', '"dic/', $jsContent);
                
                if ($jsContent !== $originalContent) {
                    file_put_contents($jsFile, $jsContent);
                }
            }
        }
    }
}

// 更新游戏模板
function updateGameTemplate($templateDir, $gameName, $domain) {
    $templateFiles = glob("{$templateDir}/*.html");
    
    foreach ($templateFiles as $templateFile) {
        $content = file_get_contents($templateFile);
        
        // 更新游戏标题
        $gameTitle = ucfirst($gameName) . ' Game';
        $content = preg_replace('/title="[^"]*Game"/', "title=\"{$gameTitle}\"", $content);
        
        // 自动将<div id="root">替换为iframe（如果存在）
        if (strpos($content, 'id="root"') !== false) {
            // 替换 <div id="root" ...></div> 为 iframe
            $content = preg_replace(
                '/<div\s+id="root"[^>]*><\/div>/',
                '<iframe id="gameFrame" src="/static/' . $domain . '/game/" style="width: 100%; border: none; display: block; overflow: hidden;" title="' . $gameTitle . '"></iframe>',
                $content
            );
        }
        
        // 确保iframe使用正确的域名路径
        $content = preg_replace('/src="\/static\/[^\/]+\/game\/"/', "src=\"/static/{$domain}/game/\"", $content);
        
        // 更新iframe的title属性
        $content = preg_replace('/title="[^"]*Game"/', "title=\"{$gameTitle}\"", $content);
        
        // 添加common.js引用（如果还没有）
        if (strpos($content, 'common.js') === false) {
            // 在</body>标签前添加脚本引用
            if (strpos($content, '</body>') !== false) {
                $commonJsScript = "    <script src=\"/static/{$domain}/js/common.js\"></script>\n</body>";
                $content = str_replace('</body>', $commonJsScript, $content);
            }
        }
        
        file_put_contents($templateFile, $content);
    }
}

// 递归复制目录
function copyDirectory($src, $dst) {
    @mkdir($dst, 0777, true);
    $files = scandir($src);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            if (is_dir($srcFile)) {
                copyDirectory($srcFile, $dstFile);
            } else {
                copy($srcFile, $dstFile);
            }
        }
    }
}

// 简单的 Markdown 转 HTML 函数
function parseMarkdown($text) {
    // 转换标题
    $text = preg_replace('/^# (.+)$/m', '<h3 class="mb-2">$1</h3>', $text);
    $text = preg_replace('/^## (.+)$/m', '<h4 class="mb-2">$1</h4>', $text);
    $text = preg_replace('/^### (.+)$/m', '<h5 class="mb-1">$1</h5>', $text);
    
    // 转换列表项
    $text = preg_replace('/^- (.+)$/m', '<li>$1</li>', $text);
    
    // 包装连续的列表项
    $text = preg_replace('/(<li>.*<\/li>(?:\n<li>.*<\/li>)*)/s', '<ul class="mb-2">$1</ul>', $text);
    
    // 转换粗体
    $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
    
    // 转换段落（简单处理）
    $lines = explode("\n", $text);
    $result = '';
    $in_list = false;
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        if (strpos($line, '<h') === 0 || strpos($line, '<ul') === 0) {
            $result .= $line . "\n";
        } elseif (strpos($line, '<li>') === false && strpos($line, '</ul>') === false) {
            $result .= '<p class="mb-2">' . $line . '</p>' . "\n";
        } else {
            $result .= $line . "\n";
        }
    }
    
    return $result;
}

// 获取游戏主题列表
function getThemes($type) {
    $themes = [];
    
    // 为游戏网站提供预设主题
    switch($type) {
        case 'wordle':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典 Wordle 样式，简洁清爽</p>'],
                ['name' => 'theme2', 'description' => '<p>深色主题，护眼模式</p>'],
                ['name' => 'theme3', 'description' => '<p>Stheme3</p>'],
                ['name' => 'theme4', 'description' => '<p>theme4</p>'],
                ['name' => 'theme5', 'description' => '<p>theme5</p>'],
            ];
            break;
        case 'tetris':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典俄罗斯方块样式</p>'],
                ['name' => 'theme2', 'description' => '<p>现代彩色主题</p>'],
            ];
            break;
        case 'snake':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典贪吃蛇绿色主题</p>'],
                ['name' => 'theme2', 'description' => '<p>霓虹灯效果主题</p>'],
            ];
            break;
        case '2048':
            $themes = [
                ['name' => 'theme1', 'description' => '<p>经典 2048 橙色主题</p>'],
                ['name' => 'theme2', 'description' => '<p>蓝色科技主题</p>'],
            ];
            break;
        default:
            $themes = [
                ['name' => 'theme1', 'description' => '<p>默认主题</p>'],
            ];
    }
    
    return $themes;
}

// 现在包含header开始HTML输出
require_once 'header.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">管理首页</a></li>
        <li class="breadcrumb-item active"><?php echo $edit_mode ? '编辑' : '添加'; ?>网站</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-8">
        <div class="form-section">
            <h4><?php echo $edit_mode ? '编辑' : '创建新'; ?>游戏网站</h4>
            
            <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="mb-3">
                    <label for="domain" class="form-label">域名</label>
                    <?php if ($edit_mode): ?>
                        <input type="text" class="form-control" id="domain" name="domain" 
                               value="<?php echo htmlspecialchars($edit_data['domain'] ?? ''); ?>" readonly>
                        <div class="form-text">编辑模式下域名不可更改</div>
                    <?php else: ?>
                        <select class="form-select" id="domain" name="domain" required>
                            <option value="">选择域名</option>
                            <?php foreach ($available_domains as $domain): ?>
                            <option value="<?php echo htmlspecialchars($domain); ?>"
                                    <?php echo ($selected_domain == $domain) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($domain); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">
                            请选择一个可用的域名。
                            <a href="domain_list.php">管理域名列表</a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="site_name" class="form-label">网站名称</label>
                    <input type="text" class="form-control" id="site_name" name="site_name" 
                           value="<?php echo htmlspecialchars($edit_data['site_name'] ?? ''); ?>"
                           placeholder="我的 Wordle 游戏" required>
                    <div class="form-text">此名称将显示在网站标题和内容中</div>
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">游戏类型</label>
                    <select class="form-select" id="type" name="type" required onchange="loadThemes(this.value)">
                        <option value="">选择游戏类型</option>
                        <?php foreach ($supportedGameTypes as $key => $name): ?>
                        <option value="<?php echo $key; ?>" 
                                <?php echo (($edit_data['type'] ?? '') == $key) ? 'selected' : ''; ?>>
                            <?php echo $name; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="theme" class="form-label">主题</label>
                    <select class="form-select" id="theme" name="theme" required>
                        <option value="">选择主题</option>
                    </select>
                    <div id="theme-description" class="form-text mt-2"></div>
                </div>
                
                <div class="mb-3">
                    <label for="tagline" class="form-label">游戏标语</label>
                    <input type="text" class="form-control" id="tagline" name="tagline" 
                           value="<?php echo htmlspecialchars($edit_data['tagline'] ?? ''); ?>"
                           placeholder="Guess the word in 6 tries">
                    <div class="form-text">显示在游戏标题下方的描述文字</div>
                </div>
                
                <div class="mb-3">
                    <label for="analytics_id" class="form-label">Google Analytics ID</label>
                    <input type="text" class="form-control" id="analytics_id" name="analytics_id" 
                           value="<?php echo htmlspecialchars($edit_data['analytics_id'] ?? ''); ?>"
                           placeholder="GA_MEASUREMENT_ID">
                    <div class="form-text">用于网站访问统计（可选）</div>
                </div>
                
                <div class="mb-3">
                    <label for="adsense_id" class="form-label">Google AdSense ID</label>
                    <input type="text" class="form-control" id="adsense_id" name="adsense_id" 
                           value="<?php echo htmlspecialchars($edit_data['adsense_id'] ?? ''); ?>"
                           placeholder="ca-pub-xxxxxxxxxxxxxxxxx">
                    <div class="form-text">用于显示广告（可选）</div>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">状态</label>
                    <select class="form-select" id="status" name="status">
                        <option value="maintenance" <?php echo (($edit_data['status'] ?? '') == 'maintenance') ? 'selected' : ''; ?>>维护中</option>
                        <option value="active" <?php echo (($edit_data['status'] ?? '') == 'active') ? 'selected' : ''; ?>>启用</option>
                    </select>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $edit_mode ? '更新' : '创建'; ?> 网站
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> 取消
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 信息
            </div>
            <div class="card-body">
                <h6>创建游戏网站时会发生什么？</h6>
                <ul class="small">
                    <li>创建Apache虚拟主机配置</li>
                    <li>复制游戏主题模板文件</li>
                    <li>设置多语言文件</li>
                    <li>配置游戏路由规则</li>
                    <li>创建静态资源目录</li>
                    <li>游戏网站将立即可以访问</li>
                </ul>
                
                <hr>
                
                <h6>游戏主题</h6>
                <p class="small">每种游戏类型都有专门优化的主题，包含游戏特色设计和功能。选择游戏类型以查看可用主题。</p>
            </div>
        </div>
    </div>
</div>

<script>
// 加载主题列表
function loadThemes(type) {
    const themeSelect = document.getElementById('theme');
    const themeDesc = document.getElementById('theme-description');
    
    themeSelect.innerHTML = '<option value="">加载中...</option>';
    themeDesc.innerHTML = '';
    
    if (!type) {
        themeSelect.innerHTML = '<option value="">选择主题</option>';
        return;
    }
    
    // 使用AJAX获取主题列表
    fetch('get_themes.php?type=' + type)
        .then(response => response.json())
        .then(themes => {
            themeSelect.innerHTML = '<option value="">选择主题</option>';
            themes.forEach(theme => {
                const option = document.createElement('option');
                option.value = theme.name;
                option.textContent = theme.name;
                option.dataset.description = theme.description;
                
                <?php if ($edit_mode): ?>
                if (theme.name === '<?php echo $edit_data['theme'] ?? ''; ?>') {
                    option.selected = true;
                    themeDesc.innerHTML = '<div class="alert alert-info small">' + theme.description + '</div>';
                }
                <?php endif; ?>
                
                themeSelect.appendChild(option);
            });
        })
        .catch(error => {
            themeSelect.innerHTML = '<option value="">没有可用主题</option>';
        });
}

// 显示主题描述
document.getElementById('theme').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const description = selectedOption.dataset.description;
    const themeDesc = document.getElementById('theme-description');
    
    if (description) {
        themeDesc.innerHTML = '<div class="alert alert-info small">' + description + '</div>';
    } else {
        themeDesc.innerHTML = '';
    }
});

// 页面加载时如果是编辑模式，加载主题
<?php if ($edit_mode && !empty($edit_data['type'])): ?>
loadThemes('<?php echo $edit_data['type']; ?>');
<?php endif; ?>
</script>

<?php require_once 'footer.php'; ?>