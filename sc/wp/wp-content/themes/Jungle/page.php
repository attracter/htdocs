<?php get_header(); ?>

<div class="row spacing-bottom">
<?php $sidebar = rwmb_meta('jungle_sidebar'); ?>
<?php if($sidebar == 'right') {
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
<?php breadcrumb(); ?>
<div class="twelve columns <?php echo $mainrightclass; ?> blog-posts-list" style="<?php echo $mainright; ?>">
	<?php while ( have_posts() ) : the_post(); ?> <!--  the Loop -->
		<div <?php post_class('blog-post-item'); ?> id="post-<?php the_ID(); ?>">

			<?php if (has_post_thumbnail()) { ?>
			/*<div class="row blog-post-featured-image">*/
				/*<div class="blog-item carousel">*/
				/*<?php echo the_post_thumbnail('blog', array('class' => 'scale-with-grid')); ?>*/
				<?php foreach($attachments as $attachment) { ?>
				<?php $attachmento = wp_get_attachment_image_src( $attachment->ID, 'full'); 
				$attachmento_img = $attachmento[0];  ?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo $attachmento_img; ?>" alt="<?php the_title(); ?>" />
					</a>
					<?php } ?>
				</div><!-- End of carousel-->
			</div><!-- End of blog post featured image -->
			<?php } else { ?>
			<?php $postvideo = rwmb_meta('jungle_postvideo'); ?>
			<?php if($postvideo != '') { ?>
				<div class="videos">
					<?php jungle_video($postvideo); ?>
				</div>
			<?php } ?>
			<?php } ?>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		
			<?php wp_reset_query(); ?>
			<?php comments_template(); ?>
		</div><!-- End of blog post item -->
	<?php endwhile; ?>
</div><!-- End of twelve columns -->
</div><!-- End of row -->
	<aside class="four columns <?php echo $sidebarleftclass; ?>" style="<?php echo $sidebarleft; ?>">
    <?php
    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Default Main SideBar')): 
    endif;
    ?>
	</aside><!-- End of sidebar -->
</div>
</div><!-- End of sixteen -->
</div><!-- End of container -->
<?php get_footer(); ?>