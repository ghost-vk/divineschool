<?php
namespace Ghost\LidForm;
require_once __DIR__ . '/LidFormData.php';

class LidForm {
	protected $name;
	protected $phone;
	protected $email;
	protected $instagram;
	
	/**
	 * LidForm constructor.
	 *
	 * @param $insert_data
	 *
	 * Insert example:
	 * array(
	 *   'name' => 	'UserName',
	 *   'phone' => '89998887766',
	 *   'email' => 'qwerty@test.com'
	 *   'instagram' => '@divine_lash_university' || 'https://www.instagram.com/divine_lash_market/'
	 * )
	 */
	public function __construct($insert_data) {
		$this->name = ( $insert_data['name'] ) ? $insert_data['name'] : '';
		$this->phone = ( $insert_data['phone'] ) ? $insert_data['phone'] : '';
		$this->email = ( $insert_data['email'] ) ? $insert_data['email'] : '';
		$this->instagram = ( $insert_data['instagram'] ) ? $insert_data['instagram'] : '';
	}
	
	public function HandleForm() {
		$is_inserted = $this->Insert();
		return (bool) $is_inserted;
	}
	
	/*
	 * Method Insert
	 *
	 * Inserts data into database
	 *
	 * @returns boolean
	 */
	protected function Insert() {
		$dal = new LidFormData();
		return $dal->Add($this->name, $this->phone, $this->instagram, $this->email);
	}
}