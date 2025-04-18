<?php

$product = $args['product'] ?? null;

defined("ABSPATH") || exit();

$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

if (isset($attachment_ids[0])) {
  $attrs = [
    "data-gallery-index" => 0,
    "data-gallery-parent" => '#slider-' . $product->get_id(),
  ];
    $master_img_html = get_gallery_image_html($attachment_ids[0], 'o-6', $attrs, 'eager');
} else {
  $master_img_html = '<div class="woocommerce-product-gallery__image--placeholder">';
  $master_img_html .= sprintf('<img loading="lazy" src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src("o-6")), esc_html__("Awaiting product image", "woocommerce"));
  $master_img_html .= "</div>";
}
?>
<div class="woocommerce-product-gallery images">

    <div class="master-image" style="display: none;">
        <?= $master_img_html ?>
    </div>

    <div class="slider keen-slider" id="slider-<?= $product->get_id() ?>">
        <?php
    echo $master_img_html;

    if ($post_thumbnail_id && $attachment_ids) {
      foreach ($attachment_ids as $i => $attachment_id) {
        if($i != 0){
          echo get_gallery_image_html($attachment_id, "o-2", [
            "data-gallery-parent" => '#slider-' . $product->get_id(),
            "data-gallery-index" => $i + 1,
          ]);
        }
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
        if($i != 0){

          if ($i == $thumbs_to_show && $remaining > 1) {
            echo get_gallery_image_html($attachment_id, "o-2", [
              "class" => "woocommerce-product-gallery__image more",
              "data-more-text" => "+ $remaining",
              "data-gallery-parent" => '#slider-' . $product->get_id(),
              "data-gallery-index" => $i, // +1 because there is no master image in thumbs
            ]);
            break;
          }
          echo get_gallery_image_html($attachment_id, "o-2", [
            "data-gallery-parent" => '#slider-' . $product->get_id(),
            "data-gallery-index" => $i, // +1 because there is no master image in thumbs
          ]);
        }
      }
      }
      ?>
        </div>
    </div>

</div>