<?php require_once 'header.php'; ?>

<!-- Download Section -->
<section class="download-section">
    <div class="container">
        <h1 class="download-title"><?php echo __('home.title', 'TikTok Video Downloader'); ?></h1>
        <p class="download-subtitle"><?php echo __('home.subtitle', 'Download TikTok videos without watermark in HD quality'); ?></p>
        
        <div class="download-form">
            <input type="text" 
                   class="url-input" 
                   id="tiktokUrl" 
                   placeholder="<?php echo __('home.placeholder', 'Paste TikTok video link here...'); ?>" 
                   autocomplete="off">
            <button type="button" class="paste-btn" onclick="pasteFromClipboard()">
                <?php echo __('paste_button', 'Paste'); ?>
            </button>
            <button type="button" class="download-btn" onclick="downloadVideo()" id="downloadBtn">
                <?php echo __('download_button', 'Download'); ?>
            </button>
        </div>
        
        <div class="format-info">
            <?php echo __('supported_formats', 'Supported formats: MP4, MP3 | Quality: HD, Full HD, 4K'); ?>
        </div>
        
        <!-- Progress Bar -->
        <div class="progress-container" id="progressContainer">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-text" id="progressText">0%</div>
        </div>
        
        <!-- Results Container -->
        <div class="results-container" id="resultsContainer"></div>
    </div>
</section>

