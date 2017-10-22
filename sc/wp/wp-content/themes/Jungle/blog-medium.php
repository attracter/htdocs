<?php 
/*
Template Name: Blog - Medium Image
*/
?>
<?php get_header(); ?>

<?php if(ot_get_option('blogsidebar') == 'right') {
	$mainright = 'float:left;';
	$mainrightclass = 'alpha';
	$sidebarleft = 'float:right;';
	$sidebarleftclass = 'omega';
} else {
	$mainright = 'float:right;';
	$mainrightclass = 'omega';
	$sidebarleft = 'float:left;';
	$sidebarleftclass = 'alpha';
}?>

<div class="row spacing-bottom">
	
	<div class="twelve columns <?php echo $mainrightclass; ?> blog-posts-list" style="<?php echo $mainright; ?>">
		<?php $loop = new WP_Query(array('posts_per_page' => '6', 'paged'=>$paged)); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?> <!--  the Loop -->
		<?php global $more; $more = 0; ?>

		<div id="post-<?php the_ID(); ?>" class="blog-post-item blog-post-medium">
			<?php if(has_post_thumbnail()) { ?>
 			<div class="image">
 				<a href="<?php the_permalink(); ?>">
				<?php echo the_post_thumbnail('blog_medium', array('class' => 'scale-with-grid')); ?>
				</a>
			</div>
			<div class="blog-post-medium-content">
			<?php } elseif('' == get_the_post_thumbnail() && rwmb_meta('jungle_postvideo') != '')  { ?>
			<div class="image">
				<?php $postvideo = rwmb_meta('jungle_postvideo'); ?>
				<?php jungle_video($postvideo); ?>
			</div>
			<div class="blog-post-medium-content">
			<?php } else  { ?>
			<div>
				<?php } ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title('<h3>', '</h3>'); ?></a>
				
				<div class="blog-post-meta">
					<div class="posted-on"><i class="icon-time"></i><?php echo get_the_date(); ?></div>
					<div class="posted-by"><i class="icon-user"></i><?php the_author_posts_link(); ?></div>
					<div class="blog-post-categories"><i class="icon-tag"></i><?php the_category(' '); ?></div>
					<div class="comment-count"><i class="icon-comments"></i><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></div>
				</div><!-- End of blog post meta -->

				<div class="blog-post-excerpt">
					<?php echo limit_excerpt_length(get_the_excerpt(), '100'); ?> <!--The Content-->
				</div><!-- End of blog post excerpt-->

				<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More &rarr;', 'Jungle'); ?></a>
			
			</div><!-- End of blog post medium content-->

		</div><!-- End of blog post item -->
		
		<?php endwhile; ?>

		<?php if (function_exists("pagination")) {
    		pagination($loop->max_num_pages);
		} ?> 
	
	</div><!-- End of blog post list -->
	
	<aside class="four columns <?php echo $sidebarleftclass; ?>" style="<?php echo $sidebarleft; ?>">
    <?php
    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Default Main SideBar')): 
    endif;
    ?>
	</aside><!-- End of sidebar -->

</div><!-- End of row -->
</div><!-- End of Sixteen -->
</div><!-- End of Container -->

<?php get_footer(); ?>