<?php
/**
 * API Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Options_API' ) ) {
	class Kata_Plus_Pro_Options_API extends Kata_Plus_Pro_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// -> Start API panel
			Kirki::add_panel(
				'kata_api_panels',
				[
					'title'      => esc_html__( 'API', 'kata-plus' ),
					'icon'       => 'ti-shield',
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);

			// -> Google Map section
			Kirki::add_section(
				'kata_google_map_section',
				[
					'panel'      => 'kata_api_panels',
					'title'      => esc_html__( 'Google Map', 'kata-plus' ),
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_google_map_api',
					'section'     => 'kata_google_map_section',
					'label'       => esc_html__( 'Google Map API', 'kata-plus' ),
					'description' => wp_kses( __( 'To create  google map API key, please follow this link: <a href="https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend,places_backend&keyType=CLIENT_SIDE&reusekey=true" target="_blank">Click Here</a>', 'kata-plus' ), wp_kses_allowed_html( 'post' ) ),
					'type'        => 'text',
				]
			);

			// -> Instagram section
			Kirki::add_section(
				'kata_instagram_section',
				[
					'panel'      => 'kata_api_panels',
					'title'      => esc_html__( 'Instagram', 'kata-plus' ),
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_instagram_app_id',
					'section'     => 'kata_instagram_section',
					'label'       => esc_html__( 'Instagram App ID', 'kata-plus' ),
					'description' => wp_kses_post( __( 'To create "Instagram App ID key", please follow this link: <a href="https://climaxthemes.com/kata/documentation/instagram" target="_blank">Click Here</a>', 'kata-plus' ) ),
					'type'        => 'text',
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_instagram_app_secret',
					'section'     => 'kata_instagram_section',
					'label'       => esc_html__( 'Instagram App Secret', 'kata-plus' ),
					'description' => wp_kses_post( __( 'To create "Instagram App Secret" key, please follow this link: <a href="https://climaxthemes.com/kata/documentation/instagram" target="_blank">Click Here</a>', 'kata-plus' ) ),
					'type'        => 'text',
				]
			);
		}
	} // class

	Kata_Plus_Pro_Options_API::set_options();
}
