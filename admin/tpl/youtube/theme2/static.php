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

require_once 'header.php'; 
?>

<!-- Static Page Content -->
<div class="container">
    <div class="static-page-content">
        <h1><?php echo htmlspecialchars($title); ?></h1>
        
        <div class="content-area">
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
    </div>
</div>

<style>
/* Static page styling for MP3Juice theme */
.static-page-content {
    max-width: 980px;
    margin: 36px auto 0 auto;
    padding: 0 20px;
}

.static-page-content h1 {
    color: #ffffff;
    font-size: 32px;
    font-weight: normal;
    text-align: center;
    margin: 0 0 30px 0;
    display: block;
}

.content-area {
    color: #bfe0ff;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.content-area h2, .content-area h3, .content-area h4, .content-area h5 {
    color: #ffffff;
    display: block;
    margin: 20px 0 10px 0;
    text-align: center;
}

.content-area p {
    color: #bfe0ff;
    line-height: 24px;
    margin: 12px 0;
    text-align: center;
}

.content-area ul, .content-area ol {
    color: #bfe0ff;
    margin: 12px 0;
    padding-left: 20px;
}

.content-area a {
    color: #bfe0ff;
    font-weight: bold;
    text-decoration: none;
}

.content-area a:hover {
    color: #ffffff;
    text-decoration: underline;
}

/* Form styling */
.form-label {
    color: #bfe0ff;
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 6px;
    padding: 10px 15px;
    width: 100%;
    margin-bottom: 15px;
    color: #333;
    font-size: 14px;
}

.form-control:focus {
    background: #ffffff;
    border-color: #0085ff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 133, 255, 0.2);
}

.btn {
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #0085ff;
    color: #ffffff;
}

.btn-primary:hover {
    background: #0069ca;
    transform: translateY(-1px);
}

/* Grid system */
.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
    justify-content: center;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
}

.col-md-6 {
    padding: 0 15px;
    flex: 0 0 50%;
    max-width: 50%;
    text-align: left;
}

.mb-3 {
    margin-bottom: 20px;
}

/* Icons */
.fas {
    margin-right: 8px;
}

.text-primary {
    color: #0085ff;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .static-page-content {
        padding: 0 15px;
    }
    
    .static-page-content h1 {
        font-size: 28px;
    }
    
    .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 30px;
    }
    
    .form-control {
        font-size: 16px; /* Prevent zoom on iOS */
    }
}
</style>

<?php require_once 'footer.php'; ?>

<?php
function generateContactContent() {
    return '
    <div class="row">
        <div class="col-md-12">
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
        
        <div class="col-md-12">
            <h3>Other Ways to Reach Us</h3>
            <div class="mb-3">
                <h5>Email</h5>
                <p>contact@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>
            </div>
            
            <div class="mb-3">
                <h5>Response Time</h5>
                <p>We typically respond within 24 hours</p>
            </div>
            
            <div class="mb-3">
                <h5>FAQ</h5>
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