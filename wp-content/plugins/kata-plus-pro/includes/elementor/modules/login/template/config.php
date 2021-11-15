<?php
/**
 * Login module config.
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
use Elementor\Group_Control_Image_Size;
class Kata_Plus_Pro_Login extends Widget_Base {
	public function get_name() {
		return 'kata-plus-login';
	}

	public function get_title() {
		return esc_html__( 'Login', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-lock-user';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_header' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-login' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-login' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_text_content',
			[
				'label' => esc_html__( 'login Settings', 'kata-plus' ),
			]
		);
		$this->add_control(
			'livelogin',
			[
				'label'        => __( 'Live Login', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'kata-plus' ),
				'label_off'    => __( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'layout',
			[
				'label' 		=> __( 'Layout', 'kata-plus' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'simple',
				'options' 		=> [
					'simple' => __( 'Simple', 'kata-plus' ),
					'modal'  => __( 'Modal', 'kata-plus' ),
					'toggle' => __( 'Toggle', 'kata-plus' ),
				],
			]
		);
		$this->add_control(
			'custom_dashboard_link',
			[
				'label'     => esc_html__('Custom Dashboard Link', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'custom_profile_link',
			[
				'label'     => esc_html__('Custom Profile Link', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'text',
			[
				'label'     => esc_html__('Modal Placeholder', 'kata-plus'),
				'type'      => Controls_Manager::TEXT,
				'default'   => __('Login', 'kata-plus'),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'welcom_text',
			[
				'label'     => esc_html__( 'Placeholder After Login', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'welcome', 'kata-plus' ),
				'description' => __( 'To show username use {{username}}' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'toggleplaceholder',
			[
				'label'		=> __('Icon Type', 'kata-plus'),
				'type'		=> Controls_Manager::CHOOSE,
				'default'	=> 'placeholder_icon',
				'toggle'	=> true,
				'options'	=> [
					'image'	=> [
						'title'	=> __('Image', 'kata-plus'),
						'icon'	=> 'fa fa-image',
					],
					'placeholder_icon'	=> [
						'title'	=> __('Icon', 'kata-plus'),
						'icon'	=> 'fas fa-icons',
					],
				],
				'condition' => [
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label'   => __('Image/SVG', 'kata-plus'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'imagei',
				'options' => [
					'imagei' => __('Image', 'kata-plus'),
					'svg'    => __('Svg', 'kata-plus'),
				],
				'condition' => [
					'toggleplaceholder' => [
						'image',
					],
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'image',
			[
				'label'   => __('Choose Image', 'kata-plus'),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'toggleplaceholder' => [
						'image', 'svg',
					],
					'layout!' => 'simple'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default'   => 'large',
				'separator' => 'none',
				'condition' => [
					'toggleplaceholder' => [
						'image',
					],
					'layout!' => 'simple'
				],
			]
		);
		$this->add_control(
			'placeholder_icon',
			[
				'label'     => esc_html__('Icon', 'kata-plus'),
				'type'      => 'kata_plus_icons',
				'default'   => 'themify/lock',
				'condition' => [
					'toggleplaceholder' => [
						'placeholder_icon',
					],
					'layout!' => 'simple'
				],
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
			'styler_wrap',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap' ),
			]
		);
		$this->add_control(
			'styler_labels',
			[
				'label'     => esc_html__( 'Lables', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap label' ),
			]
		);
		$this->add_control(
			'styler_userpasinput',
			[
				'label'     => esc_html__( 'Username Input', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap input[type="text"]' ),
			]
		);
		$this->add_control(
			'styler_pasinput',
			[
				'label'     => esc_html__( 'Password Input', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap input[type="password"]' ),
			]
		);
		$this->add_control(
			'styler_login',
			[
				'label'     => esc_html__( 'Login Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap .submit_button' ),
			]
		);
		$this->add_control(
			'styler_lost',
			[
				'label'     => esc_html__( 'Lost Password', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap .lost' ),
			]
		);
		$this->add_control(
			'styler_avatar',
			[
				'label'     => esc_html__( 'Avatar Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap .avatar' ),
			]
		);
		$this->add_control(
			'styler_avatar_image',
			[
				'label'     => esc_html__( 'Avatar Thumbnail', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap .avatar img' ),
			]
		);
		$this->add_control(
			'styler_welcome',
			[
				'label'     => esc_html__( 'Welcome', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap .user-name' ),
			]
		);
		$this->add_control(
			'styler_loginbtns',
			[
				'label'     => esc_html__( 'Logged-in Buttons', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-login-wrap .login-btns .kata-button' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_placeholder',
			[
				'label' => esc_html__( 'Modal Placeholder', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_place_holder_wrapper',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-login-open-as' ),
			]
		);
		$this->add_control(
			'styler_place_holder_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-toggle-wrapper .kata-icon' ),
			]
		);
		$this->add_control(
			'styler_place_holder_image',
			[
				'label'     => esc_html__( 'Image', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-toggle-wrapper img' ),
			]
		);
		$this->add_control(
			'styler_place_holder_text',
			[
				'label'     => esc_html__( 'Text', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kt-login-open-as .kt-login-toggle-text' ),
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
