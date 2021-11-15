<?php

/**
 * Kata Plus Theme Options Helpers.
 *
 * @since   1.0.0
 */

if ( !class_exists( 'Kata_Plus_Theme_Options_Functions' ) ) {
	class Kata_Plus_Theme_Options_Functions {
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Theme_Options_Functions
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return   object
		 */
		public static function get_instance() {
			if (self::$instance === null) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->actions();
		}

		/**
		 * Add actions.
		 *
		 * @since    1.0.0
		 */
		public function actions() {
			// Responsive
			add_filter( 'wp_head', [$this, 'option_responsive'], 100 );
			// Load google fonts
			add_action( 'wp_enqueue_scripts', [$this, 'load_google_fonts'] );
			// Option Dynamic Styles
			// customize_preview_init
			add_action( 'customize_preview_init', [$this, 'option_dynamic_styles'], 999999 );
			add_action( 'customize_preview_init', [$this, 'customizer_styler_css'], 999999 );
			// header transparent
			add_action( 'customize_preview_init', [$this, 'header_transparent'], 999999 );
			// Enqueue Scripts
			add_action( 'elementor/frontend/after_register_scripts', [$this, 'kata_plus_inline_scripts'], 999999 );
			// Page Title
			add_action( 'kata_page_before_loop', [$this, 'page_title'], 10 );
			// Sidebars
			add_action( 'kata_page_before_loop', [$this, 'left_sidebar'], 30 );
			add_action( 'kata_page_before_the_content', [$this, 'start_page_with_sidebar'] );
			add_action( 'kata_page_after_the_content', [$this, 'end_page_with_sidebar'] );
			add_action( 'kata_page_after_loop', [$this, 'right_sidebar'] );
			// Section Slider Page
			add_action( 'kata_page_before_loop', [$this, 'start_full_page_slider'], 40 );
			add_action( 'kata_page_after_loop', [$this, 'end_full_page_slider'], 40 );
			// Body Classes
			add_filter( 'body_class', [$this, 'body_classes'] );
			// Backup customizer
			add_action( 'wp_head', [$this, 'backup_customizer'] );
			add_action( 'wp_head', [$this, 'restore_backup_customizer'] );
			// add_action( 'wp_body_open', [$this, 'builders_page_options'] );
		}

		/**
		 * Enqueue dynamic inline scripts.
		 *
		 * @since   1.0.0
		 */
		public function kata_plus_inline_scripts() {
			wp_enqueue_script( 'kata-plus-inline-script', Kata_Plus::$assets . 'js/frontend/kata-plus-inline.js', ['jquery'], Kata_Plus::$version, true );
			$scripts = '(function ($) { jQuery(document).ready(function () {';
			$scripts .= '';
			$scripts = apply_filters( 'kata_plus_inline_scripts', $scripts );
			$scripts .= '}); })(jQuery);';
			wp_add_inline_script( 'kata-plus-inline-script', Kata_Plus_Helpers::jsminifier( $scripts ), 'after' );
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function load_google_fonts( $classes ) {
			$fonts = get_theme_mod( 'kata_add_google_font_repeater' );
			if ( class_exists('Kata_Plus_Pro') ) {
				if ( $fonts ) {
					foreach ($fonts as $key => $font) {
						$arr[] = [
							'ID'			=> rand( '99', '9999' ),
							'name'			=> $font['fonts'],
							'source'		=> 'google',
							'selectors'		=> '[]',
							'subsets'		=> '[]',
							'variants'		=> explode( ',', $font['varients'] ),
							'url'			=> '',
							'place'			=> 'head',
							'status'		=> 'published',
							'created_at'	=> '1613900176',
							'updated_at'	=> '161450209'
						] ;
					}
					$free_fonts = json_encode( $arr, true );
					if ( ! get_option( 'migrate_to_fonts_manger_pro' ) ) {
						update_option( 'migrate_to_fonts_manger_pro' , $free_fonts );
						global $wpdb;
						$importData = $free_fonts;
						$importData = str_replace('\"', '"', $importData);
						$importData = str_replace('\\"', '"', $importData);
						$importData = json_decode($importData, true);
						if (!$importData) {
							return;
						}
						foreach ($importData as $font) {
							$wpdb->insert(
								$wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
								array(
									'name'          => $font['name'],
									'source'        => $font['source'],
									'selectors'     => $font['selectors'],
									'subsets'       => $font['subsets'],
									'variants'      => $font['variants'],
									'url'           => $font['url'],
									'place'         => $font['place'],
									'status'        => $font['status'],
									'created_at'    => $font['created_at'],
									'updated_at'    => $font['updated_at'],
								)
							);
						}
					}
				}
				return;
			}
			$voiced_fonts = '';
			if ( $fonts ) {
				foreach ($fonts as $key => $font) {
					$voiced_fonts .= $font['fonts'] . ':' . $font['varients'] . '|';
				}
			}
			$src = 'https://fonts.googleapis.com/css?family=' . $voiced_fonts;
			if ( $voiced_fonts ) {
				wp_enqueue_style( 'kata-plus-basic-google-fonts', $src, [], Kata_Plus::$version );
			}
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function body_classes($classes) {
			$colorbase = get_theme_mod('kata_base_color', '');
			if (!empty($colorbase)) {
				$classes[] = 'kata-color-base';
			}

			return $classes;
		}

		/**
		 * Customizer styler css.
		 *
		 * @since   1.0.0
		 */
		public function builders_page_options() {
			if ( is_archive() ) {
				remove_action( 'kata_header', array(Kata_Plus_Builders_Base::get_instance(), 'load_the_builder') );
			}
			if ( is_tag() ) {
			}
			if ( is_author() ) {
			}
			if ( is_404() ) {
			}
			if ( Kata_Plus_helpers::is_blog_pages() ) {
			}
			if ( Kata_Plus_helpers::is_blog() ) {
			}
			if ( is_search() ) {
			}
		}

		/**
		 * Customizer styler css.
		 *
		 * @since   1.0.0
		 */
		public function customizer_styler_css() {
			if ( class_exists( 'Kirki' ) ) {
				$css = '';
				foreach ( Kirki::$fields as $name => $value ) {
					if ( strpos( $name, 'styler_' ) !== false ) {
						if ( $name ) {
							$defective_style = get_theme_mod( $name );
							if ( $defective_style ) {
								$defective_style = Kata_Styler::css_cleaner( $defective_style );
								set_theme_mod( $name, $defective_style );
							}
							$css .= get_theme_mod( $name );
							/* if( get_option( 'styler_' . $name ) ) {
								foreach( get_option( 'styler_' . $name ) as $index => $val ) {
									if ( ! empty( $val ) ) {
										if ( 'kata_styler' === $value['type'] ) {
											switch ( $index ) {
												case 'desktop':
													if( $index == 'desktop' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['desktop'] . '{' . $val . '}';
													}
												case 'desktophover':
													if( $index == 'desktophover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['desktophover'] . '{' . $val . '}';
													}
												case 'desktopphover':
													if( $index == 'desktopphover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['desktopphover'] . '{' . $val . '}';
													}
												case 'desktopbefore':
													if( $index == 'desktopbefore' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['desktopbefore'] . '{' . $val . '}';
													}
												case 'desktopafter':
													if( $index == 'desktopafter' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['desktopafter'] . '{' . $val . '}';
													}
												break;

												case 'laptop':
													// Open Media Query
													$css .= '@media(min-width: 1025px) and (max-width: 1366px) {';
													if( $index == 'laptop' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['laptop'] . '{' . $val . '}';
													}
												case 'laptophover':
													if( $index == 'laptophover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['laptophover'] . '{' . $val . '}';
													}
												case 'laptopphover':
													if( $index == 'laptopphover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['laptopphover'] . '{' . $val . '}';
													}
												case 'laptopbefore':
													if( $index == 'laptopbefore' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['laptopbefore'] . '{' . $val . '}';
													}
												case 'laptopafter':
													if( $index == 'laptopafter' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['laptopafter'] . '{' . $val . '}';
													}
													$css .= '}';
													// close media query
												break;

												case 'tabletlandscape':
													$css .= '@media(min-width: 769px) and (max-width: 1024px) {';
													if( $index == 'tabletlandscape' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['tabletlandscape'] . '{' . $val . '}';
													}
												case 'tabletlandscapehover':
													if( $index == 'tabletlandscapehover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['tabletlandscapehover'] . '{' . $val . '}';
													}
												case 'tabletlandscapephover':
													if( $index == 'tabletlandscapephover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['tabletlandscapephover'] . '{' . $val . '}';
													}
												case 'tabletlandscapebefore':
													if( $index == 'tabletlandscapebefore' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['tabletlandscapebefore'] . '{' . $val . '}';
													}
												case 'tabletlandscapeafter':
													if( $index == 'tabletlandscapeafter' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['tabletlandscapeafter'] . '{' . $val . '}';
													}
												$css .= '}';
												break;

												case 'tablet':
													$css .= '@media(min-width: 481px) and (max-width: 768px) {';
													if( $index == 'tablet' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['tablet'] . '{' . $val . '}';
													}
												case 'tablethover':
													if( $index == 'tablethover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['tablethover'] . '{' . $val . '}';
													}
												case 'tabletphover':
													if( $index == 'tabletphover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['tabletphover'] . '{' . $val . '}';
													}
												case 'tabletbefore':
													if( $index == 'tabletbefore' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['tabletbefore'] . '{' . $val . '}';
													}
												case 'tabletafter':
													if( $index == 'tabletafter' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['tabletafter'] . '{' . $val . '}';
													}
													$css .= '}';
												break;

												case 'mobile':
													$css .= '@media(max-width: 480px) {';
													if( $index == 'mobile' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['mobile'] . '{' . $val . '}';
													}
												case 'mobilehover':
													if( $index == 'mobilehover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['mobilehover'] . '{' . $val . '}';
													}
												case 'mobilephover':
													if( $index == 'mobilephover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['mobilephover'] . '{' . $val . '}';
													}
												case 'mobilebefore':
													if( $index == 'mobilebefore' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['mobilebefore'] . '{' . $val . '}';
													}
												case 'mobileafter':
													if( $index == 'mobileafter' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['mobileafter'] . '{' . $val . '}';
													}
													$css .= '}';
												break;

												case 'smallmobile':
													$css .= '@media(max-width: 320px) {';
													if( $index == 'smallmobile' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['smallmobile'] . '{' . $val . '}';
													}
												case 'smallmobilehover':
													if( $index == 'smallmobilehover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['smallmobilehover'] . '{' . $val . '}';
													}
												case 'smallmobilephover':
													if( $index == 'smallmobilephover' && ! empty( $val ) ) {
														$css .= $value['args']['choices']['fields']['smallmobilephover'] . '{' . $val . '}';
													}
												case 'smallmobilebefore':
													if( $index == 'smallmobilebefore' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['smallmobilebefore'] . '{' . $val . '}';
													}
												case 'smallmobileafter':
													if( $index == 'smallmobileafter' && ! empty( $val ) ) {
														$val = str_replace( '\"', '"', $val );
														$val = str_replace( '\"', '"', $val );
														$css .= $value['args']['choices']['fields']['smallmobileafter'] . '{' . $val . '}';
													}
													$css .= '}';
												break;
											}
										}
									}
								}
							} */
						}
					}
				}
				$css = Kata_Styler::css_cleaner( $css );
				Kata_Plus_Helpers::wrfile( Kata_Plus::$upload_dir . '/css/customizer-styler.css', $css );
				add_action( 'wp_head', function() {
					$preview = '';
					$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
					$url      = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					if ( strpos( $url, 'customize' ) != false ) {
						foreach (Kirki::$fields as $name => $value) {
							if (strpos($name, 'styler_') !== false) {
								$preview .= get_theme_mod($name);
							}
						}
						$preview = Kata_Styler::css_cleaner( $preview );
						echo '<style id="styler-customizer-preview">' . $preview . '</style>';
					}
				}, 999 );
			}
		}

		/**
		 * Option Dynamic Styles.
		 *
		 * @since   1.0.0
		 */
		public function option_dynamic_styles() {
			$css = '';

			// Body Typography
			$body_typo_status		= get_theme_mod( 'kata_body_typography_status', 'disable' );
			$body_font_family		= get_theme_mod( 'kata_body_font_family', 'select-font' );
			$body_font_properties	= get_theme_mod( 'kata_body_font_properties', ['font-size' => '15px', 'font-weight' => '400', 'letter-spacing' => '0px', 'line-height' => '1.5'] );
			$body_font_color		= get_theme_mod( 'kata_body_font_color' );
			if ( 'enabel' == $body_typo_status ) {
				$css .= 'body{';
				$css .= $body_font_family ? 'font-family:' . $body_font_family . ';' :'';
				$css .= $body_font_properties['font-size'] ? 'font-size:' . $body_font_properties['font-size'] . ';' : '';
				$css .= $body_font_properties['font-weight'] ? 'font-weight:' . $body_font_properties['font-weight'] . ';' : '';
				$css .= $body_font_properties['letter-spacing'] ? 'letter-spacing:' . $body_font_properties['letter-spacing'] . ';' : '';
				$css .= $body_font_properties['line-height'] ? 'line-height:' . $body_font_properties['line-height'] . ';' : '';
				$css .= $body_font_color ? 'color:' . $body_font_color . ';' : '';
				$css .= '}';
			}

			// Heading Typography
			$headings_typo_status		= get_theme_mod( 'kata_headings_typography_status', 'disable' );
			$headings_font_family		= get_theme_mod( 'kata_headings_font_family', 'select-font' );
			$headings_font_properties	= get_theme_mod( 'kata_headings_font_properties', ['font-size' => '15px', 'font-weight' => '400', 'letter-spacing' => '0px', 'line-height' => '1.5'] );
			$headings_font_color		= get_theme_mod( 'kata_headings_font_color' );
			if ( 'enabel' == $headings_typo_status ) {
				$css .= 'h1,h2,h3,h4,h5,h6{';
				$css .= $headings_font_family ? 'font-family:' . $headings_font_family . ';' :'';
				$css .= $headings_font_properties['font-size'] ? 'font-size:' . $headings_font_properties['font-size'] . ';' : '';
				$css .= $headings_font_properties['font-weight'] ? 'font-weight:' . $headings_font_properties['font-weight'] . ';' : '';
				$css .= $headings_font_properties['letter-spacing'] ? 'letter-spacing:' . $headings_font_properties['letter-spacing'] . ';' : '';
				$css .= $headings_font_properties['line-height'] ? 'line-height:' . $headings_font_properties['line-height'] . ';' : '';
				$css .= $headings_font_color ? 'color:' . $headings_font_color . ';' : '';
				$css .= '}';
			}

			// Menu Navigation Typography
			$nav_menu_typo_status		= get_theme_mod( 'kata_nav_menu_typography_status', 'disable' );
			$nav_menu_font_family		= get_theme_mod( 'kata_nav_menu_font_family', 'select-font' );
			$nav_menu_font_properties	= get_theme_mod( 'kata_nav_menu_font_properties', ['font-size' => '15px', 'font-weight' => '400', 'letter-spacing' => '0px', 'line-height' => '1.5'] );
			$nav_menu_font_color		= get_theme_mod( 'kata_nav_menu_font_color' );
			if ( 'enabel' == $nav_menu_typo_status ) {
				$css .= '.kata-menu-navigation li a{';
				$css .= $nav_menu_font_family ? 'font-family:' . $nav_menu_font_family . ';' :'';
				$css .= $nav_menu_font_properties['font-size'] ? 'font-size:' . $nav_menu_font_properties['font-size'] . ';' : '';
				$css .= $nav_menu_font_properties['font-weight'] ? 'font-weight:' . $nav_menu_font_properties['font-weight'] . ';' : '';
				$css .= $nav_menu_font_properties['letter-spacing'] ? 'letter-spacing:' . $nav_menu_font_properties['letter-spacing'] . ';' : '';
				$css .= $nav_menu_font_properties['line-height'] ? 'line-height:' . $nav_menu_font_properties['line-height'] . ';' : '';
				$css .= $nav_menu_font_color ? 'color:' . $nav_menu_font_color . ';' : '';
				$css .= '}';
			}

			// Container Size
			$kata_grid_size_desktop         = get_theme_mod( 'kata_grid_size_desktop', '1280' );
			$kata_grid_size_laptop          = get_theme_mod( 'kata_grid_size_laptop', '1024' );
			$kata_grid_size_tabletlandscape = get_theme_mod( 'kata_grid_size_tabletlandscape', '96' );
			$kata_grid_size_tablet          = get_theme_mod( 'kata_grid_size_tablet', '96' );
			$kata_grid_size_mobile          = get_theme_mod( 'kata_grid_size_mobile', '96' );
			$kata_grid_size_small_mobile    = get_theme_mod( 'kata_grid_size_small_mobile', '96' );
			$wide_container = get_theme_mod( 'kata_wide_container', '0' );


			if ( $kata_grid_size_desktop ) {
				$css .= '.container, .elementor-section.elementor-section-boxed>.elementor-container{max-width: ' . $kata_grid_size_desktop . 'px;}';
				$css .= '@media(max-width:' . $kata_grid_size_desktop . 'px){.container, .elementor-section.elementor-section-boxed>.elementor-container{padding: 0 15px;}.container .container,.elementor-section.elementor-section-boxed>.elementor-container .elementor-container{padding:0;}}';
			}
			// Layout
			if ( $wide_container ) {
				$css .= ' @media ( min-width: 1367px ) { .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: 96%; } }';
			}
			if ( $kata_grid_size_laptop ) {
				$css .= '@media(max-width:1366px){ .container, .elementor-section.elementor-section-boxed>.elementor-container{ max-width: ' . $kata_grid_size_laptop . 'px;} }';
			}
			if ( $kata_grid_size_tabletlandscape ) {
				$css .= '@media(max-width:1024px){ .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_tabletlandscape . '% !important;} }';
			}
			if ( $kata_grid_size_tablet ) {
				$css .= '@media(max-width:768px){ .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_tablet . '% !important; margin-left:auto; margin-right:auto;} }';
			}
			if ( $kata_grid_size_mobile ) {
				$css .= '@media(max-width:480px){ .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_mobile . '% !important; margin-left:auto; margin-right:auto;} }';
			}
			if ( $kata_grid_size_small_mobile ) {
				$css .= '@media(max-width:320px){ .container, .elementor-section.elementor-section-boxed>.elementor-container { max-width: ' . $kata_grid_size_small_mobile . '% !important; margin-left:auto; margin-right:auto;} }';
			}
			$css .= '.elementor-section.elementor-section-boxed>.elementor-container .elementor-container, .elementor-section.elementor-section-boxed>.elementor-container .container { max-width: 100% !important; }';
			$css .= '.single .kata-content .container .elementor-container { max-width: 100%; }';

			// Color Skin
			$colorbase = get_theme_mod( 'kata_base_color', '' );
			if ( $colorbase ) {
				$css .= '
				.kata-color-base .kata-menu-navigation>li.menu-item.current-menu-ancestor>a,
				.kata-color-base .kata-menu-navigation ul:not(.mega-menu-content)>li.menu-item.current-menu-parent>a,
				.kata-color-base .kata-menu-navigation ul:not(.mega-menu-content) li.menu-item.current-menu-parent ul>li.current-menu-item a,
				.kata-color-base .kata-language-switcher li a, .kata-color-base .kata-hamburger-menu-navigation>li.current-menu-item>a,
				.kata-color-base .kata-owl.dots-num .owl-dot.active, .kata-color-base .df-color, .kata-color-base .df-color-h:hover, .kata-color-base .kata-menu-navigation li.current-menu-item>a { color: ' . $colorbase . '; }
				.df-fill, .df-fill-h:hover { fill: ' . $colorbase . '; }
				.kata-color-base .kata-arc-scale .kata-loader .kata-arc::before,
				.kata-color-base .kata-arc-scale .kata-loader .kata-arc::after,
				.kata-color-base .kata-owl .owl-dots .owl-dot.active,
				.dbg-color, .dbg-color-h:hover { background-color: ' . $colorbase . '; }
				.dbo-color, .dbo-color-h:hover { border-color: ' . $colorbase . '; } ';
			} else {
				$css .= '
				.df-color, .df-color-h:hover { color: #403cf2; }
				.df-fill, .df-fill-h:hover { fill: #403cf2; }
				.dbg-color, .dbg-color-h:hover { background-color: #403cf2; }
				.dbo-color, .dbo-color-h:hover { border-color: #403cf2; }';
			}

			$css = apply_filters( 'option_dynamic_styles', $css );

			$uploaddir = wp_get_upload_dir();
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			$wp_filesystem->put_contents(
				$uploaddir['basedir'] . '/kata/css/dynamic-styles.css',
				Kata_Plus_Helpers::cssminifier( $css ),
				FS_CHMOD_FILE
			);
		}

		/**
		 * Start Section Slider Page.
		 *
		 * @since   1.0.0
		 */
		public function header_transparent() {
			$header_transparent		 = get_theme_mod( 'kata_make_header_transparent', 'default' );
			$header_transparent_dark = get_theme_mod( 'kata_header_transparent_white_color', 'default' );
			switch ( $header_transparent ) {
				case 'posts':
					$posts = get_posts('post_type=post&numberposts=-1&post_status=any');
					foreach ( $posts as $post ) {
						if ( 'default' == get_post_meta( $post->ID, 'kata_make_header_transparent', true ) ) {
							update_post_meta( $post->ID, 'kata_make_header_transparent', '1' );
						}
					}
				break;
				case 'pages':
					$pages = get_posts('post_type=page&numberposts=-1&post_status=any');
					foreach ( $pages as $page ) {
						if ( 'default' == get_post_meta( $page->ID, 'kata_make_header_transparent', true ) ) {
							update_post_meta( $page->ID, 'kata_make_header_transparent', '1' );
						}
					}
				break;
				case 'both':
					$posts = get_posts('post_type=post&numberposts=-1&post_status=any');
					foreach ( $posts as $post ) {
						if ( 'default' == get_post_meta( $post->ID, 'kata_make_header_transparent', true ) ) {
							update_post_meta( $post->ID, 'kata_make_header_transparent', '1' );
						}
					}
					$pages = get_posts('post_type=page&numberposts=-1&post_status=any');
					foreach ( $pages as $page ) {
						if ( 'default' == get_post_meta( $page->ID, 'kata_make_header_transparent', true ) ) {
							update_post_meta( $page->ID, 'kata_make_header_transparent', '1' );
						}
					}
				break;
				case 'default':
					$posts = get_posts('post_type=post&numberposts=-1&post_status=any');
					foreach ( $posts as $post ) {
						if ( 'default' !== get_post_meta( $post->ID, 'kata_make_header_transparent', true ) ) {
							update_post_meta( $post->ID, 'kata_make_header_transparent', 'default' );
						}
					}
					$pages = get_posts('post_type=page&numberposts=-1&post_status=any');
					foreach ( $pages as $page ) {
						if ( 'default' !== get_post_meta( $page->ID, 'kata_make_header_transparent', true ) ) {
							update_post_meta( $page->ID, 'kata_make_header_transparent', 'default' );
						}
					}
				break;
			}
			switch ( $header_transparent_dark ) {
				case 'posts':
					$posts = get_posts('post_type=post&numberposts=-1&post_status=any');
					foreach ( $posts as $post ) {
						if ( 'default' == get_post_meta( $post->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $post->ID, 'kata_header_transparent_white_color', '1' );
						}
					}
					$pages = get_posts('post_type=page&numberposts=-1&post_status=any');
					foreach ( $pages as $page ) {
						if ( 'default' == get_post_meta( $page->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $page->ID, 'kata_header_transparent_white_color', '0' );
						}
					}
				break;
				case 'pages':
					$pages = get_posts('post_type=page&numberposts=-1&post_status=any');
					foreach ( $pages as $page ) {
						if ( 'default' == get_post_meta( $page->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $page->ID, 'kata_header_transparent_white_color', '1' );
						}
					}
					$posts = get_posts('post_type=post&numberposts=-1&post_status=any');
					foreach ( $posts as $post ) {
						if ( 'default' == get_post_meta( $post->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $post->ID, 'kata_header_transparent_white_color', '0' );
						}
					}
				break;
				case 'both':
					$posts = get_posts('post_type=post&numberposts=-1&post_status=any');
					foreach ( $posts as $post ) {
						if ( 'default' == get_post_meta( $post->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $post->ID, 'kata_header_transparent_white_color', '1' );
						}
					}
					$pages = get_posts('post_type=page&numberposts=-1&post_status=any');
					foreach ( $pages as $page ) {
						if ( 'default' == get_post_meta( $page->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $page->ID, 'kata_header_transparent_white_color', '1' );
						}
					}
				break;
				case 'default':
					$posts = get_posts('post_type=post&numberposts=-1&post_status=any');
					foreach ( $posts as $post ) {
						if ( 'default' !== get_post_meta( $post->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $post->ID, 'kata_header_transparent_white_color', 'default' );
						}
					}
					$pages = get_posts('post_type=page&numberposts=-1&post_status=any');
					foreach ( $pages as $page ) {
						if ( 'default' !== get_post_meta( $page->ID, 'kata_header_transparent_white_color', true ) ) {
							update_post_meta( $page->ID, 'kata_header_transparent_white_color', 'default' );
						}
					}
				break;
			}
		}

		/**
		 * Start Section Slider Page.
		 *
		 * @since   1.0.0
		 */
		public function start_full_page_slider() {
			if ( Kata_Helpers::get_meta_box('full_page_slider') == '1') {
				echo '<div id="kata-full-page-slider" class="kata-full-page-slider"
						data-navigation ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_navigation')) . '"
						data-navigation-position ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_navigation_position')) . '"
						data-loop-bottom ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_loop_bottom')) . '"
						data-loop-top ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_loop_top')) . '"
						data-scrolling-speed ="' . esc_attr(Kata_Helpers::get_meta_box('full_page_slider_scrolling_speed')['size']) . '"
					>';
			}
		}

		/**
		 * End Section Slider Page.
		 *
		 * @since   1.0.0
		 */
		public function end_full_page_slider()
		{
			if (Kata_Helpers::get_meta_box('edge_one_pager') == '1') {
				echo '</div>';
			}
		}

		/**
		 * Left Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function left_sidebar()
		{
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			if ($sidebar_position != 'none') {
				echo '<div class="row">';
			}

			// Left sidebar
			if ($sidebar_position == 'left' || $sidebar_position == 'both') {
				echo '<div class="col-md-3 kata-sidebar kata-left-sidebar">';
				if (is_active_sidebar('kata-left-sidebar')) {
					dynamic_sidebar('kata-left-sidebar');
				}
				echo '</div>';
			}
		}

		/**
		 * Start Page with Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function start_page_with_sidebar()
		{
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			if ($sidebar_position == 'both') {
				echo '<div class="col-md-6 kata-page-content">';
			} elseif ($sidebar_position == 'right' || $sidebar_position == 'left') {
				echo '<div class="col-md-9 kata-page-content">';
			}
		}

		/**
		 * End Page with Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function end_page_with_sidebar()
		{
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			if ($sidebar_position != 'none') {
				echo '</div>';
			}
		}

		/**
		 * Right Sidebar.
		 *
		 * @since   1.0.0
		 */
		public function right_sidebar()
		{
			$sidebar_position_meta = Kata_Helpers::get_meta_box('sidebar_position');
			$sidebar_position      = $sidebar_position_meta != 'inherit_from_customizer' && !empty($sidebar_position_meta) ? $sidebar_position_meta : get_theme_mod('kata_page_sidebar_position', 'none');

			// Right sidebar
			if ($sidebar_position == 'right' || $sidebar_position == 'both') {
				echo '<div class="col-md-3 kata-sidebar kata-right-sidebar">';
				if (is_active_sidebar('kata-right-sidebar')) {
					dynamic_sidebar('kata-right-sidebar');
				}
				echo '</div>';
			}

			if ($sidebar_position != 'none') {
				echo '</div>';
			}
		}

		/**
		 * Page Title.
		 *
		 * @since   1.0.0
		 */
		public function page_title() {
			$page_title_meta      = Kata_Helpers::get_meta_box( 'kata_show_page_title' );
			$page_title_text_meta = Kata_Helpers::get_meta_box( 'kata_page_title_text' );
			$page_title           = $page_title_meta != 'inherit_from_customizer' ? $page_title_meta : get_theme_mod( 'kata_show_page_title', '1' );
			$page_title_class     = 1 == $page_title || '1' === $page_title ? 'on' : 'off';
			$page_title_text      = $page_title_text_meta ? $page_title_text_meta : get_the_title();

			if ( 'on' === $page_title_class ) {
				echo '
				<div id="kata-page-title" class="kata-page-title">
					<div class="container">
						<div class="col-sm-12">
							<h1>' . wp_kses_post( $page_title_text ) . '</h1>
						</div>
					</div>
				</div>';
			}
		}

		/**
		 * Responsive.
		 *
		 * @since   1.0.0
		 */
		public function option_responsive() {
			$kata_grid_size_desktop	= get_theme_mod( 'kata_grid_size_desktop', '1280' );
			if (get_theme_mod('kata_responsive', '1') == '1') {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
			} else {
				echo '<meta name="viewport" content="width=' . esc_attr( $kata_grid_size_desktop ) . ',user-scalable=yes">';
			}
		}

		/**
		 * Backup Customizer.
		 *
		 * @since   1.0.0
		 */
		public function backup_customizer() {
			if ( strlen(json_encode(get_option( 'theme_mods_kata' ))) < 86 ) {
				return;
			}
			if ( ! get_option( 'customizer_backup' ) ) {
				add_option( 'customizer_backup', get_option( 'theme_mods_kata' ) );
				add_option( 'customizer_backup_date', date( 'Ymd' ) );
			}
			if ( get_option( 'customizer_backup_date' ) <= date( 'Ymd' ) && '-' !== get_option( 'theme_mods_kata' ) ) {
				update_option( 'customizer_backup', get_option( 'theme_mods_kata' ) );
				update_option( 'customizer_backup_date', date( 'Ymd' ) );
			}
		}

		/**
		 * Restore Backup Customizer.
		 *
		 * @since   1.0.0
		 */
		public function restore_backup_customizer() {
			if ( get_option( 'customizer_backup' ) && get_option( 'customizer_backup_date' ) ) {
				if ( '-' == get_option( 'theme_mods_kata' ) ) {
					$user			= wp_get_current_user();
					$allowed_roles	= ['editor', 'administrator', 'author'];
					if ( array_intersect( $allowed_roles, $user->roles ) ) {
						echo '<div class="kata-plus-customizer-problem" style="background:#ffb0b0;padding:10px 10px 7px;"><h3 style="line-height:1.2;font-size:21px;font-weight:normal;color:#ad0000;">' . __( 'There is a problem with customizer (theme options) data\'s please refresh the page to resolve the problem', 'kata-plus' ) . '</h3></div>';
					}
					update_option( 'theme_mods_kata', get_option( 'customizer_backup' ) );
				}
			}
		}

	} // Class

	Kata_Plus_Theme_Options_Functions::get_instance();
}
