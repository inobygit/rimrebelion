<?php
defined("ABSPATH") || exit();
use Spatie\ArrayToXml\ArrayToXml;

class RC_Google_custom extends RC_Google{
  public static function init() {
    if (defined("ICG_GTM_ID")) {
      add_action("wp_head", [__CLASS__, "init_gtag_script"]);
      add_action("woocommerce_after_single_product", [__CLASS__, "view_content_event"]);
      add_action("woocommerce_after_checkout_form", [__CLASS__, "initiate_checkout_event"]);
      add_action("woocommerce_thankyou", [__CLASS__, "purchase_event"]);
      add_action("rest_api_init", [__CLASS__, "add_rest_routes"]);
    }
  }


  public static function init_gtag_script() {

    self::push_to_datalayer(self::init_ecommerce());
    self::push_to_datalayer(self::get_page_data());
  }

  private static function init_ecommerce() {
    return [
      "ecommerce" => null,
    ];
  }

  private static function get_page_data() {
    return [
      "event" => "page_view",
    ];
  }

  private static function get_product_id($product) {
    if ($product instanceof \WC_Product) {
      return $product->get_id();
    }
    return $product["ID"];
  }

  private static function get_event_product_data($product, $quantity) {
    $data = [
      "id" => self::get_product_id($product),
      "name" => $product->get_name(),
      "price" => wc_get_price_to_display($product),
      "google_business_vertical" => "retail",
    ];

    if($product->get_parent_id()){
      $data["ITEM_GROUP_ID"] = $product->get_parent_id();
    } else {
      $data["ITEM_GROUP_ID"] = self::get_product_id($product);
    }
    //TODO: spravne nastavene, len JS z rootcommerce sa dopytuje na rc-ajax, co nie je toto

    if ($quantity > 0) {
      $data["quantity"] = $quantity;
    }

    return $data;
  }

  private static function get_event_order_item_data($item) {
    $product_id = self::get_product_id($item->get_product());
    $variation = wc_get_product($product_id);

    return [
      "id" => self::get_product_id($item->get_product()),
      "name" => $item->get_name(),
      "price" => round(($item->get_total() + $item->get_total_tax()) / $item->get_quantity(), 2),
      "quantity" => $item->get_quantity(),
      "google_business_vertical" => "retail",
      'ITEM_GROUP_ID' => $variation->get_parent_id() ? $variation->get_parent_id() : null,
    ];
  }

  public static function get_added_product_data($product, $quantity) {
    $product_data = self::get_event_product_data($product, $quantity);
    return [
      "fb_event" => "AddToCart",
      "ga_event" => "addToCart",
      "currencyCode" => get_woocommerce_currency(),
      "ITEM_GROUP_ID" => $product->id,
      "items" => [$product_data],
      "value" => wc_get_price_to_display($product) * $quantity,
      "ecommerce" => [
        "currencyCode" => get_woocommerce_currency(),
        "add" => [
          "products" => [$product_data],
        ],
      ],
    ];
  }

  public static function get_removed_product_data($product, $quantity) {
    $product_data = self::get_event_product_data($product, $quantity);
    return [
      "ga_event" => "removeFromCart",
      "currencyCode" => get_woocommerce_currency(),
      "items" => [$product_data],
      "value" => wc_get_price_to_display($product) * $quantity,
      "ecommerce" => [
        "currencyCode" => get_woocommerce_currency(),
        "remove" => [
          "products" => [$product_data],
        ],
      ],
    ];
  }

