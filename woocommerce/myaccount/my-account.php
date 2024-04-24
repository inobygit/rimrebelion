<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<section class="header">
    <img src="<?= get_theme_file_uri("/assets/img/bg-header.webp") ?>" alt="404" />
</section>

<?php
echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col-3 col-lg-12'>";
echo '<div class="my-account-nav-wrap">';
/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_navigation' ); ?>
</div>
</div>


<div class="col-9 col-lg-12">
    <div class="woocommerce-MyAccount-content">

        <?php
		/**
		 * My Account content.
		 *
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );
	?>
    </div>
</div>
</div>
</div>