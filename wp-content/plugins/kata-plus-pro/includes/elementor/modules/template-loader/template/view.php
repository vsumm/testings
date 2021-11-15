<?php
/**
 * Post Title module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use Elementor\Plugin;

$settings = $this->get_settings();
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if ( $settings['template'] ) : ?>
		<div class="kata-plus-template-loader">
			<?php
			if( get_page_by_title($settings['template'], OBJECT, 'elementor_library') ) {
				echo Plugin::instance()->frontend->get_builder_content_for_display( get_page_by_title( $settings['template'], OBJECT, 'elementor_library')->ID );
			} else {
				echo '<p>'.__( 'Please Choose a valid template', 'kata-plus' ) . '</p>';
			}
			?>
		</div>
	<?php
	else :
		echo __( 'Please Choose Template', 'kata-plus' );
	endif;

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
