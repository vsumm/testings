<?php
/**
 * Menu Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Menu' ) ) {
	class Kata_Plus_Pro_Menu {

		/**
		 * The directory of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $dir;

		/**
		 * The directory of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $ptdir;

		/**
		 * The url of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $url;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Menu
		 */
		public static $instance;

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
		 * Constructor.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			$this->definitions();
			$this->dependencies();
			// add_filter( 'get_user_option_metaboxhidden_nav-menus', [$this,'default_menu_metaboxes'], 10, 3 );
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir   = Kata_Plus_Pro::$dir . 'includes/menu/';
			self::$ptdir = Kata_Plus_Pro::$dir . 'includes/post-types/';
			self::$url   = Kata_Plus_Pro::$url . 'includes/menu/';
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			Kata_Plus_Pro_Autoloader::load( self::$ptdir . 'mega-menu', 'mega-menu' );
		}

		/**
		 * Menu Metaboxes.
		 *
		 * @since   1.0.0
		 */
		public function default_menu_metaboxes( $result, $option, $user ) { 
			if( in_array( 'add-post-type-kata_mega_menu', $result ) ) {
				return $result = array_diff( $result, array( 'add-post-type-kata_mega_menu' ) );
			}
		}
	}

	Kata_Plus_Pro_Menu::get_instance();
}
