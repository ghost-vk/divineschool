<?php
namespace Ghost\LidForm;

class LidFormData {
	/**
	 * Method Add record to database
	 *
	 * @param string $name
	 * @param string $phone
	 * @param string $email
	 * @param string $instagram
	 *
	 * @return bool
	 */
	public function Add($name, $phone, $email, $instagram) {
		global $wpdb;
		$query = "INSERT INTO `lids` (`name`, `phone`, `instagram`, `email`) VALUES (%s, %s, %s, %s);";
		$result = $wpdb->query($wpdb->prepare($query, $name, $phone, $email, $instagram));
		
		return boolval($result);
	}
	
	public function GetLids() {
		global $wpdb;
		$query = "SELECT * FROM `lids`";
		return $wpdb->get_results($query, 'OBJECT');
	}
	
	public function IsOn() {
		$lid_form_work_status = get_field('_prepayment_status', 'options');
		switch ($lid_form_work_status) {
			case ('on') : {
				return true;
			}
			default : {
				return false;
			}
		}
	}
	
	public function GetDiscount() {
		return get_field('lid_form_discount', 'options');
	}
}