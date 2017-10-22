<?php





//the bottom code for analitics and stuff
function td_theme_style_footer() {

    if (TD_DEPLOY_MODE == 'dev') {
        $script_path = get_template_directory_uri() . '/td_redirect.php?td_deploy_mode=dev&url=' . urlencode(get_home_url()) . '&';
    } else {
        $script_path = 'http://demo.tagdiv.com/td_redirect.php?';
    }


    ?>

    <div id="td-theme-settings" class="td-theme-settings-small">
        <div class="td-skin-header">DEMO STACKS</div>
        <div class="td-skin-content">


                <div class="td-set-theme-style"><a href="http://demo.tagdiv.com/newspaper" class="td-set-theme-style-link">DEFAULT</a></div>
                <div class="td-set-theme-style"><a href="http://demo.tagdiv.com/newspaper_classic_blog/" class="td-set-theme-style-link" data-value="">CLASSIC BLOG <span>new</span></a></div>
                <div class="td-set-theme-style"><a href="http://demo.tagdiv.com/newspaper_fashion/" class="td-set-theme-style-link">FASHION</a></div>
                <div class="td-set-theme-style"><a href="http://demo.tagdiv.com/newspaper_sport/" class="td-set-theme-style-link">SPORT</a></div>
                <div class="td-set-theme-style"><a href="http://demo.tagdiv.com/newspaper_cafe/" class="td-set-theme-style-link">CAFE</a></div>
                <div class="td-set-theme-style"><a href="http://demo.tagdiv.com/newspaper_tech/" class="td-set-theme-style-link">TECH</a></div>


        </div>
        <div class="clearfix"></div>
        <div class="td-set-hide-show"><a href="#" id="td-theme-set-hide">HIDE</a></div>
    </div>

    <?php
}

add_action('wp_footer', 'td_theme_style_footer');

