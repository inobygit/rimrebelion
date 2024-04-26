<?php
defined("ABSPATH") || exit();

$name = str_replace("pa_", "p-", $args["name"]);
$filter = $args["filter"];

$value = isset($_GET[$name]) ? explode("-", $_GET[$name]) : [];
$checked = [];
foreach ($value as $key) {
  $checked[$key] = true;
}

$select = $filter->display == "select";
$expandable = $filter->display == "hidden";
$tooltip = $filter->tooltip ?? '';
$has_search = ($filter->has_search ?? false) == true;
$peekSize = 5;
$peekCount = 0;
$peek = $filter->display == "peek" && count($filter->items) > $peekSize;

$show_swatches = $filter->show_swatches ?? false;
$hide_single_option_filters = apply_filters("rc_hide_single_option_filters", true, $filter);

if ($peek) {
  // first we peek all checked options
  foreach ($filter->items as $option) {
    $option->peek = isset($checked[$option->id]);
    if ($option->peek) {
      $peekCount++;
    }
  }
  // then enabled options to max $peekSize
  foreach ($filter->items as $option) {
    if ($option->count && !$option->peek && $peekCount < $peekSize) {
      $option->peek = true;
      $peekCount++;
    }
  }
  // then disabled options to max $peekSize
  foreach ($filter->items as $option) {
    if (!$option->count && !$option->peek && $peekCount < $peekSize) {
      $option->peek = true;
      $peekCount++;
    }
  }
}
?>
<?php if(!$select): ?>
<div class="checkboxes-wrapper input-group <?= $show_swatches ? "show-swatches" : "" ?>" <?php if ($hide_single_option_filters && count($filter->items) <= 1) {
    echo 'style="display: none;"';
  } ?>>
  <?php if ($expandable || $show_swatches): ?>
  <div class="expandable-wrp <?= $filter->expanded ? "expanded" : "" ?>">
    <input type="hidden" name="expanded[<?= $args["name"] ?>]" value="<?= $filter->expanded ?>">
    <?php endif; ?>
    <label for=" filter-<?= $name ?>"><?= $filter->label ?><?php if($filter->tooltip): ?><div class="tooltip-toggle"
        aria-label="<?= $filter->tooltip ?>"></div>
      <?php endif;?></label>
    <?php if ($expandable || $show_swatches): ?>
  </div>
  <?php endif; ?>
  <?php if ($has_search): ?>
  <div class="search-wrp" data-no-results-text="<?= __("Nenašli sa žiadne výsledky", "rootcommerce") ?>">
    <input type="text" class="search-input">
    <?php ob_start(); ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"
      stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
    <?php
      $search_icon = ob_get_clean();
      echo apply_filters("rootcommerce_filter_search_icon", $search_icon);
      ?>
  </div>
  <?php endif; ?>
  <div id="filter-<?= $name ?>" class="filter-wrp">
    <?php foreach ($filter->items as $index => $option):

      $is_checked = $checked[$option->id] ?? false;
      $count = $checked[$option->id] ?? false;
      $disabled = $option->count == 0 && !$is_checked;
      ?>
    <div class="input-wrp <?= $peek ? ($option->peek ? "peek" : "hidden") : "" ?>">
      <?php if ($show_swatches): ?>
      <input style="background: <?= RC_Filter_Module::rc_get_filter_swatch_bg($option->id) ?>" type="checkbox"
        id="option-<?= $option->id ?>" name="<?= $name ?>[]" value="<?= $option->id ?>"
        <?= $disabled ? 'disabled="disabled"' : "" ?> <?= $is_checked ? "checked" : "" ?>>
      <?php else: ?>
      <input type="checkbox" id="option-<?= $option->id ?>" name="<?= $name ?>[]" value="<?= $option->id ?>"
        <?= $disabled ? 'disabled="disabled"' : "" ?> <?= $is_checked ? "checked" : "" ?>>
      <?php endif; ?>
      <label for="option-<?= $option->id ?>">
        <span data-content="<?= $option->name ?>"><?= $option->name ?></span>
      </label>
      <div class="count">( <?= $option->count ?> )</div>
    </div>
    <?php
    endforeach; ?>
    <input type="hidden" name="<?= $name ?>" value="<?= $_GET[$name] ?? "" ?>">
  </div>
  <?php if ($peek): ?>
  <div class="filter-peek-btn" showtext="<?= __("Show more", "rootcommerce") ?>"
    hidetext="<?= __("Show less", "rootcommerce") ?>"></div>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php if($select): ?>
<div class="select-wrapper input-group" <?php if ($hide_single_option_filters && count($filter->items) <= 1) {
    echo 'style="display: none;"';
  } ?>>
  <label for=" filter-<?= $name ?>"><?= $filter->label ?><?php if($filter->tooltip): ?><div class="tooltip-toggle"
      aria-label="<?= $filter->tooltip ?>"></div>
    <?php endif;?></label>
  <div id="filter-<?= $name ?>" class="filter-wrp">
    <select class="multiple-select" name="<?= $name ?>" multiple="multiple"
      data-placeholder="<?= __("Choose from list", "rootcommerce") ?>">
      <?php foreach ($filter->items as $index => $option):
      $is_checked = $checked[$option->id] ?? false;
      // $count = $checked[$option->id] ?? false;
      ?>
      <option id="option-<?= $option->id ?>" value="<?= $option->id ?>" <?= $is_checked ? "selected" : "" ?>>
        <?= $option->name ?>
      </option>
      <?php
    endforeach; ?>
    </select>
    <input type="hidden" name="<?= $name ?>" value="<?= $_GET[$name] ?? "" ?>">
  </div>
</div>
<?php endif; ?>