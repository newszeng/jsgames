<footer class="footer">
    <p>@ 2016 - <?php echo date('Y'); ?> <?php echo str_replace('{site_name}', __('site_name'), __('footer.copyright_text', '{site_name}')); ?></p>
    <ul class="footer_nav">
        <li class="fnav-menu"><a href="<?php echo get_page_url('/contact'); ?>"><?php echo __('footer.contact', 'Contact'); ?></a></li>
        <li class="fnav-menu"><a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('footer.terms', 'Terms of Service'); ?></a></li>
        <li class="fnav-menu"><a href="<?php echo get_page_url('/privacy'); ?>"><?php echo __('footer.privacy', 'Privacy Policy'); ?></a></li>
        <li class="fnav-menu"><a href="<?php echo get_page_url('/dmca'); ?>"><?php echo __('footer.dmca', 'DMCA'); ?></a></li>
        <?php
        // 加载页脚外链
        $backlinks_file = __DIR__ . "/../../backlinks/{$GLOBALS['site_domain']}/backlinks.json";
        if (file_exists($backlinks_file)) {
            $backlinks = json_decode(file_get_contents($backlinks_file), true) ?: [];
            foreach ($backlinks as $link) {
                if (($link['position'] ?? '') == 'footer' && ($link['active'] ?? false)) {
                    $target = $link['target'] ?? '_blank';
                    $rel = $link['rel'] ?? 'nofollow';
                    echo '<li class="fnav-menu"><a href="' . htmlspecialchars($link['url']) . '" target="' . $target . '" rel="' . $rel . '">' . htmlspecialchars($link['title']) . '</a></li>';
                }
            }
        }
        ?>
    </ul>
</footer>
<div>

    <div class="extension js-extension is-rolledUp">
        <header class="extension-header">
            <div class="extension-headerImgContainer">
                <svg class="extension-headerImg" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" width="55" height="50" viewBox="0 0 55 59">
                    <title>Extension</title>
                    <image width="77" height="70"
                           xlink:href="data:image/png;base64,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"
                           transform="translate(-9 -6)" fill="none" fill-rule="evenodd"></image>
                </svg>
            </div>
            <div class="extension-headerText"><?php echo __('extension.download_text', 'DOWNLOAD Chrome Extension'); ?></div>
        </header>
    </div>

