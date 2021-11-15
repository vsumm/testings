<?php
/**
 * Courses module config.
 *
 * @teacher  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! class_exists( 'Kata_Plus_Pro_LP_Profile' ) ) {
	class Kata_Plus_Pro_LP_Profile extends Widget_Base {
		public function get_name() {
			return 'kata-plus-lp-profile';
		}

		public function get_title() {
			return esc_html__( 'Learn Perss Profile', 'kata-plus' );
		}

		public function get_icon() {
			return 'kata-widget kata-eicon-courses-courses';
		}

		public function get_categories() {
			return ['kata_plus_elementor_learnpress_course' ];
		}

		protected function register_controls() {
			// Settings
			$this->start_controls_section(
				'Settings_section',
				[
					'label' => esc_html__( 'Settings', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'icon_style_error',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __('With this widget you will be able to style Learn Press profile module with Kata Styler tool.', 'kata-plus'),
					'content_classes' => 'kata-plus-elementor-error',
				]
			);
			$this->end_controls_section();

			// Learn Perss Profile Style section
			//Wrapper
			$this->start_controls_section(
				'section_widget_parent',
				[
					'label' => esc_html__( 'Wrapper', 'kata-plus' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_wrapper',
				[
					'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-user-profile' ),
				]
			);
			$this->add_control(
				'styler_lp_profile_content_wrapper',
				[
					'label'            => esc_html__('Content Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#learn-press-profile-content'),
				]
			);
			$this->end_controls_section();

			//Header
			$this->start_controls_section(
				'header_style_section',
				[
					'label' => esc_html__('Header', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_header',
				[
					'label'            => esc_html__('Header', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#learn-press-profile-header'),
				]
			);
			$this->add_control(
				'styler_lp_profile_cover',
				[
					'label'            => esc_html__('Cover', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-profile-cover'),
				]
			);
			$this->add_control(
				'styler_lp_profile_avatar_wrapper',
				[
					'label'            => esc_html__('Avatar Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-profile-avatar'),
				]
			);
			$this->add_control(
				'styler_lp_profile_avatar',
				[
					'label'            => esc_html__('Avatar', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-profile-avatar .avatar'),
				]
			);
			$this->add_control(
				'styler_lp_profile_name',
				[
					'label'            => esc_html__('User Name', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-profile-avatar .profile-name'),
				]
			);
			$this->end_controls_section();

			//Navigation
			$this->start_controls_section(
				'nav_style_section',
				[
					'label' => esc_html__('Navigation', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_wrapper',
				[
					'label'            => esc_html__('Navigation Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#learn-press-profile-nav'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu',
				[
					'label'            => esc_html__('Navigation Menu', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-tabs'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_mobile_menu',
				[
					'label'            => esc_html__('Mobile Menu Button', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-mobile-menu'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item',
				[
					'label'            => esc_html__('Menu Item', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#learn-press-profile-nav .tabs>li'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item_Link',
				[
					'label'            => esc_html__('Menu Item Link', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#learn-press-profile-nav .tabs>li a'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item_active',
				[
					'label'            => esc_html__('Active Menu Item', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-tabs li.active'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item_active_link',
				[
					'label'            => esc_html__('Active Menu Item Link', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#learn-press-profile-nav .tabs>li.active>a'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item_has_child',
				[
					'label'            => esc_html__('Has child Menu Item', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-tabs li.has-child'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item_sub_menu',
				[
					'label'            => esc_html__('Submenu', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-tabs li .profile-tab-sections'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item_sub_menu_item',
				[
					'label'            => esc_html__('Submenu Item', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-tabs li .profile-tab-sections li'),
				]
			);
			$this->add_control(
				'styler_lp_profile_nav_menu_item_sub_menu_item_link',
				[
					'label'            => esc_html__('Submenu Item Link', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-tabs li .profile-tab-sections li a'),
				]
			);
			$this->end_controls_section();

			//Title and Messages
			$this->start_controls_section(
				'titles_messages_style_section',
				[
					'label' => esc_html__('Titles & Messages', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_title',
				[
					'label'            => esc_html__('Heading Title', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.profile-heading'),
				]
			);
			$this->add_control(
				'styler_lp_profile_messages',
				[
					'label'            => esc_html__('Messages', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-message'),
				]
			);
			$this->add_control(
				'styler_lp_profile_messages_success',
				[
					'label'            => esc_html__('Success Messages', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-message.success'),
				]
			);
			$this->add_control(
				'styler_lp_profile_messages_success_icon',
				[
					'label'            => esc_html__('Success Messages icon', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-message.success i'),
				]
			);
			$this->add_control(
				'styler_lp_profile_messages_error',
				[
					'label'            => esc_html__('Error Messages', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-message.error'),
				]
			);
			$this->add_control(
				'styler_lp_profile_messages_error_icon',
				[
					'label'            => esc_html__('Error Messages icon', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-message.error i'),
				]
			);
			$this->end_controls_section();

			//Tabs
			$this->start_controls_section(
				'tabs_style_section',
				[
					'label' => esc_html__('Tabs', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_tabs_sections',
				[
					'label'            => esc_html__('Tabs Section', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-tab-sections'),
				]
			);
			$this->add_control(
				'styler_lp_profile_tabs_sections_tab',
				[
					'label'            => esc_html__('Tabs', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.section-tab'),
				]
			);
			$this->add_control(
				'styler_lp_profile_tabs_sections_tab_title',
				[
					'label'            => esc_html__('Tabs Title', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.section-tab span'),
				]
			);

			$this->add_control(
				'styler_lp_profile_sub_tabs_sections',
				[
					'label'            => esc_html__('Subtabs Section', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-subtab-content .lp-sub-menu'),
				]
			);
			$this->add_control(
				'styler_lp_profile_sub_tabs_sections_tab',
				[
					'label'            => esc_html__('Subtabs', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-subtab-content .lp-sub-menu li'),
				]
			);
			$this->add_control(
				'styler_lp_profile_sub_tabs_sections_tab_title',
				[
					'label'            => esc_html__('Subtabs Title', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.learn-press-subtab-content .lp-sub-menu span'),
				]
			);
			$this->end_controls_section();

			//Dashboard Content
			$this->start_controls_section(
				'dashboard_content_style_section',
				[
					'label' => esc_html__('Dashboard Content', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_dashboard_content_wrapper',
				[
					'label'            => esc_html__('Dashboard Content Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-dashboard'),
				]
			);
			$this->add_control(
				'styler_lp_profile_dashboard_content_p',
				[
					'label'            => esc_html__('Text', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-dashboard p'),
				]
			);
			$this->add_control(
				'styler_lp_profile_dashboard_content_username',
				[
					'label'            => esc_html__('Username', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-dashboard p strong'),
				]
			);
			$this->add_control(
				'styler_lp_profile_dashboard_content_sign_out',
				[
					'label'            => esc_html__('Sign out button', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-dashboard p a'),
				]
			);
			$this->add_control(
				'styler_lp_profile_dashboard_content_user_bio',
				[
					'label'            => esc_html__('User Bio', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-dashboard .user-bio'),
				]
			);
			$this->end_controls_section();

			//Courses Content
			$this->start_controls_section(
				'courses_content_style_section',
				[
					'label' => esc_html__('Courses Content', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_courses_wrapper',
				[
					'label'            => esc_html__('Courses Content Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-courses'),
				]
			);

			$this->end_controls_section();

			//Quizzes Content
			$this->start_controls_section(
				'quizzes_content_style_section',
				[
					'label' => esc_html__('Quizzes Content', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_quizzes_wrapper',
				[
					'label'            => esc_html__('Quizzes Content Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-quizzes'),
				]
			);

			$this->end_controls_section();

			//Orders Content
			$this->start_controls_section(
				'orders_content_style_section',
				[
					'label' => esc_html__('Orders Content', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_orders_wrapper',
				[
					'label'            => esc_html__('Orders Content Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-orders'),
				]
			);
			$this->add_control(
				'styler_lp_profile_recover_order_wrapper',
				[
					'label'            => esc_html__('Recover Order Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.profile-recover-order'),
				]
			);
			$this->add_control(
				'styler_lp_profile_recover_order_text',
				[
					'label'            => esc_html__('Recover Order Text', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.profile-recover-order p'),
				]
			);
			$this->add_control(
				'styler_lp_profile_recover_order_input',
				[
					'label'            => esc_html__('Recover Order Input', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.profile-recover-order input[name="order-key"]'),
				]
			);
			$this->add_control(
				'styler_lp_profile_recover_order_button',
				[
					'label'            => esc_html__('Recover Order Submit Button', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.profile-recover-order .button-recover-order'),
				]
			);

			$this->end_controls_section();

			//Settings Content
			$this->start_controls_section(
				'settings_content_style_section',
				[
					'label' => esc_html__('Settings Content', 'kata-plus'),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_wrapper',
				[
					'label'            => esc_html__('Settings Content Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form',
				[
					'label'            => esc_html__('Settings Form', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_lable',
				[
					'label'            => esc_html__('label', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information label'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_input_wrapper',
				[
					'label'            => esc_html__('Input Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information .form-field'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_input',
				[
					'label'            => esc_html__('Input', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information input'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_textarea_wrapper',
				[
					'label'            => esc_html__('Textarea Wrapper', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information .form-field:first-child'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_textarea',
				[
					'label'            => esc_html__('Textarea', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information textarea'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_select',
				[
					'label'            => esc_html__('Select Dropdown', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information select'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_description',
				[
					'label'            => esc_html__('Description', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information p.description'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_form_submit_button',
				[
					'label'            => esc_html__('Submit Button', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('#profile-content-settings #learn-press-profile-basic-information button[type="submit"]'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_avatar_preview',
				[
					'label'            => esc_html__('Avatar Preview', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-edit-avatar .lp-avatar-preview'),
				]
			);
			$this->add_control(
				'styler_lp_profile_settings_avatar_upload_button',
				[
					'label'            => esc_html__('Avatar upload button', 'kata-plus'),
					'type'             => 'kata_styler',
					'selectors'        => Kata_Styler::selectors('.lp-edit-avatar button'),
				]
			);
			$this->end_controls_section();

			// Common controls
			apply_filters( 'kata_plus_common_controls', $this );
			// end copy
		}

		protected function render() {
			require dirname( __FILE__ ) . '/view.php';
		}
	} // class
}
