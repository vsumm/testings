<?php

/**
 * Elementor Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Plugin;
use Elementor\Stylesheet;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Dynamic_CSS;
use Elementor\Utils as ElementorUtils;
use Elementor\Settings;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Css_Filter;

if ( ! class_exists( 'Kata_Plus_Elementor' ) ) {
	class Kata_Plus_Elementor {

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
		 * @var     Kata_Plus_Elementor
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

		/**
		 * Constructor.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return;
			}
			$this->definitions();
			$this->actions();
			$this->dependencies();
			$this->config();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir = Kata_Plus::$dir . 'includes/elementor/';
			self::$url = Kata_Plus::$url . 'includes/elementor/';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'elementor/init', [$this, 'elementorinit'], 0 );
			// add_action( 'elementor/init', [ $this, 'sync_container' ], 0 );
			// add_action( 'elementor/init', [ $this, 'elementor_space_between_widgets' ], 0 );
			add_action( 'elementor/editor/after_enqueue_styles', [$this, 'editor_styles'], 9999999 );
			add_action( 'admin_enqueue_scripts', [$this, 'editor_styles'], 9999999 );
			add_action( 'elementor/frontend/after_register_scripts', [$this, 'elementor_frontend_scripts'], 999 );

			add_action( 'elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts'] );
			add_action( 'elementor/preview/enqueue_styles', [$this, 'preview_styles'] );
			add_action( 'elementor/element/parse_css', [$this, 'module_custom_css_frontend'], 10, 2 );
			add_action( 'elementor/controls/controls_registered', [$this, 'controls'] );
			add_action( 'elementor/element/column/layout/before_section_end', [$this, 'column_layout_options'], 10, 3 );
			add_action( 'elementor/element/after_section_start', [$this, 'elementor_section'], 10, 3 );
			add_action( 'elementor/element/column/section_typo/after_section_end', [$this, 'column_style_options'], 10, 3 );
			add_action( 'elementor/element/section/section_typo/after_section_end', [$this, 'section_style_options'], 10, 3 );
			// add_action( 'elementor/css-file/post/parse', [$this, 'add_responsive_devices'], -10, 1 );
			// add_action( 'elementor/css-file/post/enqueue', [$this, 'add_responsive_devices'], -10, 1 );
			// add_action( 'wp_enqueue_scripts', [$this, 'add_elementor_stylesheet_devices'], -100, 1 );
			add_action( 'elementor/element/wp-page/document_settings/before_section_start', [$this, 'kata_page_options'], 10, 2 );
			add_action( 'elementor/element/wp-post/document_settings/before_section_start', [$this, 'kata_post_options'], 10, 2 );
			add_filter( 'kata_plus_common_controls', [$this, 'common_controls'], 10, 1 );
			if ( isset( $_GET['action'] ) && 'elementor' !== sanitize_text_field( $_GET['action'] ) ) {
				add_action( 'save_post', [$this, 'sync_post_options'], 10, 3 );
			}

			/**
			 * Fix Breakpointes
			 */
			add_action( 'elementor/init', function() {
				if ( ELEMENTOR_VERSION !== get_option( 'kata_elfile_replaced_in' ) ) {
					$stylesheet_path	= WP_PLUGIN_DIR .'/elementor/includes/stylesheet.php';
					$stylesheet			= self::$dir . 'devices/stylesheet.php';
					$file				= file_get_contents($stylesheet);
					if ( $file ) {
						if ( file_put_contents( $stylesheet_path, $file ) ) {
							update_option( 'kata_elfile_replaced_in', ELEMENTOR_VERSION );
						} else {
							update_option( 'kata_elfile_replaced_in', 'none' );
						}
					}

					$manager_path	= WP_PLUGIN_DIR .'/elementor/core/breakpoints/manager.php';
					$manager		= self::$dir . 'devices/manager.php';
					$file			= file_get_contents($manager);
					if ( $file ) {
						if( file_put_contents( $manager_path, $file ) ) {
							update_option( 'kata_elfile_replaced_in', ELEMENTOR_VERSION );
						} else {
							update_option( 'kata_elfile_replaced_in', 'none' );
						}
					}
					$manager	= new \Elementor\Core\Files\Manager;
					$manager->clear_cache();
				}
			});

			/**
			 * Elementor Default Columns Gap
			 */
			add_action( 'elementor/element/section/section_layout/before_section_end', function( $element ) {
				$element->remove_control('gap');
				$element->remove_control('gap_columns_custom');
				$element->remove_control('gap_columns_custom_tablet');
				$element->remove_control('gap_columns_custom_mobile');
			}, 10, 1 );
			add_action( 'elementor/element/section/section_layout/before_section_end', function( $element ) {
				$element->start_injection(
					[
						'of' => 'height',
						'at' => 'before',
					]
				);
				$element->add_control(
					'gap',
					[
						'label' => __( 'Columns Gap', 'kata-plus' ),
						'type' => Controls_Manager::SELECT,
						'default' => get_theme_mod( 'kata_elementor_default_columns_gap', 'default' ),
						'options' => [
							'default'	=> __( 'Default', 'kata-plus' ),
							'no'		=> __( 'No Gap', 'kata-plus' ),
							'narrow'	=> __( 'Narrow', 'kata-plus' ),
							'extended'	=> __( 'Extended', 'kata-plus' ),
							'wide'		=> __( 'Wide', 'kata-plus' ),
							'wider'		=> __( 'Wider', 'kata-plus' ),
							'custom'	=> __( 'Custom', 'kata-plus' ),
						],
					]
				);
				$element->add_responsive_control(
					'gap_columns_custom',
					[
						'label' => __( 'Custom Columns Gap', 'elementor' ),
						'type' => Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 500,
							],
							'%' => [
								'min' => 0,
								'max' => 100,
							],
							'vh' => [
								'min' => 0,
								'max' => 100,
							],
							'vw' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'size_units' => [ 'px', '%', 'vh', 'vw' ],
						'selectors' => [
							'{{WRAPPER}} .elementor-column-gap-custom .elementor-column > .elementor-element-populated' => 'padding: {{SIZE}}{{UNIT}};',
						],
						'condition' => [
							'gap' => 'custom',
						],
					]
				);
				$element->end_injection();
			}, 99, 1 );


			add_action(
				'elementor/element/parse_css',
				function () {
					$debug = debug_backtrace();
					foreach ( $debug as $key ) {
						if ( isset( $key['class'] ) && isset( $key['function'] ) && $key['class'] == 'Elementor\Core\Files\Base' && $key['function'] == 'update_file' ) {
							$post_id = $key['object']->get_post_id();

							if ( get_option( 'last-post-styles-update-' . $post_id, time() - 6 ) < time() - 5 ) {
								update_option( 'last-post-styles-update-' . $post_id, time() );
								$filename = $key['object']->get_base_uploads_dir() . '/css/' . $key['object']->get_file_name();
								add_action(
									'wp_footer',
									function () use ( $filename ) {
										if ( ! file_exists( $filename ) ) {
											return;
										}

										$breakpoints = static::get_breakpoints();
										$content = file_get_contents( $filename );
										// Erise unnecessary css
										$content = Kata_Styler::unnecessary_css_erise( $content );
										// $landscape_min_width = $breakpoints['tablet'] + 1;
										// $tablet_max_width = $breakpoints['tablet'] - 1;
										// $mobile_max_width = $breakpoints['mobile'] - 1;
										// $small_mobile_max_width = $breakpoints['mobile'] - 1;
										$content = str_replace( '@media(min-width:481px)', '@media(min-width:1025px)', $content );
										// $content = str_replace( '@media(max-width:' . $breakpoints['tabletlandscape'] . 'px) and (min-width:' . ( $breakpoints['mobile'] ) . 'px){', '@media(max-width: ' . $breakpoints['tablet'] . 'px){', $content );
										// laptop
										// $content = str_replace( '@media(max-width:' . $breakpoints['desktop'] . 'px){', '@media(min-width:' . $breakpoints['tabletlandscape'] . 'px) and (max-width: ' . $breakpoints['laptop'] . 'px){', $content );
										// tablet Landscape
										// $content = str_replace( '@media(max-width:' . $breakpoints['laptop'] . 'px){', '@media(min-width:' . $breakpoints['tablet'] . 'px) and (max-width: ' . ($breakpoints['tabletlandscape'] - 1) . 'px){', $content );
										// Tablet
										// $content = str_replace( '@media(max-width:' . $breakpoints['tabletlandscape'] . 'px){', '@media(max-width: ' . $tablet_max_width . 'px){', $content );
										// $content = str_replace( '@media(max-width:' . ( $breakpoints['tabletlandscape'] - 1 ) . 'px){', '@media(max-width: ' . $tablet_max_width . 'px){', $content );
										// Mobile
										// $content = str_replace( '@media(max-width:' . $tablet_max_width . 'px){', '@media(max-width: ' . $mobile_max_width . 'px){', $content );
										// Small Mobile
										// $content = str_replace( '@media(max-width:' . $small_mobile_max_width . 'px){', '@media(max-width: ' . $breakpoints['smallmobile'] . 'px){', $content );
										// Responsive Fix
										// $content = str_replace( '@media(max-width:' . ( $breakpoints['tabletlandscape'] - 1 ) . 'px) and (min-width:' . ( $breakpoints['tablet'] ) . 'px){', '@media(max-width: ' . $breakpoints['tablet'] . 'px){', $content );
										// $content = str_replace( '@media(max-width:' . $breakpoints['tabletlandscape'] . 'px) and (min-width:' . ( $breakpoints['tablet'] ) . 'px){', '@media(max-width: ' . $breakpoints['tablet'] . 'px){', $content );

										file_put_contents( $filename, $content );
									},
									-100
								 );
								return;
							} else {
								return;
							}
						}
					}
				},
				10,
				2
			);
		}

		public function elementor_frontend_scripts() {
			wp_register_script( 'kata-jquery-enllax', Kata_Plus::$assets . 'js/frontend/parallax-motion.js', ['jquery'], Kata_Plus::$version, true );
			wp_enqueue_script( 'kata-plus-theme-scripts', Kata_Plus::$assets . 'js/frontend/theme-scripts.js', ['jquery'], Kata_Plus::$version, true );
		}

		/**
		 * Sync post options.
		 *
		 * @since   1.0.0
		 */
		public function sync_post_options( $post_id, $post, $update ) {
			$elementor_page_settings = get_post_meta( $post_id, '_elementor_page_settings', true );

			if ( $elementor_page_settings ) {
				$elementor_page_settings['kata_show_header'] = get_post_meta( $post_id, 'kata_show_header', true );
				$elementor_page_settings['kata_make_header_transparent'] = get_post_meta( $post_id, 'kata_make_header_transparent', true );
				$elementor_page_settings['kata_header_transparent_white_color'] = get_post_meta( $post_id, 'kata_header_transparent_white_color', true );
				$elementor_page_settings['post_time_to_read'] = get_post_meta( $post_id, 'post_time_to_read', true );
				$elementor_page_settings['kata_post_video'] = get_post_meta( $post_id, 'kata_post_video', true );
				update_post_meta( $post_id, '_elementor_page_settings', $elementor_page_settings );
			}
		}

		/**
		 * Post Options.
		 *
		 * @since   1.0.0
		 */
		public function kata_post_options( $page ) {
			if ( isset( $page ) && $page->get_id() > '' ) {
				$page_options_post_type = false;
				$page_options_post_type = get_post_type( $page->get_id() );
				if ( $page_options_post_type == 'post' ) {
					/**
					 * Header options
					 */
					$page->start_controls_section(
						'kata_page_options_header',
						[
							'label' => esc_html__( 'Header Options', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
						);
					$page->add_control(
						'kata_show_header',
						[
							'label'        => __( 'Show Header:', 'kata-plus' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => __( 'Show', 'kata-plus' ),
							'label_off'    => __( 'Hide', 'kata-plus' ),
							'return_value' => '1',
							'default'      => get_post_meta( get_the_ID(), 'kata_show_header', true ) ? get_post_meta( get_the_ID(), 'kata_show_header', true ) : '1',
						]
					);
					$page->add_control(
						'kata_make_header_transparent',
						[
							'label'			=> __( 'Header Transparent', 'kata-plus' ),
							'type'			=> Controls_Manager::SELECT,
							'default'		=> get_post_meta( get_the_ID(), 'kata_make_header_transparent', true ) ? get_post_meta( get_the_ID(), 'kata_make_header_transparent', true ) : 'default',
							'options'		=> [
								'default'	=> __( 'Default', 'kata-plus' ),
								'0'			=> __( 'Disable', 'kata-plus' ),
								'1'			=> __( 'Enable', 'kata-plus' ),
							],
						]
					);
					$page->add_control(
						'kata_header_transparent_white_color',
						[
							'label'        => __( 'Dark Header Transparent', 'kata-plus' ),
							'type'         => Controls_Manager::SELECT,
							'default'      => get_post_meta( get_the_ID(), 'kata_header_transparent_white_color', true ) ? get_post_meta( get_the_ID(), 'kata_header_transparent_white_color', true ) : 'default',
							'options'		=> [
								'default'	=> __( 'Default', 'kata-plus' ),
								'0'			=> __( 'Disable', 'kata-plus' ),
								'1'			=> __( 'Enable', 'kata-plus' ),
							],
							'condition'    => [
								'kata_make_header_transparent' => '1',
							],
						]
					);
					$page->end_controls_section();
					/**
					 * Post Options
					 */
					$page->start_controls_section(
						'kata_post_options',
						[
							'label' => esc_html__( 'Post Options', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
					);
					$page->add_control(
						'post_time_to_read',
						[
							'label'     => __( 'Post\'s time to read:', 'kata-plus' ),
							'type'      => Controls_Manager::TEXT,
							'default'	=> get_post_meta( get_the_ID(), 'post_time_to_read', true ),
						]
					);
					$page->add_control(
						'kata_post_video',
						[
							'label'			=> __( 'Video URL:', 'kata-plus' ),
							'description'	=> __( 'Youtube, Vimeo or Hosted video, Works when post format is video.', 'kata-plus' ),
							'type'			=> Controls_Manager::TEXT,
							'default'		=> get_post_meta( get_the_ID(), 'kata_post_video', true ),
						]
					);
					$page->end_controls_section();
					$settings										 = $page->get_settings();
					$settings['post_time_to_read']					 = $settings['post_time_to_read'] ? $settings['post_time_to_read'] : '';
					$settings['kata_post_video']					 = $settings['kata_post_video'] ? $settings['kata_post_video'] : '';
					$settings['kata_show_header']                    = isset( $settings['kata_show_header'] ) && '1' == $settings['kata_show_header'] ? $settings['kata_show_header'] : '1';
					$settings['kata_make_header_transparent']        = isset( $settings['kata_make_header_transparent'] ) ? $settings['kata_make_header_transparent'] : '0';
					$settings['kata_header_transparent_white_color'] = isset( $settings['kata_header_transparent_white_color'] ) ? $settings['kata_header_transparent_white_color'] : '0';
					update_post_meta( get_the_ID(), 'kata_show_header', $settings['kata_show_header'] );
					update_post_meta( get_the_ID(), 'kata_make_header_transparent', $settings['kata_make_header_transparent'] );
					update_post_meta( get_the_ID(), 'kata_header_transparent_white_color', $settings['kata_header_transparent_white_color'] );
					update_post_meta( get_the_ID(), 'post_time_to_read', $settings['post_time_to_read'] );
					update_post_meta( get_the_ID(), 'kata_post_video', $settings['kata_post_video'] );
				}
			}
		}

		/**
		 * Page Options.
		 *
		 * @since   1.0.0
		 */
		public function kata_page_options( $page ) {
			if ( isset( $page ) && $page->get_id() > '' ) {
				$page_options_post_type = false;
				$page_options_post_type = get_post_type( $page->get_id() );
				if ( $page_options_post_type == 'page' ) {
					$page->start_controls_section(
						'kata_page_options_header',
						[
							'label' => esc_html__( 'Header Options', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
					);
					$page->add_control(
						'kata_show_header',
						[
							'label'        => __( 'Show Header:', 'kata-plus' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => __( 'Show', 'kata-plus' ),
							'label_off'    => __( 'Hide', 'kata-plus' ),
							'return_value' => '1',
							'default'      => get_post_meta( get_the_ID(), 'kata_show_header', true ) ? get_post_meta( get_the_ID(), 'kata_show_header', true ) : '1',
						]
					);
					$page->add_control(
						'kata_make_header_transparent',
						[
							'label'			=> __( 'Header Transparent', 'kata-plus' ),
							'type'			=> Controls_Manager::SELECT,
							'default'		=> get_post_meta( get_the_ID(), 'kata_make_header_transparent', true ) ? get_post_meta( get_the_ID(), 'kata_make_header_transparent', true ) : 'default',
							'options'		=> [
								'default'	=> __( 'Default', 'kata-plus' ),
								'0'			=> __( 'Disable', 'kata-plus' ),
								'1'			=> __( 'Enable', 'kata-plus' ),
							],
						]
					);
					$page->add_control(
						'kata_header_transparent_white_color',
						[
							'label'        => __( 'Dark Header Transparent', 'kata-plus' ),
							'type'         => Controls_Manager::SELECT,
							'default'      => get_post_meta( get_the_ID(), 'kata_header_transparent_white_color', true ) ? get_post_meta( get_the_ID(), 'kata_header_transparent_white_color', true ) : 'default',
							'options'		=> [
								'default'	=> __( 'Default', 'kata-plus' ),
								'0'			=> __( 'Disable', 'kata-plus' ),
								'1'			=> __( 'Enable', 'kata-plus' ),
							],
							'condition'    => [
								'kata_make_header_transparent' => '1',
							],
						]
					);
					$page->add_control(
						'applychanges1',
						[
							'label'			=> __('Apply', 'kata-plus'),
							'type'			=> Controls_Manager::BUTTON,
							'separator'		=> 'before',
							'button_type'	=> 'success',
							'text'			=> __('Apply', 'kata-plus'),
							'description'	=> __('Click the Apply button to save your changes.', 'kata-plus'),
							'event'			=> 'applychanges',
						]
					);
					$page->end_controls_section();

					$page->start_controls_section(
						'kata_page_options_title',
						[
							'label' => esc_html__( 'Page Title', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
					);
					$page->add_control(
						'kata_show_page_title',
						[
							'label'		=> __( 'Page Title:', 'kata-plus' ),
							'type'		=> Controls_Manager::CHOOSE,
							'toggle'	=> false,
							'options' => [
								'inherit_from_customizer' => [
									'title' => __( 'Inherit', 'kata-plus' ),
									'icon'  => 'fas fa-fingerprint',
								],
								'1'                       => [
									'title' => __( 'Show', 'kata-plus' ),
									'icon'  => 'far fa-eye',
								],
								'0'                       => [
									'title' => __( 'Hide', 'kata-plus' ),
									'icon'  => 'far fa-eye-slash',
								],
							],
							'default' => 'inherit_from_customizer',
						]
					);
					$page->add_control(
						'kata_page_title_text',
						[
							'label'       => __( 'Custom Page Title:', 'kata-plus' ),
							'type'        => Controls_Manager::TEXT,
							'placeholder' => __( 'Type your title here', 'kata-plus' ),
						]
					);
					$page->add_control(
						'kata_styler_page_title_wrapper',
						[
							'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
							'type'      => 'kata_styler',
							'selectors' => Kata_Styler::selectors( '#kata-page-title' ),
						]
					);
					$page->add_control(
						'kata_styler_page_title',
						[
							'label'     => esc_html__( 'Title', 'kata-plus' ),
							'type'      => 'kata_styler',
							'selectors' => Kata_Styler::selectors( '#kata-page-title h1' ),
						]
					);
					$page->add_control(
						'applychanges2',
						[
							'label'			=> __('Apply', 'kata-plus'),
							'type'			=> Controls_Manager::BUTTON,
							'separator'		=> 'before',
							'button_type'	=> 'success',
							'text'			=> __('Apply', 'kata-plus'),
							'description'	=> __('Click the Apply button to save your changes.', 'kata-plus'),
							'event'			=> 'applychanges',
						]
					);
					$page->end_controls_section();

					$page->start_controls_section(
						'kata_page_options_sidebar',
						[
							'label' => esc_html__( 'Sidebar', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
					);
					$page->add_control(
						'sidebar_position',
						[
							'label'   => __( 'Position:', 'kata-plus' ),
							'type'    => Controls_Manager::CHOOSE,
							'toggle' => false,
							'options' => [
								'inherit_from_customizer' => [
									'title' => __( 'Inherit', 'kata-plus' ),
									'icon'  => 'fas fa-fingerprint',
								],
								'none'                    => [
									'title' => __( 'None', 'kata-plus' ),
									'icon'  => 'ti-layout-sidebar-none',
								],
								'right'                   => [
									'title' => __( 'Right', 'kata-plus' ),
									'icon'  => 'ti-layout-sidebar-right',
								],
								'left'                    => [
									'title' => __( 'Left', 'kata-plus' ),
									'icon'  => 'ti-layout-sidebar-left',
								],
								'both'                    => [
									'title' => __( 'Both', 'kata-plus' ),
									'icon'  => 'ti-layout-sidebar-2',
								],
							],
							'default' => 'inherit_from_customizer',
						]
					);
					$page->add_control(
						'applychanges3',
						[
							'label'			=> __('Apply', 'kata-plus'),
							'type'			=> Controls_Manager::BUTTON,
							'separator'		=> 'before',
							'button_type'	=> 'success',
							'text'			=> __('Apply', 'kata-plus'),
							'description'	=> __('Click the Apply button to save your changes.', 'kata-plus'),
							'event'			=> 'applychanges',
						]
					);
					$page->end_controls_section();

					$page->start_controls_section(
						'kata_page_options_full_page_slider',
						[
							'label' => esc_html__( 'Full Page Slider', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
					);
					$page->add_control(
						'full_page_slider_pro',
						[
							'label' 			=> __( 'Full Page Slider', 'kata-plus' ),
							'type'				=> Controls_Manager::RAW_HTML,
							'raw'				=> '<div class="elementor-nerd-box">
								<img class="elementor-nerd-box-icon" src="' . esc_attr( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ) . '">
								<div class="elementor-nerd-box-title">' . __( 'Full Page Slider', 'kata-plus' ) . '</div>
								<div class="elementor-nerd-box-message">' . __( 'Full Page Slider will turns each section into a slide and displays a page in form of a slider.', 'kata-plus' ) . '</div>
								<a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="https://my.climaxthemes.com/buy" target="_blank">' . __( 'Kata Pro', 'kata-plus' ) . '</a>
							</div>',
						]
					);
					do_action( 'kata_plus_full_page_slider', $page );
					$page->add_control(
						'applychanges4',
						[
							'label'			=> __('Apply', 'kata-plus'),
							'type'			=> Controls_Manager::BUTTON,
							'separator'		=> 'before',
							'button_type'	=> 'success',
							'text'			=> __('Apply', 'kata-plus'),
							'description'	=> __('Click the Apply button to save your changes.', 'kata-plus'),
							'event'			=> 'applychanges',
						]
					);
					$page->end_controls_section();

					$page->start_controls_section(
						'kata_page_options_footer',
						[
							'label' => esc_html__( 'Footer', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
					);
					$page->add_control(
						'show_footer',
						[
							'label'        => __( 'Footer:', 'kata-plus' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => __( 'Show', 'kata-plus' ),
							'label_off'    => __( 'Hide', 'kata-plus' ),
							'return_value' => '1',
							'default'      => '1',
						]
					);
					$page->add_control(
						'applychanges5',
						[
							'label'			=> __('Apply', 'kata-plus'),
							'type'			=> Controls_Manager::BUTTON,
							'separator'		=> 'before',
							'button_type'	=> 'success',
							'text'			=> __('Apply', 'kata-plus'),
							'description'	=> __('Click the Apply button to save your changes.', 'kata-plus'),
							'event'			=> 'applychanges',
						]
					);
					$page->end_controls_section();

					$page->start_controls_section(
						'kata_page_options_page_style',
						[
							'label' => esc_html__( 'Page Stylers', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_SETTINGS,
						]
					);
					$page->add_control(
						'styler_body',
						[
							'label'     => esc_html__( 'Body Styler', 'kata-plus' ),
							'type'      => 'kata_styler',
							'selectors' => Kata_Styler::selectors( 'body' ),
						]
					);
					$page->add_control(
						'styler_content',
						[
							'label'     => esc_html__( 'Content Styler', 'kata-plus' ),
							'type'      => 'kata_styler',
							'selectors' => Kata_Styler::selectors( '.kata-content' ),
						]
					);
					$page->end_controls_section();

					$settings                                        = $page->get_settings();
					$settings['kata_show_header']                    = isset( $settings['kata_show_header'] ) && '1' == $settings['kata_show_header'] ? $settings['kata_show_header'] : '0';
					$settings['kata_make_header_transparent']        = isset( $settings['kata_make_header_transparent'] ) ? $settings['kata_make_header_transparent'] : '0';
					$settings['kata_header_transparent_white_color'] = isset( $settings['kata_header_transparent_white_color'] ) ? $settings['kata_header_transparent_white_color'] : '0';
					$settings['full_page_slider']                    = isset( $settings['full_page_slider'] ) ? $settings['full_page_slider'] : '0';
					$settings['full_page_slider_navigation']         = isset( $settings['full_page_slider_navigation'] ) ? $settings['full_page_slider_navigation'] : '0';
					$settings['full_page_slider_loop_bottom']        = isset( $settings['full_page_slider_loop_bottom'] ) ? $settings['full_page_slider_loop_bottom'] : '0';
					$settings['full_page_slider_loop_top']           = isset( $settings['full_page_slider_loop_top'] ) ? $settings['full_page_slider_loop_top'] : '0';
					$settings['show_footer']                         = isset( $settings['show_footer'] ) && $settings['show_footer'] == '1' ? '1' : '0';
					$settings['kata_show_page_title']                = isset( $settings['kata_show_page_title'] ) ? $settings['kata_show_page_title'] : '0';
					$settings['full_page_slider']                    = isset( $settings['full_page_slider'] ) ? $settings['full_page_slider'] : '0';

					update_post_meta( get_the_ID(), 'kata_show_header', $settings['kata_show_header'] );
					update_post_meta( get_the_ID(), 'kata_make_header_transparent', $settings['kata_make_header_transparent'] );
					update_post_meta( get_the_ID(), 'kata_header_transparent_white_color', $settings['kata_header_transparent_white_color'] );
					update_post_meta( get_the_ID(), 'kata_show_page_title', $settings['kata_show_page_title'] );
					update_post_meta( get_the_ID(), 'kata_page_title_text', $settings['kata_page_title_text'] );
					update_post_meta( get_the_ID(), 'kata_styler_page_title', $settings['kata_styler_page_title'] );
					update_post_meta( get_the_ID(), 'sidebar_position', $settings['sidebar_position'] );
					if ( isset( $settings['full_page_slider'] ) ) {
						update_post_meta( get_the_ID(), 'full_page_slider', $settings['full_page_slider'] );
					}
					if ( isset( $settings['full_page_slider_navigation'] ) ) {
						update_post_meta( get_the_ID(), 'full_page_slider_navigation', $settings['full_page_slider_navigation'] );
					}
					if ( isset( $settings['full_page_slider_navigation_position'] ) ) {
						update_post_meta( get_the_ID(), 'full_page_slider_navigation_position', $settings['full_page_slider_navigation_position'] );
					}
					if ( isset( $settings['full_page_slider_loop_bottom'] ) ) {
						update_post_meta( get_the_ID(), 'full_page_slider_loop_bottom', $settings['full_page_slider_loop_bottom'] );
					}
					if ( isset( $settings['full_page_slider_loop_top'] ) ) {
						update_post_meta( get_the_ID(), 'full_page_slider_loop_top', $settings['full_page_slider_loop_top'] );
					}
					if ( isset( $settings['full_page_slider_scrolling_speed'] ) ) {
						update_post_meta( get_the_ID(), 'full_page_slider_scrolling_speed', $settings['full_page_slider_scrolling_speed'] );
					}
					update_post_meta( get_the_ID(), 'show_footer', $settings['show_footer'] );
					update_post_meta( get_the_ID(), 'styler_body', $settings['styler_body'] );
					update_post_meta( get_the_ID(), 'styler_content', $settings['styler_content'] );
				}
			}
		}

		/**
		 * Get Theme Name or White Label Name
		 *
		 * @since   1.0.0
		 */
		public function the_theme_name() {
			$white_label = class_exists( 'Kata_Plus_Pro_Theme_Options_Functions' )  && Kata_Plus_Pro_Theme_Options_Functions::get_instance()->white_label()->name ? Kata_Plus_Pro_Theme_Options_Functions::get_instance()->white_label()->name : '';
			if ( ! $white_label ) :
				return Kata_Plus_Helpers::get_theme()->name . ' ';
			else :
				return $white_label . ' ';
			endif;
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {			
			// Modules
			foreach ( glob( self::$dir . 'modules/*' ) as $folder ) {
				Kata_Plus_Autoloader::load( $folder, 'widget' );
			}
			// Builders
			foreach ( glob( self::$dir . 'builders/*' ) as $file ) {
				Kata_Plus_Autoloader::load( dirname( $file ), basename( $file, '.php' ) );
			}
		}

		/**
		 * Configuration.
		 *
		 * @since   1.0.0
		 */
		public function config() {
			// Add Post types support
			add_post_type_support( 'mega_menu', 'elementor' );
		}

		/**
		 * Add Responsive Devices to Elementor
		 *
		 * @since     1.0.0
		 */
		public function add_elementor_stylesheet_devices()
		{
			$stylesheet_obj = new Stylesheet();
			$stylesheet_obj->add_device( 'smallmobile', 321 );
			$stylesheet_obj->add_device( 'mobile', get_option( 'elementor_viewport_md' ) ? get_option( 'elementor_viewport_md' )  : 481 );
			$stylesheet_obj->add_device( 'tablet', get_option( 'elementor_viewport_lg' ) ? get_option( 'elementor_viewport_lg' )  : 769 );
			$stylesheet_obj->add_device( 'tabletlandscape', 1025 );
			$stylesheet_obj->add_device( 'laptop', 1367 );
			$stylesheet_obj->add_device( 'desktop', 1440 );
		}

		/**
		 * Add Responsive Devices to Elementor
		 *
		 * @since     1.0.0
		 */
		public function add_responsive_devices( $base )
		{
			$breakpoints = \Elementor\Core\Responsive\Responsive::get_breakpoints();
			$base->get_stylesheet()->add_device( 'smallmobile', 321 );
			$base->get_stylesheet()->add_device( 'mobile', get_option( 'elementor_viewport_md' ) ? get_option( 'elementor_viewport_md' )  : 481 );
			$base->get_stylesheet()->add_device( 'tablet', get_option( 'elementor_viewport_lg' ) ? get_option( 'elementor_viewport_lg' )  : 769 );
			$base->get_stylesheet()->add_device( 'tabletlandscape', 1025 );
			$base->get_stylesheet()->add_device( 'laptop', 1367 );
			$base->get_stylesheet()->add_device( 'desktop', 1440 );
		}


		/**
		 * Add kata category.
		 *
		 * @since   1.0.0
		 */
		public function elementor_space_between_widgets() {
			if( ! get_option( 'elementor_space_between_widgets' ) ) {
				$kata_options = get_option( 'kata_options' );
				$kata_options['elementor_margin_between_widgets'] = ! isset( $kata_options['elementor_margin_between_widgets'] ) ? false : true;
				update_option( 'kata_options', $kata_options );
				if( $kata_options['elementor_margin_between_widgets'] ) {
					update_option( 'elementor_space_between_widgets' , '0' );
				}
			}
		}

		/**
		 * Add kata category.
		 *
		 * @since   1.0.0
		 */
		public function sync_container() {
			if ( ! get_option( '_elementor_general_settings' ) || ! get_option( 'elementor_container_width' ) ) {
				add_option( '_elementor_general_settings' );
				add_option( 'elementor_container_width' );
			}
			$kata_options                        = get_option( 'kata_options' );
			$kata_customizer                     = get_option( 'theme_mods_kata' );
			$kata_container                      = get_theme_mod( 'kata_grid_size_desktop', '1600' );
			$elementor_settings                  = get_option( '_elementor_general_settings' );
			$kata_options['kata_container']      = get_theme_mod( 'kata_grid_size_desktop', '1600' );
			$kata_options['elementor_container'] = $elementor_settings['container_width'] ? $elementor_settings['container_width'] : '1600';

			if ( $kata_options['kata_container'] !== $kata_options['elementor_container'] ) {
				if ( $kata_options['container'] !== $kata_options['kata_container'] ) {
					$kata_options['container']           = $kata_options['kata_container'];
					$kata_options['elementor_container'] = $kata_options['kata_container'];
				} elseif ( $kata_options['container'] !== $kata_options['elementor_container'] ) {
					$kata_options['container']      = $kata_options['elementor_container'];
					$kata_options['kata_container'] = $kata_options['elementor_container'];
				}
				update_option( 'kata_options', $kata_options );
				update_option( 'elementor_container_width', $kata_options['container'] );
				$elementor_settings['container_width'] = $kata_options['container'];
				update_option( '_elementor_general_settings', $elementor_settings );
				Plugin::$instance->files_manager->clear_cache();
			}
		}

		/**
		 * Add kata category.
		 *
		 * @since   1.0.0
		 */
		public function elementorinit() {
			$page = isset( $_REQUEST['post'] ) ? get_the_title( $_REQUEST['post'] ) : '';

			switch ( $page ) {
				case 'Kata Blog':
				case 'Kata Archive':
				case 'Kata Search':
				case 'Kata Single':
				case 'Kata Author':
					// Blog & Post
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_blog_and_post',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Blog & Posts', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Usefull
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_most_usefull',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Essentials', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Normals
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Pro', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Header
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_header',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Header', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Courses
					if( is_plugin_active( 'learnpress/learnpress.php' )  ) {
						// LearnPress Course
						Plugin::instance()->elements_manager->add_category(
							'kata_plus_elementor_learnpress_course',
							[
								'title' => self::get_instance()->the_theme_name() . esc_html__( 'Courses', 'kata-plus' ),
								'icon'  => 'eicon-font',
							],
							1
						 );
					}
					break;
				case 'Kata Header':
				case 'Kata Sticky Header':
					// Header
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_header',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Header', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Usefull
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_most_usefull',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Essentials', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Normals
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Pro', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Blog & Post
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_blog_and_post',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Blog & Posts', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Courses
					if( is_plugin_active( 'learnpress/learnpress.php' )  ) {
						// LearnPress Course
						Plugin::instance()->elements_manager->add_category(
							'kata_plus_elementor_learnpress_course',
							[
								'title' => self::get_instance()->the_theme_name() . esc_html__( 'Courses', 'kata-plus' ),
								'icon'  => 'eicon-font',
							],
							1
						 );
					}
				break;
				case 'Single Course':
					if( is_plugin_active( 'learnpress/learnpress.php' )  ) {
						// LearnPress Course
						Plugin::instance()->elements_manager->add_category(
							'kata_plus_elementor_learnpress_course',
							[
								'title' => self::get_instance()->the_theme_name() . esc_html__( 'Courses', 'kata-plus' ),
								'icon'  => 'eicon-font',
							],
							1
						 );
					}
					// Blog & Post
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_blog_and_post',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Blog & Posts', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Usefull
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_most_usefull',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Essentials', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Normals
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Pro', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Header
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_header',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Header', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
				break;
				case 'Kata Footer':
				case 'Kata 404':
				default:
					// Usefull
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_most_usefull',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Essentials', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Normals
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Pro', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Blog & Post
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_blog_and_post',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Blog & Posts', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Header
					Plugin::instance()->elements_manager->add_category(
						'kata_plus_elementor_header',
						[
							'title' => self::get_instance()->the_theme_name() . esc_html__( 'Header', 'kata-plus' ),
							'icon'  => 'eicon-font',
						],
						1
					 );
					// Courses
					if( is_plugin_active( 'learnpress/learnpress.php' )  ) {
						// LearnPress Course
						Plugin::instance()->elements_manager->add_category(
							'kata_plus_elementor_learnpress_course',
							[
								'title' => self::get_instance()->the_theme_name() . esc_html__( 'Courses', 'kata-plus' ),
								'icon'  => 'eicon-font',
							],
							1
						 );
					}
				break;
			}
		}

		/**
		 * Elementor editor styles.
		 *
		 * @since   1.0.0
		 */
		public function editor_styles() {
			$kata_options = get_option( 'kata_options' );
			$ui_theme     = Elementor\Core\Settings\Manager::get_settings_managers( 'editorPreferences' )->get_model()->get_settings( 'ui_theme' );
			if ( $ui_theme === 'auto' && isset( $kata_options['prefers_color_scheme'] ) ) {
				$ui_theme = $kata_options['prefers_color_scheme'];
			}
			$file_name = 'elementor-editor.css';
			$type      = 'light';
			if ( $ui_theme == 'dark' ) {
				$file_name = 'elementor-editor-dark.css';
				$type      = 'dark';
			}
			$kata_options['prefers_color_scheme'] = $type;
			update_option( 'kata_options', $kata_options );
			if ( Plugin::$instance->editor->is_edit_mode() || get_current_screen()->id == 'customize' || Kata_Plus_Helpers::string_is_contain( get_current_screen()->id, 'toplevel_page_kata-plus' ) || Kata_Plus_Helpers::string_is_contain( get_current_screen()->id, 'kata_page_kata-plus' ) || Kata_Plus_Helpers::string_is_contain( get_current_screen()->id, 'appearance_page_kata' ) ) {
				wp_enqueue_style( 'kata-elementor-admin-' . $type, Kata_Plus::$assets . 'css/backend/' . $file_name, [], Kata_Plus::$version );
			}
		}

		/**
		 * Elementor preview styles.
		 *
		 * @since   1.0.0
		 */
		public function preview_styles() {
			wp_enqueue_style( 'kata-elementor-admin', Kata_Plus::$assets . 'css/backend/elementor-preview.css', [], Kata_Plus::$version );
			static::render_elementor_breakpoints_script( 'jquery' );
		}

		/**
		 * Elementor editor scripts.
		 *
		 * @since   1.0.0
		 */
		public function editor_scripts() {
			wp_enqueue_script( 'kata-elementor-admin', Kata_Plus::$assets . 'js/backend/elementor-editor.js', ['jquery', 'elementor-editor'], Kata_Plus::$version, true );
			static::render_elementor_breakpoints_script( 'kata-elementor-admin' );
			static::render_kata_widgets_script( 'kata-elementor-admin' );
			/* $breakpoints = static::get_breakpoints();
			echo '<style id="kata-plus-elementor-breakpoints">';
			foreach ( $breakpoints as $b => $size ) {
				if ( $b == 'desktop' ) {
					continue;
				}
				$size = $size == 1025 ? $size - 1 : $size;
                $size = $size == 769 ? $size - 2 : $size;
				echo 'body.elementor-device-' . $b . ' #elementor-preview-responsive-wrapper {
						width: ' . ( $size ) . 'px ! important;
					}';
				echo "\n";
			}
			echo '</style>'; */
		}

		/**
		 * Render Elementor Breakpoints Var Script
		 * @param $handel string
		 * @since     1.0.0
		 */
		public function render_elementor_breakpoints_script( $handel ) {
			$breakpoints = static::get_breakpoints();
			wp_add_inline_script(
				$handel,
				'
					var ElementorBreakPoints = ' . json_encode( $breakpoints ) . ';
				'
			 );
		}

		/**
		 * Render Kata Plus Widgets
		 * @param $handel inline script id
		 * @since 1.0.0
		 */
		public function render_kata_widgets_script( $handel ) {
			$widgets = [
				'kata-plus-archive-posts' => [
					'name'				 => 'kata-plus-archive-posts',
					'elType'			 => 'widget',
					'title' 			 => 'Archive Posts',
					'icon'				 => 'kata-widget kata-eicon-archive-posts',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-archive-posts',
					'categories'		 => ['kata_plus_elementor_blog_and_post'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-archive-posts',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-author-page' => [
					'name'				 => 'kata-plus-author-page',
					'elType'			 => 'widget',
					'title' 			 => 'Author Page',
					'icon'				 => 'kata-widget kata-eicon-call-to-action-page',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-author-page',
					'categories'		 => ['kata_plus_elementor_blog_and_post'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-author-page',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-category-lists' => [
					'name'				 => 'kata-plus-category-lists',
					'elType'			 => 'widget',
					'title' 			 => 'Categories List',
					'icon'				 => 'kata-widget kata-eicon-editor-list-ul',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-category-lists',
					'categories'		 => ['kata_plus_elementor_blog_and_post'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-category-lists',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-next-prev-post' => [
					'name'				 => 'kata-plus-next-prev-post',
					'elType'			 => 'widget',
					'title' 			 => 'Next & Previous Post',
					'icon'				 => 'kata-widget kata-eicon-post-navigation',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-next-prev-post',
					'categories'		 => ['kata_plus_elementor_blog_and_post'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-next-prev-post',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-related-posts' => [
					'name'				 => 'kata-plus-related-posts',
					'elType'			 => 'widget',
					'title' 			 => 'Related Posts',
					'icon'				 => 'kata-widget kata-eicon-post-list',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-related-posts',
					'categories'		 => ['kata_plus_elementor_blog_and_post'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-related-posts',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-search-page' => [
					'name'				 => 'kata-plus-search-page',
					'elType'			 => 'widget',
					'title' 			 => 'Search Page',
					'icon'				 => 'kata-widget kata-eicon-site-search',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-search-page',
					'categories'		 => ['kata_plus_elementor_blog_and_post'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-search-page',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-social-share' => [
					'name'				 => 'kata-plus-social-share',
					'elType'			 => 'widget',
					'title' 			 => 'Social Share',
					'icon'				 => 'kata-widget kata-eicon-social-icons',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-social-share',
					'categories'		 => ['kata_plus_elementor_blog_and_post'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-social-share',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-cart' => [
					'name'				 => 'kata-plus-cart',
					'elType'			 => 'widget',
					'title' 			 => 'Cart',
					'icon'				 => 'kata-widget kata-eicon-cart',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-cart',
					'categories'		 => ['kata_plus_elementor_header'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-cart',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-date' => [
					'name'				 => 'kata-plus-date',
					'elType'			 => 'widget',
					'title' 			 => 'Date',
					'icon'				 => 'kata-widget kata-eicon-date',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-date',
					'categories'		 => ['kata_plus_elementor_header'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-date',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-language-switcher' => [
					'name'				 => 'kata-plus-language-switcher',
					'elType'			 => 'widget',
					'title' 			 => 'Language Switcher',
					'icon'				 => 'kata-widget kata-eicon-text-area',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-language-switcher',
					'categories'		 => ['kata_plus_elementor_header'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-language-switcher',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-login' => [
					'name'				 => 'kata-plus-login',
					'elType'			 => 'widget',
					'title' 			 => 'Login',
					'icon'				 => 'kata-widget kata-eicon-lock-user',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-login',
					'categories'		 => ['kata_plus_elementor_header'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-login',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-hamburger-menu' => [
					'name'				 => 'kata-plus-hamburger-menu',
					'elType'			 => 'widget',
					'title' 			 => 'Hamburger Menu',
					'icon'				 => 'kata-widget kata-eicon-menu-toggle',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-hamburger-menu',
					'categories'		 => ['kata_plus_elementor_header'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-hamburger-menu',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-reservation' => [
					'name'				 => 'kata-plus-reservation',
					'elType'			 => 'widget',
					'title' 			 => 'Reservation',
					'icon'				 => 'kata-widget kata-eicon-form-horizontal',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-reservation',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-reservation',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-breadcrumbs' => [
					'name'				 => 'kata-plus-breadcrumbs',
					'elType'			 => 'widget',
					'title' 			 => 'Breadcrumbs',
					'icon'				 => 'kata-widget kata-eicon-breadcrumbs',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-breadcrumbs',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-breadcrumbs',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-portfolio-carousel' => [
					'name'				 => 'kata-plus-portfolio-carousel',
					'elType'			 => 'widget',
					'title' 			 => 'Portfolio Carousel',
					'icon'				 => 'kata-widget kata-eicon-slider-push',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-portfolio-carousel',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-portfolio-carousel',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-comparison-slider' => [
					'name'				 => 'kata-plus-comparison-slider',
					'elType'			 => 'widget',
					'title' 			 => 'Comparison Slider',
					'icon'				 => 'kata-widget kata-eicon-image-before-after',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-comparison-slider',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-comparison-slider',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-content-slider' => [
					'name'				 => 'kata-plus-content-slider',
					'elType'			 => 'widget',
					'title' 			 => 'Content Slider',
					'icon'				 => 'kata-widget kata-eicon-post-slider',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-content-slider',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-content-slider',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-content-toggle' => [
					'name'				 => 'kata-plus-content-toggle',
					'elType'			 => 'widget',
					'title' 			 => 'Content Toggle',
					'icon'				 => 'kata-widget kata-eicon-menu-toggle',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-content-toggle',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-content-toggle',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-countdown' => [
					'name'				 => 'kata-plus-countdown',
					'elType'			 => 'widget',
					'title' 			 => 'Countdown',
					'icon'				 => 'kata-widget kata-eicon-countdown',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-countdown',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-countdown',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-divider' => [
					'name'				 => 'kata-plus-divider',
					'elType'			 => 'widget',
					'title' 			 => 'Divider',
					'icon'				 => 'kata-widget kata-eicon-divider',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-divider',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-divider',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-domain-checker' => [
					'name'				 => 'kata-plus-domain-checker',
					'elType'			 => 'widget',
					'title' 			 => 'Domain Checker',
					'icon'				 => 'kata-widget kata-eicon-site-search',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-domain-checker',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-domain-checker',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-employee-information' => [
					'name'				 => 'kata-plus-employee-information',
					'elType'			 => 'widget',
					'title' 			 => 'Employee Information',
					'icon'				 => 'kata-widget kata-eicon-person',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-employee-information',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-employee-information',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-food-menu' => [
					'name'				 => 'kata-plus-food-menu',
					'elType'			 => 'widget',
					'title' 			 => 'Food Menu',
					'icon'				 => 'kata-widget kata-eicon-menu-toggle',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-food-menu',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-food-menu',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-food-menu-toggle' => [
					'name'				 => 'kata-plus-food-menu-toggle',
					'elType'			 => 'widget',
					'title' 			 => 'Food Menu Toggle',
					'icon'				 => 'kata-widget kata-eicon-menu-toggle',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-food-menu-toggle',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-food-menu-toggle',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-gift-cards' => [
					'name'				 => 'kata-plus-gift-cards',
					'elType'			 => 'widget',
					'title' 			 => 'Gift Cards',
					'icon'				 => 'kata-widget kata-eicon-welcome',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-gift-cards',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-gift-cards',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-google-map' => [
					'name'				 => 'kata-plus-google-map',
					'elType'			 => 'widget',
					'title' 			 => 'Google Map',
					'icon'				 => 'kata-widget kata-eicon-google-maps',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-google-map',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-google-map',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-image-carousel' => [
					'name'				 => 'kata-plus-image-carousel',
					'elType'			 => 'widget',
					'title' 			 => 'Image Carousel',
					'icon'				 => 'kata-widget kata-eicon-slider-push',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-image-carousel',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-image-carousel',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-image-hover-zoom' => [
					'name'				 => 'kata-plus-image-hover-zoom',
					'elType'			 => 'widget',
					'title' 			 => 'Image Hover Zoom',
					'icon'				 => 'kata-widget kata-eicon-zoom-in',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-image-hover-zoom',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-image-hover-zoom',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-instagram' => [
					'name'				 => 'kata-plus-instagram',
					'elType'			 => 'widget',
					'title' 			 => 'Instagram',
					'icon'				 => 'kata-widget kata-eicon-gallery-grid',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-instagram',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-instagram',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-portfolio-masonry' => [
					'name'				 => 'kata-plus-portfolio-masonry',
					'elType'			 => 'widget',
					'title' 			 => 'Portfolio Masonry',
					'icon'				 => 'kata-widget kata-eicon-posts-masonry',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-portfolio-masonry',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-portfolio-masonry',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-pricing-plan' => [
					'name'				 => 'kata-plus-pricing-plan',
					'elType'			 => 'widget',
					'title' 			 => 'Pricing Plan',
					'icon'				 => 'kata-widget kata-eicon-price-table',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-pricing-plan',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-pricing-plan',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-pricing-table' => [
					'name'				 => 'kata-plus-pricing-table',
					'elType'			 => 'widget',
					'title' 			 => 'Pricing Table',
					'icon'				 => 'kata-widget kata-eicon-price-table',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-pricing-table',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-pricing-table',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-progress-bar' => [
					'name'				 => 'kata-plus-progress-bar',
					'elType'			 => 'widget',
					'title' 			 => 'Progress Bar',
					'icon'				 => 'kata-widget kata-eicon-skill-bar',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-progress-bar',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-progress-bar',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-recipes' => [
					'name'				 => 'kata-plus-recipes',
					'elType'			 => 'widget',
					'title' 			 => 'Recipes',
					'icon'				 => 'kata-widget kata-eicon-call-to-action',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-recipes',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-recipes',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-seo-analytic' => [
					'name'				 => 'kata-plus-seo-analytic',
					'elType'			 => 'widget',
					'title' 			 => 'SEO Analytic',
					'icon'				 => 'kata-widget kata-eicon-dashboard',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-seo-analytic',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-seo-analytic',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-socials' => [
					'name'				 => 'kata-plus-socials',
					'elType'			 => 'widget',
					'title' 			 => 'Socials',
					'icon'				 => 'kata-widget kata-eicon-social-icons',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-socials',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-socials',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-table' => [
					'name'				 => 'kata-plus-table',
					'elType'			 => 'widget',
					'title' 			 => 'Table',
					'icon'				 => 'kata-widget kata-eicon-date',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-table',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-table',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-tabs' => [
					'name'				 => 'kata-plus-tabs',
					'elType'			 => 'widget',
					'title' 			 => 'Tabs',
					'icon'				 => 'kata-widget kata-eicon-tabs',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-tabs',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-tabs',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-task-process' => [
					'name'				 => 'kata-plus-task-process',
					'elType'			 => 'widget',
					'title' 			 => 'Task Process',
					'icon'				 => 'kata-widget kata-eicon-form-vertical',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-task-process',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-task-process',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-team' => [
					'name'				 => 'kata-plus-team',
					'elType'			 => 'widget',
					'title' 			 => 'Team',
					'icon'				 => 'kata-widget kata-eicon-person',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-team',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-team',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-testimonials-vertical' => [
					'name'				 => 'kata-plus-testimonials-vertical',
					'elType'			 => 'widget',
					'title' 			 => 'Testimonials Vertical',
					'icon'				 => 'kata-widget kata-eicon-testimonial-carousel',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-testimonials-vertical',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-testimonials-vertical',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-timeline' => [
					'name'				 => 'kata-plus-timeline',
					'elType'			 => 'widget',
					'title' 			 => 'Timeline',
					'icon'				 => 'kata-widget kata-eicon-time-line',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-timeline',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-timeline',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-toggle-sidebox' => [
					'name'				 => 'kata-plus-toggle-sidebox',
					'elType'			 => 'widget',
					'title' 			 => 'Toggle Sidebox',
					'icon'				 => 'kata-widget kata-eicon-h-align-left',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-toggle-sidebox',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-toggle-sidebox',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-template-loader' => [
					'name'				 => 'kata-plus-template-loader',
					'elType'			 => 'widget',
					'title' 			 => 'Template Loader',
					'icon'				 => 'kata-widget kata-eicon-template-loader',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-template-loader',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-template-loader',
					'show_in_panel'		 => true,
					'editable'			=> false
				],
				'kata-plus-audio-player' => [
					'name'				 => 'kata-plus-audio-player',
					'elType'			 => 'widget',
					'title' 			 => 'Template Loader',
					'icon'				 => 'kata-widget kata-eicon-audio-player',
					'reload_preview'	 => false,
					'help_url'			 => '',
					'widget_type'		 => 'kata-plus-audio-player',
					'categories'		 => ['kata_plus_elementor'],
					'html_wrapper_class' => 'elementor-widget-kata-plus-audio-player',
					'show_in_panel'		 => true,
					'editable'			 => false
				],
			];
			wp_add_inline_script( $handel, apply_filters(
				'kata_plus_pro_widgets',
				'var KataPlusPro = false; var KataProWidgets = ' . json_encode( $widgets ) . ';'
			) );
		}

		/**
		 * Elementor Breakpoints
		 *
		 * @since     1.0.0
		 */
		public static function get_breakpoints() {

			if ( ! get_option( 'elementor_viewport_md' ) ) {
				update_option( 'elementor_viewport_md', 481 );
			}

			if ( ! get_option( 'elementor_viewport_lg' ) ) {
				update_option( 'elementor_viewport_lg', 769 );
			}

			// 'mobile'          => get_option( 'elementor_viewport_md' ) ? get_option( 'elementor_viewport_md' ) : 480,
			// 'tablet'          => get_option( 'elementor_viewport_lg' ) ? get_option( 'elementor_viewport_lg' ) : 768,
			$breakpoints = [
				'smallmobile'     => 320,
				'mobile'          => 481,
				'tablet'          => 769,
				'tabletlandscape' => 1025,
				'laptop'          => 1366,
				'desktop'         => 1439,
			];
			return $breakpoints;
		}

		/**
		 * Module custom css frontned.
		 *
		 * @since   1.0.0
		 */
		public function module_custom_css_frontend( $post_css, $element )
		{
			if ( $post_css instanceof Dynamic_CSS ) {
				return;
			}
			$element_settings = $element->get_settings();
			$custom_css       = ! empty( $element_settings['custom_css'] ) ? trim( $element_settings['custom_css'] ) : '';
			if ( ! empty( $custom_css ) ) {
				$post_css->get_stylesheet()->add_raw_css( $custom_css );
			} else {
				return;
			}
		}

		/**
		 * Module custom css backend.
		 *
		 * @since   1.0.0
		 */
		public static function module_custom_css_editor( $custom_css ) {
			if ( ! empty( $custom_css ) && Plugin::$instance->editor->is_edit_mode() ) {
				echo '<style>' . $custom_css . '</style>';
			} else {
				return;
			}
		}

		/**
		 * is Edit mode.
		 *
		 * @since   1.0.0
		 */
		public static function is_edit_mode() {
			return Plugin::$instance->editor->is_edit_mode();
		}

		/**
		 * Controls.
		 *
		 * @since   1.0.0
		 */
		public function controls() {
			foreach ( glob( self::$dir . 'controls/*' ) as $file ) {
				Kata_Plus_Autoloader::load( $file, 'control' );
			}
		}

		/**
		 * After Section Start.
		 *
		 * @since   1.0.0
		 */
		public function elementor_section( $element, $section_id, $args )
		{
			if ( 'common' === $element->get_name() && '_section_style' === $section_id ) {
				$element->add_control(
					'common_styler',
					[
						'label'     => esc_html__( 'Widget Wrapper', 'kata-plus' ),
						'type'      => 'kata_styler',
						'selectors' => Kata_Styler::selectors(),
					]
				 );
			}
		}

		/**
		 * After Section Start.
		 *
		 * @since   1.0.0
		 */
		public function column_layout_options( $element, $args )
		{
			$element->add_control(
				'responsive_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( 'To change the column size in labtop, tabletlandscape, tablet, small mobile. You should go to style tab > styler tab and with using styler change column width', 'kata-plus' ),
					'content_classes' => 'kata-plus-elementor-error',
				]
			 );
			// $element->remove_responsive_control( '_inline_size' );
			// $element->add_responsive_control(
			// '_inline_size',
			// [
			// 'label'               => __( 'Column Width', 'elementor' ) . ' ( % )',
			// 'type'                => Controls_Manager::NUMBER,
			// 'min'                 => 2,
			// 'max'                 => 100,
			// 'required'            => true,
			// 'device_args'         => [
			// Controls_Stack::RESPONSIVE_TABLET => [
			// 'max'      => 100,
			// 'required' => false,
			// ],
			// Controls_Stack::RESPONSIVE_MOBILE => [
			// 'max'      => 100,
			// 'required' => false,
			// ],
			// ],
			// 'min_affected_device' => [
			// Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
			// Controls_Stack::RESPONSIVE_TABLET  => Controls_Stack::RESPONSIVE_MOBILE,
			// ],
			// 'selectors'           => [
			// '{{WRAPPER}}' => 'width: {{VALUE}}%',
			// ],
			// ]
			// );
			$element->add_responsive_control(
				'_max_inline_size',
				[
					'label'     => __( 'Column Max Width ( px )', 'kata-plus' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'step'      => 1,
					'selectors' => [
						'{{WRAPPER}}' => 'max-width: {{SIZE}}px;',
					],
				]
			 );
			$element->add_responsive_control(
				'_min_inline_size',
				[
					'label'     => __( 'Column Min Width ( px )', 'kata-plus' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'step'      => 1,
					'selectors' => [
						'{{WRAPPER}}' => 'min-width: {{SIZE}}px;',
					],
				]
			 );
			$element->add_responsive_control(
				'_max_height_inline_size',
				[
					'label'     => __( 'Column Max Height ( px )', 'kata-plus' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'step'      => 1,
					'selectors' => [
						'{{WRAPPER}}' => 'max-height: {{SIZE}}px;',
					],
				]
			 );
			$element->add_responsive_control(
				'_min_height_inline_size',
				[
					'label'     => __( 'Column Min Height ( px )', 'kata-plus' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'step'      => 1,
					'selectors' => [
						'{{WRAPPER}}' => 'min-height: {{SIZE}}px;',
					],
				]
			 );
		}

		/**
		 * Column Styling Options.
		 *
		 * @since   1.0.0
		 */
		public function column_style_options( $element, $args )
		{
			$element->start_controls_section(
				'column_advanced',
				[
					'label' => esc_html__( 'Styler', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			 );
			$element->add_control(
				'column_styler',
				[
					'label'     => esc_html__( 'Column Wrapper', 'kata-plus' ),
					'type'      => 'kata_styler',
					'selectors' => Kata_Styler::selectors( '{{WRAPPER}}', '', ' ' ),
				]
			 );
			$element->add_control(
				'widget_wrapper_styler',
				[
					'label'     => esc_html__( 'Column Inner', 'kata-plus' ),
					'type'      => 'kata_styler',
					'selectors' => Kata_Styler::selectors( '.elementor-element-populated' ),
				]
			);
			$element->end_controls_section();
		}

		/**
		 * Column Styling Options.
		 *
		 * @since   1.0.0
		 */
		public function section_style_options( $element, $args )
		{
			$element->start_controls_section(
				'section_style_options',
				[
					'label' => esc_html__( 'Styler', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			 );
			$element->add_control(
				'section_styler',
				[
					'label'     => esc_html__( 'Section Wrapper', 'kata-plus' ),
					'type'      => 'kata_styler',
					'selectors' => Kata_Styler::selectors(),
				]
			 );
			$element->end_controls_section();
		}

		/**
		 * Common controls.
		 *
		 * @since   1.0.0
		 */
		public function common_controls( $self ) {
			// Custom CSS section
			$self->start_controls_section(
				'custom_css_section',
				[
					'label' => esc_html__( 'Custom CSS', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$self->add_control(
				'custom_css_gopro',
				[
					'label' 			=> __( 'Custom CSS', 'kata-plus' ),
					'type'				=> Controls_Manager::RAW_HTML,
					'raw'				=> '<div class="elementor-nerd-box">
						<img class="elementor-nerd-box-icon" src="' . esc_attr( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ) . '">
						<div class="elementor-nerd-box-title">' . __( 'Meet Our Custom CSS', 'kata-plus' ) . '</div>
						<div class="elementor-nerd-box-message">' . __( 'Custom CSS lets you add CSS code to any widget, and see it render live right in the editor.', 'kata-plus' ) . '</div>
						<a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="https://my.climaxthemes.com/buy" target="_blank">' . __( 'Kata Pro', 'kata-plus' ) . '</a>
					</div>',
				]
			);
			$self->end_controls_section();

			// Parallax Motion section
			$self->start_controls_section(
				'section_box_parallax',
				[
					'label' => esc_html__( 'Parallax Motion', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$self->add_control(
				'prallax_motion_gopro',
				[
					'label' 			=> __( 'Motion Effects', 'kata-plus' ),
					'type'				=> Controls_Manager::RAW_HTML,
					'raw'				=> '<div class="elementor-nerd-box">
						<img class="elementor-nerd-box-icon" src="' . esc_attr( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ) . '">
						<div class="elementor-nerd-box-title">' . __( 'Meet Our Custom CSS', 'kata-plus' ) . '</div>
						<div class="elementor-nerd-box-message">' . __( 'Custom CSS lets you add CSS code to any widget, and see it render live right in the editor.', 'kata-plus' ) . '</div>
						<a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="https://my.climaxthemes.com/buy" target="_blank">' . __( 'Kata Pro', 'kata-plus' ) . '</a>
					</div>',
				]
			);
			$self->end_controls_section();

			// Presets
			$self->start_controls_section(
				'section_kata_plus_presets',
				[
					'label'	=> __( 'Presets', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$self->add_control(
				'presets_gopro',
				[
					'label' 			=> __( 'Motion Effects', 'kata-plus' ),
					'type'				=> Controls_Manager::RAW_HTML,
					'raw'				=> '<div class="elementor-nerd-box">
						<img class="elementor-nerd-box-icon" src="' . esc_attr( ELEMENTOR_ASSETS_URL . 'images/go-pro.svg' ) . '">
						<div class="elementor-nerd-box-title">' . __( 'Meet Our Custom CSS', 'kata-plus' ) . '</div>
						<div class="elementor-nerd-box-message">' . __( 'Custom CSS lets you add CSS code to any widget, and see it render live right in the editor.', 'kata-plus' ) . '</div>
						<a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="https://my.climaxthemes.com/buy" target="_blank">' . __( 'Kata Pro', 'kata-plus' ) . '</a>
					</div>',
				]
			);
			$self->end_controls_section();
		}

		/**
		 * Start Widget Parent.
		 *
		 * @since   1.0.0
		 */
		public static function start_parent( $self )
		{
			echo '<div class="' . $self->get_name() . '-parent">';
		}

		/**
		 * Widget Parent Class.
		 *
		 * @since   1.0.0
		 */
		public static function widget_parent_class( $self )
		{
			return '.' . $self->get_name() . '-parent';
		}

		/**
		 * End Widget Parent.
		 *
		 * @since   1.0.0
		 */
		public static function end_parent( $self )
		{
			echo '</div> <! –– end ' . $self->get_name() . '-parent ––> ';
		}
	} // class

	Kata_Plus_Elementor::get_instance();
}
