<?php

/**
 * Hamburger Menu module config.
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

class Kata_Hamburger_Menu extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-hamburger-menu';
	}

	public function get_title()
	{
		return esc_html__('Hamburger Menu', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-menu-toggle';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor_header'];
	}

	public function get_script_depends()
	{
		return ['superfish', 'kata-nicescroll-script', 'kata-plus-hamburger-menu'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-hamburger-menu'];
	}

	protected function register_controls()
	{
		// Get Menu
		$menus = get_terms('nav_menu');
		if (!empty($menus)) {
			foreach ($menus as $menu) {
				$menu_name[] = $menu->name;
				$menu_id[]   = $menu->term_id;
			}
			$menus = array_combine($menu_id, $menu_name);
		}
		// Elementor Templates
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
		// general
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__('General', 'kata-plus'),
			]
		);
		$this->add_control(
			'template',
			[
				'label'   => __('Select Template', 'kata-plus'),
				'description'   => __('You can have your own custom hamburger menu with any custom design by using this widget. In order to start, you should go to WP dashboard > Templates and click on "add new", then select the section from template type and click on Create Template.', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'options' => $eletpls_opts,
			]
		);
		$this->add_control(
			'hamburger_load',
			[
				'label'   => __('Select type', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'kata-hamburger-full',
				'options' => [
					'kata-hamburger-full'  => __('Full Page', 'kata-plus'),
					'kata-hamburger-slide' => __('Slide', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'open_from',
			[
				'label'     => __('Open From', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'open-from-right',
				'options'   => [
					'open-from-left'  => __('Left', 'kata-plus'),
					'open-from-right' => __('Right', 'kata-plus'),
				],
				'condition' => [
					'hamburger_load' => ['kata-hamburger-slide'],
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
			]
		);
		$this->add_control(
			'open_icon',
			[
				'label'   => esc_html__('Open Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'simple-line/menu',
				'condition' => [
					'symbol' => 'icon'
				]
			]
		);
		$this->add_control(
			'close_icon',
			[
				'label'   => esc_html__('Close Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'themify/close',
				'condition' => [
					'symbol' => 'icon'
				]
			]
		);
		$this->add_control(
			'icon_image',
			[
				'label'     => __('Open Image/SVG', 'kata-plus'),
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
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'icon_image',
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
		$this->add_control(
			'icon_image2',
			[
				'label'     => __('Close Image/SVG', 'kata-plus'),
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
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'icon_image2',
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
		$this->end_controls_section();

		// styling
		$this->start_controls_section(
			'section_wrapper',
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
				'selectors' => Kata_Styler::selectors('.kata-plus-hamburger-menu'),
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'     => esc_html__('Content Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-hamburger-menu-template'),
			]
		);
		$this->end_controls_section();
		// styling
		$this->start_controls_section(
			'section_icons',
			[
				'label' => esc_html__('Icons', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'svg_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('To style the hamburger close and open icons, Please go to svg tab in the styler.', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_open_icon',
			[
				'label'     => esc_html__('Open Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-hamburger-menu .icons-wrap .open-icon'),
			]
		);
		$this->add_control(
			'styler_close_icon',
			[
				'label'     => esc_html__('Close Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-hamburger-menu .icons-wrap .close-icon'),
			]
		);
		$this->add_control(
			'styler_close_icon_in_hamburger_menu',
			[
				'label'     => esc_html__('Inner Close Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-hamburger-menu-template .icons-wrap .close-icon'),
			]
		);
		$this->add_control(
			'wrapper_styler_close_icon_in_hamburger_menu',
			[
				'label'     => esc_html__('Inner Close Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-hamburger-menu-template .icons-wrap'),
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
