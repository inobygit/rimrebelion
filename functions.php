<?php
define("RIMREBELLION_CHILD", get_stylesheet_directory());
define("RIMREBELLION_CHILD_URI", get_stylesheet_directory_uri());
require_once RIMREBELLION_CHILD . "/inc/product-taxonomies.php";
require_once RIMREBELLION_CHILD . "/inc/product-tabs.php";
require_once RIMREBELLION_CHILD . "/inc/product-functions.php";
require_once RIMREBELLION_CHILD . "/inc/custom-import-mapper.php";
require_once RIMREBELLION_CHILD . "/inc/custom-mail-footer.php";
require_once RIMREBELLION_CHILD . "/inc/class-rc-google-custom.php";
require_once RIMREBELLION_CHILD . "/inc/class-rc-ajax-custom.php";
require_once RIMREBELLION_CHILD . "/inc/free-shipping.php";

RC()
    ->last_seen_products()
    ->init_ajax();

    
// To ensure the action is removed, you can try adding the removal in a later hook
add_action('after_setup_theme', 'remove_parent_theme_redirect');


function remove_parent_theme_redirect() {
    remove_action('template_redirect', 'misha_redirect_to_orders_from_dashboard');
}   

function misha_redirect_to_orders_from_dashboard_child(){
    if( is_account_page() && empty( WC()->query->get_current_endpoint() ) && (empty($_GET) || isset($_GET['login']) || isset($_GET['lang']) ) && !isset($_GET['show-reset-form']) ){
      wp_safe_redirect( wc_get_account_endpoint_url( 'orders' ) );
      exit;
    }
    
}

add_action('template_redirect', 'misha_redirect_to_orders_from_dashboard_child');


function modify_rc_vars($rc_vars) {
    $my_default_lang = apply_filters('wpml_default_language', NULL );
    // Add your custom variable to the array
    $rc_vars['rc_default_lang'] = $my_default_lang;  // Replace 'my_value' with the actual value you need

    return $rc_vars;
}

// Add the filter to modify rc_vars
add_filter('rc_vars', 'modify_rc_vars');
 
add_filter( 'icl_job_elements', 'filter_title', 10, 2 );
function filter_title( $fields, $post_id ) {
    foreach ($fields as $field => $value){
        if ($value->field_type == "title") {
            $value->field_translate = 0;
            $value->field_data_translated = $value->field_data;
        }
        if ($value->field_type == "field-color") {
            $value->field_translate = 0;
            $value->field_data_translated = $value->field_data;
        }
    }
    return $fields;
}

add_action("inoby_before_footer", "footer_newsletter");
function footer_newsletter() {
    if (!is_checkout() && !is_cart()) {
        rwmb_meta_render_block("newsletter", [
            "newsletter_popup_check" => 0,
        ]);
    }
}

add_action("wp_enqueue_scripts", "enqueue_my_account_style");
function enqueue_my_account_style() {
    if (is_account_page()) {
        wp_enqueue_style("my_account", get_theme_file_uri("/build/css/my_account.css"));
    }
}

add_action("wp_enqueue_scripts", "enqueue_thank_you_style");
function enqueue_thank_you_style() {
    if (is_checkout() && !empty( is_wc_endpoint_url('order-received') )) {
        wp_enqueue_style("my_account", get_theme_file_uri("/build/css/my_account.css"));
    }
}

if (RC_ENABLED) {
    function rimrebelion_checkout_settings($settings) {
        $settings["wrp_classes"] = "rimrebelion-checkout-wrp container";
        $settings["tabs_classes"] = "tabs-column";
        $settings["step_classes"] = "col-8 col-lg-12 checkout-left-column";
        $settings["totals_classes"] = "col-4 col-lg-12 checkout-right-column";
        $settings["cross_sell_classes"] = "col-12 col-lg-12 cart-cross-sell-wrp";
        return $settings;
    }

    add_filter("rimrebelion_checkout_settings", "rimrebelion_checkout_settings");
}

add_filter("woocommerce_catalog_orderby", "rimrebellion_change_sorting_options_order", 5);
function rimrebellion_change_sorting_options_order($options) {
    $options = [
        "rating" => __("Najlepšie hodnotené", "rimrebellion"),
        "popularity" => __("Najpredávanejšie", "rimrebellion"),
        "price" => __("Najnižšia cena", "rimrebellion"),
        "price-desc" => __("Najvyššia cena", "rimrebellion"),
    ];
    return $options;
}


add_filter( 'woocommerce_output_related_products_args', 'prfx_change_related_products_count' );
function prfx_change_related_products_count( $args ) {

 $args['posts_per_page'] = -1;

 return $args;
}

/**
 * @snippet WooCommerce Disable Default CSS
 */
add_filter("woocommerce_enqueue_styles", "__return_empty_array");

