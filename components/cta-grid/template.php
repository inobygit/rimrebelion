<?php
$blockHeading = mb_get_block_field('cta-headline');
$blockDesc = mb_get_block_field('cta-desc');
$blockBtnText = mb_get_block_field('cta-btn-text');
$blockBtnUrl = mb_get_block_field('cta-btn-url');

$cta_grid = mb_get_block_field("cta-grid");
?>

<section <?= inoby_block_attrs($attributes, ["class" => "cta-grid"]) ?>>
    <div class="container">
        <div class="row items-center">
            <div class="col-9 col-md-12">
                <?php if(!empty($blockHeading)){ ?>
                <h3>
                    <?= $blockHeading ?>
                </h3>
                <?php } ?>
                <?php if(!empty($blockDesc)){ ?>
                <p>
                    <?= $blockDesc ?>
                </p>
                <?php } ?>
            </div>
        </div>
        <?php if(!empty($cta_grid)) { ?>
        <div class="row">
            <div class="col-12">
                <?php 
                echo '<div class="cta-grid-wrap-inner">';

                foreach ($cta_grid as $i => $cta) {
                  $cta_url = $cta["url"] ?? "";
                  if (isset($cta["bg"])) {
                    echo '<a href="' . $cta_url . '" class="cta-section" style="background-image: url(' . wp_get_attachment_image_src(reset($cta["bg"]), "o-6")[0] . ');">';
                  } else {
                    echo '<a href="' . $cta_url . '" class="cta-section cta-section-placeholder">';
                  }
                  if($i === 2){
                    echo file_get_contents(get_stylesheet_directory() . '/assets/svg/pattern.svg');
                  }
                  echo isset($cta["headline"]) ? "<h2>" . $cta["headline"] . "</h2>" : ""; 
                  if(isset($cta['text'])){
                  ?>
                <p class='link'>
                    <?= $cta['text'] ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 7.25H14.5V8.75H0.5V7.25Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.3853 7.99617L10.4194 5.03033L11.4801 3.96967L15.5143 8.00382L11.4763 11.9841L10.4233 10.9159L13.3853 7.99617Z"
                            fill="white" />
                    </svg>

                </p>
                <?php }
                  echo "</a>";
                }
                echo "</div>";
            ?>
            </div>
        </div>
        <?php } ?>
        <div class="row items-center">
            <div class="col-9 col-md-12">
                <?php if(!empty($blockBtnText) && !empty($blockBtnUrl)){ ?>
                <a href="<?= $blockBtnUrl ?>" class="button triangleBoth black">
                    <?= $blockBtnText ?>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>