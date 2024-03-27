<?php
/**
 * Template Name: List of components
 */

get_header();
?>

<section class="components">
  <div class="container">
    <div class="row">
      <div style="margin: 100px auto;" class="col-8 col-md-12">
        <h1><?= __('Komponenty','inoby') ?></h1>
        <?php

  $block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
  foreach ($block_types as $block_type) {
    $block_title = $block_type->render_callback[0]->meta_box["title"] ?? '';
    $block_id = $block_type->render_callback[0]->meta_box["id"] ?? '';
    $render_template = $block_type->render_callback[0]->render_template ?? '';
    $preview  = str_replace('template.php', 'preview.png', $render_template);
    $pos = strpos($preview, '/wp-content/');
    $preview_local  = substr($preview, $pos);
    $block_icon = $block_type->render_callback[0]->icon ?? '';
    if($block_title){ ?>
        <div id="<?= $block_id ?>" class="block-type" style="margin-bottom: 60px;">
          <span class="dashicons dashicons-<?= $block_icon ?>"></span>
          <h2><?= $block_title ?></h2>
          <span style="display: none;"><?= $render_template ?></span>
          <?php
          if ( file_exists( $preview ) ) {
            echo '<img src="'.$preview_local.'">';
         }
          ?>
        </div>
        <?php
        }
  }
?>
      </div>
    </div>
  </div>
</section>

<?php get_footer();