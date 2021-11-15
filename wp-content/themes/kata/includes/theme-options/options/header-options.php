<?php
/**
 * Layout Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Theme_Options_Header' ) ) {
	class Kata_Theme_Options_Header extends Kata_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {

			// Header Section
			Kirki::add_section(
				'kata_header_section',
				[
					'icon'       => 'ti-layout-tab-window',
					'title'      => esc_html__( 'Header', 'kata' ),
					'capability' => kata_Helpers::capability(),
					'priority'	 => 2,

				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_header_border',
					'section'         => 'kata_header_section',
					'label'           => esc_html__('Border', 'kata'),
					'description'     => esc_html__('Header border bottom size', 'kata'),
					'type'            => 'slider',
					'default'         => 1,
					'choices'         => [
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'section'  => 'kata_header_section',
					'settings' => 'kata_header_border_color',
					'type'     => 'color',
					'label'    => esc_html__('Border Color', 'kata'),
					'description'     => esc_html__('Header border bottom color', 'kata'),
					'default'  => '#f0f1f1',
					'choices'  => [
						'alpha' => true,
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_full_width_header',
					'section'     => 'kata_header_section',
					'label'       => esc_html__( 'Full Width Header', 'kata' ),
					'type'        => 'switch',
					'default'     => 'off',
					'choices'     => [
						'on'  	=> esc_html__( 'Enabled', 'kata' ),
						'off'	=> esc_html__( 'Disabled', 'kata' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_header_layout',
					'section'     => 'kata_header_section',
					'label'       => esc_html__( 'Layout', 'kata' ),
					'type'        => 'radio-image',
					'default'     => 'left',
					'choices'     => [
						'left'   => kata::$assets . '/img/left-header.png',
						'right'  => kata::$assets . '/img/right-header.png',
						'center' => kata::$assets . '/img/center-header.png',
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_mobile_header_layout',
					'section'     => 'kata_header_section',
					'label'       => esc_html__( 'Mobile Layout', 'kata' ),
					'type'        => 'radio-image',
					'default'     => 'left',
					'choices'     => [
						'left'   => kata::$assets . '/img/mobile-left-header.png',
						'right'  => kata::$assets . '/img/mobile-right-header.png',
					],
				]
			);

		}
	} // class

	Kata_Theme_Options_Header::set_options();
}
