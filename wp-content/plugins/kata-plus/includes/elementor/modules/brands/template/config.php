<?php
/**
 * Brands module config.
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

class Kata_Plus_Brands extends Widget_Base {
	public function get_name() {
		return 'kata-plus-brands';
	}

	public function get_title() {
		return esc_html__( 'Brands', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-accordion';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-owl', 'kata-plus-owlcarousel' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-brands', 'kata-plus-owlcarousel', 'kata-plus-kata-owl' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Brand Content Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'yb_img',
			[
				'label' => __( 'Select Your Images', 'kata-plus' ),
				'type'  => Controls_Manager::GALLERY,
			]
		);
		$this->add_responsive_control(
			'yb_num',
			[
				'label'     => __( 'Item per row', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'devices'	=> [ 'desktop', 'tablet', 'mobile' ],
				'options'   => [
					'one'   => __( 'One', 'kata-plus' ),
					'two'   => __( 'Two', 'kata-plus' ),
					'three' => __( 'Three', 'kata-plus' ),
					'four'  => __( 'Four', 'kata-plus' ),
					'five'  => __( 'Five', 'kata-plus' ),
					'six'   => __( 'Six', 'kata-plus' ),
				],
				'default'   => 'four',
				'condition' => [
					'tesp_carousel!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'tesp_carousel',
			[
				'label'        => __( 'Carousel', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
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
				'condition'   => [
					'tesp_carousel' => [
						'yes',
					],
				],
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
				'condition'   => [
					'tesp_carousel' => [
						'yes',
					],
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
				'condition'   => [
					'tesp_carousel' => [
						'yes',
					],
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
				'condition'   => [
					'tesp_carousel' => [
						'yes',
					],
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
				'condition'   => [
					'tesp_carousel' => [
						'yes',
					],
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
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_prev',
			[
				'label'     => __( 'Left Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'font-awesome/angle-left',
				'condition' => [
					'tesp_carousel' => [
						'yes',
					],
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
					'tesp_carousel' => [
						'yes',
					],
					'inc_owl_arrow' => [
						'true',
					],
				],
			]
		);
		$this->add_responsive_control(
			'inc_owl_pag',
			[
				'label'        => __( 'Pagination', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_pag_num',
			[
				'label'        => __( 'Change to Number', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
					'inc_owl_pag'   => [
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
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
				],
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
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
				],
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
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
				],
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
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
				],
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
				'condition'    => [
					'tesp_carousel' => [
						'yes',
					],
				],
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-brands' ),
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'            => esc_html__( 'Brand item', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-brands .kata-brands-items' ),
			]
		);
		$this->add_control(
			'styler_item_img',
			[
				'label'            => esc_html__( 'Brand image', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-brands .kata-brands-items img' ),
			]
		);
		$this->add_control(
			'styler_arrow',
			[
				'label'            => esc_html__( 'Left & Right Arrows', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-brands .owl-nav i' ),
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
			'styler_left_arrow',
			[
				'label'            => esc_html__( 'Left Arrow', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-brands .owl-nav .owl-prev i' ),
			]
		);
		$this->add_control(
			'styler_right_arrow',
			[
				'label'            => esc_html__( 'Right Arrow', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-brands .owl-nav .owl-next i' ),
			]
		);
		$this->add_control(
			'styler_bullets',
			[
				'label'            => esc_html__( 'Bullets', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-owl .owl-dots .owl-dot' ),
			]
		);
		$this->add_control(
			'styler_bullets_active',
			[
				'label'            => esc_html__( 'Active Bullets', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-owl .owl-dots .owl-dot.active' ),
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
