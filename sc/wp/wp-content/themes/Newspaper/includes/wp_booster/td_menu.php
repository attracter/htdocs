<?php

// the menu

class td_menu {
    var $is_header_menu_mobile = true;


    function __construct() {
        add_action( 'init', array($this, 'hook_init'));

        if (is_admin()) {
            add_action('wp_update_nav_menu_item', array( $this, 'hook_wp_update_nav_menu_item'), 10, 3);
            add_filter('wp_edit_nav_menu_walker', array($this, 'hook_wp_edit_nav_menu_walker'));
        }

        add_filter('wp_nav_menu_objects', array($this, 'hook_wp_nav_menu_objects'),  10, 2);
    }



    function hook_wp_edit_nav_menu_walker () {
        include_once('td_menu_back.php');
        return 'td_nav_menu_edit_walker';
    }

    function hook_wp_update_nav_menu_item ($menu_id, $menu_item_db_id, $args) {

        //echo $menu_item_db_id;
        if (isset($_POST['td_mega_menu_cat'][$menu_item_db_id])) {
            //print_r($_POST);
            update_post_meta($menu_item_db_id, 'td_mega_menu_cat', $_POST['td_mega_menu_cat'][$menu_item_db_id]);
        }



    }


    /**
     * adds mega menu support
     * @param $items
     * @param string $args
     * @return array
     */
    function hook_wp_nav_menu_objects($items, $args = '') {
        $items_buffy = array();

        $td_is_firstMenu = true;




        //print_r($items);


        //
        foreach ($items as &$item) {
            // $item->

            /**
             * $item
             *  -> $item (is_mega_menu = true) - this item is a mega menu
             */

            $item->is_mega_menu = false; // all items should have this property, we just init it here - when an item has this flag on it means that the item is the mega menu dropdown!

            // first menu fix
            if ($td_is_firstMenu) {
                $item->classes[] = 'menu-item-first';
                $td_is_firstMenu = false;
            }

            // fix the down arros + shortcodes
            if (strpos($item->title,'[') === false) {

            } else {
                //on shortcodes [home] etc.. do not show down arrow
                $item->classes[] = 'td-no-down-arrow';
            }

            //run shortcodes
            $item->title = do_shortcode($item->title);


            // read the menu item metadata!
            $td_mega_menu_cat = get_post_meta($item->ID, 'td_mega_menu_cat', true);


            /**
             * check to see if we are in the header menu location and if we have
             */
            if ($this->is_header_menu_mobile === false) {
                /**
                 * we are in the header menu location
                 */
                if ($td_mega_menu_cat != '') { // check to see if we are having a mega menu item (the item has metadata)
                    //create a mega menu item
                    $item->classes[] = 'td-menu-item';
                    $item->classes[] = 'td-mega-menu';
                    //add the parent menu (ex current menu to the buffer)

                    //print_r($item); //show only the parent item properties
                    $items_buffy[] = $item;

                    //create a new mega menu item: - this is just the dropdown menu / not the parrent
                    $new_item = $this->generate_wp_post();
                    /*
                     * it's a mega menu,
                     * - set the is_mega_menu flag
                     * - alter the last item classes  $last_item
                     * - change the title and url of the current item
                     */
                    $new_item->is_mega_menu = true; //this is sent to the menu walkers
                    $new_item->menu_item_parent = $item->ID;
                    $new_item->url = '';
                    $new_item->title = '<div class="td-mega-grid">';
                    $new_item->title .= td_global_blocks::get_instance('td_mega_menu')->render(
                        array(
                            'limit' => '5',
                            'td_column_number' => 3,
                            'ajax_pagination' => 'next_prev',
                            'category_id' => $td_mega_menu_cat,
                            'show_child_cat' => '5'
                        ));
                    $new_item->title .= '</div>';




                    $items_buffy[] = $new_item;
                } else { // the item is just a normal item in the header menu
                    $item->classes[] = 'td-menu-item';
                    $item->classes[] = 'td-normal-menu';
                    $items_buffy[] = $item;
                }

            } else {
                /**
                 * we are in the mobile menu location
                 */
                if ($td_mega_menu_cat != '') {
                    //this is a mega menu, do a category check

                    //add the parent item
                    $items_buffy[] = $item;

                    //check for subcategories
                    $td_subcategories = get_categories(array('child_of' => $td_mega_menu_cat));
                    if (!empty($td_subcategories)) {

                        $sub_categories_count = 0;
                        foreach ($td_subcategories as $td_category) {
                            if ($sub_categories_count == 5) { // only show 5 subcategories in the mobile menu - the same limit applies to the mega menu
                                break;
                            }

                            $new_item = $this->generate_wp_post();
                            $new_item->is_mega_menu = false; //this is sent to the menu walkers
                            $new_item->menu_item_parent = $item->ID;
                            $new_item->url = get_category_link($td_category->cat_ID);
                            $new_item->title = $td_category->name;
                            $items_buffy[] = $new_item;


                            $sub_categories_count++;

                        }
                    }



                } else {
                    // this item is a normal item in the mobile menu
                    $items_buffy[] = $item;
                }

            }







        } //end foreach


        /**
         * double warning :) - this pice of code runs FIRST because it's the mobile menu first
         */
        if ($this->is_header_menu_mobile === true) {
            /*
        }
            foreach ($items as &$item) {
                $td_mega_menu_cat = get_post_meta($item->ID, 'td_mega_menu_cat', true);
                if ($td_mega_menu_cat != '' and $this->is_header_menu_mobile === false) {


                if ($item->is_mega_menu) {
                    print_r($item);
                }
            }

            print_r($items);
            die;
            unset($items_buffy);
            */
        }


        // we have two header-menu locations and the fist one is the mobile menu
        // the second one is the header menu
        if ($args->theme_location == 'header-menu') {
            $this->is_header_menu_mobile = false;
        }



        //print_r($items_buffy);
        //die;
        return $items_buffy;
    }


