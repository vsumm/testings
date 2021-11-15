<?php

/**
 * Sticky box module config.
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
use Elementor\Plugin;

class Kata_Plus_Pro_Sticky_Box extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-sticky-box';
	}

	public function get_title()
	{
		return esc_html__('Sticky Box', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-section';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-sticky-box'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-sticky-box'];
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

		// Content Tab
		$this->start_controls_section(
			'box_section',
			[
				'label' => esc_html__('Sticky Box', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'item',
			[
				'label'   => __('Select Item', 'kata-plus'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $eletpls_opts,
			]
		);

		$this->add_responsive_control(
			'item_pos',
			[
				'label'        => __('Box Position', 'kata-plus'),
				'type'         => Controls_Manager::SELECT,
				'options'      => [
					'left'   => __('Left', 'kata-plus'),
					'right'  => __('Right', 'kata-plus'),
					'top'    => __('Top', 'kata-plus'),
					'bottom' => __('Bottom', 'kata-plus'),
				],
				'return_value' => 'true',
				'default'      => 'top',
				'devices'      => ['desktop', 'tablet', 'mobile'],
			]
		);

		$this->add_control(
			'just_sec',
			[
				'label'        => __('Sticky Just In Parrent Section', 'kata-plus'),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__('Styler', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_wrap',
			[
				'label'     => __('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-sticky-box'),
			]
		);

		$this->add_control(
			'styler_sticky',
			[
				'label'     => 'Sticky',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-sticky-box.sticky'),
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
