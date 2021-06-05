<?php
/**
 * Imports right template for post/page
 */
require_once __DIR__ . '/functions/get-template.php';


/**
 * Imports styles
 */
require_once __DIR__ . '/functions/enqueue.php';


/**
 * Admin features
 */
require_once __DIR__ . '/functions/utils-admin.php';


/**
 * Utils
 */
require_once __DIR__ . '/functions/utils.php';


/**
 * User account functions
 * Login, reset password
 */
require_once __DIR__ . '/functions/user-account.php';


/**
 * Removes repeated products in cart
 */
require_once  __DIR__ . '/functions/cart-actions.php';


/**
 * Changes checkout fields
 */
require_once __DIR__ . '/functions/checkout.php';


/**
 * Payment hooks
 */
require_once __DIR__ . '/functions/payment-hook.php';

/**
 * Prepayment plugin
 */
require_once __DIR__ . '/ghost-plugins/prepayment-save-discount/prepayment-plugin.php';