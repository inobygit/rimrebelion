<?php

class MbSimpleVideoChild extends MBComponentBase implements MBRetrievesVideoThumbnails {
  protected function init_options($options) {
    $options->id = "video-child";
    $options->title = "video";
    $options->icon = "playlist-video";
    $options->render_template = get_theme_file_path("/components/video/template.php");
    $options->fields = [
      [
        "name" => __("Náhľadový obrázok", "inoby"),
        "id" => "simple_video_thumbnail",
        "type" => "image_advanced",
        "force_delete" => false,
        "max_file_uploads" => 1,
        "max_status" => true,
        "image_size" => "thumbnail",
      ],
      [
        "name" => __("Ikona prehrávania", "inoby"),
        "id" => "simple_video_play_icon",
        "type" => "image_advanced",
        "force_delete" => false,
        "max_file_uploads" => 1,
        "max_status" => true,
        "image_size" => "thumbnail",
      ],
      [
        "name" => __("Text tlačidla prehrávania", "inoby"),
        "id" => "simple_video_play_text",
        "type" => "text",
      ],
      [
        "name" => __("Odkaz na video", "inoby"),
        "id" => "simple_video_src",
        "type" => "text",
      ],
      [
        "id" => "simple_video_default_thumb_url",
        "type" => "hidden",
      ],
    ];
  }

  public function videoThumbnailFields(): array {
    return [
      "simple_video_src" => "simple_video_default_thumb_url",
    ];
  }
}