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

$id = uniqid("child-related-slider");

$terms = get_the_terms( get_the_ID(), 'gender' );

// Empty array
$ids = array();

if($terms){
  foreach ( $terms as $term ) {
      array_push($ids, $term->term_id);
  }
}


if ($related_products): ?>
<section id="<?= $id ?>" class="container related-row related products" data-arrows="true">
    <div class="row">
        <div class="col-12 wrap">
            <div class="heading-wrap">
                <?php
    $heading = __("Súvisiace produkty", "rimrebellion");
    if ($heading) {
      echo "<h2>" . esc_html($heading) . "</h2>";
    }
?>
            </div>
            <?php  woocommerce_product_loop_start();

    foreach ($related_products as $related_product) {
      $post_object = get_post($related_product->get_id());

      $post_terms = get_the_terms($post_object, 'gender');
      $termIds = [];
      if($post_terms){
        foreach ( $post_terms as $post_term ) {
            array_push($termIds, $post_term->term_id);
        }
      }


        if (array_intersect($termIds, $ids)) {
          setup_postdata($GLOBALS["post"] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
          wc_get_template_part("content", "product");
        }
    }
    woocommerce_product_loop_end();
    ?>
        </div>
    </div>
</section>
<?php endif;

wp_reset_postdata();