<?php include 'header.php'; ?>

<div class="container-fluid px-0" style="min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="error-container text-center">
                    <!-- Floating Elements Background -->
                    <div class="floating-elements">
                        <div class="float-element" style="top: 10%; left: 10%; animation-delay: 0s;"></div>
                        <div class="float-element" style="top: 20%; right: 15%; animation-delay: 1s;"></div>
                        <div class="float-element" style="bottom: 30%; left: 5%; animation-delay: 2s;"></div>
                        <div class="float-element" style="bottom: 10%; right: 10%; animation-delay: 1.5s;"></div>
                    </div>
                    
                    <!-- Main Error Content -->
                    <div class="error-content">
                        <!-- Animated Icon -->
                        <div class="error-icon-container mb-5">
                            <div class="pulse-ring"></div>
                            <div class="pulse-ring pulse-ring-delay"></div>
                            <i class="fab fa-tiktok error-main-icon"></i>
                        </div>
                        
                        <!-- 404 Text -->
                        <div class="error-code-container mb-4">
                            <h1 class="error-code">
                                <span class="digit">4</span>
                                <span class="digit digit-middle">0</span>
                                <span class="digit">4</span>
                            </h1>
                        </div>
                        
                        <!-- Error Title -->
                        <h2 class="error-title mb-4">
                            <?php echo __('404.title', 'Content Not Found'); ?>
                        </h2>
                        
                        <!-- Error Message -->
                        <p class="error-description mb-5">
                            <?php echo __('404.description', 'The page you\'re looking for has vanished like a trending TikTok sound. Let\'s find you something better!'); ?>
                        </p>
                        
                        <!-- Search Section -->
                        <div class="search-section mb-5">
                            <h5 class="search-title mb-3">
                                <?php echo __('404.search_title', 'Search for Videos'); ?>
                            </h5>
                            <div class="advanced-search-box">
                                <div class="input-wrapper">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" 
                                           id="advancedSearch" 
                                           class="search-input" 
                                           placeholder="<?php echo __('404.search_placeholder', 'Paste TikTok URL or search for videos...'); ?>"
                                           autocomplete="off">
                                    <button type="button" class="search-submit" onclick="performSearch()">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-section mb-5">
                            <div class="btn-group-custom">
                                <a href="<?php echo get_page_url('/'); ?>" class="btn-custom btn-primary-custom">
                                    <i class="fas fa-home"></i>
                                    <span><?php echo __('404.go_home', 'Back to Home'); ?></span>
                                    <div class="btn-custom-glow"></div>
                                </a>
                                <a href="javascript:history.back()" class="btn-custom btn-secondary-custom">
                                    <i class="fas fa-arrow-left"></i>
                                    <span><?php echo __('404.go_back', 'Go Back'); ?></span>
                                    <div class="btn-custom-glow"></div>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Features Grid -->
                        <div class="features-grid">
                            <h5 class="features-title mb-4">
                                <?php echo __('404.why_choose_us', 'Why Choose Our TikTok Downloader?'); ?>
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-3">
                                    <div class="feature-card-advanced">
                                        <div class="feature-icon">
                                            <i class="fas fa-download"></i>
                                        </div>
                                        <h6><?php echo __('404.feature_1_title', 'No Watermark'); ?></h6>
                                        <p><?php echo __('404.feature_1_desc', 'Download clean videos without watermarks'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="feature-card-advanced">
                                        <div class="feature-icon">
                                            <i class="fas fa-bolt"></i>
                                        </div>
                                        <h6><?php echo __('404.feature_2_title', 'Lightning Fast'); ?></h6>
                                        <p><?php echo __('404.feature_2_desc', 'Ultra-fast download speeds and processing'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="feature-card-advanced">
                                        <div class="feature-icon">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <h6><?php echo __('404.feature_3_title', '100% Safe'); ?></h6>
                                        <p><?php echo __('404.feature_3_desc', 'Secure downloads with no malware or viruses'); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="feature-card-advanced">
                                        <div class="feature-icon">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <h6><?php echo __('404.feature_4_title', 'All Devices'); ?></h6>
                                        <p><?php echo __('404.feature_4_desc', 'Works on desktop, mobile, and tablet'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-container {
    position: relative;
    padding: 60px 30px;
    background: var(--glass-bg, rgba(255, 255, 255, 0.02));
    backdrop-filter: blur(20px);
    border-radius: 30px;
    border: 1px solid var(--border-color, rgba(255, 255, 255, 0.1));
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: containerFadeIn 1s ease-out;
}

@keyframes containerFadeIn {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    overflow: hidden;
    border-radius: 30px;
}

.float-element {
    position: absolute;
    width: 20px;
    height: 20px;
    background: var(--primary-color, #00d4ff);
    border-radius: 50%;
    opacity: 0.1;
    animation: floatAround 8s ease-in-out infinite;
}

@keyframes floatAround {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(30px, -30px) scale(1.2); }
    50% { transform: translate(-20px, -50px) scale(0.8); }
    75% { transform: translate(-30px, 20px) scale(1.1); }
}

.error-icon-container {
    position: relative;
    display: inline-block;
}

.pulse-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 150px;
    height: 150px;
    border: 3px solid var(--primary-color, #00d4ff);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: pulseRing 2s ease-out infinite;
    opacity: 0.6;
}

.pulse-ring-delay {
    animation-delay: 1s;
}

@keyframes pulseRing {
    0% {
        transform: translate(-50%, -50%) scale(0.5);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(1.8);
        opacity: 0;
    }
}

.error-main-icon {
    font-size: 80px;
    color: var(--primary-color, #00d4ff);
    position: relative;
    z-index: 2;
    animation: iconPulse 3s ease-in-out infinite;
}

@keyframes iconPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.error-code {
    font-size: 120px;
    font-weight: 900;
    line-height: 1;
    margin: 0;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.digit {
    display: inline-block;
    background: var(--gradient-primary, linear-gradient(135deg, #00d4ff 0%, #00ff88 100%));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: digitGlow 2s ease-in-out infinite alternate;
    text-shadow: 0 0 30px rgba(0, 212, 255, 0.5);
}

.digit-middle {
    animation-delay: 0.3s;
}

.digit:last-child {
    animation-delay: 0.6s;
}

@keyframes digitGlow {
    0% { opacity: 0.8; transform: scale(1); }
    100% { opacity: 1; transform: scale(1.05); }
}

.error-title {
    font-size: 36px;
    font-weight: 700;
    color: var(--light-text, #ffffff);
    margin: 0;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
}

.error-description {
    font-size: 18px;
    color: var(--muted-text, #cccccc);
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.search-section {
    max-width: 600px;
    margin: 0 auto;
}

.search-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--light-text, #ffffff);
    margin: 0;
}

.advanced-search-box {
    position: relative;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 50px;
    padding: 5px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.input-wrapper:focus-within {
    border-color: var(--primary-color, #00d4ff);
    box-shadow: 0 0 30px rgba(0, 212, 255, 0.3);
    background: rgba(255, 255, 255, 0.08);
}

.search-icon {
    position: absolute;
    left: 25px;
    color: var(--muted-text, #cccccc);
    font-size: 18px;
    z-index: 2;
}

.search-input {
    flex: 1;
    background: transparent;
    border: none;
    padding: 18px 25px 18px 55px;
    color: var(--light-text, #ffffff);
    font-size: 16px;
    outline: none;
}

.search-input::placeholder {
    color: var(--muted-text, #cccccc);
}

.search-submit {
    background: var(--primary-color, #00d4ff);
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-right: 5px;
}

.search-submit:hover {
    background: var(--primary-dark, #00b8e6);
    transform: scale(1.1);
    box-shadow: 0 5px 20px rgba(0, 212, 255, 0.4);
}

.btn-group-custom {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-custom {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 15px 30px;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    overflow: hidden;
    z-index: 1;
}

.btn-primary-custom {
    background: var(--gradient-primary, linear-gradient(135deg, #00d4ff 0%, #00ff88 100%));
    color: white;
}

.btn-secondary-custom {
    background: transparent;
    color: var(--light-text, #ffffff);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.btn-custom:hover .btn-custom-glow {
    opacity: 1;
}

.btn-custom-glow {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.features-grid {
    margin-top: 60px;
}

.features-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--light-text, #ffffff);
    margin: 0;
}

.feature-card-advanced {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 30px 20px;
    text-align: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    height: 100%;
}

.feature-card-advanced:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.feature-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--gradient-primary, linear-gradient(135deg, #00d4ff 0%, #00ff88 100%));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 24px;
    color: white;
}

.feature-card-advanced h6 {
    font-size: 18px;
    font-weight: 600;
    color: var(--light-text, #ffffff);
    margin: 0 0 15px;
}

.feature-card-advanced p {
    font-size: 14px;
    color: var(--muted-text, #cccccc);
    margin: 0;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .error-container {
        padding: 40px 20px;
        margin: 20px;
    }
    
    .error-code {
        font-size: 80px;
    }
    
    .error-title {
        font-size: 28px;
    }
    
    .error-description {
        font-size: 16px;
    }
    
    .btn-group-custom {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-custom {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
    
    .features-title {
        font-size: 20px;
    }
}
</style>

<script>
function performSearch() {
    const query = document.getElementById('advancedSearch').value.trim();
    if (query) {
        // Redirect to home with search query
        window.location.href = '<?php echo get_page_url('/'); ?>?q=' + encodeURIComponent(query);
    }
}

// Handle enter key
document.getElementById('advancedSearch').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        performSearch();
    }
});

// Add parallax effect to floating elements
document.addEventListener('mousemove', function(e) {
    const elements = document.querySelectorAll('.float-element');
    const rect = document.querySelector('.error-container').getBoundingClientRect();
    
    const x = (e.clientX - rect.left) / rect.width;
    const y = (e.clientY - rect.top) / rect.height;
    
    elements.forEach((el, index) => {
        const strength = (index + 1) * 0.5;
        const moveX = (x - 0.5) * strength * 20;
        const moveY = (y - 0.5) * strength * 20;
        
        el.style.transform = `translate(${moveX}px, ${moveY}px)`;
    });
});

// Animate features on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.feature-card-advanced');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.animationDelay = `${index * 0.1}s`;
        observer.observe(card);
    });
});
</script>

<?php include 'footer.php'; ?>