<?php
/**
 * Book Table module config.
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

class Kata_Plus_Pro_Book_Table extends Widget_Base {
	public function get_name() {
		return 'kata-plus-book-table';
	}

	public function get_title() {
		return esc_html__( 'Reservation', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-book-table', 'kata-plus-flatpickr', 'kata-plus-book-table-date', 'kata-plus-datepicker-config', 'kata-plus-book-table-select' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-book-table', 'kata-plus-flatpickr', 'kata-plus-book-table-date', 'kata-plus-book-table-select' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Horizontal', 'kata-plus' ),
					'vertical'   => __( 'Vertical', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'res_id',
			[
				'label'       => __( 'Restaurant ID', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( '8256', 'kata-plus' ),
				'description' => wp_kses( __( 'Get ID: <a href="https://www.opentable.com" target="_blank">Opentable</a>', 'kata-plus' ), wp_kses_allowed_html( 'post' ) ),
			]
		);
		$this->add_control(
			'bt_txt_p',
			[
				'label'   => __( 'Person Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Person', 'kata_plus' ),
			]
		);
		$this->add_control(
			'bt_icon_p',
			[
				'label'   => __( 'Person Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'themify/user',
			]
		);
		$this->add_control(
			'bt_icon_c',
			[
				'label'   => __( 'Calendar Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'themify/calendar',
			]
		);
		$this->add_control(
			'bt_icon_t',
			[
				'label'   => __( 'Time Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'themify/time',
			]
		);
		$this->add_control(
			'bt_txt_b',
			[
				'label'   => __( 'Button Text', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'FIND A TABLE', 'kata-plus' ),
			]
		);

		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'wrapper_style',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'input_style',
			[
				'label' => esc_html__( 'Inputs', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_inputs_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .kata-plus-book-table-input-wrapper' ),
			]
		);
		$this->add_control(
			'styler_inputs',
			[
				'label'            => esc_html__( 'Inputs', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .kata-plus-book-table-input-wrapper input[type="number"], {{WRAPPER}} .kata-plus-book-table .kata-plus-book-table-input-wrapper input[type="text"]' ),
			]
		);
		$this->add_control(
			'styler_person',
			[
				'label'            => esc_html__( 'Person', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .kata-plus-book-table-input-wrapper .people-title' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			[
				'label' => esc_html__('Button', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_button_wrapper',
			[
				'label'            => esc_html__('Button Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-book-table .kata-plus-book-table-btn'),
			]
		);
		$this->add_control(
			'styler_button',
			[
				'label'            => esc_html__('Button', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-book-table .kata-plus-book-table-btn input[type="submit"]'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'select_style',
			[
				'label' => esc_html__( 'Select Time', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_select_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .kata-plus-book-table-input-wrapper .nice-select' ),
			]
		);
		$this->add_control(
			'styler_options_wrapper',
			[
				'label'            => esc_html__( 'Options Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .kata-plus-book-table-input-wrapper .nice-select .list' ),
			]
		);
		$this->add_control(
			'styler_options',
			[
				'label'            => esc_html__( 'Options', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .kata-plus-book-table-input-wrapper .nice-select .list li.option' ),
			]
		);
		$this->add_control(
			'styler_selected_option',
			[
				'label'            => esc_html__( 'Selected Option', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .kata-plus-book-table-input-wrapper .nice-select .current' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'icons_select',
			[
				'label' => esc_html__( 'Icons', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
			'styler_input_icons',
			[
				'label'            => esc_html__( 'Symbol Icons', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table .placehoder-icon .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_input_icon_plus',
			[
				'label'            => esc_html__( 'Control Icons', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-book-table-input-wrapper .updown .numbers i.kata-icon, {{WRAPPER}} .kata-plus-book-table-input-wrapper .arrow .kata-icon' ),
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
