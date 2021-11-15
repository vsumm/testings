<?php


use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Kata_Plus_pro_Taxonomies_Url extends Tag {

	public function get_name() {
		return 'kata-plus-pro-tax-url';
	}

	public function get_title() {
		return __( 'Taxonomies URL', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'URL';
	}

	public function get_categories() {
		return [
			TagsModule::URL_CATEGORY
		];
    }

    public function get_categories_list() {

		$items = [
            '' => __( 'Select...', 'kata-plus-pro' ),
        ];

        $terms = get_categories();
		foreach ( $terms as $term ) {
			$items[ $term->term_id ] = $term->name;
		}

        return $items;
    }

	public function is_settings_required() {
		return true;
	}

	protected function _register_controls() {
		$this->add_control(
			'key',
			[
				'label'   => __( 'Categories URL', 'kata-plus-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_categories_list(),
				'default' => ''
            ]
        );
	}

	protected function get_category_url() {
		if( $key = $this->get_settings( 'key' ) ){
			return get_category_link( $key );
		}

		return '';
	}

	public function get_value( array $options = [] ) {
		return $this->get_category_url();
	}

	public function render() {
		echo $this->get_category_url();
	}

}
