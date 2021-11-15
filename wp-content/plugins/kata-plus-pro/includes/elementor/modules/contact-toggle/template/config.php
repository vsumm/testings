<?php
/**
 * Contact Toggle module config.
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

class Kata_Contact_Toggle extends Widget_Base {
	public function get_name() {
		return 'kata-plus-contact-toggle';
	}

	public function get_title() {
		return esc_html__( 'Contact Toggle', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-mail';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-contact-toggle' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-contact-toggle', 'kata-plus-contact-form' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Contact Toggle Settings', 'kata-plus' ),
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
				$contact_form_name[] = $cform->post_title;
				$contact_form_id[]   = $cform->ID;
			}
			$contact_form_op = array_combine( $contact_form_id, $contact_form_name );
		} else {
			$contact_form_op[ __( 'No contact forms found', 'kata-plus' ) ] = [ __( 'No contact forms found', 'kata-plus' ) ];
		}

		$this->add_control(
			'select_form',
			[
				'label'   => __( 'Select From', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $cform_default,
				'options' => $contact_form_op,
			]
		);

		$this->add_control(
			'type',
			[
				'label'   => __( 'Type', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => __( 'Icon', 'kata-plus' ),
					'txt'  => __( 'Text', 'kata-plus' ),
				],
			]
		);

		$this->add_control(
			't_txt',
			[
				'label'     => __( 'Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Contact Form', 'kata-plus' ),
				'condition' => [
					'type' => 'txt',
				],
			]
		);

		$this->add_control(
			'open_type',
			[
				'label'   => __( 'Open As', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'modal',
				'options' => [
					'modal' => __( 'Modal', 'kata-plus' ),
					'drop'  => __( 'Dropdown', 'kata-plus' ),
					'link'  => __( 'Link', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'link',
			[
				'label'         => __( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'kata-plus' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition' => [
					'open_type' => 'link'
				]
			]
		);
		$this->add_control(
			'form_title',
			[
				'label'   => __( 'Form Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Contact Us', 'kata-plus' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/email',
				'condition' => [
					'type' => 'icon',
				],
			]
		);

		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_styling_wrapper',
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
				'selectors'        => Kata_Styler::selectors( '.kata-contact-show-wrap' ),
				'condition'        => [
					'type' => 'icon',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_button_icon',
			[
				'label'            => esc_html__( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-toggle .kata-icon' ),
				'condition'        => [
					'type' => 'icon',
				],
			]
		);
		$this->add_control(
			'styler_button_text',
			[
				'label'            => esc_html__( 'Text', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.linktopen span' ),
				'condition'        => [
					'type' => 'txt',
				],
			]
		);
		$this->add_control(
			'styler_form_title',
			[
				'label'            => esc_html__( 'Form Title', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-drop-title h3' ),
			]
		);
		$this->add_control(
			'styler_form_title_wrap',
			[
				'label'            => esc_html__( 'Title Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-drop-title' ),
			]
		);
		$this->add_control(
			'styler_form_wrap',
			[
				'label'            => esc_html__( 'Form Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-toggle form' ),
			]
		);
		$this->add_control(
			'styler_form_label',
			[
				'label'            => esc_html__( 'Form Label', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-toggle label' ),
			]
		);
		$this->add_control(
			'styler_form_input',
			[
				'label'            => esc_html__( 'Form Input', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-toggle input:not([type="submit"])' ),
			]
		);
		$this->add_control(
			'styler_form_area',
			[
				'label'            => esc_html__( 'Form Textarea', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-toggle textarea' ),
			]
		);
		$this->add_control(
			'styler_form_button',
			[
				'label'            => esc_html__( 'Submit Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-contact-toggle input[type="submit"]' ),
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
