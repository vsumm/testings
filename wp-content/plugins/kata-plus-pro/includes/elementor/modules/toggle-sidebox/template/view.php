<?php

/**
 * Toggle SideBox view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
    exit;
}

use \Elementor\Plugin;

$settings = $this->get_settings_for_display();
$box_text = !empty($settings['box_text']) ? '<span class="toggle-sidebox-trigger-text">' . $settings['box_text'] . '</span>' : '';
$box_icon = !empty($settings['box_icon']) ? '<span class="toggle-sidebox-open-btn">' . Kata_Plus_Pro_Helpers::get_icon('', $settings['box_icon'], '', '') . '</span>' : '';
$box_icon_close = !empty($settings['box_icon_close']) ? '<span class="toggle-sidebox-close-btn">' . Kata_Plus_Pro_Helpers::get_icon('', $settings['box_icon_close'], '', '') . '</span>' : '';
$trigger  = $settings['icon_location'] == 'after-text' ? $box_text . $box_icon . $box_icon_close : $box_icon . $box_text . $box_icon_close;
$content  = !empty($settings['box_content']) ? Plugin::instance()->frontend->get_builder_content_for_display(get_page_by_title($settings['box_content'], OBJECT, 'elementor_library')->ID) : esc_html__('Please select content', 'kata-plus');

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

echo '
<div class="kata-toggle-sidebox ' . $settings['toggle_from'] . '">
    <div class="toggle-sidebox-trigger">' . $trigger . '</div>
    <div class="toggle-sidebox-content">' . $content . '</div>
</div>';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
