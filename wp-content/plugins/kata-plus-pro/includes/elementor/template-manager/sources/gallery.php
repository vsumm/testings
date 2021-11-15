<?php

/**
 * Kata Plus Pro Template Library Source Gallery Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}
class KataPlus_Template_Library_Source_Gallery extends \Elementor\TemplateLibrary\Source_Base {

	public function get_id() {
		return 'gallery';
	}

	public function get_title() {
		return __( 'Gallery', 'kata-plus' );
	}

	public function register_data() {}

	public function get_items( $args = [] ) {
		$data = Kata_Plus_Pro_Template_Manager_WebService::get_templates();
		$library_data = [];
		foreach ($data as $template) {
			if ($template['subtype'] != 'gallery') {
				continue;
			}

			$library_data[] = $this->prepare_template($template);
		}

		return $library_data;
	}

	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}

	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a remote source' );
	}

	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a remote source' );
	}

	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a remote source' );
	}

	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a remote source' );
	}

	public function get_data( array $args, $context = 'display' ) {
		$data = Kata_Plus_Pro_Template_Manager_WebService::get_template( $args['template_id'] );

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id = $args['editor_post_id'];
		$document = \Elementor\Plugin::$instance->documents->get( $post_id );
		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}

	private function prepare_template( array $template_data ) {
		$favorite_templates = $this->get_user_meta( 'favorites' );

		return [
			'template_id' => $template_data['id'],
			'source' => $this->get_id(),
			'type' => '',
			'subtype' => $template_data['subtype'],
			'title' => $template_data['title'],
			'thumbnail' => $template_data['thumbnail'],
			'date' => $template_data['tmpl_created'],
			'author' => $template_data['author'],
			// 'tags' => json_decode( $template_data['tags'] ),
			// 'plugins' => $this->prepare_template_plugins( $template_data['plugins'] ),
			// 'inactive_plugins' => $this->prepare_template_inactive_plugins( $template_data['plugins'] ),
			'isPro' => ( '1' === $template_data['is_pro'] ),
			'popularityIndex' => (int) $template_data['popularity_index'],
			'trendIndex' => (int) $template_data['trend_index'],
			'hasPageSettings' => ( '1' === $template_data['has_page_settings'] ),
			'url' => $template_data['url'],
			'favorite' => ! empty( $favorite_templates[ $template_data['id'] ] ),
		];
	}

	private function prepare_template_inactive_plugins( $plugins ) {
		$inactive_plugins = array_diff( $plugins, get_option( 'active_plugins' ) );

		return array_keys( $inactive_plugins );
	}

	private function prepare_template_plugins( $plugins ) {
		$plugins = array_keys( $plugins );

		foreach( $plugins as $key => $plugin ) {
			$plugins[ $key ] = strtolower( str_replace( ' ', '-', $plugin ) );
		}

		return $plugins;
	}
}
