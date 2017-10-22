<?php
/**
 * @package WordPress
 * @subpackage Jungle WordPress
 */
?>

<?php get_header(); ?>

</div></div>

<div class="page-title">
	<div class="container">
	  <div class="sixteen columns">
		<h1><?php printf( __( 'Search Results for: %s', 'mb' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	  </div>
	</div>
</div><!-- End of page title -->

<div class="container content">
	<div class="sixteen columns">

		<?php if ( have_posts() ) : ?>
		   
			<?php
			/* Run the loop for the search to output the results. */
			get_template_part( 'index', 'page' );
			?>
		   
		<?php else : ?>
		
		<div class="one-third">
		  <h2 class="entry-title"><?php _e( 'Nothing Found', 'mb' ); ?></h2>
		  <div class="entry-content">
			  <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
			  <?php get_search_form(); ?>
		  </div><!-- End of entry-content -->
		</div><!-- End of one third -->
		
		<?php endif; ?>


</div><!-- End of sixteen columns -->
</div><!-- End of container -->

<?php get_footer(); ?>