<?php
/**
 * Progress Bar view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();
$bars = $settings['bars'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>
	
	<?php foreach ( $bars as $bar ): ?> 		
		<div class="kata-plus-progress-bar">
			<p><?php echo wp_kses_post( $bar['title'] ); ?> <span><?php echo esc_html( $bar['counter']['size'] ); ?><span class="unit">%</span></span></p>	 
				<div class="bar-wrapper"><div class="bar dbg-color" data-counter="<?php echo esc_attr( $bar['counter']['size']. '%' ); ?>"></div>
			</div>
		</div>
	<?php endforeach; ?> 	

<?php 
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
