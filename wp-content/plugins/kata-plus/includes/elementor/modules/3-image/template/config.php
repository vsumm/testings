<?php
/**
 * Image module config.
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
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

class Kata_Plus_Image extends Widget_Base {
	public function get_name() {
		return 'kata-plus-image';
	}

	public function get_title() {
		return esc_html__( 'Image', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-image';
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
				'label'   => __( 'Format', 'kata-plus' ),
				'description'   => __( 'Choose image or SVG file format.', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'kata-plus' ),
				'description'   => __( 'Select image size.', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'kata-plus' ),
				'description'   => __( 'Select image alignment.', 'kata-plus' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'kata-plus' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'kata-plus' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'kata-plus' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'caption_source',
			[
				'label'   => __( 'Caption', 'kata-plus' ),
				'description'   => __( 'Set caption or custom caption.', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'       => __( 'None', 'kata-plus' ),
					'attachment' => __( 'Attachment Caption', 'kata-plus' ),
					'custom'     => __( 'Custom Caption', 'kata-plus' ),
				],
				'default' => 'none',
			]
		);
		$this->add_control(
			'caption',
			[
				'label'       => __( 'Custom Caption', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => __( 'Enter your image caption', 'kata-plus' ),
				'condition'   => [
					'caption_source' => 'custom',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'link_to',
			[
				'label'   => __( 'Link to', 'kata-plus' ),
				'description'   => __( 'Link image to the media file as lightbox or set accustomed URL.', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => __( 'None', 'kata-plus' ),
					'file'   => __( 'Media File', 'kata-plus' ),
					'custom' => __( 'Custom URL', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'link',
			[
				'label'       => __( 'Link to', 'kata-plus' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'kata-plus' ),
				'condition'   => [
					'link_to' => 'custom',
				],
				'show_label'  => false,
			]
		);
		$this->add_control(
			'open_lightbox',
			[
				'label'     => __( 'Lightbox', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'yes',
				'options'   => [
					'yes' => __( 'Yes', 'kata-plus' ),
					'no'  => __( 'No', 'kata-plus' ),
				],
				'condition' => [
					'link_to' => 'file',
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
				'selectors'        => Kata_Styler::selectors( '.kata-image' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_svg_styler',
			[
				'label' => __( 'SVG', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'symbol' => 'svg'
				]
			]
		);
		$this->add_control(
			'styler_svg',
			[
				'label'            => __( 'SVG Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-image i' ),
			]
		);
		$this->add_control(
			'styler_svg_tag',
			[
				'label'            => __( 'SVG', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-image svg' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image_styler',
			[
				'label' => __( 'Image', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'symbol' => 'imagei'
				]
			]
		);
		$this->add_control(
			'styler_image_figure',
			[
				'label'            => __( 'Image Figure', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-image figure' ),
			]
		);
		$this->add_control(
			'styler_image',
			[
				'label'            => __( 'Image', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-image img' ),
			]
		);
		$this->add_control(
			'styler_caption',
			[
				'label'            => 'Caption',
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.widget-image-caption' ),
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
