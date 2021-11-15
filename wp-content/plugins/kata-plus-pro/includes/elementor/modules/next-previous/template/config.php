<?php
/**
 * Post Next/Previous module config.
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

class Kata_Plus_Pro_Next_Previous extends Widget_Base {
	public function get_name() {
		return 'kata-plus-next-previous-post';
	}

	public function get_title() {
		return esc_html__( 'Next & Next Post', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-post-navigation';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_blog_and_post' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-next-previous-post' ];
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
			'show_thumbnail',
			[
				'label'     => esc_html__('Thumbnail', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
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
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);
		$this->add_control(
			'next_post_label',
			[
				'label'   => __('Next Post Label', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Next Post', 'kata-plus'),
			]
		);
		$this->add_control(
			'prev_post_label',
			[
				'label'   => __('Previous Post Label', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Previous Post', 'kata-plus'),
			]
		);
		$this->add_control(
			'next_icon',
			[
				'label'     => esc_html__( 'Next Post Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/angle-double-right',
			]
		);
		$this->add_control(
			'previous_icon',
			[
				'label'     => esc_html__( 'Previous Post Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/angle-double-left',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_styles_section',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'next_prev_post_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-next-previous-post' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'next_post_section',
			[
				'label' => esc_html__( 'Next Post', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'next_post_wrapper',
			[
				'label'     => esc_html__( 'Next Post Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.next-post' ),
			]
		);
		$this->add_control(
			'next_post_thumbnail_wrapper',
			[
				'label'     => esc_html__( 'Next Post Thumbnail Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.next-post .next-post-thumbnail-wrapper' ),
			]
		);
		$this->add_control(
			'next_post_thumbnail',
			[
				'label'     => esc_html__('Next Post Thumbnail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.next-post .next-post-thumbnail-wrapper img' ),
			]
		);
		$this->add_control(
			'next_post_content_wrapper',
			[
				'label'     => esc_html__( 'Next Post Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.next-post .next-post-content-wrapper' ),
			]
		);
		$this->add_control(
			'next_post_text_label',
			[
				'label'     => esc_html__( 'Next Post Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.next-post .next-post-label' ),
			]
		);
		$this->add_control(
			'next_post_title',
			[
				'label'     => esc_html__( 'Next Post Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.next-post .next-post-title' ),
			]
		);
		$this->add_control(
			'next_post_title_link',
			[
				'label'     => esc_html__( 'Next Post Title Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.next-post .next-post-title a' ),
			]
		);
		$this->add_control(
			'next_post_icon',
			[
				'label'     => esc_html__( 'Next Post Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.next-post .kata-icon' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'previous_post_section',
			[
				'label' => esc_html__( 'Previous Post', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'previous_post_wrapper',
			[
				'label'     => esc_html__( 'Previous Post Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.previous-post' ),
			]
		);
		$this->add_control(
			'previous_post_thumbnail_wrapper',
			[
				'label'     => esc_html__('Previous Post Thumbnail Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.previous-post .prev-post-thumbnail-wrapper'),
			]
		);
		$this->add_control(
			'previous_post_thumbnail',
			[
				'label'     => esc_html__('Previous Post Thumbnail', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.previous-post .prev-post-thumbnail-wrapper img'),
			]
		);
		$this->add_control(
			'previous_post_content_wrapper',
			[
				'label'     => esc_html__('Previous Post Content Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.previous-post .prev-post-content-wrapper'),
			]
		);
		$this->add_control(
			'previous_post_text_label',
			[
				'label'     => esc_html__('Previous Post Label', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.previous-post .prev-post-label'),
			]
		);
		$this->add_control(
			'previous_post_title',
			[
				'label'     => esc_html__( 'Previous Post Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.previous-post .prev-post-title' ),
			]
		);
		$this->add_control(
			'previous_post_title_link',
			[
				'label'     => esc_html__( 'Previous Post Title Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.previous-post .prev-post-title a' ),
			]
		);
		$this->add_control(
			'previous_post_icon',
			[
				'label'     => esc_html__( 'Previous Post Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.previous-post .kata-icon' ),
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
