<div id="footer">
    <a href="<?php echo get_page_url('/contact'); ?>"><?php echo __('footer.contact', 'Contact'); ?></a>
    <a href="<?php echo get_page_url('/dmca'); ?>"><?php echo __('footer.dmca', 'Copyright Claims'); ?></a>
    <a href="/#faq">FAQ</a>
    <a href="<?php echo get_page_url('/privacy'); ?>"><?php echo __('footer.privacy', 'Privacy Policy'); ?></a>
    <a href="<?php echo get_page_url('/terms'); ?>"><?php echo __('footer.terms', 'ToU'); ?></a>
</div>

<center>
    <small>© Copyright 2009-<?php echo date('Y'); ?> - <a href="/" title="<?php echo __('site_name'); ?>"><?php echo __('site_name'); ?></a>. All Right Reserved.</small><br>
</center>
<script>var convert_url='/convert/';</script>
<script src="https://<?php echo $GLOBALS['site_domain']; ?>/assets/js/main.js"></script>
<!-- Analytics -->
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=62cab5b0a12f7c001a58e628&product=sop' async='async'></script>
<style>
    .spinner {
        margin: 70px auto;
        position: relative;
        text-align: center;
    }
</style>
<script src="/analytics.js" defer></script>
</body>
</html>