<?php

/**
 * Compatibility Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Compatibility' ) ) {
	class Kata_Plus_Compatibility {
		/**
		 * The directory of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $dir;

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
		 * @var     Kata_Plus_Compatibility
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance() {
			if (self::$instance === null) {
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
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir = Kata_Plus::$dir . 'includes/compatiblity/';
			self::$url = Kata_Plus::$url . 'includes/compatiblity/';
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			if ( is_plugin_active( 'learnpress/learnpress.php' ) ) {
				Kata_Plus_Autoloader::load( self::$dir, 'class-kata-plus-learnpress-compatibility' );
			}
			if ( is_plugin_active( 'mailpoet/mailpoet.php' ) && is_admin() ) {
				add_filter('mailpoet_conflict_resolver_whitelist_style', function ( $whitelistedStyles ) {
					$whitelistedStyles[] = 'kata-plus';
					return $whitelistedStyles;
				});
	
				add_filter('mailpoet_conflict_resolver_whitelist_script', function ($whitelistedScripts) {
					$whitelistedScripts[] = 'kata-plus';
					return $whitelistedScripts;
				});
			}
		}

	}
	Kata_Plus_Compatibility::get_instance();
}
