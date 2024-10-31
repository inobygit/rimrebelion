<?php
$columns = mb_get_block_field("icon-box-columns");
$icon_boxes = mb_get_block_field("icon-boxes");

$icon_boxes_heading = mb_get_block_field("icon-boxes-heading");
$icon_boxes_desc = mb_get_block_field("icon-boxes-desc");
$icon_boxes_btn_text = mb_get_block_field("icon-boxes-btn-text");
$icon_boxes_btn_link = mb_get_block_field("icon-boxes-btn-link");

$colClass = "col-4";

if(!empty($columns)){
  if($columns == 1){
    $colClass = 'col-12';
  }
  else if($columns == 2){
    $colClass = 'col-6';
  }
  else if($columns == 3){
    $colClass = 'col-4';
  }
  else if($columns == 4){
    $colClass = 'col-3';
  }
  else if($columns == 5){
    $colClass = 'col-2-5';
  }
  else if($columns == 6){
    $colClass = 'col-2';
  }
}

?>
<section <?= inoby_block_attrs($attributes, ["class" => "icon-boxes"]) ?>>
    <div class="container">
        <div class="row info-row">
            <div class="col-6 col-md-12">
                <?php if(!empty($icon_boxes_heading)){ ?>
                <h3>
                    <?= $icon_boxes_heading ?>
                </h3>
                <?php } ?>
                <?php if(!empty($icon_boxes_desc)){ ?>
                <p>
                    <?= $icon_boxes_desc ?>
                </p>
                <?php } ?>
            </div>

            <div class="col-6 col-md-12 end">
                <?php if(!empty($icon_boxes_btn_text) && !empty($icon_boxes_btn_link)){ ?>
                <a href="<?= $icon_boxes_btn_link ?>" class="button triangleright">
                    <?= $icon_boxes_btn_text ?>
                </a>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <?php foreach ($icon_boxes as $icon): ?>
            <div class="<?= $colClass ?> col-lg-6 col-md-12">
                <div class="icon-box">
                    <?php
                        if(isset($icon['icon'])){ ?>
                    <div class="icon-wrp">
                        <?php echo mb_inoby_picture($icon["icon"], "o-4") ?>
                    </div>
                    <?php }
                echo isset($icon["headline"]) ? "<h3>" . $icon["headline"] . "</h3>" : "";
                echo isset($icon["text"]) ? "<p>" . $icon["text"] . "</p>" : "";
                ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>