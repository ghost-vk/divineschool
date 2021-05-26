<?php
if ( wp_doing_ajax() ) { // Add ajax actions only when it necessary
	// Authentication user
	add_action( 'wp_ajax_authentication', 'authenticate_user' );
	add_action( 'wp_ajax_nopriv_authentication', 'authenticate_user' );
	
	// Authentication user
	add_action( 'wp_ajax_send_reset_link', 'send_reset_link' );
	add_action( 'wp_ajax_nopriv_send_reset_link', 'send_reset_link' );
	
	// Reset password
	add_action( 'wp_ajax_reset_password', 'reset_user_password' );
	add_action( 'wp_ajax_nopriv_reset_password', 'reset_user_password' );
}

/**
 * Authenticates user (need to reload page)
 */
function authenticate_user() {
	check_ajax_referer( 'divine_nonce', 'nonce' ); // Check nonce code
	
	$password = $_POST['password'];
	$email = $_POST['email'];
	$response = array(
		"action" => "reload",
	);
	
	if ( ! email_exists($email) ) {
		$response["message"] = "Такого пользователя не существует";
		$response["success"] = "not";
	} else {
		$signon = wp_signon( array(
			'user_login' => $email,
			'user_password' => $password,
			'remember' => true,
		));
		
		if ( ! is_wp_error( $signon ) ) { // If not error
			// Set cookies
			wp_clear_auth_cookie();
			clean_user_cache( $signon->ID );
			wp_set_current_user( $signon->ID );
			wp_set_auth_cookie( $signon->ID );
			update_user_caches( $signon );
			
			$response["message"] = "Добро пожаловать!";
			$response["success"] = "yes";
		} else {
			$response["message"] = "Введённые логин/пароль не верны";
			$response["success"] = "not";
		}
	}
	
	wp_send_json($response);
	wp_die();
}


/**
 * Send link to reset password
 */
function send_reset_link() {
	check_ajax_referer( 'divine_nonce', 'nonce' ); // Check nonce code
	$response = array();
	
	$email = $_POST['email'];
	$user = get_user_by( 'email', $email ); // Login = email
	
	if ( ! email_exists($email) || ! $user ) {
		$response["message"] = "Такого пользователя не существует $email";
	} elseif ( is_user_logged_in() ) {
		$response["message"] = "Вы уже авторизованы, перезагрузите страницу";
	} else {
		$name = $user->get('first_name');
		if ( ! $name ) {
			$name = 'Пользователь';
		}
		
		$key = get_password_reset_key($user);
		$rp_link = home_url() . "/?action=rp&key=$key&login=" . rawurlencode($email);
		
		$headers = array(
			'From: Divine University <support@divineschool.site>',
			'content-type: text/html',
			'reply-to: <support@divineschool.site>'
		);
		
		$mail_args = array(
			'name' => $name,
			'reset_link' => $rp_link,
			'site_name' => get_bloginfo('name'),
		);
		
		ob_start();
		include __DIR__ . "/../templates/emails/reset-password.php";
		$content = ob_get_clean();
		foreach ( $mail_args as $key => $value ) {
			if ( ! is_array( $value ) && ! is_object( $value ) ) {
				$search  = '{$' . $key . '}';
				$content = str_replace( $search, $value, $content );
			}
		}
		$message = $content;
		
		// Send email
		$is_send = wp_mail( $email, 'Восстановление пароля', $message, $headers );
		if ( $is_send === true ) {
			$response["message"] = "Ссылка для сброса пароля была выслана на email: " . $email;
		} else {
			$response["message"] = "Произошла ошибка, попробуйте ещё раз";
		}
	}
	
	wp_send_json($response);
	wp_die();
}


/**
 * Reset password
 */
function reset_user_password() {
	check_ajax_referer( 'divine_nonce', 'nonce' ); // Check nonce code
	$response = array(
		"action" => "reload",
	);
	
	$key = $_POST['key'];
	$login = $_POST['login'];
	$new_password = $_POST['password'];
	$response["key"] = $key;
	$response["login"] = $login;
	$response["password"] = $new_password;
	
	$user = check_password_reset_key( $key, $login );
	
	if ( ! is_wp_error($user) && isset($new_password) ) {
		$response["message"] = "Ваш пароль изменён!";
		$response["success"] = "yes";
		reset_password($user, $new_password);
		
		$signon = wp_signon(
			array(
				'user_login' => $login,
				'user_password' => $new_password,
				'remember' => true,
			)
		);
		
		if ( ! is_wp_error( $signon ) ) { // If not error
			// Set cookies
			wp_clear_auth_cookie();
			clean_user_cache( $signon->ID );
			wp_set_current_user( $signon->ID );
			wp_set_auth_cookie( $signon->ID );
			update_user_caches( $signon );
		}
	} else {
		$response["message"] = "Упс... Что-то пошло не так";
		$response["success"] = "no";
	}
	
	wp_send_json($response);
	wp_die();
}


/**
 * Get user full paid orders to display in user account
 * @return {Array} - product ids
 */
function get_user_paid_orders( $categories = ['course'] ) {
	$current_user = wp_get_current_user();
	if ( 0 == $current_user->ID ) {
		return [];
	}
	// GET USER ORDERS (COMPLETED + PROCESSING)
	$customer_orders = get_posts(
		array (
			'numberposts' => -1,
			'meta_key' => '_customer_user',
			'meta_value' => $current_user->ID,
			'post_type' => wc_get_order_types(),
			'post_status' => 'wc-completed',
		)
	);
	
	$product_ids = array();
	
	// LOOP THROUGH ORDERS AND GET PRODUCT IDS
	if ( ! $customer_orders ) {
		return $product_ids;
	}
	
	foreach ( $customer_orders as $customer_order ) {
		$order = wc_get_order($customer_order->ID);
		$wc_order_date = $order->get_date_completed();
		$order_date = $wc_order_date->date('Y-m-d H:i:s');
		$order_datetime_object = \DateTime::createFromFormat('Y-m-d H:i:s', $order_date);
		
		$items = $order->get_items();
		
		foreach ( $items as $item ) {
			
			$product_id = $item->get_product_id();
			$variation_id = $item->get_variation_id();
			$variation = new WC_Product_Variation($variation_id);
			$package_attr = $variation->attributes['pa_package']; // Display "package_<i>"
			
			if ( has_term($categories, 'product_cat', $product_id) ) {
				
				$now = new \DateTime('now');
				$count_from = get_field('countdown_from', $product_id);
				$count_day_access_group = get_field('count_day_access', $product_id);
				if ( ! empty($count_day_access_group) ) {
					$count_day_access = $count_day_access_group[ $package_attr ];
				} else {
					continue;
				}
				
				
				if ( 'date' === $count_from ) {
					$start_access = get_field('access_start_date', $product_id);
					$start_access_datetime = DateTime::createFromFormat('d/m/Y', $start_access);
					$end_access_datetime = $start_access_datetime->modify("+$count_day_access day");
					if ( $end_access_datetime < $now ) { // If course access ends
						continue;
					}
					$product_ids[] = array(
						'product_id' => $product_id,
						'variation_id' => $variation_id,
					);
				} else if ( 'purchase' === $count_from ) {
					$order_datetime_object->modify("+$count_day_access day");
					if ( $order_datetime_object < $now ) { // If course access ends
						continue;
					}
					$product_ids[] = array(
						'product_id' => $product_id,
						'variation_id' => $variation_id,
					);
				}
				
			}
		}
	}
	return $product_ids;
}





