<?php
function td_translations_form_ajax() {
    global $td_translation_map;
    ob_start();?>

    <!-- TRANSLATE YOUR THEME -->
    <div class="td-box-row">
        <div class="td-box-description td-box-full">
            <span class="td-box-title">TRANSLATE YOUR THEME</span>
            <p>Translate your front end easily without any external plugins that costs money. Leave the box empty and the theme will load the default string</p>
        </div>
    </div>
    <?php

    foreach($td_translation_map as $key_id => $value) {
        ?>
        <div class="td-box-row">
            <div class="td-box-description">
                <span class="td-box-title td-title-on-row"><?php echo $key_id;?></span>
                <p></p>
            </div>
            <div class="td-box-control-full">
                <?php
                echo td_panel_generator::input(array(
                    'ds' => 'td_translate',
                    'option_id' => $key_id
                ));
                ?>
            </div>
        </div><?php
    }

    return ob_get_clean();
}