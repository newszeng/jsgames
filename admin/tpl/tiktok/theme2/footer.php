    </main>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-links">
                <a href="<?php echo get_page_url('/privacy'); ?>"><?php echo __('footer.privacy', 'Privacy Policy'); ?></a>
                <a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('footer.terms', 'Terms of Service'); ?></a>
                <a href="<?php echo get_page_url('/contact'); ?>"><?php echo __('footer.contact', 'Contact'); ?></a>
                <a href="<?php echo get_page_url('/dmca'); ?>"><?php echo __('footer.dmca', 'DMCA'); ?></a>

                <?php
                // Add dynamic footer backlinks
                $backlinks_file = __DIR__ . "/../../backlinks/{$GLOBALS['site_domain']}/backlinks.json";
                if (file_exists($backlinks_file)) {
                    $backlinks = json_decode(file_get_contents($backlinks_file), true) ?: [];
                    $footer_links = array_filter($backlinks, function($link) {
                        return ($link['position'] ?? '') == 'footer' && ($link['active'] ?? false);
                    });
                    
                    foreach ($footer_links as $link) {
                        echo '<a href="' . htmlspecialchars($link['url']) . '" target="' . ($link['target'] ?? '_blank') . '" rel="' . ($link['rel'] ?? 'nofollow') . '">' . htmlspecialchars($link['title']) . '</a>';
                    }
                }
                ?>
            </div>
            
            <div class="footer-copyright">
                © <?php echo date('Y'); ?> <?php echo __('site_name', 'TikTokio'); ?>. <?php echo __('footer.copyright', 'All rights reserved.'); ?>
                <br><br>
                <?php echo __('footer.disclaimer', 'This tool is for personal use only. Please respect content creators and TikTok\'s terms of service. We are not affiliated with TikTok.'); ?>
            </div>
        </div>
    </div>
</footer>

<script>
// Language change function
function changeLanguage(url) {
    if (url) {
        window.location.href = url;
    }
}

// Paste from clipboard function
function pasteFromClipboard() {
    if (navigator.clipboard && navigator.clipboard.readText) {
        navigator.clipboard.readText().then(function(text) {
            document.getElementById('tiktokUrl').value = text;
        }).catch(function(err) {
            console.error('Failed to read clipboard:', err);
            // Fallback: focus on input for manual paste
            document.getElementById('tiktokUrl').focus();
        });
    } else {
        // Fallback for older browsers
        document.getElementById('tiktokUrl').focus();
    }
}

// Main download function
function downloadVideo() {
    const urlInput = document.getElementById('tiktokUrl');
    const url = urlInput.value.trim();
    const downloadBtn = document.getElementById('downloadBtn');
    const progressContainer = document.getElementById('progressContainer');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');
    const resultsContainer = document.getElementById('resultsContainer');
    
    // Validation
    if (!url) {
        alert('<?php echo __('error.empty_url', 'Please enter a TikTok video URL'); ?>');
        urlInput.focus();
        return;
    }
    
    // Show loading state
    downloadBtn.disabled = true;
    downloadBtn.textContent = '<?php echo __('processing', 'Processing...'); ?>';
    progressContainer.style.display = 'block';
    resultsContainer.style.display = 'none';
    
    // Progress animation
    let progress = 0;
    const progressInterval = setInterval(() => {
        progress += Math.random() * 10 + 5;
        if (progress > 90) progress = 90;
        progressFill.style.width = progress + '%';
        progressText.textContent = Math.round(progress) + '%';
    }, 300);
    
    // CSRF token and API call
    fetch('/api/csrf.php', {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(tokenData => {
        if (!tokenData.success) {
            throw new Error('Failed to get security token');
        }
        
        // Prepare form data
        const formData = new FormData();
        formData.append('csrf_token', tokenData.csrf_token);
        formData.append('format', 'html');
        formData.append('url', url);
        
        return fetch('/api/downloader.php', {
            method: 'POST',
            body: formData
        });
    })
    .then(response => response.text())
    .then(htmlContent => {
        // Complete progress
        clearInterval(progressInterval);
        progressFill.style.width = '100%';
        progressText.textContent = '100%';
        
        // Show results after a brief delay
        setTimeout(() => {
            downloadBtn.disabled = false;
            downloadBtn.textContent = '<?php echo __('download_button', 'Download'); ?>';
            progressContainer.style.display = 'none';
            
            // Display results
            resultsContainer.innerHTML = htmlContent;
            resultsContainer.style.display = 'block';
            
            // Scroll to results
            resultsContainer.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 800);
    })
    .catch(error => {
        clearInterval(progressInterval);
        downloadBtn.disabled = false;
        downloadBtn.textContent = '<?php echo __('download_button', 'Download'); ?>';
        progressContainer.style.display = 'none';
        
        console.error('Download error:', error);
        alert('<?php echo __('error.network', 'Network error. Please try again later.'); ?>');
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('tiktokUrl');
    
    if (urlInput) {
        // Enter key support
        urlInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                downloadVideo();
            }
        });
        
        // Auto focus on load
        setTimeout(() => {
            urlInput.focus();
        }, 800);
    }
});

// Search result handler (for compatibility with search results)
window.selectVideo = function(url) {
    const urlInput = document.getElementById('tiktokUrl');
    if (urlInput) {
        urlInput.value = url;
        downloadVideo();
    }
};

// Prevent multiple rapid submissions
let isProcessing = false;
const originalDownloadVideo = downloadVideo;
downloadVideo = function() {
    if (isProcessing) {
        return;
    }
    isProcessing = true;
    originalDownloadVideo();
    setTimeout(() => {
        isProcessing = false;
    }, 2000);
};
</script>

</body>
</html>