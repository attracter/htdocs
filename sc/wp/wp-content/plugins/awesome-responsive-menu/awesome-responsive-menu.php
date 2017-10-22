<?php /* 
Plugin Name: Awesome Responsive Menu
Plugin URI: http://www.help4cms.com/ 
Version: 0.1 
Author: Mudit Kumawat 
Description: This plugin Convert show desktop menu to Mobile menu. 
*/





define('directory', plugins_url('awesome-responsive-menu') );
$options = get_option('awesome_responsive_menu');
//print_r($options);
if(!empty($options )){
extract($options);
};




class awesome_responsive_menu_Admin {

    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'awesome_responsive_menu';

    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected $option_metabox = array();

    /**
     * Options Page title
     * @var string
     */
    protected $title = '';

    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
		
		
$menus = get_terms('nav_menu',array('hide_empty'=>false));
$menu = array();
foreach( $menus as $m ) {
$menu[$m->name] = $m->name;
	}
		
        // Set our title
        $this->title = __( 'Awesome Responsive Menu', 'AwesomeResponsiveMenu' );

        // Set our Awesome Responsive Menu Admin Fields
        $this->fields = array(
		
		/*  array(
                'name'    => __( 'Menu Button Title ', 'AwesomeResponsiveMenu' ),
                'desc'    => __( 'This is the title show in right side of Menu 3 Line Button', 'AwesomeResponsiveMenu' ),
                'id'      => 'menu_button_title',
                'type'    => 'text_small',
              
            ),*/
		
         
            array(
                'name'    => __( 'Add Class OR ID ', 'AwesomeResponsiveMenu' ),
                'desc'    => __( 'Add Here Element class OR id including "#" OR "." Where You Prepend Responsive Menu', 'AwesomeResponsiveMenu' ),
                'id'      => 'prependto',
                'type'    => 'text_small',
              
            ),
						
				array(
                'name'    => __( 'Menu Breakpoint ', 'AwesomeResponsiveMenu' ),
                'desc'    => __( ' This is the point where the responsive menu will be visible in px width of Browser', 'AwesomeResponsiveMenu' ),
                'id'      => 'menu_breakpoint',
                'type'    => 'text_small',
              
            ),
			
			
				array(
                'name'    => __( 'Elements to Hide in Mobile ', 'AwesomeResponsiveMenu' ),
                'desc'    => __( ' Enter the css class/ids for different elements you want to hide on mobile separeted by a comma(,). Example: .nav,#main-menu ', 'AwesomeResponsiveMenu' ),
                'id'      => 'element_hide',
                'type'    => 'text_medium',
              
            ),
			

			
    array(
    'name'    => 'Choose Menu To Responsify',
    'desc'    => 'This is the menu that will be used responsive.',
    'id'      => 'awesome_responsive_menu',
    'type'    => 'select',
    'options' => $menu,
    'default' => '',
),

array(
    'name' => 'Color Settings',
    'desc' => '',
    'type' => 'title',
    'id' =>'color_settings'
),
array(
    'name' => 'Menu Background Color',
    'id'   =>  'menu_bg_color',
    'type' => 'colorpicker',
    'default'  => '#ffffff',
    'repeatable' => false,
),
			


	array(
    'name' => 'Menu Text Color',
    'id'   =>  'menu_text_color',
    'type' => 'colorpicker',
    'default'  => '#ffffff',
    'repeatable' => false,
),

array(
    'name' => 'Adavance Settings',
    'desc' => '',
    'type' => 'title',
    'id' =>'color_settings'
),

			array(
    'name'    => 'Fixed Position On Scroll',
    'desc'    => 'If you would like the menu remain in the same place when scrolling, Add Here Element class OR id including "#" OR "." ',
    'id'      => 'fixed_position',
    'type' => 'text_small',
    
),

    array(
    'name'    => 'Choose Effect for  Menu',
    'desc'    => 'This is the efftct that will be used in responsive menu .',
    'id'      => 'awesome_responsive_menu_effect',
    'type'    => 'select',
    'options' => array('1' =>'Effect 1','2' =>'Effect 2','3' =>'Effect 3','4' =>'Effect 4','5' =>'Effect 5'),
    'default' => '1',
),
			
			
        );
    }

    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }

    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init() {
        register_setting( $this->key, $this->key );
    }

    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {
        $this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' )  ,'dashicons-menu');
    }


    public function admin_page_display() {
        ?>

<div class="wrap awesome_responsive_menu_page <?php echo $this->key; ?>">
  <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
  <?php cmb_metabox_form( $this->option_metabox(), $this->key ); ?>
</div>
<?php
    }


    public function option_metabox() {
        return array(
            'id'         => 'option_metabox',
            'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
            'show_names' => true,
            'fields'     => $this->fields,
        );
    }

 
    public function __get( $field ) {

// Allowed fields to retrieve
        if ( in_array( $field, array( 'key', 'fields', 'title', 'options_page' ), true ) ) {
            return $this->{$field};
        }
        if ( 'option_metabox' === $field ) {
            return $this->option_metabox();
        }

        throw new Exception( 'Invalid property: ' . $field );
    }

}

