<?php
/**
 * Team Member module config.
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
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Team_Member extends Widget_Base {
	public function get_name() {
		return 'kata-plus-team-member';
	}

	public function get_title() {
		return esc_html__( 'Team', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-person';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-team-member', 'kata-plus-tilt' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-team-member' ];
	}

	protected function register_controls() {
		$args        = array(
			'orderby'     => 'date',
			'order'       => 'DESC',
			'post_type'   => 'kata_team_member',
			'post_status' => 'publish',
		);
		$posts_array = get_posts( $args );
		if ( ! empty( $posts_array ) ) {
			$post_names = $post_ids = array( '' );
			foreach ( $posts_array as $post_array ) {
				$post_names[] = $post_array->post_title;
				$post_ids[]   = $post_array->ID;
			}
			$posts_array = array_combine( $post_ids, $post_names );
		} else {
			$posts_array = array();
		}

		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'Team Member Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'team_source',
			[
				'label'        => __( 'Read from Team Member post type', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'posts_array',
			[
				'label'     => esc_html__( 'Select Posts', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'multiple'  => true,
				'options'   => $posts_array,
				'condition' => [
					'team_source' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'column',
			[
				'label'     => __( 'Columns', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT2,
				'options'   => [
					'col-md-12' => __( 'One Column', 'kata-plus' ),
					'col-md-6' => __( 'Two Columns', 'kata-plus' ),
					'col-md-4' => __( 'Three Columns', 'kata-plus' ),
					'col-md-3' => __( 'For Columns', 'kata-plus' ),
				],
				'default'   => 1,
				'condition' => [
					'team_source' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'kata-plus' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'team_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'team_source!' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'team_image_overlay',
			[
				'label'        => __( 'Image Overlay', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'team_name',
			[
				'label'       => __( 'Name', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Write your team name', 'kata-plus' ),
				'default'     => 'Jane Smith',
				'condition' => [
					'team_source!' => [
						'yes',
					],
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'team_job',
			[
				'label'       => __( 'Position', 'kata-plus' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Write your team job', 'kata-plus' ),
				'default'     => 'Developer',
				'condition'   => [
					'team_source!' => [
						'yes',
					],
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'team_desc',
			[
				'label'       => __( 'Description', 'kata-plus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Write your description job', 'kata-plus' ),
				'condition'   => [
					'team_source!' => [
						'yes',
					],
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'team_link_type',
			[
				'label'   => __( 'Select link type', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'wrap'  => __( 'Wrapper', 'kata-plus' ),
					'title' => __( 'Title', 'kata-plus' ),
					'more'  => __( 'Read More', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'custom_text_readmore',
			[
				'label'     => __( 'Button Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Read More',
				'condition' => [
					'team_link_type' => [
						'more',
					],
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'team_link_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'team_link_type' => 'more',
				],
			]
		);
		$this->add_control(
			'icon_position',
			[
				'label'     => esc_html__( 'Button Icon Position', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'before' => esc_html__( 'Before', 'kata-plus' ),
					'after'  => esc_html__( 'After', 'kata-plus' ),
				],
				'default'   => 'after',
				'condition' => [
					'team_link_icon!'	=> '',
					'team_link_type'	=> 'more',
				],
			]
		);
		$this->add_control(
			'team_url',
			[
				'label' => __( 'Enter team member URL', 'kata-plus' ),
				'type'  => Controls_Manager::URL,
				'condition' => [
					'team_source!' => [
						'yes',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_tilt_effect',
			[
				'label' => esc_html__( 'Tilt Effect', 'kata-plus' ),
			]
		);
		$this->add_control(
			'team_tilt_effect',
			[
				'label'        => __( 'Tilt effect', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'team_tilt_effect_glare',
			[
				'label'     => __( 'MaxGlare', 'kata-plus' ),
				'type'      	=> Controls_Manager::NUMBER,
				'min'       	=> 0,
				'max'       	=> 1,
				'step'      	=> 0.1,
				'default'   	=> 0.2,
				'description'   => __( 'From 0 - 1', 'kata-plus' ),
				'condition' => [
					'team_tilt_effect' => [
						'yes',
					],
				],
			]
		);
		$this->add_control(
			'team_tilt_effect_scale',
			[
				'label'     	=> __( 'Scale', 'kata-plus' ),
				'type'      	=> Controls_Manager::NUMBER,
				'min'       	=> 0.1,
				'max'       	=> 2,
				'step'      	=> 0.1,
				'default'   	=> 1.1,
				'description'   => __( '2 = 200%, 1.5 = 150%, etc..', 'kata-plus' ),
				'condition' => [
					'team_tilt_effect' => [
						'yes',
					],
				],
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
			'add_shape',
			[
				'label'     => esc_html__( 'Element', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}}' ),
			]
		);
		$this->add_control(
			'shape',
			[
				'label'       => esc_html__( 'Element', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_social',
			[
				'label'     => esc_html__( 'Social Settings', 'kata-plus' ),
				'condition' => [
					'team_source!' => [
						'yes',
					],
				],
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'team_social_icon',
			[
				'label'   => __( 'Icon', 'kata-plus' ),
				'type'    => 'kata_plus_icons',
				'default' => 'font-awesome/facebook',
			]
		);
		$repeater->add_control(
			'team_social_name',
			[
				'label'   => __( 'Name', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Facebook', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'current_icon_wrapper_styler',
			[
				'label'     => __('Icon Wrapper', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('{{CURRENT_ITEM}}'),
			]
		);
		$repeater->add_control(
			'current_icon_styler',
			[
				'label'     => __('Icon', 'kata-plus'),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('{{CURRENT_ITEM}} i'),
			]
		);
		$repeater->add_control(
			'team_social_link',
			[
				'label'         => __( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://facebook.com', 'kata-plus' ),
				'show_external' => true,
				'default'       => [
					'url'         => 'https://facebook.com',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);
		$this->add_control(
			'team_socials',
			[
				'label'       	=> __( 'Socials', 'kata-plus' ),
				'type'        	=> Controls_Manager::REPEATER,
				'fields'      	=> $repeater->get_controls(),
				'prevent_empty' => false,
				'default'     => [
					[
						'team_social_icon' => 'font-awesome/facebook',
						'team_social_name' => __( 'Facebook', 'kata-plus' ),
						'team_social_link' => __( 'https://facebook.com', 'kata-plus' ),
					],
					[
						'team_social_icon' => 'font-awesome/instagram',
						'team_social_name' => __( 'Instagram', 'kata-plus' ),
						'team_social_link' => __( 'https://instagram.com', 'kata-plus' ),
					],
					[
						'team_social_icon' => 'font-awesome/twitter',
						'team_social_name' => __( 'Twitter', 'kata-plus' ),
						'team_social_link' => __( 'https://twitter.com', 'kata-plus' ),
					],

				],
				'title_field' => '{{{ team_social_name }}}',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_widget_parent',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_container',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member' ),
			]
		);
		$this->add_control(
			'styler_footer_wrapper',
			[
				'label'            => esc_html__( 'Socials&Button Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .team-member-footer' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_team_styling',
			[
				'label' => esc_html__( 'Team Style', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_img_wrapper',
			[
				'label'            => esc_html__( 'Image Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-team-member .kata-plus-team-img' ),
			]
		);
		$this->add_control(
			'styler_img',
			[
				'label'            => esc_html__( 'Image', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-team-member .kata-plus-team-img img' ),
			]
		);
		$this->add_control(
			'styler_team_image_overlay',
			[
				'label'		=> esc_html__( 'Image Overlay', 'kata-plus' ),
				'type'		=> 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.team-member-image-overlay' ),
				'condition' => [
					'team_image_overlay' => 'yes'
				]
			]
		);
		$this->add_control(
			'styler_content_wrapper',
			[
				'label'            => esc_html__( 'Content Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-team-member .kata-plus-team-memcontent' ),
			]
		);
		$this->add_control(
			'styler_name',
			[
				'label'            => esc_html__( 'Name', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .kata-plus-team-memcontent h4' ),
			]
		);
		$this->add_control(
			'styler_job',
			[
				'label'            => esc_html__( 'Position', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-team-member .kata-plus-team-memcontent h5' ),
			]
		);
		$this->add_control(
			'styler_desc',
			[
				'label'            => esc_html__( 'Description', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-plus-team-member .kata-plus-team-memcontent p' ),
			]
		);
		$this->add_control(
			'styler_button',
			[
				'label'            => esc_html__( 'Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .kt-team-member-button.team-member-url' ),
			]
		);
		$this->add_control(
			'styler_button_icon_wrapper',
			[
				'label'            => esc_html__( 'Button Icon Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .kt-team-member-button.team-member-url .kata-team-button-icon-wrapper' ),
				'condition' => [
					'team_link_icon!'	=> '',
					'team_link_type'	=> 'more',
				],
			]
		);
		$this->add_control(
			'styler_button_icon',
			[
				'label'            => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .kt-team-member-button.team-member-url .kata-icon' ),
				'condition' => [
					'team_link_icon!'	=> '',
					'team_link_type'	=> 'more',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_styling',
			[
				'label' => esc_html__( 'Socials Style', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_social_box',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .kata-plus-team-social' ),
			]
		);
		$this->add_control(
			'styler_social_a',
			[
				'label'            => esc_html__( 'Icon Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .kata-plus-team-social a' ),
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
			'styler_social_a_i',
			[
				'label'            => esc_html__( 'icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-team-member .kata-plus-team-social .kata-icon' ),
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
