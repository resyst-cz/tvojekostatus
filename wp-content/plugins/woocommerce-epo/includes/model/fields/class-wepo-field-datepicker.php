<?php
/**
 * Custom product field Date Picker data object.
 *
 * @link       https://epo.localhost
 * @since      2.3.0
 *
 * @package    woocommerce-epo
 * @subpackage woocommerce-epo/includes/model/fields
 */
if(!defined('WPINC')){	die; }

if(!class_exists('WEPO_Product_Field_DatePicker')):

class WEPO_Product_Field_DatePicker extends WEPO_Product_Field{
	public $pattern = array(			
			'/d/', '/j/', '/l/', '/z/', '/S/', //day (day of the month, 3 letter name of the day, full name of the day, day of the year, )			
			'/F/', '/M/', '/n/', '/m/', //month (Month name full, Month name short, numeric month no leading zeros, numeric month leading zeros)			
			'/Y/', '/y/' //year (full numeric year, numeric year: 2 digit)
		);
		
	public $replace = array(
			'dd','d','DD','o','',
			'MM','M','m','mm',
			'yy','y'
		);
		
	public $default_date = '';
	public $date_format = '';
	public $min_date = '';
	public $max_date = '';
	public $year_range = '';
	public $number_of_months = '';
	public $disabled_days = array();
	public $disabled_dates = array();
	
	public function __construct() {
		$this->type = 'datepicker';
	}	
		
	/*public function get_html(){
		$price_data = $this->get_price_data();
		$input_class = $this->price_field ? 'epo-price-field' : '';
		$value = apply_filters( 'epo_product_extra_option_value_'.$this->name, $this->value );
		$value = isset($_POST[$this->name]) ? $_POST[$this->name] : $value;
		
		$field_props  = 'placeholder="'. $this->__wepo($this->placeholder) .'"';
		$field_props .= ' value="'.$value.'"';
		$field_props .= ' class="epo-input-field epo-date-picker '.$input_class.'"';
		$field_props .= $price_data;
		$field_props .= ' data-date-format="'.$this->date_format.'" data-default-date="'. $this->default_date .'"';
		$field_props .= ' data-min-date="'. $this->min_date .'" data-max-date="'. $this->max_date .'"';
		$field_props .= ' data-year-range="'. $this->year_range .'" data-number-months="'. $this->number_of_months .'"';
		$field_props .= ' data-disabled-days="'. $this->disabled_days .'" data-disabled-dates="'. $this->disabled_dates .'"';
		
		$input_html  = '<input type="text" id="'. $this->name .'" name="'. $this->name .'" '. $field_props .' "/>';
		
		$html = $this->prepare_field_html($input_html);
		return $html;
	}
	
	public function get_jquery_date_format($woo_date_format){				
		$woo_date_format = !empty($woo_date_format) ? $woo_date_format : wc_date_format();
		return preg_replace($this->pattern, $this->replace, $woo_date_format);	
	}
	
   
	public function get_date_format(){
		return empty($this->date_format) ? $this->get_jquery_date_format(wc_date_format()) : $this->date_format;
	}
	public function get_year_range(){
		return empty($this->year_range) ? '-100:+1' : $this->year_range;
	}
	public function get_number_of_months(){
		return empty($this->number_of_months) ? 1 : $this->number_of_months;
	}*/
}

endif;