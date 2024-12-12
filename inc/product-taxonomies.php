<?php
function custom_taxonomy_color() {
    $labels = [
        "name" => _x("Colors", "taxonomy general name"),
        "singular_name" => _x("Color", "taxonomy singular name"),
        "search_items" => __("Search Colors"),
        "all_items" => __("All Colors"),
        "edit_item" => __("Edit Color"),
        "update_item" => __("Update Color"),
        "add_new_item" => __("Add New Color"),
        "new_item_name" => __("New Color Name"),
        "menu_name" => __("Colors"),
    ];

    $args = [
        "hierarchical" => true,
        "labels" => $labels,
        "show_ui" => true,
        "public" => false,
        "show_admin_column" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "color"],
    ];

    register_taxonomy("color", "product", $args);
}
add_action("init", "custom_taxonomy_color", 0);

function custom_taxonomy_gender() {
    $labels = [
        "name" => _x("Genders", "taxonomy general name"),
        "singular_name" => _x("Gender", "taxonomy singular name"),
        "search_items" => __("Search Genders"),
        "all_items" => __("All Genders"),
        "edit_item" => __("Edit Gender"),
        "update_item" => __("Update Gender"),
        "add_new_item" => __("Add New Gender"),
        "new_item_name" => __("New Gender Name"),
        "menu_name" => __("Genders"),
    ];

    $args = [
        "hierarchical" => true,
        "labels" => $labels,
        "show_ui" => true,
        "public" => false,
        "show_admin_column" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "gender"],
    ];

    register_taxonomy("gender", "product", $args);
}
add_action("init", "custom_taxonomy_gender", 0);

function custom_taxonomy_department() {
    $labels = [
        "name" => _x("Departments", "taxonomy general name"),
        "singular_name" => _x("Department", "taxonomy singular name"),
        "search_items" => __("Search Departments"),
        "all_items" => __("All Departments"),
        "edit_item" => __("Edit Department"),
        "update_item" => __("Update Department"),
        "add_new_item" => __("Add New Department"),
        "new_item_name" => __("New Department Name"),
        "menu_name" => __("Departments"),
    ];

    $args = [
        "hierarchical" => true,
        "labels" => $labels,
        "show_ui" => true,
        "public" => false,
        "show_admin_column" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "department"],
    ];

    register_taxonomy("department", "product", $args);
}
add_action("init", "custom_taxonomy_department", 0);

function custom_taxonomy_collection() {
    $labels = [
        "name" => _x("Collections", "taxonomy general name"),
        "singular_name" => _x("Collection", "taxonomy singular name"),
        "search_items" => __("Search Collections"),
        "all_items" => __("All Collections"),
        "edit_item" => __("Edit Collection"),
        "update_item" => __("Update Collection"),
        "add_new_item" => __("Add New Collection"),
        "new_item_name" => __("New Collection Name"),
        "menu_name" => __("Collections"),
    ];

    $args = [
        "hierarchical" => true,
        "labels" => $labels,
        "show_ui" => true,
        "public" => false,
        "show_admin_column" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "collection"],
    ];

    register_taxonomy("collection", "product", $args);
}
add_action("init", "custom_taxonomy_collection", 0);

function custom_taxonomy_main_collection() {
    $labels = [
        "name" => _x("Main Collections", "taxonomy general name"),
        "singular_name" => _x("Main Collection", "taxonomy singular name"),
        "search_items" => __("Search Main Collections"),
        "all_items" => __("All Main Collections"),
        "edit_item" => __("Edit Main Collection"),
        "update_item" => __("Update Main Collection"),
        "add_new_item" => __("Add New Main Collection"),
        "new_item_name" => __("New Main Collection Name"),
        "menu_name" => __("Main Collections"),
    ];

    $args = [
        "hierarchical" => true,
        "labels" => $labels,
        "show_ui" => true,
        "public" => false,
        "show_admin_column" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "main-collection"],
    ];

    register_taxonomy("main-collection", "product", $args);
}
add_action("init", "custom_taxonomy_main_collection", 0);

function custom_taxonomy_main_category() {
    $labels = [
        "name" => _x("Main Categories", "taxonomy general name"),
        "singular_name" => _x("Main Category", "taxonomy singular name"),
        "search_items" => __("Search Main Categories"),
        "all_items" => __("All Main Categories"),
        "edit_item" => __("Edit Main Category"),
        "update_item" => __("Update Main Category"),
        "add_new_item" => __("Add New Main Category"),
        "new_item_name" => __("New Main Category Name"),
        "menu_name" => __("Main Categories"),
    ];

    $args = [
        "hierarchical" => true,
        "labels" => $labels,
        "show_ui" => true,
        "public" => false,
        "show_admin_column" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "main-category"],
    ];

    register_taxonomy("main-category", "product", $args);
}
add_action("init", "custom_taxonomy_main_category", 0);

