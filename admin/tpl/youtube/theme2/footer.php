<div id="footer">
    <a href="<?php echo get_page_url('/contact'); ?>"><?php echo __('footer.contact', 'Contact'); ?></a>
    <a href="<?php echo get_page_url('/dmca'); ?>"><?php echo __('footer.dmca', 'DMCA'); ?></a>
    <a href="<?php echo get_page_url('/privacy'); ?>"><?php echo __('footer.privacy', 'Privacy Policy'); ?></a>
    <a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('footer.terms', 'Terms of Service'); ?></a>
    <?php
    // 加载页脚外链
    $backlinks_file = __DIR__ . "/../../backlinks/{$GLOBALS['site_domain']}/backlinks.json";
    if (file_exists($backlinks_file)) {
        $backlinks = json_decode(file_get_contents($backlinks_file), true) ?: [];
        foreach ($backlinks as $link) {
            if (($link['position'] ?? '') == 'footer' && ($link['active'] ?? false)) {
                $target = $link['target'] ?? '_blank';
                $rel = $link['rel'] ?? 'nofollow';
                echo '<a href="' . htmlspecialchars($link['url']) . '" target="' . $target . '" rel="' . $rel . '">' . htmlspecialchars($link['title']) . '</a>';
            }
        }
    }
    ?>
</div>

<style>
#footer {
    background: transparent;
    text-align: center;
    padding: 20px;
    margin-top: 40px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 14px;
}

#footer a {
    color: #bfe0ff;
    text-decoration: none;
    margin: 0 15px;
    display: inline-block;
    transition: color 0.3s ease;
    font-weight: 500;
}

#footer a:hover {
    color: #ffffff;
    text-decoration: underline;
}

@media (max-width: 768px) {
    #footer {
        padding: 15px 10px;
    }
    
    #footer a {
        margin: 5px 10px;
        display: inline-block;
        font-size: 13px;
    }
}
</style>

<script>
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

<!-- Analytics -->
<script src="/analytics.js" defer></script>

</body>
</html>