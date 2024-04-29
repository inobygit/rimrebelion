<?php

class MBArticleBoxes extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-article-boxes";
    $options->title = __("Bannery zistiť viac - Články", "inoby");
    $options->icon = "welcome-view-site";
    $options->render_template = get_theme_file_path("components/article-boxes/template.php");
    $options->fields = [
      [
        'id'       => 'article-headline',
        'name'    => __('Nadpis', 'inoby'),
        'placeholder'   => __('Vložte nadpis', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'id'       => 'article-desc',
        'name'    => __('Popis', 'inoby'),
        'placeholder'   => __('Vložte popis', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'type'  => 'divider',
      ],
      [
        'id'       => 'article-btn-text',
        'name'    => __('Tlačidlo - text', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'id'       => 'article-btn-url',
        'name'    => __('Tlačidlo - link', 'inoby'),
        'type'     => 'text',
        'sanitize_callback' => 'none',
      ],
      [
        'group_title'   => __('CTA sekcia - {headline}', 'inoby'),
        'id'            => 'article-boxes',
        'type'          => 'group',
        'clone'         => true,
        'collapsible'   => true,
        'sort_clone'    => true,
        'max_clone'     => 2,
        'add_button'    => __('Pridať ďalšiu sekciu', 'inoby'),
        'fields' => array(
          [
            'id'  => 'style-2',
            'name'  => __("Štýl 2", 'inoby'),
            'type'  => 'checkbox',
            'std' => 0,
          ],
          [
            'id'  => 'illustration-color',
            'name'  => __('Farba ilustrácie', 'inoby'),
            'type'  => 'color',
          ],
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
            'type'     => 'wysiwyg',
            'sanitize_callback' => 'none',
            'raw' => true,
            "translate" => true,
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