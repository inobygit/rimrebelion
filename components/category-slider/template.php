<?php
  $slider = mb_get_block_field("category-slider-categories");
?>
<div <?= inoby_block_attrs($attributes, ["class" => "component-category-slider"]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="category-slider">
                    <?php foreach($slider as $category): ?>
                    <div class="category-slide">
                        <a href="<?= get_term_link($category) ?>">
                            <div class="category-slide-inner">
                                <div class="category-slide-image">
                                    <?= wp_get_attachment_image(get_term_meta($category->term_id, "thumbnail_id", true), "o-2") ?>
                                </div>
                                <div class="category-slide-content">
                                    <p><?= $category->name ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>