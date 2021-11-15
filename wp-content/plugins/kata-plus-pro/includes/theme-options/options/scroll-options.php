<?php

/**
 * Scroll Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('Kata_Plus_Pro_Options_Scroll')) {
	class Kata_Plus_Pro_Options_Scroll extends Kata_Plus_Pro_Theme_Options
	{
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options()
		{
			// -> Start Scroll panel
			Kirki::add_panel(
				'kata_scroll_panel',
				[
					'title'      => esc_html__('Scroll', 'kata-plus'),
					'icon'       => 'ti-mouse',
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);

			// -> Back To Top Button section
			Kirki::add_section(
				'kata_back_to_top_button_section',
				[
					'panel'      => 'kata_scroll_panel',
					'title'      => esc_html__('Back To Top', 'kata-plus'),
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_backto_top_btn',
					'section'     => 'kata_back_to_top_button_section',
					'label'       => esc_html__('Back to top button', 'kata-plus'),
					'description' => esc_html__('Back to top Button will show in right botton of your site', 'kata-plus'),
					'type'        => 'switch',
					'default'     => '1',
					'choices'     => [
						'on'  => esc_html__('Enabled', 'kata-plus'),
						'off' => esc_html__('Disabled', 'kata-plus'),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_back_to_top_btn_on_mobile',
					'section'         => 'kata_back_to_top_button_section',
					'label'           => esc_html__('Keep Back To Top Button On Mobile', 'kata-plus'),
					'description'     => esc_html__('If you select "Enabled", it will show in mobile devices.', 'kata-plus'),
					'type'            => 'switch',
					'default'         => '0',
					'choices'         => [
						'on'  => esc_html__('Enabled', 'kata-plus'),
						'off' => esc_html__('Disabled', 'kata-plus'),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_backto_top_btn',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_styler_back_to_top_wrap',
					'section'         => 'kata_back_to_top_button_section',
					'label'           => esc_html__('Back to top bottom (Box Style)', 'kata-plus'),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output('#scroll-top .scrollup'),
					'active_callback' => [
						[
							'setting'  => 'kata_backto_top_btn',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_styler_back_to_top_wrap_icon',
					'section'         => 'kata_back_to_top_button_section',
					'label'           => esc_html__('Back to top bottom (Icon Style)', 'kata-plus'),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output('#scroll-top .scrollup i'),
					'active_callback' => [
						[
							'setting'  => 'kata_backto_top_btn',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);

			// -> Smooth Scroll section
			Kirki::add_section(
				'kata_smooth_scroll_section',
				[
					'panel'      => 'kata_scroll_panel',
					'title'      => esc_html__('Smooth Scroll', 'kata-plus'),
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_smooth_scroll',
					'section'     => 'kata_smooth_scroll_section',
					'label'       => esc_html__('Smooth Scroll', 'kata-plus'),
					'description' => esc_html__('By enabling this option, your page will have smooth scrolling effect.', 'kata-plus'),
					'type'        => 'switch',
					'default'     => 'off',
					'choices'     => [
						'on'  => esc_html__('Enabled', 'kata-plus'),
						'off' => esc_html__('Disabled', 'kata-plus'),
					],
				]
			);

			// -> Scroll Bar section
			Kirki::add_section(
				'kata_scroll_bar_section',
				[
					'panel'      => 'kata_scroll_panel',
					'title'      => esc_html__('Scroll Bar', 'kata-plus'),
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_custom_scrollbar',
					'section'     => 'kata_scroll_bar_section',
					'label'       => esc_html__('Customize Browser Scroll Bar', 'kata-plus'),
					'description' => esc_html__('You will be able to customize the browser scrollbar by enable this option', 'kata-plus'),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__('Enabled', 'kata-plus'),
						'off' => esc_html__('Disabled', 'kata-plus'),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_scrollbar_cursor_color',
					'section'         => 'kata_scroll_bar_section',
					'label'           => esc_html__('Cursor Color', 'kata-plus'),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output('.nicescroll-rails .nicescroll-cursors'),
					'active_callback' => [
						[
							'setting'  => 'kata_custom_scrollbar',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_scrollbar_rail_background',
					'section'         => 'kata_scroll_bar_section',
					'label'           => esc_html__('Rail Background', 'kata-plus'),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output('.nicescroll-rails'),
					'active_callback' => [
						[
							'setting'  => 'kata_custom_scrollbar',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
		}
	} // class

	Kata_Plus_Pro_Options_Scroll::set_options();
}
