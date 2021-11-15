<?php

/**
 * Text module config.
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

class Kata_Plus_Text extends Widget_Base {

	public function get_name() {
		return 'kata-plus-text';
	}

	public function get_title() {
		return esc_html__('Text', 'kata-plus');
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-text';
	}

	public function get_script_depends() {
		return ['kata-jquery-enllax'];
	}

	public function get_categories() {
		return ['kata_plus_elementor_most_usefull'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__('Text Settings', 'kata-plus'),
			]
		);
		$this->add_control(
			'text_editor',
			[
				'label'		=> __('Text Editor', 'kata-plus'),
				'type'		=> Controls_Manager::CHOOSE,
				'options'	=> [
					'text' => [
						'title' => __('Textarea', 'kata-plus'),
						'icon'	=> 'eicon-text-area',
					],
					'text_mce' => [
						'title' => __('TinyMCE', 'kata-plus'),
						'icon'	=> 'fa fa-paragraph',
					],
				],
				'default'	=> 'text_mce',
				'toggle'	=> false,
			]
		);
		$this->add_control(
			'text',
			[
				'label'		=> __('Text', 'kata-plus'),
				'type'		=> Controls_Manager::TEXTAREA,
				'default'	=> __('Default description textarea', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
				'condition'	=> [
					'text_editor' => 'text'
				]
			]
		);
		$this->add_control(
			'text_mce',
			[
				'label'			=> __('Text', 'kata-plus'),
				'type'			=> Controls_Manager::WYSIWYG,
				'default'		=> __('Default description TinyMCE', 'kata-plus'),
				'condition'	=> [
					'text_editor' => 'text_mce'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_wrapper',
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
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text'),
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
			'styler_textdiv',
			[
				'label'     		=> esc_html__('Div', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text div'),
			]
		);
		$this->add_control(
			'styler_textp',
			[
				'label'     		=> esc_html__('Paragraph', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text p'),
			]
		);
		$this->add_control(
			'styler_text1',
			[
				'label'     		=> esc_html__('Heading 1', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text h1'),
			]
		);
		$this->add_control(
			'styler_text2',
			[
				'label'     		=> esc_html__('Heading 2', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text h2'),
			]
		);
		$this->add_control(
			'styler_text3',
			[
				'label'     		=> esc_html__('Heading 3', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text h3'),
			]
		);
		$this->add_control(
			'styler_text4',
			[
				'label'     		=> esc_html__('Heading 4', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text h4'),
			]
		);
		$this->add_control(
			'styler_text5',
			[
				'label'     		=> esc_html__('Heading 5', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text h5'),
			]
		);
		$this->add_control(
			'styler_text6',
			[
				'label'     		=> esc_html__('Heading 6', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text h6'),
			]
		);
		$this->add_control(
			'styler_textspan',
			[
				'label'     		=> esc_html__('Span', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text span'),
			]
		);
		$this->add_control(
			'styler_textstrong',
			[
				'label'     		=> esc_html__('Strong', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text strong, .kata-plus-text b'),
			]
		);
		$this->add_control(
			'styler_texta',
			[
				'label'     		=> esc_html__('Link', 'kata-plus'),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors('.kata-plus-text a'),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname(__FILE__) . '/view.php';
	}
}
