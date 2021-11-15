<?php
/**
 * Weather module view.
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
$weather_id = $settings['weather_id'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-weather">
	<div style="visibility: hidden;"><?php echo esc_html__( 'Weather', 'kata-plus' ); ?></div>
	<?php
	if( ! shortcode_exists( 'wpc-weather' ) ) {
		echo '<p>' . esc_html__( 'Please install and activate the', 'kata-plus' ) . ' <a href="' . esc_url( 'https://wordpress.org/plugins/wp-cloudy/' ) . '">' . esc_html( 'WP Cloudy' ) . '</a></p>'
	} elseif ( ! $weather_id ) {
		echo '<p>' . esc_html__( 'Please enter', 'kata-plus' ) . ' <a href="' . esc_url( 'https://wordpress.org/plugins/wp-cloudy/' ) . '">' . esc_html( 'WP Cloudy' ) . '</a></p>'
	} else {
		echo apply_shortcodes( shortcode_unautop( '[wpc-weather id="' . esc_html( $weather_id ) . '"]' ) );
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