  public static function get_updated_products_data($items) {
    $added_products = [];
    $removed_products = [];
    $added_products_value = 0;
    $removed_products_value = 0;
    foreach ($items as $item) {
      $product = $item["product"];
      if ($item["quantity"] > 0) {
        $added_products[] = self::get_event_product_data($product, $item["quantity"]);
        $added_products_value = wc_get_price_to_display($product) * $item["quantity"];
      } elseif ($item["quantity"] < 0) {
        $removed_products[] = self::get_event_product_data($product, abs($item["quantity"]));
        $removed_products_value = wc_get_price_to_display($product) * abs($item["quantity"]);
      }
    }

    $res = [];
    if (!empty($added_products)) {
      $res["add_to_cart"] = [
        "fb_event" => "AddToCart",
        "ga_event" => "addToCart",
        "currencyCode" => get_woocommerce_currency(),
        "items" => $added_products,
        "value" => $added_products_value,
        "ecommerce" => [
          "currencyCode" => get_woocommerce_currency(),
          "add" => [
            "products" => $added_products,
          ],
        ],
      ];
    }

    if (!empty($removed_products)) {
      $res["remove_from_cart"] = [
        "ga_event" => "removeFromCart",
        "currencyCode" => get_woocommerce_currency(),
        "items" => $removed_products,
        "value" => $removed_products_value,
        "ecommerce" => [
          "currencyCode" => get_woocommerce_currency(),
          "remove" => [
            "products" => $removed_products,
          ],
        ],
      ];
    }

    return $res;
  }

  public static function initiate_checkout_event() {
    self::push_to_datalayer(self::get_cart_data());
  }

  public static function view_content_event() {
    self::push_to_datalayer(self::get_product_data());
  }

  public static function get_product_data() {
    global $product;
    if(!$product){
      return;
    }

    $variation = rc_get_product_current_variation($product);
    $product_data = self::get_event_product_data($variation ? $variation : $product, 0);
    return [
      "event" => "view_item",
      "fb_event" => "ViewContent",
      "ga_event" => "viewItem",
      "ITEM_GROUP_ID" => $product->id,
      "value" => wc_get_price_to_display($product),
      "currencyCode" => get_woocommerce_currency(),
      "items" => [$product_data],
      "ecommerce" => [
        "currencyCode" => get_woocommerce_currency(),
        "detail" => [
          "products" => [$product_data],
        ],
      ],
    ];
  }

  public static function purchase_event($order_id) {
    $order = wc_get_order($order_id);

    if (!$order) {
      return;
    }

    self::push_to_datalayer(self::get_order_data($order));
  }

  public static function get_cart_data() {
    $products = [];

    if ($cart = WC()->cart) {
      foreach ($cart->get_cart() as $item) {
        if (!isset($item["data"], $item["quantity"]) || !$item["data"] instanceof \WC_Product) {
          continue;
        }
        $products[] = self::get_event_product_data($item["data"], $item["quantity"]);
      }
    }

    return [
      "event" => "begin_checkout",
      "fb_event" => "InitiateCheckout",
      "ga_event" => "checkout",
      "currencyCode" => get_woocommerce_currency(),
      "items" => $products,
      "value" => WC()->cart ? WC()->cart->total : 0,
      "ecommerce" => [
        "currencyCode" => get_woocommerce_currency(),
        "checkout" => [
          "products" => $products,
        ],
      ],
    ];
  }

  public static function get_order_data($order) {
    $products = [];
    $products_price = 0;

    foreach ($order->get_items() as $item) {
      $product = $item->get_product();

      if ($product) {
        $products[] = self::get_event_order_item_data($item);
      }
    }

    return [
      "event" => "purchase",
      "fb_event" => "Purchase",
      "ga_event" => "purchase",
      "currencyCode" => get_woocommerce_currency(),
      "items" => $products,
      "value" => $order->get_total(),
      "orderId" => $order->get_id(),
      "ecommerce" => [
        "currencyCode" => get_woocommerce_currency(),
        "purchase" => [
          "actionField" => [
            "id" => $order->get_id(),
            "revenue" => $order->get_total(),
          ],
          "products" => $products,
        ],
      ],
    ];
  }

  public static function push_to_datalayer($params, $first = false) {
    rc_enqueue_js(sprintf("((function() { dataLayer.push(%s); })());", json_encode($params)), $first);
  }

  public static function add_rest_routes() {
    register_rest_route("rootcommerce/v1", "google/export_feed", [
      "methods" => "GET",
      "callback" => [__CLASS__, "export_feed"],
      "permission_callback" => "__return_true",
    ]);
  }

