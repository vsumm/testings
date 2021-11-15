<?php

/**
 * Plugin Name:     Kata Plus
 * Plugin URI:      https://wordpress.org/plugins/kata-plus/
 * Description:     Kata Plus is one an all in one addon for Elementor page builder that is fully compatible with Kata WordPress theme. Kata Plus is an all-in-one plugin that has a header, footer, and blog builder inside Styler (the new advanced tool for styling widgets) and comes with 18 practical widgets for creating different websites.
 * Version:         1.1.6
 * Author:          ClimaxThemes
 * Author URI:      https://climaxthemes.com/
 * Elementor tested up to: 3.4.0
 * Elementor Pro tested up to: 3.4.0
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     kata-plus
 * Domain Path:     /languages
 *
 * The plugin bootstrap file
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */
// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}
use \Elementor\Core\Files\CSS\Base;
use Elementor\Core\Responsive\Responsive;
use Elementor\Stylesheet;

if ( ! class_exists( 'Kata_Plus' ) ) {
	class Kata_Plus {
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
		 * Maintains the url of the plugin.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $plugin_url;

		/**
		 * Maintains the name of the plugin.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $plugin_name;

		/**
		 * Maintains the wp-include dir.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $kata_plus_wp_include_dir;

		/**
		 * Maintains the wp-admin dir.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $kata_plus_wp_admin_dir;

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
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus
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
		 * Define the core functionality of the plugin.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
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
                        <h2><?php echo __( 'Please make sure the "Elementor" is installed and activated', 'kata-plus' ); ?></h2>
                        <h4><?php echo __( '"Kata Plus" needs "Elementor" to work.', 'kata-plus' ); ?></h4>
                        <p><a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-plugins' ) ); ?>"><?php echo __( 'Install plugins', 'kata-plus' ) ?></a></p>
                    </div>
					<?php
				} );
				// return;
			}
			if ( get_option( 'kata_is_active' ) ) {
				add_action( 'admin_notices', [$this, 'kata_not_active'] );
				return;
			}
			$this->definitions();
			$this->dependencies();
			$this->actions();
			$this->upload_dir();
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
			self::$version          = '1.1.6';
			self::$slug          	= 'kata-plus';
			self::$plugin_url		= 'https://wordpress.org/plugins/kata-plus/';
			self::$plugin_name     	= 'Kata Plus';
			self::$dir              = plugin_dir_path(__FILE__);
			self::$kata_plus_wp_include_dir	= ABSPATH . WPINC;
			self::$kata_plus_wp_admin_dir	= ABSPATH . 'wp-admin';
			self::$url              = plugin_dir_url(__FILE__);
			self::$name				= plugin_basename( __FILE__ );
			self::$assets           = self::$url . 'assets/src/';
			self::$assets_dir		= self::$dir . 'assets/src/';
			self::$fonts_table_name = 'kata_plus_fonts_manager';
			self::$upload_dir       = wp_get_upload_dir()['basedir'] . '/kata';
			self::$upload_dir_url	= is_ssl() ? str_replace( 'http://', 'https://', wp_get_upload_dir()['baseurl'] . '/kata' ): wp_get_upload_dir()['baseurl'] . '/kata';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'after_switch_theme', [$this, 'sync_theme_mods'], 999 );
			add_action( 'plugins_loaded', [$this, 'load_plugin_textdomain'], 1 );
			add_action( 'admin_init', [$this, 'update_permalink'], 9 );
			// add_action('activated_plugin', [$this, 'redirect_to_dashboard'], 10, 2);
			register_activation_hook(__FILE__, [$this, 'essentials']);
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			// AutoLoader
			require_once self::$dir . 'includes/autoloader/autoloader.php';
			// Helpers
			Kata_Plus_Autoloader::load(self::$dir . 'includes/helpers', 'helpers');
			// Vendors
			Kata_Plus_Autoloader::load(self::$dir . 'includes/vendors', 'zilla-likes');
			if (!class_exists('Kirki')) {
				Kata_Plus_Autoloader::load(self::$dir . 'includes/vendors/kirki', 'kirki');
				// Disable Admin Notice
				//remove_action('admin_notices', array(Kirki_Modules_Telemetry::get_instance(), 'admin_notice'));
				remove_action('init', array(Kirki_Modules_Loading::get_instance(), 'init'));
			}

			// Styler
			Kata_Plus_Autoloader::load(self::$dir . 'includes/styler', 'styler');
			// Theme Options
			Kata_Plus_Autoloader::load(self::$dir . 'includes/theme-options', 'theme-options');
			// Meta Box
			Kata_Plus_Autoloader::load(self::$dir . 'includes/meta-box', 'meta-box');
			// Backend
			Kata_Plus_Autoloader::load(self::$dir . 'includes/backend', 'backend');
			// Export
			Kata_Plus_Autoloader::load(self::$dir . 'includes/backend', 'export');
			// Frontend
			Kata_Plus_Autoloader::load(self::$dir . 'includes/frontend', 'frontend');

			if (class_exists('\Elementor\Plugin')) {
				// Elementor
				Kata_Plus_Autoloader::load(self::$dir . 'includes/elementor', 'elementor');
			}
			// Breadcrumbs
			Kata_Plus_Autoloader::load(self::$dir . 'includes/vendors', 'breadcrumbs');
			// Woocommerce
			Kata_Plus_Autoloader::load(self::$dir . 'includes/woocommerce', 'woocommerce');
			// Widgets
			Kata_Plus_Autoloader::load(self::$dir . 'includes/widgets', 'widgets');
			// Compatiblity
			Kata_Plus_Autoloader::load( self::$dir . 'includes/compatiblity', 'class-kata-plus-compatibility' );
			// Menu
			Kata_Plus_Autoloader::load(self::$dir . 'includes/menu', 'menu');
			if (is_admin()) {
				// Admin Panel
				Kata_Plus_Autoloader::load(self::$dir . 'includes/admin-panel', 'admin-panel');
				Kata_Plus_Autoloader::load(self::$dir . 'includes/install-plugins', 'install-plugins');
				Kata_Plus_Autoloader::load(self::$dir . 'includes/importer', 'importer');
				Kata_Plus_Autoloader::load(self::$dir . 'includes/admin-panel', 'class-system-status');
				Kata_Plus_Autoloader::load(self::$dir . 'includes/helpers', 'class-kata-plus-notices');
			}
		}

		/**
		 * Upload dir.
		 *
		 * @since   1.0.0
		 */
		public function upload_dir() {
			if (!file_exists(self::$upload_dir)) {
				mkdir(self::$upload_dir, 0777);
			}
			if (!file_exists(self::$upload_dir . '/css')) {
				mkdir(self::$upload_dir . '/css', 0777);
			}
			if (!file_exists(self::$upload_dir . '/instagram')) {
				mkdir(self::$upload_dir . '/instagram', 0777);
			}
			if (!file_exists(self::$upload_dir . '/fonts')) {
				mkdir(self::$upload_dir . '/fonts', 0777);
			}
			if (!file_exists(self::$upload_dir . '/importer')) {
				mkdir(self::$upload_dir . '/importer', 0777);
			}
			if (!file_exists(self::$upload_dir . '/localize')) {
				mkdir(self::$upload_dir . '/localize', 0777);
			}
			if (!file_exists(self::$upload_dir . '/css/admin-custom.css')) {
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}
				$wp_filesystem->put_contents(
					self::$upload_dir . '/css/admin-custom.css',
					'',
					FS_CHMOD_FILE
				);
			}
			if (!file_exists(self::$upload_dir . '/css/dynamic-styles.css')) {
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}
				$wp_filesystem->put_contents(
					self::$upload_dir . '/css/dynamic-styles.css',
					'',
					FS_CHMOD_FILE
				);
			}
			if (!file_exists(self::$upload_dir . '/css/customizer-styler.css')) {
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}
				$wp_filesystem->put_contents(
					self::$upload_dir . '/css/customizer-styler.css',
					'',
					FS_CHMOD_FILE
				);
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

		/**
		 * Deactivator.
		 *
		 * @since   1.0.0
		 */
		public function sync_theme_mods() {
			$kata_options		= get_option( 'theme_mods_kata' );
			$kata_child_options = get_option( 'theme_mods_kata-child' );
			if ( $kata_options == $kata_child_options ) {
				return;
			}
			$current_theme		= class_exists( 'Kata' ) ? Kata::$theme->get( 'TextDomain' ) : false;
			if ( ! $current_theme ) {
				return;
			}
			$previous_theme		= 'kata-child' == $current_theme ? 'kata' : 'kata-child';
			if ( 'kata' == $previous_theme ) {
				$options = get_option( 'theme_mods_kata' );
				foreach ( $options as $name => $value ) {
					set_theme_mod( $name, $value );
				}
			}
			if ( 'kata-child' == $previous_theme ) {
				$options = get_option( 'theme_mods_kata-child' );
				if ( $options ) {
					foreach ( $options as $name => $value ) {
						set_theme_mod( $name, $value );
					}
				}
			}
		}

		/**
		 * Redirect to kata admin dashboard.
		 *
		 * @since   1.0.0
		 */
		public function redirect_to_dashboard($plugin) {
			if ($plugin == plugin_basename(__FILE__)) {
				if ($_GET['page'] != 'tgmpa-install-plugins') {
					exit( wp_redirect( admin_url( 'admin.php?page=kata-plus-theme-activation' ) ) );
				}
			}
		}

		/**
		 * Create Database Tables
		 *
		 * @since     1.0.0
		 */
		public static function update_permalink() {
			$kata_options = get_option( 'kata_options' );
			if ( ! isset( $kata_options['update_permalinks'] ) ) {
				global $wp_rewrite;
				$structure = get_option( 'permalink_structure' );
				$wp_rewrite->set_permalink_structure( $structure );
				$kata_options['update_permalinks'] = true;
				update_option( 'kata_options', $kata_options );
				wp_redirect( admin_url( 'options-permalink.php' ) );
				exit();
			}
			if ( isset( $kata_options['update_permalinks'] ) && ! isset( $kata_options['show_permalink_alert'] ) ) {
				$kata_options['show_permalink_alert'] = true;
				update_option( 'kata_options', $kata_options );
				add_action('admin_footer', function () {
					echo '<script>';
					echo 'alert("' . __( 'Configuring permalinks is done.', 'kata-plus' ) . '");';
					echo '</script>';
				});
			}

		}

		/**
		 * Create Database Tables
		 *
		 * @since     1.0.0
		 */
		public static function essentials() {
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();

			$sql = 'CREATE TABLE ' . $wpdb->prefix . self::$fonts_table_name . " (
                ID int(9) NOT NULL AUTO_INCREMENT,
                name text NOT NULL,
                source varchar(200) NOT NULL,
                selectors text NOT NULL,
                subsets text NOT NULL,
                variants text NOT NULL,
                url text DEFAULT '' NOT NULL,
                place varchar(50) NOT NULL DEFAULT 'before_head_end',
                status varchar(50) NOT NULL DEFAULT 'publish',
                created_at int(12) NOT NULL,
                updated_at int(12) NOT NULL,
                PRIMARY KEY  (ID)
            ) $charset_collate;";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta($sql);

			// esential options
			add_option(
				'kata_options',
				[
					'container'           	=> 1600,
					'kata_container'      	=> 1600,
					'elementor_container'	=> 1600,
					'first_time_import'		=> true,
					'images'				=> '',
					'license'				=> [
						'purchase_code'			=> '',
						'product_version'		=> '',
						'check_time'			=> '',
					],
					'fast-mode'				=> [
						'websitetype'		=> '',
						'blogname'			=> '',
						'blogdescription'   => '',
						'siteurl'			=> '',
						'admin_email'		=> '',
						'timezone_string'	=> '',
					],
				]
			);
			if ( class_exists( 'Kata_Plus_Header_Builder' ) ) {
				Kata_Plus_Header_Builder::upload_logo();
			}

			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure('/%postname%/');
		}
	} // class
	Kata_Plus::get_instance();
}

do_action( 'kata_plus_init' );