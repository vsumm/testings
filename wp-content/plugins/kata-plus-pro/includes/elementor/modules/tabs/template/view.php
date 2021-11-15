<?php

/**
 * Tabs module view.
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

$settings  = $this->get_settings_for_display();
$space     = ' ';
$tabs      = $settings['tabs'];
$classes   = $settings['tab_pos'];
$nav_menu  = '';
$nav_menu .= '<ul class="kata-plus-tabs-item">';
$c         = 0;

foreach ($tabs as $index => $tab) {
	if (Kata_Plus_Pro_Helpers::string_is_contain($tab['image']['url'], 'svg')) {
		$svg_size = Kata_Plus_Pro_Helpers::svg_resize($tab['image_size'], $tab['image_custom_dimension']['width'], $tab['image_custom_dimension']['height']);
		$image = Kata_Plus_Pro_Helpers::get_attachment_svg_path($tab['image']['id'], $tab['image']['url'], $svg_size);
	} else {
		$image = Kata_Plus_Pro_Helpers::get_attachment_image_html($tab);
	}

	$tab_title_setting_key    = $this->get_repeater_setting_key('tab_title', 'tabs', $index);
	$tab_subtitle_setting_key = $this->get_repeater_setting_key('tab_subtitle', 'tabs', $index);
	$this->add_inline_editing_attributes($tab_title_setting_key);
	$this->add_inline_editing_attributes($tab_subtitle_setting_key);
	$c++;
	$frtac = $c == 1 ? ' active' : '';
	if ($tab) {
		$data_item = isset($tab['tab_style']) && isset($tab['tab_style']['citem']) ? 'data-item-id=' . esc_attr($tab['tab_style']['citem']) . '' : '';
		$nav_menu .= '
		<li class="kata-plus-tab-item' . esc_attr($frtac) . ' elementor-repeater-item-' . esc_attr($tab['_id']) . '"' . esc_attr($data_item) . '>
			<a href="#' . esc_attr($tab['_id']) . '" class="kata-lazyload">
				' . Kata_Plus_Pro_Helpers::get_icon('', $tab['tab_icon'], '', '') . '
				' . $image . '
				<span class="kata-tabs-title" ' . $this->get_render_attribute_string($tab_title_setting_key) . '>' . wp_kses($tab['tab_title'], wp_kses_allowed_html('post')) . '</span>
				<span class="kata-desc" ' . $this->get_render_attribute_string($tab_subtitle_setting_key) . '>' . wp_kses($tab['tab_subtitle'], wp_kses_allowed_html('post')) . '</span>
			</a>
		</li>';
	}
}
$nav_menu .= '</ul>';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if ($tabs) : ?>
	<div class="kata-plus-tabs <?php echo esc_attr($classes); ?>">
		<?php
		if ($settings['tab_pos'] == 'kata-plus-tabs-htl' || $settings['tab_pos'] == 'kata-plus-tabs-htc' || $settings['tab_pos'] == 'kata-plus-tabs-htr' || $settings['tab_pos'] == 'kata-plus-tabs-vl kata-plus-tabs-is-v' || $settings['tab_pos'] == 'kata-plus-tabs-vr kata-plus-tabs-is-v') {
			echo $nav_menu;
		}
		?>
		<div class="kata-plus-tabs-contents">
			<?php
			$c = 0;
			foreach ($tabs as $tab) {
				$c++;
				$frtac = $c == 1 ? ' active' : '';
				if ($tab['tab_item'] != '0') {
			?>
					<div class="kata-plus-tabs-content<?php echo esc_attr($frtac); ?>" id="<?php echo esc_attr($tab['_id']); ?>">
						<?php
						echo Plugin::instance()->frontend->get_builder_content_for_display(get_page_by_title($tab['tab_item'], OBJECT, 'elementor_library')->ID);
						?>
					</div>
			<?php
				} else {
					echo '<p>' . __('You don\'t select any template for content. Please select a template from tab settings', 'kata-plus') . '</p>';
				}
			}
			?>
		</div>
		<?php
		if ($settings['tab_pos'] == 'kata-plus-tabs-hbl' || $settings['tab_pos'] == 'kata-plus-tabs-hbc' || $settings['tab_pos'] == 'kata-plus-tabs-hbr') {
			echo $nav_menu;
		}
		?>
	</div>
<?php
endif;

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
