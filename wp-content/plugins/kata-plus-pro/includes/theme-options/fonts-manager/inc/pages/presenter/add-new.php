<?php
/**
 * FontsManager_Add_New_Page_Presenter.
 *
 * @author      author
 * @package     package
 * @since       1.0.0
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

if ( ! class_exists( 'FontsManager_Add_New_Page_Presenter' ) ) :
	class FontsManager_Add_New_Page_Presenter extends WP_List_Table {

		/**
		 * Instance of this class.
		 *
		 * @since     1.0.0
		 * @access     private
		 * @var     FontsManager_Add_New_Page_Presenter
		 */
		private static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Define the core functionality of the FontsManager_Add_New_Page_Presenter.
		 *
		 * Load the dependencies.
		 *
		 * @since     1.0.0
		 */
		function __construct() {
			$this->definitions();
			$this->actions();
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions() {
			// add_filter( 'set-screen-option', [ $this, 'set_screen' ], 10, 3 );
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			parent::__construct(
				[
					'singular' => esc_html__( 'Font', 'kata-plus' ),
					'plural'   => esc_html__( 'Fonts', 'kata-plus' ),
					'ajax'     => true,
				]
			);
		}

		/**
		 * Get Fonts
		 *
		 * @since   1.0.0
		 */
		public static function get_sources( $per_page = 5, $page_number = 1 ) {
			$data = array();
			$data = [
				array(
					'id'          => 'google',
					'title'       => 'Google Fonts',
					'description' => 'All the fonts in <b>Google Fonts</b> are free and open source, making beautiful type accessible to anyone for any project. This means you can share favorites and collaborate easily with friends and colleagues. Google Fonts takes care of all the licensing and hosting, ensuring that the latest and greatest version of any font is available to everyone',
				),
				/*
				 array(
					'id'            => 'font-squirrel',
					'title'         => 'Font Squirrel',
					'description'   => "Font Squirrel is a collection of free fonts for commercial use.\n\nApart from Google fonts, Font Squirrel requires to download and install fonts in order to use them. Installation process is automatic, just hit the <strong>Download</strong> button.\n\nChoose between <strong>900+</strong> available fonts to use with your site."
				), */
				array(
					'id'          => 'typekit',
					'title'       => 'Adobe Fonts (formerly TypeKit)',
					'description' => "<b>Adobe Fonts</b> is an online service which offers a subscription library of high-quality fonts. The fonts may be used directly on websites or synced via Adobe Creative Cloud to applications on the subscriber's computers",
				),
				array(
					'id'          => 'upload-font',
					'title'       => 'Uploaded Font',
					'description' => 'If you have your desired font file, for example woff2, woff, eot, ttf and svg, then you can simply upload them and use your desired font family. This method is compatible with GDPR as well, which allows you to experience a very high load speed',
				),
				array(
					'id'          => 'custom-font',
					'title'       => 'Custom Font (Deprecated)',
					'description' => "If you own a custom font family that has been hosted somewhere else and you intend to import it using a URL, then simply enter the stylesheet URL that includes @font-face's and specify the font variant names",
				),
				// array(
				// 	'id'          => 'upload-icon',
				// 	'title'       => 'Upload Icon',
				// 	'description' => "If you own a custom icon that has been hosted somewhere else and you intend to import it using a URL, then simply enter the stylesheet URL that includes @font-face's and specify the font variant names",
				// ),
			];
			return $data;
		}

		/**
		 * delete_font
		 *
		 * @since   1.0.0
		 */
		public static function delete_font( $id ) {
			global $wpdb;

			$wpdb->delete(
				$wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
				[ 'ID' => $id ],
				[ '%d' ]
			);
		}

		/**
		 * Record Count
		 *
		 * @since   1.0.0
		 */
		public static function record_count() {
			return count( self::get_sources() );
		}

		/**
		 * Record Count
		 *
		 * @since   1.0.0
		 */
		public function no_items() {
			_e( 'No Font Available.', 'kata-plus' );
		}

		public function get_columns() {
			$columns = [
				'cb'          => '',
				'title'       => __( 'Source', 'kata-plus' ),
				'description' => __( 'Description', 'kata-plus' ),
			];

			return $columns;
		}

		public function column_cb( $item ) {
			return sprintf(
				'<input type="radio" name="source" value="%s" required="required" />',
				$item['id']
			);
		}

		public function column_title( $item ) {
			$kata_options   = get_option( 'kata_options' );
			$img = $kata_options['prefers_color_scheme'] == 'dark' ? $item['id'] . '-dark' : $item['id'];
			$url    = Kata_Plus::$assets . 'images/fonts-manager/' . $img . '.png';
			$iframe = '<img src="' . esc_url( $url ) . '" width="150">';
			return $iframe;
		}

		protected function get_table_classes() {
			return array( 'widefat', 'kata-font-manager-add-new-table' );
		}

		/**
		 * Record Count
		 *
		 * @since   1.0.0
		 */
		public function column_description( $item ) {
			return $item['description'];
		}

		public function prepare_items() {

			$columns  = $this->get_columns();
			$hidden   = $this->get_hidden_columns();
			$sortable = $this->get_sortable_columns();
			$data     = $this->get_sources();

			usort( $data, array( &$this, 'sort_data' ) );

			$perPage     = 20;
			$currentPage = $this->get_pagenum();
			$totalItems  = count( $data );

			$this->set_pagination_args(
				array(
					'total_items' => $totalItems,
					'per_page'    => $perPage,
				)
			);

			$data = array_slice( $data, ( ( $currentPage - 1 ) * $perPage ), $perPage );

			$this->_column_headers = array( $columns, $hidden, $sortable );
			$this->items           = $data;

		}


		/**
		 * Define which columns are hidden
		 *
		 * @return Array
		 */
		public function get_hidden_columns() {
			return array();
		}

		/**
		 * Render
		 *
		 * @since     1.0.0
		 */
		public function render() {
			include Kata_Plus_Pro_FontsManager_Add_New_Page_Controller::$dir . 'views/add-new.php';
			return;
		}

	} //Class
endif;
