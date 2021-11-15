<?php
/**
 * Audio Player module view.
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
?>
<div class="kata-plus-audio-player">
	<?php
	foreach ( $settings['audios'] as $audio ) {
		$audio['loop']		= 'yes' == $audio['loop'] ? ' loop="on"' : '';
		$audio['autoplay']	= 'yes' == $audio['autoplay'] ? ' autoplay="on"' : '';
		$audio['preload']	= $audio['preload'] ? ' preload="'. $audio['preload'] .'"' : ' preload="auto"';
		
		echo '<div class="kata-plus-track-wrapper">';
			echo '<div class="kata-plus-track-content">';
				echo '<h5 class="kata-plus-track-title">' . wp_kses_post( $audio['audio_title'] ) . '</h5>';
				echo '<div class="kata-plus-track-meta-wrapper">';
					echo '<span class="kata-plus-track-artist">' . wp_kses_post( $audio['audio_artist'] ) . '</span>';
					echo '<span class="kata-plus-track-date">' . wp_kses_post( $audio['audio_date'] ) . '</span>';
				echo '</div>';	
			echo '</div>';

			echo '<div class="kata-plus-track">';
			echo apply_shortcodes( '[audio src="'. esc_url( $audio['audio_file'] ) .'" ' . $audio['loop'] . $audio['autoplay'] . $audio['preload'] . ']' );
			echo '</div>';
		echo '</div>';
	}
	?>
</div>
<?php
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
