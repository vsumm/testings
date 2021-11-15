<?php
/**
 * Image Hover Zoom module config.
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
use Elementor\Utils;

class Kata_Plus_Pro_Image_Hover_Zoom extends Widget_Base {
	public function get_name() {
		return 'kata-plus-image-hover-zoom';
	}

	public function get_title() {
		return esc_html__( 'Image Hover Zoom', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-zoom-in';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'jquery-zoom', 'kata-plus-img-hover-zoom' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-img-hover-zoom' ];
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
			'image',
			[
				'label'   => __( 'Choose Image', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'size', // param_name
			[
				'label'   => esc_html__( 'Size', 'kata-plus' ), // heading
				'type'    => Controls_Manager::SELECT, // type
				'default' => 'full',
				'options' => [
					'thumbnail' => esc_html__( 'Thumbnail', 'kata-plus' ),
					'medium'    => esc_html__( 'Medium', 'kata-plus' ),
					'large'     => esc_html__( 'Large', 'kata-plus' ),
					'full'      => esc_html__( 'Full', 'kata-plus' ),
					'custom'    => esc_html__( 'Custom', 'kata-plus' ),
				],
			]
		);

		$this->add_control(
			'img_size',
			[
				'label'       => esc_html__( 'Image Size', 'kata-plus' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'Enter image size (Example: 200x100 (Width x Height)).', 'kata-plus' ),
				'default'     => [
					'width'  => '',
					'height' => '',
				],
				'condition'   => [ // dependency
					'size' => [ 'custom' ],
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
			'styler_overall',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-image-hover-zoom' ),
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
