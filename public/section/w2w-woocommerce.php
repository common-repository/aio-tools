<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if ( !empty(w2w_get_option( 'opt-cfp' )) ) {
	add_filter('woocommerce_get_price_html', 'w2w_custom_call_for_price', 9999, 2 );
}
function w2w_custom_call_for_price($price, $product) {
	$cfp_html = __( 'Gọi để biết giá', 'w2w' );
	if( !empty( w2w_get_option( 'txt-cfp-text' ))){
		$cfp_html = w2w_get_option( 'txt-cfp-text' );
	}	
	if ( $product->is_type( 'variable' ) ) {
        $prices = $product->get_variation_prices( true );
        $min_price = current( $prices['price'] );
        if ( 0 == $min_price ) {
            $max_price = end( $prices['price'] );
            $min_reg_price = current( $prices['regular_price'] );
            $max_reg_price = end( $prices['regular_price'] );
            if ( $min_price !== $max_price ) {
                $price = wc_format_price_range( $cfp_html, $max_price );
                $price .= $product->get_price_suffix();
            } elseif ( $product->is_on_sale() && $min_reg_price === $max_reg_price ) {
                $price = wc_format_sale_price( wc_price( $max_reg_price ), $cfp_html );
                $price .= $product->get_price_suffix();
            } else {
                $price = $cfp_html;
            }
        }
    } elseif ( '' === $product->get_price() || 0 == $product->get_price() ) {
        $price = '<span class="woocommerce-Price-amount amount">' . $cfp_html . '</span>';
    } 
    return $price;
}
if ( !empty(w2w_get_option( 'opt-wc-show-price' )) ) {
	add_action( 'woocommerce_variable_add_to_cart', 'w2w_update_price_with_variation_price' );
}
function w2w_update_price_with_variation_price() {
   global $product;
   $price = $product->get_price_html();
   wc_enqueue_js( "     
      $(document).on('found_variation', 'form.cart', function( event, variation ) {   
         if(variation.price_html) $('p.price').html(variation.price_html);
         $('.woocommerce-variation-price').hide();
      });
      $(document).on('hide_variation', 'form.cart', function( event, variation ) {   
         $('p.price').html('" . $price . "');
      });
   " );
}

if ( !empty(w2w_get_option( 'opt-enable-wc' )) ) {
	// Frontend Hooks
	add_filter( 'woocommerce_checkout_fields', 'w2w_CustomDisplayWooCheckoutFields');
	if(w2w_get_option( 'opt-enable-vn-checkout' ) == 1){
		add_filter('woocommerce_checkout_fields', 'woocommerce_reorder_vn_checkout_fields', 9999);
		include ( W2W_PUBLIC_PATH . 'section/wc-city-select/class-w2w-provinces.php');
		$Provinces = new W2W_Provinces();
		include ( W2W_PUBLIC_PATH . 'section/wc-city-select/class-w2w-cities.php');
		new W2W_Cities();
	}
}


			
function w2w_CustomDisplayWooCheckoutFields($fields) {
	// Ignore admin, feed, robots or trackbacks
	if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
		return;
	}
	if(w2w_get_option( 'opt-first-name' ) == 1){
		unset($fields['billing']['billing_first_name']);
		unset($fields['shipping']['shipping_first_name']);
	}		
	if(w2w_get_option( 'opt-last-name' ) == 1){
		unset($fields['billing']['billing_last_name']);
		unset($fields['shipping']['shipping_last_name']);
	}		
	if(w2w_get_option( 'opt-company' ) == 1){
		unset($fields['billing']['billing_company']);
		unset($fields['shipping']['shipping_company']);
	}		
	if(w2w_get_option( 'opt-address-1' ) == 1){
		unset($fields['billing']['billing_address_1']);
		unset($fields['shipping']['shipping_address_1']);
	}		
	if(w2w_get_option( 'opt-address-2' ) == 1){
		unset($fields['billing']['billing_address_2']);
		unset($fields['shipping']['shipping_address_2']);
	}		
	if(w2w_get_option( 'opt-city' ) == 1){
		unset($fields['billing']['billing_city']);
		unset($fields['shipping']['shipping_city']);
	}		
	if(w2w_get_option( 'opt-postcode' ) == 1){
		unset($fields['billing']['billing_postcode']);
		unset($fields['shipping']['shipping_postcode']);
	}		
	if(w2w_get_option( 'opt-country' ) == 1){
		unset($fields['billing']['billing_country']);
		unset($fields['shipping']['shipping_country']);
	}		
	if(w2w_get_option( 'opt-state' ) == 1){
		unset($fields['billing']['billing_state']);
		unset($fields['shipping']['shipping_state']);
	}		
	if(w2w_get_option( 'opt-phone' ) == 1){
		unset($fields['billing']['billing_phone']);
	}		
	if(w2w_get_option( 'opt-email' ) == 1){
		unset($fields['billing']['billing_email']);
	}
	return $fields;
}
if ( ! function_exists( 'woocommerce_reorder_vn_checkout_fields' ) ) {
    function woocommerce_reorder_vn_checkout_fields( $fields ) {
		
		$i = 0;
        /* To reorder state field you need to add this array. */
        $order = array(
			"billing_last_name", 
			"billing_first_name", 
			"billing_phone",
			"billing_email",
			"billing_address_1",
			"billing_state", 
			"billing_city",
			
        );

        foreach($order as $field) {
			$ordered_fields[ $field ] = $fields[ "billing" ][ $field ];
			$ordered_fields[ $field ][ "priority" ] = ++$i;
        }
		
        $fields["billing"] = $ordered_fields;

        /* To change email and phone number you have to add only class no need to add priority. */
		$fields['billing']['billing_country']['default'] = 'Việt Nam';
		$fields['billing']['billing_country']['class'][0] = 'hidden';
		
        $fields['billing']['billing_last_name']['class'][0] = 'form-row-first';
        $fields['billing']['billing_first_name']['class'][0] = 'form-row-last';
        
		$fields['billing']['billing_phone']['class'][0] = 'form-row-first';
		$fields['billing']['billing_email']['class'][0] = 'form-row-last';
		
		$fields['billing']['billing_address_1']['class'][0] = 'form-row-wide';
		//$fields['billing']['billing_country']['class'][0] = 'form-row-last';
		
		$fields['billing']['billing_state']['class'][0] = 'form-row-last';
		$fields['billing']['billing_city']['class'][0] = 'form-row-first';
		
		return $fields;
    }
}