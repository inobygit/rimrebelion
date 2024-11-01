<?php

class MBIconBoxesChild extends MBComponentBase {
  protected function init_options($options) {
    $options->enabled = true;
    $options->id = "inoby-icon-boxes-child";
    $options->title = __("Ikonky s popisom", "inoby");
    $options->icon = "superhero-alt";
    $options->render_template = get_theme_file_path("components/icon-boxes/template.php");
    $options->fields = [
      [
            'id'       => 'icon-boxes-heading',
            'name'    => __('Nadpis sekcie', 'inoby'),
            'placeholder'   => __('Vložte nadpis', 'inoby'),
            'type'     => 'text',
            'sanitize_callback' => 'none',
          ],
            [
            'id'       => 'icon-boxes-desc',
            'name'    => __('Popis sekcie', 'inoby'),
            'placeholder'   => __('Vložte popis', 'inoby'),
            'type'     => 'text',
            'sanitize_callback' => 'none',
          ],
          [
        'type' => 'heading',
        'name' => __('Tlačidlo', 'inoby'),
      ],
      [
            'id'       => 'icon-boxes-btn-text',
            'name'    => __('Tlačidlo - text', 'inoby'),
            'type'     => 'text',
            'sanitize_callback' => 'none',
          ],
          [
            'id'       => 'icon-boxes-btn-link',
            'name'    => __('Tlačidlo - link', 'inoby'),
            'type'     => 'text',
            'sanitize_callback' => 'none',
          ],
      [
        'name'    => 'Počet stĺpcov',
        'id'      => 'icon-box-columns',
        'type'    => 'radio',
        'inline'  => false,
        'options' => [
            '1' => __('1 stĺpec', 'inoby'),
            '2' => __('2 stĺpce', 'inoby'),
            '3' => __('3 stĺpce', 'inoby'),
            '4' => __('4 stĺpce', 'inoby'),
            '5' => __('5 stĺpcov', 'inoby'),
            '6' => __('6 stĺpcov', 'inoby'),
        ],
      ],
      [
        'type' => 'heading',
        'name' => __('Boxy s ikonami', 'inoby'),
      ],
      [
        'group_title'   => __('Box {#}', 'inoby'),
        'id'            => 'icon-boxes',
        'type'          => 'group',
        'clone'         => true,
        'collapsible'   => true,
        'sort_clone'    => true,
        'add_button'    => __('Pridať ďalší box', 'inoby'),
        'fields' => array(
          [
            'id'  => 'without-graphics',
            'name'  => __("Bez brand grafiky", 'inoby'),
            'type'  => 'checkbox',
          ],
          [
            'id'               => "icon",
            'name'             => __('Ikona', 'inoby'),
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
        )
      ],
    ];
  }
}