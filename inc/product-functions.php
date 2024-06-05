<?php

function custom_more_title($title) {
    $more_text = esc_html(__('Show more ', 'rimrebellion'));
    return $more_text;
}
add_filter('woocommerce_product_search_field_more_title', 'custom_more_title');

function display_related_product_thumbnails() {
    $current_product_id = get_the_ID();
    $current_style_number = rwmb_meta("style-number", "", $current_product_id);
    $related_products_args = [
        "post_type" => "product",
        "posts_per_page" => -1,
        "meta_query" => [
            [
                "key" => "style-number",
                "value" => $current_style_number,
                "compare" => "=",
            ],
        ],
    ];
    $related_products_query = new WP_Query($related_products_args);

    if ($related_products_query->have_posts()) {
        echo '<div class="related-products-thumbnails">';
        while ($related_products_query->have_posts()) {
            $related_products_query->the_post();
            echo '<div class="related-product-thumbnail';
            if (get_the_ID() === $current_product_id) {
                echo " current-selected";
            }
            echo '">';
            if (has_post_thumbnail()) {
                echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), "o-2") . "</a>";
            } else {
                echo '<a href="' . get_permalink() . '"><img src="' . wc_placeholder_img_src() . '" alt="Placeholder" /></a>';
            }
            echo "</div>";
        }
        echo "</div>";
        wp_reset_postdata();
    }
}

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "taxonomies" => "color",
        "title" => __("Výber farby", "rimrebellion"),
        "fields" => [
            [
                "name" => __("Zvolte farbu", "rimrebellion"),
                "id" => "rc_attribute_term_color",
                "type" => "color",
            ],
        ],
    ];
    return $meta_boxes;
});

//Preselect first in stock product variation
function preselect_first_instock_variable($args) {
    if (count($args["options"]) > 0) {
        $options = [];
        $product = $args["product"];
        $has_default = count($product->get_default_attributes());
        if (!$has_default) {
            if (is_a($product, "WC_Product_Variable")) {
                foreach ($product->get_available_variations() as $key => $variation) {
                    $is_in_stock = $variation["is_in_stock"];
                    $attributes = $variation["attributes"];
                    if ($is_in_stock) {
                        foreach ($attributes as $key => $attribute) {
                            array_push($options, $attribute);
                        }
                        break;
                    }
                }
            }
            if (count($options) > 0) {
                $option_key = "";
                foreach ($options as $key => $option) {
                    $i = 0;
                    while ($i < count($args["options"])) {
                        if ($option == $args["options"][$i]) {
                            $option_key = $i;
                        }
                        $i++;
                    }
                }
                $args["selected"] = $args["options"][$option_key];
            } else {
                $args["selected"] = "";
            }
        }
    }
    return $args;
}
add_filter("woocommerce_dropdown_variation_attribute_options_args", "preselect_first_instock_variable", 10, 1);

add_filter('woocommerce_available_variation', function($available_variations, \WC_Product_Variable $variable, \WC_Product_Variation $variation) {
    if (empty($available_variations['price_html'])) {
        $available_variations['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }

    return $available_variations;
}, 10, 3);
?>