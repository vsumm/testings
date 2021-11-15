<?php
/**
 * Seo Analytic module config.
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

class Kata_Seo_Analytic extends Widget_Base {
	public function get_name() {
		return 'kata-plus-seo-analytic';
	}

	public function get_title() {
		return esc_html__( 'SEO Analytic', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-dashboard';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-seo-analytic' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-seo-analytic' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Seo Analytic Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'website_link',
			[
				'label'       => __( 'Link', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'https://www.seoptimer.com', 'kata-plus' ),
				'default'     => 'https://www.seoptimer.com/',
				'description' => __( 'The URL of the refrence website should be entered and a "/" added to the end of it, just like the default value in the field above.', 'kata-plus' ),
			]
		);
		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => esc_html__( 'themify/arrow-right', 'kata-plus' ),
			]
		);
		$this->add_control(
			'placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Enter an URL address', 'kata-plus' ),
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_parent',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-seo-analytic' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'seo_analytic',
			[
				'label' => esc_html__( 'Seo Analytic', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_input',
			[
				'label'     => esc_html__( 'Input', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-seo-analytic input[type="text"]' ),
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
			'styler_button',
			[
				'label'     => esc_html__( 'Button', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-seo-analytic button' ),
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
