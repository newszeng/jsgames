<?php
/**
 * 简单模板引擎 - PHP 7.3 兼容版本
 * 用于替代 Twig，确保在低版本 PHP 环境中正常运行
 */

class SimpleTemplate {
    private $template_dir;
    private $vars = [];
    private $functions = [];
    
    public function __construct($template_dir) {
        $this->template_dir = rtrim($template_dir, '/');
    }
    
    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }
    
    public function assignAll($vars) {
        $this->vars = array_merge($this->vars, $vars);
    }
    
    public function addFunction($name, $callback) {
        $this->functions[$name] = $callback;
    }
    
    public function render($template, $vars = []) {
        $all_vars = array_merge($this->vars, $vars);
        
        // 处理模板文件路径
        $template_file = $this->template_dir . '/' . $template;
        if (!file_exists($template_file)) {
            throw new Exception("Template file not found: {$template_file}");
        }
        
        // 读取模板内容
        $content = file_get_contents($template_file);
        
        // 简单的模板变量替换
        $content = $this->parseTemplate($content, $all_vars);
        
        return $content;
    }
    
    private function parseTemplate($content, $vars) {
        // 替换简单变量 {{ variable }}
        $content = preg_replace_callback('/\{\{\s*([^}]+)\s*\}\}/', function($matches) use ($vars) {
            $key = trim($matches[1]);
            
            // 处理函数调用，如 __('key')
            if (preg_match("/^([a-zA-Z_][a-zA-Z0-9_]*)\s*\(\s*['\"]([^'\"]+)['\"]\s*\)$/", $key, $func_matches)) {
                $func_name = $func_matches[1];
                $func_arg = $func_matches[2];
                
                if (isset($this->functions[$func_name])) {
                    return call_user_func($this->functions[$func_name], $func_arg);
                }
            }
            
            // 处理对象属性访问，如 site.title
            if (strpos($key, '.') !== false) {
                return $this->getNestedValue($vars, $key);
            }
            
            // 处理默认值，如 variable|default('default_value')
            if (strpos($key, '|default') !== false) {
                list($var_key, $default_part) = explode('|default', $key, 2);
                $var_key = trim($var_key);
                $default_value = '';
                
                if (preg_match("/\(['\"]([^'\"]*)['\"]\\)/", $default_part, $default_matches)) {
                    $default_value = $default_matches[1];
                }
                
                return isset($vars[$var_key]) ? $vars[$var_key] : $default_value;
            }
            
            return isset($vars[$key]) ? $vars[$key] : '';
        }, $content);
        
        // 处理简单的 for 循环 {% for item in items %}...{% endfor %}
        $content = preg_replace_callback('/\{%\s*for\s+(\w+)\s+in\s+([^%]+)\s*%\}(.*?)\{%\s*endfor\s*%\}/s', function($matches) use ($vars) {
            $item_var = $matches[1];
            $array_key = trim($matches[2]);
            $loop_content = $matches[3];
            
            $array = $this->getNestedValue($vars, $array_key);
            if (!is_array($array)) {
                return '';
            }
            
            $output = '';
            foreach ($array as $item) {
                $loop_vars = array_merge($vars, [$item_var => $item]);
                $output .= $this->parseTemplate($loop_content, $loop_vars);
            }
            
            return $output;
        }, $content);
        
        // 处理简单的 if 条件 {% if condition %}...{% endif %}
        $content = preg_replace_callback('/\{%\s*if\s+([^%]+)\s*%\}(.*?)\{%\s*endif\s*%\}/s', function($matches) use ($vars) {
            $condition = trim($matches[1]);
            $if_content = $matches[2];
            
            $value = $this->getNestedValue($vars, $condition);
            return $value ? $this->parseTemplate($if_content, $vars) : '';
        }, $content);
        
        return $content;
    }
    
    private function getNestedValue($array, $key) {
        $keys = explode('.', $key);
        $value = $array;
        
        foreach ($keys as $k) {
            if (is_array($value) && isset($value[$k])) {
                $value = $value[$k];
            } else {
                return '';
            }
        }
        
        return $value;
    }
}

// 辅助函数
if (!function_exists('__')) {
function __($key, $default = '') {
    global $i18n_data, $current_lang;
    
    if (!isset($i18n_data) || !isset($current_lang)) {
        return $default;
    }
    
    $keys = explode('.', $key);
    $value = $i18n_data;
    
    foreach ($keys as $k) {
        if (is_array($value) && isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default;
        }
    }
    
    return is_string($value) ? $value : $default;
}
}

if (!function_exists('get_language_url')) {
function get_language_url($lang = null) {
    global $current_lang, $debug_mode, $domain;
    
    $lang = $lang ?: $current_lang;
    
    if ($debug_mode) {
        return "/index.php?domain={$domain}&lang={$lang}";
    }
    
    return "/{$lang}/";
}
}

if (!function_exists('get_page_url')) {
function get_page_url($page, $lang = null) {
    global $current_lang, $debug_mode, $domain;
    
    $lang = $lang ?: $current_lang;
    
    if ($debug_mode) {
        return "/index.php?domain={$domain}&lang={$lang}&page={$page}";
    }
    
    return "/{$lang}/{$page}";
}
}

if (!function_exists('get_static_url')) {
function get_static_url($path) {
    global $domain;
    return "/static/{$domain}/{$path}";
}
}