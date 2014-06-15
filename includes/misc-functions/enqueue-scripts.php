<?php
/**
 * Make the mp_stacks_edd_purchase_link shortcode display the shortcode preview in tinymce
 *
 * @since   1.0.0
 * @link    http://mintplugins.com/doc/
 * @param   array $plugin_array See link for description.
 * @return  array $plugin_array
 */
function mp_stacks_edd_add_stacks_tinymce_plugin($plugin_array) {
 	if ( get_user_option('rich_editing') == 'true') {
		$plugin_array['mpstacksedd'] =  plugins_url( '/js/', dirname(__FILE__) ) . 'mp-stacks-edd-tinymce.js';
	}
    return $plugin_array;
}
add_filter("mce_external_plugins", "mp_stacks_edd_add_stacks_tinymce_plugin");

/**
 * Set the Shortcode "representor" in TINYMCE upon insert
 *
 * @since   1.0.0
 * @link    http://mintplugins.com/doc/
 * @param   array $plugin_array See link for description.
 * @return  array $plugin_array
 */
function mp_stacks_edd_call_stacks_tiny_mce_plugin_on_insert($plugin_array) {
	echo "tinyMCE.activeEditor.execCommand('MP_Stacks_Edd');";
}
add_action('mp_core_shortcode_' . 'mp_stacks_edd_purchase_link' . '_insert_event', 'mp_stacks_edd_call_stacks_tiny_mce_plugin_on_insert' );

/**
 * Add mp_stack_edd stylesheet to the TinyMCE styles
 *
 * @since    1.0.0
 * @link     http://codex.wordpress.org/Function_Reference/add_editor_style
 * @see      get_bloginfo()
 * @param    array $wp See link for description.
 * @return   void
 */
function mp_stacks_edd_addTinyMCELinkClasses( $wp ) {	
	add_editor_style( plugins_url( '/css/', dirname(__FILE__) ) . 'mp-stacks-edd-tinyMCE-style.css' ); 
}
add_action( 'mp_core_editor_styles', 'mp_stacks_edd_addTinyMCELinkClasses' );