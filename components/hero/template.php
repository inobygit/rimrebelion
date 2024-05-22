<?php
$hero_headline = mb_get_block_field("hero_headline");
$hero_subheadline = mb_get_block_field("hero_subheadline");
$hero_description = mb_get_block_field("hero_description");
$hero_btn = mb_get_block_field("hero_btn");
$hero_url = mb_get_block_field("hero_url");
$hero_bg = mb_get_block_field("hero_bg");
$hero_image = mb_get_block_field("hero_image");

if ($hero_headline) { ?>
<section
    <?= inoby_block_attrs($attributes, ["class" => "hero", "style" => "background: top/cover no-repeat url('" . (reset($hero_bg)["sizes"]["o-12"]["url"] ?? "") . "');"]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-12 hero-main">
                <?php if ($hero_headline) {
          echo "<h1>" . $hero_headline . "</h1>";
        }
        if ($hero_subheadline) {
          echo "<h3>" . $hero_subheadline . "</h3>";
        }
        if ($hero_description) {
          echo "<div class='desc'>" . $hero_description . "</div>";
        }
        do_action("component_hero_after_headline");
        if ($hero_url) {
          echo '<a class="button light btn-background" href="' . $hero_url . '">'  . $hero_btn ."</a>";
        } ?>
            </div>
        </div>
    </div>
</section>
<?php }