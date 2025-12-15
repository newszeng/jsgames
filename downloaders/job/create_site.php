<?php
/**
 * Command Line Site Creation Script
 * 
 * Usage: php job/create_site.php --domain=example.com --sitename="Site Name" --type=youtube --theme=theme1
 * 
 * Parameters:
 * --domain      : Domain name (required)
 * --sitename    : Site display name (required)
 * --type        : Site type: youtube, tiktok, instagram, facebook, twitter (required)
 * --theme       : Theme name: theme1, theme2 (required)
 * --lang        : Default language (optional, default: en)
 * --force       : Overwrite existing site (optional)
 */

// Check if script is run from command line
if (php_sapi_name() !== 'cli') {
    die("This script must be run from command line\n");
}

// Parse command line arguments
function parseArguments($argv) {
    $args = [];
    for ($i = 1; $i < count($argv); $i++) {
        if (strpos($argv[$i], '--') === 0) {
            $param = substr($argv[$i], 2);
            if (strpos($param, '=') !== false) {
                list($key, $value) = explode('=', $param, 2);
                $args[$key] = $value;
            } else {
                $args[$param] = true;
            }
        }
    }
    return $args;
}

// Validate required parameters
function validateParameters($args) {
    $required = ['domain', 'sitename', 'type', 'theme'];
    $missing = [];
    
    foreach ($required as $param) {
        if (empty($args[$param])) {
            $missing[] = $param;
        }
    }
    
    if (!empty($missing)) {
        echo "❌ Missing required parameters: " . implode(', ', $missing) . "\n";
        showUsage();
        return false;
    }
    
    // Validate site type
    $validTypes = ['youtube', 'tiktok', 'instagram', 'facebook', 'twitter'];
    if (!in_array($args['type'], $validTypes)) {
        echo "❌ Invalid site type. Valid types: " . implode(', ', $validTypes) . "\n";
        return false;
    }
    
    // Validate theme
    $validThemes = ['theme1', 'theme2'];
    if (!in_array($args['theme'], $validThemes)) {
        echo "❌ Invalid theme. Valid themes: " . implode(', ', $validThemes) . "\n";
        return false;
    }
    
    // Validate domain format
    if (!filter_var('http://' . $args['domain'], FILTER_VALIDATE_URL)) {
        echo "❌ Invalid domain format\n";
        return false;
    }
    
    return true;
}

// Show usage information
function showUsage() {
    echo "\n📖 Usage: php job/create_site.php [options]\n\n";
    echo "Required parameters:\n";
    echo "  --domain      Domain name (e.g., ytdownloader.io)\n";
    echo "  --sitename    Site display name (e.g., \"Yt Downloader\")\n";
    echo "  --type        Site type (youtube, tiktok, instagram, facebook, twitter)\n";
    echo "  --theme       Theme name (theme1, theme2)\n\n";
    echo "Optional parameters:\n";
    echo "  --lang        Default language (default: en)\n";
    echo "  --force       Overwrite existing site\n\n";
    echo "Examples:\n";
    echo "  php job/create_site.php --domain=ytdownloader.io --sitename=\"Yt Downloader\" --type=youtube --theme=theme1\n";
    echo "  php job/create_site.php --domain=tiktok.download --sitename=\"TikTok Downloader\" --type=tiktok --theme=theme2 --lang=en --force\n\n";
}

// Create website directories
function createDirectories($domain) {
    $directories = [
        "data/{$domain}",
        "pages/{$domain}",
        "backlinks/{$domain}",
        "i18n/{$domain}",
        "apache/sites-available"
    ];
    
    foreach ($directories as $dir) {
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0755, true)) {
                echo "❌ Failed to create directory: {$dir}\n";
                return false;
            }
            echo "✅ Created directory: {$dir}\n";
        }
    }
    
    return true;
}

