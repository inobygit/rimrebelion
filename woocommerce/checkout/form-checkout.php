<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined("ABSPATH")) {
    exit();
}

do_action("woocommerce_before_checkout_form", $checkout);
$order_button_text = apply_filters("woocommerce_order_button_text", __("Place order", "woocommerce"));

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters("woocommerce_checkout_must_be_logged_in_message", __("You must be logged in to checkout.", "woocommerce")));
    return;
}

if (WC()->cart->is_empty()) {
    rc_cart_empty();
    return;
}

$settings = apply_filters("rimrebelion_checkout_settings", [
    "wrp_classes" => "checkout-form-wrp",
    "tabs_classes" => "col-12",
    "step_classes" => "col-8",
    "totals_classes" => "col-4",
]);
?>

<div class="<?= $settings["wrp_classes"] ?>">
    <div class="row">
        <div class="<?= $settings["step_classes"] ?>">
            <div class="left-wrap">
                <div class="<?= $settings["tabs_classes"] ?>">
                    <?php rc_tabs([
              "tabs" => [
                  [
                      "icon" => get_theme_file_uri("/assets/icons/checkout-cart.svg"),
                      "name" => "step-1",
                      "active" => true,
                      "icon-alt" => __("Košík", "rimrebelion"),
                      "label" => __("Košík", "rimrebelion"),
                  ],
                  [
                      "icon" => get_theme_file_uri("/assets/icons/checkout-info.svg"),
                      "name" => "step-2",
                      "icon-alt" => __("Údaje", "rimrebelion"),
                      "label" => __("Údaje", "rimrebelion"),
                  ],
                  [
                      "icon" => get_theme_file_uri("/assets/icons/checkout-shipping-and-payment.svg"),
                      "name" => "step-3",
                      "icon-alt" => __("Doprava a platba", "rimrebelion"),
                      "label" => __("Doprava a platba", "rimrebelion"),
                  ],
                  [
                      "icon" => get_theme_file_uri("/assets/icons/checkout-payment.svg"),
                      "name" => "step-4",
                      "icon-alt" => __("Zhrnutie", "rimrebelion"),
                      "label" => __("Zhrnutie", "rimrebelion"),
                  ],
              ],
          ]); ?>
                </div>
                <div class="cart-step tab-content active" data-tab="step-1">
                    <h2><?= __("Košík", "rimrebelion") ?></h2>
                    <?php rc_cart(); ?>
                    <div class="checkout-actions">
                        <a href="<?= wc_get_page_permalink("shop") ?>"
                            class="link prev-arrow"><?= __("Pokračovať v nákupe", "rimrebelion") ?></a>
                        <?= rc_button([
                "text" => __("Prejsť na dodacie údaje", "rimrebelion"),
                "tag" => "button",
                "class" => "customer-info-btn tab-btn btn-next triangleright black",
                "data" => [
                    "data-security" => wp_create_nonce("rootcommerce-validate-cart-items"),
                    "data-current-tab" => "step-1",
                    "data-next-tab" => "step-2",
                ],
            ]) ?>
                    </div>
                    <div class="cart-cross-sell-wrp">
                        <?php rc_cart_cross_sell(); ?>
                    </div>
                </div>

                <div class="customer-info-step tab-content" style="display: none;" data-tab="step-2">
                    <h2><?= __("Fakturačné údaje", "rimrebelion") ?></h2>
                    <?php if (!(is_user_logged_in() || "no" === get_option("woocommerce_enable_checkout_login_reminder"))): ?>
                    <div class="not-logged-info">
                        <span><?= __("Už máš účet? Pre špeciálne výhody sa prihláste alebo zaregistrujte.", "rimrebelion") ?></span><br>
                        <a href="#" class="xoo-el-login-tgr"
                            data-popup="popup-login"><?= __("Prihlásiť sa", "rimrebelion") ?></a>
                        <a href="#" class="xoo-el-reg-tgr"
                            data-popup="popup-register"><?= __("Zaregistrovať sa", "rimrebelion") ?></a>
                    </div>
                    <?php endif; ?>
                </div>

                <form name="checkout" method="post" class="checkout woocommerce-checkout"
                    action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

                    <?php if ($checkout->get_checkout_fields()): ?>
                    <div class="customer-info-step tab-content" style="display:none" data-tab="step-2">
                        <?php do_action("woocommerce_checkout_before_customer_details"); ?>

                        <?php do_action("woocommerce_checkout_billing"); ?>
                        <?php do_action("woocommerce_checkout_shipping"); ?>

                        <?php do_action("woocommerce_checkout_after_customer_details"); ?>
                        <div class="checkout-actions">
                            <?= rc_button([
                  "text" => __("Späť do košíka", "rimrebelion"),
                  "tag" => "a",
                  "link" => "#0",
                  "class" => "tab-btn prev link prev-arrow",
                  "data" => ["data-prev-tab" => "step-1", "data-current-tab" => "step-2"],
              ]) ?>
                            <?= rc_button([
                  "text" => __("Prejsť na dopravu a platbu", "rimrebelion"),
                  "tag" => "button",
                  "class" => "tab-btn shipping-payment-btn btn-next triangleright black",
                  "data" => [
                      "data-security" => wp_create_nonce("rootcommerce-valid-customer-request"),
                      "data-current-tab" => "step-2",
                      "data-next-tab" => "step-3",
                  ],
              ]) ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="shipping-payment-step tab-content" style="display:none" data-tab="step-3">
                        <?php do_action("woocommerce_checkout_before_order_review"); ?>
                        <div class="woocommerce-checkout-review-order-table-wrp">
                            <?php woocommerce_order_review(); ?>
                        </div>
                        <div class="woocommerce-checkout-payment-wrp">
                            <?php woocommerce_checkout_payment(); ?>
                        </div>
                        <?php do_action("woocommerce_checkout_after_order_review"); ?>
                        <div class="checkout-actions">
                            <?= rc_button([
                  "text" => __("Späť na dodacie údaje", "rimrebelion"),
                  "tag" => "a",
                  "link" => "#0",
                  "class" => "tab-btn prev link prev-arrow",
                  "data" => ["data-prev-tab" => "step-2", "data-current-tab" => "step-3"],
              ]) ?>
                            <?= rc_button([
                  "text" => __("Prejsť na zhrnutie", "rimrebelion"),
                  "class" => "checkout-summary-btn tab-btn btn-next triangleright black",
                  "tag" => "button",
                  "data" => [
                      "data-security" => wp_create_nonce("rootcommerce-update-checkout-customer-request"),
                      "data-current-tab" => "step-3",
                      "data-next-tab" => "step-4",
                  ],
              ]) ?>
                        </div>
                    </div>

                    <div class="checkout-summary-step tab-content" style="display:none" data-tab="step-4">

                        <?php do_action("rc_before_checkout_summary"); ?>

                        <div class="checkout-summary-wrp">
                            <?php rc_checkout_summary(); ?>
                        </div>

                        <?php do_action("rc_after_checkout_summary"); ?>

                        <?php wc_get_template("checkout/terms.php"); ?>
                        <?php rc_checkout_create_account(); ?>
                        <?php rc_checkout_newsletter(); ?>

                        <?php do_action("woocommerce_review_order_before_submit"); ?>
                        <div class="checkout-actions">
                            <?= rc_button([
                  "text" => __("Späť na dopravu a platbu", "rimrebelion"),
                  "tag" => "a",
                  "link" => "#0",
                  "class" => "tab-btn prev link prev-arrow",
                  "data" => ["data-prev-tab" => "step-3", "data-current-tab" => "step-4"],
              ]) ?>

                            <?= apply_filters(
                  "woocommerce_order_button_html",
                  rc_button([
                      "text" => esc_html($order_button_text),
                      "name" => "woocommerce_checkout_place_order",
                      "id" => "place_order",
                      "tag" => "submit",
                      "class" => "btn-sm triangleright black",
                      "value" => esc_attr($order_button_text),
                      "data" => ["data-value" => esc_attr($order_button_text)],
                  ]),
              ) ?>

                            <?php do_action("woocommerce_review_order_after_submit"); ?>

                            <?php wp_nonce_field("woocommerce-process_checkout", "woocommerce-process-checkout-nonce"); ?>
                        </div>
                    </div>
                </form>
                <?php do_action("woocommerce_after_checkout_form", $checkout); ?>
            </div>
        </div>
        <div class="<?= $settings["totals_classes"] ?>">
            <div class="cart-step tab-content active" data-tab="step-1">
                <div class="cart-totals-wrp">
                    <?php rc_cart_totals(); ?>
                </div>
            </div>

            <div class="other-steps tab-content" style="display:none" data-tab="step-2-step-3-step-4">
                <div class="cart-summary-wrp">
                    <?php rc_cart_summary(); ?>
                </div>
                <div class="cart-totals-wrp">
                    <?php rc_cart_totals(); ?>
                </div>
            </div>

            <?php do_action("rc_after_checkout_totals", $checkout, $settings); ?>

        </div>
    </div>
</div>

<?php woocommerce_checkout_login_form(); ?>