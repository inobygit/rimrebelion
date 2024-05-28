<?php
/**
 * Admin cancelled order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-cancelled-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
*/
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %1$s: Order number, %2$s: Customer full name.  */ ?>
<p><?php printf( esc_html__( 'Notification to let you know &mdash; order #%1$s belonging to %2$s has been cancelled:', 'woocommerce' ), esc_html( $order->get_order_number() ), esc_html( $order->get_formatted_billing_full_name() ) ); ?>
</p>

<?php
/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
echo '<p>'.__('In case of any questions, do not hasitate to contact us by e-mail: ', 'rimrebellion').' <a href="mailto:help@rimrebellion.com">'. __("help@rimrebellion.com ", 'rimrebellion') .' </a> '.__("or by phone: ", 'rimrebellion').' <a href="tel:+421915111199">'. __("+ 421 915 111 199.", 'rimrebellion') .' </a></p>';
echo '<p><b>'.__("Thank you for shopping at ").' <a href="https://rimrebelion.com">'.__("rimrebelion.com!", 'rimrebellion').'</a></b></p>';

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
?>


<style>
.terms-table-row {
    background-color: black;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 15px;
}

.terms-table-row a {
    color: white;
    text-decoration: none;
    font-size: 12px;
    font-weight: 400;
    position: relative;
}

.terms-table-row a:hover {
    text-decoration: underline;
}

.terms-table-row a:first-child::after {
    content: '|';
    color: white;
    margin: 0 10px;
}
</style>

<div class="terms-table-row">
    <a
        href="<?= __('/terms-and-conditions/#terms', 'rimrebellion') ?>"><?= __("Terms and conditions", 'rimrebellion') ?></a>
    <a href="<?= __('/privacy-policy/#privacy', 'rimrebellion') ?>"><?= __("GDPR", 'rimrebellion') ?></a>
</div>