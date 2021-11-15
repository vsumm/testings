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

if ( ! class_exists( 'Kata_Plus_Pro_Options_White_Label' ) ) {
	class Kata_Plus_Pro_Options_White_Label extends Kata_Plus_Pro_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
            // -> Start White Label section
			Kirki::add_section(
				'kata_white_label_section',
				[
                    'title'      => esc_html__( 'White labeling', 'kata-plus' ),
                    'icon'   => 'ti-bookmark-alt',
					'capability' => Kata_Plus_Pro_Helpers::capability(),
				]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_theme_white_label_name',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'Choose Name', 'kata-plus' ),
                    'description' => esc_html__( 'Choose name for replacing kata words in view', 'kata-plus' ),
                    'type'        => 'text',
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_theme_version',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'Version', 'kata-plus' ),
                    'description' => esc_html__( 'Choose version for replacing theme version in view. Example: 1.0.0', 'kata-plus' ),
                    'type'        => 'text',
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_control_panel',
                    'section'     => 'kata_white_label_section',
	                'label'       => esc_html__( 'Control panel', 'kata-plus' ),
	                'default'     => '1',
                    'type'        => 'switch',
	                'choices'     => [
                        'on'  => esc_html__( 'Show', 'kata-plus' ),
	                	'off' => esc_html__( 'Hide', 'kata-plus' ),
	                ],
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_theme_control_panel_fields',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'Remove Control Panel Items', 'kata-plus' ),
                    'type'        => 'multicheck',
                    'choices'  => [
                        'activation'    	=> __( 'Theme Activation', 'kata-plus' ),
                        'demo_importer'     => __( 'Demo Importer', 'kata-plus' ),
                        'plugin_manager'    => __( 'Plugin Manager', 'kata-plus' ),
                        'font_manager' 		=> __( 'Font Manager', 'kata-plus' ),
                        'customizer'		=> __( 'Customizer Menu', 'kata-plus' ),
                        'template_library'	=> __( 'Templates Library Menu', 'kata-plus' ),
                        'add_new' 			=> __( 'Add New Menu', 'kata-plus' ),
                        'help_menu' 		=> __( 'Help Menu', 'kata-plus' ),
                        'finder'     		=> __( 'Finder Menu', 'kata-plus' ),
                        'fast_mode' 		=> __( 'Fast Mode', 'kata-plus' ),
                    ],
                    'active_callback'  => [
		                [
		                	'setting'  => 'kata_control_panel',
		                	'operator' => '===',
		                	'value'    => true,
		                ],
	                ]
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_theme_cpt_fields',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'Remove Post Types', 'kata-plus' ),
                    'type'        => 'multicheck',
                    'choices'  => [
                        'grid'    			=> 'Portfolio',
                        'testimonial'     	=> 'Testimonial',
                        'recipe'    		=> 'Recipe',
                        'team_member' 		=> 'Team Member',
                    ],
                    'active_callback'  => [
		                [
		                	'setting'  => 'kata_control_panel',
		                	'operator' => '===',
		                	'value'    => true,
		                ],
	                ]
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_theme_remove_submenu_fields',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'Remove Control Panel Submenus', 'kata-plus' ),
                    'type'        => 'multicheck',
                    'choices'  => [
                        'demo_importers'    => __( 'Demo Importer', 'kata-plus' ),
                        'plugins'    		=> __( 'Plugin Manager', 'kata-plus' ),
                        'header' 			=> __( 'Header', 'kata-plus' ),
                        'heaeder_sticky'	=> __( 'Header Sticky', 'kata-plus' ),
                        'footer'			=> __( 'Footer', 'kata-plus' ),
                        'blog'			    => __( 'Blog', 'kata-plus' ),
                        'single'			=> __( 'Single', 'kata-plus' ),
                        'archive' 			=> __( 'Archive', 'kata-plus' ),
                        'author' 			=> __( 'Author', 'kata-plus' ),
                        'search' 			=> __( 'Search', 'kata-plus' ),
                        'error_404' 		=> __( '404', 'kata-plus' ),
                        'mega_menu' 		=> __( 'Mega Menu', 'kata-plus' ),
                        'portfolio' 		=> __( 'Portfolio', 'kata-plus' ),
                        'fast_mode' 		=> __( 'Fast Mode', 'kata-plus' ),
                        'help' 		        => __( 'Help', 'kata-plus' ),
                    ],
                    'active_callback'  => [
		                [
		                	'setting'  => 'kata_control_panel',
		                	'operator' => '===',
		                	'value'    => true,
		                ],
	                ]
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_theme_admin_logo',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'Logo', 'kata-plus' ),
                    'description' => esc_html__( 'Upload your logo to display it instead of Kata logo in the admin panel', 'kata-plus' ),
                    'type'        => 'image',
                    'choices'     => [
                        'save_as' => 'array',
                    ],
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_admin_login_logo',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'WordPress Logo', 'kata-plus' ),
                    'description' => esc_html__( 'Upload your logo to display instead of  WordPress logo at the top of the login form', 'kata-plus' ),
                    'type'        => 'image',
                    'choices'     => [
                        'save_as' => 'array',
                    ],
                ]
            );
            Kirki::add_field(
                self::$opt_name,
                [
                    'settings'    => 'kata_theme_admin_custom_css',
                    'section'     => 'kata_white_label_section',
                    'label'       => esc_html__( 'Custom CSS For admin', 'kata-plus' ),
                    'description' => esc_html__( 'Any CSS your write here will run in admin.', 'kata-plus' ),
                    'type'        => 'code',
                    'choices'     => [
                        'language' => 'css',
                    ],
                ]
            );
		}
	} // class

	Kata_Plus_Pro_Options_White_Label::set_options();
}
