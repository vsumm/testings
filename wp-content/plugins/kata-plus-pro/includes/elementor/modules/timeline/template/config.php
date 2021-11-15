<?php

/**
 * Timeline module config.
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

class Kata_Plus_Pro_TimeLine extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-timeline';
	}

	public function get_title()
	{
		return esc_html__('Timeline', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-time-line';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-timeline'];
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

		// Content options Start
		$this->start_controls_section(
			'section_timeline_content',
			[
				'label' => esc_html__('Timeline Settings', 'kata-plus'),
			]
		);

		// Alignment
		$this->add_control(
			'alignment',
			[
				'label'   => __('Alignment', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'kata-plus-ac',
				'options' => [
					'kata-plus-al' => __('Left', 'kata-plus'),
					'kata-plus-ac' => __('Center', 'kata-plus'),
					'kata-plus-ar' => __('Right', 'kata-plus'),
				],
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'elementor_tpl_id',
			[
				'label'       => esc_html__('Choose template', 'kata-plus'),
				'description' => esc_html__('Please head over to WP Dashboard > Templates > Saved Templates and add a template. You can then choose the template you like here.', 'kata-plus'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => $eletpls_opts,
			]
		);
		$repeater->add_control(
			'block_pos',
			[
				'label'       => __('block Position', 'kata-plus'),
				'description' => esc_html__('Functions when alignment is set to center.', 'kata-plus'),
				'classes'     => 'kata-elementor-description-error',
				'type'        => Controls_Manager::SELECT,
				'default'     => 'block-left',
				'options'     => [
					'block-left'   => __('Left', 'kata-plus'),
					'block-center' => __('Full Center', 'kata-plus'),
					'block-right'  => __('Right', 'kata-plus'),
				],
			]
		);
		$repeater->add_control(
			'icon',
			[
				'label'   => __('Choose Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/play',
			]
		);
		$repeater->add_control(
			'date',
			[
				'label' => __('Data', 'kata-plus'),
				'type'  => Controls_Manager::DATE_TIME,
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
		// Add Item
		$this->add_control(
			'timeline_item',
			[
				'label'       => esc_html__('Process Item', 'kata-plus'),
				'type'        => Controls_Manager::REPEATER,
				'description' => esc_html__('If you want this element cover whole page width, please add it inside of a full row. For this purpose, click on edit button of the row and set Select Row Type on Full Width Row.', 'kata-plus'),
				'fields'      => $repeater->get_controls(),
			]
		);

		// Style options End
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__('Styler', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_timeline',
			[
				'label'     => esc_html__('TimeLine Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-timeline'),
			]
		);
		$this->add_control(
			'styler_item_wrapper_wrapper',
			[
				'label'     => __('Item Wrapper', 'kata-plus'), // heading
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-timeline .content-wrap'),
			]
		);
		$this->add_control(
			'styler_item_wrapper_item',
			[
				'label'     => __('Item', 'kata-plus'), // heading
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-timeline .inner-content'),
			]
		);
		$this->add_control(
			'styler_item_wrapper',
			[
				'label'     => __('Content Wrapper', 'kata-plus'), // heading
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.inner-content'),
			]
		);
		$this->add_control(
			'styler_line',
			[
				'label'     => esc_html__('Line Style', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-timeline:before'),
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
			'styler_icon', // param_name
			[
				'label'     => __('Icon Style', 'kata-plus'), // heading
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.content-wrap .kata-plus-tli .kata-icon'),
			]
		);
		$this->add_control(
			'styler_content_arrow', // param_name
			[
				'label'     => __('Content Arrow Style', 'kata-plus'), // heading
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.content-wrap .inner-content:before'),
			]
		);
		$this->add_control(
			'styler_date', // param_name
			[
				'label'     => __('Date & Time Style', 'kata-plus'), // heading
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.content-wrap .kata-plus-tld'),
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
