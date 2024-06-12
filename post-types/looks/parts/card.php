<?php

// get post
/**
 * @var WP_Post
 */
$post = $args["post"] ?? false;

if (!$post) {
  return;
}

$card_bg = rwmb_meta('look-header-background');
?>
<div class="post-card">
    <a href="<?php the_permalink($post); ?>" class="post-card-content"
        <?= (!empty($card_bg) ? 'style="background-color: '. $card_bg .'"' : '') ?>>
        <?php $url = get_the_post_thumbnail_url($post, "o-6"); ?>
        <?php if ($url): ?>
        <img src="<?= $url ?>" alt="<?= get_the_title($post) ?>">
        <?php else: ?>
        <img class="default" src="<?= get_theme_file_uri("assets/svg/logo.svg") ?>" alt="logo">
        <?php endif; ?>
    </a>
</div>