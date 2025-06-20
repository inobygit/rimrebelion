<?php

function get_gallery_image_html($post_thumbnail_id, $image_size, $attrs, $loading = 'lazy')
{
    $thumbnail_size = apply_filters("inoby_gallery_thumbnail_size", "thumbnail");
    $full_size = apply_filters("inoby_gallery_full_size", "o-12");
    $thumbnail_src = wp_get_attachment_image_src($post_thumbnail_id, $thumbnail_size);
    $full_src = wp_get_attachment_image_src($post_thumbnail_id, $full_size);
    $alt_text = trim(wp_strip_all_tags(get_post_meta($post_thumbnail_id, "_wp_attachment_image_alt", true)));
    $image = wp_get_attachment_image(
        $post_thumbnail_id,
        $image_size,
        false,
        apply_filters(
            "inoby_gallery_image_html_attachment_image_params",
            [
                "title" => _wp_specialchars(get_post_field("post_title", $post_thumbnail_id), ENT_QUOTES, "UTF-8", true),
                "data-caption" => _wp_specialchars(get_post_field("post_excerpt", $post_thumbnail_id), ENT_QUOTES, "UTF-8", true),
                "data-src" => esc_url($full_src[0]),
                "data-large_image" => esc_url($full_src[0]),
                "data-large_image_width" => esc_attr($full_src[1]),
                "data-large_image_height" => esc_attr($full_src[2]),
                'loading' => $loading,
            ],
            $post_thumbnail_id,
            $image_size,
            false
        )
    );

    $default_attrs = [
        "class" => "woocommerce-product-gallery__image post-img",
        "data-thumb" => esc_url($thumbnail_src[0]),
        "data-thumb-alt" => esc_attr($alt_text),
    ];

    $attrs = wp_parse_args($attrs, $default_attrs);

    return '<div ' . array_to_html_attrs($attrs) . '><a href="' . esc_url($full_src[0]) . '">' . $image . '</a></div>';
}

function custom_more_title($title)
{
    $more_text = esc_html(__('Show more ', 'rimrebellion'));
    return $more_text;
}
add_filter('woocommerce_product_search_field_more_title', 'custom_more_title');

function display_related_product_thumbnails($product_id = null)
{
    if ($product_id) {
        $current_product_id = $product_id;
    } else {
        $current_product_id = get_the_ID();
    }
    $current_style_number = rwmb_meta("style-number", "", $current_product_id);
    $related_products_args = [
        "post_type" => "product",
        "posts_per_page" => -1,
        "meta_query" => [
            [
                "key" => "style-number",
                "value" => $current_style_number,
                "compare" => "=",
            ],
        ],
    ];
    $related_products_query = new WP_Query($related_products_args);

    if ($related_products_query->have_posts()) {
        echo '<div class="related-products-thumbnails">';
        while ($related_products_query->have_posts()) {
            $related_products_query->the_post();
            echo '<div class="related-product-thumbnail';
            if (get_the_ID() === $current_product_id) {
                echo " current-selected";
            }
            echo '">';
            $gallery_images = get_post_meta(get_the_ID(), '_product_image_gallery', true);
            if ($gallery_images) {
                $gallery_images = explode(',', $gallery_images);
                $first_image_id = $gallery_images[0];
                echo '<a href="' . get_permalink() . '">' . wp_get_attachment_image($first_image_id, 'o-2', false, ['loading'   => 'lazy']) . "</a>";
            } else {
                echo '<a href="' . get_permalink() . '"><img loading="lazy" src="' . wc_placeholder_img_src() . '" alt="Placeholder" /></a>';
            }
            echo "</div>";
        }
        echo "</div>";
        wp_reset_postdata();
    }
}

add_filter("rwmb_meta_boxes", function ($meta_boxes) {
    $meta_boxes[] = [
        "taxonomies" => "color",
        "title" => __("Výber farby", "rimrebellion"),
        "fields" => [
            [
                "name" => __("Zvolte farbu", "rimrebellion"),
                "id" => "rc_attribute_term_color",
                "type" => "color",
            ],
        ],
    ];
    return $meta_boxes;
});


