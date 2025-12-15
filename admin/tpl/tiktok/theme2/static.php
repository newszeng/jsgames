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
<section class="content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div style="background: white; border-radius: 16px; padding: 50px; 
                           box-shadow: 0 10px 30px rgba(0, 123, 255, 0.1); border: 1px solid #e9ecef;">
                    <h1 style="color: #333; font-weight: 700; font-size: 36px; margin-bottom: 30px;">
                        <?php echo htmlspecialchars($title); ?>
                    </h1>
                    
                    <div class="content-area" style="color: #333; line-height: 1.8;">
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
                                    echo '<p style="color: #666;">Content not available.</p>';
                            }
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>

<?php
function generateContactContent() {
    return '
    <div class="row g-5">
        <div class="col-md-6">
            <h3 style="color: #007bff; margin-bottom: 30px; font-weight: 600;">Get in Touch</h3>
            <p style="color: #666; margin-bottom: 30px; font-size: 16px;">
                We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.
            </p>
            
            <form style="margin-top: 40px;">
                <div class="mb-4">
                    <label for="name" class="form-label" style="color: #333; font-weight: 500; margin-bottom: 10px;">Full Name</label>
                    <input type="text" class="form-control" id="name" required 
                           style="border: 2px solid #e9ecef; border-radius: 8px; padding: 15px 20px;">
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label" style="color: #333; font-weight: 500; margin-bottom: 10px;">Email Address</label>
                    <input type="email" class="form-control" id="email" required 
                           style="border: 2px solid #e9ecef; border-radius: 8px; padding: 15px 20px;">
                </div>
                <div class="mb-4">
                    <label for="subject" class="form-label" style="color: #333; font-weight: 500; margin-bottom: 10px;">Subject</label>
                    <input type="text" class="form-control" id="subject" required 
                           style="border: 2px solid #e9ecef; border-radius: 8px; padding: 15px 20px;">
                </div>
                <div class="mb-4">
                    <label for="message" class="form-label" style="color: #333; font-weight: 500; margin-bottom: 10px;">Message</label>
                    <textarea class="form-control" id="message" rows="5" required 
                              style="border: 2px solid #e9ecef; border-radius: 8px; padding: 15px 20px; resize: vertical;"></textarea>
                </div>
                <button type="submit" class="btn" style="background: #007bff; color: white; border: none; 
                                                         border-radius: 8px; padding: 15px 40px; font-weight: 600;">
                    <i class="fas fa-paper-plane me-2"></i>Send Message
                </button>
            </form>
        </div>
        
        <div class="col-md-6">
            <h3 style="color: #007bff; margin-bottom: 30px; font-weight: 600;">Contact Information</h3>
            
            <div class="contact-info-grid">
                <div class="mb-4" style="background: #f8f9fa; border: 1px solid #e9ecef; 
                                          padding: 25px; border-radius: 12px;">
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <div style="width: 50px; height: 50px; background: #007bff; border-radius: 8px; 
                                   display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                            <i class="fas fa-envelope" style="color: white; font-size: 18px;"></i>
                        </div>
                        <div>
                            <h5 style="color: #333; margin-bottom: 5px;">Email Support</h5>
                            <p style="color: #666; margin-bottom: 0;">contact@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4" style="background: #f8f9fa; border: 1px solid #e9ecef; 
                                          padding: 25px; border-radius: 12px;">
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <div style="width: 50px; height: 50px; background: #28a745; border-radius: 8px; 
                                   display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                            <i class="fas fa-clock" style="color: white; font-size: 18px;"></i>
                        </div>
                        <div>
                            <h5 style="color: #333; margin-bottom: 5px;">Response Time</h5>
                            <p style="color: #666; margin-bottom: 0;">Average response within 2-4 hours</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4" style="background: #f8f9fa; border: 1px solid #e9ecef; 
                                          padding: 25px; border-radius: 12px;">
                    <div style="display: flex; align-items: center; margin-bottom: 15px;">
                        <div style="width: 50px; height: 50px; background: #fd7e14; border-radius: 8px; 
                                   display: flex; align-items: center; justify-content: center; margin-right: 20px;">
                            <i class="fas fa-headset" style="color: white; font-size: 18px;"></i>
                        </div>
                        <div>
                            <h5 style="color: #333; margin-bottom: 5px;">24/7 Support</h5>
                            <p style="color: #666; margin-bottom: 0;">Round-the-clock technical assistance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .form-control:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }
    </style>';
}

function generatePrivacyContent() {
    return '
    <div style="max-width: none;">
        <div style="background: #e7f3ff; border: 1px solid #b3d9ff; 
                    border-radius: 12px; padding: 20px; margin-bottom: 40px;">
            <p style="color: #666; margin-bottom: 5px;"><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
            <p style="color: #666; margin-bottom: 0; font-size: 14px;">
                This policy outlines how we handle your data when using our TikTok downloader.
            </p>
        </div>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Information Collection</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            We collect minimal information necessary to provide our TikTok video downloading service, including video URLs and basic analytics.
        </p>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Data Usage</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            Your data is used solely to process video downloads and improve our service quality. We employ security measures to protect your information.
        </p>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Information Sharing</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            We do not sell, trade, or transfer your personal information to third parties. Your privacy is our top priority.
        </p>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Security Measures</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            We implement security protocols and encryption to protect your data. No downloaded videos are stored on our servers.
        </p>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Contact Information</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            For privacy-related questions, contact us at privacy@' . htmlspecialchars($GLOBALS['site_domain']) . '
        </p>
    </div>';
}

