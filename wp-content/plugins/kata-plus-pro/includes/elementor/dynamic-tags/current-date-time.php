<?php


use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Current_Date_Time extends Tag {

	public function get_name() {
		return 'kata-plus-pro-current-date-time';
	}

	public function get_title() {
		return __( 'Current Date Time', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'site';
	}

	public function get_categories() {
		return [ TagsModule::TEXT_CATEGORY ];
	}

	protected function _register_controls() {
		$this->add_control(
			'date_format',
			[
				'label' => __( 'Date Format', 'kata-plus-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'kata-plus-pro' ),
					'' => __( 'None', 'kata-plus-pro' ),
					'F j, Y' => date( 'F j, Y' ),
					'Y-m-d' => date( 'Y-m-d' ),
					'm/d/Y' => date( 'm/d/Y' ),
					'd/m/Y' => date( 'd/m/Y' ),
					'custom' => __( 'Custom', 'kata-plus-pro' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'time_format',
			[
				'label' => __( 'Time Format', 'kata-plus-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'kata-plus-pro' ),
					'' => __( 'None', 'kata-plus-pro' ),
					'g:i a' => date( 'g:i a' ),
					'g:i A' => date( 'g:i A' ),
					'H:i' => date( 'H:i' ),
				],
				'default' => 'default',
				'condition' => [
					'date_format!' => 'custom',
				],
			]
		);

		$this->add_control(
			'custom_format',
			[
				'label' => __( 'Custom Format', 'kata-plus-pro' ),
				'default' => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
				'description' => sprintf( '<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">%s</a>', __( 'Documentation on date and time formatting', 'kata-plus-pro' ) ),
				'condition' => [
					'date_format' => 'custom',
				],
			]
		);
	}

	public function render() {
		$settings = $this->get_settings();

		if ( 'custom' === $settings['date_format'] ) {
			$format = $settings['custom_format'];
		} else {
			$date_format = $settings['date_format'];
			$time_format = $settings['time_format'];
			$format = '';

			if ( 'default' === $date_format ) {
				$date_format = get_option( 'date_format' );
			}

			if ( 'default' === $time_format ) {
				$time_format = get_option( 'time_format' );
			}

			if ( $date_format ) {
				$format = $date_format;
				$has_date = true;
			} else {
				$has_date = false;
			}

			if ( $time_format ) {
				if ( $has_date ) {
					$format .= ' ';
				}
				$format .= $time_format;
			}
		}

		$value = date_i18n( $format );

		echo wp_kses_post( $value );
	}
}
