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
$has_different_prices = false; // Track if there are different prices

if ($product->is_type('variable')) {
    $available_variations = $product->get_available_variations();
    $first_price = null; // Store the first price for comparison

    foreach ($available_variations as $variation) {
        $price = $variation['display_price'];
        if ($lowest_price === null || $price < $lowest_price) {
            $lowest_price = $price;
        }
        // Check if the price is different from the first price
        if ($first_price === null) {
            $first_price = $price;
        } elseif ($price !== $first_price) {
            $has_different_prices = true; // Set flag if prices differ
        }
    }
    $lowest_price = number_format($lowest_price, 2, ',', ' ');

    // Update priceHtml only if there are different prices
    if ($has_different_prices) {
        $priceHtml = '<span class="woocommerce-Price-amount amount"><bdi>'. __("from ", 'inoby') .''. $lowest_price .'&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi></span>';
    } 
}

?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
    <?= (isset($priceHtml) && $lowest_price != 0 ? $priceHtml : $product->get_price_html()) ?>
</p>