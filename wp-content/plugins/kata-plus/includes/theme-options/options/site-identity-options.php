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

if ( ! class_exists( 'Kata_Plus_Theme_Options_Layout' ) ) {
	class Kata_Plus_Theme_Options_Layout extends Kata_Plus_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			$header_url = class_exists( 'Kata_Plus_Builders_Base' ) ? Kata_Plus_Builders_Base::builder_url( 'Kata Header' ) : '';
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_site_logo_builder',
					'section'	=> 'title_tagline',
					'type'		=> 'custom',
					'label'		=> esc_html__( 'Logo', 'kata-plus' ),
					'default'	=> '
					<a href="' . esc_url( $header_url ) . '" id="elementor-switch-mode-button" class="button customizer-kata-builder-button button-large">
						<span class="elementor-switch-mode-off"><i class="eicon-elementor-square" aria-hidden="true"></i>' . __( 'To Change Logo Go to Header Builder', 'kata-plus' ) . '</span>
					</a>',
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_layout',
					'section'     => 'title_tagline',
					'label'       => esc_html__( 'Layout', 'kata-plus' ),
					'description' => esc_html__( 'Controls the site layout.', 'kata-plus' ),
					'type'        => 'radio-buttonset',
					'default'     => 'kata-wide',
					'choices'     => [
						'kata-wide'  => esc_html__( 'Wide', 'kata-plus' ),
						'kata-boxed' => esc_html__( 'Boxed', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_responsive',
					'section'     => 'title_tagline',
					'label'       => esc_html__( 'Responsive', 'kata-plus' ),
					'description' => esc_html__( 'Disable this option in case you don\'t need a responsive website.', 'kata-plus' ),
					'type'        => 'switch',
					'default'     => '1',
					'choices'     => [
						'on'  => esc_html__( 'Enabled', 'kata-plus' ),
						'off' => esc_html__( 'Disabled', 'kata-plus' ),
					],
				]
			);
		}
	} // class

	Kata_Plus_Theme_Options_Layout::set_options();
}
