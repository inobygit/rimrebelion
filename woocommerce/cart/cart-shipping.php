<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined("ABSPATH") || exit();

$formatted_destination = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package["destination"], ", ");
?>
<?php if ($available_methods): ?>
<div id="shipping_method" class="woocommerce-shipping-methods">
    <?php foreach ($available_methods as $method): ?>
    <div class="method">
        <?php if (1 < count($available_methods)) {
      printf(
        '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />',
        $index,
        esc_attr(sanitize_title($method->id)),
        esc_attr($method->id),
        checked($method->id, $chosen_method, false)
      );
    } else {
      printf(
        '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />',
        $index,
        esc_attr(sanitize_title($method->id)),
        esc_attr($method->id)
      );
    } ?>
        <label for="shipping_method_<?= $index ?>_<?= esc_attr(sanitize_title($method->id)) ?>">
            <span class="label"><?= $method->get_label() ?></span>
            <?php do_action("woocommerce_after_shipping_rate", $method, $index); ?>
        </label>
        <?php if ($method->get_cost() == '0.00'): ?>
        <span class="value"><?= __("Free", 'rimrebellion') ?></span>
        <?php ; else: ?>
        <span class="value"><?= rc_cart_shipping_method_price($method) ?></span>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<?php echo wp_kses_post(
  apply_filters(
    "woocommerce_cart_no_shipping_available_html",
    sprintf(esc_html__("No shipping options were found for %s.", "woocommerce") . " ", "<strong>" . esc_html($formatted_destination) . "</strong>")
  )
); ?>
<?php endif; ?>

<?php if ($show_package_details): ?>
<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . "</small></p>"; ?>
<?php endif; ?>