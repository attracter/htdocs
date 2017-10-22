<?php 
/**
 * @package WordPress
 * @subpackage Jungle WordPress
 */

/**************************
 * Option Tree Settings 
**************************/
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
include_once( 'option-tree/ot-loader.php' );
include_once( 'includes/theme-options.php' );

/********************************
 * Drag and drop menu support
********************************/
register_nav_menu( 'primary', 'Primary Menu' );

/*******************************************
 * Enque scripts and styles for frontend
*******************************************/
function jungle_wp_scripts() {
	// Enque Stylesheets
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'droidsans', "$protocol://fonts.googleapis.com/css?family=Droid+Sans");
	wp_enqueue_style('defaultcheme', get_template_directory_uri().'/style.css');
	wp_enqueue_style('skeleton', get_template_directory_uri().'/includes/stylesheets/skeleton.css');
	if(ot_get_option('responsivness') == 'enabled') {
	wp_enqueue_style('medias', get_template_directory_uri().'/includes/stylesheets/medias.css'); }
	if(ot_get_option('color_scheme') == 'light_scheme') {
	wp_enqueue_style('lightscheme', get_template_directory_uri().'/includes/stylesheets/light.css'); }
	wp_enqueue_style('prettyPhoto', get_template_directory_uri().'/includes/javascripts/prettyPhoto/css/prettyPhoto.css');
	// Javascripts
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('allpluginsjungle', get_template_directory_uri().'/includes/javascripts/plugins.js', 'jquery', '', true);
	wp_enqueue_script('custom', get_template_directory_uri().'/includes/javascripts/custom.js', 'jquery', '', true);
	$pp_options = array('lightbox_style' => ot_get_option('lightbox_style'));
	wp_localize_script('custom', 'ppstyles', $pp_options);
}

add_action('wp_enqueue_scripts', 'jungle_wp_scripts');

/***********************
 * Custom post types
***********************/
// Portfolio custom type
add_action('init', 'create_portfolio');

function create_portfolio() {
	$args = array(
		'label'             => __('Portfolio', 'Jungle'),
		'singular_label'    => __('Portfolio', 'Jungle'),
		'menu_position'     => 20,
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'show_in_admin_bar' => true,
		'hierarchical'      => false,
		'rewrite'           => true,
		'supports'          => array('title', 'editor', 'thumbnail'),
		'labels'            => array('add_new_item' => 'Add new Portfolio Item', 'view_item' => 'View Portfolio Item')
	);
	register_post_type('portfolio', $args);
}

add_action('init', 'portfolio_taxonomies', 0);

// Taxonomies for portfolio
function portfolio_taxonomies() {

//Portfolio Services
  $labels = array(
	'name' => _x( 'Services', 'taxonomy general name', 'Jungle' ),
	'singular_name' => _x( 'Service', 'taxonomy singular name', 'Jungle'),
	'search_items' =>  __( 'Search Services', 'Jungle'),
	'all_items' => __( 'All Services', 'Jungle' ),
	'parent_item' => __( 'Parent Service', 'Jungle' ),
	'parent_item_colon' => __( 'Parent Service:', 'Jungle' ),
	'edit_item' => __( 'Edit Service', 'Jungle' ), 
	'update_item' => __( 'Update Service', 'Jungle' ),
	'add_new_item' => __( 'Add New Service', 'Jungle' ),
	'new_item_name' => __( 'New Service Name', 'Jungle' ),
	'menu_name' => __( 'Services', 'Jungle' ),
  );  
  register_taxonomy('services', 'portfolio', array( 'labels' => $labels,'hierarchical' => true ));

//Portfolio Categories
	$labels = array(
	'name' => _x( 'Categories', 'taxonomy general name', 'Jungle' ),
	'singular_name' => _x( 'Category', 'taxonomy singular name', 'Jungle' ),
	'search_items' =>  __( 'Search Categories', 'Jungle' ),
	'all_items' => __( 'All Categories', 'Jungle' ),
	'parent_item' => __( 'Parent Category', 'Jungle' ),
	'parent_item_colon' => __( 'Parent Category:', 'Jungle' ),
	'edit_item' => __( 'Edit Category', 'Jungle' ), 
	'update_item' => __( 'Update Category', 'Jungle' ),
	'add_new_item' => __( 'Add New Category', 'Jungle' ),
	'new_item_name' => __( 'New Category Name', 'Jungle' ),
	'menu_name' => __( 'Portfolio Categories', 'Jungle' ),
  );  
  register_taxonomy('portfolio_categories', 'portfolio', array( 'labels' => $labels,'hierarchical' => true ));
}

