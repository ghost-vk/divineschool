<?php
require_once __DIR__ . '/LidForm.php';
require_once __DIR__ . '/LidFormCart.php';
require_once __DIR__ . '/AdminLids.php';

if ( wp_doing_ajax() ) {
	add_action( 'wp_ajax_save_lid', 'save_lid');
	add_action( 'wp_ajax_nopriv_save_lid', 'save_lid');
}

$_admin_lids = new \Ghost\LidForm\AdminLids();
$_cart_listener = new \Ghost\LidForm\LidFormCart();
$_admin_lids->ShowLids();

/**
 * Function save lid to database
 */
function save_lid() {
	check_ajax_referer( 'divine_nonce', 'nonce' ); // Check nonce code
	
	$data_for_save = array(
		'name' => $_POST['name'],
		'phone' => $_POST['phone'],
		'email' => $_POST['email'],
		'instagram' => $_POST['instagram'],
	);
	$lf = new \Ghost\LidForm\LidForm($data_for_save);
	$is_saved = $lf->HandleForm();
	$status = ( $is_saved ) ? 'success' : 'fail';
	
	wp_send_json(array( 'status' => $status ));
	wp_die();
}

/**
 * Function deletes cookie which set by js
 * when success filled form
 */
function delete_lid_form_cookie() {
	if ( is_user_logged_in() && isset($_COOKIE['DISCOUNT_FOR_LID'])) {
		setcookie('DISCOUNT_FOR_LID', null, -1, '/');
	}
}
delete_lid_form_cookie();