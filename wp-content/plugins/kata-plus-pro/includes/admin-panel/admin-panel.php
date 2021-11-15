<?php

/**
 * Admin Panel Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Core\Editor\Editor;
use Elementor\Core\Settings\Base\Manager;
use Elementor\Core\Common\Modules\Connect\Admin;

if (!class_exists('Kata_Plus_Pro_Admin_Panel')) {
	class Kata_Plus_Pro_Admin_Panel {
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
		 * @var     Kata_Plus_Pro_Admin_Panel
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

		public $action_name = 'admin_bar_init';

		/**
		 * Constructor.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			if( ! class_exists( 'Kata_Plus_Admin_Panel' ) ) {
				return;
			}
			$this->definitions();
			$this->actions();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir = Kata_Plus_Pro::$dir . 'includes/admin-panel/';
			self::$url = Kata_Plus_Pro::$url . 'includes/admin-panel/';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_filter( 'kata_plus_submenu_url', [$this, 'kata_plus_controlpanel_item_url'] );
			add_action( 'kata_plus_license_form', [$this, 'license_form'] );
			add_action( 'after_setup_theme', function() {
				remove_action( 'admin_menu', [Kata_Plus_Admin_Panel::get_instance(), 'GoPro'] );
			}, 99 );
		}

		/**
		 * Items Control Panel url.
		 *
		 * @since   1.0.0
		 */
		public function  kata_plus_controlpanel_item_url( $args ) {
			$args['plugin_manager_url']			= 'kata-plus-plugins';
			$args['plugin_manager_url:static']	= admin_url('admin.php?page=kata-plus-plugins');
			$args['plugin_manager_func']		= [$this, 'install_plugins_page'];
			$args['fonts_manager_url']			= 'kata-plus-fonts-manager';
			$args['fonts_manager_url:static']	= admin_url('admin.php?page=kata-plus-fonts-manager');
			$args['fonts_manager_func']			= [KATA_PLUS_PRO_FONTS_MANAGER_CURRENT_CONTROLLER, 'presenter'];
			$args['header_sticky_url']			= Kata_Plus_Builders_Base::builder_url( 'Kata Sticky Header' );
			$args['single_url']					= Kata_Plus_Builders_Base::builder_url( 'Kata Single' );
			$args['single_portfolio_url']		= Kata_Plus_Builders_Base::builder_url( 'Kata Single Portfolio' );
			$args['single_course_url']			= Kata_Plus_Builders_Base::builder_url( 'Single Course' );
			$args['archive_url']				= Kata_Plus_Builders_Base::builder_url( 'Kata Archive' );
			$args['_404_url']					= Kata_Plus_Builders_Base::builder_url( 'Kata 404' );
			$args['author_url']					= Kata_Plus_Builders_Base::builder_url( 'Kata Author' );
			$args['search_url']					= Kata_Plus_Builders_Base::builder_url( 'Kata Search' );
			$args['mega_menu_url']				= 'edit.php?post_type=kata_mega_menu';
			$args['fast_mode']					= 'kata-plus-fast-mode';
			$args['fast_mode:static']			= admin_url('admin.php?page=kata-plus-fast-mode');
			$args['fast_mode_func']				= ['Kata_Plus_Pro_Fast_Mode', 'step_handler'];
			$args['add_new_kata_grid']			= admin_url('post-new.php?post_type=kata_grid');
			$args['add_new_kata_mega_menu']		= admin_url('post-new.php?post_type=kata_mega_menu');
			$args['add_new_kata_testimonial']	= admin_url('post-new.php?post_type=kata_testimonial');
			$args['add_new_kata_team_member']	= admin_url('post-new.php?post_type=kata_team_member');
			$args['add_new_kata_recipe']		= admin_url('post-new.php?post_type=kata_recipe');
			return $args;
		}

		/**
		 * Items Control Panel url.
		 *
		 * @since   1.0.0
		 */
		public function  license_form() {
			$kata_options	= get_option( 'kata_options' );
			$code	= isset( $kata_options['license']['purchase_code'] ) ? $kata_options['license']['purchase_code'] : '';
			$type	= $code ? 'password' : 'text'; ?>
			<h3 class="kata-card-header"><?php esc_html_e( 'Theme Activation', 'kata-plus' ); ?></h3>
			<p class="kata-card-text"><?php esc_html_e( 'Please enter your purchase code and activate the theme to unlock all features.', 'kata-plus' ); ?></p>
			<form id="kata-license" method="post" action="#">
				<div class="kata-form-group">
					<input type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( base64_encode( $code ) ); ?>" class="kata-form-control" placeholder="<?php echo esc_attr__( 'Enter Purchase code token', 'kata-plus' ); ?>">
					<?php if ( $code ) { ?>
						<i class="ti-check" aria-hidden="true" id="activation-successfully"></i>
					<?php } else { ?>
						<i class="ti-close" aria-hidden="true"></i>
					<?php } ?>
				</div>
				<div class="kata-form-group">
					<input type="submit" class="kata-btn kata-btn-primary" value="<?php echo esc_attr__( 'Activate', 'kata-plus' ); ?>">
				</div>
				<div class="kata-form-group">
					<div id="kata-license-faild-message"></div>
				</div>
			</form>
			<?php
		}

		/**
		 * Install Plugins page.
		 *
		 * @since   1.0.0
		 */
		public function install_plugins_page() {
			require_once self::$dir . 'views/install-plugins-page.php';
		}

		/**
		 * Header of admin panel pages.
		 *
		 * @since   1.0.0
		 */
		public function header() {
			$selected            = isset($_GET['page']) ? $_GET['page'] : 'kata-plus-theme-activation';
			$white_label         = class_exists('Kata_Plus_Pro_Theme_Options_Functions') ? Kata_Plus_Pro_Theme_Options_Functions::get_instance()->white_label()->name : '';
			$white_label_version = class_exists('Kata_Plus_Pro_Theme_Options_Functions') ? Kata_Plus_Pro_Theme_Options_Functions::get_instance()->white_label()->version : '';
			$theme_logo_label    = class_exists('Kata_Plus_Pro_Theme_Options_Functions') ? Kata_Plus_Pro_Theme_Options_Functions::get_instance()->white_label()->url : '';
			if ($theme_logo_label) {
				$theme_logo_label_style = 'style="background-image: url(' . $theme_logo_label . ');"';
			} else {
				$theme_logo_label_style = '';
			}
			?>
			<div class="kata-col-sm-12">
				<h1>
					<?php
					if (!$white_label) :
						echo esc_html(Kata_Plus_Helpers::get_theme()->name) . ' ' . str_replace( 'plugins', __('plugins manager', 'kata-plus'), self::current_screen()['base_name'] );
					else :
						echo esc_html($white_label) . ' ' . str_replace( 'plugins', __('plugins manager', 'kata-plus'), self::current_screen()['base_name'] );
					endif;
					?>
				</h1>
				<?php if ( 'kata-plus-theme-activation' == sanitize_text_field( $_GET['page'] ) ) { ?>
					<div class="about-text"><?php echo esc_html__('By activating the theme, you can use all of the features in the theme.', 'kata-plus'); ?></div>
				<?php } ?>
				<?php if ( 'kata-plus-demo-importer' == sanitize_text_field( $_GET['page'] ) ) { ?>
					<div class="about-text"><?php echo esc_html__('Just import one of the following demos and your website will be ready.', 'kata-plus'); ?></div>
				<?php } ?>
				<?php if ( 'kata-plus-plugins' == sanitize_text_field( $_GET['page'] ) ) { ?>
					<div class="about-text"><?php echo esc_html__('Install or remove, you can manage the plugin and all its settings from here.', 'kata-plus'); ?></div>
				<?php } ?>
				<?php if ( 'kata-plus-fonts-manager' == sanitize_text_field( $_GET['page'] ) ) { ?>
					<div class="about-text"><?php echo esc_html__('Add & Manage fonts from all different sources like Google Fonts.', 'kata-plus'); ?></div>
				<?php } ?>
				<?php if ( 'kata-plus-help' == sanitize_text_field( $_GET['page'] ) ) { ?>
					<div class="about-text"><?php echo esc_html__('Create your awesome website, fast and easy.', 'kata-plus'); ?></div>
				<?php } ?>
				<div class="wp-badge" <?php echo $theme_logo_label_style; ?>>
					<?php
					if (!$white_label_version) :
						printf(esc_html__('v %s', 'kata-plus'), Kata_Plus::$version);
					else :
						printf(esc_html__('v %s', 'kata-plus'), $white_label_version);
					endif;
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Current Screen
		 *
		 * @since   1.0.0
		 */
		public static function current_screen() {
			$current_screen    = get_current_screen();
			$data              = array();
			$data['base_name'] = str_replace(
				['toplevel_page_kata-plus-', 'kata_page_kata-plus-', 'Toplevel_page_kata Plus', '-'],
				['', '', '', ' '],
				get_current_screen()->base
			);
			return $data;
		}

	}

	Kata_Plus_Pro_Admin_Panel::get_instance();
}