add_filter('woocommerce_available_variation', function ($available_variations, \WC_Product_Variable $variable, \WC_Product_Variation $variation) {
    if (empty($available_variations['price_html'])) {
        $available_variations['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }

    return $available_variations;
}, 10, 3);

add_filter('woocommerce_dropdown_variation_attribute_options_args', 'dropdown_variation_attribute_options', 10, 1);
function dropdown_variation_attribute_options($args)
{

    $args['show_option_none'] = __('Select size', 'rimrebellion');

    return $args;
}

function custom_availability($availability, $product)
{
    if ($availability['class'] == 'in-stock') {
        $availability['availability'] = __('In Stock', 'rimrebellion');
    } elseif ($availability['class'] == 'outofstock') {
        $availability['availability'] = __("Out of stock", 'rimrebellion');
    }

    return $availability;
}
add_filter('woocommerce_get_availability', 'custom_availability', 10, 2);

add_filter('woocommerce_dropdown_variation_attribute_options_html', 'rudr_radio_variations', 20, 2);
function rudr_radio_variations($html, $args)
{

    // in wc_dropdown_variation_attribute_options() they also extract all the array elements into variables
    $options   = $args['options'];
    $product   = $args['product'];
    $attribute = $args['attribute'];
    $name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title($attribute);
    $id        = $args['id'] ? $args['id'] : sanitize_title($attribute);
    $class     = $args['class'];

    if (empty($options) || ! $product) {
        return $html;
    }

    // Generate unique id for the element .rudr-variation-radios using uid
    $uid = uniqid('rudr-');
    // HTML for our radio buttons
    $radios = '<div class="rudr-variation-radios" id=' . $uid . '>';

    // taxonomy-based attributes
    if (taxonomy_exists($attribute)) {

        $terms = wc_get_product_terms(
            $product->get_id(),
            $attribute,
            array(
                'fields' => 'all',
            )
        );

        foreach ($terms as $term) {
            $class = '';
            foreach ($product->get_available_variations() as $variation) {
                if (str_contains($variation['availability_html'], 'onbackorder') && in_array($term->slug, $variation['attributes'], true)) {
                    $class = 'onbackorder'; // Add class if on backorder
                }
                if (str_contains($variation['availability_html'], 'outofstock') && in_array($term->slug, $variation['attributes'], true)) {
                    $class = 'outofstock'; // Add class if on backorder
                }
                if (in_array($term->slug, $variation['attributes'], true)) {
                    $class .= ' enabled ';
                }
            }
            if (in_array($term->slug, $options, true)) {
                $radios .= "<label class=\"{$class}\" for=\"{$name}-{$term->slug}-{$uid}\"><input type=\"radio\" id=\"{$name}-{$term->slug}-{$uid}\" name=\"{$name}\" value=\"{$term->slug}\"" . checked($args['selected'], $term->slug, false) . ">{$term->name}</label>";
            }
        }
        // individual product attributes
    } else {
        foreach ($options as $option) {
            $checked = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
            $radios .= "<label for=\"{$name}-{$option}-{$uid}\"><input type=\"radio\" id=\"{$name}-{$option}-{$uid}\" name=\"{$name}\" value=\"{$option}\" id=\"{$option}\" {$checked}>{$option}</label>";
        }
    }

    $radios .= '</div>';

    return $html . $radios;
}


add_action('views_edit-product', 'add_custom_button_to_product_admin');
function add_custom_button_to_product_admin($views)
{
?>
    <button type="button" class="button" id="assign_products_btn_reload"
        style="margin-left: 1rem; background-color: #667fee; color: white;"><?php esc_html_e('Activate backorder on products', 'inoby'); ?></button>
    <button type="button" class="button" id="products_btn_reload"
        style="margin-left: 1rem; background-color: #667fee; color: white;"><?php esc_html_e('Reload products', 'inoby'); ?></button>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function processBatchReload(offset) {
                $('#assign_products_btn_reload').text('Processing...');
                var data = {
                    'action': 'reload_products',
                    'nonce': '<?php echo wp_create_nonce('reload_products_nonce'); ?>',
                    'offset': offset
                };
                $.post(ajaxurl, data, function(response) {
                    if (response.data.continue) {
                        processBatchReload(response.data.offset);
                        $('#assign_products_btn_reload')
                            .text(response.data.offset + ' / ' + response.data.total);
                    } else {
                        $('#assign_products_btn_reload').text('Done ;)');
                        alert('All products have been processed.');
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to process: ' + textStatus + ' - ' + errorThrown);
                });
            }

            $('#assign_products_btn_reload').on('click', function() {
                processBatchReload(0);
            });
        });

        jQuery(document).ready(function($) {
            function processBatchReload(offset) {
                $('#products_btn_reload').text('Processing...');
                var data = {
                    'action': 'reload',
                    'nonce': '<?php echo wp_create_nonce('reload_nonce'); ?>',
                    'offset': offset
                };
                $.post(ajaxurl, data, function(response) {
                    if (response.data.continue) {
                        console.log(response.data);
                        processBatchReload(response.data.offset);
                        $('#products_btn_reload')
                            .text(response.data.offset + ' processed');
                    } else {
                        $('#products_btn_reload').text('Done ;)');
                        alert('All products have been processed.');
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    alert('Failed to process: ' + textStatus + ' - ' + errorThrown);
                });
            }



            $('#products_btn_reload').on('click', function() {
                processBatchReload(0);
            });
        });
    </script>
<?php
    return $views;
}


add_action('wp_ajax_reload_products', 'reload_products_callback');
function reload_products_callback()
{
    // Security checks
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'reload_products_nonce')) {
        wp_send_json_error('Nonce verification failed!');
        return;
    }
    if (!current_user_can('manage_options')) {
        wp_send_json_error('You do not have sufficient permissions to access this feature.');
        return;
    }

    $batch_size = 100; // Number of products to process per batch
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

    $args = array(
        'post_type' => array('product', 'product_variation'),
        'posts_per_page' => $batch_size,
        'post_status' => 'publish',
        'fields' => 'ids',
        'offset' => $offset,
    );

    $total_products = wp_count_posts('product')->publish + wp_count_posts('product_variation')->publish;

    $products = get_posts($args);
    $processed_count = 0;

    foreach ($products as $product_id) {
        $product = wc_get_product($product_id);
        if ($product->is_type('variable')) {
            foreach ($product->get_children() as $variation_id) {
                $variation = wc_get_product($variation_id);
                $variation->set_backorders('notify'); // or 'yes' for full backorder
                $variation->save();
            }
        } else {
            $product->set_backorders('notify'); // or 'yes' for full backorder
            $product->save();
        }
        $processed_count++;
    }

    if ($processed_count === $batch_size) {
        wp_send_json_success(array(
            'continue' => true,
            'offset' => $offset + $batch_size,
            'total' => $total_products,
        ));
    } else {
        wp_send_json_success(array('continue' => false));
    }
}

