<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>
<section class="shopping__options">
<form class="variations_form cart form-shopping  shopping--single-product" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
	<div class="variations row soft--bottom cf">
			<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
				<div class="col-6  float--left">
					<label for="<?php echo sanitize_title($name); ?>" class="shop__label"><?php echo wc_attribute_label( $name ); ?></label>
					<select id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="attribute_<?php echo sanitize_title($name); ?>" class="shop__select">
						<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
						<?php
							if ( is_array( $options ) ) {

								if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
									$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
								} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
									$selected_value = $selected_attributes[ sanitize_title( $name ) ];
								} else {
									$selected_value = '';
								}

								// Get terms if this is a taxonomy - ordered
								if ( taxonomy_exists( $name ) ) {

									$terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

									foreach ( $terms as $term ) {
										if ( ! in_array( $term->slug, $options ) ) {
											continue;
										}
										echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
									}

								} else {

									foreach ( $options as $option ) {
										echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
									}

								}
							}
						?>
					</select> <?php
//						if ( sizeof($attributes) == $loop )
//							echo '<a class="reset_variations btn  btn--medium" href="#reset">' . __( 'Clear selection', 'woocommerce' ) . '</a>';
					?>
				</div>
	        <?php endforeach;?>

		<div class="single_variation_wrap col-12  push--top  float--left" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variation  push--bottom"></div>
			<div class="variations_button ">
				<input type="hidden" name="variation_id" value="" />
				<?php woocommerce_quantity_input(); ?>
				<div class="push--top">
					<button type="submit" class="single_add_to_cart_button  btn  btn--medium"><?php echo $product->single_add_to_cart_text(); ?></button>
				</div>
			</div>
		</div>
		<div>
			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

	</div>

	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif; ?>

</form>
</section>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
