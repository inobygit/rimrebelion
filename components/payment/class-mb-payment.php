<?php

class MBPayment extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-payment";
    $options->title = __("Spôsoby platby / dopravy", "inoby");
    $options->icon = "fas fa-filter";
    $options->render_template = get_theme_file_path("components/payment/template.php");
    $options->fields = [
      [
        "id" => "payment-icon",
        "type" => "image_advanced",
        "name" => __("Ikonka", "inoby"),
        'max_file_uploads'  => 1,
      ],
      [
        "id" => "payment-title",
        "type" => "text",
        "name" => __("Nadpis", "inoby"),
      ],
      [
        "id" => "payment-desc",
        "type" => "textarea",
        "name" => __("Popis", "inoby"),
      ],
      [
        "id" => "payment-price",
        "type" => "wysiwyg",
        "name" => __("Cena", "inoby"),
        "raw" => true,
        "sanitize_callback" => "none",
        "options" => [
          "textarea_rows" => 4,
          "teeny" => true,
          "media_buttons" => false,
        ],
      ],
      
    ];
  }
}