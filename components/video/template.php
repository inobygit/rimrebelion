<?php
//Video
$thumbnail = mb_get_block_field("simple_video_thumbnail");
$default_thumb = mb_get_block_field("simple_video_default_thumb_url");

$video_play_icon = mb_get_block_field("simple_video_play_icon") ?? '';
$play_button_icon = reset($video_play_icon);
if($video_play_icon ){
  $play_button_icon_url = wp_get_attachment_url($play_button_icon["ID"]);
}
else{
  $play_button_icon_url = null;
}


$play_text = mb_get_block_field("simple_video_play_text");
$src = mb_get_block_field("simple_video_src");

$config = Inoby_Config::component("video");

$has_custom_icon = mb_get_block_field("is_custom_play_btn_v");

$custom_icon_url = $config["cutsom-icon-enable"] ?? '';
?>
<section <?= inoby_block_attrs($attributes, ["class" => "video"]) ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="video-wrap">
                    <?php
          if ($default_thumb) {
            if ($thumbnail) {
              echo mb_inoby_picture($thumbnail, "o-12");
            } else {
              echo "<img src='$default_thumb' alt='Video...' />";
            }
          }
          if ($play_button_icon_url) {
            echo '<a class="play-button glightbox-item" href="' . $src . '">';
            echo '<img class="play-icon" src="' . $play_button_icon_url . '" alt="play icon">';
            if ($play_text) {
              echo isset($play_text) ? "<span>" . $play_text . "</span>" : "";
            }
            echo "</a>";
          } else {
            echo '<a class="link link-play glightbox-item" href="' .
              $src .
              '"><svg width="80" height="80" viewBox="-0.5 0 8 8" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>play [#879677]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-427.000000, -3765.000000)" fill="#879677"> <g id="icons" transform="translate(56.000000, 160.000000)"> <polygon id="play-[#879677]" points="371 3605 371 3613 378 3609"> </polygon> </g> </g> </g> </g></svg>' .
              $play_text .
              "</a>";
          }
          ?>
                </div>
            </div>
        </div>
    </div>
</section>