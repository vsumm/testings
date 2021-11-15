<?php
/**
 * Contact Form module config.
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
class Kata_Plus_ContactForm extends Widget_Base {
	public function get_name() {
		return 'kata-plus-contact-form';
	}

	public function get_title() {
		return esc_html__( 'Contact Form', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-contact-form';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-contact-form', 'kata-plus-book-table-select' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-contact-form', 'kata-plus-book-table-select' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Contact Form Settings', 'kata-plus' ),
			]
		);

		$contact_form7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

		$cform_default     = '';
		$contact_form_name = $contact_form_id = $contact_form_op = [];

		if ( $contact_form7 ) {
			$i = 0;
			foreach ( $contact_form7 as $cform ) {
				if ( $i === 0 ) {
					$cform_default = $cform->ID;
				}
				$i++;
				$contact_form_name[] = $cform->post_title;
				$contact_form_id[]   = $cform->ID;
			}
			$contact_form_op = array_combine( $contact_form_id, $contact_form_name );
		} else {
			$contact_form_op[ __( 'No contact forms found', 'kata-plus' ) ] = 0;
		}

		$this->add_control(
			'contact_form',
			[
				'label'   => __( 'Please select your desired form', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $cform_default,
				'options' => $contact_form_op,
			]
		);
		$this->add_control(
			'icon_input_text',
			[
				'label' => esc_html__( 'Input Text Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_subject',
			[
				'label' => esc_html__( 'Input subject Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_subject_icon',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the icon of subject field, Please make sure subject field name is be equal "your-subject"', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'icon_input_email',
			[
				'label' => esc_html__( 'Input Email Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_url',
			[
				'label' => esc_html__( 'Input URL Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_tel',
			[
				'label' => esc_html__( 'Input Tel Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_number',
			[
				'label' => esc_html__( 'Input Number Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_date',
			[
				'label' => esc_html__( 'Input Date Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_textarea',
			[
				'label' => esc_html__( 'Textarea Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_select',
			[
				'label' => esc_html__( 'Select Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'icon_input_file',
			[
				'label' => esc_html__( 'File Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
			]
		);

		// Style options End
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_form_wrap',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_form',
			[
				'label'     => esc_html__( 'Form', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form form' ),
			]
		);
		$this->add_control(
			'styler_label',
			[
				'label'     => esc_html__( 'Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form label' ),
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
			'styler_form_icons',
			[
				'label'     => esc_html__( 'Icons', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form .kata-icon' ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_box_style_inputs',
			[
				'label' => esc_html__( 'Inputs', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_input_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form form.wpcf7-form span.wpcf7-form-control-wrap:not(.textarea-wrapper)' ),
			]
		);
		$this->add_control(
			'styler_input',
			[
				'label'     => esc_html__( 'Input', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form input:not([type="submit"])' ),
			]
		);
		$this->add_control(
			'styler_input_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form input:not([type="submit"])::placeholder' ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_box_style_date',
			[
				'label' => esc_html__('Date', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_date_placeholder',
			[
				'label'     => esc_html__('Date Placeholder', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-contact-form input[type="date"]:valid'),
			]
		);
		$this->add_control(
			'styler_date_picker_icon',
			[
				'label'     => esc_html__('Date picker Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-contact-form input[type="date"]::-webkit-calendar-picker-indicator'),
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_box_style_textarea',
			[
				'label' => esc_html__( 'Textarea', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_textarea_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form form.wpcf7-form span.wpcf7-form-control-wrap.textarea-wrapper' ),
			]
		);
		$this->add_control(
			'styler_textarea',
			[
				'label'     => esc_html__( 'Textarea', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form textarea' ),
			]
		);
		$this->add_control(
			'styler_textarea_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form textarea::placeholder' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style_button',
			[
				'label' => esc_html__( 'Submit Button', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_button',
			[
				'label'     => esc_html__( 'Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-contact-form input[type="submit"]' ),
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'select_style',
			[
				'label' => esc_html__( 'Dropdown Select', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_select_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-contact-form .nice-select' ),
			]
		);
		$this->add_control(
			'styler_options_wrapper',
			[
				'label'            => esc_html__( 'Options Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-contact-form .nice-select .list' ),
			]
		);
		$this->add_control(
			'styler_options',
			[
				'label'            => esc_html__( 'Options', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-contact-form .nice-select .list li.option' ),
			]
		);
		$this->add_control(
			'styler_selected_current_option',
			[
				'label'            => esc_html__( 'Current Option', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-contact-form .nice-select .current' ),
			]
		);
		$this->add_control(
			'styler_selected_option',
			[
				'label'            => esc_html__( 'Selected Option', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-contact-form .nice-select .list li.option.selected' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'select_style_error_and_wranings',
			[
				'label' => esc_html__( 'Errors And Warnings', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_ew_form',
			[
				'label'            => esc_html__( 'Form Error', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.wpcf7-form .wpcf7-validation-errors, {{WRAPPER}} .wpcf7-form .wpcf7-mail-sent-ng' ),
			]
		);
		$this->add_control(
			'styler_ew_fild',
			[
				'label'            => esc_html__( 'Fields Error', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.wpcf7-form .wpcf7-not-valid-tip' ),
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
