<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */
$product = $args['product'] ?? null;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>

<h1 class="product_title entry-title notranslate">
    <?php
    $terms = wp_get_post_terms( $product->id, 'product_tag' );

                if(empty($terms)){
                    echo '<img loading="lazy" src="'. get_stylesheet_directory_uri() . '/assets/svg/cdc.svg' . '" alt="Cafe du Cycliste" class="cdc-logo">';
                } else {
                    echo '<span class="brand">';
                    if(isset(get_term_meta($terms[0]->term_id)['icon'])){
                        echo '<img loading="lazy" src="'. wp_get_attachment_image_url(get_term_meta($terms[0]->term_id)['icon'][0], 'o-6') . '" alt="'. $terms[0]->name . '" class="cdc-logo">';
                    }
                    echo '<span class="brand-name">' . $terms[0]->name . '</span>';
                    echo '</span>';
                } ?>
    <span>
        <?php 

            if(!empty($terms)){
                    echo strtoupper($terms[0]->name) . ' - ';
                }
            if(function_exists('icl_object_id')){
                $original_ID = icl_object_id( $product->get_id(), 'product', false, 'en' );

                echo get_the_title( $original_ID );}
                else{
                    echo get_the_title($product->get_id());
                }
            ?>
    </span>

    <?php if($product->get_short_description()){ ?>
    <span class="woocommerce-product-details__short-description">
        <?php echo $product->get_short_description(); // WPCS: XSS ok. ?>
    </span>
    <?php } ?>
</h1>