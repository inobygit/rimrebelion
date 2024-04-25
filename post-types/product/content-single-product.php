<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action("woocommerce_before_single_product");
$args = apply_filters(
    "inoby_product_args",
    [
        "classes" => [
            "breadcrumb" => "col-12",
            "gallery" => "col-7 col-lg-6 col-md-12",
            "summary" => "col-4 col-lg-6 col-md-12",
        ],
    ],
    $product,
);

$breadcrumb_class = $args["classes"]["breadcrumb"] ?? "";
$gallery_class = $args["classes"]["gallery"] ?? "";
$summary_class = $args["classes"]["summary"] ?? "";

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

$collections = wp_get_post_terms($product->get_id(), "collection");

// Zobrazenie termínov nad excerptom
?>
<?php get_template_part("template-parts/yoast-breadcrumbs", "yoast-breadcrumbs"); ?>


<div id="product-<?php the_ID(); ?>" <?php wc_product_class("", $product); ?>>

  <div class="row product-header">
    <div class="gallery-col column <?= $gallery_class ?>">
      <?php do_action("woocommerce_before_single_product_summary"); ?>
    </div>
    <div class="summary-col column <?= $summary_class ?>">
      <div class="summary entry-summary">
        <?php
/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
?>
        <div class="tags">
          <?php
          Inoby_Product::product_special_badge();
          Inoby_Product::new_product_badge();
          Inoby_Product::sale_badge_percentage();
          ?>
        </div>
        <?php
        woocommerce_template_single_title(); // Inoby_Product::get_manufacturer_name();
        if (!empty($collections) && !is_wp_error($collections)) {
            echo '<div class="collection-terms">';
            echo '<span class="collection-label">' . __("Collection: ", "rimrebellion") . "</span>";
            foreach ($collections as $collection) {
                echo '<span class="collection-term">' . esc_html($collection->name) . "</span>";
            }
            echo "</div>";
        }
        woocommerce_template_single_excerpt();
        display_related_product_thumbnails();
        // TODO color switching
        if ($product->is_type("simple")) {
            woocommerce_template_single_price();
        }
        woocommerce_template_single_add_to_cart();
        ?>
      </div>
    </div>
  </div>
</div>

<?php do_action("woocommerce_after_single_product"); ?>
