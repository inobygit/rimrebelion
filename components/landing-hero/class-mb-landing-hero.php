<?php

class MBLandingHero extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-landing-hero";
    $options->title = __("Landing page - hero sekcia", "inoby");
    $options->icon = "welcome-view-site";
    $options->render_template = get_theme_file_path("components/landing-hero/template.php");
    $options->fields = [
      [
        'group_title'   => __('CTA sekcia - {headline}', 'inoby'),
        'id'            => 'landing-hero',
        'type'          => 'group',
        'clone'         => true,
        'collapsible'   => true,
        'sort_clone'    => true,
        'max_clone'     => 2,
        'add_button'    => __('Pridať ďalšiu sekciu', 'inoby'),
        'fields' => array(
          [
            'id'               => "bg",
            'name'             => __('Pozadie', 'inoby'),
            'type'             => 'image_advanced',
            'force_delete'     => false,
            'max_file_uploads' => 1,
            'max_status'       => false,
            'image_size'       => 'thumbnail',
          ],
          [
            'id'       => 'headline',
            'title'    => __('Nadpis', 'inoby'),
            'placeholder'   => __('Vložte nadpis', 'inoby'),
            'type'     => 'textarea',
            'sanitize_callback' => 'none',
          ],
          [
            'id'       => 'url',
            'title'    => __('Odkaz', 'inoby'),
            'placeholder'   => __('Vložte odkaz', 'inoby'),
            'type'     => 'text',
          ],
        )
      ],
    ];
  }
}