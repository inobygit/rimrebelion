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
    echo '<span class="stock instock">' . esc_html__("In stock", "rimrebellion") . "</span>";
  } elseif ($stock_status == "do_7_dni") {
    echo '<span class="stock dosedemdni">' . esc_html__("Within 7 days", "rimrebellion") . "</span>";
  } elseif ($stock_status == "onbackorder") {
    echo '<span class="stock onbackorder">' . esc_html__("On backorder", "rimrebellion") . "</span>";
  } elseif ($stock_status == "outofstock") {
    echo '<span class="stock outofstock">' . esc_html__("Out of stock", "rimrebellion") . "</span>";
  } ?>
</div>