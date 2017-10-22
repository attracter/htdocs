<?php
/*
Template Name: Blog - Full Width
*/
?>
<?php get_header(); ?>

<?php $postvideo = rwmb_meta('jungle_postvideo'); ?>

<div class="row spacing-bottom">
	
		<?php $loop = new WP_Query(array('posts_per_page' => '4', 'paged'=>$paged)); ?>
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?> <!--  the Loop -->
		<div id="post-<?php the_ID(); ?>" class="blog-post-item">
		<?php $args = array(
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => $post->ID,
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => -1,
			'exclude' => get_post_thumbnail_id(),
		);
		$attachments = get_posts($args); ?>
		<?php global $more; $more = 0; ?>
		
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title('<h3>', '</h3>'); ?></a>
			
			<div class="blog-post-meta">
				<div class="posted-on"><i class="icon-time"></i><?php echo get_the_date(); ?></div>
				<div class="posted-by"><i class="icon-user"></i><?php the_author_posts_link(); ?></div>
				<div class="blog-post-categories"><i class="icon-tag"></i><?php the_category(', '); ?></div>
				<div class="comment-count"><i class="icon-comments"></i><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></div>
			</div><!-- End of blog post meta -->
			
			<?php if (has_post_thumbnail()) { ?>
			<div class="row blog-post-featured-image">
				<div class="blog-item carousel">
				<?php echo the_post_thumbnail('blog', array('class' => 'scale-with-grid')); ?>
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
				<?php jungle_video($postvideo); ?>
			
			<?php } ?>
			<div class="blog-post-excerpt">
					<?php echo limit_excerpt_length(get_the_excerpt(), '80', ' '); ?> <!--The Content-->
			</div><!-- End of blog post excerpt -->

			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e('Read More &rarr;', 'Jungle'); ?></a>

		</div><!--End of blog post item -->

		<?php endwhile; ?><!--  End the Loop -->
		
		<?php if (function_exists("pagination")) {
			pagination($loop->max_num_pages);
		} ?> 

	</div><!-- End of blog post list -->

</div><!-- End of row -->
</div><!-- End of Sixteen -->
</div><!-- End of Container -->

<?php get_footer(); ?>