<?php
/*
Plugin Name: Woocommerce Minimum and Maximum Quantity
Plugin URI:  http://ashokg.in/
Description: Allow the site admin to enable the feature of minimum and maximum purchase of a particular product in each product.
Version: 2.0.3
Author: Ashok G
Text Domain: wcmmax
Author URI: http://ashokg.in

Copyright: © 208 Ashok G.
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


add_action('add_meta_boxes', 'wc_mmax_meta_box_create');
add_action('save_post', 'wc_mmax_save_meta_box');
function wc_mmax_meta_box_create()
{
    add_meta_box('wc_mmax_enable', __('Min Max Quantity', 'wcmmax'), 'wc_mmax_meta_box', 'product', 'side');
}

function wc_mmax_meta_box($post)
{
    wp_nonce_field('wc_mmax_cst_prd_nonce', 'wc_mmax_cst_prd_nonce');
    
    echo '<p>';
    echo '<label for="_wc_mmax_prd_opt_enable" style="float:left; width:50px;">' . __('Enable', 'wcmmax') . '</label>';
    echo '<input type="hidden" name="_wc_mmax_prd_opt_enable" value="0" />';
    echo '<input type="checkbox" id="_wc_mmax_prd_opt_enable" class="checkbox" name="_wc_mmax_prd_opt_enable" value="1" ' . checked(get_post_meta($post->ID, '_wc_mmax_prd_opt_enable', true), 1, false) . ' />';
    echo '</p>';
    echo '<p>';
    $max = get_post_meta($post->ID, '_wc_mmax_max', true);
    $min = get_post_meta($post->ID, '_wc_mmax_min', true);
    echo '<label for="_wc_mmax_min" style="float:left; width:50px;">' . __('Min Quantity', 'wcmmax') . '</label>';
    echo '<input type="number" id="_wc_mmax_min" class="short" name="_wc_mmax_min" value="' . $min . '" />';
    echo '</p>';
    echo '<p>';
    echo '<label for="_wc_mmax_max" style="float:left; width:50px;">' . __('Max Quantity', 'wcmmax') . '</label>';
    echo '<input type="number" id="_wc_mmax_max" class="short" name="_wc_mmax_max" value="' . $max . '" />';
    echo '</p>';
    
}

function wc_mmax_save_meta_box($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!isset($_POST['_wc_mmax_prd_opt_enable']) || !wp_verify_nonce($_POST['wc_mmax_cst_prd_nonce'], 'wc_mmax_cst_prd_nonce'))
        return;
    update_post_meta($post_id, '_wc_mmax_prd_opt_enable', (int) $_POST['_wc_mmax_prd_opt_enable']);
    update_post_meta($post_id, '_wc_mmax_max',(int) $_POST['_wc_mmax_max']);
    update_post_meta($post_id, '_wc_mmax_min', (int) $_POST['_wc_mmax_min']);
}



function wc_mmax_remove_loop_button()
{
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
}
add_action('init', 'wc_mmax_remove_loop_button');


add_action('woocommerce_after_shop_loop_item', 'wc_mmax_replace_add_to_cart');
function wc_mmax_replace_add_to_cart()
{
    global $product;
    $link = $product->get_permalink();
    echo '';
}


/*Function to manipulate custom minimum and maximum purchase*/
add_filter('woocommerce_quantity_input_args', 'wc_mmax_quantity_input_args', 10, 2);
function wc_mmax_quantity_input_args($args, $product)
{
if(function_exists('icl_object_id')) {
	$default_language = wpml_get_default_language();
	$prodid = icl_object_id($product->get_id(), 'product', true, $default_language);
} else {
    $prodid = $product->get_id();
}
    $mmaxEnable = get_post_meta($prodid, '_wc_mmax_prd_opt_enable', true);
    $minQty     = get_post_meta($prodid, '_wc_mmax_min', true);
    $maxQty     = get_post_meta($prodid, '_wc_mmax_max', true);
    if ($minQty > 0 && $maxQty > 0 && $mmaxEnable == 1) {
        $args['min_value'] = $minQty; // Starting value
        $args['max_value'] = $maxQty; // Ending value
    }
 return $args;
   
}
/*Function to check weather the maximum quantity is already existing in the cart*/

add_action('woocommerce_add_to_cart', 'wc_mmax_custom_add_to_cart',10,2);

function wc_mmax_custom_add_to_cart($args,$product)
{
	$orderQTY = $_POST['quantity'];
    $mmaxEnable = get_post_meta($product, '_wc_mmax_prd_opt_enable', true);
    $minQty     = get_post_meta($product, '_wc_mmax_min', true);
    $maxQty     = get_post_meta($product, '_wc_mmax_max', true);
$cartQty =  wc_mmax_woo_in_cart($product);
	
if($maxQty < $cartQty && $mmaxEnable == 1)
{
echo "
<script>
alert('".__('You have already added the maximum Quantity for the product for the current purchase','wcmax')."');
location.href='". get_permalink($product)."';
</script>";

exit();
}

if(($orderQTY + $cartQty)  < $minQty && $mmaxEnable == 1)
{
echo "
<script>
alert('".__('Je potrebné objednať minimálne '.$minQty.' MJ.','wcmax')."');
location.href='". get_permalink($product)."';
</script>";

exit();
}

}

function wc_mmax_woo_in_cart($product_id) {
    global $woocommerce;
    foreach($woocommerce->cart->get_cart() as $key => $val ) {
	
        $_product = $val['data'];
        if($product_id == $_product->get_id()) {

		
 	    return  $val['quantity'];
	
        }
    }
 
    return 0;
}
