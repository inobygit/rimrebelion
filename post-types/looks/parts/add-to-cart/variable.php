<?php
/**
 * Variable product add to cart
 */

defined("ABSPATH") || exit();
		wp_enqueue_script( 'wc-add-to-cart-variation' );

$product = $args['product'] ?? null;
$attributes = $product->get_variation_attributes();
$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
$available_variations = $get_variations ? $product->get_available_variations() : false;

$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists("wc_esc_json") ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, "UTF-8", true);

do_action("woocommerce_before_add_to_cart_form");
?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint(
    $product->get_id(),
); ?>" data-product_variations="<?php echo $variations_attr; ?>">
    <?php do_action("woocommerce_before_variations_form"); ?>


    <?php if (empty($available_variations) && false !== $available_variations): ?>
    <p class="stock out-of-stock"><?php echo esc_html(
      apply_filters("woocommerce_out_of_stock_message", __("This product is currently out of stock and unavailable.", "woocommerce")),
  ); ?></p>
    <?php else: ?>
    <div class="single_variation_wrap">
        <?php
		echo '<div class="woocommerce-variation single_variation">'; ?>
        <script type="text/template" id="tmpl-variation-template">
            <div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>
	<div class="woocommerce-variation-availability">{{{ (data.variation.availability_html.includes('instock') ? `<p class="stock instock"> <?= __('In stock', 'rimrebellion') ?> </p>` : (data.variation.availability_html.includes('onbackorder') ? `<p class="stock onbackorder"> <?= __('On backorder', 'rimrebellion') ?> </p>` : (data.variation.availability_html.includes('outofstock') ? `<p class="stock outofstock"> <?= __('Out of stock', 'rimrebellion') ?> </p>` : data.variation.availability_html))) }}}</div>
</script>
        <?php echo '</div>';?>
        <div id="price-wrp" class="price-wrp">
            <?php
                $lowest_price = null;
                $has_different_prices = false; // Track if there are different prices

                if ($product->is_type('variable')) {
                    $available_variations = $product->get_available_variations();
                    $first_price = null; // Store the first price for comparison

                    foreach ($available_variations as $variation) {
                        $price = $variation['display_price'];
                        if ($lowest_price === null || $price < $lowest_price) {
                            $lowest_price = $price;
                        }
                        // Check if the price is different from the first price
                        if ($first_price === null) {
                            $first_price = $price;
                        } elseif ($price !== $first_price) {
                            $has_different_prices = true; // Set flag if prices differ
                        }
                    }
                    $lowest_price = number_format($lowest_price, 2, ',', ' ');

                    // Update priceHtml only if there are different prices
                    if ($has_different_prices) {
                        $priceHtml = '<span class="woocommerce-Price-amount amount"><bdi>'. __("from ", 'inoby') .''. $lowest_price .'&nbsp;<span class="woocommerce-Price-currencySymbol">€</span></bdi></span>';
                    } 
                }


                    ?>
            <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
                <?= (isset($priceHtml) && $lowest_price != 0 ? $priceHtml : $product->get_price_html()) ?>
            </p>
        </div>
        <?php $colorMeta = rwmb_meta('color', null, $product->get_id());

        $colorMeta = rwmb_meta('color', null, $product->get_id());
        if(!empty($colorMeta)){
                echo '<p class="color-term heading">' . __('Color: ', 'rimrebellion') .'<span class="color-term">'  . $colorMeta . '</span>'.'</p>';
            }
        display_related_product_thumbnails($product->get_id());
?>

        <table class="variations" cellspacing="0" role="presentation">
            <tbody>
                <?php foreach ($attributes as $attribute_name => $options): 
                    ?>
                <tr>
                    <td class="value">
                        <div class="stock-wrp">
                            <p class="size-label"><?php echo wc_attribute_label(
                                $attribute_name,
                            ); ?>: </p>
                            <?php get_template_part("template-parts/stock-status", null, ["product" => $product]); ?>
                            <div class="availability-date">
                                <?php
                            $availability_date_tomorrow = get_post_meta($product->get_id(), '_availability_date_tomorrow', true);
                            $availability_date_onbackorder = get_post_meta($product->get_id(), '_availability_date_onbackorder', true);
                            $availability_date_default = get_post_meta($product->get_id(), '_availability_date_default', true);
