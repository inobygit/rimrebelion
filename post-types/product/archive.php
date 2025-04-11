<?php
    /**
     * The Template for displaying product archives, including the main shop page which is a post type archive
     *
     * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
     *
     * HOWEVER, on occasion WooCommerce will need to update template files and you
     * (the theme developer) will need to copy the new files to your theme to
     * maintain compatibility. We try to do this as little as possible, but it does
     * happen. When this occurs the version of the template file will be bumped and
     * the readme will list any important changes.
     *
     * @see https://docs.woocommerce.com/document/template-structure/
     * @package WooCommerce\Templates
     * @version 3.4.0
     */

    defined("ABSPATH") || exit();

    inoby_enqueue_parted_style("product", "post_types");
    inoby_enqueue_parted_script("product", "post_types");
    get_header("shop");
    $cat          = $wp_query->get_queried_object();
    $thumbnail_id = "";
    $image        = "";

    if ($cat instanceof WP_Term) {
        $thumbnail_id = get_term_meta($cat->term_id, "thumbnail_id", true);
        $image        = wp_get_attachment_url($thumbnail_id);
    }
?>
<div class="woocommerce-hero">
    <div class="container fluid-right">
        <div class="row">
            <div class="col-6 col-lg-12 text-column">
                <div class="products-header-content-wrap">
                    <?php if (apply_filters("woocommerce_show_page_title", true)): ?>
                    <div class="products-header-title">
                        <h1 class="woocommerce-products-header__title page-title">
                            <?php echo woocommerce_page_title(); ?></h1>
                    </div>
                    <?php endif; ?>
<?php echo '<div class="products-header-image" style="background-image: url(' . $image . ');"></div>'; ?>
                    <div class="products-header-desc">
                        <?php //

                            // Hook woocommerce_archive_description.
                            // @hooked woocommerce_taxonomy_archive_description - 10
                            // @hooked woocommerce_product_archive_description - 10

                        do_action("woocommerce_archive_description"); ?>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="25" viewBox="0 0 29 25" fill="none">
                        <path
                            d="M28.2335 11.5073L26.1564 7.91786C25.8011 7.30827 25.152 6.93026 24.4449 6.93026H20.7826V4.44422C20.7826 3.73927 20.4034 3.08882 19.7919 2.73805L15.4873 0.265631C14.8758 -0.0885438 14.1242 -0.0885438 13.5059 0.265631L9.21157 2.73805C8.60005 3.09222 8.22084 3.73927 8.22084 4.44422V6.93366H4.56198C3.85481 6.93366 3.20571 7.30827 2.85042 7.91786L0.766471 11.5073C0.411176 12.1169 0.411176 12.8729 0.766471 13.4825L2.85042 17.0787C3.20571 17.6883 3.85481 18.0663 4.56198 18.0663H8.22084V20.5524C8.22084 21.2573 8.59663 21.9078 9.20815 22.2585L13.5024 24.7344C14.114 25.0885 14.8724 25.0885 15.4839 24.7344L19.785 22.2585C20.3965 21.9044 20.7757 21.2573 20.7757 20.5524V18.0663H24.4346C25.1418 18.0663 25.7943 17.6883 26.1462 17.0787L28.2335 13.4791C28.5888 12.8695 28.5888 12.1203 28.2335 11.5039H28.2369L28.2335 11.5073Z"
                            fill="white" />
                    </svg>
                </div>
                <?php do_action("inoby_shop_archive_after_category_description"); ?>
            </div>
            <div class="col-6 col-lg-12 image-column">
                <svg width="0" height="0">
                    <defs>
                        <clipPath id="customClipPath">
                            <path stroke="#000000"
                                d="M725.912 0.00520173H128.01C107.698 0.00520173 88.931 10.8612 78.7514 28.4795L7.63465 151.812C-2.54489 169.472 -2.54489 191.273 7.63465 208.933L78.7514 332.484C88.931 350.144 107.698 361 128.01 361H726L725.912 0V0.00520173Z" />
                        </clipPath>
                    </defs>
                </svg>


                <?php if (! empty($thumbnail_id)) {
                        echo '<img loading="lazy" class="fluid-right" src="' . esc_url($image) . '" alt="hero image">';
                    } else {
                        echo '<img loading="lazy" class="fluid-right" src="' . esc_url(get_stylesheet_directory_uri() . "/assets/img/product-cat-thumb.webp") . '" alt="hero image">';
                }?>
            </div>
        </div>
    </div>
