<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

<span class="active-orders">
    <?= '<h4>'. __( 'ACTIVE ORDERS' , 'rootscope' ) .'</h4>' ?>

    <table
        class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">

        <tbody>
            <tr class="orders-table-headings">
                <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell">
                    <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                    <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

                    <?php elseif ( 'order-number' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Order number','rootscope') ?></span>
                    <?php elseif ( 'order-date' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Date','rootscope') ?></span>
                    <?php elseif ( 'order-total' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Price','rootscope') ?></span>
                    <?php elseif ( 'order-status' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Actual state','rootscope') ?></span>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php
                $delivered_orders = [];
                    foreach ( $customer_orders->orders as $customer_order ) {
                        $order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                        if($order->get_status() != 'completed' && $order->get_status() != 'refunded' && $order->get_status() != 'cancelled'){
                        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                        ?>
            <tr
                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order active-order">
                <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>"
                    data-title="<?php echo esc_attr( $column_name ); ?>">
                    <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                    <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

                    <?php elseif ( 'order-number' === $column_id ) : ?>
                    <?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
                    <?php elseif ( 'order-date' === $column_id ) : ?>
                    <time
                        datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
                    <?php elseif ( 'order-total' === $column_id ) : ?>
                    <?php
                                        /* translators: 1: formatted order total 2: total order items */
                                        echo wp_kses_post( sprintf( _n( '%1$s', '%1$s', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
                                        ?>
                    <?php elseif ( 'order-status' === $column_id ) : ?>
                    <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

                    <?php elseif ( 'order-actions' === $column_id ) : ?>
                    <?php
                                        $actions = wc_get_account_orders_actions( $order );
        
                                        if ( ! empty( $actions ) ) {
                                            foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                                                if($key === 'view'){
                                                    echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button color ' . sanitize_html_class( $key ) . '">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 11.25H18.5V12.75H4.5V11.25Z" fill="black"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3855 11.9962L14.4197 9.03039L15.4803 7.96973L19.5145 12.0039L15.4765 15.9842L14.4235 14.9159L17.3855 11.9962Z" fill="black"/>
                                                    </svg>
                                                    </a>';
                                                }
                                            }
                                        }
                                        ?>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <tr class="spacer"></tr>
            <?php
                    } }
                    ?>
        </tbody>
    </table>
</span>


<span class="orders-history">
    <h4 class="orders-history"><?= __( 'ORDER HISTORY' , 'rootscope' ) ?> </h4>
    <table
        class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table history">

        <tbody>
            <tr class="orders-table-headings">
                <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell">
                    <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                    <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

                    <?php elseif ( 'order-number' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Order number','rootscope') ?></span>
                    <?php elseif ( 'order-date' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Date','rootscope') ?></span>
                    <?php elseif ( 'order-total' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Price','rootscope') ?></span>
                    <?php elseif ( 'order-status' === $column_id ) : ?>
                    <span class="order-legend"><?= __('Actual state','rootscope') ?></span>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php
            $delivered_orders = [];
                foreach ( $customer_orders->orders as $customer_order ) {
                    $order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                    if($order->get_status() === 'completed' || $order->get_status() === 'refunded' || $order->get_status() === 'cancelled'){
                        $status = $order->get_status();
                    $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                    ?>
            <tr
                class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order orders-completed">
                <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
                <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>"
                    data-title="<?php echo esc_attr( $column_name ); ?>">
                    <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                    <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

                    <?php elseif ( 'order-number' === $column_id ) : ?>
                    <?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
                    <?php elseif ( 'order-date' === $column_id ) : ?>
                    <time
                        datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>
                    <?php elseif ( 'order-total' === $column_id ) : ?>
                    <?php
                                    /* translators: 1: formatted order total 2: total order items */
                                    echo wp_kses_post( sprintf( _n( '%1$s', '%1$s', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
                                    ?>
                    <?php elseif ( 'order-status' === $column_id ) : ?>
                    <span class="<?= ($status === 'completed' ? "completed" : "refunded") ?>">
                        <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
                    </span>

                    <?php elseif ( 'order-actions' === $column_id ) : ?>
                    <?php
                                    $actions = wc_get_account_orders_actions( $order );
    
                                    if ( ! empty( $actions ) ) {
                                        foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                                            if($key === 'view'){
                                                echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button color ' . sanitize_html_class( $key ) . '">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 11.25H18.5V12.75H4.5V11.25Z" fill="black"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3855 11.9962L14.4197 9.03039L15.4803 7.96973L19.5145 12.0039L15.4765 15.9842L14.4235 14.9159L17.3855 11.9962Z" fill="black"/>
                                                </svg>
                                                </a>';
                                            }
                                        }
                                    }
                                    ?>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <tr class="spacer"></tr>
            <?php
                } }
                ?>
        </tbody>
    </table>
</span>

<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
    <?php if ( 1 !== $current_page ) : ?>
    <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button"
        href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
    <?php endif; ?>

    <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
    <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button"
        href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php else : ?>
<div
    class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
    <a class="woocommerce-Button button"
        href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php esc_html_e( 'Browse products', 'woocommerce' ); ?></a>
    <?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>