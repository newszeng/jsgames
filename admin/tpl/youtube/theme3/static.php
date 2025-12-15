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

    <style>body{background-color:#ffffff;background-image:linear-gradient(#000000 200px, #ffffff 200px);background-repeat:no-repeat;font-family:Arial, sans-serif;font-size:14px;margin:0;}#header{display:flex;justify-content:center;max-width:600px;margin:0 auto;padding-top:20px;}#header a{color:#ecf1fc;text-decoration:none;margin-right:20px;}#header a:last-of-type{margin-right:0;}#logo{text-align:center;max-width:600px;margin:40px auto;}.search-form{color:#1e2a54;background-color:#ffffff;max-width:560px;border-radius:8px;box-shadow:0px 8px 8px rgba(21, 40, 88, 0.2);margin:0 auto;padding:20px;}.search-form div:nth-of-type(1){text-overflow:ellipsis;white-space:nowrap;}.search-form div:nth-of-type(2){margin-top:20px;display:flex;}.search-form div:nth-of-type(2) a{color:#ffffff;background-color:#121212;font-size:16px;line-height:48px;text-decoration:none;height:48px;border-radius:4px;display:inline-block;margin-right:20px;padding:0 10px;}.search-form div:nth-of-type(2) a:last-of-type{margin-right:0;}.search-form input{font-family:Arial, sans-serif;font-size:16px;height:48px;border-radius:4px;}.search-form .input{position:relative;width:82.14285714285714%;}.search-form input[type="text"]{width:100%;color:#5f698c;background-color:#f7f9ff;border:1px #d1d7e3 solid;padding:0 1.785714285714286%;outline:none;box-sizing:border-box;}.search-form input[type="submit"]{color:#ffffff;background-color:#121212;font-weight:normal;width:14.28571428571429%;border:none;margin-left:3.571428571428571%;padding:0;cursor:pointer;appearance:none;}.search-form #progress{color:#5f698c;background-color:#f7f9ff;font-size:16px;line-height:48px;text-align:center;height:48px;border:1px #d1d7e3 solid;border-radius:4px;align-items:center;justify-content:center;box-sizing:border-box;}i{width:16px;height:16px;border:2px transparent solid;border-top:2px #121212 solid;border-bottom:2px #121212 solid;border-radius:50%;margin-left:10px;display:block;animation:spin 2s linear infinite;}@keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}#text{max-width:600px;margin:40px auto;}#text h1{color:#1e2a54;font-size:24px;font-weight:normal;text-align:center;margin:0;}#text p{color:#000000;font-size:14px;line-height:24px;text-align:justify;margin:20px 0 0 0;}#text a{color:#000000;}#footer{display:flex;justify-content:center;max-width:600px;border-top:1px #d1d7e3 solid;margin:0 auto;padding:20px 0;}#footer a{color:#1e2a54;text-decoration:none;margin-right:20px;}#footer a:last-of-type{margin-right:0;}@media only screen and (max-width:600px) {form .input{width:75.14285714285714%;}.search-form input[type="submit"]{width:21.28571428571429%;}#text{width:92%;}#footer{font-size:12px;}}</style>
    <style>table{width:100%;border-collapse:collapse;}table th{text-align:left;}table th,table td{padding:7px 10px;border:1px solid #000000;}.suggest-results{position:absolute;z-index:100;top:100%;left:0;width:100%;max-height:184px;margin:0;padding:5px 0;overflow:auto;list-style:none;line-height:auto;background:#fff;-webkit-box-shadow:0 10px 15px rgba(0,0,0,0.1);box-shadow:0 10px 15px rgba(0,0,0,0.1);-webkit-border-radius:2px;border-radius:2px;}.suggest-results.hidden{display:none;}.suggest-results li{margin:0;padding:5px 15px;line-height:auto;cursor:pointer;}.suggest-results li:hover,.suggest-results li.active{background:#f5f5f5;}.convert-iframe{padding:1rem;background:#f5f5f5;}.convert-iframe iframe{display:block;width:100%;margin:0;border:none;}.list{display:flex;flex-direction:column;gap:1rem;margin:1.5rem 0;}.list > div{display:flex;align-items:center;gap:12px;}.list img{width:48px;height:48px;-o-object-fit:cover;object-fit:cover;-webkit-border-radius:4px;border-radius:4px;}.list h2{margin:0 0 5px 0;font-size:14px;font-weight:bold;}.list>div>div{font-size:12px;}.list a{text-decoration:none;}.search-list{display:flex;flex-direction:column;gap:1rem;}.search-list > div{display:flex;flex-direction:column;}.search-list .primary{display:flex;align-items:center;gap:12px;}.search-list img {width:64px;height:64px;-o-object-fit:cover;object-fit:cover;-webkit-border-radius:4px;border-radius:4px;}.search-list .info{flex:1;overflow:hidden;}.search-list h2{margin:0 0 8px 0;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;font-size:14px;font-weight:normal;}.search-list button{display:inline-flex;align-items:center;margin-right:12px;padding:0 12px;height:32px;cursor:pointer;background:#121212;border:none;color:#fff;-webkit-border-radius:3px;border-radius:3px;}</style>
    <style>#text{background-color:#ffffff;max-width:560px;border-radius:8px;box-shadow:0 8px 8px rgba(21, 40, 88, 0.2);margin:0 auto 40px auto;padding:20px;}#text h1{text-align:left;}#collapse .opener{color:#111111;background-image:linear-gradient(#ffffff, #f4f4f4);font-size:16px;font-weight:bold;border:1px #f3f1f1 solid;border-radius:3px;margin-top:15px;padding:15px;cursor:pointer;user-select:none;box-sizing:border-box;}#collapse .opener + div{color:#494949;line-height:24px;text-align:justify;margin:15px 0;padding:0 15px;display:none;}#collapse .opener + div a{color:#494949;}ul{color:#494949;line-height:24px;text-align:justify;margin:15px 0 0 0;padding:0 0 0 15px;list-style-type:none;}#text ul {color: #000000;line-height: 24px;list-style-type: lower-alpha;margin: 20px 0 0 0;padding: 0 0 0 15px;text-align:left;}#text ul li {margin-bottom: 10px;}#text ul li:last-of-type {margin-bottom: 0;}#text ul li ul {list-style-type: lower-roman;margin: 0;}#text ul li ul li:first-of-type {margin-top: 10px;}ul p {text-align: center !important;font-weight: bold;margin: 20px 0 !important;}#text ul .b {font-weight: bold;}</style>

</head>

<body>
<div id="header">
    <a href="https://<?php echo $GLOBALS['site_domain']; ?>/">Home</a>
    <a href="/#text">FAQ</a>
</div>

<div id="logo">
    <a href="https://<?php echo $GLOBALS['site_domain']; ?>">
        <img src="https://<?php echo $GLOBALS['site_domain']; ?>/logo.svg" width="192" height="38" alt="Y2Mate" />
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

<center>
    <small>© Copyright 2009-<?php echo date('Y'); ?> - <a href="/" title="<?php echo __('site_name'); ?>"><?php echo __('site_name'); ?></a>. All Right Reserved.</small><br>
</center>

</body>
</html>
