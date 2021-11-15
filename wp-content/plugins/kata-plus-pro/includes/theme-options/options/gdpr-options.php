<?php
/**
 * White Label Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Options_GDPR' ) ) {
	class Kata_Plus_Pro_Options_GDPR extends Kata_Plus_Pro_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// -> GDPR Section
			Kirki::add_section(
				'kata_gdpr_section',
				[
                    'title'      => esc_html__( 'GDPR', 'kata-plus' ),
                    'icon'   => 'ti-lock',
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_gdpr_box',
					'section'     => 'kata_gdpr_section',
					'label'       => esc_html__( 'GDPR Box', 'kata-plus' ),
					'type'        => 'switch',
					'default'     => '0',
					'choices'     => [
                        'on'      => esc_html__( 'Show', 'kata-plus' ),
						'off'     => esc_html__( 'Hide', 'kata-plus' ),
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'    	=> 'kata_gdpr_agree_text',
					'section'     	=> 'kata_gdpr_section',
                    'label'       	=> esc_html__( 'Text for "I Agree" button', 'kata-plus' ),
                    'placeholder' 	=> esc_html__( 'Agree text', 'kata-plus' ),
					'type'        	=> 'text',
					'default'		=> __( 'I Agree', 'kata-plus' ),
                    'active_callback'    => [
						[
							'setting'  => 'kata_gdpr_box',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_gdpr_agree_style',
					'section'     => 'kata_gdpr_section',
					'label'       => esc_html__( '"I Agree" button style', 'kata-plus' ),
					'type'        => 'kata_styler',
                    'choices'   => Kata_Styler::kirki_output( 'body .kata-gdpr-box button' ),
                    'active_callback'    => [
						[
							'setting'  => 'kata_gdpr_box',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_gdpr_pp_text',
					'section'		=> 'kata_gdpr_section',
                    'label'			=> esc_html__( 'Privacy Policy text for button', 'kata-plus' ),
                    'default'		=> esc_html__( 'Privacy Preference', 'kata-plus' ),
                    'type'			=> 'text',
                    'active_callback'		=> [
						[
							'setting'	=> 'kata_gdpr_box',
							'operator'	=> '==',
							'value'		=> '1',
						],
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'			=> 'kata_gdpr_pp_link',
					'section'			=> 'kata_gdpr_section',
                    'label'				=> esc_html__( 'Privacy Policy Page URL', 'kata-plus' ),
                    'type'				=> 'link',
                    'default'			=> 'link',
                    'active_callback'	=> [
						[
							'setting'  => 'kata_gdpr_box',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_gdpr_pp_style',
					'section'     => 'kata_gdpr_section',
					'label'       => esc_html__( 'Privacy Policy button style', 'kata-plus' ),
					'type'        => 'kata_styler',
                    'choices'   => Kata_Styler::kirki_output( 'body .kata-gdpr-box .gdpr-button-privacy a' ),
                    'active_callback'    => [
						[
							'setting'  => 'kata_gdpr_box',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_gdpr_content',
					'section'     => 'kata_gdpr_section',
                    'label'       => esc_html__( 'Description', 'kata-plus' ),
                    'default'     => esc_html__( 'We use cookies from third party services to offer you a better experience. Read about how we use cookies and how you can control them by clicking Privacy Preferences.', 'kata-plus' ),
                    'type'        => 'textarea',
                    'active_callback'    => [
						[
							'setting'  => 'kata_gdpr_box',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_gdpr_content_style',
					'section'     => 'kata_gdpr_section',
					'label'       => esc_html__( 'Description style', 'kata-plus' ),
					'type'        => 'kata_styler',
                    'choices'   => Kata_Styler::kirki_output( 'body .kata-gdpr-box .gdpr-content-wrap p' ),
                    'active_callback'    => [
						[
							'setting'  => 'kata_gdpr_box',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
            );
            Kirki::add_field(
				self::$opt_name,
				[
					'settings'    => 'kata_gdpr_box_style',
					'section'     => 'kata_gdpr_section',
					'label'       => esc_html__( 'Wrapper style', 'kata-plus' ),
					'type'        => 'kata_styler',
                    'choices'   => Kata_Styler::kirki_output( 'body .kata-gdpr-box' ),
                    'active_callback'    => [
						[
							'setting'  => 'kata_gdpr_box',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
            );
		}
	} // class

	Kata_Plus_Pro_Options_GDPR::set_options();
}
