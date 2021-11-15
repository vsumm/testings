<?php
/**
 * Countdown module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings		= $this->get_settings_for_display();
$type			= $settings['type'];
$date			= $settings['date'];
$wmd			= $settings['wmd'];
$message		= $settings['message'];
$month 			= $settings['month'];
$week 			= $settings['week'];
$day 			= $settings['day'];
$hour 			= $settings['hour'];
$minute 		= $settings['minute'];
$second 		= $settings['second'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if ( $type ) {
		echo '<div class="kata-countdown" data-month="' . esc_attr($month) . '" data-week="' . esc_attr($week) . '" data-day="' . esc_attr($day) . '"  data-hour="' . esc_attr($hour) . '" data-minute="' . esc_attr($minute) . '"  data-second="' . esc_attr( $second ) . '" data-type="' . esc_attr( $type ) . '" data-date="' . esc_attr( $date ) . '" data-message="' . esc_attr( $message ) . '" data-wmd="'. esc_attr( $wmd ) .'">
			<span class="kata-countdown-time"></span>
		  </div>';
}

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
