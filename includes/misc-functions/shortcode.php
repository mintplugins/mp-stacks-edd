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
function mp_stacks_edd_show_insert_shortcode( $post_type ){

	if ( $post_type != 'mp_brick' ){
		return;
	}

	$args = array(
		'shortcode_id' => 'mp_stacks_edd_purchase_link',
		'shortcode_title' => __('Download in Brick', 'mp_stacks'),
		'shortcode_description' => __( 'Use the form below to insert a download into a brick\'s text area:', 'mp_stacks' ),
		'shortcode_icon_spot' => true,
		'shortcode_icon_dashicon_class' => 'dashicons-download', //Grab this from https://developer.wordpress.org/resource/dashicons/#info
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
add_action('mp_core_shortcode_setup', 'mp_stacks_edd_show_insert_shortcode');

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
	global $mp_stacks_edd_footer_css;
	$mp_stacks_edd_footer_css .= '<style scoped>';

		$mp_stacks_edd_footer_css .= '#edd_purchase_' . $wp_query->queried_object_id . ' .edd-add-to-cart{';

			$mp_stacks_edd_footer_css .= 'background-color:' . $vars['button_color'] . '!important;';

		$mp_stacks_edd_footer_css .= '}';

		$mp_stacks_edd_footer_css .= '#edd_purchase_' . $wp_query->queried_object_id . ' .edd-add-to-cart .edd-add-to-cart-label{';

			$mp_stacks_edd_footer_css .= 'color:' . $vars['button_text_color'] . '!important;';

		$mp_stacks_edd_footer_css .= '}';

		$mp_stacks_edd_footer_css .= '#edd_purchase_' . $wp_query->queried_object_id . ' .edd-add-to-cart:hover{';

			$mp_stacks_edd_footer_css .= 'background-color:' . $vars['button_hover_color'] . '!important;';

		$mp_stacks_edd_footer_css .= '}';

		$mp_stacks_edd_footer_css .= '#edd_purchase_' . $wp_query->queried_object_id . ' .edd-add-to-cart:hover .edd-add-to-cart-label{';

			$mp_stacks_edd_footer_css .= 'color:' . $vars['button_hover_text_color'] . '!important;';

		$mp_stacks_edd_footer_css .= '}';

	$mp_stacks_edd_footer_css .= '</style>';

	//Assemble the array to get the buy link
	$atts['class'] = 'mp_stacks_edd_purchase_link_' . $wp_query->queried_object_id;
	$atts['download_id'] = $wp_query->queried_object_id;

	//Make sure this is actually a download
	$download = edd_get_download( $atts['download_id'] );

	$button_text = !empty( $vars['button_text'] ) ? edd_price( $wp_query->queried_object_id, false ) . ' - ' . $vars['button_text'] : edd_price( $wp_query->queried_object_id, false );

	$button_behavior = edd_get_download_button_behavior( $wp_query->queried_object_id );

	$args = apply_filters( 'edd_purchase_link_defaults', array(
		'download_id' => $wp_query->queried_object_id,
		'direct'      => $button_behavior == 'direct' ? true : false,
		'text' 		  => $vars['button_text']
	) );

	return edd_get_purchase_link( $args );
}
add_shortcode( 'mp_stacks_edd_purchase_link', 'mp_stacks_edd_shortcode' );

//Create the custom CSS for this button for colors
function mp_stacks_edd_footer_css(){

	global $mp_stacks_edd_footer_css;

	echo $mp_stacks_edd_footer_css;
}
add_action( 'wp_footer', 'mp_stacks_edd_footer_css' );
