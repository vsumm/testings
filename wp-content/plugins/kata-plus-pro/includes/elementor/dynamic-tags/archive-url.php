<?php


use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Archive_URL extends Data_Tag {

	public function get_name() {
		return 'kata-plus-pro-archive-url';
	}

	public function get_group() {
		return 'URL';
	}

	public function get_categories() {
		return [ TagsModule::URL_CATEGORY ];
	}

	public function get_title() {
		return __( 'Archive URL', 'kata-plus-pro' );
	}

	public function get_archive_list() {

		$items = [
            '' => __( 'Select...', 'kata-plus-pro' ),
        ];
		
		$items = array_merge( $items, Kata_Plus_Helpers::get_post_types_with_archive() );

        return $items;
	}
	
	public function is_settings_required() {
		return true;
	}

	protected function _register_controls() {
		$this->add_control(
			'key',
			[
				'label'   => __( 'Archives URL', 'kata-plus-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_archive_list(),
				'default' => ''
            ]
        );
	}

	protected function get_archive_url() {
		if( $key = $this->get_settings( 'key' ) ){
			return get_post_type_archive_link( $key );
		}

		return '';
	}

	public function get_value( array $options = [] ) {
		return $this->get_archive_url();
	}

	public function render() {
		echo $this->get_archive_url();
	}
}

