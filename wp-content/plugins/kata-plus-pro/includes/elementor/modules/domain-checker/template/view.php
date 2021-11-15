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
if ( shortcode_exists( 'ajaxdomainchecker' ) ) {
	?>
	<div class="kata-plus-domain-checker"><?php echo apply_shortcodes( shortcode_unautop( '[ajaxdomainchecker]' ) ); ?></div>
	<?php
} elseif ( shortcode_exists( 'wpdomainchecker' ) ) {
	?>
	<div class="kata-plus-domain-checker"><?php echo apply_shortcodes( shortcode_unautop( '[wpdomainchecker]' ) ); ?></div>
	<?php
} else {
	echo wp_sprintf( __( "To Use Domain Checker, Please install the %s", 'kata-plus' ),'<a href="https://wordpress.org/plugins/ajax-domain-checker/">WP Domain Checker</a>');
}
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}