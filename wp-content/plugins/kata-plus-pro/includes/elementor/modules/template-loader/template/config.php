<?php
/**
 * Template Loader module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

class Kata_Plus_Template_Loader extends Widget_Base {
	public function get_name() {
		return 'kata-plus-template-loader';
	}

	public function get_title() {
		return esc_html__( 'Template Loader', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-template-loader';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}
	
	public function get_script_depends() {
		return [ 'kata-plus-template-loader' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
			'template',
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
			'styles_section',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_post_title',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-template-loader' ),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
