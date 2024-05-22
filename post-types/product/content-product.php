<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined("ABSPATH") || exit();

global $product;
?>

<?php // Ensure visibility.

if (empty($product) || !$product->is_visible()) {
    return;
} ?>

<div <?php wc_product_class("content-product-wrap product-card", $product); ?>>
    <?php woocommerce_template_loop_product_link_open(); ?>
    <div class="content-product-thumbnail">
        <?php if (ESHOP_ENABLED && is_user_logged_in() && Inoby_Config::wishlist()) {
        Inoby_Product::wishlist();
    } ?>
        <?php
        echo $product->get_image("o-4", ["class" => "product-image", "loading" => "lazy", 'alt' => $product->get_title()]);
        ?>
        <div class="tags">
            <?php
      Inoby_Product::product_special_badge();
      Inoby_Product::new_product_badge();
      Inoby_Product::sale_badge_percentage();
      ?>
        </div>
        <div class="product-thumbnail-footer">
            <div class="product-mask">
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="130" viewBox="0 0 300 130" fill="none">
                    <path
                        d="M183.737 9.95404L300 76.9997V129.995H0V76.8207L116.024 9.95404C136.921 -2.07062 162.84 -2.07062 183.737 9.95404Z"
                        fill="white" fill-opacity="0.6" />
                </svg>
                <svg width="108" height="59" viewBox="0 0 108 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_3908_6206)">
                        <path
                            d="M108 59V37.8586C108 31.8701 104.743 26.3188 99.4882 23.3377L62.4771 2.25951C57.2173 -0.753169 50.74 -0.753169 45.4481 2.25951L8.51184 23.3008C3.25735 26.3135 0 31.8332 0 37.8217V59H108Z"
                            fill="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M53.9121 30.6775L53.9121 21.9275L54.8496 21.9275L54.8496 30.6775L53.9121 30.6775Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M54.3784 22.6241L52.5247 24.4777L51.8618 23.8148L54.3832 21.2935L56.8709 23.8172L56.2032 24.4753L54.3784 22.6241Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_3908_6206">
                            <rect width="108" height="59" fill="white" />
                        </clipPath>
                    </defs>
                </svg>

                <span><?= __("Nakupovať", "rimrebellion") ?></span>
            </div>
        </div>
    </div>
    <div class="content-product">
        <div class="content-product-title">
            <h3 class="woocommerce-loop-product__title notranslate"><?php 
                if(function_exists('icl_object_id')){
                    $original_ID = icl_object_id( get_the_ID(), 'product', false, 'en' );

                    echo get_the_title( $original_ID );
                } else {
                    echo get_the_title(get_the_ID());
                }
            ?></h3>
        </div>
        <div class="content-product-excerpt">
            <?= the_excerpt() ?>
        </div>
        <div class="content-product-footer">
            <div class="content-product-price">
                <?php woocommerce_template_single_price(); ?>
            </div>
            <?= wc_get_stock_html($product) ?>
        </div>
    </div>
    <?php woocommerce_template_loop_product_link_close(); ?>
</div>