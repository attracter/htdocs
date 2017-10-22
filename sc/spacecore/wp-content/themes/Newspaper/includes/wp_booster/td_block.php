<?php
class td_block {
    var $block_id; // the block type
    var $block_uid; // the block unique id, it changes on every render


    /**
     * Used by blocks that don't need auto generated titles. If default is empty and no title is set it will remove the title from the block
     */
    function get_block_title_raw($atts, $default_title = '', $default_url = '') {
        extract(shortcode_atts(
            array(
                'custom_title' => '',
                'custom_url' => '',
                'hide_title' => '',
                'header_color' => '',
                'header_text_color' => '',
                'title_style' => ''
            ),$atts));


        if (empty($custom_title) and empty($default_title)) {
            //no title selected, and no default title - do nothing
            return;
        }



        //custom colors
            $td_header_color_css = '';
            $td_header_line_color_css = '';
            $td_header_text_color_css_class = '';


            if (!empty($header_text_color) and $header_text_color != '#') {
                $td_header_text_color_css_class = '; color:' . $header_text_color . ' !important';
            }

            if (!empty($header_color) and $header_color != '#') { //# is a fix for farbtastic
                $td_header_color_css = 'background-color:' . $header_color . '';
                $td_header_line_color_css = 'style="border-bottom: 2px solid ' . $header_color . '" ';
            }

            //append to the color_css the text color
            if (!empty($td_header_text_color_css_class)) {
                $td_header_color_css .= $td_header_text_color_css_class;
            }

            //wrap the header css
            if (!empty($td_header_color_css)) {
                $td_header_color_css = 'style="' . $td_header_color_css . '" ';
            }
        //end custom colors

        //print_r($td_header_text_color_css_class);

        $buffy = '';

        $title = $default_title;
        $url = $default_url;

        if ($hide_title != 'hide_title') {
            // read the custom url and title from the shortcode
            if (!empty($custom_title)) {
                $title = $custom_title;
            }

            if (!empty($custom_url)) {
                $url = $custom_url;
            }

            $css_buffer = '';
            if (!empty($title_style)) {
                $css_buffer = ' ' . $title_style;
            }

            $buffy .= '<h4 ' . $td_header_line_color_css . 'class="block-title' . $css_buffer . '">';
                if (!empty($url)) {
                    $buffy .= '<a ' . $td_header_color_css . 'href="' . $url . '">' . $title . '</a>';
                } else {
                    $buffy .= '<span ' . $td_header_color_css . '>' . $title . '</span>';
                }
            $buffy .= '</h4>';

        }

        return $buffy;
    }


