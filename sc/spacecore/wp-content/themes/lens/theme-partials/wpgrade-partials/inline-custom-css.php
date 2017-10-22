<?php
/**
 * Generate all the css declared in customizer's config
 * ====== DO NOT EDIT BELOW!!! =======
 * If you need to add custom css rules add them above so we can keep track of them
 */

$redux_sections = wpgrade::get_redux_sections();

if ( is_array( $redux_sections ) || is_object( $redux_sections ) ) {
	foreach ( $redux_sections as $key => $section ) {

		if ( isset( $section['fields'] ) ) {

			foreach ( $section['fields'] as $i => $field ) {

				if ( isset( $field['customizer'] ) && isset( $field['customizer']['css_rules'] ) ) {

					foreach ( $field['customizer']['css_rules'] as $key => $rule ) {

						//rebuild the option value for each rule
						$option_value = wpgrade::option( $field['id'] );

						// @TODO  make from this a method used also in customizer
						wpgrade::display_dynamic_css_rule( $rule, $key, $option_value );
					}
				}
			}
		}
	}
}

$main_color = wpgrade::option('main_color');
$header_color = wpgrade::option('header_background_color');
$rgb = implode(',', wpgrade::hex2rgb_array($main_color));

?>

.header:before {
	background-image: linear-gradient(<?php echo $main_color; ?> 50%, <?php echo $header_color; ?>);
}

.header:after {
	background-image: linear-gradient(<?php echo $header_color; ?> 5%, <?php echo $header_color; ?> 91.66%, transparent 91.66%, transparent);
}



<?php

$fonts = array();

if (wpgrade::option('use_google_fonts')) {
	$fonts_array = array
	(
		'google_main_font',
		'google_second_font',
		'google_menu_font',
		'google_body_font'
	);

	foreach ($fonts_array as $font) {
		$the_font = wpgrade::get_the_typo($font);
		if ( isset($the_font['font-family'] ) && ! empty($the_font['font-family'])) {
			$fonts[$font] = $the_font;
		}
	}
}

$port_color = '';
if (wpgrade::option('portfolio_text_color')) {
	$port_color = wpgrade::option('portfolio_text_color');
	$port_color = str_replace('#', '', $port_color);
}

function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
//     return implode(",", $rgb); // returns the rgb values separated by commas
    return $rgb; // returns an array with the rgb values
}

if ( !empty($main_color) ){
$rgb = implode(",", hex2rgb($main_color)); ?>


.image__item-meta, .mfp-video:hover .image__item-meta, .external_url:hover .image__item-meta, .article--product:hover .product__container,
.touch .mosaic__item--page-title .image__item-meta, .touch .mosaic__item--page-title-mobile .image__item-meta {
    background-color: <?php echo $main_color; ?>;
    background-color: rgba(<?php echo $rgb; ?>, 0.8);
}

.mosaic__item--page-title-mobile .image__item-meta
.touch .mosaic__item--page-title .image__item-meta, .touch .mosaic__item--page-title-mobile .image__item-meta {
    background-color: rgba(<?php echo $rgb; ?>, 0.8);
}

.loading .pace .pace-activity {
    border-top-color: transparent;
}

.header:before {
    background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(50%, <?php echo $main_color; ?>), color-stop(100%, #464a4d));
    background-image: -webkit-linear-gradient(<?php echo $main_color; ?> 50%, #464a4d);
    background-image: -moz-linear-gradient(<?php echo $main_color; ?> 50%, #464a4d);
    background-image: -o-linear-gradient(<?php echo $main_color; ?> 50%, #464a4d);
    background-image: linear-gradient(<?php echo $main_color; ?> 50%, #464a4d);
}

.lt-ie9 .header:before {
    filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FFFFFC00', endColorstr='#FF464A4D');
}

@media only screen and (min-width: 1201px){
    .team-member__profile{
        background-color: rgba(<?php echo $rgb; ?>, .8);
    }
}

<?php }

if ( isset($fonts["google_body_font"]) ){ ?>

html,
.wpcf7-form-control:not([type="submit"]),
.wp-caption-text,
blockquote:before,
ol li,
.comment__timestamp,
.meta-box__box-title,
.header-quote-content blockquote .author_description,
.testimonial__author-title,
.widget-content {
	<?php wpgrade::display_font_params($fonts['google_body_font']); ?>
}

<?php }

if ( isset($fonts["google_main_font"]) ){ ?>
.count, .count sup,
.header-quote-content blockquote,
.article-timestamp,
.progressbar__title,
.progressbar__tooltip,
.testimonial__content,
.testimonial__author-name,
.tweet__meta,
.search-query,
.mfp-title,
.entry__content ul li,
.hN, .alpha, h1,
.beta, h2, .gamma, h3,
.masonry__item .entry__title,
.single-portfolio-fullwidth .entry__title,
.delta, h4, .epsilon, h5, .zeta, h6,
.comment__author-name,
.entry__meta-box a {
	<?php wpgrade::display_font_params($fonts['google_main_font']); ?>
}

<?php }

if ( isset($fonts["google_menu_font"]) ){ ?>
.image__plus-icon,
.image_item-description,
.image_item-category,
.btn, .wpcf7-submit, .form-submit #comment-submit,
.header,
.header .hN,
.header .alpha,
.header h1,
.header .beta,
.header h2,
.header .gamma,
.header h3,
.header .masonry__item .entry__title,
.masonry__item .header .entry__title,
.header .single-portfolio-fullwidth .entry__title,
.single-portfolio-fullwidth .header .entry__title,
.header .delta,
.header h4,
.header .epsilon,
.header h5,
.header .zeta,
.header h6,
.footer .hN,
.footer .alpha, .footer h1,
.footer .beta,
.footer h2,
.footer .gamma,
.footer h3,
.footer .masonry__item .entry__title,
.masonry__item .footer .entry__title,
.footer .single-portfolio-fullwidth .entry__title,
.single-portfolio-fullwidth .footer .entry__title,
.footer .delta,
.footer h4,
.footer .epsilon,
.footer h5,
.footer .zeta,
.footer h6,
.text-link,
.projects_nav-item a {
	<?php wpgrade::display_font_params($fonts['google_menu_font']); ?>
}
<?php } ?>

<?php if (wpgrade::option('custom_css')):
	echo wpgrade::option('custom_css');
endif; ?>