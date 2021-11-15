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

if (class_exists('LP_Shortcode_Profile')) {
	echo learn_press_print_messages();
	echo learn_press_get_template('profile/profile.php');
}

if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
// end copy