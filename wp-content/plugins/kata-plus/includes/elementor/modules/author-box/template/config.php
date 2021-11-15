<?php
/**
 * Author Box module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Kata_Plus_Author_Box extends Widget_Base {
	public function get_name() {
		return 'kata-plus-author-box';
	}

	public function get_title() {
		return esc_html__( 'Author Box', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_blog_and_post' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-author-page' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
			]
		);
		$this->add_control(
			'show_avatar',
			[
				'label'        => __( 'Show Avatar', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'avatar_size',
			[
				'label'      => __( 'Avatar Size', 'kata-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 70,
				],
				'condition'  => [
					'show_avatar' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'show_description',
			[
				'label'        => __( 'Show Description', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'author_link_content',
			[
				'label'         => __( 'Link Content', 'kata-plus' ),
				'type'          => Controls_Manager::TEXT,
				'show_external' => true,
			]
		);
		$this->add_control(
			'author_link',
			[
				'label'         => __( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://yourwebsite.com', 'kata-plus' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styles_section_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-author-box' ),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'styles_section',
			[
				'label' => esc_html__( 'Styles', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_avatar_wrapper',
			[
				'label'     => esc_html__( 'Avatar Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-author-thumbnail' ),
			]
		);
		$this->add_control(
			'styler_avatar',
			[
				'label'     => esc_html__( 'Avatar', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-author-thumbnail img' ),
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'     => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-author-content' ),
			]
		);
		$this->add_control(
			'styler_name',
			[
				'label'     => esc_html__( 'Name', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-author-name' ),
			]
		);
		$this->add_control(
			'styler_description',
			[
				'label'     => esc_html__( 'Bio', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-author-box-description' ),
			]
		);
		$this->add_control(
			'styler_link',
			[
				'label'     => esc_html__( 'link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.author-link' ),
				'condition' => [
					'author_link_content!' => ''
				]
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