    function hook_init() {
        register_nav_menus(
            array(
                'top-menu' => __( 'Top Header Menu', TD_THEME_NAME),
                'header-menu' => __( 'Header Menu (main)', TD_THEME_NAME),
                'footer-menu' => __( 'Footer Menu', TD_THEME_NAME)
            )
        );
    }


    function generate_wp_post() {
        $post = new stdClass;
        $post->ID = 0;
        $post->post_author = '';
        $post->post_date = '';
        $post->post_date_gmt = '';
        $post->post_password = '';
        $post->post_type = 'menu_tds';
        $post->post_status = 'draft';
        $post->to_ping = '';
        $post->pinged = '';
        $post->comment_status = '';
        $post->ping_status = '';
        $post->post_pingback = '';
        $post->post_category = '';
        $post->page_template = 'default';
        $post->post_parent = 0;
        $post->menu_order = 0;
        return new WP_Post($post);
    }


}

new td_menu();





//this walker is used to remove a wrapping <a> around the megamenu
class td_tagdiv_walker_nav_menu extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         *
         * @since 3.0.0
         *
         * @param array  $classes The CSS classes that are applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of arguments. @see wp_nav_menu()
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's <li>.
         *
         * @since 3.0.1
         *
         * @param string The ID that is applied to the menu item's <li>.
         * @param object $item The current menu item.
         * @param array $args An array of arguments. @see wp_nav_menu()
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's <a>.
         *
         * @since 3.6.0
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
         *
         *     @type string $title  The title attribute.
         *     @type string $target The target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item The current menu item.
         * @param array  $args An array of arguments. @see wp_nav_menu()
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;

        //tagdiv - megamenu disable link from from includes/wp_booster/td_menu.php  hook_wp_nav_menu_objects
        if ($item->is_mega_menu == false) {
            $item_output .= '<a'. $attributes .'>';
        }

        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        //tagdiv - megamenu disable link from includes/wp_booster/td_menu.php   hook_wp_nav_menu_objects
        if ($item->is_mega_menu == false) {
            $item_output .= '</a>';
        }
        $item_output .= $args->after;

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes $args->before, the opening <a>,
         * the menu item's title, the closing </a>, and $args->after. Currently, there is
         * no filter for modifying the opening and closing <li> for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of arguments. @see wp_nav_menu()
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}






