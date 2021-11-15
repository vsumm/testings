<?php
/**
 * Social Share config.
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

class Kata_Social_Share extends Widget_Base {
	public function get_name() {
		return 'kata-plus-social-share';
	}

	public function get_title() {
		return esc_html__( 'Social Share', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-social-share';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_blog_and_post' ];
	}

	public function get_script_depends() {
		return [ 'kata-social-share' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-social-share' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Social Share', 'kata-plus' ),
			]
		);
		$this->add_control(
			'mode',
			[
				'label'    => __( 'Mode', 'kata-plus' ),
				'type'     => Controls_Manager::SELECT,
				'multiple' => true,
				'options'  => [
					'kt-social-normal'	=> __( 'Normal', 'kata-plus' ),
					'kt-social-sticky'	=> __( 'Sticky', 'kata-plus' ),
				],
				'default'  => 'kt-social-normal',
			]
		);
		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'kata-plus' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'shared_count',
			[
				'label'        => __( 'Share Count', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'socials',
			[
				'label'    => __( 'Socials', 'kata-plus' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => [
					'facebook'	=> __( 'Facebook', 'kata-plus' ),
					'twitter'	=> __( 'Twitter', 'kata-plus' ),
					'linkedin'	=> __( 'Linkedin', 'kata-plus' ),
					'reddit'	=> __( 'Reddit', 'kata-plus' ),
					'pinterest'	=> __( 'Pinterest', 'kata-plus' ),
					'email'		=> __( 'Email', 'kata-plus' ),
				],
				'default'  => [ 'facebook', 'twitter', 'linkedin' ],
			]
		);
		$this->add_control(
			'icon_image',
			[
				'label' => __( 'Image or icon', 'kata-plus' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'  => __( 'Icon', 'kata-plus' ),
					'image' => __( 'Image', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'custom_dimension',
			[
				'label' => __( 'Image Dimension', 'kata-plus' ),
				'type' => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'kata-plus' ),
				'default' => [
					'width' => '50',
					'height' => '50',
				],
				'condition' => [
					'icon_image' => 'image',
				],
			]
		);
		$this->add_control(
			'facebook_icon',
			[
				'label' => esc_html__( 'Facebook Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
				'default' => 'themify/facebook',
				'condition' => [
					'socials'    => 'facebook',
					'icon_image' => 'icon',
				],
			]
		);
		$this->add_control(
			'facebook_image',
			[
				'label' => __( 'Facebook', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'socials'    => 'facebook',
					'icon_image' => 'image',
				],
			]
		);
		$this->add_control(
			'twitter_icon',
			[
				'label' => esc_html__( 'Twitter Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
				'default' => 'themify/twitter',
				'condition' => [
					'socials'    => 'twitter',
					'icon_image' => 'icon',
				],
			]
		);
		$this->add_control(
			'twitter_image',
			[
				'label' => __( 'Twitter', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'socials'    => 'twitter',
					'icon_image' => 'image',
				],
			]
		);
		$this->add_control(
			'linkedin_icon',
			[
				'label' => esc_html__( 'Linkedin Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
				'default' => 'themify/linkedin',
				'condition' => [
					'socials'    => 'linkedin',
					'icon_image' => 'icon',
				],
			]
		);
		$this->add_control(
			'linkedin_image',
			[
				'label' => __( 'Linkedin', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'socials'    => 'linkedin',
					'icon_image' => 'image',
				],
			]
		);
		$this->add_control(
			'pinterest_icon',
			[
				'label' => esc_html__( 'Pinterest Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
				'default' => 'themify/pinterest',
				'condition' => [
					'socials'    => 'pinterest',
					'icon_image' => 'icon',
				],
			]
		);
		$this->add_control(
			'pinterest_image',
			[
				'label' => __( 'Pinterest', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'socials'    => 'pinterest',
					'icon_image' => 'image',
				],
			]
		);
		$this->add_control(
			'reddit_icon',
			[
				'label' => esc_html__( 'Reddit Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
				'default' => 'themify/reddit',
				'condition' => [
					'socials'    => 'reddit',
					'icon_image' => 'icon',
				],
			]
		);
		$this->add_control(
			'reddit_image',
			[
				'label' => __( 'Reddit', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'socials'    => 'reddit',
					'icon_image' => 'image',
				],
			]
		);
		$this->add_control(
			'email_icon',
			[
				'label' => esc_html__( 'Email Icon', 'kata-plus' ),
				'type'  => 'kata_plus_icons',
				'default' => 'themify/email',
				'condition' => [
					'socials'    => 'email',
					'icon_image' => 'icon',
				],
			]
		);
		$this->add_control(
			'email_image',
			[
				'label' => __( 'Email', 'kata-plus' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'socials'    => 'email',
					'icon_image' => 'image',
				],
			]
		);
		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'parent_shape',
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
		    	'selectors' => Kata_Styler::selectors( '.kata-social-share' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__( 'Social Share', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
			'styler_socials_wrapper',
			[
				'label'     => esc_html__( 'Socials Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-socials-icon-wrapper' ),
			]
		);
		$this->add_control(
			'styler_socials_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-social-share-title' ),
			]
		);
		$this->add_control(
			'styler_socials_share_count',
			[
				'label'     => esc_html__( 'Share Count', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-post-share-count' ),
			]
		);
		$this->add_control(
			'styler_link',
			[
				'label'     => esc_html__( 'Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-socials-icon-wrapper > a' ),
			]
		);
		$this->add_control(
			'styler_icons',
			[
				'label'     => esc_html__( 'Icons', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-socials-icon-wrapper > a .kata-icon' ),
				'condition' => [
					'icon_image' => 'icon',
				]
			]
		);
		$this->add_control(
			'styler_facebook',
			[
				'label'     => esc_html__( 'Facebook Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-facebook .kata-icon' ),
				'condition' => [
					'icon_image' => 'icon',
				]
			]
		);
		$this->add_control(
			'styler_reddit',
			[
				'label'     => esc_html__( 'Reddit Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-reddit .kata-icon' ),
				'condition' => [
					'icon_image' => 'icon',
				]
			]
		);
		$this->add_control(
			'styler_pinterest',
			[
				'label'     => esc_html__( 'Pinterest Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-pinterest .kata-icon' ),
				'condition' => [
					'icon_image' => 'icon',
				]
			]
		);
		$this->add_control(
			'styler_twitter',
			[
				'label'     => esc_html__( 'Twitter Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-twitter .kata-icon' ),
				'condition' => [
					'icon_image' => 'icon',
				]
			]
		);
		$this->add_control(
			'styler_linkedin',
			[
				'label'     => esc_html__( 'Linkedin Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-linkedin .kata-icon' ),
				'condition' => [
					'icon_image' => 'icon',
				]
			]
		);
		$this->add_control(
			'styler_email',
			[
				'label'     => esc_html__( 'Email Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-email .kata-icon' ),
				'condition' => [
					'icon_image' => 'icon',
				]
			]
		);
		$this->add_control(
			'styler_facebook_image',
			[
				'label'     => esc_html__( 'Facebook image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-facebook img' ),
				'condition' => [
					'icon_image' => 'image',
				]
			]
		);
		$this->add_control(
			'styler_twitter_image',
			[
				'label'     => esc_html__( 'Twitter image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-twitter img' ),
				'condition' => [
					'icon_image' => 'image',
				]
			]
		);
		$this->add_control(
			'styler_linkedin_image',
			[
				'label'     => esc_html__( 'Linkedin image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-linkedin img' ),
				'condition' => [
					'icon_image' => 'image',
				]
			]
		);
		$this->add_control(
			'styler_email_image',
			[
				'label'     => esc_html__( 'Email image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-email img' ),
				'condition' => [
					'icon_image' => 'image',
				]
			]
		);
		$this->add_control(
			'styler_reddit_image',
			[
				'label'     => esc_html__( 'Reddit image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-reddit img' ),
				'condition' => [
					'icon_image' => 'image',
				]
			]
		);
		$this->add_control(
			'styler_pinterest_image',
			[
				'label'     => esc_html__( 'Pinterest image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-social-share-pinterest img' ),
				'condition' => [
					'icon_image' => 'image',
				]
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
