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
	
	$menu[$woo][0] = 'Заказы';
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


/**
 * SVG support for WP
 */
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
	global $wp_version;
	$filetype = wp_check_filetype( $filename, $mimes );
	return array(
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	);
}, 10, 4 );

add_filter( 'upload_mimes', 'cc_mime_types' );
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_action( 'admin_head', 'fix_svg' );
function fix_svg() {
	echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}

/**
 * Add advanced settings
 */
if( function_exists('acf_add_options_page') ) {
	generate_booking_settings_page();
}
function generate_booking_settings_page() {
	$parent = acf_add_options_page(array(
		'page_title' 	=> 'Настройки сайта',
		'menu_title'	=> 'Настройки сайта',
		'menu_slug' 	=> 'general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> true,
		'position'	    => 1,
		'post_id'		=> 'general_settings',
		'update_button' => 'Обновить настройки',
		'updated_message' => 'Настройки обновлены',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Основные',
		'menu_title'	=> 'Основные',
		'capability'	=> 'edit_posts',
		'menu_slug' 	=> $parent['menu_slug'] . '-main',
		'parent_slug'	=> $parent['menu_slug'],
		'update_button' => $parent['update_button'],
		'updated_message' => $parent['updated_message'],
	));
}

/**
 * Works with logo
 */
add_action( 'login_head', 'my_custom_login_logo' );
add_action('add_admin_bar_menus', 'reset_admin_wplogo');
function my_custom_login_logo() {
	echo '
	<style type="text/css">
	h1 a {  background-image:url(' . get_bloginfo('template_directory') . '/images/logo.png) !important;  }
	</style>
	';
}

function reset_admin_wplogo(  ){
	remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
	
	add_action( 'admin_bar_menu', 'my_admin_bar_wp_menu', 10 );
}

function my_admin_bar_wp_menu( $wp_admin_bar ) {
	$wp_admin_bar->add_menu( array(
		'id'    => 'wp-logo',
		'title' => '<img style="max-width:30px;height:auto;" src="'. get_bloginfo('template_directory') .'/images/logo.png" alt="" >',
		'href'  => home_url(),
		'meta'  => array(
			'title' => 'О моем сайте',
		),
	) );
}

/**
 * Hide menus for site admins
 */
if ( current_user_can('edit_posts') && get_current_user_id() !== 1 ) {
	add_action('admin_init', 'remove_menus');
}
function remove_menus(){
	global $menu;
	error_log(print_r($menu, true), 0);
	// Sidebar menus
	remove_menu_page( 'index.php' );
	remove_menu_page( 'plugins.php' );
	remove_menu_page( 'upload.php' );
	remove_menu_page( 'themes.php' );
	remove_menu_page( 'users.php' );
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'options-general.php' );
//	remove_menu_page( 'cptui_main_menu' );
	remove_menu_page( 'EWD-UWPM-Options' );
	remove_menu_page( 'wp-mail-smtp' );
	remove_menu_page( 'edit.php?post_type=acf-field-group' );
//	remove_menu_page( 'wc-admin&path=/analytics/overview' );
	remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' );
	
	// Submenus WooCommerce
//	remove_submenu_page( 'woocommerce', 'wc-admin' );
	remove_submenu_page( 'woocommerce', 'yoomoney_api_menu' );
	remove_submenu_page( 'woocommerce', 'wc-admin&path=/customers' );
	remove_submenu_page( 'woocommerce', 'wc-reports' );
	remove_submenu_page( 'woocommerce', 'wc-settings' );
	remove_submenu_page( 'woocommerce', 'wc-status' );
	remove_submenu_page( 'woocommerce', 'wc-addons' );
	remove_submenu_page( 'woocommerce', 'inspire_checkout_fields_settings' );
	
	// Submenus WooCommerce Products
	remove_submenu_page( 'edit.php?post_type=product', 'post-new.php?post_type=product' );
	remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_cat&amp;post_type=product' );
	remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_tag&amp;post_type=product' );
	remove_submenu_page( 'edit.php?post_type=product', 'product_attributes');
}

/**
 * Changes footer text
 */
add_filter( 'admin_footer_text', 'admin_footer_copyright' );
function admin_footer_copyright() {
	return '<span class="footer-copyright">Сайт разработан <a href="https://api.whatsapp.com/send?phone=79019833133">ghost-vk</a></span>';
}