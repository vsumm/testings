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
?>
<div class="kata-darkmode-switcher">
	<div class="wp-dark-mode-switcher wp-dark-mode-ignore style-1 floating right_bottom">  
		<label for="wp-dark-mode-switch" class="wp-dark-mode-ignore wp-dark-mode-none">
			<div class="modes wp-dark-mode-ignore">
				<?php
				echo Kata_Plus_Helpers::get_icon('', '7-stroke/moon', 'moon wp-dark-mode-ignore', '');
				echo Kata_Plus_Helpers::get_icon('', '7-stroke/sun', 'sun wp-dark-mode-ignore', '');
				?>
			</div>
		</label>
	</div>
</div>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
