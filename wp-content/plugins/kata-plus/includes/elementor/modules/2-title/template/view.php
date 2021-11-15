<?php
/**
 * Title module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings		= $this->get_settings_for_display();
$this->add_inline_editing_attributes( 'title' );
$this->add_inline_editing_attributes( 'subtitle' );
$title			= ! empty( $settings['title'] ) ? $settings['title'] : '';
$subtitle		= ! empty( $settings['subtitle'] ) ? $settings['subtitle'] : '';
$title_tag		= ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : '';
$subtitle_tag	= ! empty( $settings['subtitle_tag'] ) ? $settings['subtitle_tag'] : '';
$shapes			= $settings['shape'];
$url			= Kata_Plus_Helpers::get_link_attr($settings['link']);

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>
<?php if ( $title || $subtitle ) : ?>
	<div class="kata-plus-title-wrapper">
		<?php
		if ( $url->src || $settings['link_to_home'] == 'yes' ) {
			$href = $settings['link_to_home'] == 'yes' ? 'href="' . esc_url( home_url() ) . '"' : $url->src; ?>
			<a <?php echo '' . $href . ' ' . $url->rel . ' ' . $url->target; ?> class="kata-title-url">
			<?php
		} ?>
		<?php if ( $title ) { ?>
			<<?php echo esc_attr( $title_tag ); ?> class="kata-plus-title elementor-inline-editing" <?php echo '' . $this->get_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
		<?php } ?>
		<?php if ( $subtitle ) { ?>
			<<?php echo esc_attr( $subtitle_tag ); ?> class="kata-plus-subtitle elementor-inline-editing" <?php echo '' . $this->get_render_attribute_string( 'subtitle' ); ?>><?php echo wp_kses_post( $subtitle ); ?></<?php echo esc_attr( $subtitle_tag ); ?>>
		<?php }
		if ( $url->src || $settings['link_to_home'] == 'yes' ) { ?>
			</a>
		<?php
		}
		if ( $shapes ) {
			foreach ( $shapes as $value ) {
				?>
				<span class="elementor-repeater-item-<?php echo esc_attr( $value['_id'] ); ?> kata-plus-shape" data-item-id="<?php echo isset( $value['shape']['citem'] ) ? esc_attr( $value['shape']['citem']  ) : ''; ?>"></span>
			<?php } ?>
		<?php } ?>
	</div>
	<?php
endif;
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
