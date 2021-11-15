<?php

/**
 * Menu module config.
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

class Kata_Plus_Menu_Navigation extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-menu-navigation';
	}

	public function get_title()
	{
		return esc_html__('Menu', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-nav-menu';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor_header'];
	}

	public function get_script_depends()
	{
		return ['superfish', 'kata-plus-menu-navigation'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-menu-navigation'];
	}

	protected function register_controls()
	{
		$menus = get_terms('nav_menu');
		if (!empty($menus)) {
			foreach ($menus as $menu) {
				$menu_name[] = $menu->name;
				$menu_id[]   = $menu->name;
			}
			$menus      = array_combine($menu_id, $menu_name);
			$menus['0'] = __('Select Menu', 'kata-plus');
		}
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('General', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Select Menu
		$this->add_control(
			'menu_type',
			[
				'label'   => __('Layout', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __('Horizontal', 'kata-plus'),
					'vertical'   => __('Vertical', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'nav_id',
			[
				'label'   => __('Select Menu', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'options' => $menus,
			]
		);
		$this->add_control(
			'respnsive_menu',
			[
				'label'        => __('Respnsive Menu', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'parent_menu',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_menu_box',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap'),
			]
		);
		$this->add_control(
			'styler_menu_hbi',
			[
				'label'     => esc_html__('Hamburger Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-icon.cm-ham-open-icon'),
				'condition' => [
					'respnsive_menu' => 'yes'
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__('General', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_menu_wrapper',
			[
				'label'     => esc_html__('Menu Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu'),
			]
		);
		$this->add_control(
			'styler_menu_item',
			[
				'label'     => esc_html__('Menu Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('li.menu-item', '', '.kata-nav-menu > '),
			]
		);
		$this->add_control(
			'styler_menu_item_first',
			[
				'label'     => esc_html__('First Menu Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('li.menu-item:first-child', '', '.kata-nav-menu > '),
			]
		);
		$this->add_control(
			'styler_menu_item_last',
			[
				'label'     => esc_html__('Last Menu Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('li.menu-item:last-child', '', '.kata-nav-menu > '),
			]
		);
		$this->add_control(
			'styler_menu_item_link',
			[
				'label'     => esc_html__('Menu Item Link', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('a', '', '.kata-nav-menu>li.menu-item>'),
			]
		);
        $this->add_control(
            'styler_menu_item_icon',
            [
                'label'     => esc_html__('Menu Item Icon', 'kata-plus'),
                'type'      => 'kata_styler',
                'selectors' => Kata_Styler::selectors(' > a > i.kata-icon', '', '.kata-nav-menu li.menu-item'),
            ]
        );
		$this->add_control(
			'styler_menu_arrow',
			[
				'label'     => esc_html__('Menu Arrow', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.parent-menu-icon', '', 'li.menu-item'),
			]
		);
		$this->add_control(
			'styler_menu_desc',
			[
				'label'     => esc_html__('Description', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu small'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling_submenu',
			[
				'label' => esc_html__('Submenu', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_submenu_box',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu li.menu-item ul.sub-menu:not(.mega-menu-content)'),
			]
		);
		$this->add_control(
			'styler_submenu_item',
			[
				'label'     => esc_html__('Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) > li.menu-item:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item:hover'),
			]
		);
		$this->add_control(
			'styler_submenu_item_first',
			[
				'label'     => esc_html__('First Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item:first-child', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) > li.menu-item:first-child:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item:first-child:hover'),
			]
		);
		$this->add_control(
			'styler_submenu_item_last',
			[
				'label'     => esc_html__('Last Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item:last-child', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) > li.menu-item:last-child:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item:last-child:hover'),
			]
		);
		$this->add_control(
			'styler_submenu_item_link',
			[
				'label'     => esc_html__('Link items', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item > a', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) > li.menu-item > a:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item > a:hover'),
			]
		);
        $this->add_control(
            'styler_submenu_item_icon',
            [
                'label'     => esc_html__('Item Icon', 'kata-plus'),
                'type'      => 'kata_styler',
                'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item i.kata-icon', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) > li.menu-item i.kata-icon:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) > li.menu-item i.kata-icon:hover'),
            ]
        );
		$this->add_control(
			'styler_submenu_arrow',
			[
				'label'     => esc_html__('Arrow', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.parent-menu-icon', '', '.sub-menu'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling_multilevel_submenu',
			[
				'label' => esc_html__('Multilevel Submenu', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_submenu_multilevel_box',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu li.menu-item ul.sub-menu:not(.mega-menu-content) .sub-menu'),
			]
		);
		$this->add_control(
			'styler_submenu_multilevel_item',
			[
				'label'     => esc_html__('Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) .sub-menu > li.menu-item:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item:hover'),
			]
		);
		$this->add_control(
			'styler_submenu_multilevel_item_first',
			[
				'label'     => esc_html__('First Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item:first-child', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) .sub-menu > li.menu-item:first-child:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item:first-child:hover'),
			]
		);
		$this->add_control(
			'styler_submenu_multilevel_item_last',
			[
				'label'     => esc_html__('Last Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item:last-child', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) .sub-menu > li.menu-item:last-child:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item:last-child:hover'),
			]
		);
		$this->add_control(
			'styler_submenu_multilevel_item_link',
			[
				'label'     => esc_html__('Item links', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item > a', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) .sub-menu > li.menu-item > a:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item > a:hover'),
			]
		);
		$this->add_control(
			'styler_submenu_multilevel_arrow',
			[
				'label'     => esc_html__( 'Arrow', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.parent-menu-icon', '', '.sub-menu > li.menu-item > a'),
			]
		);
		$this->add_control(
            'styler_submenu_multilevel_item_icon',
            [
                'label'     => esc_html__('Item Icon', 'kata-plus'),
                'type'      => 'kata_styler',
                'selectors' => Kata_Styler::selectors('.kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item i.kata-icon', '{{WRAPPER}} .kata-menu-wrap [class*="kata-menu-navigation"] ul:not(.mega-menu-content) .sub-menu > li.menu-item i.kata-icon:hover, {{WRAPPER}} .kata-nav-menu ul.sub-menu:not(.mega-menu-content) .sub-menu > li.menu-item i.kata-icon:hover'),
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling_megamenu',
			[
				'label' => esc_html__('Megamenu', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
			'styler_magamenu_wrapper',
			[
				'label'     => esc_html__( 'Megamenu Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-navigation ul.mega-menu-content'),
			]
		);
        $this->end_controls_section();
        
		$this->start_controls_section(
			'section_styling_current',
			[
				'label' => esc_html__('Current', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_menu_item_current',
			[
				'label'     => esc_html__('Current Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) li.current-menu-item'),
			]
		);
		$this->add_control(
			'styler_menu_item_current_link',
			[
				'label'     => esc_html__('Current Item Link', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) li.current-menu-item > a'),
			]
		);
        $this->add_control(
            'styler_menu_item_icon_current',
            [
                'label'     => esc_html__('Current Item Icon', 'kata-plus'),
                'type'      => 'kata_styler',
                'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) li.current-menu-item > a > i.kata-icon'),
            ]
        );
        $this->add_control(
            'styler_menu_item_icon_ancestor',
            [
                'label'     => esc_html__('Ancestor Item Icon', 'kata-plus'),
                'type'      => 'kata_styler',
                'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) li.current-menu-ancestor > a > i.kata-icon'),
            ]
        );
		$this->add_control(
			'styler_menu_item_current_ancestor',
			[
				'label'     => esc_html__('Ancestor Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) li.current-menu-ancestor'),
			]
		);
        $this->add_control(
			'styler_menu_item_current_ancestor_link',
			[
				'label'     => esc_html__('Ancestor Item Link', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) li.current-menu-ancestor > a'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling_current_submenu',
			[
				'label' => esc_html__('Submenu Currnet Item', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_menu_item_submenu_current',
			[
				'label'     => esc_html__('Current Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) .sub-menu li.current-menu-item'),
			]
		);
		$this->add_control(
			'styler_menu_item_submenu_current_link',
			[
				'label'     => esc_html__('Current Item Link', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) .sub-menu li.current-menu-item > a'),
			]
		);
        $this->add_control(
            'styler_menu_item_submenu_icon_current',
            [
                'label'     => esc_html__('Current Item Icon', 'kata-plus'),
                'type'      => 'kata_styler',
                'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) .sub-menu li.current-menu-item i.kata-icon'),
            ]
        );
		$this->add_control(
			'styler_menu_item_submenu_current_ancestor',
			[
				'label'     => esc_html__('Ancestor Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) .sub-menu li.current-menu-ancestor'),
			]
		);
        $this->add_control(
			'styler_menu_item_submenu_current_ancestor_link',
			[
				'label'     => esc_html__('Ancestor Item Link', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-menu-wrap .kata-nav-menu:not(.mega-menu-content) .sub-menu li.current-menu-ancestor > a'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_effect',
			[
				'label' => esc_html__('Hover Effect', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label'   => __('Hover Effect And Current Menu', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'kata-menu-hover-none',
				'options' => [
					'kata-menu-hover-1'    => __('Effect 1', 'kata-plus'),
					'kata-menu-hover-2'    => __('Effect 2', 'kata-plus'),
					'kata-menu-hover-3'    => __('Effect 3', 'kata-plus'),
					'kata-menu-hover-4'    => __('Effect 4', 'kata-plus'),
					'kata-menu-hover-none' => __('None', 'kata-plus'),
				],
			]
		);

		$this->add_control(
			'triangle',
			[
				'label'        => __('Triangle', 'kata-plus'),
				'description'  => __('Displaying triangle under menu items for hover. For styling the triangle you should go to the Style tab > Menu Item and style the borders.', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'separator',
			[
				'label'        => __('Separator', 'kata-plus'),
				'description'  => __('Adding circle as menu item separator. For styling the separator you should edit tabs "Before" and "After" in the following path, Style > Menu Item > Before/After', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
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
