<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
<div class="row woocommerce-Addresses addresses">
    <?php endif; ?>
    <div class="col-12 header">
        <h2>
            <?= __("Addresses", 'inoby') ?>
        </h2>
        <p>
            <?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used for default billing.', 'rootscope' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </p>
    </div>

    <div class="row">
        <?php foreach ( $get_addresses as $name => $address_title ) : ?>
        <?php
            $address = wc_get_account_formatted_address( $name );
            $customer = new WC_Customer( $customer_id );
            $phone = $customer->get_billing_phone();
            $email = $customer->get_billing_email();
            $col     = $col * -1;
            $oldcol  = $oldcol * -1;
        ?>

        <div class="col-4 col-md-12 woocommerce-Address">
            <h3><?php echo esc_html( $address_title ); ?></h3>
            <div class="address-wrapper">
                <address>
                    <?php
                        echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
                    ?>
                    <hr>
                    <?php if ($phone) : ?>
                    <span class="woocommerce-customer-phone"><?php echo esc_html($phone); ?></span>
                    <?php endif; ?>
                    <br>
                    <?php if ($email) : ?>
                    <span class="woocommerce-customer-email"><?php echo esc_html($email); ?></span>
                    <?php endif; ?>
                </address>
                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>"
                    class="edit"><?php echo $address ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ); ?></a>
            </div>
        </div>

        <?php endforeach; ?>
    </div>



    <?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
</div>
<?php
endif;