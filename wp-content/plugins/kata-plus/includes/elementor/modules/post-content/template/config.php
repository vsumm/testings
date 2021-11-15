<?php
/**
 * Post Content module config.
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

class Kata_Plus_Post_Content extends Widget_Base {
	public function get_name() {
		return 'kata-plus-post-content';
	}

	public function get_title() {
		return esc_html__( 'Post Content', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-post-content';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_blog_and_post' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-post-content' ];
	}

	protected function register_controls() {
		// Style section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-post-content' ),
			]
		);
		$this->add_control(
			'styler_h1',
			[
				'label'     => esc_html__( 'h1 tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container h1' ),
			]
		);
		$this->add_control(
			'styler_h2',
			[
				'label'     => esc_html__( 'h2 tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container h2' ),
			]
		);
		$this->add_control(
			'styler_h3',
			[
				'label'     => esc_html__( 'h3 tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container h3' ),
			]
		);
		$this->add_control(
			'styler_h4',
			[
				'label'     => esc_html__( 'h4 tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container h4' ),
			]
		);
		$this->add_control(
			'styler_h5',
			[
				'label'     => esc_html__( 'h5 tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container h5' ),
			]
		);
		$this->add_control(
			'styler_h6',
			[
				'label'     => esc_html__( 'h6 tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container h6' ),
			]
		);
		$this->add_control(
			'styler_p',
			[
				'label'     => esc_html__( 'p tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container p' ),
			]
		);
		$this->add_control(
			'styler_ul',
			[
				'label'     => esc_html__( 'ul tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container ul' ),
			]
		);
		$this->add_control(
			'styler_ol',
			[
				'label'     => esc_html__( 'ol tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container ol' ),
			]
		);
		$this->add_control(
			'styler_li',
			[
				'label'     => esc_html__( 'li tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container li' ),
			]
		);
		$this->add_control(
			'styler_blockquote',
			[
				'label'     => esc_html__( 'blockquote tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container blockquote' ),
			]
		);
		$this->add_control(
			'styler_blockquote_cite',
			[
				'label'     => esc_html__( 'blockquote cite tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container blockquote cite' ),
			]
		);
		$this->add_control(
			'styler_cite',
			[
				'label'     => esc_html__( 'cite tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container cite' ),
			]
		);
		$this->add_control(
			'styler_a',
			[
				'label'     => esc_html__( 'a tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container a' ),
			]
		);
		$this->add_control(
			'styler_image',
			[
				'label'     => esc_html__( 'img tag', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.elementor-widget-container img' ),
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