// Copy theme files
function copyThemeFiles($domain, $type, $theme) {
    $sourceDir = "admin/tpl/{$type}/{$theme}";
    $targetDir = "tpl/{$domain}";
    
    if (!is_dir($sourceDir)) {
        echo "❌ Source theme directory not found: {$sourceDir}\n";
        return false;
    }
    
    // Create target directory
    if (!file_exists($targetDir)) {
        if (!mkdir($targetDir, 0755, true)) {
            echo "❌ Failed to create target directory: {$targetDir}\n";
            return false;
        }
    }
    
    // Copy theme files
    $files = ['header.php', 'footer.php', 'home.php', 'page.php', 'static.php'];
    
    foreach ($files as $file) {
        $source = "{$sourceDir}/{$file}";
        $target = "{$targetDir}/{$file}";
        
        if (file_exists($source)) {
            if (copy($source, $target)) {
                echo "✅ Copied theme file: {$file}\n";
            } else {
                echo "❌ Failed to copy theme file: {$file}\n";
                return false;
            }
        } else {
            echo "⚠️  Theme file not found: {$source}\n";
        }
    }
    
    return true;
}

// Create Apache virtual host configuration
function createApacheConfig($domain, $sitename) {
    $config = "<VirtualHost *:80>
    ServerName {$domain}
    DocumentRoot " . getcwd() . "
    
    # Custom error and access logs
    ErrorLog \${APACHE_LOG_DIR}/{$domain}_error.log
    CustomLog \${APACHE_LOG_DIR}/{$domain}_access.log combined
    
    # Security headers
    Header always set X-Frame-Options DENY
    Header always set X-Content-Type-Options nosniff
    Header always set X-XSS-Protection \"1; mode=block\"
    Header always set Referrer-Policy \"strict-origin-when-cross-origin\"
    
    # Compression
    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/plain
        AddOutputFilterByType DEFLATE text/html
        AddOutputFilterByType DEFLATE text/xml
        AddOutputFilterByType DEFLATE text/css
        AddOutputFilterByType DEFLATE application/xml
        AddOutputFilterByType DEFLATE application/xhtml+xml
        AddOutputFilterByType DEFLATE application/rss+xml
        AddOutputFilterByType DEFLATE application/javascript
        AddOutputFilterByType DEFLATE application/x-javascript
    </IfModule>
    
    # Cache headers
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType image/jpg \"access plus 1 month\"
        ExpiresByType image/jpeg \"access plus 1 month\"
        ExpiresByType image/gif \"access plus 1 month\"
        ExpiresByType image/png \"access plus 1 month\"
        ExpiresByType text/css \"access plus 1 month\"
        ExpiresByType application/pdf \"access plus 1 month\"
        ExpiresByType text/javascript \"access plus 1 month\"
        ExpiresByType application/javascript \"access plus 1 month\"
    </IfModule>
</VirtualHost>";
    
    $configFile = "apache/sites-available/{$domain}.conf";
    
    if (file_put_contents($configFile, $config)) {
        echo "✅ Created Apache config: {$configFile}\n";
        echo "📝 To enable this site, run:\n";
        echo "   sudo a2ensite {$domain}.conf\n";
        echo "   sudo systemctl reload apache2\n\n";
        return true;
    } else {
        echo "❌ Failed to create Apache config file\n";
        return false;
    }
}

