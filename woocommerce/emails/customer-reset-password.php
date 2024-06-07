<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); 


/**
 * @hooked Kadence_Woomail_Designer::email_main_text_area_no_order
 */
do_action( 'kadence_woomail_designer_email_text', $email ); 

if ( true == $button_check ) {
	echo '<p class="btn-container"><a href="' . esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ) . '" class="btn">' . esc_html__( 'Reset Password', 'kadence-woocommerce-email-designer' ) . '</a></p>';
} else {
	?>
<p>
    <a class="link"
        href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>">
        <?php esc_html_e( 'Click here to reset your password', 'kadence-woocommerce-email-designer' ); ?></a>
</p>
<?php
}
?>
<p></p>
<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
echo '<p class="center">'.__('In case of any questions, do not hasitate to contact us by e-mail: ', 'rimrebellion').' <a href="mailto:help@rimrebellion.com">'. __("help@rimrebellion.com ", 'rimrebellion') .' </a></p>';
echo '<p class="center"><b>'.__("Thank you for shopping at ").' <a href="https://rimrebellion.com">'.__("rimrebellion.com!", 'rimrebellion').'</a></b></p>';

do_action( 'woocommerce_email_footer', $email );