<?php get_header(); ?>

<div class="row">
	<?php $counter = 1; ?>
	<?php while(have_posts()): the_post(); ?>
	<?php if(has_post_thumbnail()): ?>
	<?php if($counter % 3 == 0) { ?>
	<div class="one-third work-post-preview last">
	<?php } else { ?>
	<div class="one-third work-post-preview">					
		<?php } ?>
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('portfolio_three'); ?></a>
		<div class="work-post-meta">
			<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
		</div>	
	</div><!-- End of work post preview -->
	<?php $counter++; ?>
	<?php endif; endwhile; ?>
</div><!-- End of row -->

<?php if (function_exists("pagination")) {
    pagination($loop->max_num_pages);
} ?> 

</div><!-- End of sixteen -->
</div><!-- End of container -->

<?php get_footer(); ?>