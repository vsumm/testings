<?php
/*
 * WPS Menu Exporter
 * Author URI: https://wpserveur.net
 * 1.3.2
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Plugin constants
define( 'WPS_MENU_EXPORTER_VERSION', '1.3.2' );
define( 'WPS_MENU_EXPORTER_FOLDER', 'wps-menu-exporter' );
define( 'WPS_MENU_EXPORTER_BASENAME', plugin_basename( __FILE__ ) );

define( 'WPS_MENU_EXPORTER_URL', plugin_dir_url( __FILE__ ) );
define( 'WPS_MENU_EXPORTER_DIR', plugin_dir_path( __FILE__ ) );

require_once WPS_MENU_EXPORTER_DIR . 'autoload.php';

if ( ! function_exists( 'plugins_loaded_wps_menu_exporter_plugin' ) ) {
	add_action( 'plugins_loaded', 'plugins_loaded_wps_menu_exporter_plugin' );
	function plugins_loaded_wps_menu_exporter_plugin() {
		\WPS\WPS_Menu_Exporter\Plugin::get_instance();
	}
}