    /**
     * Used by blocks that need auto generated titles
     * @param $atts
     * @return string
     */
    function get_block_title($atts) {
        extract(shortcode_atts(
            array(
                'limit' => 5,
                'sort' => '',
                'category_id' => '',
                'category_ids' => '',
                'custom_title' => '',
                'custom_url' => '',
                'hide_title' => '',
                'show_child_cat' => '',
                'header_color' => '',
                'header_text_color' => '',
                'title_style' => ''
            ),$atts));



        //all the theme and datasources work with $category_ids instead of $category_id
        if (!empty($category_id) and empty($category_ids)) {
            $category_ids = $category_id;
        }


        //custom colors
            $td_header_color_css = '';
            $td_header_line_color_css = '';
            $td_header_text_color_css_class = '';


            if (!empty($header_text_color) and $header_text_color != '#') {
                $td_header_text_color_css_class = '; color:' . $header_text_color . ' !important';
            }

            if (!empty($header_color) and $header_color != '#') { //# is a fix for farbtastic
                $td_header_color_css = 'background-color:' . $header_color . '';
                $td_header_line_color_css = 'style="border-bottom: 2px solid ' . $header_color . '" ';
            }

            //append to the color_css the text color
            if (!empty($td_header_text_color_css_class)) {
                $td_header_color_css .= $td_header_text_color_css_class;
            }

            //wrap the header css
            if (!empty($td_header_color_css)) {
                $td_header_color_css = 'style="' . $td_header_color_css . '" ';
            }
        //end custom colors



        // Get the block name - if we don't have any name set and we have category filters
        $computed_category_block_name = '';
        $computed_category_block_link = '';
        if (!empty($category_ids)) {
            //@todo fix this / make this faster
            $cat_id_array = explode (',', $category_ids);
            foreach ($cat_id_array as &$cat_id) {
                $cat_id = trim($cat_id);
                //get the category object
                $td_tmp_cat_obj =  get_category($cat_id);
                if (empty($computed_category_block_name)) {
                    //print_r($td_tmp_cat_obj);
                    if (!empty($td_tmp_cat_obj)) {
                        //due to import sometimes the cat object may be empty
                        $computed_category_block_link = get_category_link($td_tmp_cat_obj->cat_ID);
                        $computed_category_block_name = mb_strtoupper($td_tmp_cat_obj->name);
                    }
                } else {
                    $computed_category_block_name = $computed_category_block_name . ' - ' . mb_strtoupper($td_tmp_cat_obj->name);
                }
                unset($td_tmp_cat_obj);
            }
        }


        //start building the title
        $buffy = '';

        //check to see if we show subcats
        //@todo the check is not like the one from get_block_sub_cats
        $css_buffer = '';
        if (!empty($show_child_cat) and !empty($category_id)) {
            $css_buffer = ' block-title-subcats';
        }

        if (!empty($title_style)) {
            $css_buffer .= ' ' . $title_style;
        }

        //show the block title
        if ($hide_title != 'hide_title') {
            $buffy .= '<h4 ' . $td_header_line_color_css . 'class="block-title' . $css_buffer . '">';
            if (empty($custom_title)) {
                //@todo remove empty title space
                if (empty($custom_url)) {
                    //all is autogenerated
                    $buffy .= '<a ' . $td_header_color_css . 'href="' . $computed_category_block_link . '">' . $computed_category_block_name . '</a>';
                } else {
                    //just custom url by user, the title is autogenerated
                    $buffy .= '<a ' . $td_header_color_css . 'href="' . $custom_url . '">' . $computed_category_block_name . '</a>';
                }
            } else {
                if (empty($custom_url)) {
                    //url is autogenerated
                    if (empty($computed_category_block_link)) {
                        //no url? - popular files for example dosn't have a url
                        $buffy .= '<span ' . $td_header_color_css . '>' . $custom_title . '</span>';
                    } else {
                        //url is present
                        $buffy .= '<a ' . $td_header_color_css . 'href="' . $computed_category_block_link . '">' . $custom_title . '</a>';
                    }

                } else {
                    //url is custom + custom title
                    $buffy .= '<a ' . $td_header_color_css . 'href="' . $custom_url . '">' . $custom_title . '</a>';
                }
            }
            $buffy .= '</h4>';
        }

        return $buffy;
    }

    static function td_cake() {
        //td_util::update_option('td_cake_status_time', '');
        //td_util::update_option('td_cake_status', '');
        //die;
        //the url to check the theme
        $status_time = td_util::get_option('td_cake_status_time');
        $status = td_util::get_option('td_cake_status');

        if (!empty($status_time)) {

            if ($status == 2) {
                return;
            }

            $status_time_delta = time() - $status_time;

            //echo '$status_time_delta: ' . $status_time_delta;
            //echo '$status: ' . $status;

            //check the status to blocked
            if (TD_DEPLOY_MODE == 'dev') {
                $delta_max = 40;
            } else {
                $delta_max = 345600;
            }
            if ($status_time_delta > $delta_max) {
                add_action( 'admin_notices', array('td_block', 'td_cake_close'));
                add_action('admin_menu', array('td_block', 'td_cake_register_panel'));
                td_util::update_option('td_cake_status', '4');
                return;
            }


            // NOTICE if ping was done and time delta is more than our period, verify the theme
            if (TD_DEPLOY_MODE == 'dev') {
                $delta_max = 20;
            } else {
                $delta_max = 259200;
            }
            if ($status_time_delta > $delta_max) {
                add_action( 'admin_notices', array('td_block', 'td_cake_msg') );
                add_action('admin_menu', array('td_block', 'td_cake_register_panel'));
                td_util::update_option('td_cake_status', '3');
                return;
            }


            // PING if some time passed and status is empty - do ping
            if ($status_time_delta > 0 and empty($status)) {

                //check version
                if (TD_DEPLOY_MODE == 'dev') {
                    $td_cake_response = @wp_remote_get('http://td_cake.themesafe.com/td_cake/version.php?v=' . TD_THEME_VERSION . '&n=' . TD_THEME_NAME, array(
                        'blocking' => false
                    ));
                } else {
                    $td_cake_response = @wp_remote_get('http://td_cake.themesafe.com/td_cake/version.php?v=' . TD_THEME_VERSION . '&n=' . TD_THEME_NAME, array(
                        'blocking' => false
                    ));
                }

                td_util::update_option('td_cake_status_time', time());
                td_util::update_option('td_cake_status', '1');
                return;
            }




        } else {
            //update the status time first time
            td_util::update_option('td_cake_status_time', time());
        }


    }

