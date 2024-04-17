<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined("ABSPATH") || exit();

$order_id = $order->get_id();
?>

<div class="woocommerce-order">

  <?php if ($order):
      do_action("woocommerce_before_thankyou", $order_id); ?>

  <?php if ($order->has_status("failed")): ?>

  <section class="thank-you-section">
    <div class="container">
      <div class="row">
        <div class="col-12">

          <div class="thank-you-wrapper">
            <h1 class="<?= $order->status ?>"><?= __("Vaša objednávka nie je dokončená", "rimrebelion") ?></h1>
            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
              <?php esc_html_e(
                  "Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.",
                  "woocommerce",
              ); ?>
            </p>
            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
              <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
                class="button light pay"><?php esc_html_e("Pay", "woocommerce"); ?></a>
              <?php if (is_user_logged_in()): ?>
              <a href="<?php echo esc_url(wc_get_page_permalink("myaccount")); ?>"
                class="button light pay"><?php esc_html_e("My account", "woocommerce"); ?></a>
              <?php endif; ?>
            </p>
          </div>

        </div>
      </div>
    </div>
  </section>

  <?php //do_action("woocommerce_thankyou_" . $order->get_payment_method(), $order_id);
      //do_action("woocommerce_thankyou_" . $order->get_payment_method(), $order_id);
      //do_action("woocommerce_thankyou_" . $order->get_payment_method(), $order_id);
      //do_action("woocommerce_thankyou_" . $order->get_payment_method(), $order_id);

      else: ?>


  <section class="thank-you-section">
    <div class="container">
      <div class="row">
        <div class="col-12">

          <div class="thank-you-wrapper">
            <h1><?= __("Ďakujeme za vašu objednávku", "rimrebelion") ?></h1>
            <p class="heading-like">
              <?php echo sprintf(__("Vašu objednávku #%s sme úspešne zaevidovali.", "rimrebelion"), $order_id); ?>
            </p>
            <p class="fancy">
              <?php echo __("O jej stave Vás budeme informovať na Vašu e-mailovú adresu.", "rimrebelion"); ?>
            </p>
            <?php
      //do_action("woocommerce_thankyou_" . $order->get_payment_method(), $order_id);
      ?>
            <a class="button light triangleright triangleleft"
              href="<?= get_home_url() ?>"><?= __("Naspäť domov", "rimrebelion") ?></a>
          </div>


        </div>
      </div>
    </div>
  </section>
  <section class="thank-you-order">
    <?php do_action("woocommerce_thankyou", $order_id); ?>
  </section>

  <?php endif; ?>

  <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped


  else:
       ?>

  <section class="thank-you-section">
    <div class="container">
      <div class="row">
        <div class="col-12">

          <div class="thank-you-wrapper">
            <h1><?= __("Ďakujeme za vašu objednávku", "rimrebelion") ?></h1>

            <p>
              <?php echo apply_filters(
                  "woocommerce_thankyou_order_received_text",
                  esc_html__("Thank you. Your order has been received.", "woocommerce"),
                  null,
              );
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      ?>
            </p>

            <a class="button triangleright triangleleft light"
              href="<?= get_home_url() ?>"><?= __("Naspäť domov", "rimrebelion") ?></a>
          </div>

        </div>
      </div>
    </div>
  </section>

  <?php
  endif; ?>

</div>