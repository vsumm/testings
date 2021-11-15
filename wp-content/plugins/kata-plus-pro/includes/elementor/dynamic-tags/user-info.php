<?php


use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_User_Info extends Tag {

	public function get_name() {
		return 'kata-plus-pro-user-info';
	}

	public function get_title() {
		return __( 'User Info', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'site';
	}

	public function get_categories() {
		return [ TagsModule::TEXT_CATEGORY ];
	}

	public function render() {
		$type = $this->get_settings( 'type' );
		$user = wp_get_current_user();
		if ( empty( $type ) || 0 === $user->ID ) {
			return;
		}

		$value = '';
		switch ( $type ) {
			case 'login':
			case 'email':
			case 'url':
			case 'nicename':
				$field = 'user_' . $type;
				$value = isset( $user->$field ) ? $user->$field : '';
				break;
			case 'id':
			case 'description':
			case 'first_name':
			case 'last_name':
			case 'display_name':
				$value = isset( $user->$type ) ? $user->$type : '';
				break;
			case 'meta':
				$key = $this->get_settings( 'meta_key' );
				if ( ! empty( $key ) ) {
					$value = get_user_meta( $user->ID, $key, true );
				}
				break;
		}

		echo wp_kses_post( $value );
	}

	public function get_panel_template_setting_key() {
		return 'type';
	}

	protected function _register_controls() {
		$this->add_control(
			'type',
			[
				'label' => __( 'Field', 'kata-plus-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Choose', 'kata-plus-pro' ),
					'id' => __( 'ID', 'kata-plus-pro' ),
					'display_name' => __( 'Display Name', 'kata-plus-pro' ),
					'login' => __( 'Username', 'kata-plus-pro' ),
					'first_name' => __( 'First Name', 'kata-plus-pro' ),
					'last_name' => __( 'Last Name', 'kata-plus-pro' ),
					'description' => __( 'Bio', 'kata-plus-pro' ),
					'email' => __( 'Email', 'kata-plus-pro' ),
					'url' => __( 'Website', 'kata-plus-pro' ),
					'meta' => __( 'User Meta', 'kata-plus-pro' ),
				],
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label' => __( 'Meta Key', 'kata-plus-pro' ),
				'condition' => [
					'type' => 'meta',
				],
			]
		);
	}
}
