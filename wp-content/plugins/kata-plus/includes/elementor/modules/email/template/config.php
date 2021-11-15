<?php
/**
 * Email module config.
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

class Kata_Plus_Email extends Widget_Base {
	public function get_name() {
		return 'kata-plus-email';
	}

	public function get_title() {
		return esc_html__( 'Email', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-email';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Email Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'label',
			[
				'label'       => __( 'Email', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Write a label', 'kata-plus' ),
				'default'     => __( 'Label', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'email',
			[
				'label'       => __( 'Email', 'kata-plus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your Email', 'kata-plus' ),
				'default'     => __( 'info@example.com', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'email_link',
			[
				'label'         => __('URL', 'kata-plus'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __('info@example.com', 'kata-plus'),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
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
			'email_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/alarm-clock',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'email_image',
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
				'name'      => 'email_image',
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
			'styler_email_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-email-wrapper' ),
			]
		);
		$this->add_control(
			'styler_email_label',
			[
				'label'     => esc_html__( 'Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-email-wrapper .kata-plus-email-label' ),
			]
		);
		$this->add_control(
			'styler_email',
			[
				'label'     => esc_html__( 'Email', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-email-wrapper .kata-plus-email-number' ),
			]
		);
		$this->add_control(
			'styler_email_icon_wrap',
			[
				'label'     => esc_html__( 'Icon Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-email-wrapper .kata-plus-email-icon-wrap' ),
			]
		);
		$this->add_control(
			'styler_email_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-email-wrapper .kata-plus-email-icon-wrap i' ),
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