<?php
/**
 * Kata_Plus_Pro_FontsManager_Helpers.
 *
 * @author  ClimaxThemes
 * @package    Kata Plus
 * @since  1.0.0
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_FontsManager_Helpers' ) ) :
	class Kata_Plus_Pro_FontsManager_Helpers extends Kata_Plus_Pro_FontsManager {

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

		private static $default_controller;
		private static $routers;
		private static $path;
		public static $viewport_breakpoints = array(
			'general' => array( null, null ),
			'desktop' => array( 992, null ),
			'tablet'  => array( 768, 992 ),
			'mobile'  => array( 360, 768 ),
		);

		/**
		 * Register Routers
		 *
		 * @since     1.0.0
		 */
		public static function register_router( $path, $routers, $default_controller ) {

			self::$default_controller = $default_controller;
			self::$path               = $path;
			foreach ( $routers as $route => $controller ) {
				self::$routers [] = [
					'path'       => $path,
					'uri'        => $route,
					'controller' => $controller,
				];
			}

			return true;
		}

		/**
		 * Run Routers
		 *
		 * @since     1.0.0
		 */
		public static function run_router() {
			add_action(
				'current_screen',
				function() {
					if ( get_current_screen()->base === 'kata_page_kata-plus-fonts-manager' ) {
						\Kata_Plus_Pro_Autoloader::load( __DIR__ . '/pages/functions/helpers', 'settings', '', 'helper' );
						// Kata_plus_FontsManager_Settings_Helper::get_instance();
					}
				}
			);
			$QueryString = preg_replace( '/(.*?)[?](.*?)/', '?$2', $_SERVER['REQUEST_URI'] );
			foreach ( self::$routers as $route ) {
				if ( $route['uri'] == $QueryString ) {
					Kata_Plus_Pro_Autoloader::load( $route['path'], $route['controller'] );
					$controller = str_replace( '-', '_', ucwords( $route['controller'] ) );
					$class_name = "Kata_Plus_Pro_FontsManager_{$controller}_Page_Controller";
					return $class_name;
				} elseif ( strpos( $route['uri'], '(:any)' ) !== false ) {

					$uri = str_replace( '(:any)', '', $route['uri'] );
					$uri = str_replace( '/', '\/', $uri );

					if ( preg_match( '# ' . $uri . '(.*?)#is', $QueryString ) ) {
						Kata_Plus_Pro_Autoloader::load( $route['path'], $route['controller'] );
						$controller = str_replace( '-', '_', ucwords( $route['controller'] ) );
						$class_name = "Kata_Plus_Pro_FontsManager_{$controller}_Page_Controller";
						$class_name = str_replace( 'Page_Page_', 'Page_', $class_name );
						return $class_name;
					}
				}
			}

			Kata_Plus_Pro_Autoloader::load( self::$path, self::$default_controller );
			$controller = str_replace( '-', '_', ucwords( self::$default_controller ) );
			$class_name = "Kata_Plus_Pro_FontsManager_{$controller}_Page_Controller";
			$class_name = str_replace( 'Page_Page_', 'Page_', $class_name );
			return $class_name;
		}

		 /**
		  * Render Font Preview
		  *
		  * @since     1.0.0
		  */
		public static function render_font_preview( $return = false ) {
			if ( $return ) {
				ob_start();
				include Kata_Plus_Pro_FontsManager::$dir . 'inc/pages/views/font-preview.php';
				$output = ob_get_contents();
				if ( ob_get_length() > 0 ) {
					ob_clean();
				}
				return $output;
			}
			Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager::$dir . 'inc/pages/views', 'font', '', 'preview' );
			die();
		}

		 /**
		  * get_typekit_data_html
		  *
		  * @since     1.0.0
		  */
		public static function get_typekit_data_html( $typekit_id = '', $single = false, $full = true, $justIframe = false ) {

			if ( ! isset( $_POST['typekit-id'] ) && empty( $typekit_id ) ) {
				if ( isset( $_POST['typekit-id'] ) ) {
					die();}
				return;
			}

			if ( isset( $_POST['typekit-id'] ) && ! empty( $_POST['typekit-id'] ) ) {
				$typekit_id = $_POST['typekit-id'];
			}

			if ( filter_var( $typekit_id, FILTER_VALIDATE_URL ) === false ) {
				$typekit_id = 'https://use.typekit.net/' . $typekit_id . '.css';
			}

			$temp_file_path = get_option( $typekit_id, false );
			if ( $temp_file_path && file_exists( $temp_file_path ) ) {
				global $wp_filesystem;

				if ( empty( $wp_filesystem ) ) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}

				$Allcss = $wp_filesystem->get_contents( $temp_file_path );
				$Allcss = str_replace( '<?php /* Kata */ die(); ?>', '', $Allcss );
			} else {
				$response = wp_remote_get( $typekit_id );
				$Allcss   = '';
				if ( is_array( $response ) && ! is_wp_error( $response ) ) {
					if ( $response['response']['code'] === 200 ) {
						$Allcss = $response['body'];
					} else {
						if ( isset( $_POST['typekit-id'] ) ) {
							die();}
						return;
					}
				} else {
					if ( isset( $_POST['typekit-id'] ) ) {
						die();}
					return;
				}
				$temp_file_path = static::save_to_disk_as_temp( $Allcss )->path;
				update_option( $typekit_id, $temp_file_path, true );
			}
			// $Allcss   = '';
			preg_match_all( '/(.*?)@font-face(.*?)[{](.*?)[}](.*?)/is', $Allcss, $matches );
			if ( ! isset( $matches[3][0] ) || empty( $matches[3][0] ) ) {
				if ( isset( $_POST['typekit-id'] ) ) {
					die();}
				return;
			}
			$fontFamilies     = [];
			$last_font_family = '';
			$html             = '';
			foreach ( $matches[3] as $css ) {
				preg_match_all( '/(.*?)font-family:"(.*?)"[;](.*)/', $css, $fm );
				if ( ! isset( $fm[2][0] ) || empty( $fm[2][0] ) ) {
					continue;
				}
				$fontFamily = $fm[2][0];

				if ( $last_font_family != $fontFamily && $justIframe == false ) {
					if ( ! empty( $last_font_family ) ) {
						$html .= '</div>';
					}
					$html          .= '<div class="font-pack" data-font-pack="' . $fontFamily . '">';
					$fontFamilies[] = $fontFamily;
					$html          .= '<h3>' . str_replace( '-', ' ', $fontFamily ) . '</h3>';

					$html     .= '<div class="font-preview-header">';
						$html .= '<div style="width: calc(100% - 300px);text-indent: 6px;" class="kata-plus-font-preview-title">' . esc_attr__( 'Preview', 'kata-plus' ) . '</div>';
						$html .= '<div style="width: 100px;" class="kata-plus-font-weight-title">' . esc_attr__( 'Font Weight', 'kata-plus' ) . '</div>';
						$html .= '<div style="width: 100px;" class="kata-plus-font-style-title">' . esc_attr__( 'Font Style', 'kata-plus' ) . '</div>';
						$html .= '<div style="width: 100px;" class="kata-plus-copy-css-title">' . esc_attr__( 'Copy CSS', 'kata-plus' ) . '</div>';
					$html     .= '</div>';
				}
				$last_font_family = $fontFamily;
				preg_match_all( '/(.*?)font-weight:(.*?)[;](.*)/', $css, $fw );
				$fontWeight = isset( $fw[2][0] ) && ! empty( $fw[2][0] ) ? $fw[2][0] : '';
				preg_match_all( '/(.*?)font-style:(.*?)[;](.*)/', $css, $fs );
				$fontStyle = isset( $fs[2][0] ) && ! empty( $fs[2][0] ) ? $fs[2][0] : '';

				$fontMD5   = md5( $fontFamily . 'typekit' . $typekit_id . $fontWeight . $fontStyle );
				$temp_file = get_option( $fontMD5, false );
				if ( $temp_file && file_exists( $temp_file->path ) ) {
					// :)
				} else {
					delete_option( $fontMD5 );
					$_REQUEST['font-family'] = $fontFamily;
					$_REQUEST['source']      = 'typekit';
					$_REQUEST['url']         = $typekit_id;
					$_REQUEST['font-weight'] = $fontWeight;
					$_REQUEST['font-style']  = $fontStyle;
					$_REQUEST['single-line'] = 'true';
					$_REQUEST['full']        = $full;

					$fontPreviewContent = static::render_font_preview( true );
					$temp_file          = static::save_to_disk_as_temp( $fontPreviewContent, $fontMD5 . '.html', true );
					update_option( $fontMD5, $temp_file, true );
				}
				$html .= '<iframe src="' . $temp_file->url . '" class="font-preview-iframe"></iframe>';
				if ( $single ) {
					if ( isset( $_POST['typekit-id'] ) ) {
						die();
					}
					return;
				}
			}
			if ( $fontFamilies ) {
				$fontFamilies = implode( ', ', $fontFamilies );
				$html        .= '<input type="hidden" name="fontname" value="' . $fontFamilies . '">';
			}

			preg_match_all( '/[{]"last_published":"(.*)"[}]/', $Allcss, $dt );
			if ( $justIframe == false ) {
				$html .= '
				</div>
				<div class="row postbox-container-footer">
					<span class="dashicons dashicons-clock"></span>' . esc_attr__( 'Last Update: ', 'kata-plus' ) . '
					<span class="font-last-update">' . $dt[1][0] . '</span>
				</div>
				';
			}
			echo $html;
			if ( isset( $_POST['typekit-id'] ) ) {
				die();}
			return;
		}

		public static function save_to_disk_as_temp( $data = false, $filename = false, $url = false ) {
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}

			$path = Kata_Plus_Pro::$upload_dir . '/temp/';
			if ( ! $filename ) {
				$data     = '<?php /* Kata */ die(); ?>' . $data;
				$filename = 'file-' . time() . '.php';
			}

			if ( ! is_dir( $path ) ) {
				wp_mkdir_p( $path );
			}

			$wp_filesystem->put_contents(
				$path . $filename,
				$data,
				FS_CHMOD_FILE
			);

			return (object) [
				'path' => $path . $filename,
				'url'  => Kata_Plus_Pro::$upload_dir_url . '/temp/' . $filename,
			];
		}

		/**
		 * get_custom_font_data_html
		 *
		 * @since     1.0.0
		 */
		public function get_custom_font_data_html( $url = '', $single = false, $full = true, $justIframe = false ) {

			if ( ! isset( $_POST['url'] ) && empty( $url ) ) {
				if ( isset( $_POST['url'] ) ) {
					die();}
				return;
			}

			if ( isset( $_POST['url'] ) && ! empty( $_POST['url'] ) ) {
				$url = $_POST['url'];
			}

			if ( filter_var( $url, FILTER_VALIDATE_URL ) === false ) {
				die();
			}

			$response = wp_remote_get( $url );
			$Allcss   = '';
			if ( is_array( $response ) && ! is_wp_error( $response ) ) {
				if ( $response['response']['code'] === 200 ) {
					$Allcss = $response['body'];
				} else {
					if ( isset( $_POST['url'] ) ) {
						die();}
					return;
				}
			} else {
				if ( isset( $_POST['url'] ) ) {
					die();}
				return;
			}
			preg_match_all( '/(.*?)@font-face(.*?)[{](.*?)[}](.*?)/is', $Allcss, $matches );
			if ( ! isset( $matches[3][0] ) || empty( $matches[3][0] ) ) {
				if ( isset( $_POST['url'] ) ) {
					die();}
				return;
			}

			$last_font_family = '';
			$fontFamilies     = [];
			// echo '<input name="url[]" type="hidden" value="' . $url . '">';
			foreach ( $matches[3] as $css ) {
				preg_match_all( '/(.*?)font-family:.*?["|\'](.*?)["|\'][;](.*)/', $css, $fm );

				if ( ! isset( $fm[2][0] ) || empty( $fm[2][0] ) ) {
					continue;
				}
				$fontFamily = $fm[2][0];

				if ( $last_font_family != $fontFamily && $justIframe == false ) {
					if ( ! empty( $last_font_family ) ) {
						echo '</div>';
					}
					echo '<div class="font-pack" data-font-pack="' . $fontFamily . '">';
					$fontFamilies[] = $fontFamily;
					echo '<h3>' . str_replace( '-', ' ', $fontFamily ) . '</h3>';

					echo '<div class="font-preview-header">';
						echo '<div style="width: calc(100% - 300px);text-indent: 6px;" class="kata-plus-font-preview-title">' . esc_attr__( 'Preview', 'kata-plus' ) . '</div>';
						echo '<div style="width: 100px;" class="kata-plus-font-weight-title">' . esc_attr__( 'Font Weight', 'kata-plus' ) . '</div>';
						echo '<div style="width: 100px;" class="kata-plus-font-style-title">' . esc_attr__( 'Font Style', 'kata-plus' ) . '</div>';
						echo '<div style="width: 100px;" class="kata-plus-copy-css-title">' . esc_attr__( 'Copy CSS', 'kata-plus' ) . '</div>';
					echo '</div>';
				}
				$last_font_family = $fontFamily;
				preg_match_all( '/(.*?)font-weight:(.*?)[;](.*)/', $css, $fw );
				$fontWeight = isset( $fw[2][0] ) && ! empty( $fw[2][0] ) ? $fw[2][0] : '';
				preg_match_all( '/(.*?)font-style:(.*?)[;](.*)/', $css, $fs );
				$fontStyle = isset( $fs[2][0] ) && ! empty( $fs[2][0] ) ? $fs[2][0] : '';

				echo '<iframe src="' . admin_url( 'admin-ajax.php' ) . '?action=kata_plus_pro_fonts_manager_font_preview&font-family=' . $fontFamily . '&source=custom-font&url=' . $url . '&font-weight=' . $fontWeight . '&font-style=' . $fontStyle . '&single-line=true&full=' . $full . '" class="font-preview-iframe"></iframe>';
				if ( $single ) {
					if ( isset( $_POST['url'] ) ) {
						die();}
					return;
				}
			}
			if ( $fontFamilies ) {
				$fontFamilies = implode( ', ', $fontFamilies );
				echo '<input type="hidden" name="fontname" value="' . $fontFamilies . '">';
			}
			if ( isset( $_POST['url'] ) ) {
				die();
			}
			return;
		}

		/**
		 * Render Font Preview
		 *
		 * @since     1.0.0
		 */
		public static function get_font_data_html( $source = '', $font_family = '', $return = false ) {

			if ( isset( $_REQUEST['source'] ) && ! $source ) {
				$source = $_REQUEST['source'];
			}

			if ( isset( $_REQUEST['font-family'] ) && ! $font_family ) {
				$font_family = $_REQUEST['font-family'];
			}

			if ( $source == 'google' ) {
				// $google_fonts = json_decode( file_get_contents( Kata_Plus_Pro::$dir . 'assets/src/json/google-webfonts.json' ) );
				$response = wp_remote_get(
					'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBOOsgUB12UtiN0m4IBv0DsDMx1_SHp57s',
					array(
						'timeout' => 20,
					)
				);
				// $google_fonts = json_decode( file_get_contents( Kata_Plus_Pro::$dir . 'assets/src/json/google-webfonts.json' ) );
				$google_fonts = json_decode( $response['body'] );
				foreach ( $google_fonts->items as $item ) {
					if ( $item->family == $font_family ) {
						$json_data = $item;
						break;
					}
				}
				if ( ! isset( $json_data ) ) {
					$data = [
						'variants'         => esc_html__( 'Not found!', 'kata-plus' ),
						'subsets'          => esc_html__( 'Not found!', 'kata-plus' ),
						'variants_options' => esc_html__( 'Not found!', 'kata-plus' ),
					];
					header( 'Content-Type: application/json' );
					echo json_encode( $data );
					die();
				}

				$variants         = '';
				$variants_options = '';
				foreach ( $json_data->variants as $variant ) {
					$variants         .= '<label><input type="checkbox" name="variants[]" value="' . $variant . '">' . $variant . '</label>';
					$variants_options .= '<option value="' . $variant . '">' . $variant . '</option>';
				}

				$subsets = '';
				foreach ( $json_data->subsets as $subset ) {
					$subsets .= '<label><input type="checkbox" name="subsets[]" value="' . $subset . '">' . $subset . '</label>';
				}
				$data = [
					'variants'         => $variants,
					'subsets'          => $subsets,
					'variants_options' => $variants_options,
				];

				if ( $return === true ) {
					return $data;
				}

				header( 'Content-Type: application/json' );
				echo json_encode( $data );
				die();
			} elseif ( $source == 'font-squirrel' ) {
				$font_family = str_replace( ' ', '-', $font_family );
				$url         = 'https://www.fontsquirrel.com/api/familyinfo/' . $font_family;
				$response    = wp_remote_get( $url );
				if ( is_array( $response ) ) {
					$data = $response['body']; // use the content
				} else {
					$data = [
						'variants'         => esc_html__( 'Not found!', 'kata-plus' ),
						'subsets'          => esc_html__( 'Not found!', 'kata-plus' ),
						'variants_options' => esc_html__( 'Not found!', 'kata-plus' ),
					];

					header( 'Content-Type: application/json' );
					echo json_encode( $data );
					die();
				}

				if ( ! is_array( $data ) && ! is_object( $data ) ) {
					$data = json_decode( $data, true );
				}

				$font_variants      = '';
				$variants_options   = '';
				$preview            = '';
				$font_preview_input = '';
				foreach ( $data as $font ) {
					$font_variants    .= '<label><input type="checkbox" name="variants[]" value="' . $font['style_name'] . '">' . $font['style_name'] . '</label>';
					$variants_options .= '<option value="' . $font['style_name'] . '">' . $font['style_name'] . '</option>';
					if ( $font['listing_image'] ) {
						empty( $font_preview_input ) ? $font_preview_input = '<input type="hidden" name="font_preview" value="' . $font['listing_image'] . '">' : '';
						$preview .= '<div class="preview-entry"><img src="' . $font['listing_image'] . '"><span>' . $font['style_name'] . '</span></div>';
					}
				}

				$data = [
					'variants'         => $font_variants,
					'variants_options' => $variants_options,
					'preview'          => $font_preview_input . $preview,
				];

				if ( $return === true ) {
					return $data;
				}

				header( 'Content-Type: application/json' );
				echo json_encode( $data );
				die();
			}
		}

		/**
		 * Render Font Preview
		 *
		 * @since     1.0.0
		 */
		public static function get_font_data( $source = '', $font_family = '' ) {

			if ( $source == 'google' ) {
				$response = wp_remote_get(
					'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBOOsgUB12UtiN0m4IBv0DsDMx1_SHp57s',
					array(
						'timeout' => 20,
					)
				);
				if ( isset( $response->errors ) ) {
					$google_fonts = json_decode( file_get_contents( Kata_Plus::$assets_dir . 'json/google-webfonts.json' ) )->items;
				} else {
					$google_fonts = json_decode( $response['body'] );
				}
				// $google_fonts = json_decode( file_get_contents( Kata_Plus_Pro::$dir . 'assets/src/json/google-webfonts.json' ) );
				foreach ( $google_fonts->items as $item ) {
					if ( $item->family == $font_family ) {
						return $item;
					}
				}
			} elseif ( $source == 'font-squirrel' ) {
				$font_family = str_replace( ' ', '-', $font_family );
				$url         = 'https://www.fontsquirrel.com/api/familyinfo/' . $font_family;
				$response    = wp_remote_get( $url );
				if ( is_array( $response ) ) {
					$data = $response['body']; // use the content
				} else {
					return false;
				}

				if ( ! is_array( $data ) && ! is_object( $data ) ) {
					$data = json_decode( $data, true );
				}
				return $data;
			}

			return false;
		}

		/**
		 * FontsManager Add new Font
		 *
		 * @since     1.0.0
		 */
		public static function add_new_font( $source, $url, $fontname, $variants, $subsets, $font_selectors, $font_placement = 'head', $font_status = 'published' ) {

			global $wpdb;
			$font_placement = empty( $font_placement ) ? 'head' : $font_placement;
			$font_status    = empty( $font_status ) ? 'published' : $font_status;

			$wpdb->insert(
				$wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
				array(
					'name'       => is_array( $fontname ) ? json_encode( $fontname ) : $fontname,
					'source'     => $source,
					'selectors'  => is_array( $font_selectors ) ? json_encode( $font_selectors ) : $font_selectors,
					'subsets'    => is_array( $subsets ) ? json_encode( $subsets ) : $subsets,
					'variants'   => is_array( $variants ) ? json_encode( $variants ) : $variants,
					'url'        => $url,
					'place'      => $font_placement,
					'status'     => $font_status,
					'created_at' => time(),
					'updated_at' => '',
				)
			);
			$id = $wpdb->insert_id;
			update_option( 'kata-fonts-manager-last-update', time() );
			return $id;
		}

		/**
		 * FontsManager Update Font
		 *
		 * @since     1.0.0
		 */
		public static function edit_font( $id, $source, $url, $fontname, $variants, $subsets, $font_selectors, $font_placement, $font_status ) {
			global $wpdb;
			$font_placement = empty( $font_placement ) ? 'head' : $font_placement;
			$font_status    = empty( $font_status ) ? 'published' : $font_status;
			update_option( 'kata-fonts-manager-last-update', time() );
			return $wpdb->update(
				$wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
				array(
					'name'       => is_array( $fontname ) ? json_encode( $fontname ) : $fontname,
					'selectors'  => is_array( $font_selectors ) ? json_encode( $font_selectors ) : $font_selectors,
					'subsets'    => is_array( $subsets ) ? json_encode( $subsets ) : $subsets,
					'variants'   => is_array( $variants ) ? json_encode( $variants ) : $variants,
					'url'        => $url,
					'place'      => $font_placement,
					'status'     => $font_status,
					'updated_at' => time(),
				),
				[ 'ID' => $id ]
			);
		}

		 /**
		  * Description
		  *
		  * @since     1.0.0
		  */
		public static function generate_font_css( $font ) {
			if ( $font['status'] == 'unpublished' ) {
				return '';
			}
			if ( $font['source'] == 'upload-icon' ) {
				return '';
			}

			$styles = '';
			if ( $font['source'] == 'upload-font' ) {

				$fontNames       = json_decode( $font['name'] );
				$fontSubfamilies = json_decode( $font['subsets'] );
				$fontWeights     = json_decode( $font['variants'] );
				$styles          = '';
				foreach ( json_decode( $font['url'] ) as $extension => $data ) :
					foreach ( $data as $key => $url ) {
						$fontName                        = $fontNames->$extension->$key;
						$fontSubfamily                   = $fontSubfamilies->$extension->$key;
						$fontWeight                      = $fontWeights->$extension->$key;
						$src                             = '';
						( $extension == 'ttf' ) ? $src   = 'url(' . $url . ") format('truetype')" : false;
						( $extension == 'otf' ) ? $src   = 'url(' . $url . ") format('opentype')" : false;
						( $extension == 'eot' ) ? $src   = "url('" . $url . "');\n\tsrc: url('" . $url . "?#iefix') format('embedded-opentype')" : false;
						( $extension == 'woff' ) ? $src  = 'url(' . $url . ") format('woff')" : false;
						( $extension == 'woff2' ) ? $src = 'url(' . $url . ") format('woff2')" : false;
						$styles                         .= '@font-face {
							font-family: "' . $fontName . '";
							font-style: ' . $fontSubfamily . ';
							font-weight: ' . $fontWeight . ';
							src: ' . $src . ';
						}';
					}
				endforeach;
			}

			$selectors    = is_array( $font['selectors'] ) ? $font['selectors'] : json_decode( $font['selectors'], true );
			$font['name'] = rtrim( $font['name'], ',' );

			foreach ( $selectors as $selector ) :
				$selector['variant'] = isset( $selector['variant'] ) ? $selector['variant'] : 'normal';
				$selector['variant'] = rtrim( $selector['variant'], ',' );
				$selector['variant'] = $selector['variant'] == 'regular' ? 'normal' : $selector['variant'];

				$styles .= <<<General
                    {$selector['selector']} {font-size: {$selector['font_sizes']['general']}{$selector['font_sizes']['unit']};font-family: {$font['name']};font-weight: {$selector['variant']};text-transform: {$selector['font_case']};}
