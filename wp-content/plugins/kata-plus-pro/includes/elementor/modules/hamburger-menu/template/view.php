<?php

/**
 * Hamburger Menu view.
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

$settings   = $this->get_settings();
$element_id = $this->get_id();
$symbol   = $settings['symbol'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-plus-hamburger-menu <?php echo esc_attr($settings['hamburger_load']); ?>" data-id="<?php echo esc_attr($element_id); ?>">
	<div class="icons-wrap kata-lazyload">
	<?php
		// Open icon
		if ( ! empty( $settings['open_icon'] ) && $symbol == 'icon' ) {
			echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['open_icon'], 'open-icon', '' );
		} elseif ( isset($settings['icon_image']['url']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image']['url'], 'svg' ) && $symbol == 'imagei' ) {
			echo str_replace( 'class="', 'class="open-icon ', Kata_Plus_Pro_Helpers::get_image_srcset( $settings['icon_image']['id'], 'full' ));
		} elseif ( ! empty( $settings['icon_image']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image']['url'], 'svg' ) && $symbol == 'imagei' ) {
			echo str_replace('class="','class="open-icon ',Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'icon_image' ));
		} elseif ( ! empty( $settings['icon_image']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image']['url'], 'svg' ) && $symbol == 'svg' ) {
			$svg_size = '';
			if ( isset( $settings['icon_image_custom_dimension']['width'] ) || isset( $settings['icon_image_custom_dimension']['height'] ) ) {
				$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['icon_image_size'], $settings['icon_image_custom_dimension']['width'], $settings['icon_image_custom_dimension']['height'] );
			}
			Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['icon_image']['id'], $settings['icon_image']['url'], $svg_size, 'open-icon' );
		}
		// Close icon
		if ( ! empty( $settings['close_icon'] ) && $symbol == 'icon' ) {
			echo Kata_Plus_Pro_Helpers::get_icon('', $settings['close_icon'], 'close-icon', 'style="display: none;"');
		} elseif ( isset($settings['icon_image2']['url']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image2']['url'], 'svg' ) && $symbol == 'imagei' ) {
			echo str_replace( 'class="', 'style="display:none;" class="close-icon ', Kata_Plus_Pro_Helpers::get_image_srcset( $settings['icon_image2']['id'], 'full' ));
		} elseif ( ! empty( $settings['icon_image2']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image2']['url'], 'svg' ) && $symbol == 'imagei' ) {
			echo str_replace('class="','style="display:none;" class="close-icon ',Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'icon_image2' ));
		} elseif ( ! empty( $settings['icon_image2']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image2']['url'], 'svg' ) && $symbol == 'svg' ) {
			$svg_size = '';
			if ( isset( $settings['icon_image2_custom_dimension']['width'] ) || isset( $settings['icon_image2_custom_dimension']['height'] ) ) {
				$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['icon_image2_size'], $settings['icon_image2_custom_dimension']['width'], $settings['icon_image2_custom_dimension']['height'] );
			}
			Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['icon_image2']['id'], $settings['icon_image2']['url'], $svg_size, 'close-icon', ' style="display:none;"' );
		}
	?>
	</div>
	<div class="kata-hamburger-menu-template <?php echo esc_attr($settings['hamburger_load'] . ' ' . $settings['open_from']); ?>" style="display: none;">
		<div class="icons-wrap kata-lazyload">
			<?php
			// Close icon
			if ( ! empty( $settings['close_icon'] ) && $symbol == 'icon' ) {
				echo Kata_Plus_Pro_Helpers::get_icon('', $settings['close_icon'], 'close-icon', '');
			} elseif ( isset($settings['icon_image2']['url']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image2']['url'], 'svg' ) && $symbol == 'imagei' ) {
				echo str_replace( 'class="', 'class="close-icon ', Kata_Plus_Pro_Helpers::get_image_srcset( $settings['icon_image2']['id'], 'full' ));
			} elseif ( ! empty( $settings['icon_image2']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image2']['url'], 'svg' ) && $symbol == 'imagei' ) {
				echo str_replace('class="','class="close-icon ',Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'icon_image2' ));
			} elseif ( ! empty( $settings['icon_image2']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['icon_image2']['url'], 'svg' ) && $symbol == 'svg' ) {
				$svg_size = '';
				if ( isset( $settings['icon_image2_custom_dimension']['width'] ) || isset( $settings['icon_image2_custom_dimension']['height'] ) ) {
					$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['icon_image2_size'], $settings['icon_image2_custom_dimension']['width'], $settings['icon_image2_custom_dimension']['height'] );
				}
				Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['icon_image2']['id'], $settings['icon_image2']['url'], $svg_size, 'close-icon', '' );
			}
			?>
		</div>
		<?php
		if ( get_page_by_title( $settings['template'], OBJECT, 'elementor_library' ) ) {
			echo Plugin::instance()->frontend->get_builder_content_for_display( get_page_by_title( $settings['template'], OBJECT, 'elementor_library' )->ID );
		} else {
			echo '<p class="kata-widget-notice" style="max-width: 69%; margin: 0 auto; position: relative; top: 30%;"> ' . esc_html__('You can have your own custom hamburger menu with any custom design by using this widget. In order to start, you should go to WP dashboard > Templates and click on "add new" and build your desired hamburger menu, then go back and select the section from template type and click on Create Template."', 'kata-plus') . '</p>';
		}
		?>
	</div>
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
