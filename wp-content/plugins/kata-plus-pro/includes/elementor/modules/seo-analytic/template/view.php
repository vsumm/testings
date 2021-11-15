<?php
/**
 * Seo Analytic view.
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
$icon     = Kata_Plus_Pro_Helpers::get_icon( '', $settings['icon'] );


if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}  ?>

<div class="kata-plus-seo-analytic">
	<form class="kata-seo-analytic" action="<?php echo esc_attr( $settings['website_link'] ); ?>">
	  <input type="text" placeholder="<?php echo esc_attr( $settings['placeholder'] ); ?>" required>	  
	  <button type="submit" class="dbg-color"><?php echo $icon; ?></button>
	</form>   
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}

