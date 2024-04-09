<?php

defined("ABSPATH") || exit(); ?>

<div class="cart-summary">
  <h3 class="cart-headline"><?= __("Sumár", "rimrebelion") ?></h3>
  <div class="items-wrap">
    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): ?>

    <?php
    $_product = apply_filters("woocommerce_cart_item_product", $cart_item["data"], $cart_item, $cart_item_key);
    $product_id = apply_filters("woocommerce_cart_item_product_id", $cart_item["product_id"], $cart_item, $cart_item_key);
    ?>

    <?php if (
        $_product &&
        $_product->exists() &&
        $cart_item["quantity"] > 0 &&
        apply_filters("woocommerce_cart_item_visible", true, $cart_item, $cart_item_key)
    ): ?>
    <?php $product_permalink = apply_filters(
        "woocommerce_cart_item_permalink",
        $_product->is_visible() ? $_product->get_permalink($cart_item) : "",
        $cart_item,
        $cart_item_key,
    ); ?>

    <?php do_action("rc_before_cart_summary_item", $cart_item); ?>

    <div class="item">
      <div class="name">
        <?php if (!$product_permalink) {
            echo wp_kses_post(
                apply_filters(
                    "woocommerce_cart_item_name",
                    sprintf('<span class="product-name">%s</span> - %dx', $_product->get_name(), $cart_item["quantity"]),
                    $cart_item,
                    $cart_item_key,
                ) . "&nbsp;",
            );
        } else {
            echo wp_kses_post(
                apply_filters(
                    "woocommerce_cart_item_name",
                    sprintf(
                        '<a href="%s" class="product-name">%s</a> - %dx',
                        esc_url($product_permalink),
                        $_product->get_name(),
                        $cart_item["quantity"],
                    ),
                    $cart_item,
                    $cart_item_key,
                ),
            );
        } ?>
      </div>

      <div class="subtotal">
        <?= apply_filters(
            "woocommerce_cart_item_subtotal",
            WC()->cart->get_product_subtotal($_product, $cart_item["quantity"]),
            $cart_item,
            $cart_item_key,
        ) ?>
      </div>
    </div>

    <?php do_action("rc_after_cart_summary_item", $cart_item); ?>

    <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>