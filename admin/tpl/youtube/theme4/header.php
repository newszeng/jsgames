<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['site_lang'] ?? 'en'; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- This site is optimized with the Yoast SEO Premium plugin-->
    <title><?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?></title>

    <meta name="description" content="<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>">
    <meta name="keywords" content="y2mate,youtube downloader,youtube video downloader,youtube converter,youtube to mp3,youtube to mp3 converter,youtube mp3 downloader">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="<?php
    $protocol = 'https';
    $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo $canonical_url;
    ?>">
    <link rel="shortcut icon" href="https://<?php echo $GLOBALS['site_domain']; ?>/favicon.ico">
    <meta name="twitter:description" content="<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>" />
    <meta name="twitter:title" content="<?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?>" />
    <meta name="twitter:site" content="<?php echo __('site_name'); ?>" />
    <meta name="twitter:image" content="https://<?php echo $GLOBALS['site_domain']; ?>/assets/images/y2mate-min.jpg">
    <meta name="twitter:card" content="summary" />
    <meta property="og:site_name" content="<?php echo __('site_name'); ?>" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php
    $protocol = 'https';
    $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo $canonical_url;
    ?>" />
    <meta property="og:title" content="<?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?>" />
    <meta property="og:image" content="https://<?php echo $GLOBALS['site_domain']; ?>/assets/images/y2mate-min.jpg" />
    <meta property="og:description" content="<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>" />
    <meta property="og:image:type" content="image/jpeg" />
    <link rel="image_src" href="https://<?php echo $GLOBALS['site_domain']; ?>/assets/images/ytmp3-min.jpg" />

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo __('site_name'); ?>",
        "alternateName": "<?php echo __('home.h1', 'Youtube Downloader'); ?>",
        "Headline": "<?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?>",
        "description": "<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>"
    }
    </script>

    <!-- / Yoast SEO Premium plugin. -->

    <style>body,input{font-family:Arial,sans-serif}#b,#text,.search-form{margin:0 auto 30px}#text p,ul{line-height:24px;text-align:justify;margin:15px 0 0}#footer,#logo{text-align:center}#footer,#header{max-width:600px;margin:0 auto;padding:15px 0}body{font-size:14px;margin:0}.dark body{background-color:#13192d}table,table td,table th{border:1px solid #ccc}.dark table,.dark table td,.dark table th{border-color:#616a8a}#header{color:#111;border-bottom:1px solid #f3f1f1;display:flex;justify-content:space-between}.dark #header{color:#fff;border-color:#0e1323}.search-form #progress,input[type=text]{color:#494949;background-color:#fff;width:100%;box-sizing:border-box}#footer a,#header a{color:#111;text-decoration:none;margin-right:15px}.dark #header a,.dark #text h1,.dark .trending-title{color:#fff}#footer a:last-of-type,#header a:last-of-type,.search-form div:nth-of-type(2) a:last-of-type{margin-right:0}#header #theme{color:#0086e7;font-weight:700}#logo{max-width:600px;margin:15px auto}.search-form{color:#707070;max-width:600px;border-radius:3px;padding:15px;box-sizing:border-box}html:not(.dark) #collapse .opener,html:not(.dark) .search-form{background-image:linear-gradient(#fff,#f4f4f4);border:1px solid #f3f1f1}.search-form div:nth-of-type(2) a,input{border-radius:3px;height:48px;font-size:16px}.dark #collapse .opener,.dark .search-form{color:#fff;background-color:#0e1323}.search-form div:nth-of-type(2){margin-top:15px;display:flex}.search-form div:nth-of-type(2) a{color:#fff;background-color:#0086e7;line-height:48px;text-decoration:none;margin-right:15px;padding:0 15px;display:block}.search-form div:nth-of-type(3){text-align:right}.search-form div:nth-of-type(3) a{color:#0086e7;font-weight:700;text-decoration:none}.dark .search-form #progress,.dark input[type=text]{color:#959ebd;background-color:#1d243d}.search-form #progress,html:not(.dark) input[type=text]{border:1px solid #0086e7}.search-form .input{position:relative;flex:1}input[type=text]{padding:0 1.754385964912281%;outline:0}.dark input[type=text]{border:none}.dark input[type=submit],input[type=submit]{color:#fff;background-color:#0086e7}input[type=submit]{font-weight:400;width:15.78947368421053%;border:none;margin-left:2.631578947368421%;padding:0;cursor:pointer;appearance:none}.search-form #progress{font-size:16px;line-height:48px;height:48px;border-radius:3px;align-items:center;justify-content:center}.search-form i{border:3px solid #fff;border-top:3px solid #0086e7;border-bottom:3px solid #0086e7;border-radius:50%;width:16px;height:16px;animation:2s linear infinite spin;margin-left:5px;display:block}@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}#b{max-width:600px;height:78px}#b iframe{border:none}#text{max-width:600px}#text h1{color:#111;font-size:24px;font-weight:400;margin:0}#text span,ul p{font-weight:700}.dark #collapse .opener+div,.dark #collapse .opener+div a,.dark #footer a,.dark #text,.dark #text a,.dark ul{color:#616a8a}#collapse .opener+div a,#text a,html:not(.dark) #text p,ul{color:#494949}#collapse .opener{color:#111;font-size:16px;font-weight:700;border-radius:3px;margin-top:15px;padding:15px;cursor:pointer;user-select:none;box-sizing:border-box}#collapse .opener+div{color:#494949;line-height:24px;text-align:justify;margin:15px 0;padding:0 15px;display:none}ul{padding:0 0 0 15px;list-style-type:lower-alpha}ul li{margin-bottom:15px}ul li:last-of-type{margin-bottom:0}ul li ul{list-style-type:lower-roman;padding-left:15px}ul p{color:#111!important;text-align:center!important;margin:15px 0}.dark ul p{color:#fff!important}.nomargin{margin-top:0!important}#footer{border-top:1px solid #f3f1f1}.dark #footer{border-color:#0e1323}@media only screen and (max-width:600px){#header{width:100%;border:none;padding:0;flex-wrap:wrap-reverse;justify-content:center}#header div{text-align:center;width:100%;border-bottom:1px solid #f3f1f1;padding:15px 0}.dark #header div{border-color:#0e1323}#header div:first-of-type a:nth-child(3){display:none}input[type=submit]{width:20.78947368421053%}#text{width:92%}#footer a{font-size:12px}}</style>

    <style>#header div:first-child,#footer{display:flex;justify-content:center;}table{width:100%;border-collapse:collapse;}table th{text-align:left;}table th,table td{padding:7px 10px;}.suggest-results{position:absolute;z-index:100;top:100%;left:0;width:100%;max-height:198px;margin:0;padding:5px 0;overflow:auto;list-style:none;line-height:auto;background:#fff;-webkit-box-shadow:0 10px 15px rgba(0,0,0,0.1);box-shadow:0 10px 15px rgba(0,0,0,0.1);-webkit-border-radius:2px;border-radius:2px;}.suggest-results.hidden{display:none;}.suggest-results li{margin:0;padding:2px 15px;line-height:auto;cursor:pointer;}.suggest-results li:hover,.suggest-results li.active{background:#f5f5f5;}#text h1.center{text-align:center;}.trending-title{margin-top:1rem;padding-left:0.75rem;font-size:18px;font-weight:normal;border-left:3px solid #0086e7;}.list{display:flex;flex-direction:column;gap:1rem;margin:1.5rem 0;}.list > div{display:flex;align-items:center;gap:12px;}.list img{width:48px;height:48px;-o-object-fit:cover;object-fit:cover;-webkit-border-radius:4px;border-radius:4px;}.list h2{margin:0 0 5px 0;font-size:14px;font-weight:bold;}.list>div>div{font-size:12px;}.list a{text-decoration:none;}#ajax-results{margin-top:1.5rem;}#ajax-results .loader{display:flex;justify-content:center}.dark #ajax-results .loader{color:#fff}.search-list{display:flex;flex-direction:column;gap:1rem;}.search-list > div{display:flex;flex-direction:column;}.search-list .primary{display:flex;align-items:center;gap:12px;}.search-list img {width:64px;height:64px;-o-object-fit:cover;object-fit:cover;-webkit-border-radius:4px;border-radius:4px;}.search-list .info{flex:1;overflow:hidden;}.search-list h2{margin:0 0 8px 0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;font-size:14px;font-weight:normal;}.search-list button{display:inline-flex;align-items:center;margin-right:12px;padding:0 12px;height:32px;cursor:pointer;background:#0086e7;border:none;color:#fff;-webkit-border-radius:3px;border-radius:3px;}.dark .list h2 a,.dark .search-list h2 {color: #fff!important;}.convert-iframe{padding:1rem;background:#f5f5f5;}.convert-iframe iframe{display:block;width:100%;margin:0;border:none;}#footer{justify-content:center;}@keyframes spin{from {transform:rotate(0deg);}to{transform:rotate(360deg);}}li a{color:#777;text-decoration:none;padding:0 10px}@media(max-width:767px){.footer-nav-area .footer-nav li a{display:block;padding:10px 0}}.footer-nav-area .footer-nav li a:hover{text-decoration:underline}table,th,td{border:1px solid}th,td{padding:5px}</style>

    <script>
        try {
            if ((!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) || localStorage.theme === 'dark') {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        } catch (_) {}
    </script>

</head>

<body>
<div id="header">
    <div>
        <a href="<?php
        $protocol = 'https';
        $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        echo $canonical_url;
        ?>">Home</a>
        <a href="/#text">FAQ</a>
    </div>

    <div>Dark Theme: <a id="theme" href="#" rel="nofollow">Off</a></div>
</div>

<div id="logo">
    <a href="<?php
    $protocol = 'https';
    $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo $canonical_url;
    ?>">
        <img src="/ytmp3.svg" width="144" height="70" title="<?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?>" alt="<?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?>">
    </a>
</div>

<form autocomplete="off" method="post" class="search-form">
    <div>
        <label for="url">Please insert a valid YouTube video URL or Keywords</label>
    </div>

    <div>
        <div class="input">
            <input id="url" type="text" name="q" value="" placeholder="Enter Keywords or YouTube URL here..." required />
            <ul class="suggest-results hidden"></ul>
        </div>
        <input type="submit" value="Convert" />
    </div>
</form>

<div class="spinner" style="display: none;" id="loading">
    <img id="loading_img" src="/loading.gif">
</div>
<div id="downloadResult"></div>