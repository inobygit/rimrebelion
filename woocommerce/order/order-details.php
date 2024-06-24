<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.6.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>

<section class="woocommerce-order-details">
    <?php if (is_account_page()) { ?>
    <div class="row woocommerce-order-details-hero">
        <a class="button back" href="<?= esc_url( wc_get_account_endpoint_url( 'orders' ) )?>"><svg width="24"
                height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.55 7.9502L4.5 12.0002L8.55 16.0002L9.6 14.9502L7.4 12.7502H19.5V11.2502H7.35L9.6 9.0502L8.55 7.9502Z"
                    fill="black" />
            </svg>
        </a>
    </div>
    <div class="row woocommerce-order-details-hero">
        <?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
        <?php
        if (is_account_page()) {
			echo '<h2>'. __('ORDER','rootscope') .' '. $order->get_order_number() .'</h2>';
        } else {
			echo '<h2>'. __('ORDER SUMMARY','rootscope') .'</h2>';
        }
		?>
    </div>

    <?php if (is_account_page()) { ?>
    <div class="order-legend-info">
        <table class="account-orders-table-single">
            <tbody>
                <tr class="woocommerce-orders-table__row order">
                    <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-date"
                        data-title="Order date">
                        <?= wc_format_datetime( $order->get_date_created() ) ?>
                    </td>
                    <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                        data-title="Order number">
                        <?= $order->get_order_number() ?>
                    </td>
                    <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-price"
                        data-title="Order price">
                        <?= $order->get_order_item_totals()['order_total']['value']; ?>
                    </td>
                    <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status <?= $order->get_status() ?>"
                        data-title="Order status">
                        <?= wc_get_order_status_name( $order->get_status() ) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>

    <?php if ( isset($notes) ) : ?>
    <h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
    <ol class="woocommerce-OrderUpdates commentlist notes">
        <?php foreach ( $notes as $note ) : ?>
        <li class="woocommerce-OrderUpdate comment note">
            <div class="woocommerce-OrderUpdate-inner comment_container">
                <div class="woocommerce-OrderUpdate-text comment-text">
                    <p class="woocommerce-OrderUpdate-meta meta">
                        <?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </p>
                    <div class="woocommerce-OrderUpdate-description description">
                        <?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </li>
        <?php endforeach; ?>
    </ol>
    <?php endif; ?>

    <div class="row woocommerce-order-details-info">
        <?php
			do_action( 'woocommerce_after_order_details', $order );

			if ( $show_customer_details ) {
				wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
			}
		?>
    </div>


    <div class="row woocommerce-order-details-products">
        <h3><?= __("Products", 'inoby') ?></h3>
        <?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) {
				$product = $item->get_product();
				echo '<div class="product-wrapper">';?>

        <div class="item-thumbnail">
            <?php
                        $thumbnail = $product ? $product->get_image( array( 300, 300 ) ) : '';
                        echo $thumbnail;
                    ?>
        </div>
        <div class="item-info">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo $product->get_name(); ?></a>
            <?php
                wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
        </div>
        <div class="item-qty">
            <p class="item-quantity"><?=  $item->get_quantity() . __("ks", 'inoby') ?></p>
        </div>
        <div class="item-price">
            <p class="item-price"><?= $order->get_formatted_line_subtotal( $item ) ?></p>
        </div>
        <?php echo '</div>';
			}
			do_action( 'woocommerce_order_details_after_order_table_items', $order );
		?>
    </div>

    <div class="row woocommerce-order-details-info">
        <div class="customer-note-section">
            <?php if ( $order->get_customer_note() ) : ?>
            <div class="customer-note">
                <h3><?php esc_html_e( 'Note', 'rootscope' ); ?></h3>
                <p><?= wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ) ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row woocommerce-order-details-summary">
        <?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
                if($key === 'order_total'){
				?>
        <div class="summary-item">
            <span class="summary-label"><?= esc_html( $total['label'] ) ?></span>
            <span
                class="summary-text"><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
        </div>
        <?php
			}
        }
		
		?>
    </div>

    <div class="woocommerce-order-details-footer">
        <a class="btn back" href="<?= esc_url( wc_get_account_endpoint_url( 'orders' ) )?>">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.6 2.55L10.55 1.5L4 8L10.45 14.5L11.55 13.45L6.1 8L11.6 2.55Z" fill="black" />
            </svg>

            <?= __("Back to my orders") ?>
        </a>

    </div>
    <?php } else { ?>


    <div class="row thankyou-row">
        <div class="col-7 col-md-12">
            <div class="woocommerce-order-details-hero">
                <?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
                <?php
                    echo '<h2>'. __('ORDER SUMMARY','rootscope') .'</h2>';
                ?>
            </div>

            <div class="woocommerce-order-details-info">
                <?php
			do_action( 'woocommerce_after_order_details', $order );

			if ( $show_customer_details ) {
				wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
			}
		?>
            </div>

            <?php if ( isset($notes) ) : ?>
            <h2><?php esc_html_e( 'Note', 'woocommerce' ); ?></h2>
            <ol class="woocommerce-OrderUpdates commentlist notes">
                <?php foreach ( $notes as $note ) : ?>
                <li class="woocommerce-OrderUpdate comment note">
                    <div class="woocommerce-OrderUpdate-inner comment_container">
                        <div class="woocommerce-OrderUpdate-text comment-text">
                            <p class="woocommerce-OrderUpdate-meta meta">
                                <?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </p>
                            <div class="woocommerce-OrderUpdate-description description">
                                <?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ol>
            <?php endif; ?>

        </div>

        <div class="col-5 col-md-12">
            <div class="summary-wrapper">
                <h3>
                    <?= __("Summary", 'rimrebellion') ?>
                </h3>
                <div class="woocommerce-order-details-products">
                    <?php
                do_action( 'woocommerce_order_details_before_order_table_items', $order );
                    $i = 1;
                foreach ( $order_items as $item_id => $item ) {
                    $product = $item->get_product();
                    echo '<div class="product-wrapper">';?>

                    <div class="item-number">
                        <?php
                            echo $i;
                        ?>
                    </div>
                    <div class="item-info">
                        <a
                            href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo $product->get_name(); ?></a>
                        <?php
                    wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
                    </div>
                    <div class="item-price">
                        <p class="item-price"><?= $order->get_formatted_line_subtotal( $item ) ?></p>
                    </div>
                    <?php echo '</div>';
                    $i++;
                }
                do_action( 'woocommerce_order_details_after_order_table_items', $order );
            ?>
                </div>

                <div class="woocommerce-order-details-summary">
                    <?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
                if($key === 'order_total'){
				?>
                    <div class="summary-item">
                        <span class="summary-label"><?= esc_html( $total['label'] ) ?></span>
                        <span
                            class="summary-text"><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    </div>
                    <?php
			}
        }
		
		?>
                </div>
            </div>









        </div>
    </div>
    <?php } ?>
</section>

<?php