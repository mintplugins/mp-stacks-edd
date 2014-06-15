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
	
	wp_reset_query();
	
	global $post, $edd_options;
	
	$vars = shortcode_atts( array(
		'button_color' => NULL,
		'button_text_color' => NULL,
		'button_hover_color' => NULL,
		'button_hover_text_color' => NULL
	), $atts );
	
	//Assemble the button CSS
	$button_css = '<style scoped>';
	
		$button_css .= '.mp_stacks_edd_purchase_link_' . $post->ID . '{';
		
			$button_css .= 'background-color:' . $vars['button_color'] . '!important;';
		
		$button_css .= '}';
		
		$button_css .= '.mp_stacks_edd_purchase_link_' . $post->ID . ' .edd-add-to-cart-label{';
			
			$button_css .= 'color:' . $vars['button_text_color'] . '!important;';
			
		$button_css .= '}';
		
		$button_css .= '.mp_stacks_edd_purchase_link_' . $post->ID . ':hover{';
		
			$button_css .= 'background-color:' . $vars['button_hover_color'] . '!important;';
		
		$button_css .= '}';
		
		$button_css .= '.mp_stacks_edd_purchase_link_' . $post->ID . ':hover .edd-add-to-cart-label{';
		
			$button_css .= 'color:' . $vars['button_hover_text_color'] . '!important;';
		
		$button_css .= '}';
	
	$button_css .= '</style>';

	//Assemble the array to get the buy link
	$atts['class'] = 'mp_stacks_edd_purchase_link_' . $post->ID;
	$atts['download_id'] = $post->ID;
	
	//Make sure this is actually a download
	$download = edd_get_download( $atts['download_id'] );

	if ( $download ) {
		return edd_get_purchase_link( $atts ) . $button_css;
	}
	
}
add_shortcode( 'mp_stacks_edd_purchase_link', 'mp_stacks_edd_shortcode' );