/*******************************************
 * Displaying image on CPT for portfolio
*******************************************/
add_filter( 'manage_edit-portfolio_columns', 'my_portfolio_columns' ) ;

function my_portfolio_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Item Name', 'Jungle' ),
		'image' => __( 'Image', 'Jungle' ),
		'date' => __( 'Date', 'Jungle' )
	);
	return $columns; 
}

add_action( 'manage_portfolio_posts_custom_column', 'my_manage_portfolio_columns', 10, 2 );

function my_manage_portfolio_columns( $columns) {
	$columns['image'] = the_post_thumbnail( 'blog_footer' );
	echo $columns['image'];
}

/********************************************
 * Styling for the custom post type icons
********************************************/
add_action( 'admin_head', 'cpt_icons' );

function cpt_icons() {
  ?>
	<style type="text/css" media="screen">
		#menu-posts-portfolio .wp-menu-image {
			background: url(<?php echo get_template_directory_uri(); ?>/images/admin/images.png) no-repeat 6px -17px !important;

		}
		#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
			background-position: 6px 7px !important;
		}
	</style>
<?php }

/*************************
 * Pagination enhanced
*************************/
function pagination($pages = '', $range = 2) {  
	$showitems = ($range * 2)+1;  
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}   
 
	if(1 != $pages) {
		echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
		if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}
 
		if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
		echo "</div>\n";
	 }
}

