<?php
/**
 * Single variation cart button
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="woocommerce-variation-add-to-cart variations_button">




    <input type="hidden" name="rc-add-to-cart" value="<?= $product->get_id(); ?>">
    <input type="hidden" name="product_id" value="<?= $product->get_id(); ?>" />
    <input type="hidden" name="variation_id" class="variation_id" value="0" />
    <input type="hidden" name="open_minicart" value="1">

</div>