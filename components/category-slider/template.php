<?php
    $slider = mb_get_block_field("category-slider-categories");
    $genders = mb_get_block_field("category-slider-genders");
    $gender = '';
    
    if(function_exists('icl_object_id')){
        $original_ID = icl_object_id( get_the_ID(), 'page', false, 'en' );
        if(!empty($genders)){
            if($original_ID === get_the_ID()){
                $gender = "page/1/?gender=".$genders->term_id."&disable_auto_apply_filter=false";
            } else {
                $gender = "&gender=".$genders->term_id."&disable_auto_apply_filter=false";
            }
        }
    }

?>
<div <?= inoby_block_attrs($attributes, ["class" => "component-category-slider"]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="category-slider">
                    <?php foreach($slider as $category): ?>
                    <div class="category-slide">
                        <a href="<?= get_term_link($category) . (!empty($gender) ? $gender : '' )?>">
                            <div class="category-slide-inner">
                                <div class="category-slide-image">
                                    <?= wp_get_attachment_image(get_term_meta($category->term_id, "product_search_image_id", true), "o-2") ?>
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