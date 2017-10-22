<?php
/**
 * @package WordPress
 * @subpackage Jungle WordPress
 */
?>

	<div class="comments">
	 <?php if ( post_password_required() ) : ?>
		<div class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'Jungle' ); ?></div>
	</div><!-- End of comments -->

	<?php return; endif; ?>

	<?php if ( have_comments() ) : ?>
		<div class="title">
			<h4><?php comments_number( 'no comments', '1 comment', '% comments' ); ?></h4>
		</div><!-- End of title -->

		<ol class="commentlist">
			<?php wp_list_comments('callback=jungle_comments'); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div class="pagination">
    		<?php paginate_comments_links(); ?>
		</div>
		<?php endif; // check for comment navigation ?>

	<?php else : // this is displayed if there are no comments so far ?>

		<?php if ( comments_open() ) : // If comments are open, but there are no comments ?>

		<?php else : // or, if we don't have comments:

			/* If there are no comments and comments are closed,
			 * let's leave a little note, shall we?
			 * But only on posts! We don't want the note on pages.
			 */
			if ( ! comments_open() && ! is_page() ) :
			?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'Jungle'); ?></p>
			<?php endif; // end ! comments_open() && ! is_page() ?>

		<?php endif; ?>

	<?php endif; ?>
	<?php comment_form(); ?>