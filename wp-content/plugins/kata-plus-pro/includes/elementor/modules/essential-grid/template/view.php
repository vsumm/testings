<?php

/**
 * Essential Grid module view.
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
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-plus-essential-grid">
	<?php
	if( 'none' != $settings['ess_grids'] ) {
		$grid = apply_shortcodes( shortcode_unautop( '[ess_grid alias="' . esc_html( $settings['ess_grids'] ) . '"]' ) );
		echo $grid;
	} else {
		echo __( 'Please select your a grid', 'kata-plus' );
	}
	?>
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
