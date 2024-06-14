<?php
$card_template = $args["card_template"] ?? "";
$card_classes = $args["card-classes"] ?? "";
$looks_gender = $args['gender'] ?? "";
$more_text = __("Show more", "rimrebellion");
$load_text = __("Loading...", "rimrebellion");

$button_args = "";
$button_args .= $card_template ? " card-template=\"{$card_template}\"" : "";
$button_args .= $card_classes ? " card-classes=\"{$card_classes}\"" : "";
$button_args .= "more-text=\"{$more_text}\"";
$button_args .= "load-text=\"{$load_text}\"";
$button_args .= "gender=\"{$looks_gender}\"";

if (Inoby_Config::latest_posts() > 0) {
  // todo: pri latest_posts zobrazi tlacidlo aj pri poslednej page kvoli ofsettu
  if ($wp_query->max_num_pages > 1.1): ?>
<div class="row">
    <div class="col-12 loadmore-actions">
        <a href="#0" class="button triangleleft triangleright posts_loadmore_child"
            <?= $button_args ?>><?= __("Show more", 'rimrebellion') ?></a>
    </div>
</div>
<?php endif;
} else {
  if ($wp_query->max_num_pages > 1): ?>
<div class="row">
    <div class="col-12 loadmore-actions">
        <a href="#0" class="button triangleleft triangleright posts_loadmore_child"
            <?= $button_args ?>><?= __("Show more", 'rimrebellion') ?></a>
    </div>
</div>
<?php endif;
}
?>