<?php

// 前台入口文件
// 支持调试访问模式：index.php?domain=xxx&lang=xxx
$domain = $_GET['domain'] ?? $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// 调试模式：从GET参数获取页面和语言信息
$debug_mode = isset($_GET['domain']);
$debug_lang = $_GET['lang'] ?? null;
$debug_page = $_GET['page'] ?? null;

// 定义全球39种语言
$GLOBALS['all_languages'] = [
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

// Admin 目录现在直接通过 .htaccess 处理，不再通过 index.php

// 检查是否是静态文件请求
if (strpos($path, '/static/') === 0) {
    $static_file = ltrim($path, '/');
    if (file_exists($static_file)) {
        // 设置适当的 Content-Type
        $ext = pathinfo($static_file, PATHINFO_EXTENSION);
        $mime_types = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon'
        ];
        
        if (isset($mime_types[$ext])) {
            header('Content-Type: ' . $mime_types[$ext]);
        }
        
        readfile($static_file);
        exit();
    }
}

// 检查网站维护状态
$websites_file = 'admin/data/websites.json';
if (file_exists($websites_file)) {
    $websites = json_decode(file_get_contents($websites_file), true) ?: [];
    foreach ($websites as $site) {
        if ($site['domain'] == $domain) {
            // 兼容旧版本的 active 字段
            $status = isset($site['status']) ? $site['status'] : (isset($site['active']) && $site['active'] ? 'active' : 'inactive');
            
            if ($status === 'maintenance') {
                // 检查是否有调试参数
                $has_debug_param = isset($_GET['debug']) && $_GET['debug'] == '1';
                $has_debug_cookie = isset($_COOKIE['debug_mode']) && $_COOKIE['debug_mode'] == '1';
                
                if ($has_debug_param) {
                    // 设置调试cookie，有效期1小时
                    setcookie('debug_mode', '1', time() + 3600, '/', $domain);
                } elseif (!$has_debug_cookie) {
                    // 显示维护页面
                    http_response_code(503);
                    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>maintenance</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
        .maintenance { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .icon { font-size: 64px; color: #f39c12; margin-bottom: 20px; }
        h1 { color: #333; margin-bottom: 20px; }
        p { color: #666; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="maintenance">
        <div class="icon">🔧</div>
        <h1>maintenance...</h1>
    </div>
</body>
</html>';
                    exit();
                }
            }
            break;
        }
    }
}

// 路由配置文件
$router_file = "router/{$domain}/router.json";
if (!file_exists($router_file)) {
    http_response_code(404);
    echo "<a href='https://y2mate.tools'>visit here</a><br>";
    die('Site not configured');
}

$router = json_decode(file_get_contents($router_file), true);
$routes = $router['routes'] ?? [];
$redirects = $router['redirects'] ?? [];
$default_lang = $router['default_lang'] ?? 'en';
$languages = $router['languages'] ?? ['en'];

// 检查重定向
if (isset($redirects[$path])) {
    $redirect = $redirects[$path];
    $status = $redirect['type'] == '301' ? 301 : 302;
    header("Location: " . $redirect['to'], true, $status);
    exit();
}

// 智能重定向逻辑：检查当前URL是否为该语言的最终链接
function findLanguageFinalUrl($lang, $redirects, $default_lang) {
    // 查找该语言的最终重定向目标
    $search_path = ($lang === $default_lang) ? '/' : "/{$lang}";
    
    if (isset($redirects[$search_path])) {
        return $redirects[$search_path]['to'];
    }
    
    return null;
}

function shouldRedirectToFinal($current_path, $detected_lang, $redirects, $default_lang) {
    $final_url = findLanguageFinalUrl($detected_lang, $redirects, $default_lang);
    
    // 如果找到了最终URL，且当前URL不是最终URL，则需要重定向
    if ($final_url && $current_path !== $final_url) {
        return $final_url;
    }
    
    return null;
}

// 解析路径
$path_parts = array_filter(explode('/', $path));
$original_path_parts = $path_parts; // 保留原始路径部分用于重定向检查
$lang = $default_lang;
$page_slug = '';

// 检查是否是语言+标签的组合路径，需要在语言检测之前处理
if (!empty($path_parts) && count($path_parts) >= 2) {
    $path_parts_indexed = array_values($path_parts);
    $potential_lang = $path_parts_indexed[0];
    $potential_slug = implode('/', array_slice($path_parts_indexed, 1));
    
    if (in_array($potential_lang, $languages)) {
        // 这是一个语言+标签的路径，检查是否需要重定向到混淆URL
        $final_lang_url = findLanguageFinalUrl($potential_lang, $redirects, $default_lang);
        
        // 对于默认语言，比较路径应该是 '/' 而不是 '/en'
        $expected_original_path = ($potential_lang === $default_lang) ? '/' : "/{$potential_lang}";
        
        if ($final_lang_url && $final_lang_url !== $expected_original_path) {
            // 需要重定向到混淆URL+标签
            $redirect_url = $final_lang_url . '/' . $potential_slug;
            header("Location: " . $redirect_url, true, 301);
            exit();
        }
    }
}

// 检测语言
if ($debug_mode && $debug_lang) {
    // 调试模式：直接使用GET参数中的语言
    $lang = $debug_lang;
} else if (!empty($path_parts)) {
    $first = reset($path_parts);
    if (in_array($first, $languages)) {
        $lang = $first;
        array_shift($path_parts);
    }
}

// 获取页面slug
if ($debug_mode && $debug_page) {
    // 调试模式：使用GET参数中的页面
    $page_slug = $debug_page;
} else if (!empty($path_parts)) {
    $page_slug = implode('/', $path_parts);
}

// 确定要加载的模板
$template = '';
$template_data = [];

// 检查静态路由 static.php
$check_path = '/' . ($page_slug ?: '');
if (isset($routes[$check_path])) {
    $route = $routes[$check_path];
    $template = $route['template'];
    $template_data = $route;
    
    // 如果路由中指定了语言，更新当前语言
    if (isset($route['lang'])) {
        $lang = $route['lang'];
    }
}

//var_dump($path_parts);exit;
// 检查标签页面（在语言检测后处理）
if (!$template && !empty($path_parts)) {
    // 检查是否是混淆URL+标签的组合（如 /en5800/youtube-to-mp4）
    if (count($path_parts) >= 2) {
        $path_parts_indexed = array_values($path_parts);
        $potential_obfuscated = $path_parts_indexed[0];
        $potential_slug = implode('/', array_slice($path_parts_indexed, 1));
        
        // 检查第一部分是否是混淆URL格式
        if (preg_match('/^([a-z]{2})[A-Za-z0-9]+$/', $potential_obfuscated, $matches)) {
            $detected_lang = $matches[1];
            if (in_array($detected_lang, $languages)) {
                // 检查当前混淆URL+标签是否为该语言的最终链接
                $final_lang_url = findLanguageFinalUrl($detected_lang, $redirects, $default_lang);
                if ($final_lang_url && '/' . $potential_obfuscated !== $final_lang_url) {
                    // 需要重定向到最终的混淆URL+标签
                    $redirect_url = $final_lang_url . '/' . $potential_slug;
                    header("Location: " . $redirect_url, true, 301);
                    exit();
                }
                
                // 检查标签页面是否存在
                $tag_page_file = "pages/{$domain}/{$potential_slug}/{$detected_lang}.json";
                if (file_exists($tag_page_file)) {
                    $lang = $detected_lang;
                    $template = 'page.php';
                    $template_data = [
                        'type' => 'page',
                        'slug' => $potential_slug,
                        'lang' => $lang
                    ];
                }
            }
        }
    } 
    
    // 如果不是混淆URL+标签，检查单独的混淆URL
    if (!$template && count($path_parts) == 1) {
        $page_slug = reset($path_parts);
        // 检查是否是混淆URL（格式：不包含/且前2个字母是语言代码）
        if (preg_match('/^([a-z]{2})[A-Za-z0-9]+$/', $page_slug, $matches)) {
            $detected_lang = $matches[1];
            if (in_array($detected_lang, $languages)) {
                // 检查当前混淆URL是否为该语言的最终链接
                $redirect_url = shouldRedirectToFinal('/' . $page_slug, $detected_lang, $redirects, $default_lang);
                if ($redirect_url) {
                    // 末尾加 / , 目录权重高
                    header("Location: " . rtrim($redirect_url,"/")."/", true, 301);
                    exit();
                }
                
                // 如果是最终链接，则处理混淆URL
                $lang = $detected_lang;
                $template = 'home.php';
                $template_data = [
                    'type' => 'home'
                ];
            }
        }
    }
    
    // 如果还没有匹配到，检查是否是普通标签页
    if (!$template && count($path_parts) == 1) {
        $page_slug = reset($path_parts);
        $tag_page_file = "pages/{$domain}/{$page_slug}/{$lang}.json";
        if (file_exists($tag_page_file)) {
            $template = 'page.php';
            $template_data = [
                'type' => 'page',
                'slug' => $page_slug,
                'lang' => $lang
            ];
        }
    }
}

// 检查根路径是否需要重定向（当访问 / 时）
if ($check_path === '/' && !$template) {
    $redirect_url = shouldRedirectToFinal($path, $default_lang, $redirects, $default_lang);
    if ($redirect_url) {
        header("Location: " . $redirect_url, true, 301);
        exit();
    }
}


// 如果没有找到模板，到首页
if (!$template) {
    // 调试模式：直接设置模板
    if ($debug_mode) {
        if ($debug_page) {
            // 静态页面
            $template = 'static.php';
            $template_data = [
                'type' => 'static',
                'page' => $debug_page,
                'slug' => $debug_page,
                'lang' => $lang
            ];
        } else {
            // 首页
            $template = 'index.html';
            $template_data = ['type' => 'home'];
        }
    } else {
        header("Location: /" , true, 301);
        exit();

        http_response_code(404);
        $template = $router['404_page']['template'] ?? '404.php';
        $template_data = $router['404_page'] ?? [];
    }
}

// 设置全局变量
$GLOBALS['site_domain'] = $domain;
$GLOBALS['site_lang'] = $lang;
$GLOBALS['template_data'] = $template_data;
$GLOBALS['default_lang'] = $default_lang;

// 加载语言文件
$lang_file = "i18n/{$domain}/{$lang}.json";
$lang_data = [];
if (file_exists($lang_file)) {
    $lang_data = json_decode(file_get_contents($lang_file), true) ?: [];
}
$GLOBALS['lang_data'] = $lang_data;

// 如果是首页，从语言包获取 home.title
if ($template === 'home.php' && isset($lang_data['home']['title'])) {
    $template_data['title'] = $lang_data['home']['title'];
    $GLOBALS['template_data'] = $template_data;
}

// 初始化模板引擎 (PHP 7.3 兼容版本)
if (file_exists('vendor/autoload.php')) {
    // 使用 Twig (如果 Composer 可用)
    require_once 'vendor/autoload.php';
    
    $loader = new \Twig\Loader\FilesystemLoader("tpl/{$domain}");
    $twig = new \Twig\Environment($loader, [
        'cache' => false,
        'debug' => true,
    ]);
    
    $twig->addFunction(new \Twig\TwigFunction('__', function($key, $default = '') {
        return __($key, $default);
    }));
    
    $twig->addFunction(new \Twig\TwigFunction('get_language_url', function($lang = null) {
        return get_language_url($lang);
    }));
    
    $twig->addFunction(new \Twig\TwigFunction('get_page_url', function($page, $lang = null) {
        return get_page_url($page, $lang);
    }));
    
    $twig->addFunction(new \Twig\TwigFunction('get_static_url', function($path) {
        return get_static_url($path);
    }));
    
    $use_twig = true;
} else {
    // 使用简单模板引擎 (备用方案)
    require_once 'simple_template.php';
    
    $template_engine = new SimpleTemplate("tpl/{$domain}");
    $template_engine->addFunction('__', '__');
    $template_engine->addFunction('get_language_url', 'get_language_url');
    $template_engine->addFunction('get_page_url', 'get_page_url');
    $template_engine->addFunction('get_static_url', 'get_static_url');
    
    $use_twig = false;
}

// 准备模板数据
$template_vars = array_merge($template_data, [
    'domain' => $domain,
    'current_lang' => $lang,
    'available_languages' => get_available_languages(),
    'lang_data' => $lang_data,
    'current_path' => $_SERVER['REQUEST_URI'],
]);

// 从网站配置获取站点信息
$websites_file = 'admin/data/websites.json';
if (file_exists($websites_file)) {
    $websites = json_decode(file_get_contents($websites_file), true) ?: [];
    foreach ($websites as $site) {
        if ($site['domain'] == $domain) {
            $template_vars = array_merge($template_vars, [
                'site_name' => $site['site_name'] ?? 'Game Site',
                'tagline' => $site['tagline'] ?? '',
                'game_type' => $site['type'] ?? 'wordle',
                'theme' => $site['theme'] ?? 'theme1',
            ]);
            break;
        }
    }
}

// 渲染模板
try {
    // 如果是首页，使用 index.html
    if ($template === 'home.php') {
        $template = 'index.html';
    }
    
    if ($use_twig) {
        echo $twig->render($template, $template_vars);
    } else {
        echo $template_engine->render($template, $template_vars);
    }
} catch (Exception $e) {
    http_response_code(500);
    die('Template error: ' . htmlspecialchars($e->getMessage()));
}

// 辅助函数
function __($key, $default = '') {
    $keys = explode('.', $key);
    $value = $GLOBALS['lang_data'];
    
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default ?: $key;
        }
    }
    
    return $value;
}

function get_static_url($path) {
    return '/static/' . $GLOBALS['site_domain'] . '/' . ltrim($path, '/');
}

function get_page_url($page, $lang = null) {
    if ($lang === null) {
        $lang = $GLOBALS['site_lang'];
    }
    $default_lang = $GLOBALS['default_lang'];
    if ($page == '/') {
        return $lang == $default_lang ? '/' : "/{$lang}";
    }
    if ($lang == $default_lang && stripos($page,"-")===false ) {
        return $page;
    }
    return "/{$lang}" . $page;
}

function get_language_url($lang = null) {
    if ($lang === null) {
        $lang = $GLOBALS['site_lang'];
    }
    
    $default_lang = $GLOBALS['default_lang'];
    
    // 获取路由配置
    $router_file = "router/{$GLOBALS['site_domain']}/router.json";
    if (file_exists($router_file)) {
        $router_data = json_decode(file_get_contents($router_file), true) ?: [];
        $redirects = $router_data['redirects'] ?? [];
        
        // 查找该语言在redirects中的最终目标
        $search_path = ($lang === $default_lang) ? '/' : "/{$lang}";
        
        if (isset($redirects[$search_path])) {
            return $redirects[$search_path]['to'];
        }
    }
    
    // 如果没有配置重定向，使用默认的语言路径
    return $lang == $default_lang ? '/' : "/{$lang}";
}

// 获取站点可用的语言包
function get_available_languages() {
    $domain = $GLOBALS['site_domain'];
    $i18n_dir = "i18n/{$domain}/";
    $languages = [];
    if (is_dir($i18n_dir)) {
        $files = glob($i18n_dir . '*.json');
        foreach ($files as $file) {
            $lang_code = basename($file, '.json');
            if (isset($GLOBALS['all_languages'][$lang_code])) {
                $languages[$lang_code] = $GLOBALS['all_languages'][$lang_code];
            }
        }
    }
    return $languages;
}