  public static function export_feed() {
    global $wpdb;
    $offset = 0;
    $limit = 50;
    $paginating = true;
    $items = [];
    $stock_statuses = ["instock" => "in stock", "outofstock" => "out of stock", "onbackorder" => "available for order"];

    while ($paginating) {
      // prettier-ignore
      $sql = "
        SELECT
          p.*,
          pm1.meta_value as thumbnail_id,
          pm2.meta_value as regular_price,
          pm3.meta_value as sale_price,
          pm4.meta_value as sku,
          pm5.meta_value as stock_status
            FROM $wpdb->posts p
            LEFT JOIN $wpdb->term_relationships tr ON (tr.object_id = p.id)
            LEFT JOIN $wpdb->term_taxonomy tt ON(tt.term_taxonomy_id = tr.term_taxonomy_id AND tt.taxonomy = 'product_type')
            LEFT JOIN $wpdb->terms t ON (t.term_id = tt.term_id)
            LEFT JOIN $wpdb->postmeta pm1 ON (pm1.post_id = p.id AND pm1.meta_key = '_thumbnail_id')
            LEFT JOIN $wpdb->postmeta pm2 ON (pm2.post_id = p.id AND pm2.meta_key = '_regular_price')
            LEFT JOIN $wpdb->postmeta pm3 ON (pm3.post_id = p.id AND pm3.meta_key = '_sale_price')
            LEFT JOIN $wpdb->postmeta pm4 ON (pm4.post_id = p.id AND pm4.meta_key = '_sku')
            LEFT JOIN $wpdb->postmeta pm5 ON (pm5.post_id = p.id AND pm5.meta_key = '_stock_status')
              WHERE ((p.post_type = 'product' AND t.name = 'simple') OR (p.post_type = 'product_variation'))
              AND p.post_status = 'publish'
                LIMIT %d OFFSET %d
      ";
      $query = $wpdb->prepare($sql, $limit, $offset);
      $products = $wpdb->get_results($query, ARRAY_A);
      if (!empty($products)) {
        foreach ($products as $product) {
          $parent_product = !empty($product["post_parent"]) ? wc_get_product($product["post_parent"]) : null;
          $terms = get_the_terms($parent_product ? $parent_product->get_id() : $product["ID"], "product_cat");
          $category = "";
          foreach ($terms as $term) {
            $category = $term->name;
            break;
          }
          $items[] = apply_filters(
            "rootcommerce_google_export_item",
            [
              "g:id" => self::get_product_id($product),
              "g:title" => $product["post_title"],
              "g:description" => wp_strip_all_tags(!empty($parent_product) ? $parent_product->get_description() : $product["post_content"], true),
              "g:link" => get_permalink($product["ID"]),
              "g:image_link" => wp_get_attachment_image_url($product["thumbnail_id"], "full"),
              "g:price" => $product["regular_price"] . " " . get_woocommerce_currency(),
              "g:sale_price" => !empty($product["sale_price"]) ? $product["sale_price"] . " " . get_woocommerce_currency() : null,
              "g:availability" => $stock_statuses[$product["stock_status"]],
              "g:product_type" => $category,
              "g:brand" => "",
              "g:condition" => "new",
              "g:item_group_id" => !empty($product["post_parent"]) ? $product["post_parent"] : null,
            ],
            $product
          );
        }
        $offset += $limit;
      } else {
        $paginating = false;
      }
    }

    $array = [
      "channel" => [
        "title" => get_bloginfo("name"),
        "link" => get_bloginfo("url"),
        "description" => get_bloginfo("description"),
        "item" => $items,
      ],
    ];

    $result = ArrayToXml::convert($array, [
      "rootElementName" => "rss",
      "_attributes" => [
        "xmlns:g" => "http://base.google.com/ns/1.0",
        "version" => "2.0",
      ],
    ]);

    file_put_contents(ROOTCOMMERCE_PLUGIN_DIR . "assets/google-feed.xml", $result);

    echo sprintf(__("XML generated at %s", "rootcommerce"), ROOTCOMMERCE_PLUGIN_URL . "assets/google-feed.xml");
  }
}

RC_Google_custom::init();