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

if ( ! class_exists( 'Kata_Plus_Theme_Options_Styling_Typography' ) ) {
	class Kata_Plus_Theme_Options_Styling_Typography extends Kata_Plus_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {

			// -> Start Styling & Typography section
			Kirki::add_section(
				'kata_styling_typography_section',
				[
					'title'      => esc_html__('Advanced Styling', 'kata-plus'),
					'capability' => Kata_Plus_Helpers::capability(),
					'icon'       => 'ti-palette',
					'priority'   => 5,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'     => 'color',
					'settings' => 'kata_base_color',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Primary Color', 'kata-plus'),
					'default'  => '',
					'choices'  => [
						'alpha' => true,
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_body_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Body', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('body'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_all_heading',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('All Heading', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('h1, h2, h3, h4, h5, h6', 'h1:hover, h2:hover, h3:hover, h4:hover, h5:hover, h6:hover'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_h1_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Heading 1', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('h1'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_h2_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Heading 2', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('h2'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_h3_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Heading 3', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('h3'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_h4_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Heading 4', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('h4'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_h5_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Heading 5', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('h5'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_h6_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Heading 6', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('h6'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_p_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Paragraph (p tag)', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('p'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_blockquote_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Blockquote', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('blockquote'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_a_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Links (a tag)', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('a'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_img_tag',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Image (img tag)', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output('.elementor img,img', '.elementor img:hover,img:hover'),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'styler_button_element',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Button', 'kata-plus'),
					'type'     => 'kata_styler',
					'choices'  => Kata_Styler::kirki_output( 'a.kata-button' ),
				]
			);
		}

		/**
		 * Added Fonts
		 *
		 * @since 1.0.0
		 */
		public static function added_fonts() {
			$fonts = get_theme_mod( 'kata_add_google_font_repeater' );
			$added_fonts = [];
			$added_fonts['select-font'] = 'Select Font';
			if ( $fonts ) {
				foreach ($fonts as $key => $font) {
					$added_fonts[$font['fonts']] = $font['fonts'];
				}
			}
			return $added_fonts;
		}

	} // class

	Kata_Plus_Theme_Options_Styling_Typography::set_options();
}
