<?php
  $icon = mb_get_block_field("payment-icon");
  $heading = mb_get_block_field("payment-title");
  $desc = mb_get_block_field("payment-desc");
  $price = mb_get_block_field("payment-price");
?>
<div <?= inoby_block_attrs($attributes, ["class" => "component-payment"]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="payment-box">
                    <div class="payment-box-header">
                        <?php if(!empty($icon)) { 
                          mb_inoby_picture($icon, "s-2");
                        } 
                         
                        if(!empty($heading)) { ?>
                        <h5><?= $heading ?></h5>
                        <?php } ?>
                    </div>
                    <div class="payment-box-content">
                        <?php if(!empty($desc)) { ?>
                        <p class="desc"><?= $desc ?></p>
                        <?php } 
                        if(!empty($price)) { ?>
                        <div class="payment-box-price">
                            <?= $price ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>