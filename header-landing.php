<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
  $fonts =
    rwmb_meta("theme-fonts-select", ["object_type" => "setting"], "options") ??
    "";
  $theme_fonts = rwmb_meta(
    "theme-fonts",
    ["object_type" => "setting"],
    "options",
  );
  if (Inoby_Config::custom_theme_options()) {
    $font_selection =
      rwmb_meta(
        "theme-fonts-select",
        ["object_type" => "setting"],
        "options",
      ) ?? "";
    $theme_fonts_cfg = Inoby_Config::theme_fonts();
    $fonts = array_slice($theme_fonts_cfg, $font_selection, 1, true);
    $font = reset($fonts)["link"] ?? "";
    echo "<link rel=\"preload\" href=\"{$font}\" as=\"style\">
     <link href=\"{$font}\" rel=\"stylesheet\">";
  } else {
    if (!empty($theme_fonts)) {
      foreach ($theme_fonts as $theme_font) {
        echo "<link rel=\"preload\" href=\"{$theme_font}\" as=\"style\">
          <link href=\"{$theme_font}\" rel=\"stylesheet\">";
      }
    } else {
      echo '<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">';
    }
  }
  $custom_scripts = rwmb_meta(
    "theme-custom-head-scripts",
    ["object_type" => "setting"],
    "options",
  );
  if (!empty($custom_scripts)) {
    foreach ($custom_scripts as $custom_script) {
      echo $custom_script;
    }
  }
  ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php if (Inoby_Config::show_preloader()) { ?>
    <?php get_template_part("inoby-plugins/preloader/preloader"); ?>
    <?php } ?>
    <div id="main">
        <div id="header">
            <?php
      if (Inoby_Config::show_topbar()) {
        get_template_part("inoby-plugins/topbar/topbar");
      }
      get_template_part("inoby-plugins/header/header-landing");
      ?>
        </div>
        <div class="promo-banner">
            <?php inoby_promo_banner(); ?>
        </div>