<?php
/**
 * Kata_Plus_Pro_FontsManager_Edit_Page_Controller.
 *
 * @author     ClimaxThemes
 * @package    Kata Plus
 * @since      1.0.0
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
if ( ! class_exists( 'Kata_Plus_Pro_FontsManager_Edit_Page_Controller' ) ) :

	class Kata_Plus_Pro_FontsManager_Edit_Page_Controller {

		/**
		 * The directory of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $dir;

		/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      Kata_Plus_Pro_FontsManager
		 */
		private static $instance;

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
		 * Load the dependencies.
		 *
		 * @since     1.0.0
		 */
		function __construct() {
			$this->definitions();
			$this->actions();
			$this->request_parser();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir = Kata_Plus_Pro_FontsManager::$dir . 'inc/pages/';
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			// Main Presenter
			// Kata_Plus_Pro_Autoloader::load( self::$dir . 'presenter', 'main');
		}

		 /**
		  * actions
		  *
		  * @since     1.0.0
		  */
		public function actions() {
		}


		 /**
		  * Request Parser
		  *
		  * @since     1.0.0
		  */
		public function request_parser() {
			if ( $_POST ) {

				if ( isset( $_POST['font_status'] ) && isset( $_POST['source'] ) && $_POST['source'] != 'upload-icon' ) {
					$url = '';
					if ( isset( $_REQUEST['font_preview'] ) ) {
						$url = $_REQUEST['font_preview'];
					}

					if ( isset( $_REQUEST['url'] ) ) {
						$url = $_REQUEST['url'];
					}

					if ( is_array( $url ) ) {
						$url = json_encode( $url );
					}

					if ( $_POST['source'] == 'typekit' && filter_var( $_POST['url'], FILTER_VALIDATE_URL ) === false ) {
						$url = 'https://use.typekit.net/' . $_POST['url'] . '.css';
					}

					if ( ! isset( $_POST['fontname'] ) || empty( $_POST['fontname'] ) ) {
						$_POST['fontname'] = str_replace( [ 'https://use.typekit.net/', '.css' ], '', $_POST['url'] );
					}

					if ( isset( $_REQUEST['font_family'] ) && is_array( $_REQUEST['font_family'] ) ) {
						$_REQUEST['font_family'] = implode( ',', $_REQUEST['font_family'] );
					}

					$variants       = isset( $_POST['variants'] ) ? $_POST['variants'] : [];
					$variants       = ( ! $variants && isset( $_REQUEST['font_weight'] ) ) ? $_REQUEST['font_weight'] : $variants;
					$subsets        = isset( $_POST['subsets'] ) ? $_POST['subsets'] : [];
					$subsets        = ( ! $subsets && isset( $_REQUEST['font_style'] ) ) ? $_REQUEST['font_style'] : $subsets;
					$font_selectors = isset( $_POST['font_selectors'] ) ? $_POST['font_selectors'] : [];
					if ( isset( $_POST['fontname'] ) && is_array( $_POST['fontname'] ) ) {
						$fontname = $_POST['fontname'];
					} else {
						$fontname = isset( $_POST['fontname'] ) && ! is_array( $_POST['fontname'] ) ? esc_html( $_POST['fontname'] ) : '';
					}

					Kata_Plus_Pro_FontsManager_Helpers::edit_font(
						esc_html( $_POST['font_id'] ),
						esc_html( $_POST['source'] ),
						$url,
						$fontname,
						$variants,
						$subsets,
						$font_selectors,
						esc_html( 'head' ),
						esc_html( $_POST['font_status'] )
					);
					add_action( 'kata_plus_pro_fonts_manager_before_header', function() {
						?>
						<div class="notice notice-success" style="display:block !important">
							<p><?php echo esc_attr__( 'Font was updated successfully', 'kata-plus' ); ?></p>
						</div>
						<div class="clearfix"></div>
							<?php
						},
						1000
					);

				} else if (isset($_POST['icon-pack-name']) && isset($_POST['source'])) {
					if ($_POST['source'] != 'upload-icon') {
						return;
					}

					global $wpdb;

					$sql = "SELECT * FROM " . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE ID=" . esc_attr($_REQUEST['font_id']);
					$result = $wpdb->get_results($sql, 'ARRAY_A');
					$current_font = current($result);
					$saved_icons = json_decode($current_font['selectors'], true);
					$icon_pack_name = esc_html($_POST['icon-pack-name']);
					$icons = $_POST['icons'];
					foreach ($icons as $key => $icon) {
						if (isset($icon['paths'])) {
							$icon['paths'] = json_decode($icon['paths']);
							$content = Kata_Plus_Pro_FontsManager::get_instance()->generate_svg($icon['paths'], $icon['name'], $icon['size']);
							if (!is_dir(Kata_Plus_Pro::$upload_dir . '/icons')) {
								mkdir(Kata_Plus_Pro::$upload_dir . '/icons');
							}
							$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $icon['name'] . '.svg';
							if (file_exists($destiny)) {
								$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $key . '-' . $icon['name'] . '.svg';
							}
							file_put_contents($destiny, $content);
							$saved_icons[$key] = [
								"name" => $icon['name'],
								"path" => $destiny,
								"key" => $key
							];
						} else if (isset($icon['icon'])) {
							$content = $icon['icon'];
							if(!isset($saved_icons[$key])) {
								if (!is_dir(Kata_Plus_Pro::$upload_dir . '/icons')) {
									mkdir(Kata_Plus_Pro::$upload_dir . '/icons');
								}
								$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $icon['name'] . '.svg';
								if (file_exists($destiny)) {
									$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $key . '-' . $icon['name'] . '.svg';
								}
								file_put_contents($destiny, $content);
							} else {
								$destiny = $saved_icons[$key]['path'];
							}
							$saved_icons[$key] = [
								"name" => $icon['name'],
								"path" => $destiny,
								"size" => 1024,
								"key" => $key
							];
						} else {
							$destiny = $saved_icons[$key]['path'];
							if(!isset($icon['name'])) {
								continue;
							}
							$saved_icons[$key] = [
								"name" => $icon['name'],
								"path" => $destiny,
								"size" => $icon['size'],
								"key" => $key
							];
						}
					}
					Kata_Plus_Pro_FontsManager_Helpers::edit_font(
						esc_html( $_POST['font_id'] ),
						esc_html( $_POST['source'] ),
						'',
						$icon_pack_name,
						'',
						'',
						$saved_icons,
						esc_html( 'head' ),
						'published'
					);
					add_action(
						'kata_plus_pro_fonts_manager_before_header',
						function() {
							?>
						<div class="notice notice-success" style="display:block !important">
							<p><?php echo esc_attr__( 'Icon Pack was updated successfully', 'kata-plus' ); ?></p>
						</div>
						<div class="clearfix"></div>
							<?php
						},
						1000
					);
				}
			}
		}

		/**
		 * Render the view.
		 *
		 * @since   1.0.0
		 */
		public static function presenter() {
			do_action( 'kata_plus_pro_fonts_manager_render_view_start' );
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'presenter', 'edit' );
			$presenter = new FontsManager_Edit_Page_Presenter();
			$presenter->render();
			do_action( 'kata_plus_pro_fonts_manager_render_view_end' );
			return;
		}

	} //Class
	Kata_Plus_Pro_FontsManager_Edit_Page_Controller::get_instance();
endif;
