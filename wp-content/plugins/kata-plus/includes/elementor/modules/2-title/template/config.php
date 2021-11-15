<?php
/**
 * Title module config.
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
use Elementor\Repeater;

class Kata_Plus_Title extends Widget_Base {
	public function get_name() {
		return 'kata-plus-title';
	}

	public function get_title() {
		return esc_html__( 'Title', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-editor-h1';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_script_depends() {
		return ['kata-jquery-enllax'];
	}

	public function get_style_depends() {
		return [ 'kata-plus-title' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Title Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'kata-plus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Write your Title', 'kata-plus' ),
				'default'     => __( 'Title', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle', 'kata-plus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Write your Subtitle', 'kata-plus' ),
				'default'     => __( 'Subtitle', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label'   => __( 'Title tag', 'kata-plus' ),
				'description'   => __( 'Set a certain tag for title', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1'   => __( 'H1', 'kata-plus' ),
					'h2'   => __( 'H2', 'kata-plus' ),
					'h3'   => __( 'H3', 'kata-plus' ),
					'h4'   => __( 'H4', 'kata-plus' ),
					'h5'   => __( 'H5', 'kata-plus' ),
					'h6'   => __( 'H6', 'kata-plus' ),
					'p'    => __( 'P', 'kata-plus' ),
					'span' => __( 'Span', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'subtitle_tag',
			[
				'label'   => __( 'Subtitle tag', 'kata-plus' ),
				'description'   => __( 'Set a certain tag for subtitle.', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h5',
				'options' => [
					'h1'   => __( 'H1', 'kata-plus' ),
					'h2'   => __( 'H2', 'kata-plus' ),
					'h3'   => __( 'H3', 'kata-plus' ),
					'h4'   => __( 'H4', 'kata-plus' ),
					'h5'   => __( 'H5', 'kata-plus' ),
					'h6'   => __( 'H6', 'kata-plus' ),
					'p'    => __( 'P', 'kata-plus' ),
					'span' => __( 'Span', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'link',
			[
				'label'         => __( 'Link', 'kata-plus' ),
				'description'   => __( 'Set link for title and subtitle.', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'kata-plus' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);
		$this->add_control(
			'link_to_home',
			[
				'label'        => __('Link To Home', 'kata-plus'),
				'description'   => __( 'Set the link to the homepage.', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_shape',
			[
				'label' => esc_html__( 'Shape', 'kata-plus' ),
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'shape',
			[
				'label'     => __('Shape', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('{{CURRENT_ITEM}}'),
			]
		);
		$this->add_control(
			'shape',
			[
				'label'  		=> __( 'Shape', 'kata-plus' ),
				'type'   		=> Controls_Manager::REPEATER,
				'prevent_empty' => false,
				'fields'		=> $repeater->get_controls(),
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
			'styler_title_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-title-wrapper' ),
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-title-wrapper .kata-plus-title' ),
			]
		);
		$this->add_control(
			'styler_subtitle',
			[
				'label'     => esc_html__( 'Subtitle', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-title-wrapper .kata-plus-subtitle' ),
			]
		);
		$this->add_control(
			'styler_link',
			[
				'label'     => esc_html__( 'Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-title-wrapper .kata-title-url' ),
			]
		);
		$this->end_controls_section();

		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
