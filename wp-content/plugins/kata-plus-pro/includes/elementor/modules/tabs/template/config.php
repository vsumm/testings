<?php

/**
 * Tabs module config.
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
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Tabs extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-tabs';
	}

	public function get_title()
	{
		return esc_html__('Tabs', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-tabs';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-tabs'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-tabs'];
	}

	protected function register_controls()
	{

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

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Content', 'kata-plus'),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'tab_item',
			[
				'label'   => __('Choose template content', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $eletpls_opts,
			]
		);
		$repeater->add_control(
			'tab_icon',
			[
				'label'   => __('Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/arrow-down',
			]
		);
		$repeater->add_control(
			'image',
			[
				'label'   => __('Choose Image', 'kata-plus'),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
			]
		);
		$repeater->add_control(
			'tab_title',
			[
				'label'   => __('Title', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Tab title', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'tab_subtitle',
			[
				'label'   => __('Subtitle', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Tab Subtitle', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'tab_style',
			[
				'label'     => esc_html__('Styler', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('{{CURRENT_ITEM}}'),
			]
		);
		$this->add_control(
			'tabs',
			[
				'label'       => __('Repeater List', 'kata-plus'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'tab_icon'  => 'font-awesome/paint-brush',
						'tab_title' => __('Themes', 'kata-plus'),
					],
					[
						'tab_icon'  => 'font-awesome/plug',
						'tab_title' => __('Plugins', 'kata-plus'),
					],

				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_Tab_content',
			[
				'label' => esc_html__('Tab Settings', 'kata-plus'),
			]
		);
		$this->add_control(
			'tab_pos',
			[
				'label'   => __('Tabs positions', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'kata-plus-tabs-htl',
				'options' => [
					'kata-plus-tabs-htl' => __('Top Left', 'kata-plus'),
					'kata-plus-tabs-htc' => __('Top Center', 'kata-plus'),
					'kata-plus-tabs-htr' => __('Top Right', 'kata-plus'),
					'kata-plus-tabs-hbl' => __('Bottom Left', 'kata-plus'),
					'kata-plus-tabs-hbc' => __('Bottom Center', 'kata-plus'),
					'kata-plus-tabs-hbr' => __('Bottom Right', 'kata-plus'),
					'kata-plus-tabs-vl kata-plus-tabs-is-v' => __('Vertical Left', 'kata-plus'),
					'kata-plus-tabs-vr kata-plus-tabs-is-v' => __('Vertical Right', 'kata-plus'),
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
			'styler_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styler_tabs',
			[
				'label' => esc_html__('Tabs', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_tab',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tabs-item'),
			]
		);
		$this->add_control(
			'styler_tab_items',
			[
				'label'     => esc_html__('Items', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tabs-item li'),
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
			'styler_tab_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-icon', '', '.kata-plus-tabs .kata-plus-tab-item'),
			]
		);
		$this->add_control(
			'styler_tab_image',
			[
				'label'     => esc_html__('Image', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('img', '', '.kata-plus-tabs .kata-plus-tab-item'),
			]
		);
		$this->add_control(
			'styler_tab_title',
			[
				'label'     => esc_html__('Title', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tab-item .kata-tabs-title'),
			]
		);
		$this->add_control(
			'styler_tab_subtitle',
			[
				'label'     => esc_html__('Subtitle', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tab-item .kata-desc'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styler_tabs_active',
			[
				'label' => esc_html__('Active', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_active_tab',
			[
				'label'     => esc_html__('Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tabs-item li.active'),
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
			'styler_tab_icon_active',
			[
				'label'     => esc_html__('Tab Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tab-item.active .kata-icon'),
			]
		);
		$this->add_control(
			'styler_tab_image_active',
			[
				'label'     => esc_html__('Tab Image', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tab-item.active > a > img'),
			]
		);
		$this->add_control(
			'styler_tab_title_active',
			[
				'label'     => esc_html__('Title', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tabs-item li.active .kata-tabs-title'),
			]
		);
		$this->add_control(
			'styler_tab_subtitle_active',
			[
				'label'     => esc_html__('Subtitle', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tabs-item li.active .kata-desc'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_content',
			[
				'label' => esc_html__('Content', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-tabs .kata-plus-tabs-contents'),
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
