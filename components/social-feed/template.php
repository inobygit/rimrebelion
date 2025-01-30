<?php
$feed_heading = mb_get_block_field("feed_heading");
$feed_desc = mb_get_block_field("feed_desc");
$feed_shortcode = mb_get_block_field("feed_shortcode");

?>

<section <?= inoby_block_attrs($attributes, ["class" => "social-feed"]) ?>>
    <div class="container">
        <div class="row top-row">
            <div class="col-6 col-md-12">
                <?php if(!empty($feed_heading)) : ?>
                <h3>
                    <?= $feed_heading ?>
                </h3>
                <?php endif; ?>
                <?php if(!empty($feed_desc)) : ?>
                <h4>
                    <?= $feed_desc ?>
                </h4>
                <?php endif; ?>
            </div>
            <div class="col-6 col-md-12 socials-col">
                <?php echo do_shortcode("[socials]"); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php if(!empty($feed_shortcode)){
            echo do_shortcode($feed_shortcode);  
          } ?>
            </div>
        </div>
    </div>
</section>