// Get it started
$awesome_responsive_menu_Admin = new awesome_responsive_menu_Admin();
$awesome_responsive_menu_Admin->hooks();


function awesome_responsive_menu_get_option( $key = '' ) {
    global $awesome_responsive_menu_Admin;
    return cmb_get_option( $awesome_responsive_menu_Admin->key, $key );
}




// Initialize the metabox class
add_action( 'init', 'awesome_responsive_menu_meta_boxes', 9999 );
function awesome_responsive_menu_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'metabox/init.php' );
    }
}




// Add Script And Css File
wp_enqueue_script('awesome-responsive-menu-modernizr-jquery', directory . '/assets/js/modernizr.custom.js', array('jquery'), '1.0', true);
wp_enqueue_script('awesome-responsive-menu-jquery', directory . '/assets/js/jquery.dlmenu.js', array('jquery'), '1.0', true);


// Enqueue CSS
function awesome_responsive_menu_stylesheet() {
wp_enqueue_style( 'awesome-responsive-menu-stylesheet', directory . '/assets/css/component.css' );
}
add_action('wp_enqueue_scripts', 'awesome_responsive_menu_stylesheet','30');




add_action('wp_head', 'awesome_responsive_menu', 100);
function awesome_responsive_menu() {
global $awesome_responsive_menu;
echo '<div id="awesome-menu" class="responsive-menuwrapper"><button class="menu-trigger">Open Menu</button>';
wp_nav_menu( array('menu'=>$awesome_responsive_menu,'theme_location' => 'primary','container' => false, 'menu_class' => 'awesome-menu' ));
echo '</div>';
}

function awesome_responsive_menu_script() {
global $menu_button_title,$prependto,$fixed_position,$awesome_responsive_menu_effect;
if(empty($prependto)):   $prependto='body';   endif;
?>
<script>
jQuery(document).ready(function() {
jQuery( '#awesome-menu' ).dlmenu({
	animationClasses : { classin : 'dl-animate-in-<?php echo $awesome_responsive_menu_effect; ?>', classout : 'dl-animate-out-<?php echo $awesome_responsive_menu_effect; ?>' }
	
	});
jQuery( "#awesome-menu" ).prependTo( "<?php  echo $prependto; ?>");
<?php  if( !empty($fixed_position)) { ?> 
var nav = jQuery('<?php echo $fixed_position; ?>');
var pos = nav.offset().top;
jQuery(window).scroll(function () {
var fix = (jQuery(this).scrollTop() > pos) ? true : false;
nav.toggleClass("awesome-responsive-menu-fix", fix);
});

<?php } ?>
});
   </script>
<?php 
}

add_action('wp_head', 'awesome_responsive_menu_script');



// Add Custom css
function awesome_responsive_menu_style() {
global $menu_bg_color,$menu_button_bg_color,$menu_text_color,$menu_breakpoint,$element_hide;
	?>
    
    <style>
.responsive-menuwrapper{
	display:none;
}

@media screen and (max-width: <?php echo $menu_breakpoint; ?>px) {
<?php if(!empty($element_hide)): ?>	
	<?php echo $element_hide; ?> {
		display:none;
}
<?php endif; ?>
	
.responsive-menuwrapper {
		display:block;
	}
}
<?php if(!empty($menu_bg_color)): ?> 
.responsive-menuwrapper button:hover, .responsive-menuwrapper button.dl-active, .responsive-menuwrapper button, .responsive-menuwrapper ul {background:<?php  echo $menu_bg_color; ?>}<?php endif; ?>
<?php if(!empty($menu_text_color)): ?>.responsive-menuwrapper li a{color:<?php echo $menu_text_color; ?>}<?php endif; ?>
</style>
    
    <?php
	
	}

add_action('wp_head', 'awesome_responsive_menu_style');