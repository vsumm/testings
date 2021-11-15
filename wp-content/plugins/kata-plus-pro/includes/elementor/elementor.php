<?php

/**
 * Elementor Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Dynamic_CSS;
use Elementor\Utils as ElementorUtils;
use Elementor\Settings;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Css_Filter;

if ( ! class_exists( 'Kata_Plus_Pro_Elementor' ) ) {
	class Kata_Plus_Pro_Elementor {

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
		 * @var     Kata_Plus_Pro_Elementor
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
			if ( ! class_exists( 'Elementor\Plugin' ) && ! class_exists( 'Kata_Plus' ) ) {
				return;
			}
			$this->definitions();
			$this->actions();
			$this->dependencies();
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			self::$dir = Kata_Plus_Pro::$dir . 'includes/elementor/';
			self::$url = Kata_Plus_Pro::$url . 'includes/elementor/';
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			add_action( 'elementor/init', [$this, 'elementorinit'], 0 );
			add_filter( 'kata_plus_pro_widgets', [$this, 'render_kata_widgets_script'] );
			remove_filter( 'kata_plus_common_controls', [Kata_Plus_Elementor::get_instance(), 'common_controls'], 10, 1 );
			add_action( 'elementor/element/wp-page/document_settings/before_section_start', [$this, 'kata_page_options'], 10, 2 );
			add_action( 'kata_plus_full_page_slider', [$this, 'kata_full_page_slider'], 10, 2 );
			add_action( 'elementor/controls/controls_registered', [$this, 'controls'] );
			add_filter( 'kata_plus_common_controls', [$this, 'common_controls'], 10, 1 );
			remove_action( 'styler_breakpoints', [Kata_Styler::instance(), 'breakpoints'] );
			add_action('styler_breakpoints', [$this, 'breakpoints']);
			add_action('styler_before_animation_end', [$this, 'styler_animations']);
			remove_action( 'styler_end_actions', [Kata_Styler::instance(), 'styler_actions'] );
			add_action('styler_end_actions', [$this, 'styler_actions']);
			add_action('before_start_shadow_section', [$this, 'styler_multiple_box_shadow']);
			remove_action( 'before_start_svg_panel', [Kata_Styler::instance(), 'styler_filters_and_transform_panels'] );
			add_action('before_start_svg_panel', [$this, 'styler_filters_and_transform_panels']);
			add_action('before_start_svg_section', [$this, 'styler_filters_and_transform_options']);
			add_action('styler_before_platforms', [$this, 'styler_more']);
			if( ! defined( 'ELEMENTOR_PRO_PATH' ) ) {
				add_action( 'elementor/preview/enqueue_scripts', [$this, 'full_site_editor_enqueue_script'] );
			}
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies() {
			// Modules
			foreach ( glob( self::$dir . 'modules/*' ) as $folder ) {
				Kata_Plus_Pro_Autoloader::load( $folder, 'widget' );
			}
			// Builders
			foreach ( glob( self::$dir . 'builders/*' ) as $file ) {
				Kata_Plus_Pro_Autoloader::load( dirname( $file ), basename( $file, '.php' ) );
			}
			// Dynamic Tags
			Kata_Plus_Pro_Autoloader::load( self::$dir . 'dynamic-tags/', 'class-kata-plus-pro-dynamictags' );
		}

		/**
		 * Add kata category.
		 *
		 * @since   1.0.0
		 */
		public function elementorinit() {
			// Load Template Manager
			Kata_Plus_Autoloader::load( self::$dir . 'template-manager', 'template-manager' );

			// Kata Post Type Support
			add_post_type_support( 'kata_mega_menu', 'elementor' );
		}

		/**
		 * Render Kata Plus Pro Widgets
		 *
		 * @since     1.0.0
		 */
		public function render_kata_widgets_script( $handel ) {
			return 'var KataPlusPro = true; var KataProWidgets = ' . json_encode( [] ) . ';';
		}

		/**
		 * Controls.
		 *
		 * @since   1.0.0
		 */
		public function breakpoints() {
			$breakpoints = did_action('elementor/loaded') ? Kata_Plus_Elementor::get_breakpoints() : ''; ?>
			<li data-name="desktop" class="active">
				<i class="eicon-device-desktop active"></i>
				<strong><?php echo __('Desktop', 'kata-plus'); ?></strong>
				<span><?php echo __('Default Preview', 'kata-plus'); ?></span>
			</li>
			<li data-name="laptop">
				<i class="eicon-device-laptop"></i>
				<strong><?php echo __('Laptop', 'kata-plus'); ?></strong>
				<span><?php echo $breakpoints['laptop']  ?>px</span>
			</li>
			<li data-name="tabletlandscape">
				<i class="eicon-device-tablet rotate-90"></i>
				<strong><?php echo __('Tablet Landscape', 'kata-plus'); ?></strong>
				<span><?php echo $breakpoints['tabletlandscape']  ?>px</span>
			</li>
			<li data-name="tablet">
				<i class="eicon-device-tablet"></i>
				<strong><?php echo __('Tablet', 'kata-plus'); ?></strong>
				<span><?php echo $breakpoints['tablet'] - 1  ?>px</span>
			</li>
			<li data-name="mobile">
				<i class="eicon-device-mobile"></i>
				<strong><?php echo __('Mobile', 'kata-plus'); ?></strong>
				<span><?php echo $breakpoints['mobile'] - 1  ?>px</span>
			</li>
			<li data-name="smallmobile">
				<i class="eicon-device-mobile small-icon"></i>
				<strong><?php echo __('Small Mobile', 'kata-plus'); ?></strong>
				<span><?php echo $breakpoints['smallmobile']  ?>px</span>
			</li>
			<?php
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
		 * is Edit mode.
		 *
		 * @since   1.0.0
		 */
		public static function is_edit_mode() {
			return Plugin::$instance->editor->is_edit_mode();
		}

		/**
		 * Common controls.
		 *
		 * @since   1.0.0
		 */
		public function common_controls( $self ) {
			$presets = Kata_Plus_Pro_Template_Manager_WebService::get_presets();
			/**
			 * Custom CSS section
			 */
			$self->start_controls_section(
				'custom_css_section',
				[
					'label' => esc_html__( 'Custom CSS', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$self->add_control(
				'custom_css',
				[
					'type' => 'kata_plus_custom_code',
				]
			);
			$self->end_controls_section();

			/**
			 * Parallax Motion section
			 */
			$self->start_controls_section(
				'section_box_parallax',
				[
					'label' => esc_html__( 'Parallax Motion', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$self->add_control(
				'parallax',
				[
					'label'   => esc_html__( 'Parallax', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''                 => esc_html__( 'Select', 'kata-plus' ),
						'vertical'         => esc_html__( 'Vertical', 'kata-plus' ),
						'vertical_mouse'   => esc_html__( 'Vertical + Mouse parallax', 'kata-plus' ),
						'horizontal'       => esc_html__( 'Horizontal', 'kata-plus' ),
						'horizontal_mouse' => esc_html__( 'Horizontal + Mouse parallax', 'kata-plus' ),
						'mouse'            => esc_html__( 'Mouse parallax', 'kata-plus' ),
					],
				]
			);
			// Easing Source : https://easings.net/
			$self->add_control(
				'parallax_easing',
				[
					'label'   => esc_html__( 'Easing', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''                       => 'Default',
						'initial'                => 'Initial',
						'linear'                 => 'Linear',
						'ease-out'               => 'EaseOut',
						'0.19,1,0.22,1'          => 'EaseInOut',
						'0.47,0,0.745,0.715'     => 'EaseInSine',
						'0.39,0.575,0.565,1'     => 'EaseOutSine',
						'0.445,0.05,0.55,0.95'   => 'EaseInOutSine',
						'0.55,0.085,0.68,0.53'   => 'EaseInQuad',
						'0.25,0.46,0.45,0.94'    => 'EaseOutQuad',
						'0.455,0.03,0.515,0.955' => 'EaseInOutQuad',
						'0.55,0.055,0.675,0.19'  => 'EaseInCubic',
						'0.215,0.61,0.355,1'     => 'EaseOutCubic',
						'0.645,0.045,0.355,1'    => 'EaseInOutCubic',
						'0.895,0.03,0.685,0.22'  => 'EaseInQuart',
						'0.165,0.84,0.44,1'      => 'EaseOutQuart',
						'0.77,0,0.175,1'         => 'EaseInOutQuart',
						'0.895,0.03,0.685,0.22'  => 'EaseInQuint',
						'0.895,0.03,0.685,0.22'  => 'EaseOutQuint',
						'0.895,0.03,0.685,0.22'  => 'EaseInOutQuint',
						'0.95,0.05,0.795,0.035'  => 'EaseInExpo',
						'0.19,1,0.22,1'          => 'EaseOutExpo',
						'1,0,0,1'                => 'EaseInOutExpo',
						'0.6,0.04,0.98,0.335'    => 'EaseInCirc',
						'0.075,0.82,0.165,1'     => 'EaseOutCirc',
						'0.785,0.135,0.15,0.86'  => 'EaseInOutCirc',
						'0.6,-0.28,0.735,0.045'  => 'EaseInBack',
						'0.175,0.885,0.32,1.275' => 'EaseOutBack',
						'0.68,-0.55,0.265,1.55'  => 'EaseInOutBack'
					],
					'selectors' => [
						'{{WRAPPER}} .kata-mouse-parallax, {{WRAPPER}} .kata_parallax' => 'transition-timing-function:cubic-bezier({{VALUE}});'
					],
					'condition' => [
						'parallax' => ['vertical', 'vertical_mouse', 'horizontal', 'horizontal_mouse'],
					],
				]
			);
			$self->add_control(
				'parallax_duration',
				[
					'label'     => __( 'Duration (ms)', 'kata-plus' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1000,
					'min'       => 0,
					'step'      => 100,
					'selectors'    => [
						'{{WRAPPER}} .kata-mouse-parallax, {{WRAPPER}} .kata_parallax' => 'transition-property: all; transition-duration:{{SIZE}}ms;'
					],
					'condition' => [
						'parallax' => ['vertical', 'vertical_mouse', 'horizontal', 'horizontal_mouse'],
					],
				]
			);
			$self->add_control(
				'parallax_delay',
				[
					'label'     => __( 'Delay (ms)', 'kata-plus' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => '',
					'min'       => 0,
					'step'      => 100,
					'selectors'    => [
						'{{WRAPPER}} .kata-mouse-parallax, {{WRAPPER}} .kata_parallax' => 'transition-delay:{{SIZE}}ms;'
					],
					'condition' => [
						'parallax' => ['vertical', 'vertical_mouse', 'horizontal', 'horizontal_mouse'],
					],
				]
			);
			$self->add_control(
				'parallax_speed',
				[
					'label'     => __( 'Parallax speed', 'kata-plus' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'default'   => [
						'unit' => '',
						'size' => 0,
					],
					'condition' => [
						'parallax' => ['vertical', 'vertical_mouse', 'horizontal', 'horizontal_mouse'],
					],
				]
			);
			$self->add_control(
				'parallax_mouse_speed',
				[
					'label'     => __( 'Parallax mouse speed', 'kata-plus' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'' => [
							'min'  => -30,
							'max'  => 30,
							'step' => 1,
						],
					],
					'default'   => [
						'unit' => '',
						'size' => 0,
					],
					'condition' => [
						'parallax' => ['vertical_mouse', 'horizontal_mouse', 'mouse'],
					],
				]
			);
			$self->end_controls_section();

			/**
			 * Presets
			 */
			foreach( $presets as $preset ) {
				if ( $self->get_name() === $preset ) {
					$self->start_controls_section(
						'section_kata_plus_presets',
						[
							'label'	=> __( 'Presets', 'kata-plus' ),
							'tab'   => Controls_Manager::TAB_CONTENT,
						]
					);
					$self->add_control(
						'kata_plus_presets_sync',
						[
							'type'				=> 'raw_html',
							'content_classes'	=> 'kata-plus-presets-sync',
							'raw'				=> '<div class="kata-plus-presets-sync"><span data-nonce="' . wp_create_nonce( 'kata_plus_sync_library_nonce' ) . '" data-element="' . $self->get_name() . '"><i class="eicon-sync" title=" ' . __( 'Sync library', 'kata-plus' ) . '"></i>' . __( 'Sync library', 'kata-plus' ) . '</span></div>',
						]
					);
					$self->add_control(
						'kata_plus_presets',
						[
							'type'		=> 'kata_plus_presets',
							'element'	=> $self->get_name(),
						]
					);
					$self->end_controls_section();
				}
			}
		}

		/**
		 * Full page slider.
		 *
		 * @since   1.0.0
		 */
		public function kata_page_options( $page ) {
			$page->remove_control( 'full_page_slider_pro' );
		}

		/**
		 * Full page slider Options.
		 *
		 * @since   1.0.0
		 */
		public function kata_full_page_slider( $page ) {
			$page->add_control(
				'full_page_slider',
				[
					'label'        => __( 'Full Page Slider', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'On', 'kata-plus' ),
					'label_off'    => __( 'Off', 'kata-plus' ),
					'return_value' => '1',
					'default'      => '0',
				]
			);
			$page->add_control(
				'full_page_slider_navigation',
				[
					'label'        => __( 'Navigation', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'kata-plus' ),
					'label_off'    => __( 'Hide', 'kata-plus' ),
					'return_value' => '1',
					'default'      => '1',
					'condition'    => [
						'full_page_slider' => '1',
					],
				]
			);
			$page->add_control(
				'full_page_slider_navigation_position',
				[
					'label'     => __( 'Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'right',
					'options'   => [
						'right' => __( 'Right', 'kata-plus' ),
						'left'  => __( 'Left', 'kata-plus' ),
					],
					'condition' => [
						'full_page_slider_navigation' => '1',
					],
				]
			);
			$page->add_control(
				'full_page_slider_loop_bottom',
				[
					'label'        => __( 'Loop Bottom', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'kata-plus' ),
					'label_off'    => __( 'Hide', 'kata-plus' ),
					'default'      => '1',
					'return_value' => '1',
					'condition'    => [
						'full_page_slider' => '1',
					],
				]
			);
			$page->add_control(
				'full_page_slider_loop_top',
				[
					'label'        => __( 'Loop Top', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'kata-plus' ),
					'label_off'    => __( 'Hide', 'kata-plus' ),
					'return_value' => '1',
					'default'      => '1',
					'condition'    => [
						'full_page_slider' => '1',
					],
				]
			);
			$page->add_control(
				'full_page_slider_scrolling_speed',
				[
					'label'      => __( 'Scroll Speed', 'kata-plus' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 850,
						'unit' => 'px',
					],
					'condition'  => [
						'full_page_slider' => '1',
					],
				]
			);
		}

		/**
		 * filters and transform panels.
		 *
		 * @since   1.0.0
		 */
		public function styler_filters_and_transform_panels() {
			?>
			<li class="styler-tooltip" data-name="filters" data-tooltip="Filters">
				<i class="eicon-review"></i>
				<a href="#"><?php echo __('Filters', 'kata-plus'); ?></a>
			</li>
			<li class="styler-tooltip" data-name="transform" data-tooltip="Transform">
				<i class="eicon-integration"></i>
				<a href="#"><?php echo __('Transform', 'kata-plus'); ?></a>
			</li>
			<?php
		}

		/**
		 * Multiple Box Shadow.
		 *
		 * @since   1.0.0
		 */
		public function styler_filters_and_transform_options() {
			?>
			<!-- filters Options -->
			<div class="styler-tab styler-tab-filters" data-name="filters">
				<!-- filters Options -->
				<h3><?php echo __('Effects', 'kata-plus'); ?></h3>
				<div class="form-group">
					<!-- Blur -->
					<label>
						<span><?php echo __('Blur', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="filter[blur]" data-unit="px">
					</label>

					<!-- Grayscale -->
					<label>
						<span><?php echo __('Grayscale', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="100">
						</div>
						<input type="text" name="filter[grayscale]" data-unit="%">
					</label>

					<!-- Brightness -->
					<label>
						<span><?php echo __('Brightness', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" step="0.1">
						</div>
						<input type="text" name="filter[brightness]" data-unit="%">
					</label>

					<!-- Contrast -->
					<label>
						<span><?php echo __('Contrast', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="filter[contrast]" data-unit="%">
					</label>

					<!-- Hue Rotate -->
					<label>
						<span><?php echo __('Hue Rotate', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="filter[hue-rotate]" data-unit="deg">
					</label>

					<!-- Invert -->
					<label>
						<span><?php echo __('Invert', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="filter[invert]" data-unit="%">
					</label>

					<!-- Saturate -->
					<label>
						<span><?php echo __('Saturate', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="filter[saturate]" data-unit="%">
					</label>

					<!-- Sepia -->
					<label>
						<span><?php echo __('Sepia', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="filter[sepia]" data-unit="%">
					</label>
				</div>

				<h3><?php echo __('BackDrop Effects', 'kata-plus'); ?></h3>
				<div class="form-group">
					<!-- Blur -->
					<label>
						<span><?php echo __('Blur', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="backdrop-filter[blur]" data-unit="px">
					</label>

					<!-- Grayscale -->
					<label>
						<span><?php echo __('Grayscale', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="100">
						</div>
						<input type="text" name="backdrop-filter[grayscale]" data-unit="%">
					</label>

					<!-- Brightness -->
					<label>
						<span><?php echo __('Brightness', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" step="0.1">
						</div>
						<input type="text" name="backdrop-filter[brightness]" data-unit="%">
					</label>

					<!-- Contrast -->
					<label>
						<span><?php echo __('Contrast', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="backdrop-filter[contrast]" data-unit="%">
					</label>

					<!-- Hue Rotate -->
					<label>
						<span><?php echo __('Hue Rotate', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="backdrop-filter[hue-rotate]" data-unit="deg">
					</label>

					<!-- Invert -->
					<label>
						<span><?php echo __('Invert', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="backdrop-filter[invert]" data-unit="%">
					</label>

					<!-- Saturate -->
					<label>
						<span><?php echo __('Saturate', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="backdrop-filter[saturate]" data-unit="%">
					</label>

					<!-- Sepia -->
					<label>
						<span><?php echo __('Sepia', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range">
						</div>
						<input type="text" name="backdrop-filter[sepia]" data-unit="%">
					</label>
				</div>

			</div> <!-- .styler-tab-filters -->
			<!-- transform Options -->
			<div class="styler-tab styler-tab-transform" data-name="transform">
				<!-- transform Options -->
				<h3><?php echo __('Transform', 'kata-plus'); ?></h3>
				<div class="form-group">
					<!-- Rotate -->
					<label>
						<span><?php echo __('Rotate', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="360">
						</div>
						<input type="text" name="f_transform[rotate]" data-unit="deg">
					</label>

					<!-- Scale -->
					<label>
						<span><?php echo __('Scale', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="3" step="0.1">
						</div>
						<input type="text" name="f_transform[scale]" data-unit="">
					</label>

					<!-- Scale -->
					<label>
						<span><?php echo __('Translate X', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="50" step="1">
						</div>
						<input type="text" name="f_transform[translate-x]" data-unit="px">
					</label>

					<!-- Scale -->
					<label>
						<span><?php echo __('Translate Y', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="50" step="1">
						</div>
						<input type="text" name="f_transform[translate-y]" data-unit="px">
					</label>

					<!-- Scale -->
					<label>
						<span><?php echo __('Translate Z', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="-500" max="500" step="1">
						</div>
						<input type="text" name="f_transform[translateZ]" data-unit="px">
					</label>

					<!-- Scale -->
					<label>
						<span><?php echo __('Skew X', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="50" step="1">
						</div>
						<input type="text" name="f_transform[skew-x]" data-unit="deg">
					</label>

					<!-- Scale -->
					<label>
						<span><?php echo __('Skew Y', 'kata-plus'); ?></span>
						<div class="range-wrap">
							<input type="range" min="0" max="50" step="1">
						</div>
						<input type="text" name="f_transform[skew-y]" data-unit="deg">
					</label>

				</div>
			</div> <!-- .styler-tab-transform -->
			<?php
		}

		/**
		 * Multiple Box Shadow.
		 *
		 * @since   1.0.0
		 */
		public function styler_multiple_box_shadow() {
			?>
			<div class="multi-box-shadow-actions-wrap bxh-mini-wrp">
				<div class="add-box-shadow styler-tooltip" data-tooltip="Add New">+</div>
			</div>
			<?php
		}

		/**
		 * actions options.
		 *
		 * @since   1.0.0
		 */
		public function styler_actions() {
			?>
			<span data-name="phover" class="p-hover"><?php echo __('Parent Hover', 'kata-plus'); ?></span>
			<span data-name="before"><?php echo __('Before', 'kata-plus'); ?></span>
			<span data-name="after"><?php echo __('After', 'kata-plus'); ?></span>
			<?php
		}

		/**
		 * More options.
		 *
		 * @since   1.0.0
		 */
		public function styler_more() {
			?>
			<div class="styler-tooltip more-menu-btn" data-tooltip="<?php echo __( 'More', 'kata-plus' ); ?>"><i class="eicon-ellipsis-v"></i></div>
			<ul class="actions-menu">
				<li class="kata-copy" data-action="copy"><?php echo __('Copy', 'kata-plus'); ?></li>
				<li class="kata-paste" data-action="paste"><?php echo __('Paste', 'kata-plus'); ?></li>
				<li class="kata-reset" data-action="reset"><?php echo __('Reset', 'kata-plus'); ?></li>
			</ul>
			<?php
		}

		/**
		 * Start parallax.
		 *
		 * @since   1.0.0
		 */
		public static function start_parallax( $parallax, $parallax_speed = '', $parallax_mouse_speed = '' ) {
			if ( $parallax ) {
				$parallax_speed       = isset( $parallax_speed['size'] ) ? $parallax_speed['size'] : '';
				$parallax_mouse_speed = $parallax_mouse_speed['size'];
				if ( $parallax == 'vertical_mouse' || $parallax == 'horizontal_mouse' || $parallax == 'mouse' ) {
					echo '<div class="kata-mouse-parallax" data-speed-x="' . esc_attr( -1 * $parallax_mouse_speed ) . '" data-speed-y="' . esc_attr( -1 * $parallax_mouse_speed ) . '">';
				}
				if ( $parallax == 'vertical' || $parallax == 'vertical_mouse' || $parallax == 'horizontal' || $parallax == 'horizontal_mouse' ) {
					$direction = $parallax == 'vertical' || $parallax == 'vertical_mouse' ? 'vertical' : 'horizontal';
					echo '<div class="kata_parallax" data-enllax-ratio="' . esc_attr( $parallax_speed / 100 ) . '" data-enllax-direction="' . esc_attr( $direction ) . '" data-enllax-type="foreground">';
				}
			}
		}

		/**
		 * End parallax.
		 *
		 * @since   1.0.0
		 */
		public static function end_parallax( $parallax ) {
			if ( $parallax ) {
				if ( $parallax == 'vertical' || $parallax == 'vertical_mouse' || $parallax == 'horizontal' || $parallax == 'horizontal_mouse' ) {
					echo '</div>';
				}
				if ( $parallax == 'vertical_mouse' || $parallax == 'horizontal_mouse' || $parallax == 'mouse' ) {
					echo '</div>';
				}
			}
		}

		/**
		 * Full Site Editor Enqueue scripts.
		 *
		 * @since   1.0.0
		 */
		public function full_site_editor_enqueue_script() {
			wp_enqueue_script( 'kata-plus-full-site-editor', Kata_Plus::$assets . 'js/backend/full-site-editor.js', ['jquery'], Kata_Plus::$version, true );
		}

		/**
		 * Full Site Editor Enqueue scripts.
		 *
		 * @since   1.0.0
		 */
		public function styler_animations() {
			?>
			<!-- Animation Options -->
			<h3><?php echo __('Animation', 'kata-plus'); ?></h3>
			<div class="form-group">
				<!-- Animation name -->
				<label>
					<i class="kata-important-btn eicon-star" data-task="important" data-field="animation-name"></i>
					<span><?php echo __('Pre-built Animation', 'kata-plus'); ?></span>
					<select name="animation-name">
						<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
						<option value="KPFadeIn">Fade In</option>
						<option value="KPFadeInDown">Fade In Down 1</option>
						<option value="KPFadeInDown1">Fade In Down 2</option>
						<option value="KPFadeInDown2">Fade In Down 3</option>
						<option value="KPFadeInUp">Fade In Up 1</option>
						<option value="KPFadeInUp1">Fade In Up 2</option>
						<option value="KPFadeInUp2">Fade In Up 3</option>
						<option value="KPFadeInLeft">Fade In Left 1</option>
						<option value="KPFadeInLeft1">Fade In Left 2</option>
						<option value="KPFadeInLeft2">Fade In Left 3</option>
						<option value="KPFadeInRight">Fade In Right 1</option>
						<option value="KPFadeInRight1">Fade In Right 2</option>
						<option value="KPFadeInRight2">Fade In Right 3</option>
						<option value="KPSlideFromRight">Slide From Right</option>
						<option value="KPSlideFromLeft">Slide From Left</option>
						<option value="KPSlideFromTop">Slide From Top</option>
						<option value="KPSlideFromBot">Slide From Bottom</option>
						<option value="KPMaskFromTop">Mask From Top</option>
						<option value="KPMaskFromBot">Mask From Bottom</option>
						<option value="KPMaskFromLeft">Mask From Left</option>
						<option value="KPMaskFromRight">Mask From Right</option>
						<option value="KPRotateIn">Rotate In</option>
						<option value="KPRotateInDownLeft">Rotate In Down Left 1</option>
						<option value="KPRotateInDownLeft1">Rotate In Down Left 2</option>
						<option value="KPRotateInDownLeft2">Rotate In Down Left 3</option>
						<option value="KPRotateInDownRight">Rotate In Down Right 1</option>
						<option value="KPRotateInDownRight1">Rotate In Down Right 2</option>
						<option value="KPRotateInDownRight2">Rotate In Down Right 3</option>
						<option value="KPRotateInUpLeft">Rotate In Up Left 1</option>
						<option value="KPRotateInUpLeft1">Rotate In Up Left 2</option>
						<option value="KPRotateInUpLeft2">Rotate In Up Left 3</option>
						<option value="KPRotateInUpRight">Rotate In Up Right 1</option>
						<option value="KPRotateInUpRight1">Rotate In Up Right 2</option>
						<option value="KPRotateInUpRight2">Rotate In Up Right 3</option>
						<option value="KPZoomIn">Zoom In 1</option>
						<option value="KPZoomIn1">Zoom In 2</option>
						<option value="KPZoomIn2">Zoom In 3</option>
						<option value="KPZoomIn3">Zoom In 4</option>
						<option value="KPScaleUp">Scale Up 1</option>
						<option value="KPScaleUp1">Scale Up 2</option>
						<option value="KPScaleUp2">Scale Up 3</option>
						<option value="KPScaleDown">Scale Down 1</option>
						<option value="KPScaleDown1">Scale Down 2</option>
						<option value="KPScaleDown2">Scale Down 3</option>
						<option value="KPFlipInUp">Flip In Down</option>
						<option value="KPFlipInUp1">Flip In Down 1</option>
						<option value="KPFlipInUp2">Flip In Down 2</option>
						<option value="KPFlipInDown">Flip In Up</option>
						<option value="KPFlipInDown1">Flip In Up 1</option>
						<option value="KPFlipInDown2">Flip In Up 2</option>
						<option value="KPFlipInLeft">Flip In Left</option>
						<option value="KPFlipInLeft1">Flip In Left 1</option>
						<option value="KPFlipInLeft2">Flip In Left 2</option>
						<option value="KPFlipInLeft3">Flip In Left 3</option>
						<option value="KPFlipInRight">Flip In Right</option>
						<option value="KPFlipInRight1">Flip In Right 1</option>
						<option value="KPFlipInRight2">Flip In Right 2</option>
						<option value="KPFlipInRight3">Flip In Right 3</option>
						<option value="KPPulseIn">Pulse In 1</option>
						<option value="KPPulseIn1">Pulse In 2</option>
						<option value="KPPulseIn2">Pulse In 3</option>
						<option value="KPPulseIn3">Pulse In 4</option>
						<option value="KPPulseIn4">Pulse In 5</option>
						<option value="KPPulseOut1">Pulse Out 1</option>
						<option value="KPPulseOut2">Pulse Out 2</option>
						<option value="KPPulseOut3">Pulse Out 3</option>
						<option value="KPPulseOut4">Pulse Out 4</option>
						<option value="KPShake">Shake</option>
						<option value="KPBounceIn">Bounce In</option>
						<option value="KPJackInTheBox">Jack In the Box</option>
					</select>
				</label>

				<!-- Trigger -->
				<label>
					<i class="kata-important-btn eicon-star" data-task="important" data-field="--triggeranimation"></i>
					<span><?php echo __('Trigger', 'kata-plus'); ?></span>
					<select name="--triggeranimation">
						<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
						<option value="onscreen">onScreen</option>
						<option value="pageloaded">Page Loaded</option>
					</select>
				</label>

				<!-- Animation Iteration Count -->
				<label>
					<i class="kata-important-btn eicon-star" data-task="important" data-field="animation-iteration-count"></i>
					<span><?php echo __( 'Reapeat', 'kata-plus' ); ?></span>
					<select name="animation-iteration-count">
						<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
						<option value="1">Once</option>
						<option value="2">2 Times</option>
						<option value="3">3 Times</option>
						<option value="4">4 Times</option>
						<option value="5">5 Times</option>
						<option value="6">6 Times</option>
						<option value="7">7 Times</option>
						<option value="8">8 Times</option>
						<option value="9">9 Times</option>
						<option value="10">10 Times</option>
						<option value="infinite">Infinite</option>
					</select>
				</label>

				<!-- Animation Timing Function -->
				<label>
					<i class="kata-important-btn eicon-star" data-task="important" data-field="animation-timing-function"></i>
					<span><?php echo __( 'Curve', 'kata-plus' ); ?></span>
					<select name="animation-timing-function">
						<option value=""><?php echo __('Select', 'kata-plus'); ?></option>
						<option value="initial">Initial</option>
						<option value="linear">Linear</option>
						<option value="ease-out">EaseOut</option>
						<option value="cubic-bezier(0.19,1,0.22,1)">EaseInOut</option>
						<option value="cubic-bezier(0.47,0,0.745,0.715)">EaseInSine</option>
						<option value="cubic-bezier(0.39,0.575,0.565,1)">EaseOutSine</option>
						<option value="cubic-bezier(0.445,0.05,0.55,0.95)">EaseInOutSine</option>
						<option value="cubic-bezier(0.55,0.085,0.68,0.53)">EaseInQuad</option>
						<option value="cubic-bezier(0.25,0.46,0.45,0.94)">EaseOutQuad</option>
						<option value="cubic-bezier(0.455,0.03,0.515,0.955)">EaseInOutQuad</option>
						<option value="cubic-bezier(0.55,0.055,0.675,0.19)">EaseInCubic</option>
						<option value="cubic-bezier(0.215,0.61,0.355,1)">EaseOutCubic</option>
						<option value="cubic-bezier(0.645,0.045,0.355,1)">EaseInOutCubic</option>
						<option value="cubic-bezier(0.895,0.03,0.685,0.22)">EaseInQuart</option>
						<option value="cubic-bezier(0.165,0.84,0.44,1)">EaseOutQuart</option>
						<option value="cubic-bezier(0.77,0,0.175,1)">EaseInOutQuart</option>
						<option value="cubic-bezier(0.895,0.03,0.685,0.22)">EaseInQuint</option>
						<option value="cubic-bezier(0.895,0.03,0.685,0.22)">EaseOutQuint</option>
						<option value="cubic-bezier(0.895,0.03,0.685,0.22)">EaseInOutQuint</option>
						<option value="cubic-bezier(0.95,0.05,0.795,0.035)">EaseInExpo</option>
						<option value="cubic-bezier(0.19,1,0.22,1)">EaseOutExpo</option>
						<option value="cubic-bezier(1,0,0,1)">EaseInOutExpo</option>
						<option value="cubic-bezier(0.6,0.04,0.98,0.335)">EaseInCirc</option>
						<option value="cubic-bezier(0.075,0.82,0.165,1)">EaseOutCirc</option>
						<option value="cubic-bezier(0.785,0.135,0.15,0.86)">EaseInOutCirc</option>
						<option value="cubic-bezier(0.6,-0.28,0.735,0.045)">EaseInBack</option>
						<option value="cubic-bezier(0.175,0.885,0.32,1.275)">EaseOutBack</option>
						<option value="cubic-bezier(0.68,-0.55,0.265,1.55)">EaseInOutBac</option>
					</select>
				</label>

				<!-- Animation Duration -->
				<label class="animation-duration">
					<i class="kata-important-btn eicon-star" data-task="important" data-field="animation-duration"></i>
					<span><?php echo __('Animation Duration', 'kata-plus'); ?></span>
					<div class="range-wrap">
						<input type="range" min="0" max="5000">
					</div>
					<input type="text" name="animation-duration" data-unit="ms">
				</label>
				<!-- Animation Delay -->
				<label>
					<i class="kata-important-btn eicon-star" data-task="important" data-field="animation-delay"></i>
					<span><?php echo __('Animation Delay', 'kata-plus'); ?></span>
					<div class="range-wrap">
						<input type="range" min="0" max="5000">
					</div>
					<input type="text" name="animation-delay" data-unit="ms">
				</label>
			</div>
			<?php
		}

	} // class

	Kata_Plus_Pro_Elementor::get_instance();
}