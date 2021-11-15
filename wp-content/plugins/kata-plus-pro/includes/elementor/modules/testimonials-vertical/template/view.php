<?php
/**
 * Testimonials module view.
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
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
?>
<div class="kata-testimonials-vertical-wrapper">
	<div class="kata-testimonials-vertical" data-speed="<?php echo esc_attr( $settings['owl_spd']['size'] ); ?>">
		<?php
		if ( $settings['testimonials'] ) {
			foreach ( $settings['testimonials'] as $item ) {
				?>
				<div class="kata-testimonials-vertical-item">
					<div class="testimonials-vertical-content">
						<?php
						if ( $item['owl_icon'] ) {
							echo Kata_Plus_Pro_Helpers::get_icon( '', $item['owl_icon'], '', '' );
						}
						?>
						<?php if ( $item['owl_cnt'] ) : ?>
							<p><?php echo wp_kses_post( $item['owl_cnt'] ); ?></p>
						<?php endif; ?>
					</div>
					<div class="testimonials-vertical-info">
						<div class="testimonials-vertical-info-wrap">
							<div class="testimonials-vertical-img">
								<?php
								if ( $item['owl_img']['url'] ) :
									$alt = get_post_meta( $item['owl_img']['id'], '_wp_attachment_image_alt', true ) ? 'alt=' . get_post_meta( $item['owl_img']['id'], '_wp_attachment_image_alt', true ) . '' : 'alt=' . $item['owl_name'] . '';
									echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize( $item['owl_img']['id'], [ '121', '121' ] ) . '" ' . esc_attr( $alt ) . '>';
								endif;
								?>
									<div class="testimonials-vertical-det">
										<?php if ( $item['owl_name'] ) : ?>
											<p><?php echo wp_kses_post( $item['owl_name'] ); ?></p>
										<?php endif; ?>

										<?php if ( $item['owl_pos'] ) : ?>
											<span><?php echo wp_kses_post( $item['owl_pos'] ); ?></span>
										<?php endif; ?>
									</div>
								</div>

						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
