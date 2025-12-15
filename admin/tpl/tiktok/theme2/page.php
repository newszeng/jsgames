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
$GLOBALS['template_data']['title'] = $page_data['home']['title'] ?? 'Download TikTok Videos';
$GLOBALS['template_data']['meta_description'] = str_replace('{site_name}',  __('site_name', 'SnapTik'), $page_data['site_description']) ?? '';

require_once 'header.php';
?>

    <!-- Download Section -->
    <section class="download-section">
        <div class="container">
            <h1 class="download-title"><?php echo htmlspecialchars($page_data['home']['title'] ?? 'TikTok Video Downloader'); ?></h1>
            <p class="download-subtitle"><?php echo __('hero_subtitle', 'Download TikTok videos without watermark in HD quality'); ?></p>

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
                <?php echo __('page.format_info', 'Supported formats: MP4, MP3 | Quality: HD, Full HD, 4K'); ?>
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

    <!-- Custom Content Section -->
    <section class="content-section">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">
                <?php if (!empty($page_data['content'])): ?>
                    <?php echo $page_data['content']; ?>
                <?php else: ?>
                    <h2><?php echo $page_data['custom_content']['title']; ?></h2>
                    <?php echo $page_data['custom_content']['content']; ?>
                <?php endif; ?>
            </div>
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
                    <div class="feature-icon">💎</div>
                    <h3><?php echo __('features.quality.title', 'HD Quality'); ?></h3>
                    <p><?php echo __('features.quality.desc', 'Download videos in the highest available quality, including HD and Full HD.'); ?></p>
                </div>
            </div>
        </div>
    </section>

<?php require_once 'footer.php'; ?>