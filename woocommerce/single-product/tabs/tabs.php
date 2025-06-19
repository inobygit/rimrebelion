<?php

/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if (!defined("ABSPATH")) {
  exit();
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters("woocommerce_product_tabs", []);
$key_features = rwmb_meta("key-features");
$technologies = rwmb_meta("technologies");

if (!empty($product_tabs)): ?>
  <section class="product-tabs">
    <div class="container">
      <div class="row">
        <?php if ($key_features): ?>
          <div class="col-4 col-lg-12">
            <div class="key-features-wrap">
              <div class="key-features">
                <h2><?php echo esc_html__("Key features", "rimrebellion"); ?></h2>
                <ul>
                  <?php foreach ($key_features as $feature): ?>
                    <li><?php echo esc_html($feature["feature"]); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
          <script>
            // trigger click after 0.3sec on #tab-title-product-details > h2
            setTimeout(function() {
              const tab = document.querySelector("#tab-title-product-details > h2");
              if (tab) {
                tab.click();
              }
            }, 300);
          </script>
        <?php endif; ?>
        <div class="col-8 col-lg-12">
          <div class="woocommerce-tabs wc-tabs-wrapper desktop">
            <ul class="tabs wc-tabs" role="tablist">
              <?php foreach ($product_tabs as $key => $product_tab): ?>
                <li class="<?php echo esc_attr($key); ?>_tab" id="tab-title-<?php echo esc_attr($key); ?>" role="tab"
                  aria-controls="tab-<?php echo esc_attr($key); ?>">
                  <h2 href="#tab-<?php echo esc_attr($key); ?>">
                    <?php echo wp_kses_post(apply_filters("woocommerce_product_" . $key . "_tab_title", $product_tab["title"], $key)); ?>
                  </h2>
                </li>
              <?php endforeach; ?>
            </ul>
            <?php foreach ($product_tabs as $key => $product_tab): ?>
              <div
                class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                id="tab-<?php echo esc_attr($key); ?>" role="tabpanel"
                aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                <?php if (isset($product_tab["callback"])) {
                  call_user_func($product_tab["callback"], $key, $product_tab);
                } ?>
              </div>
            <?php endforeach; ?>

            <?php do_action("woocommerce_product_after_tabs"); ?>
          </div>

          <div class="woocommerce-tabs wc-tabs-wrapper mobile">
            <ul class="tabs wc-tabs" role="tablist">
              <?php foreach ($product_tabs as $key => $product_tab): ?>
                <li class="<?php echo esc_attr($key); ?>_tab" id="tab-title-<?php echo esc_attr($key); ?>-mobile" role="tab"
                  aria-controls="tab-<?php echo esc_attr($key); ?>-mobile">
                  <h2 href="#tab-<?php echo esc_attr($key); ?>-mobile">
                    <?php echo wp_kses_post(apply_filters("woocommerce_product_" . $key . "_tab_title", $product_tab["title"], $key)); ?>
                  </h2>
                  <div
                    class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                    id="tab-<?php echo esc_attr($key); ?>-mobile" role="tabpanel"
                    aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                    <?php if (isset($product_tab["callback"])) {
                      call_user_func($product_tab["callback"], $key, $product_tab);
                    } ?>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>

            <?php do_action("woocommerce_product_after_tabs"); ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php if ($technologies): ?>
    <section class="technologies">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h2><?php echo esc_html__("Technologies", "rimrebellion"); ?></h2>
            <div class="technologies-wrap">
              <?php
              foreach ($technologies as $technology):
                $img = wp_get_attachment_image($technology["img"][0], "h-4");
                echo '<div class="technology">';
                if (!empty($img)) {
                  echo $img;
                }
                echo '<h3>' . esc_html($technology["headline"]) . '</h3>';
                echo '<div class="text">';
                echo '<p>' . esc_html($technology["text"]) . '</p>';
                echo '</div>';
                echo '</div>';
              endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

<?php endif; ?>