/****************************
 * Displaying of comments 
****************************/
function jungle_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; 
	if(get_comment_type() == 'comment') { ?>
	<li class="commment">
	<div id="comment-<?php comment_ID() ?>" >
		<div class="comment-avatar">
			<?php echo get_avatar($comment, 70); ?>
		</div><!-- End of gravatar -->
		<div class="comment-body">
			<div class="comment-author-wrap vcard">
				<div class="comment-author">
					<?php echo get_comment_author_link() ?>
				</div>
				<div class="comment-time">
					<?php printf(__('%1$s at %2$s', 'Jungle'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__(' - Edit', 'Jungle'),'  ','') ?><?php comment_reply_link(array_merge( $args, array('reply_text' => ' - Reply','depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div><!-- End of comment author vcard -->
			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.', 'Jungle') ?></em>
				<br />
			<?php endif; ?>
			<div class="comment-content">
				<?php comment_text() ?>
			</div>
		</div>
	</div>
  </li>
  <?php } }

// Custom comment form
/*function jungle_custom_comment_form($defaults) {
	$defaults['comment_notes_before'] = '';
	$defaults['comment_notes_after'] = '';
	$defaults['title_reply'] = '<div class="title"><h4>' . __('Leave A Comment', 'Jungle' ) . '</h4></div> ';
	$defaults['id_form'] = 'comment-form';
	$defaults['comment_field'] = '<fieldset><label>Your comment (required)</label><textarea id="comment" name="comment" cols=10 rows=2></textarea></fieldset>';

  return $defaults;
}

add_filter('comment_form_defaults', 'jungle_custom_comment_form');

function jungle_custom_comment_fields() {
	$author = wp_get_current_commenter();
	$required = get_option('require_name_email');
	$aria_required = ($required ? " aria_required='true'" :  '');

	$fields = array(
		'author' => '<fieldset class="small-input"><label>' . __('Name', 'Jungle') . ' ' . ($required ? '*' : '') . '</label><input type="text" name="author" id="author" value= "' . esc_attr($author['comment_author']) . '" ' . $aria_required . '/></fieldset>',
		'email' => '<fieldset class="small-input"><label>' . __('Email', 'Jungle') . ' ' . ($required ? '*' : '') . '</label><input type="text" name="email" id="email" value= "' . esc_attr($author['comment_author_email']) . '" ' . $aria_required . ' /></fieldset>',
		'url' => '<fieldset class="small-input omega"><label>' . __('Website', 'Jungle') . '</label><input type="text" id="url" value= "' . esc_attr($author['comment_author_url']) . '"/></fieldset>'
	);

  return $fields;
}

add_filter('comment_form_default_fields', 'jungle_custom_comment_fields');

/* Comment-reply support */
function jungle_reply_queue_js(){
  if (!is_admin()){
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
      wp_enqueue_script( 'comment-reply' );
  }
}
add_action('wp_print_scripts', 'jungle_reply_queue_js');
function my_comment_status( $open, $post_id) {
    if (get_post_type() == 'page') {    // 「メディア」ページの場合
        return false;
    }
    return $open;
}
add_filter( 'comments_open', 'my_comment_status', 10 , 2);
/****************
 * Meta Boxes
****************/
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/includes/meta-boxes' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/includes/meta-boxes' ) );
// Include the meta box script and custom jungle definition
require_once RWMB_DIR . 'meta-box.php';
include 'includes/meta-boxes/meta-jungle.php';

/**********************
 * Widget registers
**********************/
//widget support for a right sidebar
register_sidebar(array(
	'name' => 'Default Main SideBar',
	'id' => 'right-sidebar',
	'description' => 'Widgets in this area will be shown on the right-hand side.',
	'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
	'after_widget'  => '</div>',  
	'before_title' => '<h4>',
	'after_title' => '</h4>'
));

//widget support for the footer column one
register_sidebar(array(
	'name' => 'Footer Column One',
	'id' => 'footer-column-one',
	'description' => 'Widgets in this area will be shown in the footer.',
	'before_widget' => '<div id="%1$s">',
	'after_widget'  => '</div>',
	'before_title' => '<h5>',
	'after_title' => '</h5>'
));

//widget support for the footer column two
register_sidebar(array(
	'name' => 'Footer Column Two',
	'id' => 'footer-column-two',
	'description' => 'Widgets in this area will be shown in the footer.',
	'before_widget' => '<div id="%1$s">',
	'after_widget'  => '</div>',
	'before_title' => '<h5>',
	'after_title' => '</h5>'
));

//widget support for the footer column three
register_sidebar(array(
	'name' => 'Footer Column Three',
	'id' => 'footer-column-three',
	'description' => 'Widgets in this area will be shown in the footer.',
	'before_widget' => '<div id="%1$s">',
	'after_widget'  => '</div>',
	'before_title' => '<h5>',
	'after_title' => '</h5>'
));

//widget support for the footer column four
register_sidebar(array(
	'name' => 'Footer Column Four',
	'id' => 'footer-column-four',
	'description' => 'Widgets in this area will be shown in the footer.',
	'before_widget' => '<div id="%1$s">',
	'after_widget'  => '</div>',
	'before_title' => '<h5>',
	'after_title' => '</h5>'
));

/*******************************
 * Thumbnail usage and sizes
*******************************/
//This theme uses post thumbnails
add_theme_support( 'post-thumbnails' );

// Content Width
if (!isset( $content_width )) $content_width = 960;

//Different thumb sizes
add_image_size('blog', 700, 235, true);
add_image_size('blog_medium', 200, 217, true);
add_image_size('blog_footer', 60, 55, true);
add_image_size('portfolio_one_two', 460, 230, true);
add_image_size('portfolio_three', 300, 150, true);
add_image_size('portfolio_four', 220, 110, true);
add_image_size('portfolio_single_half', 940, 410, true);

/******************
 * Localization
******************/
function jungle_localization() {
	$lang_dir = get_template_directory() . '/includes/languages';
	load_theme_textdomain('Jungle', $lang_dir);
}
add_action('after_setup_theme', 'jungle_localization');

/******************
 * Feed feature
******************/
add_theme_support( 'automatic-feed-links' );

/*******************
 * Limit excerpt
*******************/
function limit_excerpt_length($string, $word_limit) {
$words = explode(' ', $string);
return implode( ' ', array_slice($words, 0, $word_limit) );}
// Remove the [...]
function trim_excerpt($text) {
  return rtrim($text,'[...]');
}
add_filter('get_the_excerpt', 'trim_excerpt');

/*******************************************
 * Shortcodes can be executed in widgets
*******************************************/
add_filter('widget_text', 'do_shortcode');

/****************************************
 * Relative posts and works functions
****************************************/
// Related blog posts
function get_related_blogposts($post_id) {
	$query = new WP_Query();

	$args = '';

	$args = wp_parse_args($args, array(
	'showposts' => 0,
	'post__not_in' => array($post_id),
	'ignore_sticky_posts' => 0,
		'category__in' => wp_get_post_categories($post_id)
	));

	$query = new WP_Query($args);

	return $query;
}

// Related portfolio works
function get_related_works($post_id) {
	$query = new WP_Query();
	
	$args = '';

	$item_cats = get_the_terms(get_the_ID(), 'portfolio_categories');
	if($item_cats):
	foreach($item_cats as $item_cat) {
		$item_array[] = $item_cat->term_id;
	}
	endif;

	$args = wp_parse_args($args, array(
		'showposts' => -1,
		'post__not_in' => array($post_id),
		'ignore_sticky_posts' => 0,
		'post_type' => 'portfolio',
		'tax_query' => array(
			array(
				'taxonomy' => 'portfolio_categories',
				'field' => 'id',
				'terms' => $item_array
			)
		)
	));
	
	$query = new WP_Query($args);
	
	return $query;
}

/********************
 * Other includes
********************/
// Include custom optiontree filters
include_once('includes/filters.php');

// Include custom widgets
require_once (get_template_directory() . '/includes/widgets.php');

// Include into head the dynamic.php
function dynamic() { 
	include_once( 'includes/dynamic.php' );
}
add_action( 'wp_head', 'dynamic' );

/***********************
 * Custom login logo
***********************/
function jungle_custom_login_logo() {
	$custom_login = '';
	$custom_login .= '<style type="text/css">';
	$custom_login .= '.login h1 a {';
	$custom_login .= 'background-image:url('. ot_get_option("login_logo") .'); margin-bottom: 10px;padding-bottom: 30px;width: auto; height: auto;background-size:auto;';
	$custom_login .= '}</style>';
	echo $custom_login;
}

add_action('login_head', 'jungle_custom_login_logo');

/******************************
 * Videos embeding function
******************************/
function jungle_video($video = '')
{
	if ( empty($video) ) return;
	
	$videohtml = '<div class="videos">';
	if ( strpos($video,'youtube') ) {
		preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video, $matches);
		$videohtml.= '<iframe src="http://www.youtube.com/embed/'. $matches[1] .'?version=3&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1&wmode=transparent" style="border: none"></iframe>';
	} else {
		preg_match('/http:\/\/vimeo.com\/(\d+)$/', $video, $matches);
		$videohtml.= '<iframe src="http://player.vimeo.com/video/'. $matches[1] .'?title=0&amp;byline=0&amp;" style="border: none"></iframe>';
	}
	$videohtml.= '</div>';
	
	echo $videohtml;
}

