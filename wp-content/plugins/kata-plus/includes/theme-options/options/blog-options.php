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

if ( ! class_exists( 'Kata_Plus_Theme_Options_Blog' ) ) {
	class Kata_Plus_Theme_Options_Blog extends Kata_Plus_Theme_Options {
		/**
		 * Set Options.
		 *
		 * @since   1.0.0
		 */
		public static function set_options() {
			! class_exists( 'Kata_Plus_Builders_Base' ) ? Kata_Plus_Autoloader::load(Kata_Plus::$dir . 'includes/elementor/builders', '01-builder-base') : '';

			// Blog panel
			Kirki::add_panel(
				'kata_blog_panel',
				[
					'title'      => esc_html__( 'Blog', 'kata-plus' ),
					'icon'       => 'ti-pencil-alt',
					'type' 		 => 'kirki-nested',
					'capability' => Kata_Plus_Helpers::capability(),
					'priority'   => 4,
				]
			);

			// Blog Posts
			Kirki::add_section(
				'kata_blog_posts_section',
				[
					'panel'      => 'kata_blog_panel',
					'icon'       => 'ti-pencil-alt',
					'title'      => esc_html__( 'Blog', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			$blog_url = class_exists( 'Kata_Plus_Builders_Base' ) ? Kata_Plus_Builders_Base::builder_url( 'Kata Blog' ) : '';
			Kirki::add_field(
				self::$opt_name,
				[
					'settings'		=> 'kata_blog_builder',
					'section'		=> 'kata_blog_posts_section',
					'type'			=> 'custom',
					'label'			=> esc_html__( 'Blog Builder', 'kata-plus' ),
					'description'	=> esc_html__( 'Click on the button below to customize the Blog\'s layout', 'kata-plus' ),
					'default'		=> '
					<a href="' . esc_url( $blog_url ) . '" id="elementor-switch-mode-button" class="button customizer-kata-builder-button button-large">
						<span class="elementor-switch-mode-off"><i class="eicon-elementor-square" aria-hidden="true"></i> ' . __( 'Go to Blog Builder', 'kata-plus' ) . '</span>
					</a>',
				]
			);

			// Archive Posts
			Kirki::add_section(
				'kata_archive_posts_section',
				[
					'panel'      => 'kata_blog_panel',
					'icon'       => 'ti-pencil-alt',
					'title'      => esc_html__( 'Archive Page', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			if ( class_exists( 'Kata_Plus_Pro' ) ) {
				$blog_url = class_exists( 'Kata_Plus_Builders_Base' ) ? Kata_Plus_Builders_Base::builder_url( 'Kata Archive' ) : '';
				Kirki::add_field(
					self::$opt_name,
					[
						'settings'	=> 'kata_archive_builder',
						'section'	=> 'kata_archive_posts_section',
						'type'		=> 'custom',
						'label'		=> esc_html__( 'Archive Builder', 'kata-plus' ),
						'description'	=> esc_html__( 'Click on the button below to customize the Archive\'s layout', 'kata-plus' ),
						'default'	=> '
						<a href="' . esc_url( $blog_url ) . '" id="elementor-switch-mode-button" class="button customizer-kata-builder-button button-large">
							<span class="elementor-switch-mode-off"><i class="eicon-elementor-square" aria-hidden="true"></i> ' . __( 'Go to Archive Builder', 'kata-plus' ) . '</span>
						</a>',
					]
				);
			}

			// Single
			Kirki::add_section(
				'kata_post_single_section',
				[
					'panel'      => 'kata_blog_panel',
					'icon'       => 'ti-pencil-alt',
					'title'      => esc_html__( 'Post Single', 'kata-plus' ),
					'capability' => Kata_Plus_Helpers::capability(),
				]
			);
			if ( class_exists( 'Kata_Plus_Pro' ) ) {
				$blog_url = class_exists( 'Kata_Plus_Builders_Base' ) ? Kata_Plus_Builders_Base::builder_url( 'Kata Single' ) : '';
				Kirki::add_field(
					self::$opt_name,
					[
						'settings'		=> 'kata_single_builder',
						'section'		=> 'kata_post_single_section',
						'type'			=> 'custom',
						'label'			=> esc_html__( 'Single Builder', 'kata-plus' ),
						'description'	=> esc_html__( 'Click on the button below to customize the Single\'s layout', 'kata-plus' ),
						'default'		=> '
						<a href="' . esc_url( $blog_url ) . '" id="elementor-switch-mode-button" class="button customizer-kata-builder-button button-large">
							<span class="elementor-switch-mode-off"><i class="eicon-elementor-square" aria-hidden="true"></i> ' . __( 'Go to Single Builder', 'kata-plus' ) . '</span>
						</a>',
					]
				);
			} else {
				Kirki::add_field(
					self::$opt_name,
					[
						'type'        => 'sortable',
						'section'     => 'kata_post_single_section',
						'settings'    => 'kata_post_single_structure',
						'label'       => esc_html__( 'Post Structure', 'kata-plus' ),
						'default'     => [
							'kata_post_single_thumbnail',
							'kata_post_single_title_and_meta',
							'kata_post_single_post_excerpt',
						],
						'choices'     => [
							'kata_post_single_thumbnail' 	  => esc_html__( 'Thumbnail', 'kata-plus' ),
							'kata_post_single_title_and_meta' => esc_html__( 'Title and Category', 'kata-plus' ),
							'kata_post_single_post_excerpt'	 => esc_html__( 'Post Excerpt', 'kata-plus' ),
						],
						'priority'    => 10,
					]
				);
				Kirki::add_field(
					self::$opt_name,
					[
						'type'        => 'sortable',
						'section'     => 'kata_post_single_section',
						'settings'    => 'kata_post_single_metadata_structure',
						'label'       => esc_html__( 'Metadata Structure', 'kata-plus' ),
						'default'     => [
							'kata_post_single_date',
							'kata_post_single_author',
							'kata_post_single_tags',
						],
						'choices'     => [
							'kata_post_single_date'	=> esc_html__( 'Date', 'kata-plus' ),
							'kata_post_single_author' 	=> esc_html__( 'Author', 'kata-plus' ),
							'kata_post_single_tags' 	=> esc_html__( 'Tags', 'kata-plus' ),
						],
						'priority'    => 10,
					]
				);
			}
		}
	} // class

	Kata_Plus_Theme_Options_Blog::set_options();
}
