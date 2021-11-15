<?php

/**
 * Container Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('Kata_Plus_Theme_Options_Container')) {
	class Kata_Plus_Theme_Options_Container extends Kata_Plus_Theme_Options
	{
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options()
		{
			// Container section
			Kirki::add_section(
				'kata_container_section',
				[
					'title'      => esc_html__('Container', 'kata-plus'),
					'icon'       => 'ti-layout',
					'capability' => Kata_Plus_Helpers::capability(),
					'priority'   => 3,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_wide_container',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Fluid Container', 'kata-plus'),
					'description'     => esc_html__('Wide Container for large screens', 'kata-plus'),
					'type'            => 'switch',
					'default'         => '0',
					'choices'         => [
						'on'  => esc_html__('Enabled', 'kata-plus'),
						'off' => esc_html__('Disabled', 'kata-plus'),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_styler_container',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Container Styler', 'kata-plus'),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output('.container, .elementor-section.elementor-section-boxed>.elementor-container'),
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_styler_container',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Body Styler', 'kata-plus'),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output('body'),
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-boxed',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_grid_size_desktop',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Desktop', 'kata-plus'),
					'description'     => esc_html__('Container size for desktop', 'kata-plus'),
					'type'            => 'slider',
					'default'         => 1280,
					'choices'         => [
						'min'  => 0,
						'max'  => 3840,
						'step' => 1,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_grid_size_laptop',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Laptop', 'kata-plus'),
					'description'     => esc_html__('Container size for laptop', 'kata-plus'),
					'type'            => 'slider',
					'default'         => 1024,
					'choices'         => [
						'min'  => 0,
						'max'  => 3840,
						'step' => 1,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_grid_size_tabletlandscape',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Tablet Landscape', 'kata-plus'),
					'description'     => esc_html__('Container size for landscape', 'kata-plus'),
					'type'            => 'slider',
					'default'         => 96,
					'choices'         => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_grid_size_tablet',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Tablet', 'kata-plus'),
					'description'     => esc_html__('Container size for tablet', 'kata-plus'),
					'type'            => 'slider',
					'default'         => 96,
					'choices'         => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_grid_size_mobile',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Mobile', 'kata-plus'),
					'description'     => esc_html__('Container size for mobile', 'kata-plus'),
					'type'            => 'slider',
					'default'         => 96,
					'choices'         => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_grid_size_small_mobile',
					'section'         => 'kata_container_section',
					'label'           => esc_html__('Small Mobile', 'kata-plus'),
					'description'     => esc_html__('Container size for mobile small screen sizes', 'kata-plus'),
					'type'            => 'slider',
					'default'         => 100,
					'choices'         => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'active_callback' => [
						[
							'setting'  => 'kata_layout',
							'operator' => '==',
							'value'    => 'kata-wide',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_elementor_default_columns_gap',
					'section'		=> 'kata_container_section',
					'label'			=> esc_html__( 'Columns Gap', 'kata-plus' ),
					'description'	=> esc_html__('Gap between Elementor columns', 'kata-plus'),
					'type'			=> 'select',
					'default'		=> 'default',
					'choices'		=> [
						'default'	=> __( 'Default', 'kata-plus' ),
						'no'		=> __( 'No Gap', 'kata-plus' ),
						'narrow'	=> __( 'Narrow', 'kata-plus' ),
						'extended'	=> __( 'Extended', 'kata-plus' ),
						'wide'		=> __( 'Wide', 'kata-plus' ),
						'wider'		=> __( 'Wider', 'kata-plus' ),
						'custom'	=> __( 'Custom', 'kata-plus' ),
					],
				]
			);
		}
	} // class

	Kata_Plus_Theme_Options_Container::set_options();
}
