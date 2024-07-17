<?php
/**
 * Single variation cart button
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

$product = $args['product'] ?? null;

?>
<div id="price-wrp" class="price-wrp">
    <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
        <?php echo $product->get_price_html(); ?></p>
</div>
<?php get_template_part("template-parts/stock-status", null, ["product" => $product]); ?>

<div class="woocommerce-variation-add-to-cart variations_button">
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	rc_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		),
		$product
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>
    <?php 
	rebellion_add_to_cart_btn(
		array(
			'text' => esc_html( $product->single_add_to_cart_text() ),
			'class' => 'button triangleBoth black',
			'tag' => 'submit'
		), $product
		);
	?>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

    <input type="hidden" name="rc-add-to-cart" value="<?= $product->get_id(); ?>">
    <input type="hidden" name="product_id" value="<?= $product->get_id(); ?>" />
    <input type="hidden" name="variation_id" class="variation_id" value="0" />
    <input type="hidden" name="open_minicart" value="1">
</div>