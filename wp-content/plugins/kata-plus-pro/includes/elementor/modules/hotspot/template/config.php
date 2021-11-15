<?php
/**
 * Hotspot module config.
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
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Repeater;

class Kata_Plus_Pro_Image_Hotspot extends Widget_Base {
	public function get_name() {
		return 'kata-plus-image-hotspot';
	}

	public function get_title() {
		return esc_html__( 'Image Hotspot', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-image-hotspot';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-tooltip' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-image-hotspot' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'background_section',
			[
				'label' => esc_html__( 'Background', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'label'    => esc_html__( 'Background', 'kata-plus' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .kata-hotspot',
			]
		);

		$this->add_control(
			'height',
			[
				'label'      => __( 'Height', 'kata-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors'  => [
					'{{WRAPPER}} .kata-hotspot' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pins_section',
			[
				'label' => esc_html__( 'Pins', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$pins = new Repeater();

		$pins->add_control(
			'position', [
				'label' => __( 'Position', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'cc'     => esc_html__( 'Center Center', 'kata-plus' ),
					'tr'     => esc_html__( 'Top Right', 'kata-plus' ),
					'bc'     => esc_html__( 'Bottom Center', 'kata-plus' ),
					'tl'     => esc_html__( 'Top Left', 'kata-plus' ),
					'rc'     => esc_html__( 'Right Center', 'kata-plus' ),
					'bl'     => esc_html__( 'Bottom Left', 'kata-plus' ),
					'tc'     => esc_html__( 'Top Center', 'kata-plus' ),
					'br'     => esc_html__( 'Bottom Right', 'kata-plus' ),
					'lc'     => esc_html__( 'Left Center', 'kata-plus' ),
					'custom' => esc_html__( 'Custom', 'kata-plus' ),
				],
				'default' => 'cc',
			]
		);

		$pins->add_control(
			'top', [
				'label' => __( 'Top', 'kata-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 20,
				],
				'selectors'  => [
					'{{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'position' => [ 'custom' ],
				],
			]
		);

		$pins->add_control(
			'left', [
				'label' => __( 'Left', 'kata-plus' ),
				'type'    => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [
				'%' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default'    => [
				'unit' => '%',
				'size' => 30,
			],
			'selectors'  => [
				'{{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [
				'position' => [ 'custom' ],
			],
			]
		);

		$pins->add_control(
			'display', [
			'label' => __( 'Pin Type', 'kata-plus' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'pin'   => esc_html__( 'Icon', 'kata-plus' ),
				'image' => esc_html__( 'Image', 'kata-plus' ),
			],
			'default' => 'pin',
			]
		);

		$pins->add_control(
			'pin_icon', [
				'label' => __( 'Icons', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/bolt',
				'condition' => [
					'display' => [ 'pin' ],
				],
			]
		);

		$pins->add_control(
			'image', [
				'label' => __( 'Image', 'kata-plus' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'display' => [ 'image' ],
				],
			]
		);

		$pins->add_control(
			'img_size', [
				'label' => __( 'Image Dimension', 'kata-plus' ),
				'type'      => Controls_Manager::IMAGE_DIMENSIONS,
				'default'   => [
					'width'  => '50',
					'height' => '50',
				],
				'condition' => [
					'display' => [ 'image' ],
				],
			]
		);

		$pins->add_control(
			'style_icon_wrap', [
				'label' => __( 'Icon Wrapper Style', 'kata-plus' ),
				'type'  => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}.kata-hotspot-icon'),
			]
		);

		$pins->add_control(
			'style_icon', [
				'label' 			=> __( 'Icon Style', 'kata-plus' ),
				'type'  			=> 'kata_styler',
			]
		);

		$pins->add_control(
			'style_content', [
				'label' 			=> __( 'Description Style', 'kata-plus' ),
				'type'  			=> 'kata_styler',
			]
		);

		$pins->add_control(
			'description', [
				'label' => __( 'Description', 'kata-plus' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Description', 'kata-plus' ),
			]
		);

		$this->add_control(
			'pin',
			[
				'label' => __( 'Pins', 'kata-plus' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $pins->get_controls(),
				'default' => [
					[
						'description' => __( 'Description', 'kata-plus' ),
					],
				],
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
