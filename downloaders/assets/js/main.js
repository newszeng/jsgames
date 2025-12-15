document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementsByClassName('search-form')[0];
    const videoUrl = document.getElementById('url');
    const loading = document.getElementById('loading');
    const downloadResult = document.getElementById('downloadResult');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        downloadVideo();
    });
    videoUrl.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            //downloadVideo();
        }
    });
});

function downloadVideo() {
    const urlInput = document.getElementById('url');
    const url = urlInput.value.trim();
    const resultDiv = document.getElementById('downloadResult');
    const loadingDiv = document.getElementById('loading');

    if (!url) {
        alert('Please enter a video URL');
        return;
    }
    // Show loading
    loadingDiv.style.display = 'block';
    resultDiv.innerHTML = '';

    // Check if input is a URL (contains http) or search term
    const isUrl = url.includes('http');

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
            loadingDiv.style.display = 'none';
            resultDiv.innerHTML = htmlContent; // Directly insert the HTML
        })
        .catch(error => {
            loadingDiv.style.display = 'none';
            resultDiv.innerHTML = `
            <div class="alert alert-danger">
                <?php echo __('error.network', 'Network error. Please try again.'); ?>
            </div>
        `;
        });
}
window.selectVideo = function(url) {
    console.log("selectVideo called with URL:", url);
    const urlInput = document.getElementById('url');
    if (urlInput) {
        urlInput.value = url;
        //downloadVideo();
    }
};
// Simple autocomplete functionality
var suggestions = [];
var searchInput = document.getElementById('q');
var suggestList = document.getElementById('suggest-list');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        var query = this.value.trim();
        if (query.length > 2) {
            // Show suggestions if needed
        } else {
            // Hide suggestions
            if (suggestList) {
                suggestList.style.display = 'none';
            }
        }
    });
}
// Auto-trigger download on YouTube URL paste
document.addEventListener('DOMContentLoaded', function() {
    var searchBox = document.querySelector('.y2mate_query.keyword');
    if (searchBox) {
        searchBox.addEventListener('paste', function () {
            var self = this;
            setTimeout(function () {
                var inputValue = self.value;
                if (isYouTubeURL(inputValue)) {
                    document.querySelector('.convert-btn').click();
                }
            }, 100);
        });
    }
});
function isYouTubeURL(url) {
    var pattern = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|v\/)|youtu\.be\/)/;
    return pattern.test(url);
}
window.selectVideo = function(url) {
    console.log("selectVideo called with URL:", url);
    const urlInput = document.getElementById('url');
    if (urlInput) {
        urlInput.value = url;
        downloadVideo();
    }
};