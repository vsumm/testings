<?php
/**
 * Gift Cards view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings();

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if ( function_exists('wpgv_voucher_shortcode')) {
	echo '<div class="kata-plus-gift-cards">' . apply_shortcodes('[wpgv_giftvoucher]') . '</div>';
} else {
	echo __( 'To use this widget, please first install the <a href="https://wordpress.org/plugins/gift-voucher/" target=_blank>"Gift Cards"</a>', 'kata-plus' );
}

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}