//terms and conditions sidebar
add_action("widgets_init", "my_register_sidebars");
function my_register_sidebars() {
    register_sidebar([
        "id" => "terms",
        "name" => __("Sidebar - Terms and conditions"),
        "description" => __("Sidebar used in terms and conditions page."),
        "before_widget" => '<div id="%1$s" class="widget %2$s">',
        "after_widget" => "</div>",
        "before_title" => '<h3 class="widget-title">',
        "after_title" => "</h3>",
    ]);
}

function rimrebelion_contact_info_shortcode($atts) {
    $atts = shortcode_atts(
        [
            "email" => "",
            "phone" => "",
        ],
        $atts,
        "rimrebelion_contact_info",
    );
    $contact_info = "";
    if (!empty($atts["email"])) {
        $contact_info .=
            '<a class="email-btn" href="mailto:' .
            esc_attr($atts["email"]) .
            '">' .
            file_get_contents(get_stylesheet_directory_uri() . "/assets/svg/mail.svg") .
            esc_html($atts["email"]) .
            "</a>";
    }
    if (!empty($atts["phone"])) {
        $contact_info .=
            '<a class="phone-btn" href="tel:' .
            esc_attr($atts["phone"]) .
            '">' .
            file_get_contents(get_stylesheet_directory_uri() . "/assets/svg/phone-call.svg") .
            esc_html($atts["phone"]) .
            "</a>";
    }

    return '<div class="contact-info">' . $contact_info . "</div>";
}
add_shortcode("rimrebelion_contact_info", "rimrebelion_contact_info_shortcode");

add_action("woocommerce_after_shipping_rate", "inoby_add_info_to_local_shipping_rate");

/**
 * Adds desciption to local pickup shipping method
 */
function inoby_add_info_to_local_shipping_rate(WC_Shipping_Rate $method) {
  if (str_starts_with($method->get_id(), "local_pickup")) {
    printf("<span class='description'>%s</span>", __("RimRebellion HQ<br/>  Námestie Mateja Korvína 2<br/> 811 07 Bratislava<br/> 10:00 - 16:00", "inoby"));
  }
}


function posts_load_more_scripts_child() {
  global $wp_query;
  // register our main script but do not enqueue it yet
  wp_register_script(
    "posts_loadmore_child",
    get_stylesheet_directory_uri() . "/assets/js/postsloadmore.js",
    ["jquery"],
  );
  // we have to pass parameters to postsloadmore.js script but we can get the parameters values only in PHP
  // you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
  wp_localize_script("posts_loadmore_child", "posts_loadmore_child_params", [
    "ajaxurl" => site_url() . "/wp-admin/admin-ajax.php", // WordPress AJAX
    "posts" => json_encode($wp_query->query_vars), // everything about your loop is here
    "current_page" => get_query_var("paged") ? get_query_var("paged") : 1,
    "max_page" => $wp_query->max_num_pages,
  ]);
  wp_enqueue_script("posts_loadmore_child");
}
add_action("wp_enqueue_scripts", "posts_load_more_scripts_child");


function posts_loadmore_ajax_handler_child() {
  // prepare our arguments for the query
  $args = json_decode(stripslashes($_POST["query"]), true);
  $cardTemplate = $_POST["card_template"] ?? "" ?: "post-types/post/parts/card";
  $cardClasses = $_POST["card_classes"] ?? "" ?: "col-3 col-md-6 col-sm-12";
  $looksGender = $_POST["looks_gender"] ?? "";
  if (Inoby_Config::latest_posts() > 0) {
    $current_page = max(1, $_POST["page"] + 1);
    $per_page = get_option("posts_per_page");
    $offset_start = Inoby_Config::latest_posts();
    $offset = ($current_page - 1) * $per_page + $offset_start;

    $args["paged"] = $_POST["page"] + 1; // we need next page to be loaded
    $args["offset"] = $offset; // we need next page to be loaded
  } else {
    $args["paged"] = $_POST["page"] + 1; // we need next page to be loaded
  }
  $args["post_status"] = "publish";
  // it is always better to use WP_Query but not here
  if(!empty($looksGender)){
        $args['tax_query'] = [
            [
                'taxonomy' => 'look-gender',
                'field'    => 'term_id',
                'terms'    => $looksGender,
            ],
        ];
    }
  query_posts($args);
  if (have_posts()):
    // run the loop
    while (have_posts()):
      the_post();
      global $post;
      echo apply_filters(
        "inoby_post_list_card_before",
        "<div class=\"$cardClasses\">",
      );
      get_template_part($cardTemplate, null, ["post" => $post]);
      echo apply_filters("inoby_post_list_card_after", "</div>");
    endwhile;
  endif;
  die(); // here we exit the script and even no wp_reset_query() required!
}
add_action("wp_ajax_loadmore_child", "posts_loadmore_ajax_handler_child"); // wp_ajax_{action}
add_action("wp_ajax_nopriv_loadmore_child", "posts_loadmore_ajax_handler_child"); // wp_ajax_nopriv_{action}

// Dequeue and deregister the script 'xoo-el-js'
wp_dequeue_script('xoo-el-js');
wp_deregister_script('xoo-el-js');

