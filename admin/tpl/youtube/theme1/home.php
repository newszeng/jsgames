<?php include 'header.php'; ?>

<div class="container">
    <section class="y2mate-download">
        <div class="y2mate-search-form d-flex">
            <div class="form-wrap">
                <h1 class="y2mate_title"><?php echo __('home.h1', 'Youtube Downloader'); ?></h1>
                <form class="search_form" method="POST" id="downloadForm">
                    <input class="y2mate_query keyword" type="text" name="q" id="videoUrl" placeholder="<?php echo __('home.placeholder', 'Search or paste link here...'); ?>"
                           autocomplete="off" autofocus="">
                    <button id="submit" type="submit" name="form_submit" class="convert-btn" aria-label="Search">
                        <div class="converter-btn"><?php echo __('home.start_btn', 'Start'); ?></div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="14px"
                height="14px" fill="#fff" id="Layer_1" style="enable-background:new 0 0 16 16;" version="1.1"
                viewBox="0 0 16 16" xml:space="preserve">
                <path
                  d="M15.375,7L10,2.54C9.695,2.287,9.461,2,9,2C8.375,2,8,2.516,8,3v3H1C0.45,6,0,6.45,0,7v2c0,0.55,0.45,1,1,1h7v3  c0,0.484,0.375,1,1,1c0.461,0,0.695-0.287,1-0.54L15.375,9C15.758,8.688,16,8.445,16,8S15.758,7.313,15.375,7z">
                </path>
              </svg>
                    </button>

                    <div class="suggesstion-list suggesstion-box"></div>
                    <p class="y2mate-terms"><?php echo __('home.terms_text', 'By using our service you are accepting our'); ?> <a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('home.terms_link', 'Terms of Use'); ?></a>.</p>
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
            <h2><?php echo __('content.title', 'Download Video and Audio from YouTube'); ?></h2>
            <p> <?php echo str_replace('{site_name}', __('site_name'), __('content.description_1', 'is a Popular free YouTube video Downloader that allows users to easily convert and download videos from YouTube, Facebook, TikTok, Instagram, Dailymotion, Youku, etc in High quality easily and safely. {site_name} offers various video and audio formats such as MP4, MP3, M4V FLV, AVI, 3GP, WEBM, WMV, etc. Also you can freely and easily save videos from YouTube videos in 360p, 720p, 1080p, and even 4K quality without installing software or applications. No registration required. {site_name} works seamlessly on all browsers and devices such your computer, mobile, Tablet, and other Device. It\'s a simple and Easy YouTube Downloader.')); ?></p>
            <p><?php echo str_replace('{site_name}', __('site_name'), __('content.description_2', 'Also Our {site_name} provides a search engine that allows you to search your Mp3 audio files and download it in different MP3 bit rates including 64kbps, 128kbps, 192kbps, 256kbps and 320kbps. We use the latest technology to provide our users with the best and fast experience. {site_name} is a reliable, user-friendly and completely free online YouTube Downloader tool that makes it easy to convert and download YouTube videos in MP3 and MP4 formats.')); ?></p>
        </div>
    </section>

    <section class="y2mate-instruction">
        <div class="y2mate-in-ad">
            <h5><strong><?php echo str_replace('{site_name}', __('site_name'), __('instruction.title', 'How to Download YouTube Video using {site_name}')); ?></strong></h5>
            <ol>
                <li><?php echo __('instruction.step_1', 'Enter a keyword in the search box or paste the video link that you want to convert and download'); ?></li>
                <li><?php echo __('instruction.step_2', 'Press the "Start" button and converting process start'); ?></li>
                <li><?php echo __('instruction.step_3', 'Choose the Audio and Video format would you like to download then click on the Download button.'); ?></li>
            </ol>
        </div>
        <div class="y2mate-in-ad">
            <h5><strong><?php echo str_replace('{site_name}', __('site_name'), __('advantages.title', '{site_name} Advantage')); ?></strong></h5>
            <ul>
                <li><?php echo __('advantages.item_1', 'Convert and Download Absolutely free and Unlimited use As many as you want'); ?></li>
                <li><?php echo __('advantages.item_2', 'We use Latest Technology so you can'); ?></li>
                <li><?php echo __('advantages.item_3', 'No Need to register and login required'); ?></li>
                <li><?php echo __('advantages.item_4', 'We support All video and audio formats conversion'); ?></li>
                <li><?php echo __('advantages.item_5', 'You will not need to install third-party applications and software'); ?></li>
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
                <h3><?php echo __('features.unlimited.title', 'Free Unlimited conversion'); ?></h3>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('features.unlimited.description', 'Download YouTube videos for free using {site_name} and users can download unlimited YouTube videos. Enjoy the freedom to download as many videos as you want.')); ?></p>
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
                <h3><?php echo __('features.easy.title', 'Easy and User-Friendly Interface'); ?></h3>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('features.easy.description', '{site_name} features an attractive and easy-to-use interface that simplifies the process of downloading videos from YouTube. Simply copy and paste the YouTube video URL into the designated field to begin your download.')); ?></p>
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
                <h3><?php echo __('features.quality.title', 'High-Quality Downloads'); ?></h3>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('features.quality.description', 'Our {site_name} platform supports multiple high-quality downloads, ensuring that users receive the same quality as YouTube. You can download YouTube videos in 720p, 1080p, and even up to 8K resolution.')); ?></p>
            </div>
        </div>
    </section>
    <section class="y2mate-features-wrap second">
        <div class="col-sm-4 d-flex">
            <div class="y2mate-features">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-speedometer2"
                     viewBox="0 0 16 16">
                    <path
                            d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z">
                    </path>
                    <path fill-rule="evenodd"
                          d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3">
                    </path>
                </svg>
                <h3><?php echo __('features.speed.title', 'Very Fast Download'); ?></h3>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('features.speed.description', '{site_name} is the fastest downloader that quickly converts and downloads videos, so you don\'t have to wait long for your video download and without sacrificing quality.')); ?></p>
            </div>
        </div>
        <div class="col-sm-4 d-flex">
            <div class="y2mate-features">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-ban"
                     viewBox="0 0 16 16">
                    <path
                            d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0">
                    </path>
                </svg>
                <h3><?php echo __('features.no_software.title', 'No Software Installation'); ?></h3>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('features.no_software.description', '{site_name} operates entirely online, allowing you to use the service directly in your web browser without the need to install any software. Enjoy the convenience of downloading videos without the hassle of registration or log-ins.')); ?></p>
            </div>
        </div>
        <div class="col-sm-4 d-flex">
            <div class="y2mate-features">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-aspect-ratio"
                     viewBox="0 0 16 16">
                    <path
                            d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z">
                    </path>
                    <path
                            d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0z">
                    </path>
                </svg>
                <h3><?php echo __('features.compatible.title', 'Compatible with all device'); ?></h3>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('features.compatible.description', '{site_name} is a web-based YouTube downloader that works seamlessly on all devices, including smartphones, computers, and tablets. It also works seamlessly with all popular browsers such as Chrome, Firefox, Safari, Microsoft Edge, and Opera.')); ?></p>
            </div>
        </div>
    </section>
    <section class="yt-content">
        <h3 class="d-none"><?php echo __('faq.title', 'FAQs'); ?></h3>
        <div class="download-uses">
            <p></p>
            <div class="guide-data">
                <h4><b><?php echo str_replace('{site_name}', __('site_name'), __('faq.q1', 'What is {site_name}?')); ?></b></h4>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a1', '{site_name} is the leading YouTube video downloader that allows you to quickly download audio and video from YouTube free of cost. Also, users can easily convert YouTube to MP4, and MP3 files in the highest quality. You can save YouTube videos in 1080p, 2K, 4K, and up to 8K quality.')); ?></p>
                <h4><b><?php echo str_replace('{site_name}', __('site_name'), __('faq.q2', 'Is {site_name} Free to use?')); ?></b></h4>
                <p><?php echo __('faq.a2', 'Yes, It\'s a completely free YouTube downloader. You are not required to pay to download videos and audio from YouTube.'); ?></p>
                <h4><b><?php echo __('faq.q3', 'What is the maximum number of videos and audio files that I can download?'); ?></b></h4>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a3', 'With {site_name}, you can download unlimited videos and audio files. There are no restrictions on how many videos or audio tracks users can download.')); ?></p>
                <h4><b><?php echo str_replace('{site_name}', __('site_name'), __('faq.q4', '{site_name} supports which video/audio formats?')); ?></b></h4>
                <p><?php echo __('faq.a4', 'Our YouTube Video Downloader offers a different type of video quality such as 360p, 720p, 1080p, 2K, and up to 4k resolution. and audio quality like 64kbps, 128kbps, 192kbps, 256kbps, and 320kbps.'); ?></p>
                <h4><b><?php echo __('faq.q5', 'Is YouTube Downloader supported with all devices?'); ?></b></h4>
                <p><?php echo __('faq.a5', 'We support multiple devices such as Android, iOS, iPhone, Windows, macOS, and more. As well as You can open this tool in multiple browsers like Chrome, Safari, Microsoft Edge, Opera, Firefox, Vivaldi, Brave, and more!'); ?></p>
                <h4><b><?php echo str_replace('{site_name}', __('site_name'), __('faq.q6', 'Is it safe to use {site_name} for downloading YouTube Videos?')); ?></b></h4>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a6', 'It is safe and secure to download videos and audio files with {site_name}. If users download content, they should always take precautions and comply with copyright laws.')); ?></p>
                <h4><b><?php echo str_replace('{site_name}', __('site_name'), __('faq.q7', 'Can I Download YouTube Videos without installing applications using {site_name}?')); ?></b></h4>
                <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a7', 'Yes, {site_name} can be used to download YouTube videos without installing apps. All you have to do is visit our official website and start using the tool in a browser.')); ?></p>
            </div>
        </div>
    </section>
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
            //downloadVideo();
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
        //downloadVideo();
    }
};
</script>

<?php include 'footer.php'; ?>