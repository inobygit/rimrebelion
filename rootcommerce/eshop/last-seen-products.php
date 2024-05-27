<?php
$product_ids = $args['product_ids'] ?? [];
$limit = $args['limit'] ?? 8;
$orderby = $args['orderby'] ?? 'post__in';

var_dump($product_ids);
var_dump($limit);
var_dump($orderby);
if (count($product_ids)) {
    $ids = implode(',', array_filter(array_map( 'absint', $product_ids)));
    echo do_shortcode("[products ids='$ids' limit='$limit' orderby='$orderby']");
}