// Create site data file
function createSiteData($domain, $sitename, $type, $theme, $lang = 'en') {
    $siteData = [
        'domain' => $domain,
        'sitename' => $sitename,
        'type' => $type,
        'theme' => $theme,
        'lang' => $lang,
        'active' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $dataFile = "data/{$domain}/site.json";
    
    if (file_put_contents($dataFile, json_encode($siteData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo "✅ Created site data: {$dataFile}\n";
        return true;
    } else {
        echo "❌ Failed to create site data file\n";
        return false;
    }
}

// Create default language file
function createLanguageFile($domain, $type, $lang = 'en') {
    $langData = [];
    
    // Base language data
    $langData['site_name'] = ucfirst($type) . ' Downloader';
    $langData['meta_description'] = "Professional {$type} video downloader with advanced features";
    $langData['languages'] = [$lang];
    
    // Navigation
    $langData['nav'] = [
        'home' => 'Home',
        'features' => 'Features', 
        'how_to' => 'How to Use',
        'contact' => 'Contact'
    ];
    
    // Hero section
    $langData['hero_title'] = "Advanced {$type} Downloader";
    $langData['hero_subtitle'] = "Professional-grade {$type} video downloader with cutting-edge technology";
    
    // Download section
    $langData['download'] = [
        'title' => "Enter {$type} Video URL",
        'subtitle' => "Paste any {$type} video link to start downloading in HD quality",
        'choose_format' => 'Choose Download Format',
        'audio_only' => 'Audio Only'
    ];
    
    // Features
    $langData['features'] = [
        'title' => "Why Choose Our Advanced {$type} Downloader?",
        'subtitle' => "Experience the most advanced {$type} downloading technology available"
    ];
    
    // Footer
    $langData['footer'] = [
        'about_text' => "Professional {$type} video downloader with advanced features. Download high-quality videos without watermarks in seconds.",
        'quick_links' => 'Quick Links',
        'legal' => 'Legal',
        'advanced_features' => 'Advanced Features',
        'features_text' => "Experience the most advanced {$type} downloader with cutting-edge technology.",
        'partner_tools' => 'Partner Tools',
        'copyright' => 'All rights reserved.',
        'disclaimer' => 'Professional tool for content creators and personal use.',
        'privacy' => 'Privacy Policy',
        'terms' => 'Terms of Service',
        'dmca' => 'DMCA',
        'faq' => 'FAQ',
        'api' => 'API'
    ];
    
    // Static pages
    $langData['static_pages'] = [
        'contact' => [
            'title' => 'Contact Us',
            'meta_description' => 'Get in touch with our support team',
            'content' => ''
        ],
        'privacy' => [
            'title' => 'Privacy Policy',
            'meta_description' => 'Our privacy policy and data protection practices',
            'content' => ''
        ],
        'terms' => [
            'title' => 'Terms of Service',
            'meta_description' => 'Terms and conditions for using our service',
            'content' => ''
        ],
        'dmca' => [
            'title' => 'DMCA Policy',
            'meta_description' => 'DMCA takedown policy and copyright protection',
            'content' => ''
        ],
        'about' => [
            'title' => 'About Us',
            'meta_description' => 'Learn more about our advanced downloading service',
            'content' => ''
        ]
    ];
    
    // Error messages
    $langData['error'] = [
        'empty_url' => "Please enter a {$type} video URL",
        'invalid_url' => "Please enter a valid {$type} URL",
        'download_failed' => 'Failed to process video',
        'network' => 'Network error. Please try again.'
    ];
    
    // Processing messages
    $langData['processing'] = 'Processing...';
    $langData['processing_title'] = 'Processing Your Video';
    $langData['processing_text'] = "Please wait while we analyze and prepare your {$type} video...";
    $langData['download_button'] = 'Download';
    $langData['input_placeholder'] = "https://www.{$type}.com/@username/video/...";
    
    // Stats
    $langData['stats'] = [
        'downloads' => 'Videos Downloaded',
        'users' => 'Happy Users',
        'uptime' => 'Uptime',
        'speed' => 'Avg. Processing Time'
    ];
    
    // How to use
    $langData['how_to'] = [
        'title' => "How to Use Our {$type} Downloader",
        'subtitle' => "Follow these simple steps to download any {$type} video",
        'step1' => [
            'title' => "Copy {$type} URL",
            'desc' => "Navigate to {$type} and copy the URL of the video you want to download"
        ],
        'step2' => [
            'title' => 'Paste & Analyze',
            'desc' => "Paste the URL into our advanced downloader and let our AI analyze the video"
        ],
        'step3' => [
            'title' => 'Select Quality',
            'desc' => 'Choose from available quality options including 4K, HD, and audio-only formats'
        ],
        'step4' => [
            'title' => 'Download & Enjoy',
            'desc' => 'Download your video instantly without watermarks in the highest quality'
        ]
    ];
    
    $langFile = "i18n/{$domain}/{$lang}.json";
    
    if (file_put_contents($langFile, json_encode($langData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo "✅ Created language file: {$langFile}\n";
        return true;
    } else {
        echo "❌ Failed to create language file\n";
        return false;
    }
}

// Update websites list
function updateWebsitesList($domain, $sitename, $type, $theme) {
    $websitesFile = 'admin/data/websites.json';
    $websites = [];
    
    if (file_exists($websitesFile)) {
        $websites = json_decode(file_get_contents($websitesFile), true) ?: [];
    }
    
    // Add new website
    $websites[$domain] = [
        'domain' => $domain,
        'sitename' => $sitename,
        'type' => $type,
        'theme' => $theme,
        'active' => 1,
        'created_by' => 'cli',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    if (file_put_contents($websitesFile, json_encode($websites, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo "✅ Updated websites list\n";
        return true;
    } else {
        echo "❌ Failed to update websites list\n";
        return false;
    }
}

// Main execution
function main($argv) {
    echo "\n🚀 Site Creation Script\n";
    echo "========================\n\n";
    
    $args = parseArguments($argv);
    
    if (empty($args)) {
        showUsage();
        return 1;
    }
    
    if (!validateParameters($args)) {
        return 1;
    }
    
    $domain = $args['domain'];
    $sitename = $args['sitename'];
    $type = $args['type'];
    $theme = $args['theme'];
    $lang = $args['lang'] ?? 'en';
    $force = isset($args['force']);
    
    echo "📋 Creating site with parameters:\n";
    echo "   Domain: {$domain}\n";
    echo "   Site Name: {$sitename}\n";
    echo "   Type: {$type}\n";
    echo "   Theme: {$theme}\n";
    echo "   Language: {$lang}\n";
    echo "   Force: " . ($force ? 'Yes' : 'No') . "\n\n";
    
    // Check if site already exists
    if (!$force && file_exists("data/{$domain}")) {
        echo "❌ Site already exists. Use --force to overwrite.\n";
        return 1;
    }
    
    // Create directories
    if (!createDirectories($domain)) {
        return 1;
    }
    
    // Copy theme files  
    if (!copyThemeFiles($domain, $type, $theme)) {
        return 1;
    }
    
    // Create Apache config
    if (!createApacheConfig($domain, $sitename)) {
        return 1;
    }
    
    // Create site data
    if (!createSiteData($domain, $sitename, $type, $theme, $lang)) {
        return 1;
    }
    
    // Create language file
    if (!createLanguageFile($domain, $type, $lang)) {
        return 1;
    }
    
    // Copy game files (if it's a game site)
    if (!copyGameFiles($domain, $type)) {
        return 1;
    }
    
    // Update websites list
    if (!updateWebsitesList($domain, $sitename, $type, $theme)) {
        return 1;
    }
    
    echo "\n🎉 Site created successfully!\n";
    echo "===============================\n\n";
    echo "✅ Domain: {$domain}\n";
    echo "✅ Site directory created\n";
    echo "✅ Theme files copied\n";
    echo "✅ Apache config generated\n";
    echo "✅ Site data initialized\n";
    echo "✅ Language files created\n";
    echo "✅ Websites list updated\n\n";
    
    echo "📝 Next steps:\n";
    echo "   1. Enable Apache site: sudo a2ensite {$domain}.conf\n";
    echo "   2. Reload Apache: sudo systemctl reload apache2\n";
    echo "   3. Add DNS record for {$domain}\n";
    echo "   4. Visit http://{$domain} to test\n";
    echo "   5. Access admin panel to customize content\n\n";
    
    return 0;
}

// Run the script
exit(main($argv));
?>