$today = date('D');

                            $availability_date_onbackorder = date('j.n.', strtotime('+10 days'));
                            $backorderDate = date('D', strtotime('+10 days'));
                            $backorderDateFormated = date('Y-m-d', strtotime('+10 days'));
                            if($today == 'Sat' || $today == 'Sun'){
                                $availability_date_onbackorder = date('j.n.', strtotime($backorderDateFormated . ' next tuesday'));
                            } else {
                                if ($backorderDate == 'Sat' || $backorderDate == 'Sun') {
                                    $availability_date_onbackorder = date('j.n.', strtotime($backorderDateFormated . ' next tuesday'));
                                }
                            }

                            $availability_date_tomorrow = date('j.n.', strtotime('tomorrow + 1 day'));
                            $tomorrow = date('D', strtotime('tomorrow + 1 day'));
                            if($today == 'Sat' || $today == 'Sun'){
                                $availability_date_tomorrow = date('j.n.', strtotime('next wednesday'));
                            } else {
                                if ($tomorrow == 'Sat') {
                                    $availability_date_tomorrow = date('j.n.', strtotime('next tuesday'));
                                } else if($tomorrow == 'Sun'){
                                    $availability_date_tomorrow = date('j.n.', strtotime('next wednesday'));
                                }
                            }

                            $availability_date_default = date('j.n.', strtotime('+2 days'));
                            $default = date('D', strtotime('+2 days'));
                            if($today == 'Sat' || $today == 'Sun'){
                                    $availability_date_default = date('j.n.', strtotime('next tuesday + 1 days'));
                            } else {
                                if ($default == 'Sat' || $default == 'Sun') {
                                    $availability_date_default = date('j.n.', strtotime('next tuesday + 1 days'));
                                }
                            }

                            echo '<p class="availability-date-default">' . esc_html(__('(Shipping on: ', 'rimrebellion')) . ' ' . $availability_date_default . ')</p>';

                            echo '<p class="availability-date-tomorrow">' . esc_html(__('(Shipping on: ', 'rimrebellion')) . ' ' . $availability_date_tomorrow . ')</p>';

                            echo '<p class="availability-date-onbackorder">' . esc_html(__('(Shipping on: ', 'rimrebellion')) . ' ' . $availability_date_onbackorder . ')</p>';
                            ?>
                            </div>
                        </div>
                        <?php wc_dropdown_variation_attribute_options([
                "options" => $options,
                "attribute" => $attribute_name,
                "product" => $product,
            ]); ?>
                    </td>
                </tr>
                <?php if ($attribute_name == "pa_size") {
            echo "<td style='display: none;'>TODO Veľkostná tabuľka</td>";
        } ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php do_action("woocommerce_before_single_variation"); ?>
        <?php
    get_template_part( 'post-types/looks/parts/add-to-cart/variation-add-to-cart-button', null, ['product' => $product]);
    do_action("woocommerce_after_single_variation");
    ?>
    </div>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <?php
        echo '<div class="order-wrp">';

	?>
    <?php 
	rebellion_add_to_cart_btn(
		array(
			'text' => esc_html( $product->single_add_to_cart_text() ),
			'class' => 'button triangleBoth black',
			'tag' => 'submit'
		), $product
		);
        echo '</div>';
	?>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    <?php do_action("woocommerce_after_variations_table"); ?>

    <?php endif; ?>

    <?php do_action("woocommerce_after_variations_form"); ?>
</form>

<?php
$GLOBALS['product'] = $product;
ob_start();
do_action("woocommerce_after_add_to_cart_form");
ob_clean();