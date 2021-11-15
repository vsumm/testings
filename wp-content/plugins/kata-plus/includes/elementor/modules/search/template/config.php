<?php
/**
 * Search module config.
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
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Search extends Widget_Base {
	public function get_name() {
		return 'kata-plus-search';
	}

	public function get_title() {
		return esc_html__( 'Search', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-search';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_header' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-search' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-search' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Search Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'livesearch',
			[
				'label'        => __( 'Live Search', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'layout',
			[
				'label' 		=> __( 'Layout', 'kata-plus' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'simple',
				'options' 		=> [
					'simple' => __( 'Simple', 'kata-plus' ),
					'modal'  => __( 'Modal', 'kata-plus' ),
					'toggle' => __( 'Toggle', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'text',
			[
				'label'     => esc_html__('Modal Placeholder', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => __('Search', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'toggleplaceholder',
			[
				'label'		=> __('Icon Type', 'kata-plus'),
				'type'		=> Controls_Manager::CHOOSE,
				'default'	=> 'placeholder_icon',
				'toggle'	=> true,
				'options'	=> [
					'image'	=> [
						'title'	=> __('Image', 'kata-plus'),
						'icon'	=> 'fa fa-image',
					],
					'placeholder_icon'	=> [
						'title'	=> __('Icon', 'kata-plus'),
						'icon'	=> 'fas fa-icons',
					],
				],
				'condition' => [
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __('Image/SVG', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('SVG', 'kata-plus'),
				],
				'condition' => [
					'toggleplaceholder' => [
						'image',
					],
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'   => __('Choose Image', 'kata-plus'),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'toggleplaceholder' => [
						'image', 'svg',
					],
					'layout!' => 'simple'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
				'condition' => [
					'toggleplaceholder' => [
						'image',
					],
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'placeholder_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/search',
				'condition' => [
					'toggleplaceholder' => [
						'placeholder_icon',
					],
					'layout!' => 'simple'
				],
			]
		);
		$posttypes = get_post_types( array( 'public' => true ) );
		array_push( $posttypes, 'all' );
		$this->add_control(
			'posttype',
			[
				'label'		=> __( 'Post Type', 'kata-plus' ),
				'type'		=> \Elementor\Controls_Manager::SELECT,
				'default' 	=> '0',
				'options' 	=> str_replace( '_', ' ', $posttypes ),
				'condition' => [
					'livesearch' => 'yes'
				]
			]
		);
		$taxonomies = get_taxonomies( ['public' => true], 'names', 'and' ); 
		unset( $taxonomies['post_format'] );
		$this->add_control(
			'taxonomy',
			[
				'label'		=> __( 'Taxonomy', 'kata-plus' ),
				'type'		=> \Elementor\Controls_Manager::SELECT,
				'default' 	=> 'category',
				'options' 	=> str_replace( '_', ' ', $taxonomies ),
				'condition' => [
					'livesearch' => 'yes'
				]
			]
		);
		$this->add_control(
			'placeholder',
			[
				'label' => __( 'Placeholder', 'kata-plus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Search…', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'button',
			[
				'label' => __( 'Button', 'kata-plus' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Search', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_placeholder',
			[
				'label' => esc_html__( 'Modal Placeholder', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_place_holder_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-search-open-as' ),
			]
		);
		$this->add_control(
			'styler_place_holder_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-toggle-wrapper .kata-icon' ),
				'condition' => [
					'toggleplaceholder' => 'placeholder_icon',
				]
			]
		);
		$this->add_control(
			'styler_place_holder_icon_uploaded',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-toggle-wrapper .kata-svg-icon' ),
				'condition' => [
					'toggleplaceholder' => 'image',
					'symbol' => 'svg'
				]
			]
		);
		$this->add_control(
			'styler_place_holder_image',
			[
				'label'     => esc_html__( 'Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-toggle-wrapper img' ),
				'condition' => [
					'toggleplaceholder' => 'image',
					'symbol' => 'imagei'
				]
			]
		);
		$this->add_control(
			'styler_place_holder_text',
			[
				'label'     => esc_html__( 'Text', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-search-open-as .kt-search-toggle-text' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Modal Content', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-form' ),
			]
		);
		$this->add_control(
			'styler_input_search',
			[
				'label'     => esc_html__( 'Search Field', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-form input[type="search"]' ),
			]
		);
		$this->add_control(
			'styler_input_search_placeholder',
			[
				'label'     => esc_html__( 'Search Placeholder', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-form input[type="search"]::placeholder' ),
			]
		);
		$this->add_control(
			'styler_input_button',
			[
				'label'     => esc_html__( 'Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-form input[type="submit"]' ),
			]
		);
		$this->add_control(
			'styler_modal_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-search-overlay' ),
				'condition' => [
					'layout' => 'modal'
				]
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
			'styler_button_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-search-form .kata-search-icon i.kata-icon' ),
			]
		);
		$this->add_control(
			'styler_close_icon',
			[
				'label'     => esc_html__( 'Close Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-close-search-modal .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_result',
			[
				'label'     => esc_html__( 'Result wrap', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-ajax-result' ),
				'condition' => [
					'livesearch' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'styler_result_for',
			[
				'label'     => esc_html__( 'Result For', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-ajax-result-wrap .search-result-is' ),
				'condition' => [
					'livesearch' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'styler_result_item',
			[
				'label'     => esc_html__( 'Items Featured Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-ajax-result li img' ),
				'condition' => [
					'livesearch' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'styler_result_thumb',
			[
				'label'     => esc_html__( 'Thumbnail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-ajax-result li img' ),
				'condition' => [
					'livesearch' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'styler_result_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-search-ajax-result li h4' ),
				'condition' => [
					'livesearch' => [
						'yes',
					],
				],
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
