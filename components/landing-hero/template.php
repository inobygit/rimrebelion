<?php
$cta_grid = mb_get_block_field("landing-hero");

if ($cta_grid) { ?>
<section <?= inoby_block_attrs($attributes, ["class" => "landing-hero"]) ?>>
    <div class="logo-big">
        <?= file_get_contents(get_stylesheet_directory_uri() . '/assets/svg/logo-big.svg') ?>
    </div>
    <?php 
          echo '<div class="landing-hero-wrap">';
          foreach ($cta_grid as $cta) {
            $cta_headline = $cta["headline"] ?? "";
            $cta_text = $cta["text"] ?? "";
            $cta_url = $cta["url"] ?? "";

            if ($cta_url) {
            echo '<a class="landing-hero-box" href="' . $cta_url . '">';
            } else {
              echo '<a class="landing-hero-box" href="#">';
            }
            if (isset($cta["bg"])) {
              echo '<div class="img-wrap">';
              echo '<img loading="lazy" src="' . wp_get_attachment_image_src(reset($cta["bg"]), "s-6")[0] . '" alt="' . $cta_headline . '">';
              echo "</div>";
            }
            echo '<div class="content-wrap">';
            if ($cta_headline) {
              echo "<h2>" . $cta_headline . "</h2>";
            }
            /**
             * Action to render stuff after cta grid headline
             * @package inobydoc
             */
            do_action("inoby_cta_grid_headline_after", $cta);
            if ($cta_text) {
              echo "<p>" . $cta_text . "</p>";
            }
            echo '<span class="link arrow-link">' . __("Explore", "inoby") . "</span>";
            echo "</div>";
            echo "</a>";
          }
          echo "</div>"; ?>
</section>
<?php }