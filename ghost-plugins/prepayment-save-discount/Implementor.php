<?php
namespace Ghost\Prepayment;

require_once __DIR__ . '/DataAccessLayer.php';

class Implementor {
	public function Implement($user_id, $implement_type = 'raw') {
		if ( ! in_array($implement_type, ['raw', 'with-links']) ){
			return false;
		}
		
		$discount_products = [];
		
		$dal = new DataAccessLayer();
		$raw = $dal->Read($user_id);
		
		switch ($implement_type) {
			case ('raw') : {
				$discount_products = $raw;
				break;
			}
			case ('with-links') : {
				break;
			}
			default : {
				return false;
			}
		}
		
		return $discount_products;
	}
}