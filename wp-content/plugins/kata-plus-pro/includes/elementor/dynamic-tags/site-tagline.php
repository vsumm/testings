<?php

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Kata_Plus_Pro_Site_Tagline extends Tag {
	public function get_name() {
		return 'kata-plus-pro-site-tagline';
	}

	public function get_title() {
		return __( 'Site Tagline', 'kata-plus-pro' );
	}

	public function get_group() {
		return 'site';
	}

	public function get_categories() {
		return [ TagsModule::TEXT_CATEGORY ];
	}

	public function render() {
		echo wp_kses_post( get_bloginfo( 'description' ) );
	}
}
