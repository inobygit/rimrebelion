<?php
/**
 * Looks single page
 *
 */

defined("ABSPATH") || exit();

inoby_enqueue_parted_style("product", "post_types");
inoby_enqueue_parted_style("looks", "post_types");
inoby_enqueue_parted_script("looks", "post_types");

get_header();

$card_bg = rwmb_meta('look-header-background');
$heroItalic = rwmb_meta('look-italic-text');
$heroDesc = rwmb_meta('look-desc-text');
$heroBtnText = rwmb_meta('look-btn-text');
$heroBtnLink = rwmb_meta('look-btn-link');

$use_skus = rwmb_meta('look-use-skus');
$used_products = rwmb_meta('look-used-products');
$used_products_new = rwmb_meta('look-used-products-new');

?>

<div id="looks-single">
    <div class="header" <?= (!empty($card_bg) ? 'style="background-color: '. $card_bg .'"' : '') ?>>
        <div class="container">
            <div class="controls">
                <?php get_template_part("template-parts/yoast-breadcrumbs-w-arrows", "yoast-breadcrumbs"); ?>

            </div>
            <div class="row">
                <div class="col-6 col-lg-12 text-column">
                    <div class="looks-header-content-wrap">
                        <div class="looks-header-title">
                            <h1 class="woocommerce-looks-header__title page-title">
                                <?php echo the_title(); ?></h1>
                        </div>
                        <?php if(!empty($heroDesc)) : ?>
                        <div class="looks-header-desc">
                            <p>
                                <?php if(!empty($heroItalic)){ ?>
                                <i>
                                    <?= $heroItalic ?>
                                </i><br />
                                <?php } ?>
                                <?php echo $heroDesc ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($heroBtnText) && !empty($heroBtnLink)) : ?>
                        <a href="<?= $heroBtnLink ?>" class="button triangleBoth black"><?= $heroBtnText ?></a>
                        <?php ;else : ?>
                        <a href="#products" class="button triangleBoth black"><?= __("Show all", 'rimrebellion') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (has_post_thumbnail()) { ?>
                <div class="col-6 col-lg-12 image-column">
                    <?= get_the_post_thumbnail(null, 'o-6', ['loading'  => 'eager', 'alt' => 'look thumbnail']) ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php 
    if(!empty($use_skus) && $use_skus){
        if(!empty($used_products_new)){ 
                
        /**
         * Hook: woocommerce_before_single_product.
         *
         * @hooked woocommerce_output_all_notices - 10
         */
        do_action("woocommerce_before_single_product");
                ?>

    <div class="products" id="products">
        <?php foreach($used_products_new as $used_product) { 
                $args = [
                    'product_id' => $used_product,
                ];
                ?>
        <div class="product-wrp">
            <div class="container">
                <?php get_template_part("post-types/looks/parts/content-single-product-simple", null, $args);?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } 
    } else {
    if(!empty($used_products)){ 
        
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action("woocommerce_before_single_product");
        ?>

    <div class="products" id="products">
        <?php foreach($used_products as $used_product) { 
            $args = [
                'product_id' => $used_product,
            ];
            ?>
        <div class="product-wrp">
            <div class="container">
                <?php get_template_part("post-types/looks/parts/content-single-product-simple", null, $args);?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } 
    } ?>
</div>

<?php
get_footer();