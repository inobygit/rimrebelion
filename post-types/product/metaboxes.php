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
                    // "teeny" => true,
                ],
            ],
            [
                'id'    => 'show-delivery-info',
                'name'  => esc_html__('Show custom delivery info', 'rimrebellion'),
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
            [
                'group_title'   => __('Feature - {#}', 'rimrebellion'),
                'name'   => __('Key features', 'rimrebellion'),
                'id'            => 'key-features',
                'type'          => 'group',
                'clone'         => true,
                'collapsible'   => true,
                'sort_clone'    => true,
                'add_button'    => __('+ Add feature', 'rimrebellion'),
                'fields' => array(
                    [
                        'id'       => 'feature',
                        'name'    => __('Feature', 'rimrebellion'),
                        'type'     => 'textarea',
                        'sanitize_callback' => 'none',
                    ],
                )
            ],
            [
                'group_title'   => __('Technology - {headline}', 'rimrebellion'),
                'name'   => __('Technologies', 'rimrebellion'),
                'id'            => 'technologies',
                'type'          => 'group',
                'clone'         => true,
                'collapsible'   => true,
                'sort_clone'    => true,
                'add_button'    => __('+ Add technology', 'rimrebellion'),
                'fields' => array(
                    [
                        'id'               => "img",
                        'name'             => __('Obrázok', 'rimrebellion'),
                        'type'             => 'image_advanced',
                        'force_delete'     => false,
                        'max_file_uploads' => 1,
                        'max_status'       => false,
                        'image_size'       => 'thumbnail',
                    ],
                    [
                        'id'       => 'headline',
                        'name'   => __('Headline', 'rimrebellion'),
                        'type'     => 'text',
                        'sanitize_callback' => 'none',
                    ],
                    [
                        'id'       => 'text',
                        'name'    => __('Text', 'rimrebellion'),
                        'type'     => 'textarea',
                        'sanitize_callback' => 'none',
                    ],
                )
            ],
        ],
    ];
    return $meta_boxes;
});