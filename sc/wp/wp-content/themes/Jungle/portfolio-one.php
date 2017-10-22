<?php
/*
Template Name: Portfolio - One Column
*/
?>
<?php get_header(); ?>

<?php 
$loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => ot_get_option('portfolio_items_number', '4', '', '', ''), 'paged' => $paged));
$count = 1; 
?>
<div class="row">
	<div class="title">
		<?php the_title('<h2>', '</h2>'); ?>
	</div>
</div>
<?php while ($loop->have_posts()) : $loop->the_post(); ?>
<?php $projecturl = rwmb_meta( 'jungle_portfolio_projecturl'); ?>
<div class="portfolio-col-1 spacing-bottom">
	<div class="one-half">
		<?php echo the_post_thumbnail('portfolio_one_two', array('class' => 'scale-with-grid' )); ?>
	</div>
	<div class="one-half last">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="work-post-categories">
		<?php echo get_the_term_list( $post->ID, 'portfolio_categories', '', ', ', '' ); ?>
	</div>
	<?php echo limit_excerpt_length(get_the_excerpt(), '90'); ?>
	<ul class="portfolio-item-nav">
		<li>
			<a href="<?php the_permalink(); ?>" class="btn btn-green btn-standard"><?php _e('Continue', 'Jungle'); ?></a>
		</li>
			<?php if($projecturl != '') { ?>
		<li>
			<a href="<?php echo $projecturl; ?>" class="btn btn-grey btn-standard has-arrow"><?php _e('Launch', 'Jungle'); ?></a>
		</li>
			<?php } ?>
		</ul>
	</div>
</div><!-- End of portfolio row -->

<?php $count++; endwhile; ?>

<?php 
if (function_exists("pagination")) {
	pagination($loop->max_num_pages);
} ?> 

</div><!-- End of Sixteen Columns -->
</div><!-- End of Container -->

<?php get_footer(); ?>