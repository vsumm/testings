<?php
/**
 * Countdown module config.
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

class Kata_Plus_Pro_Countdown extends Widget_Base {
	public function get_name() {
		return 'kata-plus-countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'kata-plus' );
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-countdown';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor' ];
	}

	public function get_script_depends() {
		return [ 'jquery-countdown', 'kata-plus-countdown' ];
	}

	public function get_style_depends() {
		return [ 'kata-plus-countdown' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'General', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'type',
			[
				'label'   => __( 'Countdown Type', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'	 	=> __('Default', 'kata-plus'),
					'advanced'     => __( 'Advanced', 'kata-plus' ),
					'basic'        => __( 'Basic', 'kata-plus' ),
					'legacy_style' => __( 'Legacy style', 'kata-plus' ),
					'mawo'         => __( 'Months and weeks offsets', 'kata-plus' ),
					'sothr'        => __( 'Sum of total hours remaining', 'kata-plus' ),
				],
			]
		);

		$this->add_control(
			'wmd',
			[
				'label'   => __( 'Start with', 'kata-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'days',
				'options' => [
					'weeks'  => __( 'Weeks', 'kata-plus' ),
					'months' => __( 'Months', 'kata-plus' ),
					'days'   => __( 'Days', 'kata-plus' ),
				],
				'condition' => [
					'type' => 'mawo',
				],
			]
		);
		$this->add_control(
			'date',
			[
				'label' => __( 'Date', 'kata-plus' ),
				'type'  => Controls_Manager::DATE_TIME,
				'default' => __( '2020-12-31 12:00', 'kata-plus' ),
			]
		);
		$this->add_control(
			'month',
			[
				'label' => __('Month Text', 'kata-plus'),
				'type'  => Controls_Manager::TEXT,
				'default' => __('Months', 'kata-plus'),
			]
		);
		$this->add_control(
			'week',
			[
				'label' => __('Week Text', 'kata-plus'),
				'type'  => Controls_Manager::TEXT,
				'default' => __('Weeks', 'kata-plus'),
			]
		);
		$this->add_control(
			'day',
			[
				'label' => __('Day Text', 'kata-plus'),
				'type'  => Controls_Manager::TEXT,
				'default' => __('Days', 'kata-plus'),
			]
		);
		$this->add_control(
			'hour',
			[
				'label' => __( 'Hour Text', 'kata-plus' ),
				'type'  => Controls_Manager::TEXT,
				'default' => __( 'Hours', 'kata-plus' ),
			]
		);
		$this->add_control(
			'minute',
			[
				'label' => __('Minute Text', 'kata-plus'),
				'type'  => Controls_Manager::TEXT,
				'default' => __('Minutes', 'kata-plus'),
			]
		);
		$this->add_control(
			'second',
			[
				'label' => __('Second Text', 'kata-plus'),
				'type'  => Controls_Manager::TEXT,
				'default' => __('Seconds', 'kata-plus'),
			]
		);
		$this->add_control(
			'message',
			[
				'label'   => __( 'Expiration Message', 'kata-plus' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'This offer has expired', 'kata-plus' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Styler', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_num',
			[
				'label'     => __( 'Numbers', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-countdown .countdown-num' ),
			]
		);
		$this->add_control(
			'styler_time_period',
			[
				'label'     => 'Time Period',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-countdown .countdown-h' ),
			]
		);
		$this->add_control(
			'styler_message',
			[
				'label'     => 'Expiration Message',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-countdown.disabled .kata-countdown-time' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_month',
			[
				'label' => esc_html__('Month', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_month_wrapper',
			[
				'label'     => 'Wrapper',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .month-wrapper'),
			]
		);
		$this->add_control(
			'styler_month_num',
			[
				'label'     => 'Number',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .month-num'),
			]
		);
		$this->add_control(
			'styler_month_title',
			[
				'label'     => 'Title',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .month-h'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_week',
			[
				'label' => esc_html__('Week', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_week_wrapper',
			[
				'label'     => 'Wrapper',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .week-wrapper'),
			]
		);
		$this->add_control(
			'styler_week_num',
			[
				'label'     => 'Number',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .week-num'),
			]
		);
		$this->add_control(
			'styler_week_title',
			[
				'label'     => 'Title',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .week-h'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_day',
			[
				'label' => esc_html__('Day', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_day_wrapper',
			[
				'label'     => 'Wrapper',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .day-wrapper'),
			]
		);
		$this->add_control(
			'styler_day_num',
			[
				'label'     => 'Number',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .day-num'),
			]
		);
		$this->add_control(
			'styler_day_title',
			[
				'label'     => 'Title',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .day-h'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_hour',
			[
				'label' => esc_html__('Hour', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_hour_wrapper',
			[
				'label'     => 'Wrapper',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .hour-wrapper'),
			]
		);
		$this->add_control(
			'styler_hour_num',
			[
				'label'     => 'Number',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .hour-num'),
			]
		);

		$this->add_control(
			'styler_hour_title',
			[
				'label'     => 'Title',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .hour-h'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_minute',
			[
				'label' => esc_html__('Minute', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_minute_wrapper',
			[
				'label'     => 'Wrapper',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .minute-wrapper'),
			]
		);
		$this->add_control(
			'styler_minute_num',
			[
				'label'     => 'Number',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .minute-num'),
			]
		);

		$this->add_control(
			'styler_minute_title',
			[
				'label'     => 'Title',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .minute-h'),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_second',
			[
				'label' => esc_html__('Second', 'kata-plus'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'styler_second_wrapper',
			[
				'label'     => 'Wrapper',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .second-wrapper'),
			]
		);

		$this->add_control(
			'styler_second_num',
			[
				'label'     => 'Number',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .second-num'),
			]
		);

		$this->add_control(
			'styler_second_title',
			[
				'label'     => 'Title',
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors('.kata-countdown .second-h'),
			]
		);
		$this->end_controls_section();
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
