<?php
/**
 * Phone module config.
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
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Phone extends Widget_Base {
	public function get_name() {
		return 'kata-plus-phone';
	}

	public function get_title() {
		return esc_html__( 'Phone', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-phone';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Phone Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'label',
			[
				'label'       => __( 'Label', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Write a label', 'kata-plus' ),
				'default'     => __( 'Phone', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'phonenumber',
			[
				'label'       => __( 'Phone Number', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Write the phone number', 'kata-plus' ),
				'default'     => __( '+1(408)785-9933', 'kata-plus' ),
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
			'phone_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'font-awesome/phone2',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'phone_image',
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
				'name'      => 'phone_image',
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
			'styler_phone_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-phone-wrapper' ),
			]
		);
		$this->add_control(
			'styler_phone_label',
			[
				'label'     => esc_html__( 'Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-phone-wrapper .kata-plus-phone-label' ),
			]
		);
		$this->add_control(
			'styler_phonenumber',
			[
				'label'     => esc_html__( 'Phone Number', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-phone-wrapper .kata-plus-phone-number' ),
			]
		);
		$this->add_control(
			'styler_phone_icon_wrap',
			[
				'label'     => esc_html__( 'Icon Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-phone-wrapper .kata-plus-phone-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_phone_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-phone-wrapper .kata-plus-phone-icon-wrap i' ),
			]
		);
		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}