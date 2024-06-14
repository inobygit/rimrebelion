<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<h2>
    <?= __("Order details", 'rimrebellion') ?>
</h2>

<table cellspacing="0" cellpadding="6"
    style="text-align: left; width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border: none; border-bottom: 3px solid black;">
    <thead>
        <?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	?>
        <tr>
            <td style="padding: 0;">
                <i>
                    <u>
                        <?= wp_kses_post( $before . sprintf( __( 'Order number: %s', 'rimrebellion' ) . $after, $order->get_order_number() ) ) ?>
                    </u>
                </i>
            </td>
            <td>
                <i>
                    <u>
                        <?= wp_kses_post( sprintf( __('Order date: ', 'rimrebellion') . ' <time datetime="%s">%s</time>', $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) ) ?>
                    </u>
                </i>
            </td>
        </tr>
    </thead>
</table>

<div style="margin-bottom: 40px;">
    <table class="td" cellspacing="0" cellpadding="6"
        style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
        <thead>
            <tr>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => false,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
			?>
        </tbody>
        <tfoot>
            <?php
			$item_totals = $order->get_order_item_totals();

			$payment_method = $order->get_payment_method_title();
			$shipping_method = $order->get_shipping_method();

			?>
            <tr>
                <th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php esc_html_e( 'Shipping: ', 'rimrebellion' ); ?><?php echo esc_html( $shipping_method ); ?>
                </th>
                <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php 
                    $shipping_total = $order->get_shipping_total();
                    if ($shipping_total > 0) {
                        echo wp_kses_post( wc_price( $shipping_total ) );
                    } else {
                        esc_html_e('Free', 'rimrebellion');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php esc_html_e( 'Payment: ', 'rimrebellion' ); ?><?php echo esc_html( $payment_method ); ?>
                </th>
                <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php 
                $fee_total = $order->get_total_tax(); 
                if ($fee_total > 0) {
                    echo wp_kses_post( wc_price($fee_total) );
                } else {
                    esc_html_e('Free', 'rimrebellion');
                }
                ?>
                </td>
            </tr>
            <?php

			if ( $item_totals ) {
				$i = 0;
					?>
            <tr>
                <th class="td" scope="row" colspan="2"
                    style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>">
                    <?php echo wp_kses_post( $item_totals['order_total']['label'] ); ?></th>
                <td class="td"
                    style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>">
                    <?php echo wp_kses_post( $item_totals['order_total']['value'] ); ?></td>
            </tr>
            <?php
			}
			if ( $order->get_customer_note() ) {
				?>
            <tr>
                <th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
                <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;">
                    <?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
            </tr>
            <?php
			}
			?>
        </tfoot>
    </table>
</div>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>