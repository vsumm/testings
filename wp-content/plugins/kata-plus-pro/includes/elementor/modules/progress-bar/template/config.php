<?php
/**
 * Progress Bar module config.
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
use Elementor\Repeater;

class Kata_Progress_Bar extends Widget_Base {
	public function get_name() {
		return 'kata-plus-progress-bar';
	}

	public function get_title() {
		return esc_html__( 'Progress Bar', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-skill-bar';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-progress-bar' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-progress-bar' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_progress_bar',
			[
				'label' => esc_html__( 'Progress Bar Settings', 'kata-plus' ),
			]
		);

		$progress_bar = new Repeater();

		$progress_bar->add_control(
			'title', [
				'label'       => __( 'Title', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'HTML' , 'kata-plus' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$progress_bar->add_control(
			'counter',
			[
				'label' => __( 'Counter', 'kata-plus' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
			]
		);

		$this->add_control(
			'bars',
			[
				'label' => __( 'Progress Bar', 'kata-plus' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $progress_bar->get_controls(),
				'default' => [
					[
						'title' => __( 'HTML', 'kata-plus' ),
						'counter' => __( '90%', 'kata-plus' ),
					],
					[
						'title' => __( 'CSS', 'kata-plus' ),
						'counter' => __( '70%', 'kata-plus' ),
					],
					[
						'title' => __( 'JS', 'kata-plus' ),
						'counter' => __( '60%', 'kata-plus' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'progress_styling',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-progress-bar' ),
			]
		);

		$this->add_control(
			'styler_label',
			[
				'label'     => esc_html__( 'Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-progress-bar p' ),
			]
		);

		$this->add_control(
			'styler_counter',
			[
				'label'     => esc_html__( 'Counter', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-progress-bar p span' ),
			]
		);

		$this->add_control(
			'styler_bar_wrapper',
			[
				'label'     => esc_html__( 'Bar wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-progress-bar .bar-wrapper' ),
			]
		);

		$this->add_control(
			'styler_bar',
			[
				'label'     => esc_html__( 'Bar', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-progress-bar .bar' ),
			]
		);

		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
