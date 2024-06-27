<?php

defined("ABSPATH") || exit();

class RC_Ajax_custom extends RC_Ajax {
  public static function init() {
    add_action("init", [__CLASS__, "define_ajax"], 0);
    add_action("template_redirect", [__CLASS__, "do_rc_ajax"], 0);
    self::add_ajax_events();
  }

  public static function define_ajax() {
    if (!empty($_GET["rc-ajax"])) {
      wc_maybe_define_constant("DOING_AJAX", true);
      wc_maybe_define_constant("RC_DOING_AJAX", true);
      if (!WP_DEBUG || (WP_DEBUG && !WP_DEBUG_DISPLAY)) {
        @ini_set("display_errors", 0); // Turn off display_errors during AJAX events to prevent malformed JSON.
      }
      $GLOBALS["wpdb"]->hide_errors();
    }
  }

  private static function rc_ajax_headers() {
    if (!headers_sent()) {
      send_origin_headers();
      send_nosniff_header();
      wc_nocache_headers();
      header("Content-Type: text/html; charset=" . get_option("blog_charset"));
      header("X-Robots-Tag: noindex");
      status_header(200);
    } elseif (Constants::is_true("WP_DEBUG")) {
      headers_sent($file, $line);
      trigger_error("rc_ajax_headers cannot set headers - headers already sent by {$file} on line {$line}", E_USER_NOTICE); // @codingStandardsIgnoreLine
    }
  }

  public static function do_rc_ajax() {
    global $wp_query;

    if (!empty($_GET["rc-ajax"])) {
      $wp_query->set("rc-ajax", sanitize_text_field(wp_unslash($_GET["rc-ajax"])));
    }

    $action = $wp_query->get("rc-ajax");

    if ($action) {
      self::rc_ajax_headers();
      $action = sanitize_text_field($action);
      do_action("rc_ajax_" . $action);
      wp_die();
    }
  }

  public static function add_ajax_events() {
    $ajax_events_nopriv = [
      "add_to_cart",
      "add_to_cart_single",
      "remove_from_cart",
      "update_cart",
      "update_totals",
      "update_checkout_customer",
      "get_checkout_fragments",
      "validate_cart_items",
      "validate_vat",
      "newsletter_request",
      "contact_request",
      "apply_coupon",
      "remove_coupon",
      "search_products",
    ];

    foreach ($ajax_events_nopriv as $ajax_event) {
      add_action("wp_ajax_rootcommerce_" . $ajax_event, [__CLASS__, $ajax_event]);
      add_action("wp_ajax_nopriv_rootcommerce_" . $ajax_event, [__CLASS__, $ajax_event]);

      add_action("rc_ajax_" . $ajax_event, [__CLASS__, $ajax_event]);
    }
  }

  private static function add_to_cart_handler_variable($product_id) {
    $variation_id = empty($_POST["variation_id"]) ? "" : absint(wp_unslash($_POST["variation_id"]));
    $quantity = empty($_POST["quantity"]) ? 1 : wc_stock_amount(wp_unslash($_POST["quantity"]));
    $variations = [];

    $product = wc_get_product($product_id);

    foreach ($_POST as $key => $value) {
      if ("attribute_" !== substr($key, 0, 10)) {
        continue;
      }

      $variations[sanitize_title(wp_unslash($key))] = wp_unslash($value);
    }

    $passed_validation = apply_filters("woocommerce_add_to_cart_validation", true, $product_id, $quantity, $variation_id, $variations);

    if (!$passed_validation) {
      return false;
    }

    // Prevent parent variable product from being added to cart.
    if (empty($variation_id) && $product && $product->is_type("variable")) {
      wc_add_notice(__("Select variation of product", "rootcommerce"), "error");
      return false;
    }

    if (false !== WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variations, self::prepare_product_cart_item_data($product))) {
      return true;
    }

