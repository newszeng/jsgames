<?php

declare(strict_types=1);

$domain = $_GET['domain'] ?? ($_SERVER['HTTP_HOST'] ?? '');
$lang = $_GET['lang'] ?? null;
$template = $_GET['template'] ?? null;
$refresh = isset($_GET['refresh']) ? (int)$_GET['refresh'] : 0;
$source = $_GET['source'] ?? 'site';

$theme = $_GET['theme'] ?? 'theme1';

function isValidDomainSegment(string $value): bool {
    return (bool)preg_match('/^[a-zA-Z0-9.-]+$/', $value);
}

function isValidMasterTheme(string $value): bool {
    return in_array($value, ['theme1', 'theme2'], true);
}

function h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$root = __DIR__;
$tplRoot = $root . DIRECTORY_SEPARATOR . 'tpl';

$isMasterPreview = is_string($source) && strtolower($source) === 'master';
$masterTheme = is_string($theme) && isValidMasterTheme($theme) ? $theme : 'theme1';
$masterTplDir = $root . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'wordle' . DIRECTORY_SEPARATOR . $masterTheme;

$availableDomains = [];
if ($isMasterPreview) {
    $routerRoot = $root . DIRECTORY_SEPARATOR . 'router';
    if (is_dir($routerRoot)) {
        $items = scandir($routerRoot);
        if (is_array($items)) {
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $p = $routerRoot . DIRECTORY_SEPARATOR . $item;
                if (is_dir($p) && isValidDomainSegment($item)) {
                    $availableDomains[] = $item;
                }
            }
        }
    }
} else {
    if (is_dir($tplRoot)) {
        $items = scandir($tplRoot);
        if (is_array($items)) {
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                $p = $tplRoot . DIRECTORY_SEPARATOR . $item;
                if (is_dir($p) && isValidDomainSegment($item)) {
                    $availableDomains[] = $item;
                }
            }
        }
    }
}

sort($availableDomains);

if (!is_string($domain) || $domain === '' || !isValidDomainSegment($domain) || !in_array($domain, $availableDomains, true)) {
    $domain = $availableDomains[0] ?? '';
}

if ($domain === '') {
    http_response_code(500);
    echo $isMasterPreview ? 'No router/* domain directory found.' : 'No tpl/* domain directory found.';
    exit;
}

$tplDir = $isMasterPreview ? $masterTplDir : ($tplRoot . DIRECTORY_SEPARATOR . $domain);

if ($isMasterPreview && !is_dir($tplDir)) {
    http_response_code(500);
    echo 'Master theme directory not found: ' . h($tplDir);
    exit;
}

$availableTemplates = [];
if (is_dir($tplDir)) {
    $files = scandir($tplDir);
    if (is_array($files)) {
        foreach ($files as $f) {
            if ($f === '.' || $f === '..') {
                continue;
            }
            $fp = $tplDir . DIRECTORY_SEPARATOR . $f;
            if (is_file($fp) && preg_match('/\.(html|php|twig)$/i', $f)) {
                $availableTemplates[] = $f;
            }
        }
    }
}

sort($availableTemplates);

if (!is_string($template) || $template === '' || !in_array($template, $availableTemplates, true)) {
    $template = in_array('index.html', $availableTemplates, true) ? 'index.html' : ($availableTemplates[0] ?? '');
}

if ($template === '') {
    http_response_code(500);
    echo 'No template file found in tpl/' . h($domain) . '/';
    exit;
}

$routerFile = $root . DIRECTORY_SEPARATOR . 'router' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'router.json';
$router = [];
if (is_file($routerFile)) {
    $router = json_decode((string)file_get_contents($routerFile), true) ?: [];
}

$defaultLang = $router['default_lang'] ?? 'en';
$routerLanguages = $router['languages'] ?? [$defaultLang];

if ($lang === null || !is_string($lang) || $lang === '' || !in_array($lang, $routerLanguages, true)) {
    $lang = $defaultLang;
}

$langFile = $root . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . $lang . '.json';
$langData = [];
if (is_file($langFile)) {
    $langData = json_decode((string)file_get_contents($langFile), true) ?: [];
}

$langDataSource = is_file($langFile) ? ('i18n/' . $domain . '/' . $lang . '.json') : '';

