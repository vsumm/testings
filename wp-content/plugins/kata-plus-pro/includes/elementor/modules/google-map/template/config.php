<?php

/**
 * Google Map module config.
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
use Elementor\Repeater;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;

class Kata_Plus_Pro_GoogleMap extends Widget_Base
{

	public function get_name()
	{
		return 'kata-plus-googlemap';
	}

	public function get_title()
	{
		return esc_html__('Google Map', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-google-maps';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-googlemap-api', 'kata-plus-googlemap-js'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-google-map'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__('General', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'map',
			[
				'label'   => __('Map', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'map_address',
				'options' => [
					'map_embed'   => __('Embed', 'kata-plus'),
					'map_address' => __('Address', 'kata-plus'),
				],
			]
		);

		$this->add_control(
			'em_iframe',
			[
				'label' => __('Paste the iframe here', 'kata-plus'),
				'type' => Controls_Manager::CODE,
				'language' => 'html',
				'rows' => 10,
				'default' => ('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193595.1583088633!2d-74.11976388352468!3d40.69766374868615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2suk!4v1559823774354!5m2!1sen!2suk" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>'),
				'condition' => [
					'map' => ['map_embed'],
				],
			]
		);

		$this->add_control(
			'lat',
			[
				'label'     => __('Latitude', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => '40.712776',
				'condition' => [
					'map' => ['map_address'],
				],
			]
		);

		$this->add_control(
			'long',
			[
				'label'     => __('Longitude', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => '-74.005974',
				'condition' => [
					'map' => ['map_address'],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_template',
			[
				'label' => esc_html__('Section Template', 'kata-plus'),
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
			'map_template',
			[
				'label'   => __('Choose template content', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $eletpls_opts,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'map_settings',
			[
				'label' => esc_html__('Map Settings', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'map' => ['map_address'],
				],
			]
		);
		$this->add_control(
			'map_width',
			[
				'label'      => __('Width', 'kata-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max' => 1500,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} #kata-google-map' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'map_height',
			[
				'label'      => __('Height', 'kata-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max' => 1500,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'selectors'  => [
					'{{WRAPPER}} #kata-google-map' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'map_zoom',
			[
				'label'      => __('Zoom', 'kata-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 10,
				],
			]
		);
		$this->add_control(
			'map_layer',
			[
				'label'     => __('Map Layer', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => [
					'transit' => __('Transit Layer', 'kata-plus'),
					'bicycle' => __('Bicycle Layer', 'kata-plus'),
					'traffic' => __('Traffic Layer', 'kata-plus'),
					'none'    => __('None', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'map_style',
			[
				'label'     => __('Map Style', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'standard',
				'options'   => [
					'standard'  => __('Standard', 'kata-plus'),
					'silver'    => __('Silver', 'kata-plus'),
					'retro'     => __('Retro', 'kata-plus'),
					'dark'      => __('Dark', 'kata-plus'),
					'night'     => __('Night', 'kata-plus'),
					'aubergine' => __('Aubergine', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'gestureHandling',
			[
				'label'     => __('gestureHandling', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cooperative',
				'options'   => [
					'cooperative' => __('Crtl + Scroll', 'kata-plus'),
					'greedy'      => __('Zoom', 'kata-plus'),
					'none'        => __('None', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'map_marker',
			[
				'label'     => __('Marker', 'kata-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'google_default',
				'options'   => [
					'google_default' => __('Google Default', 'kata-plus'),
					'marker_img'     => __('Image', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'map_marker_image',
			[
				'label'     => __('Map Marker Image', 'kata-plus'),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'map_marker' => ['marker_img'],
				],
			]
		);
		$this->add_control(
			'animate_marker',
			[
				'label'        => __('Animate the Marker', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'true',
				'default'      => '',
			]
		);
		$this->add_control(
			'zoom_controller',
			[
				'label'        => __('Zoom controller', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);
		$this->add_control(
			'map_type_controller',
			[
				'label'        => __('Map Type controller', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);
		$this->add_control(
			'fullscreen_controller',
			[
				'label'        => __('Fullscreen controller', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);
		$this->add_control(
			'streetview_controller',
			[
				'label'        => __('Street view controller', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Show', 'kata-plus'),
				'label_off'    => __('Hide', 'kata-plus'),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'address_section',
			[
				'label'     => __('Address', 'kata-plus'),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'map' => ['map_address'],
				],
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'address_title',
			[
				'label'       => __('Title', 'kata-plus'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Address', 'kata-plus'),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'address_lat',
			[
				'label'       => __('Latitude', 'kata-plus'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '40.712776',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'address_long',
			[
				'label'       => __('Longitude', 'kata-plus'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '-74.005974',
				'label_block' => true,
			]
		);
		$this->add_control(
			'address_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => 'Address',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'map_styler_wrapper',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_desc',
			[
				'label'     		=> esc_html__('Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-google-map'),
			]
		);
		$this->add_control(
			'ineer_wrapper',
			[
				'label'     		=> esc_html__('Inner Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('#kata-google-map'),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__('Styler', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs('filters');
		$this->start_controls_tab(
			'map_normal',
			[
				'label' => __('Normal', 'kata-plus'),
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} iframe,{{WRAPPER}} #kata-google-map',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'map_hover',
			[
				'label' => __('Hover', 'kata-plus'),
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} iframe,{{WRAPPER}} #kata-google-map:hover',
			]
		);
		$this->add_control(
			'transition',
			[
				'label'     => __('Transition', 'kata-plus'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} iframe,{{WRAPPER}} #kata-google-map' => 'transition-duration: {{SIZE}}s',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'styler_sec_template',
			[
				'label'     		=> esc_html__('Section Template', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-google-map .kata-map-template'),
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