<!-- Features Section -->
<section class="content-section">
    <div class="container">
        <h2><?php echo __('features.title', 'Why Choose Our TikTok Downloader?'); ?></h2>
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon">⚡</div>
                <h3><?php echo __('features.fast.title', 'Fast & Free'); ?></h3>
                <p><?php echo __('features.fast.desc', 'Download TikTok videos quickly and completely free. No registration required.'); ?></p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">🚫</div>
                <h3><?php echo __('features.watermark.title', 'No Watermark'); ?></h3>
                <p><?php echo __('features.watermark.desc', 'Remove TikTok watermarks automatically and save clean videos in original quality.'); ?></p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">🎬</div>
                <h3><?php echo __('features.formats.title', 'Multiple Formats'); ?></h3>
                <p><?php echo __('features.formats.desc', 'Download as MP4 video or extract MP3 audio. Choose the format that suits you best.'); ?></p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">📱</div>
                <h3><?php echo __('features.mobile.title', 'All Devices'); ?></h3>
                <p><?php echo __('features.mobile.desc', 'Works on desktop, tablet, and mobile devices. No app installation needed.'); ?></p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">🔒</div>
                <h3><?php echo __('features.safe.title', 'Safe & Secure'); ?></h3>
                <p><?php echo __('features.safe.desc', 'Your privacy is protected. We don\'t store your videos or personal data.'); ?></p>
            </div>
            
            <div class="feature-item">
                <div class="feature-icon">💎</div>
                <h3><?php echo __('features.quality.title', 'HD Quality'); ?></h3>
                <p><?php echo __('features.quality.desc', 'Download videos in the highest available quality, including HD and Full HD.'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- How to Use Section -->
<section class="content-section">
    <div class="container">
        <h2><?php echo __('how_to.title', 'How to Download TikTok Videos?'); ?></h2>
        <ul class="steps-list">
            <li>
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4><?php echo __('how_to.step1.title', 'Find the TikTok video'); ?></h4>
                    <p><?php echo __('how_to.step1.desc', 'Open TikTok app or website and find the video you want to download.'); ?></p>
                </div>
            </li>
            <li>
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4><?php echo __('how_to.step2.title', 'Copy the video link'); ?></h4>
                    <p><?php echo __('how_to.step2.desc', 'Tap the Share button and select "Copy link" to copy the video URL.'); ?></p>
                </div>
            </li>
            <li>
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4><?php echo __('how_to.step3.title', 'Paste and download'); ?></h4>
                    <p><?php echo __('how_to.step3.desc', 'Paste the link in the input field above and click the Download button.'); ?></p>
                </div>
            </li>
            <li>
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4><?php echo __('how_to.step4.title', 'Save to your device'); ?></h4>
                    <p><?php echo __('how_to.step4.desc', 'Choose your preferred format and quality, then save the video to your device.'); ?></p>
                </div>
            </li>
        </ul>
    </div>
</section>

<!-- Description Section -->
<section class="content-section">
    <div class="container">
        <h2><?php echo __('descriptions.title', 'Download TikTok videos without watermark for free'); ?></h2>
        <p><?php echo str_replace('{site_name}', '<strong>' . __('site_name', 'TikTokio') . '</strong>', __('descriptions.main_desc', '{site_name} is a free TikTok video downloader that allows you to download TikTok videos without watermark in MP4 format and HD, Full HD, or 4K quality. You don\'t need to install any application on your mobile or computer; you only need a TikTok video link, and we will do the rest. Using {site_name}, you can save videos to your device with just a single click.')); ?></p>
        
        <h3 style="color: #007bff; margin-top: 40px; margin-bottom: 20px;"><?php echo __('descriptions.how_to_title', 'How to download TikTok videos without watermark?'); ?></h3>
        <p style="margin-bottom: 30px;"><?php echo str_replace('{site_name}', __('site_name', 'TikTokio'), __('descriptions.how_to_subtitle', '{site_name} has made it easy for you. Just follow the steps below.')); ?></p>
        
        <div style="background: #f8f9fa; padding: 30px; border-radius: 12px; margin-bottom: 30px;">
            <div style="margin-bottom: 25px;">
                <h4 style="color: #007bff; font-size: 18px; margin-bottom: 10px;"><?php echo __('descriptions.step1_title', 'Step 1: Copy Link'); ?></h4>
                <p style="margin: 0; color: #666;"><?php echo __('descriptions.step1_desc', 'On the TikTok application, open your desired video, tap the Share button at the bottom right, and then tap the Copy Link option.'); ?></p>
            </div>
            
            <div style="margin-bottom: 25px;">
                <h4 style="color: #007bff; font-size: 18px; margin-bottom: 10px;"><?php echo __('descriptions.step2_title', 'Step 2: Paste the Link'); ?></h4>
                <p style="margin: 0; color: #666;"><?php echo str_replace('{site_name}', __('site_name', 'TikTokio'), __('descriptions.step2_desc', 'Return to the {site_name} website, paste the copied URL into the address field, and then tap the Download button.')); ?></p>
            </div>
            
            <div style="margin-bottom: 0;">
                <h4 style="color: #007bff; font-size: 18px; margin-bottom: 10px;"><?php echo __('descriptions.step3_title', 'Step 3: Download'); ?></h4>
                <p style="margin: 0; color: #666;"><?php echo str_replace('{site_name}', __('site_name', 'TikTokio'), __('descriptions.step3_desc', 'Wait while {site_name} processes the video. Choose the desired quality and download the video.')); ?></p>
            </div>
        </div>
        
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
            <p style="margin: 0; color: #856404; font-size: 14px;"><strong>Note:</strong> <?php echo str_replace('{site_name}', __('site_name', 'TikTokio'), __('descriptions.note', '{site_name} is a website that allows users to remove watermarks from TikTok videos for free without profits. We only support downloading public TikTok videos. We are not responsible for copyright issues if you use that video for any other profitable purpose.')); ?></p>
        </div>
    </div>
</section>

<!-- Tips Section -->
<section class="content-section">
    <div class="container">
        <h2><?php echo __('tips.title', 'Pro Tips for TikTok Downloads'); ?></h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-top: 30px;">
            <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; border-left: 4px solid #007bff;">
                <h4 style="color: #007bff; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center;">
                    <span style="background: #007bff; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;">💡</span>
                    <?php echo __('tips.tip1.title', 'Best Quality Downloads'); ?>
                </h4>
                <p style="margin: 0; color: #666; line-height: 1.6;"><?php echo __('tips.tip1.desc', 'Always choose HD quality for the best video experience on any device.'); ?></p>
            </div>
            
            <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; border-left: 4px solid #007bff;">
                <h4 style="color: #007bff; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center;">
                    <span style="background: #007bff; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;">📱</span>
                    <?php echo __('tips.tip2.title', 'Mobile Friendly'); ?>
                </h4>
                <p style="margin: 0; color: #666; line-height: 1.6;"><?php echo __('tips.tip2.desc', 'Use our tool directly from your mobile browser - no app installation needed.'); ?></p>
            </div>
            
            <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; border-left: 4px solid #007bff;">
                <h4 style="color: #007bff; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center;">
                    <span style="background: #007bff; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 14px;">🤝</span>
                    <?php echo __('tips.tip3.title', 'Respect Creators'); ?>
                </h4>
                <p style="margin: 0; color: #666; line-height: 1.6;"><?php echo __('tips.tip3.desc', 'Use downloads for personal purposes and always credit original creators.'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="content-section">
    <div class="container">
        <h2><?php echo __('faq.title', 'Frequently Asked Questions'); ?></h2>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3 style="color: #333; margin-bottom: 10px; font-size: 18px;"><?php echo __('faq.q1', 'Is it free to use this TikTok downloader?'); ?></h3>
                <p style="color: #666; margin: 0;"><?php echo __('faq.a1', 'Yes, our TikTok video downloader is completely free to use. You can download unlimited videos without any registration or subscription.'); ?></p>
            </div>
            
            <div style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3 style="color: #333; margin-bottom: 10px; font-size: 18px;"><?php echo __('faq.q2', 'Can I download TikTok videos without watermark?'); ?></h3>
                <p style="color: #666; margin: 0;"><?php echo __('faq.a2', 'Yes, our tool can remove TikTok watermarks automatically and provide you with clean video downloads in original quality.'); ?></p>
            </div>
            
            <div style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3 style="color: #333; margin-bottom: 10px; font-size: 18px;"><?php echo __('faq.q3', 'What video formats are supported?'); ?></h3>
                <p style="color: #666; margin: 0;"><?php echo __('faq.a3', 'We support MP4 video downloads and MP3 audio extraction. You can choose the format that best suits your needs.'); ?></p>
            </div>
            
            <div style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                <h3 style="color: #333; margin-bottom: 10px; font-size: 18px;"><?php echo __('faq.q4', 'Is it safe to download TikTok videos?'); ?></h3>
                <p style="color: #666; margin: 0;"><?php echo __('faq.a4', 'Yes, it\'s completely safe. We don\'t store your videos or personal data on our servers. Your privacy is fully protected.'); ?></p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'footer.php'; ?>