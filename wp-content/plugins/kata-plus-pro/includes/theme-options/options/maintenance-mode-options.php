<?php
/**
 * Maintenance Mode Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Theme_Options_Maintenance_Mode' ) ) {
	class Kata_Plus_Pro_Theme_Options_Maintenance_Mode extends Kata_Plus_Pro_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// -> Start Maintenance Mode section
			Kirki::add_section(
				'kata_maintenance_mode_options',
				[
					'title'      	=> esc_html__( 'Maintenance Mode', 'kata-plus' ),
					'icon'   		=> 'ti-hummer',
					'capability' 	=> Kata_Plus_Pro_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'section'  => 'kata_maintenance_mode_options',
					'settings' => 'maintenance_mode',
					'label'    => esc_html__('Maintenance Mode', 'kata-plus'),
					'type'     => 'switch',
					'default'  => '0',
					'choices'  => [
						'off' => esc_html__('Disable', 'kata-plus'),
						'on'  => esc_html__('Enable', 'kata-plus'),
					],
				]
			);
			$args = [
				'post_type' => 'page',
			];
			$pages = get_posts($args);
			$chooses = [];
			foreach ($pages as $page ) {
				$chooses[$page->ID] = $page->post_title;
			}
			Kirki::add_field(
				self::$opt_name,
				[
				'section'		=> 'kata_maintenance_mode_options',
				'settings'		=> 'kata_maintenance_page_id',
				'label'			=> esc_html__('Select a Page', 'kata-plus'),
				'type'			=> 'select',
				'priority'		=> 10,
				'multiple'		=> 1,
				'choices'		=> $chooses,
				'active_callback' => [
					[
						'setting'  => 'maintenance_mode',
						'operator' => '==',
						'value'    => '1',
					],
				],
			]);
		}
	} // class

	Kata_Plus_Pro_Theme_Options_Maintenance_Mode::set_options();
}
