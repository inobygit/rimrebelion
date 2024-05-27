<?php
$last_viewed_heading = mb_get_block_field("last-viewed-heading");

RC()->last_seen_products()->enqueue_scripts();
$my_default_lang = apply_filters('wpml_default_language', NULL );

var_dump($my_default_lang);
?>

<div class="container inoby-last-viewed">
    <?php if(!empty($last_viewed_heading)){ ?>
    <div class="row last-viewed-row" style="display: none;">
        <div class="col-12">
            <h3>
                <?= $last_viewed_heading ?>
            </h3>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-12">
            <?php echo do_shortcode('[rc_last_seen_products]'); ?>
        </div>
    </div>
</div>