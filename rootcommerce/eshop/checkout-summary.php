<?php

defined("ABSPATH") || exit();

$raw_billing_address = WC()->customer->get_billing();
$billing_address = WC()->countries->get_formatted_address($raw_billing_address);
$raw_shipping_address = WC()->customer->get_shipping();
$shipping_address = WC()->countries->get_formatted_address($raw_shipping_address);
$shipping_method = rc_chosen_shipping_method();
$payment_method = rc_chosen_payment_method();
$ship_to_different_address = WC()->session->get("ship_to_different_address");
$ship_to_packeta_place = WC()->session->get("ship_to_packeta_place");
$billing_company = WC()->session->get("billing_company");
$billing_business_id = WC()->session->get("billing_business_id");
$billing_vat = WC()->session->get("billing_vat");
$billing_tax_id = WC()->session->get("billing_tax_id");
$notes = WC()->session->get("order_comments");
?>

<div class="row">
    <div class="col-12">
        <h2><?= __("Zhrnutie objednávky", "rimrebelion") ?></h2>
    </div>
</div>

<div class="row ship-pay-info">
    <?php if ($shipping_method): ?>
    <div class="col-12 ship">
        <h3><?= __("Doprava", "rimrebelion") ?></h3>
        <div class="wrp">
            <div class="wrp-head">
                <?php 
                if( $shipping_method->id === "local_pickup:2" ) {
                    echo '<img loading="lazy" class="icon" src="'. get_stylesheet_directory_uri() .'/assets/icons/local.svg" />';
                }
                if($shipping_method->id === 'packetery_shipping_method:packetery_carrier_131'){
                    echo '<img loading="lazy" class="icon" src="'. get_stylesheet_directory_uri() .'/assets/icons/zasielkovna.svg" />';
                }
                if($shipping_method->id === 'packetery_shipping_method:packetery_carrier_zpointsk'){
                    echo '<img loading="lazy" class="icon" src="'. get_stylesheet_directory_uri() .'/assets/icons/zasielkovna.svg" />';
                }
                ?>
                <p class="label"><?= $shipping_method->get_label() ?></p>
                <p class="value">
                    <?= ($shipping_method->get_cost() === '0.00' ? __('Free', 'rimrebellion') : rc_cart_shipping_method_price($shipping_method)) ?>
                </p>
                <a class="edit tab-btn prev" data-prev-tab="step-3" data-current-tab="step-4" href="#0"><img
                        loading="lazy" src="<?= get_theme_file_uri("/assets/icons/edit.svg") ?>"
                        alt="<?= __("Upraviť", "rimrebelion") ?>"></a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($payment_method): ?>
    <div class="col-12 pay">
        <h3><?= __("Platba", "rimrebelion") ?></h3>
        <div class="wrp">
            <div class="wrp-head">
                <?php if($payment_method->get_icon()): ?>
                <div class="icon">
                    <?= $payment_method->get_icon() ?>
                </div>
                <?php endif; ?>
                <p class="label"><?= $payment_method->get_title() ?></p>
                <?php 
		            $order = WC()->cart;
                    $fee_total = $order->get_fee_total();
                    $fee_tax = $order->get_fee_tax() ?? 0;
                     if ($fee_total != '0'){ ?>
                <p class="value"><?= wp_kses_post( wc_price($fee_total + $fee_tax) ) ?></p>
                <?php } else { 
                    esc_html_e('Free', 'rimrebellion');
                } ?>
                <a class="edit tab-btn prev" data-prev-tab="step-3" data-current-tab="step-4" href="#0"><img
                        loading="lazy" src="<?= get_theme_file_uri("/assets/icons/edit.svg") ?>"
                        alt="<?= __("Upraviť", "rimrebelion") ?>"></a>
            </div>
            <?php if ($payment_method->get_description()): ?>
            <div class="wrp-foot">
                <p class="desc"><?= $payment_method->get_description() ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row shipping-billing-info">
    <div class="col-4 col-md-12 shipping">
        <h3><?= __("Dodacie údaje", "rimrebelion") ?></h3>
        <address>
            <?= $ship_to_different_address || $ship_to_packeta_place ? $shipping_address : $billing_address ?>
            <hr>
            <?php if (WC()->customer->get_billing_phone()): ?>
            <br><?= esc_html(WC()->customer->get_billing_phone()) ?>
            <?php endif; ?>

            <?php if (WC()->customer->get_billing_email()): ?>
            <br><?= esc_html(WC()->customer->get_billing_email()) ?>
            <?php endif; ?>
        </address>
    </div>
    <div class="col-4 col-md-12 bill">
        <h3><?= __("Fakturačné údaje", "rimrebelion") ?></h3>
        <address>
            <?= $billing_address ?>
            <hr>
            <?php if (WC()->customer->get_billing_phone()): ?>
            <br><?= esc_html(WC()->customer->get_billing_phone()) ?>
            <?php endif; ?>

            <?php if (WC()->customer->get_billing_email()): ?>
            <br><?= esc_html(WC()->customer->get_billing_email()) ?>
            <?php endif; ?>
        </address>

    </div>
    <?php if (!empty($billing_business_id) || !empty($billing_vat) || !empty($billing_tax_id)): ?>
    <div class="col-4 col-md-12 company-additional-info">
        <h3><?= __("Firemné údaje", "rimrebelion") ?></h3>
        <address>
            <?php if (!empty($billing_company)): ?>
            <div><?= $billing_company ?></div>
            <?php endif; ?>
            <?php if (!empty($billing_business_id)): ?>
            <div><?= __("IČO", "rimrebelion") ?>: <?= $billing_business_id ?></div>
            <?php endif; ?>

            <?php if (!empty($billing_vat)): ?>
            <div><?= __("IČ DPH", "rimrebelion") ?>: <?= $billing_vat ?></div>
            <?php endif; ?>

            <?php if (rc_show_tax_id() && !empty($billing_tax_id)): ?>
            <div><?= __("DIČ", "rimrebelion") ?>: <?= $billing_tax_id ?></div>
            <?php endif; ?>
        </address>
    </div>
    <?php endif; ?>
</div>

<?php if (!empty($notes)): ?>
<div class="row">
    <div class="col-12 note-wrp">
        <h3><?= __("Poznámka", "rimrebelion") ?></h3>
        <div class="note"><?= $notes ?></div>
    </div>
</div>
<?php endif; ?>