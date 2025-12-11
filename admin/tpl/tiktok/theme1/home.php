<?php require_once 'header.php'; ?>

<!-- SnapTik -->
<main>
    <section class="dl-box">
        <div class="container">
            <div class="section-contents">
                <h1 class="dl-box-title"><?php echo __('hero_title', 'TikTok Video Downloader'); ?></h1>
                <form class="downloadform" method="post" novalidate="true">
                    <div class="input-group tiktokpageaddress">
                        <input type="text" name="page" class="form-control addr" placeholder="<?php echo __('input_placeholder', 'Paste tiktok video link here'); ?>" value="">
                        <button class="btn btn_paste f_size_15 f_500 ld-ext-right" type="button">
                            <i class="fa fa-paste"></i>Paste                        </button>
                        <input class="ftype" name="ftype" type="hidden" value="all">
                    </div>
                    <button class="btn btn_submit f_size_15 f_500 ld-ext-right" type="submit">
                        <?php echo __('download_button', 'Download'); ?>                        <div class="ld ld-spin ld-ring"></div>
                    </button>
                </form>
                <div class="terms-string">
                    <?php echo __('terms_text', 'By using our service you accept our'); ?> <a rel="nofollow" href="<?php echo get_page_url('/terms'); ?>"><?php echo __('footer.terms', 'Terms of Service'); ?></a> <?php echo __('privacy_text', 'and'); ?> <a rel="nofollow" href="<?php echo get_page_url('/privacy'); ?>"><?php echo __('footer.privacy', 'Privacy Policy'); ?></a>.
                </div>
            </div>
        </div>
    </section>

    <section class="ads" style="display: none">
        <div class="container">
            <div class="ads_top mt-3 mb-2" style="display: none">
                <!-- Advertisement Placeholder -->
            </div>
        </div>
    </section>

    <section class="results-section">
        <div class="container">
            <div class="results"></div>
        </div>
    </section>
    <section class="downloader-descriptions">
        <div class="container">
            <h2><?php echo __('descriptions.title', 'Download TikTok videos without watermark for free'); ?></h2>
            <p><?php echo str_replace('{site_name}', '<strong>' . __('site_name', 'SnapTik') . '</strong>', __('descriptions.main_desc')); ?></p>
            <br />
            <div class="ads_mid mb-4" style="display: none">
                <!-- Advertisement Placeholder -->
            </div>
            <h3><?php echo __('descriptions.how_to_title', 'How to download TikTok videos without watermark ?'); ?></h3>
            <p class="mb-4"><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('descriptions.how_to_subtitle')); ?></p>
            <div class="mb-5">
                <h5><?php echo __('descriptions.step1_title', 'Step 1: Copy Link'); ?></h5>
                <p><?php echo __('descriptions.step1_desc'); ?></p>

                <div class="row helper-images" style="display: none">
                    <div class="col-md-6">
                        <img class="lazy" data-src="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIW2NgAAIAAAUAAR4f7BQAAAAASUVORK5CYII=" alt="Tap on the Share button">
                    </div>
                    <div class="col-md-6">
                        <img class="lazy" data-src="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIW2NgAAIAAAUAAR4f7BQAAAAASUVORK5CYII=" alt="Tap on the Copy Link">
                    </div>
                </div>

            </div>
            <div class="mb-5">
                <h5><?php echo __('descriptions.step2_title', 'Step 2: Paste the Link'); ?></h5>
                <p><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('descriptions.step2_desc')); ?></p>

                <div class="row helper-images" style="display: none">
                    <div class="col-md-6">
                        <img class="lazy" data-src="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIW2NgAAIAAAUAAR4f7BQAAAAASUVORK5CYII=" alt="Tap on the Paste button">
                    </div>
                    <div class="col-md-6">
                        <img class="lazy" data-src="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIW2NgAAIAAAUAAR4f7BQAAAAASUVORK5CYII=" alt="Tap on the Download button">
                    </div>
                </div>

            </div>
            <div class="mb-3">
                <h5><?php echo __('descriptions.step3_title', 'Step 3: Download'); ?></h5>
                <p><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('descriptions.step3_desc')); ?></p>

                <div class="row helper-images" style="display: none">
                    <div class="col-md-6">
                        <img class="lazy" data-src="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIW2NgAAIAAAUAAR4f7BQAAAAASUVORK5CYII=" alt="Tap on the Download button">
                    </div>
                </div>

            </div>

            <br />
            <blockquote>
                <p class="mb-0"><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('descriptions.note')); ?></p>
            </blockquote>
        </div>
    </section>
    <section class="downloader-features">
        <div class="container">
            <h3><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('features_section.title')); ?></h3>
            <ul>
                <li>
                    <div class="title"><?php echo __('features_section.watermark.title', 'Remove watermark'); ?></div>
                    <div class="text"><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('features_section.watermark.desc')); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.free.title', 'Completely free'); ?></div>
                    <div class="text"><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('features_section.free.desc')); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.compatibility.title', 'Compatibility'); ?></div>
                    <div class="text"><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('features_section.compatibility.desc')); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.easy.title', 'Easy To Use'); ?></div>
                    <div class="text"><?php echo __('features_section.easy.desc', 'We want to keep things simple for you; all you need is a TikTok video link.'); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.mp4.title', 'Download MP4'); ?></div>
                    <div class="text"><?php echo __('features_section.mp4.desc', 'Download TikTok videos in MP4 format, which is a popular video format and is supported by all devices.'); ?></div>
                </li>
            </ul>        </div>
    </section>
    <section class="downloader-faq">
        <div class="container">
            <h5><?php echo __('faq_section.title', 'Frequently asked questions'); ?></h5>
            <div id="accordion" class="faq_accordion" itemscope="" itemtype="https://schema.org/FAQPage">
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo __('faq_section.q1', 'How to download a TikTok video on android or iphone?'); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('faq_section.a1')); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo __('faq_section.q2', 'Where are TikTok videos saved after download?'); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo __('faq_section.a2', 'TikTok videos are saved in the browser\'s default downloads folder. In the browser settings, you can see or change the default path of downloaded files.'); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo __('faq_section.q3', 'How to download TikTok videos on my PC?'); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo __('faq_section.a3', '1. Open your web browser, navigate to TikTok\'s official website, and go to the desired video.<br />2. Copy the video page URL from your web browser address bar.<br />3. Paste the copied link into the address field at the top of this page, then click on the Download button.'); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('faq_section.q4', 'Is using {site_name} free?')); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('faq_section.a4', 'Yes, of course, {site_name} is completely free to use.')); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo str_replace('{site_name}', __('site_name', 'SnapTik'), __('faq_section.q5', 'Does the {site_name} keep a copy of downloaded videos?')); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo __('faq_section.a5', 'No, we don\'t keep a copy of downloaded videos.'); ?>                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>