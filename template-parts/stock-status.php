<?php
$p = $args["product"];

if (!$p) {
  return;
}

$stock_status = $p->get_stock_status();
?>

<!-- Stock Status -->
<div class="stock-status">
    <?php if ($stock_status == "instock") {
    echo '<span class="in-stock">' . esc_html__("In stock", "rimrebellion") . "</span>";
  } elseif ($stock_status == "do_7_dni") {
    echo '<span class="do-sedem-dni">' . esc_html__("Within 7 days", "rimrebellion") . "</span>";
  } elseif ($stock_status == "onbackorder") {
    echo '<span class="on-back-order">' . esc_html__("On backorder", "rimrebellion") . "</span>";
  } elseif ($stock_status == "outofstock") {
    echo '<span class="out-of-stock">' . esc_html__("Out of stock", "rimrebellion") . "</span>";
  } ?>
</div>