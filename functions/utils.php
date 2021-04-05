<?php
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
