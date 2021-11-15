<?php
/**
 * Masonry Grid module config.
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

class Kata_Plus_Pro_Masonry_Grid extends Widget_Base {
	public function get_name() {
		return 'kata-plus-masonry-grid';
	}

	public function get_title() {
		return esc_html__( 'Portfolio Masonry', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-posts-masonry';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-owl-masonry-css', 'kata-plus-masonry-grid-css', 'kata-plus-lightgallery' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-masonry-grid-js', 'kata-plus-lightgallery' ];
	}

	protected function register_controls() {
		// Categories
		$terms              = get_terms( 'grid_category' );
		$categories_options = [];
		foreach ( $terms as $term ) {
			$categories_options[ $term->slug ] = $term->name;
		}

		// Posts
		$args          = array(
			'post_type'   => 'kata_grid',
			'post_status' => 'publish',
			'order'       => 'DESC',
		);
		$arr_posts     = new WP_Query( $args );
		$posts_options = [];
		foreach ( $arr_posts->get_posts() as $post ) {
			$posts_options[ $post->ID ] = $post->post_title;
		}

		// Content Settings #
		$this->start_controls_section(
			'content',
			[
				'label' => esc_html__( 'Content Settings', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mode',
			[
				'label'   => esc_html__( 'Content', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'all_posts'    => esc_html__( 'All Posts', 'kata-plus' ),
					'custom_posts' => esc_html__( 'Custom Posts', 'kata-plus' ),
				],
				'default' => 'all_posts',
			]
		);
		$this->add_control(
			'categories_mode',
			[
				'label'     => esc_html__( 'Categories', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'all'    => esc_html__( 'All', 'kata-plus' ),
					'custom' => esc_html__( 'Custom', 'kata-plus' ),
				],
				'default'   => 'all',
				'condition' => [
					'mode' => 'custom_posts',
				],
			]
		);
		$this->add_control(
			'categories',
			[
				'label'     => esc_html__( 'Select Categories', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'dynamic'   => [ 'active' => true ],
				'multiple'  => true,
				'options'   => $categories_options,
				'default'   => '',
				'condition' => [
					'mode'            => 'custom_posts',
					'categories_mode' => 'custom',
				],
			]
		);
		$this->add_control(
			'show_posts',
			[
				'label'     => esc_html__( 'Show Posts', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'all'    => esc_html__( 'All', 'kata-plus' ),
					'custom' => esc_html__( 'Custom', 'kata-plus' ),
				],
				'default'   => 'all',
				'condition' => [
					'mode'            => 'custom_posts',
					'categories_mode' => 'all',
				],
			]
		);
		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( 'Layout 1', 'kata-plus' ),
					'2' => esc_html__( 'Layout 2', 'kata-plus' ),
				],
				'default' => '1',
			]
		);
		$this->add_control(
			'posts_per_page',
			[
				'label'   => __( 'Post Per Page', 'kata-plus' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
				'default' => 8,
			]
		);
		$this->add_control(
			'posts',
			[
				'label'     => esc_html__( 'Select Posts', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'dynamic'   => [
					'active' => true,
				],
				'multiple'  => true,
				'options'   => $posts_options,
				'condition' => [
					'mode'            => 'custom_posts',
					'show_posts'      => 'custom',
					'categories_mode' => 'all',
				],
			]
		);
		$this->end_controls_section();

		// Appearance Settings #
		$this->start_controls_section(
			'appearance',
			[
				'label' => esc_html__( 'Appearance Settings', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'grid_gap',
			[
				'label'      => __( 'Gap', 'kata-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'em',
					'size' => 2,
				],
				'selectors'  => [
					'{{WRAPPER}} .kata-ms-grid-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'show_categories',
			[
				'label'        => esc_html__( 'Filter', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Post Title', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'show_date',
			[
				'label'        => esc_html__( 'Post Date', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'show_item_categories',
			[
				'label'        => esc_html__( 'Post Categories', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'categories_seperator',
			[
				'label'			=> __( 'Category Separator', 'kata-plus' ),
				'type'			=> Controls_Manager::TEXT,
				'default'		=> ',',
			]
		);
		$this->add_control(
			'show_excerpt',
			[
				'label'        => esc_html__( 'Post Excerpt', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'off',
			]
		);
		$this->add_control(
			'show_modal',
			[
				'label'   => esc_html__( 'Post Link', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'modal'  => esc_html__( 'Modal', 'kata-plus' ),
					'single' => esc_html__( 'Post Single', 'kata-plus' ),
				],
				'default' => 'modal',
				'toggle'  => true,
			]
		);
		$this->end_controls_section();

		// See More Settings #
		$this->start_controls_section(
			'design_tab',
			[
				'label' => esc_html__( 'Design', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'post_has_link',
			[
				'label'        => esc_html__( 'Use Link', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Use', 'kata-plus' ),
				'label_off'    => esc_html__( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$repeater->add_control(
			'post_link',
			[
				'label'         => esc_html__( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [ 'post_has_link' => 'yes' ],
			]
		);
		$repeater->add_control(
			'post_icon',
			[
				'label'   => esc_html__( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/twitter',
			]
		);
		$repeater->add_control(
			'icon_style_error',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$repeater->add_control(
			'styler_nav_post_icon',
			[
				'label'     => esc_html__( 'Icon Style', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'posts_icons',
			[
				'label'       => esc_html__( 'Add Icons', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ post_icon }}}',
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'masonry_nav_post_element_title',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'New Element',
			]
		);
		$repeater->add_control(
			'styler_nav_post_element',
			[
				'label'     => esc_html__( 'Element', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'posts_elements',
			[
				'label'       => esc_html__( 'Element', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{masonry_nav_post_element_title}}}',
			]
		);
		$this->end_controls_section();

		// See More Settings #
		$this->start_controls_section(
			'load_more_tab',
			[
				'label' => esc_html__( 'Load More Settings', 'kata-plus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'load_more',
			[
				'label'        => esc_html__( 'Show/Hide Button', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'load_more_text',
			[
				'label'     => esc_html__( 'Button Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'See More',
				'condition' => [
					'load_more' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'load_more_link',
			[
				'label'       => esc_html__( 'Link', 'kata-plus' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'kata-plus' ),
				'default'     => [
					'url'         => get_site_url( null, '/portfolio/' ),
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'   => [
					'load_more' => 'yes',
				],
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
			'load_more_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'load_more' => 'yes',
				],
			]
		);
		$this->add_control(
			'load_more_icon_position',
			[
				'label'     => esc_html__( 'See More Icon Position', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'after'  => esc_html__( 'After', 'kata-plus' ),
					'before' => esc_html__( 'Before', 'kata-plus' ),
				],
				'default'   => 'after',
				'condition' => [
					'load_more'       => 'yes',
					'load_more_icon!' => '',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_grid',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-masonry-grid-wrap' ),
			]
		);
		$this->add_control(
			'styler_grid_row',
			[
				'label'     => esc_html__( 'Row', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-masonry-grid-wrap .kata-ms-grid-row' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Item', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_grid_post_item',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-masonry-grid-wrap .ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_overlay',
			[
				'label'            => esc_html__( 'Overlay', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.grid-overlay', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_content_wrapper',
			[
				'label'     => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.ms-grid-content-wrap', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_image_wrapper',
			[
				'label'     => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-image', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_image',
			[
				'label'     => esc_html__( 'Thumbnail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-image img', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-title', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_date',
			[
				'label'     => esc_html__( 'Date', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-date', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-excerpt', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_a_wrapper',
			[
				'label'     => esc_html__( 'Categories Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-item-category', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_a',
			[
				'label'     => esc_html__( 'Categories item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-item-category a', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_separator',
			[
				'label'     => esc_html__( 'Categories Separator', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.masonry-item-category .separator', '', '.ms-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_nav_load_more_button',
			[
				'label'     => esc_html__( 'See more button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-masonry-button-wrapper .kata-button' ),
			]
		);
		$this->add_control(
			'styler_grid_nav_load_more_button_icon',
			[
				'label'     => esc_html__( 'See more button icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-masonry-button-wrapper .kata-button .kata-icon' ),
			]
		);
		// Style options End
		$this->end_controls_section();

		$this->start_controls_section(
			'filter_styler',
			[
				'label' => esc_html__( 'Filters', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_filter_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.filters.masonry-category-filters' ),
			]
		);
		$this->add_control(
			'styler_filter_items',
			[
				'label'     => esc_html__( 'Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.filters.masonry-category-filters .cat-item' ),
			]
		);
		$this->add_control(
			'styler_filter_active_items',
			[
				'label'     => esc_html__( 'Active Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.filters.masonry-category-filters .cat-item.active' ),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
