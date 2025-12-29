document.addEventListener('DOMContentLoaded', function () {
    // Language dropdown toggle functionality
    const languageButton = document.getElementById('languageButton');
    const languageDropdown = document.getElementById('languageDropdown');

    if (languageButton && languageDropdown) {
        languageButton.addEventListener('click', function (event) {
            event.stopPropagation();
            languageDropdown.classList.toggle('hidden');
            languageDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!languageDropdown.contains(event.target) && !languageButton.contains(event.target)) {
                languageDropdown.classList.add('hidden');
                languageDropdown.classList.remove('show');
            }
        });
    }

    // Parent page: listen for iframe height messages and auto-resize iframe
    const gameFrame = document.getElementById('gameFrame');
    if (gameFrame) {
        // Listen for height messages from iframe
        window.addEventListener('message', function(event) {
            if (!event.data) return;
            if (event.data.type !== 'COMBINATIONS_IFRAME_HEIGHT') return;
            
            const height = event.data.height;
            if (height && height > 0) {
                gameFrame.style.height = height + 'px';
            }
        });

        // Send initialization message to iframe when it loads
        gameFrame.addEventListener('load', function() {
            try {
                gameFrame.contentWindow.postMessage(
                    { type: 'COMBINATIONS_IFRAME_PARENT_INIT' },
                    '*'
                );
            } catch (e) {
                console.error('Failed to send iframe init message:', e);
            }
        });

        // Also send init message after a delay to ensure iframe is ready
        setTimeout(function() {
            try {
                gameFrame.contentWindow.postMessage(
                    { type: 'COMBINATIONS_IFRAME_PARENT_INIT' },
                    '*'
                );
            } catch (e) {
                console.error('Failed to send delayed iframe init message:', e);
            }
        }, 1000);
    }
});
