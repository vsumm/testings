<?php


use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Author_Meta extends Tag {

	public function get_name() {
		return 'kata-plus-pro-author-meta';
	}

	public function get_title() {
		return __( 'Author Meta', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'author';
	}

	public function get_categories() {
		return [ TagsModule::TEXT_CATEGORY ];
	}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	public function render() {
		$key = $this->get_settings( 'key' );
		if ( empty( $key ) ) {
			return;
		}

		$value = get_the_author_meta( $key );

		echo wp_kses_post( $value );
	}

	protected function _register_controls() {
		$this->add_control(
			'key',
			[
				'label' => __( 'Meta Key', 'kata-plus-pro' ),
			]
		);
	}
}
