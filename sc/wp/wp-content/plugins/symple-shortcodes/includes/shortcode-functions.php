<?php
/**
 * This file has all the main shortcode functions
 * @package Symple Shortcodes Plugin
 * @since 1.1
 * @author AJ Clarke : http://sympleplorer.com
 * @copyright Copyright (c) 2012, AJ Clarke
 * @link http://sympleplorer.com
 * @License: GNU General Public License version 3.0
 * @License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/*
 * Alerts
 */
if(!function_exists('symple_alert_shortcode')) {
	function symple_alert_shortcode($atts, $content = null) {
		extract( shortcode_atts( array(
			'type' => ''
		  ), $atts ) );
		$html = '';
		$html .= '<div class="alert '.$type.'">';
		$html .= '<span>'.do_shortcode($content).'</span>';
		$html .= '<div class="close"><a href="#">x</a></div>';
		$html .= '</div>'; // End of Alert

		return $html;
	}
	add_shortcode('alert', 'symple_alert_shortcode');
}

/*
 * Content box
 */
if( !function_exists('symple_box_shortcode') ) {
  function symple_box_shortcode($atts, $content = null) {
    $html = '';
    $html .= '<section class="row">';
    $html .= do_shortcode($content);
    $html .= '</section>';

    return $html;
  }
add_shortcode('box', 'symple_box_shortcode');
}

/*
 * Content boxes
 */
if( !function_exists('symple_boxes_shortcode') ) {
  function symple_boxes_shortcode($atts, $content = null) {
  	$html = '';
    if(isset($atts['last']) && ($atts['last'] == 'yes')):
    $html .= '<article class="one-third service-post-preview last">';
    else:
    $html .= '<article class="one-third service-post-preview">';
    endif;

    if($atts['image'] || $atts['title']):
    if($atts['image']):
    $html .= '<img src="'.$atts['image'].'" alt="">';
    endif;
    if($atts['title']):
    $html .= '<h3>'.$atts['title'].'</h3>';
    endif;
    endif;

    $html .= '<p>'.do_shortcode($content).'</p>';
    
    $html .= '</article>';

    return $html;
  }
add_shortcode('boxes', 'symple_boxes_shortcode');
}

/*
* Title
*/
if(!function_exists('symple_title_shortcode')) {
	function symple_title_shortcode($atts, $content) {
		$title_content ='';
		$title_content .= '<div class="title"><h2>';
		$title_content .= do_shortcode($content);
		$title_content .= '</h2></div>';
		return $title_content;
	}
	add_shortcode('title', 'symple_title_shortcode');
}

/*
* Recent Works 
*/
if( !function_exists('symple_works_shortcode') ) {
function symple_works_shortcode($atts, $content = null) {
			extract(shortcode_atts( array(
			'numberofworks' => '8',
			'categories' => '',
			'title' => ''
		), $atts));
		$args = array(
					'post_type' => 'portfolio',
					'paged' => -1,
					'posts_per_page' => $numberofworks
				);
				$works = new WP_Query($args);
	$html = '';
	$html .= '<div class="row shortcode carousel" data-transition="slide">';
				$counter = 1;
				while($works->have_posts()): $works->the_post();
				$post->ID = get_the_ID();
				$realsize = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'full'); 
				$lightbox_img = $realsize[0];
				$video = rwmb_meta('jungle_portfolio_addvideourl');
				if( $counter % 3 == 0 ) {
			
	$html .= '<div class="one-third work-post-preview last">';
				} else {
	$html .= '<div class="one-third work-post-preview">';
				}	
	if (has_post_thumbnail() ) {
	$html .= '<div class="image">';
	$html .=  	'<nav class="hover-card">';
	$html .= 	 	'<ul class="thumb-options">';
	$html .=		 	'<li class="thumb link"><a href="'.get_permalink($post->ID).'">Permalink</a></li>';
	if($video == true) { 
	$html .=		 	'<li class="thumb-zoom"><a href="'.$video.'" data-rel="prettyPhoto">Zoom</a></li>';
	} else {
	$html .=		 	'<li class="thumb-zoom"><a href="'.$lightbox_img.'" data-rel="prettyPhoto">Zoom</a></li>';
	}
	$html .=		 '</ul>';
	$html .=	'</nav>';
	$html .=	'<a href="'.get_permalink($post->ID).'">';
	$html .= get_the_post_thumbnail($post->ID, 'portfolio_three');
	$html .= '</a>';
	$html .= '</div>';
		} else { }
	if($categories || $title) {
	$html .= '<div class="work-post-meta">';
	if($title == 'yes') {
	$html .= '<h3>';
	$html .= '<a href="'.get_permalink().'">';
	$html .= get_the_title();
	$html .= '</a>'; 
	$html .= '</h3>';
	} else { }
	if($categories == 'yes') {
	$html .= '<span class="work-post-categories">';
	$html .= get_the_term_list( $post->ID, 'portfolio_categories', '', ', ', '' );
	$html .= '</span>';
	} else { }
	$html .= '</div>';
	} else { } // end of work-post-meta
	$html .= '</div>'; //end of third
	$counter++;	endwhile;
	$html .= '</div>'; //end of row carousel
	return $html;
}
add_shortcode('works', 'symple_works_shortcode');
}

