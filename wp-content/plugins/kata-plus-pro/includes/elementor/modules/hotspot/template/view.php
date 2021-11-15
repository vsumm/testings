<?php
/**
 * Hotspot module view.
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

echo '<div class="kata-hotspot">';

if ( $settings['pin'] ) {
	foreach ( $settings['pin'] as $pin ) {
		echo '<div class="kata-hotspot-icon ' . esc_attr( $pin['position'] ) . ' elementor-repeater-item-' . $pin['_id'] . '" data-item-id="' . isset( $pin['style_icon_wrap']['citem'] ) ? esc_attr( $pin['style_icon_wrap']['citem'] ) : '' . '">';
			if ( $pin['display'] == 'pin' ) {
				if ( $pin['pin_icon'] ) {
					if ( $pin['description'] ) {
						echo '<span class="description-tooltip elementor-repeater-item-' . $pin['_id'] . '" data-item-id="' . isset( $pin['style_content']['citem'] ) ? esc_attr( $pin['style_content']['citem'] ) : '' . '">' . esc_html( $pin['description'] ) . '</span>';
					}
					echo '<div> ' . Kata_Plus_Pro_Helpers::get_icon( '', $pin['pin_icon'], 'elementor-repeater-item-' . $pin['_id'], 'data-item-id="' . isset( $pin['style_icon']['citem'] ) ? esc_attr( $pin['style_icon']['citem'] ) : '' . '"' ) . ' </div>';
				}
			} else {
				if ( $pin['image'] ) {
					if ( $pin['description'] ) {
						echo '<span class="description-tooltip elementor-repeater-item-' . $pin['_id'] . '" data-item-id="' . isset( $pin['style_content']['citem'] ) ? esc_attr( $pin['style_content']['citem'] ) : '' . '">' . esc_html( $pin['description'] ) . '</span>';
					}
					$image_size = $pin['img_size']['width'] == '' || $pin['img_size']['height'] == '' ? 'full' : array( $pin['img_size']['width'], $pin['img_size']['height'] );
					echo Kata_Plus_Pro_Helpers::get_image_srcset( $pin['image']['id'], $image_size, '' );
				}
			}
		echo '</div>';
	}
}

echo '</div>';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