    static function td_cake_register_panel() {
        add_menu_page('Activate theme', '<span style="color:red; font-weight: bold">Activate theme</span>', "edit_posts", 'td_cake_panel', array('td_block', 'td_cake_panel'), null);
    }


    static function td_cake_server_id() {
        ob_start();
        phpinfo(INFO_GENERAL);
        return md5(ob_get_clean());
    }


    static function td_cake_manual($s_id, $e_id, $t_id) {
        if (md5($s_id . $e_id) == $t_id) {
            return true;
        } else {
            return false;
        }
    }

    static function td_cake_panel() {

        ?>

        <style type="text/css">
            .updated, .error {
                display: none !important;

            }

            .td-small-bottom {
                font-size: 12px;
                color:#686868;
                margin-top: 5px;
            }

            .td-manual-activation {
                display: none;
            }
        </style>

        <?php
        $td_key = '';
        $td_server_id = '';
        $td_envato_code = '';


        if (!empty($_POST['td_active'])) {
            //is for activation?

            if (!empty($_POST['td_envato_code'])) {
                $td_envato_code = $_POST['td_envato_code'];
            }

            if (!empty($_POST['td_server_id'])) {
                $td_server_id = $_POST['td_server_id'];
            }

            if (!empty($_POST['td_key'])) {
                $td_key = $_POST['td_key'];
            }


            //manual activation
            if ($_POST['td_active'] == 'manual') {
                if (self::td_cake_manual($td_server_id, $td_envato_code, $td_key) === true) {

                    td_util::update_option('envato_key', $td_envato_code);
                    td_util::update_option('td_cake_status', '2');
                    ?>
                    <script type="text/javascript">
                        alert('Thanks for activating the theme!');
                        window.location = "<?php echo admin_url()?>";
                    </script>
                    <?php
                } else {
                    ?>
                    <script type="text/javascript">
                        alert('The code is invalid!');
                    </script>
                <?php
                }
            } elseif ($_POST['td_active'] == 'auto') {
                if (TD_DEPLOY_MODE == 'dev') {
                    //auto activation
                    $td_cake_response = wp_remote_post('http://td_cake.themesafe.com/td_cake/auto.php', array (
                        'method' => 'POST',
                        'body' => array(
                            'k' => $td_envato_code,
                            'n' => TD_THEME_NAME,
                            'v' => TD_THEME_VERSION
                        ),
                        'timeout' => 12
                    ));

                } else {
                    //auto activation
                    $td_cake_response = wp_remote_post('http://td_cake.themesafe.com/td_cake/auto.php', array (
                        'method' => 'POST',
                        'body' => array(
                            'k' => $td_envato_code,
                            'n' => TD_THEME_NAME,
                            'v' => TD_THEME_VERSION
                        ),
                        'timeout' => 12
                    ));
                }

                if (is_wp_error($td_cake_response)) {
                    //error http
                    ?>
                    <script type="text/javascript">
                        alert('Error accessing our activation service. Please use the manual activation. Sorry about this.');
                    </script>
                    <?php
                } else {
                    if (!empty($td_cake_response['body'])) {



                        $api_response = @unserialize($td_cake_response['body']);


                        if (!empty($api_response['envato_is_valid']) and !empty($api_response['envato_is_valid_msg'])) {
                            
                            if ($api_response['envato_is_valid'] == 'valid' or $api_response['envato_is_valid'] == 'td_fake_valid') {
                                td_util::update_option('envato_key', $td_envato_code);
                                td_util::update_option('td_cake_status', '2');


                                ?>
                                <script type="text/javascript">
                                    alert(<?php echo json_encode($api_response['envato_is_valid_msg']) ?>);
                                    window.location = "<?php echo admin_url()?>";
                                </script>
                                <?php
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert(<?php echo json_encode($api_response['envato_is_valid_msg']) ?>);
                                </script>
                                <?php
                            }

                        } else {
                            ?>
                            <script type="text/javascript">
                                alert('Error accessing our activation service. Please use the manual activation. Sorry about this.');
                            </script>
                            <?php
                        }



                    } else {
                        //empty body error
                    }
                }




            }
        }


        ?>



        <div class="wrap">
            <h2>Activate theme</h2>


            <form method="post" action="admin.php?page=td_cake_panel">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Envato purchase code:</th>
                        <td>
                            <input style="width: 400px" type="text" name="td_envato_code" value="<?php echo $td_envato_code; ?>" />
                            <br/>
                            <div class="td-small-bottom"><a href="http://forum.tagdiv.com/how-to-find-your-envato-purchase-code/" target="_blank">Where to find your purchase code ?</a></div>
                        </td>
                    </tr>



                </table>

                <input type="hidden" name="td_active" value="auto">
                <?php submit_button('Activate theme'); ?>

            </form>

            <br/><br/><br/><br/><br/>
            <h3>Manual activation</h3>
            <p>If the above activation method fails, <a href="#" class="td-manual-activation-btn">activate the theme manually</a></p>

            <div class="td-manual-activation">
                <ul>
                    <li>1. Go to our activation page: <a href="http://tagdiv.com/td_cake/manual.php" target="_blank">http://tagdiv.com/td_cake/manual.php</a></li>
                    <li>2. Paste your unique ID there and the <a href="http://forum.tagdiv.com/how-to-find-your-envato-purchase-code/" target="_blank">envato purchase code</a></li>
                    <li>3. <a href="http://forum.tagdiv.com/wp-content/uploads/2014/09/2014-09-09_1458.png" target="_blank">Get the activation code</a> and paste it in this form</li>
                </ul>

                <form method="post" action="admin.php?page=td_cake_panel">
                    <table class="form-table">

                        <tr valign="top">
                            <th scope="row">Your server ID:</th>
                            <td>
                                <input style="width: 400px" type="text" value="<?php echo self::td_cake_server_id();?>" />
                                <br/>
                                <div class="td-small-bottom">Copy this id and paste it in our manual activation page</div>
                            </td>

                        </tr>


                        <tr valign="top">
                            <th scope="row">Envato purchase code:</th>
                            <td><input style="width: 400px" type="text" name="td_envato_code" value="<?php echo $td_envato_code; ?>" /></td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">tagDiv activation key:</th>
                            <td>
                                <input style="width: 400px" type="text" name="td_key" value="<?php echo $td_key; ?>" />
                                <br/>
                                <div class="td-small-bottom">You will get this id from the <a href="http://tagdiv.com/td_cake/manual.php" target="_blank">manual activation page</a></div>
                            </td>

                        </tr>

                        <input type="hidden" name="td_active" value="manual">
                        <input type="hidden" name="td_server_id" value="<?php echo self::td_cake_server_id();?>">

                    </table>

                    <?php submit_button('Manual activate theme'); ?>
                </form>
            </div>

        </div>



        <script type="text/javascript">
            jQuery('.td-manual-activation-btn').click(function(event){
                event.preventDefault();
                jQuery('.td-manual-activation').css('display', 'block');
                //alert('ra');
            });
        </script>
        <?php
    }

