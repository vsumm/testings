<?php
/**
 * Footer Bottom Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Theme_Options_Footer' ) ) {
	class Kata_Theme_Options_Footer extends Kata_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// Footer panel
			Kirki::add_panel(
				'kata_footer_panel',
				[
					'title'      => esc_html__( 'Footer', 'kata' ),
					'icon'       => 'ti-layout-media-overlay-alt',
					'capability' => Kata_Helpers::capability(),
					'priority'   => 4,

				]
			);
			// Footer Top Widgets Area
			Kirki::add_section(
				'kata_footer_widgets_area_section',
				[
					'panel'      => 'kata_footer_panel',
					'title'      => esc_html__( 'Footer Widgets Area', 'kata' ),
					'capability' => Kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_footer_widget_area',
					'section'     => 'kata_footer_widgets_area_section',
					'label'       => esc_html__( 'Widget Area', 'kata' ),
					'description' => esc_html__( 'By chooing enable you will abel add widgets to footer widgets are for showing widgets in footer.', 'kata' ),
					'type'        => 'switch',
					'default'     => true,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'section'     => 'kata_footer_widgets_area_section',
					'settings'    => 'kata_footer_background_setting',
					'type'        => 'background',
					'label'       => esc_html__( 'Background', 'kata' ),
					'default'     => [
						'background-color'      => '',
						'background-image'      => '',
						'background-repeat'     => '',
						'background-position'   => '',
						'background-size'       => 'cover',
						'background-attachment' => 'scroll',
					],
					'transport'   => 'auto',
					'active_callback' => [
						[
							'setting'  => 'kata_footer_widget_area',
							'operator' => '==',
							'value'    => 'enabel',
						],
					],
				]
			);
			// Footer Buttom
			Kirki::add_section(
				'kata_footer_bottom_section',
				[
					'panel'      => 'kata_footer_panel',
					'title'      => esc_html__( 'Footer Bottom', 'kata' ),
					'capability' => Kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_footer_bottom_area',
					'section'     => 'kata_footer_bottom_section',
					'label'       => esc_html__( 'Footer Buttom', 'kata' ),
					'description' => esc_html__( 'By chooing enable you will abel add widgets to footer widgets are for showing widgets in footer.', 'kata' ),
					'type'        => 'switch',
					'default'     => 'on',
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_footer_bottom_layout',
					'section'     => 'kata_footer_bottom_section',
					'label'       => esc_html__( 'Layout', 'kata' ),
					'type'        => 'radio-image',
					'default'     => 'left',
					'choices'     => [
						'left'		=> Kata::$assets . '/img/left-footer.png',
						'center'	=> Kata::$assets . '/img/center-footer.png',
					],
					'active_callback' => [
						[
							'setting'  => 'kata_footer_bottom_area',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_footer_bottom_left_section',
					'section'     => 'kata_footer_bottom_section',
					'type'        => 'select',
					'label'       => esc_html__( 'First Section', 'kata' ),
					'default'     => 'custom-text',
					'choices'     => [
						'none' 			=> esc_html__( 'None', 'kata' ),
						'footer-menu' 	=> esc_html__( 'Footer Menu', 'kata' ),
						'custom-text'	=> esc_html__( 'Custom Text', 'kata' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_footer_bottom_area',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_footer_bottom_left_custom_text',
					'section'	=> 'kata_footer_bottom_section',
					'type'		=> 'textarea',
					'label'		=> esc_html__( 'First Custom Text', 'kata' ),
					'description'	=> esc_html__( 'Copyright ©[kata-date] all right reserved.', 'kata' ),
					'active_callback' => [
						[
							'setting'  => 'kata_footer_bottom_left_section',
							'operator' => '==',
							'value'    => 'custom-text',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_footer_bottom_right_section',
					'section'     => 'kata_footer_bottom_section',
					'type'        => 'select',
					'label'       => esc_html__( 'Second Section', 'kata' ),
					'default'     => 'footer-menu',
					'choices'     => [
						'none' 			=> esc_html__( 'None', 'kata' ),
						'footer-menu' 	=> esc_html__( 'Footer Menu', 'kata' ),
						'custom-text'	=> esc_html__( 'Custom Text', 'kata' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_footer_bottom_area',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_footer_bottom_right_custom_text',
					'section'	=> 'kata_footer_bottom_section',
					'type'		=> 'textarea',
					'label'		=> esc_html__( 'Second Custom Text', 'kata' ),
					'description'	=> esc_html__( 'Email: contact@yourwebsite.com', 'kata' ),
					'active_callback' => [
						[
							'setting'  => 'kata_footer_bottom_right_section',
							'operator' => '==',
							'value'    => 'custom-text',
						],
					],
				]
			);
		}
	} // class

	Kata_Theme_Options_Footer::set_options();
}
