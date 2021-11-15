<?php
/**
 * Performance Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Theme_Options_Performance' ) ) {
	class Kata_Plus_Pro_Theme_Options_Performance extends Kata_Plus_Pro_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// Elementor Performance section
			Kirki::add_panel(
				'kata_performance_options',
				[
					'title'      => esc_html__( 'Performance', 'kata-plus-pro' ),
					'capability' => kata_Plus_Helpers::capability(),
					'icon' 		 => 'ti-dashboard',
				]
			);
			Kirki::add_section(
				'kata_elementor_performance_options',
				[
					'panel'      => 'kata_performance_options',
					'title'      => esc_html__( 'Elementor', 'kata-plus-pro' ),
					'capability' => kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_google_fonts',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Google fonts', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable Google fonts that Elementor loads.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_fontawesome',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'FontAwesome', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable FontAwesome that Elementor loads.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_pro_js',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Elementor Pro JS Files', 'kata-plus-pro' ),
					'description' => esc_html__( 'It is possible that some features of Elementor Pro stop working by disabling these files.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_editor_js',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Editor Scripts', 'kata-plus-pro' ),
					'description' => esc_html__( 'It is possible that some features of Elementor stop working for logged in user by disabling these files.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_animations',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Animations', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable if you do not use animations in you page.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_prallax_motions',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Prallax Motion', 'kata-plus-pro' ),
					'description' => esc_html__( 'By Disabling this option Parallax motion effects will not works.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_frontend_scripts',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Elementor Frontend Scripts', 'kata-plus-pro' ),
					'description' => esc_html__( 'dialog, swiper, share link', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_frontend_scripts',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Elementor Frontend Scripts', 'kata-plus-pro' ),
					'description' => esc_html__( 'dialog, swiper, share link', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_elementor_performance_icons',
					'section'     => 'kata_elementor_performance_options',
					'label'       => esc_html__( 'Elementor Icons', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable jQuery Elementor e-icons', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);

			// Elementor Performance section
			Kirki::add_section(
				'kata_wordpress_performance_options',
				[
					'panel'      => 'kata_performance_options',
					'title'      => esc_html__( 'WordPress', 'kata-plus-pro' ),
					'capability' => kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_wordpress_performance_jquery_migrate',
					'section'     => 'kata_wordpress_performance_options',
					'label'       => esc_html__( 'jQuery Migrate', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable jQuery Migrate Javascript library', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_wordpress_performance_minify_html',
					'section'     => 'kata_wordpress_performance_options',
					'label'       => esc_html__( 'Minify HTML', 'kata-plus-pro' ),
					'description' => esc_html__( 'Remove unnecessary whitespaces from HTML', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on' => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off'  => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_wordpress_performance_wp_emojis',
					'section'     => 'kata_wordpress_performance_options',
					'label'       => esc_html__( 'jQuery WP emojis', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable WP emojis', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on' => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off'  => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_wordpress_performance_wp_block_library',
					'section'     => 'kata_wordpress_performance_options',
					'label'       => esc_html__( 'WP Block Library', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable WP Block Library (Does not include single posts)', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on' => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off'  => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_wordpress_performance_query_var_strings',
					'section'     => 'kata_wordpress_performance_options',
					'label'       => esc_html__( 'Query Strings', 'kata-plus-pro' ),
					'description' => esc_html__( 'Disable styles and scripts query strings', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on' => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off'  => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);

			Kirki::add_section(
				'kata_assets_manager',
				[
					'panel'      => 'kata_performance_options',
					'title'      => esc_html__( 'Assets Manager', 'kata-plus-pro' ),
					'capability' => kata_Plus_Helpers::capability(),
				]
			);
			$scripts = json_decode( get_option( 'kata_script_manager' ), true );
			if ( ! empty( $scripts ) ) {
				Kirki::add_field(
					self::$opt_name,
					[
						'settings'	=> 'kata_script_manager_title',
						'section'	=> 'kata_assets_manager',
						'type'		=> 'custom',
						'label'		=> '',
						'default'	=> wp_kses( '<h2>Manage Script files</h2><p>' . __( 'Note that these options are designed for professional users, using these options may cause some functions not to work well. So if you are a beginner, it is not recommended to use these options.', 'kata-plus-pro' ) . '</p>', array( 'p' => true, 'h2' => true ) ),
					]
				);
				foreach ( $scripts['scripts'] as $script ) {
					Kirki::add_field(
						self::$opt_name,
						[
							'settings'    => 'kata_prevent_load_script_' . $script,
							'section'     => 'kata_assets_manager',
							'label'       => esc_html__( 'Prevent loading ' . $script, 'kata-plus-pro' ),
							'type'        => 'switch',
							'default'     => '0',
							'choices'     => [
								'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
								'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
							],
						]
					);
				}
				Kirki::add_field(
					self::$opt_name,
					[
						'settings'	=> 'kata_style_manager_title',
						'section'	=> 'kata_assets_manager',
						'type'		=> 'custom',
						'label'		=> '',
						'default'	=> wp_kses( '<h2>Manage Style files</h2><p>' . __( 'Note that these options are designed for professional users, using these options may cause some functions not to work well. So if you are a beginner, it is not recommended to use these options.', 'kata-plus-pro' ) . '</p>', array( 'p' => true, 'h2' => true ) ),
					]
				);
				foreach ( $scripts['styles'] as $style ) {
					Kirki::add_field(
						self::$opt_name,
						[
							'settings'    => 'kata_prevent_load_style_' . $style,
							'section'     => 'kata_assets_manager',
							'label'       => esc_html__( 'Prevent loading ' . $style, 'kata-plus-pro' ),
							'type'        => 'switch',
							'default'     => '0',
							'choices'     => [
								'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
								'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
							],
						]
					);
				}
			}

			Kirki::add_section(
				'kata_assets_performance_options',
				[
					'panel'      => 'kata_performance_options',
					'title'      => esc_html__( 'Optimization', 'kata-plus-pro' ),
					'capability' => kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_plus_pro_css_minify',
					'section'     => 'kata_assets_performance_options',
					'label'       => esc_html__( 'Merge & minify Styles', 'kata-plus-pro' ),
					'description' => esc_html__( 'Merge CSS files to reduce number of HTTP requests.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_plus_pro_js_minify',
					'section'     => 'kata_assets_performance_options',
					'label'       => esc_html__( 'Merge & minify JavaScript', 'kata-plus-pro' ),
					'description' => esc_html__( 'Merge Javascript files to reduce number of HTTP requests.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_plus_pro_js_load_interaction',
					'section'     => 'kata_assets_performance_options',
					'label'       => esc_html__( 'Delay Async Scripts', 'kata-plus-pro' ),
					'description' => esc_html__( 'Load scripts only on user interaction or load after 3 seconds.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_plus_pro_lazyload',
					'section'     => 'kata_assets_performance_options',
					'label'       => esc_html__( 'Lazyload', 'kata-plus-pro' ),
					'description' => esc_html__( 'Lazyload for images.', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_plus_pro_leverage_browser_caching',
					'section'     => 'kata_assets_performance_options',
					'label'       => esc_html__( 'Browser Cache', 'kata-plus-pro' ),
					'description' => esc_html__( 'If you enable this option it will generate htacess/nginx rules for browser cache. (Expire headers should be configured on your server as well).', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_plus_pro_gzip',
					'section'     => 'kata_assets_performance_options',
					'label'       => esc_html__( 'Gzip', 'kata-plus-pro' ),
					'description' => esc_html__( 'If you enable this option it will generate htacess/nginx rules for gzip compression. (Compression should be configured on your server as well).', 'kata-plus-pro' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus-pro' ),
						'off' => esc_html__( 'Disabled', 'kata-plus-pro' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_plus_pro_critical_css',
					'section'		=> 'kata_assets_performance_options',
					'type'			=> 'code',
					'label'			=> __( 'Critical CSS', 'kata-plus' ),
					'choices'		=> [
						'language' => 'css',
					],
				]
			);
		}
	} // class

	Kata_Plus_Pro_Theme_Options_Performance::set_options();
}