/* 
* From the Blog with category option
*/

if (!function_exists('symple_blog_shortcode')) {

	function symple_blog_shortcode($atts, $content) {
		$latest_posts = '';
		$latest_posts .= '<div class="row shortcode carousel" data-transition="slide">';
		extract(shortcode_atts( array(
			'image' => '',
			'title' => '',
			'date' => '',
			'numberofposts' => '',
			'fromcategory' => '',
			'comments' => '',
			'column' => '',
			'excerpt' => '',
			'secondlast' => ''
			), $atts));
		$lpq = new WP_Query('&category_name='.$fromcategory.'&posts_per_page='.$numberofposts);
		$postvideo = rwmb_meta('jungle_postvideo');
		if(esc_attr($excerpt)) {
			$latest_excerpt = esc_attr($excerpt);
		} else {
			$latest_excerpt = "15";
		}
		$numberofposts = 1;
		while($lpq->have_posts()): $lpq->the_post();
		$post->ID = get_the_ID();
		if($secondlast == 'yes' && $numberofposts % 2 == 0) { 
		$latest_posts .= '<div class="'.$column.' blog-post-preview last">';
		}
		// else {
		// $latest_posts .= '<div class="'.$column.' blog-post-preview">';
		// } 
		elseif($secondlast === 'no' || $secondlast === '' && $numberofposts % 3 == 0) { 
		$latest_posts .= '<div class="'.$column.' blog-post-preview last">';
		}
		else {
		$latest_posts .= '<div class="'.$column.' blog-post-preview">';
		} 
		$latest_posts .= '<header class="image">';
		if (has_post_thumbnail() && $image == 'yes') {
		$latest_posts .= get_the_post_thumbnail($post->ID, 'portfolio_three');
		} elseif('' == get_the_post_thumbnail() && rwmb_meta('jungle_postvideo') != '') { 
		$videos = rwmb_meta('jungle_postvideo');
		if ( strpos($videos,'youtube') ) {
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $videos, $matches);
			$latest_posts.= '<iframe src="http://www.youtube.com/embed/'. $matches[1] .'?version=3&rel=1&fs=1&showsearch=0&showinfo=1&iv_load_policy=1&wmode=transparent" style="border: none"></iframe>';
		} else {
			preg_match('/http:\/\/vimeo.com\/(\d+)$/', $videos, $matches);
			$latest_posts.= '<iframe src="http://player.vimeo.com/video/'. $matches[1] .'?title=0&amp;byline=0&amp;color=8CBD2F&amp;autoplay=0" style="border: none"></iframe>';
		}
		}
		else {
		$latest_posts .= ''; 
		}
		$latest_posts .= '</header>';// End of header-->
		$latest_posts .= '<section class="blog-preview-content features">';
		if($title == 'yes') {
		$latest_posts .= '<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
		} else { }
		if($date == 'yes') {
		$latest_posts .= '<span class="blog-post-preview-meta">'.get_the_date('j F, Y', $post->ID).'</span>'; } else { }
		if($comments == 'yes') {
		$latest_posts .= '<span class="blog-post-preview-meta-comment">'.get_comments_number($post->ID).' Comments</span>'; } else { }
		if($excerpt == 'yes') {
		$latest_posts .= '<p>'.limit_excerpt_length(get_the_excerpt(), '25').'</p>';
		$latest_posts .= '<a  href="'.get_permalink().'" class="read-more">Learn more &rarr;</a>';
		} else { }
		$latest_posts .= '</section>'; //End of section
		$latest_posts .= '</div>';// End of one-half-->
		$numberofposts++; 
		endwhile;$latest_posts .= '</div>';
		return $latest_posts;
		}
	add_shortcode('latest_blog', 'symple_blog_shortcode');
}