General;

				if ( $selector['font_sizes']['desktop'] ) :
					$styles .= <<<Desktop
                        @media only screen and ( max-width: Device_Desktop ) { {$selector['selector']} { font-size: {$selector['font_sizes']['desktop']}{$selector['font_sizes']['unit']}; font-family: {$font['name']}; font-weight: {$selector['variant']}; text-transform: {$selector['font_case']}; } }
Desktop;
				endif;

				if ( $selector['font_sizes']['tablet'] ) :
					$styles .= <<<Tablet
                        @media only screen and ( max-width: Device_Tablet ) { {$selector['selector']} { font-size: {$selector['font_sizes']['tablet']}{$selector['font_sizes']['unit']}; font-family: {$font['name']}; font-weight: {$selector['variant']}; text-transform: {$selector['font_case']}; } }
Tablet;
				endif;

				if ( $selector['font_sizes']['mobile'] ) :
					$styles .= <<<Mobile
                        @media only screen and ( max-width: Device_Mobile ) { {$selector['selector']} { font-size: {$selector['font_sizes']['mobile']}{$selector['font_sizes']['unit']}; font-family: {$font['name']}; font-weight: {$selector['variant']}; text-transform: {$selector['font_case']}; } }
Mobile;
				endif;

			endforeach;

			$styles = str_replace(
				[
					'Device_Desktop',
					'Device_Tablet',
					'Device_Mobile',
					'text-transform: ;',
					'font-size: px;',
				],
				[
					self::$viewport_breakpoints['desktop'][0] . 'px',
					self::$viewport_breakpoints['tablet'][0] . 'px',
					self::$viewport_breakpoints['mobile'][0] . 'px',
					'',
					'',
				],
				$styles
			);

			return $styles;
		}


		/**
		 * Get Fonts
		 *
		 * @since   1.0.0
		 */
		public static function get_fonts() {
			global $wpdb;

			$sql    = 'SELECT * FROM ' . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name;
			$result = $wpdb->get_results( $sql, 'ARRAY_A' );
			return $result;
		}

	} //Class
endif;
