<?php

/**
 * Content Slider module config.
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
use Elementor\Plugin;

class Kata_Plus_Pro_ContentSlider extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-content-slider';
	}

	public function get_title()
	{
		return esc_html__('Content Slider', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-post-slider';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-owlcarousel', 'kata-plus-owl'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-owlcarousel', 'kata-plus-owl'];
	}

	protected function register_controls()
	{

		// Content options Start
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content Slider Settings', 'kata-plus'),
			]
		);

		$eletpls      = Plugin::instance()->templates_manager->get_source('local')->get_items();
		$eletpls_opts = [
			'0' => __('Elementor template is not defined yet.', 'kata-plus'),
		];

		if (!empty($eletpls)) {
			$eletpls_opts = [
				'0' => __('Select elementor template', 'kata-plus'),
			];
			foreach ($eletpls as $template) {
				$eletpls_opts[$template['title']] = $template['title'] . ' (' . $template['type'] . ')';
			}
		}

		$repeater = new Repeater();

		$repeater->add_control(
			'cntslider_item',
			[
				'label'       => esc_html__('Choose template', 'kata-plus'),
				'description' => esc_html__('Please head over to WP Dashboard > Templates > Saved Templates and add a template. You can then choose the template you like here.', 'kata-plus'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => $eletpls_opts,
			]
		);

		$repeater->add_control(
			'cntslider_html',
			[
				'label'    => __('Custom HTML', 'kata-plus'),
				'type'     => Controls_Manager::CODE,
				'language' => 'html',
				'rows'     => 20,
			]
		);

		$this->add_control(
			'cntsliders',
			[
				'label'       => __('Slider Items', 'kata-plus'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => __('Slider Item', 'kata-plus'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'owl_section',
			[
				'label' => esc_html__('Carousel Settings', 'kata-plus'),
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
				'default'     => 1,
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'description' => __('Varies between 1/12', 'kata-plus'),
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
				'max'         => 400,
				'step'        => 1,
				'default'     => 0,
				'devices'     => ['desktop', 'tablet', 'mobile'],
				'description' => __('Varies between 0/400', 'kata-plus'),
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
		$this->add_responsive_control(
			'inc_owl_arrow',
			[
				'label'        => __('Arrows', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => ['desktop', 'tablet', 'mobile'],
			]
		);
		$this->add_control(
			'inc_owl_prev',
			[
				'label'     => __('Previous Icon', 'kata-plus'),
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
				'label'     => __('Next Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'font-awesome/angle-right',
				'condition' => [
					'inc_owl_arrow' => [
						'true',
					],
				],
			]
		);
		$this->add_responsive_control(
			'inc_owl_pag',
			[
				'label'        => __('Pagination', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
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
					'dots-counter' => __('Counter', 'kata-plus'),
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
			'progress_bar',
			[
				'label'        => __('Progress bar', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'false',
			]
		);
		$this->add_control(
			'vertical_bullet',
			[
				'label'        => __('Vertical Bullets', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'false',
				'condition'    => [
					'inc_owl_pag' => 'true',
					'inc_owl_pag_num' => [
						'dots',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_loop',
			[
				'label'        => __('Loop', 'kata-plus'),
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
				'label'        => __('Center', 'kata-plus'),
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
			'section_style_parent',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrap',
			[
				'label'     => __('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider'),
			]
		);
		$this->add_control(
			'styler_stage',
			[
				'label'     => __('Carousel Stage', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-stage-outer'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_carousel_options',
			[
				'label' => esc_html__('Carousel', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_arrow_wrapper',
			[
				'label'     => __('Arrow Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-nav'),
			]
		);
		$this->add_control(
			'styler_arrow_left_wrapper',
			[
				'label'     => __('Left Arrow Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.owl-prev'),
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
				'selectors' => Kata_Styler::selectors('.owl-next'),
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
			'styler_boolets_counter_wrapper',
			[
				'label'     => __('Counter Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .dots-counter'),
				'condition' => [
					'inc_owl_pag'     => 'true',
					'inc_owl_pag_num' => 'dots-counter',
				],
			]
		);
		$this->add_control(
			'styler_boolets_counter_current',
			[
				'label'     => __('Current Page', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .dots-counter .counter'),
				'condition' => [
					'inc_owl_pag'     => 'true',
					'inc_owl_pag_num' => 'dots-counter',
				],
			]
		);
		$this->add_control(
			'styler_boolets_total_current',
			[
				'label'     => __('Total Page', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .dots-counter .sum'),
				'condition' => [
					'inc_owl_pag'     => 'true',
					'inc_owl_pag_num' => 'dots-counter',
				],
			]
		);
		$this->add_control(
			'styler_boolets_wrapper',
			[
				'label'     => __('Bullets Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-dots'),
				'condition' => [
					'inc_owl_pag_num' => 'dots',
				],
			]
		);
		$this->add_control(
			'styler_boolets',
			[
				'label'     => __('Bullet', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-dots .owl-dot'),
				'condition' => [
					'inc_owl_pag_num' => 'dots',
				],
			]
		);
		$this->add_control(
			'styler_boolets_active',
			[
				'label'     => __('Active Bullet', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-dots .owl-dot.active'),
				'condition' => [
					'inc_owl_pag_num' => 'dots',
				],
			]
		);
		$this->add_control(
			'styler_numbers_wrapper',
			[
				'label'     => __('Numbers Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider.dots-num .owl-dots'),
				'condition' => [
					'inc_owl_pag_num' => 'dots-num',
				],
			]
		);
		$this->add_control(
			'styler_numbers',
			[
				'label'     => __('Number', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider.dots-num .owl-dots .owl-dot'),
				'condition' => [
					'inc_owl_pag_num' => 'dots-num',
				],
			]
		);
		$this->add_control(
			'styler_numbers_active',
			[
				'label'     => __('Active Number', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider.dots-num .owl-dots .owl-dot.active'),
				'condition' => [
					'inc_owl_pag_num' => 'dots-num',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_item_options',
			[
				'label' => esc_html__('Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'     => __('Items', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .kata-plus-cntslider'),
			]
		);
		$this->add_control(
			'styler_custom_html',
			[
				'label'     => __('Custom Html Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .custom-html'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_carousel_active_options',
			[
				'label' => esc_html__('Active Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_active_item',
			[
				'label'     => __('Items', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-item.active .kata-plus-cntslider'),
			]
		);
		$this->add_control(
			'styler_active_custom_html',
			[
				'label'     => __('Custom Html Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-item.active .custom-html'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_carousel_center_options',
			[
				'label' => esc_html__('Center Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_center_item',
			[
				'label'     => __('Items', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-item.active.center .kata-plus-cntslider'),
			]
		);
		$this->add_control(
			'styler_center_custom_html',
			[
				'label'     => __('Custom Html Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-slider .owl-item.active.center .custom-html'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_progress_bar',
			[
				'label'     => esc_html__('Progress Bar', 'kata-plus'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'progress_bar' => 'true',
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