/*
 * Notifications
 */

if( !function_exists('symple_notification_box_shortcode') ) { 
	function symple_notification_box_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => '',
			'text_align' => 'left',
			'shadow' => 'yes'
		  ), $atts ) );
		  $notification_box = '';
		  if($shadow != '' && $shadow != null && $shadow == 'yes') {
		  $notification_box .= '<div class="drop-shadow warp-shadow spacing-bottom">';
		  $notification_box .= '<div class="notification notification-centered" style="text-align:'. $text_align .'; background-color:' . $color . ';">';
		  } else {
		  $notification_box .= '<div class="row notification notification-centered spacing-bottom" style="text-align:'. $text_align .'; background-color:' . $color . ';">';
		  }
		  $notification_box .= do_shortcode($content);
		  $notification_box .='</div>';
		  if($shadow != '' && $shadow != null && $shadow == 'yes') {
		  $notification_box .= '</div>'; }
		  return $notification_box;
	}
	add_shortcode('notification', 'symple_notification_box_shortcode');
}

if(!function_exists('symple_notification_content_shortcode')) {
	function symple_notification_content_shortcode($atts, $content = null) {
		  $notification_content = '';
		  $notification_content .= '<div class="notification-content">';
		  $notification_content .= do_shortcode($content);
		  $notification_content .='</div>';
		  return $notification_content;
	}
	add_shortcode('notification_content', 'symple_notification_content_shortcode');
}

/*
 * Clear Floats
 * @since v1.0
 */
if( !function_exists('symple_clear_floats_shortcode') ) {
	function symple_clear_floats_shortcode() {
	   return '<div class="symple-clear-floats"></div>';
	}
	add_shortcode( 'clear', 'symple_clear_floats_shortcode' );
}

/*
 * Spacing
 * @since v1.0
 */
if( !function_exists('symple_spacing_shortcode') ) {
	function symple_spacing_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'size' => '20px',
		  ),
		  $atts ) );
	 return '<div style="height: '. $size .'"></div>';
	}
	add_shortcode( 'spacing', 'symple_spacing_shortcode' );
}

/*
 * Fix Shortcodes
 * @since v1.0
 */
if( !function_exists('symple_fix_shortcodes') ) {
	function symple_fix_shortcodes($content){   
		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);
		$content = strtr($content, $array);
		return $content;
	}
	add_filter('the_content', 'symple_fix_shortcodes');
}


/**
* Social Icons
* @since 1.0
*/
if( !function_exists('symple_social_shortcode') ) {
	function symple_social_shortcode( $atts ){   
		extract( shortcode_atts( array(
			'icon' => 'twitter',
			'url' => 'http://www.twitter.com',
			'title' => 'Follow Us',
			'target' => 'self',
			'rel' => '',
			'border_radius' => ''
		), $atts ) );
		
		return '<a href="' . $url . '" class="'.$icon.' symple-social-icon" target="_'.$target.'" title="'. $title .'" rel="'. $rel .'"
></a>';
	}
	add_shortcode('social', 'symple_social_shortcode');
}

/**
* Highlights
* @since 1.0
*/
if ( !function_exists( 'symple_highlight_shortcode' ) ) {
	function symple_highlight_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'yellow',
		  ),
		  $atts ) );
		  return '<span style="background:'.$color.'">' . do_shortcode( $content ) . '</span>';
	
	}
	add_shortcode('highlight', 'symple_highlight_shortcode');
}


/*
 * Buttons
 * @since v1.0
 */
