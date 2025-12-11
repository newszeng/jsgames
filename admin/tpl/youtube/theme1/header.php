<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['site_lang'] ?? 'en'; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/favicon.png">
    <title><?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?></title>
    <meta name="description" content="<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>">
    <meta itemprop="name" content="<?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?>" />
    <meta itemprop="description" content="<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo __('site_name'); ?>" />
    <meta property="og:locale" content="<?php echo $GLOBALS['site_lang'] ?? 'en'; ?>" />
    <meta property="og:title" content="<?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?>" />
    <meta property="og:description" content="<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>" />
    <meta property="og:image" content="https://<?php echo $GLOBALS['site_domain']; ?>/logo.webp" />
    <meta property="og:url" content="https://<?php echo $GLOBALS['site_domain']; ?>/"/>
    <link rel="canonical" href="<?php
        $protocol = 'https';
        $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        echo $canonical_url;
    ?>">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link type="image/png" sizes="16x16" rel="icon" href="/favicon1616.png">
    <link type="image/png" sizes="32x32" rel="icon" href="/favicon3232.png">
    <link type="image/png" sizes="48x48" rel="icon" href="/favicon4848.png">
    <link type="image/png" sizes="96x96" rel="icon" href="/favicon9696.png">
    <script src="/async-download.js"></script>
    <style>html, body {font-size: 16px;font-family: sans-serif;line-height: 1.6;margin: 0 auto;color: #293a46;padding: 0;background-color: #f9f9f9;}a:visited, a:hover, a:link {text-decoration: none;}html:not(.tab-outline) *:focus {outline: none;}p{margin: 0 0 10px;}ul {padding: 0;margin: 0;list-style: none;}.y2mate-content-other ul {padding: revert;margin: auto;list-style: disc;}h2 {font-size: 26px;font-weight: 300;line-height: 1.4;margin: 10px 0;}h1, h2, h3, h4, h5 {line-height: 1.4;display: inline-block;}h4{font-size: 18px;font-weight: 300;margin: 10px 0;}h5{font-size: 18px;margin: 6px 0;font-weight: 400;}.block_error {border: 1px solid #ebccd1;border-radius: 6px;text-align: center;padding: 10px;background: #f2dede; max-width: 80%;margin: 20px auto 0;color: #a94442;}.block_error p{color: rgba(0,0,0,.7);margin: 0; } .y2mate-content-other h1 {text-align: center;display: block;}.d-none{display: none;}.container {max-width: 980px;margin: 0 auto;padding: 0px;}.text-center {text-align: center;}.row-padded {padding-top: 30px;padding-bottom: 30px;}.navbar-logo a{float: left;display: flex;align-items: center;margin: 6px 0 0 0;}.navbar-logo img{width: 46px;height: 46px;}.menu-navbar>li>a:hover, .menu-navbar>li>a:focus {text-decoration: none;background-color: #eee;color: #c10841;}.suggesstion-list ul.result_box {background: #fff;color: #000;text-align: left;line-height: normal;list-style: none;position: absolute;width: 100%;top: 62%;margin: 0;z-index: 4;border: 1px solid #d3e0e9;border-radius: 0;box-shadow: 0 3px 3px rgb(0 0 0 / 21%);padding: 6px 0 5px;overflow: auto;}ul.result_box li.search_result {padding: 3px 15px;cursor: pointer;}li.selected {background-color: #f0f0f0;font-weight: 600;}.nav-header{height: 66px;position: relative;}.navbar-logo:hover .logo-name{color: #c10841;}.navbar-logo .logo-name {display: inline-block;font-size: 20px;font-weight: 700;line-height: 50px;padding-left: 10px;color: #293a46;}.header-menu .menu-navbar{float: right;}.nav_head .navbar-logo{float: left;}.navbar-toggler {position: absolute;right: 15px;top: 0;color: #293a46;margin-right: 0;float: right;padding: 9px 10px;margin-top: 18px;margin-bottom: 18px;background-color: transparent;background-image: none;border: 1px solid #c10841;border-radius: 4px;}.navbar-toggler .toggle-icon {background: #c10841;display: block;width: 22px;height: 2px;border-radius: 1px;}.navbar-toggler .toggle-icon+.toggle-icon {margin-top: 4px;}.menu-navbar .navbar{display: inline-block;}.menu-navbar>li>a{font-size: 14px;color: #293a46;padding: 26px 15px;}.menu-navbar .navbar{line-height: 66px;position: relative;}.shape{display: inline-block;width: 0;height: 0;margin-left: 6px;vertical-align: middle;border-top: 4px dashed;border-top: 4px solid \9;border-right: 4px solid transparent;border-left: 4px solid transparent;}.dropdown-menu{display: none;}.dropdown-menu.open{display: block;}.language {float: right;position: relative;cursor: pointer;}.dropdown-menu .lang-menu{position: absolute;top: 100%;left: auto;right: 0;z-index: 1000;float: left;min-width: 160px;padding: 5px 0;margin: 0;list-style: none;font-size: 16px;text-align: left;background-color: #fff;border: 1px solid rgba(0,0,0,0.15);border-radius: 4px;-webkit-box-shadow: 0 6px 12px rgb(0 0 0 / 18%);box-shadow: 0 6px 12px rgb(0 0 0 / 18%);-webkit-background-clip: padding-box;background-clip: padding-box;}.lang-menu>li>a {display: block;padding: 3px 20px;clear: both;font-weight: normal;line-height: 1.42857143;color: #333;white-space: nowrap;}.lang-menu>li>a:hover, .lang-menu>li>a:focus {text-decoration: none;color: #262626;background-color: #f5f5f5;}.y2mate-download .y2mate-search-form{background-color: #fff;border: 1px solid #ddd;border-radius: 4px;-webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);box-shadow: 0 1px 1px rgb(0 0 0 / 5%);padding: 15px;}.d-flex{text-align: center;}.form-wrap>.y2mate_title:first-child {font-size: 34px;font-weight: 300;line-height: 1.4;margin: 0 0 10px 0;}.y2mate-download .form-wrap{padding: 30px 0;border-bottom: 0;}.search_form {margin: 36px auto;max-width: 600px;position: relative;}.search_form .y2mate_query{width: -webkit-fill-available;height: 50px;border: 5px solid #ff0068;border-radius: 4px;max-width: 100%;padding: 0 130px 0 20px;}.search_form p {color: #666;font-size: 14px;padding: 6px;margin: 0;}.submit-btn img{float: right;height: 60px;padding: 0 0 0 8px;}.search_form .convert-btn {width: 120px;height: 60px;background: #f20a51;position: absolute;top: 0;right: 0;border-radius: 0 4px 4px 0;display: flex;justify-content: center;align-items: center;cursor: pointer;border: none;}.convert-btn .converter-btn {display: inline-block;font-size: 14px;color: #fff;background: transparent;font-weight: 400;cursor: pointer;border: none;}.search_form .submit-btn:hover, .search_form .submit-btn:hover button{color: #fff;background: #c10841;}.y2mate-features-wrap h3{color: #c10841;font-size: 22px;margin-bottom: 8px;}.y2mate-features-wrap img{display: block;margin: 0 auto;}.y2mate-features-wrap svg{display: block;margin: 0 auto;}section.y2mate-features-wrap.first:before {background: inherit;}.y2mate-terms a{color: #c10841;}.y2mate-content, .y2mate-instruction, .y2mate-features-wrap, .y2mate-tips{padding: 30px 0;position: relative;display: flex;}.y2mate-features-wrap::before, .y2mate-content::before {background: rgba(0,0,0,0) radial-gradient(ellipse at center center,rgba(0,0,0,0.2) 0px,rgba(255,255,255,0) 75%) repeat scroll 0 0;bottom: 0;content: "";display: block;height: 1px;left: 50%;margin-left: -40%;position: absolute;width: 80%;}.y2mate-content h2{font-weight: bold;}.y2mate-instruction{display: flex;justify-content: space-between;}.y2mate-instruction::before {background: rgba(0,0,0,0) radial-gradient(ellipse at center center,rgba(0,0,0,0.2) 0px,rgba(255,255,255,0) 75%) repeat scroll 0 0;bottom: 0;content: "";display: block;height: 1px;left: 50%;margin-left: -40%;position: absolute;width: 80%;}.y2mate-in-ad ol{margin: 0;padding: 0 0 0 16px;}.y2mate-in-ad ol li, .y2mate-in-ad ul li{margin: 0 0 10px 0;font-size: 17px;}.y2mate-in-ad{width: 60%;padding: 0 15px;}.y2mate-instruction .y2mate-in-ad:nth-child(2n) {width: 40%;padding: 0 15px;}.y2mate-in-ad ul{list-style: initial;padding: 0 0 0 16px;}.col-sm-4{width: 33.33%;display: inline-block;/*padding: 0 15px;*/}.footer {padding: 60px 0;position: relative;text-align: center;font-size: 14px;border-top: 1px solid #dcdfe4;}.footer p:last-of-type{margin-bottom: 20px;}.footer_nav {list-style: none;padding: 0;margin: 0 0 10px;}.footer .fnav-menu{display: inline-block;position: relative;padding: 0 12px;}.fnav-menu a{position: relative;color: #293a46;}.fnav-menu:not(:last-child):after {content: ".";bottom: -6px;position: absolute;padding: 10px;right: auto;color: #000;}#SearchResultsDiv .col-md-3 {width: 25%;padding: 0;}#SearchResultsDiv, #search_result{max-width: 800px;margin: 20px auto 0;}.yt-mate-thumb{margin: 0 auto;vertical-align: middle;border: 0;padding: 0 15px;cursor: pointer;}.yt-mate-thumb .vi_thumimage {width: 100%;height: auto;}.search-info h3 {display: block;font-size: 14px;font-weight: 600;height: 42px;line-height: 19px;overflow: hidden;padding-top: 5px;text-align: left;text-decoration: none;margin: 0;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;  overflow: hidden;}.result_form .submit-video{border: none;background-color: transparent;color: #fff;vertical-align: middle;padding: 0 0 0 5px;cursor: pointer;}.downloaded-convert img{vertical-align: middle;}.downloaded-convert{display: inline-block;color: #fff;background-color: #5cb85c;border-color: #4cae4c;border: 1px solid transparent;border-radius: 4px;padding: 1px 6px;margin: 0 0 20px 0;cursor: pointer;}#search_result .col-md-5{width: 41.6667%;}#search_result .col-md-7{width: 58.3333%;}.convert-result .thumb_img{float: left;position: relative;width: 100%;}.convert-result{display: flex;}.convert-result .thumb_img img{max-width: 100%;height: auto;}.nav-tab {border-bottom: 1px solid #ddd;margin-bottom: 0;padding-left: 0;list-style: none;display: flex;flex-direction: row;}.nav-tab>li {float: left;margin-bottom: -1px;position: relative;display: inherit;cursor: pointer;}.nav-tab>li>button {border-radius: 2px 2px 0 0;color: #c10841;padding: 10px 20px 11px;transition: background-color .2s linear 0;font-weight: 700;font-size: 16px;margin-right: 2px;line-height: 1.42857143;border: 1px solid transparent;background-color: transparent;cursor: pointer;}.nav-tab>li.active>button, .nav-tab>li.active>button:focus, .nav-tab>li.active>button:hover {background-color: #eee;color: #555;border: 1px solid #ddd;border-bottom-color: transparent;cursor: default;}.tab-content .table-detail {border-top: 0;width: 100%;border: 1px solid #ddd;width: 100%;max-width: 100%;margin-bottom: 22px;}table {background-color: transparent;border-collapse: collapse;border-spacing: 0;}.table-detail>thead>tr>th, .table-detail>tbody>tr>td {padding: 20px;text-align: left;border-bottom: 1px solid #dcdfe4;border-top: 0;border: 1px solid #ddd;}.table-detail>thead>tr>th {font-size: 16px;font-weight: 400;text-align: left;}.table-detail>tbody>tr>td {font-size: 18px;}.tab-panel.active{display:block;}.tab-panel{display: none;}.nav-tabsection, .video_data{padding: 0 15px;}.tab-panel .fade{opacity: 0;-webkit-transition: opacity .15s linear;-o-transition: opacity .15s linear;transition: opacity .15s linear;}.y2link-download{color: #fff;}.img-title h3{margin: 0;text-align: left;display: block;}.table-detail tr .inn-button{display: flex;background-color: #5cb85c;border-color: #4cae4c;padding: 10px 10px;border: 1px solid transparent;border-radius: 4px;align-items: center;justify-content: space-evenly;}.mpd-button .y2-play-button{display: flex;background-color: #e71111;border-color: #e71111;padding: 10px 10px;border: 1px solid transparent;border-radius: 4px;align-items: center;}.mpd-button{display: flex;justify-content: space-around;}/*css for extension box start*/.extension.is-rolledUp {margin-right: 20px;border-radius: 5px;animation: extRollUp 2.6s ease-in-out;}.extension {position: fixed;bottom: 14px;right: 0;z-index: 1200;width: 220px;font-weight: 400;color: #fff;cursor: pointer;box-shadow: 0 2px 4px 0 rgb(0 0 0 / 19%);background: #c10841;transform: translateZ(0);}.is-rolledUp .extension-header {border-radius: 5px;background: #c10841;animation: extRollUpHeader 2.6s ease-in-out;}.extension-header {padding: 5px 10px;font-size: 0;line-height: 0;}.extension-headerImgContainer {display: inline-block;width: 56px;height: 60px;margin-right: 16px;vertical-align: middle;line-height: 60px;}.extension-headerImg {max-width: 100%;max-height: 100%;}.extension-headerText {display: inline-block;overflow: hidden;width: calc(100% - 56px - 16px);max-height: 150px;line-height: 1.25em;vertical-align: middle;font-size: 15px;font-weight: 700;}/*css for extension box end*/.spinner{margin: 70px auto;position: relative;}.show {margin: 100px auto;font-size: 8px;width: 8px;height: 8px;border-radius: 50%;position: relative;text-indent: -9999em;-webkit-animation: load5 1.1s infinite ease;animation: load5 1.1s infinite ease;-webkit-transform: translateZ(0);-ms-transform: translateZ(0);transform: translateZ(0);}/* Media query */@media (min-width: 768px){.search_form .y2mate_query{display: inline-block;vertical-align: middle;padding-right: 0 14px;font-size: 16px;box-shadow: none;}.navbar-toggler{display: none;}.col-sm-6 {width: 46%;display: inline-block;padding: 0 15px;}}@media (min-width: 1025px){.extension {display: block;animation: extAppear .8s ease-in-out;}}@media (max-width: 991px){.container{padding: 0 30px;}/*.col-sm-4{width: 28%;}*/#SearchResultsDiv .col-md-3{width: 33.33%;}}@media (max-width: 816px){.menu-navbar>li>a{padding: 26px 8px;}.table-detail>thead>tr>th, .table-detail>tbody>tr>td{padding: 20px 15px;}}@media (max-width: 767px){.convert-result{display: block;}/*  .mpd-button{justify-content: flex-start;}*/.nav-tabsection{padding: 15px 0 0 0;}/*.table-detail tr .inn-button{margin: 0 10px 0 0;}*/.table-detail>thead>tr>th, .table-detail>tbody>tr>td{padding: 16px 10px;}#search_result .col-md-5, #search_result .col-md-7{width: 100%;}.convert-result .thumb_img img{width: 100%;}.video_data {padding: 0;}.convert-btn .converter-btn{display: none;}.search_form .convert-btn {width: 60px;}.menu-navbar .navbar{display: block;line-height: 26px;}.header-menu .menu-navbar{text-align: left;float: initial;background-color: #f9f9f9;box-shadow: 0px 1px 2px #0000001f;}.header-menu {-webkit-transition: all 0.5s;position: absolute;left: 0;right: 0;margin: 0 auto;top: 60px;width: 100%;height: 0;visibility: hidden;opacity: 0;}.header-menu.collapse{visibility: visible;opacity: 1;height: 100vh;z-index: 10;}.dropdown-menu .lang-menu {position: static;float: none;width: auto;margin-top: 0;background-color: transparent;border: 0;-webkit-box-shadow: none;box-shadow: none;}.lang-menu>li>a{padding: 3px 10px;}.language{float: none;}.menu-navbar>li>a{display: block;padding: 10px;}.y2mate-instruction{display: block;}.y2mate-in-ad, .y2mate-instruction .y2mate-in-ad:nth-child(2n){width: 100%;padding: 0;}.y2mate-features-wrap {display: block;}.col-sm-4{width: 100%;padding: 0;}.y2mate-features-wrap h3{width: 100%;margin: 8px 0 0 0;}.y2mate-features-wrap h4{margin: 0px 0 18px 0;}.footer{padding: 20px 0;}.container{padding: 0 15px;}.container>.y2mate-download{margin: 0 -15px;}.form-wrap>.y2mate_title:first-child{font-size: 30px;}.search_form{margin: 24px auto;}.y2mate-download .form-wrap{padding: 26px 0 10px 0;}.y2mate-content, .y2mate-instruction, .y2mate-features-wrap, .y2mate-tips{padding: 25px 0px;}.search_form .y2mate_query{padding: 0 60px 0 10px;}.search_form .submit-btn{width: 60px;}.submit-btn input{visibility: hidden;}.submit-btn svg{position: absolute;}.left-arrow-search{position: absolute;}}@media (max-width: 575px){.y2mate-content h2{margin: 0;font-size: 22px;}.search_form p{font-size: 12px;}.search_form{margin: 22px auto 18px auto;}.footer .fnav-menu{padding: 0 8px;}#SearchResultsDiv .col-md-3{width: 50%;}.downloaded-convert{padding: 1px 4px;}.result_form .submit-video{padding: 0 0 0 4px;}.yt-mate-thumb{padding: 0 10px;}.container{padding: 0 12px;}.container>.y2mate-download{margin: 0 -12px;}.col-xs-12{width: 100%;}}</style>
</head>

<body>
<header class="nav-header">
    <div class="container">
        <div class="nav_head">
            <div class="navbar-logo">
                <a href="<?php echo get_page_url('/'); ?>">
                    <img height="46px" width="46px" src="/youtube.webp" alt="<?php echo __('site_name'); ?> logo">
                    <span class="logo-name"><?php echo __('site_name'); ?></span>
                </a>
            </div>
            <button type="button" class="navbar-toggler">
                <span class="toggle-icon"></span>
                <span class="toggle-icon"></span>
                <span class="toggle-icon"></span>
            </button>
        </div>

        <div class="header-menu">
            <ul class="menu-navbar">
                <li class="navbar"><a href="<?php echo get_page_url('/'); ?>"><?php echo __('nav.youtube_downloader', 'YouTube Downloader'); ?></a></li>
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
                            
                            echo '<li class="navbar"><a href="' . get_page_url('/' . $item['slug']) . '">' . htmlspecialchars($page_title) . '</a></li>';
                        }
                    }
                } else {
                    // 如果没有导航配置，显示默认导航
                    ?>


                    <?php
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
                            echo '<li class="navbar"><a href="' . htmlspecialchars($link['url']) . '" target="' . $target . '" rel="' . $rel . '">' . htmlspecialchars($link['title']) . '</a></li>';
                        }
                    }
                }
                ?>
                <li class="navbar language"><a href="javascript:void(0);"><?php 
                    $available_langs = get_available_languages();
                    $current_lang_name = $available_langs[$GLOBALS['site_lang']] ?? __('nav.language', 'English');
                    echo $current_lang_name; 
                ?><span class="shape"></span></a>
                    <div class="dropdown-menu">
                        <ul class="lang-menu">
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
                                
                                echo '<li><a data-lang="' . $lang_code . '" href="' . $lang_url . '">' . $lang_name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>