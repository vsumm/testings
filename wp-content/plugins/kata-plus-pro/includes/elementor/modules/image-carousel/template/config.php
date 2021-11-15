<?php

/**
 * Image Carousel module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Image_Carousel extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-image-carousel';
	}

	public function get_title()
	{
		return esc_html__('Image Carousel', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-image-slider';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-owlcarousel', 'kata-plus-owlcarousel-thumbs', 'kata-plus-owl', 'kata-plus-lightgallery', 'kata-image-carousel'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-owlcarousel', 'kata-plus-owl', 'kata-plus-lightgallery', 'kata-image-carousel'];
	}


	protected function register_controls()
	{

		$this->start_controls_section(
			'carousel_images',
			[
				'label' => esc_html__('Images', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'gallery',
			[
				'label'   => __('Add Images', 'kata-plus'),
				'type'    => Controls_Manager::GALLERY,
				'default' => [],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'separator' => 'none',
			]
		);
		$this->add_control(
			'kata_plus_grid_show_modal',
			[
				'label'        => esc_html__('Open in Modal', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'kata-plus'),
				'label_off'    => __('Off', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'kata_plus_stairs_carousel',
			[
				'label'        => esc_html__('Stairs carousel', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'kata-plus'),
				'label_off'    => __('Off', 'kata-plus'),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'stairs_style',
			[
				'label'     => __('Layout', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => ' stairs-right',
				'options'   => [
					' stairs-right'  => __('Right', 'kata-plus'),
					' stairs-center' => __('Center', 'kata-plus'),
					' stairs-left'   => __('Left', 'kata-plus'),
				],
				'condition' => [
					'kata_plus_stairs_carousel' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__('Settings', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'inc_owl_item',
			[
				'label'       => __('Items Per View', 'kata-plus'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 12,
				'step'        => 1,
				'default'     => 3,
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'description' => __('Varies between 1/12', 'kata-plus'),
				'condition'   => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
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
				'condition'   => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->add_control(
			'inc_owl_spd',
			[
				'label'       => __('Slide Speed', 'kata-plus'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 500,
				'max'         => 6000,
				'step'        => 1,
				'default'     => 5000,
				'description' => __('Varies between 500/6000', 'kata-plus'),
			]
		);
		$this->add_control(
			'inc_owl_smspd',
			[
				'label'       => __('Smart Speed', 'kata-plus'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 500,
				'max'         => 6000,
				'step'        => 1,
				'default'     => 1000,
				'description' => __('Varies between 500/6000', 'kata-plus'),
			]
		);
		$this->add_responsive_control(
			'inc_owl_stgpad',
			[
				'label'       => __('Stage Padding', 'kata-plus'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 200,
				'step'        => 1,
				'default'     => 0,
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'description' => __('Varies between 0/400', 'kata-plus'),
				'condition'   => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'inc_owl_margin',
			[
				'label'       => __('Margin', 'kata-plus'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 200,
				'step'        => 1,
				'default'     => 20,
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'description' => __('Varies between 0/400', 'kata-plus'),
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
				'condition'    => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
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
				'condition'    => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->add_control(
			'inc_owl_thumbnail',
			[
				'label'        => __('Thumbnails', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => ['desktop', 'tablet', 'mobile'],
				'condition'    => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->add_control(
			'thumbs_size',
			[
				'label'       => __('Thumbnail Dimension', 'kata-plus'),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __('Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'kata-plus'),
				'default'     => [
					'width'  => '100',
					'height' => '100',
				],
				'condition'    => [
					'inc_owl_thumbnail' => 'true',
				],
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
				'condition'    => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->add_control(
			'inc_owl_vert',
			[
				'label'			=> __('Vertical Slider', 'kata-plus'),
				'description'	=> __('This option works only when "Items Per View" is set to 1.', 'kata-plus'),
				'type'			=> Controls_Manager::SWITCHER,
				'label_on'		=> __('Yes', 'kata-plus'),
				'label_off'		=> __('No', 'kata-plus'),
				'return_value'	=> 'true',
				'default'		=> 'false',
				'condition'		=> [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__('Icon', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$icon = new Repeater();
		$icon->add_control(
			'carousel_post_has_link',
			[
				'label'        => esc_html__('Use Link', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Use', 'kata-plus'),
				'label_off'    => esc_html__('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$icon->add_control(
			'carousel_post_link',
			[
				'label'         => esc_html__('Link', 'kata-plus'),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => ['carousel_post_has_link' => 'yes'],
			]
		);
		$icon->add_control(
			'carousel_post_icon',
			[
				'label'   => esc_html__('Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/twitter',
			]
		);
		$icon->add_control(
			'styler_carousel_nav_post_icon',
			[
				'label'            => esc_html__('Icon Style', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('{{CURRENT_ITEM}}', '', '.kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'carousel_posts_icons',
			[
				'label'			=> esc_html__('Add Icons', 'kata-plus'),
				'type'			=> Controls_Manager::REPEATER,
				'fields'		=> $icon->get_controls(),
				'prevent_empty'	=> false,
				'title_field'	=> '{{{ carousel_post_icon }}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_shape',
			[
				'label' => esc_html__('Shape', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$shape = new Repeater();
		$shape->add_control(
			'carousel_nav_post_element_title',
			[
				'label'   => esc_html__('Title', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'New Element',
			]
		);
		$shape->add_control(
			'styler_carousel_nav_post_element',
			[
				'label'            => esc_html__('Element', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('{{CURRENT_ITEM}}', '', '.kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'carousel_posts_elements',
			[
				'label'			=> esc_html__('Element', 'kata-plus'),
				'type'			=> Controls_Manager::REPEATER,
				'fields'		=> $shape->get_controls(),
				'prevent_empty'	=> false,
				'title_field'	=> '{{{carousel_nav_post_element_title}}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_parent',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel'),
			]
		);
		$this->add_control(
			'styler_widget_stage',
			[
				'label'            => esc_html__('Carousel Stage', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-stage-outer'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_items',
			[
				'label' => esc_html__('Items', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_items',
			[
				'label'            => esc_html__('item', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'styler_image',
			[
				'label'            => esc_html__('Image', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel-single-image', '', '.kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'styler_image_caption',
			[
				'label'            => esc_html__('Caption', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item figcaption'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_center_items',
			[
				'label' => esc_html__('Center Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->add_control(
			'styler_center_items',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-item.center .kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'styler_center_image',
			[
				'label'            => esc_html__('Image', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item.center .kata-image-carousel-img img'),
			]
		);
		$this->add_control(
			'styler_center_image_caption',
			[
				'label'            => esc_html__('Caption', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item.active.center .kata-image-carousel-img figcaption'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_active_items',
			[
				'label' => esc_html__('Active Items', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'kata_plus_stairs_carousel!' => 'yes',
				],
			]
		);
		$this->add_control(
			'styler_active_items',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-item.active .kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'styler_active_image',
			[
				'label'            => esc_html__('Images', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item.active .kata-image-carousel-img img'),
			]
		);
		$this->add_control(
			'styler_active_image_caption',
			[
				'label'            => esc_html__('Caption', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item.active .kata-image-carousel-img figcaption'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'stairs_carousel_section1',
			[
				'label' => esc_html__('First Stair', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'kata_plus_stairs_carousel' => 'yes',
				],
			]
		);
		$this->add_control(
			'stairs1_wrapper',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-item.prev .kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'stairs1_image',
			[
				'label'            => esc_html__('Images', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item.prev .kata-image-carousel-img img'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'stairs_carousel_section2',
			[
				'label' => esc_html__('Second Stair', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'kata_plus_stairs_carousel' => 'yes',
				],
			]
		);
		$this->add_control(
			'stairs2_wrapper',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-item.center .kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'stairs2_image',
			[
				'label'            => esc_html__('Images', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item.center .kata-image-carousel-img img'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'stairs_carousel_section3',
			[
				'label' => esc_html__('Third Stair', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'kata_plus_stairs_carousel' => 'yes',
				],
			]
		);
		$this->add_control(
			'stairs3_wrapper',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-item.next .kata-image-carousel-img'),
			]
		);
		$this->add_control(
			'stairs3_image',
			[
				'label'            => esc_html__('Images', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-item.next .kata-image-carousel-img img'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__('Carousel', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_bullet_wrap',
			[
				'label'            => esc_html__('Bullet Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-dots'),
			]
		);
		$this->add_control(
			'styler_bullet',
			[
				'label'            => esc_html__('Bullet', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-dots .owl-dot'),
			]
		);
		$this->add_control(
			'styler_active_bullet',
			[
				'label'            => esc_html__('Active Bullet', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-dots .owl-dot.active'),
			]
		);
		$this->add_control(
			'styler_next_wrapper',
			[
				'label'            => esc_html__('Arrows Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel .owl-nav'),
			]
		);
		$this->add_control(
			'styler_prev_arrow_wrapper',
			[
				'label'            => esc_html__('Prev Arrow Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel button.owl-prev'),
			]
		);
		$this->add_control(
			'styler_prev_arrow',
			[
				'label'            => esc_html__('Prev Arrow', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel button.owl-prev .kata-icon'),
			]
		);
		$this->add_control(
			'styler_next_arrow_wrapper',
			[
				'label'            => esc_html__('Next Arrow Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel button.owl-next'),
			]
		);
		$this->add_control(
			'styler_next_arrow',
			[
				'label'            => esc_html__('Next Arrow', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-image-carousel button.owl-next .kata-icon'),
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
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-owl-progress-bar'),
			]
		);
		$this->add_control(
			'styler_progress',
			[
				'label'            => esc_html__('Progress Bar', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-owl-progress-bar .kata-progress-bar-inner'),
			]
		);
		$this->add_control(
			'styler_progress_min_number',
			[
				'label'            => esc_html__('Start Number', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-owl-progress-bar .minitems'),
			]
		);
		$this->add_control(
			'styler_progress_max_number',
			[
				'label'            => esc_html__('End Number', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-owl-progress-bar .maxitems'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_thumbnails',
			[
				'label' => esc_html__('Thumbnails', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_thumbnail_wrapper',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-thumbs'),
			]
		);
		$this->add_control(
			'styler_thumbnail_item',
			[
				'label'            => esc_html__('Items', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-thumbs .owl-thumb-item'),
			]
		);
		$this->add_control(
			'styler_thumbnail_item_img',
			[
				'label'            => esc_html__('Images', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.owl-thumbs .owl-thumb-item img'),
			]
		);
		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render()
	{
		require dirname(__FILE__) . '/view.php';
	}
}
