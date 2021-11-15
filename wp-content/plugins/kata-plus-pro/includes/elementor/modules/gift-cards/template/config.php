<?php
/**
 * Gift Cards module config.
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

class Kata_Gift_Cards extends Widget_Base {
	public function get_name() {
		return 'kata-plus-gift-cards';
	}

	public function get_title() {
		return esc_html__( 'Gift Cards', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-welcome';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-gift-card'];
	}

	public function get_style_depends() {
		return [ 'kata-plus-gift-cards' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Gift Cards', 'kata-plus' ),
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
