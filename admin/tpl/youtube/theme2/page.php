<?php 
// Tag page template
$page_slug = $GLOBALS['template_data']['slug'] ?? '';
$lang = $GLOBALS['site_lang'];
$page_file = "pages/{$GLOBALS['site_domain']}/{$page_slug}/{$lang}.json";

$page_data = [];
if (file_exists($page_file)) {
    $page_data = json_decode(file_get_contents($page_file), true) ?: [];
}

// Set page title and meta description from JSON structure
$GLOBALS['template_data']['title'] = $page_data['page']['title'] ?? $page_data['title'] ?? __('site_name');
$GLOBALS['template_data']['meta_description'] = $page_data['page']['meta_description'] ?? $page_data['meta_description'] ?? '';

include 'header.php'; 
?>

<div class="container">
    <section class="y2mate-download">
        <div class="y2mate-search-form d-flex">
            <div class="form-wrap">
                <h1 class="y2mate_title"><?php echo $page_data['page']['h1'] ?? $GLOBALS['template_data']['h1'] ?? __('page.h1'); ?></h1>

                <form class="search_form" method="POST" id="downloadForm">
                    <input class="y2mate_query keyword" type="text" name="q" id="videoUrl" placeholder="<?php echo $page_data['page']['placeholder'] ?? __('page.placeholder', 'Search or paste link here...'); ?>"
                           autocomplete="off" autofocus="">
                    <button id="submit" type="submit" name="form_submit" class="convert-btn" aria-label="Search">
                        <div class="converter-btn"><?php echo $page_data['page']['start_btn'] ?? __('page.start_btn', 'Start'); ?></div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px"
                height="14px" fill="#fff" id="Layer_1" style="enable-background:new 0 0 16 16;" version="1.1"
                viewBox="0 0 16 16" xml:space="preserve">
                <path
                  d="M15.375,7L10,2.54C9.695,2.287,9.461,2,9,2C8.375,2,8,2.516,8,3v3H1C0.45,6,0,6.45,0,7v2c0,0.55,0.45,1,1,1h7v3  c0,0.484,0.375,1,1,1c0.461,0,0.695-0.287,1-0.54L15.375,9C15.758,8.688,16,8.445,16,8S15.758,7.313,15.375,7z">
                </path>
              </svg>
                    </button>

                    <div class="suggesstion-list suggesstion-box"></div>
                    <p class="y2mate-terms"><?php echo $page_data['page']['converter_desc'] ?? __('page.converter_desc', 'By using our service you are accepting our'); ?> <a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('home.terms_link', 'Terms of Use'); ?></a>.</p>
                </form>
                <div class="spinner" style="display: none;" id="loading">
                    <img id="loading_img" src="/loading.gif">
                </div>
                
                <!-- Results Container -->
                <div id="downloadResult"></div>
            </div>
        </div>
    </section>
    <section class="y2mate-content d-flex">
        <div class="col-sm-12">
            <h2><?php echo $page_data['content']['title'] ?? __('content.title', 'Download Video and Audio from YouTube'); ?></h2>
            <p>
                <?php echo str_replace('{site_name}', $page_data['site_name'] ?? __('site_name'), $page_data['content']['description_1'] ?? __('content.description_1', 'Y2mate is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube, Facebook, TikTok, Instagram, Dailymotion, Youku, etc in High quality easily and safely.')); ?></p>
            <p>
                <?php echo str_replace('{site_name}', $page_data['site_name'] ?? __('site_name'), $page_data['content']['description_2'] ?? __('content.description_2', 'Also Our {site_name} provides a search engine that allows you to search your Mp3 audio files and download it in different MP3 bit rates including 64kbps, 128kbps, 192kbps, 256kbps and 320kbps.')); ?>
            </p>
        </div>
    </section>

    <section class="y2mate-instruction">
        <div class="y2mate-in-ad">
            <h5><strong><?php echo str_replace('{site_name}', $page_data['site_name'] ?? __('site_name'), $page_data['instruction']['title'] ?? __('instruction.title', 'How to Download YouTube Video using {site_name}')); ?></strong></h5>
            <ol>
                <li><?php echo $page_data['instruction']['step_1'] ?? __('instruction.step_1', 'Enter a keyword in the search box or paste the video link that you want to convert and download'); ?></li>
                <li><?php echo $page_data['instruction']['step_2'] ?? __('instruction.step_2', 'Press the Start button and converting process start'); ?></li>
                <li><?php echo $page_data['instruction']['step_3'] ?? __('instruction.step_3', 'Choose the Audio and Video format would you like to download then click on the Download button.'); ?></li>
            </ol>
        </div>
        <div class="y2mate-in-ad">
            <h5><strong><?php echo str_replace('{site_name}', $page_data['site_name'] ?? __('site_name'), $page_data['advantages']['title'] ?? __('advantages.title', '{site_name} Advantage')); ?></strong></h5>
            <ul>
                <li><?php echo $page_data['advantages']['item_1'] ?? __('advantages.item_1', 'Convert and Download Absolutely free and Unlimited use As many as you want'); ?></li>
                <li><?php echo $page_data['advantages']['item_2'] ?? __('advantages.item_2', 'We use Latest Technology so you can'); ?></li>
                <li><?php echo $page_data['advantages']['item_3'] ?? __('advantages.item_3', 'No Need to register and login required'); ?></li>
                <li><?php echo $page_data['advantages']['item_4'] ?? __('advantages.item_4', 'We support All video and audio formats conversion'); ?></li>
                <li><?php echo $page_data['advantages']['item_5'] ?? __('advantages.item_5', 'You will not need to install third-party applications and software'); ?></li>
            </ul>
        </div>
    </section>

    <section class="y2mate-features-wrap first">
        <div class="col-sm-4 d-flex">
            <div class="y2mate-features">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-infinity"
                     viewBox="0 0 16 16">
                    <path
                            d="M5.68 5.792 7.345 7.75 5.681 9.708a2.75 2.75 0 1 1 0-3.916ZM8 6.978 6.416 5.113l-.014-.015a3.75 3.75 0 1 0 0 5.304l.014-.015L8 8.522l1.584 1.865.014.015a3.75 3.75 0 1 0 0-5.304l-.014.015zm.656.772 1.663-1.958a2.75 2.75 0 1 1 0 3.916z">
                    </path>
                </svg>
                <h3><?php echo $page_data['features']['unlimited']['title'] ?? __('features.unlimited.title', 'Free Unlimited conversion'); ?></h3>
                <p><?php echo str_replace('{site_name}', $page_data['site_name'] ?? __('site_name'), $page_data['features']['unlimited']['description'] ?? __('features.unlimited.description', 'Download YouTube videos for free using {site_name} and users can download unlimited YouTube videos.')); ?></p>
            </div>
        </div>

        <div class="col-sm-4 d-flex">
            <div class="y2mate-features">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                     class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                    <path
                            d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z">
                    </path>
                </svg>
                <h3><?php echo $page_data['features']['easy']['title'] ?? __('features.easy.title', 'Easy and User-Friendly Interface'); ?></h3>
                <p><?php echo str_replace('{site_name}', $page_data['site_name'] ?? __('site_name'), $page_data['features']['easy']['description'] ?? __('features.easy.description', '{site_name} features an attractive and easy-to-use interface that simplifies the process of downloading videos.')); ?></p>
            </div>
        </div>

        <div class="col-sm-4 d-flex">
            <div class="y2mate-features">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-badge-8k"
                     viewBox="0 0 16 16">
                    <path
                            d="M4.837 11.114c1.406 0 2.333-.725 2.333-1.766 0-.945-.712-1.38-1.256-1.49v-.053c.496-.15 1.02-.55 1.02-1.331 0-.914-.831-1.587-2.084-1.587-1.257 0-2.087.673-2.087 1.587 0 .773.51 1.177 1.02 1.331v.053c-.546.11-1.258.54-1.258 1.494 0 1.042.906 1.762 2.312 1.762m.013-3.643c-.545 0-.95-.356-.95-.866s.405-.852.95-.852.945.343.945.852c0 .51-.4.866-.945.866m0 2.786c-.65 0-1.142-.395-1.142-.984S4.2 8.28 4.85 8.28c.646 0 1.143.404 1.143.993s-.497.984-1.143.984M13.408 5h-1.306L9.835 7.685h-.057V5H8.59v5.998h1.187V9.075l.615-.699 1.679 2.623H13.5l-2.232-3.414z">
                    </path>
                    <path
                            d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z">
                    </path>
                </svg>
                <h3><?php echo $page_data['features']['quality']['title'] ?? __('features.quality.title', 'High-Quality Downloads'); ?></h3>
                <p><?php echo str_replace('{site_name}', $page_data['site_name'] ?? __('site_name'), $page_data['features']['quality']['description'] ?? __('features.quality.description', 'Our {site_name} platform supports multiple high-quality downloads, ensuring that users receive the same quality as YouTube.')); ?></p>
            </div>
        </div>
    </section>

    <!-- Custom Content Section -->
    <?php if (!empty($page_data['custom_content']['content'])): ?>
    <section class="y2mate-content d-flex">
        <div class="col-sm-12">
            <div class="content-area">
                <h2><?php echo $page_data['custom_content']['title'] ?? 'Additional Information'; ?></h2>
                <?php echo $page_data['custom_content']['content']; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('downloadForm');
    const videoUrl = document.getElementById('videoUrl');
    const loading = document.getElementById('loading');
    const downloadResult = document.getElementById('downloadResult');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        downloadVideo();
    });
    
    videoUrl.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            downloadVideo();
        }
    });
});

function downloadVideo() {
    const urlInput = document.getElementById('videoUrl');
    const url = urlInput.value.trim();
    const resultDiv = document.getElementById('downloadResult');
    const loadingDiv = document.getElementById('loading');
    
    if (!url) {
        alert('<?php echo __('error.empty_url', 'Please enter a video URL'); ?>');
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

<?php include 'footer.php'; ?>