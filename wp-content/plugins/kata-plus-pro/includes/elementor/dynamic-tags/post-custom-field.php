<?php


use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Post_Custom_Field extends Tag {

	public function get_name() {
		return 'kata-plus-pro-post-custom-field';
	}

	public function get_title() {
		return __( 'Post Custom Field', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'post';
	}

	public function get_categories() {
		return [
			TagsModule::TEXT_CATEGORY,
			TagsModule::URL_CATEGORY,
			TagsModule::POST_META_CATEGORY
		];
	}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	public function is_settings_required() {
		return true;
	}

	protected function _register_controls() {
		$this->add_control(
			'key',
			[
				'label' => __( 'Key List', 'kata-plus-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_custom_keys_array(),
			]
		);

		$this->add_control(
			'custom_key',
			[
				'label' => __( 'Custom Key', 'kata-plus-pro' ),
				'type' => Controls_Manager::TEXT,
				'options' => $this->get_custom_keys_array(),
                'condition'    => array(
                    'key' => '',
                )
			]
		);
	}

	public function render() {
		$key = $this->get_settings( 'key' );
		$handy_custom_keys = $this->get_settings( 'handy_custom_keys' );
		$key = empty( $key ) ? ( empty( $handy_custom_keys ) ? $this->get_settings( 'custom_key' ) : $handy_custom_keys ) : $key;

		if ( empty( $key ) ) {
			return;
		}

		$value = get_post_meta( get_the_ID(), $key, true );

		echo wp_kses_post( $value );
	}

	private function get_custom_keys_array() {
		$custom_keys = get_post_custom_keys();
		$options = [
			'' => __( 'Select...', 'kata-plus-pro' ),
		];

		if ( ! empty( $custom_keys ) ) {
			foreach ( $custom_keys as $custom_key ) {
				if ( '_' !== substr( $custom_key, 0, 1 ) ) {
					$options[ $custom_key ] = $custom_key;
				}
			}
		}

		return $options;
	}
}
