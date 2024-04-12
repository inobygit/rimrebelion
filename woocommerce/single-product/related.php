<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined("ABSPATH")) {
    exit();
}

$id = uniqid("related-slider");

if ($related_products): ?>
<section id="<?= $id ?>" class="related products">
  <div class="container">
    <div class="row">
      <div class="col-12 wrap">
        <?php
        $heading = __("Súvisiace produkty", "rimrebellion");
        if ($heading) {
            echo "<h3>" . esc_html($heading) . "</h3>";
        }
        woocommerce_product_loop_start();

        foreach ($related_products as $related_product) {
            $post_object = get_post($related_product->get_id());

            setup_postdata($GLOBALS["post"] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

            wc_get_template_part("content", "product");
        }
        woocommerce_product_loop_end();
        get_template_part("template-parts/keen-arrows", "keen-arrows", ["slider-id" => $id]);
        ?>
      </div>
    </div>
  </div>
</section>
<?php endif;

wp_reset_postdata();