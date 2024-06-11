<?php

add_filter("mb_settings_pages", function ($settings_pages) {
  $settings_pages[] = ["id" => "options-archive", "option_name" => "options", "menu_title" => "Archive", "parent" => "options", "capability" => "edit_pages", 'parent' => 'edit.php?post_type=looks'];
  return $settings_pages;
});

add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {

  $meta_boxes[] = [
      'id'             => 'mb-archive-looks',
      'title'          => 'Archive Config',
      'menu_title'  => 'Archive',
      'settings_pages' => 'options-archive',
      'context'        => 'normal',
      'label_description' => 'Label description',
      'fields' => array(
        array(
            'name'             => __('Looks - Banner - Hero image', 'inoby'),
            'id'               => 'archive_looks_heroimg',
            'type'             => 'image_advanced',
            'force_delete'     => false,
            'max_file_uploads' => 1,
        ),
        array(
            'name' => __('Looks - Banner - Heading', 'inoby'),
            'id'   => 'archive_looks_heading',
            'type' => 'text',
            'sanitize_callback' => 'none',
        ),
        array(
            'name' => __('Looks - Banner - Italic Text', 'inoby'),
            'id'   => 'archive_looks_italic_text',
            'type' => 'textarea',
            'sanitize_callback' => 'none',
        ),
        array(
            'name' => __('Looks - Banner - Text', 'inoby'),
            'id'   => 'archive_looks_text',
            'type' => 'textarea',
            'sanitize_callback' => 'none',
        ),
      )
  ];

  return $meta_boxes;
} );