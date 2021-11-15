<?php

/**
 * Content Toggle module config.
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
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Content_Toggle extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-content-toggle';
	}

	public function get_title()
	{
		return esc_html__('Content Toggle', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-content-toggle';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor'];
	}

	public function get_script_depends()
	{
		return ['kata-plus-content-toggle'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-content-toggle'];
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
		$this->add_control(
			'placeholder',
			[
				'label'		=> __('Placeholder', 'kata-plus'),
				'type'		=> Controls_Manager::CHOOSE,
				'default'	=> 'icon',
				'toggle'	=> true,
				'options'	=> [
					'image'	=> [
						'title'	=> __('Image', 'kata-plus'),
						'icon'	=> 'fa fa-image',
					],
					'icon'	=> [
						'title'	=> __('Icon', 'kata-plus'),
						'icon'	=> 'fas fa-icons',
					],
					'text'	=> [
						'title'	=> __('Text', 'kata-plus'),
						'icon'	=> 'fas fa-align-left',
					],
				],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __('Image/SVG', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
				'condition' => [
					'placeholder' => [
						'image',
					],
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'   => __('Choose Image', 'kata-plus'),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'placeholder' => [
						'image', 'svg',
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
				'condition' => [
					'placeholder' => [
						'image',
					],
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/align-justify',
				'condition' => [
					'placeholder' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'text',
			[
				'label'     => esc_html__('Text', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => __('Login', 'kata-plus'),
				'condition' => [
					'placeholder' => [
						'text',
					],
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$get_templates	= Plugin::instance()->templates_manager->get_source('local')->get_items();
		$templates		= [
			'0' => __('Elementor template is not defined yet.', 'kata-plus'),
		];
		if (!empty($get_templates)) {
			$templates = [
				'0' => __('Select elementor template', 'kata-plus'),
			];
			foreach ($get_templates as $template) {
				$templates[$template['title']] = $template['title'] . ' (' . $template['type'] . ')';
			}
		}
		$this->add_control(
			'content_toggle_template',
			[
				'label'       => esc_html__('Choose template', 'kata-plus'),
				'description' => esc_html__('Please head over to WP Dashboard > Templates > Saved Templates and add a template. You can then choose the template you like here.', 'kata-plus'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => $templates,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrapper',
			[
				'label'     		=> esc_html__('Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling_placeholder',
			[
				'label' => esc_html__('Placeholder', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_placeholder_wrapper',
			[
				'label'     		=> esc_html__('Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-toggle-click'),
			]
		);
		$this->add_control(
			'styler_placeholder_image',
			[
				'label'     		=> esc_html__('Image', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-toggle-click img'),
			]
		);
		$this->add_control(
			'styler_placeholder_icon',
			[
				'label'     		=> esc_html__('Icon', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-toggle-click i'),
			]
		);
		$this->add_control(
			'styler_placeholder_text',
			[
				'label'     		=> esc_html__('Text', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-toggle-click .content-toggle-text'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling_toggle',
			[
				'label' => esc_html__('Toggle Content', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_toggle_wrapper',
			[
				'label'     		=> esc_html__('Wrapper', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-content-toggle-content-wrap'),
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
