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

if ( wp_doing_ajax() ) {
	add_action('wp_ajax_add_course_to_cart', 'add_course_to_cart');
	add_action('wp_ajax_nopriv_add_course_to_cart', 'add_course_to_cart');
}
function add_course_to_cart() {
	check_ajax_referer('divine_nonce', 'nonce');
	if ( ! isset($_POST['id']) ) {
		wp_send_json( array('status' => 'fail') );
		wp_die();
	}
	$product = wc_get_product($_POST['id']);
	if ( ! $product ) {
		wp_send_json( array('status' => 'fail') );
		wp_die();
	}
	global $woocommerce;
	$is_added = $woocommerce->cart->add_to_cart($product->get_id());
	$status = ( $is_added ) ? 'success' : 'fail';
	
	$cart_items = $woocommerce->cart->get_cart();
	do_action('clear_cart', $cart_items);
	wp_send_json( array('status' => $status) );
	wp_die();
}

/**
 * Save only one product in cart
 */
add_filter( 'woocommerce_add_to_cart_validation', 'save_only_one_in_cart', 9999, 2 );
function save_only_one_in_cart( $passed, $added_product_id ) {
	wc_empty_cart();
	return $passed;
}

// Max quantity in cart is 1
add_action( 'woocommerce_add_to_cart', 'set_quantity_only_one', 10, 6 );
function set_quantity_only_one( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
	global $woocommerce;
	$cart = $woocommerce->cart;
	$cart_items = $cart->get_cart();
	foreach ( $cart_items as $key => $item ) {
		if ( (int)$item['quantity'] > 1 ) {
			$woocommerce->cart->set_quantity($key);
		}
	}
}