<?php
//Content
$type = mb_get_block_field("video-section-headline-type");
$headline = mb_get_block_field("video-section-headline");
$text = mb_get_block_field("video-section-text");
$buttons = mb_get_block_field("video-section-buttons");
//Video
$thumbnail = mb_get_block_field("video-section-thumbnail");
$default_thumb = mb_get_block_field("video-section-default-thumb-url");
$play = mb_get_block_field("video-section-play-text");
$src = mb_get_block_field("video-section-src");
$autoplay = mb_get_block_field("video-section-autoplay") ?? 0;
$position = mb_get_block_field("video-section-position");

$id = uniqid('video_section');
?>
<div <?= inoby_block_attrs($attributes, ["class" => "component-video-section"]) ?> id="<?= $id ?>">
    <div class="container">
        <div class="row <?= $position ?>">
            <div class="col-6 col-md-12 video-col" id="<?= $id ?>" data-autoplay="<?= $autoplay ?>">
                <div class="video-wrap">
                    <?php 
                  echo '<span class="link-play"><svg width="80" height="80" viewBox="-0.5 0 8 8" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>play [#879677]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-427.000000, -3765.000000)" fill="#879677"> <g id="icons" transform="translate(56.000000, 160.000000)"> <polygon id="play-[#879677]" points="371 3605 371 3613 378 3609"> </polygon> </g> </g> </g> </g></svg></span>'; ?>
                    <?php 
        if ($default_thumb) {
            if ($thumbnail) { 
              ?>
                    <img loading="eager" src="<?= wp_get_attachment_image_url(reset($thumbnail)['ID'], "o-12") ?>"
                        alt="Video">
                    <?php } else {
              echo "<img loading='lazy' src='$default_thumb' alt='Video...' />";
            }
          }
        ?>
                    <?php if(!empty($src)): ?>
                    <div id="player<?= $id ?>" data-src="<?= $src ?>"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-6 col-md-12">
                <div class="content-wrap">
                    <?php
          if ($type) {
            echo "<" . $type . ">" . $headline . "</" . $type . ">";
          }
          if ($text) {
            echo "<p>" . $text . "</p>";
          }
          if ($buttons) {
            echo "<div class='btn-wrap'>";
            foreach ($buttons as $button) {
              echo '<a class="button triangleright black" href="' . $button[1] . '" target="' . $button[2] . '">' . $button[0] . "</a>";
            }
            echo "</div>";
          }
          ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script async defer>
// Load the IFrame Player API code asynchronously
var tag = document.createElement('script');
if (!document.querySelector('script[src="https://www.youtube.com/iframe_api"]')) {

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

var playerInstances = {}; // Store player instances by ID
var videoBlocks = $('.video-col'); // Select all video blocks

function onYouTubeIframeAPIReady() {
    videoBlocks.each(function() {
        var id = $(this).attr('id'); // Get the unique ID for this block
        playerInstances[id] = new YT.Player('player' + id, {
            height: '100%',
            width: '100%',
            playerVars: {
                loop: 1,
                controls: 0,
                showinfo: 0,
                autohide: 1,
                disablekb: 1,
                rel: 0,
                fs: 0,
                mute: 1,
                modestbranding: 1,
                vq: 'hd1080',
                wmode: 'opaque',
                playsinline: 1,
            },
            videoId: '<?= $src ?? '' ?>',
            events: {
                'onReady': function(event) {
                    onPlayerReady(event, id);
                },
                'onStateChange': function(event) {
                    onPlayerStateChange(event, id);
                }
            }
        });
    });
}

function onPlayerReady(event, id) {
    var videoBlock = $('#' + id); // Get the specific video block
    var autoplay = $(videoBlock).find('.video-col').data('autoplay'); // Get the unique ID for this block
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                videoBlock.find(".video-wrap img").animate({
                    opacity: 0
                }, 500);
                videoBlock.find(".video-wrap .link-play").hide();
                playerInstances[id].playVideo(); // Play video when in view
            } else {
                videoBlock.find(".video-wrap img").animate({
                    opacity: 1
                }, 500);
                videoBlock.find(".video-wrap .link-play").show();
                playerInstances[id].pauseVideo(); // Pause video when out of view
            }
        });
    });

    if (autoplay) {
        observer.observe(videoBlock[0]);
    }

    videoBlock.on('click', function() {
        if (playerInstances[id].getPlayerState() === 1) {
            videoBlock.find(".video-wrap img").animate({
                opacity: 1
            }, 500);
            videoBlock.find(".video-wrap .link-play").show();
            playerInstances[id].pauseVideo();
        } else {
            videoBlock.find(".video-wrap img").animate({
                opacity: 0
            }, 500);
            videoBlock.find(".video-wrap .link-play").hide();
            playerInstances[id].playVideo();
        }
    });
}

function onPlayerStateChange(event, id) {
    var videoBlock = $('#' + id);
    if (event.data === -1) {
        playerInstances[id].playVideo();
    }
    if (event.data === 1) {
        videoBlock.find(".video-wrap img").animate({
            opacity: 0
        }, 500);
        videoBlock.find(".video-wrap .link-play").hide();
    }
    if (event.data === 0) {
        playerInstances[id].playVideo();
    }
}
</script>