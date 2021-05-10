<?php
// Get template for pages/posts
add_filter( 'template_include', 'include_my_template' );
function include_my_template( $template ) {
	if ( is_front_page() ) { // Homepage
		return __DIR__ . '/../pages/home.php';
	}

	if ( is_page( // Document page (privacy policy and user agreement)
		[
			'privacy',
			'user-agreement'
		]
	) ) {
		return __DIR__ . '/../pages/page-document.php';
	}

	if ( is_page('cart') ) { // Cart page
		return __DIR__ . '/../pages/cart.php';
	}

	if ( is_page('checkout') ) { // Checkout page
		return __DIR__ . '/../pages/checkout.php';
	}

	if ( is_page('user') ) { // User account
		return __DIR__ . '/../pages/user-account.php';
	}

	if ( is_page('user-admin') ) {
		return __DIR__ . '/../pages/user-admin.php';
	}

	return $template;
}