<?php
/**
 * Minify JS and CSS.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.1.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Kata_Plus_Pro_Minifier.
 */
class Kata_Plus_Pro_Minifier {
	/**
	 * Instance of this class.
	 *
	 * @since   4.5.7
	 * @access  public
	 * @var     Kata_Plus_Pro_Minifier
	 */
	public static $instance;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   4.5.7
	 * @return  object
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private $dir;

	private $host;

	private $minify_scripts;

	private $root;

	private $css_imports;

	private $wp_dir;

	private $count;

	private $is_merged;

	private $wp_content;

	/**
	 * Constructor.
	 *
	 * @since 4.5.7
	 * @access private
	 */
	private function __construct() {
		if ( false == get_theme_mod( 'kata_plus_pro_css_minify', false ) && false == get_theme_mod( 'kata_plus_pro_js_minify', false ) ) {
			return;
		}

		if ( is_admin() ) {
			return;
		}

        $this->definition();
		add_action( 'init', [$this, 'init'] );
		add_action( 'customize_preview_init', [$this, 'purgeAll'] );
		add_action( 'save_post', [$this, 'purgeAll'] );
	}

	/**
	 * Definition.
	 *
	 * @since 4.5.7
	 * @access private
	 */
	private function definition() {
		$this->dir				= Kata_Plus_Pro_Theme_Options::$dir . 'functions/minify/';
		$this->count			= 0;
		$this->minify_scripts	= false;
		$this->css_imports		= true;
		$this->wp_content		= parse_url( WP_CONTENT_URL,PHP_URL_PATH );
		$this->root				= $_SERVER["DOCUMENT_ROOT"];
		$this->wp_dir			= rtrim( parse_url( network_site_url(), PHP_URL_PATH ),'/' );

		define( 'KATA_CACHE_DIR', WP_CONTENT_DIR . '/cache/kata/min' );
		define( 'KATA_CACHE_URL', WP_CONTENT_URL . '/cache/kata/min' );
		define( 'KATA_JS_CACHE_URL', KATA_CACHE_URL );
		define( 'KATA_CSS_CACHE_URL', KATA_CACHE_URL );
	}

	public function purgeAll() {
		foreach ( glob( KATA_CACHE_DIR . '/*' ) as $files ) {
			wp_delete_file( $files );
		}
	}

	public function init() {
		
		wp_mkdir_p( KATA_CACHE_DIR );

		if ( array_key_exists('HTTP_HOST', $_SERVER) ) {
			$this->host = $_SERVER['HTTP_HOST'];

			if ( mb_substr($this->host, 0, 4) !== 'http' ) {
				$this->host = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 's' : '') . '://' . $this->host;
			}
			$this->host = parse_url($this->host, PHP_URL_HOST);
		}

		foreach( $this->get_files_to_minify( 'css' ) as $path ) {
			$this->compress_css( $path );
		}

		if ( $this->minify_scripts ) {
			foreach( $this->get_files_to_minify( 'js' ) as $path ) {
				$this->compress_js( $path );
			}
		}


		if ( true == get_theme_mod( 'kata_plus_pro_css_minify', false ) ) {
			add_action( 'wp_print_styles', [$this,'inspect_styles'] );
			add_action( 'wp_print_footer_scripts', [$this,'inspect_styles_footer'], 9 );
		}
		
