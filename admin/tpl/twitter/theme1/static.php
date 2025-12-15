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
<section class="py-5" style="padding-top: 100px !important; background: var(--bg-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb" style="background: white; border-radius: 12px; padding: 15px 20px; 
                                                    box-shadow: 0 2px 10px var(--shadow-light); border: 1px solid var(--border-color);">
                        <li class="breadcrumb-item">
                            <a href="<?php echo get_page_url('/'); ?>" style="color: var(--primary-color); text-decoration: none;">
                                <i class="fas fa-home me-1"></i>
                                <?php echo __('nav.home', 'Home'); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" style="color: var(--gray-text);"><?php echo htmlspecialchars($title); ?></li>
                    </ol>
                </nav>
                
                <div style="background: white; border-radius: 16px; padding: 50px; 
                           box-shadow: 0 10px 30px var(--shadow-medium); border: 1px solid var(--border-color);">
                    <h1 class="mb-4" style="color: var(--dark-text); font-weight: 700; font-size: 32px;">
                        <?php echo htmlspecialchars($title); ?>
                    </h1>
                    
                    <div class="content-area" style="color: var(--dark-text); line-height: 1.7;">
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
                                    echo '<p style="color: var(--gray-text);">Content not available.</p>';
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
    <div class="row g-4">
        <div class="col-md-6">
            <h3 style="color: var(--primary-color); margin-bottom: 25px;">Get in Touch</h3>
            <p style="color: var(--gray-text);">We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.</p>
            
            <form style="margin-top: 30px;">
                <div class="mb-3">
                    <label for="name" class="form-label" style="color: var(--dark-text); font-weight: 500;">Name</label>
                    <input type="text" class="form-control" id="name" required 
                           style="border: 2px solid var(--border-color); border-radius: 10px; padding: 12px 15px; 
                                  transition: border-color 0.3s ease;">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: var(--dark-text); font-weight: 500;">Email</label>
                    <input type="email" class="form-control" id="email" required 
                           style="border: 2px solid var(--border-color); border-radius: 10px; padding: 12px 15px; 
                                  transition: border-color 0.3s ease;">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label" style="color: var(--dark-text); font-weight: 500;">Subject</label>
                    <input type="text" class="form-control" id="subject" required 
                           style="border: 2px solid var(--border-color); border-radius: 10px; padding: 12px 15px; 
                                  transition: border-color 0.3s ease;">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label" style="color: var(--dark-text); font-weight: 500;">Message</label>
                    <textarea class="form-control" id="message" rows="5" required 
                              style="border: 2px solid var(--border-color); border-radius: 10px; padding: 12px 15px; 
                                     transition: border-color 0.3s ease; resize: vertical;"></textarea>
                </div>
                <button type="submit" class="btn" style="background: linear-gradient(45deg, var(--primary-color), var(--accent-color)); 
                                                         color: white; border: none; border-radius: 10px; padding: 12px 30px; 
                                                         font-weight: 600; transition: all 0.3s ease;">
                    <i class="fas fa-paper-plane me-2"></i>Send Message
                </button>
            </form>
        </div>
        
        <div class="col-md-6">
            <h3 style="color: var(--primary-color); margin-bottom: 25px;">Other Ways to Reach Us</h3>
            
            <div class="mb-4" style="background: var(--bg-light); padding: 25px; border-radius: 12px; 
                                    border: 1px solid var(--border-color);">
                <h5 style="color: var(--dark-text);"><i class="fas fa-envelope" style="color: var(--primary-color); margin-right: 10px;"></i>Email</h5>
                <p style="color: var(--gray-text);">contact@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>
            </div>
            
            <div class="mb-4" style="background: var(--bg-light); padding: 25px; border-radius: 12px; 
                                    border: 1px solid var(--border-color);">
                <h5 style="color: var(--dark-text);"><i class="fas fa-clock" style="color: var(--primary-color); margin-right: 10px;"></i>Response Time</h5>
                <p style="color: var(--gray-text);">We typically respond within 24 hours</p>
            </div>
            
            <div class="mb-4" style="background: var(--bg-light); padding: 25px; border-radius: 12px; 
                                    border: 1px solid var(--border-color);">
                <h5 style="color: var(--dark-text);"><i class="fas fa-question-circle" style="color: var(--primary-color); margin-right: 10px;"></i>FAQ</h5>
                <p style="color: var(--gray-text);">Check our frequently asked questions for quick answers to common queries.</p>
            </div>
        </div>
    </div>';
}

