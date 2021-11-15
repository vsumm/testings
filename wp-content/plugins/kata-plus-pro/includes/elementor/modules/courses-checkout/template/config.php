<?php
/**
 * Courses module config.
 *
 * @teacher  ClimaxThemes
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

if ( ! class_exists( 'Kata_Plus_Pro_LP_Checkout' ) ) {
	class Kata_Plus_Pro_LP_Checkout extends Widget_Base {
		public function get_name() {
			return 'kata-plus-lp-checkout';
		}

		public function get_title() {
			return esc_html__( 'Learn Perss Checkout', 'kata-plus' );
		}

		public function get_icon() {
			return 'kata-widget kata-eicon-courses-courses';
		}

		public function get_categories() {
			return ['kata_plus_elementor_learnpress_course' ];
		}

		protected function register_controls() {
			// Settings
			$this->start_controls_section(
				'Settings_section',
				[
					'label' => esc_html__( 'Settings', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'icon_style_error',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __('With this widget you will be able to style Learn Press Checkout module with Kata Styler tool.', 'kata-plus'),
					'content_classes' => 'kata-plus-elementor-error',
				]
			);
			$this->end_controls_section();

			//Messages
			$this->start_controls_section(
				'section_widget_messages',
				[
					'label' => esc_html__( 'Messages', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_empty_cho_message',
				[
					'label'            => esc_html__( 'Empty Cart Error Message', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('{{WRAPPER}} .learn-press-message.error' ),
				]
			);
			$this->add_control(
				'styler_lp_empty_cho_back_to_class',
				[
					'label'            => esc_html__( 'Empty Cart Back To Class Button', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('{{WRAPPER}} a' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_logged_in_as',
				[
					'label'            => esc_html__( 'Logged in as', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout p' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_username',
				[
					'label'            => esc_html__( 'Username', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout p a:nth-child(1)' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_logout',
				[
					'label'            => esc_html__( 'Logout Button', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout p a:nth-child(2)' ),
				]
			);
			$this->end_controls_section();

			//Order Table
			$this->start_controls_section(
				'section_widget_order_tabel',
				[
					'label' => esc_html__( 'Order Tabel', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_full_cho_tabel_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.checkout-review-order h4' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table',
				[
					'label'            => esc_html__( 'Order Table', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-review-order-table' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_headings',
				[
					'label'            => esc_html__( 'Order Table Headings', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table thead tr th' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_course_name_heading',
				[
					'label'            => esc_html__( 'Course Heading', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table thead tr th.course-name' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_course_total_heading',
				[
					'label'            => esc_html__( 'Total Heading', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table thead tr th.course-total' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_cells',
				[
					'label'            => esc_html__( 'Order Table Cells', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tbody tr td' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_course_name_cell',
				[
					'label'            => esc_html__( 'Course Name Cell', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tbody tr td.course-name' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_course_quantity',
				[
					'label'            => esc_html__( 'Course Quantity', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tbody tr td.course-name .course-quantity' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_course_total_cell',
				[
					'label'            => esc_html__( 'Course Total Cell', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tbody tr td.course-total' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_cart_subtotal_heading',
				[
					'label'            => esc_html__( 'Subtotal Heading', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tfoot tr.cart-subtotal th' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_cart_subtotal_cell',
				[
					'label'            => esc_html__( 'Subtotal Cell', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tfoot tr.cart-subtotal td' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_cart_total_heading',
				[
					'label'            => esc_html__( 'Total Heading', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tfoot tr.cart-total th' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_table_cart_total_cell',
				[
					'label'            => esc_html__( 'Total Cell', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-list-table tfoot tr.cart-total td' ),
				]
			);
			$this->end_controls_section();

			//Order Additional Info
			$this->start_controls_section(
				'section_widget_order_additional_info',
				[
					'label' => esc_html__( 'Order Additional Info', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_additional_info_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-comment' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_additional_info_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-comment h4' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_additional_info_textarea',
				[
					'label'            => esc_html__( 'Textarea', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-comment .order-comments' ),
				]
			);
			$this->end_controls_section();

			//Payment
			$this->start_controls_section(
				'section_widget_order_payment',
				[
					'label' => esc_html__( 'Payment', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_payment_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-payment' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_payment_wrapper_title',
				[
					'label'            => esc_html__( 'Wrapper Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-payment h4' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_payments_list_wrapper',
				[
					'label'            => esc_html__( 'Payment Methods List Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-payment .payment-methods' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_payments_item',
				[
					'label'            => esc_html__( 'Payment Method Item', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-payment .payment-methods li.lp-payment-method' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_payments_item_name',
				[
					'label'            => esc_html__( 'Payment Method Item name', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#learn-press-payment .payment-methods .lp-payment-method.selected>label' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_payments_item_logo',
				[
					'label'            => esc_html__( 'Payment Method Item Logo', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-payment .payment-methods li.lp-payment-method label img' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_payments_item_form',
				[
					'label'            => esc_html__( 'Payment Method Item Form', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-checkout-payment .payment-methods li.lp-payment-method .payment-method-form' ),
				]
			);
			$this->end_controls_section();

			//Place Order Button
			$this->start_controls_section(
				'section_widget_order_place_order',
				[
					'label' => esc_html__( 'Place Order Button', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_place_order_button_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.place-order-action' ),
				]
			);
			$this->add_control(
				'styler_lp_full_cho_order_place_order_button',
				[
					'label'            => esc_html__( 'Button', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.place-order-action button[name="learn_press_checkout_place_order"]' ),
				]
			);
			$this->end_controls_section();

			// Common controls
			apply_filters( 'kata_plus_common_controls', $this );
			// end copy
		}

		protected function render() {
			require dirname( __FILE__ ) . '/view.php';
		}

	} // class
}
