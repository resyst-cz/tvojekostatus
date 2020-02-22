<?php
/**
 * Custom product field Input Tel data object.
 *
 * @link       https://epo.localhost
 * @since      2.3.0
 *
 * @package    woocommerce-epo
 * @subpackage woocommerce-epo/includes/model/fields
 */
if(!defined('WPINC')){	die; }

if(!class_exists('WEPO_Product_Field_Tel')):

class WEPO_Product_Field_Tel extends WEPO_Product_Field{
	public function __construct() {
		$this->type = 'tel';
	}
}

endif;