</div>

<?php get_template_part("template-parts/yoast-breadcrumbs", "yoast-breadcrumbs"); ?>

<div class="container container-fluid products-wrp">
    <div class="row">
        <div class="col-12">
            <div class="categories" id="categories">

                <?php
                    $term         = get_queried_object();
                    $genderID     = (isset($_GET['gender']) ? $_GET['gender'] : null);
                    $collectionID = (isset($_GET['collection']) ? $_GET['collection'] : null);
                    $colorID      = (isset($_GET['color']) ? $_GET['color'] : null);
                    $mainCatID    = (isset($_GET['main-category']) ? $_GET['main-category'] : null);
                    $specials     = (isset($_GET['product_specials']) ? $_GET['product_specials'] : null);
                    $tags         = (isset($_GET['product_tag']) ? $_GET['product_tag'] : null);
                    $brands       = (isset($_GET['product_brand']) ? $_GET['product_brand'] : null);

                    $args = [
                        'post_type'        => 'product',
                        'posts_per_page'   => -1,
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                        'fields'           => 'ids',
                        'tax_query'        => [
                            'relation' => 'AND',
                        ],
                        'meta_query'       => [
                            'relation' => 'OR',
                            [
                                'key'   => '_stock_status',
                                'value' => 'instock',
                            ],
                            [
                                'key'   => '_backorders',
                                'value' => 'no',
                            ],
                            [
                                'key'     => '_product_type',
                                'value'   => ['virtual', 'simple', 'variable'], // Include virtual and other types
                                'compare' => 'IN',
                            ],
                        ],
                    ];

                    if ($genderID) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'gender',
                            'field'    => 'id',
                            'terms'    => $genderID,
                        ];
                    }

                    if ($collectionID) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'collection',
                            'field'    => 'id',
                            'terms'    => $collectionID,
                        ];
                    }

                    if ($colorID) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'color',
                            'field'    => 'id',
                            'terms'    => $colorID,
                        ];
                    }

                    if ($mainCatID) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'main-category',
                            'field'    => 'id',
                            'terms'    => $mainCatID,
                        ];
                    }

                    if ($specials) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'product_specials',
                            'field'    => 'id',
                            'terms'    => $specials,
                        ];
                    }

                    if ($tags) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'product_tag',
                            'field'    => 'id',
                            'terms'    => $tags,
                        ];
                    }

                    if ($brands) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'product_brand',
                            'field'    => 'id',
                            'terms'    => $brands,
                        ];
                    }

                    if (is_tax('product_specials')) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'product_specials',
                            'field'    => 'id',
                            'terms'    => get_queried_object()->term_id,
                        ];
                    }

                    if (is_tax('product_tag')) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'product_tag',
                            'field'    => 'id',
                            'terms'    => get_queried_object()->term_id,
                        ];
                    }

                    if (is_tax('product_brand')) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'product_brand',
                            'field'    => 'id',
                            'terms'    => get_queried_object()->term_id,
                        ];
                    }

                    if (is_tax('main-collection')) {
                        $args['tax_query'][] = [
                            'taxonomy' => 'main-collection',
                            'field'    => 'id',
                            'terms'    => get_queried_object()->term_id,
                        ];
                    }

                    $desination_ids = get_posts($args);

                    if (is_product_category()) {
                        $term_id = $term->term_id;

                        $term_children = wp_get_object_terms($desination_ids, 'product_cat', [
                            "parent"     => $term_id,
                            "exclude"    => $term_id,
                            'hide_empty' => true,
                            'fields'     => 'ids',
                        ]);

                        $termlist = array_unique($term_children);

                        $term_parent = get_term($term->parent, "product_cat");

                        if (count($termlist) > 0) {
                            echo '<div class="cats-wrp">';
                            if ($term_parent && ! is_wp_error($term_parent)) {
                                echo "<div class='category-item back'>
                                    <a class='cat' rel='keep-search' href='" . get_term_link($term_parent) . "'>
                                        <div class='name'> " . __("Späť na ", 'inoby') . $term_parent->name . "</div>
                                    </a>
                                </div>";
                            }
                            foreach ($termlist as $child_id) {
                                echo "<div class='category-item'>
                                    <a class='cat' rel='keep-search' href='" . get_term_link($child_id) . "'>
                                        <div class='img-wrp'>
                                            " . wp_get_attachment_image(get_term_meta($child_id, "product_search_image_id", true), "o-2", false, ['loading' => 'lazy']) . "
                                        </div>
                                        <div class='name'>" . get_term($child_id, "product_cat")->name . "</div>
                                    </a>
                                </div>";
                            }
                            echo '</div>';
                        } else {
                            // This category does not have subcategories, showing sibling categories
                            $term_parent_id = $term->parent;
                            if ($term_parent && ! is_wp_error($term_parent)) {

                                $term_siblings = wp_get_object_terms($desination_ids, 'product_cat', [
                                    "parent"     => $term_parent_id,
                                    "exclude"    => $term_id,
                                    'hide_empty' => true,
                                    'fields'     => 'ids',
                                ]);

                                $term_parent = get_term($term->parent, "product_cat");

                                $termlist = array_unique($term_siblings);

                                echo '<div class="cats-wrp">';
                                echo "<div class='category-item back'>
                            <a class='cat' rel='keep-search' href='" . get_term_link($term_parent) . "'>
                            <div class='name'> " . __("Back to ", 'inoby') . $term_parent->name . "</div>
                            </a>
                            </div>";
                                if (! empty($termlist)) {
                                    foreach ($termlist as $sibling) {
                                        echo "<div class='category-item'>
                                    <a class='cat' rel='keep-search' href='" . get_term_link($sibling) . "'>
                                    <div class='img-wrp'>
                                    " .
                                        wp_get_attachment_image(get_term_meta($sibling, "product_search_image_id", true), "o-2", false, ['loading' => 'lazy']) . "
                                    </div>
                                    <div class='name'>" . get_term($sibling, 'product_cat')->name . "</div></a>
                                    </div>";
                                    }
                                }
                                echo '</div>';
                            }
                        }
                    } else {
                        // Check if we are on the 'product_specials' taxonomy archive
                        if (is_tax('product_specials')) {
                            $term_id       = get_queried_object()->term_id; // Get the current term ID
                            $term_children = wp_get_object_terms($desination_ids, 'product_cat', [
                                'hide_empty'       => true,
                                'parent'           => 0,
                                'suppress_filters' => true,
                                'fields'           => 'ids',
                                'exclude'          => 316,
                            ]);

                            $termlist = array_unique($term_children);

                            if (count($termlist) > 0) {
                                echo '<div class="cats-wrp shop">';
                                foreach ($termlist as $child_id) {
                                    if ($child_id != 317) {
                                        // Add the query parameter to the term link
                                        echo "<div class='category-item'>
                                            <a class='cat' rel='keep-search' href='" . add_query_arg('product_specials', $term_id, get_term_link($child_id)) . "'>
                                                <div class='img-wrp'>
                                                    " . wp_get_attachment_image(get_term_meta($child_id, "thumbnail_id", true), "o-2", false, ['loading' => 'lazy']) . "
                                                </div>
                                                <div class='name'>" . get_term($child_id, "product_cat")->name . "</div>
                                            </a>
                                        </div>";
                                    }
                                }
                                echo '</div>';
                            }
                        } else if (is_tax('product_tag')) {
                            $term_id       = get_queried_object()->term_id; // Get the current term ID
                            $term_children = wp_get_object_terms($desination_ids, 'product_cat', [
                                'hide_empty'       => true,
                                'parent'           => 0,
                                'suppress_filters' => true,
                                'fields'           => 'ids',
                                'exclude'          => 316,
                            ]);

                            $termlist = array_unique($term_children);

                            if (count($termlist) > 0) {
                                echo '<div class="cats-wrp shop">';
                                foreach ($termlist as $child_id) {
                                    if ($child_id != 317) {
                                        // Add the query parameter to the term link
                                        echo "<div class='category-item'>
                                            <a class='cat' rel='keep-search' href='" . add_query_arg('product_tag', $term_id, get_term_link($child_id)) . "'>
                                                <div class='img-wrp'>
                                                    " . wp_get_attachment_image(get_term_meta($child_id, "thumbnail_id", true), "o-2", false, ['loading' => 'lazy']) . "
                                                </div>
                                                <div class='name'>" . get_term($child_id, "product_cat")->name . "</div>
                                            </a>
                                        </div>";
                                    }
                                }
                                echo '</div>';
                            }
                        } else if (is_tax('main-collection')) {
                            $term_id       = get_queried_object()->term_id; // Get the current term ID
                            $term_children = wp_get_object_terms($desination_ids, 'product_cat', [
                                'hide_empty'       => true,
                                'parent'           => 0,
                                'suppress_filters' => true,
                                'fields'           => 'ids',
                                'exclude'          => 316,
                            ]);

                            $termlist = array_unique($term_children);

                            if (count($termlist) > 0) {
                                echo '<div class="cats-wrp shop">';
                                foreach ($termlist as $child_id) {
                                    if ($child_id != 317) {
                                        // Add the query parameter to the term link
                                        echo "<div class='category-item'>
                                            <a class='cat' rel='keep-search' href='" . add_query_arg('main-collection', $term_id, get_term_link($child_id)) . "'>
                                                <div class='img-wrp'>
                                                    " . wp_get_attachment_image(get_term_meta($child_id, "thumbnail_id", true), "o-2", false, ['loading' => 'lazy']) . "
                                                </div>
                                                <div class='name'>" . get_term($child_id, "product_cat")->name . "</div>
                                            </a>
                                        </div>";
                                    }
                                }
                                echo '</div>';
                            }
                        } else if (is_tax('product_brand')) {
                            $term_id       = get_queried_object()->term_id; // Get the current term ID
                            $term_children = wp_get_object_terms($desination_ids, 'product_cat', [
                                'hide_empty'       => true,
                                'parent'           => 0,
                                'suppress_filters' => true,
                                'fields'           => 'ids',
                                'exclude'          => 316,
                            ]);

                            $termlist = array_unique($term_children);

                            if (count($termlist) > 0) {
                                echo '<div class="cats-wrp shop">';
                                foreach ($termlist as $child_id) {
                                    if ($child_id != 317) {
                                        // Add the query parameter to the term link
                                        echo "<div class='category-item'>
                                            <a class='cat' rel='keep-search' href='" . add_query_arg('product_brand', $term_id, get_term_link($child_id)) . "'>
                                                <div class='img-wrp'>
                                                    " . wp_get_attachment_image(get_term_meta($child_id, "thumbnail_id", true), "o-2", false, ['loading' => 'lazy']) . "
                                                </div>
                                                <div class='name'>" . get_term($child_id, "product_cat")->name . "</div>
                                            </a>
                                        </div>";
                                    }
                                }
                                echo '</div>';
                            }
                        } else {
                            // Existing code for when not on 'product_specials' taxonomy archive
                            $term_children = wp_get_object_terms($desination_ids, 'product_cat', [
                                'hide_empty'       => true,
                                'parent'           => 0,
                                'suppress_filters' => true,
                                'fields'           => 'ids',
                                'exclude'          => 316,
                            ]);

                            $termlist = array_unique($term_children);

                            if (count($termlist) > 0) {
                                echo '<div class="cats-wrp shop">';
                                foreach ($termlist as $child_id) {
                                    if ($child_id != 317) {
                                        echo "<div class='category-item'>
                                            <a class='cat' rel='keep-search' href='" . get_term_link($child_id) . "'>
                                                <div class='img-wrp'>
                                                    " . wp_get_attachment_image(get_term_meta($child_id, "thumbnail_id", true), "o-2", false, ['loading' => 'lazy']) . "
                                                </div>
                                                <div class='name'>" . get_term($child_id, "product_cat")->name . "</div>
                                            </a>
                                        </div>";
                                    }
                                }
                                echo '</div>';
                            }
                        }
                    }
                ?>
            </div>
            <?php if (! is_search() && Inoby_Config::show_shop_sidebar("true")): ?>
            <div id="products-top-sidebar">
                <?php do_action("woocommerce_sidebar"); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div id="products-main" class="col">
            <?php
                /**
                 * Hook: woocommerce_before_shop_loop.
                 *
                 * @hooked woocommerce_output_all_notices - 10
                 * @hooked woocommerce_result_count - 20
                 * @hooked woocommerce_catalog_ordering - 30
                 */
                // echo '<div class="order-by-wrap">';
                // do_action("woocommerce_before_shop_loop");
                // echo "</div>";
                woocommerce_product_loop_start();

                if (wc_get_loop_prop("total")) {
                    if (isset($cat->term_id)) {
                        $article_grid = get_term_meta($cat->term_id, "archive-banner-boxes", true);
                    } else {
                        $article_grid = null;
                    }
                    if (! empty($article_grid) && isset($article_grid[0])) {
                        if (isset($article_grid[0]['active']) && $article_grid[0]['active']) {
                        ?>

            <div class="banner banner-top">
                <?php

                                $article_url = $article_grid[0]["url"] ?? "";
                                $id          = uniqid('archive_video');

                                if (isset($article_grid[0]['style'])) {
                                    if ($article_grid[0]['style'] == 'style-1') {
                                        $class = 'style-1';
                                    } elseif ($article_grid[0]['style'] == 'style-2') {
                                        $class = 'style-2';
                                    } elseif ($article_grid[0]['style'] == 'style-3') {
                                        $class = 'style-3';
                                    } elseif ($article_grid[0]['style'] == 'video') {
                                        $class = 'video';
                                    } elseif ($article_grid[0]['style'] == 'mood') {
                                        $class = 'mood';
                                    } else {
                                        $class = "";
                                    }
                                } else {
                                    $class = '';
                                }

                                if (isset($article_grid[0]["bg"])) {
                                    if (isset($article_grid[0]["style"]) && $article_grid[0]["style"] == 'video') {
                                        echo '<a href="' . $article_url . '" class="article-section ' . $class . ' video-col" id="' . $id . '" data-src="' . $article_grid[0]['video-id'] . '">';
                                    } else {
                                        echo '<a href="' . $article_url . '" class="article-section ' . $class . '" style="background-image: url(' . wp_get_attachment_image_src(reset($article_grid[0]["bg"]), "o-12")[0] . ');">';
                                    }
                                } else {
                                    echo '<a href="' . $article_url . '" class="article-section article-section-placeholder ' . $class . '">';
                                }
                                if (isset($article_grid[0]["style"]) && $article_grid[0]["style"] == 'video' && isset($article_grid[0]['video-id'])) {
                                ?>

                <?php
                    if (isset($article_grid[0]['bg'])) {
                                    ?>
                <img loading="lazy" src="<?php echo wp_get_attachment_image_src(reset($article_grid[0]["bg"]), "o-6")[0] ?>"
                    alt="Video">
                <?php } else {
                                        echo "<img loading='lazy' src='$default_thumb' alt='Video...' />";
                                    }
                                ?>
<?php if (! empty($article_grid[0]['video-id'])): ?>
                <div id="player<?php echo $id ?>" data-src="<?php echo $article_grid[0]['video-id'] ?>"></div>
                <?php endif; ?>
<?php } else {
                ?>
<?php if (isset($article_grid[0]["style"]) && $article_grid[0]["style"] == 'style-2') {?>
                <svg class="illustration style-2" width="640" height="271" viewBox="0 0 640 271" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M385.848 18.9371L640 159.72V271H0V159.344L243.65 18.9371C287.534 -6.31235 341.964 -6.31235 385.848 18.9371Z"
                        fill="<?php echo(isset($article_grid[0]['illustration-color']) ? $article_grid[0]['illustration-color'] : '#ffffff') ?>"
                        fill-opacity="0.7" />
                </svg>
                <?php } elseif (isset($article_grid[0]['style']) && $article_grid[0]['style'] == 'style-3' || $article_grid[0]['style'] == 'mood') {} else {?>
                <svg class="illustration" width="316" height="289" viewBox="0 0 316 289" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M312.993 133.024L289.551 91.5304C285.541 84.4836 278.216 80.1138 270.235 80.1138H228.903V51.3752C228.903 43.226 224.624 35.7067 217.722 31.6518L169.143 3.0707C162.241 -1.02357 153.759 -1.02357 146.78 3.0707L98.3163 31.6518C91.4148 35.7461 87.1352 43.226 87.1352 51.3752V80.1531H45.8424C37.8614 80.1531 30.5359 84.4836 26.5261 91.5304L3.00732 133.024C-1.00244 140.071 -1.00244 148.811 3.00732 155.858L26.5261 197.43C30.5359 204.477 37.8614 208.847 45.8424 208.847H87.1352V237.585C87.1352 245.735 91.3763 253.254 98.2777 257.309L146.742 285.929C153.643 290.024 162.203 290.024 169.104 285.929L217.645 257.309C224.547 253.215 228.826 245.735 228.826 237.585V208.847H270.119C278.1 208.847 285.464 204.477 289.435 197.43L312.993 155.818C317.002 148.771 317.002 140.11 312.993 132.985H313.031L312.993 133.024Z"
                        fill="<?php echo(isset($article_grid[0]['illustration-color']) ? $article_grid[0]['illustration-color'] : '#ffffff') ?>" />
                    <text>

                    </text>
                </svg>
                <?php }?>
<?php
    if (isset($article_grid[0]['text'])) {
                        echo '<div class="info">';
                        echo isset($article_grid[0]["headline"]) ? "<div class='heading'>" . $article_grid[0]["headline"] . "</div>" : "";

                    ?>
                <p class='link'>
                    <?php echo $article_grid[0]['text'] ?>
<?php if (isset($article_grid[0]["style"]) && $article_grid[0]["style"] == 'style-2') {?>
<?php } else {?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 7.25H14.5V8.75H0.5V7.25Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.3853 7.99617L10.4194 5.03033L11.4801 3.96967L15.5143 8.00382L11.4763 11.9841L10.4233 10.9159L13.3853 7.99617Z"
                            fill="white" />
                    </svg>
                    <?php }?>

                </p>

                <?php
                    echo '</div>';
                                    }
                                }
                                echo "</a>";
                            ?>
            </div>
            <?php }
                }?>

            <?php
                while (have_posts()) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action("woocommerce_shop_loop");

                        wc_get_template_part("content", "product");
                    }
                    if (! empty($article_grid) && isset($article_grid[1])) {
                        if (isset($article_grid[1]['active']) && $article_grid[1]['active']) {
                            if (isset($article_grid[1]['style'])) {
                                if ($article_grid[1]['style'] == 'style-1') {
                                    $classBottom = 'style-1';
                                } elseif ($article_grid[1]['style'] == 'style-2') {
                                    $classBottom = 'style-2';
                                } elseif ($article_grid[1]['style'] == 'style-3') {
                                    $classBottom = 'style-3';
                                } elseif ($article_grid[1]['style'] == 'video') {
                                    $classBottom = 'video';
                                } elseif ($article_grid[1]['style'] == 'mood') {
                                    $classBottom = 'mood';
                                } else {
                                    $classBottom = "";
                                }
                            } else {
                                $classBottom = '';
                            }
                        ?>

            <div class="banner banner-bottom">
                <?php

                                $article_url = $article_grid[1]["url"] ?? "";
                                $id          = uniqid('archive_video');

                                if (isset($article_grid[1]['style'])) {
                                    if ($article_grid[1]['style'] == 'style-1') {
                                        $class = 'style-1';
                                    } elseif ($article_grid[1]['style'] == 'style-2') {
                                        $class = 'style-2';
                                    } elseif ($article_grid[1]['style'] == 'style-3') {
                                        $class = 'style-3';
                                    } elseif ($article_grid[1]['style'] == 'video') {
                                        $class = 'video';
                                    } elseif ($article_grid[1]['style'] == 'mood') {
                                        $class = 'mood';
                                    } else {
                                        $class = "";
                                    }
                                } else {
                                    $class = '';
                                }

                                if (isset($article_grid[1]["bg"])) {
                                    if (isset($article_grid[1]["style"]) && $article_grid[1]["style"] == 'video') {
                                        echo '<a href="' . $article_url . '" class="article-section ' . $class . ' video-col" id="' . $id . '" data-src="' . $article_grid[1]['video-id'] . '">';
                                    } else {
                                        echo '<a href="' . $article_url . '" class="article-section ' . $class . '" style="background-image: url(' . wp_get_attachment_image_src(reset($article_grid[1]["bg"]), "o-12")[0] . ');">';
                                    }
                                } else {
                                    echo '<a href="' . $article_url . '" class="article-section article-section-placeholder ' . $class . '">';
                                }
                                if (isset($article_grid[1]["style"]) && $article_grid[1]["style"] == 'video' && isset($article_grid[1]['video-id'])) {
                                ?>

                <?php
                    if (isset($article_grid[1]['bg'])) {
                                    ?>
                <img loading="lazy" src="<?php echo wp_get_attachment_image_src(reset($article_grid[1]["bg"]), "o-6")[0] ?>"
                    alt="Video">
                <?php } else {
                                        echo "<img loading='lazy' src='$default_thumb' alt='Video...' />";
                                    }
                                ?>
<?php if (! empty($article_grid[1]['video-id'])): ?>
                <div id="player<?php echo $id ?>" data-src="<?php echo $article_grid[1]['video-id'] ?>"></div>
                <?php endif; ?>
<?php } else {
                ?>
<?php if (isset($article_grid[1]["style"]) && $article_grid[1]["style"] == 'style-2') {?>
                <svg class="illustration style-2" width="640" height="271" viewBox="0 0 640 271" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M385.848 18.9371L640 159.72V271H0V159.344L243.65 18.9371C287.534 -6.31235 341.964 -6.31235 385.848 18.9371Z"
                        fill="<?php echo(isset($article_grid[1]['illustration-color']) ? $article_grid[1]['illustration-color'] : '#ffffff') ?>"
                        fill-opacity="0.7" />
                </svg>
                <?php } elseif (isset($article_grid[1]['style']) && $article_grid[1]['style'] == 'style-3' || $article_grid[1]['style'] == 'mood') {} else {?>
                <svg class="illustration" width="316" height="289" viewBox="0 0 316 289" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M312.993 133.024L289.551 91.5304C285.541 84.4836 278.216 80.1138 270.235 80.1138H228.903V51.3752C228.903 43.226 224.624 35.7067 217.722 31.6518L169.143 3.0707C162.241 -1.02357 153.759 -1.02357 146.78 3.0707L98.3163 31.6518C91.4148 35.7461 87.1352 43.226 87.1352 51.3752V80.1531H45.8424C37.8614 80.1531 30.5359 84.4836 26.5261 91.5304L3.00732 133.024C-1.00244 140.071 -1.00244 148.811 3.00732 155.858L26.5261 197.43C30.5359 204.477 37.8614 208.847 45.8424 208.847H87.1352V237.585C87.1352 245.735 91.3763 253.254 98.2777 257.309L146.742 285.929C153.643 290.024 162.203 290.024 169.104 285.929L217.645 257.309C224.547 253.215 228.826 245.735 228.826 237.585V208.847H270.119C278.1 208.847 285.464 204.477 289.435 197.43L312.993 155.818C317.002 148.771 317.002 140.11 312.993 132.985H313.031L312.993 133.024Z"
                        fill="<?php echo(isset($article_grid[1]['illustration-color']) ? $article_grid[1]['illustration-color'] : '#ffffff') ?>" />
                    <text>

                    </text>
                </svg>
                <?php }?>
<?php
    if (isset($article_grid[1]['text'])) {
                        echo '<div class="info">';
                        echo isset($article_grid[1]["headline"]) ? "<div class='heading'>" . $article_grid[1]["headline"] . "</div>" : "";

                    ?>
                <p class='link'>
                    <?php echo $article_grid[1]['text'] ?>
<?php if (isset($article_grid[1]["style"]) && $article_grid[1]["style"] == 'style-2') {?>
<?php } else {?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 7.25H14.5V8.75H0.5V7.25Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.3853 7.99617L10.4194 5.03033L11.4801 3.96967L15.5143 8.00382L11.4763 11.9841L10.4233 10.9159L13.3853 7.99617Z"
                            fill="white" />
                    </svg>
                    <?php }?>

                </p>

                <?php
                    echo '</div>';
                                    }
                                }
                                echo "</a>";
                            ?>
            </div>
            <?php }
                    }
                ?>