function custom_taxonomy_size_chart() {
    $labels = [
        "name" => _x("Size charts", "taxonomy general name"),
        "singular_name" => _x("Size chart", "taxonomy singular name"),
        "search_items" => __("Search Size charts"),
        "all_items" => __("All Size charts"),
        "edit_item" => __("Edit Size chart"),
        "update_item" => __("Update Size chart"),
        "add_new_item" => __("Add New Size chart"),
        "new_item_name" => __("New Size chart Name"),
        "menu_name" => __("Size charts"),
    ];

    $args = [
        "hierarchical" => true,
        "labels" => $labels,
        "show_ui" => true,
        "public" => false,
        "show_admin_column" => true,
        "query_var" => true,
        "rewrite" => ["slug" => "size-chart"],
    ];

    register_taxonomy("size-chart", "product", $args);
}
add_action("init", "custom_taxonomy_size_chart", 0);

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "taxonomies" => "size-chart",
        "title" => __("Tabuľka", "rimrebellion"),
        "fields" => [
            [
                'id'  => 'table-heading',
                'name'  => __('Nadpis tabuľky', 'inoby'),
                'type'  => 'text',
            ],
            [
                'id'  => 'table-desc',
                'name'  => __('Popis tabuľky', 'inoby'),
                'type'  => 'wysiwyg',
                'raw'   => true,
            ],
            [
                'id'  => 'table-number-columns',
                'name'  => __('Počet stĺpcov', 'inoby'),
                'type'  => 'range',
                'min' => 1,
                'step'  => 1,
                'max' => 12,
                'std'   => 1,
            ],
            [
                'id'  => 'table-headings-group',
                'group_title' => __("Nadpisy", 'inoby'),
                'type'  => 'group',
                'clone' => false,
                'collapsible' => true,
                'default_state' => 'collapsed',
                'fields'  => [
                [
                    'id'  => 'table-heading-1',
                    'name'  => __("Nadpis stĺpca 1", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 0],
                ],
                [
                    'id'  => 'table-heading-2',
                    'name'  => __("Nadpis stĺpca 2", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 1],
                ],
                [
                    'id'  => 'table-heading-3',
                    'name'  => __("Nadpis stĺpca 3", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 2],
                ],
                [
                    'id'  => 'table-heading-4',
                    'name'  => __("Nadpis stĺpca 4", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 3],
                ],
                [
                    'id'  => 'table-heading-5',
                    'name'  => __("Nadpis stĺpca 5", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 4],
                ],
                [
                    'id'  => 'table-heading-6',
                    'name'  => __("Nadpis stĺpca 6", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 5],
                ],
                [
                    'id'  => 'table-heading-7',
                    'name'  => __("Nadpis stĺpca 7", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 6],
                ],
                [
                    'id'  => 'table-heading-8',
                    'name'  => __("Nadpis stĺpca 8", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 7],
                ],
                [
                    'id'  => 'table-heading-9',
                    'name'  => __("Nadpis stĺpca 9", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 8],
                ],
                [
                    'id'  => 'table-heading-10',
                    'name'  => __("Nadpis stĺpca 10", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 9],
                ],
                [
                    'id'  => 'table-heading-11',
                    'name'  => __("Nadpis stĺpca 11", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 10],
                ],
                [
                    'id'  => 'table-heading-12',
                    'name'  => __("Nadpis stĺpca 12", 'inoby'),
                    'type'  => 'text',
                    'visible' => ['table-number-columns', '>', 11],
                ],
                ],
            ],
            [
                'id'  => 'table-rows-group',
                'group_title' => __("Riadky", 'inoby'),
                'type'  => 'group',
                'clone' => false,
                'collapsible' => true,
                'default_state' => 'collapsed',
                'fields'  => [
                [
                    'id'  => 'row',
                    'group_title' => __("Riadok {row-1}", 'inoby'),
                    'type'  => 'group',
                    'clone' => true,
                    'collapsible' => true,
                    'sort_clone' => true,
                    'default_state' => 'collapsed',
                    'fields'  => [
                    [
                        'id'  => 'row-icon',
                        'name'  => __("Ikona riadku", 'inoby'),
                        'type'  => 'image_advanced',
                        'max_file_uploads' => 1,
                    ],
                    [
                        'id'  => 'row-1',
                        'name'  => __("Stĺpec 1", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 0],
                    ],
                    [
                        'id'  => 'row-2',
                        'name'  => __("Stĺpec 2", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 1],
                    ],
                    [
                        'id'  => 'row-3',
                        'name'  => __("Stĺpec 3", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 2],
                    ],
                    [
                        'id'  => 'row-4',
                        'name'  => __("Stĺpec 4", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 3],
                    ],
                    [
                        'id'  => 'row-5',
                        'name'  => __("Stĺpec 5", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 4],
                    ],
                    [
                        'id'  => 'row-6',
                        'name'  => __("Stĺpec 6", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 5],
                    ],
                    [
                        'id'  => 'row-7',
                        'name'  => __("Stĺpec 7", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 6],
                    ],
                    [
                        'id'  => 'row-8',
                        'name'  => __("Stĺpec 8", 'inoby'),
                        'type'  => 'text',
                        'visible' => ['table-number-columns', '>', 7],
                    ],
                    [
                        'id' => 'row-9',
                        'name' => __("Stĺpec 9", 'inoby'),
                        'type' => 'text',
                        'visible' => ['table-number-columns', '>', 8],
                    ],
                    [
                        'id' => 'row-10',
                        'name' => __("Stĺpec 10", 'inoby'),
                        'type' => 'text',
                        'visible' => ['table-number-columns', '>', 9],
                    ],
                    [
                        'id' => 'row-11',
                        'name' => __("Stĺpec 11", 'inoby'),
                        'type' => 'text',
                        'visible' => ['table-number-columns', '>', 10],
                    ],
                    [
                        'id' => 'row-12',
                        'name' => __("Stĺpec 12", 'inoby'),
                        'type' => 'text',
                        'visible' => ['table-number-columns', '>', 11],
                    ],
                    ],
                ],
                ],
            ],
        ],
    ];

    $meta_boxes[] = [
        "taxonomies" => "product_specials",
        "title" => __("Nastavenia", "rimrebellion"),
        "fields" => [
            [
                'id'  => 'thumbnail_id',
                'name'  => __('Thumbnail', 'inoby'),
                'type'  => 'image_advanced',
                'max_file_uploads'  => 1,
            ],
        ],
    ];

    $meta_boxes[] = [
        "taxonomies" => "product_tag",
        "title" => __("Nastavenia", "rimrebellion"),
        "fields" => [
            [
                'id'  => 'thumbnail_id',
                'name'  => __('Thumbnail', 'inoby'),
                'type'  => 'image_advanced',
                'max_file_uploads'  => 1,
            ],
        ],
    ];
    return $meta_boxes;
});

