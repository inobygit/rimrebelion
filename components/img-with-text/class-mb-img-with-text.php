<?php

class MbImgWithTextChild extends MBComponentBase {
  protected function init_options($options) {
    $options->id = "img-with-text-child";
    $options->title = "Obrázok s textom";
    $options->icon = "fas fa-image";

    $options->render_template = get_theme_file_path("/components/img-with-text/template.php");

    $options->fields = [
      [
        "name" => "Pozícia obrázku",
        "id" => "img-position",
        "type" => "radio",
        "inline" => false,
        "options" => [
          "left" => "Vľavo",
          "right" => "Vpravo",
        ],
      ],
      [
        "type" => "divider",
      ],
      [
        "name" => __("Obrázok", "inoby"),
        "id" => "img",
        "type" => "image_advanced",
        "force_delete" => false,
        "max_file_uploads" => 1,
        "max_status" => true,
        "image_size" => "thumbnail",
      ],
      [
        "name" => "Alt popis obrázku",
        "id" => "img-alt-text",
        "type" => "text",
      ],
      [
        "type" => "divider",
      ],
      [
        "name" => "Text",
        "id" => "text",
        "type" => "wysiwyg",
        "raw" => true,
        "sanitize_callback" => "none",
        "options" => [
          "textarea_rows" => 4,
          "teeny" => true,
          "media_buttons" => false,
        ],
      ],
      [
        "type" => "divider",
      ],
      [
        "name" => "Tlačidlo - text",
        "id" => "btn-text",
        "type" => "text",
      ],
      [
        "name" => "Tlačidlo - link",
        "id" => "btn-url",
        "type" => "text",
      ],
    ];
  }
}