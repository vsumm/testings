<?php
/**
 * Preloader Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Theme_Options_Preloader' ) ) {
	class Kata_Plus_Pro_Theme_Options_Preloader extends Kata_Plus_Pro_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// -> START Preloader section
			Kirki::add_section(
				'kata_preloader_section',
				[
					'title'      => esc_html__( 'Preloader', 'kata-plus' ),
					'icon'       => 'ti-reload',
					'capability' => Kata_Plus_Pro_Helpers::capability(),
					'priority'   => 2,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_enable_preloader',
					'section'     => 'kata_preloader_section',
					'label'       => esc_html__( 'Preloader', 'kata-plus' ),
					'description' => esc_html__( 'Add Preloader to your website', 'kata-plus' ),
					'type'        => 'switch',
					'default'     => 'off',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus' ),
						'off' => esc_html__( 'Disabled', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_preloader_preview',
					'section'     => 'kata_preloader_section',
					'label'       => esc_html__( 'Preview Mode', 'kata-plus' ),
					'description' => esc_html__( 'To style the preloader enable this option to see a preview of the preloader. After making the changes please disable this option.', 'kata-plus' ),
					'type'        => 'switch',
					'default'     => 'off',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus' ),
						'off' => esc_html__( 'Disabled', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_enable_preloader',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_preloader_type',
					'section'  => 'kata_preloader_section',
					'label'    => esc_html__( 'Preloader Type', 'kata-plus' ),
					'description' => esc_html__( 'Select a preloader to be displayed as the page loads.', 'kata-plus' ),
					'type'     => 'select',
					'default'  => 'ball-chasing',
					'choices'  => [
						'arc-scale'             => esc_html__( 'Arc Scale', 'kata-plus' ),
						'arc-rotate2'           => esc_html__( 'Arc Rotate2', 'kata-plus' ),
						'circle-pulse'          => esc_html__( 'Circle Pulse', 'kata-plus' ),
						'ball-chasing'          => esc_html__( 'Ball Chasing', 'kata-plus' ),
						'ball-pulse'            => esc_html__( 'Ball Pulse', 'kata-plus' ),
						'ball-pulse-double'     => esc_html__( 'Ball Pulse Double', 'kata-plus' ),
						'wave'                  => esc_html__( 'Wave', 'kata-plus' ),
						'wave-spread'           => esc_html__( 'Wave Spread', 'kata-plus' ),
						'circle-pulse-multiple' => esc_html__( 'Circle Pulse Multiple', 'kata-plus' ),
						'arc-rotate-double'     => esc_html__( 'Arc Rotate Double', 'kata-plus' ),
						'square-split'          => esc_html__( 'Square Split', 'kata-plus' ),
						'arc-rotate'            => esc_html__( 'Arc Rotate', 'kata-plus' ),
						'clock'                 => esc_html__( 'Clock', 'kata-plus' ),
						'square-rotate-3d'      => esc_html__( 'Square Rotate 3D', 'kata-plus' ),
						'spinner'               => esc_html__( 'Spinner', 'kata-plus' ),
						'whirlpool'             => esc_html__( 'Whirlpool', 'kata-plus' ),
						'drawing'               => esc_html__( 'Drawing', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_enable_preloader',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_preloader',
					'section'         => 'kata_preloader_section',
					'label'           => esc_html__( 'Preloader Style', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         =>  Kata_Styler::kirki_output( 'body .kata-preloader-screen, body .kata-arc-scale .kata-loader .kata-arc::before, body .kata-arc-scale .kata-loader .kata-arc::after' ) ,
					'active_callback' => [
						[
							'setting'  => 'kata_enable_preloader',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
		}
	} // class

	Kata_Plus_Pro_Theme_Options_Preloader::set_options();
}
