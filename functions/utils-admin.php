<?php
/**
 * Removes comments from WP
 */
add_action('admin_init', function () {
// Redirect any user trying to access comments page
	global $pagenow;
	
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}

// Remove comments metabox from dashboard
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

// Disable support for comments and trackbacks in post types
	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page and posts page
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
	remove_menu_page('edit.php');
});

// Remove comments tab from top admin bar
add_action( 'wp_before_admin_bar_render', 'my_admin_bar_render' );
function my_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}

/**
 * Removes marketing tab
 */
function filter_woocommerce_admin_get_feature_config( $feature_config ) {
	$feature_config['marketing'] = false;
	return $feature_config;
}
add_filter( 'woocommerce_admin_get_feature_config', 'filter_woocommerce_admin_get_feature_config', 10, 1 );

// http://www.php.net/manual/en/function.array-search.php#91365
function recursive_array_search_php_91365( $needle, $haystack ) {
	foreach( $haystack as $key => $value ) {
		$current_key = $key;
		if ( $needle === $value
			OR (
				is_array( $value )
				&& recursive_array_search_php_91365( $needle, $value ) !== false
			)
		) {
			return $current_key;
		}
	}
	return false;
}

/**
 * Renames WooCommerce tabs
 */
add_action( 'admin_menu', 'rename_woocoomerce_wpse_100758', 999 );
function rename_woocoomerce_wpse_100758() {
	global $menu;
	
	$woo = recursive_array_search_php_91365( 'WooCommerce', $menu );
	$products_tab_name = recursive_array_search_php_91365( 'Товары', $menu );
	if( !$woo ) {
		return;
	}
	
	$menu[$woo][0] = 'Настройки магазина';
	$menu[$products_tab_name][0] = 'Курсы';
	
}

/**
 * Removes metabox fields from WooCommerce admin product cards panel
 */
add_action('add_meta_boxes', 'remove_product_metabox', 999);
function remove_product_metabox() {
	remove_meta_box( 'postexcerpt', 'product', 'normal'); // Short description
	remove_meta_box( 'tagsdiv-product_tag', 'product', 'side' ); // Product tags
	remove_meta_box( 'woocommerce-product-images',  'product', 'side'); // Products gallery
}

/**
 * Removes unused product data tabs
 */
add_filter('woocommerce_product_data_tabs', 'remove_tab', 10, 1);
function remove_tab ($tabs) {
	unset($tabs['inventory']); // it is to remove inventory tab
	unset($tabs['linked_product']); // it is to remove linked_product tab
	unset($tabs['shipping']); // it is to remove shipping tab
	
	return($tabs);
}

/**
 * Support WooCommerce for custom theme
 */
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );