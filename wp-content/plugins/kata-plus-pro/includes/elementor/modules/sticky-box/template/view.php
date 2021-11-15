<?php

/**
 * Sticky box module view.
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

$settings        = $this->get_settings();
$item            = get_page_by_title($settings['item'], OBJECT, 'elementor_library')->ID;
$item_pos        = $settings['item_pos'];
$just_sec        = $settings['just_sec'];
$item_pos_tablet = $settings['item_pos_tablet'];
$item_pos_mobile = $settings['item_pos_mobile'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
static $i = 2;
echo '<div class="kata-sticky-box" id="box-' . $i . '" data-pos-des="' . $item_pos . '" data-pos-tablet="' . $item_pos_tablet . '" data-pos-mobile="' . $item_pos_mobile . '" data-sec="' . $just_sec . '" >';
if ($item) {
	echo '<div> ' . Plugin::instance()->frontend->get_builder_content_for_display($item) . ' </div>';
}
echo '</div>';
$i++;
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
