<?php

/**
 * Banner module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;

class Kata_Plus_Banner extends Widget_Base
{
	public function get_name()
	{
		return 'kata-plus-banner';
	}

	public function get_title()
	{
		return esc_html__('Banner', 'kata-plus');
	}

	public function get_icon()
	{
		return 'kata-widget kata-eicon-image-rollover';
	}

	public function get_categories()
	{
		return ['kata_plus_elementor_most_usefull'];
	}

	public function get_script_depends()
	{
		return ['jquery-visible'];
	}

	public function get_style_depends()
	{
		return ['kata-plus-banner'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'banner',
			[
				'label' => esc_html__('Banner', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'banner_tag',
			[
				'label'   => __('Banner Tag', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'figure',
				'options' => [
					'figure'  => __('FIGURE', 'kata-plus'),
					'div'     => __('DIV', 'kata-plus'),
					'article' => __('ARTICLE', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'banner_link',
			[
				'label'         => __('Banner Link', 'kata-plus'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __('https://your-link.com', 'kata-plus'),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'image',
			[
				'label' => esc_html__('Image', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'image_tag',
			[
				'label'   => __('Image Wrapper Tag', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'figure'  => __('FIGURE', 'kata-plus'),
					'div'     => __('DIV', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'img',
			[
				'label'   => __('Choose your desired photo', 'kata-plus'),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'img_size',
			[
				'label'       => __('Image Dimension', 'kata-plus'),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __('Crop the original image size.', 'kata-plus'),
				'default'     => [
					'width'  => '',
					'height' => '',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'description',
			[
				'label' => esc_html__('Description', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'description_tag',
			[
				'label'   => __('Description Tag', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'figcaption'  => __('Figcaption', 'kata-plus'),
					'div'         => __('Div', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'banner_title',
			[
				'label'       => __('Title', 'kata-plus'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __('Type your title here', 'kata-plus'),
				'default'     => __('Title', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'banner_title_tag',
			[
				'label'   => __('Title Tag', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1'   => __('H1', 'kata-plus'),
					'h2'   => __('H2', 'kata-plus'),
					'h3'   => __('H3', 'kata-plus'),
					'h4'   => __('H4', 'kata-plus'),
					'h5'   => __('H5', 'kata-plus'),
					'h6'   => __('H6', 'kata-plus'),
					'h6'   => __('H6', 'kata-plus'),
					'p'    => __('P', 'kata-plus'),
					'span' => __('Span', 'kata-plus'),
					'cite' => __('Cite', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'banner_subtitle',
			[
				'label'       => __('Subtitle', 'kata-plus'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __('Type your subtitle here', 'kata-plus'),
				'default'     => __('Subtitle', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'banner_subtitle_tag',
			[
				'label'   => __('Subtitle Tag', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'p',
				'options' => [
					'h1'   => __('H1', 'kata-plus'),
					'h2'   => __('H2', 'kata-plus'),
					'h3'   => __('H3', 'kata-plus'),
					'h4'   => __('H4', 'kata-plus'),
					'h5'   => __('H5', 'kata-plus'),
					'h6'   => __('H6', 'kata-plus'),
					'h6'   => __('H6', 'kata-plus'),
					'p'    => __('P', 'kata-plus'),
					'span' => __('Span', 'kata-plus'),
					'cite' => __('Cite', 'kata-plus'),
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'button',
			[
				'label' => esc_html__('Button', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'banner_button_txt',
			[
				'label'       => __('Button Text ', 'kata-plus'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __('Button name', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'button_link',
			[
				'label'         => __('Button Link', 'kata-plus'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __('https://your-link.com', 'kata-plus'),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		$this->add_control(
			'banner_button_icon',
			[
				'label' => esc_html__('Button Icon', 'kata-plus'),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'shape',
			[
				'label' => esc_html__('Shape', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'shape_sk',
			[
				'name'		=> 'shape_sk',
				'label'		=> esc_html__('Shape style', 'kata-plus'),
				'type'		=> 'kata_styler',
				'selectors'	=> Kata_Styler::selectors('{{CURRENT_ITEM}}'),
			]
		);
		$this->add_control(
			'banner_shapes',
			[
				'label'  => esc_html__('Shapes', 'kata-plus'),
				'type'   => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__('Styler', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_banner_wrapper',
			[
				'label'            => 'Banner Wrapper',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-banner-wrap'),
			]
		);
		$this->add_control(
			'styler_image_box',
			[
				'label'            => 'Image Wrapper',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-banner-img'),
			]
		);
		$this->add_control(
			'styler_image',
			[
				'label'            => 'Image',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-banner-img img', '', '.kata-banner-wrap' ),
			]
		);
		$this->add_control(
			'styler_description_wrap',
			[
				'label'            => 'Description Box',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-banner-description'),
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'            => 'Title',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-banner-title'),
			]
		);
		$this->add_control(
			'styler_subtitle',
			[
				'label'            => 'Subtitle',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-banner-subtitle'),
			]
		);
		$this->add_control(
			'styler_button',
			[
				'label'            => 'Button',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-banner-button'),
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
			'styler_button_icon',
			[
				'label'            => 'Button Icon',
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-banner-button i'),
			]
		);
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render()
	{
		require dirname(__FILE__) . '/view.php';
	}
}
