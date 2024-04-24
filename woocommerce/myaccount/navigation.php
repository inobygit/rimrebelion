<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>
<div class="my-account-profile">
    <div class="my-account-profile-content">
        <?php
			$current_user = wp_get_current_user();
			echo '<h3 class="profile-name">'. esc_html( $current_user->display_name ) .'</h3>';	
		?>
    </div>
</div>

<div class="my-account-navigation-wrap">
    <nav id="my-account-navigation" class="woocommerce-MyAccount-navigation">
        <ul>
            <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
                if($endpoint !== 'downloads'){
                ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <a
                    href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
            </li>
            <?php } endforeach; ?>
        </ul>
    </nav>
</div>

<div class="contact-info">
    <h3>
        <?= __("Do you have any questions?") ?>
    </h3>
    <?php 
        $email = rwmb_meta("contact_form_email_to", ["object_type" => "setting"], "options");
        if(!empty($email)) {
    ?>
    <a class="email-btn" href="mailto:<?= $email ?>">
        <?= $email ?></a>
    <?php } ?>
    <a class="phone-btn" href="tel:+421 910 511 244">
        +421 910 511 244</a>
</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>