    return false;
  }

  private static function add_to_cart_handler_grouped($product_id) {
    $was_added_to_cart = false;
    $added_to_cart = [];
    $items = isset($_POST["quantity"]) && is_array($_POST["quantity"]) ? wp_unslash($_POST["quantity"]) : [];

    if (!empty($items)) {
      $quantity_set = false;

      foreach ($items as $item => $quantity) {
        $quantity = wc_stock_amount($quantity);
        if ($quantity <= 0) {
          continue;
        }
        $quantity_set = true;

        $passed_validation = apply_filters("woocommerce_add_to_cart_validation", true, $item, $quantity);

        // Suppress total recalculation until finished.
        remove_action("woocommerce_add_to_cart", [WC()->cart, "calculate_totals"], 20, 0);

        if ($passed_validation && false !== WC()->cart->add_to_cart($item, $quantity)) {
          $was_added_to_cart = true;
          $added_to_cart[$item] = $quantity;
        }

        add_action("woocommerce_add_to_cart", [WC()->cart, "calculate_totals"], 20, 0);
      }

      if (!$was_added_to_cart && !$quantity_set) {
        wc_add_notice(__("Please choose the quantity of items you wish to add to your cart&hellip;", "woocommerce"), "error");
      } elseif ($was_added_to_cart) {
        wc_add_to_cart_message($added_to_cart);
        WC()->cart->calculate_totals();
        return true;
      }
    } elseif ($product_id) {
      wc_add_notice(__("Please choose a product to add to your cart&hellip;", "woocommerce"), "error");
    }
    return false;
  }

  private static function add_to_cart_handler_simple($product) {
    $product_id = $product->get_id();
    $quantity = empty($_POST["quantity"]) ? 1 : wc_stock_amount(wp_unslash($_POST["quantity"]));
    $passed_validation = apply_filters("woocommerce_add_to_cart_validation", true, $product_id, $quantity);

    if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity, 0, [], self::prepare_product_cart_item_data($product))) {
      return true;
    }
    return false;
  }

  public static function add_to_cart_single() {
    if (!isset($_POST["rc-add-to-cart"]) || !is_numeric(wp_unslash($_POST["rc-add-to-cart"]))) {
      return;
    }

    $product_id = apply_filters("woocommerce_add_to_cart_product_id", absint(wp_unslash($_POST["rc-add-to-cart"])));
    $was_added_to_cart = false;
    $adding_to_cart = wc_get_product($product_id);

    if (!$adding_to_cart) {
      return;
    }

    $add_to_cart_handler = apply_filters("woocommerce_add_to_cart_handler", $adding_to_cart->get_type(), $adding_to_cart);

    if ("variable" === $add_to_cart_handler || "variation" === $add_to_cart_handler) {
      $res = self::add_to_cart_handler_variable($product_id);
      if ($res) {
        $adding_to_cart = wc_get_product(absint(wp_unslash($_POST["variation_id"])));
      }
    } elseif ("grouped" === $add_to_cart_handler) {
      $res = self::add_to_cart_handler_grouped($product_id);
    } elseif (has_action("woocommerce_add_to_cart_handler_" . $add_to_cart_handler)) {
      do_action("woocommerce_add_to_cart_handler_" . $add_to_cart_handler, $url);
    } else {
      $res = self::add_to_cart_handler_simple($adding_to_cart);
    }

    if ($res) {
      $quantity = empty($_POST["quantity"]) ? 1 : wc_stock_amount(wp_unslash($_POST["quantity"]));
      self::add_gifts_to_cart($adding_to_cart, $quantity);
      self::success_added_to_cart($adding_to_cart, $quantity);
    } else {
      self::error_added_to_cart();
    }
  }

  public static function add_product_to_cart($product, $quantity, $cart_item_data = []) {
    $product_id = $product->get_id();
    $passed_validation = true;
    $product_status = get_post_status($product_id);
    $variation_id = 0;
    $variation = [];

    if ($product && "variation" === $product->get_type()) {
      $variation_id = $product_id;
      $product_id = $product->get_parent_id();
      $variation = $product->get_variation_attributes();
    }

    if ($passed_validation && false !== WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation, $cart_item_data) && "publish" === $product_status) {
      return true;
    } else {
      return false;
    }
  }

  private static function prepare_product_cart_item_data($product) {
    if ($product) {
      $gift_products = self::get_gift_products($product);
      return !empty($gift_products) ? ["attached_gifts" => $gift_products] : [];
    }
    return [];
  }

  public static function add_to_cart() {
    if (!isset($_POST["product_id"]) || !is_numeric(wp_unslash($_POST["product_id"]))) {
      return;
    }

    $product_id = absint(wp_unslash($_POST["product_id"]));
    $quantity = empty($_POST["quantity"]) ? 1 : wc_stock_amount(wp_unslash($_POST["quantity"]));
    $product = wc_get_product($product_id);

    $res = self::add_product_to_cart($product, $quantity, self::prepare_product_cart_item_data($product));

    if ($res) {
      do_action("woocommerce_ajax_added_to_cart", $product_id);
      self::add_gifts_to_cart($product, $quantity);
      self::success_added_to_cart($product, $quantity);
    } else {
      self::error_added_to_cart();
    }
  }

  public static function error_added_to_cart() {
    ob_start();
    wc_print_notices();
    $content = ob_get_clean();

    wp_send_json_error([
      "fragments" => [
        "#popup-base .content" => $content,
      ],
    ]);
  }

  private static function update_gifts_in_cart() {
    if (!WC()->cart->is_empty()) {
      $all_gift_ids = [];
      $attached_gift_ids = [];
      $gifts_quantity = [];
      $gift_cart_item_keys = [];

      foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
        if (isset($values["gift"]) && $values["gift"]) {
          $product_id = $values["data"]->get_id();
          $all_gift_ids[] = $product_id;
          $gift_cart_item_keys[$product_id] = $cart_item_key;
        } elseif (isset($values["attached_gifts"]) && is_array($values["attached_gifts"])) {
          $gift_products = $values["attached_gifts"];
          $attached_gift_ids = array_merge(array_column($gift_products, "id"), $attached_gift_ids);
          foreach ($gift_products as $gift_product) {
            $gift_product_id = $gift_product["id"];
            $quantity = $values["quantity"] * $gift_product["quantity"];
            if (isset($gifts_quantity[$gift_product_id])) {
              $gifts_quantity[$gift_product_id] += $quantity;
            } else {
              $gifts_quantity[$gift_product_id] = $quantity;
            }
          }
        }
      }

      // set recalculated quantities for attached gifts (two products can have same gift that's why we must recalculate it like this)
      foreach ($gifts_quantity as $product_id => $gift_quantity) {
        if (isset($gift_cart_item_keys[$product_id])) {
          WC()->cart->set_quantity($gift_cart_item_keys[$product_id], $gift_quantity, false);
        }
      }

      $attached_gift_ids = array_unique($attached_gift_ids);
      $not_attached_gift_ids = array_diff($all_gift_ids, $attached_gift_ids);

      // remove gifts which is not attached to any product (it can happen when user set zero quantity for parent product)
      foreach ($not_attached_gift_ids as $product_id) {
        if (isset($gift_cart_item_keys[$product_id])) {
          WC()->cart->set_quantity($gift_cart_item_keys[$product_id], 0, false);
        }
      }
    }
  }

  private static function remove_gifts_from_cart($cart_item) {
    $gift_products = isset($cart_item["attached_gifts"]) && is_array($cart_item["attached_gifts"]) ? $cart_item["attached_gifts"] : [];
    $gift_product_ids = array_column($gift_products, "id");
    $quantity = $cart_item["quantity"];
    $cart_updated = false;
    if (!WC()->cart->is_empty() && !empty($gift_products)) {
      foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
        if (isset($values["gift"]) && $values["gift"]) {
          $_product = $values["data"];
          $gift_product_index = array_search($_product->get_id(), $gift_product_ids);
          if ($gift_product_index !== false) {
            $gift_product = $gift_products[$gift_product_index];
            WC()->cart->set_quantity($cart_item_key, $values["quantity"] - $quantity * $gift_product["quantity"], false);
            $cart_updated = true;
          }
        }
      }
    }

    if ($cart_updated) {
      WC()->cart->calculate_totals();
    }
  }

  private static function get_gift_products($product) {
    if ($product && "variation" === $product->get_type()) {
      return get_post_meta($product->get_parent_id(), "gift_products", true);
    } else {
      return $product->get_meta("gift_products");
    }
  }

  private static function add_gifts_to_cart($product, $quantity) {
    $gift_products = self::get_gift_products($product);
    if (!empty($gift_products)) {
      foreach ($gift_products as $gift_product) {
        $product = wc_get_product($gift_product["id"]);
        self::add_product_to_cart($product, $quantity * $gift_product["quantity"], ["gift" => true]);
      }
    }
  }

  public static function success_added_to_cart($product, $quantity) {
    $open_minicart = boolval($_POST["open_minicart"]);
    $is_checkout_page = boolval($_POST["is_checkout_page"]);

    $fragments = [];

    if ($open_minicart) {
      $fragments = self::get_cart_checkout_fragments(["cart", "cart_totals", "cart_count_badge"], ["cart" => ["minicart" => true]], true);
    } else {
      if ($is_checkout_page) {
        $fragments = self::get_cart_checkout_fragments(["cart", "cart_totals", "cart_summary", "cart_cross_sell", "checkout", "cart_count_badge"], [], true);
      } else {
        ob_start();
        rc_product_added_content($product);
        $fragments["#popup-base .content"] = ob_get_clean();

        ob_start();
        rc_cart_count(false);
        $fragments[".cart-count-badge"] = ob_get_clean();
      }
    }

    wp_send_json_success([
      "fragments" => $fragments,
      "events" => self::get_events(["add_to_cart"], ["product" => $product, "quantity" => $quantity]),
    ]);
  }

  public static function update_cart() {
    check_ajax_referer("woocommerce-cart", "woocommerce-cart-nonce");

    $cart_updated = false;
    $cart_totals = isset($_POST["cart"]) ? wp_unslash($_POST["cart"]) : "";
    $minicart = isset($_POST["minicart"]) ? boolval($_POST["minicart"]) : "";
    $updated_products = [];

    if (!WC()->cart->is_empty() && is_array($cart_totals)) {
      foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
        $_product = $values["data"];

        if (isset($values["gift"]) && $values["gift"]) {
          continue;
        }

        // Skip product if no updated quantity was posted.
        if (!isset($cart_totals[$cart_item_key]) || !isset($cart_totals[$cart_item_key]["qty"])) {
          continue;
        }

        // Sanitize.
        $quantity = apply_filters("woocommerce_stock_amount_cart_item", wc_stock_amount(preg_replace("/[^0-9\.]/", "", $cart_totals[$cart_item_key]["qty"])), $cart_item_key);

        if ("" === $quantity || $quantity === $values["quantity"]) {
          continue;
        }

        // Update cart validation.
        $passed_validation = apply_filters("woocommerce_update_cart_validation", true, $cart_item_key, $values, $quantity);

        // is_sold_individually.
        if ($_product->is_sold_individually() && $quantity > 1) {
          /* Translators: %s Product title. */
          wc_add_notice(sprintf(__("You can only have 1 %s in your cart.", "woocommerce"), $_product->get_name()), "error");
          $passed_validation = false;
        }

        $updated_products[] = [
          "product" => $_product,
          "quantity" => $quantity - $values["quantity"],
        ];

        if ($passed_validation) {
          WC()->cart->set_quantity($cart_item_key, $quantity, false);
          $cart_updated = true;
        }
      }
    }

    // Trigger action - let 3rd parties update the cart if they need to and update the $cart_updated variable.
    $cart_updated = apply_filters("woocommerce_update_cart_action_cart_updated", $cart_updated);

    if ($cart_updated) {
      self::update_gifts_in_cart();
      WC()->cart->calculate_totals();
    }

    if (WC()->cart->is_empty() && !$minicart) {
      wp_send_json_success([
        "redirect" => !empty($_POST["referrer"]) ? add_query_arg("referrer", $_POST["referrer"], wc_get_checkout_url()) : wc_get_checkout_url(),
        "events" => self::get_events(["update_cart"], ["products" => $updated_products]),
      ]);
    } else {
      wp_send_json_success([
        "fragments" => self::get_cart_checkout_fragments(["cart", "cart_totals", "cart_summary", "checkout", "cart_count_badge"], ["cart" => ["minicart" => $minicart]], true),
        "events" => self::get_events(["update_cart"], ["products" => $updated_products]),
      ]);
    }
  }

  public static function newsletter_request() {
    check_ajax_referer("rootcommerce-newsletter-request", "security");

    $email = isset($_POST["email"]) ? wp_unslash($_POST["email"]) : null;
    $gdpr = isset($_POST["gdpr"]) ? boolval(wp_unslash($_POST["gdpr"])) : false;

    if ($email && $gdpr) {
      $res = rc_mailchimp_subscribe($email);

      switch ($res["response"]["code"]) {
        case 200:
          wp_send_json_success([
            "fragments" => [
              "#popup-base .content" => __("You were successfully subscribed to newsletter.", "rootcommerce"),
            ],
          ]);
          break;
        case 400:
          $body = json_decode($res["body"]);
          if ($body->title == "Member Exists") {
            wp_send_json_success([
              "fragments" => [
                "#popup-base .content" => __("You were already subscribed to newsletter.", "rootcommerce"),
              ],
            ]);
          }
          break;
      }

      wp_send_json_error([
        "fragments" => [
          "#popup-base .content" => __("Something went wrong. Try it later.", "rootcommerce"),
        ],
      ]);
    }

    wp_send_json_error([
      "fragments" => [
        "#popup-base .content" => __("Email is required.", "rootcommerce"),
      ],
    ]);
  }

  public static function validate_cart_items() {
    check_ajax_referer("rootcommerce-validate-cart-items", "security");
    do_action("woocommerce_check_cart_items");
    $errors = wc_notice_count("error") > 0;
    $fragments = self::get_cart_checkout_fragments(["cart"], [], true);
    wc_clear_notices();

    if ($errors) {
      wp_send_json_error([
        "fragments" => $fragments,
      ]);
    } else {
      wp_send_json_success([
        "fragments" => $fragments,
      ]);
    }
  }

  public static function remove_from_cart() {
    check_ajax_referer("woocommerce-cart", "security");

    $minicart = isset($_POST["minicart"]) ? boolval($_POST["minicart"]) : "";
    $cart_item_key = wc_clean(isset($_POST["cart_item_key"]) ? wp_unslash($_POST["cart_item_key"]) : "");
    $cart_item = WC()->cart->get_cart_item($cart_item_key);

    if ($cart_item && !(isset($cart_item["gift"]) && $cart_item["gift"]) && false !== WC()->cart->remove_cart_item($cart_item_key)) {
      $product = wc_get_product($cart_item["product_id"]);
      self::remove_gifts_from_cart($cart_item);

      $item_removed_title = apply_filters(
        "woocommerce_cart_item_removed_title",
        $product ? sprintf(_x("&ldquo;%s&rdquo;", "Item name in quotes", "woocommerce"), $product->get_name()) : __("Item", "woocommerce"),
        $cart_item
      );

      if ($product && $product->is_in_stock() && $product->has_enough_stock($cart_item["quantity"])) {
        $removed_notice = sprintf(__("%s removed.", "woocommerce"), $item_removed_title);
        // $removed_notice .= ' <a href="' . esc_url(wc_get_cart_undo_url($cart_item_key)) . '" class="restore-item">' . __("Undo?", "woocommerce") . "</a>";
      } else {
        $removed_notice = sprintf(__("%s removed.", "woocommerce"), $item_removed_title);
      }

      wc_add_notice($removed_notice, apply_filters("woocommerce_cart_item_removed_notice_type", "success"));

      if (WC()->cart->is_empty() && !$minicart) {
        wp_send_json_success([
          "redirect" => !empty($_POST["referrer"]) ? add_query_arg("referrer", $_POST["referrer"], wc_get_checkout_url()) : wc_get_checkout_url(),
          "events" => self::get_events(["remove_from_cart"], ["product" => $product, "quantity" => $cart_item["quantity"]]),
        ]);
      } else {
        wp_send_json_success([
          "fragments" => self::get_cart_checkout_fragments(["cart", "cart_totals", "cart_summary", "cart_cross_sell", "checkout", "cart_count_badge"], ["cart" => ["minicart" => $minicart]], true),
          "events" => self::get_events(["remove_from_cart"], ["product" => $product, "quantity" => $cart_item["quantity"]]),
        ]);
      }
    } else {
      wp_send_json_error();
    }
  }

  public static function get_checkout_fragments() {
    self::get_cart_checkout_fragments();
  }

  public static function contact_request() {
    check_ajax_referer("rootcommerce-contact-request", "security");

    $email = isset($_POST["email"]) ? wp_unslash($_POST["email"]) : null;
    $phone = isset($_POST["phone"]) ? wp_unslash($_POST["phone"]) : null;
    $name = isset($_POST["name"]) ? wp_unslash($_POST["name"]) : null;
    $vat = isset($_POST["vat"]) ? wp_unslash($_POST["vat"]) : null;
    $message = isset($_POST["message"]) ? wp_unslash($_POST["message"]) : null;

    if ($email && $phone && $name && $message) {
      do_action("rootcommerce_contact_request", [
        "email" => $email,
        "phone" => $phone,
        "name" => $name,
        "vat" => $vat,
        "message" => $message,
      ]);

      wp_send_json_success([
        "fragments" => [
          "#popup-base .content" => __("We have received your message and we will contact you in a few days.", "rootcommerce"),
        ],
      ]);
    }

    wp_send_json_error([
      "fragments" => [
        "#popup-base .content" => __("You have to fill all required fields.", "rootcommerce"),
      ],
    ]);
  }

  public static function search_products() {
    global $wpdb;

    $name = $_POST["name"];
    // Take only simple products and product variations (not variable product)
    $sql = "
      SELECT p.id as value, p.post_title as label
        FROM $wpdb->posts p
        LEFT JOIN $wpdb->term_relationships tr ON (tr.object_id = p.id)
        LEFT JOIN $wpdb->term_taxonomy tt ON(tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = 'product_type')
        LEFT JOIN $wpdb->terms t ON (t.term_id = tt.term_id)
          WHERE ((p.post_type = 'product' AND t.name = 'simple') OR (p.post_type = 'product_variation'))
          AND p.post_status = 'publish'
          AND post_title LIKE %s
            LIMIT 10
    ";
    $query = $wpdb->prepare($sql, "%" . $wpdb->esc_like($name) . "%");
    $products = $wpdb->get_results($query, ARRAY_A);

    wp_send_json_success($products);
  }

  public static function apply_coupon() {
    check_ajax_referer("apply-coupon", "security");

    if (!empty($_POST["coupon_code"])) {
      WC()->cart->add_discount(wc_format_coupon_code(wp_unslash($_POST["coupon_code"])));
    } else {
      wc_add_notice(WC_Coupon::get_generic_coupon_error(WC_Coupon::E_WC_COUPON_PLEASE_ENTER), "error");
    }

    self::get_cart_checkout_fragments(["cart_coupon", "cart_totals"]);
  }

  public static function remove_coupon() {
    check_ajax_referer("remove-coupon", "security");

    $coupon = isset($_POST["coupon"]) ? wc_format_coupon_code(wp_unslash($_POST["coupon"])) : false;

    if (empty($coupon)) {
      wc_add_notice(__("Sorry there was a problem removing this coupon.", "woocommerce"), "error");
    } else {
      WC()->cart->remove_coupon($coupon);
      wc_add_notice(__("Coupon has been removed.", "woocommerce"));
    }

    self::get_cart_checkout_fragments(["cart_totals"]);
  }

  public static function update_totals() {
    self::get_cart_checkout_fragments(["cart_totals"]);
  }

  private static function get_cart_checkout_fragments($trigger_funcs = null, $func_args = [], $return = false) {
    $fragments = [];
    $funcs = [
      "cart_count_badge" => function () use (&$fragments) {
        ob_start();
        rc_cart_count(false);
        $fragments[".cart-count-badge"] = ob_get_clean();
      },
      "cart" => function () use (&$fragments, $func_args) {
        ob_start();
        $args = array_merge(["container" => false], isset($func_args["cart"]) ? $func_args["cart"] : []);
        rc_cart($args);
        $fragments["#cart-wrapper .content"] = ob_get_clean();
      },
      "cart_totals" => function () use (&$fragments) {
        ob_start();
        rc_cart_totals();
        $fragments[".cart-totals-wrp"] = ob_get_clean();
      },
      "cart_summary" => function () use (&$fragments) {
        ob_start();
        rc_cart_summary();
        $fragments[".cart-summary-wrp"] = ob_get_clean();
      },
      "cart_cross_sell" => function () use (&$fragments) {
        ob_start();
        rc_cart_cross_sell();
        $fragments[".cart-cross-sell-wrp"] = ob_get_clean();
      },
      "cart_coupon" => function () use (&$fragments) {
        ob_start();
        rc_cart_coupon();
        $fragments[".cart-coupon-wrp"] = ob_get_clean();
      },
      "checkout" => function () use (&$fragments) {
        ob_start();
        woocommerce_order_review();
        $fragments[".woocommerce-checkout-review-order-table-wrp"] = ob_get_clean();

        ob_start();
        woocommerce_checkout_payment();
        $fragments[".woocommerce-checkout-payment-wrp"] = ob_get_clean();
      },
      "summary" => function () use (&$fragments) {
        ob_start();
        rc_checkout_summary();
        $fragments[".checkout-summary-wrp"] = ob_get_clean();
      },
    ];

    if (!$trigger_funcs) {
      $trigger_funcs = array_keys($funcs);
    }

    WC()->cart->calculate_shipping();
    WC()->cart->calculate_totals();

    foreach ($trigger_funcs as $func_name) {
      $funcs[$func_name]();
    }

    if ($return) {
      return $fragments;
    } else {
      wp_send_json_success([
        "fragments" => $fragments,
      ]);
    }
  }

  public static function update_checkout_customer() {
    check_ajax_referer("rootcommerce-update-checkout-customer-request", "security");
    $full_reload = false;
    $current_locale = get_locale();

    WC()->session->set("chosen_payment_method", empty($_POST["payment_method"]) ? "" : wc_clean(wp_unslash($_POST["payment_method"])));

    $billing_company_enabled = isset($_POST["billing_company_enabled"]) ? wc_clean(wp_unslash($_POST["billing_company_enabled"])) === "true" : false;
    WC()->session->set("billing_company_enabled", $billing_company_enabled);
    WC()->session->set("ship_to_different_address", isset($_POST["ship_to_different_address"]) ? wc_clean(wp_unslash($_POST["ship_to_different_address"])) === "true" : false);

    $billing_vat = isset($_POST["billing_vat"]) ? wc_clean(wp_unslash($_POST["billing_vat"])) : null;
    WC()->session->set("billing_vat", $billing_vat);

    if ($current_locale == "cs_CZ") {
      if ($billing_company_enabled && !empty($billing_vat)) {
        if (!WC()->customer->get_is_vat_exempt()) {
          WC()->customer->set_is_vat_exempt(true);
          $full_reload = true;
        }
      } elseif (WC()->customer->get_is_vat_exempt()) {
        WC()->customer->set_is_vat_exempt(false);
        $full_reload = true;
      }
    }

    WC()->session->set("billing_business_id", isset($_POST["billing_business_id"]) ? wc_clean(wp_unslash($_POST["billing_business_id"])) : null);
    WC()->session->set("billing_tax_id", isset($_POST["billing_tax_id"]) ? wc_clean(wp_unslash($_POST["billing_tax_id"])) : null);

    $order_comments = isset($_POST["order_comments"]) ? wc_clean(wp_unslash($_POST["order_comments"])) : null;
    $additional_fields_enabled = isset($_POST["additional_fields_enabled"]) ? wc_clean(wp_unslash($_POST["additional_fields_enabled"])) === "true" : false;
    WC()->session->set("order_comments", $additional_fields_enabled && !empty($order_comments) ? $order_comments : null);
    WC()->session->set("additional_fields_enabled", $additional_fields_enabled && !empty($order_comments));

    WC()->customer->set_props([
      "billing_first_name" => isset($_POST["billing_first_name"]) ? wc_clean(wp_unslash($_POST["billing_first_name"])) : null,
      "billing_last_name" => isset($_POST["billing_last_name"]) ? wc_clean(wp_unslash($_POST["billing_last_name"])) : null,
      "billing_company" => isset($_POST["billing_company"]) ? wc_clean(wp_unslash($_POST["billing_company"])) : null,
      "billing_phone" => isset($_POST["billing_phone"]) ? wc_clean(wp_unslash($_POST["billing_phone"])) : null,
      "billing_email" => isset($_POST["billing_email"]) ? wc_clean(wp_unslash($_POST["billing_email"])) : null,
      "shipping_first_name" => isset($_POST["shipping_first_name"]) ? wc_clean(wp_unslash($_POST["shipping_first_name"])) : null,
      "shipping_last_name" => isset($_POST["shipping_last_name"]) ? wc_clean(wp_unslash($_POST["shipping_last_name"])) : null,
      "shipping_company" => isset($_POST["shipping_company"]) ? wc_clean(wp_unslash($_POST["shipping_company"])) : null,
    ]);

    if (isset($_POST["zasilkovna_id"]) && $_POST["zasilkovna_id"] !== "default") {
      WC()->session->set("ship_to_packeta_place", true);
      WC()->customer->set_props([
        "shipping_company" => $_POST["zasilkovna_place"],
        "shipping_address_1" => $_POST["zasilkovna_street"],
        "shipping_postcode" => $_POST["zasilkovna_zip"],
        "shipping_city" => $_POST["zasilkovna_city"],
      ]);
    } else {
      WC()->session->set("ship_to_packeta_place", false);
    }

    WC()->customer->save();

    if ($full_reload) {
      self::get_cart_checkout_fragments(["summary", "cart", "cart_totals", "cart_summary", "cart_cross_sell"]);
    } else {
      self::get_cart_checkout_fragments(["summary"]);
    }
  }

  public static function validate_vat() {
    check_ajax_referer("rootcommerce-valid-customer-request", "security");

    $is_valid = true;
    $vat = isset($_POST["billing_vat"]) ? rc_adjust_vat(wc_clean(wp_unslash($_POST["billing_vat"]))) : null;
    $validated_vats = WC()->session->get("validated_vats");
    if (empty($validated_vats)) {
      $validated_vats = [];
    }

    if ($vat) {
      if (!empty($validated_vats) && isset($validated_vats[$vat])) {
        $is_valid = $validated_vats[$vat];
      } else {
        $is_valid = rc_is_vat_valid($vat);
        $validated_vats[$vat] = $is_valid;
        WC()->session->set("validated_vats", $validated_vats);
      }
    }

    if ($is_valid) {
      wp_send_json_success();
    } else {
      wp_send_json_error([
        "code" => "error.invalitVAT",
      ]);
    }
  }

  private static function get_events($trigger_events = [], $func_args = []) {
    $events = ["gtag" => []];
    $funcs = [
      "add_to_cart" => function () use (&$events, $func_args) {
        if (!empty($func_args["product"]) && !empty($func_args["quantity"])) {
          $events["gtag"][] = [
            "name" => "add_to_cart",
            "data" => RC_Google_custom::get_added_product_data($func_args["product"], $func_args["quantity"]),
          ];
        }
      },
      "remove_from_cart" => function () use (&$events, $func_args) {
        if (!empty($func_args["product"]) && !empty($func_args["quantity"])) {
          $events["gtag"][] = [
            "name" => "remove_from_cart",
            "data" => RC_Google_custom::get_removed_product_data($func_args["product"], $func_args["quantity"]),
          ];
        }
      },
      "update_cart" => function () use (&$events, $func_args) {
        if (!empty($func_args["products"])) {
          $gtag_update_data = RC_Google_custom::get_updated_products_data($func_args["products"]);
          if (!empty($gtag_update_data["add_to_cart"])) {
            $events["gtag"][] = [
              "name" => "add_to_cart",
              "data" => $gtag_update_data["add_to_cart"],
            ];
          }
          if (!empty($gtag_update_data["remove_from_cart"])) {
            $events["gtag"][] = [
              "name" => "remove_from_cart",
              "data" => $gtag_update_data["remove_from_cart"],
            ];
          }
        }
      },
    ];

    if (empty($trigger_events)) {
      $trigger_events = array_keys($funcs);
    }

    foreach ($trigger_events as $func_name) {
      $funcs[$func_name]();
    }

    return $events;
  }
}

RC_Ajax_custom::init();