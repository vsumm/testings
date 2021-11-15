<?php
/**
 * Recipes module config.
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

class Kata_Plus_Pro_Recipes_elm extends Widget_Base {
	public function get_name() {
		return 'kata-plus-recipes';
	}

	public function get_title() {
		return esc_html__( 'Recipes', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-recipes';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-owlcarousel', 'kata-plus-owl' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-owlcarousel', 'kata-plus-owl', 'kata-plus-recipes' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'column',
			[
				'label'   => __( 'Column', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => '4',
				'options' => [
					'3' => __( 'Four Columns', 'kata-plus' ),
					'4' => __( 'Three Columns', 'kata-plus' ),
					'6' => __( 'Two Columns', 'kata-plus' ),
					'12' => __( 'One Column', 'kata-plus' ),
				],
			]
		);
		$terms      = get_terms( 'kata_recipe_category' );
		$categories = [];
		foreach ( $terms as $term ) {
			$categories[ $term->name ] = $term->name;
		}
		$this->add_control(
			'categories',
			[
				'label'       => __( 'Categories', 'kata-plus' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => __( 'You need to select categories (if you don\'t have any categories, please cfirst create one)', 'kata-plus' ),
				'multiple'    => true,
				'options'     => $categories,
			]
		);
		$this->add_control(
			'post_count',
			[
				'label'   => __( 'Post Count', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 6,
			]
		);
		$this->add_control(
			'carousel',
			[
				'label'        => __( 'Carousel', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->add_control(
			'cat_nav',
			[
				'label'        => __( 'Categories Navigation', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->end_controls_section();

		// owl option
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Carousel Settings', 'kata-plus' ),
				'condition' => [
					'carousel' => [
						'yes',
					],
				],
			]
		);
		$this->add_responsive_control(
			'inc_owl_item',
			[
				'label'       => __( 'Items Per View', 'kata-plus' ),
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
				'label'        => __( 'Change To Number', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
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
			'section_style_parent',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes' ),
				'condition' => [
					'carousel' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'styler_widget_stage',
			[
				'label'            => esc_html__( 'Carousel Stage', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.owl-stage-outer' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_cat_nav',
			[
				'label' => esc_html__( 'Categories Navigation', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_recipes_title_wrap',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-recipes-title' ),
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
			'styler_recipes_title_arrow',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_recipes_title_terms',
			[
				'label'     => esc_html__( 'Categories', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .recipes-terms-name' ),
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_styling_recipe',
			[
				'label' => esc_html__( 'Recipes', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_recipes_box',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .kata-recipes-item' ),
			]
		);
		$this->add_control(
			'styler_recipes_img',
			[
				'label'     => esc_html__( 'Thumbnail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .recipes-img img' ),
			]
		);
		$this->add_control(
			'styler_recipes_det_box',
			[
				'label'     => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-recipes-item .recipes-det' ),
			]
		);
		$this->add_control(
			'styler_recipes_cat',
			[
				'label'     => esc_html__( 'Category', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .recipes-cat .terms-item' ),
			]
		);
		$this->add_control(
			'styler_recipes_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .recipes-title h4' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_carousel_options',
			[
				'label' => esc_html__( 'Carousel', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'     => __( 'Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .kata-recipes-item' ),
			]
		);
		$this->add_control(
			'styler_arrow_left',
			[
				'label'     => __( 'Left Arrow', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .owl-nav .owl-prev i' ),
			]
		);
		$this->add_control(
			'styler_arrow_right',
			[
				'label'     => __( 'Right Arrow', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .owl-nav .owl-next i' ),
			]
		);
		$this->add_control(
			'styler_boolets',
			[
				'label'     => __( 'Bullet', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .owl-dots .owl-dot' ),
			]
		);
		$this->add_control(
			'styler_boolets_active',
			[
				'label'     => __( 'Active Bullet', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-recipes .owl-dots .owl-dot.active' ),
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
