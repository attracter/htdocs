<?php
function td_category_form_ajax($category_id) {
    ob_start();?>

    <!-- DISPLAY VIEW -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">ARTICLE DISPLAY VIEW</span>
            <p>Select a module type, this is how your article list will be displayed</p>
        </div>
        <div class="td-box-control-full td-panel-module">
            <?php
            echo td_panel_generator::visual_select_o(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_layout',
                'values' => array(
                    array('text' => '', 'title' => '', 'val' => '', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-default.png'),
                    array('text' => '', 'title' => '', 'val' => '1', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-1.png'),
                    array('text' => '', 'title' => '', 'val' => '2', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-2.png'),
                    array('text' => '', 'title' => '', 'val' => '3', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-3.png'),
                    array('text' => '', 'title' => '', 'val' => '4', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-4.png'),
                    array('text' => '', 'title' => '', 'val' => '5', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-5.png'),
                    array('text' => '', 'title' => '', 'val' => '6', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-6.png'),
                    array('text' => '', 'title' => '', 'val' => '7', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-7.png'),
                    array('text' => '', 'title' => '', 'val' => '8', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-8.png'),
                    array('text' => '', 'title' => '', 'val' => '9', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-9.png'),
                    array('text' => '', 'title' => '', 'val' => 'search', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/module-10.png')
                )
            ));
            ?>
        </div>
    </div>

    <!-- Custom Sidebar + position -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">CUSTOM SIDEBAR + POSITION</span>
            <p>Sidebar position and custom sidebars</p>
        </div>
        <div class="td-box-control-full td-panel-sidebar-pos">
            <div class="td-display-inline-block">
                <?php
                echo td_panel_generator::visual_select_o(array(
                    'ds' => 'td_category',
                    'item_id' => $category_id,
                    'option_id' => 'tdc_sidebar_pos',
                    'values' => array(
                        array('text' => '', 'title' => '', 'val' => '', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/sidebar-default.png'),
                        array('text' => '', 'title' => '', 'val' => 'sidebar_left', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/sidebar-left.png'),
                        array('text' => '', 'title' => '', 'val' => 'no_sidebar', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/sidebar-full.png'),
                        array('text' => '', 'title' => '', 'val' => 'sidebar_right', 'img' => get_template_directory_uri() . '/wp-admin/images/panel/sidebar-right.png')
                    )
                ));
                ?>
                <div class="td-panel-control-comment td-text-align-right">Select sidebar position</div>
            </div>
            <div class="td-display-inline-block td_sidebars_pulldown_align">
                <?php
                echo td_panel_generator::sidebar_pulldown(array(
                    'ds' => 'td_category',
                    'item_id' => $category_id,
                    'option_id' => 'tdc_sidebar_name'
                ));
                ?>
                <div class="td-panel-control-comment td-text-align-right">Create or select an existing sidebar</div>
            </div>
        </div>
    </div>

    <!-- Show Featured slider -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">SHOW FEATURED SLIDER</span>
            <p>Enable or disable the featured slider (only posts that are in the Featured category are showed in slider)</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_slider',
                'true_value' => '',
                'false_value' => 'yes'
            ));
            ?>
        </div>
    </div>

    <!-- Category color -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">CATEGORY TAG COLOR ON POST PAGE</span>
            <p>Pick a color for this category tag on post page</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::color_picker(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_color',
                'default_color' => ''
            ));
            ?>
        </div>
    </div>

    <!-- BACKGROUND UPLOAD -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">BACKGROUND UPLOAD</span>
            <p>Upload your logo (300 x 100px) .png</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::upload_image(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_image'
            ));
            ?>
        </div>
    </div>

    <!-- BACKGROUND STYLE -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">BACKGROUND STYLE</span>
            <p>How the background will be dispalyed</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::radio_button_control(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_bg_repeat',
                'values' => array(
                    array('text' => 'Default', 'val' => ''),
                    array('text' => 'Stretch', 'val' => 'stretch'),
                    array('text' => 'Tiled', 'val' => 'tile')
                )
            ));
            ?>
        </div>
    </div>

    <!-- Background color -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">BACKGROUND COLOR</span>
            <p>Use a solid color instead of an image</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::color_picker(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_bg_color',
                'default_color' => ''
            ));
            ?>
        </div>
    </div>

    <!-- Hide category tag on post -->
    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title">HIDE CATEGORY TAG ON POST</span>
            <p>Show or hide category tags on post page</p>
        </div>
        <div class="td-box-control-full">
            <?php
            echo td_panel_generator::checkbox(array(
                'ds' => 'td_category',
                'item_id' => $category_id,
                'option_id' => 'tdc_hide_on_post',
                'true_value' => 'hide',
                'false_value' => ''
            ));
            ?>
        </div>
    </div>
    <?php

    return ob_get_clean();

}//end function