<?php

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

if ( ! class_exists( 'Kata_plus_FontsManager_Add_New_Google_Helper' ) ) :
	/**
	 * Kata_plus_FontsManager_Add_New_Google_Helper.
	 *
	 * @author     author
	 * @package     package
	 * @since     1.0.0
	 */
	class Kata_plus_FontsManager_Add_New_Google_Helper {

		public static $fonts_list;

		/**
		 * Instance of this class.
		 *
		 * @since     1.0.0
		 * @access     private
		 * @var     Kata_plus_FontsManager_Add_New_Google_Helper
		 */
		private static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
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
			$this->definitions();
			$this->scripts();
		}

		 /**
		  * Description
		  *
		  * @since     1.0.0
		  */
		public function definitions() {
			$response = wp_remote_get(
				'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBOOsgUB12UtiN0m4IBv0DsDMx1_SHp57s',
				array(
					'timeout'     => 10
				)
			);


			if(isset($response->errors )) {
				static::$fonts_list = json_decode( file_get_contents( Kata_Plus::$assets_dir . 'json/google-webfonts.json' ) )->items;
			} else {
				static::$fonts_list = json_decode($response['body'] )->items;
			}
			if ( isset( $_GET['cat'] ) && trim( $_GET['cat'] ) ) {
				$fonts_list = [];
				$_CAT       = isset( $_GET['cat'] ) ? explode( ',', $_GET['cat'] ) : [];
				if ( $_CAT ) {
					foreach ( static::$fonts_list as $cat ) {
						if ( in_array( $cat->category, $_CAT ) ) {
							$fonts_list[] = $cat;
						}
					}
				} else {
					$fonts_list = static::$fonts_list;
				}
				static::$fonts_list = $fonts_list;
			}
		}

		 /**
		  * Scripts
		  *
		  * @since     1.0.0
		  */
		public function scripts() {
			wp_add_inline_script(
				'postbox',
				'
				var kataGoogleFontsList = ' . json_encode( static::$fonts_list ) . ';
				jQuery(function(){
					postboxes.add_postbox_toggles();
				});
				'
			);
			wp_enqueue_script( 'postbox' );
		}

	} //Class
	Kata_plus_FontsManager_Add_New_Google_Helper::get_instance();
endif;
