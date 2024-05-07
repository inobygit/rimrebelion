<?php

class MBCategorySlider extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-category-slider";
    $options->title = __("Slider s kategóriami", "inoby");
    $options->icon = "fas fa-filter";
    $options->render_template = get_theme_file_path("components/category-slider/template.php");
    $options->fields = [
      [
        "id" => "category-slider-categories",
        "type" => "taxonomy_advanced",
        "name" => __("Kategórie", "inoby"),
        'taxonomy'  => 'product_cat',
        'field_type' => 'checkbox_list',
        'query_args' => [
          'hide_empty' => false,
          'hierarchical' => false,
          'depth' => 0,
        ],
      ],
      
    ];
  }
}