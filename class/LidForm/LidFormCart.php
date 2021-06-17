<?php
namespace Ghost\LidForm;
require_once __DIR__ . '/LidFormData.php';

class LidFormCart {
	public $discount;
	
	public function __construct() {
		if (isset($_COOKIE['DISCOUNT_FOR_LID']) && $_COOKIE['DISCOUNT_FOR_LID'] === 'true') {
			$this->discount = (new LidFormData())->GetDiscount();
			add_action('woocommerce_before_calculate_totals', array( $this, 'SetAppliedCoupon' ), 20, 1);
			add_action('woocommerce_get_shop_coupon_data', array($this, 'SetCouponData'), 20, 3);
		}
	}
	
	public function SetAppliedCoupon(\WC_Cart $cart) {
		$cart_items = $cart->get_cart();
		
		foreach ( $cart_items as $item ) {
			$product_id = $item['data']->get_id();
			$product = wc_get_product($product_id);
			$categories = $product->get_category_ids();
			if ( ! empty($categories) ) {
				$term = get_term_by( 'id', $categories[0], 'product_cat', 'ARRAY_A' );
				$slug = $term['slug'];
				if ( $slug === 'prepayment' ) { // Discount only for full payment product
					return;
				}
			}
		}
		
		$cart->applied_coupons = array_diff($cart->applied_coupons, ['lid-discount']);
		$cart->applied_coupons[] = 'lid-discount';
	}
	
	public function SetCouponData($false, $data, $coupon) {
		switch($data) {
			case 'lid-discount':
				$coupon->set_virtual(true);
				$coupon->set_discount_type('fixed_cart');
				$coupon->set_amount($this->discount);
				
				return $coupon;
		}
	}
}