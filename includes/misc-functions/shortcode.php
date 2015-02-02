<?php 
/**
 * This file contains the shortcode function used to show a download using the paren't post id
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Edd
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2014, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * Show "Insert Shortcode" above posts
 */
function mp_stacks_edd_show_insert_shortcode(){
		
	$args = array(
		'shortcode_id' => 'mp_stacks_edd_purchase_link',
		'shortcode_title' => __('Download in Brick', 'mp_stacks'),
		'shortcode_description' => __( 'Use the form below to insert a download into a brick\'s text area:', 'mp_stacks' ),
		'shortcode_icon_spot' => true,
		'shortcode_options' => array(
			array(
				'option_id' => 'button_text',
				'option_title' => __( 'Button Text', 'mp_stacks_edd' ),
				'option_description' => __( 'What should the button say? (Default: "Buy Now")', 'mp_stacks_edd' ),
				'option_type' => 'textbox',
				'option_value' => '',
			),
			array(
				'option_id' => 'button_color',
				'option_title' => __( 'Button Color', 'mp_stacks_edd' ),
				'option_description' => __( 'Choose the color to use for the button', 'mp_stacks_edd' ),
				'option_type' => 'colorpicker',
				'option_value' => '',
			),
			array(
				'option_id' => 'button_text_color',
				'option_title' => __( 'Button Text Color', 'mp_stacks_edd' ),
				'option_description' => __( 'Choose the color to use for text on the button', 'mp_stacks_edd' ),
				'option_type' => 'colorpicker',
				'option_value' => '',
			),
			array(
				'option_id' => 'button_hover_color',
				'option_title' => __( 'Mouse-Over Button Color', 'mp_stacks_edd' ),
				'option_description' => __( 'Choose the color to use for the button when the mouse is over it', 'mp_stacks_edd' ),
				'option_type' => 'colorpicker',
				'option_value' => '',
			),
			array(
				'option_id' => 'button_hover_text_color',
				'option_title' => __( 'Mouse-Over Button Text Color', 'mp_stacks_edd' ),
				'option_description' => __( 'Choose the color to use for text on this button when the mouse is over it', 'mp_stacks_edd' ),
				'option_type' => 'colorpicker',
				'option_value' => '',
			),
		)
	); 
		
	//Shortcode args filter
	$args = has_filter('mp_stacks_edd_insert_shortcode_args') ? apply_filters('mp_stacks_edd_insert_shortcode_args', $args) : $args;
	
	new MP_CORE_Shortcode_Insert($args);	
}
add_action('init', 'mp_stacks_edd_show_insert_shortcode');
 
/**
 * This function hooks to the brick output. If it is supposed to be a 'eddcart', then it will output the eddcart
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_edd_shortcode($atts){
	
	global $wp_query, $edd_options;
	
	$vars = shortcode_atts( array(
		'button_color' => NULL,
		'button_text' => __( 'Buy Now', 'mp_stacks_edd' ),
		'button_text_color' => NULL,
		'button_hover_color' => NULL,
		'button_hover_text_color' => NULL
	), $atts );
	
	//Assemble the button CSS
	$button_css = '<style scoped>';
	
		$button_css .= '.mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . '{';
		
			$button_css .= 'background-color:' . $vars['button_color'] . '!important;';
		
		$button_css .= '}';
		
		$button_css .= '.mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . ' .edd-add-to-cart-label{';
			
			$button_css .= 'color:' . $vars['button_text_color'] . '!important;';
			
		$button_css .= '}';
		
		$button_css .= '.mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . ':hover{';
		
			$button_css .= 'background-color:' . $vars['button_hover_color'] . '!important;';
		
		$button_css .= '}';
		
		$button_css .= '.mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . ':hover .edd-add-to-cart-label{';
		
			$button_css .= 'color:' . $vars['button_hover_text_color'] . '!important;';
		
		$button_css .= '}';
	
	$button_css .= '</style>';

	//Assemble the array to get the buy link
	$atts['class'] = 'mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id;
	$atts['download_id'] = $wp_query->queried_object_id;
	
	//Make sure this is actually a download
	$download = edd_get_download( $atts['download_id'] );
	
	$button_text = !empty( $vars['button_text'] ) ? edd_price( $wp_query->queried_object_id, false ) . ' - ' . $vars['button_text'] : edd_price( $wp_query->queried_object_id, false );

	if ( $download ) {
		
		//If the MP EDD All Access plugin exists, check if the user has all access here
		if ( function_exists( 'mp_edd_all_access_textdomain' ) ){
			
			//Check if this user has all access priveleges
			$all_access = mp_all_access_check();
			
			//If the user does NOT have all access
			if ( !$all_access ){
				return '<a href="' . edd_get_checkout_uri() . '?edd_action=add_to_cart&download_id=' . $wp_query->queried_object_id . '" class="edd-add-to-cart button mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . ' edd-has-js" data-action="edd_add_to_cart" data-download-id="' . $wp_query->queried_object_id . '" data-variable-price="no" data-price-mode="single" data-edd-loading="">
			<span class="edd-add-to-cart-label">' . $button_text . '</span> <span class="edd-loading" style="margin-left: 0px; margin-top: 0px;">
			<i class="edd-icon-spinner edd-icon-spin"></i>
			</span></a>
			<a href="' . edd_get_checkout_uri() . '" class="edd_go_to_checkout button mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . '" style="display: none;">' . __( 'Checkout', 'mp_stacks_edd' ) . '</a>' . $button_css;
			}
			//If this user DOES have all access
			else{
				
				//Get price
				$price = get_post_meta( $wp_query->queried_object_id, 'edd_price', true );
				
				$exluded_download_ids = mp_core_get_option( 'mp_edd_all_access_settings_general',  'mp_all_access_download_exclude' );
				$exluded_download_ids = explode(',', preg_replace('/\s+/', '', $exluded_download_ids) );
				
				//If this product is excluded from all access
				if ( in_array( $wp_query->queried_object_id, $exluded_download_ids ) ){
					//Return the normal button
					return $purchase_form;	
				}
				//If this post is included in All Access
				else{
					
					//Get deliverable file
					$deliverable_file = get_post_meta( $wp_query->queried_object_id, 'edd_download_files', true );
					
					//return a button that links to the deliverable in a new window
					return '<a class="button edd-free-download-btn" target="_blank" href="' . add_query_arg( array( 'mp_all_access_download' => $wp_query->queried_object_id ),  get_bloginfo( 'wpurl' ) ) . '">' . __( 'Download', 'mp_edd_all_access' ) . '</a>';	
				}
				
			}
			
		}
		//If the MP EDD All Access plugin is not activated/installed
		else{
		 	
			//Give the user the normal "Buy" Button.
			return '<a href="' . edd_get_checkout_uri() . '" class="edd-add-to-cart button mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . ' edd-has-js" data-action="edd_add_to_cart" data-download-id="' . $wp_query->queried_object_id . '" data-variable-price="no" data-price-mode="single" data-edd-loading="">
			<span class="edd-add-to-cart-label">' . $button_text . '</span> <span class="edd-loading" style="margin-left: 0px; margin-top: 0px;">
			<i class="edd-icon-spinner edd-icon-spin"></i>
			</span></a>
			<a href="' . edd_get_checkout_uri() . '" class="edd_go_to_checkout button mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id . '" style="display: none;">' . __( 'Checkout', 'mp_stacks_edd' ) . '</a>' . $button_css;
		}
		
	}
	
}
add_shortcode( 'mp_stacks_edd_purchase_link', 'mp_stacks_edd_shortcode' );