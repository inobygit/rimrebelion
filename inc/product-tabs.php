<?php
add_filter("woocommerce_product_tabs", "rimrebellion_add_product_tab_additional_info", 9999);
function rimrebellion_add_product_tab_additional_info($tabs) {
    $tabs["product-details"] = [
        "title" => __("Product details", "rimrebellion"),
        "priority" => 1, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        "callback" => "rimrebellion_product_tab_additional_info", // TAB CONTENT CALLBACK
    ];
    return $tabs;
}

function rimrebellion_product_tab_additional_info() {
    global $product;
    // echo "Whatever content for " . $product->get_name();
    $additional_info = get_post_meta($product->get_id(), "additional-info", true);
    if (!empty($additional_info)) {
        echo wpautop($additional_info);
    } else {
        echo get_the_excerpt($product->get_id());
    }
}

add_filter("woocommerce_product_tabs", "rimrebellion_add_product_tab_delivery_info", 9999);
function rimrebellion_add_product_tab_delivery_info($tabs) {
    $tabs["delivery-info"] = [
        "title" => __("Delivery info", "rimrebellion"),
        "priority" => 2, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        "callback" => "rimrebellion_product_tab_delivery_info", // TAB CONTENT CALLBACK
    ];
    return $tabs;
}

function rimrebellion_product_tab_delivery_info() {
    global $product;
    echo '<p>'.__("Delivery info for ", 'rimrebellion') . $product->get_name() . '</p>';
    // $additional_info = get_post_meta($product->get_id(), "delivery-info", true);
    // if (!empty($additional_info)) {
    //     echo wpautop($additional_info);
    // }
    echo '<p>'.__('FREE EU SHIPPING FOR ANY REGISTERED CUSTOMER WITH ANY ORDER over 200 EUR' ,'rimrebellion').'</p>';
    echo '<p>'.__('FREE AND CONVENIENT RETURN OF ANY ORDER, FOR ANY REGISTERED CUSTOMER WITHOUT RESTRICTIONS' ,'rimrebellion').'</p>';

}

add_filter("woocommerce_product_tabs", "rimrebellion_add_product_tab_size_help", 9999);
function rimrebellion_add_product_tab_size_help($tabs) {
    global $product;

    $size_help = get_the_terms($product->get_id(), "size-chart"); 

    if(!empty($size_help)){
        $tabs["size-help"] = [
            "title" => __("Size help", "rimrebellion"),
            "priority" => 3, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
            "callback" => "rimrebellion_product_tab_size_help", // TAB CONTENT CALLBACK
        ];
        return $tabs;
    }
    return $tabs;
}

function rimrebellion_product_tab_size_help() {
    global $product;
    
    $size_help = get_the_terms($product->get_id(), "size-chart"); 
    $tableHeading = rwmb_meta("table-heading", ["object_type" => "term"], $size_help[0]->term_id);
    $tableDesc = rwmb_meta("table-desc", ["object_type" => "term"], $size_help[0]->term_id);
    
    $tableNumberColumns = rwmb_meta("table-number-columns", ["object_type" => "term"], $size_help[0]->term_id);

    $tableHeadingsGroup = rwmb_meta("table-headings-group", ["object_type" => "term"], $size_help[0]->term_id);

    $tableRowsGroup = rwmb_meta("table-rows-group", ["object_type" => "term"], $size_help[0]->term_id);
    ?>

<?php if(!empty($tableHeading)) { ?>
<h3 class="table-heading">
    <?= $tableHeading ?>
</h3>
<?php } ?>
<div class="table-wrap">

    <div class="grid-wrap <?php 
        if(!empty($tableRowsGroup)){
            foreach($tableRowsGroup as $row){
                foreach($row as $item){
                    if(isset($item['row-icon'])){
                        echo 'has-icon';
                        break;
                    }
                }
            }
         }
        ?>">
        <div class="grid-container columns-<?php echo $tableNumberColumns ?? '1'; ?>">
            <?php 
                    if(!empty($tableHeadingsGroup)) {
                        echo '<div class="grid-row">';
                        foreach ($tableHeadingsGroup as $heading) : ?>
            <div class="grid-item heading"><?= $heading ?? '' ?></div>
            <?php endforeach; 
            echo '</div>';
                    } ?>
        </div>
        <div class="grid-container columns-<?php echo $tableNumberColumns ?? '1'; ?>">
            <?php
                    if(!empty($tableRowsGroup)) {
                        foreach ($tableRowsGroup as $row) : 
                            foreach ($row as $item) : 
                                echo '<div class="grid-row">';
                                for($i = 1; $i <= $tableNumberColumns; $i++){ ?>
            <div class="grid-item <?= ($i != 1) ? 'regular' : '' ?>">
                <?php if(isset($item['row-icon']) && $i == 1){ ?>
                <img class="icon" src="<?= wp_get_attachment_image_url($item['row-icon'][0], 'full'); ?>" alt="row icon"
                    loading="lazy">
                <?php } ?>
                <?php if($i === 1){
                        echo '<strong>'. ($item['row-'. $i .''] ?? '') .'</strong>';
                    } else {
                        echo ($item['row-'. $i .''] ?? '');
                    } ?>
            </div>
            <?php 
                    }
                    echo '</div>';
                endforeach; ?>
            <?php endforeach; 
            }?>
        </div>

    </div>
</div>

<?php if(!empty($tableDesc)) { ?>
<div class="table-description">
    <?= $tableDesc ?>
</div>
<?php } ?>
<?php
}


/**
 * @snippet WooCommerce Remove Description Tab
 */
add_filter("woocommerce_product_tabs", "rimrebellion_remove_desc_tab", 9999);
function rimrebellion_remove_desc_tab($tabs) {
    unset($tabs["description"]);
    return $tabs;
}

/**
 * @snippet WooCommerce Remove Additional Info Product Tab
 */
add_filter("woocommerce_product_tabs", "rimrebellion_remove_info_tab", 9999);
function rimrebellion_remove_info_tab($tabs) {
    unset($tabs["additional_information"]);
    return $tabs;
}

?>