<?php

/**
 * Post Metadata module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class Kata_Plus_Post_Metadata extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-post-metadata';
	}

	public function get_title()
	{
		return esc_html__('Post Metadata', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-post-info';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor_blog_and_post'];
	}

	public function get_script_depends()
	{
		return ['zilla-likes'];
	}

	public function get_style_depends()
	{
		return ['zilla-likes'];
	}

	protected function register_controls()
	{
		// Metadata section
		$this->start_controls_section(
			'metadata_section',
			[
				'label' => esc_html__('Metadata', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'categories',
			[
				'label'     => esc_html__('Categories', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
			]
		);
		$this->add_control(
			'cat_icon',
			[
				'label'     => esc_html__('Category Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/folder',
				'condition' => [
					'categories' => 'yes',
				],
			]
		);
		$this->add_control(
			'cat_seprator',
			[
				'label'     => esc_html__( 'Seperator', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'	=> '|',
				'condition' => [
					'categories' => 'yes',
				],
			]
		);
		$this->add_control(
			'tags',
			[
				'label'     => esc_html__('Tags', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tags_icon',
			[
				'label'     => esc_html__('Tags Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/tag',
				'condition' => [
					'tags' => 'yes',
				],
			]
		);
		$this->add_control(
			'date',
			[
				'label'     => esc_html__('Post Date', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'icon_style_error',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'date_icon',
			[
				'label'     => esc_html__('Date Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/calendar',
				'condition' => [
					'date' => 'yes',
				],
			]
		);
		$this->add_control(
			'comments',
			[
				'label'     => esc_html__('Post Comments', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'comments_icon',
			[
				'label'     => esc_html__('Comments Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/comments',
				'condition' => [
					'comments' => 'yes',
				],
			]
		);
		$this->add_control(
			'author',
			[
				'label'     => esc_html__('Post Author', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'author_avatar',
			[
				'label'     => esc_html__('Post Author Avatar', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
				'condition' => [
					'author' => 'yes',
				],
			]
		);
		$this->add_control(
			'author_avatar_size',
			[
				'label'     => __('Post Author Avatar Size', 'kata-plus'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'' => [
						'min'  => 10,
						'max'  => 400,
						'step' => 1,
					],
				],
				'default'   => [
					'unit' => '',
					'size' => 22,
				],
				'condition' => [
					'author'        => 'yes',
					'author_avatar' => 'yes',
				],
			]
		);
		$this->add_control(
			'author_icon',
			[
				'label'     => esc_html__('Author Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/user',
				'condition' => [
					'author'        => 'yes',
					'author_avatar' => '',
				],
			]
		);
		$this->add_control(
			'like',
			[
				'label'     => esc_html__('Like', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'post_share_count',
			[
				'label'     => esc_html__('Social Share Counter:', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'post_share_count_icon',
			[
				'label'     => esc_html__('Social Share Counter Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'simple-line/action-redo',
				'condition' => [
					'post_share_count' => 'yes',
				],
			]
		);
		$this->add_control(
			'post_view',
			[
				'label'     => esc_html__('Post View:', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'post_view_icon',
			[
				'label'     => esc_html__('Post View Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'simple-line/eye',
				'condition' => [
					'post_view' => 'yes',
				],
			]
		);
		$this->add_control(
			'post_time_to_read',
			[
				'label'     => esc_html__('Post Time To Read:', 'kata-plus'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__('Show', 'kata-plus'),
				'label_off' => esc_html__('Hide', 'kata-plus'),
				'default'   => '',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'post_time_to_read_icon',
			[
				'label'     => esc_html__('Post Time To Read Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/time',
				'condition' => [
					'post_time_to_read' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		// Style section
		$this->start_controls_section(
			'style_section_wrapper',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'post_metadata_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-postmetadata'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_categories',
			[
				'label' => esc_html__('Categories', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'categories' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_category_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-category-links'),
			]
		);
		$this->add_control(
			'styler_category',
			[
				'label'     => esc_html__('Category', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-category-links a'),
			]
		);
		$this->add_control(
			'styler_category_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-category-links .kata-icon'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_tags',
			[
				'label' => esc_html__('Tags', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'tags' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_tags_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-tags-links'),
			]
		);
		$this->add_control(
			'styler_tags',
			[
				'label'     => esc_html__('Tags', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-tags-links a'),
			]
		);
		$this->add_control(
			'styler_tags_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-tags-links .kata-icon'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_date',
			[
				'label' => esc_html__('Date', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'date' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_date_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-date'),
			]
		);
		$this->add_control(
			'styler_date',
			[
				'label'     => esc_html__('Date', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-date a'),
			]
		);
		$this->add_control(
			'styler_date_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-date .kata-icon'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_comments',
			[
				'label' => esc_html__('Comments', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'comments' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_comments_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-comments-number'),
			]
		);
		$this->add_control(
			'styler_comments',
			[
				'label'     => esc_html__('Comments', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-comments-number span'),
			]
		);
		$this->add_control(
			'icon_style_error_2',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_comments_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-comments-number .kata-icon'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_author',
			[
				'label' => esc_html__('Author', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'author' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_author_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-author'),
			]
		);
		$this->add_control(
			'styler_author',
			[
				'label'     => esc_html__('Author', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-author a'),
			]
		);
		$this->add_control(
			'icon_style_error_3',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_author_avatar_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-author .kata-icon'),
			]
		);
		$this->add_control(
			'styler_author_avatar',
			[
				'label'     => esc_html__('Avatar', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-author img'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_time_to_read',
			[
				'label' => esc_html__('Time To Read', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_time_to_read' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_time_to_read_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-time-to-read'),
			]
		);
		$this->add_control(
			'styler_time_to_read',
			[
				'label'     => esc_html__('Time To Read', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-time-to-read span'),
			]
		);
		$this->add_control(
			'styler_time_to_read_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-time-to-read .kata-icon'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_like',
			[
				'label' => esc_html__('like', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'like' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_like_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.zilla-likes'),
			]
		);
		$this->add_control(
			'styler_like',
			[
				'label'     => esc_html__('Like Counter', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.zilla-likes-count'),
			]
		);
		$this->add_control(
			'styler_like_icon',
			[
				'label'     => esc_html__('Like Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.zilla-likes .kata-icon'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_social_share',
			[
				'label' => esc_html__('Social Share Counter', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_share_count' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_share_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-share-count'),
			]
		);
		$this->add_control(
			'styler_share',
			[
				'label'     => esc_html__('Counter', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-share-count span'),
			]
		);
		$this->add_control(
			'styler_share_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-share-count .kata-icon'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section_post_view',
			[
				'label' => esc_html__('Post View Counter', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_view' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_view_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-view'),
			]
		);
		$this->add_control(
			'styler_view',
			[
				'label'     => esc_html__('Counter', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-view span'),
			]
		);
		$this->add_control(
			'styler_view_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-post-view .kata-icon'),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render()
	{
		require dirname(__FILE__) . '/view.php';
	}
}
