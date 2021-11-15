<?php
/**
 * Dark Mode Switcher module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Repeater;

class Kata_Plus_Pro_DarkMode_Switcher extends Widget_Base {
	public function get_name() {
		return 'kata-plus-darkmode-switcher';
	}

	public function get_title() {
		return esc_html__( 'Dark Mode Switcher', 'kata-plus-pro' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-darkmode-switcher';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-frontend-darkmode', 'kata-dark-mode', 'kata-dark-mode-config' ];
	}

	public function get_style_depends() {
		return [ 'kata-dark-mode' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'wrapper',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dark_mode_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus-pro'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-darkmode-switcher'),
			]
		);
		$this->add_control(
			'dark_mode_container',
			[
				'label'     => esc_html__('Container', 'kata-plus-pro'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.wp-dark-mode-switcher'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'icons',
			[
				'label' => esc_html__('Icon', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dark_mode_moon',
			[
				'label'     => esc_html__('Moon Icon', 'kata-plus-pro'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.moon'),
			]
		);
		$this->add_control(
			'dark_mode_sun',
			[
				'label'     => esc_html__('Sun Icon', 'kata-plus-pro'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.sun'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'active_icons',
			[
				'label' => esc_html__('Active Icon', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dark_mode_moon_active',
			[
				'label'     => esc_html__('Moon Icon', 'kata-plus-pro'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.active .moon'),
			]
		);
		$this->add_control(
			'dark_mode_sun_active',
			[
				'label'     => esc_html__('Sun Icon', 'kata-plus-pro'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.active .sun'),
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