<?php rc_shop_pagination(wc_get_loop_prop("total_pages"), wc_get_loop_prop("current_page")); ?>
<?php
    } else {
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action("woocommerce_no_products_found");
}?>


            <?php
                woocommerce_product_loop_end();
            ?>

            <?php
                /**
                 * Hook: woocommerce_after_main_content.
                 *
                 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                 */
                /**
                 *  zakomentovane ukoncenie do_action("woocommerce_before_main_content");
                 */
                // do_action("woocommerce_after_main_content");
            ?>
        </div>
    </div>
</div>

<?php if ((isset($article_grid[0]["style"]) && $article_grid[0]["style"] == 'video') || (isset($article_grid[1]["style"]) && $article_grid[1]["style"] == 'video')) {?>
<script async defer>
// Load the IFrame Player API code asynchronously
var tag = document.createElement('script');
if (!document.querySelector('script[src="https://www.youtube.com/iframe_api"]')) {

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

var playerInstances = {}; // Store player instances by ID
var videoBlocks = $('.video-col'); // Select all video blocks

function onYouTubeIframeAPIReady() {
    videoBlocks.each(function() {
        var id = $(this).attr('id'); // Get the unique ID for this block
        var src = $(this).data('src');
        playerInstances[id] = new YT.Player('player' + id, {
            height: '100%',
            width: '100%',
            playerVars: {
                loop: 1,
                controls: 0,
                showinfo: 0,
                autohide: 1,
                disablekb: 1,
                rel: 0,
                fs: 0,
                mute: 1,
                modestbranding: 1,
                vq: 'hd1080',
                wmode: 'opaque',
                playsinline: 1,
            },
            videoId: src ?? '',
            events: {
                'onReady': function(event) {
                    onPlayerReady(event, id);
                },
                'onStateChange': function(event) {
                    onPlayerStateChange(event, id);
                }
            }
        });
    });
}

function onPlayerReady(event, id) {
    var videoBlock = $('#' + id); // Get the specific video block
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {

                playerInstances[id].playVideo(); // Play video when in view
                setTimeout(() => {
                    videoBlock.find("img").animate({
                        opacity: 0
                    }, 600);
                }, 600);
            } else {
                playerInstances[id].pauseVideo(); // Pause video when out of view
                videoBlock.find("img").animate({
                    opacity: 1
                }, 600);
            }
        });
    });
    observer.observe(videoBlock[0]);

    videoBlock.on('click', function() {
        if (playerInstances[id].getPlayerState() === 1) {
            playerInstances[id].pauseVideo();
            videoBlock.find("img").animate({
                opacity: 1
            }, 600);
        } else {
            playerInstances[id].playVideo();
            setTimeout(() => {
                videoBlock.find("img").animate({
                    opacity: 0
                }, 600);
            }, 600);
        }
    });
}

function onPlayerStateChange(event, id) {
    var videoBlock = $('#' + id);
    if (event.data === -1) {
        playerInstances[id].playVideo();
    }
    if (event.data === 1) {
        setTimeout(() => {
            videoBlock.find("img").animate({
                opacity: 0
            }, 600);
        }, 600);
    }
    if (event.data === 0) {
        playerInstances[id].playVideo();
    }
}

$(document).on('customEvent', function() {
    // Your code here
    playerInstances = {}; // Store player instances by ID
    videoBlocks = $('.video-col'); // Select all video blocks
    onYouTubeIframeAPIReady(); // Load again after AJAX completes
});
</script>
<?php }?>
<?php
do_action("inoby_after_shop_archive");
get_footer("shop");