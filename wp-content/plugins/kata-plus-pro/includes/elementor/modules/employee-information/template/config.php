<?php
/**
 * Employee Information config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Employee_Information extends Widget_Base {
	public function get_name() {
		return 'kata-plus-employee-information';
	}

	public function get_title() {
		return esc_html__( 'Employee Information', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-person';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-employee' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'box_section',
			[
				'label' => esc_html__( 'Employee Information', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'name',
			[
				'label'   => __( 'Name', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Steve J Parker', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'position',
			[
				'label'   => __( 'Position', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Managing Director', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'profile_symbol',
			[
				'label'   => __( 'Image/SVG', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'profile',
			[
				'label' => __( 'Profile Picture', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'profile',
				'default'   => 'full',
				'separator' => 'none',
			]
		);
		$this->add_control(
			'signature',
			[
				'label' => __( 'Signature', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'signature_symbol',
			[
				'label'   => __( 'Image/SVG', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __( 'Image', 'kata-plus' ),
					'svg'    => __( 'Svg', 'kata-plus' ),
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'signature',
				'default'   => 'full',
				'separator' => 'none',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_widget_wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-employee-information' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_employee_style',
			[
				'label' => esc_html__( 'Employee', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_profile_wrapper',
			[
				'label'     		=> __( 'Profile Picture Wrapper', 'kata-plus' ),
				'type'      		=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors(  '.kata-employee-information .employee-profile' ),
			]
		);
		$this->add_control(
			'styler_profile_picture',
			[
				'label'     => __( 'Profile Picture', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-employee-information .employee-profile .employee-image img' ),
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'     => __( 'Content Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-employee-information .employee-dec' ),
			]
		);
		$this->add_control(
			'styler_name',
			[
				'label'     => __( 'Name', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-employee-information .employee-dec .employee-name' ),
			]
		);
		$this->add_control(
			'styler_position',
			[
				'label'     => __( 'Position', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-employee-information .employee-dec .employee-position' ),
			]
		);
		$this->add_control(
			'styler_signature',
			[
				'label'     => __( 'Signature', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-employee-information .employee-signature img' ),
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
