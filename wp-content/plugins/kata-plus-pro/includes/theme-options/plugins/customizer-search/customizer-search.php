<?php
/**
 * Customizer Search
 * https://github.com/Nikschavan/customizer-search
 * Search for settings in customizer.
 * Brainstorm Force
 * https://www.brainstormforce.com/
 * customizer-search
 * 1.1.6
 *
 * @package Customizer_Search
 */

define( 'BSFCS_VER', '1.1.6' );
define( 'BSFCS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BSFCS_URL', plugins_url( '/', __FILE__ ) );
define( 'BSFCS_PATH', plugin_basename( __FILE__ ) );

/**
 * Load the plugin.
 */
require_once 'class-customizer-search.php';

if ( is_admin() ) {
	// Admin Notice Library Settings.
	require_once 'lib/notices/class-astra-notices.php';
}