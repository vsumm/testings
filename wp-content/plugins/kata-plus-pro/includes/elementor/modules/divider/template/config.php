<?php
/**
 * Divider module config.
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

class Kata_Plus_Pro_Divider extends Widget_Base {
	public function get_name() {
		return 'kata-plus-divider';
	}

	public function get_title() {
		return esc_html__( 'Divider', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-divider';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-team-member' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'divider',
			[
				'label'     => __( 'Divider', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-divider-separator' ),
			]
		);

		// Common controls
		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );

	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
