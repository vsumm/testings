<?php


use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Request_Parameter extends Tag {
	public function get_name() {
		return 'kata-plus-pro-request-parameter';
	}

	public function get_title() {
		return __( 'Request Parameter', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'site';
	}

	public function get_categories() {
		return [
			TagsModule::TEXT_CATEGORY,
			TagsModule::POST_META_CATEGORY,
		];
	}

	public function render() {
		$settings = $this->get_settings();
		$request_type = isset( $settings['request_type'] ) ? strtoupper( $settings['request_type'] ) : false;
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : false;
		$value = '';

		if ( ! $param_name || ! $request_type ) {
			return '';
		}

		switch ( $request_type ) {
			case 'POST':
				if ( ! isset( $_POST[ $param_name ] ) ) {
					return '';
				}
				$value = $_POST[ $param_name ];
				break;
			case 'GET':
				if ( ! isset( $_GET[ $param_name ] ) ) {
					return '';
				}
				$value = $_GET[ $param_name ];
				break;
			case 'QUERY_VAR':
				$value = get_query_var( $param_name );
				break;
		}
		echo htmlentities( wp_kses_post( $value ) );
	}

	protected function _register_controls() {
		$this->add_control(
			'request_type',
			[
				'label'   => __( 'Type', 'kata-plus-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'get',
				'options' => [
					'get' => 'Get',
					'post' => 'Post',
					'query_var' => 'Query Var',
				],
			]
		);
		$this->add_control(
			'param_name',
			[
				'label'   => __( 'Parameter Name', 'kata-plus-pro' ),
				'type' => Controls_Manager::TEXT,
			]
		);
	}
}
