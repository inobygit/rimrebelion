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

function remove_parent_theme_redirect()
{
    remove_action('template_redirect', 'misha_redirect_to_orders_from_dashboard');
}

function misha_redirect_to_orders_from_dashboard_child()
{
    if (is_account_page() && empty(WC()->query->get_current_endpoint()) && (empty($_GET) || isset($_GET['login']) || isset($_GET['lang'])) && ! isset($_GET['show-reset-form'])) {
        wp_safe_redirect(wc_get_account_endpoint_url('orders'));
        exit;
    }

}

add_action('template_redirect', 'misha_redirect_to_orders_from_dashboard_child');

function modify_rc_vars($rc_vars)
{
    $my_default_lang = apply_filters('wpml_default_language', null);
                                                    // Add your custom variable to the array
    $rc_vars['rc_default_lang'] = $my_default_lang; // Replace 'my_value' with the actual value you need

    return $rc_vars;
}

// Add the filter to modify rc_vars
add_filter('rc_vars', 'modify_rc_vars');

add_filter('icl_job_elements', 'filter_title', 10, 2);
function filter_title($fields, $post_id)
{
    foreach ($fields as $field => $value) {
        if ($value->field_type == "title") {
            $value->field_translate       = 0;
            $value->field_data_translated = $value->field_data;
        }
        if ($value->field_type == "field-color") {
            $value->field_translate       = 0;
            $value->field_data_translated = $value->field_data;
        }
    }
    return $fields;
}

add_action("inoby_before_footer", "footer_newsletter");
function footer_newsletter()
{
    if (! is_checkout() && ! is_cart()) {
        rwmb_meta_render_block("newsletter", [
            "newsletter_popup_check" => 0,
        ]);
    }
}

add_action("wp_enqueue_scripts", "enqueue_my_account_style");
function enqueue_my_account_style()
{
    if (is_account_page()) {
        wp_enqueue_style("my_account", get_theme_file_uri("/build/css/my_account.css"));
    }
}

add_action("wp_enqueue_scripts", "enqueue_thank_you_style");
function enqueue_thank_you_style()
{
    if (is_checkout() && ! empty(is_wc_endpoint_url('order-received'))) {
        wp_enqueue_style("my_account", get_theme_file_uri("/build/css/my_account.css"));
    }
}

if (RC_ENABLED) {
    function rimrebelion_checkout_settings($settings)
    {
        $settings["wrp_classes"]        = "rimrebelion-checkout-wrp container";
        $settings["tabs_classes"]       = "tabs-column";
        $settings["step_classes"]       = "col-8 col-lg-12 checkout-left-column";
        $settings["totals_classes"]     = "col-4 col-lg-12 checkout-right-column";
        $settings["cross_sell_classes"] = "col-12 col-lg-12 cart-cross-sell-wrp";
        return $settings;
    }

    add_filter("rimrebelion_checkout_settings", "rimrebelion_checkout_settings");
}

add_filter("woocommerce_catalog_orderby", "rimrebellion_change_sorting_options_order", 5);
function rimrebellion_change_sorting_options_order($options)
{
    $options = [
        // "season" => __("Sezóna", "rimrebellion"),
        "rating"     => __("Najlepšie hodnotené", "rimrebellion"),
        "popularity" => __("Najpredávanejšie", "rimrebellion"),
        "price"      => __("Najnižšia cena", "rimrebellion"),
        "price-desc" => __("Najvyššia cena", "rimrebellion"),
    ];
    return $options;
}

add_filter('woocommerce_output_related_products_args', 'prfx_change_related_products_count');
function prfx_change_related_products_count($args)
{

    $args['posts_per_page'] = -1;

    return $args;
}

/**
 * @snippet WooCommerce Disable Default CSS
 */
add_filter("woocommerce_enqueue_styles", "__return_empty_array");

//terms and conditions sidebar
add_action("widgets_init", "my_register_sidebars");
function my_register_sidebars()
{
    register_sidebar([
        "id"            => "terms",
        "name"          => __("Sidebar - Terms and conditions"),
        "description"   => __("Sidebar used in terms and conditions page."),
        "before_widget" => '<div id="%1$s" class="widget %2$s">',
        "after_widget"  => "</div>",
        "before_title"  => '<h3 class="widget-title">',
        "after_title"   => "</h3>",
    ]);
}

