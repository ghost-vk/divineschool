<?php
global $course_product_id;
global $is_course_started;
global $package_names;

$packages = array();
$packages['names'] = array(
	1 => get_field( "package_1_name", $course_product_id ),
	2 => get_field( "package_2_name", $course_product_id ),
	3 => get_field( "package_3_name", $course_product_id ),
);
$package_names = $packages['names'];
$packages['buttons'] = array(
	1 => get_field( "package_1_btn_text", $course_product_id ),
	2 => get_field( "package_2_btn_text", $course_product_id ),
	3 => get_field( "package_3_btn_text", $course_product_id ),
);
$packages['images'] = array(
	1 => get_field( "package_1_image", $course_product_id ),
	2 => get_field( "package_2_image", $course_product_id ),
	3 => get_field( "package_3_image", $course_product_id ),
);
$packages['price'] = array();
$packages['id'] = array();

$product = wc_get_product( $course_product_id );
$variations = $product->get_available_variations('objects');
$i = 1;

require_once __DIR__ . '/../../ghost-plugins/prepayment-save-discount/Prepayment.php';
$prepayment_plugin = new \Ghost\Prepayment\Prepayment();
if ( $prepayment_plugin->IsPluginOn() ) {
	$prepayment_product_id = get_field('prepayment_product_id', 'options')[0];
}

foreach ( $variations as $variation ) {
	$package_attr = $variation->attributes['pa_package'];
	if ( ! $package_attr ) {
		continue;
	}
	
	$regular_price = (int)$variation->regular_price;
	if ( $regular_price > 0 ) {
		$regular_price = number_format( $regular_price, 0, '', ' ' );
	}
	
	$sale_price = (int)$variation->sale_price;
	if ( $sale_price > 0 ) {
		$sale_price = number_format( $sale_price, 0, '', ' ' );
	} else {
		$sale_price = false;
	}
	
	$packages['price'][$i] = array(
		'regular' => $regular_price,
		'sale' => $sale_price,
	);
	$packages['id'][$i] = $variation->get_id();
	$i += 1;
}

for ( $i = 1; $i <= 3; $i += 1 ) {
	$package_name = $packages['names'][$i];
	$package_index = $i;
	$sale_price = $packages['price'][$i]['sale'];
	$regular_price = $packages['price'][$i]['regular'];
	$btn_text = $packages['buttons'][$i];
	$bg_image = $packages['images'][$i];
	$is_started = $is_course_started;
	$package_id = $packages['id'][$i];
	require __DIR__ . '/package-card.php';
}
