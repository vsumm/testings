<?php
/**
 * Subscribe module config.
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

class Kata_Plus_Subscribe extends Widget_Base {
	public function get_name() {
		return 'kata-plus-subscribe';
	}

	public function get_title() {
		return esc_html__( 'Subscribe Newsletter', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-mail';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-subscribe' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'source',
			[
				'label'         => esc_html__( 'Source URL', 'kata-plus' ),
				'description'   => esc_html__( 'Mailchimp / Google feedburner URL', 'kata-plus' ),
				'type'          => Controls_Manager::SELECT,
				'default' 		=> 'feedburner',
				'options'		=> [
					'feedburner' => __( 'Feedburner', 'kata-plus' ),
					'mailchimp'  => __( 'Mailchimp', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'feedburner_uri',
			[
				'label'         => esc_html__( 'Feedburner URI', 'kata-plus' ),
				'placeholder' 	=> 'climaxthemes/rbPw',
				'type'          => Controls_Manager::TEXT,
				'show_external' => false,
				'condition' 	=> [
					'source' 	=> 'feedburner'
				],
			]
		);
		$this->add_control(
			'action',
			[
				'label'         => esc_html__( 'Mailchimp Signup form URL', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => false,
				'condition' 	=> [
					'source' 	=> 'mailchimp'
				],
			]
		);
		$this->add_control(
			'placeholder',
			[
				'label'   => esc_html__( 'Placeholder', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Email address', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'button',
			[
				'label' => esc_html__( 'Button', 'kata-plus' ),
				'type'  => Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_pos',
			[
				'label'		=> __( 'Icon Position', 'kata-plus' ),
				'type'		=> Controls_Manager::SELECT,
				'default'	=> 'right',
				'options'	=> [
					'right'	=> __( 'Right', 'kata-plus' ),
					'left'	=> __( 'Left', 'kata-plus' ),
				],
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
			'styler_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-subscribe' ),
			]
		);
		$this->add_control(
			'styler_input',
			[
				'label'     => esc_html__( 'Email Input', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-subscribe input[type="email"]' ),
			]
		);
		$this->add_control(
			'styler_input_placeholder',
			[
				'label'     => esc_html__( 'Email Placeholder', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-subscribe input[type="email"]::placeholder' ),
			]
		);
		$this->add_control(
			'styler_button',
			[
				'label'     => esc_html__( 'Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-subscribe .kt-submit-sub' ),
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
			'styler_button_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-subscribe .kata-icon' ),
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
