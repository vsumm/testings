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

class Kata_Domain_Checker extends Widget_Base {
	public function get_name() {
		return 'kata-plus-domain-checker';
	}

	public function get_title() {
		return esc_html__( 'Domain Checker', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-site-search';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-domain-checker' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Domain Checker', 'kata-plus' ),
			]
		);
		$this->add_control(
			'heading',
			[
				'label' => __( 'Please install "Ajax Domain Checker" from plugins manager.', 'kata-plus' ),
				'type'  => Controls_Manager::HEADING,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_parent',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_form',
			[
				'label' => esc_html__( 'Form', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_form_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .input-group' ),
			]
		);
		$this->add_control(
			'styler_form_input',
			[
				'label'            => esc_html__( 'Input', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker input[type="text"]' ),
			]
		);
		$this->add_control(
			'styler_form_button',
			[
				'label'            => esc_html__( 'Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .input-group-btn button[type="submit"]' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_success',
			[
				'label' => esc_html__( 'Success', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_success_message_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .result .callout-success' ),
			]
		);
		$this->add_control(
			'styler_success_message',
			[
				'label'            => esc_html__( 'Message', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .result .callout-success .col-xs-10' ),
			]
		);
		$this->add_control(
			'styler_success_button_wrapper',
			[
				'label'            => esc_html__( 'Button Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .callout-success .col-xs-2' ),
			]
		);
		$this->add_control(
			'styler_success_button',
			[
				'label'            => esc_html__( 'Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .callout .col-xs-2 a#buy' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_warning',
			[
				'label' => esc_html__( 'Warning', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_warning_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .result .alert-warning' ),
			]
		);
		$this->add_control(
			'styler_warning_message',
			[
				'label'            => esc_html__( 'Message', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .result .alert-warning .col-xs-10' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_error',
			[
				'label' => esc_html__( 'Error', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_error_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .result .callout-danger' ),
			]
		);
		$this->add_control(
			'styler_error_message',
			[
				'label'            => esc_html__( 'Message', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .result .callout-danger .col-xs-10' ),
			]
		);
		$this->add_control(
			'styler_error_button_wrapper',
			[
				'label'            => esc_html__( 'Button Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .result .callout-danger .col-xs-2' ),
			]
		);
		$this->add_control(
			'styler_error_button',
			[
				'label'            => esc_html__( 'Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-domain-checker .callout .col-xs-2 a button' ),
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
