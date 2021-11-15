<?php

/**
 * Icon Box module config.
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
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_IconBox extends Widget_Base {

	public function get_name() {
		return 'kata-plus-icon-box';
	}

	public function get_title() {
		return esc_html__('Icon Box', 'kata-plus');
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-icon-box';
	}

	public function get_script_depends() {
		return ['kata-jquery-enllax'];
	}

	public function get_categories() {
		return ['kata_plus_elementor_most_usefull'];
	}

	public function get_style_depends() {
		return ['kata-plus-icon-box'];
	}

	protected function register_controls()
	{
		// Content options Start
		$this->start_controls_section(
			'section_Tab_content',
			[
				'label' => esc_html__('Settings', 'kata-plus'),
			]
		);
		$this->add_control(
			'iconbox_layout',
			[
				'label'   => __('Layout', 'kata-plus'),
				'description'   => __('Set vertical or horizontal layout.', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __('Vertical', 'kata-plus'),
					'vertical'   => __('Horizontal', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'iconbox_aligne',
			[
				'label'   => __('Alignment', 'kata-plus'),
				'description'   => __('Set box alignment', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dfalt',
				'options' => [
					'dfalt' => __('Center', 'kata-plus'),
					'left'  => __('Left', 'kata-plus'),
					'right' => __('Right', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'iconbox_title',
			[
				'label'   => __('Title', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Your Title', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'iconbox_title_tag',
			[
				'label'   => __('Title Tag', 'kata-plus'),
				'description'   => __('Set a certain tag for title.', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => __('H1', 'kata-plus'),
					'h2'   => __('H2', 'kata-plus'),
					'h3'   => __('H3', 'kata-plus'),
					'h4'   => __('H4', 'kata-plus'),
					'h5'   => __('H5', 'kata-plus'),
					'h6'   => __('H6', 'kata-plus'),
					'p'    => __('p', 'kata-plus'),
					'span' => __('span', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'iconbox_subtitle',
			[
				'label'   => __('Subtitle', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Your Subtitle', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'iconbox_subtitle_tag',
			[
				'label'   => __('SubTitle Tag', 'kata-plus'),
				'description'   => __('Set a certain tag for subtitle.', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1'   => __('H1', 'kata-plus'),
					'h2'   => __('H2', 'kata-plus'),
					'h3'   => __('H3', 'kata-plus'),
					'h4'   => __('H4', 'kata-plus'),
					'h5'   => __('H5', 'kata-plus'),
					'h6'   => __('H6', 'kata-plus'),
					'p'    => __('p', 'kata-plus'),
					'span' => __('span', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'iconbox_desc',
			[
				'label'   => __('Description', 'kata-plus'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'kata-plus'),
				'rows'    => 10,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'icon_box_list',
			[
				'label'        => esc_html__( 'List Content', 'kata-plus' ),
				'type'         => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'icon_box_lists',
			[
				'label'       	=> esc_html__( 'Add List', 'kata-plus' ),
				'description'	=> esc_html__( 'Add several individual items as list items.', 'kata-plus' ),
				'type'        	=> Controls_Manager::REPEATER,
				'fields'      	=> $repeater->get_controls(),
				'prevent_empty' => false,
				'title_field'	=> '{{{ icon_box_list }}}',
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __('Icon Source', 'kata-plus'),
				'description'   => __('Set icon source, Kata icons, custom image or custom svg', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => __('Kata Icons', 'kata-plus'),
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('SVG', 'kata-plus'),
				],
			]
		);
		$this->add_control(
			'iconbox_icon',
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
			'iconbox_image',
			[
				'label'     => __('Choose Image', 'kata-plus'),
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
				'name'      => 'iconbox_image',
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
			'iconbox_number',
			[
				'label'     => __('Number', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => __('1', 'kata-plus'),
				'condition' => [
					'symbol' => [
						'numberi',
					],
				],
			]
		);
		$this->add_control(
			'iconbox_link',
			[
				'label'         => __('Link', 'kata-plus'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __('https://your-link.com', 'kata-plus'),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);
		$this->add_control(
			'link_to_whole_wrapper',
			[
				'label'        => __('Make the Whole Wrapper Clickable', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('On', 'kata-plus'),
				'label_off'    => __('Off', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'linkcnt',
			[
				'label'   => __('Link Text', 'kata-plus'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Read More', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'link_icon',
			[
				'label' => esc_html__('Link Icon', 'kata-plus'),
				'type'  => 'kata_plus_icons',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'Parent',
			[
				'label' => esc_html__('Wrapper', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_container',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__('Content', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'svg_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('To style the SVGs please go to Style SVG tab.', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_icon_wrap',
			[
				'label'     => esc_html__('Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox-icon-wrap'),
			]
		);
		// $this->add_control(
		// 	'styler_icon_wrap_icon',
		// 	[
		// 		'label'     => esc_html__( 'Icon', 'kata-plus' ),
		// 		'type'      => 'kata_styler',
		// 		'selectors' => Kata_Styler::selectors( '.kata-plus-iconbox-icon-wrap .kata-icon' ),
		// 	]
		// );
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
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox-icon-wrap .kata-icon'),
				'condition' => [
					'symbol' => [
						'icon',
					],
				],
			]
		);
		$this->add_control(
			'styler_image_st',
			[
				'label'     => esc_html__('Image', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.imagei img'),
				'condition' => [
					'symbol' => [
						'imagei',
					],
				],
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'     => esc_html__('Content Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox .kata-plus-iconbox-cntt'),
				'condition' => [
					'iconbox_layout' => 'vertical',
				],
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'     => esc_html__('Title', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox [data-class="ck-icon-box-title"]'),
			]
		);
		$this->add_control(
			'styler_subtitle',
			[
				'label'     => esc_html__('Subtitle', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox [data-class="ck-icon-box-subtitle"]'),
			]
		);
		$this->add_control(
			'styler_desc',
			[
				'label'     => esc_html__('Description', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox [data-class="ck-icon-box-desc"]'),
			]
		);
		$this->add_control(
			'styler_desc_ul',
			[
				'label'     => esc_html__('List Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.icon-box-lists'),
			]
		);
		$this->add_control(
			'styler_desc_li',
			[
				'label'     => esc_html__('List Item', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.icon-box-list-item'),
			]
		);
		$this->add_control(
			'styler_rm',
			[
				'label'     => esc_html__('Read more', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox a[data-class="icon-box-readmore"]'),
			]
		);
		$this->add_control(
			'styler_rm_icon',
			[
				'label'     => esc_html__('Read more icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox a[data-class="icon-box-readmore"] i.kata-icon'),
			]
		);
		$this->add_control(
			'styler_rn',
			[
				'label'     => esc_html__('Number', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-plus-iconbox-icon-wrap.numberi p'),
				'condition' => [
					'symbol' => [
						'numberi',
					],
				],
			]
		);
		// Style options End
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_svg',
			[
				'label' => esc_html__('SVG', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'important_note2',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('Because certain SVGs use different tags for styling, you need to use the options below to style the uploaded SVG. They SVG tab in the Styler is there to do this.', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_icon_svg_wrapper',
			[
				'label'     => esc_html__('Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-svg-icon'),
			]
		);
		$this->add_control(
			'styler_icon_path',
			[
				'label'     => esc_html__('Path', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-svg-icon path'),
			]
		);
		$this->add_control(
			'styler_icon_rect',
			[
				'label'     => esc_html__('Rect', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-svg-icon rect'),
			]
		);
		$this->add_control(
			'styler_icon_line',
			[
				'label'     => esc_html__('Line', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-svg-icon line'),
			]
		);
		$this->add_control(
			'styler_icon_circel',
			[
				'label'     => esc_html__('Circle', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-svg-icon circle'),
			]
		);
		$this->add_control(
			'styler_icon_ellipse',
			[
				'label'     => esc_html__('Ellipse', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-svg-icon ellipse'),
			]
		);
		// Style options End
		$this->end_controls_section();

		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render()
	{
		require dirname(__FILE__) . '/view.php';
	}
}
