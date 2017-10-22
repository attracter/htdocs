<?php
/**
 * Template Name: Full-width, no sidebar
 * Description: A full-width template with no sidebar
 *
 * @package WordPress
 * @subpackage Jungle WordPress
 */
?>
<?php get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>

	</div><!-- End of sixteen -->
</div><!-- End of container -->
                
<?php get_footer(); ?>