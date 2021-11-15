<?php
/**
 * Comparison Slider view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings				= $this->get_settings_for_display();
$image1                 = $settings['img1'];
$image2                 = $settings['img2'];
$orientation            = $settings['orientation'];
$img1                   = Kata_Plus_Pro_Helpers::get_image_srcset( $image1['id'], '' );
$img2                   = Kata_Plus_Pro_Helpers::get_image_srcset( $image2['id'], '' );
$title1                 = $settings['label1'];
$title2                 = $settings['label2'];
$pos                    = strval( $settings['pos']['size'] );

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

    if ( $img1 || $img2 ) {
        echo '<div class="kata-comparison-slider" id="' . esc_attr( wp_unique_id( 'kata-comparison-slider' ) ) . '" data-img1="'. esc_attr( $image1['url'] ). '" data-img2="'. esc_attr( $image2['url'] ) .'" data-title1="'. esc_attr( $title1 ) .'" data-title2="'. esc_attr( $title2 ) .'" data-pos="'. esc_attr( $pos ) .'" data-orientation="'. esc_attr( $orientation ) .'"></div>';
	} else {
		echo '<img src="' . ELEMENTOR_ASSETS_URL . 'images/placeholder.png' . '">';
    }

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
