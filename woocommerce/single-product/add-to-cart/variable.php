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
                        <?php
    $size_help = get_the_terms($product->get_id(), "size-chart"); 

    if(!empty($size_help)){ ?>
                        <div class="help-wrp">
                            <a href="#0" id="size-help">
                                <?= file_get_contents(RIMREBELLION_CHILD_URI . '/assets/svg/tabulka_velkosti.svg'); ?>
                                <?= __('Size help', 'inoby') ?></a>
                        </div>
                        <?php } ?>
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