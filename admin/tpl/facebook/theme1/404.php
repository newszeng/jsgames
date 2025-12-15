<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="error-page text-center">
                <!-- Animated TikTok Logo -->
                <div class="error-icon mb-4">
                    <i class="fab fa-tiktok" style="font-size: 120px; color: var(--primary-color); animation: bounce 2s infinite;"></i>
                </div>
                
                <!-- 404 Code -->
                <div class="error-code mb-3">
                    <span style="font-size: 120px; font-weight: 800; background: linear-gradient(45deg, var(--primary-color), #ff0050); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1;">404</span>
                </div>
                
                <!-- Error Title -->
                <h1 class="error-title mb-3" style="color: white; font-size: 32px; font-weight: 700;">
                    <?php echo __('404.title', 'Video Not Found!'); ?>
                </h1>
                
                <!-- Error Message -->
                <p class="error-message mb-4" style="color: #cccccc; font-size: 18px; line-height: 1.6;">
                    <?php echo __('404.message', 'Oops! The page you\'re looking for seems to have disappeared like a viral TikTok trend. Don\'t worry, let\'s get you back on track!'); ?>
                </p>
                
                <!-- Search Box -->
                <div class="search-box mb-4">
                    <div class="input-group" style="max-width: 500px; margin: 0 auto;">
                        <input type="text" 
                               class="form-control search-input" 
                               placeholder="<?php echo __('404.search_placeholder', 'Search for TikTok videos...'); ?>" 
                               id="search404" 
                               style="background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.2); color: white; height: 55px; font-size: 16px;">
                        <button class="btn search-btn" 
                                type="button" 
                                onclick="search404()"
                                style="background: var(--primary-color); border: none; color: white; padding: 0 25px;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons d-flex flex-wrap gap-3 justify-content-center mb-4">
                    <a href="<?php echo get_page_url('/'); ?>" class="btn btn-primary btn-lg" style="padding: 12px 30px; font-weight: 600;">
                        <i class="fas fa-home me-2"></i>
                        <?php echo __('404.go_home', 'Go Home'); ?>
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-light btn-lg" style="padding: 12px 30px; font-weight: 600;">
                        <i class="fas fa-arrow-left me-2"></i>
                        <?php echo __('404.go_back', 'Go Back'); ?>
                    </a>
                </div>
                
                <!-- Popular Features -->
                <div class="popular-features">
                    <h5 class="mb-3" style="color: #cccccc; font-weight: 600;">
                        <?php echo __('404.try_these', 'Try These Popular Features:'); ?>
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="feature-card p-3" style="background: rgba(255,255,255,0.05); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                                <i class="fas fa-download mb-2" style="color: var(--primary-color); font-size: 24px;"></i>
                                <h6 style="color: white; font-weight: 600;">
                                    <?php echo __('404.feature_download', 'Video Download'); ?>
                                </h6>
                                <p style="color: #cccccc; font-size: 14px; margin: 0;">
                                    <?php echo __('404.feature_download_desc', 'Download TikTok videos without watermark'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card p-3" style="background: rgba(255,255,255,0.05); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                                <i class="fas fa-music mb-2" style="color: var(--primary-color); font-size: 24px;"></i>
                                <h6 style="color: white; font-weight: 600;">
                                    <?php echo __('404.feature_audio', 'Audio Extract'); ?>
                                </h6>
                                <p style="color: #cccccc; font-size: 14px; margin: 0;">
                                    <?php echo __('404.feature_audio_desc', 'Extract audio from TikTok videos'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card p-3" style="background: rgba(255,255,255,0.05); border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                                <i class="fas fa-mobile-alt mb-2" style="color: var(--primary-color); font-size: 24px;"></i>
                                <h6 style="color: white; font-weight: 600;">
                                    <?php echo __('404.feature_mobile', 'Mobile Friendly'); ?>
                                </h6>
                                <p style="color: #cccccc; font-size: 14px; margin: 0;">
                                    <?php echo __('404.feature_mobile_desc', 'Works perfectly on all devices'); ?>
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
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-30px); }
    60% { transform: translateY(-15px); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.error-page {
    padding: 40px 20px;
    animation: fadeInUp 0.6s ease-out;
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

.search-input:focus {
    background: rgba(255,255,255,0.15) !important;
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25) !important;
}

.search-input::placeholder {
    color: rgba(255,255,255,0.7);
}

.btn {
    border-radius: 25px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.feature-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.feature-card:hover {
    background: rgba(255,255,255,0.1) !important;
    transform: translateY(-5px);
}

@media (max-width: 768px) {
    .error-code span {
        font-size: 80px !important;
    }
    
    .error-title {
        font-size: 24px !important;
    }
    
    .error-message {
        font-size: 16px !important;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>

<script>
function search404() {
    const query = document.getElementById('search404').value.trim();
    if (query) {
        // Redirect to home page with search query
        window.location.href = '<?php echo get_page_url('/'); ?>?q=' + encodeURIComponent(query);
    }
}

// Handle enter key in search box
document.getElementById('search404').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        search404();
    }
});

// Add some interactive elements
document.addEventListener('DOMContentLoaded', function() {
    // Animate feature cards on scroll
    const cards = document.querySelectorAll('.feature-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                }, index * 100);
            }
        });
    });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        observer.observe(card);
    });
});
</script>

<?php include 'footer.php'; ?>