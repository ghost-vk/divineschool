<?php
// Styles
add_action('wp_enqueue_scripts', 'add_styles');
function add_styles() {
	$directory = get_stylesheet_directory_uri();
	
	// General styles, loads for each page
	wp_enqueue_style( 'vendor', $directory . '/dist/442.css' );
	wp_enqueue_style( 'main', $directory . '/dist/main.css', 'vendor' );
}

// Scripts
add_action ('wp_enqueue_scripts', 'add_scripts');
function add_scripts () {
	$directory = get_stylesheet_directory_uri();
	
	/**
	 * General scripts, loads for each page
	 */
	// CDN Vendor
	wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/519fd0f28a.js', array(), null, true);
	
	// Local Vendor
	wp_enqueue_script('smooth-scroll', $directory . '/node_modules/smooth-scroll/dist/smooth-scroll.polyfills.min.js',
		array(), null, true);
	wp_enqueue_script('js-cookie', $directory . '/node_modules/js-cookie/src/js.cookie.js', array(), null, true);
	
	// Local scripts
	wp_enqueue_script('utils-divine', $directory . '/js/lib/Utils.js?v=1.0.2', array(), null, true);
	wp_enqueue_script('store', $directory . '/js/store/store.js?v=1.0.2', array('utils-divine'), null, true);
	wp_enqueue_script('notification', $directory . '/js/lib/Notification.js?v=1.0.2', array(), null, true);
	wp_enqueue_script('cookie-notification', $directory . '/js/lib/NotificationCookie.js?v=1.0.2', array('js-cookie'), null, true);
	wp_enqueue_script('header', $directory . '/js/components/header.js?v=1.0.2', array(), null, true);
	wp_enqueue_script('user-popup-form', $directory . '/js/popup-form.js?v=1.0.2', array('jquery'), null, true);
	
	wp_localize_script('store', 'appSettings', array(
		'userAccountURL' => home_url('/user'),
		'nonce' => wp_create_nonce('divine_nonce'),
		'url' => admin_url('admin-ajax.php'),
	));
	
	// Homepage
	if ( is_front_page() ) {
		wp_enqueue_script('flipdown', $directory . '/js/flipdown/flipdown.js?v=1.0.2', array('jquery'), null, true);
		wp_enqueue_script( 'viewport-checker', $directory
			. '/node_modules/jquery-viewport-checker/src/jquery.viewportchecker.js', array('jquery'), null, true );
		wp_enqueue_script('homepage', $directory . '/js/components/homepage.js?v=1.0.2',
			array('flipdown', 'notification', 'viewport-checker'), null, true);
		
		$course_product_id = get_field('course_product_id')[0];
		$start_string = get_field('start_datetime', $course_product_id);
		$start_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $start_string);
		wp_localize_script('store', 'countdownTimer', array(
			'timeTo' => $start_datetime->getTimestamp(),
		));
	}
	
	// Checkout
	if ( is_page('checkout') ) {
		wp_dequeue_script('wc-checkout');
		wp_enqueue_script('checkout', $directory . '/js/checkout.js?v=1.0.2', array('jquery'), null, true);
	}
}