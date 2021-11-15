<?php
/**
 * LearnPress Course Teacher module config.
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
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Course_Teacher extends Widget_Base {
	public function get_name() {
		return 'kata-plus-course-teacher';
	}

	public function get_title() {
		return esc_html__( 'Course Teacher', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-person';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_learnpress_course' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'teacher',
			[
				'label' => esc_html__( 'Teacher', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'post_author_symbol',
			[
				'label'     => esc_html__( 'Teacher Symbol', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'icon',
				'options'   => [
					'icon'  => esc_html__( 'Icon', 'kata-plus' ),
					'avatar' => esc_html__( 'Avatar', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'post_author_icon',
			[
				'label'     => esc_html__( 'Teacher Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/user',
				'condition' => [
					'post_author_symbol'	=> 'icon',
				],
			]
		);
		$this->add_control(
			'avatar_size',
			[
				'label'		=> __( 'Avatar Size', 'kata-plus' ),
				'type'		=> Controls_Manager::NUMBER,
				'min'		=> 5,
				'max'		=> 300,
				'step'		=> 1,
				'default'	=> 20,
				'condition' => [
					'post_author_symbol' => 'avatar',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_lessons_style_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_teacher_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-teacher' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_lessons_style',
			[
				'label' => esc_html__( 'Teacher', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_icon_teacher',
			[
				'label'     => __( 'Teacher Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-post-author .kata-icon' ),
				'condition' => [
					'post_author_symbol' => 'icon'
				],
			]
		);
		$this->add_control(
			'styler_avatar_teacher',
			[
				'label'     => __( 'Teacher Avatar', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-post-author img.avatar' ),
				'condition' => [
					'post_author_symbol' => 'avatar'
				],
			]
		);
		$this->add_control(
			'styler_name_teacher',
			[
				'label'     => __( 'Teacher Name', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-post-author a' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_teacher_socials',
			[
				'label' => esc_html__( 'Social Network', 'kata-plus' ),
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
			'socials_wrapper',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-author-social-network' ),
			]
		);
		$this->add_control(
			'socials_items',
			[
				'label'     => __( 'Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-author-social-network li' ),
			]
		);
		$this->add_control(
			'socials_link',
			[
				'label'     => __( 'Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-author-social-network li a' ),
			]
		);
		$this->add_control(
			'socials_icon',
			[
				'label'     => __( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-author-social-network li .kata-icon' ),
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
