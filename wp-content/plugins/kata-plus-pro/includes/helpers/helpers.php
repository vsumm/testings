<?php

/**
 * Helpers Pro Class.
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
use Elementor\Group_Control_Image_Size;


if ( ! class_exists( 'Kata_Plus_Pro_Helpers' ) ) {
	class Kata_Plus_Pro_Helpers {
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Helpers
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
		public function __construct()
		{
			$this->actions();
		}

		/**
		 * Define the core functionality of the plugin.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			// add the filter
			add_filter( 'wp_kses_allowed_html', [$this, 'filter_wp_kses_allowed_html'], 10, 1 );
			add_filter( 'upload_mimes', [$this, 'mime_types'], 10, 1);
			add_action( 'kata_single_before_loop', [$this, 'post_view_counter'] );
			add_action( 'after_switch_theme', [$this, 'start_kata_plus'] );
			add_action( 'kata_plus_add_icon_set', [$this, 'icon_manager_icon_set'] );
			add_action( 'kata_plus_plugins', [$this, 'kata_plus_plugins'] );
			add_action( 'wp_enqueue_scripts', [$this, 'get_all_scripts_styles'], 999999999999 );
		}


		/**
		 * manage scripts and styles.
		 *
		 * @since   1.0.0
		 */
		public static function get_all_scripts_styles() {
			$result = [];
			$result['scripts'] = [];
			$result['styles'] = [];
		
			// Print all loaded Scripts
			global $wp_scripts;
			foreach( $wp_scripts->queue as $script ) :
			   $result['scripts'][] =  $script;
			endforeach;
		
			// Print all loaded Styles (CSS)
			global $wp_styles;
			foreach( $wp_styles->queue as $style ) :
			   $result['styles'][] =  $style;
			endforeach;

			$result = json_encode( $result, true );
			if ( ! get_option( 'kata_script_manager' ) ) {
				update_option( 'kata_script_manager', $result );
			}
		}

		/**
		 * Get MetaBox.
		 *
		 * @param string  $key Required. Post meta key.
		 * @param string  $id Optional. Post ID.
		 * @param boolean $single Optional. Add class to heading.
		 * @since   1.0.0
		 */
		public static function get_meta_box( $key, $id = '', $single = true ) {
			if ( function_exists( 'rwmb_meta' ) && '' === $id ) {
				return ! empty( rwmb_meta( $key ) ) || rwmb_meta( $key ) === '0' ? rwmb_meta( $key ) : '';
			} else {
				$id = $id ? $id : get_the_ID();
				return get_post_meta( $id, $key, $single );
			}
		}

		/**
		 * Post Counter Container.
		 *
		 * @since   1.0.0
		 */
		public function post_view_counter() {
			if ( ! get_post_meta( get_the_ID(), 'kata_post_view', true ) ) {
				add_post_meta( get_the_ID(), 'kata_post_view', 1 );
			} else {
				$i = get_post_meta( get_the_ID(), 'kata_post_view', true );
				$i++;
				update_post_meta( get_the_ID(), 'kata_post_view', $i );
			}
		}

		/**
		 * Add Svg to Kses
		 *
		 * @since   1.0.0
		 */
		public function filter_wp_kses_allowed_html($allowed_tags)
		{
			$allowed_tags['i']     = [
				'class' => true,
			];
			$allowed_tags['svg']   = [
				'version' => true,
				'xmlns'   => true,
				'width'   => true,
				'height'  => true,
				'viewbox' => true,
			];
			$allowed_tags['title'] = [];
			$allowed_tags['path']  = [
				'fill' => true,
				'd'    => true,
			];
			$allowed_tags['time']  = [
				'class'		=> true,
				'datetime'	=> true,
			];
			return $allowed_tags;
		}

		/**
		 * Add Svg to Kses
		 *
		 * @since   1.0.0
		 */
		public function mime_types($mimes = [])
		{
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}

		/**
		 * Insert attachment
		 *
		 * @since   1.0.0
		 */
		public static function insert_attachment($file_url)
		{
			$file        = $file_url;
			$filename    = basename($file);
			$upload_file = wp_upload_bits($filename, null, file_get_contents($file));

			if (!$upload_file['error']) {
				$wp_filetype   = wp_check_filetype($filename, null);
				$attachment    = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_parent'    => null,
					'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
					'post_content'   => '',
					'post_status'    => 'inherit',
				);
				$attachment_id = wp_insert_attachment($attachment, $upload_file['file'], null);
				$attach_url    = wp_get_attachment_url($attachment_id);

				if (!is_wp_error($attachment_id)) {
					require_once ABSPATH . 'wp-admin/includes/image.php';
					$attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
					wp_update_attachment_metadata($attachment_id, $attachment_data);
				}

				return [
					'id'  => $attachment_id,
					'url' => $attach_url,
				];
			}
		}

		/**
		 * Get current theme info.
		 *
		 * @since   1.0.0
		 */
		public static function get_theme()
		{
			$get_theme = wp_get_theme();
			if ($get_theme->parent_theme) {
				$get_theme = wp_get_theme(basename(get_template_directory()));
			}
			return $get_theme;
		}

		/**
		 * Get theme options.
		 *
		 * @since   1.0.0
		 */
		public static function get_theme_option($opts, $key, $default = '')
		{
			return isset($opts[$key]) ? $opts[$key] : $default;
		}

		/**
		 * SSL URL.
		 *
		 * @since   1.0.0
		 */
		public static function ssl_url()
		{
			return (is_ssl()) ? 'https://' : 'http://';
		}

		/**
		 * Check URL.
		 *
		 * @since   1.0.0
		 */
		public static function check_url($url)
		{
			$headers = @get_headers($url);
			$headers = (is_array($headers)) ? implode("\n ", $headers) : $headers;
			return (bool) preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
		}

		/**
		 * Get Image srcset.
		 *
		 * @since   1.0.0
		 */
		public static function get_attachment_image_html( $settings, $image_size_key = 'image' ) {
			$dim = '';
			$image = Group_Control_Image_Size::get_attachment_image_html( $settings, $image_size_key );
			$lazyload = get_theme_mod( 'kata_plus_pro_lazyload', 'disable' );

			if ( 'custom' === $settings[ $image_size_key . '_size' ] && $lazyload !== 'disable' || $lazyload === true ) {
				if ( isset( $settings[ $image_size_key . '_custom_dimension' ]['width'] ) && ! empty( $settings[ $image_size_key . '_custom_dimension' ]['width'] ) ) {
					$dim .= 'width="' . $settings[ $image_size_key . '_custom_dimension' ]['width'] . '"';
				}
				if ( isset( $settings[ $image_size_key . '_custom_dimension' ]['height'] ) && ! empty( $settings[ $image_size_key . '_custom_dimension' ]['height'] ) ) {
					$dim .= ' height="' . $settings[ $image_size_key . '_custom_dimension' ]['height'] . '"';
				}
				if ( $dim ) {
					$image = str_replace( 'src="', $dim . ' src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="', $image );
					$image = str_replace( 'srcset="', ' srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-srcset="', $image );
				}
			} else if ( 'custom' !== $settings[ $image_size_key . '_size' ] && $lazyload === true ) {
				$image = str_replace( 'src="', ' src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="', $image );
				$image = str_replace( 'srcset="', ' srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-srcset="', $image );
			}
			return $image;
		}

		/**
		 * Get Image srcset.
		 *
		 * @since   1.0.0
		 */
		public static function get_image_srcset($attachment_id = '', $size = 'full', $null = '', $image_meta = null) {
			if ( !empty( $attachment_id ) && is_numeric( $attachment_id ) ) {
				$image_meta		= ! empty( trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ) ) ? '' : $image_meta;
				$attachmet_meta = wp_get_attachment_metadata( $attachment_id );
				$dim = '';
				if ( 'full' !== $size && isset( $size[0] ) && ! empty( $size[0] ) ) {
					$dim .= 'width="' . $size[0] . '"';
				} else if ( 'full' !== $size && isset( $metadata['width'] ) && ! empty( $metadata['width'] ) ) {
					$dim .= 'width="' . $metadata['width'] . '"';
				}
				if ( 'full' !== $size && isset( $size[1] ) && ! empty( $size[1] ) ) {
					$dim .= ' height="' . $size[1] . '"';
				} else if ( 'full' !== $size && isset( $metadata['height'] ) && ! empty( $metadata['height'] ) ) {
					$dim .= ' height="' . $metadata['height'] . '"';
				}
				$lazyload = get_theme_mod( 'kata_plus_pro_lazyload', false );
				$image = wp_get_attachment_image( $attachment_id, $size, '', $image_meta );
				if ( $lazyload === true ) {
					$image = str_replace( 'src="', $dim . 'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="', $image);
					$image = str_replace( 'srcset="', 'srcset="#" data-srcset="', $image );
					return $image;
				} else {
					return $image;
				}
			}
		}

		/**
		 * Get Attachment SVG path.
		 *
		 * @since   1.0.0
		 */
		public static function get_attachment_svg_path( $id, $url, $attr = '', $class = '', $icon_attr = '' ) {
			if ($id) {
				if (self::string_is_contain($url, 'svg')) {
					if( $attr == 'medium' ) {
						$attr = 'width="300" height="300"';
					}
					switch ($attr) {
						case 'thumbnail':
							$attr = 'width="150" height="150"';
						break;
						case 'medium':
							$attr = 'width="300" height="300"';
						break;
						case 'medium_large':
							$attr = 'width="760"';
						break;
						case 'large':
							$attr = 'width="1024" height="1024"';
						break;
						case '1536x1536':
							$attr = 'width="1536" height="1536"';
						break;
						case '2048x2048':
							$attr = 'width="2048" height="2048"';
						break;
						case 'full':
							$attr = 'data-size="full"';
						break;
					}
					$svg = get_attached_file($id) ? file_get_contents(get_attached_file($id)) : __('No SVG file selected', 'kata-plus');
					if ($attr != '') {
						$svg = str_replace('<svg ', '<svg ' . $attr, $svg);
					}
					?>
					<i class="kata-svg-icon<?php echo ' ' . esc_attr( $class ); ?>"<?php echo ' ' . $icon_attr;?>>
						<?php echo '' . $svg; ?>
					</i>
					<?php
				}
			}
		}

		/**
		 * Is Blog Pages
		 *
		 * @since   1.0.0
		 */
		public static function is_blog_pages() {
			return ( (((is_search()) || is_archive()) ||  (is_author()) || (is_category()) || (is_home()) || (is_tag())) ) ? true : false ;
		}

		/**
		 * Is Blog Page
		 *
		 * @since   1.0.0
		 */
		public static function is_blog() {
			return ( is_home() ) ? true : false ;
		}

		/**
		 * SVG size
		 *
		 * @since   1.0.0
		 */
		public static function svg_resize( $size_type, $width = '', $height = '' ) {
			$thumbnail_w       = get_option('thumbnail_size_w') != '0' ? 'width="' . get_option('thumbnail_size_w') . '"' : '';
			$thumbnail_h       = get_option('thumbnail_size_h') != '0' ? ' height="' . get_option('thumbnail_size_h') . '"' : '';
			$medium_w          = get_option('medium_size_w') != '0' ? 'width="' . get_option('medium_size_w') . '"' : '';
			$medium_h          = get_option('medium_size_h') != '0' ? ' height="' . get_option('medium_size_h') . '"' : '';
			$large_w           = get_option('large_size_w') != '0' ? 'width="' . get_option('large_size_w') . '"' : '';
			$large_h           = get_option('large_size_h') != '0' ? ' height="' . get_option('large_size_h') . '"' : '';
			$medium_large_w    = get_option('medium_large_size_w') != '0' ? 'width="' . get_option('medium_large_size_w') . '"' : '';
			$medium_large_h    = get_option('medium_large_size_h') != '0' ? ' height="' . get_option('medium_large_size_h') . '"' : '';
			$thumbnail_size    = $thumbnail_w . $thumbnail_h;
			$medium_size       = $medium_w . $medium_h;
			$medium_large_size = $medium_large_w . $medium_large_h;
			$large_size        = $large_w . $large_h;

			if ($size_type != 'custom') {
				switch ($size_type) {
					case 'thumbnail':
						$svg_size = $thumbnail_size;
						break;
					case 'medium':
						$svg_size = $medium_size;
						break;
					case 'medium_large':
						$svg_size = $medium_large_size;
						break;
					case 'large':
						$svg_size = $large_size;
						break;
					case 'full':
						$svg_size = '';
						break;
				}
			} else {
				$custom_w = $width ? 'width="' . esc_attr($width) . '"' : '';
				$custom_h = $height ? ' height="' . esc_attr($height) . '" ' : '';
				$svg_size = $custom_w . $custom_h;
			}
			return $svg_size;
		}

		/**
		 * Get Image srcset.
		 *
		 * @since   1.0.0
		 */
		public static function get_link_attr( $data ) {
			$link_src         = new stdClass();
			$link_src->src    = $data['url'] != '' ? 'href="' . esc_url( $data['url'], self::ssl_url()) . '"' : '';
			$link_src->rel    = $data['nofollow'] != '' ? ' rel="nofollow"' : '';
			$link_src->target = $data['is_external'] != '' ? ' target="_blank"' : '';
			$link_src->attr   = explode(',', $data['custom_attributes']);
			if ($link_src->src) {
				if ($data['custom_attributes']) {
					foreach ($link_src->attr as $value) {
						$link_src->src .= ' ' . str_replace('|', '="', $value) . '"';
					}
				}
			}
			return $link_src;
		}

		/**
		 * Minimum capability.
		 *
		 * @since   1.0.0
		 */
		public static function capability() {
			return 'manage_options';
		}

		/**
		 * CSS Minifier.
		 *
		 * @since   1.0.0
		 */
		public static function cssminifier( $css ) {
			$css = str_replace(
				["\r\n", "\r", "\n", "\t", '    '],
				'',
				preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', trim( $css ) )
			);
			return str_replace(
				['  ', '{ ', ' }', ' {', '} ', ' screen and ', '; ', ', ', ': '],
				['','{','}','{','}','',';',',',':'],
				$css
			);
		}

		/**
		 * JS Minifier.
		 *
		 * @since   1.0.0
		 */
		public static function jsminifier( $js ) {
			$js = str_replace(
				["\r\n", "\r", "\n", "\t", '    '],
				'',
				preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', trim( $js ) )
			);
			return str_replace(
				['  ', '{ ', ' }', ' {', '} ', '; ', ', ', ': ', ' ('],
				['','{','}','{','}',';',',',':', '('],
				$js
			);
		}

		/**
		 * Post Excerpt.
		 *
		 * @since   1.0.0
		 */
		public static function post_excerpt( $n ) {
			return substr(get_the_content(), 0, $n);
		}

		/**
		 * Post Formats.
		 *
		 * @since   1.0.0
		 */
		public static function post_format_icon()
		{
			echo '<div class="kata-post-format">';
			if (get_post_format() == 'gallery') {
				echo self::get_icon('', 'themify/gallery', '', '');
			} elseif (get_post_format() == 'link') {
				echo self::get_icon('', 'themify/link', '', '');
			} elseif (get_post_format() == 'image') {
				echo self::get_icon('', 'themify/image', '', '');
			} elseif (get_post_format() == 'quote') {
				echo self::get_icon('', 'themify/quote-left', '', '');
			} elseif (get_post_format() == 'status') {
				echo self::get_icon('', 'themify/pencil', '', '');
			} elseif (get_post_format() == 'video') {
				echo self::get_icon('', 'themify/video-camera', '', '');
			} elseif (get_post_format() == 'aside') {
				echo self::get_icon('', 'themify/plus', '', '');
			} else {
				echo self::get_icon('', 'themify/notepad', '', '');
			}
			echo '</div>';
		}

		/**
		 * Allow to start kata plus.
		 *
		 * @since   1.0.0
		 */
		public function start_kata_plus() {
			if ( ! defined( 'KATA_VERSION' ) ) {
				deactivate_plugins( Kata_Plus::$name );
				if ( wp_safe_redirect( admin_url( 'themes.php' ) ) ) {
					exit;
				}
			}
		}

		/**
		 * Sanatize CSS value.
		 *
		 * @since   1.0.0
		 */
		public static function validate_unit_of_number($value)
		{
			if (is_numeric($value)) :
				return $value . 'px';
			endif;

			return $value;
		}

		/**
		 * Make File.
		 *
		 * @since   1.0.0
		 */
		public static function mkfile($path, $name)
		{
			if (!file_exists( $path . '/' . $name )) {
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
					WP_Filesystem();
				}
				$wp_filesystem->put_contents(
					$path . '/' . $name,
					'',
					FS_CHMOD_FILE
				);
			}
		}

		/**
		 * Make and write File.
		 *
		 * @since   1.0.0
		 */
		public static function wrfile($path, $content)
		{
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			$wp_filesystem->put_contents( $path, $content, 0644 );
		}

		/**
		 * Read File.
		 *
		 * @since   1.0.0
		 */
		public static function rfile($path)
		{
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			return $wp_filesystem->get_contents( $path );
		}

		/**
		 * Remove Directory.
		 *
		 * @since   1.0.0
		 */
		public static function rmdir($path)
		{
			if (file_exists($path)) {
				if (!class_exists('WP_Filesystem_Base')) {
					global $wp_filesystem;
					if (empty($wp_filesystem)) {
						require_once ABSPATH . '/wp-admin/includes/file.php';
						WP_Filesystem();
					}
				}
				global $wp_filesystem;
				$wp_filesystem->rmdir($path, true);
			}
		}

		/**
		 * Make Directory.
		 *
		 * @since   1.0.0
		 */
		public static function mkdir($path) {
			if (!file_exists($path)) {
				if (!class_exists('WP_Filesystem_Base')) {
					global $wp_filesystem;
					if (empty($wp_filesystem)) {
						require_once ABSPATH . '/wp-admin/includes/file.php';
						WP_Filesystem();
					}
				}
				// global $wp_filesystem;
				// $wp_filesystem->mkdir($path, false);
				mkdir($path, 0777);
			}
		}

		/**
		 * Get icon url.
		 *
		 * @since   1.0.0
		 */
		public static function get_icon_dir( $font_family = '', $icon_name ) {
			$font_family = $font_family ? $font_family . '/' : '';
			$assets_dir = self::string_is_contain( $font_family, '7-stroke' ) || self::string_is_contain( $icon_name, '7-stroke' ) && class_exists( 'Kata_Plus_Pro' ) ? Kata_Plus_Pro::$assets_dir : Kata_Plus::$assets_dir;
			return apply_filters( 'kata-get-icon-dir', $assets_dir . 'fonts/svg-icons/' . $font_family . $icon_name . '.svg' );
		}

		/**
		 * Get icon url.
		 *
		 * @since   1.0.0
		 */
		public static function get_icon_url( $font_family = '', $icon_name ) {
			return self::abs_path_to_url( static::get_icon_dir( $font_family, $icon_name ) );
		}

		/**
		 * path to url.
		 *
		 * @since   1.0.0
		 */
		public static function abs_path_to_url($path = '')
		{
			$url = str_replace(
				wp_normalize_path(untrailingslashit(ABSPATH)),
				site_url(),
				wp_normalize_path($path)
			);
			return esc_url_raw($url);
		}

		/**
		 * Get SVG icon.
		 *
		 * @since   1.0.0
		 */
		public static function get_icon($font_family = '', $icon_name, $custom_class = '', $extra_attr = '') {
			if ( ! empty( $icon_name ) ) {
				$custom_class = !empty($custom_class) ? ' ' . $custom_class : '';
				$extra_attr   = !empty($extra_attr) ? ' ' . $extra_attr : '';
				$icon = file_get_contents( self::get_icon_dir( $font_family, $icon_name ) );
				return '<i class="kata-icon' . $custom_class . '"' . $extra_attr . '>' . $icon . '</i>';
			}
			return '';
		}

		/**
		 * String is Contain
		 *
		 * @since   1.0.0
		 */
		public static function string_is_contain($string, $search)
		{
			if (strpos($string, $search) !== false) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Get Latest Post ID.
		 *
		 * @since   1.0.0
		 */
		public static function get_latest_post_id() {
			if (!Plugin::$instance->editor->is_edit_mode()) {
				return;
			}

			$latest_post = get_posts('post_type=post&numberposts=1');
			return $latest_post[0]->ID;
		}

		/**
		 * Get Latest Course ID.
		 *
		 * @since   1.0.0
		 */
		public static function get_latest_course_id() {
			if ( ! Plugin::$instance->editor->is_edit_mode() ) {
				return get_the_ID();
			} else {
				$latest_post = get_posts( 'post_type=lp_course&numberposts=1' );
				return $latest_post[0]->ID;
			}

		}

		/**
		 * Image Resizer
		 *
		 * @since   1.0.0
		 */
		public static function image_resize( $id, $size = [] ) {
			if ( !empty( $id ) && $size[1] ) {
				$file     = get_attached_file($id, true);
				$img_path  = realpath($file);
				$file_exists = str_replace(
					['.jpg','.png'],
					[
						'-' . $size[0] . 'x' . $size[1] . '.jpg',
						'-' . $size[0] . 'x' . $size[1] . '.png'
					],
				$img_path );
				if( ! file_exists( $file_exists ) ) {
					$image    = wp_get_image_editor(wp_get_attachment_url($id));
					$filename = wp_basename( $img_path );
					$src      = str_replace($filename, '', $img_path);
					if ( ! is_wp_error( $image ) ) {
						$image->resize($size['0'], $size['1'], true);
						$save_name = $image->generate_filename($size[0] . 'x' . $size[1], $src, null);
						$save      = $image->save($save_name);
						return str_replace($filename, $save['file'], wp_get_attachment_url($id));
					}
				} else {
					return str_replace(
						['.jpg','.png'],
						[
							'-' . $size[0] . 'x' . $size[1] . '.jpg',
							'-' . $size[0] . 'x' . $size[1] . '.png'
						],
					wp_get_attachment_url( $id ) );
				}
			} else {
				return wp_get_attachment_url( $id );
			}
		}

		/**
		 * Image Resize Output
		 *
		 * @since   1.0.0
		 */
		public static function image_resize_output( $id = '', $size = [], $custom_attr = '', $classes = '' ) {
			$id = $id ? $id : get_post_thumbnail_id();
			$alt = get_post_meta( $id, '_wp_attachment_image_alt', true ) ? ' alt=' . get_post_meta( $id, '_wp_attachment_image_alt', true ) . ' ' : ' alt ';
			$classes = $classes ? 'kata-single-post-featured-image ' . $classes : 'kata-single-post-featured-image';
			$dim = '';
			$metadata = wp_get_attachment_metadata( $id );
			$dim .= is_array($size) && isset( $size[0] ) && ! empty( $size[0] ) ? 'width=' . $size[0] : 'width=' . $metadata['width'] ;
			$dim .= is_array($size) && isset( $size[1] ) && ! empty( $size[1] ) ? ' height=' . $size[1] : ' height=' . $metadata['height'];
			$lazyload = get_theme_mod( 'kata_plus_pro_lazyload', false );
			if ( $lazyload === true ) {
				$src = ' src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' . self::image_resize( $id, $size ) . '"';
			} else {
				$src = ' src="' . self::image_resize( $id, $size ) . '"';
			}
			echo '<img ' . esc_attr( $dim ) . $src . '  class="' . esc_attr( $classes ) . '" ' . esc_attr( $alt ) . esc_attr( $custom_attr ) . '>';
		}

		/**
		 * get string between
		 * https://stackoverflow.com/questions/5696412/how-to-get-a-substring-between-two-strings-in-php
		 * @since   1.0.0
		 */
		public static function get_string_between( $string, $start, $end ) {
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr($string, $ini, $len);
		}

		/**
		 * generate video
		 * 
		 * @since   1.0.0
		 */
		public static function video_player( $url ) {
			if ( self::string_is_contain( $url, 'https://www.youtube.com/watch?v=' ) ) {
				$url = str_replace( 'https://www.youtube.com/watch?v=', '', $url );
				$url = ' data-video="' . esc_url( 'https://www.youtube.com/embed/' . $url ) . '" data-videotype="' . esc_attr( 'youtube' ) . '"';
			} else if ( self::string_is_contain( $url, 'https://youtu.be/' ) ) {
				$url = str_replace( 'https://youtu.be/', '', $url );
				$url = ' data-video="' . esc_url( 'https://www.youtube.com/embed/' . $url ) . '" data-videotype="' . esc_attr( 'youtube' ) . '"';
			} else if ( self::string_is_contain( $url, 'https://www.youtube.com/embed/' ) ) {
				$url = ' data-video="' . esc_url( $url ) . '" data-videotype="youtube"';
			} else if ( self::string_is_contain( $url, 'https://vimeo.com/' ) && ! self::string_is_contain( $url, 'player.vimeo.com' ) ) {
				$url = str_replace( 'https://vimeo.com/', '', $url );
				$url = ' data-video="' . esc_url( 'https://player.vimeo.com/video/' . $url ) . '" data-videotype="' . esc_attr( 'vimeo' ) . '"';
			} else if ( self::string_is_contain( $url, 'https://player.vimeo.com/video/' ) ) {
				$url = ' data-video="' . esc_url( $url ) . '" data-videotype="' . esc_attr( 'vimeo' ) . '"';
			} else if ( self::string_is_contain( $url, site_url() ) ) {
				$url = ' data-video="' . esc_url( $url ) . '" data-videotype="' . esc_attr( 'hosted' ) . '"';
			}
			if ( ! $url ) {
				return false;
			}
			return $url;
		}

		/**
		 * Comments Template for Single Builder
		 *
		 * @since   1.0.0
		 */
		public static function comments_template() {
			?>
			<div id="kata-comments" class="kata-comments-area">
				<ul class="kata-comment-list">
					<!-- #comment-## -->
					<li id="comment-8" class="comment odd alt thread-odd thread-alt depth-1">
						<article id="div-comment-8" class="comment-body">
							<footer class="comment-meta">
								<div class="comment-author vcard"> <img alt=""
										src="http://1.gravatar.com/avatar/75e48a7020624657e5da6033590030ee?s=81&amp;d=mm&amp;r=g"
										srcset="http://1.gravatar.com/avatar/75e48a7020624657e5da6033590030ee?s=162&amp;d=mm&amp;r=g 2x"
										class="avatar avatar-81 photo" height="81" width="81" loading="lazy"> <b class="fn">Anonymous
										User</b> <span class="says">says:</span> </div><!-- .comment-author -->
								<div class="comment-metadata"> <a href="http://localhost/kata/template-comments/#comment-8"><time
											datetime="2013-03-11T23:45:54+00:00">March 11, 2013 at 11:45 pm</time></a> <span
										class="edit-link"><a class="comment-edit-link"
											href="http://localhost/kata/wp-admin/comment.php?action=editcomment&amp;c=8">Edit</a></span>
								</div><!-- .comment-metadata -->
							</footer><!-- .comment-meta -->
							<div class="comment-content">
								<p>This user it trying to be anonymous.</p>
								<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui excepturi atque velit mollitia quaerat,
									dolore iusto molestiae numquam laboriosam fugiat, ipsa quod ad rerum saepe, quas ex nobis ratione
									sunt!</p>
							</div><!-- .comment-content -->
							<div class="reply"><a rel="nofollow" class="comment-reply-link"
									href="http://localhost/kata/template-comments/?replytocom=8#respond" data-commentid="8"
									data-postid="1148" data-belowelement="div-comment-8" data-respondelement="respond"
									data-replyto="Reply to Anonymous User" aria-label="Reply to Anonymous User">Reply</a></div>
						</article><!-- .comment-body -->
					</li>
					<li id="comment-12" class="comment odd alt thread-odd thread-alt depth-1 parent">
						<article id="div-comment-12" class="comment-body">
							<footer class="comment-meta">
								<div class="comment-author vcard"> <img alt=""
										src="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=81&amp;d=mm&amp;r=g"
										srcset="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=162&amp;d=mm&amp;r=g 2x"
										class="avatar avatar-81 photo" height="81" width="81" loading="lazy"> <b class="fn"><a
											href="http://example.org/" rel="external nofollow ugc" class="url">John Κώστας Doe
											Τάδε</a></b> <span class="says">says:</span> </div><!-- .comment-author -->
								<div class="comment-metadata"> <a href="http://localhost/kata/template-comments/#comment-12"><time
											datetime="2013-03-14T07:57:01+00:00">March 14, 2013 at 7:57 am</time></a> <span
										class="edit-link"><a class="comment-edit-link"
											href="http://localhost/kata/wp-admin/comment.php?action=editcomment&amp;c=12">Edit</a></span>
								</div><!-- .comment-metadata -->
							</footer><!-- .comment-meta -->
							<div class="comment-content">
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor voluptas autem minima et modi,
									possimus perferendis tempore sit esse rerum!</p>
							</div><!-- .comment-content -->
							<div class="reply"><a rel="nofollow" class="comment-reply-link"
									href="http://localhost/kata/template-comments/?replytocom=12#respond" data-commentid="12"
									data-postid="1148" data-belowelement="div-comment-12" data-respondelement="respond"
									data-replyto="Reply to John Κώστας Doe Τάδε" aria-label="Reply to John Κώστας Doe Τάδε">Reply</a>
							</div>
						</article><!-- .comment-body -->
						<ul class="children">
							<li id="comment-13" class="comment even depth-2 parent">
								<article id="div-comment-13" class="comment-body">
									<footer class="comment-meta">
										<div class="comment-author vcard"> <img alt=""
												src="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=81&amp;d=mm&amp;r=g"
												srcset="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=162&amp;d=mm&amp;r=g 2x"
												class="avatar avatar-81 photo" height="81" width="81" loading="lazy"> <b class="fn"><a
													href="http://example.org/" rel="external nofollow ugc" class="url">Jane
													Bloggs</a></b> <span class="says">says:</span> </div><!-- .comment-author -->
										<div class="comment-metadata"> <a
												href="http://localhost/kata/template-comments/#comment-13"><time
													datetime="2013-03-14T08:01:21+00:00">March 14, 2013 at 8:01 am</time></a> <span
												class="edit-link"><a class="comment-edit-link"
													href="http://localhost/kata/wp-admin/comment.php?action=editcomment&amp;c=13">Edit</a></span>
										</div><!-- .comment-metadata -->
									</footer><!-- .comment-meta -->
									<div class="comment-content">
										<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui excepturi atque velit mollitia
											quaerat, dolore iusto molestiae numquam laboriosam fugiat, ipsa quod ad rerum saepe, quas ex
											nobis ratione sunt!</p>
									</div><!-- .comment-content -->
									<div class="reply"><a rel="nofollow" class="comment-reply-link"
											href="http://localhost/kata/template-comments/?replytocom=13#respond" data-commentid="13"
											data-postid="1148" data-belowelement="div-comment-13" data-respondelement="respond"
											data-replyto="Reply to Jane Bloggs" aria-label="Reply to Jane Bloggs">Reply</a></div>
								</article><!-- .comment-body -->
								<ul class="children">
									<li id="comment-14" class="comment odd alt depth-3 parent">
										<article id="div-comment-14" class="comment-body">
											<footer class="comment-meta">
												<div class="comment-author vcard"> <img alt=""
														src="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=81&amp;d=mm&amp;r=g"
														srcset="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=162&amp;d=mm&amp;r=g 2x"
														class="avatar avatar-81 photo" height="81" width="81" loading="lazy"> <b
														class="fn"><a href="http://example.org/" rel="external nofollow ugc"
															class="url">Fred Bloggs</a></b> <span class="says">says:</span> </div>
												<!-- .comment-author -->
												<div class="comment-metadata"> <a
														href="http://localhost/kata/template-comments/#comment-14"><time
															datetime="2013-03-14T08:02:06+00:00">March 14, 2013 at 8:02 am</time></a>
													<span class="edit-link"><a class="comment-edit-link"
															href="http://localhost/kata/wp-admin/comment.php?action=editcomment&amp;c=14">Edit</a></span>
												</div><!-- .comment-metadata -->
											</footer><!-- .comment-meta -->
											<div class="comment-content">
												<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui excepturi atque velit
													mollitia quaerat, dolore iusto molestiae numquam laboriosam fugiat, ipsa quod ad
													rerum saepe, quas ex nobis ratione sunt!</p>
											</div><!-- .comment-content -->
											<div class="reply"><a rel="nofollow" class="comment-reply-link"
													href="http://localhost/kata/template-comments/?replytocom=14#respond"
													data-commentid="14" data-postid="1148" data-belowelement="div-comment-14"
													data-respondelement="respond" data-replyto="Reply to Fred Bloggs"
													aria-label="Reply to Fred Bloggs">Reply</a></div>
										</article><!-- .comment-body -->
										<ul class="children">
											<li id="comment-15" class="comment even depth-4 parent">
												<article id="div-comment-15" class="comment-body">
													<footer class="comment-meta">
														<div class="comment-author vcard"> <img alt=""
																src="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=81&amp;d=mm&amp;r=g"
																srcset="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=162&amp;d=mm&amp;r=g 2x"
																class="avatar avatar-81 photo" height="81" width="81" loading="lazy"> <b
																class="fn"><a href="http://example.org/" rel="external nofollow ugc"
																	class="url">Fred Bloggs</a></b> <span class="says">says:</span>
														</div><!-- .comment-author -->
														<div class="comment-metadata"> <a
																href="http://localhost/kata/template-comments/#comment-15"><time
																	datetime="2013-03-14T08:03:22+00:00">March 14, 2013 at 8:03
																	am</time></a> <span class="edit-link"><a class="comment-edit-link"
																	href="http://localhost/kata/wp-admin/comment.php?action=editcomment&amp;c=15">Edit</a></span>
														</div><!-- .comment-metadata -->
													</footer><!-- .comment-meta -->
													<div class="comment-content">
														<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui excepturi atque
															velit mollitia quaerat, dolore iusto molestiae numquam laboriosam fugiat,
															ipsa quod ad rerum saepe, quas ex nobis ratione sunt!</p>
													</div><!-- .comment-content -->
													<div class="reply"><a rel="nofollow" class="comment-reply-link"
															href="http://localhost/kata/template-comments/?replytocom=15#respond"
															data-commentid="15" data-postid="1148" data-belowelement="div-comment-15"
															data-respondelement="respond" data-replyto="Reply to Fred Bloggs"
															aria-label="Reply to Fred Bloggs">Reply</a></div>
												</article><!-- .comment-body -->
												<ul class="children">
													<li id="comment-16" class="comment odd alt depth-5 parent">
														<article id="div-comment-16" class="comment-body">
															<footer class="comment-meta">
																<div class="comment-author vcard"> <img alt=""
																		src="http://1.gravatar.com/avatar/4fdb3b572ac7dd8d7a58ba70317efa14?s=81&amp;d=mm&amp;r=g"
																		srcset="http://1.gravatar.com/avatar/4fdb3b572ac7dd8d7a58ba70317efa14?s=162&amp;d=mm&amp;r=g 2x"
																		class="avatar avatar-81 photo" height="81" width="81"
																		loading="lazy"> <b class="fn"><a
																			href="https://wpthemetestdata.wordpress.com/"
																			rel="external nofollow ugc" class="url">themedemos</a></b>
																	<span class="says">says:</span> </div><!-- .comment-author -->
																<div class="comment-metadata">
																	<a href="http://localhost/kata/template-comments/#comment-16"><time datetime="2013-03-14T08:10:29+00:00">March 14, 2013 at 8:10 am</time></a> <span class="edit-link"><a class="comment-edit-link" href="http://localhost/kata/wp-admin/comment.php?action=editcomment&amp;c=16">Edit</a></span>
																</div><!-- .comment-metadata -->
															</footer><!-- .comment-meta -->
															<div class="comment-content">
																<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui excepturi atque velit mollitia quaerat, dolore iusto molestiae numquam laboriosam fugiat, ipsa quod ad rerum saepe, quas ex nobis ratione sunt!</p>
															</div><!-- .comment-content -->
														</article><!-- .comment-body -->
													</li><!-- #comment-## -->
													<li id="comment-17" class="comment even depth-5 parent">
														<article id="div-comment-17" class="comment-body">
															<footer class="comment-meta">
																<div class="comment-author vcard"> <img alt=""
																		src="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=81&amp;d=mm&amp;r=g"
																		srcset="http://0.gravatar.com/avatar/f72c502e0d657f363b5f2dc79dd8ceea?s=162&amp;d=mm&amp;r=g 2x"
																		class="avatar avatar-81 photo" height="81" width="81"
																		loading="lazy"> <b class="fn"><a href="http://example.org/"
																			rel="external nofollow ugc" class="url">Jane Bloggs</a></b>
																	<span class="says">says:</span> </div><!-- .comment-author -->
																<div class="comment-metadata">
																	<a href="http://localhost/kata/template-comments/#comment-17"><time datetime="2013-03-14T08:12:16+00:00">March 14, 2013 at 8:12 am</time></a> <span class="edit-link"><a class="comment-edit-link" href="http://localhost/kata/wp-admin/comment.php?action=editcomment&amp;c=17">Edit</a></span>
																</div><!-- .comment-metadata -->
															</footer><!-- .comment-meta -->
															<div class="comment-content">
																<p>Comment Depth 06 has some more text than some of the other comments on this post.</p>
															</div><!-- .comment-content -->
														</article><!-- .comment-body -->
													</li><!-- #comment-## -->
													<!-- #comment-## -->
												</ul><!-- .children -->
											</li><!-- #comment-## -->
										</ul><!-- .children -->
									</li><!-- #comment-## -->
								</ul><!-- .children -->
							</li><!-- #comment-## -->
						</ul><!-- .children -->
					</li>
				</ul>
			</div>
			<?php
		}

		/**
		 * get string between
		 *
		 * @since   1.0.0
		 */
		public function icon_manager_icon_set() {
			echo '<div class="management-btn" data-back-text="' . __('Back To Icon List', 'kata-plus') . '" data-text="' . __('Add Icon Set', 'kata-plus') . '">' .  __('Add Icon Set', 'kata-plus') . '</div>';
		}

		/**
		 * get string between
		 *
		 * @since   1.0.0
		 */
		public function kata_plus_plugins( $plugins ) {
			$Kata_Plus_Install_Plugins = new Kata_Plus_Install_Plugins;
			$new_plugins = [
				[
					'name'      => esc_html__('Quform', 'kata-plus'),
					'slug'      => 'quform',
					'author'    => '<a href="' . esc_url( 'https://www.themecatcher.net/' ) . '">' . esc_html__('ThemeCatcher', 'kata-plus') . '</a>',
					'images_url'  => $Kata_Plus_Install_Plugins->images_url . 'kata-plugin-icon-4.png',
					'source'    => $Kata_Plus_Install_Plugins->plugins_dir . 'quform.zip',
					'version'    => '2.12.0',
					'fast-mode'   => true,
				],
				[
					'name'      => esc_html__('Slider Revolution', 'kata-plus'),
					'slug'      => 'revslider',
					'author'    => '<a href="' . esc_url( 'https://www.themepunch.com/' ) . '">' . esc_html__('ThemePunch', 'kata-plus') . '</a>',
					'images_url'  => $Kata_Plus_Install_Plugins->images_url . 'kata-plugin-icon-5.png',
					'source'    => $Kata_Plus_Install_Plugins->plugins_dir . 'revslider.zip',
					'version'    => '6.2.12',
					'fast-mode'   => false,
				],
				[
					'name'      => esc_html__('LayerSlider', 'kata-plus'),
					'slug'      => 'LayerSlider',
					'author'    => '<a href="' . esc_url( 'https://kreaturamedia.com/' ) . '">' . esc_html__('Kreatura Media', 'kata-plus') . '</a>',
					'images_url'  => $Kata_Plus_Install_Plugins->images_url . 'kata-plugin-icon-34.png',
					'source'    => $Kata_Plus_Install_Plugins->plugins_dir . 'LayerSlider.zip',
					'version'    => '6.11.8',
					'fast-mode'   => false,
				],
				[
					'name'      => esc_html__('FileBird', 'kata-plus'),
					'slug'      => 'filebird',
					'author'    => '<a href="' . esc_url( 'https://ninjateam.org' ) . '">' . esc_html__('FileBird', 'kata-plus') . '</a>',
					'images_url'  => $Kata_Plus_Install_Plugins->images_url . 'kata-plugin-icon-7.png',
					'source'    => $Kata_Plus_Install_Plugins->plugins_dir . 'filebird-wordpress-media-library-folders.zip',
					'version'    => '3.9',
					'fast-mode'   => false,
				],
				[
					'name'      => esc_html__('Essential Grid', 'kata-plus'),
					'slug'      => 'essential-grid',
					'author'    => '<a href="' . esc_url( 'https://themepunch.com' ) . '">' . esc_html__('ThemePunch', 'kata-plus') . '</a>',
					'images_url'  => $Kata_Plus_Install_Plugins->images_url . 'kata-plugin-icon-12.png',
					'source'    => $Kata_Plus_Install_Plugins->plugins_dir . 'essential-grid.zip',
					'version'    => '3.0.8',
					'fast-mode'   => false,
				],
				[
					'name'      => esc_html__('Advanced Custom Fields PRO', 'kata-plus'),
					'slug'      => 'advanced-custom-fields-pro',
					'author'    => '<a href="' . esc_url( 'https://www.advancedcustomfields.com' ) . '">' . esc_html__('Elliot Condon', 'kata-plus') . '</a>',
					'images_url'  => $Kata_Plus_Install_Plugins->images_url . 'kata-plugin-icon-1.png',
					'source'    => $Kata_Plus_Install_Plugins->plugins_dir . 'advanced-custom-fields-pro.zip',
					'version'    => '5.8.12',
					'fast-mode'   => false,
				],
			];
			return array_merge( $new_plugins, $plugins );
		}

	} // class

	Kata_Plus_Pro_Helpers::get_instance();
}
