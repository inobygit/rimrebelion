<?php

class MbVideoBackground extends MBComponentBase implements MBRetrievesVideoThumbnails {
  protected function init_options($options) {
    $options->id = "inoby-video-background";
    $options->title = "Video pozadie";
    $options->icon = "playlist-video";
    $options->render_template = get_theme_file_path("/components/video-background/template.php");
    $options->fields = [
      [
        "name" => __("Nadpis", "inoby"),
        "id" => "video-background-headline",
        "type" => "text",
        "sanitize_callback" => "none",
      ],
      [
        "name" => __("Text", "inoby"),
        "id" => "video-background-text",
        "type" => "textarea",
        "sanitize_callback" => "none",
      ],
      [
        "id" => "video-background-button",
        "name" => __("Tlačidlo", "inoby"),
        "type" => "text_list",
        "options" => [
          "Zisti viac" => "Text",
          "https://www.google.com/" => "Odkaz",
          "_self" => "target",
        ],
      ],
      [
        "type" => "divider",
      ],
      [
        "name" => __("Náhľadový obrázok", "inoby"),
        "id" => "video-background-thumbnail",
        "type" => "image_advanced",
        "force_delete" => false,
        "max_file_uploads" => 1,
        "max_status" => true,
        "image_size" => "thumbnail",
      ],
      [
        "name" => __("Youtube Video ID", "inoby"),
        "id" => "video-background-src",
        "type" => "text",
      ],
      [
        "id" => "video-background-default-thumb-url",
        "type" => "hidden",
      ],
    ];
  }

  public function videoThumbnailFields(): array {
    return [
      "video-background-src" => "video-background-default-thumb-url",
    ];
  }
}