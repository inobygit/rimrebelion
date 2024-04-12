<?php
if (!defined("ABSPATH")) {
    exit();
}

$base = esc_url_raw(str_replace(999999999, "%#%", remove_query_arg("add-to-cart", add_query_arg("paged", "999999999"))));
$format = "?paged=%#%";

if ($args["total"] <= 1) {
    return;
}
$current = max(1, $args["current"]);
?>
<div class="pagination-wrap col-12">
  <nav id="pagination">
    <?= paginate_links(
        apply_filters("woocommerce_pagination_args", [
            "base" => $base,
            "format" => $format,
            "add_args" => false,
            "current" => $current,
            "total" => $args["total"],
            "prev_next" => true,
            "prev_text" => __("", "woocommerce"),
            "next_text" => __("", "woocommerce"),
            "type" => "list",
            "end_size" => 1,
            "mid_size" => 2,
        ]),
    ) ?>
  </nav>
</div>