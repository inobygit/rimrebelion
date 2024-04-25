<?php

class MBCtaGridChild extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-cta-grid-child";
    $options->title = __("Bannery zistiť viac", "inoby");
    $options->icon = "welcome-view-site";
    $options->render_template = get_theme_file_path("components/cta-grid/template.php");
    $options->fields = [
      [
        'id'       => 'cta-headline',
        'name'    => __('Nadpis', 'inoby'),
        'placeholder'   => __('Vložte nadpis', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'id'       => 'cta-desc',
        'name'    => __('Popis', 'inoby'),
        'placeholder'   => __('Vložte popis', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'type'  => 'divider',
      ],
      [
        'id'       => 'cta-btn-text',
        'name'    => __('Tlačidlo - text', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'id'       => 'cta-btn-url',
        'name'    => __('Tlačidlo - link', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'group_title'   => __('CTA sekcia - {headline}', 'inoby'),
        'id'            => 'cta-grid',
        'type'          => 'group',
        'clone'         => true,
        'collapsible'   => true,
        'sort_clone'    => true,
        'max_clone'     => 3,
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
            'type'     => 'text',
            'sanitize_callback' => 'none',
          ],
          [
            'id'       => 'text',
            'title'    => __('Text', 'inoby'),
            'placeholder'   => __('Vložte text', 'inoby'),
            'type'     => 'text',
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