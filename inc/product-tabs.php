<?php
add_filter("woocommerce_product_tabs", "rimrebellion_add_product_tab_additional_info", 9999);
function rimrebellion_add_product_tab_additional_info($tabs) {
    $tabs["product-details"] = [
        "title" => __("Product details", "rimrebellion"),
        "priority" => 1, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        "callback" => "rimrebellion_product_tab_additional_info", // TAB CONTENT CALLBACK
    ];
    return $tabs;
}

function rimrebellion_product_tab_additional_info() {
    global $product;
    // echo "Whatever content for " . $product->get_name();
    $additional_info = get_post_meta($product->get_id(), "additional-info", true);
    if (!empty($additional_info)) {
        echo wpautop($additional_info);
    } else {
        echo get_the_excerpt($product->get_id());
    }
}

add_filter("woocommerce_product_tabs", "rimrebellion_add_product_tab_delivery_info", 9999);
function rimrebellion_add_product_tab_delivery_info($tabs) {
    $tabs["delivery-info"] = [
        "title" => __("Delivery info", "rimrebellion"),
        "priority" => 2, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        "callback" => "rimrebellion_product_tab_delivery_info", // TAB CONTENT CALLBACK
    ];
    return $tabs;
}

function rimrebellion_product_tab_delivery_info() {
    global $product;
    echo "Delivery info for " . $product->get_name();
    // $additional_info = get_post_meta($product->get_id(), "delivery-info", true);
    // if (!empty($additional_info)) {
    //     echo wpautop($additional_info);
    // }
}

/**
 * @snippet WooCommerce Remove Description Tab
 */
add_filter("woocommerce_product_tabs", "rimrebellion_remove_desc_tab", 9999);
function rimrebellion_remove_desc_tab($tabs) {
    unset($tabs["description"]);
    return $tabs;
}

/**
 * @snippet WooCommerce Remove Additional Info Product Tab
 */
add_filter("woocommerce_product_tabs", "rimrebellion_remove_info_tab", 9999);
function rimrebellion_remove_info_tab($tabs) {
    unset($tabs["additional_information"]);
    return $tabs;
}

?>