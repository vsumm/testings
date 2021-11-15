<?php
/**
 * Theme Options Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Theme_Options' ) ) {
	class Kata_Plus_Pro_Theme_Options {
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
		 * This is kata option name where all the Redux data is stored.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $opt_name;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Theme_Options
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
			$this->config();
			$this->actions();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir      = Kata_Plus_Pro::$dir . 'includes/theme-options/';
			self::$url      = Kata_Plus_Pro::$url . 'includes/theme-options/';
			self::$opt_name = 'kata_plus_theme_options';
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			// Options
			Kata_Plus_Pro_Autoloader::load(
				self::$dir . 'options',
				[
					'api',
					'custom-codes',
					'gdpr',
					'maintenance-mode',
					'performance',
					'preloader',
					'scroll',
					'white-label',
					'add-google-fonts',
				],
				'',
				'options'
			);

			// Functions
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions', 'theme-options-functions' );
			// Font Manager
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'fonts-manager', 'main' );
			// Customizer Search
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'plugins/customizer-search', 'customizer-search' );
			// Elementor Optimizer Class
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions', 'class-kata-elementor-optimizer' );
			// Class HTML Minify
			if ( true == get_theme_mod( 'kata_wordpress_performance_minify_html', false ) ) {
				Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions', 'class-kata-plus-pro-minify-html' );
			}
			// CSS & JS Minify
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions', 'class-kata-plus-pro-minifier' );

			// Browser Caching
			if ( true == get_theme_mod( 'kata_plus_pro_leverage_browser_caching', false ) ) {
				Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions', 'class-kata-plus-pro-leverage-browser-caching' );
			}
			// GZIP
			if ( true == get_theme_mod( 'kata_plus_pro_gzip', false ) ) {
				Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions', 'class-kata-plus-pro-gzip' );
			}
	
		}

		/**
		 * Configuration redux framework.
		 *
		 * @since   1.0.0
		 */
		public function config() {
			Kirki::add_config(
				self::$opt_name,
				[
					'capability'  => Kata_Plus_Pro_Helpers::capability(),
					'option_type' => 'theme_mod',
				]
			);
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'customize_register', [$this, 'change_wp_customizer'], 100 );
			add_action( 'current_screen', array( $this, 'current_screen' ) );
		}

		/**
		 * Current Screen
		 *
		 * @since   1.0.0
		 */
		public static function current_screen() {
			return get_current_screen()->base;
		}

		/**
		 * Change Customizer Default panels order
		 *
		 * @since   1.0.0
		 */
		public function change_wp_customizer( $wp_customize ) {
			$site_identitiy_section = $wp_customize->get_section( 'title_tagline' );
			if ( $site_identitiy_section ) {
				$site_identitiy_section->priority = 0;
			}

			$static_front_page_section = $wp_customize->get_section( 'static_front_page' );
			if ( $static_front_page_section ) {
				$static_front_page_section->priority = 2;
			}

			$nav_panel = $wp_customize->get_panel( 'nav_menus' );
			if ( $nav_panel ) {
				$nav_panel->priority = 7;
			}

			$widgets_panel = $wp_customize->get_panel( 'widgets' );
			if ( $widgets_panel ) {
				$widgets_panel->priority = 8;
			}
			$wp_customize->remove_section('kata_add_google_fonts_section');
			$wp_customize->remove_control('kata_add_google_font_repeater');
			$wp_customize->remove_setting('kata_add_google_font_repeater');
		}
	}

	Kata_Plus_Pro_Theme_Options::get_instance();
}
