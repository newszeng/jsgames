<?php
// Static page template
$page = $GLOBALS['template_data']['page'] ?? 'contact';
$lang = $GLOBALS['site_lang'];

// Get static page content
$static_content = $GLOBALS['lang_data']['static_pages'][$page] ?? [];
$title = $static_content['title'] ?? ucfirst($page);
$content = $static_content['content'] ?? '';

// Set page title
$GLOBALS['template_data']['title'] = $title;
$GLOBALS['template_data']['meta_description'] = $static_content['meta_description'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- This site is optimized with the Yoast SEO Premium plugin-->
    <title><?php echo ($GLOBALS['template_data']['title'] ?? __('site_name')); ?></title>

    <meta name="description" content="<?php echo $GLOBALS['template_data']['meta_description'] ?? str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube in High quality quickly and easily.')); ?>">
    <meta name="keywords" content="">
    <link rel="canonical" href="<?php
    $protocol = 'https';
    $canonical_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo $canonical_url;
    ?>">
    <link rel="shortcut icon" href="https://<?php echo $GLOBALS['site_domain']; ?>/favicon.ico">
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
        <a href="https://<?php echo $GLOBALS['site_domain']; ?>/">Home</a>
        <a href="/#text">FAQ</a>
    </div>

    <div>Dark Theme: <a id="theme" href="#" rel="nofollow">Off</a></div>
</div>

<div id="logo">
    <a href="https://<?php echo $GLOBALS['site_domain']; ?>">
        <img src="/ytmp3.svg" width="144" height="70" title="<?php echo __('site_name'); ?>" alt="<?php echo __('site_name'); ?>">
    </a>
</div>

<div id="text">
    <h1><?php echo htmlspecialchars($title); ?></h1>

    <?php if (!empty($content)): ?>
        <?php echo $content; ?>
    <?php else: ?>
        <?php
        // Default content for common pages
        switch ($page) {
            case 'contact':
                echo generateContactContent();
                break;
            case 'privacy':
                echo generatePrivacyContent();
                break;
            case 'terms':
                echo generateTermsContent();
                break;
            case 'dmca':
                echo generateDmcaContent();
                break;
            case 'about':
                echo generateAboutContent();
                break;
            default:
                echo '<p class="text-muted">Content not available.</p>';
        }
        ?>
    <?php endif; ?>

</div>

<?php
function generateContactContent() {
    return '
    <div class="row">
        <div class="col-md-6">
            <h3>Get in Touch</h3>
            <p>We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.</p>
            
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
        
        <div class="col-md-6">
            <h3>Other Ways to Reach Us</h3>
            <div class="mb-3">
                <h5><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
                <p>contact@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>
            </div>
            
            <div class="mb-3">
                <h5><i class="fas fa-clock text-primary me-2"></i>Response Time</h5>
                <p>We typically respond within 24 hours</p>
            </div>
            
            <div class="mb-3">
                <h5><i class="fas fa-question-circle text-primary me-2"></i>FAQ</h5>
                <p>Check our frequently asked questions for quick answers to common queries.</p>
            </div>
        </div>
    </div>';
}

function generatePrivacyContent() {
    return '
    <h2>Privacy Policy</h2>
    <p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
    
    <h3>Information We Collect</h3>
    <p>We collect information you provide directly to us, such as when you use our video downloading service.</p>
    
    <h3>How We Use Your Information</h3>
    <p>We use the information we collect to provide, maintain, and improve our services.</p>
    
    <h3>Information Sharing</h3>
    <p>We do not sell, trade, or otherwise transfer your personal information to third parties.</p>
    
    <h3>Data Security</h3>
    <p>We implement appropriate security measures to protect your personal information.</p>
    
    <h3>Contact Us</h3>
    <p>If you have any questions about this Privacy Policy, please contact us at privacy@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>';
}

function generateTermsContent() {
    return '
    <h2>Terms of Service</h2>
    <p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
    
    <h3>Acceptance of Terms</h3>
    <p>By using our service, you agree to be bound by these Terms of Service.</p>
    
    <h3>Description of Service</h3>
    <p>We provide a video downloading service that allows users to download videos from supported platforms.</p>
    
    <h3>User Responsibilities</h3>
    <p>You are responsible for ensuring that your use of our service complies with applicable laws and regulations.</p>
    
    <h3>Prohibited Uses</h3>
    <p>You may not use our service for any illegal or unauthorized purpose.</p>
    
    <h3>Limitation of Liability</h3>
    <p>We shall not be liable for any direct, indirect, incidental, special, or consequential damages.</p>
    
    <h3>Contact Information</h3>
    <p>Questions about the Terms of Service should be sent to us at legal@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>';
}

function generateDmcaContent() {
    return '
    <h2>DMCA Policy</h2>
    <p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
    
    <h3>DMCA Notice</h3>
    <p>We respect the intellectual property rights of others and expect our users to do the same.</p>
    
    <h3>Filing a DMCA Notice</h3>
    <p>If you believe that material on our service infringes your copyright, you may file a DMCA notice with us.</p>
    
    <h3>Required Information</h3>
    <ul>
        <li>Your contact information</li>
        <li>Identification of the copyrighted work</li>
        <li>Identification of the infringing material</li>
        <li>A statement of good faith belief</li>
        <li>A statement of accuracy under penalty of perjury</li>
        <li>Your physical or electronic signature</li>
    </ul>
    
    <h3>Counter-Notice</h3>
    <p>If you believe that material was removed in error, you may file a counter-notice.</p>
    
    <h3>Contact</h3>
    <p>DMCA notices should be sent to: dmca@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>';
}

function generateAboutContent() {
    return '
    <h2>About ' . htmlspecialchars($GLOBALS['lang_data']['site_name'] ?? 'Us') . '</h2>
    
    <p>We are a free video downloading service that helps users download videos from YouTube and other popular platforms.</p>
    
    <h3>Our Mission</h3>
    <p>To provide a fast, free, and easy-to-use video downloading service that respects user privacy and delivers high-quality downloads.</p>
    
    <h3>Features</h3>
    <ul>
        <li>Fast downloads with optimized servers</li>
        <li>Multiple format options (MP4, MP3, etc.)</li>
        <li>No registration required</li>
        <li>High-quality downloads up to 4K</li>
        <li>Mobile-friendly interface</li>
        <li>Completely free service</li>
    </ul>
    
    <h3>Why Choose Us?</h3>
    <p>We prioritize user experience, privacy, and quality. Our service is designed to be simple yet powerful, giving you access to your favorite videos without any hassle.</p>
    
    <h3>Get Started</h3>
    <p><a href="' . get_page_url('/') . '" class="btn btn-primary">Start Downloading Now</a></p>';
}
?>

<div id="footer">
    <a href="<?php echo get_page_url('/contact'); ?>"><?php echo __('footer.contact', 'Contact'); ?></a>
    <a href="<?php echo get_page_url('/dmca'); ?>"><?php echo __('footer.dmca', 'Copyright Claims'); ?></a>
    <a href="/#faq">FAQ</a>
    <a href="<?php echo get_page_url('/privacy'); ?>"><?php echo __('footer.privacy', 'Privacy Policy'); ?></a>
    <a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('footer.terms', 'ToU'); ?></a>
</div>

</body>
</html>