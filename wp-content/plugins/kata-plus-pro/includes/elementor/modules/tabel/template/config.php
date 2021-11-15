<?php
/**
 *  Table module config.
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
use Elementor\Repeater;

class Kata_Plus_Pro_Table extends Widget_Base {
	public function get_name() {
		return 'kata-plus-table';
	}

	public function get_title() {
		return esc_html__( 'Table', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-tabel';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	protected function register_controls() {
		// Content Tab
		$this->start_controls_section(
			'table_header',
			[
				'label' => esc_html__( 'Header', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$header_items = new Repeater();
		$header_items->add_control(
			'header_item',
			[
				'label'        => esc_html__( 'Title', 'kata-plus' ),
				'type'         => Controls_Manager::TEXT,
			]
		);
		$header_items->add_control(
			'header_item_size',
			[
				'label'		=> esc_html__( 'Column Size', 'kata-plus' ),
				'type'		=> Controls_Manager::SELECT,
				'options'	=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'default' => '1',
			]
		);
		$this->add_control(
			'header_items',
			[
				'label'       	=> esc_html__( 'Add List', 'kata-plus' ),
				'type'        	=> Controls_Manager::REPEATER,
				'fields'      	=> $header_items->get_controls(),
				'prevent_empty' => false,
				'title_field'	=> '{{{ header_item }}}',
				'default'		=> [
					[
						'header_item' 		=> 'Course Name',
						'header_item_size' 	=> '2',
					],
					[
						'header_item' 		=> 'Hrs/Week',
						'header_item_size' 	=> '1',
					],
					[
						'header_item' 		=> 'Total Weeks',
						'header_item_size' 	=> '1',
					],
					[
						'header_item' 		=> 'Start Date',
						'header_item_size' 	=> '1',
					],
					[
						'header_item' 		=> 'End Date',
						'header_item_size' 	=> '1',
					],
					[
						'header_item' 		=> 'Price (USD)',
						'header_item_size' 	=> '1',
					],
					[
						'header_item' 		=> 'Action',
						'header_item_size' 	=> '1',
					],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'table_body',
			[
				'label' => esc_html__( 'Body', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$body_items = new Repeater();
		$body_items->add_control(
			'start_row',
			[
				'label'        => __('Start Row', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$body_items->add_control(
			'end_row',
			[
				'label'        => __('End Row', 'kata-plus'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __('Yes', 'kata-plus'),
				'label_off'    => __('No', 'kata-plus'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$body_items->add_control(
			'body_item',
			[
				'label'        => esc_html__( 'Items', 'kata-plus' ),
				'type'         => Controls_Manager::TEXT,
			]
		);
		$body_items->add_control(
			'body_item_link',
			[
				'label'			=> __( 'Link', 'kata-plus' ),
				'type'			=> \Elementor\Controls_Manager::URL,
				'placeholder'	=> __( 'https://climaxthemes.com', 'kata-plus' ),
				'show_external' => true,
				'default'		=> [
					'url'			=> '',
					'is_external'	=> false,
					'nofollow'		=> false,
				],
			]
		);
		$body_items->add_control(
			'body_item_link_icon',
			[
				'label'     => esc_html__( 'Icon', 'kata-plus' ),
				'type'      => 'kata_plus_icons',
				'default'   => '',
			]
		);
		$body_items->add_control(
			'body_item_link_icon_pos',
			[
				'label'		=> esc_html__( 'Icon Position', 'kata-plus' ),
				'type'		=> Controls_Manager::SELECT,
				'options'	=> [
					'start' => __( 'Before Content', 'kata-plus'),
					'end' => __( 'After Content', 'kata-plus'),
				],
				'default' => 'end',
			]
		);
		$body_items->add_control(
			'body_item_tag',
			[
				'label'		=> esc_html__( 'Item Tag', 'kata-plus' ),
				'type'		=> Controls_Manager::SELECT,
				'options'	=> [
					'td' => __( 'Standard', 'kata-plus'),
					'th' => __( 'Heading', 'kata-plus'),
				],
				'default' => 'td',
			]
		);
		$body_items->add_control(
			'body_item_size',
			[
				'label'		=> esc_html__( 'Column Size', 'kata-plus' ),
				'type'		=> Controls_Manager::SELECT,
				'options'	=> [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'default' => '1',
			]
		);
		$this->add_control(
			'body_items',
			[
				'label'       	=> esc_html__( 'Add List', 'kata-plus' ),
				'type'        	=> Controls_Manager::REPEATER,
				'fields'      	=> $body_items->get_controls(),
				'prevent_empty' => false,
				'title_field'	=> '{{{ body_item }}}',
				'default'     => [
					[
						'start_row' 		=> 'yes',
						'end_row' 			=> '',
						'body_item' 		=> 'English - Beginner',
						'body_item_tag' 	=> 'th',
						'body_item_size' 	=> '2',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '15',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '4',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 1',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 30',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '460.00',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 			=> '',
						'end_row' 				=> '',
						'body_item' 			=> 'Apply Now',
						'body_item_link_icon'	=> 'font-awesome/arrow-right',
						'body_item_link' 		=> [
							'url' => '#'
						],
						'body_item_tag' 		=> 'td',
						'body_item_size' 		=> '1',
					],

					[
						'start_row' 		=> 'yes',
						'end_row' 			=> '',
						'body_item' 		=> 'English - Intermediate',
						'body_item_tag' 	=> 'th',
						'body_item_size' 	=> '2',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '14',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '4',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 1',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 30',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '750.00',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 			=> '',
						'end_row' 				=> '',
						'body_item' 			=> 'Apply Now',
						'body_item_link_icon'	=> 'font-awesome/arrow-right',
						'body_item_link' 		=> [
							'url' => '#'
						],
						'body_item_tag' 		=> 'td',
						'body_item_size' 		=> '1',
					],

					[
						'start_row' 		=> 'yes',
						'end_row' 			=> '',
						'body_item' 		=> 'English - Professional',
						'body_item_tag' 	=> 'th',
						'body_item_size' 	=> '2',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '13',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '4',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 1',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 30',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '950.00',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 			=> '',
						'end_row' 				=> '',
						'body_item' 			=> 'Apply Now',
						'body_item_link_icon'	=> 'font-awesome/arrow-right',
						'body_item_link' 		=> [
							'url' => '#'
						],
						'body_item_tag' 		=> 'td',
						'body_item_size' 		=> '1',
					],

					[
						'start_row' 		=> 'yes',
						'end_row' 			=> '',
						'body_item' 		=> 'French - Beginner',
						'body_item_tag' 	=> 'th',
						'body_item_size' 	=> '2',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '16',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '4',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 1',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 30',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '575.00',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 			=> '',
						'end_row' 				=> '',
						'body_item' 			=> 'Apply Now',
						'body_item_link_icon'	=> 'font-awesome/arrow-right',
						'body_item_link' 		=> [
							'url' => '#'
						],
						'body_item_tag' 		=> 'td',
						'body_item_size' 		=> '1',
					],

					[
						'start_row' 		=> 'yes',
						'end_row' 			=> '',
						'body_item' 		=> 'French - Intermediate',
						'body_item_tag' 	=> 'th',
						'body_item_size' 	=> '2',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '15',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '4',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 1',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 30',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '320.00',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 			=> '',
						'end_row' 				=> '',
						'body_item' 			=> 'Apply Now',
						'body_item_link_icon'	=> 'font-awesome/arrow-right',
						'body_item_link' 		=> [
							'url' => '#'
						],
						'body_item_tag' 		=> 'td',
						'body_item_size' 		=> '1',
					],

					[
						'start_row' 		=> 'yes',
						'end_row' 			=> '',
						'body_item' 		=> 'French - Professional',
						'body_item_tag' 	=> 'th',
						'body_item_size' 	=> '2',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '12',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '4',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 1',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> 'Sep 30',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 		=> '',
						'end_row' 			=> '',
						'body_item' 		=> '460.00',
						'body_item_tag' 	=> 'td',
						'body_item_size' 	=> '1',
					],
					[
						'start_row' 			=> '',
						'end_row' 				=> '',
						'body_item' 			=> 'Apply Now',
						'body_item_link_icon'	=> 'font-awesome/arrow-right',
						'body_item_link' 		=> [
							'url' => '#'
						],
						'body_item_tag' 		=> 'td',
						'body_item_size' 		=> '1',
					],
				]
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
				'selectors' => Kata_Styler::selectors( '.kata-plus-table-wrap' ),
			]
		);
		$this->add_control(
			'styler_wrap_tabel',
			[
				'label'     => __( 'Tabel', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-table' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style_table_header',
			[
				'label' => esc_html__( 'Table Header', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrap_header',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-table thead' ),
			]
		);
		$this->add_control(
			'styler_wrap_header_row',
			[
				'label'     => __( 'Row', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( 'tr.kt-table-header-item' ),
			]
		);
		$this->add_control(
			'styler_wrap_header_item',
			[
				'label'     => __( 'Items', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( 'th.kt-table-header-item' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_style_table_body',
			[
				'label' => esc_html__( 'Table Body', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrap_body',
			[
				'label'     => __( 'Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-table tbody' ),
			]
		);
		$this->add_control(
			'styler_wrap_body_row',
			[
				'label'     => __( 'Row', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-table tbody tr' ),
			]
		);
		$this->add_control(
			'styler_wrap_header_heading_item',
			[
				'label'     => __( 'Heading Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-table tbody th' ),
			]
		);
		$this->add_control(
			'styler_wrap_header_standard_item',
			[
				'label'     => __( 'Standard Item', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-table tbody td' ),
			]
		);
		$this->add_control(
			'styler_link_item',
			[
				'label'     => __( 'Link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-plus-table tbody a' ),
			]
		);
		$this->add_control(
			'styler_icon_item',
			[
				'label'     => __( 'Icon', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-icon', '', '.kata-plus-table tbody a' ),
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
