<?php
/**
 * Recipes Class.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Recipes' ) ) {
    class Kata_Plus_Pro_Recipes {
		/**
		 * The directory of the file.
		 *
		 * @access	public
		 * @var		string
		 */
		public static $dir;

		/**
		 * The url of the file.
		 *
		 * @access	public
		 * @var		string
		 */
		public static $url;

		/**
		 * Instance of this class.
         *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Recipes
		 */
		public static $instance;

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
		 * Constructor.
		 *
		 * @since	1.0.0
		 */
		public function __construct() {
            $this->definitions();
			$this->actions();
			$this->dependencies();
		}

		/**
		 * Global definitions.
		 *
		 * @since	1.0.0
		 */
		public function definitions() {
			self::$dir = Kata_Plus_Pro::$dir . 'includes/post-types/recipes/';
            self::$url = Kata_Plus_Pro::$url . 'includes/post-types/recipes/';
		}

		/**
		 * Add actions.
		 *
		 * @since	1.0.0
		 */
		public function actions() {
		}

		/**
		 * Load dependencies.
		 *
		 * @since	1.0.0
		 */
		public function dependencies() {
			Kata_Plus_Pro_Autoloader::load( self::$dir, 'main', 'recipes' );
        }
	}

	Kata_Plus_Pro_Recipes::get_instance();
}