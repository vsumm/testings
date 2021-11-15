<?php
/**
 * LearnPress Course Price module config.
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

class Kata_Plus_Pro_Course_Metadata extends Widget_Base {
	public function get_name() {
		return 'kata-plus-course-metadata';
	}

	public function get_title() {
		return esc_html__( 'Course Metadata', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-date';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_learnpress_course' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'lessons',
			[
				'label' => esc_html__( 'Lessons', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'show_lessons',
			[
				'label'			=> __( 'Show Lessons', 'kata-plus' ),
				'type'			=> Controls_Manager::SWITCHER,
				'label_on'		=> __( 'Show', 'kata-plus' ),
				'label_off'		=> __( 'Hide', 'kata-plus' ),
				'return_value'	=> 'yes',
				'default'		=> 'yes',
			]
		);
		$this->add_control(
			'symbol_lessons',
			[
				'label'   => __('Icon Source', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __('Kata Icons', 'kata-plus'),
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
				'condition' => [
					'show_lessons' => 'yes'
				],
			]
		);
		$this->add_control(
			'course_lessons_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'linea/note-single',
				'condition' => [
					'show_lessons'		=> 'yes',
					'symbol_lessons'	=> [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'course_lessons_image',
			[
				'label'     => __('Choose Image', 'kata-plus'),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'symbol_lessons' => [
						'imagei',
						'svg',
					],
					'show_lessons' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'course_lessons_image',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'show_lessons' => 'yes',
					'symbol_lessons' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'students',
			[
				'label' => esc_html__( 'Students', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'show_students',
			[
				'label'			=> __( 'Show Students', 'kata-plus' ),
				'type'			=> Controls_Manager::SWITCHER,
				'label_on'		=> __( 'Show', 'kata-plus' ),
				'label_off'		=> __( 'Hide', 'kata-plus' ),
				'return_value'	=> 'yes',
				'default'		=> 'yes',
			]
		);
		$this->add_control(
			'symbol_students',
			[
				'label'   => __('Icon Source', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __('Kata Icons', 'kata-plus'),
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
				'condition' => [
					'show_students' => 'yes'
				],
			]
		);
		$this->add_control(
			'course_students_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => '7-stroke/study',
				'condition' => [
					'show_students'		=> 'yes',
					'symbol_students'	=> [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'course_students_image',
			[
				'label'     => __('Choose Image', 'kata-plus'),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'symbol_students' => [
						'imagei',
						'svg',
					],
					'show_students' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'course_students_image',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'show_students' => 'yes',
					'symbol_students' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'duration',
			[
				'label' => esc_html__( 'Duration', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'show_duration',
			[
				'label'			=> __( 'Show duration', 'kata-plus' ),
				'type'			=> Controls_Manager::SWITCHER,
				'label_on'		=> __( 'Show', 'kata-plus' ),
				'label_off'		=> __( 'Hide', 'kata-plus' ),
				'return_value'	=> 'yes',
				'default'		=> 'yes',
			]
		);
		$this->add_control(
			'symbol_duration',
			[
				'label'   => __('Icon Source', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __('Kata Icons', 'kata-plus'),
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
				'condition' => [
					'show_duration' => 'yes'
				],
			]
		);
		$this->add_control(
			'course_duration_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/alarm-clock',
				'condition' => [
					'show_duration'		=> 'yes',
					'symbol_duration'	=> [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'course_duration_image',
			[
				'label'     => __('Choose Image', 'kata-plus'),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'symbol_duration' => [
						'imagei',
						'svg',
					],
					'show_duration' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'course_duration_image',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'show_duration' => 'yes',
					'symbol_duration' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_lessons_style',
			[
				'label' => esc_html__( 'Lessons', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_lessons_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.max-lessons-wrapper' ),
			]
		);
		$this->add_control(
			'styler_icon_lesson_wrapper',
			[
				'label'     => __( 'Icon Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-lesson-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_lesson_icon',
			[
				'label'     => __( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-lesson-icon-wrap .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_lesson_content',
			[
				'label'     => __( 'Content', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.max-lesson' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_students_style',
			[
				'label' => esc_html__( 'Students', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_student_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.max-students-wrapper' ),
			]
		);
		$this->add_control(
			'styler_icon_student_wrapper',
			[
				'label'     => __( 'Icon Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-students-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_student_icon',
			[
				'label'     => __( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-students-icon-wrap .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_student_content',
			[
				'label'     => __( 'Content', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.max-students' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_duration_style',
			[
				'label' => esc_html__( 'Duration', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_duration_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.max-duration-wrapper' ),
			]
		);
		$this->add_control(
			'styler_icon_duration_wrapper',
			[
				'label'     => __( 'Icon Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-duration-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_duration_icon',
			[
				'label'     => __( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-course-duration-icon-wrap .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_duration_content',
			[
				'label'     => __( 'Content', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.max-duration' ),
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
