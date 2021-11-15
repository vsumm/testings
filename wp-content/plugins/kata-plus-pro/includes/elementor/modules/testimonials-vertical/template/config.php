<?php
/**
 * Testimonials Vertical module config.
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
use Elementor\Repeater;

class Kata_Plus_Pro_Testimonials_Vertical extends Widget_Base {
	public function get_name() {
		return 'kata-plus-testimonials-vertical';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Vertical', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-testimonial-vertical';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-testimonials-vertical' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-testimonials-vertical' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'kata-plus' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'owl_img',
			[
				'label' => __( 'Choose Image', 'kata-plus' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);
		$repeater->add_control(
			'owl_icon',
			[
				'label'   => __( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/quote-right',
			]
		);
		$repeater->add_control(
			'owl_name',
			[
				'label'   => __( 'Name', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Jane Smith', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'owl_pos',
			[
				'label'   => __( 'Position', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'CEO', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'owl_cnt',
			[
				'label'   => __( 'Content', 'kata-plus' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 10,
				'default' => __( 'would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'testimonials',
			[
				'label'       => __( 'Repeater List', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'owl_icon' => __( 'font-awesome/quote-right', 'kata-plus' ),
						'owl_name' => __( 'Emily Parker', 'kata-plus' ),
						'owl_pos'  => __( 'Company CEO', 'kata-plus' ),
						'owl_cnt'  => __( 'would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus' ),
					],
					[
						'owl_icon' => __( 'font-awesome/quote-right', 'kata-plus' ),
						'owl_name' => __( 'Mary Taylor', 'kata-plus' ),
						'owl_pos'  => __( 'Company CEO', 'kata-plus' ),
						'owl_cnt'  => __( 'would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus' ),
					],
					[
						'owl_icon' => __( 'font-awesome/quote-right', 'kata-plus' ),
						'owl_name' => __( 'Eric Walker', 'kata-plus' ),
						'owl_pos'  => __( 'Company CEO', 'kata-plus' ),
						'owl_cnt'  => __( 'would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus' ),
					],
					[
						'owl_icon' => __( 'font-awesome/quote-right', 'kata-plus' ),
						'owl_name' => __( 'Emily Parker', 'kata-plus' ),
						'owl_pos'  => __( 'Company CEO', 'kata-plus' ),
						'owl_cnt'  => __( 'would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus' ),
					],

				],
				'title_field' => '{{{ owl_name }}} {{{ owl_pos }}}',
			]
		);
		$this->end_controls_section();

		// owl option
		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'owl_spd',
			[
				'label'       => __( 'Slide Speed', 'kata-plus' ),
				'description' => __( 'Varies between 500/6000', 'kata-plus' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 500,
						'max'  => 6000,
						'step' => 1,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 5000,
				],
			]
		);
		$this->end_controls_section();

		// Styles
		$this->start_controls_section(
			'widget_style_parent',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'            => __( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-testimonials-vertical-wrapper' ),
			]
		);
		$this->add_control(
			'styler_widget_stage',
			[
				'label'            => esc_html__( 'Carousel Stage', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-testimonials-vertical' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'testimonials_style',
			[
				'label' => esc_html__( 'Testimonials', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'            => __( 'Item', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-testimonials-vertical-item' ),
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
			'styler_icon',
			[
				'label'            => __( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.testimonials-vertical-content .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_icon_content_wrapper',
			[
				'label'            => __( 'Content Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.testimonials-vertical-content' ),
			]
		);
		$this->add_control(
			'styler_icon_content',
			[
				'label'            => __( 'Content', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.testimonials-vertical-content p' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'testimonials_author',
			[
				'label' => esc_html__( 'Testimonial Author', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_icon_image',
			[
				'label'            => __( 'Image', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.testimonials-vertical-img img' ),
			]
		);
		$this->add_control(
			'styler_author_wrapper',
			[
				'label'            => __( 'Author Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.testimonials-vertical-info' ),
			]
		);
		$this->add_control(
			'styler_author_name',
			[
				'label'            => __( 'Author Name', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.testimonials-vertical-det p' ),
			]
		);
		$this->add_control(
			'styler_author_pos',
			[
				'label'            => __( 'Author Position', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.testimonials-vertical-det span' ),
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
