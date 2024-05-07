<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined("ABSPATH") || exit();

inoby_enqueue_parted_style("product", "post_types");
inoby_enqueue_parted_script("product", "post_types");
get_header("shop");
$cat = $wp_query->get_queried_object();
$thumbnail_id = "";
$image = "";

if ($cat instanceof WP_Term) {
    $thumbnail_id = get_term_meta($cat->term_id, "thumbnail_id", true);
    $image = wp_get_attachment_url($thumbnail_id);
}
?>
<div class="woocommerce-hero">
    <div class="container fluid-right">
        <div class="row">
            <div class="col-6 col-lg-12 text-column">
                <div class="products-header-content-wrap">
                    <?php if (apply_filters("woocommerce_show_page_title", true)): ?>
                    <div class="products-header-title">
                        <h1 class="woocommerce-products-header__title page-title">
                            <?php echo woocommerce_page_title(); ?></h1>
                    </div>
                    <?php endif; ?>
                    <?php echo '<div class="products-header-image" style="background-image: url(' . $image . ');"></div>'; ?>
                    <div class="products-header-desc">
                        <?php //

// Hook woocommerce_archive_description.
            // @hooked woocommerce_taxonomy_archive_description - 10
            // @hooked woocommerce_product_archive_description - 10

            do_action("woocommerce_archive_description"); ?>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="25" viewBox="0 0 29 25" fill="none">
                        <path
                            d="M28.2335 11.5073L26.1564 7.91786C25.8011 7.30827 25.152 6.93026 24.4449 6.93026H20.7826V4.44422C20.7826 3.73927 20.4034 3.08882 19.7919 2.73805L15.4873 0.265631C14.8758 -0.0885438 14.1242 -0.0885438 13.5059 0.265631L9.21157 2.73805C8.60005 3.09222 8.22084 3.73927 8.22084 4.44422V6.93366H4.56198C3.85481 6.93366 3.20571 7.30827 2.85042 7.91786L0.766471 11.5073C0.411176 12.1169 0.411176 12.8729 0.766471 13.4825L2.85042 17.0787C3.20571 17.6883 3.85481 18.0663 4.56198 18.0663H8.22084V20.5524C8.22084 21.2573 8.59663 21.9078 9.20815 22.2585L13.5024 24.7344C14.114 25.0885 14.8724 25.0885 15.4839 24.7344L19.785 22.2585C20.3965 21.9044 20.7757 21.2573 20.7757 20.5524V18.0663H24.4346C25.1418 18.0663 25.7943 17.6883 26.1462 17.0787L28.2335 13.4791C28.5888 12.8695 28.5888 12.1203 28.2335 11.5039H28.2369L28.2335 11.5073Z"
                            fill="white" />
                    </svg>
                </div>
                <?php do_action("inoby_shop_archive_after_category_description"); ?>
            </div>
            <div class="col-6 col-lg-12 image-column">
                <svg width="0" height="0">
                    <defs>
                        <clipPath id="customClipPath">
                            <path stroke="#000000"
                                d="M725.912 0.00520173H128.01C107.698 0.00520173 88.931 10.8612 78.7514 28.4795L7.63465 151.812C-2.54489 169.472 -2.54489 191.273 7.63465 208.933L78.7514 332.484C88.931 350.144 107.698 361 128.01 361H726L725.912 0V0.00520173Z" />
                        </clipPath>
                    </defs>
                </svg>


                <?php if (!empty($thumbnail_id)) {
            echo '<img class="fluid-right" src="' . esc_url($image) . '" alt="">';
        } else {
            echo '<img class="fluid-right" src="' . esc_url(get_stylesheet_directory_uri() . "/assets/img/product-cat-thumb.webp") . '" alt="">';
        } ?>
            </div>
        </div>
    </div>
</div>

<?php get_template_part("template-parts/yoast-breadcrumbs", "yoast-breadcrumbs"); ?>

<?php if (is_product_category()) {
    $current_category = get_queried_object();
    $args = array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => $current_category->term_id
    );
    $subcategories = get_terms($args);
    $slides = array();
    foreach ($subcategories as $subcategory) {
        $slides[] = $subcategory;
    }?>
<div <?= inoby_block_attrs($attributes, ["class" => "component-category-slider"]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="category-slider">
                    <?php foreach($slides as $category): ?>
                    <div class="category-slide">
                        <a href="<?= get_term_link($category) ?>">
                            <div class="category-slide-inner">
                                <div class="category-slide-image">
                                    <?= wp_get_attachment_image(get_term_meta($category->term_id, "thumbnail_id", true), "o-2") ?>
                                </div>
                                <div class="category-slide-content">
                                    <p><?= $category->name ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<div class="container container-fluid products-wrp">
    <?php if (!is_search() && Inoby_Config::show_shop_sidebar("true")): ?>
    <div class="row">
        <div class="col-12">
            <div id="products-top-sidebar">
                <?php do_action("woocommerce_sidebar"); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div id="products-main" class="col">
            <?php
      /**
       * Hook: woocommerce_before_shop_loop.
       *
       * @hooked woocommerce_output_all_notices - 10
       * @hooked woocommerce_result_count - 20
       * @hooked woocommerce_catalog_ordering - 30
       */
      // echo '<div class="order-by-wrap">';
      // do_action("woocommerce_before_shop_loop");
      // echo "</div>";
      woocommerce_product_loop_start();

      if (wc_get_loop_prop("total")) {
          while (have_posts()) {
              the_post();

              /**
               * Hook: woocommerce_shop_loop.
               */
              do_action("woocommerce_shop_loop");

              wc_get_template_part("content", "product");
          } ?>
            <?php rc_shop_pagination(wc_get_loop_prop("total_pages"), wc_get_loop_prop("current_page")); ?>
            <?php
      } else {
          /**
           * Hook: woocommerce_no_products_found.
           *
           * @hooked wc_no_products_found - 10
           */
          do_action("woocommerce_no_products_found");
      }
      woocommerce_product_loop_end();
      ?>

            <?php
/**
       * Hook: woocommerce_after_main_content.
       *
       * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
       */
/**
        *  zakomentovane ukoncenie do_action("woocommerce_before_main_content");
       */
// do_action("woocommerce_after_main_content");
?>
        </div>
    </div>
</div>
<?php
do_action("inoby_after_shop_archive");
get_footer("shop");