<?php
/**
 * Variable product add to cart
 */

defined("ABSPATH") || exit();

global $product;

$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists("wc_esc_json") ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, "UTF-8", true);

do_action("woocommerce_before_add_to_cart_form");
?>

<form class="variations_form cart" action="<?php echo esc_url(
    apply_filters("woocommerce_add_to_cart_form_action", $product->get_permalink()),
); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint(
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
        <?php foreach ($attributes as $attribute_name => $options): ?>
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
    do_action("woocommerce_single_variation");
    do_action("woocommerce_after_single_variation");
    ?>
  </div>
  <?php do_action("woocommerce_after_variations_table"); ?>

  <?php endif; ?>

  <?php do_action("woocommerce_after_variations_form"); ?>
</form>

<?php do_action("woocommerce_after_add_to_cart_form");