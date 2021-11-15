<?php
/**
 * Contact Toggle view.
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
$this->add_inline_editing_attributes( 't_txt' );
$this->add_inline_editing_attributes( 'form_title' );
$form          	= $settings['select_form'];
$contact_form7 	= get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );
$type          	= $settings['type'];
$txt           	= $settings['t_txt'];
$open_type     	= $settings['open_type'];
$icon          	= $settings['icon'];
$title         	= $settings['form_title'];
$url			= Kata_Plus_Pro_Helpers::get_link_attr( $settings['link'] );
$urlt			= $open_type == 'link' ? $url->src : 'href="#"';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-contact-toggle" data-view="<?php echo esc_attr( $open_type ); ?>">
	<div class="kata-contact-show-wrap">
		<a <?php echo $urlt; ?><?php echo $url->rel . $url->target; ?> class="linktopen">
			<?php
			if ( $icon ) {
				switch ( $type ) {
					case 'txt':
						echo '<span class="elementor-inline-editing" ' . $this->get_render_attribute_string( 't_txt' ) . '>' . wp_kses_post( $txt ) . '</span>';
						break;
					case 'icon':
						echo Kata_Plus_Pro_Helpers::get_icon( '', $icon, '', '' );
						break;
				}
			}
			?>
		</a> 
	</div>
	<div class="contact-content" style="display: none;">
		<div class="kata-contact-drop-title">
			<h3 class="elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'form_title' ); ?>><?php echo wp_kses_post( $title ); ?></h3>
		</div>
		<div class="kata-contact-modal">
			<?php
			if ( $contact_form7 ) {
				foreach ( $contact_form7 as $formn ) {
					if ( $formn->ID == $form ) {
						echo apply_shortcodes( '[contact-form-7 title="' . $formn->post_title . '"]' );
					}
				}
			} else {
				esc_html_e( 'Please select your desired form', 'kata-plus' );
			}
			?>
		</div>
	</div> 
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
