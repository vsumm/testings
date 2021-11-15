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

if ( ! class_exists( 'Kata_Theme_Options_Styling_Typography' ) ) {
	class Kata_Theme_Options_Styling_Typography extends Kata_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// Page panel
			Kirki::add_panel(
				'kata_styling_and_typography_panel',
				[
					'title'      => esc_html__( 'Styling', 'kata' ),
					'icon'       => 'ti-palette',
					'capability' => 'manage_options',
					'priority'   => 5,
				]
			);

			// -> Start Theme Typography Section
			Kirki::add_section(
				'kata_body_typography_section',
				[
					'panel'      => 'kata_styling_and_typography_panel',
					'title'      => esc_html__( 'Basic Typography', 'kata' ),
					'capability' => 'manage_options',
					'priority'   => 8,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_body_typography_status',
					'section'     => 'kata_body_typography_section',
					'label'       => esc_html__( 'Body Typography', 'kata' ),
					'description' => esc_html__( 'Controls the typography of body.', 'kata' ),
					'type'        => 'radio-buttonset',
					'default'     => 'disable',
					'choices'     => [
						'disable'	=> esc_html__( 'Disable', 'kata' ),
						'enabel'	=> esc_html__( 'Enabel', 'kata' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_body_font_family',
					'section'	=> 'kata_body_typography_section',
					'type'		=> 'select',
					'default'	=> 'select-font',
					'label'		=> esc_html__( 'Font Family', 'kata' ),
					'choices'	=> self::added_fonts(),
					'active_callback' => [
						[
							'setting'  => 'kata_body_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_body_font_properties',
					'section'	=> 'kata_body_typography_section',
					'type'		=> 'dimensions',
					'label'		=> esc_html__( 'Font Properties', 'kata' ),
					'default'	=> [
						'font-size'			=> '15px',
						'font-weight'		=> '400',
						'letter-spacing'	=> '0px',
						'line-height'		=> '1.5',
					],
					'active_callback' => [
						[
							'setting'  => 'kata_body_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_body_font_color',
					'section'  => 'kata_body_typography_section',
					'type'     => 'color',
					'label'    => esc_html__('Color', 'kata'),
					'default'  => '',
					'choices'  => [
						'alpha' => true,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_body_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);

			// -> Start Headings Typography Section
			Kirki::add_section(
				'kata_headings_typography_section',
				[
					'panel'      => 'kata_styling_and_typography_panel',
					'title'      => esc_html__( 'Headings Typography', 'kata' ),
					'capability' => 'manage_options',
					'priority'   => 9,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_headings_typography_status',
					'section'     => 'kata_headings_typography_section',
					'label'       => esc_html__( 'Headings Typography', 'kata' ),
					'description' => esc_html__( 'Controls the typography of H1-H6.', 'kata' ),
					'type'        => 'radio-buttonset',
					'default'     => 'disable',
					'choices'     => [
						'disable'	=> esc_html__( 'Disable', 'kata' ),
						'enabel'	=> esc_html__( 'Enabel', 'kata' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_headings_font_family',
					'section'	=> 'kata_headings_typography_section',
					'type'		=> 'select',
					'default'	=> 'select-font',
					'label'		=> esc_html__( 'Font Family', 'kata' ),
					'choices'	=> self::added_fonts(),
					'active_callback' => [
						[
							'setting'  => 'kata_headings_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_headings_font_properties',
					'section'	=> 'kata_headings_typography_section',
					'type'		=> 'dimensions',
					'label'		=> esc_html__( 'Font Properties', 'kata' ),
					'default'	=> [
						'font-size'			=> '15px',
						'font-weight'		=> '400',
						'letter-spacing'	=> '0px',
						'line-height'		=> '1.5',
					],
					'active_callback' => [
						[
							'setting'  => 'kata_headings_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_headings_font_color',
					'section'  => 'kata_headings_typography_section',
					'type'     => 'color',
					'label'    => esc_html__('Color', 'kata'),
					'default'  => '',
					'choices'  => [
						'alpha' => true,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_headings_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);

			// -> Start Nav Menu Typography Section
			Kirki::add_section(
				'kata_nav_menu_typography_section',
				[
					'panel'      => 'kata_styling_and_typography_panel',
					'title'      => esc_html__( 'Nav Menu Typography', 'kata' ),
					'capability' => 'manage_options',
					'priority'   => 9,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_nav_menu_typography_status',
					'section'     => 'kata_nav_menu_typography_section',
					'label'       => esc_html__( 'Nav Menu Typography', 'kata' ),
					'description' => esc_html__( 'Controls the typography of nav menu items.', 'kata' ),
					'type'        => 'radio-buttonset',
					'default'     => 'disable',
					'choices'     => [
						'disable'	=> esc_html__( 'Disable', 'kata' ),
						'enabel'	=> esc_html__( 'Enabel', 'kata' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_nav_menu_font_family',
					'section'	=> 'kata_nav_menu_typography_section',
					'type'		=> 'select',
					'default'	=> 'select-font',
					'label'		=> esc_html__( 'Font Family', 'kata' ),
					'choices'	=> self::added_fonts(),
					'active_callback' => [
						[
							'setting'  => 'kata_nav_menu_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_nav_menu_font_properties',
					'section'	=> 'kata_nav_menu_typography_section',
					'type'		=> 'dimensions',
					'label'		=> esc_html__( 'Font Properties', 'kata' ),
					'default'	=> [
						'font-size'			=> '15px',
						'font-weight'		=> '400',
						'letter-spacing'	=> '0px',
						'line-height'		=> '1.5',
					],
					'active_callback' => [
						[
							'setting'  => 'kata_nav_menu_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_nav_menu_font_color',
					'section'  => 'kata_nav_menu_typography_section',
					'type'     => 'color',
					'label'    => esc_html__('Color', 'kata'),
					'default'  => '',
					'choices'  => [
						'alpha' => true,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_nav_menu_typography_status',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);

			// -> Start Styling & Typography section
			Kirki::add_section(
				'kata_styling_typography_section',
				[
					'title'      => esc_html__('Advanced Styling', 'kata'),
					'panel'      => 'kata_styling_and_typography_panel',
					'capability' => Kata_Helpers::capability(),
					'priority'   => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'     => 'color',
					'settings' => 'kata_base_color',
					'section'  => 'kata_styling_typography_section',
					'label'    => esc_html__('Primary Color', 'kata'),
					'default'  => '',
					'choices'  => [
						'alpha' => true,
					],
				]
			);

			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_install_kata_plus',
					'section'	=> 'kata_styling_typography_section',
					'type'		=> 'custom',
					'label'		=> esc_html__( 'To more options please install Kata Plus', 'kata' ),
					'default'	=> '
					<a href="' . esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . '" target="_blank" class="button customizer-kata-builder-button button-large">
						<span class="elementor-switch-mode-off">' . esc_html__( 'Plugins Installer', 'kata' ) . '</span>
					</a>',
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

	Kata_Theme_Options_Styling_Typography::set_options();
}
