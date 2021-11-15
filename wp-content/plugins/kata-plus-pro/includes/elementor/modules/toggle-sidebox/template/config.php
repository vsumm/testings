<?php

/**
 * Toggle SideBox module config.
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

class Kata_Plus_Pro_Toggle_SideBox extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-toggle-sidebox';
	}

	public function get_title()
	{
		return esc_html__('Toggle Sidebox', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-h-align-left';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-toggle-sidebox'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-toggle-sidebox'];
	}

	protected function register_controls()
	{
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('General', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
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

		$this->add_control(
			'toggle_from',
			[
				'label'   => __('Toggle', 'kata-plus'),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left-to-right' => [
						'title' => __('Left to right', 'kata-plus'),
						'icon'  => 'fa fa-arrow-right',
					],
					'right-to-left' => [
						'title' => __('Right to left', 'kata-plus'),
						'icon'  => 'fa fa-arrow-left',
					],
					'top-to-bottom' => [
						'title' => __('Top to bottom', 'kata-plus'),
						'icon'  => 'fa fa-arrow-down',
					],
					'bottom-to-top' => [
						'title' => __('Bottom to top', 'kata-plus'),
						'icon'  => 'fa fa-arrow-up',
					],
				],
				'default' => 'left-to-right',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'box_text',
			[
				'label'   => esc_html__('Box Text', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Custom Text', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'box_icon',
			[
				'label'   => __('Box Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/angle-right',
			]
		);

		$this->add_control(
			'box_icon_close',
			[
				'label'   => __('Close Icon', 'kata-plus'),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/angle-left',
			]
		);

		$this->add_control(
			'icon_location',
			[
				'label'       => esc_html__('Icon Location', 'kata-plus'),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'before-text' => esc_html__('Before Text', 'kata-plus'),
					'after-text'  => esc_html__('After Text', 'kata-plus'),
				],
				'default'     => 'after-text',
			]
		);

		$this->add_control(
			'box_content',
			[
				'description' => esc_html__('Please head over to WP Dashboard > Templates > Saved Templates and add a template. You can then choose the template you like here.', 'kata-plus'),
				'label'   => esc_html__('Content', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'options' => $eletpls_opts,
			]
		);

		$this->add_control(
			'content_width_ltr',
			[
				'label'      => __('Width', 'kata-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1900,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 350,
				],
				'selectors'  => [
					'{{WRAPPER}} .toggle-sidebox-content:not(.open-toggle)' => 'transform: translateX(-{{SIZE}}{{UNIT}});-ms-transform: translateX(-{{SIZE}}{{UNIT}});-webkit-transform: translateX(-{{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .toggle-sidebox-content' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .toggle-sidebox-trigger.open-toggle' => 'transform: translateX({{SIZE}}{{UNIT}});-ms-transform: translateX({{SIZE}}{{UNIT}});-webkit-transform: translateX({{SIZE}}{{UNIT}});',
				],
				'condition'  => [
					'toggle_from' => 'left-to-right',
				],
			]
		);

		$this->add_control(
			'content_width_rtl',
			[
				'label'      => __('Width', 'kata-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1900,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 350,
				],
				'selectors'  => [
					'{{WRAPPER}} .toggle-sidebox-content:not(.open-toggle)' => 'transform: translateX({{SIZE}}{{UNIT}});-ms-transform: translateX({{SIZE}}{{UNIT}});-webkit-transform: translateX({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .toggle-sidebox-content' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .toggle-sidebox-trigger.open-toggle' => 'transform: translateX(-{{SIZE}}{{UNIT}});-ms-transform: translateX(-{{SIZE}}{{UNIT}});-webkit-transform: translateX(-{{SIZE}}{{UNIT}});',
				],
				'condition'  => [
					'toggle_from' => 'right-to-left',
				],
			]
		);

		$this->add_control(
			'content_height_ttb',
			[
				'label'      => __('Height', 'kata-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1900,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 480,
				],
				'selectors'  => [
					'{{WRAPPER}} .toggle-sidebox-content:not(.open-toggle)' => 'transform: translateY(-{{SIZE}}{{UNIT}});-ms-transform: translateY(-{{SIZE}}{{UNIT}});-webkit-transform: translateY(-{{SIZE}}{{UNIT}})',
					'{{WRAPPER}} .toggle-sidebox-content' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .toggle-sidebox-trigger.open-toggle' => 'transform: translateY({{SIZE}}{{UNIT}});-ms-transform: translateY({{SIZE}}{{UNIT}});-webkit-transform: translateY({{SIZE}}{{UNIT}});',
				],
				'condition'  => [
					'toggle_from' => 'top-to-bottom',
				],
			]
		);

		$this->add_control(
			'content_height_btt',
			[
				'label'      => __('Height', 'kata-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1900,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 480,
				],
				'selectors'  => [
					'{{WRAPPER}} .toggle-sidebox-content:not(.open-toggle)' => 'transform: translateY({{SIZE}}{{UNIT}});-ms-transform: translateY({{SIZE}}{{UNIT}});-webkit-transform: translateY({{SIZE}}{{UNIT}})',
					'{{WRAPPER}} .toggle-sidebox-content' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .toggle-sidebox-trigger.open-toggle' => 'transform: translateY(-{{SIZE}}{{UNIT}});-ms-transform: translateY(-{{SIZE}}{{UNIT}});-webkit-transform: translateY(-{{SIZE}}{{UNIT}});',
				],
				'condition'  => [
					'toggle_from' => 'bottom-to-top',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__('Styler', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_tb',
			[
				'label'     => esc_html__('Trigger Box', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.toggle-sidebox-trigger'),
			]
		);

		$this->add_control(
			'styler_tbt',
			[
				'label'     => esc_html__('Trigger Text', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.toggle-sidebox-trigger .toggle-sidebox-trigger-text'),
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
			'styler_tbi',
			[
				'label'     => esc_html__('Trigger Box Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.toggle-sidebox-trigger i'),
			]
		);

		$this->add_control(
			'styler_content',
			[
				'label'     => esc_html__('Content', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.toggle-sidebox-content'),
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
