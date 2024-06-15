<?php
/**
 * Looks archive page
 *
 */

defined("ABSPATH") || exit();

inoby_enqueue_parted_style("looks", "post_types");
inoby_enqueue_parted_script("looks", "post_types");

$archive_looks_heroimg = rwmb_meta("archive_looks_heroimg", ["limit" => 1, "size" => "archive-banner", "object_type" => "setting"], "options");
$archive_looks_hero = reset($archive_looks_heroimg);
$archive_looks_heading = rwmb_meta("archive_looks_heading", ["object_type" => "setting"], "options");
$archive_looks_italic_text = rwmb_meta("archive_looks_italic_text", ["object_type" => "setting"], "options");
$archive_looks_text = rwmb_meta("archive_looks_text", ["object_type" => "setting"], "options");

if(isset($_GET['gender'])){
    $gender = $_GET['gender'];
} else {
    $gender = null;
}

get_header();
?>

<div id="looks-archive">
    <div class="header">
        <div class="container fluid-right">
            <div class="row">
                <div class="col-6 col-lg-12 text-column">
                    <div class="looks-header-content-wrap">
                        <?php if (!empty($archive_looks_heading)): ?>
                        <div class="looks-header-title">
                            <h1 class="woocommerce-looks-header__title page-title">
                                <?php echo $archive_looks_heading ?></h1>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($archive_looks_text)) : ?>
                        <div class="looks-header-desc">
                            <p>
                                <?php if(!empty($archive_looks_italic_text)){ ?>
                                <i>
                                    <?= $archive_looks_italic_text ?>
                                </i><br />
                                <?php } ?>
                                <?php echo $archive_looks_text ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="25" viewBox="0 0 29 25" fill="none">
                            <path
                                d="M28.2335 11.5073L26.1564 7.91786C25.8011 7.30827 25.152 6.93026 24.4449 6.93026H20.7826V4.44422C20.7826 3.73927 20.4034 3.08882 19.7919 2.73805L15.4873 0.265631C14.8758 -0.0885438 14.1242 -0.0885438 13.5059 0.265631L9.21157 2.73805C8.60005 3.09222 8.22084 3.73927 8.22084 4.44422V6.93366H4.56198C3.85481 6.93366 3.20571 7.30827 2.85042 7.91786L0.766471 11.5073C0.411176 12.1169 0.411176 12.8729 0.766471 13.4825L2.85042 17.0787C3.20571 17.6883 3.85481 18.0663 4.56198 18.0663H8.22084V20.5524C8.22084 21.2573 8.59663 21.9078 9.20815 22.2585L13.5024 24.7344C14.114 25.0885 14.8724 25.0885 15.4839 24.7344L19.785 22.2585C20.3965 21.9044 20.7757 21.2573 20.7757 20.5524V18.0663H24.4346C25.1418 18.0663 25.7943 17.6883 26.1462 17.0787L28.2335 13.4791C28.5888 12.8695 28.5888 12.1203 28.2335 11.5039H28.2369L28.2335 11.5073Z"
                                fill="white" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($archive_looks_heroimg)) {
                echo '<img class="fluid" src="' . wp_get_attachment_image_url($archive_looks_hero['ID'], 'o-12') . '" alt="hero image">';
            } else {
                echo '<img class="fluid" src="' . esc_url(get_stylesheet_directory_uri() . "/assets/img/bg-looks-archive.webp") . '" alt="hero image">';
            } ?>

    </div>

    <?php get_template_part("template-parts/yoast-breadcrumbs", "yoast-breadcrumbs"); ?>


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="products-top-sidebar">
                    <?php 
                    $terms = get_terms( array(
                        'taxonomy' => 'look-gender',
                        'post_type' => 'looks',
                        'hide_empty' => true,
                    ) );
                    if(!empty($terms)) { 
                        ?>
                    <div id="shop-sidebar" class="sticky-side-menu">
                        <div class="mobile-header">
                            <h3><?= __("Filtrovať produkty", "rootscope") ?></h3>
                        </div>
                        <form id="products-filter">
                            <div class="fields">
                                <div class="checkboxes-wrapper-looks input-group ">
                                    <label for=" filter-gender"><?= __("Gender", 'rimrebellion') ?></label>
                                    <div id="filter-gender" class="filter-wrp-looks">
                                        <?php foreach($terms as $gen) { 
                                            ?>
                                        <div class="input-wrp-looks">
                                            <input type="checkbox" id="option-<?= $gen->term_id ?>" name="gender[]"
                                                value="<?= $gen->term_id ?>">
                                            <label for="option-<?= $gen->term_id ?>">
                                                <span data-content="<?= $gen->name ?>"><?= $gen->name ?></span>
                                            </label>
                                            <div class="count">(<?= $gen->count ?>)</div>
                                        </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="disable_auto_apply_filter" value="false">

                            <?php
                                // tento button sa zobrazi len na mobile - (product/archive.ts, product/filter.scss)
                            ?>
                            <button class="button filter-trigger"><?= __("Filtrovať", "inoby") ?></button>
                        </form>


                        <button class="button color products-filter-init"><?= __("Filter", "rootscope") ?></button>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <section class="list">
        <div class="container">
            <?php get_template_part("post-types/looks/parts/looks-list", null, ['gender' => $gender]); ?>
        </div>
    </section>

    <?php if(!isset($_GET['gender'])){ ?>
    <section class="pagination">
        <div class="container">
            <?php 
            $args = [
                'card_template' => 'post-types/looks/parts/card',
                'card-classes'  => 'col-3 col-md-6 col-sm-12',
                'gender'    => $gender,
            ];
            get_template_part("post-types/looks/parts/pagination", null, $args); ?>
        </div>
    </section>
    <?php } ?>
</div>

<?php
get_footer();