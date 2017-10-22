<?php
/**
 * @package WordPress
 * @subpackage Jungle WordPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>> 
	
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
		
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if gte IE 9 ]><html class="no-js ie9" lang="en"> <![endif]-->
	
<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); ?></title>
	

<meta name="keywords" content="<?php echo ot_get_option('site_keywords'); ?>">

<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS -->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

<!-- Favicons -->
<?php if (ot_get_option('favicon') != '') { ?><link rel="shortcut icon" href="<?php echo ot_get_option('favicon'); ?>"><?php }?>
<?php if (ot_get_option('apple_favicon') != '') { ?><link rel="apple-touch-icon" href="<?php echo ot_get_option('apple_favicon'); ?>"><?php }?>
<?php if (ot_get_option('apple_favicon_72') != '') { ?><link rel="apple-touch-icon" sizes="72x72" href="<?php echo ot_get_option('apple_icon_72'); ?>"><?php }?>
<?php if (ot_get_option('apple_favicon_114') != '') { ?><link rel="apple-touch-icon" sizes="114x114" href="<?php echo ot_get_option('apple_icon_114'); ?>"><?php }?>

<?php wp_head(); ?>   
<meta name="google-site-verification" content="sgKoLiwgjmYoAdQfxNyerf2KVcXbRaHu-qDq4bblDss" />   
</head>

<body <?php body_class(); ?>><!-- the Body  -->

<?php if(ot_get_option('boxed') == 'boxy') { ?>
	<div class="container inner">
<?php } ?>

<header class="header-border-light">
	<div class="container">
		<div class="sixteen columns header-border">
			
			<div class="logo">
				<?php if(ot_get_option('logo') != '') { ?>
				<a href="<?php echo home_url(); ?>"><img src="<?php echo ot_get_option('logo'); ?>" alt="<?php echo bloginfo('blog_name'); ?>" /></a>
				<?php } else { ?>
				<a href="<?php echo home_url(); ?>" title="<?php echo bloginfo('blog_name'); ?>"><?php echo bloginfo('name'); ?></a> 
				<?php } ?>
			</div><!-- End of logo -->
		
			<nav>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- End of menu -->
		
		</div><!-- End of sixteen -->
	</div><!-- End of container -->
</header><!-- End of header -->

<?php $pagetitle = rwmb_meta('jungle_hidetitle'); ?>
<?php $customtitle = rwmb_meta('jungle_customtitle'); ?>

<?php if(is_front_page() && is_single() || !is_home()) { ?>
<?php $sliderid = rwmb_meta( 'jungle_slidernumber'); ?>
<?php $sliderenabled = rwmb_meta('jungle_sliderenable'); ?>
<?php $slidercolor = rwmb_meta('jungle_slidercolor'); ?>
<?php if($sliderenabled == 'enable') { ?>
<div class="slider-band" <?php if($slidercolor != '') { echo 'style="background-color: '. $slidercolor .'; "';} ?>>
	<?php echo do_shortcode('[layerslider id="'.$sliderid.'"]'); ?>
</div><!-- End of LayerSlider -->
<?php } ?>
<?php } ?>

<?php if(is_page() && !is_front_page() && $pagetitle != 'hide') { ?>
	<div class="page-title">
		<div class="container">
			<div class="sixteen columns">
				<?php if($customtitle != '') { ?>
				<h1><?php echo $customtitle; ?></h1>
					<?php } else { ?>
				<h1><?php the_title(); ?></h1>
				<?php } ?>
			</div><!-- End of sixteen -->
		</div><!-- End of container -->
	</div><!-- End of page title -->
<?php } ?>

<?php if(is_home() && !is_front_page() || is_single() && !is_singular('portfolio')) { ?>
	<div class="page-title">
		<div class="container">
			<div class="sixteen columns">
				<?php if(ot_get_option('blog_title') != '') { ?>
				<h1><?php echo ot_get_option('blog_title'); ?></h1>
					<?php } else { ?>
				<h1><?php the_title(); ?></h1>
				<?php } ?>
			</div>
		</div><!-- End of container -->
	</div><!-- End of page title -->
<?php } ?>

<?php if(!is_search() && !is_404() && !is_author()) { ?>
<div class="container content">
	<div class="sixteen columns">
<?php } else { } ?>