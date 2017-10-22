<?php 
$prefix = 'jungle_';

global $meta_boxes;

$meta_boxes = array();

// Posts meta box
$meta_boxes[] = array(
	'id' => 'fullposts',
	'title' => 'Post Options',
	'pages' => array( 'post'),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array (
		array(
			'name'		=> 'Add Embed Video',
			'id'		=> $prefix . 'postvideo',
			'desc'		=> 'Add the video url, for example: Vimeo: http://vimeo.com/44955634',
			'type'		=> 'text',
			'size'		=> 70
		),
	)
);
// Portfolio meta box
$meta_boxes[] = array(
	'id' => 'portfolio',
	'title' => 'Portfolio Item Options',
	'pages' => array( 'portfolio' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		// meta fields
		array(
			'name'		=> 'Add video URL',
			'id'		=> $prefix . 'portfolio_addvideourl',
			'desc'		=> 'Add the video url, for example: Vimeo: http://vimeo.com/44955634',
			'type'		=> 'text',
			'size'		=> 70
		),
		array(
			'name'		=> 'Project URL',
			'id'		=> $prefix . 'portfolio_projecturl',
			'desc'		=> 'If this portfolio item has a link to external website, enter its URL here',
			'type'		=> 'text',
			'size'		=> 70
		),
		array(
			'name'		=> 'Client Name',
			'id'		=> $prefix . 'portfolio_clientname',
			'desc'		=> 'Add the client name for this portfolio item',
			'type'		=> 'text',
			'size'		=> 70
		),
		array(
			'name'		=> 'Page Layout',
			'id'		=> $prefix . 'portfolio_itemlayout',
			'desc'		=> 'Choose the page layout for this portfolio item',
			'type'		=> 'select',
			'options'   => array(
				'single' => 'Single Item Layout',
				'half' 	 => 'Half Item Layout'
			),
			'multiple'	=> false,
			'size'		=> 50
		),
		array(
			'name'		=> 'Tagline',
			'id'		=> $prefix . 'portfolio_tagline',
			'desc'		=> 'Add the introduction or tagline about this portfolio item (displayed above the item)',
			'type'		=> 'wysiwyg',
			'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
				'media_buttons' => false,
			),
		),
		array(
			'name'		=> 'Challenge or Objectives',
			'id'		=> $prefix . 'portfolio_challenge',
			'desc'		=> 'If any, put your objectives, challenges or simply extra info about this portfolio item',
			'type'		=> 'wysiwyg',
			'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
				'media_buttons' => false,
			),
		))
);
// Page meta's
$meta_boxes[] = array(
	'id' => 'fullpages',
	'title' => 'Page Item Options',
	'pages' => array( 'page' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array (
		array(
			'name'		=> 'Add Custom Page Title',
			'id'		=> $prefix . 'customtitle',
			'desc'		=> 'Add custom title to this page - different than the default',
			'type'		=> 'text',
			'size'		=> 70
		),
		array(
			'name'		=> 'Hide Title',
			'id'		=> $prefix . 'hidetitle',
			'desc'		=> 'Select "Yes" if you do NOT want to display the title',
			'type'		=> 'select',
			'options' => array(
				'show' => 'No',
				'hide' => 'Yes',
			),
			'std'		=> 'show',
			'multiple' => false,
			),
		array(
			'name'		=> 'Sidebar Position',
			'id'		=> $prefix . 'sidebar',
			'desc'		=> 'If the page supports sidebar, choose whether to be right or left positioned',
			'type'		=> 'select',
			'options' => array(
				'right' => 'Right',
				'left' => 'Left',
			),
			'multiple' => false,
		),
	)
);
//Sliders meta's
$meta_boxes[] = array(
	'id' => 'slideroptions',
	'title' => 'LayerSlider Options',
	'pages' => array( 'page' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array (
		array(
			'name' => 'Enable Slider:',
			'id'   => "{$prefix}sliderenable",
			'type' => 'select',
			'options' => array(
				'enable' => 'Enabled',
				'disable' => 'Disabled',
			),
			'desc'	=> 'Enable or disable the slider on this page',
			'std'  => 'disable',
			'multiple' => false,
		),
		array(
			'name' => 'Slider number:',
			'id'   => "{$prefix}slidernumber",
			'type' => 'number',
			'min'  => 0,
			'step' => 1,
			'desc'	=> 'Add the ID of the slider you want to show on this page',
			'std'  => '0',
		),
		array(
			'name' => 'Add background color',
			'id'   => "{$prefix}slidercolor",
			'type' => 'color',
			'desc' => 'Change the background color of the chosen slider for this page',
			'std'  => '#fff',
		),		
	)
);
function jungle_register_meta_boxes()
{
	global $meta_boxes;

	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
add_action( 'admin_init', 'jungle_register_meta_boxes' );
?>