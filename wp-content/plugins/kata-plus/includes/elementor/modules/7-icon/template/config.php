<?php
/**
 * Icon module config.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

class Kata_Plus_Icon extends Widget_Base {

	public function get_name() {
		return 'kata-plus-icon';
	}

	public function get_title() {
		return esc_html__( 'Icon', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-alert';
	}

	public function get_script_depends() {
		return ['kata-jquery-enllax'];
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
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
		$this->add_control(
			'symbol',
			[
				'label'   => __( 'Icon Source', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __( 'Kata Icons', 'kata-plus' ),
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/alarm-clock',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'     => __( 'Choose Image', 'kata-plus' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'symbol' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'symbol' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->add_control(
			'url',
			[
				'label'			=> __( 'Link', 'kata-plus' ),
				'type'			=> Controls_Manager::URL,
				'placeholder'	=> __( 'https://your-link.com', 'kata-plus' ),
				'show_external'	=> true,
				'default'		=> [
					'url'			=> '',
					'is_external'	=> true,
					'nofollow'		=> true,
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_image_wrapper',
			[
				'label'            => __( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-icon' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image_and_image',
			[
				'label' => __( 'Icon & Image', 'kata-plus' ),
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
			'styler_icon',
			[
				'label'            => __( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-icon i' ),
			]
		);
		$this->add_control(
			'styler_svg',
			[
				'label'            => __( 'Uploaded SVG', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-icon i path' ),
			]
		);
		$this->add_control(
			'styler_image',
			[
				'label'            => __( 'Image', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-icon img' ),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	private function has_caption( $settings ) {
		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	private function get_caption( $settings ) {
		$caption = '';
		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['image']['id'] );
					break;
				case 'custom':
					$caption = ! empty( $settings['caption'] ) ? $settings['caption'] : '';
			}
		}
		return $caption;
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}

	private function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}
			return $settings['link'];
		}

		return [
			'url' => $settings['image']['url'],
		];
	}
}
