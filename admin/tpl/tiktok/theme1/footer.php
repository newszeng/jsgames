    <!-- SnapTik Footer Structure -->
    <footer style="background-color: #161823; color: white; padding: 60px 0 30px;">
        <div class="container">
            <div class="text-center">
                <!-- Static Pages Links -->
                <div style="margin-bottom: 20px;">
                    <a href="<?php echo get_page_url('/terms'); ?>" style="color: #3bb3fb; margin: 0 10px;">Terms of Service</a>
                    <a href="<?php echo get_page_url('/privacy'); ?>" style="color: #3bb3fb; margin: 0 10px;">Privacy Policy</a>
                    <a href="<?php echo get_page_url('/dmca'); ?>" style="color: #3bb3fb; margin: 0 10px;">DMCA</a>
                    <a href="<?php echo get_page_url('/contact'); ?>" style="color: #3bb3fb; margin: 0 10px;">Contact Us</a>
                </div>
                
                <p>© <?php echo date('Y'); ?> <a href="<?php echo get_page_url('/'); ?>" style="color: #3bb3fb;"><?php echo __('site_name', 'SnapTik'); ?></a>. All rights reserved. </p>
                
                <?php
                // Display footer backlinks like SnapTik
                $backlinks_file = __DIR__ . "/../../backlinks/{$GLOBALS['site_domain']}/backlinks.json";
                if (file_exists($backlinks_file)) {
                    $backlinks = json_decode(file_get_contents($backlinks_file), true) ?: [];
                    $footer_links = array_filter($backlinks, function($link) {
                        return ($link['position'] ?? '') == 'footer' && ($link['active'] ?? false);
                    });
                    
                    if (!empty($footer_links)) {
                        echo '<div class="ads_bottom" style="margin: 20px 0 10px 0; width: 100%;">';
                        foreach ($footer_links as $link) {
                            echo '<a href="' . htmlspecialchars($link['url']) . '" target="' . ($link['target'] ?? '_blank') . '" rel="' . ($link['rel'] ?? 'nofollow') . '" style="color: #3bb3fb; margin: 0 10px;">' . htmlspecialchars($link['title']) . '</a>';
                        }
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS (Compatible with SnapTik structure) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SnapTik Original JavaScript Functions -->
    <script>
        // SnapTik-style paste functionality
        $(document).ready(function() {
            $('.btn_paste').click(function() {
                navigator.clipboard.readText().then(function(text) {
                    $('.form-control.addr').val(text);
                }).catch(function(err) {
                    console.error('Failed to read clipboard contents: ', err);
                });
            });
            
            // Form submission handling
            $('.downloadform').submit(function(e) {
                e.preventDefault();
                
                const url = $('.form-control.addr').val().trim();
                const submitBtn = $('.btn_submit');
                const loadingSpinner = $('.ld-ring');
                const resultsContainer = $('.results');
                
                if (!url) {
                    alert('Please enter a TikTok video URL');
                    return;
                }
                
                // Validate TikTok URL
                if (!url.includes('tiktok.com') && !url.includes('vm.tiktok.com')) {
                    alert('Please enter a valid TikTok URL');
                    return;
                }
                
                // Show loading state with loading.gif
                submitBtn.prop('disabled', true);
                loadingSpinner.show();
                resultsContainer.html('<div class="text-center py-4"><img src="/loading.gif" alt="Loading..." style="width: 50px; height: 50px;"><p class="mt-3">' + '<?php echo __('processing_text', 'Processing your TikTok video...'); ?>' + '</p></div>');
                
                // First get CSRF token, then call API
                fetch('/api/csrf.php', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(tokenData => {
                    if (!tokenData.success) {
                        throw new Error('Failed to get security token');
                    }
                    
                    // Now call the download API with CSRF token and HTML format
                    const formData = new FormData();
                    formData.append('csrf_token', tokenData.csrf_token);
                    formData.append('format', 'html');
                    formData.append('url', url);
                    
                    return fetch('/api/downloader.php', {
                        method: 'POST',
                        body: formData
                    });
                })
                .then(response => response.text()) // Get HTML response instead of JSON
                .then(htmlContent => {
                    // Reset button
                    submitBtn.prop('disabled', false);
                    loadingSpinner.hide();
                    resultsContainer.html(htmlContent); // Directly insert the HTML
                })
                .catch(error => {
                    // Reset button
                    submitBtn.prop('disabled', false);
                    loadingSpinner.hide();
                    
                    alert('Network error. Please try again.');
                    console.error('Error:', error);
                });
            });
            
            // FAQ accordion functionality (SnapTik style)
            $('.faq_accordion .btn-link').click(function(e) {
                e.preventDefault();
                const target = $(this).closest('.card').find('.collapse');
                
                // Close other accordions
                $('.faq_accordion .collapse').not(target).removeClass('show');
                
                // Toggle current accordion
                target.toggleClass('show');
            });
        });
    </script>
    
    <!-- CSRF Token Integration -->
    <?php
    // Generate CSRF token for JavaScript use
    $csrf_token = '';
    if (function_exists('generate_csrf_token')) {
        $csrf_token = generate_csrf_token();
    } elseif (isset($_SESSION['csrf_token'])) {
        $csrf_token = $_SESSION['csrf_token'];
    } else {
        // Generate basic token if functions don't exist
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;
    }
    ?>
    <script>
        // Add CSRF token to forms
        $(document).ready(function() {
            $('form').each(function() {
                if (!$(this).find('input[name="csrf_token"]').length) {
                    $(this).append('<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">');
                }
            });
        });
    </script>
    
    <?php if (!empty($GLOBALS['site_config']['analytics']['gtag_id'])): ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $GLOBALS['site_config']['analytics']['gtag_id']; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo $GLOBALS['site_config']['analytics']['gtag_id']; ?>');
    </script>
    <?php endif; ?>
    
    <!-- Download Script -->
    <script>
    function downloadVideo() {
        const urlInput = document.getElementById('videoUrl');
        const url = urlInput.value.trim();
        const resultDiv = document.getElementById('downloadResult');
        const loadingDiv = document.getElementById('loading');
        const btnText = document.querySelector('.btn-text');
        const btnIcon = document.querySelector('.download-btn i');
        
        if (!url) {
            showAlert('<?php echo __('error.empty_url', 'Please enter a TikTok video URL'); ?>', 'warning');
            return;
        }
        
        // Validate TikTok URL or search term
        const isUrl = url.includes('http');
        if (isUrl && !url.includes('tiktok.com') && !url.includes('vm.tiktok.com')) {
            showAlert('<?php echo __('error.invalid_url', 'Please enter a valid TikTok URL'); ?>', 'danger');
            return;
        }
        
        // Show loading state
        btnText.textContent = '<?php echo __('processing', 'Processing...'); ?>';
        btnIcon.className = 'loading-spinner me-2';
        loadingDiv.style.display = 'block';
        resultDiv.innerHTML = '';
        
        // First get CSRF token, then call API
        fetch('/api/csrf.php', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(tokenData => {
            if (!tokenData.success) {
                throw new Error('Failed to get security token');
            }
            
            // Now call the download API with CSRF token and HTML format
            const formData = new FormData();
            formData.append('csrf_token', tokenData.csrf_token);
            formData.append('format', 'html');
            
            if (isUrl) {
                // Download mode
                formData.append('url', url);
            } else {
                // Search mode
                formData.append('action', 'search');
                formData.append('keyword', url);
            }
            
            return fetch('/api/downloader.php', {
                method: 'POST',
                body: formData
            });
        })
        .then(response => response.text()) // Get HTML response instead of JSON
        .then(htmlContent => {
            // Reset button
            btnText.textContent = '<?php echo __('download_button', 'Download'); ?>';
            btnIcon.className = 'fas fa-download me-2';
            loadingDiv.style.display = 'none';
            resultDiv.innerHTML = htmlContent; // Directly insert the HTML
        })
        .catch(error => {
            // Reset button
            btnText.textContent = '<?php echo __('download_button', 'Download'); ?>';
            btnIcon.className = 'fas fa-download me-2';
            loadingDiv.style.display = 'none';
            
            showAlert('<?php echo __('error.network', 'Network error. Please try again.'); ?>', 'danger');
        });
    }
    
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.download-container');
        container.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
    
    // Handle enter key
    document.getElementById('videoUrl').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            downloadVideo();
        }
    });
    
    // Auto focus on input
    document.addEventListener('DOMContentLoaded', function() {
        const urlInput = document.getElementById('videoUrl');
        if (urlInput) {
            urlInput.focus();
        }
    });
    
    // 搜索结果点击处理函数
    window.selectVideo = function(url) {
        console.log("selectVideo called with URL:", url);
        
        // 将URL填入输入框
        const urlInput = document.getElementById('videoUrl');
        if (urlInput) {
            urlInput.value = url;
            
            // 自动触发下载
            downloadVideo();
        }
    };

    </script>
</body>
</html>