if ($isMasterPreview && !$langDataSource) {
    $masterLangFile = $root . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . 'wordle' . DIRECTORY_SEPARATOR . $masterTheme . DIRECTORY_SEPARATOR . $lang . '.json';
    if (is_file($masterLangFile)) {
        $langData = json_decode((string)file_get_contents($masterLangFile), true) ?: [];
        $langDataSource = 'admin/i18n/wordle/' . $masterTheme . '/' . $lang . '.json';
    }
}

$GLOBALS['site_domain'] = $domain;
$GLOBALS['site_lang'] = $lang;
$GLOBALS['default_lang'] = $defaultLang;
$GLOBALS['lang_data'] = $langData;
$GLOBALS['is_master_preview'] = $isMasterPreview;
$GLOBALS['master_theme'] = $masterTheme;

if (!function_exists('__')) {
    function __(string $key, string $default = '') {
        $keys = explode('.', $key);
        $value = $GLOBALS['lang_data'] ?? [];

        foreach ($keys as $k) {
            if (is_array($value) && array_key_exists($k, $value)) {
                $value = $value[$k];
            } else {
                return $default !== '' ? $default : $key;
            }
        }

        return $value;
    }
}

if (!function_exists('get_static_url')) {
    function get_static_url(string $path): string {
        $isMasterPreview = (bool)($GLOBALS['is_master_preview'] ?? false);
        if ($isMasterPreview) {
            return '/admin/static/wordle/' . ($GLOBALS['master_theme'] ?? 'theme1') . '/' . ltrim($path, '/');
        }

        return '/static/' . ($GLOBALS['site_domain'] ?? '') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('get_language_url')) {
    function get_language_url(?string $lang = null): string {
        $lang = $lang ?: ($GLOBALS['site_lang'] ?? 'en');
        $defaultLang = $GLOBALS['default_lang'] ?? 'en';

        $routerFile = __DIR__ . DIRECTORY_SEPARATOR . 'router' . DIRECTORY_SEPARATOR . ($GLOBALS['site_domain'] ?? '') . DIRECTORY_SEPARATOR . 'router.json';
        if (is_file($routerFile)) {
            $routerData = json_decode((string)file_get_contents($routerFile), true) ?: [];
            $redirects = $routerData['redirects'] ?? [];
            $searchPath = ($lang === $defaultLang) ? '/' : "/{$lang}";
            if (isset($redirects[$searchPath]['to'])) {
                return $redirects[$searchPath]['to'];
            }
        }

        return $lang === $defaultLang ? '/' : "/{$lang}";
    }
}

if (!function_exists('get_page_url')) {
    function get_page_url(string $page, ?string $lang = null): string {
        $lang = $lang ?: ($GLOBALS['site_lang'] ?? 'en');
        $defaultLang = $GLOBALS['default_lang'] ?? 'en';

        if ($page === '/') {
            return $lang === $defaultLang ? '/' : "/{$lang}";
        }

        if ($lang === $defaultLang && stripos($page, "-") === false) {
            return $page;
        }

        return "/{$lang}" . $page;
    }
}

$templateVars = [
    'domain' => $domain,
    'current_lang' => $lang,
    'available_languages' => [],
    'lang_data' => $langData,
    'lang_data_source' => $langDataSource,
    'current_path' => '/?preview_theme=1&source=' . rawurlencode((string)$source) . '&theme=' . rawurlencode($masterTheme) . '&domain=' . rawurlencode($domain) . '&lang=' . rawurlencode($lang) . '&template=' . rawurlencode($template),
    'site_name' => $domain,
    'tagline' => '',
    'theme' => $masterTheme,
    'page_title' => 'Preview - ' . $domain,
    'page_description' => '',
    'page_keywords' => '',
];

$i18nDir = $root . DIRECTORY_SEPARATOR . 'i18n' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR;
if (is_dir($i18nDir)) {
    $files = glob($i18nDir . '*.json') ?: [];
    foreach ($files as $f) {
        $code = basename($f, '.json');
        if (preg_match('/^[a-z]{2,3}$/', $code)) {
            $templateVars['available_languages'][$code] = strtoupper($code);
        }
    }
}

$websitesFile = $root . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'websites.json';
if (is_file($websitesFile)) {
    $websites = json_decode((string)file_get_contents($websitesFile), true) ?: [];
    foreach ($websites as $site) {
        if (is_array($site) && ($site['domain'] ?? '') === $domain) {
            $templateVars['site_name'] = $site['site_name'] ?? $templateVars['site_name'];
            $templateVars['tagline'] = $site['tagline'] ?? $templateVars['tagline'];
            $templateVars['theme'] = $site['theme'] ?? $templateVars['theme'];
            $templateVars['analytics_id'] = $site['analytics_id'] ?? null;
            $templateVars['adsense_id'] = $site['adsense_id'] ?? null;
            break;
        }
    }
}

$rendered = '';
try {
    if (is_file($root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
        require_once $root . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

        $loader = new \Twig\Loader\FilesystemLoader($tplDir);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
            'debug' => true,
            'autoescape' => false,
        ]);

        $twig->addFunction(new \Twig\TwigFunction('__', function ($key, $default = '') {
            return __((string)$key, (string)$default);
        }));
        $twig->addFunction(new \Twig\TwigFunction('get_language_url', function ($lang = null) {
            return get_language_url($lang === null ? null : (string)$lang);
        }));
        $twig->addFunction(new \Twig\TwigFunction('get_page_url', function ($page, $lang = null) {
            return get_page_url((string)$page, $lang === null ? null : (string)$lang);
        }));
        $twig->addFunction(new \Twig\TwigFunction('get_static_url', function ($path) {
            return get_static_url((string)$path);
        }));

        $rendered = $twig->render($template, $templateVars);
    } else {
        require_once $root . DIRECTORY_SEPARATOR . 'simple_template.php';
        $engine = new SimpleTemplate($tplDir);
        $engine->addFunction('__', '__');
        $engine->addFunction('get_language_url', 'get_language_url');
        $engine->addFunction('get_page_url', 'get_page_url');
        $engine->addFunction('get_static_url', 'get_static_url');

        $rendered = $engine->render($template, $templateVars);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Preview render error: ' . h($e->getMessage());
    exit;
}

if ($refresh > 0) {
    $rendered = preg_replace('/<head(\s[^>]*)?>/i', '$0' . "\n" . '<meta http-equiv="refresh" content="' . (int)$refresh . '">', $rendered, 1);
}

$toolbar = '<div style="position:fixed;left:0;right:0;bottom:0;z-index:99999;background:rgba(0,0,0,.75);color:#fff;padding:10px 12px;font:12px/1.4 -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica,Arial,sans-serif;">'
    . '<form method="get" style="margin:0;display:flex;flex-wrap:wrap;gap:8px;align-items:center;">'
    . '<input type="hidden" name="preview_theme" value="1">'
    . '<input type="hidden" name="source" value="' . h((string)$source) . '">'
    . ($isMasterPreview ? '<label>theme <select name="theme" onchange="this.form.submit()">'
        . '<option value="theme1"' . ($masterTheme === 'theme1' ? ' selected' : '') . '>theme1</option>'
        . '<option value="theme2"' . ($masterTheme === 'theme2' ? ' selected' : '') . '>theme2</option>'
        . '</select></label>' : '')
    . '<label>domain <select name="domain" onchange="this.form.submit()">';

foreach ($availableDomains as $d) {
    $toolbar .= '<option value="' . h($d) . '"' . ($d === $domain ? ' selected' : '') . '>' . h($d) . '</option>';
}

$toolbar .= '</select></label>'
    . '<label>template <select name="template" onchange="this.form.submit()">';

foreach ($availableTemplates as $t) {
    $toolbar .= '<option value="' . h($t) . '"' . ($t === $template ? ' selected' : '') . '>' . h($t) . '</option>';
}

$toolbar .= '</select></label>'
    . '<label>lang <input name="lang" value="' . h($lang) . '" style="width:64px"></label>'
    . '<label>refresh <input name="refresh" value="' . ($refresh > 0 ? (int)$refresh : '') . '" placeholder="sec" style="width:64px"></label>'
    . '<button type="submit" style="padding:4px 10px;cursor:pointer;">Apply</button>'
    . '<span style="opacity:.85">Source: ' . ($isMasterPreview ? 'master' : 'site') . ' | Editing: ' . ($isMasterPreview ? ('admin/tpl/wordle/' . h($masterTheme) . '/') : ('tpl/' . h($domain) . '/')) . '</span>'
    . '</form>'
    . '</div>';

if (stripos($rendered, '</body>') !== false) {
    $rendered = str_ireplace('</body>', $toolbar . "\n</body>", $rendered);
} else {
    $rendered .= $toolbar;
}

echo $rendered;
