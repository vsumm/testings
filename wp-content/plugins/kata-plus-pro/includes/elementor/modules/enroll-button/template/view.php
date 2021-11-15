<?php

/**
 * Course Enroll module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

$settings				= $this->get_settings_for_display();
$this->add_inline_editing_attributes( 'btn_text' );
$text					= $settings['btn_text'];
$icon					= ( ! empty( $settings['icon'] ) ) ? Kata_Plus_Pro_Helpers::get_icon( '', $settings['icon'] ) : '';
$this->add_inline_editing_attributes( 'text' );

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
?>

<div class="kata-plus-enroll-button">
	<div class="lp-course-buttons">
		<form name="enroll-course" class="enroll-course" method="post" enctype="multipart/form-data">
			<input type="hidden" name="enroll-course" value="<?php echo esc_attr( Kata_Plus_Pro_Helpers::get_latest_course_id() ) ?>"/>
			<input type="hidden" name="enroll-course-nonce" value="<?php echo esc_attr( esc_attr( LP_Nonce_Helper::create_course( 'enroll' ) ) ); ?>"/>
			<button class="kata-button kata-lazyload dbg-color lp-button button button-purchase-course">
				<?php
					if ( !empty( $settings['icon'] ) && $settings['symbol'] == 'icon' ) {
						echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['icon'], '', '' );
					} elseif (isset($settings['btn_image']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['btn_image']['url'], 'svg' ) && $settings['symbol'] == 'imagei' ) {
						echo Kata_Plus_Pro_Helpers::get_image_srcset( $settings['btn_image']['id'], 'full' );
					} elseif ( ! empty( $settings['btn_image']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['btn_image']['url'], 'svg' ) && $settings['symbol'] == 'imagei' ) {
						echo Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'btn_image' );
					} elseif ( ! empty( $settings['btn_image']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['btn_image']['url'], 'svg' ) && $settings['symbol'] == 'svg' ) {
						$svg_size = '';
						if ( $settings['btn_image_custom_dimension']['width'] || $settings['btn_image_custom_dimension']['height'] ) {
							$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['btn_image_size'], $settings['btn_image_custom_dimension']['width'], $settings['image_custom_dimension']['height'] );
						}
						Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['btn_image']['id'], $settings['btn_image']['url'], $svg_size );
					}
				?>
				<span class="kata-course-enroll-text elementor-inline-editing" <?php $this->get_render_attribute_string('btn_text') ?>><?php echo esc_html( $text ) ?></span>
			</button>
		</form>
	</div>
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}