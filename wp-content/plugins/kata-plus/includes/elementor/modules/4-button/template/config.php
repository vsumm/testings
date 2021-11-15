<?php
/**
 * Button module config.
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
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Button extends Widget_Base {
	public function get_name() {
		return 'kata-plus-button';
	}

	public function get_title() {
		return esc_html__( 'Button', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-button';
	}

	public function get_categories() {
		return ['kata_plus_elementor_most_usefull'];
	}

	public function get_script_depends() {
		return ['kata-jquery-enllax'];
	}

	public function get_style_depends() {
		return ['kata-plus-button'];
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
			'link',
			[
				'label'         => __( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'kata-plus' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);
		$this->add_control(
			'link_to_home',
			[
				'label'        => __('Link To Home', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'kata-plus'),
				'label_off'    => __('Off', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
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
		$this->add_control(
			'button_icon_position',
			[
				'label'   => __( 'Icon Position', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'   => __( 'Left', 'kata-plus' ),
					'right' => __( 'Right', 'kata-plus' ),
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'st_button_wrapper',
			[
				'label'     		=> esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      		=> 'kata_styler',
				'selectors' 		=> Kata_Styler::selectors( '.kata-plus-button-wrap' ),
			]
		);
		$this->add_control(
			'st_button',
			[
				'label'    			=> esc_html__( 'Button', 'kata-plus' ),
				'type'     			=> 'kata_styler',
				'selectors'			=> Kata_Styler::selectors( '.kata-button' ),
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
				'selectors' 		=> Kata_Styler::selectors( '.kata-icon', '', '.kata-button' ),
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
