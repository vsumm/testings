<?php
/**
 * LearnPress Course Price module config.
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
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Course_Price extends Widget_Base {
	public function get_name() {
		return 'kata-plus-course-price';
	}

	public function get_title() {
		return esc_html__( 'Course Price', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-date';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_learnpress_course' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'box_section',
			[
				'label' => esc_html__( 'Course Price', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'title',
			[
				'label'   => __( 'Title', 'kata-plus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Price', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __('Icon Source', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __('Kata Icons', 'kata-plus'),
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'course_price_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'linea/coin-dollar',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'course_price_image',
			[
				'label'     => __('Choose Image', 'kata-plus'),
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
				'name'      => 'course_price_image',
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
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-price' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_icon',
			[
				'label' => esc_html__( 'Icon', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_style_error',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_icon_wrapper',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-price-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_icon',
			[
				'label'     => __( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-price-icon-wrap .kata-icon' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_price',
			[
				'label' => esc_html__( 'Icon', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_price_wrapper',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.course-price' ),
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'     => __( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.price-title' ),
			]
		);
		$this->add_control(
			'sale_price',
			[
				'label'     => __( 'Sale Price', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.sale-price' ),
			]
		);
		$this->add_control(
			'origin_price',
			[
				'label'     => __( 'Origin Price', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.origin-price' ),
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