if( !function_exists('symple_button_shortcode') ) {
	function symple_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'blue',
			'url' => 'http://www.themeseagle.com',
			'title' => 'Visit Site',
			'target' => 'self',
			'icon' => '',
			'arrow' => '',
			'rel' => '',
			'border_radius' => ''
		), $atts ) );
		
		$border_radius_style = ( $border_radius ) ? 'style="border-radius:'. $border_radius .'"' : NULL;
		if($icon != '') {
		return '<a href="' . $url . '" class="btn btn-has-icon btn-standard btn-' . $color . ' arrow-'.$arrow.'" target="_'.$target.'" title="'. $title .'" '. $border_radius_style .' rel="'.$rel.'"><i class="'.$icon.'"></i><span class="symple-button-inner" '.$border_radius_style.'>' . $content . '</span></a>';
	} else {
		return '<a href="' . $url . '" class="btn btn-standard btn-' . $color . ' arrow-'.$arrow.'" target="_'.$target.'" title="'. $title .'" '. $border_radius_style .' rel="'.$rel.'"><span class="symple-button-inner" '.$border_radius_style.'>' . $content . '</span></a>';
	}
	}
	add_shortcode('button', 'symple_button_shortcode');
}

/* Testimonial Box */
if(!function_exists('symple_testimonial_box_shortcode')) {
	function symple_testimonial_box_shortcode($atts, $content = null) {
		extract(shortcode_atts(array(
			'effect' => ''
			), $atts ) );
		$testimonial_box = '';
		$testimonial_box .= '<div class="row shortcode carousel" data-transition="'.$effect.'" data-autoplay data-interval="5000">';
		$testimonial_box .= do_shortcode($content);
		$testimonial_box .= '</div>';
		return $testimonial_box;
	}
	add_shortcode('testimonial_box', 'symple_testimonial_box_shortcode');
}
/*
 * Testimonial
 * @since v1.0
 *
 */
if( !function_exists('symple_testimonial_shortcode') ) { 
	function symple_testimonial_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'by' => '',
			'photo' => '',
			'link' => '',
			'description' => ''
		  ), $atts ) );
		$testimonial_content = '';
		$testimonial_content .= '<div class="testimonials-widget"><blockquote>';
		$testimonial_content .= $content;
		$testimonial_content .= '</blockquote>';
		$testimonial_content .= '<img src="'.$photo.'" alt="'.$by.'">';
		$testimonial_content .= '<span class="source-name">';
		$testimonial_content .= $by . '</span><br />';
	    $testimonial_content .= '<span class="source-meta"><a href="'.$link.'">';
	    $testimonial_content .= $description . '</a></span>';
	    $testimonial_content .= '</div>';
		return $testimonial_content;
	}
	add_shortcode( 'testimonial', 'symple_testimonial_shortcode' );
}

/*
 * Columns
 * @since v1.0
 *
 */
/* One Third */
if( !function_exists('symple_one_third_shortcode') ) {
	function symple_one_third_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'position' => ''
		  ), $atts ) );
		  return '<div class="one-third '. $position .'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_third', 'symple_one_third_shortcode');
}

/* One Fourth */
if( !function_exists('symple_one_fourth_shortcode') ) {
	function symple_one_fourth_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'position' => ''
		  ), $atts ) );
		  return '<div class="one-fourth '. $position .'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fourth', 'symple_one_fourth_shortcode');
}

/* One Half */
if( !function_exists('symple_one_half_shortcode') ) {
	function symple_one_half_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'position' =>''
		  ), $atts ) );
		  return '<div class="one-half '.$position.'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_half', 'symple_one_half_shortcode');
}

/* Two Thirds */
if( !function_exists('symple_two_third_shortcode') ) {
	function symple_two_third_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'position' =>''
		  ), $atts ) );
		  return '<div class="two-third '.$position.'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_third', 'symple_two_third_shortcode');
}

/* Three Fourth */
if( !function_exists('symple_three_fourth_shortcode') ) {
	function symple_three_fourth_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'position' =>''
		  ), $atts ) );
		  return '<div class="three-fourth '.$position.'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('three_fourth', 'symple_three_fourth_shortcode');
}

/* Three Fifth */
if( !function_exists('symple_three_fifth_shortcode') ) {
	function symple_three_fifth_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'position' =>''
		  ), $atts ) );
		  return '<div class="three-fifth '.$position.'">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('three_fifth', 'symple_three_fifth_shortcode');
}

/*
 * Toggle
 * @since v1.0
 */
