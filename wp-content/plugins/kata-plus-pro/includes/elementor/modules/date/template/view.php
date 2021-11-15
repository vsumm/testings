<?php
/**
 * Date module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings    = $this->get_settings_for_display();
$date_format = $settings['date'];
$title       = $settings['title'];
$icon        = $settings['icon'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-date">
	<?php
	if ( $date_format || $title || $icon ) {
		?>
			<span class="kata-date-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $icon, '', '' ); ?></span>
			<span class="kata-date-title"><?php echo wp_kses( $title, wp_kses_allowed_html( 'post' ) ); ?></span>
			<div class="kata-date-format">
				<?php echo date( wp_kses( $date_format, wp_kses_allowed_html( 'post' ) ), current_time( 'timestamp', 0 ) ); ?>
			</div>  
		<?php
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
