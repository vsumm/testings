<?php

/**
 * Content Toggle module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;

$settings = $this->get_settings_for_display();
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>
<div class="kata-plus-content-toggle">
	<div class="kata-plus-content-toggle-click kata-lazyload">
		<?php
		if ($settings['placeholder']) :
			switch ($settings['placeholder']) {
				case 'image':
					if ($settings['image']['id']) {
						if (Kata_Plus_Pro_Helpers::string_is_contain($settings['image']['url'], 'svg')) {
							$svg_size = '';
							if( isset( $settings['image_custom_dimension']['width'] ) || isset( $settings['image_custom_dimension']['height'] ) ) {
								$svg_size = Kata_Plus_Pro_Helpers::svg_resize($settings['image_size'], $settings['image_custom_dimension']['width'], $settings['image_custom_dimension']['height']);
							}
							Kata_Plus_Pro_Helpers::get_attachment_svg_path($settings['image']['id'], $settings['image']['url'], $svg_size);
						} else {
							echo Kata_Plus_Pro_Helpers::get_attachment_image_html($settings);
						}
					}
					break;

				case 'text':
					echo '<p class="content-toggle-text">' . wp_kses($settings['text'], wp_kses_allowed_html('post')) . '</p>';
					break;

				case 'icon':
				default:
					echo Kata_Plus_Pro_Helpers::get_icon('', $settings['icon'], '', '');
					break;
			}
		endif;
		?>
	</div>
	<?php
	if ($settings['content_toggle_template']) : ?>
		<div class="kata-plus-content-toggle-content-wrap" style="display: none;">
			<?php
			if( get_page_by_title($settings['content_toggle_template'], OBJECT, 'elementor_library') ) {
				echo Plugin::instance()->frontend->get_builder_content_for_display(get_page_by_title($settings['content_toggle_template'], OBJECT, 'elementor_library')->ID);
			} else {
				echo '<p>'.__( 'Please Choose a valid template', 'kata-plus' ) . '</p>';
			}
			?>
		</div>
	<?php
	else :
		echo __('Please Choose Template', 'kata-plus');
	endif;
	?>
</div>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
