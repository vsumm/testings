<?php

/**
 * Plugin Name:     Kata Plus Pro
 * Plugin URI:      https://climaxthemes.com/kata-wp/
 * Description:     Kata Plus Pro functionality
 * Version:         1.1.5
 * Author:          ClimaxThemes
 * Author URI:      https://climaxthemes.com/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     kata-plus
 * Domain Path:     /languages
 *
 * The plugin bootstrap file
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */
// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}
use \Elementor\Core\Files\CSS\Base;
use Elementor\Core\Responsive\Responsive;
use Elementor\Stylesheet;

if ( ! class_exists( 'Kata_Plus_Pro' ) ) {
	class Kata_Plus_Pro {
		/**
		 * Maintains the current version of the plugin.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $version;

		/**
		 * Maintains the slug of the plugin.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $slug;

		/**
		 * Maintains the name of the plugin.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $plugin_name;

		/**
		 * Maintains the url of the plugin.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $plugin_url;

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
		 * The base name of the kata plus.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $name;

		/**
		 * Fonts table name.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $fonts_table_name;

		/**
		 * Upload dir.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $upload_dir;

		/**
		 * Upload dir.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $upload_dir_url;

		/**
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $assets;

		/**
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $assets_dir;

		/**
		 * The url of assets file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $get_plugin;

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro
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
		 * Define the core functionality of the plugin.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			if ( ! class_exists( 'Kata_Plus' ) || ! class_exists( 'Elementor\Plugin' ) ) {
				add_action( 'admin_notices', function() {
					?>
					<style>
						.kata-notice.notice.is-dismissible {
							padding-left: 270px;
							background-image: url(<?php echo get_template_directory_uri() . '/assets/img/dashboard-notice.png' ?>);
							background-repeat: no-repeat;
							background-position: 2px 2px;
							background-size: 252px;
							border-left-color: #908efc;
							min-height: 170px;
							padding-right: 10px;
						}

						.kata-notice.notice.is-dismissible h2 {
							margin-bottom: 8px;
							margin-top: 21px;
							font-size: 17px;
							font-weight: 700;
						}

						.kata-notice.notice.is-dismissible a:not(.notice-dismiss) {
							border-radius: 3px;
							border-color: #6d6af8;
							color: #fff;
							text-shadow: unset;
							background: #6d6af8;
							font-weight: 400;
							font-size: 14px;
							line-height: 18px;
							text-decoration: none;
							text-transform: capitalize;
							padding: 12px 20px;
							display: inline-block;
							margin: 7px 0 13px;
							box-shadow: 0 1px 2px rgba(0,0,0,0.1);
							letter-spacing: 0.4px;
						}

						.kata-notice.notice.is-dismissible a:not(.notice-dismiss):hover {
							border-color: #17202e;
							background: #17202e;
						}

						.kt-dashboard-row .kata-notice.notice.is-dismissible {
							display: block;
							margin: 0 0 25px;
							border-left: 4px solid #6d6af8;
							border-radius: 2px;
							overflow: hidden;
							box-shadow: 0 2px 7px -1px rgba(0,0,0,0.04);
						}

						.kt-dashboard-row .kata-notice.notice.is-dismissible .notice-dismiss {
							display: none;
						}

						.kt-dashboard-row .kata-notice.notice.is-dismissible h2 {
							letter-spacing: -0.3px;
						}

					</style>
					<div class="kata-notice kt-dashboard-box notice notice-error is-dismissible">
                        <h2><?php echo __( 'Please make sure the "kata plus" is installed and activated', 'kata' ); ?></h2>
                        <h4><?php echo __( '"Kata Plus Pro" needs "Kata Plus" to work.', 'kata' ); ?></h4>
                        <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>"><?php echo __( 'Install plugins', 'kata' ) ?></a></p>
                    </div>
					<?php
				}, 99 );
				return false;
			} else {
				$this->definitions();
				$this->actions();
				$this->dependencies();
			}
		}

		/**
		 * Elementor is not activate notice.
		 *
		 * @since   1.0.0
		 */
		public function elementor_not_active() {
			echo '<div id="message" class="updated error is-dismissible"><p>' . __('Elementor is not activated. Kata plus needs Elementor to work', 'kata-plus') . '</p></div>';
		}

		/**
		 * Kata theme is not activate notice.
		 *
		 * @since   1.0.0
		 */
		public function kata_not_active() {
			echo '<div id="message" class="updated error is-dismissible"><p>' . __('Kata theme is not activated. Kata plus needs kata theme to work', 'kata-plus') . '</p></div>';
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$version          = '1.1.5';
			self::$slug          	= 'kata-plus-pro';
			self::$plugin_name     	= 'Kata Plus Pro';
			self::$plugin_url		= 'https://climaxthemes.com/kata/';
			self::$dir              = plugin_dir_path(__FILE__);
			self::$url              = plugin_dir_url(__FILE__);
			self::$name				= plugin_basename( __FILE__ );
			self::$assets           = self::$url . 'assets/src/';
			self::$assets_dir		= self::$dir . 'assets/src/';
			self::$fonts_table_name = 'kata_plus_fonts_manager';
			self::$upload_dir       = wp_get_upload_dir()['basedir'] . '/kata';
			self::$upload_dir_url   = wp_get_upload_dir()['baseurl'] . '/kata';
			if( ! function_exists('get_plugin_data') ){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			self::$get_plugin   	= get_plugin_data( __FILE__ );
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'plugins_loaded', [$this, 'load_plugin_textdomain'], 1 );
		}


		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			/**
			 * AutoLoader
			 */
			require_once self::$dir . 'includes/autoloader/autoloader.php';
			/**
			 * Helpers
			 */
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'includes/helpers', 'helpers' );

			if ( class_exists('\Elementor\Plugin') ) {
				Kata_Plus_Pro_Autoloader::load( self::$dir . 'includes/elementor', 'elementor' );
			}

			if ( ! class_exists( 'Kirki' ) ) {
				Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes/vendors/kirki', 'kirki');
				// Disable Admin Notice
				remove_action('admin_notices', array(Kirki_Modules_Telemetry::get_instance(), 'admin_notice'));
				remove_action('init', array(Kirki_Modules_Loading::get_instance(), 'init'));
			}

			/**
			 * Theme Options
			 */
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes/theme-options', 'theme-options');
			/**
			 * Menu & Mega Menu
			 */
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes/menu', 'menu');
			/**
			 * Grid Post Type
			 */
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes/post-types/grid', 'grid');
			/**
			 * Testimonial Post Type
			 */
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes/post-types/testimonial', 'testimonial');
			/**
			 * Recipes Post Type
			 */
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes/post-types/recipes', 'recipes');
			/**
			 * Team Member Post Type
			 */
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'includes/post-types/team-member', 'team-member');

			if ( is_admin() ) {
				/**
				* Admin Panel
				*/
				Kata_Plus_Pro_Autoloader::load( self::$dir . 'includes/admin-panel', 'admin-panel' );
				Kata_Plus_Pro_Autoloader::load( self::$dir . 'includes/admin-panel', 'class-fast-mode' );
				Kata_Plus_Pro_Autoloader::load( self::$dir . 'includes/licenseing', 'class-kata-plus-pro-license-activation' );
				if ( ! defined( 'WPP_PLUGIN_VERSION' ) ) {
					Kata_Plus_Pro_Autoloader::load( self::$dir . 'includes/vendors/wp-paint', 'wp-paint' );
				}
			}
		}

		/**
		 * Load the textdomain of the plugin.
		 *
		 * @since   1.0.0
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain('kata-plus', false, basename(dirname(__FILE__)) . '/languages');
		}

	} // class
}

add_action( 'plugins_loaded', ['Kata_Plus_Pro', 'get_instance'], 10 );