<?php

class MBReferencesSlider extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-references-slider";
    $options->title = __("Slider s referenciami", "inoby");
    $options->icon = "fas fa-images";
    $options->render_template = get_theme_file_path("components/references-slider/template.php");
    $options->fields = [
      [
        'id'  => 'references-slider-heading',
        'name' => __("Nadpis sekcie", 'inoby'),
        'type'  => 'text',
      ],
      [
        'id'  => 'references-slider-desc',
        'name' => __("Popis sekcie", 'inoby'),
        'type'  => 'text',
      ],
      [
        "type" => "group",
        "id" => "references-group",
        "collapsible" => true,
        'clone' => true,
        'sort_clone'  => true,
        'default_state' => 'collapsed',
        "group_title" => __("Referencia {name}", "inoby"),
        "fields" => [
          [
            "id" => "photo",
            "type" => "image_advanced",
            'max_file_uploads'  => 1,
            "name" => __("Fotka", "inoby"),
          ],
          [
            "id" => "name",
            "type" => "text",
            "name" => __("Meno", "inoby"),
          ],
          [
            "id" => "position",
            "type" => "text",
            "name" => __("Pozícia", "inoby"),
          ],
          [
            "id" => "reference",
            "type" => "textarea",
            "name" => __("Referencia", "inoby"),
          ],
        ],
      ],
    ];
  }
}