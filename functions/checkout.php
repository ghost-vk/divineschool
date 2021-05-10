<?php

/**
 * Unset unused field,
 * changes fields data
 */
add_filter( 'woocommerce_checkout_fields', 'change_checkout_fields', 25 );
function change_checkout_fields( $fields ) {
	
	// unset( $fields[ 'billing' ][ 'billing_first_name' ] ); // имя
	// unset( $fields[ 'billing' ][ 'billing_last_name' ] ); // фамилия
	// unset( $fields[ 'billing' ][ 'billing_phone' ] ); // телефон
	// unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл
	//	unset( $fields[ 'billing' ][ 'billing_city' ] ); // город
	
	unset( $fields[ 'billing' ][ 'billing_company' ] ); // компания
	unset( $fields[ 'billing' ][ 'billing_country' ] ); // страна
	unset( $fields[ 'billing' ][ 'billing_address_1' ] ); // адрес 1
	unset( $fields[ 'billing' ][ 'billing_address_2' ] ); // адрес 2
	unset( $fields[ 'billing' ][ 'billing_state' ] ); // регион, штат
	unset( $fields[ 'billing' ][ 'billing_postcode' ] ); // почтовый индекс
	unset( $fields[ 'order' ][ 'order_comments' ] ); // заметки к заказу
	
	$fields[ 'billing' ][ 'billing_city' ]['label'] = 'Город';
	$fields[ 'billing' ][ 'billing_phone' ]['label'] = 'Номер телефона';
	
	return $fields;
}


/**
 * WooCommerce - Modify each individual input type $args defaults
 **/

add_filter('woocommerce_form_field_args','wc_form_field_args',10,3);

function wc_form_field_args( $args, $key, $value = null ) {
	/**
	 * This is not meant to be here, but it serves as a reference
	 * of what is possible to be changed.
	 **/
	
	/**
	 * $defaults = array(
	 * 'type'              => 'text',
	 * 'label'             => '',
	 * 'description'       => '',
	 * 'placeholder'       => '',
	 * 'maxlength'         => false,
	 * 'required'          => false,
	 * 'id'                => $key,
	 * 'class'             => array(),
	 * 'label_class'       => array(),
	 * 'input_class'       => array(),
	 * 'return'            => false,
	 * 'options'           => array(),
	 * 'custom_attributes' => array(),
	 * 'validate'          => array(),
	 * 'default'           => '',
	 * );
	 */

	// Start field type switch case
	
	switch ( $args['type'] ) {
		
		case "select" :  /* Targets all select input type elements, except the country and state select input types */
			$args['class'][] = 'form-group'; // Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag
			$args['input_class'] = array('form-control', 'input-lg'); // Add a class to the form input itself
			//$args['custom_attributes']['data-plugin'] = 'select2';
			$args['label_class'] = array('control-label');
			$args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  ); // Add custom data attributes to the form input itself
			break;
		
		case 'country' : /* By default WooCommerce will populate a select with the country names - $args defined for this specific input type targets only the country select element */
			$args['class'][] = 'form-group single-country';
			$args['label_class'] = array('control-label');
			break;
		
		case "state" : /* By default WooCommerce will populate a select with state names - $args defined for this specific input type targets only the country select element */
			$args['class'][] = 'form-group'; // Add class to the field's html element wrapper
			$args['input_class'] = array('form-control', 'input-lg'); // add class to the form input itself
			//$args['custom_attributes']['data-plugin'] = 'select2';
			$args['label_class'] = array('control-label');
			$args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  );
			break;
		
		
		case "password" :
		case "text" :
		case "email" :
		case "tel" :
		case "number" :
			$args['class'][] = 'form-group';
			//$args['input_class'][] = 'form-control input-lg'; // will return an array of classes, the same as bellow
			$args['input_class'] = array('form-control', 'input-lg');
			$args['label_class'] = array('control-label');
			break;
		
		case 'textarea' :
			$args['input_class'] = array('form-control', 'input-lg');
			$args['label_class'] = array('control-label');
			break;
		
		case 'checkbox' :
			break;
		
		case 'radio' :
			break;
		
		default :
			$args['class'][] = 'form-group';
			$args['input_class'] = array('form-control', 'input-lg');
			$args['label_class'] = array('control-label');
			break;
	}
	
	return $args;
}