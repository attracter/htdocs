<?php get_header(); ?>
<?php breadcrumb(); ?>
<?php $postvideo = rwmb_meta('jungle_postvideo'); ?>

<div class="row spacing-bottom">  
<?php while ( have_posts() ) : the_post(); ?> <!--  the Loop -->
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

	<div class="twelve columns alpha single-blog-post-item">

		<div <?php post_class('blog-post-item'); ?> id="post-<?php the_ID(); ?>">

		  	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title('<h2>', '</h2>'); ?></a>
		  
			<div class="blog-post-meta">
				<div class="posted-on"><i class="icon-time"></i><?php echo get_the_date(); ?></div>
				<div class="posted-by"><i class="icon-user"></i><?php the_author_posts_link(); ?></div>
				<div class="blog-post-categories"><i class="icon-tag"></i><?php the_category(' '); ?></div>
				<div class="comment-count"><i class="icon-comments"></i><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></div>
			</div><!-- End of blog post meta -->

			<div class="row blog-post-featured-image">
				<div class="blog-item carousel">
				<?php if (has_post_thumbnail()) { ?>
				<?php echo the_post_thumbnail('blog', array('class' => 'scale-with-grid')); ?>
				<?php foreach($attachments as $attachment) { ?>
				<?php $attachmento = wp_get_attachment_image_src( $attachment->ID, 'full'); 
				$attachmento_img = $attachmento[0];  ?>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo $attachmento_img; ?>" alt="<?php the_title(); ?>" />
					</a>
				<?php } ?>
				<?php } elseif($postvideo != '') { ?>
					<?php jungle_video($postvideo); ?>
				<?php } ?>
				</div><!-- End of blog item carousel -->
			</div><!-- End of row blog post featured image -->

		  	<div class="blog-post-content spacing-bottom">
				<?php the_content(); ?>
				<div class="page-link">
					<?php wp_link_pages(); ?>
				</div>
		  	</div>

			<?php $blogposts = get_related_blogposts($post->ID); ?>       
		  	<?php if($blogposts->have_posts()): ?>

			<div class="title">
				<h4><?php _e('Related Posts', 'Jungle'); ?></h4>
			</div><!-- End of title -->

		  	<div class="row shortcode carousel" data-transition="slide">
		  	<?php $counter = 1; ?>
			<?php while($blogposts->have_posts()): $blogposts->the_post(); ?>
			<?php if($counter % 2 == 0) { ?>
				<div class="one-half work-post-preview last">
				<?php } else { ?>
				<div class="one-half work-post-preview">
				<?php } ?>
				<?php if(has_post_thumbnail()) { ?>
				  	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('portfolio_three'); ?></a>
			  	<?php } else { ?>
				  	<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
				<?php } ?>
				</div><!-- End of work post preview -->
			
			<?php $counter++; endwhile; ?>
			
			</div><!-- End of shortcode carousel -->

	  		<?php endif; ?>

			<div class="author-about">
				<div class="title">
				  <h4><?php _e('About the Author', 'Jungle'); ?></h4>
				</div><!-- End of title -->

				<?php echo get_avatar(get_the_author_meta('ID'), '70'); ?>
				<div class="author-content">
					<h5><?php the_author_posts_link(); ?></h5>
					<?php the_author_meta("description"); ?>
				</div>
			</div><!-- End of author about -->

		</div><!-- End of blog post item -->

	<?php wp_reset_query(); ?>
	<?php comments_template(); ?>
	</div><!-- End of twelve columns single blog post item -->
	<?php endwhile; ?>

</div><!-- End of row -->

<aside class="four columns last">    
	<?php
	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Default Main SideBar')): 
	endif;
	?>
</aside><!-- End of sidebar -->

</div>
</div><!-- End of Sixteen Columns -->
</div><!-- End of Container -->

<?php get_footer(); ?>