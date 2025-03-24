<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}


if ( $product->is_in_stock() ) : ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<?php 

        $colorMeta = rwmb_meta('color', null, $product->get_id());
        if(!empty($colorMeta)){
                echo '<p class="color-term heading">' . __('Color: ', 'rimrebellion') .'<span class="color-term">'  . $colorMeta . '</span>'.'</p>';
            }
        display_related_product_thumbnails();?>
<form class="cart"
    action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
    method="post" enctype='multipart/form-data'>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <div class="stock-wrp">
        <?php get_template_part("template-parts/stock-status", null, ["product" => $product]); ?>
        <div class="availability-date">
            <?php
                            $availability_date_tomorrow = get_post_meta($product->get_id(), '_availability_date_tomorrow', true);
                            $availability_date_onbackorder = get_post_meta($product->get_id(), '_availability_date_onbackorder', true);
                            $availability_date_default = get_post_meta($product->get_id(), '_availability_date_default', true);
                            $today = date('D');

                            if(ICL_LANGUAGE_CODE=='en'){
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
    
                                $availability_date_tomorrow = date('j.n.', strtotime('today'));
                                $tomorrow = date('D', strtotime('today'));
                                if($today == 'Sat' || $today == 'Sun'){
                                    $availability_date_tomorrow = date('j.n.', strtotime('next monday'));
                                } else {
                                    if ($tomorrow == 'Sat') {
                                        $availability_date_tomorrow = date('j.n.', strtotime('next monday'));
                                    }
                                }
    
                                $availability_date_default = date('j.n.', strtotime('tomorrow'));
                                $default = date('D', strtotime('tomorrow'));
                                if($today == 'Sat' || $today == 'Sun'){
                                        $availability_date_default = date('j.n.', strtotime('next monday'));
                                } else {
                                    if ($default == 'Sat' || $default == 'Sun') {
                                        $availability_date_default = date('j.n.', strtotime('next monday'));
                                    }
                                }
    
                                echo '<p class="availability-date-default">' . esc_html(__('(Shipping on: ', 'rimrebellion')) . ' ' . $availability_date_default . ')</p>';
    
                                echo '<p class="availability-date-tomorrow">' . esc_html(__('(Shipping on: ', 'rimrebellion')) . ' ' . $availability_date_tomorrow . ')</p>';
    
                                echo '<p class="availability-date-onbackorder">' . esc_html(__('(Shipping on: ', 'rimrebellion')) . ' ' . $availability_date_onbackorder . ')</p>';
                            } else {
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
    
                                $availability_date_tomorrow = date('j.n.', strtotime('tomorrow'));
                                $tomorrow = date('D', strtotime('tomorrow'));
                                if($today == 'Sat' || $today == 'Sun'){
                                    $availability_date_tomorrow = date('j.n.', strtotime('next monday'));
                                } else {
                                    if ($tomorrow == 'Sat') {
                                        $availability_date_tomorrow = date('j.n.', strtotime('next monday'));
                                    }
                                }
    
                                $availability_date_default = date('j.n.', strtotime('+2 days'));
                                $default = date('D', strtotime('+2 days'));
                                if($today == 'Sat' || $today == 'Sun'){
                                        $availability_date_default = date('j.n.', strtotime('next tuesday'));
                                } else {
                                    if ($default == 'Sat' || $default == 'Sun') {
                                        $availability_date_default = date('j.n.', strtotime('next tuesday'));
                                    }
                                }
    
                                echo '<p class="availability-date-default">' . esc_html(__('(Doručíme: ', 'rimrebellion')) . ' ' . $availability_date_default . ')</p>';
    
                                echo '<p class="availability-date-tomorrow">' . esc_html(__('(Doručíme: ', 'rimrebellion')) . ' ' . $availability_date_tomorrow . ')</p>';
    
                                echo '<p class="availability-date-onbackorder">' . esc_html(__('(Doručíme: ', 'rimrebellion')) . ' ' . $availability_date_onbackorder . ')</p>';
                            }
                            ?>
        </div>
    </div>
    <?php
    $size_help = get_the_terms($product->get_id(), "size-chart"); 

    if(!empty($size_help)){ ?>
    <div class="help-wrp">
        <a href="#0" id="size-help">
            <?= file_get_contents(RIMREBELLION_CHILD_URI . '/assets/svg/tabulka_velkosti.svg'); ?>
            <?= __('Size help', 'inoby') ?></a>
    </div>
    <?php } ?>
    <div class="simple-row">
        <?php rebellion_add_to_cart_btn(
				array(
					'text' => esc_html( $product->single_add_to_cart_text() ),
					'class' => 'button triangleBoth black',
					'tag' => 'submit'
					)
				); ?>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

        <input type="hidden" name="rc-add-to-cart" value="<?= $product->get_id(); ?>">
        <input type="hidden" name="open_minicart" value="1">

    </div>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>