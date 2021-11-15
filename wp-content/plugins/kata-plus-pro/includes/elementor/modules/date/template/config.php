<?php
/**
 * Date module config.
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

class Kata_Plus_Pro_Date extends Widget_Base {
	public function get_name() {
		return 'kata-plus-date';
	}

	public function get_title() {
		return esc_html__( 'Date', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-date';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_header' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-date' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'box_section',
			[
				'label' => esc_html__( 'Date', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => __( 'Title', 'kata-plus' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Date', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => '7-stroke/date',
			]
		);

		$this->add_control(
			'date',
			[
				'label'       => __( 'Date', 'kata-plus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Date Format <a href="' . esc_url( 'https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples' ) . '" target="_blank">See Example</a>', 'kata-plus' ),
				'default'     => 'F j, Y h:i:s a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-date' ),
			]
		);

		$this->add_control(
			'styler_icon',
			[
				'label'     => 'Icon',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-date .kata-icon' ),
			]
		);

		$this->add_control(
			'styler_title',
			[
				'label'     => 'Title',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-date .kata-date-title' ),
			]
		);

		$this->add_control(
			'styler_date',
			[
				'label'     => 'Date',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-date .kata-date-format' ),
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
