<?php
/**
 * Recent Posts module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! class_exists( 'Kata_Plus_Recent_Posts' ) ) {
	class Kata_Plus_Recent_Posts extends Widget_Base {
		public function get_name() {
			return 'kata-plus-blog-posts';
		}

		public function get_title() {
			return esc_html__( 'Recent Posts', 'kata-plus' );
		}

		public function get_icon() {
			return 'kata-widget kata-eicon-recent-posts';
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
			$cat_options = [];
			foreach ( get_categories() as $category ) {
				$cat_options[ $category->slug ] = $category->name;
			}
			$this->add_control(
				'query_categories',
				[
					'label'    => __( 'Categories', 'kata-plus' ),
					'type'     => Controls_Manager::SELECT2,
					'options'  => $cat_options,
					'default'  => [],
					'multiple' => true,
				]
			);
			$tag_options = [];
			foreach ( get_tags() as $tag ) {
				$tag_options[ $tag->slug ] = $tag->name;
			}
			$this->add_control(
				'query_tags',
				[
					'label'    => __( 'Tags', 'kata-plus' ),
					'type'     => Controls_Manager::SELECT2,
					'options'  => $tag_options,
					'default'  => [],
					'multiple' => true,
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

			// Posts section
			$this->start_controls_section(
				'posts_section',
				[
					'label' => esc_html__( 'Posts', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_responsive_control(
				'posts_columns',
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
				]
			);
			$this->add_control(
				'posts_per_page',
				[
					'label'   => __( 'Posts Per Page', 'kata-plus' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'step'    => 1,
					'default' => 10,
				]
			);
			$this->add_control(
				'posts_thumbnail',
				[
					'label'     => esc_html__( 'Post Thumbnail', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'posts_thumbnail_position',
				[
					'label'     => esc_html__( 'Post Thumbnail Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title' => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'  => esc_html__( 'After Title', 'kata-plus' ),
					],
					'condition' => [
						'posts_thumbnail' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_thumbnail_layout_position',
				[
					'label'     => esc_html__( 'Post Thumbnail Layout Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'top',
					'options'   => [
						'top'  => esc_html__( 'Top', 'kata-plus' ),
						'left' => esc_html__( 'Left', 'kata-plus' ),
						'right' => esc_html__( 'Right', 'kata-plus' ),
					],
					'condition' => [
						'posts_thumbnail'          => 'yes',
						'posts_thumbnail_position' => 'before-title',
					],
				]
			);
			$this->add_control(
				'posts_thumbnail_size',
				[
					'label'     => esc_html__( 'Post Thumbnail Size', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'full',
					'options'   => [
						'full'   => esc_html__( 'Full', 'kata-plus' ),
						'custom' => esc_html__( 'Custom', 'kata-plus' ),
					],
					'condition' => [
						'posts_thumbnail' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_thumbnail_custom_size',
				[
					'label'       => __( 'Post Thumbnail Custom Size', 'kata-plus' ),
					'description' => __( 'Crop the original image size to any custom size.', 'kata-plus' ),
					'type'        => Controls_Manager::IMAGE_DIMENSIONS,
					'default'     => [
						'width'  => '',
						'height' => '',
					],
					'condition'   => [
						'posts_thumbnail'      => 'yes',
						'posts_thumbnail_size' => 'custom',
					],
				]
			);
			$this->add_control(
				'posts_title',
				[
					'label'     => esc_html__( 'Post Title', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
				]
			);
			$this->add_control(
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
						'posts_title' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_excerpt',
				[
					'label'     => __( 'Post Excerpt', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Show', 'kata-plus' ),
					'label_off' => __( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'posts_excerpt_length',
				[
					'label'     => __( 'Post Excerpt Length', 'kata-plus' ),
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
						'posts_excerpt' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_read_more',
				[
					'label'     => esc_html__( 'Read More', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'posts_read_more_text',
				[
					'label'     => esc_html__( 'Read More Text', 'kata-plus' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'Read More', 'kata-plus' ),
					'condition' => [
						'posts_read_more' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_pagination',
				[
					'label'     => esc_html__( 'Pagination', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
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
			$this->end_controls_section();

			// Posts Metadata section
			$this->start_controls_section(
				'posts_metadata_section',
				[
					'label' => esc_html__( 'Posts Metadata', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'post_format',
				[
					'label'     => esc_html__( 'Post Format', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'separator' => 'before',
				]
			);
			$this->add_control(
				'post_format_position',
				[
					'label'     => esc_html__( 'Post Format Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'post_format' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_categories',
				[
					'label'     => esc_html__( 'Categories', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
				]
			);
			$this->add_control(
				'posts_category_icon',
				[
					'label'     => esc_html__( 'Category Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'posts_categories' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_categories_position',
				[
					'label'     => esc_html__( 'Categories Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'posts_categories' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_tags',
				[
					'label'     => esc_html__( 'Tags', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'posts_tags_position',
				[
					'label'     => esc_html__( 'Tags Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'posts_tags' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_date',
				[
					'label'     => esc_html__( 'Post Date', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'custom_date_format',
				[
					'label'     	=> esc_html__( 'Custom Date Format', 'kata-plus' ),
					'type'			=> Controls_Manager::SWITCHER,
					'label_on'		=> __( 'On', 'kata-plus' ),
					'label_off'		=> __( 'Off', 'kata-plus' ),
					'return_value'	=> 'yes',
					'condition' => [
						'posts_date' => 'yes'
					]
				]
			);
			$this->add_control(
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
			$this->add_control(
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
			$this->add_control(
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
			$this->add_control(
				'posts_date_icon',
				[
					'label'     => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'posts_date' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_date_position',
				[
					'label'     => esc_html__( 'Date Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'posts_date' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_comments',
				[
					'label'     => esc_html__( 'Post Comments', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'posts_comments_icon',
				[
					'label'     => esc_html__( 'Comments Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/comments',
					'condition' => [
						'posts_comments' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_comments_position',
				[
					'label'     => esc_html__( 'Comments Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'posts_comments' => 'yes',
					],
				]
			);
			$this->add_control(
				'posts_author',
				[
					'label'     => esc_html__( 'Post Author', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
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
						'posts_author' => 'yes',
					],
				]
			);
			$this->add_control(
				'avatar_size',
				[
					'label'		=> __( 'Avatar Size', 'kata-plus' ),
					'type'		=> Controls_Manager::NUMBER,
					'min'		=> 5,
					'max'		=> 300,
					'step'		=> 1,
					'default'	=> 20,
					'condition' => [
						'post_author_symbol' => 'avatar',
					],
				]
			);
			$this->add_control(
				'posts_author_icon',
				[
					'label'     => esc_html__( 'Author Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/user',
					'condition' => [
						'posts_author'			=> 'yes',
						'post_author_symbol'	=> 'icon',
					],
				]
			);
			$this->add_control(
				'posts_author_position',
				[
					'label'     => esc_html__( 'Author Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'posts_author' => 'yes',
					],
				]
			);
			$this->add_control(
				'post_time_to_read',
				[
					'label'     => esc_html__( 'Post\'s time to read:', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'post_time_to_read_icon',
				[
					'label'     => esc_html__( 'Post\'s time to read Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/time',
					'condition' => [
						'post_time_to_read' => 'yes',
					],
				]
			);
			$this->add_control(
				'post_time_to_read_position',
				[
					'label'     => esc_html__( 'Post\'s time to read Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'post_time_to_read' => 'yes',
					],
				]
			);
			$this->add_control(
				'post_share_count',
				[
					'label'     => esc_html__( 'Social Share Counter:', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'post_share_count_icon',
				[
					'label'     => esc_html__( 'Social Share Counter Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/action-redo',
					'condition' => [
						'post_share_count' => 'yes',
					],
				]
			);
			$this->add_control(
				'post_share_count_position',
				[
					'label'     => esc_html__( 'Social Share Counter Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'post_share_count' => 'yes',
					],
				]
			);
			$this->add_control(
				'post_view',
				[
					'label'     => esc_html__( 'Post View:', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'post_view_icon',
				[
					'label'     => esc_html__( 'Post View Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/eye',
					'condition' => [
						'post_view' => 'yes',
					],
				]
			);
			$this->add_control(
				'post_view_position',
				[
					'label'     => esc_html__( 'Post View Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'post_view' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			// First Post section
			$this->start_controls_section(
				'first_post_section',
				[
					'label' => esc_html__( 'First Post', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'first_post',
				[
					'label'     => esc_html__( 'Mark First Post as Featured', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'kata-plus' ),
					'label_off' => esc_html__( 'No', 'kata-plus' ),
					'default'   => '',
				]
			);
			$this->add_control(
				'first_post_thumbnail',
				[
					'label'     => esc_html__( 'Post Thumbnail', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
					'condition' => [
						'first_post' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_thumbnail_layout_position',
				[
					'label'     => esc_html__( 'Post Thumbnail Layout Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'top',
					'options'   => [
						'top'  => esc_html__( 'Top', 'kata-plus' ),
						'left' => esc_html__( 'Left', 'kata-plus' ),
					],
					'condition' => [
						'first_post'                    => 'yes',
						'first_post_thumbnail'          => 'yes',
						'first_post_thumbnail_position' => 'before-title',
					],
				]
			);
			$this->add_control(
				'first_post_thumbnail_position',
				[
					'label'     => esc_html__( 'Post Thumbnail Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title' => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'  => esc_html__( 'After Title', 'kata-plus' ),
					],
					'condition' => [
						'first_post'           => 'yes',
						'first_post_thumbnail' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_thumbnail_size',
				[
					'label'     => esc_html__( 'Post Thumbnail Size', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'full',
					'options'   => [
						'full'   => esc_html__( 'Full', 'kata-plus' ),
						'custom' => esc_html__( 'Custom', 'kata-plus' ),
					],
					'condition' => [
						'first_post'           => 'yes',
						'first_post_thumbnail' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_thumbnail_custom_size',
				[
					'label'       => __( 'Post Thumbnail Custom Size', 'kata-plus' ),
					'description' => __( 'Crop the original image size to any custom size.', 'kata-plus' ),
					'type'        => Controls_Manager::IMAGE_DIMENSIONS,
					'default'     => [
						'width'  => '',
						'height' => '',
					],
					'condition'   => [
						'first_post'                => 'yes',
						'first_post_thumbnail'      => 'yes',
						'first_post_thumbnail_size' => 'custom',
					],
				]
			);
			$this->add_control(
				'first_post_title',
				[
					'label'     => esc_html__( 'Title', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
					'condition' => [
						'first_post' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_title_tag',
				[
					'label'     => esc_html__( 'Title Tag', 'kata-plus' ),
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
						'first_post'       => 'yes',
						'first_post_title' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_excerpt',
				[
					'label'     => __( 'Excerpt', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Show', 'kata-plus' ),
					'label_off' => __( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
					'condition' => [
						'first_post' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_excerpt_length',
				[
					'label'     => __( 'Excerpt Length', 'kata-plus' ),
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
						'first_post'         => 'yes',
						'first_post_excerpt' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_read_more',
				[
					'label'     => esc_html__( 'Read More', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
					'condition' => [
						'first_post' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_read_more_text',
				[
					'label'     => esc_html__( 'Read More Text', 'kata-plus' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'Read More', 'kata-plus' ),
					'condition' => [
						'first_post'           => 'yes',
						'first_post_read_more' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			// First Post Metadata section
			$this->start_controls_section(
				'first_post_metadata_section',
				[
					'label' => esc_html__( 'First Post Metadata', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
					'condition' => [
						'first_post' => 'yes'
					]
				]
			);
			$this->add_control(
				'first_post_post_format',
				[
					'label'     => esc_html__( 'Post Format', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_post_format_position',
				[
					'label'     => esc_html__( 'Post Format Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_post_format' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_categories',
				[
					'label'     => esc_html__( 'Categories', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_category_icon',
				[
					'label'     => esc_html__( 'Category Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'first_post_categories' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_categories_position',
				[
					'label'     => esc_html__( 'Categories Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_categories' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_tags',
				[
					'label'     => esc_html__( 'Tags', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_tags_position',
				[
					'label'     => esc_html__( 'Tags Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_tags' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_date',
				[
					'label'     => esc_html__( 'Post Date', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => 'yes',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_custom_date_format',
				[
					'label'     	=> esc_html__( 'Custom Date Format', 'kata-plus' ),
					'type'			=> Controls_Manager::SWITCHER,
					'label_on'		=> __( 'On', 'kata-plus' ),
					'label_off'		=> __( 'Off', 'kata-plus' ),
					'return_value'	=> 'yes',
					'condition' => [
						'first_post_date' => 'yes'
					]
				]
			);
			$this->add_control(
				'first_post_date_format_1',
				[
					'label'		=> __( 'Date Format 1', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'm/', 'kata-plus' ),
					'condition' => [
						'first_post_custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'first_post_date_format_2',
				[
					'label'		=> __( 'Date Format 2', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'd/', 'kata-plus' ),
					'condition' => [
						'first_post_custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'first_post_date_format_3',
				[
					'label'		=> __( 'Date Format 3', 'kata-plus' ),
					'type'		=> Controls_Manager::TEXT,
					'default'	=> __( 'Y', 'kata-plus' ),
					'condition' => [
						'first_post_custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'first_post_date_icon',
				[
					'label'     => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'first_post_date' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_date_position',
				[
					'label'     => esc_html__( 'Date Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_date' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_comments',
				[
					'label'     => esc_html__( 'Post Comments', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_comments_icon',
				[
					'label'     => esc_html__( 'Comments Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/comments',
					'condition' => [
						'first_post_comments' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_comments_position',
				[
					'label'     => esc_html__( 'Comments Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_comments' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_author',
				[
					'label'     => esc_html__( 'Post Author', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_author_symbol',
				[
					'label'     => esc_html__( 'Author Symbol', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'icon',
					'options'   => [
						'icon'  => esc_html__( 'Icon', 'kata-plus' ),
						'avatar' => esc_html__( 'Avatar', 'kata-plus' ),
					],
					'condition' => [
						'first_post_author' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_avatar_size',
				[
					'label'		=> __( 'Avatar Size', 'kata-plus' ),
					'type'		=> Controls_Manager::NUMBER,
					'min'		=> 5,
					'max'		=> 300,
					'step'		=> 1,
					'default'	=> 20,
					'condition' => [
						'first_post_author_symbol' => 'avatar',
					],
				]
			);
			$this->add_control(
				'first_post_author_icon',
				[
					'label'     => esc_html__( 'Author Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/user',
					'condition' => [
						'first_post_author'			=> 'yes',
						'first_post_author_symbol'	=> 'icon',
					],
				]
			);
			$this->add_control(
				'first_post_author_position',
				[
					'label'     => esc_html__( 'Author Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_author' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_time_to_read',
				[
					'label'     => esc_html__( 'Post\'s time to read:', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_time_to_read_icon',
				[
					'label'     => esc_html__( 'Post\'s time to read Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/time',
					'condition' => [
						'first_post_time_to_read' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_time_to_read_position',
				[
					'label'     => esc_html__( 'Post\'s time to read Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_time_to_read' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_share_count',
				[
					'label'     => esc_html__( 'Social Share Counter:', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_share_count_icon',
				[
					'label'     => esc_html__( 'Social Share Counter Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/action-redo',
					'condition' => [
						'first_post_share_count' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_share_count_position',
				[
					'label'     => esc_html__( 'Social Share Counter Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_share_count' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_view',
				[
					'label'     => esc_html__( 'Post View:', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Show', 'kata-plus' ),
					'label_off' => esc_html__( 'Hide', 'kata-plus' ),
					'default'   => '',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'first_post_view_icon',
				[
					'label'     => esc_html__( 'Post View Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'simple-line/eye',
					'condition' => [
						'first_post_view' => 'yes',
					],
				]
			);
			$this->add_control(
				'first_post_view_position',
				[
					'label'     => esc_html__( 'Post View Position', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'before-title',
					'options'   => [
						'before-title'  => esc_html__( 'Before Title', 'kata-plus' ),
						'after-title'   => esc_html__( 'After Title', 'kata-plus' ),
						'after-excerpt' => esc_html__( 'After Excerpt', 'kata-plus' ),
					],
					'condition' => [
						'first_post_view' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			// owl option
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
					'label'       => __( 'Item', 'kata-plus' ),
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
					'label'        => __( 'Center Item', 'kata-plus' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'kata-plus' ),
					'label_off'    => __( 'No', 'kata-plus' ),
					'return_value' => 'no',
					'default'      => 'no',
					'devices'      => [ 'desktop', 'tablet', 'mobile' ],
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
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-thumbnail' ),
				]
			);
			$this->add_control(
				'styler_posts_post_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-thumbnail img' ),
				]
			);
			$this->add_control(
				'styler_posts_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-content' ),
				]
			);
			$this->add_control(
				'styler_posts_post_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.kata-post-title', '', '.kata-blog-post:not(.kata-first-post)'),
				]
			);
			$this->add_control(
				'styler_posts_post_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-excerpt' ),
				]
			);
			$this->add_control(
				'styler_posts_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-readmore' ),
				]
			);
			$this->end_controls_section();

			// Posts Pagination Style section
			$this->start_controls_section(
				'posts_pagination_style_section',
				[
					'label' => esc_html__( 'Pagination', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
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
					'label'            => esc_html__( 'Pagination', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .kata-post-pagination .page-numbers' ),
				]
			);
			$this->add_control(
				'styler_posts_post_pagination_current',
				[
					'label'            => esc_html__( 'Pagination Current', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .kata-post-pagination .current' ),
				]
			);
			$this->add_control(
				'styler_posts_post_pagination_prev_next',
				[
					'label'            => esc_html__( 'Pagination Previous/Next', 'kata-plus' ),
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
					'label'            => esc_html__( 'Metadata Wrapper (Before Title)', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-metadata.before-title' ),
				]
			);
			$this->add_control(
				'styler_posts_post_metadata_container_after_title',
				[
					'label'            => esc_html__( 'Metadata Wrapper (After Title)', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-metadata.after-title' ),
				]
			);
			$this->add_control(
				'styler_posts_post_metadata_container_after_excerpt',
				[
					'label'            => esc_html__( 'Metadata Wrapper (After Excerpt)', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-metadata.after-excerpt' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_format_wrapper',
				[
					'label'            => esc_html__( 'Post Format Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-format' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_format_icon',
				[
					'label'            => esc_html__( 'Post Format Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-format .kata-icon' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_categories_wrapper',
				[
					'label'            => esc_html__( 'Categories Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-category-links' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_categories',
				[
					'label'            => esc_html__( 'Categories', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-category-links a' ),
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
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-category-links i' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_tags_wrapper',
				[
					'label'            => esc_html__( 'Tags Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-tags-links' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_tags',
				[
					'label'            => esc_html__( 'Tags', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-tags-links a' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_wrapper',
				[
					'label'            => esc_html__( 'Date Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-date' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date',
				[
					'label'            => esc_html__( 'Date', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-date a' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_1',
				[
					'label'				=> esc_html__( 'Custom Date Format 1', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-date a .kt-date-format1' ),
					'condition'			=> [
						'custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_2',
				[
					'label'				=> esc_html__( 'Custom Date Format 2', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-date a .kt-date-format2' ),
					'condition'			=> [
						'custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_3',
				[
					'label'				=> esc_html__( 'Custom Date Format 3', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-date a .kt-date-format3' ),
					'condition'			=> [
						'custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_date_icon',
				[
					'label'            => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-date i' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_comments_wrapper',
				[
					'label'            => esc_html__( 'Comments Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-comments-number' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_comments',
				[
					'label'            => esc_html__( 'Comments', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-comments-number span' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_comments_icon',
				[
					'label'            => esc_html__( 'Comments Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-comments-number i' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author_wrapper',
				[
					'label'            => esc_html__( 'Author Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-author' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author',
				[
					'label'            => esc_html__( 'Author', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-author a' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author_icon',
				[
					'label'            => esc_html__( 'Author Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-author i' ),
					'condition' => [
						'post_author_symbol' => 'icon',
					],
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_author_avatar',
				[
					'label'            => esc_html__( 'Author Avatar', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-author .avatar' ),
					'condition' => [
						'post_author_symbol' => 'avatar',
					],
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_time_to_read_wrapper',
				[
					'label'            => esc_html__( 'Time To Read Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-time-to-read' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_time_to_read',
				[
					'label'            => esc_html__( 'Time To Read', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-time-to-read span' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_time_to_read_icon',
				[
					'label'            => esc_html__( 'Time To Read Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-time-to-read i' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_social_share_count_wrapper',
				[
					'label'            => esc_html__( 'Social Share Counter Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-share-count' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_social_share_count',
				[
					'label'            => esc_html__( 'Social Share Counter', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-share-count span' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_social_share_count_icon',
				[
					'label'            => esc_html__( 'Social Share Counter Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-share-count i' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_post_view_wrapper',
				[
					'label'            => esc_html__( 'Post View Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-view' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_post_view',
				[
					'label'            => esc_html__( 'Post View', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-view span' ),
				]
			);
			$this->add_control(
				'styler_posts_metadata_post_post_view_icon',
				[
					'label'            => esc_html__( 'Post View Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post:not(.kata-first-post) .kata-post-view i' ),
				]
			);
			$this->end_controls_section();

			// First Post Style section
			$this->start_controls_section(
				'first_post_style_section',
				[
					'label' => esc_html__( 'First Post', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
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
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-thumbnail' ),
				]
			);
			$this->add_control(
				'styler_first_post_post_thumbnail_image',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-thumbnail img' ),
				]
			);
			$this->add_control(
				'styler_first_post_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-content' ),
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
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-excerpt' ),
				]
			);
			$this->add_control(
				'styler_first_post_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-readmore' ),
				]
			);
			$this->end_controls_section();

			// Posts Metadata Style section
			$this->start_controls_section(
				'first_post_metadata_style_section',
				[
					'label' => esc_html__( 'Fist Post Metadata', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_first_posts_post_metadata_container',
				[
					'label'            => esc_html__( 'Metadata Wrapper (Before Title)', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-metadata.before-title' ),
				]
			);
			$this->add_control(
				'styler_first_posts_post_metadata_container_after_title',
				[
					'label'            => esc_html__( 'Metadata Wrapper (After Title)', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-metadata.after-title' ),
				]
			);
			$this->add_control(
				'styler_first_posts_post_metadata_container_after_excerpt',
				[
					'label'            => esc_html__( 'Metadata Wrapper (After Excerpt)', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-metadata.after-excerpt' ),
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_format_wrapper',
				[
					'label'            => esc_html__( 'Post Format Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-format' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'first_styler_posts_metadata_post_format_icon',
				[
					'label'            => esc_html__( 'Post Format Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-format .kata-icon' ),
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_categories_wrapper',
				[
					'label'            => esc_html__( 'Categories Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-category-links' ),
					'separator'			=> 'before',
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
					'separator'			=> 'before',
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
					'separator'			=> 'before',
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
					'label'				=> esc_html__( 'Custom Date Format 1', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-first-post .kata-post-date a .kt-date-format1' ),
					'condition'			=> [
						'first_post_custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'styler_first_posts_metadata_post_date_2',
				[
					'label'				=> esc_html__( 'Custom Date Format 2', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-first-post .kata-post-date a .kt-date-format2' ),
					'condition'			=> [
						'first_post_custom_date_format' => 'yes'
					]
				]
			);
			$this->add_control(
				'styler_first_posts_metadata_post_date_3',
				[
					'label'				=> esc_html__( 'Custom Date Format 3', 'kata-plus' ),
					'type'				=> 'kata_styler',
					'selectors'			=> Kata_Styler::selectors( '.kata-first-post .kata-post-date a .kt-date-format3' ),
					'condition'			=> [
						'first_post_custom_date_format' => 'yes'
					]
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
					'separator'			=> 'before',
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
					'separator'			=> 'before',
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
					'condition' => [
						'first_post_author_symbol' => 'icon',
					],
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_author_avatar',
				[
					'label'            => esc_html__( 'Author Avatar', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-author .avatar' ),
					'condition' => [
						'first_post_author_symbol' => 'avatar',
					],
				]
			);
			$this->add_control(
				'styler_first_post_metadata_container',
				[
					'label'            => esc_html__( 'Metadata Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-first-post .kata-post-metadata' ),
					'separator'			=> 'before',
				]
			);
			$this->add_control(
				'styler_first_post_metadata_post_time_to_read_wrapper',
				[
					'label'            => esc_html__( 'Time To Read Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post .kata-time-to-read' ),
					'separator'			=> 'before',
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
					'separator'			=> 'before',
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
				'first_styler_posts_metadata_post_post_view_wrapper',
				[
					'label'            => esc_html__( 'Post View Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-post.kata-first-post .kata-post-view' ),
					'separator'			=> 'before',
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
				'styler_arrow_left_wrapper',
				[
					'label'            => __( 'Left Arrow Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-nav .owl-prev' ),
				]
			);
			$this->add_control(
				'styler_arrow_left',
				[
					'label'            => __( 'Left Arrow', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-nav .owl-prev i' ),
				]
			);
			$this->add_control(
				'styler_arrow_right_wrapper',
				[
					'label'            => __( 'Right Arrow Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-blog-posts .owl-nav .owl-next' ),
				]
			);
			$this->add_control(
				'styler_arrow_right',
				[
					'label'            => __( 'Right Arrow', 'kata-plus' ),
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
					],
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post',
				[
					'label'            => esc_html__( 'Post', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-blog-post:not(.kata-first-post)' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-blog-post:not(.kata-first-post) .kata-post-thumbnail' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-blog-post:not(.kata-first-post) .kata-post-thumbnail img' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-blog-post:not(.kata-first-post) .kata-post-content' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-blog-post:not(.kata-first-post) .kata-post-title' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-blog-post:not(.kata-first-post) .kata-post-excerpt' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_posts_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-blog-post:not(.kata-first-post) .kata-post-readmore' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'carousel_center_item_section',
				[
					'label' => esc_html__( 'Carousel Center Item', 'kata-plus' ),
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
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-blog-post:not(.kata-first-post) .kata-post-thumbnail' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-blog-post:not(.kata-first-post) .kata-post-thumbnail img' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_content_wrapper',
				[
					'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-blog-post:not(.kata-first-post) .kata-post-content' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-blog-post:not(.kata-first-post) .kata-post-title' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-blog-post:not(.kata-first-post) .kata-post-excerpt' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_posts_post_read_more',
				[
					'label'            => esc_html__( 'Read More', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-blog-post:not(.kata-first-post) .kata-post-readmore' ),
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
