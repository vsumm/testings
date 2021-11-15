<?php
/**
 * Author Page module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! class_exists( 'Kata_Plus_Pro_Author_Page' ) ) {
	class Kata_Plus_Pro_Author_Page extends Widget_Base {
		public function get_name() {
			return 'kata-plus-author-page';
		}

		public function get_title() {
			return esc_html__( 'Author Page', 'kata-plus' );
		}

		public function get_icon() {
			return 'kata-widget kata-eicon-call-to-action-page';
		}

		public function get_categories() {
			return [ 'kata_plus_elementor_blog_and_post' ];
		}

		public function get_style_depends() {
			return [ 'kata-plus-owl-carousel-css', 'kata-plus-owl', 'kata-plus-blog-posts' ];
		}

		public function get_script_depends() {
			return [ 'kata-plus-owl-carousel-js', 'kata-plus-owl' ];
		}

		protected function register_controls() {
			// Query
			$this->start_controls_section(
				'query_section',
				[
					'label' => esc_html__( 'Query', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'query_order_by',
				[
					'label'   => esc_html__( 'Order By', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'date',
					'options' => [
						'date'          => esc_html__( 'Date', 'kata-plus' ),
						'title'         => esc_html__( 'Title', 'kata-plus' ),
						'comment_count' => esc_html__( 'Comment Count', 'kata-plus' ),
						'menu_order'    => esc_html__( 'Menu Order', 'kata-plus' ),
						'rand'          => esc_html__( 'Random', 'kata-plus' ),
					],
				]
			);
			$this->add_control(
				'query_order',
				[
					'label'   => esc_html__( 'Order', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'DESC',
					'options' => [
						'DESC' => esc_html__( 'DESC', 'kata-plus' ),
						'ASC'  => esc_html__( 'ASC', 'kata-plus' ),
					],
				]
			);
			$this->end_controls_section();

			/**
			 * Settings
			 */
			$this->start_controls_section(
				'posts_section',
				[
					'label' => esc_html__( 'Settings', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_responsive_control(
				'post_columns',
				[
					'label'   => esc_html__( 'Columns Number', 'kata-plus' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '3',
					'options' => [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
					'condition' => [
						'enable_carousel!' => 'yes'
					]
				]
			);
			$this->add_control(
				'post_per_page',
				[
					'label'   => __( 'Posts Per Page', 'kata-plus' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'step'    => 1,
					'default' => 10,
				]
			);
			$this->add_control(
				'post_pagination',
				[
					'label'     => esc_html__( 'Pagination', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
					'condition' => [
						'enable_carousel!' => 'yes'
					]
				]
			);
			$this->add_control(
				'enable_carousel',
				[
					'label'     => __( 'Carousel', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'kata-plus' ),
					'label_off' => __( 'No', 'kata-plus' ),
					'default'   => '',
				]
			);
			$this->add_control(
				'first_post',
				[
					'label'			=> __( 'Distinct First Post', 'kata-plus' ),
					'type'			=> Controls_Manager::SWITCHER,
					'label_on'		=> __( 'Yes', 'kata-plus' ),
					'label_off'		=> __( 'No', 'kata-plus' ),
					'return_value'	=> 'yes',
					'default'		=> 'no',
				]
			);
			$this->end_controls_section();

			/**
			 * First Post Components
			 */
			$this->start_controls_section(
				'posts_metadata_section_first_post',
				[
					'label'		=> esc_html__( 'First Post Components', 'kata-plus' ),
					'tab'		=> Controls_Manager::TAB_CONTENT,
					'condition' => [
						'first_post'	=> 'yes',
					],
				]
			);
			$first_post = new Repeater();
			$first_post->add_control(
				'post_repeater_select_2',
				[
					'label'     => esc_html__( 'Component', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'title',
					'options'   => [
						'title'						=> esc_html__( 'Title', 'kata-plus' ),
						'thumbnail'					=> esc_html__( 'Thumbnail', 'kata-plus' ),
						'excerpt'					=> esc_html__( 'Excerpt', 'kata-plus' ),
						'post_format'				=> esc_html__( 'Post Format', 'kata-plus' ),
						'categories'				=> esc_html__( 'Categories', 'kata-plus' ),
						'tags'						=> esc_html__( 'Tags', 'kata-plus' ),
						'date'						=> esc_html__( 'Date', 'kata-plus' ),
						'comments'					=> esc_html__( 'Comments', 'kata-plus' ),
						'author'					=> esc_html__( 'Author', 'kata-plus' ),
						'time_to_read'				=> esc_html__( 'Time to read', 'kata-plus' ),
						'share_post'				=> esc_html__( 'Share Post', 'kata-plus' ),
						'share_post_counter'		=> esc_html__( 'Share Counter', 'kata-plus' ),
						'post_view'					=> esc_html__( 'View', 'kata-plus' ),
						'post_like'					=> esc_html__( 'Like', 'kata-plus' ),
						'read_more'					=> esc_html__( 'Read More', 'kata-plus' ),
						'start_content_wrapper'		=> esc_html__( 'Content div Open', 'kata-plus' ),
						'end_content_wrapper'		=> esc_html__( 'Content div Close', 'kata-plus' ),
						'start_meta_data_wrapper'	=> esc_html__( 'Metadata div Open', 'kata-plus' ),
						'end_meta_data_wrapper'		=> esc_html__( 'Metadata div Close', 'kata-plus' ),
					],
				]
			);
			$first_post->add_control(
				'posts_title_tag',
				[
					'label'     => esc_html__( 'post Title Tag', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default'   => 'h3',
					'condition' => [
						'post_repeater_select_2' => 'title',
					],
				]
			);
			$first_post->add_control(
				'thumbnail_size',
				[
					'label'     => esc_html__( 'Thumbnail Size', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'full',
					'options'   => [
						'full'   => esc_html__( 'Full', 'kata-plus' ),
						'custom' => esc_html__( 'Custom', 'kata-plus' ),
					],
					'condition' => [
						'post_repeater_select_2' => 'thumbnail',
					],
				]
			);
			$first_post->add_control(
				'posts_thumbnail_custom_size',
				[
					'label'       => __( 'post Thumbnail Custom Size', 'kata-plus' ),
					'description' => __( 'Crop the original image size to any custom size.', 'kata-plus' ),
					'type'        => Controls_Manager::IMAGE_DIMENSIONS,
					'default'     => [
						'width'  => '',
						'height' => '',
					],
					'condition'   => [
						'post_repeater_select_2' => 'thumbnail',
						'thumbnail_size' => 'custom',
					],
				]
			);
			$first_post->add_control(
				'excerpt_length',
				[
					'label'     => __( 'post Excerpt Length', 'kata-plus' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'' => [
							'min'  => 1,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'   => [
						'unit' => '',
						'size' => 25,
					],
					'condition' => [
						'post_repeater_select_2' => 'excerpt',
					],
				]
			);
			$first_post->add_control(
				'post_category_icon',
				[
					'label'     => esc_html__( 'Category Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'post_repeater_select_2' => 'categories',
					],
				]
			);
			$first_post->add_control(
				'post_comments_icon',
				[
					'label'     => esc_html__( 'Comments Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/comments',
					'condition' => [
						'post_repeater_select_2' => 'comments',
					],
				]
			);
			$first_post->add_control(
				'post_author_symbol',
				[
					'label'     => esc_html__( 'Author Symbol', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'icon',
					'options'   => [
						'icon'  => esc_html__( 'Icon', 'kata-plus' ),
						'avatar' => esc_html__( 'Avatar', 'kata-plus' ),
					],
					'condition' => [
						'post_repeater_select_2' => 'author',
					],
				]
			);
			$first_post->add_control(
				'post_author_icon',
				[
					'label'     => esc_html__( 'Author Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/user',
					'condition' => [
						'post_author_symbol'	=> 'icon',
						'post_repeater_select_2'	=> 'author',
					],
				]
			);
			$first_post->add_control(
				'avatar_size',
				[
					'label'		=> __( 'Avatar Size', 'kata-plus' ),
					'type'		=> Controls_Manager::NUMBER,
					'min'		=> 5,
					'max'		=> 300,
					'step'		=> 1,
					'default'	=> 20,
					'condition' => [
						'post_repeater_select_2'	=> 'author',
						'post_author_symbol'	=> 'avatar',
					],
				]
			);
			$first_post->add_control(
				'post_time_to_read_icon',
				[
					'label'     => esc_html__( 'Time To Read Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/time',
					'condition' => [
						'post_repeater_select_2' => 'time_to_read',
					],
				]
			);
			$first_post->add_control(
				'share_post_icon',
				[
					'label'     => esc_html__( 'Post Share Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/share',
					'condition' => [
						'post_repeater_select_2' => 'share_post',
					],
				]
			);
			$first_post->add_control(
				'post_share_post_counter_icon',
				[
					'label'     => esc_html__( 'Share Counter Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/action-redo',
					'condition' => [
						'post_repeater_select_2' => 'share_post_counter',
					],
				]
			);
			$first_post->add_control(
				'post_view_icon',
				[
					'label'     => esc_html__( 'Views Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/eye',
					'condition' => [
						'post_repeater_select_2' => 'post_view',
					],
				]
			);
			$first_post->add_control(
				'post_tag_icon',
				[
					'label'     => esc_html__( 'Tag Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/tag',
					'condition' => [
						'post_repeater_select_2' => 'tags',
					],
				]
			);
			$first_post->add_control(
				'post_format_gallery_icon',
				[
					'label'     => esc_html__( 'Gallery Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/gallery',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_format_link_icon',
				[
					'label'     => esc_html__( 'Link Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/link',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_format_image_icon',
				[
					'label'     => esc_html__( 'Image Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/image',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_format_quote_icon',
				[
					'label'     => esc_html__( 'Quote Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/quote-left',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_format_status_icon',
				[
					'label'     => esc_html__( 'Status Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/pencil',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_format_video_icon',
				[
					'label'     => esc_html__( 'Video Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/video-camera',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_format_aside_icon',
				[
					'label'     => esc_html__( 'Aside Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/plus',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_format_standard_icon',
				[
					'label'     => esc_html__( 'Standard Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/notepad',
					'condition' => [
						'post_repeater_select_2' => 'post_format',
					],
				]
			);
			$first_post->add_control(
				'post_date_icon',
				[
					'label'     => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'post_repeater_select_2' => 'date',
					],
				]
			);
			$first_post->add_control(
				'custom_date_format',
				[
					'label'     	=> esc_html__( 'Custom Date Format', 'kata-plus' ),
					'type'			=> Controls_Manager::SWITCHER,
					'label_on'		=> __( 'On', 'kata-plus' ),
					'label_off'		=> __( 'Off', 'kata-plus' ),
					'return_value'	=> 'yes',
					'condition' => [
						'post_repeater_select_2' => 'date',
					],
				]
			);
			$first_post->add_control(
				'date_format_1',
				[
					'label'		=> __( 'Date Format 1', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'm/', 'kata-plus' ),
					'condition' => [
						'custom_date_format' => 'yes'
					]
				]
			);
			$first_post->add_control(
				'date_format_2',
				[
					'label'		=> __( 'Date Format 2', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'd/', 'kata-plus' ),
					'condition' => [
						'custom_date_format' => 'yes'
					]
				]
			);
			$first_post->add_control(
				'date_format_3',
				[
					'label'		=> __( 'Date Format 3', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'Y', 'kata-plus' ),
					'condition' => [
						'custom_date_format' => 'yes'
					]
				]
			);
			$first_post->add_control(
				'terms_separator',
				[
					'label'			=> __( 'Separator', 'kata-plus' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> ',',
					'condition' => [
						'post_repeater_select_2' => [
							'categories',
							'tags'
						],
					],
				]
			);
			$first_post->add_control(
				'read_more_text',
				[
					'label'			=> __( 'Read More Text', 'kata-plus' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> 'Read More',
					'condition' => [
						'post_repeater_select_2' => 'read_more',
					],
				]
			);
			$this->add_control(
				'post_repeaters_2',
				[
					'label'       => __('Component Wrapper', 'kata-plus'),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $first_post->get_controls(),
					'title_field' => '{{{ post_repeater_select_2 }}}',
					'default'     => [
						['post_repeater_select_2' => 'thumbnail',],
						['post_repeater_select_2' => 'title',],
						['post_repeater_select_2' => 'excerpt',],
						['post_repeater_select_2' => 'categories',],
						['post_repeater_select_2' => 'tags',],
						['post_repeater_select_2' => 'date',],
					],
					'condition' => [
						'first_post'	=> 'yes',
					],
				]
			);
			$this->end_controls_section();

			/**
			 * Posts Components
			 */
			$this->start_controls_section(
				'posts_metadata_section',
				[
					'label'		=> esc_html__( 'Posts Components', 'kata-plus' ),
					'tab'		=> Controls_Manager::TAB_CONTENT,
				]
			);
			$posts = new Repeater();
			$posts->add_control(
				'post_repeater_select',
				[
					'label'     => esc_html__( 'Component', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'title',
					'options'   => [
						'title'						=> esc_html__( 'Title', 'kata-plus' ),
						'thumbnail'					=> esc_html__( 'Thumbnail', 'kata-plus' ),
						'excerpt'					=> esc_html__( 'Excerpt', 'kata-plus' ),
						'post_format'				=> esc_html__( 'Post Format', 'kata-plus' ),
						'categories'				=> esc_html__( 'Categories', 'kata-plus' ),
						'tags'						=> esc_html__( 'Tags', 'kata-plus' ),
						'date'						=> esc_html__( 'Date', 'kata-plus' ),
						'comments'					=> esc_html__( 'Comments', 'kata-plus' ),
						'author'					=> esc_html__( 'Author', 'kata-plus' ),
						'time_to_read'				=> esc_html__( 'Time to read', 'kata-plus' ),
						'share_post'				=> esc_html__( 'Share Post', 'kata-plus' ),
						'share_post_counter'		=> esc_html__( 'Share Counter', 'kata-plus' ),
						'post_view'					=> esc_html__( 'View', 'kata-plus' ),
						'post_like'					=> esc_html__( 'Like', 'kata-plus' ),
						'read_more'					=> esc_html__( 'Read More', 'kata-plus' ),
						'start_content_wrapper'		=> esc_html__( 'Content div Open', 'kata-plus' ),
						'end_content_wrapper'		=> esc_html__( 'Content div Close', 'kata-plus' ),
						'start_meta_data_wrapper'	=> esc_html__( 'Metadata div Open', 'kata-plus' ),
						'end_meta_data_wrapper'		=> esc_html__( 'Metadata div Close', 'kata-plus' ),
					],
				]
			);
			$posts->add_control(
				'posts_title_tag',
				[
					'label'     => esc_html__( 'Post Title Tag', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default'   => 'h3',
					'condition' => [
						'post_repeater_select' => 'title',
					],
				]
			);
			$posts->add_control(
				'title_animation',
				[
					'label'     => esc_html__( 'Animation Title', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'none'        => __( 'None', 'kata-plus' ),
						'kata-post-title-underline'   => __( 'Underline', 'kata-plus' ),
					],
					'default'   => 'none',
					'condition' => [
						'post_repeater_select' => 'title',
					],
				]
			);
			$posts->add_control(
				'thumbnail_size',
				[
					'label'     => esc_html__( 'Thumbnail Size', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'full',
					'options'   => [
						'full'   => esc_html__( 'Full', 'kata-plus' ),
						'custom' => esc_html__( 'Custom', 'kata-plus' ),
					],
					'condition' => [
						'post_repeater_select' => 'thumbnail',
					],
				]
			);
			$posts->add_control(
				'posts_thumbnail_custom_size',
				[
					'label'       => __( 'post Thumbnail Custom Size', 'kata-plus' ),
					'description' => __( 'Crop the original image size to any custom size.', 'kata-plus' ),
					'type'        => Controls_Manager::IMAGE_DIMENSIONS,
					'default'     => [
						'width'  => '',
						'height' => '',
					],
					'condition'   => [
						'post_repeater_select' => 'thumbnail',
						'thumbnail_size' => 'custom',
					],
				]
			);
			$posts->add_control(
				'excerpt_length',
				[
					'label'     => __( 'post Excerpt Length', 'kata-plus' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'' => [
							'min'  => 1,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'   => [
						'unit' => '',
						'size' => 25,
					],
					'condition' => [
						'post_repeater_select' => 'excerpt',
					],
				]
			);
			$posts->add_control(
				'post_category_icon',
				[
					'label'     => esc_html__( 'Category Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'post_repeater_select' => 'categories',
					],
				]
			);
			$posts->add_control(
				'post_comments_icon',
				[
					'label'     => esc_html__( 'Comments Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/comments',
					'condition' => [
						'post_repeater_select' => 'comments',
					],
				]
			);
			$posts->add_control(
				'post_author_symbol',
				[
					'label'     => esc_html__( 'Author Symbol', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'icon',
					'options'   => [
						'icon'  => esc_html__( 'Icon', 'kata-plus' ),
						'avatar' => esc_html__( 'Avatar', 'kata-plus' ),
					],
					'condition' => [
						'post_repeater_select' => 'author',
					],
				]
			);
			$posts->add_control(
				'post_author_icon',
				[
					'label'     => esc_html__( 'Author Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/user',
					'condition' => [
						'post_author_symbol'	=> 'icon',
						'post_repeater_select'	=> 'author',
					],
				]
			);
			$posts->add_control(
				'avatar_size',
				[
					'label'		=> __( 'Avatar Size', 'kata-plus' ),
					'type'		=> Controls_Manager::NUMBER,
					'min'		=> 5,
					'max'		=> 300,
					'step'		=> 1,
					'default'	=> 20,
					'condition' => [
						'post_repeater_select'	=> 'author',
						'post_author_symbol'	=> 'avatar',
					],
				]
			);
			$posts->add_control(
				'post_time_to_read_icon',
				[
					'label'     => esc_html__( 'Time To Read Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/time',
					'condition' => [
						'post_repeater_select' => 'time_to_read',
					],
				]
			);
			$posts->add_control(
				'share_post_icon',
				[
					'label'     => esc_html__( 'Post Share Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/share',
					'condition' => [
						'post_repeater_select' => 'share_post',
					],
				]
			);
			$posts->add_control(
				'post_share_post_counter_icon',
				[
					'label'     => esc_html__( 'Share Counter Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/action-redo',
					'condition' => [
						'post_repeater_select' => 'share_post_counter',
					],
				]
			);
			$posts->add_control(
				'post_view_icon',
				[
					'label'     => esc_html__( 'Views Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/eye',
					'condition' => [
						'post_repeater_select' => 'post_view',
					],
				]
			);
			$posts->add_control(
				'post_tag_icon',
				[
					'label'     => esc_html__( 'Tag Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/tag',
					'condition' => [
						'post_repeater_select' => 'tags',
					],
				]
			);
			$posts->add_control(
				'post_format_gallery_icon',
				[
					'label'     => esc_html__( 'Gallery Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/gallery',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_format_link_icon',
				[
					'label'     => esc_html__( 'Link Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/link',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_format_image_icon',
				[
					'label'     => esc_html__( 'Image Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/image',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_format_quote_icon',
				[
					'label'     => esc_html__( 'Quote Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/quote-left',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_format_status_icon',
				[
					'label'     => esc_html__( 'Status Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/pencil',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_format_video_icon',
				[
					'label'     => esc_html__( 'Video Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/video-camera',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_format_aside_icon',
				[
					'label'     => esc_html__( 'Aside Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/plus',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_format_standard_icon',
				[
					'label'     => esc_html__( 'Standard Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/notepad',
					'condition' => [
						'post_repeater_select' => 'post_format',
					],
				]
			);
			$posts->add_control(
				'post_date_icon',
				[
					'label'     => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'post_repeater_select' => 'date',
					],
				]
			);
			$posts->add_control(
				'custom_date_format',
				[
					'label'     	=> esc_html__( 'Custom Date Format', 'kata-plus' ),
					'type'			=> Controls_Manager::SWITCHER,
					'label_on'		=> __( 'On', 'kata-plus' ),
					'label_off'		=> __( 'Off', 'kata-plus' ),
					'return_value'	=> 'yes',
					'condition' => [
						'post_repeater_select' => 'date',
					],
				]
			);
			$posts->add_control(
				'date_format_1',
				[
					'label'		=> __( 'Date Format 1', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'm/', 'kata-plus' ),
					'condition' => [
						'custom_date_format' => 'yes'
					]
				]
			);
			$posts->add_control(
				'date_format_2',
				[
					'label'		=> __( 'Date Format 2', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'd/', 'kata-plus' ),
					'condition' => [
						'custom_date_format' => 'yes'
					]
				]
			);
			$posts->add_control(
				'date_format_3',
				[
					'label'		=> __( 'Date Format 3', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'Y', 'kata-plus' ),
					'condition' => [
						'custom_date_format' => 'yes'
					]
				]
			);
			$posts->add_control(
				'terms_separator',
				[
					'label'			=> __( 'Separator', 'kata-plus' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> ',',
					'condition' => [
						'post_repeater_select' => [
							'categories',
							'tags'
						],
					],
				]
			);
			$posts->add_control(
				'read_more_text',
				[
					'label'			=> __( 'Read More Text', 'kata-plus' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> 'Read More',
					'condition' => [
						'post_repeater_select' => 'read_more',
					],
				]
			);
			$this->add_control(
				'post_repeaters',
				[
					'label'       => __('Component Wrapper', 'kata-plus'),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $posts->get_controls(),
					'title_field' => '{{{ post_repeater_select }}}',
					'default'     => [
						['post_repeater_select' => 'thumbnail',],
						['post_repeater_select' => 'title',],
						['post_repeater_select' => 'excerpt',],
						['post_repeater_select' => 'categories',],
						['post_repeater_select' => 'tags',],
						['post_repeater_select' => 'date',],
					],
				]
			);
			$this->end_controls_section();

			/**
			 * Owl option
			 */
			$this->start_controls_section(
				'content_section',
				[
					'label'     => esc_html__( 'Carousel Settings', 'kata-plus' ),
					'condition' => [
						'enable_carousel' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'inc_owl_item',
				[
					'label'       => __( 'Items Per View', 'kata-plus' ),
					'type'        => Controls_Manager::NUMBER,
					'min'         => 1,
					'max'         => 12,
					'step'        => 1,
					'default'     => 3,
					'devices'     => [ 'desktop', 'tablet', 'mobile' ],
					'description' => __( 'Varies between 1/12', 'kata-plus' ),
				]
			);
			$this->add_control(
				'inc_owl_item_tab_landescape',
				[
					'label'       => __('Number of items between <br> Desktop and Tablet', 'kata-plus'),
					'type'        => Controls_Manager::NUMBER,
					'min'         => 1,
					'max'         => 12,
					'step'        => 1,
					'description' => __('Varies between 1/12', 'kata-plus'),
				]
			);
			$this->add_control(
				'inc_owl_spd',
				[
					'label'       => __( 'Slide Speed', 'kata-plus' ),
					'description' => __( 'Varies between 500/6000', 'kata-plus' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 500,
							'max'  => 6000,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 5000,
					],
				]
			);
			$this->add_control(
				'inc_owl_smspd',
				[
					'label'       => __( 'Smart Speed', 'kata-plus' ),
					'description' => __( 'Varies between 500/6000', 'kata-plus' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 500,
							'max'  => 6000,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 1000,
					],
				]
			);
			$this->add_responsive_control(
				'inc_owl_stgpad',
				[
					'label'       => __( 'Stage Padding', 'kata-plus' ),
					'description' => __( 'Varies between 0/400', 'kata-plus' ),
					'devices'     => [ 'desktop', 'tablet', 'mobile' ],
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 0,
					],
				]
			);
			$this->add_responsive_control(
				'inc_owl_margin',
				[
					'label'       => __( 'Margin', 'kata-plus' ),
					'description' => __( 'Varies between 0/400', 'kata-plus' ),
					'devices'     => [ 'desktop', 'tablet', 'mobile' ],
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [ 'px' ],
					'range'       => [
						'px' => [
							'min'  => 0,
							'max'  => 400,
							'step' => 1,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 20,
					],
				]
			);
			$this->add_control(
				'inc_owl_arrow',
				[
					'label'        => __( 'Prev/Next Arrows', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'kata-plus' ),
					'label_off'    => __( 'Hide', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'no',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_prev',
				[
					'label'     => __( 'Left Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'font-awesome/angle-left',
					'condition' => [
						'inc_owl_arrow' => [
							'true',
						],
					],
				]
			);
			$this->add_control(
				'inc_owl_nxt',
				[
					'label'     => __( 'Right Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'font-awesome/angle-right',
					'condition' => [
						'inc_owl_arrow' => [
							'true',
						],
					],
				]
			);
			$this->add_control(
				'inc_owl_pag',
				[
					'label'        => __( 'Pagination', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'kata-plus' ),
					'label_off'    => __( 'Hide', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'no',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_pag_num',
				[
					'label'     => __( 'Pagination Layout', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'dots'         => __( 'Bullets', 'kata-plus' ),
						'dots-num'     => __( 'Numbers', 'kata-plus' ),
						'dots-and-num' => __( 'Progress bar', 'kata-plus' ),
					],
					'default'   => 'dots',
					'condition' => [
						'inc_owl_pag' => [
							'true',
						],
					],
				]
			);
			$this->add_control(
				'inc_owl_loop',
				[
					'label'        => __( 'Slider loop', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'true',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_autoplay',
				[
					'label'        => __( 'Autoplay', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'true',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'inc_owl_center',
				[
					'label'        => __( 'Active Center Item', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				]
			);
			$this->add_control(
				'active_item',
				[
					'label'		=> __( 'Active Item', 'kata-plus' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'left',
					'options'	=> [
						'left'	 => __( 'Left', 'kata-plus' ),
						'right'	 => __( 'Right', 'kata-plus' ),
					],
					'condition' => [
						'inc_owl_center!' => 'yes',
					]
				]
			);
			$this->add_control(
				'inc_owl_rtl',
				[
					'label'        => __( 'RTL', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'inc_owl_vert',
				[
					'label'        => __( 'Vertical Slider', 'kata-plus' ),
					'description'  => __( 'This option works only when "Items Per View" is set to 1.', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'true',
					'default'      => 'false',
				]
			);
			$this->end_controls_section();

			// Posts Style section
			$this->start_controls_section(
				'section_widget_parent',
				[
					'label' => esc_html__( 'Wrapper', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_posts_container',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts' ),
				]
			);
			$this->add_control(
				'styler_widget_stage',
				[
					'label'            => esc_html__( 'Carousel Stage', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-stage-outer' ),
					'condition'        => [
						'enable_carousel' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'posts_style_section',
				[
					'label' => esc_html__( 'Posts', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_posts_post_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.ktbl-post-wrapper' ),
					'condition' => [
						'enable_carousel!' => 'yes'
					]
				]
			);
			$this->add_control(
				'styler_posts_post',
				[
					'label'            => esc_html__( 'Post', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_post_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_post_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail img', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'post_video_icon_styler',
				[
					'label'            => esc_html__( 'Video Play Button', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post-video-player', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-content', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_post_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-title', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_post_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-excerpt', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-readmore', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->end_controls_section();

			// Posts Pagination Style section
			$this->start_controls_section(
				'posts_pagination_style_section',
				[
					'label' => esc_html__( 'Pagination', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel!' => 'yes'
					]
				]
			);
			$this->add_control(
				'styler_posts_post_pagination_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .kata-post-pagination' ),
				]
			);
			$this->add_control(
				'styler_posts_post_pagination',
				[
					'label'            => esc_html__( 'Item', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .kata-post-pagination .page-numbers' ),
				]
			);
			$this->add_control(
				'styler_posts_post_pagination_current',
				[
					'label'            => esc_html__( 'Active Item', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .kata-post-pagination .current' ),
				]
			);
			$this->add_control(
				'styler_posts_post_pagination_prev_next',
				[
					'label'            => esc_html__( 'Prev & Next Button', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .kata-post-pagination a.next.page-numbers, .kata-blog-posts .kata-post-pagination a.prev.page-numbers' ),
				]
			);
			$this->end_controls_section();

			// Posts Metadata Style section
			$this->start_controls_section(
				'posts_metadata_style_section',
				[
					'label' => esc_html__( 'Metadata', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_posts_post_metadata_container',
				[
					'label'            => esc_html__( 'Metadata Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-metadata', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_format_wrapper',
				[
					'label'				=> esc_html__( 'Post Format Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-post-format', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_format_icon',
				[
					'label'            => esc_html__( 'Post Format Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-format .kata-icon', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_categories_wrapper',
				[
					'label'				=> esc_html__( 'Categories Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-category-links', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_posts_metadata_post_categories',
				[
					'label'            => esc_html__( 'Categories', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-category-links a', '', '.kata-blog-post:not(.kata-first-post)' ),
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
				'styler_posts_metadata_post_category_icon',
				[
					'label'            => esc_html__( 'Categories Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-category-links i', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_tags_wrapper',
				[
					'label'				=> esc_html__( 'Tags Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-tags-links', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_posts_metadata_post_tags',
				[
					'label'            => esc_html__( 'Tags', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-tags-links a', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_tags_icon',
				[
					'label'            => esc_html__( 'Tags Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-tags-links .kata-icon', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_wrapper',
				[
					'label'				=> esc_html__( 'Date Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-post-date', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date',
				[
					'label'            => esc_html__( 'Date', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-date a', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_1',
				[
					'label'            => esc_html__( 'Custom Date Format 1', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-date a .kt-date-format1', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_2',
				[
					'label'            => esc_html__( 'Custom Date Format 2', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-date a .kt-date-format2', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_3',
				[
					'label'            => esc_html__( 'Custom Date Format 3', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-date a .kt-date-format3', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_icon',
				[
					'label'            => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-date i', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_comments_wrapper',
				[
					'label'				=> esc_html__( 'Comments Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-comments-number', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_posts_metadata_post_comments',
				[
					'label'            => esc_html__( 'Comments', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-comments-number span', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_comments_icon',
				[
					'label'            => esc_html__( 'Comments Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-comments-number i', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author_wrapper',
				[
					'label'				=> esc_html__( 'Author Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-post-author', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author',
				[
					'label'            => esc_html__( 'Author', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-author a', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author_icon',
				[
					'label'            => esc_html__( 'Author Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-author i', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author_avatar',
				[
					'label'            => esc_html__( 'Author Avatar', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-author img.avatar', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_time_to_read_wrapper',
				[
					'label'				=> esc_html__( 'Time To Read Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-time-to-read', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_time_to_read',
				[
					'label'            => esc_html__( 'Time To Read', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-time-to-read span', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_time_to_read_icon',
				[
					'label'            => esc_html__( 'Time To Read Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-time-to-read i', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_social_share_count_wrapper',
				[
					'label'				=> esc_html__( 'Social Share Counter Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-post-share-count', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_social_share_count',
				[
					'label'            => esc_html__( 'Social Share Counter', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-share-count span', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_social_share_count_icon',
				[
					'label'            => esc_html__( 'Social Share Counter Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-share-count i', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_share_post_wrapper',
				[
					'label'            => esc_html__( 'Share Post Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kt-post-socials-share-wrapper', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_posts_metadata_share_post_socials_wrapper',
				[
					'label'            => esc_html__( 'Share Post Socials Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kt-post-share-toggle-socials-wrapper', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_share_post_socials_link',
				[
					'label'            => esc_html__( 'Share Post Socials link', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kt-post-share-toggle-socials-wrapper a', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_share_post_socials_link_icon',
				[
					'label'            => esc_html__( 'Share Post Socials Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kt-post-share-toggle-socials-wrapper a svg', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_share_post_socials_icon',
				[
					'label'            => esc_html__( 'Share Post Toggle Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kt-post-share-toggle-wrapper .kata-icon', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_post_view_wrapper',
				[
					'label'				=> esc_html__( 'Post View Wrapper', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-post-view', '', '.kata-blog-post:not(.kata-first-post)' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_post_view',
				[
					'label'            => esc_html__( 'Post View', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-view span', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_post_view_icon',
				[
					'label'            => esc_html__( 'Post View Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-view i', '', '.kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->end_controls_section();

			// First Post Style section
			$this->start_controls_section(
				'first_post_style_section',
				[
					'label' => esc_html__( 'First Post', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'first_post'	=> 'yes',
					],
				]
			);
			$this->add_control(
				'styler_first_post_post',
				[
					'label'            => esc_html__( 'Post', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post' ),
				]
			);
			$this->add_control(
				'styler_first_post_post_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail', '', '.kata-first-post' ),
				]
			);
			$this->add_control(
				'styler_first_post_post_thumbnail_image',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail img', '', '.kata-first-post' ),
				]
			);
			$this->add_control(
				'styler_first_post_video_icon_styler',
				[
					'label'            => esc_html__( 'Video Play Button', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post-video-player', '', '.kata-first-post' ),
				]
			);
			$this->add_control(
				'styler_first_post_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-content', '', '.kata-first-post' ),
				]
			);
			$this->add_control(
				'styler_first_post_post_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-title', '', '.kata-first-post'  ),
				]
			);
			$this->add_control(
				'styler_first_post_post_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-excerpt', '', '.kata-first-post' ),
				]
			);
			$this->add_control(
				'styler_first_post_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-readmore', '', '.kata-first-post' ),
				]
			);
			$this->end_controls_section();

			// Posts Metadata Style section
			$this->start_controls_section(
				'first_post_metadata_style_section',
				[
					'label'		=> esc_html__( 'First Post Metadata', 'kata-plus' ),
					'tab'		=> Controls_Manager::TAB_STYLE,
					'condition'	=> [
						'first_post' => 'yes',
					],
				]
			);
			$this->add_control(
				'styler_first_posts_post_metadata_container',
				[
					'label'            => esc_html__( 'Metadata Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-metadata', '', '.kata-blog-post.kata-first-post' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_format_wrapper',
				[
					'label'            => esc_html__( 'Post Format Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-format', '', '.kata-blog-post.kata-first-post' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_format_icon',
				[
					'label'            => esc_html__( 'Post Format Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-format .kata-icon', '', '.kata-blog-post.kata-first-post' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_categories_wrapper',
				[
					'label'            => esc_html__( 'Categories Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-category-links' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_categories',
				[
					'label'            => esc_html__( 'Categories', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-category-links a' ),
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
				'styler_first_post_metadata_post_category_icon',
				[
					'label'            => esc_html__( 'Categories Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-category-links i' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_tags_wrapper',
				[
					'label'            => esc_html__( 'Tags Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-tags-links' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_tags',
				[
					'label'            => esc_html__( 'Tags', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-tags-links a' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_date_wrapper',
				[
					'label'            => esc_html__( 'Date Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-date' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_date',
				[
					'label'            => esc_html__( 'Date', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-date a' ),
				]
			);
			$this->add_control(
				'styler_first_posts_metadata_post_date_1',
				[
					'label'            => esc_html__( 'Custom Date Format 1', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-date a .kt-date-format1' ),
				]
			);
			$this->add_control(
				'styler_first_posts_metadata_post_date_2',
				[
					'label'            => esc_html__( 'Custom Date Format 2', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-date a .kt-date-format2' ),
				]
			);
			$this->add_control(
				'styler_first_posts_metadata_post_date_3',
				[
					'label'            => esc_html__( 'Custom Date Format 3', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-date a .kt-date-format3' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_date_icon',
				[
					'label'            => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-date i' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_comments_wrapper',
				[
					'label'            => esc_html__( 'Comments Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-comments-number' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_comments',
				[
					'label'            => esc_html__( 'Comments', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-comments-number span' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_comments_icon',
				[
					'label'            => esc_html__( 'Comments Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-comments-number i' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_author_wrapper',
				[
					'label'            => esc_html__( 'Author Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-author' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_author',
				[
					'label'            => esc_html__( 'Author', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-author a' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_author_icon',
				[
					'label'            => esc_html__( 'Author Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-author i' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_author_avatar',
				[
					'label'            => esc_html__( 'Author Avatar', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-author img.avatar' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_time_to_read_wrapper',
				[
					'label'            => esc_html__( 'Time To Read Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post .kata-time-to-read' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_time_to_read',
				[
					'label'            => esc_html__( 'Time To Read', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post .kata-time-to-read span' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_time_to_read_icon',
				[
					'label'            => esc_html__( 'Time To Read Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post .kata-time-to-read i' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_social_share_count_wrapper',
				[
					'label'            => esc_html__( 'Social Share Counter Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-share-count' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_social_share_count',
				[
					'label'            => esc_html__( 'Social Share Counter', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-share-count span' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_social_share_count_icon',
				[
					'label'            => esc_html__( 'Social Share Counter Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-share-count i' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_share_post_wrapper',
				[
					'label'            => esc_html__( 'Share Post Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kt-post-socials-share-wrapper' ),
					'separator'			=> 'before'
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_share_post_socials_wrapper',
				[
					'label'            => esc_html__( 'Share Post Socials Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kt-post-share-toggle-socials-wrapper' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_share_post_socials_link',
				[
					'label'            => esc_html__( 'Share Post Socials link', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kt-post-share-toggle-socials-wrapper a' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_share_post_socials_link_icon',
				[
					'label'            => esc_html__( 'Share Post Socials Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kt-post-share-toggle-socials-wrapper a svg' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_share_post_socials_icon',
				[
					'label'            => esc_html__( 'Share Post Toggle Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kt-post-share-toggle-wrapper .kata-icon' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_post_view_wrapper',
				[
					'label'            => esc_html__( 'Post View Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-view' ),
					'separator'			=> 'before'

				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_post_view',
				[
					'label'            => esc_html__( 'Post View', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-view span' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_post_view_icon',
				[
					'label'            => esc_html__( 'Post View Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-view i' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'styler_carousel_settings_section',
				[
					'label'     => esc_html__( 'Carousel', 'kata-plus' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel' => 'yes',
					],
				]
			);
			$this->add_control(
				'styler_item',
				[
					'label'            => __( 'Item', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-item .kata-blog-post' ),
				]
			);
			$this->add_control(
				'styler_arrow_wrapper',
				[
					'label'            => __( 'Slider Arrows Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-nav' ),
				]
			);
			$this->add_control(
				'styler_arrow_left',
				[
					'label'            => __( 'Slider Left Arrow', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-nav .owl-prev i' ),
				]
			);
			$this->add_control(
				'styler_arrow_right',
				[
					'label'            => __( 'Slider Right Arrow', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-nav .owl-next i' ),
				]
			);
			$this->add_control(
				'styler_boolets',
				[
					'label'            => __( 'Bullets Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-dots' ),
				]
			);
			$this->add_control(
				'styler_boolet',
				[
					'label'            => __( 'Bullets', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-dots .owl-dot' ),
				]
			);
			$this->add_control(
				'styler_boolet_active',
				[
					'label'            => __( 'Active Bullet', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-dots .owl-dot.active' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'carousel_active_item_section',
				[
					'label' => esc_html__( 'Carousel Active Item', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel' => 'yes',
						'inc_owl_center!' => 'yes',
					],
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post',
				[
					'label'            => esc_html__( 'Post', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.kata-owl-active-item .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail', '', '.owl-item.kata-owl-active-item .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail img', '', '.owl-item.kata-owl-active-item .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-content', '', '.owl-item.kata-owl-active-item .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-title', '', '.owl-item.kata-owl-active-item .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-excerpt', '', '.owl-item.kata-owl-active-item .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-readmore', '', '.owl-item.kata-owl-active-item .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'carousel_center_item_section',
				[
					'label' => esc_html__( 'Active Center Item', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel'	=> 'yes',
						'inc_owl_center'	=> 'yes',
					],
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post',
				[
					'label'            => esc_html__( 'Post', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail', '', '.owl-item.center .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-thumbnail img', '', '.owl-item.center .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-content', '', '.owl-item.center .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-title', '', '.owl-item.center .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-excerpt', '', '.owl-item.center .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-post-readmore', '', '.owl-item.center .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'section_style_progress_bar',
				[
					'label'     => esc_html__( 'Progress Bar', 'kata-plus' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'enable_carousel' => 'yes',
						'inc_owl_pag_num' => 'dots-and-num',
					],
				]
			);
			$this->add_control(
				'styler_progress_wraper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar' ),
				]
			);
			$this->add_control(
				'styler_progress',
				[
					'label'            => esc_html__( 'Progress Bar', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar .kata-progress-bar-inner' ),
				]
			);
			$this->add_control(
				'styler_progress_min_number',
				[
					'label'            => esc_html__( 'Start Number', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar .minitems' ),
				]
			);
			$this->add_control(
				'styler_progress_max_number',
				[
					'label'            => esc_html__( 'End Number', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-owl-progress-bar .maxitems' ),
				]
			);
			$this->end_controls_section();

			// Common controls
			apply_filters( 'kata_plus_common_controls', $this );
			// end copy
		}

		protected function render() {
			require dirname( __FILE__ ) . '/view.php';
		}
	} // class
}
