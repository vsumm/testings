<?php
/**
 * List module config.
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
use Elementor\Repeater;

class Kata_Plus_List extends Widget_Base {
	public function get_name() {
		return 'kata-plus-list';
	}

	public function get_title() {
		return esc_html__( 'List', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-editor-list-ul';
	}

	public function get_style_depends() {
		return [ 'kata-plus-list' ];
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
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

		$repeater = new Repeater();

		$repeater->add_control(
			'list_title',
			[
				'label'   => __( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'List Title', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'list_description',
			[
				'label'   => __( 'Description ', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Description', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'list_link',
			[
				'label'         => __( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'kata-plus' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$repeater->add_control(
			'list_icon',
			[
				'label'   => __( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/wordpress',
			]
		);

		$this->add_control(
			'list',
			[
				'label'       => __( 'Items', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'list_title'    => __( 'Themes', 'kata-plus' ),
						'list_description' => __( 'Want to learn how to start theming WordPress?', 'kata-plus' ),
					],
					[
						'list_title'    => __( 'Plugins', 'kata-plus' ),
						'list_description' => __( 'Ready to dive deep into the world of plugin authoring?', 'kata-plus' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_container',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-list' ),
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-list li' ),
			]
		);
		$this->add_control(
			'styler_item_first_item',
			[
				'label'     => esc_html__( 'First Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-list li:first-child' ),
			]
		);
		$this->add_control(
			'styler_item_last_item',
			[
				'label'     => esc_html__( 'Last Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-list li:last-child' ),
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-lists .list-title' ),
			]
		);
		$this->add_control(
			'styler_description',
			[
				'label'     => esc_html__( 'Description', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-list li .list-description' ),
			]
		);

		$this->add_control(
			'styler_icon_wrapper',
			[
				'label'     => esc_html__( 'Icon Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-list .list-icon-wrapper' ),
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
			'styler_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-list .kata-icon' ),
			]
		);
		// Style options End
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
