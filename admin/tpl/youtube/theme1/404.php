<?php include 'header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="error-page-container text-center">
                
                <!-- Error Icon -->
                <div class="error-icon-wrapper mb-4">
                    <i class="fab fa-youtube error-icon"></i>
                    <div class="icon-glow"></div>
                </div>
                
                <!-- 404 Code -->
                <div class="error-code-display mb-3">
                    <h1 class="error-code">404</h1>
                    <div class="error-underline"></div>
                </div>
                
                <!-- Error Title -->
                <h2 class="error-title mb-3">
                    <?php echo __('404.title', 'Page Not Found'); ?>
                </h2>
                
                <!-- Error Message -->
                <p class="error-message mb-4">
                    <?php echo __('404.message', 'Oops! The page you\'re looking for doesn\'t exist. It might have been moved, deleted, or you entered the wrong URL.'); ?>
                </p>
                
                <!-- Search Section -->
                <div class="search-section mb-5">
                    <h5 class="search-heading mb-3">
                        <?php echo __('404.search_heading', 'Try searching for a video instead:'); ?>
                    </h5>
                    
                    <div class="search-form">
                        <div class="input-group search-input-group">
                            <span class="input-group-text search-icon-bg">
                                <i class="fas fa-search search-icon"></i>
                            </span>
                            <input type="text" 
                                   class="form-control search-input-404" 
                                   id="search404Input"
                                   placeholder="<?php echo __('404.search_placeholder', 'Paste YouTube URL or search for videos...'); ?>"
                                   autocomplete="off">
                            <button class="btn btn-primary search-btn-404" type="button" onclick="handleSearch404()">
                                <?php echo __('404.search_btn', 'Search'); ?>
                            </button>
                        </div>
                        
                        <!-- Search suggestions -->
                        <div class="search-suggestions mt-3">
                            <span class="suggestion-label"><?php echo __('404.popular_searches', 'Popular:'); ?></span>
                            <button class="suggestion-tag" onclick="searchFor('music')"><?php echo __('404.tag_music', 'Music'); ?></button>
                            <button class="suggestion-tag" onclick="searchFor('tutorial')"><?php echo __('404.tag_tutorial', 'Tutorial'); ?></button>
                            <button class="suggestion-tag" onclick="searchFor('gaming')"><?php echo __('404.tag_gaming', 'Gaming'); ?></button>
                            <button class="suggestion-tag" onclick="searchFor('news')"><?php echo __('404.tag_news', 'News'); ?></button>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons mb-5">
                    <a href="<?php echo get_page_url('/'); ?>" class="btn btn-primary btn-lg action-btn">
                        <i class="fas fa-home me-2"></i>
                        <?php echo __('404.go_home', 'Back to Home'); ?>
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-primary btn-lg action-btn">
                        <i class="fas fa-arrow-left me-2"></i>
                        <?php echo __('404.go_back', 'Go Back'); ?>
                    </a>
                </div>
                
                <!-- Features Section -->
                <div class="features-section">
                    <h5 class="features-heading mb-4">
                        <?php echo __('404.why_use_us', 'Why Use Our YouTube Downloader?'); ?>
                    </h5>
                    
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon-container">
                                    <i class="fas fa-hd-video feature-icon"></i>
                                </div>
                                <h6 class="feature-title">
                                    <?php echo __('404.feature_hd_title', 'HD Quality'); ?>
                                </h6>
                                <p class="feature-description">
                                    <?php echo __('404.feature_hd_desc', 'Download videos in up to 4K resolution'); ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon-container">
                                    <i class="fas fa-music feature-icon"></i>
                                </div>
                                <h6 class="feature-title">
                                    <?php echo __('404.feature_mp3_title', 'MP3 Convert'); ?>
                                </h6>
                                <p class="feature-description">
                                    <?php echo __('404.feature_mp3_desc', 'Extract audio in high-quality MP3'); ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon-container">
                                    <i class="fas fa-bolt feature-icon"></i>
                                </div>
                                <h6 class="feature-title">
                                    <?php echo __('404.feature_fast_title', 'Super Fast'); ?>
                                </h6>
                                <p class="feature-description">
                                    <?php echo __('404.feature_fast_desc', 'Lightning fast download speeds'); ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-item">
                                <div class="feature-icon-container">
                                    <i class="fas fa-shield-alt feature-icon"></i>
                                </div>
                                <h6 class="feature-title">
                                    <?php echo __('404.feature_safe_title', '100% Safe'); ?>
                                </h6>
                                <p class="feature-description">
                                    <?php echo __('404.feature_safe_desc', 'No malware or unwanted software'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<style>
.error-page-container {
    padding: 40px 20px;
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.error-icon-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 30px;
}

.error-icon {
    font-size: 100px;
    color: #ff0000;
    position: relative;
    z-index: 2;
    animation: iconBounce 2s ease-in-out infinite;
}

@keyframes iconBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.icon-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 120px;
    height: 120px;
    background: radial-gradient(circle, rgba(255, 0, 0, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: iconGlow 2s ease-in-out infinite alternate;
}

@keyframes iconGlow {
    0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.5; }
    100% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.8; }
}

