<?php

namespace Ghost\Prepayment;

class DataAccessLayer {
	private string $meta_key = '_prepayment_discount';
	
	/**
	 * You can rewrite that method
	 * method should return { true | false }
	 * @returns { Boolean }
	 */
	public function IsPluginOn() {
		$switcher = get_field('_prepayment_status', 'options');
		switch ($switcher) {
			case ('on') : {
				return true;
			}
			default : {
				return false;
			}
		}
	}
	
	public function Create($user_id, $product_prices) {
		return update_user_meta($user_id, $this->meta_key, $product_prices);
	}
	
	public function RemoveDiscount($user_id) {
		return delete_user_meta($user_id, $this->meta_key);
	}
	
	public function Read($user_id) {
		return get_user_meta($user_id, $this->meta_key);
	}
	
	/**
	 * Method should be hooked on 'woocommerce_after_register_post_type'
	 * @param $product_id Prepayment product ID
	 *
	 * @return array
	 */
	public function GetPartiallyPaidProducts($product_id) {
		$raw = get_field('_prepayment_products', $product_id);
		$data = [];
		if ( empty($raw) ) {
			return $data;
		}
		$prepayment_amount = wc_get_product($product_id)->get_regular_price();
		foreach ( $raw as $id ) {
			$product = wc_get_product($id);
			$regular_price = $product->get_regular_price();
			$sale_price = $product->get_sale_price();
			$price_to_save = ( $sale_price ) ? $sale_price : $regular_price;
			$price_to_save = (int)$price_to_save - (int)$prepayment_amount;
			$data[] = array(
				'id' => $id,
				'price' => $price_to_save
			);
		}
		return $data;
	}
}