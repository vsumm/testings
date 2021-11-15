<?php
/**
 * Weather module config.
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

class Kata_Plus_Pro_Weather extends Widget_Base {
	public function get_name() {
		return 'kata-plus-weather';
	}

	public function get_title() {
		return esc_html__( 'Weather', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-cloud-check';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_header' ];
	}

	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'box_section',
			[
				'label' => esc_html__( 'Weather', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'weather_id',
			[
				'label'       => __( 'Weather ID', 'kata-plus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Weather ID', 'kata-plus' ),
				'description' => __( 'Please, install WP cloudy plugin, and then create a new weather, after that place the id related to the weather in the following input.', 'kata-plus' ),
				'description' => wp_kses( 'Please, install <a href="https://en-gb.wordpress.org/plugins/wp-cloudy/" target="_blank">WP cloudy plugin</a>, and then create a new weather, after that place the id related to the weather in the following input.', wp_kses_allowed_html( 'post' ) ),
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
