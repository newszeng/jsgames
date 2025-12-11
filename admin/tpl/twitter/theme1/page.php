<?php 
// Tag page template
$page_slug = $GLOBALS['template_data']['slug'] ?? '';
$lang = $GLOBALS['site_lang'];
$page_file = "pages/{$GLOBALS['site_domain']}/{$page_slug}/{$lang}.json";

$page_data = [];
if (file_exists($page_file)) {
    $page_data = json_decode(file_get_contents($page_file), true) ?: [];
}

// Set page title
$GLOBALS['template_data']['title'] = $page_data['title'] ?? 'Download Twitter Videos';
$GLOBALS['template_data']['meta_description'] = $page_data['meta_description'] ?? '';

require_once 'header.php'; 
?>

<!-- Hero Section with Download Functionality -->
<section class="hero-section">
    <div class="container">
        <div class="text-center">
            <h1 class="hero-title"><?php echo htmlspecialchars($page_data['title'] ?? 'Twitter Video Downloader'); ?></h1>
            <p class="hero-subtitle"><?php echo __('hero_subtitle', 'Download Twitter videos and GIFs in HD quality'); ?></p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="download-container">
                    <div class="mb-4 text-center">
                        <i class="fab fa-twitter" style="font-size: 48px; color: var(--primary-color); margin-bottom: 20px;"></i>
                        <h4 style="color: var(--dark-text); font-weight: 600;"><?php echo __('download.paste_url', 'Paste Twitter Video URL'); ?></h4>
                    </div>
                    
                    <div class="input-group mb-3" style="gap: 15px;">
                        <input type="text" 
                               class="url-input" 
                               id="videoUrl" 
                               placeholder="<?php echo __('input_placeholder', 'Paste Twitter URL here...'); ?>">
                        <button class="btn download-btn" type="button" onclick="downloadVideo()">
                            <i class="fas fa-download me-2"></i>
                            <span class="btn-text"><?php echo __('download_button', 'Download'); ?></span>
                        </button>
                    </div>
                    
                    <div class="format-tags">
                        <span class="format-tag">
                            <i class="fas fa-video me-1"></i> MP4 HD
                        </span>
                        <span class="format-tag">
                            <i class="fas fa-video me-1"></i> MP4 SD
                        </span>
                        <span class="format-tag">
                            <i class="fas fa-download me-1"></i> HD Videos
                        </span>
                        <span class="format-tag">
                            <i class="fas fa-images me-1"></i> GIFs
                        </span>
                    </div>
                    
                    <!-- Loading Indicator -->
                    <div id="loading" class="text-center mt-4" style="display: none;">
                        <div style="background: #f8f9fa; border-radius: 12px; padding: 30px;">
                            <img src="/loading.gif" alt="Loading..." style="width: 50px; height: 50px; margin-bottom: 15px;">
                            <p class="mb-0" style="color: #6c757d; font-weight: 500;">
                                <?php echo __('processing_text', 'Processing your Twitter video...'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Download Results -->
                <div id="downloadResult"></div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Content Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="background: white; border-radius: 16px; padding: 40px; 
                           box-shadow: 0 10px 30px var(--shadow-medium); border: 1px solid var(--border-color);">
                    <?php if (!empty($page_data['content'])): ?>
                        <div style="color: var(--dark-text); line-height: 1.7;">
                            <?php echo $page_data['content']; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center" style="padding: 60px 0; color: var(--gray-text);">
                            <i class="fab fa-twitter" style="font-size: 80px; opacity: 0.3; margin-bottom: 30px;"></i>
                            <p class="mb-0">Content not available in the current language.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Features Section -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="row g-4">
            <?php 
            $features = [
                [
                    'title' => __('features.tweets.title', 'Download Tweets'),
                    'description' => __('features.tweets.desc', 'Save video Tweets in high quality with original resolution'),
                    'icon' => 'fab fa-twitter'
                ],
                [
                    'title' => __('features.retweets.title', 'Save Retweets'),
                    'description' => __('features.retweets.desc', 'Download retweeted videos and maintain original quality'),
                    'icon' => 'fas fa-retweet'
                ],
                [
                    'title' => __('features.gifs.title', 'Twitter GIFs'),
                    'description' => __('features.gifs.desc', 'Save Twitter GIFs as MP4 videos or animated GIFs'),
                    'icon' => 'fas fa-images'
                ]
            ];
            
            foreach ($features as $feature):
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card" style="margin-bottom: 0;">
                    <div class="feature-icon" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="<?php echo $feature['icon']; ?>"></i>
                    </div>
                    <h4 class="feature-title" style="font-size: 18px;"><?php echo htmlspecialchars($feature['title']); ?></h4>
                    <p class="feature-description" style="font-size: 14px; margin-bottom: 0;"><?php echo htmlspecialchars($feature['description']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>