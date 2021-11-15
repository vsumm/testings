<?php
/**
 * Spacer module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Kata_Plus_Spacer extends Widget_Base {
	public function get_name() {
		return 'kata-plus-gap';
	}

	public function get_title() {
		return esc_html__( 'Spacer', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-v-align-stretch';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Select Type Section
		$this->add_responsive_control(
			'inner_scroll_height',
			[
				'label'           => __( 'Space', 'kata-plus' ),
				'type'            => Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 100,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .kata-spacer-inner' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'spacer_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('To change spacer height size in (Laptop, Tabletlandscape, Small mobile) go to style tab > Wrapper then click on "Styler icon" go to size tab and then change the height attribute.', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_widget_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrap',
			[
				'label'				=> __( 'Wrapper', 'kata-plus' ),
				'type'				=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors(  '.kata-spacer-inner' ),
			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
