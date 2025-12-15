// 异步下载处理脚本
// 这个脚本应该被包含在主页面中，而不是API返回的HTML中

(function() {
    'use strict';
    
    console.log('Async download handler initializing...');
    
    // 使用MutationObserver来监听DOM变化
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                // 检查是否有新的异步下载按钮被添加
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // 检查是否包含异步下载按钮
                        var buttons = node.querySelectorAll ? node.querySelectorAll('.async-download-btn') : [];
                        if (buttons.length > 0) {
                            console.log('Found ' + buttons.length + ' new async download buttons');
                        }
                        
                        // 如果节点本身就是异步下载按钮
                        if (node.classList && node.classList.contains('async-download-btn')) {
                            console.log('Found new async download button');
                        }
                    }
                });
            }
        });
    });
    
    // 开始观察整个文档的变化
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // 全局点击事件处理
    document.addEventListener('click', function(e) {
        // 检查是否点击了异步下载按钮
        var button = e.target.closest('.async-download-btn');
        if (!button) return;
        
        console.log('Async download button clicked');
        e.preventDefault();
        e.stopPropagation();
        
        var downloadId = button.getAttribute('data-download-id');
        if (!downloadId) {
            console.error('No download ID found on button');
            return;
        }
        
        // 防止重复点击
        if (button.disabled) return;
        
        // 禁用按钮并显示加载状态
        button.disabled = true;
        var originalHtml = button.innerHTML;
        button.innerHTML = '<span class="download-icon">⏳</span>Downloading...';
        
        console.log('Fetching download URL for ID:', downloadId);
        
        // 首先获取下载参数
        fetch('/api/downloader.php?did=' + downloadId)
            .then(function(response) {
                console.log('Initial response received:', response);
                
                if (!response.ok) {
                    throw new Error('Failed to get download parameters: ' + response.status);
                }
                
                // 如果是直接重定向（非加密链接），直接打开
                if (response.redirected) {
                    console.log('Direct download URL:', response.url);
                    window.open(response.url, '_blank');
                    button.disabled = false;
                    button.innerHTML = originalHtml;
                    return null;
                }
                
                // 否则解析JSON响应（加密链接）
                return response.json();
            })
            .then(function(data) {
                if (!data) return; // 直接下载已处理
                
                console.log('Download parameters:', data);
                
                if (!data.success) {
                    throw new Error('Failed to decrypt download parameters');
                }
                
                // 使用解密后的参数直接请求CDN
                var downloadUrl = 'https://' + data.cdnUrl + '/download';
                var requestData = {
                    downloadType: data.downloadType,
                    quality: data.quality,
                    key: data.key
                };
                
                console.log('Requesting final download URL from:', downloadUrl);
                
                // 客户端直接请求CDN获取最终下载链接
                return fetch(downloadUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Origin': window.location.origin,
                        'User-Agent': navigator.userAgent
                    },
                    body: JSON.stringify(requestData)
                });
            })
            .then(function(response) {
                if (!response) return; // 直接下载已处理
                
                console.log('CDN response received:', response);
                
                if (!response.ok) {
                    throw new Error('CDN request failed: ' + response.status);
                }
                
                return response.json();
            })
            .then(function(result) {
                if (!result) return; // 直接下载已处理
                
                console.log('Final download result:', result);
                
                if (result.status && result.data && result.data.downloadUrl) {
                    console.log('Opening final download URL:', result.data.downloadUrl);
                    window.open(result.data.downloadUrl, '_blank');
                } else {
                    throw new Error('No download URL in response');
                }
                
                // 恢复按钮状态
                button.disabled = false;
                button.innerHTML = originalHtml;
            })
            .catch(function(error) {
                console.error('Download error:', error);
                alert('Download failed: ' + error.message);
                
                // 恢复按钮
                button.disabled = false;
                button.innerHTML = originalHtml;
            });
    }, true); // 使用捕获阶段
    
    console.log('Async download handler initialized');
})();