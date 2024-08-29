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

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}


if ( $product->is_in_stock() ) : ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart"
    action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
    method="post" enctype='multipart/form-data'>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <div class="stock-wrp">
        <?php get_template_part("template-parts/stock-status", null, ["product" => $product]); ?>
        <div class="availability-date">
            <?php
                            $availability_date_tomorrow = get_post_meta($product->get_id(), '_availability_date_tomorrow', true);
                            $availability_date_onbackorder = get_post_meta($product->get_id(), '_availability_date_onbackorder', true);
                            $availability_date_default = get_post_meta($product->get_id(), '_availability_date_default', true);

                            $availability_date_onbackorder = date('j.n.', strtotime('+10 days'));
                            $availability_date_tomorrow = date('j.n.', strtotime('tomorrow'));
                            $availability_date_default = date('j.n.', strtotime('+2 days'));

                            echo '<p class="availability-date-default">' . esc_html(__('(Delivery: ', 'rimrebellion')) . ' ' . $availability_date_default . ')</p>';

                            echo '<p class="availability-date-tomorrow">' . esc_html(__('(Delivery: ', 'rimrebellion')) . ' ' . $availability_date_tomorrow . ')</p>';

                            echo '<p class="availability-date-onbackorder">' . esc_html(__('(Delivery: ', 'rimrebellion')) . ' ' . $availability_date_onbackorder . ')</p>';
                            ?>
        </div>
    </div>
    <div class="help-wrp">
        <a href="#0" id="size-help"><svg width="11" height="12" viewBox="0 0 11 12" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_948_435)">
                    <path
                        d="M10.9883 1.83925C10.9581 1.48519 10.6721 1.1875 10.3125 1.1875H0.6875C0.327937 1.1875 0.0419375 1.48519 0.0116875 1.83925H0V10.8125C0 10.9948 0.0724328 11.1697 0.201364 11.2986C0.330295 11.4276 0.505164 11.5 0.6875 11.5H10.3125C10.4948 11.5 10.6697 11.4276 10.7986 11.2986C10.9276 11.1697 11 10.9948 11 10.8125V1.83925H10.9883ZM4.125 5.3125V3.25H6.875V5.3125H4.125ZM6.875 6V8.11956H4.125V6H6.875ZM3.4375 3.25V5.3125H0.6875V3.25H3.4375ZM0.6875 6H3.4375V8.11956H0.6875V6ZM0.6875 10.8125V8.75H3.4375V10.8125H0.6875ZM4.125 10.8125V8.75H6.875V10.8125H4.125ZM10.3125 10.8125H7.5625V8.75H10.3125V10.8125ZM10.3125 8.11956H7.5625V6H10.3125V8.11956ZM10.3125 5.3125H7.5625V3.25H10.3125V5.3125Z"
                        fill="#A7A7A7" />
                </g>
                <defs>
                    <clipPath id="clip0_948_435">
                        <rect width="11" height="11" fill="white" transform="translate(0 0.5)" />
                    </clipPath>
                </defs>
            </svg>
            <?= __('Size help', 'inoby') ?></a>
    </div>

    <div class="simple-row">
        <?php
			do_action( 'woocommerce_before_add_to_cart_quantity' );
	
			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
				)
			);
	
			do_action( 'woocommerce_after_add_to_cart_quantity' );
			?>
        <?php rebellion_add_to_cart_btn(
				array(
					'text' => esc_html( $product->single_add_to_cart_text() ),
					'class' => 'button triangleBoth black',
					'tag' => 'submit'
					)
				); ?>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

        <input type="hidden" name="rc-add-to-cart" value="<?= $product->get_id(); ?>">
        <input type="hidden" name="open_minicart" value="1">

    </div>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>