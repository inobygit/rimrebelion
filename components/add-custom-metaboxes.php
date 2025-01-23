<?php

add_filter("component_add_mb_video-section", function ($mb) {
  $mb[] = [
    'id'       => 'video-section-autoplay',
    'name'    => __('Autoplay', 'inoby'),
    'type'     => 'checkbox',
    "std" => 0,
    "after_id" => "video-section-src",
  ];
  return $mb;
}, 10);