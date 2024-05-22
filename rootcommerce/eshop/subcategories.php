<?php
$categories = $args["categories"]; ?>

<div class="cats-wrp">
    <?php foreach ($categories as $category) {
    if ($category->count > 0) { ?>
    <div class="category-item">
        <a href="<?= get_term_link($category) ?>" class="cat">
            <?php
      $thumbnail_id = get_term_meta($category->term_id, "thumbnail_id", true);
      if ($thumbnail_id) {
        echo sprintf('<div class="img-wrp">%s</div>', wp_get_attachment_image($thumbnail_id, "s-2"));
      }
      ?>
            <div class="name"><?= $category->name ?></div>
        </a>
    </div>
    <?php }
  } ?>
</div>