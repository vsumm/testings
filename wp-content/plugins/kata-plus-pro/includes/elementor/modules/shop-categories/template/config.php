<?php
/**
 * Categories List module config.
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

class Kata_Plus_Pro_Shop_Categories extends Widget_Base {
	public function get_name() {
		return 'kata-plus-shop-categories';
	}

	public function get_title() {
		return esc_html__( 'Shop Categories', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-editor-list-ul';
	}

	public function get_style_depends() {
		return [ 'kata-plus-shop-categories' ];
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_blog_and_post' ];
	}

	protected function register_controls() {

		// Content options Start
		$this->start_controls_section(
			'list_content',
			[
				'label' => __( 'Kata List', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'list',
				'options' => [
					'list'     => __( 'list', 'kata-plus' ),
					'dropdown' => __( 'dropdown', 'kata-plus' ),
					'inline'   => __( 'inline', 'kata-plus' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_container',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'list_style',
			[
				'label'     => esc_html__( 'List Style', 'kata-plus' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'list',
				],
			]
		);
		$this->add_control(
			'item_style',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories li' ),
			]
		);
		$this->add_control(
			'item_link_style',
			[
				'label'     => esc_html__( 'Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories li a' ),
			]
		);
		$this->add_control(
			'current_item_style',
			[
				'label'     => esc_html__( 'Current Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories li.current-cat' ),
			]
		);
		$this->add_control(
			'post_count_style',
			[
				'label'     => esc_html__( 'Post Count', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories li .kata-post-count' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'dropdown_style',
			[
				'label'     => esc_html__( 'Dropdown Style', 'kata-plus' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'dropdown',
				],
			]
		);
		$this->add_control(
			'select',
			[
				'label'     => esc_html__( 'Select', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories select' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'inline_style',
			[
				'label'     => esc_html__( 'Inline Style', 'kata-plus' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'inline',
				],
			]
		);
		$this->add_control(
			'inline_item_style',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories span' ),
			]
		);
		$this->add_control(
			'inline_item_link_style',
			[
				'label'     => esc_html__( 'Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shop-categories span a' ),
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
