<?php
// Styles
add_action('wp_enqueue_scripts', 'add_styles');
function add_styles() {
	$directory = get_stylesheet_directory_uri();
	
	// General styles, loads for each page
	wp_enqueue_style( 'main', $directory . '/scss/main.css?v=1.0.1' );
	wp_enqueue_style( 'general', $directory . '/scss/general/general.css?v=1.0.1' );
	wp_enqueue_style( 'popup', $directory . '/scss/popup.css?v=1.0.1' );
	
	// Homepage
	if ( is_front_page() ) {
		wp_enqueue_style( 'homepage', $directory . '/scss/homepage/main.css?v=1.0.1' );
	}
	
	// Document page
	if ( is_page(
		[
			'privacy',
			'user-agreement'
		]
	) ) {
		wp_enqueue_style( 'document-page', $directory . '/scss/page-document.css?v=1.0.1' );
	}
	
	// Cart, Checkout, Thank you
	if ( is_page(
		array(
			'cart',
			'checkout',
		)
	) ) {
		wp_enqueue_style( 'cart', $directory . '/scss/cart.css?v=1.0.1' );
	}
	
	// User account
	if ( is_page('user') ) {
		wp_enqueue_style( 'user-account', $directory . '/scss/user-account.css?v=1.0.1' );
	}
	
	// Course page template
	if ( is_product() ) {
		wp_enqueue_style( 'user-account', $directory . '/scss/product.css?v=1.0.1' );
	}
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
	wp_enqueue_script('utils-divine', $directory . '/js/lib/Utils.js?v=1.0.1', array(), null, true);
	wp_enqueue_script('store', $directory . '/js/store/store.js?v=1.0.1', array('utils-divine'), null, true);
	wp_enqueue_script('notification', $directory . '/js/lib/Notification.js?v=1.0.1', array(), null, true);
	wp_enqueue_script('cookie-notification', $directory . '/js/lib/NotificationCookie.js?v=1.0.1', array('js-cookie'), null, true);
	wp_enqueue_script('header', $directory . '/js/components/header.js?v=1.0.1', array(), null, true);
	wp_enqueue_script('user-popup-form', $directory . '/js/popup-form.js?v=1.0.1', array('jquery'), null, true);
	
	wp_localize_script('store', 'appSettings', array(
		'userAccountURL' => home_url('/user'),
		'nonce' => wp_create_nonce('divine_nonce'),
		'url' => admin_url('admin-ajax.php'),
	));
	
	// Homepage
	if ( is_front_page() ) {
		wp_enqueue_script('flipdown', $directory . '/js/flipdown/flipdown.js?v=1.0.1', array(), null, true);
		wp_enqueue_script('homepage', $directory . '/js/components/homepage.js?v=1.0.1', array('jquery', 'flipdown', 'notification'), null, true);
		
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
		wp_enqueue_script('checkout', $directory . '/js/checkout.js?v=1.0.1', array('jquery'), null, true);
	}
}