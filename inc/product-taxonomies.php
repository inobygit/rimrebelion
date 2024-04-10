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

?>