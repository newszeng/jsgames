<?php include 'header.php'; ?>

<div class="container">
    <form class="search_form" method="POST" id="downloadForm" autocomplete="off">
        <div>
            <input class="y2mate_query keyword" type="text" name="q" id="videoUrl" placeholder="<?php echo __('home.placeholder', 'Search or paste link here...'); ?>" 
                   autocomplete="off" autofocus="" aria-label="Search on <?php echo __('site_name'); ?>">
            <button id="submit" type="submit" name="form_submit" class="convert-btn" aria-label="Search">
                <?php echo __('home.start_btn', 'Search'); ?>
            </button>
        </div>
        <div class="suggesstion-list suggesstion-box"></div>
    </form>

    <div id="tou">
        <?php echo __('home.terms_text', 'By pressing "Search" you confirm your consent to our'); ?> 
        <a href="<?php echo get_page_url('/terms'); ?>" target="_blank"><?php echo __('home.terms_link', 'Terms of Use'); ?></a>.
    </div>

    <div class="loading-container" style="display: none;" id="loading">
        <img src="/loading.gif" alt="Loading..." class="loading-gif">
        <p class="loading-text"><?php echo __('processing', 'Processing...'); ?></p>
    </div>

    <!-- Results Container -->
    <div id="downloadResult"></div>
    
    <div id="text">
        <h1><?php echo __('site_name'); ?></h1>

        <p><?php echo str_replace('{site_name}', __('site_name'), __('content.description_1', '{site_name} is a free MP3 search engine with a built-in downloader. Simply search for your favorite music on several sources and download the music as MP3 (audio) or MP4 (video) files for free. {site_name} will work on your desktop, tablet and mobile devices, so you do not need to install any additional apps. The usage of {site_name} is free and safe!')); ?></p>

        <p><?php echo str_replace('{site_name}', __('site_name'), __('content.description_2', 'Also Our {site_name} provides a search engine that allows you to search your Mp3 audio files and download it in different MP3 bit rates including 64kbps, 128kbps, 192kbps, 256kbps and 320kbps. We use the latest technology to provide our users with the best and fast experience. {site_name} is a reliable, user-friendly and completely free online MP3 downloader tool that makes it easy to convert and download music in MP3 and MP4 formats.')); ?></p>

        <h2><?php echo str_replace('{site_name}', __('site_name'), __('instruction.title', 'How to use {site_name}:')); ?></h2>
        
        <p><?php echo __('instruction.step_1', '1. Simply enter your search query above. As soon as you type in your search query, a list of suggestions will pop up. Feel free to choose a suggestion or ignore them. Then click on the "Search" button.'); ?></p>
        
        <p><?php echo str_replace('{site_name}', __('site_name'), __('instruction.step_2', '2. {site_name} will search for any matching results for your search query. As soon as the search is completed you will get a list of results. If you would like to search on more sources for your search query simply click on the "Enable" button at the end of the results list.')); ?></p>
        
        <p><?php echo __('instruction.step_3', '3. Now you are able to listen to the results or to download them by clicking on one of the download buttons. Kindly note: some results need to be converted to the chosen format before you are able to download them. This might take a short while.'); ?></p>
        
        <p><?php echo str_replace('{site_name}', __('site_name'), __('instruction.alternative', 'Alternatively you can also use {site_name} as a video downloader. Just enter the video URL above and click on the "Search" button. After that choose your preferred download format. The video will be converted, and after a short time you will be able to download the converted video.')); ?></p>
        
        <p><?php echo str_replace('{site_name}', __('site_name'), __('footer.terms_text', 'With the usage of {site_name} you are accepting our')); ?> 
        <a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('footer.terms', 'Terms of Use'); ?></a>. 
        <?php echo str_replace('{site_name}', __('site_name'), __('footer.thank_you', 'Thank you for using {site_name}.')); ?></p>
        
        <!-- Advantages Section -->
        <h2><?php echo str_replace('{site_name}', __('site_name'), __('advantages.title', '{site_name} Advantage')); ?></h2>
        <p><?php echo __('advantages.item_1', 'Convert and Download Absolutely free and Unlimited use As many as you want'); ?></p>
        <p><?php echo __('advantages.item_2', 'We use Latest Technology so you can'); ?></p>
        <p><?php echo __('advantages.item_3', 'No Need to register and login required'); ?></p>
        <p><?php echo __('advantages.item_4', 'We support All video and audio formats conversion'); ?></p>
        <p><?php echo __('advantages.item_5', 'You will not need to install third-party applications and software'); ?></p>
        
        <!-- Features Section -->
        <h3><?php echo __('features.unlimited.title', 'Free Unlimited conversion'); ?></h3>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('features.unlimited.description', 'Download music for free using {site_name} and users can download unlimited MP3 files. Enjoy the freedom to download as many songs as you want.')); ?></p>
        
        <h3><?php echo __('features.easy.title', 'Easy and User-Friendly Interface'); ?></h3>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('features.easy.description', '{site_name} features an attractive and easy-to-use interface that simplifies the process of downloading music. Simply search for your favorite songs or paste a URL to begin your download.')); ?></p>
        
        <h3><?php echo __('features.quality.title', 'High-Quality Downloads'); ?></h3>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('features.quality.description', 'Our {site_name} platform supports multiple high-quality downloads, ensuring that users receive the best audio quality. You can download MP3 files in various bitrates including 320kbps.')); ?></p>
        
        <h3><?php echo __('features.speed.title', 'Very Fast Download'); ?></h3>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('features.speed.description', '{site_name} is the fastest downloader that quickly converts and downloads music, so you don\'t have to wait long for your MP3 download and without sacrificing quality.')); ?></p>
        
        <h3><?php echo __('features.no_software.title', 'No Software Installation'); ?></h3>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('features.no_software.description', '{site_name} operates entirely online, allowing you to use the service directly in your web browser without the need to install any software. Enjoy the convenience of downloading music without the hassle of registration or log-ins.')); ?></p>
        
        <h3><?php echo __('features.compatible.title', 'Compatible with all device'); ?></h3>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('features.compatible.description', '{site_name} is a web-based MP3 downloader that works seamlessly on all devices, including smartphones, computers, and tablets. It also works seamlessly with all popular browsers such as Chrome, Firefox, Safari, Microsoft Edge, and Opera.')); ?></p>
        
        <!-- FAQ Section -->
        <h2 id="faq"><?php echo __('faq.title', 'FAQs'); ?></h2>
        
        <h4><?php echo str_replace('{site_name}', __('site_name'), __('faq.q1', 'What is {site_name}?')); ?></h4>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a1', '{site_name} is the leading MP3 search engine that allows you to quickly search and download music from various sources free of cost. Also, users can easily convert videos to MP3 files in the highest quality.')); ?></p>
        
        <h4><?php echo str_replace('{site_name}', __('site_name'), __('faq.q2', 'Is {site_name} Free to use?')); ?></h4>
        <p><?php echo __('faq.a2', 'Yes, It\'s a completely free MP3 downloader. You are not required to pay to download music files.'); ?></p>
        
        <h4><?php echo __('faq.q3', 'What is the maximum number of MP3 files that I can download?'); ?></h4>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a3', 'With {site_name}, you can download unlimited MP3 files. There are no restrictions on how many songs you can download.')); ?></p>
        
        <h4><?php echo str_replace('{site_name}', __('site_name'), __('faq.q4', '{site_name} supports which audio/video formats?')); ?></h4>
        <p><?php echo __('faq.a4', 'Our MP3 downloader offers different audio quality options like 64kbps, 128kbps, 192kbps, 256kbps, and 320kbps for MP3 format. We also support MP4 video downloads.'); ?></p>
        
        <h4><?php echo __('faq.q5', 'Is MP3 Downloader supported with all devices?'); ?></h4>
        <p><?php echo __('faq.a5', 'We support multiple devices such as Android, iOS, iPhone, Windows, macOS, and more. As well as You can open this tool in multiple browsers like Chrome, Safari, Microsoft Edge, Opera, Firefox, Vivaldi, Brave, and more!'); ?></p>
        
        <h4><?php echo str_replace('{site_name}', __('site_name'), __('faq.q6', 'Is it safe to use {site_name} for downloading MP3 files?')); ?></h4>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a6', 'It is safe and secure to download music files with {site_name}. If users download content, they should always take precautions and comply with copyright laws.')); ?></p>
        
        <h4><?php echo str_replace('{site_name}', __('site_name'), __('faq.q7', 'Can I Download MP3 files without installing applications using {site_name}?')); ?></h4>
        <p><?php echo str_replace('{site_name}', __('site_name'), __('faq.a7', 'Yes, {site_name} can be used to download MP3 files without installing apps. All you have to do is visit our official website and start using the tool in a browser.')); ?></p>



    </div>
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
        alert('<?php echo __('error.empty_url', 'Please enter a video URL or search term'); ?>');
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
            <div class="error-message">
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

<style>
/* Content text heading center alignment */
#text h1 {
    text-align: center;
}

/* Enhanced loading container styles */
.loading-container {
    text-align: center;
    padding: 40px 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    margin: 30px auto;
    max-width: 400px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.loading-gif {
    margin-bottom: 15px;
}

.loading-text {
    color: #bfe0ff;
    font-size: 16px;
    margin: 0;
    font-weight: 500;
}

/* Enhanced error message styling */
.error-message {
    background: rgba(255, 107, 107, 0.9);
    color: white;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    margin: 20px auto;
    max-width: 500px;
    box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
}

/* Mobile responsive enhancements */
@media (max-width: 768px) {
    .loading-container {
        padding: 30px 15px;
        margin: 20px;
    }
}
</style>

<?php include 'footer.php'; ?>