// Register and enqueue a new script from 'assets/js'
wp_register_script('xoo-el-js', get_stylesheet_directory_uri() . '/assets/js/xoo-el-js.js', array(), '1.0.2', true);
wp_enqueue_script('xoo-el-js');

function rebellion_add_to_cart_btn($atts = [], $prod = null) {
  global $product;

  if (!$product) {
    if($prod){
        $product = $prod;
    } else {
        return;
    }
  }

  $data = [
      "data-quantity" => 1,
      "data-product_id" => $product->get_id(),
    ];
  if (isset($atts["data"])) {
    $data = array_merge($data, $atts["data"]);
    unset($atts["data"]);
  }

  $class = "add-to-cart-single-btn";
  if (isset($atts["class"])) {
    $class .= " " . $atts["class"];
    unset($atts["class"]);
  }

  $args = array_merge(
    [
      "text" => __("Add to card", "rootcommerce"),
      "type" => "primary",
      "class" => $class,
      "data" => $data,
    ],
    $atts
  );

  rc_get_template("eshop/add-to-cart.php", $args);
}

/**
*  Add Custom Icon 
*/ 

function custom_gateway_icon( $icon, $id ) {
    if ( $id === 'cod' ) {
        return '<img loading="lazy" src="' . get_stylesheet_directory_uri() . '/assets/icons/cod.svg" > '; 
    } else {
        return $icon;
    }
}
add_filter( 'woocommerce_gateway_icon', 'custom_gateway_icon', 10, 2 );




add_filter("inoby_theme_settings_tabs", function ($tabs) {

    $tabs["delivery-info"] = [
        "label" => "Woocommerce - Custom nastavenia",
        "icon" => "dashicons-category",
        "sort" => 20,
    ];

    return $tabs;


});

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "id" => "mb-my-delivery-info",
        "title" => __("Nastavenie delivery info", "inoby"),
        "settings_pages" => "options",
        "context" => "normal",
        "tab" => "delivery-info",
        "fields" => [
            [
              'id' => "delivery_info_text",
              'name'  => __("Delivery info text", 'inoby'),
              'type'  => 'wysiwyg',
              'raw' => true,
              'sanitize_callback' => 'none',
            ],
        ],
    ];

    // $meta_boxes[] = [
    //     "id" => "mb-shop-banners",
    //     "title" => __("Nastavenie bannerov na stránke obchodu", "inoby"),
    //     "settings_pages" => "options",
    //     "context" => "normal",
    //     "tab" => "delivery-info",
    //     "fields" => [
    //       [
    //         'type'  => 'heading',
    //         'name'  => __("Nastavenie bannerov na stránke obchodu", "inoby"),
    //       ],
    //   [
    //     'group_title'   => __('CTA sekcia - {headline}', 'inoby'),
    //     'id'            => 'archive-banner-boxes',
    //     'type'          => 'group',
    //     'clone'         => true,
    //     'collapsible'   => true,
    //     'sort_clone'    => true,
    //     'max_clone'     => 2,
    //     'translate' => true,
    //     'add_button'    => __('Pridať ďalšiu sekciu', 'inoby'),
    //     'fields' => array(
    //       [
    //         'id'  => 'style-2',
    //         'name'  => __("Štýl 2", 'inoby'),
    //         'type'  => 'checkbox',
    //         'std' => 0,
    //         'translate' => true,
    //       ],
    //       [
    //         'id'  => 'illustration-color',
    //         'name'  => __('Farba ilustrácie', 'inoby'),
    //         'type'  => 'color',
    //     'translate' => true,
    //       ],
    //       [
    //     'translate' => true,
    //         'id'               => "bg",
    //         'name'             => __('Pozadie', 'inoby'),
    //         'type'             => 'image_advanced',
    //         'force_delete'     => false,
    //         'max_file_uploads' => 1,
    //         'max_status'       => false,
    //         'image_size'       => 'thumbnail',
    //       ],
    //       [
    //     'translate' => true,
    //         'id'       => 'headline',
    //         'title'    => __('Nadpis', 'inoby'),
    //         'placeholder'   => __('Vložte nadpis', 'inoby'),
    //         'type'     => 'wysiwyg',
    //         'sanitize_callback' => 'none',
    //         'raw' => true,
    //         "translate" => true,
    //       ],
    //       [
    //     'translate' => true,
    //         'id'       => 'text',
    //         'title'    => __('Text', 'inoby'),
    //         'placeholder'   => __('Vložte text', 'inoby'),
    //         'type'     => 'text',
    //         'sanitize_callback' => 'none',
    //       ],
    //       [
    //     'translate' => true,
    //         'id'       => 'url',
    //         'title'    => __('Odkaz', 'inoby'),
    //         'placeholder'   => __('Vložte odkaz', 'inoby'),
    //         'type'     => 'text',
    //       ],
    //     )
    //   ],
    //     ],
    // ];

    return $meta_boxes;
});