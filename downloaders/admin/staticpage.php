<?php
// 这个文件被 website_pages.php 包含，$domain 变量已经可用

$i18n_dir = "../i18n/{$domain}";
$current_lang = $_GET['lang'] ?? 'en';
$current_page = $_GET['page'] ?? 'contact';

// 静态页面列表
$static_pages = [
    'contact' => 'Contact Us',
    'privacy' => 'Privacy Policy',
    'terms' => 'Terms of Service',
    'dmca' => 'DMCA Policy',
    'about' => 'About Us'
];

// 读取语言文件
$lang_file = "{$i18n_dir}/{$current_lang}.json";
$lang_data = [];
if (file_exists($lang_file)) {
    $lang_data = json_decode(file_get_contents($lang_file), true) ?: [];
}

// 初始化静态页面数据
if (!isset($lang_data['static_pages'])) {
    $lang_data['static_pages'] = [];
}

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page_key = $_POST['page_key'] ?? '';
    if (isset($static_pages[$page_key])) {
        $lang_data['static_pages'][$page_key] = [
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? ''
        ];
        
        file_put_contents($lang_file, json_encode($lang_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $success = 'Static page content updated successfully';
    }
}

// 获取当前页面数据
$page_data = $lang_data['static_pages'][$current_page] ?? [
    'title' => $static_pages[$current_page] ?? '',
    'content' => '',
    'meta_description' => ''
];

// 获取可用语言
$languages = [];
if (is_dir($i18n_dir)) {
    $files = scandir($i18n_dir);
    foreach ($files as $file) {
        if (preg_match('/^([a-z]{2})\.json$/', $file, $matches)) {
            $languages[] = $matches[1];
        }
    }
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">Static Pages</div>
            <div class="list-group list-group-flush">
                <?php foreach ($static_pages as $key => $title): ?>
                <a href="website_pages.php?domain=<?php echo $domain; ?>&act=staticpage&page=<?php echo $key; ?>&lang=<?php echo $current_lang; ?>" 
                   class="list-group-item list-group-item-action <?php echo $current_page == $key ? 'active' : ''; ?>">
                    <?php echo $title; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="form-section">
            <h4><?php echo $static_pages[$current_page] ?? 'Static Page'; ?> Content</h4>
            
            <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="mb-3">
                <label class="form-label">Language</label>
                <select class="form-select" onchange="window.location.href=this.value">
                    <?php 
                    // 定义全球39种语言
                    $all_languages = [
                        'en' => 'English',
                        'es' => 'Español',
                        'fr' => 'Français',
                        'de' => 'Deutsch',
                        'it' => 'Italiano',
                        'pt' => 'Português',
                        'ru' => 'Русский',
                        'ja' => '日本語',
                        'ko' => '한국어',
                        'zh' => '中文',
                        'ar' => 'العربية',
                        'hi' => 'हिन्दी',
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
                        'el' => 'Ελληνικά',
                        'he' => 'עברית',
                        'th' => 'ไทย',
                        'vi' => 'Tiếng Việt',
                        'id' => 'Bahasa Indonesia',
                        'ms' => 'Bahasa Melayu',
                        'uk' => 'Українська',
                        'bg' => 'Български',
                        'hr' => 'Hrvatski',
                        'sk' => 'Slovenčina',
                        'sl' => 'Slovenščina',
                        'sr' => 'Српски',
                        'lt' => 'Lietuvių',
                        'lv' => 'Latviešu',
                        'et' => 'Eesti',
                        'ka' => 'ქართული',
                        'az' => 'Azərbaycan'
                    ];
                    
                    foreach ($languages as $lang): 
                        $lang_name = $all_languages[$lang] ?? strtoupper($lang);
                    ?>
                    <option value="website_pages.php?domain=<?php echo $domain; ?>&act=staticpage&page=<?php echo $current_page; ?>&lang=<?php echo $lang; ?>" 
                            <?php echo $current_lang == $lang ? 'selected' : ''; ?>>
                        <?php echo $lang_name; ?> (<?php echo strtoupper($lang); ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <form method="post">
                <input type="hidden" name="page_key" value="<?php echo $current_page; ?>">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Page Title</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?php echo htmlspecialchars($page_data['title']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description" 
                           value="<?php echo htmlspecialchars($page_data['meta_description']); ?>"
                           placeholder="SEO meta description for this page">
                </div>
                
                <div class="mb-3">
                    <label for="content" class="form-label">Content (HTML)</label>
                    <textarea class="form-control" id="content" name="content" rows="15" required><?php echo htmlspecialchars($page_data['content']); ?></textarea>
                    <div class="form-text">You can use HTML tags for formatting</div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                
                <button type="button" class="btn btn-secondary" onclick="previewContent()">
                    <i class="fas fa-eye"></i> Preview
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Content Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h3 id="preview-title"></h3>
                <div id="preview-content"></div>
            </div>
        </div>
    </div>
</div>

<script>
function previewContent() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    
    document.getElementById('preview-title').textContent = title;
    document.getElementById('preview-content').innerHTML = content;
    
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}
</script>