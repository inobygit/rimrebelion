<?php
//Content
$headline = mb_get_block_field("video-background-headline");
$text = mb_get_block_field("video-background-text");
$button = mb_get_block_field("video-background-button");
//Video
$thumbnail = mb_get_block_field("video-background-thumbnail");
$default_thumb = mb_get_block_field("video-background-default-thumb-url");
$src = mb_get_block_field("video-background-src");
?>
<div <?= inoby_block_attrs($attributes, ["class" => "component-video-background"]) ?>>
    <div class="video-wrap">
        <?php 
        if ($default_thumb) {
            if ($thumbnail) { 
              ?>
        <img loading="eager" src="<?= wp_get_attachment_image_url(reset($thumbnail)['ID'], "o-12") ?>" alt="Video">
        <?php } else {
              echo "<img src='$default_thumb' alt='Video...' />";
            }
          }
        ?>
        <?php if(!empty($src)): ?>
        <div id="player" data-src="<?= $src ?>"></div>
        <?php endif; ?>
    </div>
    <div class="container controls">
        <div class="row">
            <div class="col-12 end">
                <div class="sound-control">
                    <img src="<?= get_stylesheet_directory_uri() . '/assets/icons/sound-off.svg' ?>"
                        alt="sound off icon" class="sound-off">
                    <img src="<?= get_stylesheet_directory_uri() . '/assets/icons/sound-on.svg' ?>" alt="sound on icon"
                        class="sound-on">

                </div>
            </div>
        </div>
    </div>
    <div class="container content">
        <div class="row">
            <div class="col-7 col-sm-12">
                <?php
          if (!empty($headline)) { ?>
                <h1><?= $headline ?></h1>
                <?php } if(!empty($text)) { ?>
                <p><?= $text ?></p>
                <?php } if(!empty($button)) { ?>
                <a class="button light btn-background" href="<?= $button[1] ?>" target="<?= $button[2] ?>">
                    <?= $button[0] ?></a>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
// 1. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

$('.sound-on').on('click', function(e) {
    e.preventDefault();
    if (player.isMuted()) {
        player.unMute();
    } else {
        player.mute();
    }
    $('.sound-on').hide(300);
    $('.sound-off').show(300);
});

$('.sound-off').on('click', function(e) {
    e.preventDefault();
    if (player.isMuted()) {
        player.unMute();
    } else {
        player.mute();
    }
    $('.sound-off').hide(300);
    $('.sound-on').show(300);
});

// 2. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '100%',
        width: '100%',
        playerVars: {
            loop: 1,
            controls: 0,
            showinfo: 0,
            autohide: 1,
            controls: 0,
            disablekb: 1,
            rel: 0,
            fs: 0,
            mute: 1,
            modestbranding: 1,
            vq: 'hd1080',
            wmode: 'opaque',
            playsinline: 1,
        },
        videoId: '<?php echo $src ?? '' ?>',
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// 3. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    player.playVideo();
    player.mute();
}

var done = false;

function onPlayerStateChange(event) {
    if (event.data === -1) {
        player.playVideo();
    }
    if (event.data === 1) {
        $(".video-wrap img").animate({
            opacity: 0
        }, 500);
        $(".container.controls").animate({
            opacity: 1
        }, 500);
    }
    if (event.data === 0) {
        player.playVideo();
    }
}
</script>