<?php
$tabs = $args["tabs"]; ?>

<div class="tabs">
  <?php foreach ($tabs as $index => $tab): ?>
  <div class="tab <?= isset($tab["active"]) && $tab["active"] ? "active" : "" ?>" data-tab="<?= $tab["name"] ?>">
    <div class="icon-wrap">
      <svg xmlns="http://www.w3.org/2000/svg" width="61" height="45" viewBox="0 0 61 45" fill="none">
        <path
          d="M36.914 1.79892L57.6595 13.7306C59.2105 14.6226 60.1666 16.2755 60.1666 18.0648V45H0.166626V18.03C0.166626 16.2402 1.12325 14.587 2.67495 13.6951L23.3714 1.79892C27.5508 -0.59964 32.7346 -0.59964 36.914 1.79892Z"
          fill="#CCC9C9" />
      </svg>
      <img src="<?= $tab["icon"] ?>" class="icon" alt="<?= $tab["icon-alt"] ?>">
    </div>
    <p class="label"><?= $tab["label"] ?></p>
  </div>
  <img class="arrow" src="<?= get_theme_file_uri("/assets/icons/checkout-arrow-right.svg") ?>"
    alt="<?= __("Ďalší krok", "rimrebelion") ?>">
  <?php endforeach; ?>
</div>