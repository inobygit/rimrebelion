<?php

defined("ABSPATH") || exit();

/**
 * @var WC_Product $product
 */
global $product;

$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

function get_gallery_image_html($post_thumbnail_id, $image_size, $attrs) {
$thumbnail_size = apply_filters("inoby_gallery_thumbnail_size", "thumbnail");
    $full_size = apply_filters("inoby_gallery_full_size", "o-12");
    $thumbnail_src = wp_get_attachment_image_src($post_thumbnail_id, $thumbnail_size);
    $full_src = wp_get_attachment_image_src($post_thumbnail_id, $full_size);
    $alt_text = trim(wp_strip_all_tags(get_post_meta($post_thumbnail_id, "_wp_attachment_image_alt", true)));
    $image = wp_get_attachment_image(
      $post_thumbnail_id,
      $image_size,
      false,
      apply_filters(
        "inoby_gallery_image_html_attachment_image_params",
        [
          "title" => _wp_specialchars(get_post_field("post_title", $post_thumbnail_id), ENT_QUOTES, "UTF-8", true),
          "data-caption" => _wp_specialchars(get_post_field("post_excerpt", $post_thumbnail_id), ENT_QUOTES, "UTF-8", true),
          "data-src" => esc_url($full_src[0]),
          "data-large_image" => esc_url($full_src[0]),
          "data-large_image_width" => esc_attr($full_src[1]),
          "data-large_image_height" => esc_attr($full_src[2]),
        ],
        $post_thumbnail_id,
        $image_size,
        false
      )
    );

    $default_attrs = [
      "class" => "woocommerce-product-gallery__image post-img",
      "data-thumb" => esc_url($thumbnail_src[0]),
      "data-thumb-alt" => esc_attr($alt_text),
    ];

    $attrs = wp_parse_args($attrs, $default_attrs);

    return '<div ' . array_to_html_attrs($attrs) . '><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
}

if ($post_thumbnail_id) {
  $attrs = [
    "data-gallery-index" => 0,
  ];
    $master_img_html = get_gallery_image_html($post_thumbnail_id, 'o-6', $attrs);
} else {
  $master_img_html = '<div class="woocommerce-product-gallery__image--placeholder">';
  $master_img_html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src("o-6")), esc_html__("Awaiting product image", "woocommerce"));
  $master_img_html .= "</div>";
}
?>
<div class="woocommerce-product-gallery images">

    <div class="master-image" style="display: none;">
        <?= $master_img_html ?>
    </div>

    <div class="slider keen-slider">
        <?php
    echo $master_img_html;

    if ($post_thumbnail_id && $attachment_ids) {
      foreach ($attachment_ids as $i => $attachment_id) {
        echo get_gallery_image_html($attachment_id, "o-4", [
          "data-gallery-index" => $i + 1,
        ]);
      }
    }
    ?>
    </div>

    <div class="gallery">
        <?= $master_img_html ?>
        <div class="thumbs">
            <?php
      $thumbs_to_show = 4;
      $remaining = count($attachment_ids) - $thumbs_to_show;
      if ($post_thumbnail_id && $attachment_ids) {
        foreach ($attachment_ids as $i => $attachment_id) {
          if ($i == $thumbs_to_show && $remaining > 1) {
            echo get_gallery_image_html($attachment_id, "o-4", [
              "class" => "woocommerce-product-gallery__image more",
              "data-more-text" => "+ $remaining",
              "data-gallery-index" => $i + 1, // +1 because there is no master image in thumbs
            ]);
            break;
          }
          echo get_gallery_image_html($attachment_id, "o-4", [
            "data-gallery-index" => $i + 1, // +1 because there is no master image in thumbs
          ]);
        }
      }
      ?>
        </div>
    </div>

</div>