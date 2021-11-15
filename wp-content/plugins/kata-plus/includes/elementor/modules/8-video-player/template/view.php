<?php
/**
 * Video Player module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Utils;
// Variables
$settings				= $this->get_settings_for_display();
$space      = ' ';
$video_url  = ! empty( $settings['video_url'] ) ? $settings['video_url'] : '#';
$title      = ! empty( $settings['title'] ) ? $settings['title'] : '';
$subtitle   = ! empty( $settings['subtitle'] ) ? $settings['subtitle'] : '';
$icon       = ! empty( $settings['icon'] ) ? $settings['icon'] : '';
$popup      = $settings['lightbox'] == 'yes' ? 'kata-lightbox' : '';
$background = ( $settings['button'] == 'yes' ) ? 'background' : 'no-background';
$classes    = $popup;
$video_type = 'local';


if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
// Detect video type
if ( $popup != 'yes' ) {
	if ( strpos( $video_url, 'youtube' ) !== false ) {
		$video_type = 'youtube';
		$video_id   = $popup != 'kata-lightbox' ? substr( $video_url, 32 ) : '';
	} elseif ( strpos( $video_url, 'vimeo' ) !== false ) {
		$video_type = 'vimeo';
		$video_id   = $popup != 'kata-lightbox' ? substr( $video_url, 18 ) : '';
	}
}
// output
$video_url = $popup == 'kata-lightbox' ? $video_url : $video_id; ?>
<div class="kata-plus-video-player <?php echo esc_attr( $classes ); ?> <?php echo esc_attr( $background ); ?>" data-video-type="<?php echo esc_attr( $video_type ); ?>">

	<?php if ( $settings['badge'] ): ?>
		<span class="video-badge"><?php echo esc_html( $settings['badge'] ); ?></span>
	<?php endif; ?>

	<a href="<?php echo esc_attr( $video_url ); ?>">
		<?php
		if ( $icon || $title || $subtitle ) {
			?>
			<div class="kata-vp-conent">
				<?php if ( $icon ) { ?>
					<span class="iconwrap">
						<?php echo Kata_Plus_Helpers::get_icon( '', $icon, '', '' ); ?>
					</span>
				<?php } ?>

				<?php if ( $title ) { ?>
					<div class="kata-video-btn-content-wrap">
						<h5><?php echo wp_kses( $title, wp_kses_allowed_html( 'post' ) ); ?></h5>
						<?php if ( $subtitle ) { ?>
							<span><?php echo wp_kses( $subtitle, wp_kses_allowed_html( 'post' ) ); ?></span>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<?php
		}
		
		if ( $settings['button'] == 'yes' ) {
			if ( $settings['image_placeholder']['id'] ) {
				echo '<div class="kata-lazyload">';
				echo Kata_Plus_Helpers::get_image_srcset( $settings['image_placeholder']['id'], 'full' );
				echo '</div>';
			} else {
				echo '<img src="' . Utils::get_placeholder_image_src() . '">';
			}
		} ?>
	</a>
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}