function generatePrivacyContent() {
    return '
    <h2 style="color: var(--primary-color); margin-bottom: 30px;">Privacy Policy</h2>
    <p style="color: var(--gray-text);"><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Information We Collect</h3>
    <p style="color: var(--gray-text);">We collect information you provide directly to us, such as when you use our Twitter video downloading service.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">How We Use Your Information</h3>
    <p style="color: var(--gray-text);">We use the information we collect to provide, maintain, and improve our Twitter downloading services.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Information Sharing</h3>
    <p style="color: var(--gray-text);">We do not sell, trade, or otherwise transfer your personal information to third parties.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Data Security</h3>
    <p style="color: var(--gray-text);">We implement appropriate security measures to protect your personal information and do not store your downloaded videos.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Contact Us</h3>
    <p style="color: var(--gray-text);">If you have any questions about this Privacy Policy, please contact us at privacy@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>';
}

function generateTermsContent() {
    return '
    <h2 style="color: var(--primary-color); margin-bottom: 30px;">Terms of Service</h2>
    <p style="color: var(--gray-text);"><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Acceptance of Terms</h3>
    <p style="color: var(--gray-text);">By using our Twitter video downloading service, you agree to be bound by these Terms of Service.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Description of Service</h3>
    <p style="color: var(--gray-text);">We provide a free Twitter video downloading service that allows users to download Twitter videos and GIFs in HD quality.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">User Responsibilities</h3>
    <p style="color: var(--gray-text);">You are responsible for ensuring that your use of our service complies with applicable laws and Twitter\'s terms of service.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Prohibited Uses</h3>
    <p style="color: var(--gray-text);">You may not use our service for any illegal or unauthorized purpose, including downloading copyrighted content without permission.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Limitation of Liability</h3>
    <p style="color: var(--gray-text);">We shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from your use of our service.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Contact Information</h3>
    <p style="color: var(--gray-text);">Questions about the Terms of Service should be sent to us at legal@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>';
}

function generateDmcaContent() {
    return '
    <h2 style="color: var(--primary-color); margin-bottom: 30px;">DMCA Policy</h2>
    <p style="color: var(--gray-text);"><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">DMCA Notice</h3>
    <p style="color: var(--gray-text);">We respect the intellectual property rights of others and expect our users to do the same when using our Twitter downloading service.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Filing a DMCA Notice</h3>
    <p style="color: var(--gray-text);">If you believe that material accessible through our service infringes your copyright, you may file a DMCA notice with us.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Required Information</h3>
    <ul style="color: var(--gray-text);">
        <li>Your contact information</li>
        <li>Identification of the copyrighted work</li>
        <li>Identification of the infringing material</li>
        <li>A statement of good faith belief</li>
        <li>A statement of accuracy under penalty of perjury</li>
        <li>Your physical or electronic signature</li>
    </ul>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Counter-Notice</h3>
    <p style="color: var(--gray-text);">If you believe that material was removed in error, you may file a counter-notice with the required information.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Contact</h3>
    <p style="color: var(--gray-text);">DMCA notices should be sent to: dmca@' . htmlspecialchars($GLOBALS['site_domain']) . '</p>';
}

function generateAboutContent() {
    return '
    <h2 style="color: var(--primary-color); margin-bottom: 30px;">About ' . htmlspecialchars($GLOBALS['lang_data']['site_name'] ?? 'Our Service') . '</h2>
    
    <p style="color: var(--gray-text); font-size: 18px; margin-bottom: 30px;">We are a free Twitter video downloading service that helps users download Twitter videos, Tweets, Retweets, and GIFs in HD quality.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Our Mission</h3>
    <p style="color: var(--gray-text);">To provide a fast, free, and easy-to-use Twitter video downloader that respects user privacy and delivers high-quality downloads of Tweets, Retweets, and GIFs.</p>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Features</h3>
    <ul style="color: var(--gray-text); line-height: 1.8;">
        <li>Download Twitter videos and GIFs in HD quality</li>
        <li>Support for Tweets, Retweets, and Twitter GIFs</li>
        <li>Audio extraction to MP3 format</li>
        <li>No registration or account creation required</li>
        <li>Fast processing and download speeds</li>
        <li>Mobile-friendly responsive design</li>
        <li>Completely free service with no hidden costs</li>
        <li>Privacy-focused - we don\'t store your videos</li>
    </ul>
    
    <h3 style="color: var(--dark-text); margin: 40px 0 20px;">Why Choose Us?</h3>
    <p style="color: var(--gray-text);">We prioritize user experience, privacy, and quality. Our service is designed to be simple yet powerful, giving you access to your favorite Twitter content including videos, GIFs, and media.</p>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="' . get_page_url('/') . '" class="btn" style="background: linear-gradient(45deg, var(--primary-color), var(--accent-color)); 
                                                                 color: white; border: none; border-radius: 12px; padding: 15px 40px; 
                                                                 font-weight: 600; text-decoration: none; display: inline-block; 
                                                                 transition: all 0.3s ease;">
            <i class="fab fa-twitter me-2"></i>Start Downloading Now
        </a>
    </div>';
}
?>