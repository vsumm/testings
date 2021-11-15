<?php
/**
 * Courses module config.
 *
 * @teacher  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! class_exists( 'Kata_Plus_Pro_Courses' ) ) {
	class Kata_Plus_Pro_Courses extends Widget_Base {
		public function get_name() {
			return 'kata-plus-course-wrap';
		}

		public function get_title() {
			return esc_html__( 'Courses', 'kata-plus' );
		}

		public function get_icon() {
			return 'kata-widget kata-eicon-courses-courses';
		}

		public function get_categories() {
			return ['kata_plus_elementor_learnpress_course' ];
		}

		public function get_style_depends() {
			return ['kata-plus-owlcarousel', 'kata-plus-owl', 'kata-plus-courses'];
		}

		public function get_script_depends() {
			return ['kata-plus-owlcarousel', 'kata-plus-owl', 'kata-jquery-enllax'];
		}

		protected function register_controls() {
			// Query
			$this->start_controls_section(
				'query_section',
				[
					'label' => esc_html__( 'Query', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);

			$categories = get_terms('course_category');

			$cat_options = [];
			foreach ($categories as $category ) {
				$cat_options[ $category->slug ] = $category->name;
			}
			$this->add_control(
				'query_categories',
				[
					'label'    => __( 'Course Categories', 'kata-plus' ),
					'type'     => Controls_Manager::SELECT2,
					'options'  => $cat_options,
					'default'  => [],
					'multiple' => true,
				]
			);

			$tags = get_terms('course_tag');

			$tag_options = [];
			foreach ( $tags as $tag ) {
				$tag_options[ $tag->slug ] = $tag->name;
			}
			$this->add_control(
				'query_tags',
				[
					'label'    => __( 'Course Tags', 'kata-plus' ),
					'type'     => Controls_Manager::SELECT2,
					'options'  => $tag_options,
					'default'  => [],
					'multiple' => true,
				]
			);
			$this->add_control(
				'query_order_by',
				[
					'label'   => esc_html__( 'Order By', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'date',
					'options' => [
						'date'          => esc_html__( 'Date', 'kata-plus' ),
						'title'         => esc_html__( 'Title', 'kata-plus' ),
						'comment_count' => esc_html__( 'Comment Count', 'kata-plus' ),
						'menu_order'    => esc_html__( 'Menu Order', 'kata-plus' ),
						'rand'          => esc_html__( 'Random', 'kata-plus' ),
					],
				]
			);
			$this->add_control(
				'query_order',
				[
					'label'   => esc_html__( 'Order', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'DESC',
					'options' => [
						'DESC' => esc_html__( 'DESC', 'kata-plus' ),
						'ASC'  => esc_html__( 'ASC', 'kata-plus' ),
					],
				]
			);
			$this->end_controls_section();

			// Courses section
			$this->start_controls_section(
				'courses_section',
				[
					'label' => esc_html__( 'Courses', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_responsive_control(
				'course_columns',
				[
					'label'   => esc_html__( 'Columns Number', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '3',
					'options' => [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
				]
			);
			$this->add_control(
				'course_per_page',
				[
					'label'   => __( 'Courses Per Page', 'kata-plus' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'step'    => 1,
					'default' => 10,
				]
			);
			$this->add_control(
				'course_thumbnail_float',
				[
					'label'   => esc_html__('Thumbnail float', 'kata-plus'),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' => __( 'None', 'Kata-plus' ),
						'left' => __('Left', 'Kata-plus'),
						'right' => __( 'Right', 'Kata-plus' ),
					],
				]
			);
			$this->add_control(
				'course_pagination',
				[
					'label'     => esc_html__( 'Pagination', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'enable_carousel',
				[
					'label'     => __( 'Enable Carousel', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'kata-plus' ),
					'label_off' => __( 'No', 'kata-plus' ),
					'default'   => '',
				]
			);
			$this->end_controls_section();

			// courses Metadata section
			$this->start_controls_section(
				'courses_metadata_section',
				[
					'label' => esc_html__( 'Course Components', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'course_repeater_select',
				[
					'label'     => esc_html__( 'Component', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'title',
					'options'   => [
						'title'				=> esc_html__( 'Title', 'kata-plus' ),
						'thumbnail'			=> esc_html__( 'Thumbnail', 'kata-plus' ),
						'excerpt'			=> esc_html__( 'Excerpt', 'kata-plus' ),
						'categories'		=> esc_html__( 'Categories', 'kata-plus' ),
						'tags'				=> esc_html__( 'Tags', 'kata-plus' ),
						'date'				=> esc_html__( 'Date', 'kata-plus' ),
						'teacher'			=> esc_html__( 'Teacher', 'kata-plus' ),
						'price'				=> esc_html__( 'Price', 'kata-plus'),
					],
				]
			);
			$repeater->add_control(
				'courses_title_tag',
				[
					'label'     => esc_html__( 'Course Title Tag', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default'   => 'h3',
					'condition' => [
						'course_repeater_select' => 'title',
					],
				]
			);
			$repeater->add_control(
				'thumbnail_size',
				[
					'label'     => esc_html__( 'Thumbnail Size', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'full',
					'options'   => [
						'full'   => esc_html__( 'Full', 'kata-plus' ),
						'custom' => esc_html__( 'Custom', 'kata-plus' ),
					],
					'condition' => [
						'course_repeater_select' => 'thumbnail',
					],
				]
			);
			$repeater->add_control(
				'courses_thumbnail_custom_size',
				[
					'label'       => __( 'Course Thumbnail Custom Size', 'kata-plus' ),
					'description' => __( 'Crop the original image size to any custom size.', 'kata-plus' ),
					'type'        => Controls_Manager::IMAGE_DIMENSIONS,
					'default'     => [
						'width'  => '',
						'height' => '',
					],
					'condition'   => [
						'course_repeater_select' => 'thumbnail',
						'thumbnail_size' => 'custom',
					],
				]
			);
			$repeater->add_control(
				'excerpt_length',
				[
					'label'     => __( 'Course Excerpt Length', 'kata-plus' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'' => [
							'min'  => 1,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'   => [
						'unit' => '',
						'size' => 25,
					],
					'condition' => [
						'course_repeater_select' => 'excerpt',
					],
				]
			);
			$repeater->add_control(
				'course_category_icon',
				[
					'label'     => esc_html__( 'Category Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'course_repeater_select' => 'categories',
					],
				]
			);
			$repeater->add_control(
				'course_tag_icon',
				[
					'label'     => esc_html__( 'Tag Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/tag',
					'condition' => [
						'course_repeater_select' => 'tags',
					],
				]
			);
			$repeater->add_control(
				'course_date_icon',
				[
					'label'     => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'course_repeater_select' => 'date',
					],
				]
			);
			$repeater->add_control(
				'course_price_icon',
				[
					'label'     => esc_html__( 'Price Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/money',
					'condition' => [
						'course_repeater_select' => 'price',
					],
				]
			);
			$repeater->add_control(
				'terms_seperator',
				[
					'label'			=> __( 'Category Separator', 'kata-plus' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> ',',
					'condition' => [
						'course_repeater_select' => 'categories',
						'course_repeater_select' => 'tags',
					],
				]
			);
			$repeater->add_control(
				'course_teacher_symbol',
				[
					'label'     => esc_html__('Teacher Symbol', 'kata-plus'),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'icon',
					'options'   => [
						'icon'  => esc_html__('Icon', 'kata-plus'),
						'avatar' => esc_html__('Avatar', 'kata-plus'),
					],
					'condition' => [
						'course_repeater_select' => 'teacher',
					],
				]
			);
			$repeater->add_control(
				'avatar_size',
				[
					'label'		=> __('Avatar Size', 'kata-plus'),
					'type'		=> Controls_Manager::NUMBER,
					'min'		=> 5,
					'max'		=> 300,
					'step'		=> 1,
					'default'	=> 20,
					'condition' => [
						'course_repeater_select' => 'teacher',
						'course_teacher_symbol' => 'avatar',
					],
				]
			);
			$repeater->add_control(
				'course_teacher_icon',
				[
					'label'     => esc_html__('Teacher Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/user',
					'condition' => [
						'course_repeater_select' => 'teacher',
						'course_teacher_symbol'	=> 'icon',
					],
				]
			);
			$repeater->add_control(
				'start_mete_wrapper',
				[
					'label'        => __('Start Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'course_repeater_select' =>[
							'categories',
							'tags',
							'date',
							'price',
							'teacher',
						],
					],
				]
			);
			$repeater->add_control(
				'end_mete_wrapper',
				[
					'label'        => __('End Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'course_repeater_select' => [
							'categories',
							'tags',
							'date',
							'price',
							'teacher',
						],
					],
				]
			);
			$this->add_control(
				'course_repeaters',
				[
					'label'       => __('Component Wrapper', 'kata-plus'),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'title_field' => '{{{ course_repeater_select }}}',
					'default'     => [
						[
							'course_repeater_select' => 'thumbnail',
						],
						[
							'course_repeater_select' => 'title',
						],
						[
							'course_repeater_select' => 'excerpt',
						],
						[
							'course_repeater_select' => 'categories',
						],
						[
							'course_repeater_select' => 'tags',
						],
						[
							'course_repeater_select' => 'date',
						],
						[
							'course_repeater_select' => 'teacher',
						],
						[
							'course_repeater_select' => 'price',
						],
					],
					'condition' => [
						'course_thumbnail_float' => 'none',
					],
				]
			);
			$repeater2 = new Repeater();
			$repeater2->add_control(
				'course_repeater_select_2',
				[
					'label'     => esc_html__('Component', 'kata-plus'),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'title',
					'options'   => [
						'title'				=> esc_html__('Title', 'kata-plus'),
						'excerpt'			=> esc_html__('Excerpt', 'kata-plus'),
						'categories'		=> esc_html__('Categories', 'kata-plus'),
						'tags'				=> esc_html__('Tags', 'kata-plus'),
						'date'				=> esc_html__('Date', 'kata-plus'),
						'teacher'			=> esc_html__('Teacher', 'kata-plus'),
						'price'				=> esc_html__('Price', 'kata-plus'),
					],
				]
			);
			$repeater2->add_control(
				'courses_title_tag',
				[
					'label'     => esc_html__('Course Title Tag', 'kata-plus'),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default'   => 'h3',
					'condition' => [
						'course_repeater_select_2' => 'title',
					],
				]
			);
			$repeater2->add_control(
				'excerpt_length',
				[
					'label'     => __('Course Excerpt Length', 'kata-plus'),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'' => [
							'min'  => 1,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'   => [
						'unit' => '',
						'size' => 25,
					],
					'condition' => [
						'course_repeater_select_2' => 'sexcerpt',
					],
				]
			);
			$repeater2->add_control(
				'course_category_icon',
				[
					'label'     => esc_html__('Category Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'course_repeater_select_2' => 'categories',
					],
				]
			);
			$repeater2->add_control(
				'course_tag_icon',
				[
					'label'     => esc_html__('Tag Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/tag',
					'condition' => [
						'course_repeater_select_2' => 'tags',
					],
				]
			);
			$repeater2->add_control(
				'course_date_icon',
				[
					'label'     => esc_html__('Date Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'course_repeater_select_2' => 'date',
					],
				]
			);
			$repeater2->add_control(
				'course_price_icon',
				[
					'label'     => esc_html__('Price Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/money',
					'condition' => [
						'course_repeater_select_2' => 'price',
					],
				]
			);
			$repeater2->add_control(
				'terms_seperator',
				[
					'label'			=> __('Category Separator', 'kata-plus'),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> ',',
					'condition' => [
						'course_repeater_select_2' => 'categories',
						'course_repeater_select_2' => 'tags',
					],
				]
			);
			$repeater2->add_control(
				'course_teacher_symbol',
				[
					'label'     => esc_html__('Teacher Symbol', 'kata-plus'),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'icon',
					'options'   => [
						'icon'  => esc_html__('Icon', 'kata-plus'),
						'avatar' => esc_html__('Avatar', 'kata-plus'),
					],
					'condition' => [
						'course_repeater_select_2' => 'teacher',
					],
				]
			);
			$repeater2->add_control(
				'avatar_size',
				[
					'label'		=> __('Avatar Size', 'kata-plus'),
					'type'		=> Controls_Manager::NUMBER,
					'min'		=> 5,
					'max'		=> 300,
					'step'		=> 1,
					'default'	=> 20,
					'condition' => [
						'course_repeater_select_2' => 'teacher',
						'course_teacher_symbol' => 'avatar',
					],
				]
			);
			$repeater2->add_control(
				'course_teacher_icon',
				[
					'label'     => esc_html__('Teacher Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/user',
					'condition' => [
						'course_repeater_select_2' => 'teacher',
						'course_teacher_symbol'	=> 'icon',
					],
				]
			);
			$repeater2->add_control(
				'start_mete_wrapper',
				[
					'label'        => __('Start Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'course_repeater_select' =>[
							'categories',
							'tags',
							'date',
							'price',
							'teacher',
						],
					],
				]
			);
			$repeater2->add_control(
				'end_mete_wrapper',
				[
					'label'        => __('End Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'course_repeater_select' => [
							'categories',
							'tags',
							'date',
							'price',
							'teacher',
						],
					],
				]
			);
			$this->add_control(
				'course_repeaters_2',
				[
					'label'       => __( 'Component Wrapper', 'kata-plus' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater2->get_controls(),
					'title_field' => '{{{ course_repeater_select_2 }}}',
					'default'     => [
						[
							'course_repeater_select_2' => 'title',
						],
						[
							'course_repeater_select_2' => 'excerpt',
						],
						[
							'course_repeater_select_2' => 'categories',
						],
						[
							'course_repeater_select_2' => 'tags',
						],
						[
							'course_repeater_select_2' => 'date',
						],
						[
							'course_repeater_select_2' => 'teacher',
						],
						[
							'course_repeater_select_2' => 'price',
						],
					],
					'condition' => [
						'course_thumbnail_float' => [
							'left',
							'right',
						],
					],
				]
			);
			$this->end_controls_section();

			// owl option
			$this->start_controls_section(
				'content_section',
				[
					'label'     => esc_html__( 'Carousel Settings', 'kata-plus' ),
					'condition' => [
						'enable_carousel' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'inc_owl_item',
				[
					'label'       => __( 'Items Per View', 'kata-plus' ),
					'type'        => Controls_Manager::NUMBER,
					'min'         => 1,
					'max'         => 5,
					'step'        => 1,
					'default'     => 3,
					'devices'     => [ 'desktop', 'tablet', 'mobile' ],
					'description' => __( 'Varies between 1/5', 'kata-plus' ),
				]
			);
			$this->add_control(
				'inc_owl_spd',
				[
					'label'       => __( 'Slide Speed', 'kata-plus' ),
					'description' => __( 'Varies between 500/6000', 'kata-plus' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 500,
							'max'  => 6000,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 5000,
					],
				]
			);
			$this->add_control(
				'inc_owl_smspd',
				[
					'label'       => __( 'Smart Speed', 'kata-plus' ),
					'description' => __( 'Varies between 500/6000', 'kata-plus' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 500,
							'max'  => 6000,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 1000,
					],
				]
			);
			$this->add_responsive_control(
				'inc_owl_stgpad',
				[
					'label'       => __( 'Stage Padding', 'kata-plus' ),
					'description' => __( 'Varies between 0/400', 'kata-plus' ),
					'devices'     => [ 'desktop', 'tablet', 'mobile' ],
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 0,
					],
				]
			);
			$this->add_responsive_control(
				'inc_owl_margin',
				[
					'label'       => __( 'Margin', 'kata-plus' ),
					'description' => __( 'Varies between 0/400', 'kata-plus' ),
					'devices'     => [ 'desktop', 'tablet', 'mobile' ],
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 20,
					],
				]
			);
			$this->add_control(
				'inc_owl_arrow',
				[
					'label'        => __( 'Prev/Next Arrows', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'kata-plus' ),
					'label_off'    => __( 'Hide', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'no',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_prev',
				[
					'label'     => __( 'Left Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'font-awesome/angle-left',
					'condition' => [
						'inc_owl_arrow' => [
							'true',
						],
					],
				]
			);
			$this->add_control(
				'inc_owl_nxt',
				[
					'label'     => __( 'Right Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'font-awesome/angle-right',
					'condition' => [
						'inc_owl_arrow' => [
							'true',
						],
					],
				]
			);
			$this->add_control(
				'inc_owl_pag',
				[
					'label'        => __( 'Pagination', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'kata-plus' ),
					'label_off'    => __( 'Hide', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'no',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_pag_num',
				[
					'label'     => __( 'Pagination Layout', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'dots'         => __( 'Bullets', 'kata-plus' ),
						'dots-num'     => __( 'Numbers', 'kata-plus' ),
						'dots-and-num' => __( 'Progress bar', 'kata-plus' ),
					],
					'default'   => 'dots',
					'condition' => [
						'inc_owl_pag' => [
							'true',
						],
					],
				]
			);
			$this->add_control(
				'inc_owl_loop',
				[
					'label'        => __( 'Slider loop', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'true',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_autoplay',
				[
					'label'        => __( 'Autoplay', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'true',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_center',
				[
					'label'        => __( 'Center Item', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'no',
					'default'      => 'no',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_rtl',
				[
					'label'        => __( 'RTL', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'inc_owl_vert',
				[
					'label'        => __( 'Vertical Slider', 'kata-plus' ),
					'description'  => __( 'This option works only when "Items Per View" is set to 1.', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'false',
				]
			);
			$this->end_controls_section();

			// courses Style section
			$this->start_controls_section(
				'section_widget_parent',
				[
					'label' => esc_html__( 'Wrapper', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_courses_container',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap' ),
				]
			);
			$this->add_control(
				'styler_widget_stage',
				[
					'label'            => esc_html__( 'Carousel Stage', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-stage-outer' ),
					'condition'        => [
						'enable_carousel' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'courses_style_section',
				[
					'label' => esc_html__( 'Courses Style', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_courses_course',
				[
					'label'            => esc_html__( 'Course', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course' ),
				]
			);
			$this->add_control(
				'styler_course_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-thumbnail-wrapper' ),
				]
			);
			$this->add_control(
				'styler_course_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.kata-plus-course .kata-plus-course-thumbnail-wrapper img' ),
				]
			);
			$this->add_control(
				'styler_course_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-title a' ),
				]
			);
			$this->add_control(
				'styler_course_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-excerpt' ),
				]
			);
			$this->end_controls_section();

			// Courses Pagination Style section
			$this->start_controls_section(
				'courses_pagination_style_section',
				[
					'label' => esc_html__( 'Pagination Style', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_course_pagination_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .kata-plus-course-pagination' ),
				]
			);
			$this->add_control(
				'styler_course_pagination',
				[
					'label'            => esc_html__( 'Pagination', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .kata-plus-course-pagination .page-numbers' ),
				]
			);
			$this->add_control(
				'styler_course_pagination_current',
				[
					'label'            => esc_html__( 'Pagination Current', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .kata-plus-course-pagination .current' ),
				]
			);
			$this->add_control(
				'styler_course_pagination_prev_next',
				[
					'label'            => esc_html__( 'Pagination Previous/Next', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .kata-plus-course-pagination a.next.page-numbers, {{WRAPPER}} .kata-plus-course-wrap .kata-course-pagination a.prev.page-numbers' ),
				]
			);
			$this->end_controls_section();

			// Courses Metadata Style section
			$this->start_controls_section(
				'courses_metadata_style_section',
				[
					'label' => esc_html__( 'Metadata Style', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_categories_wrapper',
				[
					'label'            => esc_html__( 'Categories Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-categories' ),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_categories',
				[
					'label'            => esc_html__( 'Categories', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-categories a' ),
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
				'styler_courses_metadata_course_category_icon',
				[
					'label'            => esc_html__( 'Categories Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-categories i' ),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_tags_wrapper',
				[
					'label'            => esc_html__( 'Tags Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-tags' ),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_tags',
				[
					'label'            => esc_html__( 'Tags', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-tags a' ),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_date_wrapper',
				[
					'label'            => esc_html__( 'Date Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-date' ),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_date',
				[
					'label'            => esc_html__( 'Date', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-date a' ),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_date_icon',
				[
					'label'            => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course .kata-plus-course-date i' ),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_teacher_wrapper',
				[
					'label'            => esc_html__('Teacher Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.kata-plus-course .kata-post-author'),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_teacher',
				[
					'label'            => esc_html__('Teacher Name', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.kata-plus-course .kata-post-author a'),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_teacher_icon',
				[
					'label'            => esc_html__('Teacher Icon', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.kata-plus-course .kata-post-author i'),
				]
			);
			$this->add_control(
				'styler_courses_metadata_course_teacher_avatar',
				[
					'label'            => esc_html__('Teacher Avatar', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.kata-plus-course .kata-post-author .avatar'),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'styler_carousel_settings_section',
				[
					'label'     => esc_html__( 'Carousel', 'kata-plus' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel' => 'yes',
					],
				]
			);
			$this->add_control(
				'styler_item',
				[
					'label'            => __( 'Item', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .owl-item .kata-plus-course' ),
				]
			);
			$this->add_control(
				'styler_arrow_wrapper',
				[
					'label'            => __( 'Slider Arrows Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .owl-nav' ),
				]
			);
			$this->add_control(
				'styler_arrow_left',
				[
					'label'            => __( 'Slider Left Arrow', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .owl-nav .owl-prev i' ),
				]
			);
			$this->add_control(
				'styler_arrow_right',
				[
					'label'            => __( 'Slider Right Arrow', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .owl-nav .owl-next i' ),
				]
			);
			$this->add_control(
				'styler_boolets',
				[
					'label'            => __( 'Bullets Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .owl-dots' ),
				]
			);
			$this->add_control(
				'styler_boolet',
				[
					'label'            => __( 'Bullets', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .owl-dots .owl-dot' ),
				]
			);
			$this->add_control(
				'styler_boolet_active',
				[
					'label'            => __( 'Active Bullet', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-course-wrap .owl-dots .owl-dot.active' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'carousel_active_item_section',
				[
					'label' => esc_html__( 'Carousel Active Item', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel' => 'yes',
					],
				]
			);
			$this->add_control(
				'carousel_active_styler_course',
				[
					'label'            => esc_html__( 'Course', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-course' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_course_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-course .kata-plus-course-thumbnail' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_course_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-course .kata-plus-course-thumbnail img' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_course_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-course .kata-plus-course-title' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_course_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-course .kata-plus-course-excerpt' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'carousel_center_item_section',
				[
					'label' => esc_html__( 'Carousel Center Item', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel'	=> 'yes',
						'inc_owl_center'	=> 'yes',
					],
				]
			);
			$this->add_control(
				'carousel_center_styler_course',
				[
					'label'            => esc_html__( 'Course', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-course' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_course_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-course .kata-plus-course-thumbnail' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_course_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-course .kata-plus-course-thumbnail img' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_course_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-course .kata-plus-course-title' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_course_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-course .kata-plus-course-excerpt' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'section_style_progress_bar',
				[
					'label'     => esc_html__( 'Progress Bar', 'kata-plus' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel' => 'yes',
						'inc_owl_pag_num' => 'dots-and-num',
					],
				]
			);
			$this->add_control(
				'styler_progress_wraper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar' ),
				]
			);
			$this->add_control(
				'styler_progress',
				[
					'label'            => esc_html__( 'Progress Bar', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar .kata-progress-bar-inner' ),
				]
			);
			$this->add_control(
				'styler_progress_min_number',
				[
					'label'            => esc_html__( 'Start Number', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar .minitems' ),
				]
			);
			$this->add_control(
				'styler_progress_max_number',
				[
					'label'            => esc_html__( 'End Number', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar .maxitems' ),
				]
			);
			$this->end_controls_section();

			// Common controls
			apply_filters( 'kata_plus_common_controls', $this );
			// end copy
		}

		protected function render() {
			require dirname( __FILE__ ) . '/view.php';
		}
	} // class
}