function rimrebelion_contact_info_shortcode($atts)
{
    $atts = shortcode_atts(
        [
            "email" => "",
            "phone" => "",
        ],
        $atts,
        "rimrebelion_contact_info",
    );
    $contact_info = "";
    if (! empty($atts["email"])) {
        $contact_info .=
        '<a class="email-btn" href="mailto:' .
        esc_attr($atts["email"]) .
        '">' .
        file_get_contents(get_stylesheet_directory_uri() . "/assets/svg/mail.svg") .
        esc_html($atts["email"]) .
            "</a>";
    }
    if (! empty($atts["phone"])) {
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
function inoby_add_info_to_local_shipping_rate(WC_Shipping_Rate $method)
{
    if (str_starts_with($method->get_id(), "local_pickup")) {
        printf("<span class='description'>%s</span>", __("RimRebellion Store <br/>Košická 27 (ZWIRN)<br/>821 09 Bratislava<br/>Str - Pia 14:00 - 19:00<br/>So 10:00 - 16:00", "inoby"));
    }
}

function posts_load_more_scripts_child()
{
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
        "ajaxurl"      => site_url() . "/wp-admin/admin-ajax.php", // WordPress AJAX
        "posts"        => json_encode($wp_query->query_vars),      // everything about your loop is here
        "current_page" => get_query_var("paged") ? get_query_var("paged") : 1,
        "max_page"     => $wp_query->max_num_pages,
    ]);
    wp_enqueue_script("posts_loadmore_child");
}
add_action("wp_enqueue_scripts", "posts_load_more_scripts_child");

function posts_loadmore_ajax_handler_child()
{
    // prepare our arguments for the query
    $args         = json_decode(stripslashes($_POST["query"]), true);
    $cardTemplate = $_POST["card_template"] ?? "" ?: "post-types/post/parts/card";
    $cardClasses  = $_POST["card_classes"] ?? "" ?: "col-3 col-md-6 col-sm-12";
    $looksGender  = $_POST["looks_gender"] ?? "";
    if (Inoby_Config::latest_posts() > 0) {
        $current_page = max(1, $_POST["page"] + 1);
        $per_page     = get_option("posts_per_page");
        $offset_start = Inoby_Config::latest_posts();
        $offset       = ($current_page - 1) * $per_page + $offset_start;

        $args["paged"]  = $_POST["page"] + 1; // we need next page to be loaded
        $args["offset"] = $offset;            // we need next page to be loaded
    } else {
        $args["paged"] = $_POST["page"] + 1; // we need next page to be loaded
    }
    $args["post_status"] = "publish";
    // it is always better to use WP_Query but not here
    if (! empty($looksGender)) {
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
add_action("wp_ajax_loadmore_child", "posts_loadmore_ajax_handler_child");        // wp_ajax_{action}
add_action("wp_ajax_nopriv_loadmore_child", "posts_loadmore_ajax_handler_child"); // wp_ajax_nopriv_{action}

// Dequeue and deregister the script 'xoo-el-js'
wp_dequeue_script('xoo-el-js');
wp_deregister_script('xoo-el-js');

// Register and enqueue a new script from 'assets/js'
wp_register_script('xoo-el-js', get_stylesheet_directory_uri() . '/assets/js/xoo-el-js.js', [], '1.0.2', true);
wp_enqueue_script('xoo-el-js');

function rebellion_add_to_cart_btn($atts = [], $prod = null)
{
    global $product;

    if (! $product) {
        if ($prod) {
            $product = $prod;
        } else {
            return;
        }
    }

    $data = [
        "data-quantity"   => 1,
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
            "text"  => __("Add to card", "rootcommerce"),
            "type"  => "primary",
            "class" => $class,
            "data"  => $data,
        ],
        $atts
    );

    rc_get_template("eshop/add-to-cart.php", $args);
}

/**
 *  Add Custom Icon
 */

function custom_gateway_icon($icon, $id)
{
    if ($id === 'cod') {
        return '<img loading="lazy" src="' . get_stylesheet_directory_uri() . '/assets/icons/cod.svg" > ';
    } else {
        return $icon;
    }
}
add_filter('woocommerce_gateway_icon', 'custom_gateway_icon', 10, 2);

add_filter("inoby_theme_settings_tabs", function ($tabs) {

    $tabs["delivery-info"] = [
        "label" => "Woocommerce - Custom nastavenia",
        "icon"  => "dashicons-category",
        "sort"  => 20,
    ];

    return $tabs;

});

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "id"             => "mb-my-delivery-info",
        "title"          => __("Nastavenie delivery info", "inoby"),
        "settings_pages" => "options",
        "context"        => "normal",
        "tab"            => "delivery-info",
        "fields"         => [
            // [
            //     'id'   => 'sortinig_season',
            //     'name' => __("Sorting season", 'inoby'),
            //     'type' => 'taxonomy_advanced',
            //     'field_type'    => 'select_advanced',
            //     'taxonomy'  => 'season',
            // ],
            // [
            //     'name' => __("Rimrebellion delivery info", 'inoby'),
            //     'type' => 'heading',
            // ],
            [
                'id'                => "delivery_info_text",
                'name'              => __("Delivery info text", 'inoby'),
                'type'              => 'wysiwyg',
                'raw'               => true,
                'sanitize_callback' => 'none',
            ],
            [
                'name' => __("Rimrebellion social club", 'inoby'),
                'type' => 'heading',
            ],
            [
                'id'   => 'club_popup_show',
                'name' => __("Show popup", 'inoby'),
                'type' => 'checkbox',
                'std'  => 0,
            ],
            [
                'id'               => "club_popup_image",
                'name'             => __("Club popup image - left", 'inoby'),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
            ],
            [
                'id'               => "club_popup_logo",
                'name'             => __("Club popup logo", 'inoby'),
                'type'             => 'image_advanced',
                'max_file_uploads' => 1,
            ],
            [
                'id'    => "club_popup_benefits",
                'name'  => __("Club popup benefits", 'inoby'),
                'type'  => 'text',
                'clone' => true,
            ],
            [
                'type' => 'divider',
            ],
            [
                'id'   => "club_popup_heading_last",
                'name' => __("Club popup - Nadpis nad kupónom", 'inoby'),
                'type' => 'text',
            ],
            [
                'id'   => "club_popup_desc_last",
                'name' => __("Club popup - Popis nad kupónom", 'inoby'),
                'type' => 'textarea',
            ],
            [
                'id'   => "club_popup_coupon",
                'name' => __("Club popup - Kód kupónu", 'inoby'),
                'type' => 'text',
            ],
        ],
    ];

    return $meta_boxes;
});

