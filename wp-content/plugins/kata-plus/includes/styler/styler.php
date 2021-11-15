<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
if ( ! class_exists( 'Kata_Styler' ) ) {
	class Kata_Styler {

		public static $dir;
		public static $url;
		private static $instance = null;
		public static $selector;
		public static $enqueue_when_preview_mode = false;
		public static $rendered                  = [];

		public function __construct() {
			if( ! class_exists( 'Elementor\Plugin' ) ) {
				return false;
			}
			$this->definitions();
			$this->actions();
			if (class_exists('Kirki')) {
				Kata_Plus_Autoloader::load(self::$dir . 'kirki', 'styler-kirki');
			}
		}

		/**
		 * save_customizer
		 *
		 * @since     1.0.0
		 */
		public function save_customizer() {
			if ( $_POST && is_array( $_POST ) ) {
				foreach ( $_POST as $name => $value ) {
					if ( strpos( $name, 'styler_' ) !== false ) {
						$value = sanitize_option( $name, $value );
						update_option( $name, $value );
					}
				}
			}
			die();
		}

		/**
		 * Actions
		 *
		 * @since     1.0.0
		 */
		public function actions() {
			add_action('init', [$this, 'init']);
			add_action('admin_footer', [$this, 'modal']);
			add_action('elementor/editor/footer', [$this, 'modal']);
			add_action('customize_controls_print_footer_scripts', [$this, 'modal']);
			add_action('admin_enqueue_scripts', [$this, 'enqueue'], 999);
			add_action('elementor/controls/controls_registered', [$this, 'controls']);
			add_action('styler_breakpoints', [$this, 'breakpoints']);
			add_action('styler_end_actions', [$this, 'styler_actions']);
			add_action('before_start_svg_panel', [$this, 'styler_filters_and_transform_panels']);
			add_action('redux/extensions/kata_plus_theme_options/before', [$this, 'redux_extension']);
			add_action('redux/extension/customizer/control/includes', [$this, 'redux_customizer']);
			add_action('wp_ajax_kata_plus_styler_save_customizer_form', [$this, 'save_customizer']);
			add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_when_parse_css'], 10, 1);
			// add_action('elementor/frontend/before_enqueue_styles', [$this, 'enqueue_when_parse_css'], 10, 1);
		}

		/**
		 * Generate CSS
		 *
		 * @since     1.0.0
		 */
		public static function enqueue_when_parse_css() {
			wp_enqueue_script('kata-plus-styler-frontend', Kata_Plus::$assets . 'js/styler/styler-frontend.js', ['jquery'], true);
		}
		/**
		 * Generate CSS
		 *
		 * @since     1.0.0
		 */
		public static function generate_css($breakpoints, $selectors, $parent, $current = false) {
			$css = '';
			if (is_array($breakpoints)) {
				foreach ($breakpoints as $key => $value) {
					if (!isset($selectors[$key])) {
						$selectors[$key] = '';
					}
					$selectors[$key] = str_replace('{{WRAPPER}}', $parent, $selectors[$key]);
					$selectors[$key] = str_replace('{{CURRENT_ITEM}}', $current, $selectors[$key]);
					switch ($key) {
						case 'desktop':
						case 'desktophover':
						case 'desktopphover':
						case 'desktopbefore':
						case 'desktopafter':
							if (trim($value) && $selectors[$key]) {
								$css .= $selectors[$key] . '{' . $value . '}';
							}
							break;
						case 'laptop':
						case 'laptophover':
						case 'laptopphover':
						case 'laptopbefore':
						case 'laptopafter':
							if (trim($value) && $selectors[$key]) {
								$css .= '@media (max-width:1367px) {' . $selectors[$key] . '{' . $value . '} }';
							}
							break;
						case 'tablet':
						case 'tablethover':
						case 'tabletphover':
						case 'tabletbefore':
						case 'tabletafter':
							if (trim($value) && $selectors[$key]) {
								$css .= '@media screen and (max-width:768px) {' . $selectors[$key] . '{' . $value . '} }';
							}
							break;
						case 'tabletlandscape':
						case 'tabletlandscapehover':
						case 'tabletlandscapephover':
						case 'tabletlandscapebefore':
						case 'tabletlandscapeafter':
							if (trim($value) && $selectors[$key]) {
								$css .= '@media (max-width:1025px) {' . $selectors[$key] . '{' . $value . '} }';
							}
							break;
						case 'mobile':
						case 'mobilehover':
						case 'mobilephover':
						case 'mobilebefore':
						case 'mobileafter':
							if (trim($value) && $selectors[$key]) {
								$css .= '@media screen and (max-width:560px) {' . $selectors[$key] . '{' . $value . '} }';
							}
							break;
						case 'smallmobile':
						case 'smallmobilehover':
						case 'smallmobilephover':
						case 'smallmobilebefore':
						case 'smallmobileafter':
							if (trim($value) && $selectors[$key]) {
								$css .= '@media (max-width:470px) {' . $selectors[$key] . '{' . $value . '} }';
							}
							break;
					}
				}
				return $css;
			}
			return false;
		}

		/**
		 * Erise unnecessary css
		 *
		 * @since     1.0.0
		 */
		public static function unnecessary_css_erise( $content ) {
			$content = Kata_Plus_Helpers::cssminifier( $content );
			$content = str_replace([') {', '} }', '} @', ' ;',  '; '], ['){', '}}', '}@', ';',  ';'], $content);
			$content = str_replace(['outline:notset;', 'outline:none;', 'outline: none;', 'outline: notset;', 'undefined'], '', $content);
			$content = str_replace(
				[ '}.', '}#', '}@media', '} .', '} #', '} @media', '){.', '}html', '}h1, h2, h3, h4, h5, h6{', 'body{', '}p{', '}undefined', '}a', '}body.archive'],
				['}QRF45.', '}QRF45#', '}QRF45@media', '}QRF45.', '}QRF45#', '}QRF45@media', '){QRF45.', '}QRF45html', '}QRF45h1, h2, h3, h4, h5, h6{', 'QRF45body{', '}QRF45p{', '}QRF45undefined', '}QRF45a', '}QRF45body.archive' ], $content
			);
			$content = (explode('QRF45', $content));
			foreach ($content as $key => $val) {
				if ( isset( $content[$key] ) && ! strpos( $content[$key], 'media' ) ) {
					if ( isset( $content[$key] ) && strpos($content[$key], '{}}') ) {
						$content[$key] = '}';
					}
					if ( isset( $content[$key] ) && strpos( $content[$key], '{}' ) ) {
						unset( $content[$key] );
					}
					if ( isset( $content[$key] ) && strpos( $content[$key], '{content:"";}' ) ) {
						unset( $content[$key] );
					}
				}
			}
			foreach ($content as $key => $val) {
				if (strpos($content[$key], 'media')) {
					if (strpos($content[$key], '{}}')) {
						unset($content[$key]);
					}
				}
			}
			$content = implode(' ', $content);
			$content = str_replace(['{ }', '} '], ['{}', '}'], $content);
			$content = str_replace(['@media(max-width:1366px){}', '@media(max-width:768px){}', '@media(max-width:1439px){}', '@media(min-width:1025px) and (max-width:1366px){}', '@media(max-width:480px){}', '@media(min-width:769px) and (max-width:1024px){}', '@media(min-width:481px) and (max-width:768px){}', '@media(max-width: 320px){}', '@media(min-width: 769px) and (max-width: 1024px){}', '@media(min-width: 481px) and (max-width: 768px){}', '@media(min-width: 1025px) and (max-width: 1366px){}', '@media(max-width: 480px){}', '@media(max-width:1024px){}', '@media(max-width:769px){}', '@media(max-width:481px){}', '@media(max-width:320px){}'], '', $content);

			return $content;
		}

		/**
		 * Clean Generated CSS
		 *
		 * @since     1.0.0
		 */
		public static function css_cleaner( $content ) {
			$content = Kata_Plus_Helpers::cssminifier($content);
			$content = self::unnecessary_css_erise($content);
			$content = Kata_Plus_Helpers::cssminifier($content);
			$content = str_replace("font-family:\'","font-family:'", $content);
			$content = str_replace("content:\\",'', $content);
			$content = str_replace("\\",'', $content);
			$content = str_replace('undefined','', $content);
			return $content;
		}

		/**
		 * Global definitions
		 *
		 * @since     1.0.0
		 */
		public function definitions() {

			define('KATA_PLUS_STYLER_DIR', Kata_Plus::$dir . 'includes/styler/');
			define('KATA_PLUS_STYLER_URL', Kata_Plus::$url . 'includes/styler/');

			self::$dir = plugin_dir_path(__FILE__);
			self::$url = plugin_dir_url(__FILE__);
		}

		/**
		 *
		 * Instance
		 *
		 * @return class|null
		 */
		public static function instance() {
			if (self::$instance === null) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 *
		 * Enqueue required assets
		 *
		 * @return string
		 */
		public static function enqueue() {
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_script('jquery-ui-dialog');

			wp_enqueue_script(
				'pickr',
				ELEMENTOR_ASSETS_URL . 'lib/pickr/pickr.min.js',
				[],
				'1.4.7',
				true
			);
			wp_enqueue_style('kata-picker-classic', Kata_Plus::$assets . 'css/libraries/classic.min.css', [], Kata_Plus::$version);

			wp_enqueue_script('kata-styler', Kata_Plus::$assets . 'js/styler/styler.js', ['jquery'], '', false);
			$currentScreen = get_current_screen();
			if ($currentScreen->id === "customize") {
				$breakpoints = Kata_Plus_Elementor::get_breakpoints();
				wp_enqueue_script('kata-plus-styler-customizer', Kata_Plus::$assets . 'js/styler/customizer.js', ['jquery'], false);
				wp_add_inline_script(
					'kata-plus-styler-customizer',
					'var ElementorBreakPoints = ' . json_encode($breakpoints) . ';'
				);
			}
			wp_enqueue_script('wp_media');
			wp_enqueue_style('kata-styler', Kata_Plus::$assets . 'css/backend/styler.css');
			if ( is_rtl() ) {
				wp_enqueue_style('kata-styler-rtl', Kata_Plus::$assets . 'css/backend/styler-rtl.css');
			}
		}

		/**
		 * Init
		 */
		public static function init() {
			require_once KATA_PLUS_STYLER_DIR . 'metabox/metabox.php';
			require_once KATA_PLUS_STYLER_DIR . 'widgets/widgets.php';
		}
		/**
		 *
		 * Stylers fields name
		 *
		 * @return array
		 */
		public static function fields() {
			return [
				// Platforms
				'desktop',
				'laptop',
				'tablet',
				'mobile',
				'tabletlandscape',
				'smallmobile',

				// Desktop
				'desktophover',
				'desktopactive',
				'desktopphover',
				'desktopbefore',
				'desktopafter',
				'desktopplaceholder',

				// Tablet
				'tablethover',
				'tabletactive',
				'tabletphover',
				'tabletbefore',
				'tabletafter',
				'tabletplaceholder',

				// Mobile
				'mobilehover',
				'mobilephover',
				'mobilebefore',
				'mobileafter',
				'mobileplaceholder',

				// Laptop
				'laptophover',
				'laptopphover',
				'laptopbefore',
				'laptopafter',
				'laptopplaceholder',

				// Tablet Landscape
				'tabletlandscapehover',
				'tabletlandscapephover',
				'tabletlandscapebefore',
				'tabletlandscapeafter',
				'tabletlandscapeplaceholder',

				// Small Mobile
				'smallmobilehover',
				'smallmobilephover',
				'smallmobilebefore',
				'smallmobileafter',
				'smallmobileplaceholder',
				'cid',
				'citem',
				'rp',
			];
		}

		/**
		 *
		 * CSS selectors for styler controls
		 *
		 * @return array
		 */
		public static function selectors($normal = '', $hover = '', $parent = '') {

			if (!$parent) {
				$parent = '{{WRAPPER}}';
			} else if (strpos($parent, '{{WRAPPER}}') === false && $normal != '{{WRAPPER}}') {
				$parent = trim('{{WRAPPER}} ' . $parent);
			}

			if (!$normal || $normal == '{{WRAPPER}}' && empty($parent)) {
				return static::wrapper_selectors($parent);
			}

			if ($normal && strpos($normal, '{{CURRENT_ITEM}}') !== false) {
				$normal = str_replace('{{CURRENT_ITEM}}', '', $normal);
				$hover  = str_replace('{{CURRENT_ITEM}}', '', $hover);

				return static::current_item_selectors($normal, $hover, $parent);
			}


			$normal = rtrim($normal);
			self::$selector = $normal;
			$hover          = $hover ? $hover : rtrim($normal) . ':hover';
			return [
				$parent . ' ' . $normal                      => '{{DESKTOP}}',
				'(laptop-)' . $parent . ' ' . $normal             => '{{LAPTOP}}',
				'(tabletlandscape-)' . $parent . ' ' . $normal    => '{{TABLETLANDSCAPE}}',
				'(tablet-)' . $parent . ' ' . $normal             => '{{TABLET}}',
				'(mobile-)' . $parent . ' ' . $normal             => '{{MOBILE}}',
				'(smallmobile-)' . $parent . ' ' . $normal        => '{{SMALLMOBILE}}',

				// Desktop
				$parent . ' ' . $hover                       => '{{DESKTOPHOVER}}',
				// '{{WRAPPER}}' . ':active'               => '{{DESKTOPACTIVE}}',
				$parent . ':hover ' . $normal                => '{{DESKTOPPHOVER}}',
				$parent . ' ' . $normal . ':before'          => '{{DESKTOPBEFORE}}',
				$parent . ' ' . $normal . ':after'          => '{{DESKTOPAFTER}}',
				$parent . ' ' . $normal . '::placeholder'           => '{{DESKTOPPLACEHOLDER}}',

				// laptop
				'(laptop-)' . $parent . ' ' . $hover              => '{{LAPTOPHOVER}}',
				'(laptop-)' . $parent . ':hover ' . $normal       => '{{LAPTOPPHOVER}}',
				'(laptop-)' . $parent . ' ' . $normal . ':before' => '{{LAPTOPBEFORE}}',
				'(laptop-)' . $parent . ' ' . $normal . ':after' => '{{LAPTOPAFTER}}',
				'(laptop-)' . $parent . ' ' . $normal . '::placeholder'  => '{{LAPTOPPLACEHOLDER}}',

				// Tablet
				'(tablet-)' . $parent . ' ' . $hover              => '{{TABLETHOVER}}',
				// '(tablet-)'. $parent .'' . ':active'      => '{{TABLETACTIVE}}',
				'(tablet-)' . $parent . ':hover ' . $normal       => '{{TABLETPHOVER}}',
				'(tablet-)' . $parent . ' ' . $normal . ':before' => '{{TABLETBEFORE}}',
				'(tablet-)' . $parent . ' ' . $normal . ':after' => '{{TABLETAFTER}}',
				'(tablet-)' . $parent . ' ' . $normal . '::placeholder'  => '{{TABLETPLACEHOLDER}}',

				// tablet-landscape
				'(tabletlandscape-)' . $parent . ' ' . $hover     => '{{TABLETLANDSCAPEHOVER}}',
				'(tabletlandscape-)' . $parent . ':hover ' . $normal => '{{TABLETLANDSCAPEPHOVER}}',
				'(tabletlandscape-)' . $parent . ' ' . $normal . ':before' => '{{TABLETLANDSCAPEBEFORE}}',
				'(tabletlandscape-)' . $parent . ' ' . $normal . ':after' => '{{TABLETLANDSCAPEAFTER}}',
				'(tabletlandscape-)' . $parent . ' ' . $normal . '::placeholder' => '{{TABLETLANDSCAPEPLACEHOLDER}}',

				// Mobile
				'(mobile-)' . $parent . ' ' . $hover              => '{{MOBILEHOVER}}',
				'(mobile-)' . $parent . ':hover ' . $normal       => '{{MOBILEPHOVER}}',
				'(mobile-)' . $parent . ' ' . $normal . ':before' => '{{MOBILEBEFORE}}',
				'(mobile-)' . $parent . ' ' . $normal . ':after' => '{{MOBILEAFTER}}',
				'(mobile-)' . $parent . ' ' . $normal . '::placeholder'  => '{{MOBILEPLACEHOLDER}}',

				// small-mobile
				'(smallmobile-)' . $parent . ' ' . $hover         => '{{SMALLMOBILEHOVER}}',
				'(smallmobile-)' . $parent . ':hover ' . $normal  => '{{SMALLMOBILEPHOVER}}',
				'(smallmobile-)' . $parent . ' ' . $normal . ':before' => '{{SMALLMOBILEBEFORE}}',
				'(smallmobile-)' . $parent . ' ' . $normal . ':after' => '{{SMALLMOBILEAFTER}}',
				'(smallmobile-)' . $parent . ' ' . $normal . '::placeholder' => '{{SMALLMOBILEPLACEHOLDER}}',
				// 'cid'                                         => '{{cid}}',
				// 'citem'                                       => '{{citem}}',
				// 'rp'                                          => '{{rp}}',
			];
		}

		/**
		 *
		 * CSS selectors for styler controls (Wrapper) (Elementor)
		 *
		 * @return array
		 */
		public static function wrapper_selectors($parent) {
			return [
				$parent       => '{{DESKTOP}}',
				'(laptop-)' . $parent => '{{LAPTOP}}',
				'(tabletlandscape-)' . $parent => '{{TABLETLANDSCAPE}}',
				'(tablet-)' . $parent => '{{TABLET}}',
				'(mobile-)' . $parent => '{{MOBILE}}',
				'(smallmobile-)' . $parent => '{{SMALLMOBILE}}',

				// Desktop
				$parent . ':hover'        => '{{DESKTOPHOVER}}',
				// $parent. '' . ':active'               => '{{DESKTOPACTIVE}}',
				// $parent . ':hover' => '{{DESKTOPPHOVER}}',
				$parent . ':before' => '{{DESKTOPBEFORE}}',
				$parent . ':after' => '{{DESKTOPAFTER}}',
				$parent . ':placeholder' => '{{DESKTOPPLACEHOLDER}}',

				// laptop
				'(laptop-)' . $parent . ':hover' => '{{LAPTOPHOVER}}',
				// '(laptop-)' . $parent . ':hover' => '{{LAPTOPPHOVER}}',
				'(laptop-)' . $parent . ':before' => '{{LAPTOPBEFORE}}',
				'(laptop-)' . $parent . ':after' => '{{LAPTOPAFTER}}',
				'(laptop-)' . $parent . ':placeholder' => '{{LAPTOPPLACEHOLDER}}',

				// Tablet
				'(tablet-)' . $parent . ':hover' => '{{TABLETHOVER}}',
				// '(tablet-)'. $parent .'' . ':active'      => '{{TABLETACTIVE}}',
				// '(tablet-)' . $parent . ':hover' => '{{TABLETPHOVER}}',
				'(tablet-)' . $parent . ':before' => '{{TABLETBEFORE}}',
				'(tablet-)' . $parent . ':after' => '{{TABLETAFTER}}',
				'(tablet-)' . $parent . ':placeholder' => '{{TABLETPLACEHOLDER}}',

				// tablet-landscape
				'(tabletlandscape-)' . $parent . ':hover' => '{{TABLETLANDSCAPEHOVER}}',
				// '(tabletlandscape-)' . $parent . ':hover' => '{{TABLETLANDSCAPEPHOVER}}',
				'(tabletlandscape-)' . $parent . ':before' => '{{TABLETLANDSCAPEBEFORE}}',
				'(tabletlandscape-)' . $parent . ':after' => '{{TABLETLANDSCAPEAFTER}}',
				'(tabletlandscape-)' . $parent . ':placeholder' => '{{TABLETLANDSCAPEPLACEHOLDER}}',

				// Mobile
				'(mobile-)' . $parent . ':hover' => '{{MOBILEHOVER}}',
				// '(mobile-)' . $parent . ':hover' => '{{MOBILEPHOVER}}',
				'(mobile-)' . $parent . ':before' => '{{MOBILEBEFORE}}',
				'(mobile-)' . $parent . ':after' => '{{MOBILEAFTER}}',
				'(mobile-)' . $parent . ':placeholder' => '{{MOBILEPLACEHOLDER}}',

				// small-mobile
				'(smallmobile-)' . $parent . ':hover' => '{{SMALLMOBILEHOVER}}',
				// '(smallmobile-)' . $parent . ':hover' => '{{SMALLMOBILEPHOVER}}',
				'(smallmobile-)' . $parent . ':before' => '{{SMALLMOBILEBEFORE}}',
				'(smallmobile-)' . $parent . ':after' => '{{SMALLMOBILEAFTER}}',
				'(smallmobile-)' . $parent . ':placeholder' => '{{SMALLMOBILEPLACEHOLDER}}',
				// 'cid'                                          => '{{cid}}',
				// 'citem'                                        => '{{citem}}',
				// 'rp'                                           => '{{rp}}',
			];
		}

		/**
		 *
		 * CSS selectors for styler controls (Current Item)
		 *
		 * @return array
		 */
		public static function current_item_selectors( $parent, $normal = '', $hover = '' ) {
			$normal         = ' ' . $normal;
			self::$selector = $normal;
			$hover          = $hover ? $hover : rtrim($normal) . ':hover';
			return [
				$parent . ' {{CURRENT_ITEM}}' . $normal       => '{{DESKTOP}}',
				'(laptop-)' . $parent . ' {{CURRENT_ITEM}}' . $normal => '{{LAPTOP}}',
				'(tabletlandscape-)' . $parent . ' {{CURRENT_ITEM}}' . $normal => '{{TABLETLANDSCAPE}}',
				'(tablet-)' . $parent . ' {{CURRENT_ITEM}}' . $normal => '{{TABLET}}',
				'(mobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal => '{{MOBILE}}',
				'(smallmobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal => '{{SMALLMOBILE}}',

				// Desktop
				$parent . ' {{CURRENT_ITEM}}' . $hover        => '{{DESKTOPHOVER}}',
				// $parent. '' . ':active'               => '{{DESKTOPACTIVE}}',
				$parent . ':hover {{CURRENT_ITEM}}' . $normal => '{{DESKTOPPHOVER}}',
				$parent . ' {{CURRENT_ITEM}}' . $normal . ':before' => '{{DESKTOPBEFORE}}',
				$parent . ' {{CURRENT_ITEM}}' . $normal . ':after' => '{{DESKTOPAFTER}}',
				$parent . ' {{CURRENT_ITEM}}' . $normal . ':placeholder' => '{{DESKTOPPLACEHOLDER}}',

				// laptop
				'(laptop-)' . $parent . ' {{CURRENT_ITEM}}' . $hover => '{{LAPTOPHOVER}}',
				'(laptop-)' . $parent . ':hover {{CURRENT_ITEM}}' . $normal => '{{LAPTOPPHOVER}}',
				'(laptop-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':before' => '{{LAPTOPBEFORE}}',
				'(laptop-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':after' => '{{LAPTOPAFTER}}',
				'(laptop-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':placeholder' => '{{LAPTOPPLACEHOLDER}}',

				// Tablet
				'(tablet-)' . $parent . ' {{CURRENT_ITEM}}' . $hover => '{{TABLETHOVER}}',
				// '(tablet-)'. $parent .'' . ':active'      => '{{TABLETACTIVE}}',
				'(tablet-)' . $parent . ':hover {{CURRENT_ITEM}}' . $normal => '{{TABLETPHOVER}}',
				'(tablet-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':before' => '{{TABLETBEFORE}}',
				'(tablet-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':after' => '{{TABLETAFTER}}',
				'(tablet-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':placeholder' => '{{TABLETPLACEHOLDER}}',

				// tablet-landscape
				'(tabletlandscape-)' . $parent . ' {{CURRENT_ITEM}}' . $hover => '{{TABLETLANDSCAPEHOVER}}',
				'(tabletlandscape-)' . $parent . ':hover {{CURRENT_ITEM}}' . $normal => '{{TABLETLANDSCAPEPHOVER}}',
				'(tabletlandscape-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':before' => '{{TABLETLANDSCAPEBEFORE}}',
				'(tabletlandscape-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':after' => '{{TABLETLANDSCAPEAFTER}}',
				'(tabletlandscape-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':placeholder' => '{{TABLETLANDSCAPEPLACEHOLDER}}',

				// Mobile
				'(mobile-)' . $parent . ' {{CURRENT_ITEM}}' . $hover => '{{MOBILEHOVER}}',
				'(mobile-)' . $parent . ':hover {{CURRENT_ITEM}}' . $normal => '{{MOBILEPHOVER}}',
				'(mobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':before' => '{{MOBILEBEFORE}}',
				'(mobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':after' => '{{MOBILEAFTER}}',
				'(mobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':placeholder' => '{{MOBILEPLACEHOLDER}}',

				// small-mobile
				'(smallmobile-)' . $parent . ' {{CURRENT_ITEM}}' . $hover => '{{SMALLMOBILEHOVER}}',
				'(smallmobile-)' . $parent . ':hover {{CURRENT_ITEM}}' . $normal => '{{SMALLMOBILEPHOVER}}',
				'(smallmobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':before' => '{{SMALLMOBILEBEFORE}}',
				'(smallmobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':after' => '{{SMALLMOBILEAFTER}}',
				'(smallmobile-)' . $parent . ' {{CURRENT_ITEM}}' . $normal . ':placeholder' => '{{SMALLMOBILEPLACEHOLDER}}',
				// 'cid'                                          => '{{cid}}',
				// 'citem'                                        => '{{citem}}',
				// 'rp'                                           => '{{rp}}',
			];
		}

		/**
		 *
		 * Kirki Pattern Output
		 *
		 * @return array
		 */
		public static function kirki_output($normal, $hover = '') {
			return [
				'element'  => $normal,
				'fields'   => static::output($normal, $hover),
				'property' => '',
				'units'    => '',
			];
		}

		/**
		 *
		 * Elementor Output
		 *
		 * @return array
		 */
		public static function elementor_output($normal, $hover = '', $parent = '') {
			if (!$parent) {
				$parent = '{{WRAPPER}}';
			} else if (strpos($parent, '{{WRAPPER}}') === false) {
				$parent = trim('{{WRAPPER}} ' . $parent);
			}

			return json_encode(static::e_output($normal, $hover, $parent));
		}

		/**
		 *
		 * CSS selectors for styler in Kirki framework
		 *
		 * @return array
		 */
		public static function output($normal, $hover = '') {
			$hover = $hover ? $hover : $normal . ':hover';
			return [
				'desktop'               => $normal,
				'desktophover'          => $hover,
				'desktopphover'         => $normal,
				'desktopbefore'         => $normal . ':before',
				'desktopafter'          => $normal . ':after',
				'desktopplaceholder'	=> $normal . ':placeholder',

				// Laptop
				'laptop'                => $normal,
				'laptophover'           => $hover,
				'laptopphover'          => $normal,
				'laptopbefore'          => $normal . ':before',
				'laptopafter'           => $normal . ':after',
				'laptopplaceholder'		=> $normal . ':placeholder',

				// Tablet Landscape
				'tabletlandscape'       		=> $normal,
				'tabletlandscapehover'  		=> $hover,
				'tabletlandscapephover' 		=> $normal,
				'tabletlandscapebefore' 		=> $normal . ':before',
				'tabletlandscapeafter'  		=> $normal . ':after',
				'tabletlandscapeplaceholder'	=> $normal . ':placeholder',

				// Tablet
				'tablet'                => $normal,
				'tablethover'           => $hover,
				'tabletphover'          => $normal,
				'tabletbefore'          => $normal . ':before',
				'tabletafter'           => $normal . ':after',
				'tabletplaceholder'		=> $normal . ':placeholder',

				// Mobile
				'mobile'                => $normal,
				'mobilehover'           => $hover,
				'mobilephover'          => $normal,
				'mobilebefore'          => $normal . ':before',
				'mobileafter'           => $normal . ':after',
				'mobileplaceholder'		=> $normal . ':placeholder',

				// Small Mobile
				'smallmobile'           	=> $normal,
				'smallmobilehover'      	=> $hover,
				'smallmobilephover'     	=> $normal,
				'smallmobilebefore'     	=> $normal . ':before',
				'smallmobileafter'      	=> $normal . ':after',
				'smallmobileplaceholder'	=> $normal . ':placeholder',
			];
		}

		/**
		 *
		 * CSS selectors for styler in Elementor
		 *
		 * @return array
		 */
		public static function e_output( $parent, $normal, $hover = '' ) {
			$hover = $hover ? $hover : $normal . ':hover';
			return [
				'desktop'               => $parent . ' ' . $normal,
				'laptop'                => $parent . ' ' . $normal,
				'tabletlandscape'       => $parent . ' ' . $normal,
				'tablet'                => $parent . ' ' . $normal,
				'mobile'                => $parent . ' ' . $normal,
				'smallmobile'           => $parent . ' ' . $normal,

				// Desktop
				'desktophover'          => $parent . ' ' . $hover,
				'desktopphover'         => $parent . ':hover ' . $normal,
				// 'desktopphover'         => $parent . ' ' . $normal,
				'desktopbefore'         => $parent . ' ' . $normal . ':before',
				'desktopafter'          => $parent . ' ' . $normal . ':after',
				'desktopplaceholder'          => $parent . ' ' . $normal . '::placeholder',

				// Laptop
				'laptophover'           => $parent . ' ' . $hover,
				'laptopphover'          => $parent . ':hover ' . $normal,
				// 'laptopphover'          => $parent . ' ' . $normal,
				'laptopbefore'          => $parent . ' ' . $normal . ':before',
				'laptopafter'           => $parent . ' ' . $normal . ':after',
				'laptopplaceholder'           => $parent . ' ' . $normal . '::placeholder',

				// Tablet Landscape
				'tabletlandscapehover'  => $parent . ' ' . $hover,
				'tabletlandscapephover' => $parent . ':hover ' . $normal,
				// 'tabletlandscapephover' => $parent . ' ' . $normal,
				'tabletlandscapebefore' => $parent . ' ' . $normal . ':before',
				'tabletlandscapeafter'  => $parent . ' ' . $normal . ':after',
				'tabletlandscapeplaceholder'  => $parent . ' ' . $normal . '::placeholder',

				// Tablet
				'tablethover'           => $parent . ' ' . $hover,
				'tabletphover'          => $parent . ':hover ' . $normal,
				// 'tabletphover'          => $parent . ' ' . $normal,
				'tabletbefore'          => $parent . ' ' . $normal . ':before',
				'tabletafter'           => $parent . ' ' . $normal . ':after',
				'tabletplaceholder'           => $parent . ' ' . $normal . '::placeholder',

				// Mobile
				'mobilehover'           => $parent . ' ' . $hover,
				'mobilephover'          => $parent . ':hover ' . $normal,
				// 'mobilephover'          => $parent . ' ' . $normal,
				'mobilebefore'          => $parent . ' ' . $normal . ':before',
				'mobileafter'           => $parent . ' ' . $normal . ':after',
				'mobileplaceholder'           => $parent . ' ' . $normal . '::placeholder',

				// Small Mobile
				'smallmobilehover'      => $parent . ' ' . $hover,
				'smallmobilephover'     => $parent . ':hover ' . $normal,
				// 'smallmobilephover'     => $parent . ' ' . $normal,
				'smallmobilebefore'     => $parent . ' ' . $normal . ':before',
				'smallmobileafter'      => $parent . ' ' . $normal . ':after',
				'smallmobileplaceholder'      => $parent . ' ' . $normal . '::placeholder',
				'cid'                   => '',
			];
		}

		/**
		 *
		 * Styler extension for redun framework
		 *
		 * @return object
		 */
		public static function redux_extension($redux) {
			$class  = 'ReduxFramework_Extension_Kata_Styler';
			$folder = KATA_PLUS_STYLER_DIR . 'redux/';
			if (!class_exists($class)) {
				$class_file = $folder . 'extension.php';
				$class_file = apply_filters('redux/extension/' . $redux->args['opt_name'] . '/' . $folder, $class_file);
				if ($class_file) {
					require_once $class_file;
				}
			}
			if (!isset($redux->extensions[$folder])) {
				$redux->extensions[$folder] = new $class($redux);
			}
		}

		/**
		 *
		 * Allow styler in redux customizer
		 *
		 * @return object
		 */
		public static function redux_customizer() {
			require_once KATA_PLUS_STYLER_DIR . 'redux/redux_customizer.php';
		}

		/**
		 *
		 * Styler control for elementor
		 *
		 * @return object
		 */
		public static function controls() {
			if (!class_exists('\Elementor\Plugin')) {
				return;
			}
			require_once KATA_PLUS_STYLER_DIR . 'elementor/control.php';
			\Elementor\Plugin::$instance->controls_manager->register_control('kata_styler', new Kata_Styler_Elementor_Control());
		}

		/**
		 *
		 * Modal box content
		 *
		 * @return string
		 */
		public static function modal() {
			if ( isset( $_GET['page'] ) && 'tgmpa-install-plugins' == $_GET['page'] ) {
				return;
			}
			wp_enqueue_media();
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('wp-color-picker-alpha');
			$breakpoints = did_action('elementor/loaded') ? Kata_Plus_Elementor::get_breakpoints() : '';
			?>
			<!-- styler -->
			<div class="styler-wrap active">
				<div class="top-bar">
					<strong><?php echo __('Layer Style', 'kata-plus'); ?></strong>

					<span class="styler-tooltip mini-full" data-tooltip="Collapse menu"><i class="kata-icon eicon-angle-left"></i></span>
					<div class="styler-platforms-wrapper">
						<?php do_action( 'styler_before_platforms' ); ?>
						<div class="styler-tooltip selected-platform" data-tooltip="Devices" data-active="deactive"><i class="eicon-device-desktop active" data-name="desktop"></i></div>
						<ul class="platforms kata-dropdown" style="display:none;">
							<?php do_action( 'styler_breakpoints' ); ?>
						</ul>
					</div>
					<span class="close styler-tooltip" data-tooltip="Save & Close">x</span>
					<span class="minimize styler-tooltip" data-tooltip="Minimize"><i>_</i></span>
				</div>


				<div class="actions">
					<span data-name=""><?php echo __('Normal', 'kata-plus'); ?></span>
					<span data-name="hover"><?php echo __('Hover', 'kata-plus'); ?></span>
					<?php do_action('styler_end_actions') ?>
					<!-- <span data-name="active">Active</span> -->
				</div>
				<div class="container">
					<!-- left-side -->
					<div class="left-side">
						<ul>
							<li class="styler-tooltip" data-name="font-typography" class="active" data-tooltip="Text">
								<i class="eicon-site-title"></i>
								<a href="#">Text</a>
							</li>
							<li class="styler-tooltip" data-name="background" data-tooltip="Background">
								<i class="eicon-image-rollover"></i>
								<a href="#"><?php echo __('Background', 'kata-plus'); ?></a>
							</li>
							<li class="styler-tooltip" data-name="display" data-tooltip="Display">
								<i class="eicon-parallax"></i>
								<a href="#"><?php echo __('Display', 'kata-plus'); ?></a>
							</li>
							<li class="styler-tooltip" data-name="width-height" data-tooltip="Size">
								<i class="eicon-slider-vertical"></i>
								<a href="#"><?php echo __('Size', 'kata-plus'); ?></a>
							</li>
							<li class="styler-tooltip" data-name="padding-margin" data-tooltip="Padding & Margin">
								<i class="eicon-spacer"></i>
								<a href="#"><?php echo __('Padding & Margin', 'kata-plus'); ?></a>
							</li>
							<li class="styler-tooltip" data-name="border" data-tooltip="Border">
								<i class="eicon-button"></i>
								<a href="#"><?php echo __('Border', 'kata-plus'); ?></a>
							</li>
							<li class="styler-tooltip" data-name="shadow" data-tooltip="Shadow">
								<i class="eicon-accordion"></i>
								<a href="#"><?php echo __('Shadow', 'kata-plus'); ?></a>
							</li>
							<li class="styler-tooltip" data-name="position" data-tooltip="Position">
								<i class="eicon-scroll"></i>
								<a href="#"><?php echo __('Position', 'kata-plus'); ?></a>
							</li>
							<?php do_action('before_start_svg_panel') ?>
							<li class="styler-tooltip" data-name="svg" data-tooltip="SVG">
								<i class="eicon-image"></i>
								<a href="#"><?php echo __('SVG', 'kata-plus'); ?></a>
							</li>
							<li class="styler-tooltip" data-name="animation" data-tooltip="Animation">
								<i class="eicon-dashboard"></i>
								<a href="#"><?php echo __('Animation', 'kata-plus'); ?></a>
							</li>
						</ul>
					</div> <!-- .left-side -->
					<!-- content -->
					<form class="content">
						<!-- Font & Typography -->
						<div class="styler-tab styler-tab-font-typography active" data-name="font-typography">
							<!-- Color Options -->
							<h3><?php echo __('Color Options', 'kata-plus'); ?></h3>

							<!-- Text Color -->
							<div class="form-group">

								<div class="form-group">
									<!-- Content -->
									<label class="hidden css-content-par">
										<span><?php echo __('Content', 'kata-plus'); ?></span>
										<input type="text" name="content">
									</label>
								</div>
								<div class="color-picker-wrap">
									<label class="inline" for="styler-color-option">
										<i class="kata-important-btn eicon-star" data-task="important" data-field="color"></i>
										<span><?php echo __('Color', 'kata-plus'); ?></span>
									</label>
									<div class="color-picker-input"></div>
									<input type="hidden" name="color" id="styler-color-option" data-alpha="true" class="color-picker">
								</div>
								<div class="color-picker-wrap">
									<label class="inline" for="styler-color-option">
										<i class="kata-important-btn eicon-star" data-task="important" data-field="color"></i>
										<span><?php echo __('Placeholder Color', 'kata-plus'); ?></span>
									</label>
									<div class="color-picker-input"></div>
									<input type="hidden" name="placeholder-color" id="styler-color-option" data-alpha="true" class="color-picker">
								</div>
							</div>
							<!-- Font Options -->
							<h3><?php echo __('Font Options', 'kata-plus'); ?></h3>
							<div class="form-group">
								<!-- Font Size -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="font-size"></i>
									<span><?php echo __('Font Size', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" max="500" min="0">
									</div>
									<input type="text" name="font-size" data-unit="px" data-units="px,em,%">
								</label>
								<!-- Line Height -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="line-height"></i>
									<span><?php echo __('Line Height', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" max="100" min="0">
									</div>
									<input type="text" name="line-height" data-unit="px" data-units="px,em,%">
								</label>
								<!-- Font Family -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="font-family"></i>
									<span><?php echo __('Font family', 'kata-plus'); ?></span>
									<select name="font-family">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<?php
										$fonts = class_exists( 'Kata_Plus_Pro_FontsManager_Helpers' ) ? Kata_Plus_Pro_FontsManager_Helpers::get_fonts() : [];
										$theme_opts_typographies = self::customizer_fonts();
										if ( $fonts ) {
											foreach ($fonts as $font) {
												if($font['source'] == 'upload-icon') {
													continue;
												}
												$alternative_fonts = get_option( 'kata.plus.fonts_manager.alternative.fonts', 'Arial, Roboto, Sans-serif' );
												if ($font['source'] == 'typekit' || $font['source'] == 'custom-font') {
													foreach (explode(', ', $font['name']) as $fname) {
														echo '<option value="' . '\'' . $fname . '\', ' . $alternative_fonts . '">' . $fname . '</option>';
													}
												} elseif ($font['source'] == 'upload-font') {
													$fontNames = json_decode($font['name']);
													foreach (json_decode($font['url']) as $extension => $data) :
														foreach ($data as $key => $url) {
															$fontName = $fontNames->$extension->$key;
															echo '<option value="' . '\'' . $fontName . '\', ' . $alternative_fonts . '">' . $fontName . '</option>';
														}
													endforeach;
												} else {
													echo '<option value="' . '\'' . $font['name'] . '\', ' . $alternative_fonts . '">' . $font['name'] . '</option>';
												}
											}
										}
										/*
										 * Theme Options Typographies.
										 */
										if( $theme_opts_typographies ) {
											foreach ($theme_opts_typographies as $fontfamily) {
												if ( 'Select Font' != $fontfamily ) {
													$alternative_fonts = $alternative_fonts ? $alternative_fonts : 'Arial, Roboto, Sans-serif';
													echo '<option value="' . '\'' . $fontfamily . '\', ' . $alternative_fonts . '">' . $fontfamily . '</option>';
												}
											}
										}
										?>
									</select>

								</label>
								<!-- Font Weight -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="font-weight"></i>
									<span><?php echo __('Font Weight', 'kata-plus'); ?></span>
									<select name="font-weight">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="100">100 | Thin</option>
										<option value="200">200 | Extra Light</option>
										<option value="300">300 | Light</option>
										<option value="400">400 | Normal</option>
										<option value="500">500 | Medium</option>
										<option value="600">600 | Semi Bold</option>
										<option value="700">700 | Bold</option>
										<option value="800">800 | Extra Bold</option>
										<option value="900">900 | High Bold</option>
									</select>
								</label>

								<!-- Font Style -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="font-style"></i>
									<span><?php echo __('Font Style', 'kata-plus'); ?></span>
									<div class="custom-select">
										<span data-name="normal" class="styler-tooltip normal" data-tooltip="Normal"><strong>T</strong></span>
										<span data-name="italic" class="styler-tooltip italic" data-tooltip="Italic"><strong>T</strong></span>
										<span data-name="oblique" class="styler-tooltip oblique" data-tooltip="Oblique"><strong>T</strong></span>
									</div>
									<input type="hidden" name="font-style">
								</label>
							</div>
							<!-- Text Options -->
							<h3><?php echo __('Text Options', 'kata-plus'); ?></h3>
							<div class="form-group">
								<!-- Text Align -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="text-align"></i>
									<span><?php echo __('Text Align', 'kata-plus'); ?></span>
									<div class="custom-select">
										<span data-name="left" class="styler-tooltip" data-tooltip="Left"><?php echo Kata_Plus_Helpers::get_icon('themify', 'align-left'); ?></span>
										<span data-name="center" class="styler-tooltip" data-tooltip="Center"><?php echo Kata_Plus_Helpers::get_icon('themify', 'align-center'); ?></span>
										<span data-name="right" class="styler-tooltip" data-tooltip="Right"><?php echo Kata_Plus_Helpers::get_icon('themify', 'align-right'); ?></span>
										<span data-name="justify" class="styler-tooltip" data-tooltip="Justify"><?php echo Kata_Plus_Helpers::get_icon('themify', 'align-justify'); ?></span>
									</div>
									<input type="hidden" name="text-align">
								</label>
								<!-- Transform -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="text-transform"></i>
									<span><?php echo __('Text Transform', 'kata-plus'); ?></span>
									<div class="custom-select">
										<span data-name="none" class="styler-tooltip" data-tooltip="none"><?php echo Kata_Plus_Helpers::get_icon('themify', 'na'); ?></span>
										<span data-name="uppercase" class="styler-tooltip" data-tooltip="Uppercase"><strong>TT</strong></span>
										<span data-name="lowercase" class="styler-tooltip" data-tooltip="lowercase"><strong>tt</strong></span>
										<span data-name="capitalize" class="styler-tooltip" data-tooltip="Capitalize"><strong>Tt</strong></span>
									</div>
									<input type="hidden" name="text-transform">
								</label>
								<!-- Decoration -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="text-decoration"></i>
									<span><?php echo __('Text Decoration', 'kata-plus'); ?></span>
									<div class="custom-select">
										<span data-name="none" class="styler-tooltip" data-tooltip="none"><?php echo Kata_Plus_Helpers::get_icon('themify', 'na'); ?></span>
										<span data-name="underline" class="styler-tooltip underline" data-tooltip="underline"><strong>T</strong></span>
										<span data-name="overline" class="styler-tooltip overline" data-tooltip="Overline"><strong>T</strong></span>
										<span data-name="line-through" class="styler-tooltip line-through" data-tooltip="Line-through"><strong>T</strong></span>
									</div>
									<input type="hidden" name="text-decoration">

								</label>
								<!-- Letter Spacing -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="letter-spacing"></i>
									<span><?php echo __('Letter Spacing', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" max="50" min="0">
									</div>
									<input type="text" name="letter-spacing" data-unit="px" data-units="px,em,%">
								</label>
								<!-- Writing Mode -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="writing-mode"></i>
									<span><?php echo __('Writing Mode', 'kata-plus'); ?></span>
									<select name="writing-mode">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="horizontal-tb">horizontal-tb</option>
										<option value="vertical-rl">vertical-rl</option>
										<option value="vertical-lr">vertical-lr</option>
									</select>
								</label>
								<!-- Text Orientation -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="text-orientation"></i>
									<span><?php echo __('Text Orientation', 'kata-plus'); ?></span>
									<select name="text-orientation">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="mixed">mixed</option>
										<option value="upright">upright</option>
										<option value="sideways">sideways</option>
										<option value="sideways-right">sideways-right</option>
									</select>
								</label>
							</div> <!-- .form-group -->
						</div> <!-- .styler-tab-font-typography -->

						<!-- Display -->
						<div class="styler-tab styler-tab-display" data-name="display">
							<!-- Display Options -->
							<h3><?php echo __('Display Options', 'kata-plus'); ?></h3>
							<!-- Display -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="display"></i>
								<span><?php echo __('Display', 'kata-plus'); ?></span>
								<select name="display">
									<option value="">Default</option>
									<option value="inline">inline</option>
									<option value="block">block</option>
									<option value="none">none</option>
									<option value="contents">contents</option>
									<option value="flex">flex</option>
									<option value="grid">grid</option>
									<option value="inline-block">inline-block</option>
									<option value="inline-flex">inline-flex</option>
									<option value="inline-grid">inline-grid</option>
									<option value="inline-table">inline-table</option>
									<option value="list-item">list-item</option>
									<option value="run-in">run-in</option>
									<option value="table">table</option>
									<option value="table-caption">table-caption</option>
									<option value="table-column-group">table-column-group</option>
									<option value="table-header-group">table-header-group</option>
									<option value="table-footer-group">table-footer-group</option>
									<option value="table-row-group">table-row-group</option>
									<option value="table-cell">table-cell</option>
									<option value="table-column">table-column</option>
									<option value="table-row">table-row</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>
							</label>
							<!-- Box-Sizing -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="box-sizing"></i>
								<span><?php echo __('Box Sizing', 'kata-plus'); ?></span>
								<select name="box-sizing">
									<option value="">Default</option>
									<option value="content-box">content-box</option>
									<option value="border-box">border-box</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>
							</label>
							<!-- Float -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="float"></i>
								<span><?php echo __('Float', 'kata-plus'); ?></span>
								<select name="float">
									<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
									<option value="left">Left</option>
									<option value="right">Right</option>
									<option value="none">None</option>
									<option value="initial">Initial</option>
									<option value="inherit">Inherit</option>
								</select>
							</label>
							<!-- Clear -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="clear"></i>
								<span><?php echo __('Clear', 'kata-plus'); ?></span>
								<select name="clear">
									<option value="">Default</option>
									<option value="both">Both</option>
									<option value="right">Right</option>
									<option value="left">Left</option>
									<option value="none">None</option>
								</select>
							</label>
							<!-- Overflow -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="oveflow"></i>
								<span><?php echo __('Overflow', 'kata-plus'); ?></span>
								<select name="overflow">
									<option value="">Default</option>
									<option value="visible">Visible</option>
									<option value="hidden">Hidden</option>
									<option value="scroll">Scroll</option>
									<option value="auto">Auto</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>
							</label>
							<!-- Vertical Align -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="vertical-align"></i>
								<span><?php echo __('Vertical Align', 'kata-plus'); ?></span>
								<select name="vertical-align">
									<option value="">Default</option>
									<option value="baseline">baseline</option>
									<option value="length">length</option>
									<option value="sub">sub</option>
									<option value="super">super</option>
									<option value="top">top</option>
									<option value="text-top">text-top</option>
									<option value="middle">middle</option>
									<option value="bottom">bottom</option>
									<option value="text-bottom">text-bottom</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>
							</label>
							<!-- Direction -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="direction"></i>
								<span><?php echo __('Direction', 'kata-plus'); ?></span>
								<select name="direction">
									<option value="">Default</option>
									<option value="ltr">LTR</option>
									<option value="rtl">RTL</option>
								</select>
							</label>
							<!-- Cursor -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="cursor"></i>
								<span><?php echo __('Cursor', 'kata-plus'); ?></span>
								<select name="cursor">
									<option value="">Default</option>
									<option value="alias">alias</option>
									<option value="all-scroll">all-scroll</option>
									<option value="auto">auto</option>
									<option value="cell">cell</option>
									<option value="context-menu">context-menu</option>
									<option value="col-resize">col-resize</option>
									<option value="copy">copy</option>
									<option value="crosshair">crosshair</option>
									<option value="default">default</option>
									<option value="e-resize">e-resize</option>
									<option value="ew-resize">ew-resize</option>
									<option value="grab">grab</option>
									<option value="grabbing">grabbing</option>
									<option value="help">help</option>
									<option value="move">move</option>
									<option value="n-resize">n-resize</option>
									<option value="ne-resize">ne-resize</option>
									<option value="nesw-resize">nesw-resize</option>
									<option value="ns-resize">ns-resize</option>
									<option value="nw-resize">nw-resize</option>
									<option value="nwse-resize">nwse-resize</option>
									<option value="no-drop">no-drop</option>
									<option value="none">none</option>
									<option value="not-allowed">not-allowed</option>
									<option value="pointer">pointer</option>
									<option value="progress">progress</option>
									<option value="row-resize">row-resize</option>
									<option value="s-resize">s-resize</option>
									<option value="se-resize">se-resize</option>
									<option value="sw-resize">sw-resize</option>
									<option value="text">text</option>
									<option value="URL">URL</option>
									<option value="vertical-text">vertical-text</option>
									<option value="w-resize">w-resize</option>
									<option value="wait">wait</option>
									<option value="zoom-in">zoom-in</option>
									<option value="zoom-out">zoom-out</option>
									<option value="initial">initial</option>
									<option value="inherit">inherit</option>
								</select>
							</label>
							<!-- Object Fit -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="object-fit"></i>
								<span><?php echo __('Object Fit', 'kata-plus'); ?></span>
								<select name="object-fit">
									<option value="">Default</option>
									<option value="fill">fill</option>
									<option value="contain">contain</option>
									<option value="cover">cover</option>
									<option value="none">none</option>
									<option value="scale-down">scale-down</option>
								</select>
							</label>
							<!-- Position -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="object-position"></i>
								<span><?php echo __('Object Position', 'kata-plus'); ?></span>
								<select name="object-position">
									<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
									<option value="top">top</option>
									<option value="left">left</option>
									<option value="center">center</option>
									<option value="right">right</option>
									<option value="bottom">bottom</option>
									<option value="left top">left top</option>
									<option value="left center">left center</option>
									<option value="left bottom">left bottom</option>
									<option value="right top">right top</option>
									<option value="right center">right center</option>
									<option value="right bottom">right bottom</option>
									<option value="center top">center top</option>
									<option value="center center">center center</option>
									<option value="center bottom">center bottom</option>
								</select>
							</label>
							<!-- Visibility -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="visibility"></i>
								<span><?php echo __('Visibility', 'kata-plus'); ?></span>
								<select name="visibility">
									<option value="">Default</option>
									<option value="visible">Visible</option>
									<option value="hidden">Hidden</option>
									<option value="collapse">Collapse</option>
									<option value="initial">Initial</option>
									<option value="inherit">Inherit</option>
								</select>
							</label>
							<!-- Opacity -->
							<label>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="opacity"></i>
								<span><?php echo __('Opacity', 'kata-plus'); ?></span>
								<div class="range-wrap">
									<input type="range" step="0.1" min="0" max="1">
								</div>
								<input type="text" name="opacity" data-unit="">
							</label>
							<div class="display-flex-options hidden">
								<!-- Align Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="align-content"></i>
									<span><?php echo __('Align Content', 'kata-plus'); ?></span>
									<select name="align-content">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="stretch">stretch</option>
										<option value="center">center</option>
										<option value="flex-start">flex-start</option>
										<option value="flex-end">flex-end</option>
										<option value="space-between">space-between</option>
										<option value="space-around">space-around</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>
								</label>
								<!-- Align Items -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="align-items"></i>
									<span><?php echo __('Align Items', 'kata-plus'); ?></span>
									<select name="align-items">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="stretch">stretch</option>
										<option value="center">center</option>
										<option value="flex-start">flex-start</option>
										<option value="flex-end">flex-end</option>
										<option value="baseline">baseline</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>
								</label>
								<!-- Justify Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="justify-content"></i>
									<span><?php echo __('Justify Content', 'kata-plus'); ?></span>
									<select name="justify-content">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="flex-start">flex-start</option>
										<option value="flex-end">flex-end</option>
										<option value="center">center</option>
										<option value="space-between">space-between</option>
										<option value="space-around">space-around</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>
								</label>
								<!-- Flex Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="flex"></i>
									<span><?php echo __('Flex', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" step="1" min="0" max="100">
									</div>
									<input type="text" name="flex-basis" data-unit="">
								</label>
								<!-- Flex-Direction Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="flex-direction"></i>
									<span><?php echo __('Flex Direction', 'kata-plus'); ?></span>
									<select name="flex-direction">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="row">row</option>
										<option value="row-reverse">row-reverse</option>
										<option value="column">column</option>
										<option value="column-reverse">column-reverse</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>
								</label>
								<!-- Flex-Wrap Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="flex-wrap"></i>
									<span><?php echo __('Flex Wrap', 'kata-plus'); ?></span>
									<select name="flex-wrap">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="nowrap">nowrap</option>
										<option value="wrap">wrap</option>
										<option value="wrap-reverse">wrap-reverse</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>
								</label>
								<!-- Align-Self Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="align-self"></i>
									<span><?php echo __('Align Self', 'kata-plus'); ?></span>
									<select name="align-self">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="auto">auto</option>
										<option value="stretch">stretch</option>
										<option value="center">center</option>
										<option value="flex-start">flex-start</option>
										<option value="flex-end">flex-end</option>
										<option value="baseline">baseline</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>
								</label>
								<!-- Flex-Flow Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="flex-flow"></i>
									<span><?php echo __('Flex Flow', 'kata-plus'); ?></span>
									<select name="flex-flow">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="row nowrap">row nowrap</option>
										<option value="row-reverse nowrap">row-reverse nowrap</option>
										<option value="column nowrap">column nowrap</option>
										<option value="column-reverse nowrap">column-reverse nowrap</option>
										<option value="row wrap">row wrap</option>
										<option value="row-reverse wrap">row-reverse wrap</option>
										<option value="column wrap">column wrap</option>
										<option value="column-reverse wrap">column-reverse wrap</option>
										<option value="row wrap-reverse">row wrap-reverse</option>
										<option value="row-reverse wrap-reverse">row-reverse wrap-reverse</option>
										<option value="column wrap-reverse">column wrap-reverse</option>
										<option value="column-reverse wrap-reverse">column-reverse wrap-reverse</option>
									</select>
								</label>
								<!-- Order Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="order"></i>
									<span><?php echo __('Order', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" step="1" min="0" max="20">
									</div>
									<input type="text" name="order" data-unit="">
								</label>
								<!-- Flex-Grow Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="flex-grow"></i>
									<span><?php echo __('Flex Grow', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" step="1" min="0" max="20">
									</div>
									<input type="text" name="flex-grow" data-unit="">
								</label>
								<!-- Flex-Shrink Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="flex-shrink"></i>
									<span><?php echo __('Flex Shrink', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" step="1" min="0" max="20">
									</div>
									<input type="text" name="flex-shrink" data-unit="">
								</label>
								<!-- Flex-Basis Content -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="flex-basis"></i>
									<span><?php echo __('Flex Basis', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" step="1" min="0" max="100">
									</div>
									<input type="text" name="flex-basis" data-unit="px">
								</label>
							</div>
						</div>
						<!-- Background -->
						<div class="styler-tab styler-tab-background" data-name="background">
							<!-- Background Options -->
							<div class="form-group">
								<div class="styler-tabs-wrap">
									<h3><?php echo __('Background Type', 'kata-plus'); ?></h3>
									<div class="styler-tabs-items">
										<span data-tab="normal" class="active"><?php echo __('Classic', 'kata-plus'); ?></span>
										<span data-tab="gradient"><?php echo __('Gradient', 'kata-plus'); ?></span>
									</div>

									<div class="color-picker-wrap">
										<!-- Background Color -->
										<label class="inline" for="styler-background-color-option">
											<i class="kata-important-btn eicon-star" data-task="important" data-field="background-color"></i>
											<span><?php echo __('Color', 'kata-plus'); ?></span>
										</label>
										<div class="color-picker-input"></div>
										<input type="hidden" name="background-color" id="styler-background-color-option" data-alpha="true" class="color-picker">
									</div>
									<!-- Normal -->
									<div class="styler-inner-tab active" data-name="normal">
										<!-- Image -->
										<label class="styler_upload">
											<i class="kata-important-btn eicon-star" data-task="important" data-field="background-image"></i>
											<span><?php echo __('Image', 'kata-plus'); ?></span>
											<div class="image-container">
												<span class="remove hidden"><?php echo __('remove', 'kata-plus'); ?></span>
												<a href="#">+</a>
											</div>
											<input type="hidden" name="background-image">
										</label>
										<!-- Repeat -->
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="background-repeat"></i>
											<span><?php echo __('Repeat', 'kata-plus'); ?></span>
											<select name="background-repeat">
												<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
												<option value="repeat">repeat</option>
												<option value="repeat-x">repeat-x</option>
												<option value="repeat-y">repeat-y</option>
												<option value="no-repeat">no-repeat</option>
											</select>
										</label>
										<!-- Attachment -->
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="background-attachment"></i>
											<span><?php echo __('Attachment', 'kata-plus'); ?></span>
											<select name="background-attachment">
												<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
												<option value="scroll">scroll</option>
												<option value="fixed">fixed</option>
											</select>
										</label>
										<!-- Position -->
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="background-position"></i>
											<span><?php echo __('Position', 'kata-plus'); ?></span>
											<select name="background-position">
												<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
												<option value="left top">left top</option>
												<option value="left center">left center</option>
												<option value="left bottom">left bottom</option>
												<option value="right top">right top</option>
												<option value="right center">right center</option>
												<option value="right bottom">right bottom</option>
												<option value="center top">center top</option>
												<option value="center center">center center</option>
												<option value="center bottom">center bottom</option>
												<option value="custom">Custom</option>
											</select>
										</label>
										<div class="inline-inputs background-position-custom-wrap hidden" data-units="px,em,%">
											<label style="width: 50%;">
												<i class="kata-important-btn eicon-star" data-task="important" data-field="background-position-x"></i>
												<span>X</span>
												<input type="text" name="background-position-x" data-unit="px">
											</label>
											<label style="width: 50%;">
												<i class="kata-important-btn eicon-star" data-task="important" data-field="background-position-y"></i>
												<span>Y</span>
												<input type="text" name="background-position-y" data-unit="px">
											</label>
											<i class="eicon-editor-link connect-all"></i>
										</div>
										<!-- Size -->
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="background-size"></i>
											<span><?php echo __('Size', 'kata-plus'); ?></span>
											<select name="background-size">
												<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
												<option value="auto">auto</option>
												<option value="cover">cover</option>
												<option value="contain">contain</option>
												<option value="inherit">inherit</option>
												<option value="initial">initial</option>
												<option value="custom">Custom</option>
											</select>
										</label>
										<div class="inline-inputs background-size-custom-wrap hidden" data-units="px,em,%">
											<label style="width: 50%;">
												<i class="kata-important-btn eicon-star" data-task="important" data-field="background-size-x"></i>
												<span>X</span>
												<input type="text" name="background-size-x" data-unit="px">
											</label>
											<label style="width: 50%;">
												<i class="kata-important-btn eicon-star" data-task="important" data-field="background-size-y"></i>
												<span>Y</span>
												<input type="text" name="background-size-y" data-unit="px">
											</label>
											<i class="eicon-editor-link connect-all"></i>
										</div>
									</div>
									<!-- Gradient -->
									<div class="styler-inner-tab" data-name="gradient">
										<!-- Second Background Color -->
										<div class="color-picker-wrap">
											<label class="inline" for="styler-background-color2-option">
												<i class="kata-important-btn eicon-star" data-task="important" data-field="background-color2"></i>
												<span><?php echo __('Second Color', 'kata-plus'); ?></span>
											</label>
											<div class="color-picker-input"></div>
											<input type="hidden" name="background-color2" id="styler-background-color2-option" data-alpha="true" class="color-picker">
										</div>

										<!-- Angel -->
										<label>
											<span><?php echo __('Angel', 'kata-plus'); ?></span>
											<div class="range-wrap">
												<input type="range" min="0" max="360">
											</div>
											<input type="text" name="angel" data-unit="deg">
										</label>

									</div>
									<!-- Use Background As Color -->
									<label>
										<span><?php echo __('Use As Color', 'kata-plus'); ?></span>
										<div class="custom-select">
											<span data-name="yes" class="styler-tooltip" data-tooltip="Use Background As Color"><strong>Yes</strong></span>
											<span data-name="no" class="styler-tooltip" data-tooltip="Don`t Use Background As Color"><strong>No</strong></span>
										</div>
										<input type="hidden" id="use-background-color-as-color">
										<input type="text" name="-webkit-background-clip" style="display:none;">
										<input type="text" name="-webkit-text-fill-color" style="display:none;">
									</label>
									<!-- Background image none -->
									<label class="inline" for="background-image-none">
										<i class="kata-important-btn eicon-star" data-task="important" data-field="background-image-none"></i>
										<span><?php echo __( 'Background image none', 'kata-plus' ); ?></span>
										<div class="switcher-wrap">
											<input type="checkbox" id="background-image-none" name="background-image-none" value="">
											<span class="switcher-circle"></span>
										</div>
									</label>
								</div>
							</div>
						</div> <!-- .styler-tab-background -->
						<!-- With & Height -->
						<div class="styler-tab styler-tab-width-height" data-name="width-height">
							<!-- Width Options -->
							<h3><?php echo __('Width Options', 'kata-plus'); ?></h3>
							<div class="form-group">
								<!-- Width -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="width"></i>
									<span><?php echo __('Width', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range">
									</div>
									<input type="text" name="width" data-unit="px" data-units="px,em,%">
								</label>
								<!-- Min Width -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="min-width"></i>
									<span><?php echo __('Min Width', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range">
									</div>
									<input type="text" name="min-width" data-unit="px" data-units="px,em,%">
								</label>
								<!-- Max Width -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="max-width"></i>
									<span><?php echo __('Max Width', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range">
									</div>
									<input type="text" name="max-width" data-unit="px" data-units="px,em,%">
								</label>
							</div>
							<!-- Height Options -->
							<h3><?php echo __('Height Options', 'kata-plus'); ?></h3>
							<div class="form-group">
								<!-- Height -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="height"></i>
									<span><?php echo __('Height', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range">
									</div>
									<input type="text" name="height" data-unit="px" data-units="px,em,%">
								</label>
								<!-- Min Height -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="min-height"></i>
									<span><?php echo __('Min Height', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range">
									</div>
									<input type="text" name="min-height" data-unit="px" data-units="px,em,%">
								</label>
								<!-- Max Height -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="max-height"></i>
									<span><?php echo __('Max Height', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range">
									</div>
									<input type="text" name="max-height" data-unit="px" data-units="px,em,%">
								</label>
							</div>
						</div> <!-- .styler-tab-width-height -->

						<!-- Padding Options -->
						<div class="styler-tab styler-tab-padding" data-name="padding-margin">
							<!-- Padding & Margin -->
							<h3><?php echo __('Padding Options', 'kata-plus'); ?></h3>
							<div class="form-group">
								<div class="group-input styler-padding" data-name="padding">
									<div class="inline-inputs" data-units="px,em,%">
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="padding-top"></i>
											<span><?php echo __('Top', 'kata-plus'); ?></span>
											<input type="text" name="padding-top" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="padding-right"></i>
											<span><?php echo __('Right', 'kata-plus'); ?></span>
											<input type="text" name="padding-right" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="padding-bottom"></i>
											<span><?php echo __('Bottom', 'kata-plus'); ?></span>
											<input type="text" name="padding-bottom" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="padding-left"></i>
											<span><?php echo __('Left', 'kata-plus'); ?></span>
											<input type="text" name="padding-left" data-unit="px">
										</label>
										<i class="eicon-editor-link connect-all"></i>
									</div>
								</div>
							</div>
							<!-- Margin Options -->
							<h3><?php echo __('Margin Options', 'kata-plus'); ?></h3>
							<div class="form-group">
								<div class="group-input styler-margin" data-name="margin">
									<div class="inline-inputs" data-units="px,em,%">
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="margin-top"></i>
											<span><?php echo __('Top', 'kata-plus'); ?></span>
											<input type="text" name="margin-top" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="margin-right"></i>
											<span><?php echo __('Right', 'kata-plus'); ?></span>
											<input type="text" name="margin-right" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="margin-bottom"></i>
											<span><?php echo __('Bottom', 'kata-plus'); ?></span>
											<input type="text" name="margin-bottom" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="margin-left"></i>
											<span><?php echo __('Left', 'kata-plus'); ?></span>
											<input type="text" name="margin-left" data-unit="px">
										</label>
										<i class="eicon-editor-link connect-all"></i>
									</div>
								</div>
							</div>
						</div>
						<!-- Border Options -->
						<div class="styler-tab styler-tab-border" data-name="border">
							<!-- Border Options -->
							<h3><?php echo __('Border Options', 'kata-plus'); ?></h3>
							<div class="form-group">
								<!-- Border Style -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="border-style"></i>
									<span><?php echo __('Border Style', 'kata-plus'); ?></span>
									<select name="border-style">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="solid">solid</option>
										<option value="dotted">dotted</option>
										<option value="dashed">dashed</option>
										<option value="double">double</option>
										<option value="none">none</option>
										<option value="unset">unset</option>
									</select>
								</label>
								<div class="group-input" data-name="border">
									<h3><?php echo __('Border Width', 'kata-plus'); ?></h3>
									<div class="inline-inputs" data-units="px,em,%">
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-top-width"></i>
											<span><?php echo __('Top', 'kata-plus'); ?></span>
											<input type="text" name="border-top-width" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-right-width"></i>
											<span><?php echo __('Right', 'kata-plus'); ?></span>
											<input type="text" name="border-right-width" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-bottom-width"></i>
											<span><?php echo __('Bottom', 'kata-plus'); ?></span>
											<input type="text" name="border-bottom-width" data-unit="px">
										</label>
										<label>
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-left-width"></i>
											<span><?php echo __('Left', 'kata-plus'); ?></span>
											<input type="text" name="border-left-width" data-unit="px">
										</label>
										<i class="eicon-editor-link connect-all"></i>
									</div>
								</div>
								<!-- Border Radius -->
								<h3><?php echo __('Border Radius', 'kata-plus'); ?></h3>
								<div class="form-group">
									<div class="group-input" data-name="border-radius">
										<div class="inline-inputs" data-units="px,em,%">
											<label>
												<i class="kata-important-btn eicon-star" data-task="important" data-field="border-top-left-radius"></i>
												<span><?php echo __('Top', 'kata-plus'); ?></span>
												<input type="text" name="border-top-left-radius" data-unit="px">
											</label>
											<label>
												<i class="kata-important-btn eicon-star" data-task="important" data-field="border-top-right-radius"></i>
												<span><?php echo __('Right', 'kata-plus'); ?></span>
												<input type="text" name="border-top-right-radius" data-unit="px">
											</label>
											<label>
												<i class="kata-important-btn eicon-star" data-task="important" data-field="border-bottom-right-radius"></i>
												<span><?php echo __('Bottom', 'kata-plus'); ?></span>
												<input type="text" name="border-bottom-right-radius" data-unit="px">
											</label>
											<label>
												<i class="kata-important-btn eicon-star" data-task="important" data-field="border-bottom-left-radius"></i>
												<span><?php echo __('Left', 'kata-plus'); ?></span>
												<input type="text" name="border-bottom-left-radius" data-unit="px">
											</label>
											<i class="eicon-editor-link connect-all"></i>
										</div>
									</div>
								</div>
								<h3><?php echo __('Border Colors', 'kata-plus'); ?></h3>
								<div class="color-picker-wrap">
									<label class="inline" for="styler-border-color-option">
										<i class="kata-important-btn eicon-star" data-task="important" data-field="border-color"></i>
										<span><?php echo __('Color', 'kata-plus'); ?></span>
									</label>
									<div class="color-picker-input"></div>
									<input type="hidden" name="border-color" id="styler-border-color-option" data-alpha="true" class="color-picker">
								</div>
								<div class="form-group">
									<div class="color-picker-wrap">
										<label class="inline" for="box-shadow-color">
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-top-color"></i>
											<span><?php echo __('Border Top', 'kata-plus'); ?></span>
										</label>
										<div class="color-picker-input"></div>
										<input type="hidden" name="border-top-color" id="border-top-color" data-alpha="true" class="color-picker">
									</div>
								</div>
								<div class="form-group">
									<div class="color-picker-wrap">
										<label class="inline" for="box-shadow-color">
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-bottom-color"></i>
											<span><?php echo __('Border Bottom', 'kata-plus'); ?></span>
										</label>
										<div class="color-picker-input"></div>
										<input type="hidden" name="border-bottom-color" id="border-bottom-color" data-alpha="true" class="color-picker">
									</div>
								</div>
								<div class="form-group">
									<div class="color-picker-wrap">
										<label class="inline" for="box-shadow-color">
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-right-color"></i>
											<span><?php echo __('Border Right', 'kata-plus'); ?></span>
										</label>
										<div class="color-picker-input"></div>
										<input type="hidden" name="border-right-color" id="border-right-color" data-alpha="true" class="color-picker">
									</div>
								</div>
								<div class="form-group">
									<div class="color-picker-wrap">
										<label class="inline" for="box-shadow-color">
											<i class="kata-important-btn eicon-star" data-task="important" data-field="border-left-color"></i>
											<span><?php echo __('Border Left', 'kata-plus'); ?></span>
										</label>
										<div class="color-picker-input"></div>
										<input type="hidden" name="border-left-color" id="border-left-color" data-alpha="true" class="color-picker">
									</div>
								</div>
							</div>

							<div class="clearfix"></div>
						</div> <!-- .styler-tab-border-options -->
						<!-- Shadow Options -->
						<div class="styler-tab styler-tab-shadow" data-name="shadow">
							<!-- Box Shadow -->
							<h3><?php echo __('Box Shadow', 'kata-plus'); ?>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="box-shadow" data-trigger="box-shadow[x]"></i>
								<?php do_action('before_start_shadow_section'); ?>
							</h3>
							<div class="form-group">
								<div class="group-input styler-box-shadow" data-name="box-shadow">
									<div class="inline-inputs">
										<!-- X -->
										<label>
											<span>X</span>
											<input type="text" name="box-shadow[x]" data-unit="px">
										</label>
										<!-- Y -->
										<label>
											<span>Y</span>
											<input type="text" name="box-shadow[y]" data-unit="px">
										</label>
										<!-- Blur -->
										<label>
											<span><?php echo __('Blur', 'kata-plus'); ?></span>
											<input type="text" name="box-shadow[blur]" data-unit="px">
										</label>

										<!-- Spread -->
										<label>
											<span><?php echo __('Spread', 'kata-plus'); ?></span>
											<input type="text" name="box-shadow[spread]" data-unit="px">
										</label>
									</div>
									<!-- Box Shadow Color -->
									<div class="form-group">
										<div class="color-picker-wrap">
											<label class="inline" for="box-shadow-color">
												<span><?php echo __('Color', 'kata-plus'); ?></span>
											</label>
											<div class="color-picker-input"></div>
											<input type="hidden" name="box-shadow[color]" id="box-shadow-color" data-alpha="true" class="color-picker">
										</div>
									</div>
									<label>
										<span><?php echo __('Shadow Mode', 'kata-plus'); ?></span>
										<select name="box-shadow[mode]">
											<option value=""><?php echo __('Default', 'kata-plus'); ?></option>
											<option value="">Outset</option>
											<option value="inset">Inset</option>
										</select>
									</label>
								</div>
							</div>
							<div class="mlti-bx-sh-wrp hidden">
								<h3>+ <?php echo __('Box Shadow', 'kata-plus'); ?>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="box-shadow" data-trigger="box-shadow[x]"></i>
								</h3>
								<div class="form-group multi-box-shadow bxsh-first">
									<div class="multi-box-shadow-color"></div>
									<div class="multi-box-shadow-actions-wrap">
										<div class="add-box-shadow styler-tooltip" data-tooltip="Add New">+</div>
										<div class="remove-box-shadow styler-tooltip" data-tooltip="Remove">-</div>
									</div>
									<div class="group-input styler-multi-box-shadow" data-name="multi-box-shadow">
										<div class="inline-inputs">
											<!-- X -->
											<label>
												<span>X</span>
												<input type="text" name="multi-box-shadow[first][x]" data-unit="px">
											</label>
											<!-- Y -->
											<label>
												<span>Y</span>
												<input type="text" name="multi-box-shadow[first][y]" data-unit="px">
											</label>
											<!-- Blur -->
											<label>
												<span><?php echo __('Blur', 'kata-plus'); ?></span>
												<input type="text" name="multi-box-shadow[first][blur]" data-unit="px">
											</label>

											<!-- Spread -->
											<label>
												<span><?php echo __('Spread', 'kata-plus'); ?></span>
												<input type="text" name="multi-box-shadow[first][spread]" data-unit="px">
											</label>
										</div>
										<!-- Box Shadow Color -->
										<div class="form-group">
											<div class="color-picker-wrap">
												<label class="inline" for="multi-box-shadow-color">
													<span><?php echo __('Color', 'kata-plus'); ?></span>
												</label>
												<div class="color-picker-input"></div>
												<input type="hidden" name="multi-box-shadow[first][color]" id="multi-box-shadow-color" data-alpha="true" class="color-picker">
											</div>
										</div>
										<label>
											<span><?php echo __('Shadow Mode', 'kata-plus'); ?></span>
											<select name="multi-box-shadow[first][mode]">
												<option value=""><?php echo __('Default', 'kata-plus'); ?></option>
												<option value="">Outset</option>
												<option value="inset">Inset</option>
											</select>
										</label>
									</div>
								</div>
							</div>

							<!-- Text Shadow -->
							<h3><?php echo __('Text Shadow', 'kata-plus'); ?>
								<i class="kata-important-btn eicon-star" data-task="important" data-field="text-shadow" data-trigger="text-shadow[x]"></i>
							</h3>
							<div class="form-group">
								<div class="group-input styler-text-shadow" data-name="text-shadow">
									<div class="inline-inputs">
										<!-- X -->
										<label>
											<span>X</span>
											<input type="text" name="text-shadow[x]" data-unit="px">
										</label>
										<!-- Y -->
										<label>
											<span>Y</span>
											<input type="text" name="text-shadow[y]" data-unit="px">
										</label>
										<!-- Blur -->
										<label>
											<span><?php echo __('Blur', 'kata-plus'); ?></span>
											<input type="text" name="text-shadow[blur]" data-unit="px">
										</label>
									</div>
									<!-- Text Shadow Color -->
									<div class="form-group">
										<div class="color-picker-wrap">
											<label class="inline" for="text-shadow-color">
												<span><?php echo __('Color', 'kata-plus'); ?></span>
											</label>
											<div class="color-picker-input"></div>
											<input type="hidden" name="text-shadow[color]" id="text-shadow-color" data-alpha="true" class="color-picker">
										</div>
									</div>
								</div>
							</div>
						</div> <!-- .styler-tab-Shadow -->
						<!-- Position Options -->
						<div class="styler-tab styler-tab-position" data-name="position">
							<!-- Position Options -->
							<h3><?php echo __('Position Options', 'kata-plus'); ?></h3>
							<div class="group-input styler-position" data-name="position">
								<!-- Position -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="position"></i>
									<span><?php echo __('Position', 'kata-plus'); ?></span>
									<select name="position">
										<option value="">Default</option>
										<option value="fixed">Fixed</option>
										<option value="static">Static</option>
										<option value="relative">Relative</option>
										<option value="absolute">Absolute</option>
										<option value="initial">Initial</option>
										<option value="inherit">Inherit</option>
									</select>
								</label>

								<div class="inline-inputs" data-units="px,em,%">
									<label>
										<i class="kata-important-btn eicon-star" data-task="important" data-field="top"></i>
										<span><?php echo __('Top', 'kata-plus'); ?></span>
										<input type="text" name="top" data-unit="px">
									</label>
									<label>
										<i class="kata-important-btn eicon-star" data-task="important" data-field="right"></i>
										<span><?php echo __('Right', 'kata-plus'); ?></span>
										<input type="text" name="right" data-unit="px">
									</label>
									<label>
										<i class="kata-important-btn eicon-star" data-task="important" data-field="bottom"></i>
										<span><?php echo __('Bottom', 'kata-plus'); ?></span>
										<input type="text" name="bottom" data-unit="px">
									</label>
									<label>
										<i class="kata-important-btn eicon-star" data-task="important" data-field="left"></i>
										<span><?php echo __('Left', 'kata-plus'); ?></span>
										<input type="text" name="left" data-unit="px">
									</label>
								</div>
								<!-- Z-Index -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="z-index"></i>
									<span><?php echo __('Z-Index', 'kata-plus'); ?></span>
									<select name="z-index">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="-2">-2</option>
										<option value="-1">-1</option>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="99">99</option>
										<option value="999">999</option>
										<option value="9999">9999</option>
									</select>
								</label>
							</div>
						</div> <!-- .styler-tab-Position -->

						<?php do_action('before_start_svg_section') ?>

						<!-- transform Options -->
						<div class="styler-tab styler-tab-svg" data-name="svg">
							<!-- transform Options -->
							<h3><?php echo __('SVG', 'kata-plus'); ?></h3>
							<div class="form-group">
								<!-- Fill -->
								<div class="color-picker-wrap">
									<label class="inline" for="styler-fill-option">
										<i class="kata-important-btn eicon-star" data-task="important" data-field="fill"></i>
										<span><?php echo __('Fill', 'kata-plus'); ?></span>
									</label>
									<div class="color-picker-input"></div>
									<input type="hidden" name="fill" id="styler-fill-option" data-alpha="true" class="color-picker">
								</div>
								<!-- Stroke -->
								<div class="color-picker-wrap">
									<label class="inline" for="styler-stroke-option">
										<i class="kata-important-btn eicon-star" data-task="important" data-field="stroke"></i>
										<span><?php echo __('Stroke', 'kata-plus'); ?></span>
									</label>
									<div class="color-picker-input"></div>
									<input type="hidden" name="stroke" id="styler-stroke-option" data-alpha="true" class="color-picker">
								</div>
								<!-- Fill Opacity -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="fill-opacity"></i>
									<span><?php echo __('Fill Opacity', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" step="0.1" min="0" max="1">
									</div>
									<input type="text" name="fill-opacity" data-unit="">
								</label>
								<!-- Stroke Opacity -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="stroke-opacity"></i>
									<span><?php echo __('Stroke Opacity', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" step="0.1" min="0" max="1">
									</div>
									<input type="text" name="stroke-opacity" data-unit="">
								</label>
								<!-- Stroke Width -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="stroke-width"></i>
									<span><?php echo __('Stroke Width', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range">
									</div>
									<input type="text" name="stroke-width" data-unit="px" data-units="px,em,%">
								</label>
							</div>
						</div> <!-- .styler-tab-transform -->

						<!-- animation Options -->
						<div class="styler-tab styler-tab-animation" data-name="animation">
							<!-- Transition Options -->
							<h3><?php echo __('Transition', 'kata-plus'); ?></h3>
							<div class="form-group">
								<!-- Duration -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="transition-duration"></i>
									<span><?php echo __('Duration', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" min="0" max="5000">
									</div>
									<input type="text" name="transition-duration" data-unit="ms">
								</label>

								<!-- transition-timing-function -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="transition-timing-function"></i>
									<span><?php echo __('FX', 'kata-plus'); ?></span>
									<select name="transition-timing-function">
										<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
										<option value="ease">ease</option>
										<option value="linear">linear</option>
										<option value="ease-in">ease-in</option>
										<option value="ease-out">ease-out</option>
										<option value="ease-in-out">ease-in-out</option>
										<option value="step-start">step-start</option>
										<option value="step-end">step-end</option>
										<option value="initial">initial</option>
										<option value="inherit">inherit</option>
									</select>
								</label>

								<!-- Delay -->
								<label>
									<i class="kata-important-btn eicon-star" data-task="important" data-field="transition-delay"></i>
									<span><?php echo __('Delay', 'kata-plus'); ?></span>
									<div class="range-wrap">
										<input type="range" min="0" max="5000">
									</div>
									<input type="text" name="transition-delay" data-unit="ms">
								</label>
							</div>

							<?php do_action( 'styler_before_animation_end' ) ?>
						</div> <!-- .styler-tab-animation -->

					</form> <!-- .content -->
				</div>
			</div>
			<?php
		}

		/**
		 *
		 * Breakpints
		 *
		 * @return string
		 */
		public function breakpoints() {
			$breakpoints = did_action('elementor/loaded') ? Kata_Plus_Elementor::get_breakpoints() : '';
			?>
			<li data-name="desktop" class="active">
				<i class="eicon-device-desktop active"></i>
				<strong><?php echo __('Desktop', 'kata-plus'); ?></strong>
				<span><?php echo __('Default Preview', 'kata-plus'); ?></span>
			</li>
			<li>
				<i class="eicon-device-laptop"></i>
				<strong><?php echo __('Laptop', 'kata-plus'); ?></strong>
				<span><?php echo esc_html( $breakpoints['laptop'] );  ?>px</span>
			</li>
			<li>
				<i class="eicon-device-tablet rotate-90"></i>
				<strong><?php echo __('Tablet Landscape', 'kata-plus'); ?></strong>
				<span><?php echo esc_html( $breakpoints['tabletlandscape'] );  ?>px</span>
			</li>
			<li data-name="tablet">
				<i class="eicon-device-tablet"></i>
				<strong><?php echo __('Tablet', 'kata-plus'); ?></strong>
				<span><?php echo esc_html( $breakpoints['tablet'] - 1 );  ?>px</span>
			</li>
			<li data-name="mobile">
				<i class="eicon-device-mobile"></i>
				<strong><?php echo __('Mobile', 'kata-plus'); ?></strong>
				<span><?php echo esc_html( $breakpoints['mobile'] - 1 );  ?>px</span>
			</li>
			<li>
				<i class="eicon-device-mobile small-icon"></i>
				<strong><?php echo __('Small Mobile', 'kata-plus'); ?></strong>
				<span><?php echo esc_html( $breakpoints['smallmobile'] );  ?>px</span>
			</li>
			<?php
		}

		/**
		 * filters and transform panels.
		 *
		 * @since   1.0.0
		 */
		public function styler_filters_and_transform_panels() {
			?>
			<li class="styler-tooltip" data-tooltip="Filters">
				<i class="eicon-review"></i>
				<a href="#"><?php echo __('Filters', 'kata-plus'); ?></a>
			</li>
			<li class="styler-tooltip" data-tooltip="Transform">
				<i class="eicon-integration"></i>
				<a href="#"><?php echo __('Transform', 'kata-plus'); ?></a>
			</li>
			<?php
		}

		/**
		 *
		 * Customizer Fonts
		 *
		 * @return string
		 */
		public static function customizer_fonts() {
			$fonts = get_theme_mod( 'kata_add_google_font_repeater' );
			$added_fonts = [];
			$added_fonts['select-font'] = 'Select Font';
			if ( $fonts ) {
				foreach ($fonts as $key => $font) {
					$added_fonts[$font['fonts']] = $font['fonts'];
				}
			}
			return $added_fonts;
		}

		/**
		 *
		 * actions
		 *
		 * @return string
		 */
		public function styler_actions() {
			?>
			<span><i class="ti-lock"></i><?php echo __('Parent Hover', 'kata-plus'); ?></span>
			<span><i class="ti-lock"></i><?php echo __('Before', 'kata-plus'); ?></span>
			<span><i class="ti-lock"></i><?php echo __('After', 'kata-plus'); ?></span>
			<?php
		}
	}
	// Run
	Kata_Styler::instance();
}
