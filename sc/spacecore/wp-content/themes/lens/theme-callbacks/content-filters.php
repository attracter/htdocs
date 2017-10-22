<?php

	#
	# See wpgrade-config.php for the order in which the following filters are
	# executed in. You may filter content via wpgrade::filter_content or
	# wpgrade::display_content if you want to echo it.
	#

	/**
	 * @param string content
	 * @return string filtered content
	 */
	function wpgrade_callback_theme_general_filters($content) {
		// since we cannot apply "the_content" filter on some content blocks
		// we should apply at least these bellow
		$wptexturize = apply_filters('wptexturize', $content);
		$convert_smilies = apply_filters('convert_smilies', $wptexturize);
		$convert_chars = apply_filters('convert_chars', $convert_smilies);
		$wpautop = wpautop($convert_chars);

		return $wpautop;
	}

	/**
	 * @param string content
	 * @return string filtered content
	 */
	function wpgrade_callback_shortcode_filters($content) {
		// including Wordpress plugin.php for is_plugin_active function
		include_once(ABSPATH.'wp-admin/includes/plugin.php');

		if (is_plugin_active('pixelgrade-shortcodes/plugin.php')) {
			$content = wpgrade_remove_spaces_around_shortcodes($content);
		}

		return $content;
	}

	/**
	 * @param string content
	 * @return string filtered content
	 */
	function wpgrade_callback_attachement_filters($content) {
		return apply_filters( 'prepend_attachment', $content);
	}

	/**
	 * @param string content
	 * @return string filtered content
	 */
	function wpgrade_callback_paragraph_filters($content) {
		return do_shortcode($content);
	}

// Media Handlers
// --------------

function wpgrade_media_handlers() {
	// make sure that WordPress allows the upload of our used mime types
	add_filter( 'upload_mimes', 'wpgrade_callback_custom_upload_mimes' );
	// remove the first gallery shortcode from the content
	add_filter( 'the_content', 'wpgrade_callback_gallery_slideshow_filter' );
}

add_action( 'after_wpgrade_core', 'wpgrade_media_handlers');

/**
 * Make sure wordpress allows our mime types.
 * @return array
 */
function wpgrade_callback_custom_upload_mimes( $existing_mimes = null ) {
	if ( $existing_mimes === null ) {
		$existing_mimes = array();
	}

	$existing_mimes['mp3']  = 'audio/mpeg3';
	$existing_mimes['oga']  = 'audio/ogg';
	$existing_mimes['ogv']  = 'video/ogg';
	$existing_mimes['mp4a'] = 'audio/mp4';
	$existing_mimes['mp4']  = 'video/mp4';
	$existing_mimes['weba'] = 'audio/webm';
	$existing_mimes['webm'] = 'video/webm';

	//and some more
	$existing_mimes['svg'] = 'image/svg+xml';

	return $existing_mimes;
}

/**
 * Remove the first gallery shortcode from the content
 */
function wpgrade_callback_gallery_slideshow_filter( $content ) {
	$gallery_ids = array();
	$gallery_ids = get_post_meta( wpgrade::lang_post_id( get_the_ID() ), wpgrade::prefix() . 'main_gallery', true );

	if ( get_post_format() == 'gallery' && empty( $gallery_ids ) ) {
		// search for the first gallery shortcode
		$gallery_matches = null;
		preg_match( "!\[gallery.+?\]!", $content, $gallery_matches );

		if ( ! empty( $gallery_matches ) ) {
			$content = str_replace( $gallery_matches[0], "", $content );
		}
	}

	return $content;
}
