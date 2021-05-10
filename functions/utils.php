<?php
/**
 * Display site title
 */
add_theme_support( 'title-tag' );


/**
* Detect mobile users
* @return false|int
*/
function is_mobile() {
	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

/**
 * Allow additional redirect hosts
 */
add_filter( 'allowed_redirect_hosts', 'allow_redirect_hosts' );
function allow_redirect_hosts( $hosts ) {
	$my_hosts = array(
		'www.paypal.com',
		'www.sandbox.paypal.com',
	);
	return array_merge( $hosts, $my_hosts );
}


/**
 * Displays package description from product page (course)
 * @param $package_index {Integer}
 * @param $course_product_id {Integer}
 */
function display_package_description( $package_index, $course_product_id ) {
	if ( have_rows( 'package_' . $package_index . '_description', $course_product_id ) ) {
		while ( have_rows( 'package_' . $package_index . '_description', $course_product_id ) ) {
			the_row();
			echo '<li>' . get_sub_field('text') . '</li>';
		}
	}
}

/**
 * Function redirects logged user to user cabinet
 */
add_action('redirect_to_user_account', 'redirect_to_user_account', 10, 0);
function redirect_to_user_account() {
	if ( current_user_can('administrator') ) {
		return;
	}
	if ( is_user_logged_in() ) {
		header("Location: " . home_url('/user'));
	}
}

add_action('redirect_non_admin', 'redirect_non_admin', 10, 0);
function redirect_non_admin () {
	if ( ! is_user_logged_in() || ! current_user_can('administrator') ) {
		header("Location: " . home_url('/?login=true'));
	}
}

