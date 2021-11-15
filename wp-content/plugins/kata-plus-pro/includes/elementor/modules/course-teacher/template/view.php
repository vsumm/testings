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

$settings = $this->get_settings_for_display();
$course   = LP_Global::course( 30 );
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-plus-course-teacher">
	<?php
	Kata_Template_Tags::post_author( Kata_Plus_Pro_Helpers::get_icon( '', $settings['post_author_icon'], 'df-fill' ), $settings['post_author_symbol'], $settings['avatar_size'] );
	Kata_Plus_Pro_Helpers::get_the_author_social_networks();
	?>
<div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
