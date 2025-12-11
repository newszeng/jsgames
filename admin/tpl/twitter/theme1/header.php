<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['site_lang']; ?>">
<head>
    <title><?php echo htmlspecialchars($GLOBALS['template_data']['title'] ?? __('hero_title', 'Twitter Video Downloader')); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($GLOBALS['template_data']['meta_description'] ?? __('meta_description', 'Download Twitter videos in HD quality. Fast, free, and easy to use Twitter downloader.')); ?>" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=5, shrink-to-fit=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="canonical" href="<?php echo get_page_url('/'); ?>" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/themes/snaptik/img/fav-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/themes/snaptik/img/fav-16x16.png">
    
    <!-- Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars(__('hero_title', 'Twitter Video Downloader')); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(__('meta_description', 'Download Twitter videos in HD quality. Fast, free, and easy to use Twitter downloader.')); ?>">
    <meta property="og:locale" content="<?php echo $GLOBALS['site_lang']; ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?php echo htmlspecialchars(__('hero_title', 'Twitter Video Downloader')); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars(__('meta_description', 'Download Twitter videos in HD quality.')); ?>">
    <meta name="theme-color" content="#1DA1F2">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    
    <!-- SnapTik Original CSS -->
    <link href="/common.min.css" rel="stylesheet">
    
    <!-- Twitter Brand Colors -->
    <style>
        .dl-box {
            background: linear-gradient(135deg, #1DA1F2 0%, #0d8bd9 100%) !important;
        }
    </style>
    <script src="/async-download.js"></script>
</head>
<body>
    <!-- Header Navigation - SnapTik Exact Structure -->
    <header>
        <nav class="navbar header-nav navbar-expand-lg navbar-light scrolling-navbar">
            <div class="container">
                <a class="navbar-brand" href="<?php echo get_page_url('/'); ?>">
                    <img src="/twitter.png" alt="Twitter" class="d-inline-block align-top" style="height: 32px; width: auto; margin-right: 10px;">
                    <strong><?php echo __('site_name', 'Twitter Downloader'); ?></strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#headerNavbarContent" aria-controls="headerNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="headerNavbarContent">
                    <ul class="navbar-nav nav-flex-icons ml-auto">
                        <?php
                        // 加载动态导航项
                        $navbar_file = __DIR__ . "/../../navbars/{$GLOBALS['site_domain']}/navbar.json";
                        if (file_exists($navbar_file)) {
                            $navbar_items = json_decode(file_get_contents($navbar_file), true) ?: [];
                            foreach ($navbar_items as $item) {
                                if ($item['active'] ?? false) {
                                    // 获取页面标题
                                    $page_file = __DIR__ . "/../../pages/{$GLOBALS['site_domain']}/{$item['slug']}/{$GLOBALS['site_lang']}.json";
                                    $page_title = $item['slug']; // 默认使用slug
                                    
                                    if (file_exists($page_file)) {
                                        $page_data = json_decode(file_get_contents($page_file), true);
                                        $page_title = $page_data['page']['h1'] ?? $page_data['page']['title'] ?? $item['slug'];
                                    } else {
                                        // 如果当前语言文件不存在，尝试英文
                                        $en_page_file = __DIR__ . "/../../pages/{$GLOBALS['site_domain']}/{$item['slug']}/en.json";
                                        if (file_exists($en_page_file)) {
                                            $page_data = json_decode(file_get_contents($en_page_file), true);
                                            $page_title = $page_data['page']['h1'] ?? $page_data['page']['title'] ?? $item['slug'];
                                        }
                                    }
                                    
                                    echo '<li class="nav-item">';
                                    echo '<a class="nav-link" href="' . get_page_url('/' . $item['slug']) . '"><i class="fa fa-circle-notch"></i> <span class="clearfix d-sm-inline-block">' . htmlspecialchars($page_title) . '</span></a>';
                                    echo '</li>';
                                }
                            }
                        }
                        ?>
                        <?php
                        // 加载头部导航外链
                        $backlinks_file = __DIR__ . "/../../backlinks/{$GLOBALS['site_domain']}/backlinks.json";
                        if (file_exists($backlinks_file)) {
                            $backlinks = json_decode(file_get_contents($backlinks_file), true) ?: [];
                            foreach ($backlinks as $link) {
                                if (($link['position'] ?? '') == 'header' && ($link['active'] ?? false)) {
                                    $target = $link['target'] ?? '_blank';
                                    $rel = $link['rel'] ?? 'nofollow';
                                    echo '<li class="nav-item">';
                                    echo '<a class="nav-link" href="' . htmlspecialchars($link['url']) . '" target="' . $target . '" rel="' . $rel . '"><i class="fa fa-external-link"></i> <span class="clearfix d-sm-inline-block">' . htmlspecialchars($link['title']) . '</span></a>';
                                    echo '</li>';
                                }
                            }
                        }
                        ?>
                        <?php if (count(get_available_languages()) > 0): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-globe"></i> 
                                <?php 
                                $available_langs = get_available_languages();
                                echo $available_langs[$GLOBALS['site_lang']] ?? 'English';
                                ?>
                            </a>
                            <div id="langsDropDown" class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php 
                                foreach ($available_langs as $lang_code => $lang_name) {
                                    // 检查是否在标签页面
                                    $current_page = $GLOBALS['template_data']['slug'] ?? '';
                                    
                                    if ($current_page && ($GLOBALS['template_data']['type'] ?? '') === 'page') {
                                        // 在标签页面：构建带标签的语言URL
                                        $base_lang_url = get_language_url($lang_code);
                                        //en首页
                                        if($base_lang_url=='/'){
                                            $base_lang_url = $base_lang_url."en";
                                        }
                                        $lang_url = $base_lang_url . '/' . $current_page;
                                    } else {
                                        // 在首页：使用基础语言URL
                                        $lang_url = get_language_url($lang_code);
                                    }
                                    
                                    $active_class = $lang_code == $GLOBALS['site_lang'] ? ' active' : '';
                                    echo '<a class="dropdown-item' . $active_class . '" href="' . $lang_url . '" lang="' . $lang_code . '">';
                                    echo '' . $lang_name;
                                    echo '</a>';
                                }
                                ?>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>