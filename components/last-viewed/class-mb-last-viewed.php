<?php

class MBLastViewed extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-last-viewed";
    $options->title = __("Last viewed products", "inoby");
    $options->icon = "welcome-view-site";
    $options->render_template = get_theme_file_path("components/last-viewed/template.php");
    $options->fields = [
      [
        'id'       => 'last-viewed-heading',
        'name'    => __('Nadpis', 'inoby'),
        'placeholder'   => __('Vložte nadpis', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      
    ];
  }
}