<?php

function get_gallery_image_html($post_thumbnail_id, $image_size, $attrs) {
$thumbnail_size = apply_filters("inoby_gallery_thumbnail_size", "thumbnail");
    $full_size = apply_filters("inoby_gallery_full_size", "o-12");
    $thumbnail_src = wp_get_attachment_image_src($post_thumbnail_id, $thumbnail_size);
    $full_src = wp_get_attachment_image_src($post_thumbnail_id, $full_size);
    $alt_text = trim(wp_strip_all_tags(get_post_meta($post_thumbnail_id, "_wp_attachment_image_alt", true)));
    $image = wp_get_attachment_image(
      $post_thumbnail_id,
      $image_size,
      false,
      apply_filters(
        "inoby_gallery_image_html_attachment_image_params",
        [
          "title" => _wp_specialchars(get_post_field("post_title", $post_thumbnail_id), ENT_QUOTES, "UTF-8", true),
          "data-caption" => _wp_specialchars(get_post_field("post_excerpt", $post_thumbnail_id), ENT_QUOTES, "UTF-8", true),
          "data-src" => esc_url($full_src[0]),
          "data-large_image" => esc_url($full_src[0]),
          "data-large_image_width" => esc_attr($full_src[1]),
          "data-large_image_height" => esc_attr($full_src[2]),
        ],
        $post_thumbnail_id,
        $image_size,
        false
      )
    );

    $default_attrs = [
      "class" => "woocommerce-product-gallery__image post-img",
      "data-thumb" => esc_url($thumbnail_src[0]),
      "data-thumb-alt" => esc_attr($alt_text),
    ];

    $attrs = wp_parse_args($attrs, $default_attrs);

    return '<div ' . array_to_html_attrs($attrs) . '><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
}

function custom_more_title($title) {
    $more_text = esc_html(__('Show more ', 'rimrebellion'));
    return $more_text;
}
add_filter('woocommerce_product_search_field_more_title', 'custom_more_title');

function display_related_product_thumbnails($product_id = null) {
    if($product_id) {
        $current_product_id = $product_id;
    } else {
        $current_product_id = get_the_ID();
    }
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


add_filter('woocommerce_available_variation', function($available_variations, \WC_Product_Variable $variable, \WC_Product_Variation $variation) {
    if (empty($available_variations['price_html'])) {
        $available_variations['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }

    return $available_variations;
}, 10, 3);
?>