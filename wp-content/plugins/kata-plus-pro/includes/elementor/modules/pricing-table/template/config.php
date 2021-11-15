<?php
/**
 * Pricing Table module config.
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
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

class Kata_Plus_Pro_Pricing_Table extends Widget_Base {
	public function get_name() {
		return 'kata-plus-pricing-table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-price-table';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-pricing-table' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-pricing-table' ];
	}

	protected function register_controls() {
		// General Settings
		$this->start_controls_section(
			'section_tab_toolbar_general_settings',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
			]
		);
		$this->add_control(
			'currency',
			[
				'label'   => esc_html__( 'Currency', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'featured_table',
			[
				'label'		=> esc_html__( 'Featured Plan', 'kata-plus' ),
				'type'		=> Controls_Manager::SELECT2,
				'options'	=> [
					'none'		=> __( 'None', 'kata-plus' ),
					'tableone' 	=> __( 'Plan One', 'kata-plus' ),
					'tabletwo' 	=> __( 'Plan Two', 'kata-plus' ),
					'tableThree'	=> __( 'Plan Three', 'kata-plus' ),
				],
				'default'	=> 'tabletwo',
			]
		);
		$this->end_controls_section();

		// Toolbar Settings
		$this->start_controls_section(
			'section_tab_toolbar',
			[
				'label' => esc_html__( 'Toolbar', 'kata-plus' ),
			]
		);

		$this->add_control(
			'tools_mode_options',
			[
				'label'		=> __( 'Mode Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'mod_first',
			[
				'label'   => esc_html__( 'First mode', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Yearly', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'mod_second',
			[
				'label'   => esc_html__( 'Second mode', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Monthly', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$toolbar = new Repeater();
		$this->add_control(
			'tools_mode_items',
			[
				'label'		=> __( 'Items', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$toolbar->add_control(
			'tools_link_allow',
			[
				'label'        => esc_html__( 'Use Link', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Use', 'kata-plus' ),
				'label_off'    => esc_html__( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$toolbar->add_control(
			'tools_link',
			[
				'label'         => esc_html__( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [ 'tools_link_allow' => 'yes' ],
			]
		);
		$toolbar->add_control(
			'tools_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$toolbar->add_control(
			'tools_text',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'tools',
			[
				'label'       => esc_html__( 'Add Item', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $toolbar->get_controls(),
				'title_field' => '{{{ tools_text }}}',

				'default'     => [
					[
						'tools_icon'	=> '7-stroke/cloud',
						'tools_text'	=> __( 'Space For Host', 'kata-plus' ),
					],
					[
						'tools_icon'	=> '7-stroke/users',
						'tools_text'	=> __( 'FTP Users', 'kata-plus' ),
					],
					[
						'tools_icon'	=> '7-stroke/server',
						'tools_text'	=> __( 'Databases', 'kata-plus' ),
					],
					[
						'tools_icon'	=> '7-stroke/global',
						'tools_text'	=> __( 'Adons Domains', 'kata-plus' ),
					],
					[
						'tools_icon'	=> '7-stroke/call',
						'tools_text'	=> __( '24/7 Support', 'kata-plus' ),
					],
				],

			]
		);
		$this->end_controls_section();


		// Plan one
		$this->start_controls_section(
			'section_tab_table_one',
			[
				'label' => esc_html__( 'Plan One', 'kata-plus' ),
			]
		);
		$this->add_control(
			'table_one_title_header_options',
			[
				'label'		=> __( 'Header Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_one_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'table_one_title',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Basic', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_one_price',
			[
				'label'   => esc_html__( 'Price', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '10', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_one_period',
			[
				'label'   => esc_html__( 'Period', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '/mo', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_one_price2',
			[
				'label'   => esc_html__( 'Second Price', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '120', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_one_period2',
			[
				'label'   => esc_html__( 'Second Period', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '/yr', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$table_one = new Repeater();
		$table_one->add_control(
			'table_one_link_allow',
			[
				'label'        => esc_html__( 'Use Link', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Use', 'kata-plus' ),
				'label_off'    => esc_html__( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$table_one->add_control(
			'table_one_link',
			[
				'label'         => esc_html__( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [ 'table_one_link_allow' => 'yes' ],
			]
		);
		$table_one->add_control(
			'table_one_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$table_one->add_control(
			'table_one_text',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_one_title_items_options',
			[
				'label'		=> __( 'Items Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_one_items',
			[
				'label'       => esc_html__( 'Add Item', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $table_one->get_controls(),
				'title_field' => '{{{ table_one_text }}}',

				'default'     => [
					[
						'table_one_text'	=> __( '30GB Of Storage', 'kata-plus' ),
					],
					[
						'table_one_text'	=> __( '50 Users', 'kata-plus' ),
					],
					[
						'table_one_text'	=> __( '5 Database', 'kata-plus' ),
					],
					[
						'table_one_text'	=> __( '10 Adons', 'kata-plus' ),
					],
					[
						'table_one_text'	=> __( 'Yes', 'kata-plus' ),
					],
				],

			]
		);
		$this->add_control(
			'table_one_title_footer_options',
			[
				'label'		=> __( 'Footer Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_one_button', // param_name
			[
				'label'        => esc_html__( 'Show Button', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'table_one_text_button',
			[
				'label'     => esc_html__( 'Button Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Choose', 'kata-plus' ),
				'condition' => [
					'table_one_button' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_one_link_button', // param_name
			[
				'label'       => esc_html__( 'Link', 'kata-plus' ), // heading
				'type'        => Controls_Manager::URL, // type
				'placeholder' => esc_html__( 'https://your-link.com', 'kata-plus' ),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'   => [
					'table_one_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'table_one_icon_button',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'table_one_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'table_one_icon_position_button',
			[
				'label'     => esc_html__( 'Button Icon Position', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'before' => esc_html__( 'Before', 'kata-plus' ),
					'after'  => esc_html__( 'After', 'kata-plus' ),
				],
				'default'   => 'after',
				'condition' => [
					'table_one_button'       => 'yes',
					'table_one_icon_button!' => '',
				],
			]
		);
		$this->end_controls_section();

		// Plan Two
		$this->start_controls_section(
			'section_tab_table_two',
			[
				'label' => esc_html__( 'Plan Two', 'kata-plus' ),
			]
		);
		$this->add_control(
			'table_two_title_header_options',
			[
				'label'		=> __( 'Header Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_two_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'table_two_title',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'standard', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_two_price',
			[
				'label'   => esc_html__( 'Price', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '360', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_two_period',
			[
				'label'   => esc_html__( 'Period', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '/mo', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_two_price2',
			[
				'label'   => esc_html__( 'Second Price', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '120', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_two_period2',
			[
				'label'   => esc_html__( 'Second Period', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '/yr', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$table_two = new Repeater();
		$table_two->add_control(
			'table_two_link_allow',
			[
				'label'        => esc_html__( 'Use Link', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Use', 'kata-plus' ),
				'label_off'    => esc_html__( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$table_two->add_control(
			'table_two_link',
			[
				'label'         => esc_html__( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [ 'table_two_link_allow' => 'yes' ],
			]
		);
		$table_two->add_control(
			'table_two_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$table_two->add_control(
			'table_two_text',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_two_title_items_options',
			[
				'label'		=> __( 'Items Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_two_items',
			[
				'label'       => esc_html__( 'Add Item', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $table_two->get_controls(),
				'title_field' => '{{{ table_two_text }}}',

				'default'     => [
					[
						'table_two_text'	=> __( '50GB Of Storage', 'kata-plus' ),
					],
					[
						'table_two_text'	=> __( '60 Users', 'kata-plus' ),
					],
					[
						'table_two_text'	=> __( '10 Database', 'kata-plus' ),
					],
					[
						'table_two_text'	=> __( '15 Adons', 'kata-plus' ),
					],
					[
						'table_two_text'	=> __( 'Yes', 'kata-plus' ),
					],
				],

			]
		);
		$this->add_control(
			'table_two_title_footer_options',
			[
				'label'		=> __( 'Footer Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_two_button', // param_name
			[
				'label'        => esc_html__( 'Show Button', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'table_two_text_button',
			[
				'label'     => esc_html__( 'Button Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Choose', 'kata-plus' ),
				'condition' => [
					'table_two_button' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_two_link_button', // param_name
			[
				'label'       => esc_html__( 'Link', 'kata-plus' ), // heading
				'type'        => Controls_Manager::URL, // type
				'placeholder' => esc_html__( 'https://your-link.com', 'kata-plus' ),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'   => [
					'table_two_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'table_two_icon_button',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'table_two_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'table_two_icon_position_button',
			[
				'label'     => esc_html__( 'Button Icon Position', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'before' => esc_html__( 'Before', 'kata-plus' ),
					'after'  => esc_html__( 'After', 'kata-plus' ),
				],
				'default'   => 'after',
				'condition' => [
					'table_two_button'       => 'yes',
					'table_two_icon_button!' => '',
				],
			]
		);
		$this->end_controls_section();

		// Plan Three
		$this->start_controls_section(
			'section_tab_table_three',
			[
				'label' => esc_html__( 'Plan Three', 'kata-plus' ),
			]
		);
		$this->add_control(
			'table_three_title_header_options',
			[
				'label'		=> __( 'Header Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_three_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$this->add_control(
			'table_three_title',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'advanced', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_three_price',
			[
				'label'   => esc_html__( 'Price', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '90', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_three_period',
			[
				'label'   => esc_html__( 'Period', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '/mo', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_three_price2',
			[
				'label'   => esc_html__( 'Second Price', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '1080', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_three_period2',
			[
				'label'   => esc_html__( 'Second Period', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '/yr', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$table_three = new Repeater();
		$table_three->add_control(
			'table_three_link_allow',
			[
				'label'        => esc_html__( 'Use Link', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Use', 'kata-plus' ),
				'label_off'    => esc_html__( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$table_three->add_control(
			'table_three_link',
			[
				'label'         => esc_html__( 'Link', 'kata-plus' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'     => [ 'table_three_link_allow' => 'yes' ],
			]
		);
		$table_three->add_control(
			'table_three_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
			]
		);
		$table_three->add_control(
			'table_three_text',
			[
				'label'   => esc_html__( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_three_title_items_options',
			[
				'label'		=> __( 'Items Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_three_items',
			[
				'label'       => esc_html__( 'Add Item', 'kata-plus' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $table_three->get_controls(),
				'title_field' => '{{{ table_three_text }}}',

				'default'     => [
					[
						'table_three_text'	=> __( '100GB Of Storage', 'kata-plus' ),
					],
					[
						'table_three_text'	=> __( '70 Users', 'kata-plus' ),
					],
					[
						'table_three_text'	=> __( '15 Database', 'kata-plus' ),
					],
					[
						'table_three_text'	=> __( '20 Adons', 'kata-plus' ),
					],
					[
						'table_three_text'	=> __( 'Yes', 'kata-plus' ),
					],
				],

			]
		);
		$this->add_control(
			'table_three_title_footer_options',
			[
				'label'		=> __( 'Footer Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'table_three_button', // param_name
			[
				'label'        => esc_html__( 'Show Button', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'kata-plus' ),
				'label_off'    => esc_html__( 'Hide', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'table_three_text_button',
			[
				'label'     => esc_html__( 'Button Text', 'kata-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Choose', 'kata-plus' ),
				'condition' => [
					'table_three_button' => 'yes',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'table_three_link_button', // param_name
			[
				'label'       => esc_html__( 'Link', 'kata-plus' ), // heading
				'type'        => Controls_Manager::URL, // type
				'placeholder' => esc_html__( 'https://your-link.com', 'kata-plus' ),
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'condition'   => [
					'table_three_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'table_three_icon_button',
			[
				'label'     => esc_html__( 'Button Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'condition' => [
					'table_three_button' => 'yes',
				],
			]
		);
		$this->add_control(
			'table_three_icon_position_button',
			[
				'label'     => esc_html__( 'Button Icon Position', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'before' => esc_html__( 'Before', 'kata-plus' ),
					'after'  => esc_html__( 'After', 'kata-plus' ),
				],
				'default'   => 'after',
				'condition' => [
					'table_three_button'       => 'yes',
					'table_three_icon_button!' => '',
				],
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
				'label'            => esc_html__('Wrapper', 'kata-plus'),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.kata-plus-pricing-table'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_toolbar',
			[
				'label' => esc_html__( 'Toolbar', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_toolbar_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-tools-table'),
			]
		);
		$this->add_control(
			'styler_toolbar_header',
			[
				'label'            => esc_html__( 'Header', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-toolbar-header'),
			]
		);
		$this->add_control(
			'styler_toolbar_mode_options',
			[
				'label'		=> __( 'Mode Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_toolbar_mode_option_first',
			[
				'label'            => esc_html__( 'First mode', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.price-mode-first'),
			]
		);
		$this->add_control(
			'switcher_note',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('To style the switcher circle click on switcher styler button then go to "Before" tab.', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_toolbar_mode_option_switcher',
			[
				'label'            => esc_html__( 'Switcher', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.mode-switcher'),
			]
		);
		$this->add_control(
			'styler_toolbar_mode_option_second',
			[
				'label'            => esc_html__( 'Second mode', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.price-mode-second'),
			]
		);
		$this->add_control(
			'styler_toolbar_Item_options',
			[
				'label'		=> __( 'Item Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_toolbar_mode_option_link',
			[
				'label'            => esc_html__( 'Link', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-tool-item>a .tool-text'),
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
			'styler_toolbar_mode_option_icon',
			[
				'label'            => esc_html__( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-tool-item .tool-icon .kata-icon'),
			]
		);
		$this->add_control(
			'styler_toolbar_mode_option_title',
			[
				'label'            => esc_html__( 'Title', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-tool-item .tool-text'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_normal_plan',
			[
				'label' => esc_html__( 'Normal Tables', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_normal_plan_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table)'),
			]
		);
		$this->add_control(
			'styler_normal_plan_header',
			[
				'label'            => esc_html__( 'Header', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-header'),
			]
		);
		$this->add_control(
			'styler_normal_plan_icon_wrapper',
			[
				'label'            => esc_html__( 'Icon Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-header-wrapper .pricing-table-icon'),
			]
		);
		$this->add_control(
			'icon_style_error_2',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_normal_plan_icon',
			[
				'label'            => esc_html__( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-header-wrapper .pricing-table-icon .kata-icon'),
			]
		);
		$this->add_control(
			'styler_normal_plan_title',
			[
				'label'            => esc_html__( 'Title', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-title'),
			]
		);
		$this->add_control(
			'styler_normal_plan_pricing_options',
			[
				'label'		=> __( 'Pricing Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_normal_plan_price_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-price'),
			]
		);
		$this->add_control(
			'styler_normal_plan_price_currency',
			[
				'label'            => esc_html__( 'Currency', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-price .currency'),
			]
		);
		$this->add_control(
			'styler_normal_plan_price_price',
			[
				'label'            => esc_html__( 'Price', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-price .price'),
			]
		);
		$this->add_control(
			'styler_normal_plan_price_period',
			[
				'label'            => esc_html__( 'Period', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-price .period'),
			]
		);
		$this->add_control(
			'styler_normal_plan_item_options',
			[
				'label'		=> __( 'Item Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_normal_plan_item_wrapper',
			[
				'label'            => esc_html__( 'Item Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) tbody tr td'),
			]
		);
		$this->add_control(
			'styler_normal_plan_item',
			[
				'label'            => esc_html__( 'Item', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-item'),
			]
		);
		$this->add_control(
			'styler_normal_plan_footer_options',
			[
				'label'		=> __( 'Footer Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_normal_plan_footer',
			[
				'label'            => esc_html__( 'Footer', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-footer'),
			]
		);
		$this->add_control(
			'styler_normal_plan_footer_button',
			[
				'label'            => esc_html__( 'Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table:not(.featured-table) .pricing-table-footer .kata-button'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styler_featured_plan',
			[
				'label' => esc_html__( 'Featured Table', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_featured_plan_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table'),
			]
		);
		$this->add_control(
			'styler_featured_plan_header',
			[
				'label'            => esc_html__( 'Header', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-header'),
			]
		);
		$this->add_control(
			'styler_featured_plan_icon_wrapper',
			[
				'label'            => esc_html__( 'Icon Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-header-wrapper .pricing-table-icon'),
			]
		);
		$this->add_control(
			'icon_style_error_3',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __('In order to change the color of icons, Open Styler and navigate to the SVG tab (all Kata icons is SVG)', 'kata-plus'),
				'content_classes' => 'kata-plus-elementor-error',
			]
		);
		$this->add_control(
			'styler_featured_plan_icon',
			[
				'label'            => esc_html__( 'Icon', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-header-wrapper .pricing-table-icon .kata-icon'),
			]
		);
		$this->add_control(
			'styler_featured_plan_title',
			[
				'label'            => esc_html__( 'Title', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-title'),
			]
		);
		$this->add_control(
			'styler_featured_plan_pricing_options',
			[
				'label'		=> __( 'Pricing Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_featured_plan_price_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-price'),
			]
		);
		$this->add_control(
			'styler_featured_plan_price_currency',
			[
				'label'            => esc_html__( 'Currency', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-price .currency'),
			]
		);
		$this->add_control(
			'styler_featured_plan_price_price',
			[
				'label'            => esc_html__( 'Price', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-price .price'),
			]
		);
		$this->add_control(
			'styler_featured_plan_price_period',
			[
				'label'            => esc_html__( 'Period', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-price .period'),
			]
		);
		$this->add_control(
			'styler_featured_plan_item_options',
			[
				'label'		=> __( 'Item Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_featured_plan_item_wrapper',
			[
				'label'            => esc_html__( 'Item Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table tbody tr td'),
			]
		);
		$this->add_control(
			'styler_featured_plan_item',
			[
				'label'            => esc_html__( 'Item', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-item'),
			]
		);
		$this->add_control(
			'styler_featured_plan_footer_options',
			[
				'label'		=> __( 'Footer Options', 'kata-plus' ),
				'type'		=> Controls_Manager::HEADING,
				'separator'	=> 'default',
			]
		);
		$this->add_control(
			'styler_featured_plan_footer',
			[
				'label'            => esc_html__( 'Footer', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-footer'),
			]
		);
		$this->add_control(
			'styler_featured_plan_footer_button',
			[
				'label'            => esc_html__( 'Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors('.pricing-table-table.featured-table .pricing-table-footer .kata-button'),
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
