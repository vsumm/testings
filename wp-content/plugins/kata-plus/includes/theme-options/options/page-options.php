<?php
/**
 * Page Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Theme_Options_Page' ) ) {
	class Kata_Plus_Theme_Options_Page extends Kata_Plus_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// Page panel
			Kirki::add_panel(
				'kata_page_panel',
				[
					'title'      => esc_html__( 'Pages', 'kata-plus' ),
					'icon'       => 'ti-write',
					'capability' => Kata_Plus_Helpers::capability(),
					'priority'   => 4,
				]
			);

			// Page Title section
			Kirki::add_section(
				'kata_page_title_section',
				[
					'panel'      => 'kata_page_panel',
					'title'      => esc_html__( 'Pages', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_show_page_title',
					'section'		=> 'kata_page_title_section',
					'label'			=> esc_html__( 'Page Title', 'kata-plus' ),
					'description'	=> esc_html__( 'Show/Hide Page\'s title', 'kata-plus' ),
					'type'     => 'switch',
					'default'  => '1',
					'choices'  => [
						'off' => esc_html__( 'Hide', 'kata-plus' ),
						'on'  => esc_html__( 'Show', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_page_title_wrapper',
					'section'         => 'kata_page_title_section',
					'label'           => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.page #kata-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_page_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_page_title',
					'section'         => 'kata_page_title_section',
					'label'           => esc_html__( 'Page Title', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.page #kata-page-title h1' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_page_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);

			// Blog Title section
			Kirki::add_section(
				'kata_blog_title_section',
				[
					'panel'      => 'kata_page_panel',
					'title'      => esc_html__( 'Blog', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_blog_show_header',
					'section'	=> 'kata_blog_title_section',
					'label'		=> esc_html__('Header', 'kata-plus'),
					'description'	=> esc_html__( 'Show/Hide Header in Blog\'s page', 'kata-plus' ),
					'type'		=> 'switch',
					'default'	=> '1',
					'priority'	=> 1,
					'choices'	=> [
						'on'  => esc_html__('Show', 'kata-plus'),
						'off' => esc_html__('Hide', 'kata-plus'),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_blog_transparent_header',
					'section'	=> 'kata_blog_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 2,
					'choices'	=> [
						'0'			=> esc_html__( 'Disable', 'kata-plus' ),
						'1'			=> esc_html__( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_blog_show_header',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_blog_header_transparent_white_color',
					'section'	=> 'kata_blog_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Dark Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 3,
					'choices'	=> [
						'0'			=> __( 'Disable', 'kata-plus' ),
						'1'			=> __( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_blog_transparent_header',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_show_blog_title',
					'section'  => 'kata_blog_title_section',
					'label'    => esc_html__( 'Blog Title', 'kata-plus' ),
					'description'    => esc_html__( 'Show/Hide Blog\'s title', 'kata-plus' ),
					'type'     => 'switch',
					'default'  => '1',
					'choices'  => [
						'off' => esc_html__( 'Hide', 'kata-plus' ),
						'on'  => esc_html__( 'Show', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_blog_title_wrapper',
					'section'         => 'kata_blog_title_section',
					'label'           => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.blog #kata-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_blog_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_blog_title',
					'section'         => 'kata_blog_title_section',
					'label'           => esc_html__( 'Title', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.blog #kata-page-title h1.kata-archive-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_blog_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);

			// Archive Title section
			Kirki::add_section(
				'kata_archive_title_section',
				[
					'panel'      => 'kata_page_panel',
					'title'      => esc_html__( 'Archive', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_archive_show_header',
					'section'		=> 'kata_archive_title_section',
					'label'			=> esc_html__('Header', 'kata-plus'),
					'description'	=> esc_html__('Show/Hide Header in Archive\'s page', 'kata-plus'),
					'type'			=> 'switch',
					'default'		=> '1',
					'priority'		=> 1,
					'choices'	=> [
						'on'  => esc_html__('Show', 'kata-plus'),
						'off' => esc_html__('Hide', 'kata-plus'),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_archive_transparent_header',
					'section'	=> 'kata_archive_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 2,
					'choices'	=> [
						'0'			=> esc_html__( 'Disable', 'kata-plus' ),
						'1'			=> esc_html__( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_archive_show_header',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_archive_header_transparent_white_color',
					'section'	=> 'kata_archive_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Dark Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 3,
					'choices'	=> [
						'0'			=> __( 'Disable', 'kata-plus' ),
						'1'			=> __( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_archive_transparent_header',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_show_archive_title',
					'section'		=> 'kata_archive_title_section',
					'label'			=> esc_html__( 'Archive Title', 'kata-plus' ),
					'description'	=> esc_html__( 'Show/Hide Archive\'s title', 'kata-plus' ),
					'type'			=> 'switch',
					'default'		=> '1',
					'choices'  => [
						'off' => esc_html__( 'Hide', 'kata-plus' ),
						'on'  => esc_html__( 'Show', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_archive_title_wrapper',
					'section'         => 'kata_archive_title_section',
					'label'           => esc_html__( 'Container', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.archive #kata-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_archive_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_archive_title',
					'section'         => 'kata_archive_title_section',
					'label'           => esc_html__( 'Title Wrapper', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.archive #kata-page-title h1.kata-archive-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_archive_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_archive_title_part1',
					'section'         => 'kata_archive_title_section',
					'label'           => esc_html__( 'Title', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.archive #kata-page-title h1.kata-archive-page-title .kt-tax-name' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_archive_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_archive_title_part2',
					'section'         => 'kata_archive_title_section',
					'label'           => esc_html__( 'Subtitle', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( 'body.archive #kata-page-title h1.kata-archive-page-title .kt-tax-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_archive_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);

			// Author Title section
			Kirki::add_section(
				'kata_author_title_section',
				[
					'panel'      => 'kata_page_panel',
					'title'      => esc_html__( 'Author', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_author_show_header',
					'section'	=> 'kata_author_title_section',
					'label'		=> esc_html__('Header', 'kata-plus'),
					'description'	=> esc_html__( 'Show/Hide Header in Authro\'s page', 'kata-plus' ),
					'type'		=> 'switch',
					'default'	=> '1',
					'priority'	=> 1,
					'choices'	=> [
						'on'  => esc_html__('Show', 'kata-plus'),
						'off' => esc_html__('Hide', 'kata-plus'),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_author_transparent_header',
					'section'	=> 'kata_author_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 2,
					'choices'	=> [
						'0'			=> esc_html__( 'Disable', 'kata-plus' ),
						'1'			=> esc_html__( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_author_show_header',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_author_header_transparent_white_color',
					'section'	=> 'kata_author_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Dark Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 3,
					'choices'	=> [
						'0'			=> __( 'Disable', 'kata-plus' ),
						'1'			=> __( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_author_transparent_header',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_show_author_title',
					'section'  => 'kata_author_title_section',
					'label'    => esc_html__( 'Author Title', 'kata-plus' ),
					'description'    => esc_html__( 'Show/Hide Author\'s title', 'kata-plus' ),
					'type'     => 'switch',
					'default'  => '1',
					'choices'  => [
						'off' => esc_html__( 'Hide', 'kata-plus' ),
						'on'  => esc_html__( 'Show', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_author_title_wrapper',
					'section'         => 'kata_author_title_section',
					'label'           => esc_html__( 'Container', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.author #kata-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_author_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_author_title',
					'section'         => 'kata_author_title_section',
					'label'           => esc_html__( 'Title Wrapper', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.author #kata-page-title h1.kata-archive-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_author_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_author_title_part1',
					'section'         => 'kata_author_title_section',
					'label'           => esc_html__( 'Title', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.author #kata-page-title h1.kata-archive-page-title .kt-tax-name' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_author_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_author_title_part2',
					'section'         => 'kata_author_title_section',
					'label'           => esc_html__( 'Subtitle', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.author #kata-page-title h1.kata-archive-page-title .vcard' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_author_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);

			// Search Title section
			Kirki::add_section(
				'kata_search_title_section',
				[
					'panel'      => 'kata_page_panel',
					'title'      => esc_html__( 'Search', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_search_show_header',
					'section'	=> 'kata_search_title_section',
					'label'		=> esc_html__('Show Header', 'kata-plus'),
					'description'	=> esc_html__( 'Show/Hide Header in Search\'s page', 'kata-plus' ),
					'type'		=> 'switch',
					'default'	=> '1',
					'priority'	=> 1,
					'choices'	=> [
						'on'  => esc_html__('Show', 'kata-plus'),
						'off' => esc_html__('Hide', 'kata-plus'),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_search_transparent_header',
					'section'	=> 'kata_search_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 2,
					'choices'	=> [
						'0'			=> esc_html__( 'Disable', 'kata-plus' ),
						'1'			=> esc_html__( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_search_show_header',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_search_header_transparent_white_color',
					'section'	=> 'kata_search_title_section',
					'type'		=> 'radio-buttonset',
					'label'		=> esc_html__( 'Dark Header Transparent', 'kata-plus' ),
					'default'	=> '0',
					'priority'	=> 3,
					'choices'	=> [
						'0'			=> __( 'Disable', 'kata-plus' ),
						'1'			=> __( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_search_transparent_header',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_show_search_title',
					'section'  => 'kata_search_title_section',
					'label'    => esc_html__( 'Page Title', 'kata-plus' ),
					'description'    => esc_html__( 'Show/Hide Search\'s title', 'kata-plus' ),
					'type'     => 'switch',
					'default'  => '1',
					'choices'  => [
						'off' => esc_html__( 'Hide', 'kata-plus' ),
						'on'  => esc_html__( 'Show', 'kata-plus' ),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_search_title_wrapper',
					'section'         => 'kata_search_title_section',
					'label'           => esc_html__( 'Container', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.search #kata-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_search_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_search_title',
					'section'         => 'kata_search_title_section',
					'label'           => esc_html__( 'Title Wrapper', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.search #kata-page-title h1.kata-archive-page-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_search_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_search_title_part1',
					'section'         => 'kata_search_title_section',
					'label'           => esc_html__( 'Title', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.search #kata-page-title h1.kata-archive-page-title .kt-tax-name' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_search_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'styler_kata_search_title_part2',
					'section'         => 'kata_search_title_section',
					'label'           => esc_html__( 'Subtitle', 'kata-plus' ),
					'type'            => 'kata_styler',
					'choices'         => Kata_Styler::kirki_output( '.search #kata-page-title h1.kata-archive-page-title .kt-search-title' ),
					'active_callback' => [
						[
							'setting'  => 'kata_show_search_title',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);

			// 404 Not Found section
			Kirki::add_section(
				'kata_404_title_section',
				[
					'panel'      => 'kata_page_panel',
					'title'      => esc_html__( '404 Not Found', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'	=> 'kata_404_show_header',
					'section'	=> 'kata_404_title_section',
					'label'		=> esc_html__('Header', 'kata-plus'),
					'description'	=> esc_html__( 'Show/Hide Header in 404\'s page', 'kata-plus' ),
					'type'		=> 'switch',
					'default'	=> '1',
					'priority'	=> 1,
					'choices'	=> [
						'on'  => esc_html__('Show', 'kata-plus'),
						'off' => esc_html__('Hide', 'kata-plus'),
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_404_transparent_header',
					'section'		=> 'kata_404_title_section',
					'type'			=> 'radio-buttonset',
					'label'			=> esc_html__( 'Header Transparent', 'kata-plus' ),
					'default'		=> '0',
					'priority'		=> 2,
					'choices'		=> [
						'0'	=> esc_html__( 'Disable', 'kata-plus' ),
						'1'	=> esc_html__( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_404_show_header',
							'operator' => '==',
							'value'    => true,
						],
					],
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_404_header_transparent_white_color',
					'section'		=> 'kata_404_title_section',
					'type'			=> 'radio-buttonset',
					'label'			=> esc_html__( 'Dark Header Transparent', 'kata-plus' ),
					'default'		=> '0',
					'priority'		=> 3,
					'choices'		=> [
						'0'	=> __( 'Disable', 'kata-plus' ),
						'1'	=> __( 'Enable', 'kata-plus' ),
					],
					'active_callback' => [
						[
							'setting'  => 'kata_404_transparent_header',
							'operator' => '==',
							'value'    => '1',
						],
					],
				]
			);

			// -> Sidebar section
			Kirki::add_section(
				'kata_page_sidebar_section',
				[
					'panel'      => 'kata_page_panel',
					'title'      => esc_html__( 'Sidebar', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings' => 'kata_page_sidebar_position',
					'section'  => 'kata_page_sidebar_section',
					'label'    => esc_html__( 'Sidebar', 'kata-plus' ),
					'description'    => esc_html__( 'Positions of Sidebar', 'kata-plus' ),
					'type'     => 'radio-buttonset',
					'default'  => 'none',
					'choices'  => [
						'none'  => esc_html__( 'None', 'kata-plus' ),
						'left'  => esc_html__( 'Left', 'kata-plus' ),
						'right' => esc_html__( 'Right', 'kata-plus' ),
						'both'  => esc_html__( 'Both', 'kata-plus' ),
					],
				]
			);
		}
	} // class

	Kata_Plus_Theme_Options_Page::set_options();
}
