<?php
/**
 * Language Switcher module config.
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

class Kata_Language_Switcher extends Widget_Base {
	public function get_name() {
		return 'kata-plus-language-switcher';
	}

	public function get_title() {
		return esc_html__( 'Language Switcher', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-text-area';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_header' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-language', 'kata-plus-book-table-select' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-language-switcher', 'kata-plus-book-table-select' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_plugin',
			[
				'label' => esc_html__( 'Select Plugin', 'kata-plus' ),
			]
		);

		$this->add_control(
			'installed_plugin',
			[
				'label'       => esc_html__( 'Which plugin have you installed?', 'kata-plus' ),
				'description' => esc_html__( 'Please install only one of these plugins and not both, in order to prevent any conflicts.', 'kata-plus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'polylang',
				'options'     => [
					'polylang' => 'Polylang',
					'wpml'     => 'WPML',
				],
			]
		);

		$this->add_control(
			'po_dropdown',
			[
				'label'        => esc_html__( 'Dropdown', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kata-plus' ),
				'label_off'    => esc_html__( 'Disable', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '0',
				'condition'    => [
					'installed_plugin' => [ 'polylang' ],
				],
			]
		);

		$this->add_control(
			'po_names',
			[
				'label'        => esc_html__( 'Languages Names', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '1',
				'condition'    => [
					'installed_plugin' => [ 'polylang' ],
				],
			]
		);

		$this->add_control(
			'po_display_as',
			[
				'label'     => esc_html__( 'Display names as:', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'name',
				'options'   => [
					'name' => 'Name',
					'slug' => 'Slug',
				],
				'condition' => [
					'installed_plugin' => [ 'polylang' ],
					'po_names'         => [ '1' ],
				],
			]
		);

		$this->add_control(
			'po_flag',
			[
				'label'        => esc_html__( 'Flag', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '0',
				'condition'    => [
					'installed_plugin' => [ 'polylang' ],
					'po_dropdown!'     => [ '1' ],
				],
			]
		);

		$this->add_control(
			'po_hide_if_empty',
			[
				'label'        => esc_html__( 'Languages with no posts (or pages)', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '1',
				'condition'    => [
					'installed_plugin' => [ 'polylang' ],
				],
			]
		);

		$this->add_control(
			'po_hide_if_no_translation',
			[
				'label'        => esc_html__( 'Language if no translation exists', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '1',
				'condition'    => [
					'installed_plugin' => [ 'polylang' ],
				],
			]
		);

		$this->add_control(
			'po_hide_current',
			[
				'label'        => esc_html__( 'Current language', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '1',
				'condition'    => [
					'installed_plugin' => [ 'polylang' ],
				],
			]
		);

		$this->add_control(
			'wpml_type',
			[
				'label'       => esc_html__( 'Type', 'kata-plus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'footer',
				'description' => esc_html__( 'You can customize types in WPML > Languages.', 'kata-plus' ),
				'options'     => [
					'footer'            => 'Footer',
					'post_translations' => 'Post Translations',
					'widget'            => 'widget',
					'custom'            => 'Custom',
				],
				'condition'   => [
					'installed_plugin' => [ 'wpml' ],
				],
			]
		);

		$this->add_control(
			'important_note',
			[
				'label'           => esc_html__( 'Note:', 'kata-plus' ),
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Please go to WPML > Languages menu and set your custom language skin.', 'kata-plus' ),
				'content_classes' => 'kata-admin-notification-message',
				'condition'       => [
					'installed_plugin' => [ 'wpml' ],
					'wpml_type'        => [ 'custom' ],
				],
			]
		);

		$this->add_control(
			'wpml_flag',
			[
				'label'        => esc_html__( 'Flag', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '1',
				'condition'    => [
					'installed_plugin' => [ 'wpml' ],
					'wpml_type!'       => [ 'custom' ],
				],
			]
		);

		$this->add_control(
			'wpml_link_current',
			[
				'label'        => esc_html__( 'Link for current language', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kata-plus' ),
				'label_off'    => esc_html__( 'Disable', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '0',
				'condition'    => [
					'installed_plugin' => [ 'wpml' ],
					'wpml_type!'       => [ 'custom' ],
				],
			]
		);

		$this->add_control(
			'wpml_native',
			[
				'label'        => esc_html__( 'Display names in native language', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kata-plus' ),
				'label_off'    => esc_html__( 'Disable', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '0',
				'condition'    => [
					'installed_plugin' => [ 'wpml' ],
					'wpml_type!'       => [ 'custom' ],
				],
			]
		);

		$this->add_control(
			'wpml_translated',
			[
				'label'        => esc_html__( 'Display names in current language', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'kata-plus' ),
				'label_off'    => esc_html__( 'Disable', 'kata-plus' ),
				'return_value' => '1',
				'default'      => '0',
				'condition'    => [
					'installed_plugin' => [ 'wpml' ],
					'wpml_type!'       => [ 'custom' ],
				],
			]
		);

		$this->end_controls_section();

		// Content options Start
		$this->start_controls_section(
			'section_styling',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_box',
			[
				'label'     => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-language-switcher' ),
			]
		);
		$this->add_control(
			'styler_item',
			[
				'label'     => esc_html__( 'Language Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-language-switcher li,.kata-language-switcher select' ),
				'condition' => [
					'installed_plugin' => [ 'polylang' ],
				],
			]
		);
		$this->add_control(
			'styler_links',
			[
				'label'     => esc_html__( 'Links', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-language-switcher li a' ),
				'condition' => [
					'installed_plugin' => [ 'polylang' ],
					'po_dropdown!'     => [ '1' ],
				],
			]
		);
		$this->add_control(
			'styler_flag',
			[
				'label'     => esc_html__( 'Flags', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-language-switcher li a img' ),
				'condition' => [
					'installed_plugin' => [ 'polylang' ],
					'po_dropdown!'     => [ '1' ],
				],
			]
		);
		$this->add_control(
			'styler_item_wpml',
			[
				'label'     => esc_html__( 'Language Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.wpml-ls-item,.kata-language-switcher select' ),
				'condition' => [
					'installed_plugin' => [ 'wpml' ],
				],
			]
		);
		$this->add_control(
			'styler_links_wpml',
			[
				'label'     => esc_html__( 'Links', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.wpml-ls-item a' ),
				'condition' => [
					'installed_plugin' => [ 'wpml' ],
				],
			]
		);
		$this->add_control(
			'styler_flag_wpml',
			[
				'label'     => esc_html__( 'Flags', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.wpml-ls-item a img' ),
				'condition' => [
					'installed_plugin' => [ 'wpml' ],
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'select_style',
			[
				'label' => esc_html__( 'Select Language', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'installed_plugin' => [ 'polylang' ],
				],
			]
		);
		$this->add_control(
			'styler_select_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-language-switcher .nice-select' ),
			]
		);
		$this->add_control(
			'styler_options_wrapper',
			[
				'label'            => esc_html__( 'Options Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-language-switcher .nice-select .list' ),
			]
		);
		$this->add_control(
			'styler_options',
			[
				'label'            => esc_html__( 'Options', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-language-switcher .nice-select .list li.option' ),
			]
		);
		$this->add_control(
			'styler_selected_option',
			[
				'label'            => esc_html__( 'Selected Option', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-language-switcher .nice-select .current' ),
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
