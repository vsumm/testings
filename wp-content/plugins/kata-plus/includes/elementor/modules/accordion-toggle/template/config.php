<?php

/**
 * Accordion Toggle module config.
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

class Kata_Accordion_Toggle extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-accordion-toggle';
	}

	public function get_title()
	{
		return esc_html__('Accordion', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-toggle';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor_most_usefull'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-accordion-toggle'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-accordion-toggle'];
	}

	protected function register_controls()
	{
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__('Content Toggle Settings', 'kata-plus'),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'at_icon',
			[
				'label'   => __('Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'themify/plus',
			]
		);
		$repeater->add_control(
			'at_icon_close',
			[
				'label'   => __('Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'themify/close',
			]
		);
		$repeater->add_control(
			'at_name',
			[
				'label'   => __('Title', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('How do I select a lawyer?', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'at_txt',
			[
				'label'   => __('Content', 'kata-plus'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __('Our restaurant and bar are located in the heart of Saalfelden.', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'at_items',
			[
				'label'       => __('Items', 'kata-plus'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'at_icon' => __('themify/plus', 'kata-plus'),
						'at_name' => __('How do I select a lawyer?', 'kata-plus'),
						'at_txt'  => __('Our restaurant and bar are located in the heart of Saalfelden.', 'kata-plus'),
					],
					[
						'at_icon' => __('themify/plus', 'kata-plus'),
						'at_name' => __('When do I need a lawyer?', 'kata-plus'),
						'at_txt'  => __('Our restaurant and bar are located in the heart of Saalfelden.', 'kata-plus'),
					],
					[
						'at_icon' => __('themify/plus', 'kata-plus'),
						'at_name' => __('What should I look for in an attorney?', 'kata-plus'),
						'at_txt'  => __('Our restaurant and bar are located in the heart of Saalfelden.', 'kata-plus'),
					],

				],
				'title_field' => '{{{ at_name }}}',
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__('Normal', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'wrapper',
			[
				'label'     		=> esc_html__('Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion-plus'),
			]
		);
		$this->add_control(
			'item',
			[
				'label'     		=> esc_html__('Item', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion'),
			]
		);
		$this->add_control(
			'styler_t_box',
			[
				'label'     		=> esc_html__('Title Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion-btn'),
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'     		=> esc_html__('Title', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion .kata-accordion-btn p'),
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
				'label'     		=> esc_html__('Icon', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion  .kata-accordion-btn .kata-icon'),
			]
		);
		$this->add_control(
			'styler_txt',
			[
				'label'     		=> esc_html__('Content', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion .kata-accordion-content p'),
			]
		);
		$this->add_control(
			'styler_txt_box',
			[
				'label'     		=> esc_html__('Content Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion .kata-accordion-content'),
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_styling_active',
			[
				'label' => esc_html__('Active', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'item_active',
			[
				'label'     		=> esc_html__('Item', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion.active'),
			]
		);
		$this->add_control(
			'styler_t_box_active',
			[
				'label'     		=> esc_html__('Title Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion.active .kata-accordion-btn'),
			]
		);
		$this->add_control(
			'styler_title_active',
			[
				'label'     		=> esc_html__('Title', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion.active .kata-accordion-btn p'),
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
			'styler_icon_active',
			[
				'label'     		=> esc_html__('Icon', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion.active .kata-accordion-btn .kata-icon'),
			]
		);
		$this->add_control(
			'styler_txt_active',
			[
				'label'     		=> esc_html__('Content', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion.active .kata-accordion-content p'),
			]
		);
		$this->add_control(
			'styler_txt_box_active',
			[
				'label'     		=> esc_html__('Content Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-accordion.active .kata-accordion-content p'),
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
