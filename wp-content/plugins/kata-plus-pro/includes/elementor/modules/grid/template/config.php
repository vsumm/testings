<?php
/**
 * Grid module config.
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

class Kata_Plus_Pro_Grid extends Widget_Base {
	public function get_name() {
		return 'kata-plus-grid';
	}

	public function get_title() {
		return esc_html__( 'Portfolio', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-grid', 'kata-plus-lightgallery' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-lightgallery', 'kata-plus-grid-js' ];
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
		$this->start_controls_section(
			'kata_plus_grid_content',
			[
				'label' => esc_html__( 'Content Settings', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'kata_plus_grid_mode', // param_name
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
			'posts_per_page', // param_name
			[
				'label'       => __( 'Posts per page', 'kata-plus' ),
				'description' => __( 'Set to "-1" to show all posts', 'kata-plus' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => -1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 10,
			]
		);
		$this->add_control(
			'kata_plus_grid_categories_mode', // param_name
			[
				'label'     => esc_html__( 'Categories', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'all'    => esc_html__( 'All', 'kata-plus' ),
					'custom' => esc_html__( 'Custom', 'kata-plus' ),
				],
				'default'   => 'all',
				'condition' => [
					'kata_plus_grid_mode' => 'custom_posts',
				],
			]
		);
		$this->add_control(
			'kata_plus_grid_categories', // param_name
			[
				'label'     => esc_html__( 'Select Categories', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'dynamic'   => [ 'active' => true ],
				'multiple'  => true,
				'options'   => $categories_options,
				'default'   => '',
				'condition' => [
					'kata_plus_grid_mode'            => 'custom_posts',
					'kata_plus_grid_categories_mode' => 'custom',
				],
			]
		);
		$this->add_control(
			'kata_plus_grid_show_posts', // param_name
			[
				'label'     => esc_html__( 'Show Posts', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'all'    => esc_html__( 'All', 'kata-plus' ),
					'custom' => esc_html__( 'Custom', 'kata-plus' ),
				],
				'default'   => 'all',
				'condition' => [
					'kata_plus_grid_mode'            => 'custom_posts',
					'kata_plus_grid_categories_mode' => 'all',
				],
			]
		);
		$this->add_control(
			'kata_plus_grid_posts', // param_name
			[
				'label'     => esc_html__( 'Select Posts', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'dynamic'   => [
					'active' => true,
				],
				'multiple'  => true,
				'options'   => $posts_options,
				'condition' => [
					'kata_plus_grid_mode'            => 'custom_posts',
					'kata_plus_grid_show_posts'      => 'custom',
					'kata_plus_grid_categories_mode' => 'all',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Settings', 'kata-plus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'kata_plus_grid_settings_items', // param_name
			[
				'label'      => esc_html__( 'Items Per Row', 'kata-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'post' ],
				'range'      => [
					'post' => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'post',
					'size' => 3,
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'kata_plus_grid_appearance',
			[
				'label' => esc_html__( 'Appearance Settings', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'thumbnail_size',
			[
				'label'       => __( 'Thumbnail Dimension', 'kata-plus' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'kata-plus' ),
				'default'     => [
					'width'  => '450',
					'height' => '450',
				],
			]
		);
		$this->add_control(
			'kata_plus_grid_show_title', // param_name
			[
				'label'        => esc_html__( 'Title', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'kata_plus_grid_show_date', // param_name
			[
				'label'        => esc_html__( 'Date', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'kata_plus_grid_show_item_categories', // param_name
			[
				'label'        => esc_html__( 'Categories', 'kata-plus' ),
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
				'label'   => __( 'Category Separator', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => ',',
			]
		);
		$this->add_control(
			'kata_plus_grid_show_excerpt', // param_name
			[
				'label'        => esc_html__( 'Excerpt', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'kata_plus_grid_show_modal',
			[
				'label'   => esc_html__( 'Link', 'kata-plus' ),
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
			'kata_plus_grid_post_link',
			[
				'label'         => esc_html__( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'condition'     => [ 'post_has_link' => 'yes' ],
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		$repeater->add_control(
			'kata_plus_grid_post_icon',
			[
				'label'   => esc_html__( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/twitter',
			]
		);
		$repeater->add_control(
			'styler_grid_nav_post_icon',
			[
				'label'     => esc_html__( 'Icon Style', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'kata_plus_grid_posts_icons',
			[
				'label'         => esc_html__( 'Add Icons', 'kata-plus' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field'   => '{{{ kata_plus_grid_post_icon }}}',
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'grid_nav_post_element_title',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'New Element',
			]
		);
		$repeater->add_control(
			'styler_grid_nav_post_element',
			[
				'label'     => esc_html__( 'Element', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'kata_plus_grid_posts_elements',
			[
				'label'         => esc_html__( 'Element', 'kata-plus' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field'   => '{{{grid_nav_post_element_title}}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'load_more_tab',
			[
				'label' => esc_html__( 'See More Settings', 'kata-plus' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'kata_plus_grid_load_more', // param_name
			[
				'label'        => esc_html__( 'Show See More Button', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'kata_plus_grid_load_more_text',
			[
				'label'     => esc_html__( 'See More Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'See More',
				'condition' => [
					'kata_plus_grid_load_more' => 'yes',
				],
			]
		);
		$this->add_control(
			'kata_plus_grid_load_more_link', // param_name
			[
				'label'       => esc_html__( 'Link', 'kata-plus' ), // heading
				'type'        => Controls_Manager::URL, // type
				'placeholder' => esc_html__( 'https://your-link.com', 'kata-plus' ),
				'default'     => [
					'url'         => get_site_url( null, '/grid/' ),
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'   => [
					'kata_plus_grid_load_more' => 'yes',
				],
			]
		);
		$this->add_control(
			'kata_plus_grid_load_more_icon',
			[
				'label'     => esc_html__( 'See More Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'kata_plus_grid_load_more' => 'yes',
				],
			]
		);
		$this->add_control(
			'kata_plus_grid_load_more_icon_position',
			[
				'label'     => esc_html__( 'See More Icon Position', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'after'  => esc_html__( 'After', 'kata-plus' ),
					'before' => esc_html__( 'Before', 'kata-plus' ),
				],
				'default'   => 'after',
				'condition' => [
					'kata_plus_grid_load_more'       => 'yes',
					'kata_plus_grid_load_more_icon!' => '',
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
				'selectors' => Kata_Styler::selectors( '.kata-plus-grid-wrap' ),
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
				'selectors' => Kata_Styler::selectors( '.kata-plus-grid .kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-overlay', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_content_wrapper',
			[
				'label'     => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-grid-content-wrap', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_thumbnail_wrapper',
			[
				'label'     => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-image', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_image',
			[
				'label'     => esc_html__( 'Thumbnail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-image img', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-title', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_date',
			[
				'label'     => esc_html__( 'Date', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-date', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-excerpt', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_wrapper',
			[
				'label'     => esc_html__( 'Categories Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-item-category', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_a',
			[
				'label'     => esc_html__( 'Categories item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-item-category a', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_separator',
			[
				'label'     => esc_html__( 'Categories Separator', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.grid-item-category .separator', '', '.kata-grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_nav_load_more_button',
			[
				'label'     => esc_html__( 'See More button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-grid-button' ),
			]
		);
		$this->add_control(
			'styler_grid_nav_load_more_button_icon',
			[
				'label'     => esc_html__( 'See More button icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-grid-button .kata-icon', '', '.kata-grid-item' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cat_filter_style',
			[
				'label' => esc_html__( 'Filters', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_grid_cat_filter_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-grid-wrap .masonry-category-filters' ),
			]
		);
		$this->add_control(
			'styler_grid_cat_filter_itmes',
			[
				'label'     => esc_html__( 'Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-grid-wrap .masonry-category-filters span' ),
			]
		);
		// Style options End
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
} // Class
