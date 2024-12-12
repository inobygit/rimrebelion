<?php

/**
 * Checkbox fields should have default value set to false. Because if
 * set to true & checkbox is not checked, function "inoby_parse_args"
 * will evaluate the field as thruthy because it is not present in
 * the fieldlist and therefore the default value will be used.
 *
 * If you want to enable some features by default, you should
 * add ["std" => "on"] to metabox checkbox field.
 * @package inobydoc
 */

$sliderID = uniqid("inoby-references-slider-");
$heading = mb_get_block_field("references-slider-heading");
$desc = mb_get_block_field("references-slider-desc");
$references = mb_get_block_field("references-group"); 
?>


<div <?= inoby_block_attrs($attributes, [
  "class" => "inoby-references-slider",
  "id" => $sliderID,
  'data-number-items' => sizeof($references),
]) ?>>
    <div class="container">
        <?php if(!empty($references)) { ?>
        <div class="row items-center">
            <div class="col-6 col-md-12">
                <?php if(!empty($heading)){ ?>
                <h3>
                    <?= $heading ?>
                </h3>
                <?php } ?>
                <?php if(!empty($desc)){ ?>
                <h4>
                    <?= $desc ?>
                </h4>
                <?php } ?>
            </div>
            <div class="col-12">
                <div class="keen-slider references" data-items="<?= sizeof($references) ?>">
                    <?php foreach ($references as $reference): ?>

                    <div class="references-slide">
                        <div class="references-card">
                            <div class="content">
                                <?php if(isset($reference['reference'])){ ?>
                                <p><?= $reference['reference'] ?></p>
                                <?php } ?>
                                <div class="info">
                                    <?php if(isset($reference['photo']) && is_array($reference['photo'])){ ?>
                                    <div class="photo">
                                        <svg width="0" height="0">
                                            <defs>
                                                <clipPath id="customClipPathImage">
                                                    <path stroke="#000000"
                                                        d="M70.2966 29.919L65.0692 20.5864C64.175 19.0015 62.5415 18.0187 60.7617 18.0187H51.5449V11.555C51.5449 9.72211 50.5906 8.03092 49.0516 7.11892L38.2184 0.690642C36.6794 -0.230214 34.7879 -0.230214 33.2317 0.690642L22.4243 7.11892C20.8853 8.03978 19.9309 9.72211 19.9309 11.555V18.0275H10.7227C8.943 18.0275 7.30943 19.0015 6.41526 20.5864L1.17063 29.919C0.276458 31.5039 0.276458 33.4696 1.17063 35.0545L6.41526 44.4047C7.30943 45.9897 8.943 46.9725 10.7227 46.9725H19.9309V53.4362C19.9309 55.269 20.8767 56.9602 22.4157 57.8722L33.2231 64.3094C34.7621 65.2302 36.6708 65.2302 38.2098 64.3094L49.0344 57.8722C50.5734 56.9514 51.5277 55.269 51.5277 53.4362V46.9725H60.7359C62.5157 46.9725 64.1578 45.9897 65.0434 44.4047L70.2966 35.0456C71.1908 33.4607 71.1908 31.5127 70.2966 29.9101H70.3052L70.2966 29.919Z" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <?php mb_inoby_picture($reference['photo'], 'o-6'); ?>
                                    </div>
                                    <?php } ?>
                                    <div class="info-content">
                                        <?php if(isset($reference['name'])){ ?>
                                        <h3><?= $reference['name'] ?></h3>
                                        <?php } ?>
                                        <?php if(isset($reference['position'])){ ?>
                                        <p><?= $reference['position'] ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <?php } ?>
    </div>
</div>