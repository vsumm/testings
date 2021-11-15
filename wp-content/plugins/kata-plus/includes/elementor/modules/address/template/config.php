<?php
/**
 * Address module config.
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

class Kata_Plus_Address extends Widget_Base {
	public function get_name() {
		return 'kata-plus-address';
	}

	public function get_title() {
		return esc_html__( 'Address', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-address';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Address Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'label',
			[
				'label'       => __( 'Label', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Write a label', 'kata-plus' ),
				'default'     => __( 'Address', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'address',
			[
				'label'       => __( 'Address', 'kata-plus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your Address', 'kata-plus' ),
				'default'     => __( 'California City Blvd California City CA 78912', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __('Icon Source', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __('Kata Icons', 'kata-plus'),
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'address_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/location-pin',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'address_image',
			[
				'label'     => __( 'Choose Image', 'kata-plus' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'symbol' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'address_image',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'symbol' => [
						'imagei',
						'svg',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_address_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-address-wrapper' ),
			]
		);
		$this->add_control(
			'styler_address_label',
			[
				'label'     => esc_html__( 'Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-address-wrapper .kata-plus-address-label' ),
			]
		);
		$this->add_control(
			'styler_address',
			[
				'label'     => esc_html__( 'Address', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-address-wrapper .kata-plus-address' ),
			]
		);
		$this->add_control(
			'styler_address_icon_wrap',
			[
				'label'     => esc_html__( 'Icon Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-address-wrapper .kata-plus-address-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_address_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-address-wrapper .kata-plus-address-icon-wrap i' ),
			]
		);
		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}