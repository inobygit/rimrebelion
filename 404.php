<?php

$cfg = Inoby_Config::page404();
$title = $cfg["title"];
$headline = $cfg["headline"];
$text = $cfg["text"];
$btn_home_text = $cfg["btn_home_text"];

inoby_enqueue_parted_style("page404", "page_templates");

get_header();
?>
<main id="primary" class="site-main">
    <section class="page-404">
        <div class="bg-image">
            <img loading="lazy" src="<?= get_theme_file_uri("/assets/img/404.webp") ?>" alt="404" />
        </div>
        <div class="container">
            <div class="row items-center">
                <div class="col-9 col-md-12">
                    <div class="text-container">
                        <h1><?= $title ?></h1>
                        <h2><?= $headline ?></h2>
                        <p class="large"><?= $text ?></p>
                        <a href="/" class="button white triangleBoth"><?= $btn_home_text ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php do_action('inoby_404_after_content_section'); ?>
</main>
<?php get_footer();