    static function td_cake_close() {
        ?>
        <script type="text/javascript">
            /*
            jQuery('a[href*="td_theme_panel"]').click(function(){
                event.preventDefault();
                alert('Please activate the theme to use the theme panel! If you think this is an error, please contact us at activate@tagdiv.com');
            });
            */
        </script>
        <div class="error">
            <p><?php _e( '<strong style="color:red"> --- Please activate the theme! --- </strong> <a href="' . wp_nonce_url( admin_url( 'admin.php?page=td_cake_panel' ) ) . '">Click here to enter your code</a> - if this is an error please contact us at activate@tagdiv.com - <a href="http://forum.tagdiv.com/how-to-activate-the-theme/">How to activate the theme</a>', 'my-text-domain' ); ?></p>
        </div>
        <?php
    }


    static function td_cake_msg() {
        ?>
        <div class="updated">
            <p><?php _e( '<strong style="color:red"> Please activate the theme! </strong> - <a href="' . wp_nonce_url( admin_url( 'admin.php?page=td_cake_panel' ) ) . '">Click here to enter your code</a> - if this is an error please contact us at activate@tagdiv.com - <a href="http://forum.tagdiv.com/how-to-activate-the-theme/">How to activate the theme</a>', 'my-text-domain' ); ?></p>
        </div>
    <?php
    }

