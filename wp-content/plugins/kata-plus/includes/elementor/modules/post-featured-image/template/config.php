<?php
/**
 * Post Featured Image module config.
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

class Kata_Plus_Post_Featured_Image extends Widget_Base {
	public function get_name() {
		return 'kata-plus-post-featured-image';
	}

	public function get_title() {
		return esc_html__( 'Post Featured Image', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-featured-image';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_blog_and_post' ];
	}

	protected function register_controls() {
		// Styles section
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'thumbnail_dimension',
			[
				'label'			=> __( 'Image Dimension', 'plugin-domain' ),
				'type'			=> Controls_Manager::IMAGE_DIMENSIONS,
				'description'	=> __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'plugin-name' ),
				'default'		=> [
					'width' => '',
					'height' => '',
				],
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
			'styler_post_featured_image',
			[
				'label'     => esc_html__( 'Post Featured Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-single-post-featured-image' ),
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