add_filter('woocommerce_available_payment_gateways', 'conditional_cheque_payment_gateway');

function conditional_cheque_payment_gateway($available_gateways)
{
    if (is_checkout() && !is_wc_endpoint_url()) {
        $chosen_shipping_methods = WC()->session->get('chosen_shipping_methods');
        if (isset($chosen_shipping_methods[0]) && $chosen_shipping_methods[0] !== 'local_pickup:2') {
            unset($available_gateways['cheque']);
        }
    }
    return $available_gateways;
}



//Reload products

add_action('wp_ajax_reload', 'reload_callback');
function reload_callback()
{
    // Security checks
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'reload_nonce')) {
        wp_send_json_error('Nonce verification failed!');
        return;
    }
    if (!current_user_can('manage_options')) {
        wp_send_json_error('You do not have sufficient permissions to access this feature.');
        return;
    }

    $batch_size = 100; // Number of products to process per batch
    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

    $args = array(
        'post_type' => array('product', 'product_variation'),
        'posts_per_page' => $batch_size,
        'post_status' => 'publish',
        'fields' => 'ids',
        'offset' => $offset,
        'suppress_filters' => false,
    );
    $products = get_posts($args);
    $processed_count = 0;
    $total_products = wp_count_posts('product')->publish;

    foreach ($products as $product_id) {
        $product = wc_get_product($product_id);
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();

        $product_translation = apply_filters('wpml_object_id', $product->get_id(), 'product', FALSE, 'sk');
        if ($product_translation) {
            $translated_product = wc_get_product($product_translation);

            $translated_product->set_regular_price($regular_price);
            $translated_product->set_sale_price($sale_price);

            $translated_product->save();
        }

        $processed_count++;
    }

    if ($processed_count === $batch_size) {
        wp_send_json_success(array(
            'continue' => true,
            'offset' => $offset + $batch_size,
            'total' => $total_products,
        ));
    } else {
        wp_send_json_success(array('continue' => false));
    }
}

