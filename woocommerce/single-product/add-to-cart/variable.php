<?php
/**
 * Variable product add to cart
 */

defined("ABSPATH") || exit();

global $product;

$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists("wc_esc_json") ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, "UTF-8", true);

do_action("woocommerce_before_add_to_cart_form");
?>

<form class="variations_form cart" action="<?php echo esc_url(
    apply_filters("woocommerce_add_to_cart_form_action", $product->get_permalink()),
); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint(
    $product->get_id(),
); ?>" data-product_variations="<?php echo $variations_attr; ?>">
    <?php do_action("woocommerce_before_variations_form"); ?>


    <?php if (empty($available_variations) && false !== $available_variations): ?>
    <p class="stock out-of-stock"><?php echo esc_html(
      apply_filters("woocommerce_out_of_stock_message", __("This product is currently out of stock and unavailable.", "woocommerce")),
  ); ?></p>
    <?php else: ?>
    <div class="single_variation_wrap">
        <div id="price-wrp" class="price-wrp"><?php woocommerce_template_single_price(); ?></div>
        <?php do_action("woocommerce_before_single_variation");
    do_action("woocommerce_single_variation");
    do_action("woocommerce_after_single_variation");
    ?>
        <?php 

        $colorMeta = rwmb_meta('color', null, $product->get_id());
        if(!empty($colorMeta)){
                echo '<p class="color-term heading">' . __('Color: ', 'rimrebellion') .'<span class="color-term">'  . $colorMeta . '</span>'.'</p>';
            }
        display_related_product_thumbnails();?>

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

                            $availability_date_onbackorder = date('j.n.', strtotime('+10 days'));
                            $backorderDate = date('D', strtotime('+10 days'));
                            $backorderDateFormated = date('Y-m-d', strtotime('+10 days'));
                            if ($backorderDate == 'Sat' || $backorderDate == 'Sun') {
                                $availability_date_onbackorder = date('j.n.', strtotime($backorderDateFormated . ' next monday'));
                            }

                            $availability_date_tomorrow = date('j.n.', strtotime('tomorrow'));
                            $tomorrow = date('D', strtotime('tomorrow'));
                            if ($tomorrow == 'Sat' || $tomorrow == 'Sun') {
                                $availability_date_tomorrow = date('j.n.', strtotime('next monday'));
                            }

                            $availability_date_default = date('j.n.', strtotime('+2 days'));
                            $default = date('D', strtotime('+2 days'));
                            if ($default == 'Sat' || $default == 'Sun') {
                                $availability_date_default = date('j.n.', strtotime('next monday'));
                            }

                            echo '<p class="availability-date-default">' . esc_html(__('(Delivery: ', 'rimrebellion')) . ' ' . $availability_date_default . ')</p>';

                            echo '<p class="availability-date-tomorrow">' . esc_html(__('(Delivery: ', 'rimrebellion')) . ' ' . $availability_date_tomorrow . ')</p>';

                            echo '<p class="availability-date-onbackorder">' . esc_html(__('(Delivery: ', 'rimrebellion')) . ' ' . $availability_date_onbackorder . ')</p>';
                            ?>
                            </div>
                        </div>

                        <?php wc_dropdown_variation_attribute_options([
                "options" => $options,
                "attribute" => $attribute_name,
                "product" => $product,
            ]); ?>
                        <div class="help-wrp">
                            <a href="#0" id="size-help"><svg width="11" height="12" viewBox="0 0 11 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_948_435)">
                                        <path
                                            d="M10.9883 1.83925C10.9581 1.48519 10.6721 1.1875 10.3125 1.1875H0.6875C0.327937 1.1875 0.0419375 1.48519 0.0116875 1.83925H0V10.8125C0 10.9948 0.0724328 11.1697 0.201364 11.2986C0.330295 11.4276 0.505164 11.5 0.6875 11.5H10.3125C10.4948 11.5 10.6697 11.4276 10.7986 11.2986C10.9276 11.1697 11 10.9948 11 10.8125V1.83925H10.9883ZM4.125 5.3125V3.25H6.875V5.3125H4.125ZM6.875 6V8.11956H4.125V6H6.875ZM3.4375 3.25V5.3125H0.6875V3.25H3.4375ZM0.6875 6H3.4375V8.11956H0.6875V6ZM0.6875 10.8125V8.75H3.4375V10.8125H0.6875ZM4.125 10.8125V8.75H6.875V10.8125H4.125ZM10.3125 10.8125H7.5625V8.75H10.3125V10.8125ZM10.3125 8.11956H7.5625V6H10.3125V8.11956ZM10.3125 5.3125H7.5625V3.25H10.3125V5.3125Z"
                                            fill="#A7A7A7" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_948_435">
                                            <rect width="11" height="11" fill="white" transform="translate(0 0.5)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <?= __('Size help', 'inoby') ?></a>
                        </div>
                    </td>
                </tr>
                <?php if ($attribute_name == "pa_size") {
            echo "<td style='display: none;'>TODO Veľkostná tabuľka</td>";
        } ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <?php
        echo '<div class="order-wrp">';
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>
        <?php rebellion_add_to_cart_btn(
		array(
			'text' => esc_html( $product->single_add_to_cart_text() ),
			'class' => 'button triangleBoth black',
			'tag' => 'submit'
			)
		);
        echo '</div>';
	?>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </div>
    <?php do_action("woocommerce_after_variations_table"); ?>

    <?php endif; ?>

    <?php do_action("woocommerce_after_variations_form"); ?>
</form>

<?php do_action("woocommerce_after_add_to_cart_form");