if( !function_exists('symple_toggle_shortcode') ) {
	function symple_toggle_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array( 'title' => 'Toggle Title' ), $atts ) );
		 
		// Enque scripts
		wp_enqueue_script('symple_toggle');
		
		// Display the Toggle
		return '<div class="toggle"><h3 class="toggle-trigger">'. $title .'</h3><div class="toggle-container">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('toggle', 'symple_toggle_shortcode');
}

/*
 * Accordion
 * @since v1.0
 *
 */

// Main
if( !function_exists('symple_accordion_main_shortcode') ) {
	function symple_accordion_main_shortcode( $atts, $content = null  ) {
		
		// Enque scripts
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('symple_accordion');
		
		// Display the accordion	
		return '<div class="symple-accordion">' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'symple_accordion', 'symple_accordion_main_shortcode' );
}


// Section
if( !function_exists('symple_accordion_section_shortcode') ) {
	function symple_accordion_section_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
		  'title' => 'Title',
		), $atts ) );
		  
	   return '<h3 class="symple-accordion-trigger"><a href="#">'. $title .'</a></h3><div>' . do_shortcode($content) . '</div>';
	}
	
	add_shortcode( 'symple_accordion_section', 'symple_accordion_section_shortcode' );
}

/*
 * Horizontal Tabs
 * @since v1.0
 *
 */
if (!function_exists('symple_tabgroup_shortcode')) {
	function symple_tabgroup_shortcode( $atts, $content = null ) {
		
		//Enque scripts
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('symple_tabs');
		
		// Display Tabs
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
		    $output .= '<div id="symple-tab-'. rand(1, 100) .'" class="symple-tabs">';
			$output .= '<ul class="ui-tabs-nav symple-clearfix">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#symple-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	add_shortcode( 'tabgroup', 'symple_tabgroup_shortcode' );
}
if (!function_exists('symple_tab_shortcode')) {
	function symple_tab_shortcode( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab', 'icons' => 'icons');
		extract( shortcode_atts( $defaults, $atts ) );
		return '<div id="symple-tab-'. sanitize_title( $title ) .'" class="tab-content">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'tab', 'symple_tab_shortcode' );
}

/*
 * Vertical tabs
 *
 */
if(!function_exists('symple_vertical_tabs_shortcode')) {
	function symple_vertical_tabs_shortcode($atts, $content = null) {
		//Enque scripts only if activated
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('symple_tabs');

		//Let's display the vertical tabs
	    $defaults = array();
	    extract( shortcode_atts( $defaults, $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		extract( shortcode_atts( $tab_titles, $atts ) );
		$icons = array('icons' => 'funnel');
		extract( shortcode_atts( $icons, $atts ) );
		// 		extract( shortcode_atts( array(
		// 	'icons' => 'funnel'
		// ), $atts ) );
		global $icons;
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ) {
		    $output .= '<div id="tabs-'. rand(1, 100) .'" class="ui-tabs-vertical">';
			$output .= '<ul class="ui-tabs-nav">';
			foreach($tab_titles as $tab) {
				$output .= '<li><a href="#symple-tab-'. sanitize_title( $tab[0] ) .'"><i class="icon-'. $icons[1] . '">'. $icons .'</i><span>' . $tab[0] . '</span></a></li>';
			}
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;	
	}
	add_shortcode( 'vertical_tabs', 'symple_vertical_tabs_shortcode' );
}

/*
 * Pricing Table
 * @since v1.0
 *
 */
 
/*main*/
if( !function_exists('symple_pricing_table_shortcode') ) {
	function symple_pricing_table_shortcode( $atts, $content = null  ) {
	   return '<div class="plans">' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'symple_pricing_table', 'symple_pricing_table_shortcode' );
}

/*section*/
if( !function_exists('symple_pricing_shortcode') ) {
	function symple_pricing_shortcode( $atts, $content = null  ) {
		
		extract( shortcode_atts( array(
			'size' => 'one-half',
			'position' => '',
			'featured' => 'no',
			'plan' => 'Basic',
			'cost' => '$20',
			'decimal' => '',
			'per' => '',
			'button_url' => '',
			'button_text' => 'Purchase',
			'button_target' => 'self',
			'button_rel' => 'nofollow',
			'button_color' => '',
			'button_border_radius' => ''
		), $atts ) );
		
		//set variables
		$featured_pricing = ( $featured == 'yes' ) ? 'featured' : NULL;
		$border_radius_style = ( $button_border_radius ) ? 'style="border-radius:'. $button_border_radius .'"' : NULL;
		
		//start content  
		$pricing_content ='';
		$pricing_content .= '<div class="plan symple-'. $size .' '. $featured_pricing .' symple-column-'. $position. '">';
			$pricing_content .= '<div class="plan-heading">';
				$pricing_content .= '<h2>'. $plan. '</h2>';
				$pricing_content .= '<div class="plan-pricing">'. $cost .'<span class="decimals">'.$decimal.'</span><span class="plan-period">'. $per .'</span></div>';
			$pricing_content .= '</div>';
		    $pricing_content .= ''. $content. '';
			if( $button_url ) {
				$pricing_content .= '<div class="plan-footer"><a style="background:'.$button_color.'" href="'. $button_url .'" class="sign-up-btn" target="_'. $button_target .'" rel="'. $button_rel .'" '. $border_radius_style .'><span class="symple-button-inner" '. $border_radius_style .'>'. $button_text .'</a></div>';
			}
		$pricing_content .= '</div>';  
		return $pricing_content;
	}
	
	add_shortcode( 'symple_pricing', 'symple_pricing_shortcode' );
}

/************************
 *
 * Version 1.1 Additions
 *
*************************/

/*
 * Heading
 * @since v1.1
 */
if( !function_exists('symple_heading_shortcode') ) {
	function symple_heading_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'title' => 'Sample Heading',
			'type' => 'h2',
			'margin_top' => '',
			'margin_bottom' => '',
			'text_align' => 'center'
		  ),
		  $atts ) );
		  
		$style_attr = '';
		if ( $margin_top && $margin_bottom ) {  
			$style_attr = 'style="margin-top: '. $margin_top .';margin-bottom: '. $margin_bottom .';"';
		} elseif( $margin_bottom ) {
			$style_attr = 'style="margin-bottom: '. $margin_bottom .';"';
		} elseif ( $margin_top ) {
			$style_attr = 'style="margin-top: '. $margin_top .';"';
		} else {
			$style_attr = NULL;
		}
	 	return '<'.$type.' class="symple-heading text-align-'. $text_align .'" '.$style_attr.'><span>'. $title .'</span></'.$type.'>';
	}
	add_shortcode( 'symple_heading', 'symple_heading_shortcode' );
}


