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
 * Function clears cart. Used for save only one element in cart.
 * @param $cart_items
 */
add_action('clear_cart', 'clear_cart_from_second_one', 10, 1);
function clear_cart_from_second_one($cart_items) {
	if ( count($cart_items) === 1 ) {
		return;
	}
	global $woocommerce;
	$i = 1;
	$count = count($cart_items);
	foreach ( $cart_items as $cart_item_key => $item ) {
		if ( $i === $count ) { // Last one
			break;
		}
		$woocommerce->cart->remove_cart_item($cart_item_key);
		$i += 1;
	}
}