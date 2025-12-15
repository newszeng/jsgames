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
    <link rel="image_src" href="https://<?php echo $GLOBALS['site_domain']; ?>/assets/images/y2mate-min.jpg" />

    <!-- / Yoast SEO Premium plugin. -->

    <style>body{background-color:#ffffff;background-image:linear-gradient(#000000 200px, #ffffff 200px);background-repeat:no-repeat;font-family:Arial, sans-serif;font-size:14px;margin:0;}#header{display:flex;justify-content:center;max-width:600px;margin:0 auto;padding-top:20px;}#header a{color:#ecf1fc;text-decoration:none;margin-right:20px;}#header a:last-of-type{margin-right:0;}#logo{text-align:center;max-width:600px;margin:40px auto;}.search-form{color:#1e2a54;background-color:#ffffff;max-width:560px;border-radius:8px;box-shadow:0px 8px 8px rgba(21, 40, 88, 0.2);margin:0 auto;padding:20px;}.search-form div:nth-of-type(1){text-overflow:ellipsis;white-space:nowrap;}.search-form div:nth-of-type(2){margin-top:20px;display:flex;}.search-form div:nth-of-type(2) a{color:#ffffff;background-color:#121212;font-size:16px;line-height:48px;text-decoration:none;height:48px;border-radius:4px;display:inline-block;margin-right:20px;padding:0 10px;}.search-form div:nth-of-type(2) a:last-of-type{margin-right:0;}.search-form input{font-family:Arial, sans-serif;font-size:16px;height:48px;border-radius:4px;}.search-form .input{position:relative;width:82.14285714285714%;}.search-form input[type="text"]{width:100%;color:#5f698c;background-color:#f7f9ff;border:1px #d1d7e3 solid;padding:0 1.785714285714286%;outline:none;box-sizing:border-box;}.search-form input[type="submit"]{color:#ffffff;background-color:#121212;font-weight:normal;width:14.28571428571429%;border:none;margin-left:3.571428571428571%;padding:0;cursor:pointer;appearance:none;}.search-form #progress{color:#5f698c;background-color:#f7f9ff;font-size:16px;line-height:48px;text-align:center;height:48px;border:1px #d1d7e3 solid;border-radius:4px;align-items:center;justify-content:center;box-sizing:border-box;}i{width:16px;height:16px;border:2px transparent solid;border-top:2px #121212 solid;border-bottom:2px #121212 solid;border-radius:50%;margin-left:10px;display:block;animation:spin 2s linear infinite;}@keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}#text{max-width:600px;margin:40px auto;}#text h1{color:#1e2a54;font-size:24px;font-weight:normal;text-align:center;margin:0;}#text p{color:#000000;font-size:14px;line-height:24px;text-align:justify;margin:20px 0 0 0;}#text a{color:#000000;}#footer{display:flex;justify-content:center;max-width:600px;border-top:1px #d1d7e3 solid;margin:0 auto;padding:20px 0;}#footer a{color:#1e2a54;text-decoration:none;margin-right:20px;}#footer a:last-of-type{margin-right:0;}@media only screen and (max-width:600px) {form .input{width:75.14285714285714%;}.search-form input[type="submit"]{width:21.28571428571429%;}#text{width:92%;}#footer{font-size:12px;}}</style>
    <style>table{width:100%;border-collapse:collapse;}table th{text-align:left;}table th,table td{padding:7px 10px;border:1px solid #000000;}.suggest-results{position:absolute;z-index:100;top:100%;left:0;width:100%;max-height:184px;margin:0;padding:5px 0;overflow:auto;list-style:none;line-height:auto;background:#fff;-webkit-box-shadow:0 10px 15px rgba(0,0,0,0.1);box-shadow:0 10px 15px rgba(0,0,0,0.1);-webkit-border-radius:2px;border-radius:2px;}.suggest-results.hidden{display:none;}.suggest-results li{margin:0;padding:5px 15px;line-height:auto;cursor:pointer;}.suggest-results li:hover,.suggest-results li.active{background:#f5f5f5;}.convert-iframe{padding:1rem;background:#f5f5f5;}.convert-iframe iframe{display:block;width:100%;margin:0;border:none;}.list{display:flex;flex-direction:column;gap:1rem;margin:1.5rem 0;}.list > div{display:flex;align-items:center;gap:12px;}.list img{width:48px;height:48px;-o-object-fit:cover;object-fit:cover;-webkit-border-radius:4px;border-radius:4px;}.list h2{margin:0 0 5px 0;font-size:14px;font-weight:bold;}.list>div>div{font-size:12px;}.list a{text-decoration:none;}.search-list{display:flex;flex-direction:column;gap:1rem;}.search-list > div{display:flex;flex-direction:column;}.search-list .primary{display:flex;align-items:center;gap:12px;}.search-list img {width:64px;height:64px;-o-object-fit:cover;object-fit:cover;-webkit-border-radius:4px;border-radius:4px;}.search-list .info{flex:1;overflow:hidden;}.search-list h2{margin:0 0 8px 0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;font-size:14px;font-weight:normal;}.search-list button{display:inline-flex;align-items:center;margin-right:12px;padding:0 12px;height:32px;cursor:pointer;background:#121212;border:none;color:#fff;-webkit-border-radius:3px;border-radius:3px;}</style>

</head>

<body>
<div id="header">
    <a href="<?php
    $protocol = 'https';
    $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo $canonical_url;
    ?>">Home</a>
    <a href="#text">FAQ</a>
</div>

<div id="logo">
    <a href="<?php
    $protocol = 'https';
    $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo $canonical_url;
    ?>">
        <img src="https://<?php echo $GLOBALS['site_domain']; ?>/logo.svg" width="192" height="38" alt="Y2Mate" />
    </a>
</div>
<form autocomplete="off" method="post" action="/convert/" class="search-form">
    <div><label for="url">Enter Keywords or YouTube URL</label></div>
    <div>
        <div class="input">
            <input id="url" type="text" value="" name="q" placeholder="Search or Convert Here ..." required />
            <ul class="suggest-results hidden"></ul>
        </div>
        <input type="submit" value="Convert" />
    </div>
</form>

<div class="spinner" style="display: none;" id="loading">
    <img id="loading_img" src="/loading.gif">
</div>
<div id="downloadResult"></div>

