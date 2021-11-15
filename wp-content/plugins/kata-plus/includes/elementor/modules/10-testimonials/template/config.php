<?php

/**
 * Testimonials module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Testimonials extends Widget_Base {

	public function get_name() {
		return 'kata-plus-testimonials';
	}

	public function get_title() {
		return esc_html__('Testimonials', 'kata-plus');
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-testimonial-carousel';
	}

	public function get_categories() {
		return ['kata_plus_elementor_most_usefull'];
	}

	public function get_script_depends() {
		return ['kata-plus-owlcarousel', 'kata-plus-owl', 'kata-jquery-enllax'];
	}

	public function get_style_depends() {
		return ['kata-plus-owlcarousel', 'kata-plus-owl', 'kata-plus-testimonials'];
	}

	protected function register_controls()
	{
		$args        = array(
			'orderby'     => 'date',
			'order'       => 'DESC',
			'post_type'   => 'kata_testimonial',
			'post_status' => 'publish',
		);
		$posts_array = get_posts($args);
		if (!empty($posts_array)) {
			$post_names = $post_ids = array('');
			foreach ($posts_array as $post_array) {
				$post_names[] = $post_array->post_title;
				$post_ids[]   = $post_array->ID;
			}
			$posts_array = array_combine($post_ids, $post_names);
		} else {
			$posts_array = array();
		}
		$this->start_controls_section(
			'content_tes',
			[
				'label' => esc_html__('Content', 'kata-plus'),
			]
		);
		$this->add_control(
			'testp_source',
			[
				'label'        => __('Read from testimonial post type', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'posts_array',
			[
				'label'     => esc_html__('Select Posts', 'kata-plus'),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => true,
				'options'   => $posts_array,
				'condition' => [
					'testp_source' => ['yes'],
				],
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'inc_owl_img',
			[
				'label' => __('Choose Image', 'kata-plus'),
				'type'  => Controls_Manager::MEDIA,
			]
		);
		$repeater->add_control(
			'rate',
			[
				'label'   => __('Rate', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'			=> __('None', 'kata-plus'),
					'one'			=> __('1 Star', 'kata-plus'),
					'one_half'		=> __('1.5 Star', 'kata-plus'),
					'two'			=> __('2 Star', 'kata-plus'),
					'two_half'		=> __('2.5 Star', 'kata-plus'),
					'three'			=> __('3 Star', 'kata-plus'),
					'three_half'	=> __('3.5 Star', 'kata-plus'),
					'four'			=> __('4 Star', 'kata-plus'),
					'four_half'		=> __('4.5 Star', 'kata-plus'),
					'five'			=> __('5 Star', 'kata-plus'),
				],
			]
		);
		$repeater->add_control(
			'symbol',
			[
				'label'   => __('Icon Source', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __('Kata Icons', 'kata-plus'),
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
			]
		);
		$repeater->add_control(
			'inc_owl_icon',
			[
				'label'   => __('Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/quote-left',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$repeater->add_control(
			'inc_owl_image',
			[
				'label'     => __('Choose Image', 'kata-plus'),
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
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'inc_owl_image',
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
		$repeater->add_control(
			'inc_owl_name',
			[
				'label'   => __('Name', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Jane Smith', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'inc_owl_pos',
			[
				'label'   => __('Position', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('CEO', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'inc_owl_cnt',
			[
				'label'   => __('Content', 'kata-plus'),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 10,
				'default' => __('would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'inc_owl_date',
			[
				'label'       => __('Date', 'kata-plus'),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => '',
				'placeholder' => __('February 19, 2018', 'kata-plus'),
			]
		);
		$repeater->add_control(
			'show_time',
			[
				'label'        => __('Show The Time', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$repeater->add_control(
			'inc_owl_shape',
			[
				'label'     => __('Shape', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('{{CURRENT_ITEM}} .kata-plus-shape'),
			]
		);
		$repeater->add_control(
			'inc_owl_html',
			[
				'label'    => __('Custom HTML', 'kata-plus'),
				'type'     => Controls_Manager::CODE,
				'language' => 'html',
				'rows'     => 20,
			]
		);
		$this->add_control(
			'testimonials',
			[
				'label'       => __('Testimonials', 'kata-plus'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'inc_owl_icon' => __('font-awesome/quote-left', 'kata-plus'),
						'inc_owl_name' => __('Emily Parker', 'kata-plus'),
						'inc_owl_pos'  => __('Company CEO', 'kata-plus'),
						'inc_owl_cnt'  => __('would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus'),
					],
					[
						'inc_owl_icon' => __('font-awesome/quote-left', 'kata-plus'),
						'inc_owl_name' => __('Mary Taylor', 'kata-plus'),
						'inc_owl_pos'  => __('Company CEO', 'kata-plus'),
						'inc_owl_cnt'  => __('would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus'),
					],
					[
						'inc_owl_icon' => __('font-awesome/quote-left', 'kata-plus'),
						'inc_owl_name' => __('Eric Walker', 'kata-plus'),
						'inc_owl_pos'  => __('Company CEO', 'kata-plus'),
						'inc_owl_cnt'  => __('would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus'),
					],
					[
						'inc_owl_icon' => __('font-awesome/quote-left', 'kata-plus'),
						'inc_owl_name' => __('Emily Parker', 'kata-plus'),
						'inc_owl_pos'  => __('Company CEO', 'kata-plus'),
						'inc_owl_cnt'  => __('would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus'),
					],

				],
				'title_field' => '{{{ inc_owl_name }}} {{{ inc_owl_pos }}}',
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);

		$this->end_controls_section();

		// Shape option
		$this->start_controls_section(
			'shape_section',
			[
				'label' => esc_html__('Shape', 'kata-plus'),
			]
		);

		$repeater2 = new Repeater();
		$repeater2->add_control(
			'pttest_shape',
			[
				'label'     => __('Shape', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('{{CURRENT_ITEM}} .kata-plus-shape'),
			]
		);
		$this->add_control(
			'pttesti',
			[
				'label'     => __('Custom Shape', 'kata-plus'),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeater2->get_controls(),
				'condition' => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->end_controls_section();

		// owl option
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Carousel Settings', 'kata-plus'),
			]
		);
		$this->add_responsive_control(
			'inc_owl_item',
			[
				'label'       => __('Visible Items', 'kata-plus'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 5,
				'step'        => 1,
				'default'     => 3,
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'description' => __('Varies between 1/5', 'kata-plus'),
			]
		);
		$this->add_control(
			'inc_owl_item_tab_landescape',
			[
				'label'       => __('Number of items between <br> Desktop and Tablet', 'kata-plus'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 12,
				'step'        => 1,
				'description' => __('Varies between 1/12', 'kata-plus'),
			]
		);
		$this->add_control(
			'inc_owl_spd',
			[
				'label'       => __('Slide Speed', 'kata-plus'),
				'description' => __('Varies between 500/6000', 'kata-plus'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
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
				'label'       => __('Smart Speed', 'kata-plus'),
				'description' => __('Varies between 500/6000', 'kata-plus'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
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
				'label'       => __('Stage Padding', 'kata-plus'),
				'description' => __('Varies between 0/400', 'kata-plus'),
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
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
				'label'       => __('Margin', 'kata-plus'),
				'description' => __('Varies between 0/400', 'kata-plus'),
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px'],
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
				'label'        => __('Prev/Next Arrows', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => ['desktop', 'tablet', 'mobile'],
			]
		);
		$this->add_control(
			'inc_owl_prev',
			[
				'label'     => __('Left Icon', 'kata-plus'),
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
				'label'     => __('Right Icon', 'kata-plus'),
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
				'label'        => __('Pagination', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => ['desktop', 'tablet', 'mobile'],
			]
		);
		$this->add_control(
			'inc_owl_pag_num',
			[
				'label'     => __('Pagination Layout', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dots'         => __('Bullets', 'kata-plus'),
					'dots-num'     => __('Numbers', 'kata-plus'),
					'dots-and-num' => __('Progress bar', 'kata-plus'),
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
				'label'        => __('Slider loop', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'true',
				'devices'      => ['desktop', 'tablet', 'mobile'],
			]
		);
		$this->add_control(
			'inc_owl_autoplay',
			[
				'label'        => __('Autoplay', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'true',
				'devices'      => ['desktop', 'tablet', 'mobile'],
			]
		);
		$this->add_control(
			'inc_owl_center',
			[
				'label'        => __('Center Item', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => ['desktop', 'tablet', 'mobile'],
			]
		);
		$this->add_control(
			'inc_owl_rtl',
			[
				'label'        => __('RTL', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'inc_owl_vert',
			[
				'label'        => __('Vertical Slider', 'kata-plus'),
				'description'  => __('This option works only when "Items Per View" is set to 1.', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'false',
			]
		);
		$this->end_controls_section();

		// Styles
		$this->start_controls_section(
			'widget_style_parent',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'     => __('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials'),
			]
		);
		$this->add_control(
			'styler_widget_stage',
			[
				'label'     => esc_html__('Carousel Stage', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.owl-stage-outer'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'testimonials_style',
			[
				'label' => esc_html__('Items Per View', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'     => __('Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-testimonial'),
			]
		);
		$this->add_control(
			'styler_thumbnail_wrapper',
			[
				'label'     => __('Image/Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-img-wrap'),
			]
		);
		$this->add_control(
			'styler_icon_image_wrapper',
			[
				'label'     => __('Image Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-img'),
			]
		);
		$this->add_control(
			'styler_icon_image',
			[
				'label'     => __('Image', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-img img'),
			]
		);
		$this->add_control(
			'styler_icon_wrapper',
			[
				'label'     => __('Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-icon'),
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
				'label'     => __('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-icon .kata-icon'),
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'     => __('Content Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-testimonial-content'),
			]
		);
		$this->add_control(
			'styler_name_pos_wrap',
			[
				'label'     => __('Name & Position Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .name-pos-wrap'),
			]
		);
		$this->add_control(
			'styler_name',
			[
				'label'     => __('Name', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-name-wrap'),
			]
		);
		$this->add_control(
			'styler_pos',
			[
				'label'     => __('Position', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-pos'),
			]
		);
		$this->add_control(
			'styler_cnt',
			[
				'label'     => __('Content', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-cnt'),
			]
		);
		$this->add_control(
			'styler_date',
			[
				'label'     => __('Date', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kata-plus-date'),
			]
		);
		$this->add_control(
			'styler_stars_wrapper',
			[
				'label'     => __('Stars Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kt-ts-stars-wrapper'),
			]
		);
		$this->add_control(
			'styler_stars',
			[
				'label'     => __('Stars', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kt-ts-stars-wrapper .kt-ts-star'),
			]
		);
		$this->add_control(
			'styler_full_star',
			[
				'label'     => __('Full Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kt-ts-stars-wrapper .kt-ts-star.kt-star-full'),
			]
		);
		$this->add_control(
			'styler_half_star',
			[
				'label'     => __('Half Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kt-ts-stars-wrapper .kt-ts-star.kt-ts-star-half'),
			]
		);
		$this->add_control(
			'styler_empty_star',
			[
				'label'     => __('Empty Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .kt-ts-stars-wrapper .kt-ts-star-empty'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'active_testimonials_style',
			[
				'label' => esc_html__('Active Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'active_styler_item',
			[
				'label'     => __('Active Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-testimonial'),
			]
		);
		$this->add_control(
			'active_styler_thumbnail_wrapper',
			[
				'label'     => __('Image/Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-img-wrap'),
			]
		);
		$this->add_control(
			'active_styler_icon_image_wrapper',
			[
				'label'     => __('Image Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-img'),
			]
		);
		$this->add_control(
			'active_styler_icon_image',
			[
				'label'     => __('Image', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-img img'),
			]
		);
		$this->add_control(
			'active_styler_icon_wrapper',
			[
				'label'     => __('Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-icon'),
			]
		);
		$this->add_control(
			'icon_style_error_2',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'active_styler_icon',
			[
				'label'     => __('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-icon .kata-icon'),
			]
		);
		$this->add_control(
			'active_styler_content_wrapper',
			[
				'label'     => __('Content Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-testimonial-content'),
			]
		);
		$this->add_control(
			'active_styler_name',
			[
				'label'     => __('Name', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-name-wrap'),
			]
		);
		$this->add_control(
			'active_styler_pos',
			[
				'label'     => __('Position', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-pos'),
			]
		);
		$this->add_control(
			'active_styler_cnt',
			[
				'label'     => __('Content', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-cnt'),
			]
		);
		$this->add_control(
			'active_styler_date',
			[
				'label'     => __('Date', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kata-plus-date'),
			]
		);
		$this->add_control(
			'active_styler_stars_wrapper',
			[
				'label'     => __('Stars Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kt-ts-stars-wrapper'),
			]
		);
		$this->add_control(
			'active_styler_stars',
			[
				'label'     => __('Stars', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kt-ts-stars-wrapper .kt-ts-star'),
			]
		);
		$this->add_control(
			'active_styler_full_star',
			[
				'label'     => __('Full Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kt-ts-stars-wrapper .kt-ts-star.kt-star-full'),
			]
		);
		$this->add_control(
			'active_styler_half_star',
			[
				'label'     => __('Half Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kt-ts-stars-wrapper .kt-ts-star.kt-ts-star-half'),
			]
		);
		$this->add_control(
			'active_styler_empty_star',
			[
				'label'     => __('Empty Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active .kt-ts-stars-wrapper .kt-ts-star-empty'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'center_testimonials_style',
			[
				'label' => esc_html__('Center Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'center_styler_item',
			[
				'label'     => __('Center Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-testimonial'),
			]
		);
		$this->add_control(
			'center_styler_thumbnail_wrapper',
			[
				'label'     => __('Image/Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-img-wrap'),
			]
		);
		$this->add_control(
			'center_styler_icon_image_wrapper',
			[
				'label'     => __('Image Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-img'),
			]
		);
		$this->add_control(
			'center_styler_icon_image',
			[
				'label'     => __('Image', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-img img'),
			]
		);
		$this->add_control(
			'center_styler_icon_wrapper',
			[
				'label'     => __('Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-icon'),
			]
		);
		$this->add_control(
			'icon_style_error_3',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'center_styler_icon',
			[
				'label'     => __('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-icon .kata-icon'),
			]
		);
		$this->add_control(
			'center_styler_content_wrapper',
			[
				'label'     => __('Content Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-testimonial-content'),
			]
		);
		$this->add_control(
			'center_styler_name',
			[
				'label'     => __('Name', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-name-wrap'),
			]
		);
		$this->add_control(
			'center_styler_pos',
			[
				'label'     => __('Position', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-pos'),
			]
		);
		$this->add_control(
			'center_styler_cnt',
			[
				'label'     => __('Content', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-cnt'),
			]
		);
		$this->add_control(
			'center_styler_date',
			[
				'label'     => __('Date', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kata-plus-date'),
			]
		);
		$this->add_control(
			'center_styler_stars_wrapper',
			[
				'label'     => __('Stars Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kt-ts-stars-wrapper'),
			]
		);
		$this->add_control(
			'center_styler_stars',
			[
				'label'     => __('Stars', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kt-ts-stars-wrapper .kt-ts-star'),
			]
		);
		$this->add_control(
			'center_styler_full_star',
			[
				'label'     => __('Full Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kt-ts-stars-wrapper .kt-ts-star.kt-star-full'),
			]
		);
		$this->add_control(
			'center_styler_half_star',
			[
				'label'     => __('Half Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kt-ts-stars-wrapper .kt-ts-star.kt-ts-star-half'),
			]
		);
		$this->add_control(
			'center_styler_empty_star',
			[
				'label'     => __('Empty Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-item.active.center .kt-ts-stars-wrapper .kt-ts-star-empty'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__('Carousel', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_arrow_wrapper',
			[
				'label'     => __('Slider Arrows Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-nav'),
			]
		);
		$this->add_control(
			'styler_arrow_left_wrapper',
			[
				'label'     => __('Left Arrow Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-nav .owl-prev'),
			]
		);
		$this->add_control(
			'styler_arrow_left',
			[
				'label'     => __('Left Arrow', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('i', '', '.owl-prev'),
			]
		);
		$this->add_control(
			'styler_arrow_right_wrapper',
			[
				'label'     => __('Right Arrow Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-nav .owl-next'),
			]
		);
		$this->add_control(
			'styler_arrow_right',
			[
				'label'     => __('Right Arrow', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('i', '', '.owl-next'),
			]
		);
		$this->add_control(
			'styler_boolets',
			[
				'label'     => __('Pagination Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-dots'),
			]
		);
		$this->add_control(
			'styler_boolet',
			[
				'label'     => __('Bullets', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-dots .owl-dot'),
			]
		);
		$this->add_control(
			'styler_boolet_active',
			[
				'label'     => __('Active Bullet', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-testimonials .owl-dots .owl-dot.active'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_progress_bar',
			[
				'label'     => esc_html__('Progress Bar', 'kata-plus'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'inc_owl_pag_num' => 'dots-and-num',
				],
			]
		);
		$this->add_control(
			'styler_progress_wraper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-owl-progress-bar'),
			]
		);
		$this->add_control(
			'styler_progress',
			[
				'label'     => esc_html__('Progress Bar', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-owl-progress-bar .kata-progress-bar-inner'),
			]
		);
		$this->add_control(
			'styler_progress_min_number',
			[
				'label'     => esc_html__('Start Number', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-owl-progress-bar .minitems'),
			]
		);
		$this->add_control(
			'styler_progress_max_number',
			[
				'label'     => esc_html__('End Number', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-owl-progress-bar .maxitems'),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render()
	{
		require dirname(__FILE__) . '/view.php';
	}
}
