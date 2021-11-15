<?php
/**
 * Comparison Slider config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Kata_Plus_Pro_comparison_slider extends Widget_Base {
	public function get_name() {
		return 'kata-plus-comparison-slider';
	}

	public function get_title() {
		return esc_html__( 'Comparison Slider', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-image-before-after';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-juxtapose', 'kata-plus-comparison-slider' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-juxtapose', 'kata-plus-comparison-slider-css' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'img1',
			[
				'label'   => __( 'Image After', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'label1',
			[
				'label' => esc_html__( 'Label After', 'kata-plus' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'img2',
			[
				'label'   => __( 'Image Before ', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'label2',
			[
				'label' => esc_html__( 'Label Before', 'kata-plus' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting_section',
			[
				'label' => esc_html__( 'Settings', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		'pos',
		[
			'label'      => esc_html__( 'Starting Position', 'kata-plus' ),
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [
			'%' => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
			],
		],
			'default'    => [
			'unit' => '%',
			'size' => 50,
			],
		]
		);

		$this->add_control(
			'orientation',
			[
				'label'   => esc_html__( 'Orientation', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'horizontal' => 'Horizontal',
					'vertical'   => 'Vertical',
				],
				'default' => 'horizontal',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_handle_line',
			[
				'label'     => esc_html__( 'Handle Line', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comparison-slider .jx-control' ),
			]
		);

		$this->add_control(
			'styler_handle_controller',
			[
				'label'     => esc_html__( 'Controller', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comparison-slider .jx-controller' ),
			]
		);

		$this->add_control(
			'styler_handle_right_arrow',
			[
				'label'     => esc_html__( 'Right Arrow', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comparison-slider .jx-arrow.jx-right' ),
			]
		);

		$this->add_control(
			'styler_handle_left_arrow',
			[
				'label'     => esc_html__( 'Left Arrow', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comparison-slider .jx-arrow.jx-left' ),
			]
		);

		$this->add_control(
			'styler_text',
			[
				'label'     => 'Before After Label',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comparison-slider .jx-label' ),
			]
		);

		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
