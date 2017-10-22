<?php echo td_panel_generator::box_start('Documentation on how to use custom fonts');//, false?>

    <div class="td-box-row">
        <div class="td-box-description">
            <span class="td-box-title td-title-on-row"></span>
            <p><a href="http://forum.tagdiv.com/how-to-use-custom-fonts/" target="_blank">Documentation on how to use custom fonts</a></p>

            <p><a href="?page=td_theme_panel&td_page=td_view_custom_fonts" target="_blank" class="td-big-button">To add custom fonts click here</a></p>
        </div>
        <div class="td-box-control-full">
        </div>
    </div>

<?php echo td_panel_generator::box_end();?>

<?php
class td_panel_custom_typograpfy {

    function __construct() {

        //insert separator after this section numbers from td_fonts::$typography_sections. the counting of td_fonts::$typography_sections starts from 1
        $td_section_separator_array = array(
                                        0  => 'Post Page',
                                        16 => 'Slides',
                                        19 => 'Menu`s',
                                        23 => 'Pages',
                                        37 => 'Tabs'
                                     );

        $td_section_counter = 0;
        foreach(td_fonts::$typography_sections as $font_section_settings_id => $font_section_name) {

            //create the section separators
            if(array_key_exists($td_section_counter, $td_section_separator_array)) {
                echo '<hr><div class="td-section-separator">' . $td_section_separator_array[$td_section_counter] . '</div>';
            }

            //ajax sections
            echo td_panel_generator::ajax_box($font_section_name , array('section_id' => $font_section_settings_id, 'td_ajax_view' => 'td_theme_fonts'));


            $td_section_counter++;
        }//end foreach
    }
}


//call the generate function to create the ajax fonts control panel
$object_custom_typograpfy = new td_panel_custom_typograpfy();