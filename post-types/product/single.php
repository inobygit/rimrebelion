<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly
}

inoby_enqueue_parted_style("product", "post_types");
inoby_enqueue_parted_script("product", "post_types");
get_header("shop");

?>
<?php woocommerce_output_content_wrapper(); ?>

<?php while (have_posts()): ?>
<?php the_post(); ?>

<?php wc_get_template_part("content", "single-product"); ?>

<?php endwhile; ?>

<?php woocommerce_output_content_wrapper_end(); ?>

<?php 
$gallery_id = uniqid("inoby-slider-gallery-");
$sliderImagesGallery = rwmb_meta('slider-images');
$settings = apply_filters("inoby_slider_gallery_default_settings", [
  "has_lightbox" => false,
  "has_thumbs" => false,
  "has_arrows" => true,
  "per_view" => 1,
]);
if(!empty($sliderImagesGallery)){
?>
<div class="inoby-slider-gallery" id="<?= $gallery_id ?>" data-settings=<?= json_encode($settings) ?>>
    <div class="keen-slider gallery">
        <?php 
        foreach ($sliderImagesGallery as $image):
           ?>
        <div class="image-wrapper gallery-slide">
            <img src="<?= wp_get_attachment_image_url($image['ID'], 'o-12') ?>" alt="gb-image" loading="lazy">
        </div>
        <?php 
      endforeach; ?>
    </div>
</div>
<?php } ?>

<section class="product-description">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-wrap">
                    <?php 
                the_content(); ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php woocommerce_output_product_data_tabs(); ?>

<?php woocommerce_output_related_products(); ?>

<?php woocommerce_upsell_display(); ?>

<?php get_footer("shop"); /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */