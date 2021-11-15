<?php

/**
 * Styling & Typography Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Theme_Options_Add_Google_Fonts_Typography' ) ) {
	class Kata_Plus_Pro_Theme_Options_Add_Google_Fonts_Typography extends Kata_Plus_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// -> Start Section
			Kirki::add_section(
				'kata_add_google_fonts_pro_section',
				[
					'title'			=> esc_html__( 'Font Manager', 'kata-plus' ),
					'capability'	=> 'manage_options',
					'priority'		=> 4,
					'icon'			=> 'ti-uppercase'
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_fonts_manager',
					'section'	=> 'kata_add_google_fonts_pro_section',
					'type'		=> 'custom',
					'label'		=> esc_html__( 'Font Manager', 'kata-plus' ),
					'description'	=> esc_html__( 'Click on the button below to add/remove Fonts', 'kata-plus' ),
					'default'	=> '
					<a href="' . esc_url( admin_url( 'admin.php?page=kata-plus-fonts-manager' ) ) . '" id="elementor-switch-mode-button" class="button customizer-kata-builder-button button-large">
						<span class="elementor-switch-mode-off"><i class="eicon-elementor-square" aria-hidden="true"></i> ' . __( 'Go to Font Manager', 'kata-plus' ) . '</span>
					</a>',
				]
			);
		}

	} // class

	Kata_Plus_Pro_Theme_Options_Add_Google_Fonts_Typography::set_options();
}
