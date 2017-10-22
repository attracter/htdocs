<?php get_header(); ?>

<div class="row">
	<?php while ( have_posts() ) : the_post(); ?> <!--  the Loop -->
	<?php $realsize = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'full'); 
		$lightbox_img = $realsize[0]; 
		$portfoliolayout = rwmb_meta('jungle_portfolio_itemlayout');
		$video = rwmb_meta('jungle_portfolio_addvideourl');
		$projecturl = rwmb_meta( 'jungle_portfolio_projecturl'); 
		$tagline = rwmb_meta('jungle_portfolio_tagline');
		$challenge = rwmb_meta( 'jungle_portfolio_challenge');
		$clientname = rwmb_meta('jungle_portfolio_clientname');
		$terms = get_the_terms( $post->ID, 'services' );
		$args = array(
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => $post->ID,
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => -1,
			'exclude' => get_post_thumbnail_id(),
		);
	$attachments = get_posts($args); ?>

<?php if($tagline != '') { ?>
	<div class="row tagline">
		<?php echo do_shortcode($tagline); ?>
	</div><!-- End of tagline -->
<?php } ?>

<div class="row title">
	<?php the_title('<h2>', '</h2>'); ?>
	<ul class="arrow-pagination-wrap absolute-top-right">
		<li class="arrow-pagination-prev"><?php previous_post_link('%link', __('Previous', 'Jungle')); ?></li>
		<li class="arrow-pagination-next"><?php next_post_link('%link', __('Next', 'Jungle')); ?></li>
	</ul>
</div><!-- End of row -->

<?php if($portfoliolayout == "half") { ?>
<div class="two-third single-portfolio-item-gallery">
<?php } else { ?>
<div class="row single-portfolio-item-gallery spacing-bottom"> <?php } ?>
	<div class="portfolio-item carousel" data-transition="fade">
	<?php if($video != '') { ?>
		<?php jungle_video($video); ?>
	<?php } else { ?>
	<img src="<?php echo $lightbox_img; ?>" alt="<?php the_title(); ?>" />
	<?php foreach($attachments as $attachment) { ?>
	<?php $attachmento = wp_get_attachment_image_src( $attachment->ID, 'full'); 
		  $attachmento_img = $attachmento[0];  ?>
			<img src="<?php echo $attachmento_img; ?>" alt="<?php the_title(); ?>" />
	<?php } ?>
	<?php } ?>
	</div><!-- End of carousel -->
</div><!-- End of row -->

<?php if($portfoliolayout == "half") { ?>
<div class="one-third single-portfolio-item-about last">
<?php } else { ?>
<div class="row spacing-bottom"> <?php } ?>
	<?php if($portfoliolayout == "half") { } else { ?>
	<div class="one-third single-portfolio-item-about"> <?php } ?>
		<?php $cf = get_the_content(); if(ot_get_option('project_overview') != '') { ?> 
		<h3><?php echo ot_get_option('project_overview'); ?></h3>
		<?php } elseif($cf != '') { ?>
		<h3><?php _e('Overview', 'Jungle'); ?></h3>
		<?php } ?>
		<?php the_content(); ?><!-- end overview -->
		<?php if($portfoliolayout == "half") { } else { ?>
	</div><!-- End of single portfolio item --> <?php } ?>

	<?php if($portfoliolayout == "half") { } else { ?>
	<?php if($terms == '') { 
	echo '<div class="two-third single-portfolio-item-about omega">'; } 
	else { 
	echo '<div class="one-third single-portfolio-item-about">'; } ?> <?php } ?>
	<?php if(ot_get_option('project_challenge') != '') { ?>
		<h3><?php echo ot_get_option('project_challenge'); ?></h3>
	<?php } else { ?>
	<?php if($challenge != '') { ?>
		<h3><?php _e('Challenges', 'Jungle'); ?></h3>
	<?php } ?>
	<?php echo do_shortcode($challenge); ?> <?php } ?> <!-- end challenge -->
	<?php if($portfoliolayout == "half") { } else { ?>
	</div><!-- End of single portfolio item --> 
	<?php } ?>

	<?php if($terms && ! is_wp_error( $terms )) { ?>
	<?php if($portfoliolayout == "half") { } else { ?>
	<div class="one-third single-portfolio-item-about omega"> <?php } ?>
		<?php if(ot_get_option('project_details')) { ?>
		<h3><?php echo ot_get_option('project_details'); ?></h3>
		<?php } else { ?>
		<h3><?php _e('Things We Did', 'Jungle'); ?></h3>
		<?php } ?>
		<ul class="tick-list">
		<?php echo get_the_term_list($post->ID, 'services', '<li>', ',</li><li>', '</li>'); ?>
		</ul>
		<ul class="infos">
			<?php if($clientname != '') { ?>
			<li>
				<strong><?php _e('Client:', 'Jungle'); ?></strong> <?php echo $clientname; ?>
			</li>
			<?php } ?>
			<?php if($projecturl != '') { ?>
			<li>
				<strong><?php _e('Project URL:', 'Jungle'); ?></strong> <a href="<?php echo $projecturl; ?>"><?php _e('View Project', 'Jungle'); ?></a>
			</li>
			<?php } ?>
		</ul>
	</div><!-- End of single portfolio item-->
	<?php } ?>

<?php endwhile; ?>
</div>

<?php if(ot_get_option('related_works') == 'enable') { ?>
<?php $works = get_related_works($post->ID); ?>				
	<?php if($works->have_posts()): ?>

	<div class="title">
		<h2><?php _e('Related Projects', 'Jungle'); ?></h2>
	</div><!-- End of title -->

		<div class="row shortcode carousel" data-transition="slide">
		<?php $counter = 1; ?>
			<?php while($works->have_posts()): $works->the_post(); ?>
			<?php if($counter % 3 == 0) { ?>
			<div class="one-third work-post-preview last">
			<?php } else { ?>
			<div class="one-third work-post-preview"><?php } ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('portfolio_three'); ?></a>
				<div class="work-post-meta"><a href="<?php the_permalink(); ?>">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<span class="work-post-categories">
						<?php echo get_the_term_list( $post->ID, 'portfolio_categories', '', ', ', '' );?>
					</span>
				</div>	
			</div><!-- End of work post preview -->

			<?php $counter++; endwhile; ?>
		</div><!-- End of row shortcode carousel -->

	<?php endif; ?>
<?php } ?>
		</div>

</div><!-- End of Sixteen Columns -->
</div><!-- End of Container -->

<?php get_footer(); ?>                         