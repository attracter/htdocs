<?php
/**
 * @package WordPress
 * @subpackage Jungle WordPress
 */
?>
<?php get_header(); ?>

<div class="error-wrap">
	<div class="page-title">
		<div class="container">
			<div class="sixteen columns">
				<h1>Error 404</h1>
			</div>
		</div>
	</div><!-- End of page title-->

<div class="container">
	<div class="sixteen columns">
		<div class="row">

			<div class="centered-content">
				<?php if(ot_get_option('error_text') != '') { ?>
					<?php echo ot_get_option('error_text'); ?>
				<?php } else { ?>
					<h2>Are you lost in the Jungle?</h2>
					<p>The page you've requested can not be displayed. It appears you've missed your intended destination, either through a bad or outdated link, or a typo in the page you were hoping to reach.</p>
				<?php } ?>
			</div><!-- End of centered content-->

			<div class="not-found-help">
				<?php if(ot_get_option('error_image') != '') { ?>
					<img src="<?php echo ot_get_option('error_image'); ?>" alt="<?php the_title(); ?>" /> 
				<?php } else { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/ui/404-illustration.png" />
				<?php } ?>
			</div><!-- End of 404 help-->

			<div class="error-search">
				<?php get_template_part('searchform'); ?>
			</div><!-- End of error search-->
		
		</div><!-- End of row-->
	</div> <!-- End of sixteen -->
</div> <!-- End of container -->

<?php get_footer(); ?>