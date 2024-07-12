<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'woocommerce' ) : esc_html__( 'Shipping address', 'woocommerce' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<?php if ( ! $load_address ) : ?>
<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

<form class="edit-address-form" method="post">
    <a class="btn back" href="<?= esc_url( wc_get_account_endpoint_url( 'edit-address' ) )?>"><svg width="24"
            height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M8.55 7.9502L4.5 12.0002L8.55 16.0002L9.6 14.9502L7.4 12.7502H19.5V11.2502H7.35L9.6 9.0502L8.55 7.9502Z"
                fill="black" />
        </svg>
    </a>
    <h2><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h2>
    <?php // @codingStandardsIgnoreLine ?>

    <div class="woocommerce-address-fields">
        <?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

        <div class="woocommerce-address-fields__field-wrapper">
            <?php
				foreach ( $address as $key => $field ) {
					woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
				}
				?>
        </div>

        <?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
        <p class="form-submit">
            <button type="submit" class="button triangleBoth black" name="save_address"
                value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>"><?php esc_html_e( 'Save address', 'woocommerce' ); ?></button>
            <?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
            <input type="hidden" name="action" value="edit_address" />
        </p>

    </div>

</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>