</div>
<script type="text/javascript">
  // Select the search boxes using querySelectorAll
  var searchBoxes = document.querySelectorAll('.y2mate_query.keyword, .input-control.keyword');

  searchBoxes.forEach(function (searchBox) {
    // Add event listener for the paste event
    // searchBox.addEventListener('paste', function () {
    //   // Show the spinner by setting display to block
    //   document.querySelector('.spinner').style.display = 'block';
    //
    //   // Use setTimeout to delay the execution
    //   setTimeout(function () {
    //     var inputValue = searchBox.value;
    //     if (isYouTubeURL(inputValue)) {
    //       // Trigger click on the convert button and start button
    //       document.querySelectorAll('.convert-btn, .start-btn').forEach(function (button) {
    //         button.click();
    //       });
    //     }
    //   }, 100);
    // });
  });

  function isYouTubeURL(url) {
    var pattern = /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/|v\/)|youtu\.be\/)/;
    return pattern.test(url);
  }

  // Navigation toggle
  document.addEventListener('DOMContentLoaded', function() {
    const toggler = document.querySelector('.navbar-toggler');
    const menu = document.querySelector('.header-menu');
    
    if (toggler && menu) {
      toggler.addEventListener('click', function() {
        menu.classList.toggle('collapse');
      });
    }
    
    // Language dropdown
    const languageLink = document.querySelector('.language > a');
    const dropdown = document.querySelector('.dropdown-menu');
    
    if (languageLink && dropdown) {
      languageLink.addEventListener('click', function(e) {
        e.preventDefault();
        dropdown.classList.toggle('open');
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(e) {
        if (!e.target.closest('.language')) {
          dropdown.classList.remove('open');
        }
      });
    }
  });

  // Search suggestions (if needed)
  var k_qs = [];
  var k_data_vid = '';
  var k_data_vtitle = '';
  var k__id = '';
  var k_busy = false;

  function changeSel(tthis) {
    var resultItems = document.querySelectorAll('.result_box li');
    
    resultItems.forEach(function (item) {
      item.classList.remove('selected');
    });

    tthis.classList.add('selected');

    var selectedElement = document.querySelector('.result_box li.selected');
    var new_query = selectedElement.textContent;

    var keywordInput = document.querySelector('.keyword');
    keywordInput.value = new_query;
  }

  function handleResponse(data) {
    var suggestionBox = document.querySelector('.suggesstion-box');
    suggestionBox.innerHTML = '';
    suggestionBox.style.display = 'block';

    var obj = data[1];
    var searchTxt = "";
    if (obj[0]) {
      searchTxt = "<ul class='result_box'>";
    }
    obj.forEach(function (value) {
      searchTxt += "<li class='search_result' onmouseover='changeSel(this)'>" + value[0] + "</li>";
    });
    if (obj[0]) {
      searchTxt += "</ul>";
    }
    suggestionBox.innerHTML = searchTxt;
  }

  // Hide suggestion box when clicking outside of it
  document.addEventListener("mouseup", function (e) {
    if (!e.target.closest(".suggesstion-box")) {
      document.querySelector(".suggesstion-box").style.display = "none";
    }
  });

  // Handle clicks on list items within the result_box
  document.addEventListener("click", function (e) {
    if (e.target.matches('ul.result_box li')) {
      var valattr = e.target.textContent;
      document.querySelector('.keyword').value = valattr;
      document.querySelector(".suggesstion-box").style.display = "none";
      document.querySelector('.converter-btn').click();
      document.querySelector('.convert-btn').click();
    }
  });

  // 搜索结果点击处理函数
  window.selectVideo = function(url) {
    console.log("selectVideo called with URL:", url);
    
    // 将URL填入输入框
    const urlInput = document.getElementById('videoUrl');
    if (urlInput) {
      urlInput.value = url;
      downloadVideo();
    }
  };

</script>
<script type="application/ld+json">
{"@context":"https://schema.org",
"@type":"WebPage",
"name":"<?php echo __('site_name'); ?>",
"description":"<?php echo str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a free YouTube Downloader web application that allows you to download audio and video from YouTube effortlessly, in HD, UHD, 1080p, 2K, and 4k quality, and with a fast download speed')); ?>",
"alternateName":"<?php echo __('nav.youtube_downloader', 'YouTube Downloader'); ?>",
"url":"https://<?php echo $GLOBALS['site_domain']; ?>/"}
</script>

<script>
// Language dropdown handler
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing language dropdown...');
    
    // Handle language dropdown toggle
    var languageLink = document.querySelector('.navbar.language > a');
    console.log('Language link found:', languageLink);
    
    if (languageLink) {
        languageLink.addEventListener('click', function(e) {
            console.log('Language link clicked');
            e.preventDefault();
            e.stopPropagation();
            
            var dropdownMenu = this.parentElement.querySelector('.dropdown-menu');
            console.log('Dropdown menu found:', dropdownMenu);
            
            if (dropdownMenu) {
                // Use setTimeout to ensure the class is added after any other handlers
                setTimeout(function() {
                    dropdownMenu.classList.add('open');
                    console.log('Added open class');
                }, 0);
            }
            
            return false;
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        // Don't close immediately if clicking the language link
        if (e.target.closest('.navbar.language > a')) {
            return;
        }
        
        if (!e.target.closest('.navbar.language')) {
            var dropdownMenus = document.querySelectorAll('.dropdown-menu');
            dropdownMenus.forEach(function(menu) {
                menu.classList.remove('open');
            });
        }
    });
    
    // Handle mobile menu toggle
    var navbarToggler = document.querySelector('.navbar-toggler');
    var headerMenu = document.querySelector('.header-menu');
    if (navbarToggler && headerMenu) {
        navbarToggler.addEventListener('click', function() {
            headerMenu.classList.toggle('collapse');
        });
    }
});
</script>

<script type="application/ld+json">
{"@context":"https://schema.org/",
"@graph":[{"@type":"website",
"@id":"https://<?php echo $GLOBALS['site_domain']; ?>/",
"name":"<?php echo __('site_name'); ?>",
"url":"https://<?php echo $GLOBALS['site_domain']; ?>/",
"description":"<?php echo str_replace('{site_name}', __('site_name'), __('site_description', '{site_name} is a free YouTube Downloader web application that allows you to download audio and video from YouTube effortlessly, in HD, UHD, 1080p, 2K, and 4k quality, and with a fast download speed')); ?>"}]
}
</script>
<!-- Analytics -->
<script src="/analytics.js" defer></script>

</body>
</html>