.error-code-display {
    position: relative;
    display: inline-block;
}

.error-code {
    font-size: 120px;
    font-weight: 900;
    color: #ff0000;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    line-height: 1;
}

.error-underline {
    height: 6px;
    background: linear-gradient(90deg, transparent 0%, #ff0000 50%, transparent 100%);
    border-radius: 3px;
    margin-top: 10px;
    animation: underlineExpand 1.5s ease-out;
}

@keyframes underlineExpand {
    0% { width: 0; margin-left: 50%; }
    100% { width: 100%; margin-left: 0; }
}

.error-title {
    font-size: 36px;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.error-message {
    font-size: 18px;
    color: #666;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.search-section {
    background: #f8f9fa;
    padding: 40px 30px;
    border-radius: 15px;
    border: 1px solid #e9ecef;
}

.search-heading {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.search-input-group {
    max-width: 500px;
    margin: 0 auto;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.search-icon-bg {
    background: #ff0000;
    border: none;
    color: white;
}

.search-input-404 {
    border: none;
    padding: 15px 20px;
    font-size: 16px;
    background: white;
}

.search-input-404:focus {
    box-shadow: none;
    border: none;
}

.search-btn-404 {
    background: #ff0000;
    border: none;
    padding: 15px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.search-btn-404:hover {
    background: #cc0000;
    transform: translateY(-1px);
}

.search-suggestions {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
}

.suggestion-label {
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.suggestion-tag {
    background: white;
    border: 1px solid #ddd;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
    color: #666;
    cursor: pointer;
    transition: all 0.3s ease;
}

.suggestion-tag:hover {
    background: #ff0000;
    color: white;
    border-color: #ff0000;
    transform: translateY(-1px);
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.action-btn {
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 25px;
    transition: all 0.3s ease;
    min-width: 160px;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.features-section {
    margin-top: 50px;
}

.features-heading {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.feature-item {
    background: white;
    padding: 30px 20px;
    border-radius: 15px;
    border: 1px solid #e9ecef;
    height: 100%;
    transition: all 0.3s ease;
    text-align: center;
}

.feature-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: #ff0000;
}

.feature-icon-container {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    transition: all 0.3s ease;
}

.feature-item:hover .feature-icon-container {
    transform: scale(1.1) rotate(5deg);
}

.feature-icon {
    font-size: 28px;
    color: white;
}

.feature-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px;
}

.feature-description {
    font-size: 14px;
    color: #666;
    margin: 0;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .error-code {
        font-size: 80px;
    }
    
    .error-title {
        font-size: 28px;
    }
    
    .error-message {
        font-size: 16px;
    }
    
    .search-section {
        padding: 30px 20px;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .action-btn {
        width: 100%;
        max-width: 300px;
    }
    
    .search-suggestions {
        margin-top: 15px;
    }
    
    .suggestion-label {
        width: 100%;
        text-align: center;
        margin-bottom: 10px;
    }
}
</style>

<script>
function handleSearch404() {
    const searchInput = document.getElementById('search404Input');
    const query = searchInput.value.trim();
    
    if (query) {
        // Redirect to home page with search query
        window.location.href = '<?php echo get_page_url('/'); ?>?q=' + encodeURIComponent(query);
    } else {
        // Focus the input if empty
        searchInput.focus();
    }
}

function searchFor(term) {
    document.getElementById('search404Input').value = term;
    handleSearch404();
}

// Handle enter key in search input
document.getElementById('search404Input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        handleSearch404();
    }
});

// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Animate features on scroll
    const features = document.querySelectorAll('.feature-item');
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, observerOptions);
    
    features.forEach(feature => {
        feature.style.opacity = '0';
        feature.style.transform = 'translateY(20px)';
        feature.style.transition = 'all 0.6s ease';
        observer.observe(feature);
    });
    
    // Auto focus search input after a delay
    setTimeout(() => {
        document.getElementById('search404Input').focus();
    }, 1000);
});
</script>

<?php include 'footer.php'; ?>