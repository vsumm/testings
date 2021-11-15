<?php
/**
 * Food Menu Toggle module config.
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
use Elementor\Utils;

class Kata_Food_menu_Toggle extends Widget_Base {
	public function get_name() {
		return 'kata-plus-food-menu-toggle';
	}

	public function get_title() {
		return esc_html__( 'Food Menu Toggle', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-food-menu-toggle';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-food-menu-toggle' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-food-menu-toggle' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Food Menu Toggle', 'kata-plus' ),
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
				'default' => 'full',
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
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'image_title',
			[
				'label'   => __( 'Image Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Coffee', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'image_link',
			[
				'label'       => __( 'Details Link', 'kata-plus' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'kata-plus' ),
				'show_external' => true,
				'default' => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'link_title',
			[
				'label'   => __( 'Link Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'View Details', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'fm_name',
			[
				'label'   => __( 'Food Title', 'kata-plus' ),
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
				'label'   => __( 'Food Description', 'kata-plus' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Our restaurant and bar are located in the heart of Saalfelden.', 'kata-plus' ),
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
						'fm_name'     => __( 'Coffee Latte', 'kata-plus' ),
						'fm_txt'      => __( 'Fresh breved coffee and steamed milk', 'kata-plus' ),
						'fm_cs_price' => __( '2.95', 'kata-plus' ),
					],
					[
						'fm_name'     => __( 'Coffee Mocha', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso With Milk, and Whopped Cream', 'kata-plus' ),
						'fm_cs_price' => __( '3.6', 'kata-plus' ),
					],
					[
						'fm_name'     => __( 'White Chocolate Mocha', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso, WHite Chocolate, Milk, Ice and Cream', 'kata-plus' ),
						'fm_cs_price' => __( '2.79', 'kata-plus' ),
					],
					[
						'fm_name'     => __( 'Caffe Americano', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso Shots and Light Layer of Cream', 'kata-plus' ),
						'fm_cs_price' => __( '3.06', 'kata-plus' ),
					],
					[
						'fm_name'     => __( 'Cappuccino', 'kata-plus' ),
						'fm_txt'      => __( 'Espresso, and Smoothed Layer of Foam', 'kata-plus' ),
						'fm_cs_price' => __( '4.03', 'kata-plus' ),
					],
					[
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
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_left_side',
			[
				'label' => esc_html__( 'Left side', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_left_side',
			[
				'label'     => esc_html__( 'Left side', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .left-side-food' ),
			]
		);
		$this->add_control(
			'styler_food_content_wrapper',
			[
				'label'     => esc_html__( 'Food content wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu' ),
			]
		);
		$this->add_control(
			'styler_food_title',
			[
				'label'     => esc_html__( 'Food title', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu-btn' ),
			]
		);
		$this->add_control(
			'styler_food_description',
			[
				'label'     => esc_html__( 'Food description', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu-content p' ),
			]
		);
		$this->add_control(
			'styler_food_price',
			[
				'label'     => esc_html__( 'Food price', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu-price' ),
			]
		);
		$this->add_control(
			'styler_currency_symbol',
			[
				'label'     => esc_html__( 'Currency symbol', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .currency-symbol' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'active_item',
			[
				'label' => esc_html__( 'Active Item', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_active',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu.active .kata-food-menu-btn' ),
			]
		);
		$this->add_control(
			'content_active',
			[
				'label'     => esc_html__( 'Content', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu.active .kata-food-menu-content p' ),
			]
		);
		$this->add_control(
			'price_active',
			[
				'label'     => esc_html__( 'Price', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu.active .kata-food-menu-price' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_right_side',
			[
				'label' => esc_html__( 'Right side', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_right_side',
			[
				'label'     => esc_html__( 'Right side', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .right-side-food' ),
			]
		);
		$this->add_control(
			'styler_image',
			[
				'label'     => esc_html__( 'Image', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .kata-food-menu-image img' ),
			]
		);
		$this->add_control(
			'styler_image_details',
			[
				'label'     => esc_html__( 'Image details wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .image-details' ),
			]
		);
		$this->add_control(
			'styler_image_description',
			[
				'label'     => esc_html__( 'Image description', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .image-title' ),
			]
		);
		$this->add_control(
			'styler_image_view_details',
			[
				'label'     => esc_html__( 'View Details', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-food-menu-toggle .image-link a' ),
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
