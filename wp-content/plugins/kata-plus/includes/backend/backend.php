<?php

/**
 * Backend Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}
if (!class_exists('Kata_Plus_Backend')) {
	class Kata_Plus_Backend
	{
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
		 * @var     Kata_Plus_Backend
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance()
		{
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
		public function __construct()
		{
			$this->definitions();
			$this->actions();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions()
		{
			self::$dir = Kata_Plus::$dir . 'includes/backend/';
			self::$url = Kata_Plus::$url . 'includes/backend/';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
		}

		/**
		* Enqueue Admin Scripts
		*
		* @since     1.0.0
		*/
		public function admin_enqueue_scripts () {
			wp_enqueue_script('kata-plus-sweet-alert', Kata_Plus::$assets . 'js/libraries/sweetalert.js', ['jquery'], Kata_plus::$version, true);
			wp_enqueue_script('kata-plus-admin-js', Kata_Plus::$assets . 'js/backend/admin.js', ['jquery'], Kata_plus::$version, true);
		}

	}
	Kata_Plus_Backend::get_instance();
}
