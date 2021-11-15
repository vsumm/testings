<?php
/**
 * products module config.
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

if ( ! class_exists( 'Kata_Plus_Pro_Products' ) ) {
	class Kata_Plus_Pro_Products extends Widget_Base {
		public function get_name() {
			return 'kata-plus-product-wrap';
		}

		public function get_title() {
			return esc_html__( 'products', 'kata-plus' );
		}

		public function get_icon() {
			return 'kata-widget kata-eicon-products-products';
		}

		public function get_categories() {
			return ['kata_plus_elementor_learnpress_product' ];
		}

		public function get_style_depends() {
			return ['kata-plus-owlcarousel', 'kata-plus-owl', 'kata-plus-products'];
		}

		public function get_script_depends() {
			return ['kata-plus-owlcarousel', 'kata-plus-owl', 'kata-jquery-enllax'];
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

			$categories = get_terms('product_cat');
			if ( isset( $categories->errors ) ) {
				return;
			}
			$cat_options['select_cat'] = __( 'Select Category', 'kata-plus' );
			if ( ! empty ( $categories ) ) {
				foreach ($categories as $category ) {
					$cat_options[ $category->slug ] = $category->name;
				}
			}
			$this->add_control(
				'query_categories',
				[
					'label'    => __( 'product Categories', 'kata-plus' ),
					'type'     => Controls_Manager::SELECT2,
					'options'  => $cat_options,
					'default'  => [],
					'multiple' => true,
				]
			);

			$tags = get_terms('product_tag');
			if ( isset( $tags->errors ) ) {
				return;
			}
			$tag_options['select_tag'] = __( 'Select Tag', 'kata-plus' );
			if ( ! empty ( $tags ) ) {
				foreach ( $tags as $tag ) {
					$tag_options[ $tag->slug ] = $tag->name;
				}
			}
			$this->add_control(
				'query_tags',
				[
					'label'    => __( 'product Tags', 'kata-plus' ),
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

			// products section
			$this->start_controls_section(
				'products_section',
				[
					'label' => esc_html__( 'products', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_responsive_control(
				'product_columns',
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
				'product_per_page',
				[
					'label'   => __( 'products Per Page', 'kata-plus' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'step'    => 1,
					'default' => 10,
				]
			);
			$this->add_control(
				'product_thumbnail_float',
				[
					'label'   => esc_html__('Thumbnail float', 'kata-plus'),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' => __( 'None', 'Kata-plus' ),
						'left' => __('Left', 'Kata-plus'),
						'right' => __( 'Right', 'Kata-plus' ),
					],
				]
			);
			$this->add_control(
				'product_pagination',
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
					'label'     => __( 'Enable Carousel', 'kata-plus' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'kata-plus' ),
					'label_off' => __( 'No', 'kata-plus' ),
					'default'   => '',
				]
			);
			$this->end_controls_section();

			// products Metadata section
			$this->start_controls_section(
				'products_metadata_section',
				[
					'label' => esc_html__( 'product Components', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'product_repeater_select',
				[
					'label'     => esc_html__( 'Component', 'kata-plus' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'title',
					'options'   => [
						'title'				=> esc_html__( 'Title', 'kata-plus' ),
						'thumbnail'			=> esc_html__( 'Thumbnail', 'kata-plus' ),
						'excerpt'			=> esc_html__( 'Excerpt', 'kata-plus' ),
						'categories'		=> esc_html__( 'Categories', 'kata-plus' ),
						'tags'				=> esc_html__( 'Tags', 'kata-plus' ),
						'date'				=> esc_html__( 'Date', 'kata-plus' ),
						'price'				=> esc_html__( 'Price', 'kata-plus'),
						'add_to_cart'		=> esc_html__( 'Add To Cart', 'kata-plus'),
					],
				]
			);
			$repeater->add_control(
				'start_mete_wrapper',
				[
					'label'        => __('Start Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'product_repeater_select' =>[
							'categories',
							'tags',
							'date',
						],
					],
				]
			);
			$repeater->add_control(
				'end_mete_wrapper',
				[
					'label'        => __('End Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'product_repeater_select' => [
							'categories',
							'tags',
							'date',
						],
					],
				]
			);
			$repeater->add_control(
				'products_title_tag',
				[
					'label'     => esc_html__( 'product Title Tag', 'kata-plus' ),
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
						'product_repeater_select' => 'title',
					],
				]
			);
			$repeater->add_control(
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
						'product_repeater_select' => 'thumbnail',
					],
				]
			);
			$repeater->add_control(
				'products_thumbnail_custom_size',
				[
					'label'       => __( 'product Thumbnail Custom Size', 'kata-plus' ),
					'description' => __( 'Crop the original image size to any custom size.', 'kata-plus' ),
					'type'        => Controls_Manager::IMAGE_DIMENSIONS,
					'default'     => [
						'width'  => '',
						'height' => '',
					],
					'condition'   => [
						'product_repeater_select' => 'thumbnail',
						'thumbnail_size' => 'custom',
					],
				]
			);
			$repeater->add_control(
				'excerpt_length',
				[
					'label'     => __( 'product Excerpt Length', 'kata-plus' ),
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
						'product_repeater_select' => 'excerpt',
					],
				]
			);
			$repeater->add_control(
				'product_category_icon',
				[
					'label'     => esc_html__( 'Category Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'product_repeater_select' => 'categories',
					],
				]
			);
			$repeater->add_control(
				'product_tag_icon',
				[
					'label'     => esc_html__( 'Tag Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/tag',
					'condition' => [
						'product_repeater_select' => 'tags',
					],
				]
			);
			$repeater->add_control(
				'product_date_icon',
				[
					'label'     => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'product_repeater_select' => 'date',
					],
				]
			);
			$repeater->add_control(
				'product_price_icon',
				[
					'label'     => esc_html__( 'Price Icon', 'kata-plus' ),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/money',
					'condition' => [
						'product_repeater_select' => 'price',
					],
				]
			);
			$repeater->add_control(
				'terms_seperator',
				[
					'label'			=> __( 'Category Separator', 'kata-plus' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> ',',
					'condition' => [
						'product_repeater_select' => 'categories',
						'product_repeater_select' => 'tags',
					],
				]
			);
			$this->add_control(
				'product_repeaters',
				[
					'label'       => __('Component Wrapper', 'kata-plus'),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'title_field' => '{{{ product_repeater_select }}}',
					'default'     => [
						[
							'product_repeater_select' => 'thumbnail',
						],
						[
							'product_repeater_select' => 'title',
						],
						[
							'product_repeater_select' => 'excerpt',
						],
						[
							'product_repeater_select' => 'price',
						],
						[
							'product_repeater_select' => 'add_to_cart',
						],
						[
							'product_repeater_select' => 'categories',
						],
						[
							'product_repeater_select' => 'tags',
						],
						[
							'product_repeater_select' => 'date',
						],
					],
					'condition' => [
						'product_thumbnail_float' => 'none',
					],
				]
			);
			$repeater2 = new Repeater();
			$repeater2->add_control(
				'product_repeater_select_2',
				[
					'label'     => esc_html__('Component', 'kata-plus'),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'title',
					'options'   => [
						'title'				=> esc_html__('Title', 'kata-plus'),
						'excerpt'			=> esc_html__('Excerpt', 'kata-plus'),
						'categories'		=> esc_html__('Categories', 'kata-plus'),
						'tags'				=> esc_html__('Tags', 'kata-plus'),
						'date'				=> esc_html__('Date', 'kata-plus'),
						'price'				=> esc_html__('Price', 'kata-plus'),
						'add_to_cart'		=> esc_html__( 'Add To Cart', 'kata-plus'),
					],
				]
			);
			$repeater2->add_control(
				'start_mete_wrapper',
				[
					'label'        => __('Start Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'product_repeater_select' =>[
							'categories',
							'tags',
							'date',
						],
					],
				]
			);
			$repeater2->add_control(
				'end_mete_wrapper',
				[
					'label'        => __('End Mete Data Wrapper', 'kata-plus'),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __('Yes', 'kata-plus'),
					'label_off'    => __('No', 'kata-plus'),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition' => [
						'product_repeater_select' => [
							'categories',
							'tags',
							'date',
						],
					],
				]
			);
			$repeater2->add_control(
				'products_title_tag',
				[
					'label'     => esc_html__('product Title Tag', 'kata-plus'),
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
						'product_repeater_select_2' => 'title',
					],
				]
			);
			$repeater2->add_control(
				'excerpt_length',
				[
					'label'     => __('product Excerpt Length', 'kata-plus'),
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
						'product_repeater_select_2' => 'sexcerpt',
					],
				]
			);
			$repeater2->add_control(
				'product_category_icon',
				[
					'label'     => esc_html__('Category Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/folder',
					'condition' => [
						'product_repeater_select_2' => 'categories',
					],
				]
			);
			$repeater2->add_control(
				'product_tag_icon',
				[
					'label'     => esc_html__('Tag Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/tag',
					'condition' => [
						'product_repeater_select_2' => 'tags',
					],
				]
			);
			$repeater2->add_control(
				'product_date_icon',
				[
					'label'     => esc_html__('Date Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/calendar',
					'condition' => [
						'product_repeater_select_2' => 'date',
					],
				]
			);
			$repeater2->add_control(
				'product_price_icon',
				[
					'label'     => esc_html__('Price Icon', 'kata-plus'),
					'type'      => 'kata_plus_icons',
					'default'   => 'themify/money',
					'condition' => [
						'product_repeater_select_2' => 'price',
					],
				]
			);
			$repeater2->add_control(
				'terms_seperator',
				[
					'label'			=> __('Category Separator', 'kata-plus'),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> ',',
					'condition' => [
						'product_repeater_select_2' => 'categories',
						'product_repeater_select_2' => 'tags',
					],
				]
			);
			$this->add_control(
				'product_repeaters_2',
				[
					'label'       => __( 'Component Wrapper', 'kata-plus' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater2->get_controls(),
					'title_field' => '{{{ product_repeater_select_2 }}}',
					'default'     => [
						[
							'product_repeater_select_2' => 'title',
						],
						[
							'product_repeater_select_2' => 'excerpt',
						],
						[
							'product_repeater_select_2' => 'price',
						],
						[
							'product_repeater_select' => 'add_to_cart',
						],
						[
							'product_repeater_select_2' => 'categories',
						],
						[
							'product_repeater_select_2' => 'tags',
						],
						[
							'product_repeater_select_2' => 'date',
						],
					],
					'condition' => [
						'product_thumbnail_float' => [
							'left',
							'right',
						],
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
					'max'         => 5,
					'step'        => 1,
					'default'     => 3,
					'devices'     => [ 'desktop', 'tablet', 'mobile' ],
					'description' => __( 'Varies between 1/5', 'kata-plus' ),
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

			// products Style section
			$this->start_controls_section(
				'section_widget_parent',
				[
					'label' => esc_html__( 'Wrapper', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_products_container',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap' ),
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
				'products_style_section',
				[
					'label' => esc_html__( 'products Style', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_products_product',
				[
					'label'            => esc_html__( 'product', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product' ),
				]
			);
			$this->add_control(
				'styler_product_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-thumbnail-wrapper' ),
				]
			);
			$this->add_control(
				'styler_product_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-thumbnail-wrapper img' ),
				]
			);
			$this->add_control(
				'styler_product_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-title a' ),
				]
			);
			$this->add_control(
				'styler_product_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-excerpt' ),
				]
			);
			$this->add_control(
				'styler_product_price_wrapper',
				[
					'label'            => esc_html__( 'Price Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-price-wrapper' ),
				]
			);
			$this->add_control(
				'styler_product_price_amount',
				[
					'label'            => esc_html__( 'Price Amount', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-price-wrapper .amount' ),
				]
			);
			$this->add_control(
				'styler_product_price_currency_symbol',
				[
					'label'            => esc_html__( 'Price Currency Symbol', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-price-wrapper .woocommerce-Price-currencySymbol' ),
				]
			);
			$this->add_control(
				'styler_product_add_to_cart_wrapper',
				[
					'label'            => esc_html__( 'Add To Cart Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-add-to-cart-wrapper' ),
				]
			);
			$this->add_control(
				'styler_product_add_to_cart_button',
				[
					'label'            => esc_html__( 'Add To Cart Button', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-add-to-cart-wrapper a' ),
				]
			);
			$this->end_controls_section();

			// products Pagination Style section
			$this->start_controls_section(
				'products_pagination_style_section',
				[
					'label' => esc_html__( 'Pagination Style', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_product_pagination_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .kata-plus-product-pagination' ),
				]
			);
			$this->add_control(
				'styler_product_pagination',
				[
					'label'            => esc_html__( 'Pagination', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .kata-plus-product-pagination .page-numbers' ),
				]
			);
			$this->add_control(
				'styler_product_pagination_current',
				[
					'label'            => esc_html__( 'Pagination Current', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .kata-plus-product-pagination .current' ),
				]
			);
			$this->add_control(
				'styler_product_pagination_prev_next',
				[
					'label'            => esc_html__( 'Pagination Previous/Next', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .kata-plus-product-pagination a.next.page-numbers, {{WRAPPER}} .kata-plus-product-wrap .kata-product-pagination a.prev.page-numbers' ),
				]
			);
			$this->end_controls_section();

			// products Metadata Style section
			$this->start_controls_section(
				'products_metadata_style_section',
				[
					'label' => esc_html__( 'Metadata Style', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_products_metadata_product_categories_wrapper',
				[
					'label'            => esc_html__( 'Categories Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-categories' ),
				]
			);
			$this->add_control(
				'styler_products_metadata_product_categories',
				[
					'label'            => esc_html__( 'Categories', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-categories a' ),
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
				'styler_products_metadata_product_category_icon',
				[
					'label'            => esc_html__( 'Categories Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-categories i' ),
				]
			);
			$this->add_control(
				'styler_products_metadata_product_tags_wrapper',
				[
					'label'            => esc_html__( 'Tags Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-tags' ),
				]
			);
			$this->add_control(
				'styler_products_metadata_product_tags',
				[
					'label'            => esc_html__( 'Tags', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-tags a' ),
				]
			);
			$this->add_control(
				'styler_products_metadata_product_date_wrapper',
				[
					'label'            => esc_html__( 'Date Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-date' ),
				]
			);
			$this->add_control(
				'styler_products_metadata_product_date',
				[
					'label'            => esc_html__( 'Date', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-date a' ),
				]
			);
			$this->add_control(
				'styler_products_metadata_product_date_icon',
				[
					'label'            => esc_html__( 'Date Icon', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product .kata-plus-product-date i' ),
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
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .owl-item .kata-plus-product' ),
				]
			);
			$this->add_control(
				'styler_arrow_wrapper',
				[
					'label'            => __( 'Slider Arrows Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .owl-nav' ),
				]
			);
			$this->add_control(
				'styler_arrow_left',
				[
					'label'            => __( 'Slider Left Arrow', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .owl-nav .owl-prev i' ),
				]
			);
			$this->add_control(
				'styler_arrow_right',
				[
					'label'            => __( 'Slider Right Arrow', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .owl-nav .owl-next i' ),
				]
			);
			$this->add_control(
				'styler_boolets',
				[
					'label'            => __( 'Bullets Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .owl-dots' ),
				]
			);
			$this->add_control(
				'styler_boolet',
				[
					'label'            => __( 'Bullets', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .owl-dots .owl-dot' ),
				]
			);
			$this->add_control(
				'styler_boolet_active',
				[
					'label'            => __( 'Active Bullet', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.kata-plus-product-wrap .owl-dots .owl-dot.active' ),
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
				'carousel_active_styler_product',
				[
					'label'            => esc_html__( 'product', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-product' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_product_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-product .kata-plus-product-thumbnail' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_product_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-product .kata-plus-product-thumbnail img' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_product_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-product .kata-plus-product-title' ),
				]
			);
			$this->add_control(
				'carousel_active_styler_product_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.active .kata-plus-product .kata-plus-product-excerpt' ),
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
				'carousel_center_styler_product',
				[
					'label'            => esc_html__( 'product', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-product' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_product_thumbnail_wrapper',
				[
					'label'            => esc_html__( 'Thumbnail Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-product .kata-plus-product-thumbnail' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_product_thumbnail',
				[
					'label'            => esc_html__( 'Thumbnail', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-product .kata-plus-product-thumbnail img' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_product_title',
				[
					'label'            => esc_html__( 'Title', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-product .kata-plus-product-title' ),
				]
			);
			$this->add_control(
				'carousel_center_styler_product_excerpt',
				[
					'label'            => esc_html__( 'Excerpt', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors( '.owl-item.center .kata-plus-product .kata-plus-product-excerpt' ),
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
