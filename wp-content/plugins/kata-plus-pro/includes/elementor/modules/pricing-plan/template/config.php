<?php

/**
 * Pricing Plan module config.
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
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Pricing_Plan extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-pricing-plan';
	}

	public function get_title()
	{
		return esc_html__('Pricing Plan', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-price-plan';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-pricing-plan'];
	}

	protected function register_controls()
	{
		// Content options Start
		$this->start_controls_section(
			'section_plan_settings',
			[
				'label' => esc_html__('Pricing Plan', 'kata-plus'),
			]
		);
		$this->add_control(
			'pricing_plan_title',
			[
				'label'   => __('Title', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Your Title', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'pricing_plan_subtitle',
			[
				'label'   => __('Time period', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('/ Monthly', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'pricing_plan_price',
			[
				'label'   => __('Price', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('100', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'pricing_plan_currency',
			[
				'label'   => __('Currency', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('$', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'pricing_plan_desc',
			[
				'label'   => __('Description', 'kata-plus'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
				'rows'    => 10,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'pricing_plan_link',
			[
				'label'         => __('Link', 'kata-plus'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __('https://your-link.com', 'kata-plus'),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		$this->add_control(
			'pricing_plan_icon_type',
			[
				'label'   => __('Icon Type', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'simplei',
				'options' => [
					'simplei'	=> __( 'Icon', 'kata-plus' ),
					'imagei'	=> __( 'Image', 'kata-plus' ),
					'svg'		=> __( 'SVG', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'pricing_plan_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/dashboard',
				'condition' => [
					'pricing_plan_icon_type' => 'simplei',
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'     => __('Choose Image', 'kata-plus'),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'pricing_plan_icon_type' => [
						'imagei',
						'svg'
					],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
			]
		);
		$this->add_control(
			'pricing_plan_number',
			[
				'label'     => __('Number', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => __('1', 'kata-plus'),
				'condition' => [
					'pricing_plan_icon_type' => [
						'numberi',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_Tab_content',
			[
				'label' => esc_html__('Items List', 'kata-plus'),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'pricing_plan_negative_item',
			[
				'label'        => esc_html__('Negative Item', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Use', 'kata-plus'),
				'label_off'    => esc_html__('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'off',
			]
		);

		$repeater->add_control(
			'pricing_plan_item_has_link',
			[
				'label'        => esc_html__('Use Link', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Use', 'kata-plus'),
				'label_off'    => esc_html__('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'off',
			]
		);

		$repeater->add_control(
			'pricing_plan_item_link',
			[
				'label'         => esc_html__('Link', 'kata-plus'),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => ['pricing_plan_item_has_link' => 'yes'],
			]
		);
		$repeater->add_control(
			'pricing_plan_item_icon',
			[
				'label'   => esc_html__('Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'themify/check',
			]
		);
		$repeater->add_control(
			'styler_pricing_plan_icon_style',
			[
				'label'            => esc_html__('Icon Style', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('{{CURRENT_ITEM}} .kata-icon'),
			]
		);
		$repeater->add_control(
			'pricing_plan_item_text',
			[
				'label'   => esc_html__('Text', 'kata-plus'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Lorem ipsum dolor sit amet.',
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'pricing_items',
			[
				'label'       => esc_html__('Add Item', 'kata-plus'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ pricing_plan_item_text }}}',

				'default'     => [
					[
						'pricing_plan_item_has_link' => 'off',
						'pricing_plan_item_text'     => 'Free Consultation',
					],
					[
						'pricing_plan_item_has_link' => 'off',
						'pricing_plan_item_text'     => 'Google Local Map Generator',
					],
					[
						'pricing_plan_item_has_link' => 'off',
						'pricing_plan_item_text'     => '100 GB Storage',
					],
					[
						'pricing_plan_item_has_link' => 'off',
						'pricing_plan_item_text'     => '1T Bandwidth',
					],
				],

			]
		);

		$this->end_controls_section();

		// Button Settings #
		$this->start_controls_section(
			'button_tab',
			[
				'label' => esc_html__('Button', 'kata-plus'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pricing_plan_button',
			[
				'label'        => esc_html__('Show Button', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Show', 'kata-plus'),
				'label_off'    => esc_html__('Hide', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'pricing_plan_button_text',
			[
				'label'     => esc_html__('Button Text', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'SELECT PLAN',
				'condition' => [
					'pricing_plan_button' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'pricing_plan_button_link',
			[
				'label'       => esc_html__('Link', 'kata-plus'),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'kata-plus'),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'   => [
					'pricing_plan_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'pricing_plan_button_icon',
			[
				'label'     => esc_html__('Button Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'pricing_plan_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'pricing_plan_button_icon_position',
			[
				'label'     => esc_html__('Button Icon Position', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'after'  => esc_html__('After', 'kata-plus'),
					'before' => esc_html__('Before', 'kata-plus'),
				],
				'default'   => 'after',
				'condition' => [
					'pricing_plan_button'       => 'yes',
					'pricing_plan_button_icon!' => '',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_widget_parent',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_container',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_widget_header',
			[
				'label' => esc_html__('Header', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_header_wrapper',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-cntt'),
			]
		);
		$this->add_control(
			'styler_icon_wrap',
			[
				'label'            => esc_html__('Icon Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-icon-wrap'),
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
			'plan_icon',
			[
				'label'            => esc_html__( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-icon-wrap .kata-icon'),
				'condition'        => [
					'pricing_plan_icon_type' => [
						'simplei',
					],
				],
			]
		);
		$this->add_control(
			'plan_icon_svg',
			[
				'label'            => esc_html__( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-icon-wrap .kata-svg-icon'),
				'condition'        => [
					'pricing_plan_icon_type' => [
						'svg',
					],
				],
			]
		);
		$this->add_control(
			'styler_image',
			[
				'label'            => esc_html__('Image', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-icon-wrap img'),
				'condition'        => [
					'pricing_plan_icon_type' => [
						'imagei',
					],
				],
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'            => esc_html__('Title', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-title'),
			]
		);
		$this->add_control(
			'styler_price',
			[
				'label'            => esc_html__('Price', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-price'),
			]
		);
		$this->add_control(
			'styler_currency',
			[
				'label'            => esc_html__('Currency', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-price .currency'),
			]
		);
		$this->add_control(
			'styler_subtitle',
			[
				'label'            => esc_html__('Time period', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-subtitle'),
			]
		);
		$this->add_control(
			'styler_desc',
			[
				'label'            => esc_html__('Description', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-description'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_items',
			[
				'label' => esc_html__('Items', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_items_wrapper',
			[
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-plan-items'),
			]
		);
		$this->add_control(
			'styler_items_text',
			[
				'label'            => esc_html__('Items', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-text'),
			]
		);
		$this->add_control(
			'styler_negative_items_text',
			[
				'label'            => esc_html__('Negative Items', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-text.negative'),
			]
		);
		$this->add_control(
			'styler_items_link',
			[
				'label'            => esc_html__('Items Icon Link', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-icon-link'),
				'condition'        => [
					'pricing_plan_item_has_link' => 'yes',
				],
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
			'styler_items_icon',
			[
				'label'            => esc_html__('Items Icon', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-icon.kata-icon'),
			]
		);
		$this->add_control(
			'styler_pricing_plan_button_wrapper',
			[
				'label'            => esc_html__('Button Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-button-wrapper'),
			]
		);
		$this->add_control(
			'styler_pricing_plan_button',
			[
				'label'            => esc_html__('Button', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-button'),
			]
		);
		$this->add_control(
			'styler_pricing_plan_button_icon',
			[
				'label'            => esc_html__('Button icon', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-plan-button .kata-icon'),
			]
		);
		// Style options End
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render()
	{
		require dirname(__FILE__) . '/view.php';
	}
}
