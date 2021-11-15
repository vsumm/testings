<?php


use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Author_Profile_Picture extends Data_Tag {

	public function get_name() {
		return 'kata-plus-pro-author-profile-picture';
	}

	public function get_title() {
		return __( 'Author Profile Picture', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'author';
	}

	public function get_categories() {
		return [ TagsModule::IMAGE_CATEGORY ];
	}

	public function get_value( array $options = [] ) {
		return [
			'id' => '',
			'url' => get_avatar_url( (int) get_the_author_meta( 'ID' ) ),
		];
	}
}
