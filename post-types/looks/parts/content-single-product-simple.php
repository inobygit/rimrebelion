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

$product_id = $args['product_id'] ?? null;
$product = wc_get_product($product_id);
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

$collections = wp_get_post_terms($product_id, "collection");

?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class("", $product); ?>>

    <div class="row product-header">
        <div class="gallery-col column <?= $gallery_class ?>">
            <?php get_template_part("post-types/looks/parts/product-image-simple", null, ['product' => $product]); ?>
        </div>
        <div class="summary-col column <?= $summary_class ?>">
            <div class="summary entry-summary">
                <div class="tags">
                    <?php
                    $taxonomy = "product_specials";
                    $terms = get_the_terms($product->get_id(), $taxonomy);

                    if ($terms) {
                        foreach ($terms as $term) {
                            echo '<span class="tag special ' . $term->slug . '">' . esc_html__($term->name, "inoby") . "</span>";
                        }
                    }

                    $newness_days = 30;
                    $created = strtotime($product->get_date_created());

                    if ($product->is_on_sale() || time() - 60 * 60 * 24 * $newness_days < $created) {
                        if (time() - 60 * 60 * 24 * $newness_days < $created) {
                            echo '<span class="tag new-product">' . esc_html__("Novinka", "inoby") . "</span>";
                        }
                    }

                    if ($product->is_on_sale()) {
                        $max_percentage = 0;
                        if ($product->is_type("simple")) {
                        $max_percentage = (($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100;
                        } elseif ($product->is_type("variable")) {
                        foreach ($product->get_children() as $child_id) {
                            $variation = wc_get_product($child_id);
                            $price = $variation->get_regular_price();
                            $sale = $variation->get_sale_price();
                            if ($price != 0 && !empty($sale)) {
                            $percentage = (($price - $sale) / $price) * 100;
                            }
                            if ($percentage > $max_percentage) {
                            $max_percentage = $percentage;
                            }
                        }
                        }
                        if ($max_percentage > 0) {
                        echo "<span class='tag on-sale'>-" . round($max_percentage) . "%</span>";
                        } 
                    }

          ?>
                </div>
                <?php
                get_template_part("post-types/looks/parts/title-simple", null, ['product' => $product]); // Inoby_Product::get_manufacturer_name();
        $gender_terms = wp_get_post_terms($product->get_id(), 'gender');
        if (!empty($gender_terms) && !is_wp_error($gender_terms)) {
            echo '<div class="product-genders">';
            $unisex_only = array_filter($gender_terms, function($term) {
                return strtolower($term->name) === 'unisex';
            });

            if (!empty($unisex_only)) {
                echo '<span class="gender-term-box">' . esc_html('Unisex', 'rimrebellion') . '</span>';
            } else {
                foreach ($gender_terms as $term) {
                    echo '<span class="gender-term-box">' . esc_html($term->name, 'rimrebellion') . '</span>';
                }
            }
            echo '</div>';
        }
        get_template_part("post-types/looks/parts/short-description-simple", null, ['product' => $product]);
        echo '<div class="collection-terms">';
        foreach ($collections as $collection) {
            echo '<span class="collection-term">'.__('CAFÉ DU CYCLISTE', 'rimrebellion').'</span>';
        }
        echo "</div>";
        display_related_product_thumbnails($product->get_id());

            $colorMeta = rwmb_meta('color', null, $product->get_id());

            if(!empty($colorMeta)){
                echo '<p class="color-term">' . __('Color: ', 'rimrebellion') . $colorMeta . '</p>';
            }

        if ($product->is_type("simple")) {
            get_template_part("post-types/looks/parts/price-simple", null, ['product' => $product]);
        }
        	get_template_part( 'post-types/looks/parts/add-to-cart/' . $product->get_type(), null, ['product' => $product]);

        ?>
            </div>
        </div>
    </div>
</div>

<?php do_action("woocommerce_after_single_product"); ?>