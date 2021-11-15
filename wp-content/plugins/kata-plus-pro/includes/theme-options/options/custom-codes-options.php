<?php
/**
 * Custom Codes Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Theme_Options_Custom_Codes' ) ) {
	class Kata_Plus_Pro_Theme_Options_Custom_Codes extends Kata_Plus_Pro_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// -> Start Custom Codes section
			Kirki::add_section(
				'kata_custom_codes_options',
				[
					'title'      => esc_html__( 'Custom Codes', 'kata-plus' ),
					'icon'   => 'ti-shortcode',
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_space_before_head',
					'section'		=> 'kata_custom_codes_options',
					'type'			=> 'code',
					'label'			=> __( 'Before </head> Tag', 'kata-plus' ),
					'choices'		=> [
						'language' => 'html',
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_space_before_body',
					'section'		=> 'kata_custom_codes_options',
					'type'			=> 'code',
					'label'			=> __( 'Before </body> Tag', 'kata-plus' ),
					'choices'		=> [
						'language' => 'html',
					],
				]
			);
		}
	} // class

	Kata_Plus_Pro_Theme_Options_Custom_Codes::set_options();
}
