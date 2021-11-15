<?php
/**
 * Socials module config.
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
use Elementor\Repeater;
class Kata_Plus_Pro_Socials extends Widget_Base {
	public function get_name() {
		return 'kata-plus-socials';
	}

	public function get_title() {
		return esc_html__( 'Socials', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-social-icons';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-socials' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'social_icon',
			[
				'label'   => __( 'Select Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/facebook',
			]
		);
		$repeater->add_control(
			'icon_name',
			[
				'label'   => esc_html__( 'Name', 'kata-plus' ), // heading
				'type'    => Controls_Manager::TEXT, // type
				'default' => __( 'Facebook', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'icon_link',
			[
				'label'       => __( 'Link', 'kata-plus' ),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'is_external' => 'true',
				],
				'placeholder' => __( 'https://your-link.com', 'kata-plus' ),
			]
		);
		$repeater->add_control(
			'r_icon_style',
			[
				'label'     => __( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-icon', '', '{{CURRENT_ITEM}} .social-wrapper' ),
			]
		);
		$repeater->add_control(
			'r_name_style',
			[
				'label'     => __( 'Name', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.social-name', '', '{{CURRENT_ITEM}} .social-wrapper' ),
			]
		);

		// Select Type Section
		$this->add_control(
			'icons', // param_name
			[
				'label'       => esc_html__( 'Icons', 'kata-plus' ), // heading
				'type'        => Controls_Manager::REPEATER, // type
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'social_icon' => 'font-awesome/instagram',
						'icon_name'   => 'Instagram',
						'icon_link'   => [
							'url' => 'https://www.instagram.com/',
						],
					],
					[
						'social_icon' => 'font-awesome/linkedin',
						'icon_name'   => 'Linkedin',
						'icon_link'   => [
							'url' => 'https://www.linkedin.com/',
						],
					],
					[
						'social_icon' => 'font-awesome/facebook',
						'icon_name'   => 'Facebook',
						'icon_link'   => [
							'url' => 'https://www.facebook.com/',
						],
					],
				],
				'title_field' => '{{{ icon_name }}}',
			]
		);

		$this->add_control(
			'display_as',
			[
				'label'        => __( 'Side by side icons', 'kata-plus' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'side',
				'default'      => 'side',
			]
		);

		$this->add_control(
			'name_before_icon',
			[
				'label'        => esc_html__( 'Display name before icon', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'kata-plus' ),
				'label_off'    => esc_html__( 'No', 'kata-plus' ),
				'return_value' => 'on',
				'default'      => 'off',
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
			'styler_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_name',
			[
				'label'     => esc_html__( 'Name', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( 'span','','.kata-social-icon' ),
			]
		);
		$this->add_control(
			'styler_wrapper_link',
			[
				'label'     => esc_html__( 'Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-icon a' ),
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
			'styler_icon',
			[
				'label'     => esc_html__( 'Icons', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-icon','','.kata-social-icon' ),
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