function generateTermsContent() {
    return '
    <div style="max-width: none;">
        <div style="background: #e7f3ff; border: 1px solid #b3d9ff; 
                    border-radius: 12px; padding: 20px; margin-bottom: 40px;">
            <p style="color: #666; margin-bottom: 5px;"><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
            <p style="color: #666; margin-bottom: 0; font-size: 14px;">
                These terms govern the use of our TikTok video downloading service.
            </p>
        </div>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Service Agreement</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            By using our advanced TikTok downloader, you agree to these terms of service and our privacy policy.
        </p>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Service Description</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            We provide a professional TikTok video downloading service with advanced features including 4K quality, watermark removal, and AI-powered processing.
        </p>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">User Responsibilities</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            Users must ensure compliance with applicable laws and TikTok\'s terms of service when downloading content.
        </p>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">Prohibited Activities</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            Users may not use our service for illegal purposes or to download copyrighted content without proper authorization.
        </p>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">Service Availability</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            We strive to maintain 99.9% uptime but do not guarantee uninterrupted service availability.
        </p>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">Contact Information</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            For legal inquiries, contact us at legal@' . htmlspecialchars($GLOBALS['site_domain']) . '
        </p>
    </div>';
}

function generateDmcaContent() {
    return '
    <div style="max-width: none;">
        <div style="background: #fff3e0; border: 1px solid #ffcc80; 
                    border-radius: 12px; padding: 20px; margin-bottom: 40px;">
            <p style="color: #666; margin-bottom: 5px;"><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
            <p style="color: #666; margin-bottom: 0; font-size: 14px;">
                Our policy regarding copyright protection and DMCA compliance.
            </p>
        </div>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">Copyright Protection</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            We respect intellectual property rights and expect users to do the same when using our TikTok downloading service.
        </p>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">DMCA Notice Filing</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            If you believe content accessible through our service infringes your copyright, you may file a DMCA notice.
        </p>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">Required Information</h2>
        <ul style="color: var(--muted-text); font-size: 16px; line-height: 1.8; padding-left: 30px;">
            <li>Complete contact information</li>
            <li>Detailed identification of copyrighted work</li>
            <li>Identification of allegedly infringing material</li>
            <li>Statement of good faith belief</li>
            <li>Accuracy statement under penalty of perjury</li>
            <li>Physical or electronic signature</li>
        </ul>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">Counter-Notice Process</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            If you believe material was removed in error, you may file a counter-notice with the required documentation.
        </p>
        
        <h2 style="color: var(--primary-color); margin: 50px 0 25px; font-size: 28px;">Contact Information</h2>
        <p style="color: var(--muted-text); font-size: 16px; line-height: 1.7;">
            Send DMCA notices to: dmca@' . htmlspecialchars($GLOBALS['site_domain']) . '
        </p>
    </div>';
}

function generateAboutContent() {
    return '
    <div style="max-width: none;">
        <p style="color: #666; font-size: 18px; line-height: 1.6; margin-bottom: 30px;">
            We provide reliable TikTok video downloading service, helping users save their favorite videos easily and quickly.
        </p>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Our Mission</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            To provide a secure and user-friendly TikTok video downloading experience with high quality and fast processing.
        </p>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Key Features</h2>
        <div class="row g-4 my-4">
            <div class="col-md-6">
                <ul style="color: #666; font-size: 16px; line-height: 2; padding-left: 0; list-style: none;">
                    <li style="margin-bottom: 12px;"><i class="fas fa-video" style="color: #007bff; margin-right: 15px; width: 20px;"></i>HD Quality downloads</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-bolt" style="color: #007bff; margin-right: 15px; width: 20px;"></i>Fast processing</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-ban" style="color: #007bff; margin-right: 15px; width: 20px;"></i>Watermark removal</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-download" style="color: #007bff; margin-right: 15px; width: 20px;"></i>Easy downloading</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul style="color: #666; font-size: 16px; line-height: 2; padding-left: 0; list-style: none;">
                    <li style="margin-bottom: 12px;"><i class="fas fa-music" style="color: #28a745; margin-right: 15px; width: 20px;"></i>Audio extraction</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-mobile-alt" style="color: #28a745; margin-right: 15px; width: 20px;"></i>Mobile friendly</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-shield-alt" style="color: #28a745; margin-right: 15px; width: 20px;"></i>Safe & secure</li>
                    <li style="margin-bottom: 12px;"><i class="fas fa-free-code-camp" style="color: #28a745; margin-right: 15px; width: 20px;"></i>Completely free</li>
                </ul>
            </div>
        </div>
        
        <h2 style="color: #007bff; margin: 40px 0 20px; font-size: 24px;">Why Choose Our Service?</h2>
        <p style="color: #666; font-size: 16px; line-height: 1.7;">
            We focus on providing a simple, fast, and reliable TikTok downloading experience. Our service ensures high quality video downloads while maintaining user privacy and security.
        </p>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="' . get_page_url('/') . '" class="btn" style="background: #007bff; color: white; border: none; 
                                                                     border-radius: 8px; padding: 15px 30px; font-weight: 600; 
                                                                     text-decoration: none; display: inline-block; font-size: 16px;">
                <i class="fas fa-download me-2"></i>Start Downloading
            </a>
        </div>
    </div>';
}
?>