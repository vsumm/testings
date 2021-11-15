<?php
/**
 * Language Switcher view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings         = $this->get_settings();
$installed_plugin = $settings['installed_plugin'];

// Ploylang Settings
$po_dropdown               = $settings['po_dropdown'] ? 1 : 0;
$po_names                  = $settings['po_names'] ? 1 : 0;
$po_display_as             = $settings['po_display_as'];
$po_flag                   = $settings['po_flag'] ? 1 : 0;
$po_hide_if_empty          = $settings['po_hide_if_empty'] ? 0 : 1;
$po_hide_if_no_translation = $settings['po_hide_if_no_translation'] ? 0 : 1;
$po_hide_current           = $settings['po_hide_current'] ? 0 : 1;
$po_args                   = array(
	'dropdown'               => $po_dropdown,
	'show_names'             => $po_names,
	'display_names_as'       => $po_display_as,
	'show_flags'             => $po_flag,
	'hide_if_empty'          => $po_hide_if_empty,
	'hide_if_no_translation' => $po_hide_if_no_translation,
	'hide_current'           => $po_hide_current,
);

// WPML Settings
$wpml_type         = $settings['wpml_type'];
$wpml_flag         = $settings['wpml_flag'] ? 1 : 0;
$wpml_link_current = $settings['wpml_link_current'] ? 1 : 0;
$wpml_native       = $settings['wpml_native'] ? 1 : 0;
$wpml_translated   = $settings['wpml_translated'] ? 1 : 0;
if ( $wpml_type != 'custom' ) {
	$wpml_arg = array(
		'type'         => $wpml_type,
		'flags'        => $wpml_flag,
		'link_current' => $wpml_link_current,
		'native'       => $wpml_native,
		'translated'   => $wpml_translated,
	);
} else {
	$wpml_arg = array(
		'type' => $wpml_type,
	);
}


if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

echo '<div class="kata-language-switcher">';
if ( $installed_plugin == 'polylang' ) {
	if ( function_exists( 'pll_the_languages' ) ) {
		if ( $po_dropdown == 0 ) {
			echo '<ul>';
		}
		pll_the_languages( $po_args );
		if ( $po_dropdown == 0 ) {
			echo '</ul>';
		}
	}
} elseif ( $installed_plugin == 'wpml' ) {
	if ( class_exists( 'WPML_PHP_Functions' ) ) {
		do_action( 'wpml_language_switcher', $wpml_arg, '' );
	}
}
echo '</div>';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
