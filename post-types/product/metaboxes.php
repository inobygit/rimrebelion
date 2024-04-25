<?php

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "context" => "normal",
        "title" => __("Custom metaboxes", "rimrebellion"),
        "post_types" => ["product"],
        "fields" => [
            [
                "id" => "product-type",
                "name" => __("Product type", "rimrebellion"),
                "type" => "text",
            ],
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
                "type" => "text",
            ],
        ],
    ];
    return $meta_boxes;
});
