<?php
/**
 * Employee Information module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;

$settings = $this->get_settings_for_display();
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} 		
?>

	<div class="kata-employee-information">
		<?php if ( $settings['profile']['url'] ): ?>
			<div class="employee-profile">
				<div class="employee-image kata-lazyload">
					<?php											
						if ( $settings['profile_symbol'] == 'imagei' ) {							
							echo Kata_Plus_Helpers::get_attachment_image_html( $settings, 'profile' );
						} elseif ( ! empty( $settings['profile']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['profile']['url'], 'svg' ) && $settings['profile_symbol'] == 'svg' ) {									
							$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['profile_size'], $settings['profile_custom_dimension']['width'], $settings['image_custom_dimension']['height'] );
							Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['profile']['id'], $settings['profile']['url'], $svg_size );
						}
					?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $settings['name'] || $settings['position'] ): ?>
			<div class="employee-dec">
				<?php if ( $settings['name'] ): ?>
					<p class="employee-name">
						<?php echo wp_kses_post( $settings['name'] ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $settings['position'] ): ?>
					<p class="employee-position">
						<?php echo wp_kses_post( $settings['position'] ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $settings['signature']['url'] ): ?>
			<div class="employee-signature kata-lazyload">
					<?php
						if ( $settings['signature_symbol'] == 'imagei' ) {							
							echo Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'signature' );
						} elseif ( ! empty( $settings['signature']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['signature']['url'], 'svg' ) && $settings['signature_symbol'] == 'svg' ) {									
							$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['signature_size'], $settings['signature_custom_dimension']['width'], $settings['image_custom_dimension']['height'] );
							Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['signature']['id'], $settings['signature']['url'], $svg_size );
						}
					?>
			</div>
		<?php endif; ?>
	</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}

