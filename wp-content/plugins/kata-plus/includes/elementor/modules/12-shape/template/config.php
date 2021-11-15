<?php
/**
 * Shape module config.
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
use Elementor\Group_Control_Image_Size;

class Kata_Shape extends Widget_Base {
	public function get_name() {
		return 'kata-plus-shape';
	}

	public function get_title() {
		return esc_html__( 'Shape', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-circle';
	}

	public function get_script_depends() {
		return ['kata-jquery-enllax'];
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-shape' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Shape', 'kata-plus' ),
			]
		);

		$this->add_control(
			'shape',
			[
				'label'   => __( 'Shape', 'kata-plus' ),
				'description'   => __( 'Create circles, squares, and other shapes.', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => __( 'Circle', 'kata-plus' ),
					'square' => __( 'Square', 'kata-plus' ),
					'custom' => __( 'Custom Designing', 'kata-plus' ),
					'img'    => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);

		$this->add_control(
			'custom_dec',
			[
				'label'     => __( 'If you choose this option, you have an empty DIV tag that via the styler in style tab you can syle your DIV.', 'kata-plus' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'shape' => 'custom',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => __( 'Choose Image', 'kata-plus' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'shape' => [ 'img', 'svg' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'shape' => [ 'img', 'svg' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'parent_shape',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shape-element' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'shape_styling',
			[
				'label' => esc_html__( 'Shape', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_circle',
			[
				'label'     => esc_html__( 'Circle', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shape-element .circle-shape' ),
				'condition' => [
					'shape' => 'circle',
				],
			]
		);

		$this->add_control(
			'styler_square',
			[
				'label'     => esc_html__( 'Square', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shape-element .square-shape' ),
				'condition' => [
					'shape' => 'square',
				],
			]
		);

		$this->add_control(
			'styler_custom_element',
			[
				'label'     => esc_html__( 'Custom element', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shape-element .custom-shape' ),
				'condition' => [
					'shape' => 'custom',
				],
			]
		);

		$this->add_control(
			'styler_img',
			[
				'label'     => esc_html__( 'Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shape-element .img-shape' ),
				'condition' => [
					'shape' => 'img',
				],
			]
		);
		$this->add_control(
			'styler_svg',
			[
				'label'     => esc_html__( 'SVG', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-shape-element .kata-svg-icon' ),
				'condition' => [
					'shape' => 'svg',
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
