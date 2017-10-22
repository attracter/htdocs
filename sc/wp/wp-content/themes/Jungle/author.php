<?php
/**
 * @package WordPress
 * @subpackage Jungle WordPress
 */
?>

<?php get_header(); ?>

	<div class="page-title">
		<div class="container">
			<div class="sixteen columns">
				<?php the_post(); ?>
				<h1><?php printf( __( 'Author Archives for: <span class="vcard">%s</span>', 'Jungle' ), "<a class='author' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" ); ?></h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="sixteen columns">
			<?php rewind_posts(); ?>
			<?php get_template_part( 'index', 'author' ); ?>
		</div>
	</div>
	</div><!-- End of sixteen -->
</div><!-- End of container -->

<?php get_footer(); ?>