<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined("ABSPATH") || exit(); ?>
<div class="cart-totals-wrap">
    <div class="cart-totals">
        <?php wc_print_notices(); ?>
        <h3 class="totals-headline"><?= __("Súhrn", "rimrebelion") ?></h3>
        <div class="cart-totals-simple subtotal">
            <p class="label"><?= __("Cena za tovar", "rimrebelion") ?></p>
            <p class="value"><?php wc_cart_totals_subtotal_html(); ?></p>
        </div>

        <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
        <div class="cart-totals-simple coupon">
            <div class="title-wrp">
                <p class="title"><?= __("Zľavový kód:", "rimrebelion") ?></p>
                <p class="label"><?= $coupon->get_code() ?></p>
            </div>
            <p class="value"><?= rc_cart_totals_coupon_html($coupon) ?></p>
        </div>
        <?php endforeach; ?>

        <?php $shipping_method = rc_chosen_shipping_method(); ?>
        <?php if ($shipping_method): ?>
        <div class="cart-totals-simple shipping">
            <div class="title-wrp">
                <p class="title"><?= __("Poštovné a doprava", "rimrebelion") ?></p>
                <p class="label sublabel"><?= $shipping_method->get_label() ?></p>
            </div>
            <p class="value"><?= rc_cart_shipping_method_price($shipping_method) ?></p>
        </div>
        <?php endif; ?>

        <?php foreach (WC()->cart->get_fees() as $fee): ?>
        <div class="cart-totals-simple fee">
            <p class="label"><?= esc_html($fee->name) ?></p>
            <p class="value"><?php wc_cart_totals_fee_html($fee); ?></p>
        </div>
        <?php endforeach; ?>

        <div class="cart-coupon-wrp">
            <?php rc_cart_coupon(); ?>
        </div>

        <div class="total">
            <p class="label"><?= __("Spolu k úhrade:", "rimrebelion") ?></p>
            <p class="value"><?= WC()->cart->get_total() ?></p>
        </div>
        <div class="payment-proof">
            <h4>
                <?= __("Bezpečné online platby", 'rimrebellion') ?>
                <img src="<?= get_theme_file_uri("/assets/svg/gp-logo.svg") ?>" alt="gp-payment">
            </h4>
            <p>
                <?= __("Prostredníctvom platobnej brány GP webpay. Popredného svetového poskytovateľa platobných technológií so zabezpečením:", 'rimrebellion') ?>
            </p>
            <p class="label secure">
                <span><b><?= __("3D secure - ", "rimrebelion") ?></b><?= __("najvyšie možné zabezpečenie pre transakcie", 'rimrebellion') ?></span>
            </p>
            <p class="label fraud">
                <span><b><?= __("Fraud detection - ", "rimrebelion") ?></b><?= __("funkcie pre aktívne obmedzenie podvodov", 'rimrebellion') ?></span>
            </p>
            <img class="payment" style="margin-top: 1rem;" src="<?= get_theme_file_uri("/assets/svg/payment.svg") ?>"
                alt="payment">
        </div>
    </div>
</div>