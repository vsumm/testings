<?php
/**
 * Essential Grid module config.
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

class Kata_Plus_Pro_EssentialGrid extends Widget_Base {
	public function get_name() {
		return 'kata-plus-essential-grid';
	}

	public function get_title() {
		return esc_html__( 'Essential Grid', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	// public function get_style_depends() {
	// 	return [ 'essential-grid-plugin-settings', 'tp-fontello', 'themepunchboxextcss' ];
	// }

	public function get_script_depends() {
		return [ 'tp-tools', 'essential-grid-essential-grid-script', 'themepunchboxext' ];
	}

	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Settings', 'kata-plus' ),
			]
		);
		$order = [
			'handle' 		=> 'ASC',
			'last_modified' => 'ASC',
			'favorite' 		=> 'ASC',
			'id' 			=> 'ASC',
			'name' 			=> 'ASC',
		];
		$grids = Essential_Grid::get_essential_grids($order, false);
		$my_grids = ['none' => __( 'Select', 'kata-plus')];
		if ( !empty($grids) && is_array($grids) ) {
			$i = 0;
			foreach ( $grids as $grid ) {
				$my_grids[$grid->handle] = $grid->name;
			}
		} else {
			$my_grids['none'] = __( 'No contact forms found', 'kata-plus' );
		}

		$this->add_control(
			'ess_grids',
			[
				'label'   => __( 'Please select your desired Grid', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => $my_grids,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_form_wrap',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-essential-grid' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_filters',
			[
				'label' => esc_html__( 'Filters', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_filters_wrappers',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-filters' ),
			]
		);
		$this->add_control(
			'styler_filters_item',
			[
				'label'     => esc_html__( 'Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-filterbutton' ),
			]
		);
		$this->add_control(
			'styler_filters_selected_item',
			[
				'label'     => esc_html__( 'Selected Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-filterbutton.selected ' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_pagination',
			[
				'label' => esc_html__( 'Pagination', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_paginations',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-loadmore-wrapper' ),
			]
		);
		$this->add_control(
			'styler_loarmore',
			[
				'label'     => esc_html__( 'Load More Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-navigationbutton.esg-loadmore' ),
			]
		);
		$this->add_control(
			'styler_pagination_wrapper',
			[
				'label'     => esc_html__( 'Pagination', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-pagination' ),
			]
		);
		$this->add_control(
			'styler_pagination_item',
			[
				'label'     => esc_html__( 'Pagination Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-navigationbutton.esg-pagination-button' ),
			]
		);
		$this->add_control(
			'styler_pagination_selected_item',
			[
				'label'     => esc_html__( 'Selected Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.esg-filterbutton.selected' ),
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
