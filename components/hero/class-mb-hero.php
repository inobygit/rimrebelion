<?php

class MBHeroChild extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-hero-child";
    $options->title = __("Úvodný banner - Muži / Ženy", "inoby");
    $options->icon = "welcome-view-site";
    $options->render_template = get_theme_file_path(
      "components/hero/template.php",
    );
    $options->fields = [
      [
        "id" => "hero_bg",
        "name" => __("Pozadie", "inoby"),
        "type" => "image_advanced",
        "force_delete" => false,
        "max_file_uploads" => 1,
        "max_status" => false,
        "image_size" => "thumbnail",
      ],
      [
        "type" => "divider",
      ],
      [
        "name" => __("Nadpis", "inoby"),
        "placeholder" => __("Vložte nadpis", "inoby"),
        "id" => "hero_headline",
        "type" => "text",
        "sanitize_callback" => "none",
        "translate" => true,
      ],
      [
        "name" => __("Podnadpis", "inoby"),
        "placeholder" => __("Vložte podnadpis", "inoby"),
        "id" => "hero_subheadline",
        "type" => "text",
        "sanitize_callback" => "none",
        "translate" => true,
      ],
      [
        "name" => __("Popis", "inoby"),
        "placeholder" => __("Vložte popis", "inoby"),
        "id" => "hero_description",
        "type" => "wysiwyg",
        'raw' => true,
        "sanitize_callback" => "none",
        "translate" => true,
      ],
      [
        "name" => __("Tlačidlo - Text", "inoby"),
        "placeholder" => __("Vložte text", "inoby"),
        "id" => "hero_btn",
        "type" => "text",
        "translate" => true,
      ],
      [
        "name" => __("Tlačidlo - Odkaz", "inoby"),
        "placeholder" => __("Vložte odkaz", "inoby"),
        "id" => "hero_url",
        "type" => "text",
        "translate" => true,
      ],
    ];
  }
}