// Taxonómia product_specials
function modify_taxonomy_product_specials() {
    $args = [
        "hierarchical" => false, // Ak chcete hierarchickú taxonómiu ako kategórie, nastavte na true
        "labels" => [
            "name" => _x("Product Specials", "taxonomy general name", "mammut"),
            "singular_name" => _x("Product Special", "taxonomy singular name", "mammut"),
            "search_items" => __("Search Product Specials", "mammut"),
            "all_items" => __("All Product Specials", "mammut"),
            "edit_item" => __("Edit Product Special", "mammut"),
            "update_item" => __("Update Product Special", "mammut"),
            "add_new_item" => __("Add New Product Special", "mammut"),
            "new_item_name" => __("New Product Special", "mammut"),
            "menu_name" => __("Product Specials", "mammut"),
        ],
        "show_ui" => true,
        "public" => true,
        "show_admin_column" => true,
        "query_var" => 'product_specials_custom', // Custom query var to avoid conflicts
        "hierarchical" => true,
        "show_in_nav_menus" => true, 
        'has_archive'   => true,
        "rewrite" => ["slug" => "specials-slug"],
    ];

    register_taxonomy("product_specials", ["product"], $args);
}

add_action("init", "modify_taxonomy_product_specials");


// Taxonómia product_tag
function modify_taxonomy_product_tag() {
    $args = [
        "hierarchical" => false, // Ak chcete hierarchickú taxonómiu ako kategórie, nastavte na true
        "labels" => [
            "name" => _x("Tags", "taxonomy general name", "mammut"),
            "singular_name" => _x("Tag", "taxonomy singular name", "mammut"),
            "search_items" => __("Search Tags", "mammut"),
            "all_items" => __("All Tags", "mammut"),
            "edit_item" => __("Edit Tag", "mammut"),
            "update_item" => __("Update Tag", "mammut"),
            "add_new_item" => __("Add New Tag", "mammut"),
            "new_item_name" => __("New Tag", "mammut"),
            "menu_name" => __("Tags", "mammut"),
        ],
        "show_ui" => true,
        "public" => true,
        "show_admin_column" => true,
        "query_var" => 'product_tag_custom', // Custom query var to avoid conflicts
        "show_in_nav_menus" => true, 
        'has_archive'   => true,
        "rewrite" => ["slug" => "znacka-produktu"],
    ];

    register_taxonomy("product_tag", ["product"], $args);
}

add_action("init", "modify_taxonomy_product_tag");
?>