<?php
/**
 * Carousel Grid module config.
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

class Kata_Plus_Pro_Carousel_Grid extends Widget_Base {

	public function get_name() {
		return 'kata-plus-carousel-grid';
	}

	public function get_title() {
		return esc_html__( 'Portfolio Carousel', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-slider-push';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-owlcarousel', 'kata-plus-owl', 'kata-plus-carousel-grid-css', 'kata-plus-lightgallery' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-owlcarousel', 'kata-plus-owl-owlcarousel2-filter-js', 'kata-plus-carousel-grid-js', 'kata-plus-lightgallery' ];
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
			'carousel_content',
			[
				'label' => esc_html__( 'Content Settings', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'carousel_mode',
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
			'carousel_categories_mode',
			[
				'label'     => esc_html__( 'Categories', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'all'    => esc_html__( 'All', 'kata-plus' ),
					'custom' => esc_html__( 'Custom', 'kata-plus' ),
				],
				'default'   => 'all',
				'condition' => [
					'carousel_mode' => 'custom_posts',
				],
			]
		);
		$this->add_control(
			'carousel_categories',
			[
				'label'     => esc_html__( 'Select Categories', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'dynamic'   => [ 'active' => true ],
				'multiple'  => true,
				'options'   => $categories_options,
				'default'   => '',
				'condition' => [
					'carousel_mode'            => 'custom_posts',
					'carousel_categories_mode' => 'custom',
				],
			]
		);
		$this->add_control(
			'carousel_show_posts',
			[
				'label'     => esc_html__( 'Posts', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'all'    => esc_html__( 'All', 'kata-plus' ),
					'custom' => esc_html__( 'Custom', 'kata-plus' ),
				],
				'default'   => 'all',
				'condition' => [
					'carousel_mode'            => 'custom_posts',
					'carousel_categories_mode' => 'all',
				],
			]
		);
		$this->add_control(
			'carousel_posts',
			[
				'label'     => esc_html__( 'Select Posts', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'dynamic'   => [
					'active' => true,
				],
				'multiple'  => true,
				'options'   => $posts_options,
				'condition' => [
					'carousel_mode'            => 'custom_posts',
					'carousel_show_posts'      => 'custom',
					'carousel_categories_mode' => 'all',
				],
			]
		);
		$this->end_controls_section();

		// owl option
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Carousel Settings', 'kata-plus' ),
			]
		);
		$this->add_responsive_control(
			'inc_owl_item',
			[
				'label'       => __( 'Item', 'kata-plus' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 5,
				'step'        => 1,
				'default'     => 3,
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'description' => __( 'Varies between 1/5', 'kata-plus' ),
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
				'return_value' => 'false',
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

		$this->start_controls_section(
			'carousel_appearance',
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
		$this->add_responsive_control(
			'carousel_show_categories',
			[
				'label'        => esc_html__( 'Filter', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_responsive_control(
			'carousel_show_title',
			[
				'label'        => esc_html__( 'Post Title', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_responsive_control(
			'carousel_show_date',
			[
				'label'        => esc_html__( 'Post Date', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'off',
			]
		);
		$this->add_responsive_control(
			'carousel_show_item_categories',
			[
				'label'        => esc_html__( 'Post Categories', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
		$this->add_responsive_control(
			'carousel_show_excerpt',
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
			'carousel_show_modal',
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

		$this->start_controls_section(
			'design_tab',
			[
				'label' => esc_html__( 'Design', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'carousel_post_has_link',
			[
				'label'        => esc_html__( 'Use Link', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Use', 'kata-plus' ),
				'label_off'    => esc_html__( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$repeater->add_control(
			'carousel_post_link',
			[
				'label'         => esc_html__( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [ 'carousel_post_has_link' => 'yes' ],
			]
		);
		$repeater->add_control(
			'carousel_post_icon',
			[
				'label'   => esc_html__( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/twitter',
			]
		);
		$repeater->add_control(
			'styler_carousel_nav_post_icon',
			[
				'label'            => esc_html__( 'Icon Style', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '{{CURRENT_ITEM}}', '', '.owl-item' ),
			]
		);
		$this->add_control(
			'carousel_posts_icons',
			[
				'label'       => esc_html__( 'Add Icons', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{ carousel_post_icon }}}',
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'showeletitle',
			[
				'label'        => esc_html__( 'Show Title', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$repeater->add_control(
			'carousel_nav_post_element_title',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'New Element',
				'condition'	=> [
					'showeletitle' => 'yes'
				]
			]
		);
		$repeater->add_control(
			'styler_carousel_nav_post_element_gtitle',
			[
				'label'		=> esc_html__( 'title', 'kata-plus' ),
				'type'		=> 'kata_styler',
				'selectors'	=> Kata_Styler::selectors( '{{CURRENT_ITEM}}.gtitle', '', '.owl-item' ),
				'condition'	=> [
					'showeletitle' => 'yes'
				]
			]
		);
		$repeater->add_control(
			'styler_carousel_nav_post_element',
			[
				'label'            => esc_html__( 'Element', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '{{CURRENT_ITEM}}.gele', '', '.owl-item' ),
			]
		);
		$this->add_control(
			'carousel_posts_elements',
			[
				'label'       => esc_html__( 'Element', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field' => '{{{carousel_nav_post_element_title}}}',
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
			'carousel_load_more',
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
			'carousel_load_more_text',
			[
				'label'     => esc_html__( 'See More Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'See More',
				'condition' => [
					'carousel_load_more' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'carousel_load_more_link',
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
					'carousel_load_more' => 'yes',
				],
			]
		);
		$this->add_control(
			'carousel_load_more_icon',
			[
				'label'     => esc_html__( 'See More Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'carousel_load_more' => 'yes',
				],
			]
		);
		$this->add_control(
			'carousel_load_more_icon_position',
			[
				'label'     => esc_html__( 'See More Icon Position', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'after'  => esc_html__( 'After', 'kata-plus' ),
					'before' => esc_html__( 'Before', 'kata-plus' ),
				],
				'default'   => 'after',
				'condition' => [
					'carousel_load_more'       => 'yes',
					'carousel_load_more_icon!' => '',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_widget_parent',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_carousel_carousel',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid' ),
			]
		);
		$this->add_control(
			'styler_carousel_stage',
			[
				'label'            => esc_html__( 'Carousel Stage', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.owl-stage-outer' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styler_filters',
			[
				'label' => esc_html__( 'Filter', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_carousel_carousel_categories',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.carousel-categories' ),
			]
		);
		$this->add_control(
			'styler_carousel_carousel_categories_items',
			[
				'label'            => esc_html__( 'Items', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.carousel-categories .cat-item' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styler_post_meta',
			[
				'label' => esc_html__( 'Metadata', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_carousel_postmeta_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.carousel-post-meta', '', '.owl-item' ),
			]
		);
		$this->add_control(
			'styler_carousel_date',
			[
				'label'            => esc_html__( 'Items Date', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.carousel-date', '', '.owl-item' ),
			]
		);
		$this->add_control(
			'styler_carousel_carousel_items_categories',
			[
				'label'            => esc_html__( 'Posts Categories', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.carousel-item-category', '', '.owl-item' ),
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
				'label'            => esc_html__( 'Item', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid .grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_overlay',
			[
				'label'            => esc_html__( 'Overlay', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.grid-overlay', '', '.owl-item' ),
			]
		);
		$this->add_control(
			'styler_grid_thumbnail',
			[
				'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.carousel-image', '', '.owl-item' ),
			]
		);
		$this->add_control(
			'styler_grid_image',
			[
				'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.carousel-image img', '', '.grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_content_wrapper',
			[
				'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.content-wrapper', '', '.grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_title',
			[
				'label'            => esc_html__( 'Title', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.carousel-title', '', '.grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_date',
			[
				'label'            => esc_html__( 'Date', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.carousel-date', '', '.grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_a',
			[
				'label'            => esc_html__( 'Categories item', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.carousel-item-category a', '', '.grid-item'  ),
			]
		);
		$this->add_control(
			'styler_grid_post_categories_separator',
			[
				'label'     => esc_html__( 'Categories Separator', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.carousel-item-category .separator', '', '.grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_excerpt',
			[
				'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.carousel-excerpt', '', '.grid-item' ),
			]
		);
		$this->add_control(
			'styler_grid_nav_load_more_button',
			[
				'label'            => esc_html__( 'See more button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-button-wrapper .kata-button' ),
			]
		);
		$this->add_control(
			'styler_grid_nav_load_more_button_icon',
			[
				'label'            => esc_html__( 'See more button icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-button-wrapper .kata-button .kata-icon' ),
			]
		);
		// Style options End
		$this->end_controls_section();

		// Carousel
		$this->start_controls_section(
			'section_box_style_carousel',
			[
				'label' => esc_html__( 'Carousel', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_arrow_wrapper',
			[
				'label'            => __( 'Slider Arrows Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid .owl-nav' ),
			]
		);
		$this->add_control(
			'styler_arrow_left',
			[
				'label'            => __( 'Slider Left Arrow', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid .owl-nav .owl-prev i' ),
			]
		);
		$this->add_control(
			'styler_arrow_right',
			[
				'label'            => __( 'Slider Right Arrow', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid .owl-nav .owl-next i' ),
			]
		);
		$this->add_control(
			'styler_boolets',
			[
				'label'            => __( 'Pagination Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid .owl-dots' ),
			]
		);
		$this->add_control(
			'styler_boolet',
			[
				'label'            => __( 'Bullets', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid .owl-dots .owl-dot' ),
			]
		);
		$this->add_control(
			'styler_boolet_active',
			[
				'label'            => __( 'Active Bullets', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-carousel-grid .owl-dots .owl-dot.active' ),
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
