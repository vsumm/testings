<?php
/**
 * Instagram module config.
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

class Kata_Plus_Pro_Instagram extends Widget_Base {
	public function get_name() {
		return 'kata-plus-instagram';
	}

	public function get_title() {
		return esc_html__( 'Instagram', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-owlcarousel', 'kata-plus-owl' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-owlcarousel', 'kata-plus-owl', 'kata-plus-instagram' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'get_access_token',
			[
				'label'			=> __( 'Get Access Token', 'kata-plus' ),
				'type'			=> Controls_Manager::RAW_HTML,
				'separator'		=> 'before',
				'raw'			=> '<a href="' . Kata_Plus_Pro_Instagram_API::$api_url . '" class="elementor-button elementor-button-success" target="_blank">' . __('Get Access Token', 'kata-plus') . '</a><div class="elementor-control-field-description">Before click on the GET ACCESS TOKEN button read the <a href="https://climaxthemes.com/kata/documentation/instagram/" target="_blank">' . __('Instagram Document', 'kata-plus') . '</a></div>',
			]
		);
		$this->add_control(
			'download_images',
			[
				'label'			=> __('Clear Instagram Cache', 'kata-plus'),
				'type'			=> Controls_Manager::BUTTON,
				'separator'		=> 'before',
				'button_type'	=> 'success',
				'text'			=> __('Clear Cache', 'kata-plus'),
				'description'	=> __('By click on clear cache button, images will be download Again on your server, then instagram widget is able to use local images.', 'kata-plus'),
				'event'			=> 'clearinstagramcache',
			]
		);
		$this->add_control(
			'access_token', // param_name
			[
				'label'			=> esc_html__('Access Token', 'kata-plus'), // heading
				'type'			=> Controls_Manager::TEXTAREA, // type
				'description'	=> esc_html__('By Click on Get Access Token Button you will get your Access Token', 'kata-plus'),
			]
		);
		$this->add_control(
			'update_images',
			[
				'label'		=> __('View', 'kata-plus'),
				'type'		=> Controls_Manager::HIDDEN,
				'default'	=> 'update',
			]
		);
		$this->add_control(
			'carousel',
			[
				'label'        => esc_html__( 'Carousel', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'kata-plus' ),
				'label_off'    => esc_html__( 'Off', 'kata-plus' ),
				'return_value' => 'on',
				'default'      => 'off',
			]
		);
		$this->add_control(
			'post_count',
			[
				'label'   => esc_html__( 'Number Of Post', 'kata-plus' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 9,
				'min'     => 1,
				'max'     => 10000000,
				'step'    => 1,
			]
		);
		$this->add_control(
			'hashtag', // param_name
			[
				'label'			=> esc_html__('Enter Specefic Hashtag to show', 'kata-plus'), // heading
				'type'			=> Controls_Manager::TEXT, // type
				'placeholder'	=> esc_html( '#cmx_kata_fashion_blog', 'kata-plus' ),
				'description'	=> esc_html__( 'Enter hashtag using #. For example: #cmx_kata_fashion_blog', 'kata-plus' ),
			]
		);

		// Show description
		$this->add_control(
			'show_description',
			[
				'label'        => __( 'Show Caption', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'show',
				'default'      => 'hide',
			]
		);

		$this->add_control(
			'description_length',
			[
				'label'      => __( 'Description length', 'kata-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'condition'  => [
					'show_description' => 'show',
				],
			]
		);
		$this->add_responsive_control(
			'column',
			[
				'label'   => __( 'Column', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'1'       => __( 'One', 'kata-plus' ),
					'2'       => __( 'Two', 'kata-plus' ),
					'3'       => __( 'Three', 'kata-plus' ),
					'4'       => __( 'Four', 'kata-plus' ),
					'5'       => __( 'Five', 'kata-plus' ),
					'6'       => __( 'Six', 'kata-plus' ),
					'default' => __( 'Default', 'kata-plus' ),
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default'	=> '4',
				'tablet_default'	=> '2',
				'mobile_default'	=> '1',
			]
		);
		$this->add_control(
			'link_to_post',
			[
				'label'        => esc_html__( 'Link the image to instagram\'s post', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'kata-plus' ),
				'label_off'    => esc_html__( 'Off', 'kata-plus' ),
				'return_value' => 'on',
				'default'      => 'on',
			]
		);
		$this->add_control(
			'target_blank',
			[
				'label'        => esc_html__( 'Open links in new tab', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'kata-plus' ),
				'label_off'    => esc_html__( 'Off', 'kata-plus' ),
				'return_value' => 'on',
				'default'      => 'on',
				'condition'    => [ // dependency
					'link_to_post' => [ 'on' ],
				],
			]
		);
		$this->add_control(
			'custom_icon',
			[
				'label'        => esc_html__( 'Custom icon', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'show',
				'default'      => 'hide',
			]
		);
		$this->add_control(
			'overlay_style',
			[
				'label'        => esc_html__( 'Overlay', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'show',
				'default'      => 'hide',
			]
		);
		$this->add_control(
			'overlay_active',
			[
				'label'        => esc_html__( 'Overlay', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'show',
				'default'      => 'hide',
			]
		);
		$this->add_control(
			'icon',
			[
				'label'     => __( 'Select Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'font-awesome/arrow-right',
				'condition' => [ // dependency
					'custom_icon' => [ 'show' ],
				],
			]
		);
		$this->end_controls_section();

		// owl option
		$this->start_controls_section(
			'carousel_section',
			[
				'label'     => esc_html__( 'Carousel Settings', 'kata-plus' ),
				'condition' => [ // dependency
					'carousel' => [ 'on' ],
				],
			]
		);
		$this->add_responsive_control(
			'inc_owl_item',
			[
				'label'       => __( 'Items Per View', 'kata-plus' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 20,
				'step'        => 1,
				'default'     => 3,
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'description' => __( 'Varies between 1/5', 'kata-plus' ),
			]
		);
		$this->add_control(
			'inc_owl_spd',
			[
				'label'       => __( 'Slide Speed', 'kata-plus' ),
				'description' => __( 'Varies between 500/6000', 'kata-plus' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 500,
						'max'  => 6000,
						'step' => 1,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 5000,
				],
			]
		);
		$this->add_control(
			'inc_owl_smspd',
			[
				'label'       => __( 'Smart Speed', 'kata-plus' ),
				'description' => __( 'Varies between 500/6000', 'kata-plus' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 500,
						'max'  => 6000,
						'step' => 1,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 1000,
				],
			]
		);
		$this->add_responsive_control(
			'inc_owl_stgpad',
			[
				'label'       => __( 'Stage Padding', 'kata-plus' ),
				'description' => __( 'Varies between 0/400', 'kata-plus' ),
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 400,
						'step' => 1,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 0,
				],
			]
		);
		$this->add_responsive_control(
			'inc_owl_margin',
			[
				'label'       => __( 'Margin', 'kata-plus' ),
				'description' => __( 'Varies between 0/400', 'kata-plus' ),
				'devices'     => [ 'desktop', 'tablet', 'mobile' ],
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [
						'min'  => 0,
						'max'  => 400,
						'step' => 1,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 20,
				],
			]
		);
		$this->add_control(
			'inc_owl_arrow',
			[
				'label'        => __( 'Prev/Next Arrows', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->add_control(
			'inc_owl_prev',
			[
				'label'     => __( 'Left Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'font-awesome/angle-left',
				'condition' => [
					'inc_owl_arrow' => [
						'true',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_nxt',
			[
				'label'     => __( 'Right Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => 'font-awesome/angle-right',
				'condition' => [
					'inc_owl_arrow' => [
						'true',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_pag',
			[
				'label'        => __( 'Pagination', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'no',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->add_control(
			'inc_owl_pag_num',
			[
				'label'        => __( 'Change To Number', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'no',
				'condition'    => [
					'inc_owl_pag' => [
						'true',
					],
				],
			]
		);
		$this->add_control(
			'inc_owl_loop',
			[
				'label'        => __( 'Slider loop', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'true',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->add_control(
			'inc_owl_autoplay',
			[
				'label'        => __( 'Autoplay', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'true',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->add_control(
			'inc_owl_center',
			[
				'label'        => __( 'Center Item', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'false',
				'default'      => 'no',
				'devices'      => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->add_control(
			'inc_owl_rtl',
			[
				'label'        => __( 'RTL', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'inc_owl_vert',
			[
				'label'        => __( 'Vertical Slider', 'kata-plus' ),
				'description'  => __( 'This option works only when "Items Per View" is set to 1.', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'true',
				'default'      => 'false',
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'parent_instagram',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_widget_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram' ),
			]
		);
		$this->add_control(
			'styler_widget_wrapper_carousel_stage',
			[
				'label'     => esc_html__( 'Carousel Stage', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.owl-stage-outer' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Instagram', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_overlay',
			[
				'label'     => __( 'Overlay', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram .instagram-lc-wrap' ),
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'     => __( 'Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram li' ),
			]
		);
		$this->add_control(
			'styler_img_wrapper',
			[
				'label'     => __( 'Image Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram li a' ),
			]
		);
		$this->add_control(
			'styler_img',
			[
				'label'     => __( 'Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram li img' ),
			]
		);
		$this->add_control(
			'styler_description_wrapper',
			[
				'label'     => __( 'Caption', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.instagram-description-sec' ),
			]
		);
		$this->add_control(
			'styler_description',
			[
				'label'     => __( 'Description', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.instagram-description-sec .instagram-description' ),
			]
		);
		$this->add_control(
			'styler_icon',
			[
				'label'     => __( 'Custom icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram .instagram-ci-sec .kata-icon' ),
				'condition' => [
					'custom_icon' => [
						'show',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'custom_carousel_section',
			[
				'label'     => esc_html__( 'Carousel', 'kata-plus' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'carousel' => [ 'on' ],
				],
			]
		);
		$this->add_control(
			'styler_arrow_left',
			[
				'label'     => __( 'Left Arrow', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram .owl-nav .owl-prev i' ),
			]
		);
		$this->add_control(
			'styler_arrow_right',
			[
				'label'     => __( 'Right Arrow', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram .owl-nav .owl-next i' ),
			]
		);
		$this->add_control(
			'styler_boolets',
			[
				'label'     => __( 'Pagination', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram .owl-dots .owl-dot' ),
			]
		);
		$this->add_control(
			'styler_boolets_active',
			[
				'label'     => __( 'Active Pagin', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-instagram .owl-dots .owl-dot.active' ),
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
