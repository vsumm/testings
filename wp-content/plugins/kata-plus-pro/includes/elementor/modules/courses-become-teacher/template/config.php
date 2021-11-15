<?php
/**
 * Courses module config.
 *
 * @teacher  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! class_exists('Kata_Plus_Pro_LP_Become_Teacher' ) ) {
	class Kata_Plus_Pro_LP_Become_Teacher extends Widget_Base {
		public function get_name() {
			return 'kata-plus-lp-become-teacher';
		}

		public function get_title() {
			return esc_html__( 'Learn Perss Become Teacher', 'kata-plus' );
		}

		public function get_icon() {
			return 'kata-widget kata-eicon-courses-courses';
		}

		public function get_categories() {
			return ['kata_plus_elementor_learnpress_course' ];
		}

		protected function register_controls() {
			// Settings
			$this->start_controls_section(
				'Settings_section',
				[
					'label' => esc_html__( 'Settings', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'icon_style_error',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __('With this widget you will be able to style Learn Press Become Teacher module with Kata Styler tool.', 'kata-plus'),
					'content_classes' => 'kata-plus-elementor-error',
				]
			);
			$this->end_controls_section();

			//Wrapper and Title
			$this->start_controls_section(
				'section_widget_wrapper',
				[
					'label' => esc_html__('Wrapper', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_bct_wrapper',
				[
					'label'            => esc_html__('Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_wrapper',
				[
					'label'            => esc_html__('Form Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form form[name="become-teacher-form"]'),
				]
			);
			$this->add_control(
				'styler_lp_bct_fields_wrapper',
				[
					'label'            => esc_html__('Fields Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields"]'),
				]
			);
			$this->add_control(
				'styler_lp_bct_title',
				[
					'label'            => esc_html__('Title', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form form[name="become-teacher-form"] h3'),
				]
			);
			$this->end_controls_section();

			//Messages
			$this->start_controls_section(
				'section_widget_messages',
				[
					'label' => esc_html__('Messages', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_bct_messages',
				[
					'label'            => esc_html__('Messages', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form form[name="become-teacher-form"] .learn-press-message.success'),
				]
			);
			$this->end_controls_section();

			//Name Field
			$this->start_controls_section(
				'section_widget_form_name',
				[
					'label' => esc_html__('Name Field', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_bct_form_name_wrapper',
				[
					'label'            => esc_html__('Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(1)'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_name_label',
				[
					'label'            => esc_html__('Label', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(1) label'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_name_input',
				[
					'label'            => esc_html__('Input', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(1) input'),
				]
			);
			$this->end_controls_section();

			//Email Field
			$this->start_controls_section(
				'section_widget_form_email',
				[
					'label' => esc_html__('Email Field', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_bct_form_email_wrapper',
				[
					'label'            => esc_html__('Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(2)'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_email_label',
				[
					'label'            => esc_html__('Label', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(2) label'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_email_input',
				[
					'label'            => esc_html__('Input', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(2) input'),
				]
			);
			$this->end_controls_section();

			//Phone Field
			$this->start_controls_section(
				'section_widget_form_phone',
				[
					'label' => esc_html__('Phone Field', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_bct_form_phone_wrapper',
				[
					'label'            => esc_html__('Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(3)'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_phone_label',
				[
					'label'            => esc_html__('Label', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(3) label'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_phone_input',
				[
					'label'            => esc_html__('Input', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(3) input'),
				]
			);
			$this->end_controls_section();

			//Message Field
			$this->start_controls_section(
				'section_widget_form_message',
				[
					'label' => esc_html__('Message Field', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_bct_form_message_wrapper',
				[
					'label'            => esc_html__('Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(4)'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_message_label',
				[
					'label'            => esc_html__('Label', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(1) label'),
				]
			);
			$this->add_control(
				'styler_lp_bct_form_message_textarea',
				[
					'label'            => esc_html__('Textarea', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form ul.become-teacher-fields li:nth-child(1) textarea'),
				]
			);
			$this->end_controls_section();

			//Submit button
			$this->start_controls_section(
				'section_widget_form_submit_button',
				[
					'label' => esc_html__('Submit Button', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_bct_form_submit_button',
				[
					'label'            => esc_html__('Submit Button', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.become-teacher-form form[name="become-teacher-form"] button[type="submit"]'),
				]
			);

			$this->end_controls_section();

			// Common controls
			apply_filters( 'kata_plus_common_controls', $this );
			// end copy
		}

		protected function render() {
			require dirname( __FILE__ ) . '/view.php';
		}
	} // class
}
