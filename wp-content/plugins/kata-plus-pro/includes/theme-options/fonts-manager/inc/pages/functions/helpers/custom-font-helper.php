<?php

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

if ( ! class_exists( 'Kata_plus_FontsManager_Add_New_Font_Custom_Font_Helper' ) ) :
	/**
	* Kata_plus_FontsManager_Add_New_Font_Custom_Font_Helper.
	*
	* @author	ClimaxThemes
	* @package	Kata Plus
	* @since	1.0.0
	*/
	class Kata_plus_FontsManager_Add_New_Font_Custom_Font_Helper {

		/**
        * Instance of this class.
        *
        * @since     1.0.0
        * @access     private
        * @var     Kata_plus_FontsManager_Add_New_Font_Custom_Font_Helper
        */
        private static $instance;

        /**
         * Provides access to a single instance of a module using the singleton pattern.
         *
         * @since   1.0.0
         * @return	object
         */
        public static function get_instance() {
            if ( self::$instance === null ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

		/**
        * Define the core functionality of the FontsManager_Add_New_Page_Presenter.
        *
        * Load the dependencies.
        *
        * @since     1.0.0
        */
        function __construct() {
        }


		 /**
		 * Scripts
		 *
		 * @since     1.0.0
		 */
		public function scripts () {
			wp_enqueue_script( 'postbox' );
			wp_enqueue_script( 'kata-plus-fonts-manager-listnav', Kata_Plus::$assets . '/js/libraries/jquery-listnav.js', null, Kata_Plus_Pro::$version, true );
			wp_add_inline_script( 'kata-plus-fonts-manager-listnav', "
			jQuery(function(){
				postboxes.add_postbox_toggles();
			});
			" );
		}

	} //Class
	Kata_plus_FontsManager_Add_New_Font_Custom_Font_Helper::get_instance();
endif;