<?php
$blockHeading = mb_get_block_field('article-headline');
$blockDesc = mb_get_block_field('article-desc');
$blockBtnText = mb_get_block_field('article-btn-text');
$blockBtnUrl = mb_get_block_field('article-btn-url');

$article_grid = mb_get_block_field("article-boxes");
?>

<section <?= inoby_block_attrs($attributes, ["class" => "article-grid"]) ?>>
    <div class="container">
        <div class="row info-row">
            <div class="col-6 col-md-12">
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

            <div class="col-6 col-md-12 end">
                <?php if(!empty($blockBtnText) && !empty($blockBtnUrl)){ ?>
                <a href="<?= $blockBtnUrl ?>" class="button triangleright">
                    <?= $blockBtnText ?>
                </a>
                <?php } ?>
            </div>
        </div>
        <?php if(!empty($article_grid)) { ?>
        <div class="row">
            <div class="col-12">
                <?php 
                echo '<div class="article-grid-wrap-inner">';

                foreach ($article_grid as $article) {
                  $article_url = $article["url"] ?? "";
                  if (isset($article["bg"])) {
                    echo '<a href="' . $article_url . '" class="article-section '. (isset($article['style-2']) && $article["style-2"] == 1 ? 'style-2' : '') .'" style="background-image: url(' . wp_get_attachment_image_src(reset($article["bg"]), "o-6")[0] . ');">';
                  } else {
                    echo '<a href="' . $article_url . '" class="article-section article-section-placeholder '. (isset($article['style-2']) && $article["style-2"] == 1 ? 'style-2' : '') .'">';
                  }
                  ?>
                <?php if(isset($article["style-2"]) && $article["style-2"] == 1) { ?>
                <svg class="illustration style-2" width="640" height="271" viewBox="0 0 640 271" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M385.848 18.9371L640 159.72V271H0V159.344L243.65 18.9371C287.534 -6.31235 341.964 -6.31235 385.848 18.9371Z"
                        fill="<?= (isset($article['illustration-color']) ? $article['illustration-color'] : '#ffffff') ?>"
                        fill-opacity="0.7" />
                </svg>
                <?php } else { ?>
                <svg class="illustration" width="316" height="289" viewBox="0 0 316 289" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M312.993 133.024L289.551 91.5304C285.541 84.4836 278.216 80.1138 270.235 80.1138H228.903V51.3752C228.903 43.226 224.624 35.7067 217.722 31.6518L169.143 3.0707C162.241 -1.02357 153.759 -1.02357 146.78 3.0707L98.3163 31.6518C91.4148 35.7461 87.1352 43.226 87.1352 51.3752V80.1531H45.8424C37.8614 80.1531 30.5359 84.4836 26.5261 91.5304L3.00732 133.024C-1.00244 140.071 -1.00244 148.811 3.00732 155.858L26.5261 197.43C30.5359 204.477 37.8614 208.847 45.8424 208.847H87.1352V237.585C87.1352 245.735 91.3763 253.254 98.2777 257.309L146.742 285.929C153.643 290.024 162.203 290.024 169.104 285.929L217.645 257.309C224.547 253.215 228.826 245.735 228.826 237.585V208.847H270.119C278.1 208.847 285.464 204.477 289.435 197.43L312.993 155.818C317.002 148.771 317.002 140.11 312.993 132.985H313.031L312.993 133.024Z"
                        fill="<?= (isset($article['illustration-color']) ? $article['illustration-color'] : '#ffffff') ?>" />
                    <text>

                    </text>
                </svg>
                <?php } ?>
                <?php
                if(isset($article['text'])){ 
                    echo '<div class="info">';
                  echo isset($article["headline"]) ? "<div class='heading'>" . $article["headline"] . "</div>" : ""; 
                    
                    ?>
                <p class='link'>
                    <?= $article['text'] ?>
                    <?php if(isset($article["style-2"]) && $article["style-2"] == 1) { ?>
                    <?php } else { ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 7.25H14.5V8.75H0.5V7.25Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.3853 7.99617L10.4194 5.03033L11.4801 3.96967L15.5143 8.00382L11.4763 11.9841L10.4233 10.9159L13.3853 7.99617Z"
                            fill="white" />
                    </svg>
                    <?php } ?>

                </p>

                <?php 
            echo '</div>';    
            }
                  echo "</a>";
                }
                echo "</div>";
            ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>