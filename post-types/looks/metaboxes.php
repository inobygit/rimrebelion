<?php

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "context" => "normal",
        "title" => __("Custom metaboxes", "rimrebellion"),
        "post_types" => ["looks"],
        'tabs'  => [
            'settings'  => 'Settings',
            'header'    => 'Header',
        ],
        "fields" => [
            [
                "id" => "look-header-background",
                "name" => __("Header background color", "rimrebellion"),
                "type" => "color",
                'tab'   => 'settings',
            ],
            [
                "id" => "look-used-products",
                "name" => __("Used products", "rimrebellion"),
                "type" => "post",
                'post_type' => "product",
                'field_type' => 'select_advanced',
                'multiple'  => true,
                'tab'   => 'settings',
            ],
            [
                "id" => "look-italic-text",
                "name" => __("Italic text", "rimrebellion"),
                "type" => "text",
                'tab'   => 'header',
            ],
            [
                "id" => "look-desc-text",
                "name" => __("Description text", "rimrebellion"),
                "type" => "text",
                'tab'   => 'header',
            ],
            [
                'type'  => 'divider',
            ],
            [
                "id" => "look-btn-text",
                "name" => __("Button text", "rimrebellion"),
                "type" => "text",
                'tab'   => 'header',
            ],
            [
                "id" => "look-btn-link",
                "name" => __("Button link", "rimrebellion"),
                "type" => "text",
                'tab'   => 'header',
            ],
        ],
    ];
    return $meta_boxes;
});