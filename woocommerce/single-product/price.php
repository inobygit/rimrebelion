<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$lowest_price = null;
if ($product->is_type('variable')) {


$available_variations = $product->get_available_variations();
foreach ($available_variations as $variation) {
    $price = $variation['display_price'];
    if ($lowest_price === null || $price < $lowest_price) {
        $lowest_price = $price;
    }
}
$lowest_price = number_format($lowest_price, 2);

$priceHtml = '<span class="woocommerce-Price-amount amount"><bdi>'. __("from ", 'inoby') .''. $lowest_price .'&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi></span>';
}


?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
    <?= ($lowest_price && $lowest_price != 0 ? $priceHtml : $product->get_price_html()) ?>
</p>