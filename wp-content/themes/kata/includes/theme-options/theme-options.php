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

if ( ! class_exists( 'Kata_Theme_Options' ) ) {
	class Kata_Theme_Options {
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
		 * @var     Kata_Theme_Options
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
			if ( class_exists('Kata_Plus') ) {
				return;
			}
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
			self::$dir      = kata::$dir . 'includes/theme-options/';
			self::$url      = kata::$url . 'includes/theme-options/';
			self::$opt_name = 'Kata_theme_options';
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			// Options
			kata_Autoloader::load(
				self::$dir . 'options',
				[
					'header',
					'container',
					'site-identity',
					'customizer-page',
					'footer',
					'add-google-fonts',
					'styling',
					'blog',
				],
				'',
				'options'
			);

			// Functions
			kata_Autoloader::load( self::$dir . 'functions', 'theme-options-functions' );
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
					'capability'  => kata_Helpers::capability(),
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
			add_action( 'admin_enqueue_scripts', [$this, 'enqueue_styles'] );
			add_action( 'current_screen', array( $this, 'current_screen' ) );
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function enqueue_styles() {
			if ( 'customize' === self::current_screen() ) {
				wp_enqueue_style( 'kata-customizer', Kata::$assets . '/css/customizer.css', array(), Kata::$version );
			}
		}

		/**
		 * Current Screen
		 *
		 * @since   1.0.0
		 */
		public static function current_screen() {
			return get_current_screen()->base;
		}

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
			add_action( 'wp_footer', [$this, 'customizer_inline_style'] );
		}
		public function customizer_inline_style() {
			echo '
			<div class="kata-customizer-preloader">
				<img src="' . esc_url( kata::$assets ) . 'img/svg/kata-icon.svg" class="kata-customizer-preloader-icon">
			</div>
			<style>
				body.wp-customizer-unloading {
					opacity: 1 !important;
				}
				.kata-customizer-preloader {
					position: fixed;
					top: 0;
					left: 0;
					opacity: 0;
					width: 100%;
					height: 100%;
					background: rgba(255, 255, 255, 0.60);
					opacity: 0;
					z-index: -9999;
					transition: all .3s ease;
					-webkit-transition: all .3s ease;
				}
				@-webkit-keyframes sk-scaleout {
					0% { -webkit-transform: scale(0) }
					100% {
						-webkit-transform: scale(1.0);
						opacity: 0;
					}
				}
				@keyframes sk-scaleout {
					0% {
						-webkit-transform: scale(0);
						transform: scale(0);
					}
					100% {
						-webkit-transform: scale(1.0);
						transform: scale(1.0);
						opacity: 0;
					}
				}
				.wp-customizer-unloading .kata-customizer-preloader {
					opacity: 1;
					z-index: 9999;
				}
				.wp-customizer-unloading .kata-customizer-preloader img {
					position: fixed;
					top: calc( 50% - 50px );
					left: calc( 50% - 50px );
					height: 100px;
					width: 100px;
					transition: all .3s ease;
					-webkit-transition: all .3s ease;
					-webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
					animation: sk-scaleout 1.0s infinite ease-in-out;
				}
			</style>';
		}
	}

	Kata_Theme_Options::get_instance();
}
