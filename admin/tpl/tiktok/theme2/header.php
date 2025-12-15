<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['site_lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($GLOBALS['template_data']['title'] ?? __('home.title', 'TikTokio - TikTok Video Downloader')); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($GLOBALS['template_data']['meta_description'] ?? __('site_description', 'Download TikTok videos without watermark. TikTokio is the best TikTok downloader to save TikTok videos in HD quality.')); ?>">
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.png" type="image/png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        color: #333;
        background: #fff;
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Header - White background with blue accents */
    .header-orange {
        background: #ffffff;
        color: #007bff;
        padding: 10px 0;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .header-orange .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .logo-section {
        display: flex;
        align-items: center;
        text-decoration: none !important;
    }
    
    .logo-section img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
        border-radius: 8px;
    }
    
    .logo-text {
        font-size: 24px;
        font-weight: 700;
        color: #007bff !important;
        text-decoration: none !important;
    }
    
    .header-nav {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .header-nav a {
        color: #333 !important;
        text-decoration: none !important;
        font-weight: 500;
        opacity: 0.8;
        transition: all 0.3s;
    }
    
    .header-nav a:hover {
        color: #007bff !important;
        opacity: 1;
    }
    
    .header-nav a:link,
    .header-nav a:visited,
    .header-nav a:active {
        color: #333 !important;
        text-decoration: none !important;
    }
    
    .header-nav a:hover {
        color: #007bff !important;
        text-decoration: none !important;
    }
    
    .lang-selector {
        background: #007bff;
        border: none;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
    }
    
    /* Main white content area */
    .main-content {
        background: white;
        min-height: calc(100vh - 120px);
        padding: 0;
    }
    
    /* Download section */
    .download-section {
        background: white;
        padding: 40px 0;
        text-align: center;
        border-bottom: 1px solid #eee;
    }
    
    .download-title {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }
    
    .download-subtitle {
        font-size: 16px;
        color: #666;
        margin-bottom: 30px;
    }
    
    .download-form {
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .url-input {
        flex: 1;
        padding: 12px 16px;
        border: 2px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        outline: none;
        transition: border-color 0.3s;
    }
    
    .url-input:focus {
        border-color: #007bff;
    }
    
    .paste-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: background 0.3s;
    }
    
    .paste-btn:hover {
        background: #5a6268;
    }
    
    .download-btn {
        background: #007bff;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background 0.3s;
    }
    
    .download-btn:hover {
        background: #0056b3;
    }
    
    .download-btn:disabled {
        background: #adb5bd;
        cursor: not-allowed;
    }
    
    .format-info {
        font-size: 14px;
        color: #666;
        margin-top: 15px;
    }
    
    /* Progress bar */
    .progress-container {
        margin-top: 20px;
        display: none;
    }
    
    .progress-bar {
        width: 100%;
        height: 6px;
        background: #f0f0f0;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 10px;
    }
    
    .progress-fill {
        height: 100%;
        background: #007bff;
        width: 0%;
        transition: width 0.3s ease;
    }
    
    .progress-text {
        text-align: center;
        color: #666;
        font-size: 14px;
    }
    
    /* Results */
    .results-container {
        margin-top: 30px;
        display: none;
    }
    
    /* Content sections */
    .content-section {
        padding: 40px 0;
        border-bottom: 1px solid #eee;
    }
    
    .content-section h2 {
        font-size: 24px;
        font-weight: 600;
        color: #007bff;
        margin-bottom: 20px;
        text-align: center;
    }
    
    .content-section p {
        font-size: 16px;
        line-height: 1.6;
        color: #666;
        margin-bottom: 15px;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }
    
    .feature-item {
        text-align: center;
        padding: 20px;
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 48px;
        color: #007bff;
        transition: all 0.3s ease;
    }
    
    .feature-item:hover .feature-icon {
        transform: scale(1.1);
    }
    
    .feature-item h3 {
        font-size: 18px;
        font-weight: 600;
        color: #007bff;
        margin-bottom: 10px;
    }
    
    .feature-item p {
        font-size: 14px;
        color: #666;
        margin-bottom: 0;
    }
    
    /* How to section */
    .steps-list {
        list-style: none;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .steps-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    
    .step-number {
        background: #007bff;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .step-content h4 {
        font-size: 16px;
        font-weight: 600;
        color: #007bff;
        margin-bottom: 5px;
    }
    
    .step-content p {
        font-size: 14px;
        color: #666;
        margin: 0;
    }
    
    /* Footer */
    footer {
        background: #2c3e50;
        color: #bdc3c7;
        padding: 40px 0 20px;
    }
    
    .footer-content {
        text-align: center;
    }
    
    .footer-links {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    
    .footer-links a {
        color: #bdc3c7;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s;
    }
    
    .footer-links a:hover {
        color: #007bff;
    }
    
    .footer-copyright {
        font-size: 14px;
        color: #95a5a6;
        border-top: 1px solid #34495e;
        padding-top: 20px;
        text-align: center;
    }
    
    /* Mobile responsive */
    @media (max-width: 768px) {
        .header-orange .container {
            flex-direction: column;
            gap: 10px;
        }
        
        .header-nav {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .download-form {
            flex-direction: column;
            gap: 10px;
        }
        
        .download-title {
            font-size: 24px;
        }
        
        .content-section {
            padding: 30px 0;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
        }
        
        .footer-links {
            flex-direction: column;
            gap: 15px;
        }
    }
    </style>
    <script src="/async-download.js"></script>
</head>
<body>
    <!-- Orange Header -->
    <div class="header-orange">
        <div class="container">
            <a href="<?php echo get_page_url('/'); ?>" class="logo-section">
                <img src="/tiktok.png" alt="<?php echo __('site_name', 'SnapTik'); ?>">
                <span class="logo-text"><?php echo __('site_name', 'SnapTik'); ?></span>
            </a>
            
            <nav class="header-nav">
                <a href="<?php echo get_page_url('/'); ?>"><?php echo __('nav.home', 'Home'); ?></a>

                <?php
                // Dynamic navigation
                $navbar_file = __DIR__ . "/../../navbars/{$GLOBALS['site_domain']}/navbar.json";
                if (file_exists($navbar_file)) {
                    $navbar_items = json_decode(file_get_contents($navbar_file), true) ?: [];
                    foreach ($navbar_items as $item) {
                        if ($item['active'] ?? false) {
                            $page_title = $item['slug'];
                            $page_file = __DIR__ . "/../../pages/{$GLOBALS['site_domain']}/{$item['slug']}/{$GLOBALS['site_lang']}.json";
                            if (file_exists($page_file)) {
                                $page_data = json_decode(file_get_contents($page_file), true);
                                $page_title = $page_data['page']['h1'] ?? $page_data['page']['title'] ?? $item['slug'];
                            }
                            echo '<a href="' . get_page_url('/' . $item['slug']) . '">' . htmlspecialchars($page_title) . '</a>';
                        }
                    }
                }
                ?>
                
                <?php if (count(get_available_languages()) > 1): ?>
                <select class="lang-selector" onchange="changeLanguage(this.value)">
                    <?php 
                    $available_langs = get_available_languages();
                    foreach ($available_langs as $lang_code => $lang_name) {
                        $selected = $lang_code == $GLOBALS['site_lang'] ? 'selected' : '';
                        echo '<option value="' . get_language_url($lang_code) . '" ' . $selected . '>' . $lang_name . '</option>';
                    }
                    ?>
                </select>
                <?php endif; ?>
            </nav>
        </div>
    </div>
    
    <!-- Main white content -->
    <main class="main-content">