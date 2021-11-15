<?php
/**
 * Team Member Class.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Team_Member_Type' ) ) {
    class Kata_Plus_Pro_Team_Member_Type {
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
		 * @var     Kata_Plus_Pro_Team_Member_Type
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
			self::$dir = Kata_Plus_Pro::$dir . 'includes/post-types/team-member/';
            self::$url = Kata_Plus_Pro::$url . 'includes/post-types/team-member/';
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
			Kata_Plus_Pro_Autoloader::load( self::$dir, 'main', 'team-member' );
        }
	}

	Kata_Plus_Pro_Team_Member_Type::get_instance();
}