/*
 * Google Maps
 * @since v1.1
 */
if (! function_exists( 'symple_shortcode_googlemaps' ) ) :
	function symple_shortcode_googlemaps($atts, $content = null) {
		
		extract(shortcode_atts(array(
				"title" => '',
				"location" => '',
				"width" => '', //leave width blank for responsive designs
				"height" => '300',
				"zoom" => 8,
				"align" => '',
		), $atts));
		
		// load scripts
		wp_enqueue_script('symple_googlemap');
		wp_enqueue_script('symple_googlemap_api');
		
		
		$output = '<div id="map_canvas_'.rand(1, 100).'" class="googlemap" style="height:'.$height.'px;width:100%">';
			$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
			$output .= '<input class="location" type="hidden" value="'.$location.'" />';
			$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
			$output .= '<div class="map_canvas"></div>';
		$output .= '</div>';
		
		return $output;
	   
	}
	add_shortcode("googlemap", "symple_shortcode_googlemaps");
endif;

/*
 * Divider
 * @since v1.1
 */
if( !function_exists('symple_divider_shortcode') ) {
	function symple_divider_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'style' => 'solid',
			'margin_top' => '20px',
			'margin_bottom' => '20px',
		  ),
		  $atts ) );
		$style_attr = '';
		if ( $margin_top && $margin_bottom ) {  
			$style_attr = 'style="margin-top: '. $margin_top .';margin-bottom: '. $margin_bottom .';"';
		} elseif( $margin_bottom ) {
			$style_attr = 'style="margin-bottom: '. $margin_bottom .';"';
		} elseif ( $margin_top ) {
			$style_attr = 'style="margin-top: '. $margin_top .';"';
		} else {
			$style_attr = NULL;
		}
	 return '<hr class="symple-divider '. $style .'" '.$style_attr.' />';
	}
	add_shortcode( 'divider', 'symple_divider_shortcode' );
}

