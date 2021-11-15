<?php
/**
 * Course Featured Image module config.
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

class Kata_Plus_Pro_Course_Featured_Image extends Widget_Base {
	public function get_name() {
		return 'kata-plus-course-featured-image';
	}

	public function get_title() {
		return esc_html__( 'Course Featured Image', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-featured-image';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_learnpress_course' ];
	}

	protected function register_controls() {
		// Styles section
		$this->start_controls_section(
			'styles_section',
			[
				'label' => esc_html__( 'Styles', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_course_featured_image',
			[
				'label'     => esc_html__( 'Course Featured Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-single-course-featured-image' ),
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