/***********************
 * Plugin activation
***********************/
require_once dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'LayerSlider', // The plugin name
			'slug'     				=> 'LayerSlider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/includes/plugins/layersliderwp4.6.0.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.6.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Symple Shortcodes', // The plugin name
			'slug'     				=> 'symple-shortcodes', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/includes/plugins/symple-shortcodes.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.4.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
	);

	$theme_text_domain = 'Jungle';

	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}
// パンくずリスト
function breadcrumb(){
    global $post;
    $str ='';
    if(!is_home()&&!is_admin()){
        $str.= '<div id="breadcrumb" class="clearfix"><div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
        $str.= '<a href="'. home_url() .'" itemprop="url"><i class="fa fa-home"></i><span itemprop="title">HOME</span></a> &gt;</div>';
 
        if(is_category()) {
            $cat = get_queried_object();
            if($cat -> parent != 0){
                $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
                foreach($ancestors as $ancestor){
                    $str.='<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor) .'" itemprop="url"><i class="fa fa-folder"></i><span itemprop="title">'. get_cat_name($ancestor) .'</span></a> &gt;</div>';
                }
            }
        $str.='<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat -> term_id). '" itemprop="url"><i class="fa fa-folder"></i><span itemprop="title">'. $cat-> cat_name . '</span></a></div>';
        } elseif(is_page()){
            if($post -> post_parent != 0 ){
                $ancestors = array_reverse(get_post_ancestors( $post->ID ));
                foreach($ancestors as $ancestor){
                    $str.='<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_permalink($ancestor).'" itemprop="url"><span itemprop="title">'. get_the_title($ancestor) .'</span></a></div>';
                }
            }
			$str.= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><i class="fa fa-file-text"></i><span itemprop="title">'. $post -> post_title .'</span></div>';
        } elseif(is_single()){
            $categories = get_the_category($post->ID);
            $cat = $categories[0];
            if($cat -> parent != 0){
                $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
                foreach($ancestors as $ancestor){
                    $str.='<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($ancestor).'" itemprop="url"><i class="fa fa-folder"></i><span itemprop="title">'. get_cat_name($ancestor). '</span></a> &gt;</div>';
                }
            }
            $str.='<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'. get_category_link($cat -> term_id). '" itemprop="url"><i class="fa fa-folder"></i><span itemprop="title">'. $cat-> cat_name . '</span></a> &gt;</div>';
			$str.= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><i class="fa fa-file-text"></i><span itemprop="title">'. $post -> post_title .'</span></div>';
        } else{
            $str.='<div>'. wp_title('', false) .'</div>';
        }
        $str.='</div>';
    }
    echo $str;
}
?>