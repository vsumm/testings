<?php
/**
 * Video Player module config.
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

class Kata_Plus_Video_Player extends Widget_Base {

	public function get_name() {
		return 'kata-plus-video-player';
	}

	public function get_title() {
		return esc_html__( 'Video Player', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-youtube';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-lightgallery', 'kata-plus-video-player', 'kata-jquery-enllax' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-lightgallery', 'kata-plus-video-player' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Text Settings', 'kata-plus' ),
			]
		);

		$this->add_control(
			'video_url',
			[
				'label'       => __( 'Video URL', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'https://www.youtube.com/watch?v=7e90gBu4pas', 'kata-plus' ),
				'placeholder' => __( 'Paste your youtube video URL here ', 'kata-plus' ),
			]
		);

		$this->add_control(
			'button',
			[
				'label'        => __( 'Background Image', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'image_placeholder',
			[
				'label'     => __( 'Image Placeholder', 'kata-plus' ), // heading
				'type'      => Controls_Manager::MEDIA, // type
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'button' => 'yes',
				],
			]
		);

		$this->add_control(
			'lightbox',
			[
				'label'        => __( 'Open in lightbox', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'no', 'kata-plus' ),
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'title_and_icon',
			[
				'label'     => __( 'Title And Icon', 'kata-plus' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your subtitle here', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'badge',
			[
				'label'       => __( 'Video badge', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'New services', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => __( 'Choose Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/play',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'parent_video',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-video-player' ),
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
			'styler_playerbtnwrapper',
			[
				'label'            => __( 'Player Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-vp-conent' ),
			]
		);
		$this->add_control(
			'styler_playerimg',
			[
				'label'            => __( 'Image', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-video-player img' ),
			]
		);
		$this->add_control(
			'styler_icon_wrapper',
			[
				'label'            => 'Icon Wrapper',
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-video-player .iconwrap' ),
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
			'styler_icon',
			[
				'label'            => 'Icon',
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-video-player .iconwrap .kata-icon' ),
			]
		);
		$this->add_control(
			'title_subtitle_wrapper',
			[
				'label'            => esc_html( 'Title&Subtitle Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-video-btn-content-wrap' ),
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'            => 'Title',
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-video-player .kata-vp-conent h5' ),
			]
		);
		$this->add_control(
			'styler_subtitle',
			[
				'label'            => 'Subtitle',
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-video-btn-content-wrap span' ),
			]
		);
		$this->add_control(
			'styler_video_badge',
			[
				'label'            => 'Video badge',
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-plus-video-player .video-badge' ),
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
