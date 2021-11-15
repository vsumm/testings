<?php

/**
 * Contact Form module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Utils;

$settings      = $this->get_settings();
$contact_form7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

// Render
echo '<div class="kata-plus-contact-form">';
if ( $contact_form7 ) {
	$out = apply_shortcodes('[contact-form-7 id="' . esc_attr($settings['contact_form']) . '" title="' . esc_attr(get_the_title($settings['contact_form'])) . '"]');

	if ($settings['icon_input_text']) {
		$out = str_replace('<input type="text"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_text'], '', '') . '<input type="text"', $out);
	}
	if ($settings['icon_input_subject']) {
		$out = str_replace('<input type="text" name="your-subject"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_subject'], '', '') . '<input type="text" name="your-subject"', $out);
	}
	if ($settings['icon_input_email']) {
		$out = str_replace('<input type="email"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_email'], '', '') . '<input type="email"', $out);
	}
	if ($settings['icon_input_url']) {
		$out = str_replace('<input type="url"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_url'], '', '') . '<input type="url"', $out);
	}
	if ($settings['icon_input_tel']) {
		$out = str_replace('<input type="tel"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_tel'], '', '') . '<input type="tel"', $out);
	}
	if ($settings['icon_input_number']) {
		$out = str_replace('<input type="number"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_number'], '', '') . '<input type="number"', $out);
	}
	if ($settings['icon_input_date']) {
		$out = str_replace('<input type="date"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_date'], '', '') . '<input type="date"', $out);
	}
	if ($settings['icon_input_textarea']) {
		$out = str_replace('<textarea', Kata_Plus_Helpers::get_icon('', $settings['icon_input_textarea'], '', '') . '<textarea', $out);
	}
	if ($settings['icon_input_select']) {
		$out = str_replace('<select', Kata_Plus_Helpers::get_icon('', $settings['icon_input_select'], '', '') . '<select', $out);
	}
	if ($settings['icon_input_file']) {
		$out = str_replace('<input type="file"', Kata_Plus_Helpers::get_icon('', $settings['icon_input_file'], '', '') . '<input type="file"', $out);
	}
	echo '' . $out;
} else {
	esc_html_e('Please select your desired form', 'kata-plus');
}
echo '</div>';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
