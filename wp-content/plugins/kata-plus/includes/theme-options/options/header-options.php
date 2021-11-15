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

if ( ! class_exists( 'Kata_Plus_Theme_Options_Header' ) ) {
	class Kata_Plus_Theme_Options_Header extends Kata_Plus_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			Kata_Plus_Autoloader::load(Kata_Plus::$dir . 'includes/elementor/builders', '01-builder-base');

			// Header Section
			Kirki::add_section(
				'kata_header_section',
				[
					'icon'       => 'ti-layout-tab-window',
					'title'      => esc_html__( 'Header', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
					'priority'	 => 2,

				]
			);
			$header_url = class_exists( 'Kata_Plus_Builders_Base' ) ? Kata_Plus_Builders_Base::builder_url( 'Kata Header' ) : '';
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_header_builder',
					'section'	=> 'kata_header_section',
					'type'		=> 'custom',
					'label'		=> esc_html__( 'Header Builder', 'kata-plus' ),
					'default'	=> '
					<a href="' . esc_url( $header_url ) . '" id="elementor-switch-mode-button" class="button customizer-kata-builder-button button-large">
						<span class="elementor-switch-mode-off"><i class="eicon-elementor-square" aria-hidden="true"></i> Go to Header Builder</span>
					</a>',
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_make_header_transparent',
					'section'	=> 'kata_header_section',
					'label'		=> esc_html__( 'Header Transparent', 'kata-plus' ),
					'type'		=> 'radio-buttonset',
					'default'	=> 'default',
					'choices'	=> [
						'default'	=> esc_html__( 'None', 'kata-plus' ),
						'posts'		=> esc_html__( 'Posts', 'kata-plus' ),
						'pages'		=> esc_html__( 'Pages', 'kata-plus' ),
						'both'		=> esc_html__( 'Both', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_header_transparent_white_color',
					'section'	=> 'kata_header_section',
					'label'		=> esc_html__( 'Dark Header Transparent', 'kata-plus' ),
					'type'		=> 'radio-buttonset',
					'default'	=> 'none',
					'default'	=> 'default',
					'choices'	=> [
						'default'	=> esc_html__( 'None', 'kata-plus' ),
						'posts'		=> esc_html__( 'Posts', 'kata-plus' ),
						'pages'		=> esc_html__( 'Pages', 'kata-plus' ),
						'both'		=> esc_html__( 'Both', 'kata-plus' ),
					],
					'active_callback'  => [
		                [
		                	'setting'  => 'kata_make_header_transparent',
		                	'operator' => '!==',
		                	'value'    => 'default',
		                ],
	                ]
				]
			);
		}
	} // class

	Kata_Plus_Theme_Options_Header::set_options();
}