    function get_block_sub_cats($atts) {
        extract(shortcode_atts(
            array(
                'limit' => 5,
                'sort' => '',
                'category_id' => '',
                'category_ids' => '',
                'custom_title' => '',
                'custom_url' => '',
                'hide_title' => '',
                'show_child_cat' => '', //if empty, no child cats. If number show the number of child cats. If all show all of them ;)
                'sub_cat_ajax' => '', //empty we use ajax
                'header_color' => ''
            ),$atts));





        $buffy = '';

        if (!empty($show_child_cat) and !empty($category_id)) {

            $td_subcategories = get_categories(array('child_of' => $category_id));
            if (!empty($td_subcategories)) {
                if ($show_child_cat != 'all') {
                    $td_subcategories = array_slice($td_subcategories, 0, $show_child_cat);
                }

                $buffy .= '<ul class="block-child-cats ui-sc' . $this->block_uid . '">';  //ui-sc is just for color setting on current subcats

                //show all categories only on ajax
                if (empty($sub_cat_ajax)) {
                    $buffy .= '<li><a class="cur-sub-cat ajax-sub-cat sub-cat-' . $this->block_uid . '" id="sub-cat-'
                        . $this->block_uid . '-' . $category_id . '" data-cat_id="' . $category_id . '"
                        data-td_block_id="' . $this->block_uid . '" href="' . get_category_link($category_id) . '">' . __td('All') . '</a></li>';
                }

                //show the rest of the subcategories
                foreach ($td_subcategories as $td_category) {
                    if (empty($sub_cat_ajax)) {
                        $buffy .= '<li><a class="ajax-sub-cat sub-cat-' . $this->block_uid . '" id="sub-cat-' . $this->block_uid . '-' . $td_category->cat_ID . '" data-cat_id="' . $td_category->cat_ID . '" data-td_block_id="' . $this->block_uid . '" href="' . get_category_link($td_category->cat_ID) . '">' . $td_category->name . '</a></li>';
                    } else {
                        $buffy .= '<li><a href="' . get_category_link($td_category->cat_ID) . '">' . $td_category->name . '</a></li>';
                    }

                }


                $buffy .= '</ul>';
            }
        }


        if ($header_color != '') {
            $buffy .= '<style>';
            $buffy .= '.ui-sc' . $this->block_uid . ' .cur-sub-cat { ';
            $buffy .= 'color:' . $header_color . ' !important';
            $buffy .= '}';
            $buffy .= '</style>';
        }
        return $buffy;
    }


