<?php


/**
 * custom walker
 * Class td_category_walker_panel
 */
class td_category_walker_panel extends Walker {
    var $tree_type = 'category';
    var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');


    var $td_category_hierarchy = array();  // we store them like so [0] Category 1 - [1] Category 2 - [2] Category 3


    var $td_category_buffer = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {

    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {

    }


    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

        if (!isset($td_last_category_objects[$depth])) {
            $this->td_category_hierarchy[$depth] = $category;
        }


        if ($depth == 0) {
            //reset the parrents
            $this->td_category_hierarchy = array();
            //put the
            $this->td_category_hierarchy[0] = $category;

            //add first parent
            $this->td_category_buffer['<a href="' . get_category_link($category->term_id) . '" target="_blank" data-is-category-link="yes">' . $category->name . '</a>'] = $category->term_id;
        } else {

            $td_tmp_buffer = '';
            $last_cat_id = 0;
            $contor_array = 0;
            foreach ($this->td_category_hierarchy as $parent_cat_obj) {
                if ($td_tmp_buffer === '') {
                    $td_tmp_buffer = '<a href="' . get_category_link($parent_cat_obj->term_id) . '" target="_blank" data-is-category-link="yes">' . $parent_cat_obj->name . '</a>';
                    $last_cat_id = $parent_cat_obj->term_id;
                } else {
                    if($this->td_category_hierarchy[$contor_array-1]->term_id == $parent_cat_obj->parent) {
                        $td_tmp_buffer .=  '<img src="' . get_template_directory_uri() . '/wp-admin/images/panel/panel-breadcrumb.png" class="td-panel-breadcrumb">' . '<a href="' . get_category_link($parent_cat_obj->term_id) . '" target="_blank" data-is-category-link="yes">' . $parent_cat_obj->name . '</a>';
                        $last_cat_id = $parent_cat_obj->term_id;
                    }
                }

                $contor_array++;

            }

            //add child
            $this->td_category_buffer[$td_tmp_buffer] = $last_cat_id;

        }


    }


    function end_el( &$output, $page, $depth = 0, $args = array() ) {

    }

}






class td_display_categories_sttings {

    /**
     * render the categories forms
     */
    static function render_categories_form() {
        //get all categories from database


        $categories = get_categories(array(
            'hide_empty' => 0
        ));



        $td_category_walker_panel = new td_category_walker_panel;
        $td_category_walker_panel->walk($categories, 4);


        foreach ($td_category_walker_panel->td_category_buffer as $display_category_name => $category_id) {

            //echo td_panel_generator::ajax_box($display_category_name, 'td_category', array('category_id' => $category_id));

            ?>
            <!-- LAYOUT SETTINGS -->
            <?php echo td_panel_generator::ajax_box($display_category_name , array('category_id' => $category_id, 'td_ajax_view' => 'td_category'));

        }//end foreach

    }//end function

}//end class

//start building the categories form
td_display_categories_sttings::render_categories_form();