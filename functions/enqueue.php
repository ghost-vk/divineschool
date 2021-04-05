<?php
// Styles
add_action('wp_enqueue_scripts', 'add_styles');
function add_styles() {
	wp_enqueue_style( 'main', get_template_directory_uri() . '/scss/main.css' );
	wp_enqueue_style( 'popup', get_template_directory_uri() . '/scss/popup.css' );
	
	if ( is_front_page() ) {
		wp_enqueue_style( 'home', get_template_directory_uri() . '/scss/home.css' );
		wp_enqueue_style( 'time-to', get_template_directory_uri() . '/node_modules/time-to/timeTo.css' );
		wp_enqueue_style( 'animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css' );
	}
	
	if ( is_page(
		[
			'privacy',
			'user-agreement'
		]
	) ) {
		wp_enqueue_style( 'document-page', get_template_directory_uri() . '/scss/page-document.css' );
	}
	
	if ( is_page(
		array(
			'cart',
			'checkout',
		)
	) ) {
		wp_enqueue_style( 'cart', get_template_directory_uri() . '/scss/cart.css' );
	}
	
	if ( is_page('user') ) {
		wp_enqueue_style( 'user-account', get_template_directory_uri() . '/scss/user-account.css' );
	}
	
	if ( is_product() ) {
		wp_enqueue_style( 'user-account', get_template_directory_uri() . '/scss/product.css' );
	}
}

// Scripts
add_action ('wp_enqueue_scripts', 'add_scripts');
function add_scripts () {
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
	wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/519fd0f28a.js', array(), null, true);
	wp_enqueue_script('user-popup-form', get_template_directory_uri() . '/js/popup-form.js', array('jquery'), null, true);
	wp_localize_script('user-popup-form', 'popupForm', array(
		'userAccountURL' => home_url('/user'),
		'nonce' => wp_create_nonce('user_nonce'),
		'url' => admin_url('admin-ajax.php'),
	));
	
	if ( is_front_page() ) {
		wp_enqueue_script('time-to', get_template_directory_uri() . '/node_modules/time-to/jquery.time-to.min.js', array('jquery'), null, true);
		wp_enqueue_script('homepage', get_template_directory_uri() . '/js/homepage.js', array('jquery', 'time-to'), null, true);
		
		$course = get_field('course_product_id');
		$course_product_id = $course[0];
		
		$start_string = get_field('start_datetime', $course_product_id);
		$start_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $start_string);
		$start_timestamp = $start_datetime->getTimestamp();
		
		wp_localize_script('homepage', 'countdown', array(
			'timeTo' => $start_timestamp,
		));
	}
	
	if ( is_page('checkout') ) {
		wp_dequeue_script('wc-checkout');
		wp_enqueue_script('checkout', get_template_directory_uri() . '/js/checkout.js', array('jquery'), null, true);
	}
}