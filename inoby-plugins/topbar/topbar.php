<?php
$topbar_layout = rwmb_meta("mb-topbar-layout", ["object_type" => "setting"], "options");
if ($topbar_layout !== "topbar-none") { ?>

<div id="topbar">
    <div class="container">
        <div class="row">
            <?php
        echo '<div class="topbar-center marquee js-marquee">';
        echo '<div class="marquee-inner">';
        $topbar_center_items = rwmb_meta("topbar-items-center", ["object_type" => "setting"], "options");
        foreach ($topbar_center_items as $topbar_center_item) {
          if (empty($topbar_center_item[1])) {
            echo '<span class="' . $topbar_center_item[2] . '">' . $topbar_center_item[0] . "</span>";
          } else {
            echo '<a class="' . $topbar_center_item[2] . '" href="' . $topbar_center_item[1] . '">' . $topbar_center_item[0] . "</a>";
          }
        }
        echo "</div>";
        echo "</div>";
      ?>
        </div>
    </div>
</div>

<?php }
?>