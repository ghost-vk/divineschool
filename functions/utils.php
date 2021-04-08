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


use PHPMailer\PHPMailer\PHPMailer;

/**
 * Set SMTP
 *
 * @param PHPMailer $phpmailer
 */
add_action( 'phpmailer_init', 'send_smtp_email' );
function send_smtp_email( PHPMailer $phpmailer ) {
	if ( defined('SMTP_USER') && defined('SMTP_PASS') ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = SMTP_HOST;
		$phpmailer->SMTPAuth   = SMTP_AUTH;
		$phpmailer->Port       = SMTP_PORT;
		$phpmailer->Username   = SMTP_USER;
		$phpmailer->Password   = SMTP_PASS;
		$phpmailer->SMTPSecure = SMTP_SECURE;
		$phpmailer->From       = SMTP_FROM;
		$phpmailer->FromName   = SMTP_NAME;
	}
}

/**
 * Allow additional redirect hosts
 */
add_filter( 'allowed_redirect_hosts', 'allow_redirect_hosts' );
function allow_redirect_hosts( $hosts ) {
	$my_hosts = array(
		'www.paypal.com',
	);
	return array_merge( $hosts, $my_hosts );
}