/* Carousel */
if( !function_exists('symple_carousel') ) {
  function symple_carousel($atts, $content = null) {
	extract(shortcode_atts(array(
		'type'	 	=> ''
	), $atts));
    $html = '';
    $html .= '<div class="row shortcode carousel" data-transition="'.$type.'">';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;
  }
add_shortcode('carousel', 'symple_carousel');
}
/*
 * Team Member Shortcode
 */
if( !function_exists('symple_team_member') ) {
	function symple_team_member( $atts , $content = null ){
		extract(shortcode_atts(array(
			'name'	 	=> '',
			'position'	=> '',
			'image'		=> '',
			'tooltips' 	=> '',
			'twitter'	=> '',
			'facebook'	=> '',
			'linkedin'	=> '',
			'vimeo' 	=> '',
			'dribbble'  => ''
	    ), $atts));
	    $html = '';
		$html .= '<div class="team-member-preview">';
		$html .= '<img src="'.$image.'">';
		$html .= '<div class="team-member-meta">';
		$html .= '<h3>'.$name.'</h3>';
		$html .= '<div class="team-member-role">'.$position.'</div>';
		$html .= '<p>'.do_shortcode($content).'</p>';
		$html .= '<nav class="social-links">';
		$html .= '<ul>';
		if ($twitter != '' && $twitter != null && $tooltips == 'yes') {
			$html .= '<li><a data-rel="tooltip" target="_blank" title="twitter" class="twitter-icon" href="'.$twitter.'">"'.$twitter.'"</a></li>';
		} elseif($twitter != '') {
			$html .= '<li><a class="twitter-icon" href="'.$twitter.'">"'.$twitter.'"</a></li>';
		}
		if ($facebook != '' && $facebook != null && $tooltips == 'yes') {
			$html .= '<li><a data-rel="tooltip" target="_blank" title="facebook" class="facebook-icon" href="'.$facebook.'"></a></li>';
		} elseif($facebook != '') {
			$html .= '<li><a class="facebook-icon" href="'.$facebook.'"></a></li>';
		}
		if ($linkedin != '' && $linkedin != null && $tooltips == 'yes') {
			$html .= '<li><a data-rel="tooltip" target="_blank" title="linkedin" class="linkedin-icon" href="'.$linkedin.'"></a></li>';
		} elseif($linkedin != '') {
			$html .= '<li><a class="linkedin-icon" href="'.$linkedin.'"></a></li>';
		}
		if ($vimeo != '' && $vimeo != null && $tooltips == 'yes') {
			$html .= '<li><a data-rel="tooltip" target="_blank" title="vimeo" class="vimeo-icon" href="'.$vimeo.'"></a></li>';
		} elseif($vimeo != '') {
			$html .= '<li><a class="vimeo-icon" href="'.$vimeo.'"></a></li>';
		}
		if ($dribbble != '' && $dribbble != null && $tooltips == 'yes') {
			$html .= '<li><a data-rel="tooltip" target="_blank" title="dribbble" class="dribbble-icon" href="'.$dribbble.'"></a></li>';
		} elseif($dribbble != '') {
			$html .= '<li><a class="dribbble-icon" href="'.$dribbble.'"></a></li>';			
		}
		$html .= '</ul>';
		$html .= '</nav>';
		$html .= '</div>'; // End of Team Member Meta
		$html .= '</div>'; // End of Team Member Preview

		return $html;

	}
	add_shortcode( 'team_member' , 'symple_team_member' );
}
/*
 * Skills
 */
if (!function_exists('symple_skills_shortcode')) {
	function symple_skills_shortcode( $atts, $content = '' ) {
		extract(shortcode_atts(array(
			'name' => 'Project Management',
			'percent' => '100%'
				),$atts));
		$html = '<div class="skills"><ul><li>';
		$html .= '<h5>'.$name.'</h5>';
		$html .= '<div class="skillbar">';
		$html .= '<div class="countbar" style="width:' . intval( $percent ) . '%;"></div>';
		$html .= '</div>'; // End of Skillbar
		$html .= '</li></ul></div>';
		
		return $html;
		
	}
	add_shortcode( 'skills', 'symple_skills_shortcode' );
}