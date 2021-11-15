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

class Kata_Plus_Single_Testimonial extends Widget_Base {
	public function get_name() {
		return 'kata-plus-single-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Single Testimonial', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-single-testimonial';
	}

	public function get_categories() {
		return ['kata_plus_elementor_most_usefull'];
	}

	public function get_style_depends() {
		return ['kata-plus-testimonials'];
	}

	protected function register_controls() {
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
				'multiple'  => false,
				'options'   => $posts_array,
				'condition' => [
					'testp_source' => ['yes'],
				],
			]
		);

		$this->add_control(
			'inc_owl_img',
			[
				'label' => __('Choose Image', 'kata-plus'),
				'type'  => Controls_Manager::MEDIA,
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
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
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
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
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_icon',
			[
				'label'   => __('Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/quote-left',
				'condition' => [
					'symbol' => [
						'icon',
					],
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
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
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_group_control(
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
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_name',
			[
				'label'   => __('Name', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Jane Smith', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_pos',
			[
				'label'   => __('Position', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('CEO', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_cnt',
			[
				'label'   => __('Content', 'kata-plus'),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 10,
				'default' => __('would like to highly recommend Kata to anyone looking for a designer who they can trust to produce a beautiful result in their home.', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_date',
			[
				'label'       => __('Date', 'kata-plus'),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => '',
				'placeholder' => __('February 19, 2018', 'kata-plus'),
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'show_time',
			[
				'label'        => __('Show The Time', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_shape',
			[
				'label'     => __('Shape', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('{{CURRENT_ITEM}} .kata-plus-shape'),
				'condition'   => [
					'testp_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_html',
			[
				'label'    => __('Custom HTML', 'kata-plus'),
				'type'     => Controls_Manager::CODE,
				'language' => 'html',
				'rows'     => 20,
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
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'testimonials_style',
			[
				'label' => esc_html__('Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'     => __('Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-testimonial'),
			]
		);
		$this->add_control(
			'styler_thumbnail_wrapper',
			[
				'label'     => __('Image/Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-img-wrap'),
			]
		);
		$this->add_control(
			'styler_icon_image_wrapper',
			[
				'label'     => __('Image Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-img'),
			]
		);
		$this->add_control(
			'styler_icon_image',
			[
				'label'     => __('Image', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-img img'),
			]
		);
		$this->add_control(
			'styler_icon_wrapper',
			[
				'label'     => __('Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-icon'),
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
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-icon .kata-icon'),
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'     => __('Content Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-testimonial-content'),
			]
		);
		$this->add_control(
			'styler_name_pos_wrap',
			[
				'label'     => __('Name & Position Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .name-pos-wrap'),
			]
		);
		$this->add_control(
			'styler_name',
			[
				'label'     => __('Name', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-name-wrap'),
			]
		);
		$this->add_control(
			'styler_pos',
			[
				'label'     => __('Position', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-pos'),
			]
		);
		$this->add_control(
			'styler_cnt',
			[
				'label'     => __('Content', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-cnt'),
			]
		);
		$this->add_control(
			'styler_date',
			[
				'label'     => __('Date', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kata-plus-date'),
			]
		);
		$this->add_control(
			'styler_stars_wrapper',
			[
				'label'     => __('Stars Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kt-ts-stars-wrapper'),
			]
		);
		$this->add_control(
			'styler_stars',
			[
				'label'     => __('Stars', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kt-ts-stars-wrapper .kt-ts-star'),
			]
		);
		$this->add_control(
			'styler_full_star',
			[
				'label'     => __('Full Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kt-ts-stars-wrapper .kt-ts-star.kt-star-full'),
			]
		);
		$this->add_control(
			'styler_half_star',
			[
				'label'     => __('Half Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kt-ts-stars-wrapper .kt-ts-star.kt-ts-star-half'),
			]
		);
		$this->add_control(
			'styler_empty_star',
			[
				'label'     => __('Empty Star', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-single-testimonial .kt-ts-stars-wrapper .kt-ts-star-empty'),
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
