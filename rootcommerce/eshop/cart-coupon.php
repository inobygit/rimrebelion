<?php
global $wp_query;

if (wc_coupons_enabled()): ?>
<div class="form-wrp" style="display:<?= $wp_query->get("rc-ajax") == "apply_coupon" ? "block" : "block" ?>">
  <form>
    <label for="coupon_code" class="inplace-label"><?= __("Zadajte zľavový kód", "rimrebelion") ?></label>
    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
      placeholder="<?= __("Zadajte zľavový kód", "rimrebelion") ?>" />
    <input type="hidden" name="security" value="<?= wp_create_nonce("apply-coupon") ?>" />
    <?= rc_button([
        "text" => __("Použiť kód", "rimrebelion"),
        "tag" => "button",
        "class" => "apply-coupon-btn btn-sm button",
    ]) ?>
  </form>
  <?php wc_print_notices(); ?>
</div>
<?php endif; ?>