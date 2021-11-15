<?php
/**
 * Blog Options.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Theme_Options_Blog' ) ) {
	class Kata_Theme_Options_Blog extends Kata_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			// Blog panel
			Kirki::add_panel(
				'kata_blog_panel',
				[
					'title'      => esc_html__( 'Blog', 'kata' ),
					'icon'       => 'ti-pencil-alt',
					'type' 		 => 'kirki-nested',
					'capability' => kata_Helpers::capability(),
					'priority'   => 4,
				]
			);
			Kirki::add_panel(
				'kata_blog_and_archive_panel',
				[
					'title'      => esc_html__( 'Blog', 'kata' ),
					'capability' => kata_Helpers::capability(),
					'icon' 		 => 'ti-layout-list-post',
					'panel'      => 'kata_blog_panel',
					'priority'   => 4,
				]
			);
			Kirki::add_panel(
				'kata_blog_post_single_panel',
				[
					'title'      => esc_html__( 'Single', 'kata' ),
					'capability' => kata_Helpers::capability(),
					'icon' 		 => 'ti-layout-list-post',
					'panel'      => 'kata_blog_panel',
					'priority'   => 4,
				]
			);

			// First Posts
			Kirki::add_section(
				'kata_blog_sidebar_section',
				[
					'panel'      => 'kata_blog_and_archive_panel',
					'title'      => esc_html__( 'Sidebar', 'kata' ),
					'capability' => kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'section'     => 'kata_blog_sidebar_section',
					'settings'    => 'kata_blog_sidebar_setting',
					'label'    => esc_html__( 'Sidebar Position', 'kata' ),
					'type'     => 'radio-buttonset',
					'default'  => 'right',
					'choices'  => [
						'none'  => esc_html__( 'None', 'kata' ),
						'left'  => esc_html__( 'Left', 'kata' ),
						'right' => esc_html__( 'Right', 'kata' ),
						'both'  => esc_html__( 'Both', 'kata' ),
					],
				]
			);

			// Posts
			Kirki::add_section(
				'kata_blog_posts_section',
				[
					'panel'      => 'kata_blog_and_archive_panel',
					'title'      => esc_html__( 'Posts', 'kata' ),
					'capability' => kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'select',
					'section'     => 'kata_blog_posts_section',
					'settings'    => 'kata_blog_posts_thumbnail_pos',
					'label'       => esc_html__( 'Thumbnail Position', 'kata' ),
					'default'     => 'left',
					'choices'     => [
						'left'	=> esc_html__( 'Left', 'kata' ),
						'right'	=> esc_html__( 'Right', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'sortable',
					'section'     => 'kata_blog_posts_section',
					'settings'    => 'kata_blog_posts_sortable_setting',
					'label'       => esc_html__( 'Post Structure', 'kata' ),
					'default'     => [
						'kata_post_categories',
						'kata_post_title',
						'kata_post_post_excerpt',
					],
					'choices'     => [
						'kata_post_categories'		=> esc_html__( 'Category', 'kata' ),
						'kata_post_title'			=> esc_html__( 'Title', 'kata' ),
						'kata_post_post_excerpt'	=> esc_html__( 'Post Excerpt', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'sortable',
					'section'     => 'kata_blog_posts_section',
					'settings'    => 'kata_blog_posts_metadata_sortable_setting',
					'label'       => esc_html__( 'Metadata Structure', 'kata' ),
					'default'     => [
						'kata_post_date',
						'kata_post_author',
					],
					'choices'     => [
						'kata_post_date'	=> esc_html__( 'Date', 'kata' ),
						'kata_post_author' 	=> esc_html__( 'Author', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'        => 'kata_blog_posts_excerpt_length',
					'section'         => 'kata_blog_posts_section',
					'label'           => esc_html__('Excerpt length', 'kata'),
					'description'     => esc_html__('Sets the post excerpt length size', 'kata'),
					'type'            => 'slider',
					'default'         => 40,
					'choices'         => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				]
			);

			// Single
			Kirki::add_section(
				'kata_post_single_section',
				[
					'panel'      => 'kata_blog_panel',
					'icon'       => 'ti-pencil-alt',
					'title'      => esc_html__( 'Post Single', 'kata' ),
					'capability' => kata_Helpers::capability(),
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_thumbnail',
					'label'       => esc_html__( 'Post Thumbnail', 'kata' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_categories',
					'label'       => esc_html__( 'Post Categories', 'kata' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_title',
					'label'       => esc_html__( 'Post Title', 'kata' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_date',
					'label'       => esc_html__( 'Post Date', 'kata' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_author',
					'label'       => esc_html__( 'Post Author', 'kata' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_tags',
					'label'       => esc_html__( 'Post Tags', 'kata' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
					'priority'    => 10,
				]
			);
			Kirki::add_field(
				self::$opt_name,
				[
					'type'        => 'switch',
					'section'     => 'kata_post_single_section',
					'settings'    => 'kata_post_single_socials',
					'label'       => esc_html__( 'Post Socials', 'kata' ),
					'default'     => '1',
					'priority'    => 10,
					'choices'     => [
						'on'  => esc_html__( 'Enable', 'kata' ),
						'off' => esc_html__( 'Disable', 'kata' ),
					],
					'priority'    => 10,
				]
			);
		}
	} // class

	Kata_Theme_Options_Blog::set_options();
}
