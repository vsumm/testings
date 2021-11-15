<?php
/**
 * Course_Enroll module config.
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
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Course_Enroll extends Widget_Base {
	public function get_name() {
		return 'kata-plus-course-enroll';
	}

	public function get_title() {
		return esc_html__( 'Course Enroll', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-button';
	}

	public function get_categories() {
		return ['kata_plus_elementor_learnpress_course'];
	}

	public function get_script_depends() {
		return ['kata-jquery-enllax'];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Button Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Text', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Default text', 'kata-plus' ),
				'placeholder' => __( 'Type your text here', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __( 'Icon Source', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __( 'Kata Icons', 'kata-plus' ),
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'btn_image',
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
				'name'      => 'btn_image',
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
			'widget_wrapper_styles',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'st_button_wrapper',
			[
				'label'     		=> esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      		=> 'kata_styler',
				'selectors' 		=> Kata_Styler::selectors( '.kata-plus-enroll-button' ),
			]
		);
		$this->add_control(
			'st_course_form_wrapper',
			[
				'label'     		=> esc_html__( 'Form Wrapper', 'kata-plus' ),
				'type'      		=> 'kata_styler',
				'selectors' 		=> Kata_Styler::selectors( '.enroll-course' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'buttons_styles_tab',
			[
				'label' => esc_html__( 'Button', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'st_button',
			[
				'label'    			=> esc_html__( 'Enroll Button', 'kata-plus' ),
				'type'     			=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.button-purchase-course' ),
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
			'st_icon',
			[
				'label'     		=> esc_html__( 'Icon', 'kata-plus' ),
				'type'      		=> 'kata_styler',
				'selectors' 		=> Kata_Styler::selectors( '.kata-button .kata-icon' ),
			]
		);
		$this->add_control(
			'st_image',
			[
				'label'     		=> esc_html__( 'Image', 'kata-plus' ),
				'type'      		=> 'kata_styler',
				'selectors' 		=> Kata_Styler::selectors( '.kata-button img' ),
				'condition' => [
					'symbol' => ['imagei'],
				],
			]
		);
		$this->add_control(
			'st_svg',
			[
				'label'     		=> esc_html__( 'SVG', 'kata-plus' ),
				'type'      		=> 'kata_styler',
				'selectors' 		=> Kata_Styler::selectors( '.kata-button svg' ),
				'condition' => [
					'symbol' => ['svg'],
				],
			]
		);
		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