//bike template functions
function conditional_gutenberg_for_products($can_edit, $post_type)
{
    if ($post_type === 'product') {
        $post_id = get_the_ID();
        if (!$post_id && isset($_GET['post'])) {
            $post_id = intval($_GET['post']);
        }

        if ($post_id) {
            $template_type = rwmb_meta('custom_product_template', '', $post_id);

            if ($template_type === 'bike') {
                return true;
            }
        }
    }
    return $can_edit;
}
add_filter('use_block_editor_for_post_type', 'conditional_gutenberg_for_products', 10, 2);

// add template type to body class 
add_filter('body_class', function ($classes) {
    if (is_singular('product')) {
        $template_type = rwmb_meta('custom_product_template');
        if ($template_type) {
            $classes[] = 'product-template-' . sanitize_html_class($template_type);
        }
    }
    return $classes;
});

add_filter('woocommerce_available_payment_gateways', 'rim_block_payment_gateways_for_main_category');

// disable payment gateways for bike category
function rim_block_payment_gateways_for_main_category($gateways)
{
    if (is_admin() || !is_checkout()) return $gateways;

    $blocked_categories = ['bike', 'bike-sk'];
    $blocked_gateways = [
        'gpwebpaygpebinder',
        'gpwebpaygpebindergooglepay',
        'gpwebpaygpebinderbankall',
        'gpwebpaygpebinderapplepay'
    ];

    foreach (WC()->cart->get_cart_contents() as $item) {
        $product_id = $item['product_id'];
        $term_slugs = wp_get_post_terms($product_id, 'main-category', ['fields' => 'slugs']);

        if (array_intersect($term_slugs, $blocked_categories)) {
            foreach ($blocked_gateways as $id) {
                unset($gateways[$id]);
            }
            break;
        }
    }

    return $gateways;
}

// disable shipping methods for bike category
add_filter('woocommerce_package_rates', 'rim_block_shipping_methods_for_main_category', 10, 2);
function rim_block_shipping_methods_for_main_category($rates, $package)
{
    $blocked_categories = ['bike', 'bike-sk'];
    $blocked_shipping_methods = ['packetery_shipping_method:packetery_carrier_zpointsk'];

    foreach ($package['contents'] as $item) {
        $product_id = $item['product_id'];
        $term_slugs = wp_get_post_terms($product_id, 'main-category', ['fields' => 'slugs']);

        if (array_intersect($term_slugs, $blocked_categories)) {
            foreach ($blocked_shipping_methods as $id) {
                unset($rates[$id]);
            }
            break;
        }
    }

    return $rates;
}


?>