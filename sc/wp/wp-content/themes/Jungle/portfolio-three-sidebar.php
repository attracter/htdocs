<?php 
/*
Template Name: Portfolio - Three Columns Sidebar
*/
?>
<?php get_header(); ?>

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

<?php while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>

<?php
	$loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => ot_get_option('portfolio_items_number', '9', '', '', ''), 'paged'=>$paged));
	$count = 1;
?>

<div class="row twelve columns <?php echo $mainrightclass; ?>" style="<?php echo $mainright; ?>">
	
	<div class="title">
		<?php the_title('<h2>', '</h2>'); ?>
		<?php if(ot_get_option('portfolio_filter') == 'enabled') { ?>
		<ul class="category-nav carousel" data-transition="flip">
			<li class="active"><a href="#" data-filter="*">All</a></li>
		<?php
			$categories = get_categories( array('taxonomy'	=> 'portfolio_categories', 'hide_empty' => 1) );
			foreach($categories as $category) { ?>
			<li><a href="#" data-filter=".<?php echo $category->slug; ?>"><?php echo $category->cat_name; ?></a></li>
		<?php } ?>
		</ul>
			<?php } else { } ?>
	</div><!-- End of title -->

	<div class="row portfolio-col-4 isotope spacing-bottom">
	<?php while ($loop->have_posts()) : $loop->the_post(); ?>
		<?php
			$item_classes = '';
			$item_cats = get_the_terms($post->ID, 'portfolio_categories');
			if($item_cats):
			foreach($item_cats as $item_cat) {
				$item_classes .= $item_cat->slug . ' ';
			}
			endif;
			$realsize = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'full'); 
			$lightbox_img = $realsize[0];
			$video = rwmb_meta('jungle_portfolio_addvideourl');
		?>
		<div class="work-post-preview<?php echo ' '.$item_classes; ?>">
			
			<div class="image">
				<?php if(ot_get_option('portfolio_hover') == 'enabled') { ?>
				<nav class="hover-card">
					<ul class="thumb-options">
						<li class="thumb link">
							<a href="<?php the_permalink(); ?>">Link</a>
						</li>
						<li class="thumb-zoom">
							<a <?php if($video == true) { ?> href="<?php echo $video;?>" <?php } else { ?> href="<?php echo $lightbox_img;?>" <?php }?> data-rel="prettyPhoto">Zoom</a>
						</li>
					</ul>
				</nav>
				<?php } else { } ?>
				<a href="<?php the_permalink(); ?>"><?php echo the_post_thumbnail('portfolio_four', array('class' => 'scale-with-grid' )); ?></a>
			</div><!-- End of image -->

			<div class="work-post-meta">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="work-post-categories">
					<?php echo get_the_term_list( $post->ID, 'portfolio_categories', '', ', ', '' ); ?>
				</div>
			</div><!-- End of work post meta -->
		
		</div><!-- End of portfolio item -->

	<?php $count++; endwhile; ?>

	</div><!-- End of portfolio four -->

<?php if (function_exists("pagination")) {
    pagination($loop->max_num_pages);
} ?>

</div><!-- End of row -->

	<aside class="four columns <?php echo $sidebarleftclass; ?>" style="<?php echo $sidebarleft; ?>">
    <?php
    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Default Main SideBar')): 
    endif;
    ?>
	</aside><!-- End of sidebar -->

</div><!-- End of Sixteen Columns -->
</div><!-- End of Container -->

<?php get_footer(); ?>