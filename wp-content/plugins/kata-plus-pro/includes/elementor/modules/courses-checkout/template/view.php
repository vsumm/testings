<?php

/**
 * Blog course module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

$settings = $this->get_settings();

if ( class_exists( 'LP_Shortcode_Checkout'  ) ) {
	if ( Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
			<h6 class="">If the cart was empty the checkout page will look like:</h6>
		<?php
		echo learn_press_get_template('checkout/empty-cart.php');
		learn_press_print_messages();
		?>
		<h6 class="">If the user adds a cours to the cart the checkout page will look like:</h6>
			<form method="post" id="learn-press-checkout" name="learn-press-checkout" class="learn-press-checkout checkout"
				action="http://localhost/kata/test/" enctype="multipart/form-data">
				<p>
					Logged in as <a href="http://localhost/kata/wp-admin/profile.php">admin</a>.<a href="http://localhost/kata/wp-login.php?action=logout&amp;redirect_to=http%3A%2F%2Flocalhost%2Fkata%2Ftest%2F&amp;_wpnonce=5780034107"title="Log out of this account">Log out »</a>
				</p>
				<div id="learn-press-order-review" class="checkout-review-order">
					<h4>Your order</h4>
					<table class="learn-press-checkout-review-order-table lp-list-table">
						<thead>
							<tr>
								<th class="course-name">Course</th>
								<th class="course-total">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr class="cart-item">
								<td class="course-name">
									<a href="http://localhost/kata/courses/japanese-reading-skills/">Sample Course Name</a>
									<strong class="course-quantity">× 1</strong> </td>
								<td class="course-total">
									$100.00 </td>
							</tr>
						</tbody>
						<tfoot>
							<tr class="cart-subtotal">
								<th>Subtotal</th>
								<td>$100.00</td>
							</tr>
							<tr class="order-total">
								<th>Total</th>
								<td>$100.00</td>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="learn-press-checkout-comment">
					<h4>Additional Information</h4>
					<textarea name="order_comments" class="order-comments" placeholder="Note to administrator"></textarea>
				</div>
				<div id="learn-press-payment" class="learn-press-checkout-payment">
					<h4>Payment Method</h4>
					<ul class="payment-methods">
						<li class="lp-payment-method lp-payment-method-paypal selected" id="learn-press-payment-method-paypal">
							<label for="payment_method_paypal">
								<input type="radio" class="input-radio" name="payment_method" id="payment_method_paypal"
									value="paypal" checked="checked" data-order_button_text="">
								Paypal <img src="http://localhost/kata/wp-content/plugins/learnpress/assets/images/paypal.png"
									alt="Paypal" style="width: 51px; height: 32px"> </label>
							<div class="payment-method-form payment_method_paypal">
								Pay with Paypal </div>
						</li>
					</ul>
					<div id="checkout-order-action" class="place-order-action">
						<button type="submit" class="lp-button button alt" name="learn_press_checkout_place_order"
							id="learn-press-checkout-place-order" data-processing-text="Processing" data-value="Place order">Place
							order</button>
					</div>
				</div>
			</form>
		<?php
	} else {
		if ( function_exists( 'LP' ) && method_exists( LP()->cart, 'is_empty' ) ) {
			global $wp;
			ob_start();
	
			if (isset($wp->query_vars['lp-order-received'])) {
				// Get the order
				$order_id     = absint($wp->query_vars['lp-order-received']);
				$order_key    = !empty($_GET['key']) ? LP_Helper::sanitize_params_submitted($_GET['key']) : '';
				$order_received = learn_press_get_order($order_id);
	
				if (!$order_received) {
					return;
				}
	
				if ($order_received->is_trashed() || $order_received->get_order_key() != $order_key) {
					return;
				}
	
				LP()->session->remove('order_awaiting_payment');
				LP()->cart->empty_cart();
	
				learn_press_print_messages();
	
				learn_press_get_template('checkout/order-received.php', array('order_received' => $order_received));
			} else {
				// Check cart has contents
				if (LP()->cart->is_empty()) {
					learn_press_get_template('checkout/empty-cart.php');
				} else {
					$checkout = LP()->checkout();
					learn_press_get_template('checkout/form.php', array('checkout' => $checkout));
				}
			}
			echo ob_get_clean();
		}
	}
}




if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
// end copy