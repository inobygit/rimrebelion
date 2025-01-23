<?php

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "context" => "normal",
        "title" => __("Custom metaboxes", "rimrebellion"),
        "post_types" => ["product"],
        "fields" => [
            [
                "id" => "style-number",
                "name" => __("Style number", "rimrebellion"),
                "type" => "text",
            ],
            [
                "id" => "color",
                "name" => __("Color", "rimrebellion"),
                "type" => "text",
            ],
            [
                "id" => "additional-info",
                "name" => esc_html__("Additional info", "rimrebellion"),
                "type" => "wysiwyg",
                "raw" => false,
                "options" => [
                    "textarea_rows" => 4,
                    "teeny" => true,
                ],
            ],
            [
                'id'    => 'show-delivery-info',
                'name'  => esc_html__( 'Show custom delivery info', 'rimrebellion' ),
                'type'  => 'checkbox',
                'std'   => 0,
            ],
            [
                "id" => "delivery-info",
                "name" => esc_html__("Delivery info", "rimrebellion"),
                "type" => "wysiwyg",
                "raw" => true,
                'sanitize_callback' => 'none',
                "options" => [
                    "textarea_rows" => 4,
                    "teeny" => true,
                ],
                'visible'   => ['show-delivery-info', '=', 1],
            ],
            [
                "id" => "range-temperature",
                "name" => __("Range temperature", "rimrebellion"),
                "type" => "text",
            ],
            [
                "id" => "technical-qualificative",
                "name" => __("Technical qualificative", "rimrebellion"),
                "type" => "text",
            ],
            [
                "id" => "slider-images",
                "name" => __("Slider Images", "rimrebellion"),
                "type" => "image_advanced",
            ],
        ],
    ];
    return $meta_boxes;
});