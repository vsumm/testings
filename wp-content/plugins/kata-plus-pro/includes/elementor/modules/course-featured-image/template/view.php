<?php
/**
 * Post Featured Image module view.
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

$thumbnail_url = get_the_post_thumbnail_url( Kata_Plus_Pro_Helpers::get_latest_course_id() );
if ( ! empty( $thumbnail_url ) ) {
	?>
	<img class="kata-single-course-featured-image" src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title(); ?>">
	<?php
} else {
	?>
	<img class="kata-single-course-featured-image" src="<?php echo Kata_Plus::$assets . 'images/frontend/featured-image.png'; ?>" alt="<?php the_title(); ?>">
	<?php
}

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
