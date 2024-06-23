<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

$product = $args['product'] ?? null;

if ( ! $product->is_purchasable() ) {
	return;
}


if ( $product->is_in_stock() ) : ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" method="post" enctype='multipart/form-data'>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <div class="simple-row between">
        <div class="woocommerce-variation-availability">
            <?=
			 wc_get_stock_html( $product );
			?>
        </div>
    </div>
    <div class="simple-row">
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

        <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"
            class="single_add_to_cart_button button triangleright triangleleft alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
    </div>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php 
$GLOBALS['product'] = $product;
ob_start();
do_action("woocommerce_after_add_to_cart_form");
ob_clean();
?>

<?php endif; ?>