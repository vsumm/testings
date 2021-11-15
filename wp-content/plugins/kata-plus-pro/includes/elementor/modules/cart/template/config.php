<?php
/**
 * Cart module config.
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

class Kata_Cart extends Widget_Base {
	public function get_name() {
		return 'kata-plus-cart';
	}

	public function get_title() {
		return esc_html__( 'Cart', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-cart';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_header' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-cart' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-cart' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Cart Settings', 'kata-plus' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => '7-stroke/cart',
			]
		);
		$this->add_control(
			'headercart',
			[
				'label'       => __( 'Header cart text', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Items In Shopping Bag', 'kata-plus' ),
				'default'     => __( 'Items In Shopping Bag', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-cart-icon-wrap .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_cart_cart_wrap',
			[
				'label'     => esc_html__( 'Cart wrap', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .kata-plus-cart' ),
			]
		);
		$this->add_control(
			'styler_cart_item_count',
			[
				'label'     => esc_html__( 'Cart item count', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-cart-icon-wrap span.count' ),
			]
		);
		$this->add_control(
			'styler_header_cart',
			[
				'label'     => esc_html__( 'Header cart', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .cart-items-count.count' ),
			]
		);
		$this->add_control(
			'styler_no_product',
			[
				'label'     => esc_html__( 'No product', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart .woocommerce-mini-cart__empty-message' ),
			]
		);
		$this->add_control(
			'styler_cart_item_wrap',
			[
				'label'     => esc_html__( 'Cart items wrap', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .woocommerce-mini-cart' ),
			]
		);
		$this->add_control(
			'styler_cart_item',
			[
				'label'     => esc_html__( 'Cart item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap li' ),
			]
		);
		$this->add_control(
			'styler_cart_item_remove',
			[
				'label'     => esc_html__( 'Remove cart item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap li a.remove' ),
			]
		);
		$this->add_control(
			'styler_cart_item_thumb',
			[
				'label'     => esc_html__( 'Cart item thumbnail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap li img' ),
			]
		);
		$this->add_control(
			'styler_cart_item_title',
			[
				'label'     => esc_html__( 'Cart item title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap li a.remove+a' ),
			]
		);
		$this->add_control(
			'styler_cart_item_qty',
			[
				'label'     => esc_html__( 'Cart Item quantity', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap li .quantity' ),
			]
		);
		$this->add_control(
			'styler_cart_subtotal',
			[
				'label'     => esc_html__( 'Subtotal wrap', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .woocommerce-mini-cart__total.total' ),
			]
		);
		$this->add_control(
			'styler_cart_subtotal_text',
			[
				'label'     => esc_html__( 'Subtotal text', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .total strong' ),
			]
		);
		$this->add_control(
			'styler_cart_subtotal_price',
			[
				'label'     => esc_html__( 'Subtotal price', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .total span' ),
			]
		);
		$this->add_control(
			'styler_cart_buttons_wrap',
			[
				'label'     => esc_html__( 'Buttons wrap', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .buttons' ),
			]
		);
		$this->add_control(
			'styler_cart_buttons',
			[
				'label'     => esc_html__( 'Buttons', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-cart-wrap .buttons a' ),
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
