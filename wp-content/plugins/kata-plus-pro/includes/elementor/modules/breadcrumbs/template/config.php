<?php
/**
 * Breadcrumbs module config.
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

class Kata_Plus_Pro_Breadcrumbs extends Widget_Base {
	public function get_name() {
		return 'kata-plus-breadcrumbs';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumbs', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-breadcrumbs';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Setting', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'start_text',
			[
				'label'     => __( 'Location of Start', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Home', 'kata-plus' ),
			]
		);
		$this->add_control(
			'seperator_icon',
			[
				'label'     => esc_html__('Seperator', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/angle-double-right',
			]
		);
		$this->end_controls_section();

		// Content Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '#kata-breadcrumbs' ),
			]
		);
		$this->add_control(
			'styler_path',
			[
				'label'     => esc_html__( 'Path', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '#kata-breadcrumbs a' ),
			]
		);
		$this->add_control(
			'styler_current',
			[
				'label'     => esc_html__( 'Current', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '#kata-breadcrumbs span.current' ),
			]
		);
		$this->add_control(
			'styler_seperator',
			[
				'label'     => esc_html__( 'Seperator', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '#kata-breadcrumbs .kata-icon' ),
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
