<?php $term_id = isset(get_queried_object()->term_id) ? get_queried_object()->term_id : null; ?>
<div id="shop-sidebar" class="<?= Inoby_Config::show_shop_sidebar("false") ? "" : "hidden-shop-sidebar" ?>">
  <div class="mobile-header">
    <h3><?= __("Filtrovať produkty", "rimrebellion") ?></h3>
  </div>
  <button class="button color products-filter-init"><?= __("Filtrovanie", "rimrebellion") ?></button>
  <div class="filter-row">
    <form id="products-filter">
      <div class="fields">
        <?php rc_shop_filter($term_id); ?>
      </div>

      <input type="hidden" name="tx_n" value="<?= $term_id ? get_queried_object()->taxonomy : null ?>">
      <input type="hidden" name="tx_v" value="<?= $term_id ?>">
      <input type="hidden" name="paged" value="<?= get_query_var("paged") ? get_query_var("paged") : 1 ?>">
      <input type="hidden" name="disable_auto_apply_filter" value="false">

      <?php
// tento button sa zobrazi len na mobile - (product/archive.ts, product/filter.scss)
?>
      <button class="button filter-trigger"><?= __("Filtrovať", "inoby") ?></button>
    </form>
    <?php woocommerce_catalog_ordering(); ?>
  </div>
  <?php woocommerce_result_count(); ?>
</div>