<?php
  function pt_register_looks() {
    $labels = array(
        'name'                => _x('Looks', 'Post Type General Name', 'Inoby'),
        'singular_name'       => _x('Looks', 'Post Type Singular Name', 'Inoby'),
        'menu_name'           => __('Looks', 'Inoby'),
        'parent_item_colon'   => __('Nadradené looks', 'Inoby'),
        'all_items'           => __('Všetky looks', 'Inoby'),
        'view_item'           => __('Pozri looks', 'Inoby'),
        'add_new_item'        => __('Pridať nové looks', 'Inoby'),
        'add_new'             => __('Pridať nové', 'Inoby'),
        'edit_item'           => __('Upraviť looks', 'Inoby'),
        'update_item'         => __('Aktualizovať looks', 'Inoby'),
        'search_items'        => __('Hladať looks', 'Inoby'),
        'not_found'           => __('Nič sa nenašlo', 'Inoby'),
        'not_found_in_trash'  => __('Nič sa nenašlo v koši', 'Inoby'),
    );
        
    $args = array(
        'label'               => __('Looks', 'Inoby'),
        'description'         => __('Looks popis', 'Inoby'),
        'labels'              => $labels,
        'supports'            => array('title', 'thumbnail'),
        'menu_icon' => 'dashicons-universal-access',
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
        
    register_post_type('looks', $args);
  }

  add_action('init', 'pt_register_looks', 0);
?>