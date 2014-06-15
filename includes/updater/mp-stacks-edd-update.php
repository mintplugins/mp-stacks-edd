<?php
/**
 * This file contains the function keeps the MP Stacks Edd plugin up to date.
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
 * Check for updates for the MP Stacks Edd Plugin by creating a new instance of the MP_CORE_Plugin_Updater class.
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
 if (!function_exists('mp_stacks_edd_update')){
	function mp_stacks_edd_update() {
		$args = array(
			'software_name' => 'MP Stacks + Edd', //<- The exact name of this Plugin. 
			'software_api_url' => 'http://mintplugins.com',//The URL where EddCart and mp_stacks-eddcart are installed and checked
			'software_filename' => 'mp-stacks-edd.php',
			'software_licensed' => false, //<-Boolean
		);
		
		//Since this is a plugin, call the Plugin Updater class
		$mp_stacks_edd_plugin_updater = new MP_CORE_Plugin_Updater($args);
	}
 }
add_action( 'admin_init', 'mp_stacks_edd_update' );
