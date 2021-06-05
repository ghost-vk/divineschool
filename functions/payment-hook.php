<?php
/**
 * This hooks turn status complete for every order upon payment.
 */
add_filter( 'woocommerce_order_item_needs_processing', 'need_processing_false_filter' );
// See class-wc-order line 1368 to understand the return value
function need_processing_false_filter() {
	return false;
}

/**
 * Register user and send login data after payment
 */
add_action( 'woocommerce_order_status_completed', 'register_user_after_payment' );
function register_user_after_payment( $order_id ) {
	$WC_Order = new WC_Order($order_id);
	if ( ! $WC_Order ) {
		error_log("Can't get WC_Order object", 0);
		return;
	}
	
	$email = $WC_Order->get_billing_email();
	if ( ! $email ) {
		error_log("Email was not set in Order", 0);
		return;
	}
	
	$name = $WC_Order->get_billing_first_name();
	if ( ! $name ) {
		$name = 'Пользователь';
	}
	
	$password = wp_generate_password(12, false, false); // Random password
	
	if ( email_exists($email) ) { // Already registered user
		return;
	} else {
		$new_user_id = wp_insert_user(
			array (
				'user_login' => $email,
				'user_email' => $email,
				'user_pass' => $password,
			)
		);
		
		$headers = array(
			'From: Divine University <support@divineschool.site>',
			'content-type: text/html',
			'reply-to: <support@divineschool.site>'
		);
		
		if ( ! is_wp_error( $new_user_id ) ) { // If not error
			update_user_meta( $new_user_id, 'first_name', $name );
			update_post_meta( $order_id, '_customer_user', $new_user_id );
			
			$mail_args = array(
				'email' => $email,
				'name' => $name,
				'password' => $password,
				'login_link' => home_url('/?login=true'),
			);
			
			ob_start();
			include __DIR__ . "/../templates/emails/new-user.php";
			$content = ob_get_clean();
			foreach ( $mail_args as $key => $value ) {
				if ( ! is_array( $value ) && ! is_object( $value ) ) {
					$search  = '{$' . $key . '}';
					$content = str_replace( $search, $value, $content );
				}
			}
			$message = $content;
			
			wp_mail($email, 'Ваш аккаунт успешно создан', $message, $headers);
		} else {
			return;
		}
	}
}