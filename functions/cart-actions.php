<?php
add_action( 'remove_repeated_products', 'remove_repeated_products', 10, 1 );

function remove_repeated_products( $cart_items ) {
	global $woocommerce;
	foreach ( $cart_items as $key => $item ) {
		if ( (int)$item['quantity'] > 1 ) {
			$woocommerce->cart->set_quantity($key);
		}
	}
}