		if ( true == get_theme_mod( 'kata_plus_pro_js_minify', false ) ) {
			add_action( 'wp_print_scripts', [$this,'inspect_scripts'] );
			add_action( 'wp_print_footer_scripts', [$this,'inspect_scripts_footer'], 9 );
		}
		add_filter( 'style_loader_src', [$this,'remove_cssjs_ver'], 10, 2 );
		add_filter( 'script_loader_src', [$this,'remove_cssjs_ver'], 10, 2 );
	}

	public function remove_cssjs_ver( $src ) {
		if ( strpos($src,'?ver=') ) {
			$src = remove_query_arg('ver', $src);
		}
		return $src;
	}

	private function host_match( $url ) {
		if ( empty( $url ) ) {
			return false;
		}

		$url = $this->ensure_scheme($url);
		$url_host = parse_url($url, PHP_URL_HOST);

		if ( ! $url_host || $url_host == $this->host ) {
			return true;
		} else {
			return false;
		}
	}

	private function ensure_scheme( $url ) {
		return preg_replace("/(http(s)?:\/\/|\/\/)(.*)/i", "http$2://$3", $url);
	}

	private function fix_wp_subfolder( $file_path ) {
		if (!is_main_site() && defined('SUBDOMAIN_INSTALL') && !SUBDOMAIN_INSTALL) {
			$details = get_blog_details();
			$file_path = preg_replace('|^' . $details->path . '|', '/', $file_path);
		}

		if (
			$this->wp_dir != '' &&
			substr($file_path, 0, strlen($this->wp_dir) + 1) != $this->wp_dir . '/' &&
			substr($file_path, 0, strlen($this->wp_content) + 1) != $this->wp_content . '/'
		) {
			$file_path = $this->wp_dir . $file_path;
		}
		return $file_path;
	}

	public function inspect_styles() {
		wp_styles();

		global $wp_styles;
		$this->process_scripts($wp_styles, 'css');
	}

	public function inspect_scripts() {
		wp_scripts();

		global $wp_scripts;
		$this->process_scripts($wp_scripts, 'js');
	}

	public function inspect_styles_footer() {
		global $wp_styles;
		$this->process_scripts($wp_styles, 'css');
	}

	public function inspect_scripts_footer() {
		global $wp_scripts;
		$this->process_scripts($wp_scripts, 'js');
	}

	private function process_scripts( $script_list, $ext ) {
		if ( $script_list ) {
			$script_line_end = "\n";
			if ( $ext == 'js' )
			{
				$script_line_end = ";\n";
			}

            $scripts = clone $script_list;

			$scripts->all_deps($scripts->queue);

			$handles = $this->get_handles($ext, $scripts);

			$done = $scripts->done;

			for( $i=0, $l=count($handles); $i<$l; $i++ ) {
				if ( ! isset( $handles[$i]['handle'] ) ) {
					$done = array_merge($done, $handles[$i]['handles']);

					$hash = hash('adler32', get_home_url() . implode('', $handles[$i]['handles']));

					$file_path = '/' . $hash . '-' . get_the_ID() . '.' . $ext;

					$full_path = KATA_CACHE_DIR . $file_path;

					$min_path = '/' . $hash . '-' . get_the_ID() . '.min.' . $ext;

					$min_exists = file_exists(KATA_CACHE_DIR . $min_path);

					if ( ! file_exists($full_path) && ! $min_exists ) {
						$this->is_merged = true;

						$output = '';
						$should_minify = true;

						foreach( $handles[$i]['handles'] as $handle) {

							$script_path = parse_url($this->ensure_scheme($scripts->registered[$handle]->src), PHP_URL_PATH);
							$script_path = $this->fix_wp_subfolder($script_path);

							if ( ! file_exists($this->root . $script_path ) ) {
								continue;
							}
							
							if ( substr($script_path, -7) == '.min.' . $ext ) {
								if ( count($handles[$i]['handles']) > 1 ) {
									$nomin_path = substr($script_path, 0, -7) . '.' . $ext;
									if (is_file($this->root . $nomin_path)) {
										$script_path = $nomin_path;
									}
								} else {
									$should_minify = false;
								}
							}
							
							$contents = '';

							if ( $ext == 'js' && isset($scripts->registered[$handle]->extra['before']) && count($scripts->registered[$handle]->extra['before']) > 0)  {
								$contents .= implode($script_line_end,$scripts->registered[$handle]->extra['before']) . $script_line_end;
							}

							$scriptContent = file_get_contents($this->root . $script_path);
							if ( extension_loaded('mbstring') && mb_detect_encoding($scriptContent, 'UTF-8,ISO-8859-1', true) == 'ISO-8859-1' ) {
								$scriptContent = utf8_encode($scriptContent);
							}

							// Remove the UTF-8 BOM
							$contents .= preg_replace("/^\xEF\xBB\xBF/", '', $scriptContent) . $script_line_end;

							if ( isset($scripts->registered[$handle]->extra['after']) && count($scripts->registered[$handle]->extra['after']) > 0 ) {
								$contents .= implode($script_line_end,$scripts->registered[$handle]->extra['after']) . $script_line_end;
							}

							if ( $ext == 'css' ) {
								$contents = preg_replace("/url\(\s*['\"]?(?!data:)(?!http)(?![\/'\"#])(.+?)['\"]?\s*\)/i", "url(" . dirname($script_path) . "/$1)", $contents);
							}

							$output .= $contents;
						}

						if ( $should_minify ) {
							file_put_contents($full_path , $output);
						}
					}


					if ( $ext == 'js' ) {
						$data = '';

						foreach( $handles[$i]['handles'] as $handle ) {
							if ( isset($scripts->registered[$handle]->extra['data']) ) {
								$data .= $scripts->registered[$handle]->extra['data'];
							}
						}

						if ( false ) {
							wp_register_script('js-' . $this->count, KATA_JS_CACHE_URL . $min_path, array(), false, true);
						}
						else {
							wp_register_script('js-' . $this->count, KATA_JS_CACHE_URL . $file_path, array(), false, true);
						}

						if ( $data != '' ) {
							$script_list->registered['js-' . $this->count]->extra['data'] = $data;
						}
						
						if ( false == get_theme_mod( 'kata_plus_pro_js_load_interaction', false ) || is_admin() ) {
							wp_enqueue_script('js-' . $this->count);
						} else {
							echo '<script>
									var loaded = true;
									document.addEventListener("scroll", function(e) {
										if (loaded) {
											var s = document.createElement("script");
											s.type = "text/javascript";
											s.src = "' . KATA_JS_CACHE_URL . $file_path . '";
											document.getElementsByTagName("head")[0].appendChild(s);
											loaded = false;
										}
									});
									document.addEventListener("mousemove", function(e) {
										if (loaded) {
											var s = document.createElement("script");
											s.type = "text/javascript";
											s.src = "' . KATA_JS_CACHE_URL . $file_path . '";
											document.getElementsByTagName("head")[0].appendChild(s);
											loaded = false;
										}
									});
									setTimeout(function () {
										if (loaded) {
											var s = document.createElement("script");
											s.type = "text/javascript";
											s.src = "' . KATA_JS_CACHE_URL . $file_path . '";
											document.getElementsByTagName("head")[0].appendChild(s);
											loaded = false;
										}
									}, 8000);
								</script>';
						}
					} else {
						if ( $min_exists ) {
							wp_register_style('css-' . $this->count, KATA_CSS_CACHE_URL . $min_path, false, false, $handles[$i]['media']);
						} else {
							wp_register_style('css-' . $this->count, KATA_CSS_CACHE_URL . $file_path, false, false, $handles[$i]['media']);
						}
						wp_enqueue_style('css-' . $this->count);
					}

					$this->count++;

				} else {
					if ( $ext == 'js' ) {
						wp_dequeue_script($handles[$i]['handle']);
						wp_enqueue_script($handles[$i]['handle']);
					} else {
						wp_dequeue_style($handles[$i]['handle']);
						wp_enqueue_style($handles[$i]['handle']);
					}
				}
			}
			$script_list->done = $done;
		}
	}

	private function get_handles($type, $ourList) {
		switch( $type ) {
			case 'js': {
				$ext = 'js';
				$src_filter = 'script_loader_src';
				$check_media = false;
				$css_imports = false;
				break;
			}

			case 'css': {
				$ext = 'css';
				$src_filter = 'style_loader_src';
				$check_media = true;
				$css_imports = $this->css_imports;
				break;
			}

			default:
				return array();
		}

		$handles = array();
		$currentHandle = -1;
		foreach( $ourList->to_do as $handle ) {
			if ( apply_filters( $src_filter, $ourList->registered[$handle]->src, $handle ) !== false ) {
				$script_path = parse_url($this->ensure_scheme($ourList->registered[$handle]->src), PHP_URL_PATH);
				$script_path = $this->fix_wp_subfolder($script_path);

				$extension = pathinfo($script_path, PATHINFO_EXTENSION);

				if (
					file_exists($this->root . $script_path) &&
					$extension == $ext &&
					$this->host_match($ourList->registered[$handle]->src) &&
					!isset($ourList->registered[$handle]->extra["conditional"])
				) {
					$mediaMatches = true;
					if ( $check_media ) {
						$media = isset($ourList->registered[$handle]->args) ? $ourList->registered[$handle]->args : 'all';
						$mediaMatches = $currentHandle != -1 && isset($handles[$currentHandle]['media']) && $handles[$currentHandle]['media'] == $media;
					}

					$hasCSSImport = false;
					if ( $css_imports ) {
						$contents = file_get_contents($this->root . $script_path);
						$hasCSSImport = strpos($contents, '@import') !== false;
					}

					if ( $hasCSSImport || $currentHandle == -1 || isset($handles[$currentHandle]['handle']) || ! $mediaMatches ) {
						if ( $check_media ) {
							array_push( $handles, array('modified'=>0,'handles'=>array(),'media'=>$media) );
						} else {
							array_push( $handles, array('modified'=>0,'handles'=>array()) );
						}
						$currentHandle++;
					}

					$modified = 0;

					if ( is_file($this->root . $script_path) ) {
						$modified = filemtime($this->root . $script_path);
					}

					array_push( $handles[$currentHandle]['handles'], $handle );

					if ( $modified > $handles[$currentHandle]['modified'] ) {
						$handles[$currentHandle]['modified'] = $modified;
					}
				}
				else {
					array_push($handles, array('handle'=>$handle, 'src'=>$ourList->registered[$handle]->src));
					$currentHandle++;
				}
			}
		}
		return $handles;
	}

	private function compress_css( $full_path ) {
		if ( is_file( $full_path ) ) {
			$min_path = str_replace('.css', '.min.css', $full_path);

			require_once($this->dir . 'src/Minify.php');
			require_once($this->dir . 'src/CSS.php');
			require_once($this->dir . 'src/ConverterInterface.php');
			require_once($this->dir . 'src/Converter.php');
			require_once($this->dir . 'src/Exception.php');

			$file_size_before = filesize($full_path);

			$minifier = new \MatthiasMullie\Minify\CSS($full_path);

			$minifier->minify($min_path);
		}
	}

	private function compress_js( $full_path ) {
		if ( is_file( $full_path)  ) {
			$min_path = str_replace( '.js', '.min.js', $full_path );

			require_once($this->dir . 'src/Minify.php');
			require_once($this->dir . 'src/JS.php');

			$minifier = new \MatthiasMullie\Minify\JS( $full_path );

			$minifier->minify( $min_path );
		}
	}

	private function get_files_to_minify($ext) {
		return array_filter(glob(KATA_CACHE_DIR . '/*.' . $ext), function($file) use ($ext) {
			if ( strpos($file, '.min.' . $ext ) ) {
				return false;
			}
			return ! file_exists(str_replace('.' . $ext, '.min.' . $ext, $file));
		});
	}
}

Kata_Plus_Pro_Minifier::get_instance();