add_filter('xoo_el_registration_redirect', function ($redirect, $user) {
    // Check if the request is from the popup
    if (isset($_POST['source']) && $_POST['source'] === 'popup') {
        return false; // Prevent redirect for popup registration
    }
    return $redirect; // Allow normal redirect for other cases
}, 99, 2);

add_filter('wpseo_breadcrumb_single_link', 'remove_shop', 10, 2);
function remove_shop($link_output, $link)
{
    if ($link['text'] == __('Obchod', 'inoby')) {
        $link_output = "";
    }
    return $link_output;
}

add_action('xoo_el_form_end', function($form, $args) {
    $current_lang = apply_filters( 'wpml_current_language', NULL );
    if($form === 'register' ){
		?>
		<input type="hidden" name="merge_fields[LOCALITY]" value="<?= $current_lang ?>">
		<?php
	}

}, 10, 2);


// /**
//  * Modify product query based on season sorting
//  */
// function modify_product_query_by_season($query) {
//     if (!is_admin() && $query->is_main_query()) {
//         $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : '';
//         $sorting_season = rwmb_meta('sortinig_season', ["object_type" => "setting"], 'options');
        
//         if(!empty($sorting_season)){
//             if (strpos($orderby, 'season') === 0 || empty($orderby)) {
//                 $season_id = str_replace('season', '', $sorting_season->term_id);
                
//                 // Get the current sorting method from the URL or default to menu_order
//                 $current_order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'ASC';
    
//                 $product_visibility_terms = wc_get_product_visibility_term_ids();
//                 $product_visibility_not_in[] = $product_visibility_terms["exclude-from-catalog"];
//                 if (get_option("woocommerce_hide_out_of_stock_items", "no") == "yes") {
//                     $product_visibility_not_in[] = $product_visibility_terms["outofstock"];
//                 }

//                 // Base tax query for visibility
//                 $tax_query = [
//                     [
//                         "taxonomy" => "product_visibility",
//                         "field"    => "term_taxonomy_id",
//                         "terms"    => $product_visibility_not_in,
//                         "operator" => "NOT IN",
//                     ]
//                 ];

//                 // Add custom ordering using posts_clauses filter
//                 add_filter('posts_clauses', function($clauses) use ($season_id) {
//                     global $wpdb;
                    
//                     // Add a subquery to check if the post has the season term
//                     $clauses['join'] .= " LEFT JOIN (
//                         SELECT object_id, COUNT(*) as has_season
//                         FROM {$wpdb->term_relationships} tr
//                         INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
//                         WHERE tt.taxonomy = 'season' AND tt.term_id = {$season_id}
//                         GROUP BY object_id
//                     ) season_check ON {$wpdb->posts}.ID = season_check.object_id";
                    
//                     // Add the season check to the ORDER BY clause
//                     $clauses['orderby'] = "COALESCE(season_check.has_season, 0) DESC, " . $clauses['orderby'];
                    
//                     return $clauses;
//                 });
                
//                 $query->set('tax_query', $tax_query);
//                 $query->set('orderby', $orderby);
//                 $query->set('order', $current_order);
//             }
//         }
//     }
// }
// add_action('pre_get_posts', 'modify_product_query_by_season');

// // Add a function to set season priority when products are saved
// function set_season_priority($post_id) {
//     if (get_post_type($post_id) !== 'product') {
//         return;
//     }

//     $sorting_season = rwmb_meta('sortinig_season', ["object_type" => "setting"], 'options');
//     if (!empty($sorting_season)) {
//         $season_id = str_replace('season', '', $sorting_season->term_id);
        
//         // Check if product has the current season
//         $terms = wp_get_post_terms($post_id, 'season', ['fields' => 'ids']);
//         if (in_array($season_id, $terms)) {
//             update_post_meta($post_id, '_season_priority', 1);
//         } else {
//             update_post_meta($post_id, '_season_priority', 0);
//         }
//     }
// }
// add_action('save_post', 'set_season_priority');