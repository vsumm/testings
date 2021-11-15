<?php
/**
 * Counter module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Counter extends Widget_Base {
	public function get_name() {
		return 'kata-plus-counter';
	}

	public function get_title() {
		return __( 'Counter', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-counter';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-counter' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_counter',
			[
				'label' => __( 'Counter', 'kata-plus' ),
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Vertical', 'kata-plus' ),
					'vertical'   => __( 'Horizontal', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'aligne',
			[
				'label'   => __( 'Alignment', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dfalt',
				'options' => [
					'dfalt' => __( 'Center', 'kata-plus' ),
					'left'  => __( 'Left', 'kata-plus' ),
					'right' => __( 'Right', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'starting_number',
			[
				'label'   => __( 'Starting Number', 'kata-plus' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);
		$this->add_control(
			'ending_number',
			[
				'label'   => __( 'Ending Number', 'kata-plus' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 20000,
			]
		);
		$this->add_control(
			'prefix',
			[
				'label'       => __( 'Number Prefix', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$',
				'placeholder' => '$',
			]
		);
		$this->add_control(
			'suffix',
			[
				'label'       => __( 'Number Suffix', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Plus', 'kata-plus' ),
			]
		);
		$this->add_control(
			'duration',
			[
				'label'   => __( 'Animation Duration', 'kata-plus' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2000,
				'min'     => 100,
				'step'    => 100,
			]
		);
		$this->add_control(
			'thousand_separator',
			[
				'label'     => __( 'Thousand Separator', 'kata-plus' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_on'  => __( 'Show', 'kata-plus' ),
				'label_off' => __( 'Hide', 'kata-plus' ),
			]
		);
		$this->add_control(
			'thousand_separator_char',
			[
				'label'     => __( 'Separator', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'thousand_separator' => 'yes',
				],
				'options'   => [
					''  => 'Default',
					'.' => 'Dot',
					' ' => 'Space',
				],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __( 'Icon Source', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __( 'Kata Icon', 'kata-plus' ),
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/linux',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'     => __( 'Choose Image', 'kata-plus' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'symbol' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'symbol' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'kata-plus' ),
				'type'  => Controls_Manager::TEXTAREA,
				'rows'  => 3,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'view',
			[
				'label'   => __( 'View', 'kata-plus' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-counter' ),
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-counter .content-wrap' ),
			]
		);
		$this->add_control(
			'styler_number',
			[
				'label'            => esc_html__( 'Number', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.elementor-counter-number-wrapper .elementor-counter-number' ),
			]
		);
		$this->add_control(
			'styler_prefix',
			[
				'label'            => esc_html__( 'Prefix', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.elementor-counter-number-prefix' ),
			]
		);
		$this->add_control(
			'styler_suffix',
			[
				'label'            => esc_html__( 'Suffix', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.elementor-counter-number-suffix' ),
			]
		);
		$this->add_control(
			'styler_icon_wrap',
			[
				'label'            => esc_html__( 'Icon Wrap', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-counter-icon' ),
			]
		);
		$this->add_control(
			'styler_icon',
			[
				'label'            => esc_html__( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-counter-icon .kata-icon' ),
				'condition'        => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'svg_note',
			[
				'type'				=> Controls_Manager::RAW_HTML,
				'raw'				=> __( 'To style the SVGs please go to Style SVG tab.', 'kata-plus' ),
				'content_classes'	=> 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_image_st',
			[
				'label'            => esc_html__( 'Image', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-counter-icon img, {{WRAPPER}} .kata-plus-counter-icon .kata-svg-icon' ),
				'condition'        => [
					'symbol' => [
						'imagei',
					],
				],
			]
		);
		$this->add_control(
			'styler_description',
			[
				'label'            => esc_html__( 'Description', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-counter-text-wrap p' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_svg',
			[
				'label' => esc_html__( 'SVG', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'important_note2',
			[
				'type'				=> Controls_Manager::RAW_HTML,
				'raw'				=> __( 'Because certain SVGs use different tags for styling, you need to use the options below to style the uploaded SVG. They SVG tab in the Styler is there to do this.', 'kata-plus' ),
				'content_classes'	=> 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_icon_path',
			[
				'label'            => esc_html__( 'Path', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-svg-icon path' ),
			]
		);
		$this->add_control(
			'styler_icon_rect',
			[
				'label'            => esc_html__( 'Rect', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-svg-icon rect' ),
			]
		);
		$this->add_control(
			'styler_icon_line',
			[
				'label'            => esc_html__( 'Line', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-svg-icon line' ),
			]
		);
		$this->add_control(
			'styler_icon_circel',
			[
				'label'            => esc_html__( 'Circel', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-svg-icon circle' ),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