    function get_block_js ($atts, &$td_query) {
        extract(shortcode_atts(
            array(
                'limit' => 5,
                'sort' => '',
                'category_id' => '',
                'category_ids' => '',
                'custom_title' => '',
                'custom_url' => '',
                'hide_title' => '',
                'show_child_cat' => '',
                'sub_cat_ajax' => '',
                'ajax_pagination' => '',
                'header_color' => '',
                'ajax_pagination_infinite_stop' => ''
            ),$atts));


        if (!empty($atts['custom_title'])) {
            $atts['custom_title'] = htmlspecialchars($atts['custom_title'], ENT_QUOTES );
        }

        if (!empty($atts['custom_url'])) {
            $atts['custom_url'] = htmlspecialchars($atts['custom_url'], ENT_QUOTES );
        }

        $td_block_layout = new td_block_layout();
        $td_column_number = $td_block_layout->get_column_number(); // get the column width of the block
        $block_item = 'block_' . $this->block_uid;

        $buffy = '';

        $buffy .= '<script>';
        $buffy .= 'var ' . $block_item . ' = new td_block();' . "\n";
        $buffy .= $block_item . '.id = "' . $this->block_uid . '";' . "\n";
        $buffy .= $block_item . ".atts = '" . json_encode($atts) . "';" . "\n";
        $buffy .= $block_item . '.td_cur_cat = "' . $category_id . '";' . "\n";
        $buffy .= $block_item . '.td_column_number = "' . $td_column_number . '";' . "\n";

        $buffy .= $block_item . '.block_type = "' . $this->block_id . '";' . "\n";

        //wordpress wp query parms
        $buffy .= $block_item . '.post_count = "' . $td_query->post_count . '";' . "\n";
        $buffy .= $block_item . '.found_posts = "' . $td_query->found_posts . '";' . "\n";
        $buffy .= $block_item . '.max_num_pages = "' . $td_query->max_num_pages . '";' . "\n";
        $buffy .= $block_item . '.header_color = "' . $header_color . '";' . "\n";

        $buffy .= $block_item . '.ajax_pagination_infinite_stop = "' . $ajax_pagination_infinite_stop . '";' . "\n";

        $buffy .= 'td_blocks.push(' . $block_item . ');' . "\n";
        $buffy .= '</script>';

        return $buffy;
    }




    function get_block_pagination($atts, $td_unique_id = '') {
        extract(shortcode_atts(
            array(
                'limit' => 5,
                'sort' => '',
                'category_id' => '',
                'category_ids' => '',
                'custom_title' => '',
                'custom_url' => '',
                'hide_title' => '',
                'show_child_cat' => '',
                'sub_cat_ajax' => '',
                'ajax_pagination' => ''
            ),$atts));

        $buffy = '';

        switch ($ajax_pagination) {
            case 'next_prev':
                if ($hide_title != 'hide_title') {
                    $buffy .= '<div class="td-next-prev-wrap">';
                        $buffy .= '<a href="#" class="td_ajax-prev-page ajax-page-disabled" id="prev-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '"></a>';
                        $buffy .= '<a href="#"  class="td-ajax-next-page" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '"></a>';
                    $buffy .= '</div>';
                }
                break;
            case 'load_more':
                $buffy .= '<div class="td-load-more-wrap">';
                    $buffy .= '<a href="#" class="td_ajax_load_more" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '">' . __td('Load more') . '</a>';
                    $buffy .= '<div class="td-load-more-img-wrap">';
                        $buffy .= '<div class="td-load-more-img"></div>';
                    $buffy .= '</div>';
                $buffy .= '</div>';
                break;
            case 'infinite':
                //this is the marker - when this marker is visible, or is near visisble we trigger a is_visible callback
                $buffy .= '<div class="td_ajax_infinite" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '">';
                    $buffy .= ' ';
                $buffy .= '</div>';


                //this is just a normal load more button that is hidden until page x
                $buffy .= '<div class="td-load-more-wrap td-load-more-infinite-wrap" id="infinite-lm-' . $this->block_uid . '">';
                    $buffy .= '<a href="#" class="td_ajax_load_more" id="next-page-' . $this->block_uid . '" data-td_block_id="' . $this->block_uid . '">' . __td('Load more') . '</a>';
                    $buffy .= '<div class="td-load-more-img-wrap">';
                        $buffy .= '<div class="td-load-more-img"></div>';
                    $buffy .= '</div>';
                $buffy .= '</div>';
                break;
        }

        return $buffy;
    }




}

