// Wordly.org JavaScript - 100% Replica Functionality

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functionality
    initializeGame();
    initializeGameOptions();
    initializeAnalytics();
    initializeMobileOptimizations();
});

// Game initialization
function initializeGame() {
    // Track page view
    trackEvent('page_view', {
        'page': window.location.pathname,
        'game_type': 'wordly'
    });
    
    // Play button functionality
    const playButtons = document.querySelectorAll('.play-button');
    playButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            trackEvent('play_button_click', {
                'source': 'hero_section'
            });
        });
    });
}

// FAQ functionality removed - now handled by pure CSS

// Game options functionality
function initializeGameOptions() {
    // Word length selection
    document.querySelectorAll('[data-length]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Update active state
            document.querySelectorAll('[data-length]').forEach(b => {
                b.classList.remove('active');
            });
            button.classList.add('active');
            
            const length = button.dataset.length;
            
            // Track selection
            trackEvent('word_length_selected', {
                'length': parseInt(length)
            });
            
            // Store preference
            localStorage.setItem('wordly_word_length', length);
            
            console.log('Word length selected:', length);
        });
    });
    
    // Language selection tracking
    document.querySelectorAll('.option-btn[href*="lang"]').forEach(button => {
        button.addEventListener('click', function() {
            const lang = this.href.match(/lang=([^&]+)/)?.[1] || 'en';
            trackEvent('language_selected', {
                'language': lang
            });
        });
    });
    
    // Load saved preferences
    const savedLength = localStorage.getItem('wordly_word_length');
    if (savedLength) {
        const lengthButton = document.querySelector(`[data-length="${savedLength}"]`);
        if (lengthButton) {
            document.querySelectorAll('[data-length]').forEach(b => b.classList.remove('active'));
            lengthButton.classList.add('active');
        }
    }
}

// Analytics and tracking
function initializeAnalytics() {
    // Track scroll depth
    let maxScroll = 0;
    window.addEventListener('scroll', function() {
        const scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
        if (scrollPercent > maxScroll) {
            maxScroll = scrollPercent;
            if (maxScroll % 25 === 0) { // Track at 25%, 50%, 75%, 100%
                trackEvent('scroll_depth', {
                    'percent': maxScroll
                });
            }
        }
    });
    
    // Track time on page
    const startTime = Date.now();
    window.addEventListener('beforeunload', function() {
        const timeOnPage = Date.now() - startTime;
        trackEvent('time_on_page', {
            'seconds': Math.round(timeOnPage / 1000)
        });
    });
    
    // Track outbound links
    document.querySelectorAll('a[href^="http"]').forEach(link => {
        link.addEventListener('click', function() {
            trackEvent('outbound_click', {
                'url': this.href,
                'text': this.textContent.trim()
            });
        });
    });
}

// Mobile optimizations
function initializeMobileOptimizations() {
    if (window.innerWidth <= 768) {
        // Optimize for mobile view
        optimizeForMobile();
    }
    
    // Handle orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(optimizeForMobile, 100);
    });
}

function optimizeForMobile() {
    // Adjust hero section for mobile
    const hero = document.querySelector('.hero');
    if (hero && window.innerHeight < 600) {
        hero.style.padding = '20px 0';
    }
    
    // Optimize FAQ for touch
    document.querySelectorAll('.faq-question').forEach(button => {
        button.style.minHeight = '48px'; // Touch target size
    });
    
    // Prevent zoom on button tap
    document.querySelectorAll('.option-btn').forEach(btn => {
        btn.addEventListener('touchstart', function(e) {
            // Prevent zoom
        });
    });
}

// Share functionality
function shareGame(method) {
    const url = window.location.href;
    const title = document.title;
    const text = "I just played Wordly! Can you guess the hidden word?";
    
    switch(method) {
        case 'native':
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: text,
                    url: url
                });
            }
            break;
            
        case 'facebook':
            const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            window.open(facebookUrl, '_blank', 'width=600,height=400');
            break;
            
        case 'twitter':
            const twitterUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
            window.open(twitterUrl, '_blank', 'width=600,height=400');
            break;
            
        case 'whatsapp':
            const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
            window.open(whatsappUrl, '_blank');
            break;
            
        case 'copy':
            navigator.clipboard.writeText(url).then(function() {
                showNotification('Link copied to clipboard!');
            });
            break;
    }
    
    trackEvent('share_click', {
        'method': method,
        'page': window.location.pathname
    });
}

// Notification system
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : '#f44336'};
        color: white;
        padding: 12px 20px;
        border-radius: 4px;
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Utility functions
function trackEvent(eventName, eventData = {}) {
    // Google Analytics 4
    if (typeof gtag !== 'undefined') {
        gtag('event', eventName, eventData);
    }
    
    // Custom analytics
    if (window.analytics && typeof window.analytics.track === 'function') {
        window.analytics.track(eventName, eventData);
    }
    
    // Console log for debugging
    console.log('Event tracked:', eventName, eventData);
}

function getCurrentWordLength() {
    const activeButton = document.querySelector('[data-length].active');
    return activeButton ? parseInt(activeButton.dataset.length) : 5;
}

function getCurrentLanguage() {
    return document.documentElement.lang || 'en';
}

// Expose global functions
window.shareGame = shareGame;
window.trackEvent = trackEvent;
window.showNotification = showNotification;
window.getCurrentWordLength = getCurrentWordLength;
window.getCurrentLanguage = getCurrentLanguage;

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .faq-question.active {
        background: #e9ecef !important;
    }
`;
document.head.appendChild(style);