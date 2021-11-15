<?php
/**
 * Food Menu module config.
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

class Kata_Food_Menu extends Widget_Base {
	public function get_name() {
		return 'kata-plus-food-menu';
	}

	public function get_title() {
		return esc_html__( 'Food Menu', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-food-menu';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-food-menu' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-food-menu' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Content Food Menu Settings', 'kata-plus' ),
			]
		);

		$this->add_control(
			'fm_accordion',
			[
				'label'        => __( 'Accordion', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'kata-plus' ),
				'label_off'    => __( 'Off', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'fm_stays_open',
			[
				'label'        => __( 'First Item stays open', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Open', 'kata-plus' ),
				'label_off'    => __( 'Close', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'fm_accordion' => 'yes',
				],
			]
		);

		$this->add_control(
			'fm_desc',
			[
				'label'        => __( 'Description', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'fm_image_size',
			[
				'label'   => __( 'Image Size', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'thumbnail'    => esc_html__( 'Thumbnail', 'kata-plus' ),
					'medium'       => esc_html__( 'Medium', 'kata-plus' ),
					'medium_large' => esc_html__( 'Medium Large', 'kata-plus' ),
					'large'        => esc_html__( 'Large', 'kata-plus' ),
					'full'         => esc_html__( 'Full', 'kata-plus' ),
				],
				'default' => 'thumbnail',
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'   => __( 'Currency symbol', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '$', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'fm_image',
			[
				'label'   => __( 'Choose Image', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'fm_name',
			[
				'label'   => __( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'How do I select a lawyer?', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'fm_txt',
			[
				'label'   => __( 'Text', 'kata-plus' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Our restaurant and bar are located in the heart of Saalfelden.', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'fm_cs_badge',
			[
				'label' => __( 'Badge', 'kata-plus' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'fm_cs_price',
			[
				'label' => __( 'Price', 'kata-plus' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'fm_items',
			[
				'label'       => __( 'Foods', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'fm_icon'     => __( 'fa fa-plus', 'kata-plus' ),
						'fm_name'     => __( 'Coffee Latte', 'kata-plus' ),
						'fm_txt'      => __( 'Fresh breved coffee and steamed milk', 'kata-plus' ),
						'fm_cs_price' => __( '2.95', 'kata-plus' ),
					],
					[
						'fm_icon'     => __( 'fa fa-plus', 'kata-plus' ),
						'fm_name'     => __( 'Coffee Mocha', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso With Milk, and Whopped Cream', 'kata-plus' ),
						'fm_cs_price' => __( '3.6', 'kata-plus' ),
					],
					[
						'fm_icon'     => __( 'fa fa-plus', 'kata-plus' ),
						'fm_name'     => __( 'White Chocolate Mocha', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso, WHite Chocolate, Milk, Ice and Cream', 'kata-plus' ),
						'fm_cs_price' => __( '2.79', 'kata-plus' ),
					],
					[
						'fm_icon'     => __( 'fa fa-plus', 'kata-plus' ),
						'fm_name'     => __( 'Caffe Americano', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso Shots and Light Layer of Cream', 'kata-plus' ),
						'fm_cs_price' => __( '3.06', 'kata-plus' ),
					],
					[
						'fm_icon'     => __( 'fa fa-plus', 'kata-plus' ),
						'fm_name'     => __( 'Cappuccino', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso, and Smoothed Layer of Foam', 'kata-plus' ),
						'fm_cs_price' => __( '4.03', 'kata-plus' ),
					],
					[
						'fm_icon'     => __( 'fa fa-plus', 'kata-plus' ),
						'fm_name'     => __( 'Vanilla Latte', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso Milk With Flavor, and Cream', 'kata-plus' ),
						'fm_cs_price' => __( '3.65', 'kata-plus' ),
					],

				],
				'title_field' => '{{{ fm_name }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'design_tab',
			[
				'label' => esc_html__( 'Design', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
			$repeater->add_control(
				'fm_has_link',
				[
					'label'        => esc_html__( 'Use Link', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Use', 'kata-plus' ),
					'label_off'    => esc_html__( 'No', 'kata-plus' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$repeater->add_control(
				'fm_link',
				[
					'label'         => esc_html__( 'Link', 'kata-plus' ),
					'type'          => Controls_Manager::URL,
					'show_external' => true,
					'default'       => [
						'url'         => '',
						'is_external' => true,
						'nofollow'    => true,
					],
					'condition'     => [ 'fm_has_link' => 'yes' ],
				]
			);

			$repeater->add_control(
				'fm_icon',
				[
					'label'   => esc_html__( 'Icon', 'kata-plus' ),
					'type'    => 'kata_plus_icons',
					'default' => 'font-awesome/twitter',
				]
			);

			$repeater->add_control(
				'styler_item_icon',
				[
					'label'     => esc_html__( 'Icon Style', 'kata-plus' ),
					'type'      => 'kata_styler',
					'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}' ),
				]
			);

		$this->add_control(
			'fm_item_icons',
			[
				'label'       => esc_html__( 'Add Icons', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ fm_icon }}}',
			]
		);

		$repeater = new Repeater();
			$repeater->add_control(
				'fm_item_element_title',
				[
					'label'   => esc_html__( 'Title', 'kata-plus' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'New Element',
				]
			);

			$repeater->add_control(
				'styler_fm_item_element',
				[
					'label'     => esc_html__( 'Element', 'kata-plus' ),
					'type'      => 'kata_styler',
					'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}', '.kata-food-menu:hover {{CURRENT_ITEM}}' ),
				]
			);

		$this->add_control(
			'fm_item_elements',
			[
				'label'       => esc_html__( 'Element', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{fm_item_element_title}}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'parent_food',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors( '.kata-food-menu-wrap' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
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
				'selectors' => Kata_Styler::selectors( '.kata-food-menu-wrap' ),
			]
		);

		$this->add_control(
			'styler_items',
			[
				'label'     => esc_html__( 'Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-food-menu' ),
			]
		);

		$this->add_control(
			'styler_image',
			[
				'label'     => esc_html__( 'Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-food-menu-image img', '.kata-food-menu:hover .kata-food-menu-image img' ),
			]
		);

		$this->add_control(
			'styler_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-food-menu-btn', '.kata-food-menu:hover .kata-food-menu-btn' ),
			]
		);

		$this->add_control(
			'styler_description',
			[
				'label'     => esc_html__( 'Description', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-food-menu-content p', '.kata-food-menu:hover .kata-food-menu-content p' ),
			]
		);
		$this->add_control(
			'styler_price',
			[
				'label'     => esc_html__( 'Price', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-food-menu-price', '.kata-food-menu:hover .kata-food-menu-price' , '.kata-food-menu' ),
			]
		);
		$this->add_control(
			'styler_badge',
			[
				'label'     => esc_html__( 'Badge', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-food-menu-badge', '.kata-food-menu:hover .kata-food-menu-badge' , '.kata-food-menu' ),
			]
		);
		$this->add_control(
			'styler_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-food-menu-btn .kata-icon', '.kata-food-menu:hover .kata-food-menu-btn .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_currency_symbol',
			[
				'label'     => esc_html__( 'Currency symbol', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors( '.kata-food-menu-price .currency-symbol' ),
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
