<?php


use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Archive_Title extends Tag {
	public function get_name() {
		return 'kata-plus-pro-archive-title';
	}

	public function get_title() {
		return __( 'Archive Title', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'archive';
	}

	public function get_categories() {
		return [ TagsModule::TEXT_CATEGORY ];
	}

	public function render() {
		echo get_the_title();
	}
}
