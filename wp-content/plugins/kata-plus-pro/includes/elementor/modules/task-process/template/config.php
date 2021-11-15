<?php
/**
 * Task Process module config.
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
use Elementor\Repeater;

class Kata_Task_Process extends Widget_Base {
	public function get_name() {
		return 'kata-plus-task-process';
	}

	public function get_title() {
		return esc_html__( 'Task Process', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-form-vertical';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-owlcarousel', 'kata-plus-owl' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-task-process', 'kata-plus-owlcarousel', 'kata-plus-owl' ];
	}

	protected function register_controls() {
		// Content options Start
		$this->start_controls_section(
			'section_task_process',
			[
				'label' => esc_html__( 'Task Process Settings', 'kata-plus' ),
			]
		);

		$task = new Repeater();

		$task->add_control(
			'number', [
				'label'   => __( 'Number', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( '1' , 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$task->add_control(
			'styler_number_repeater',
			[
				'label'     => esc_html__( 'Number', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}} .process-number' ),
			]
		);

		$task->add_control(
			'title', [
				'label'   => __( 'Title', 'kata-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$task->add_control(
			'styler_title_repeater',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}} .task-process-title' ),
			]
		);

		$task->add_control(
			'title_tag',
			[
				'label'   => __( 'Title tag', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1'   => __( 'H1', 'kata-plus' ),
					'h2'   => __( 'H2', 'kata-plus' ),
					'h3'   => __( 'H3', 'kata-plus' ),
					'h4'   => __( 'H4', 'kata-plus' ),
					'h5'   => __( 'H5', 'kata-plus' ),
					'h6'   => __( 'H6', 'kata-plus' ),
					'p'    => __( 'P', 'kata-plus' ),
					'span' => __( 'Span', 'kata-plus' ),
				],
			]
		);

		$task->add_control(
			'content', [
				'label'   => __( 'Content', 'kata-plus' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' , 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$task->add_control(
			'content_tag',
			[
				'label'   => __( 'Content tag', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'p',
				'options' => [
					'h1'   => __( 'H1', 'kata-plus' ),
					'h2'   => __( 'H2', 'kata-plus' ),
					'h3'   => __( 'H3', 'kata-plus' ),
					'h4'   => __( 'H4', 'kata-plus' ),
					'h5'   => __( 'H5', 'kata-plus' ),
					'h6'   => __( 'H6', 'kata-plus' ),
					'p'    => __( 'P', 'kata-plus' ),
					'span' => __( 'Span', 'kata-plus' ),
				],
			]
		);

		$task->add_control(
			'styler_title_repeater_wrapper',
			[
				'label'     => esc_html__( 'Content wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors( '{{CURRENT_ITEM}} .task-process' ),
			]
		);

		$this->add_control(
			'tasks',
			[
				'label'   => __( 'Task Process', 'kata-plus' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $task->get_controls(),
				'default' => [
					[
						'number'  => __( '1', 'kata-plus' ),
						'title'   => __( 'Title', 'kata-plus' ),
						'content' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'kata-plus' ),
					],
					[
						'number'  => __( '1', 'kata-plus' ),
						'title'   => __( 'Title', 'kata-plus' ),
						'content' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'kata-plus' ),
					],
					[
						'number'  => __( '1', 'kata-plus' ),
						'title'   => __( 'Title', 'kata-plus' ),
						'content' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'kata-plus' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'carousel',
			[
				'label'        => __( 'Carousel', 'kata-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'kata-plus' ),
				'label_off'    => __( 'No', 'kata-plus' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'kata-plus' ),
				'condition' => [
					'carousel' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'inc_owl_item',
			[
				'label'       => __( 'Item', 'kata-plus' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 5,
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
				'label'     => __( 'Pagination Layout', 'kata-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dots'         => __( 'Bullets', 'kata-plus' ),
					'dots-num'     => __( 'Numbers', 'kata-plus' ),
					'dots-and-num' => __( 'Progress bar', 'kata-plus' ),
				],
				'default'   => 'dots',
				'condition' => [
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
			'parent_task_process',
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
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-task-process' ),
			]
		);

		$this->add_control(
			'styler_widget_carousel_stage',
			[
				'label'     => esc_html__( 'Carousel Stage', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-task-process-wrapper .owl-stage-outer' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'task_process',
			[
				'label' => esc_html__( 'Task Process', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_number_wrapper',
			[
				'label'     => esc_html__( 'Number wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-task-process .task-process-number' ),
			]
		);

		$this->add_control(
			'styler_number',
			[
				'label'     => esc_html__( 'Number', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-task-process .task-process-number .process-number' ),
			]
		);

		$this->add_control(
			'styler_title_wrapper',
			[
				'label'     => esc_html__( 'Content wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-task-process .task-process' ),
			]
		);

		$this->add_control(
			'styler_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-task-process .task-process-title' ),
			]
		);

		$this->add_control(
			'styler_content',
			[
				'label'     => esc_html__( 'Content', 'kata-plus' ),
				'type'      => 'kata_styler',
		    	'selectors' => Kata_Styler::selectors(  '.kata-plus-task-process .task-process-content' ),
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
