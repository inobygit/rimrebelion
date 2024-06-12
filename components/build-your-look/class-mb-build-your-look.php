<?php

class MBBuildYourLook extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-build-your-look";
    $options->title = __("Build Your Look", "inoby");
    $options->icon = "welcome-view-site";
    $options->render_template = get_theme_file_path("components/build-your-look/template.php");
    $options->fields = [
      [
        'id'       => 'build-your-look-heading',
        'name'    => __('Nadpis', 'inoby'),
        'placeholder'   => __('Vložte nadpis', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'id'       => 'build-your-look-desc',
        'name'    => __('Popis', 'inoby'),
        'placeholder'   => __('Vložte popis', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'id'       => 'build-your-look-category',
        'name'    => __('Kategória', 'inoby'),
        'type'     => 'taxonomy_advanced',
        'taxonomy' => 'look-gender',
        'sanitize_callback' => 'none',
        'field_type'  => 'radio_list',
      ],
      
    ];
  }
}