<?php
define("RIMREBELLION_CHILD", get_stylesheet_directory());
define("RIMREBELLION_CHILD_URI", get_stylesheet_directory_uri());
require_once RIMREBELLION_CHILD . "/inc/product-taxonomies.php";
require_once RIMREBELLION_CHILD . "/inc/product-tabs.php";
require_once RIMREBELLION_CHILD . "/inc/product-functions.php";
require_once RIMREBELLION_CHILD . "/inc/custom-import-mapper.php";
    
RC()
    ->last_seen_products()
    ->init_ajax();
    
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