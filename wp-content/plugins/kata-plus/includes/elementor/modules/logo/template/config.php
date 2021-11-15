<?php
/**
 * Logo module config.
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
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

class Kata_Plus_Logo extends Widget_Base {
	public function get_name() {
		return 'kata-plus-logo';
	}

	public function get_title() {
		return esc_html__( 'Logo', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-logo';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_header' ];
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
			'symbol_default_logo',
			[
				'label'   => __( 'Image/SVG', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'default-logo',
			[
				'label'   => __( 'Default Logo', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Kata_Plus::$assets . 'images/logo.png',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'default-logo', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
			]
		);
		$this->add_control(
			'symbol_transparent_logo',
			[
				'label'   => __( 'Image/SVG', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'transparent-logo',
			[
				'label'   => __( 'Logo for Transparent Header', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'transparent-logo', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'kata-plus' ),
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Advanced Styling', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_image_wrapper',
			[
				'label'     => 'Wrapper',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-logo' ),
			]
		);

		$this->add_control(
			'styler_image',
			[
				'label'     => 'Image',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-logo img' ),
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
