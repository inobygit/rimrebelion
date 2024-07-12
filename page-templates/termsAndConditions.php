<?php
/**
 * Template Name: Terms and conditions
 */

inoby_enqueue_parted_script("terms", "page_templates");
inoby_enqueue_parted_style("terms", "page_templates");

get_header();

$icon = rwmb_meta('termsIcon');

?>

<main id="pt-terms">
    <?php if ( has_post_thumbnail() ) : ?>
    <section class="header">
        <div class="header-image">
            <?php the_post_thumbnail(); ?>
        </div>
    </section>
    <?php endif; ?>

    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-4 col-xl-12 left-content">
                    <?php dynamic_sidebar('terms'); ?>
                </div>
                <div class="col-8 col-xl-12">
                    <?= the_content(); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer();