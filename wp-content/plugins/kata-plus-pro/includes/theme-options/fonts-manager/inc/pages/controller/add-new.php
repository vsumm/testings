<?php
/**
 * Kata_Plus_Pro_FontsManager_Add_New_Page_Controller.
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

if ( ! class_exists( 'Kata_Plus_Pro_FontsManager_Add_New_Page_Controller' ) ) :
	class Kata_Plus_Pro_FontsManager_Add_New_Page_Controller {

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
		  * actions
		  *
		  * @since     1.0.0
		  */
		public function actions() {
			add_action( 'admin_init', [ $this, 'redirect' ] );
		}


		 /**
		  * Request Parser
		  *
		  * @since     1.0.0
		  */
		public function request_parser() {
			if ( $_POST ) {
				if ( isset( $_POST['font_status'] ) && isset( $_POST['source'] ) ) {
					if($_POST['source'] == 'upload-icon') {
						return;
					}
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

                    if (!isset( $_POST['fontname'] ) || empty( $_POST['fontname'] )) {
                        $_POST['fontname'] = str_replace(['https://use.typekit.net/','.css'],'',$_POST['url']);
                    }

					if ( isset( $_REQUEST['font_family'] ) && is_array( $_REQUEST['font_family'] ) ) {
						$_REQUEST['font_family'] = implode( ',', $_REQUEST['font_family'] );
					}

					$variants       = isset( $_POST['variants'] ) ? $_POST['variants'] : [];
					$variants       = ( ! $variants && isset( $_REQUEST['font_weight'] ) ) ? $_REQUEST['font_weight'] : $variants;
					$subsets        = isset( $_POST['subsets'] ) ? $_POST['subsets'] : [];
					$subsets        = ( ! $subsets && isset( $_REQUEST['font_style'] ) ) ? $_REQUEST['font_style'] : $subsets;
					$font_selectors = isset( $_POST['font_selectors'] ) ? $_POST['font_selectors'] : [];
					if (isset( $_POST['fontname'] ) && is_array($_POST['fontname'])) {
						$fontname = $_POST['fontname'];
					} else {
						$fontname       = isset( $_POST['fontname'] ) && !is_array($_POST['fontname']) ? esc_html( $_POST['fontname'] ) : '';
					}

					$id = Kata_Plus_Pro_FontsManager_Helpers::add_new_font(
						esc_html( $_POST['source'] ),
						$url,
						$fontname,
						$variants,
						$subsets,
						$font_selectors,
						esc_html( 'head' ),
						esc_html( $_POST['font_status'] )
					);

					echo '
					<script>
						window.location.href = "' . admin_url( 'admin.php?page=kata-plus-fonts-manager&action=edit&font_id=' . $id . '&source=' . $_POST['source'] ) . '";
					</script>';
					exit();
				} else if (isset($_POST['icon-pack-name']) && isset($_POST['source'])) {
					if($_POST['source'] != 'upload-icon') {
						return;
					}

					$icon_pack_name = esc_html($_POST['icon-pack-name']);
					$icons = $_POST['icons'];
					$icons_destiny = [];
					foreach ($icons as $key => $icon) {
						if(isset($icon['paths'])) {
							$icon['paths'] = json_decode($icon['paths']);
							$content = Kata_Plus_Pro_FontsManager::get_instance()->generate_svg($icon['paths'], $icon['name'], $icon['size']);
							if(!is_dir( Kata_Plus_Pro::$upload_dir . '/icons')) {
								mkdir(Kata_Plus_Pro::$upload_dir . '/icons');
							}
							$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $icon['name'] . '.svg';
							if(file_exists($destiny)) {
								$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $key . '-' . $icon['name'] . '.svg';
							}
							file_put_contents($destiny, $content);
							$icons_destiny[$key] = [
								"name" => $icon['name'],
								"path" => $destiny,
								"key" => $key,
								"size" => $icon['size']
							];
						} else if( isset($icon['icon']) ) {
							$content = $icon['icon'];
							if (!is_dir(Kata_Plus_Pro::$upload_dir . '/icons')) {
								mkdir(Kata_Plus_Pro::$upload_dir . '/icons');
							}
							$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $icon['name'] . '.svg';
							if (file_exists($destiny)) {
								$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $key . '-' . $icon['name'] . '.svg';
							}
							file_put_contents($destiny, $content);
							$icons_destiny[$key] = [
								"name" => $icon['name'],
								"path" => $destiny,
								"key" => $key,
								"size" => 1024
							];
						}
					}
					$id = Kata_Plus_Pro_FontsManager_Helpers::add_new_font(
						esc_html($_POST['source']),
						'',
						$icon_pack_name,
						'',
						'',
						$icons_destiny,
						'head',
						'published'
					);

					echo '
					<script>
						window.location.href = "' . admin_url('admin.php?page=kata-plus-fonts-manager&action=edit&font_id=' . $id . '&source=' . $_POST['source']) . '";
					</script>';
					exit();
				}
			}
		}

		 /**
		  * Redirect
		  *
		  * @since     1.0.0
		  */
		public function redirect() {
			if ( isset( $_POST['source'] ) ) {
				wp_redirect( admin_url( 'admin.php?page=kata-plus-fonts-manager&action=add_new_font&source=' . esc_attr( $_POST['source'] ) . '&step=2' ) );
			}
		}


		/**
		 * Render the view.
		 *
		 * @since   1.0.0
		 */
		public static function presenter() {
			do_action( 'kata_plus_pro_fonts_manager_render_view_start' );
			if ( isset( $_REQUEST['step'] ) ) {
				if ( $_REQUEST['step'] == '2' ) {
					Kata_Plus_Pro_Autoloader::load( self::$dir . 'presenter', 'add-new', '', 'step2' );
					$presenter = new FontsManager_Add_New_Page_Presenter();
					$presenter->render();
					do_action( 'kata_plus_pro_fonts_manager_render_view_end' );
					return;
				}
			}

			Kata_Plus_Pro_Autoloader::load( self::$dir . 'presenter', 'add-new' );
			$presenter = new FontsManager_Add_New_Page_Presenter();
			$presenter->render();
			do_action( 'kata_plus_pro_fonts_manager_render_view_end' );
			return;
		}

	} //Class
	Kata_Plus_Pro_FontsManager_Add_New_Page_Controller::get_instance();
endif;
