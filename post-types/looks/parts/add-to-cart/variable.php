<?php
/**
 * Variable product add to cart
 */

defined("ABSPATH") || exit();
		wp_enqueue_script( 'wc-add-to-cart-variation' );

$product = $args['product'] ?? null;
$attributes = $product->get_variation_attributes();
$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
$available_variations = $get_variations ? $product->get_available_variations() : false;

$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists("wc_esc_json") ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, "UTF-8", true);

do_action("woocommerce_before_add_to_cart_form");
?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint(
    $product->get_id(),
); ?>" data-product_variations="<?php echo $variations_attr; ?>">
    <?php do_action("woocommerce_before_variations_form"); ?>


    <?php if (empty($available_variations) && false !== $available_variations): ?>
    <p class="stock out-of-stock"><?php echo esc_html(
      apply_filters("woocommerce_out_of_stock_message", __("This product is currently out of stock and unavailable.", "woocommerce")),
  ); ?></p>
    <?php else: ?>
    <div class="single_variation_wrap">

        <table class="variations" cellspacing="0" role="presentation">
            <tbody>
                <?php foreach ($attributes as $attribute_name => $options): 
                    ?>
                <tr>
                    <td class="value">
                        <label class="inplace-label" for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>"><?php echo wc_attribute_label(
    $attribute_name,
); ?></label>
                        <?php wc_dropdown_variation_attribute_options([
                "options" => $options,
                "attribute" => $attribute_name,
                "product" => $product,
            ]); ?>
                    </td>
                </tr>
                <?php if ($attribute_name == "pa_size") {
            echo "<td style='display: none;'>TODO Veľkostná tabuľka</td>";
        } ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php do_action("woocommerce_before_single_variation"); ?>
        <?php
		echo '<div class="woocommerce-variation single_variation">'; ?>
        <script type="text/template" id="tmpl-variation-template">
            <div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
	<div class="woocommerce-variation-sku"><span class="sku-label"><?= __("Kód produktu: ", "rimrebelion") ?></span>{{{ data.variation.sku }}}</div>
	<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
</script>
        <?php echo '</div>';
    get_template_part( 'post-types/looks/parts/add-to-cart/variation-add-to-cart-button', null, ['product' => $product]);
    do_action("woocommerce_after_single_variation");
    ?>
    </div>
    <?php do_action("woocommerce_after_variations_table"); ?>

    <?php endif; ?>

    <?php do_action("woocommerce_after_variations_form"); ?>
</form>

<?php do_action("woocommerce_after_add_to_cart_form");