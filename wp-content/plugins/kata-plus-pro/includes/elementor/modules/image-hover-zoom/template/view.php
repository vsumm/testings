<?php
/**
 * Image Hover Zoom module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings   = $this->get_settings();
$element_id = $this->get_id();
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if ( ! empty( $settings['image']['id'] ) ) {
	if ( $settings['size'] != 'custom' ) {
		$img = Kata_Plus_Pro_Helpers::get_image_srcset( $settings['image']['id'], $settings['size'] );
	} else {
		if ( ! empty( $settings['img_size']['width'] ) && ! empty( $settings['img_size']['height'] ) ) {
			$img = Kata_Plus_Pro_Helpers::get_image_srcset( $settings['image']['id'], array( $settings['img_size']['width'], $settings['img_size']['height'] ) );
		} else {
			$img = Kata_Plus_Pro_Helpers::get_image_srcset( $settings['image']['id'], 'full' );
		}
	}
} elseif ( ! empty( $settings['image']['url'] ) && empty( $settings['image']['id'] ) ) {
	$img = '<img src="' . $settings['image']['url'] . '">';
}

echo '
<div class="kata-image-hover-zoom" id="kata-image-hover-zoom-' . esc_attr( $element_id ) . '">
	' . wp_kses_post( $img ) . '
</div>';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
