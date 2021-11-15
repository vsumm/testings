<?php
/**
 * Gallery module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
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

class Kata_Plus_Gallery extends Widget_Base {
	public function get_name() {
		return 'kata-plus-gallery';
	}

	public function get_title() {
		return __( 'Gallery', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-gallery';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_most_usefull' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-gallery' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_gallery',
			[
				'label' => __( 'Image Gallery', 'kata-plus' ),
			]
		);
		$this->add_control(
			'wp_gallery',
			[
				'label' => __( 'Add Images', 'kata-plus' ),
				'type' => Controls_Manager::GALLERY,
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'separator' => 'none',
			]
		);
		$gallery_columns = range( 1, 10 );
		$gallery_columns = array_combine( $gallery_columns, $gallery_columns );
		$this->add_control(
			'gallery_columns',
			[
				'label' => __( 'Columns', 'kata-plus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 4,
				'options' => $gallery_columns,
			]
		);
		$this->add_control(
			'gallery_link',
			[
				'label' => __( 'Link', 'kata-plus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'file',
				'options' => [
					'file' => __( 'Media File', 'kata-plus' ),
					'attachment' => __( 'Attachment Page', 'kata-plus' ),
					'none' => __( 'None', 'kata-plus' ),
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
				'condition' => [
					'gallery_link' => 'none'
				]
			]
		);
		$this->add_control(
			'external_url',
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
				'condition' => [
					'link_to_whole_wrapper' => 'yes'
				]
			]
		);
		$this->add_control(
			'open_lightbox',
			[
				'label' => __( 'Lightbox', 'kata-plus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'kata-plus' ),
					'yes' => __( 'Yes', 'kata-plus' ),
					'no' => __( 'No', 'kata-plus' ),
				],
				'condition' => [
					'gallery_link' => 'file',
				],
			]
		);
		$this->add_control(
			'gallery_rand',
			[
				'label' => __( 'Order By', 'kata-plus' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'kata-plus' ),
					'rand' => __( 'Random', 'kata-plus' ),
				],
				'default' => '',
			]
		);
		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'kata-plus' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_caption',
			[
				'label' => __( 'Caption', 'kata-plus' ),
			]
		);
		$this->add_control(
			'gallery_display_caption',
			[
				'label' => __( 'Display', 'kata-plus' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Show', 'kata-plus' ),
					'none' => __( 'Hide', 'kata-plus' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'display: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'align',
			[
				'label' => __( 'Alignment', 'kata-plus' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'kata-plus' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'kata-plus' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'kata-plus' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'kata-plus' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => '',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_gallery_images',
			[
				'label' => __( 'Gallery', 'kata-plus' ),
			]
		);
		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'kata-plus' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'kata-plus' ),
					'custom' => __( 'Custom', 'kata-plus' ),
				],
				'prefix_class' => 'gallery-spacing-',
				'default' => '',
			]
		);
		$columns_margin = is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';
		$columns_padding = is_rtl() ? '0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};' : '0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;';
		$this->add_control(
			'image_spacing_custom',
			[
				'label' => __( 'Image Spacing', 'kata-plus' ),
				'type' => Controls_Manager::SLIDER,
				'show_label' => false,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item' => 'padding:' . $columns_padding,
					'{{WRAPPER}} .gallery' => 'margin: ' . $columns_margin,
				],
				'condition' => [
					'image_spacing' => 'custom',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'imge_gallery_wrapper_style',
			[
				'label' => __( 'Gallery', 'kata-plus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_image_gallery_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-image-gallery' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'imge_gallery_item_style',
			[
				'label' => __( 'Items', 'kata-plus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_image_gallery_item_wrapper',
			[
				'label'     => esc_html__( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.gallery-item' ),
			]
		);
		$this->add_control(
			'styler_image_gallery_image_wrapper',
			[
				'label'     => esc_html__( 'Image Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.gallery-icon' ),
			]
		);
		$this->add_control(
			'styler_image_gallery_image',
			[
				'label'     => esc_html__( 'Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.gallery-icon img' ),
			]
		);
		$this->add_control(
			'styler_image_caption_image',
			[
				'label'     => esc_html__( 'Caption', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.gallery-caption' ),
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
