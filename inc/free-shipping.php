<?php

/**
 * Tu sa vyberá hodnota z dopravnej metódy Poštovné zdarma (Free Shipping)
 * Je potrebné ju nakonfigurovať vo WooCommerce -> Doprava -> Zóny Dopravy (doplň $zone_name vo snippete) -> Spôsoby doručenia
 * @param $zone_name The name of the zone to get the threshold of. Case-sensitive.
 * @return int The threshold corresponding to the zone, if there is any. If there is no such zone, or no free shipping method, null will be returned.
 */
function get_free_shipping_minimum($zone_name = 'Slovensko') {
  if ( ! isset( $zone_name ) ) return null;

  $result = null;
  $zone = null;

  $zones = WC_Shipping_Zones::get_zones();
  foreach ( $zones as $z ) {
    if ( $z['zone_name'] == $zone_name ) {
      $zone = $z;
    }
  }

  if ( $zone ) {
    $shipping_methods_nl = $zone['shipping_methods'];
    $free_shipping_method = null;
    foreach ( $shipping_methods_nl as $method ) {
      if ( $method->id == 'free_shipping' ) {
        $free_shipping_method = $method;
        break;
      }
    }

    if ( $free_shipping_method ) {
      $result = $free_shipping_method->min_amount;
    }
  }

  return $result;
}

/**
 * From https://isabelcastillo.com/woocommerce-check-shipping-class
 * Check if the cart has product with a certain Shipping Class
 * @param string $slug the shipping class slug to check for
 * @return bool true if a product with the Shipping Class is found in cart
 */
function cart_has_product_with_shipping_class( $slug ) {
  
  global $woocommerce;

  $product_in_cart = false;

  foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {

      $_product = $values['data'];
      $terms = get_the_terms( $_product->id, 'product_shipping_class' );

      if ( $terms ) {
          foreach ( $terms as $term ) {
              $_shippingclass = $term->slug;
              if ( $slug === $_shippingclass ) {
                   
                  $product_in_cart = true;
              }
          }
      }
  }

  return $product_in_cart;
}


/**
 * Kalkulácia dopravy zadarmo vo woocommerce_before_cart_contents
 */
function inoby_calculator_to_free_shipping() {

  
  $free_shipping_price = get_free_shipping_minimum();
  $total_price = WC()->cart->subtotal;
  $remaining = $free_shipping_price - $total_price;
  $remaining_price = wc_price($remaining);

    $percentage = ($total_price / $free_shipping_price) * 100;
  

    if (is_user_logged_in()) {
      if($free_shipping_price > $total_price){
        echo '<div class="free-shipping-notice">';
        echo __('<p>Purchase for '. $remaining_price .' more, and get free delivery.</p>','inoby');
        echo '<div class="line"><span class="line-color" style="width: '. $percentage .'%;"></span></div>';
        echo '</div>';
      }
      else {
        echo '<div class="free-shipping-notice free-is-available">';
        echo __('<p>Congratulations, you have earned a <strong>free delivery</strong></p>','inoby');
        echo '<div class="line full"><span class="line-color"></span></div>';
        echo '</div>';
      }
    } 
  
};
add_action('woocommerce_before_cart_contents', 'inoby_calculator_to_free_shipping');

function inoby_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
  
  if (is_user_logged_in() && WC()->cart->subtotal > get_free_shipping_minimum()) {
    foreach ( $rates as $rate_id => $rate ) {
      if ( 'free_shipping' === $rate->method_id ) {
        $free[ $rate_id ] = $rate;
        break;
      }
    }
  }
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'inoby_hide_shipping_when_free_is_available', 100 );