<?php
$heading = mb_get_block_field("build-your-look-heading");
$desc = mb_get_block_field("build-your-look-desc");
$gender = mb_get_block_field("build-your-look-category");

?>

<section class="build-your-look">
    <?php if(!empty($heading)){ ?>
    <a class="header-tag" href="<?php echo get_post_type_archive_link('looks'); ?>">
        <svg width="270" height="193" viewBox="0 0 270 193" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M104.637 184.831L19.4227 135.372C7.39966 128.394 6.77149e-06 115.543 7.9868e-06 101.642L1.68726e-05 -2.36041e-05L270 0L270 101.797C270 115.702 262.596 128.555 250.568 135.532L165.578 184.831C146.771 195.723 123.444 195.723 104.637 184.831Z"
                fill="black" />
        </svg>
        <div class="content">
            <h3>
                <?= $heading ?>
            </h3>
            <?php if(!empty($desc)) { ?>
            <p class="italic"><?= $desc ?></p>
            <?php } ?>
        </div>
    </a>
    <?php } ?>
    <?php if(!empty($gender) && isset($gender)){?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="slider-wrapper">
                    <?php
                    $args = array(
                        'post_type' => 'looks', 
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'look-gender', 
                                'field'    => 'slug',
                                'terms'    => $gender->slug, 
                            ),
                        ),
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                        $current_post = get_post();
                            get_template_part('post-types/looks/parts/card', null, ['post' => $current_post]);
                        endwhile;
                        wp_reset_postdata();
                    ; else :
                        echo 'No posts found';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</section>