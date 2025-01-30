<?php

class MBSocialFeed extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-social-feed";
    $options->title = __("Instagram feed", "inoby");
    $options->icon = "welcome-view-site";
    $options->render_template = get_theme_file_path(
      "components/social-feed/template.php",
    );
    $options->fields = [
      [
        "id" => "feed_heading",
        "name" => __("Nadpis", "inoby"),
        "type" => "text",
      ],
      [
        "id" => "feed_desc",
        "name" => __("Popis", "inoby"),
        "type" => "text",
      ],
      [
        "id" => "feed_shortcode",
        "name" => __("Shortcode feedu", "inoby"),
        "type" => "text",
      ],
      
    ];
  }
}