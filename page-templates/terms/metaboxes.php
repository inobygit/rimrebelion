<?php
function pg_metabox_terms($meta_boxes)
{
  $meta_boxes[] = [
    "id" => "terms",
    "title" => esc_html__("Terms and conditions", "Inoby"),
    "post_types" => ["page"],
    "show" => [
      "template" => ["page-templates/termsAndConditions.php"],
    ],
    "context" => "normal",
    "priority" => "default",
    "autosave" => "false",
    'tab_style' => 'left',
    "fields" => [
    ], 
  ];

  return $meta_boxes;
}
add_filter("rwmb_meta_boxes", "pg_metabox_terms");
?>