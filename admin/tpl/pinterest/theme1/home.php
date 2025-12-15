<?php require_once 'header.php'; ?>

<!-- SnapTik -->
<main>
    <section class="dl-box">
        <div class="container">
            <div class="section-contents">
                <h1 class="dl-box-title"><?php echo __('hero_title', 'Pinterest Video Downloader'); ?></h1>
                <form class="downloadform" method="post" novalidate="true">
                    <div class="input-group tiktokpageaddress">
                        <input type="text" name="page" class="form-control addr" placeholder="<?php echo __('input_placeholder', 'Paste Pinterest video or Pin link here'); ?>" value="">
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
            <h2><?php echo __('descriptions.title', 'Download Pinterest videos online for free'); ?></h2>
            <p><?php echo str_replace('{site_name}', '<strong>' . __('site_name', 'Pinterest Downloader') . '</strong>', __('descriptions.main_desc')); ?></p>
            <br />
            <div class="ads_mid mb-4" style="display: none">
                <!-- Advertisement Placeholder -->
            </div>
            <h3><?php echo __('descriptions.how_to_title', 'How to download Pinterest videos?'); ?></h3>
            <p class="mb-4"><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('descriptions.how_to_subtitle')); ?></p>
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
                <p><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('descriptions.step2_desc')); ?></p>

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
                <p><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('descriptions.step3_desc')); ?></p>

                <div class="row helper-images" style="display: none">
                    <div class="col-md-6">
                        <img class="lazy" data-src="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIW2NgAAIAAAUAAR4f7BQAAAAASUVORK5CYII=" alt="Tap on the Download button">
                    </div>
                </div>

            </div>

            <br />
            <blockquote>
                <p class="mb-0"><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('descriptions.note')); ?></p>
            </blockquote>
        </div>
    </section>
    <section class="downloader-features">
        <div class="container">
            <h3><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('features_section.title')); ?></h3>
            <ul>
                <li>
                    <div class="title"><?php echo __('features_section.hd_quality.title', 'HD Quality Downloads'); ?></div>
                    <div class="text"><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('features_section.hd_quality.desc')); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.free.title', '100% Free'); ?></div>
                    <div class="text"><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('features_section.free.desc')); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.all_content.title', 'All Pinterest Content'); ?></div>
                    <div class="text"><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('features_section.all_content.desc')); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.fast_download.title', 'Lightning Fast'); ?></div>
                    <div class="text"><?php echo __('features_section.fast_download.desc', 'Our servers ensure the fastest download speeds for Pinterest videos and images.'); ?></div>
                </li>
                <li>
                    <div class="title"><?php echo __('features_section.no_login.title', 'No Login Required'); ?></div>
                    <div class="text"><?php echo __('features_section.no_login.desc', 'Download Pinterest videos without logging in or providing personal information.'); ?></div>
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
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo __('faq_section.q1', 'Can I download videos from private Pinterest boards?'); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('faq_section.a1')); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo __('faq_section.q2', 'What video formats are supported?'); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo __('faq_section.a2', 'We support MP4 video format which works on all devices. You can also download images in JPEG and PNG formats.'); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo __('faq_section.q3', 'Is there a limit on downloads?'); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo __('faq_section.a3', 'No, there are no limits. You can download unlimited Pinterest videos and images for free.'); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('faq_section.q4', 'Can I download entire Pinterest boards?')); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('faq_section.a4', 'Currently, you need to download Pins individually by pasting each Pin\'s URL.')); ?>                            </p>
                        </div>
                    </div>
                </div>
                <div class="card" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <button class="btn btn-link collapsed" itemprop="name"><?php echo str_replace('{site_name}', __('site_name', 'Pinterest Downloader'), __('faq_section.q5', 'Why can\'t I download some Pins?')); ?></button>
                        </h6>
                    </div>
                    <div id="collapseOne" class="collapse">
                        <div class="card-body" itemprop="acceptedAnswer" itemscope="" itemtype="https://schema.org/Answer">
                            <p itemprop="text">
                                <?php echo __('faq_section.a5', 'Some Pins may be restricted by privacy settings or may not contain downloadable video content.'); ?>                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>