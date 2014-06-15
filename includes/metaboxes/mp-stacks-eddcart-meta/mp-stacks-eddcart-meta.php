<?php
/**
 * This page contains functions for modifying the metabox for eddcart as a media type
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks Edd
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2014, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Add EddCart as a Media Type to the dropdown
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @param    array $args See link for description.
 * @return   void
 */
function mp_stacks_edd_create_meta_box(){	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_stacks_edd_add_meta_box = array(
		'metabox_id' => 'mp_stacks_edd_metabox', 
		'metabox_title' => __( '"EDD Cart" Content-Type', 'mp_stacks_edd'), 
		'metabox_posttype' => 'mp_brick', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' 
	);
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_stacks_edd_items_array = array(
		array(
			'field_id'			=> 'eddcart_icon_color',
			'field_title' 	=> __( 'Cart Icon Color', 'mp_stacks_edd'),
			'field_description' 	=> __( 'Select the color you want the cart icon to be', 'mp_stacks_edd' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_font_size',
			'field_title' 	=> __( 'Cart\'s Text Size', 'mp_stacks_edd'),
			'field_description' 	=> __( 'Enter the size the text inside the cart should be (Pixels)', 'mp_stacks_edd' ),
			'field_type' 	=> 'number',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_font_color',
			'field_title' 	=> __( 'Cart\'s Text Color', 'mp_stacks_edd'),
			'field_description' 	=> __( 'Enter the color the text inside the cart should be (Pixels)', 'mp_stacks_edd' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_show_borders',
			'field_title' 	=> __( 'Show Lines Between Cart Items?', 'mp_stacks_edd'),
			'field_description' 	=> __( 'Should there be separating lines between items the customer has added to the cart?', 'mp_stacks_edd' ),
			'field_type' 	=> 'checkbox',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_border_color',
			'field_title' 	=> __( 'Line Colors', 'mp_stacks_edd'),
			'field_description' 	=> __( 'What color should the separating lines be?', 'mp_stacks_edd' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_checkout_btn_color',
			'field_title' 	=> __( 'Checkout Button Color', 'mp_stacks_edd'),
			'field_description' 	=> __( 'What color should the Checkout Button be?', 'mp_stacks_edd' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_checkout_btn_text_color',
			'field_title' 	=> __( 'Checkout Button Text Color', 'mp_stacks_edd'),
			'field_description' 	=> __( 'What color should the Checkout Button\'s Text be?', 'mp_stacks_edd' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_checkout_btn_mouseover_color',
			'field_title' 	=> __( 'Mouse-Over Checkout Button Color', 'mp_stacks_edd'),
			'field_description' 	=> __( 'What color should the Checkout Button be when the mouse is over it?', 'mp_stacks_edd' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'eddcart_checkout_btn_mouseover_text_color',
			'field_title' 	=> __( 'Mouse-Over Checkout Button Text Color', 'mp_stacks_edd'),
			'field_description' 	=> __( 'What color should the Checkout Button\'s Text be when the mouse is over it?', 'mp_stacks_edd' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '',
		),
		
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_stacks_edd_add_meta_box = has_filter('mp_stacks_edd_meta_box_array') ? apply_filters( 'mp_stacks_edd_meta_box_array', $mp_stacks_edd_add_meta_box) : $mp_stacks_edd_add_meta_box;
	
	//Globalize the and populate mp_stacks_features_items_array (do this before filter hooks are run)
	global $global_mp_stacks_edd_items_array;
	$global_mp_stacks_edd_items_array = $mp_stacks_edd_items_array;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_stacks_edd_items_array = has_filter('mp_stacks_edd_items_array') ? apply_filters( 'mp_stacks_edd_items_array', $mp_stacks_edd_items_array) : $mp_stacks_edd_items_array;
	
	/**
	 * Create Metabox class
	 */
	global $mp_stacks_edd_meta_box;
	$mp_stacks_edd_meta_box = new MP_CORE_Metabox($mp_stacks_edd_add_meta_box, $mp_stacks_edd_items_array);
}
add_action('widgets_init', 'mp_stacks_edd_create_meta_box');