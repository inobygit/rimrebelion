<?php

$cfg = Inoby_Config::component("img-with-text");

//IMG BLOCK
$image = mb_get_block_field("img");
$img_alt_text = mb_get_block_field("img-alt-text");
$img_position = mb_get_block_field("img-position");
$space_col = $cfg["space-col"];

//TEXT BLOCK
$text = mb_get_block_field("text");

//BUTTON BLOCK
$btn_text = mb_get_block_field("btn-text");
$btn_url = mb_get_block_field("btn-url");

$id = uniqid("inoby-img-with-text");

if ($image): ?>
<div <?= inoby_block_attrs($attributes, [
    "id" => $id,
    "class" => "inoby-img-with-text",
  ]) ?>>
    <div class="container">
        <div class="row <?php if ($img_position == "left") {
        echo "left";
      } else {
        echo "right";
      } ?>">
            <div class="col-6 col-md-12">
                <div class="img-wrap">
                    <?= isset($image)
                ? mb_inoby_picture(
                  $image,
                  "o-6",
                  $cfg["bp-sizes"] ?? [],
                )
                : "" ?>
                </div>
            </div>

            <div class="col-6 col-md-12">
                <div class="content-wrap">
                    <div class="text-wrap">
                        <?php echo isset($text) ? "<p>" . $text . "</p>" : ""; ?>
                    </div>
                    <div class="button-wrap">
                        <?php if ($btn_url):
                  echo isset($btn_url) || $btn_text
                    ? '<a href="' .
                      $btn_url .
                      '" class="button triangleright black">' .
                      $btn_text .
                      "</a>"
                    : "";
                endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>