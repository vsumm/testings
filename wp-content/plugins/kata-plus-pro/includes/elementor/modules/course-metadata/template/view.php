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

use Elementor\Group_Control_Image_Size;

$settings			= $this->get_settings_for_display();
$max_students		= get_post_meta( Kata_Plus_Pro_Helpers::get_latest_course_id(), '_lp_students', true );
$duration			= get_post_meta( Kata_Plus_Pro_Helpers::get_latest_course_id(), '_lp_duration', true );
$lessons			= get_post_meta( Kata_Plus_Pro_Helpers::get_latest_course_id(), 'count_items', true );
$title				= isset( $settings['title'] ) ? $settings['title'] : '';
$symbol_students	= $settings['symbol_students'];
$symbol_duration	= $settings['symbol_duration'];
$symbol_lessons		= $settings['symbol_lessons'];
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-plus-course-metadata">
	<?php if ( $lessons && 'yes' == $settings['show_lessons'] ) : ?>
		<div class=max-lessons-wrapper">
			<?php if ( $symbol_lessons ) { ?>
				<div class="kata-plus-course-lesson-icon-wrap kata-lazyload <?php echo esc_attr( $symbol_lessons ); ?>">
					<?php
					if ( ! empty( $settings['course_lessons_icon'] ) && $symbol_lessons == 'icon' ) {
						echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['course_lessons_icon'], '', '' );
					} elseif ( isset($settings['course_lessons_image']['url']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_lessons_image']['url'], 'svg' ) && $symbol_lessons == 'imagei' ) {
						echo Kata_Plus_Pro_Helpers::get_image_srcset( $settings['course_lessons_image']['id'], 'full' );
					} elseif ( ! empty( $settings['course_lessons_image']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_lessons_image']['url'], 'svg' ) && $symbol_lessons == 'imagei' ) {
					echo Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'course_lessons_image' );
					} elseif ( ! empty( $settings['course_lessons_image']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_lessons_image']['url'], 'svg' ) && $symbol_lessons == 'svg' ) {
						$svg_size = '';
						if ( isset( $settings['course_lessons_image_custom_dimension']['width'] ) || isset( $settings['course_lessons_image_custom_dimension']['height'] ) ) {
							$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['course_lessons_image_size'], $settings['course_lessons_image_custom_dimension']['width'], $settings['course_lessons_image_custom_dimension']['height'] );
						}
						Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['course_lessons_image']['id'], $settings['course_lessons_image']['url'], $svg_size );
					}
					?>
				</div>
			<?php } ?>
			<span class="max-lesson"><?php echo esc_html( $lessons ) . ' ' . __( 'Lessons', 'kata-plus' ); ?></span>
		</div>
	<?php endif; ?>
	<?php if ( $max_students && 'yes' == $settings['show_students'] ) : ?>
		<div class="max-students-wrapper">
			<?php if ( $symbol_students ) { ?>
				<div class="kata-plus-course-students-icon-wrap kata-lazyload <?php echo esc_attr( $symbol_students ); ?>">
					<?php
					if ( ! empty( $settings['course_students_icon'] ) && $symbol_students == 'icon' ) {
						echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['course_students_icon'], '', '' );
					} elseif ( isset($settings['course_students_image']['url']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_students_image']['url'], 'svg' ) && $symbol_students == 'imagei' ) {
						echo Kata_Plus_Pro_Helpers::get_image_srcset( $settings['course_students_image']['id'], 'full' );
					} elseif ( ! empty( $settings['course_students_image']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_students_image']['url'], 'svg' ) && $symbol_students == 'imagei' ) {
					echo Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'course_students_image' );
					} elseif ( ! empty( $settings['course_students_image']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_students_image']['url'], 'svg' ) && $symbol_students == 'svg' ) {
						$svg_size = '';
						if ( isset( $settings['course_students_image_custom_dimension']['width'] ) || isset( $settings['course_students_image_custom_dimension']['height'] ) ) {
							$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['course_students_image_size'], $settings['course_students_image_custom_dimension']['width'], $settings['course_students_image_custom_dimension']['height'] );
						}
						Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['course_students_image']['id'], $settings['course_students_image']['url'], $svg_size );
					}
					?>
				</div>
			<?php } ?>
			<span class="max-students"><?php echo esc_html( $max_students ) . ' ' . __( 'Students', 'kata-plus' ); ?></span>
		</div>
	<?php endif; ?>
	<?php if ( $duration && 'yes' == $settings['show_duration'] ) : ?>
		<div class="max-duration-wrapper">
			<?php if ( $symbol_duration ) { ?>
				<div class="kata-plus-course-duration-icon-wrap kata-lazyload <?php echo esc_attr( $symbol_duration ); ?>">
					<?php
					if ( ! empty( $settings['course_duration_icon'] ) && $symbol_duration == 'icon' ) {
						echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['course_duration_icon'], '', '' );
					} elseif ( isset($settings['course_duration_image']['url']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_duration_image']['url'], 'svg' ) && $symbol_duration == 'imagei' ) {
						echo Kata_Plus_Pro_Helpers::get_image_srcset( $settings['course_duration_image']['id'], 'full' );
					} elseif ( ! empty( $settings['course_duration_image']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_duration_image']['url'], 'svg' ) && $symbol_duration == 'imagei' ) {
					echo Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'course_duration_image' );
					} elseif ( ! empty( $settings['course_duration_image']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_duration_image']['url'], 'svg' ) && $symbol_duration == 'svg' ) {
						$svg_size = '';
						if ( isset( $settings['course_duration_image_custom_dimension']['width'] ) || isset( $settings['course_duration_image_custom_dimension']['height'] ) ) {
							$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['course_duration_image_size'], $settings['course_duration_image_custom_dimension']['width'], $settings['course_duration_image_custom_dimension']['height'] );
						}
						Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['course_duration_image']['id'], $settings['course_duration_image']['url'], $svg_size );
					}
					?>
				</div>
			<?php } ?>
			<span class="max-duration"><?php echo esc_html( $duration ); ?></span>
		</div>
	<?php endif; ?>
<div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
