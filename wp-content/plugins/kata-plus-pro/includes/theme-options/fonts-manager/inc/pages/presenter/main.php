<?php
/**
 * FontsManager_Main_Page_Presenter.
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

if ( ! class_exists( 'FontsManager_Main_Page_Presenter' ) ) :
	class FontsManager_Main_Page_Presenter extends WP_List_Table {

		/**
		 * Instance of this class.
		 *
		 * @since     1.0.0
		 * @access     private
		 * @var     FontsManager_Main_Page_Presenter
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
		 * Define the core functionality of the FontsManager_Main_Page_Presenter.
		 *
		 * Load the dependencies.
		 *
		 * @since     1.0.0
		 */
		function __construct() {
			$this->parser();
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
		  * Parser
		  *
		  * @since     1.0.0
		  */
		public function parser() {
			if ( 'delete' === $this->current_action() ) {

				// In our file that handles the request, verify the nonce.
				$nonce = esc_attr( $_REQUEST['_wpnonce'] );

				if ( ! wp_verify_nonce( $nonce, 'delete-action' . $_REQUEST['font_id'] ) ) {
					die( 'Go get a life script kiddies' );
				} else {
					if ( ! self::delete_font( absint( $_GET['font_id'] ) ) ) {
						$class   = 'notice notice-warning';
						$message = esc_html__( "Sorry, we couldn't find the font!", 'kata-plus' );
						printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
					} else {
						$class   = 'notice notice-success';
						$message = esc_html__( 'The font was successfully deleted', 'kata-plus' );
						printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
					}
				}
			}
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
					'ajax'     => false,
				]
			);
		}

		/**
		 * Get Fonts
		 *
		 * @since   1.0.0
		 */
		public static function get_fonts() {
			global $wpdb;

			$sql = 'SELECT * FROM ' . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name;
			$sql .= ' WHERE source<>"upload-icon"';
			if ( ! empty( $_REQUEST['orderby'] ) ) {
				$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
				$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
			} else {
				$sql .= ' ORDER BY ' . esc_sql( 'created_at' ) . ' ASC';
			}
			$wpdb->hide_errors();
			$result = $wpdb->get_results( $sql, 'ARRAY_A' );
			if(strpos($wpdb->last_error,"doesn't exist")) {
				$sql = 'SELECT * FROM ' . $wpdb->prefix . 'kata_plus_pro_typography_fonts';
				$wpdb->hide_errors();
				$result = $wpdb->get_results($sql, 'ARRAY_A');
				if (strpos($wpdb->last_error, "doesn't exist")) {
					$charset_collate = $wpdb->get_charset_collate();
					$sql = 'CREATE TABLE ' . $wpdb->prefix . \Kata_Plus_Pro::$fonts_table_name . " (
						ID int(9) NOT NULL AUTO_INCREMENT,
						name text NOT NULL,
						source varchar(200) NOT NULL,
						selectors text NOT NULL,
						subsets text NOT NULL,
						variants text NOT NULL,
						url text DEFAULT '' NOT NULL,
						place varchar(50) NOT NULL DEFAULT 'before_head_end',
						status varchar(50) NOT NULL DEFAULT 'publish',
						created_at int(12) NOT NULL,
						updated_at int(12) NOT NULL,
						PRIMARY KEY  (ID)
					) $charset_collate;";

					require_once ABSPATH . 'wp-admin/includes/upgrade.php';
					dbDelta($sql);
				}

				return static::get_fonts();
			}

			return $result;
		}

		/**
		 * delete_font
		 *
		 * @since   1.0.0
		 */
		public static function delete_font( $id ) {
			global $wpdb;
			try {
				update_option( 'kata-fonts-manager-last-update', time() );
				return $wpdb->delete(
					$wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
					[ 'ID' => $id ],
					[ '%d' ]
				);
			} catch ( \Throwable $th ) {
				return false;
			}
			return true;
		}

		/**
		 * Change font status
		 *
		 * @since   1.0.0
		 */
		public static function change_font_status( $id, $status ) {
			global $wpdb;
			try {
				update_option( 'kata-fonts-manager-last-update', time() );
				return $wpdb->update(
					$wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
					[ 'status' => $status ],
					[ 'ID' => $id ]
				);
			} catch ( \Throwable $th ) {
				return false;
			}
			return true;
		}

		/**
		 * Record Count
		 *
		 * @since   1.0.0
		 */
		public static function record_count() {
			global $wpdb;

			$sql = 'SELECT COUNT( * ) FROM ' . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name;

			return $wpdb->get_var( $sql );
		}

		/**
		 * Record Count
		 *
		 * @since   1.0.0
		 */
		public function no_items() {
			_e( 'No Font Available.', 'kata-plus' );
		}

		public function get_bulk_actions() {
			$actions = [
				'bulk-delete'      => 'Delete',
				'bulk-unpublished' => 'Unpublished',
				'bulk-published'   => 'Published',
			];

			return $actions;
		}

		public function get_columns() {
			$columns = [
				'cb'      => '<input type="checkbox" />',
				'name'    => __( 'Name', 'kata-plus' ),
				'preview' => esc_html__( 'Font Preview', 'kata-plus' ),
				'source'  => esc_html__( 'Source', 'kata-plus' ),
				'status'  => esc_html__( 'Status', 'kata-plus' ),
			];

			return $columns;
		}

		public function column_preview( $item ) {
			if ( $item['source'] == 'font-squirrel' ) {
				return '<img src="' . $item['url'] . '" alt="' . $item['name'] . '">';
			} elseif ( $item['source'] == 'upload-font' ) {

				if ( ! empty( $item['url'] ) ) {
					$fontNames = json_decode($item['name']);
					$fontSubfamilies = json_decode($item['subsets']);
					$fontWeights = json_decode($item['variants']);
					foreach(json_decode($item['url']) as $extension => $data):
						foreach ($data as $key => $url) {
							$fontName = $fontNames->$extension->$key;
							$fontSubfamily = $fontSubfamilies->$extension->$key;
							$fontWeight = $fontWeights->$extension->$key;
							$fontMD5 = md5($fontName . $item['source'] . $item['url'] . $fontWeight . $fontSubfamily);
							$temp_file = get_option($fontMD5, false);
							if ($temp_file  && file_exists($temp_file->path)) {
								$temp_file_path = $temp_file->url;
							} else {
								delete_option($fontMD5);
								$_REQUEST['font-size'] = get_option('kata.plus.fonts_manager.font.preview.size', 13);
								$_REQUEST['font-family'] = $fontName;
								$_REQUEST['source'] = $item['source'];
								$_REQUEST['font-weight'] = str_replace('"', '', $fontWeight);
								$_REQUEST['font-style'] = str_replace(['"', 'regular'],['','normal'], strtolower($fontSubfamily));
								$_REQUEST['single-line'] = 'true';
								$_REQUEST['url-'.$extension] = $url;
								$fontPreviewContent = Kata_Plus_Pro_FontsManager_Helpers::render_font_preview(true);
								$temp_file = Kata_Plus_Pro_FontsManager_Helpers::save_to_disk_as_temp($fontPreviewContent, $fontMD5 . '.html', true);
								$temp_file_path = $temp_file->url;
								update_option($fontMD5, $temp_file, true);
							}
							return '<iframe src="'. $temp_file_path.'" frameborder="0" style="width: 100%;display: block;position: relative;padding: 10px;border: none;margin-top: 0px;height: 60px;padding-top: 0;"></iframe>';
						}
					endforeach;
				}
				return '';
			} else {
				$src = admin_url( 'admin-ajax.php' ) . '?action=
				&single-line=true&font-family=' . $item['name'] . '&source=' . $item['source'];
				if ( ! empty( $item['url'] ) ) {
					$src .= '&url=' . $item['url'];
				}

				$fontMD5 = md5($item['name'] . $item['source'] . $item['url']);
				$temp_file = get_option($fontMD5, false);
				if ($temp_file  && file_exists($temp_file->path)) {
					$temp_file_path = $temp_file->url;
				} else {
					delete_option($fontMD5);
					$_REQUEST['font-family'] = $item['name'];
					$_REQUEST['source'] = $item['source'];
					$_REQUEST['url'] = $item['url'];
					$_REQUEST['single-line'] = 'true';

					$fontPreviewContent = Kata_Plus_Pro_FontsManager_Helpers::render_font_preview(true);
					$temp_file = Kata_Plus_Pro_FontsManager_Helpers::save_to_disk_as_temp($fontPreviewContent, $fontMD5 . '.html', true);
					$temp_file_path = $temp_file->url;
					update_option($fontMD5, $temp_file, true);
				}
				$iframe = '
                <iframe src="' . $temp_file_path . '" class="font-preview-iframe"></iframe>
                ';
				return $iframe;
			}
		}

		public function column_source( $item ) {
			switch ( $item['source'] ) {
				case 'google':
					return '<img src="' . Kata_Plus::$assets . 'images/fonts-manager/google.png' . '" class="provider-logo-img">';
					break;
				case 'font-squirrel':
					return '<img src="' . Kata_Plus::$assets . 'images/fonts-manager/font-squirrel.png' . '" class="provider-logo-img">';
					break;
				case 'custom-font':
					return '<img src="' . Kata_Plus::$assets . 'images/fonts-manager/custom-font.png' . '" class="provider-logo-img">';
					break;
				case 'typekit':
					return '<img src="' . Kata_Plus::$assets . 'images/fonts-manager/typekit.png' . '" class="provider-logo-img">';
					break;
				case 'upload-font':
					return '<img src="' . Kata_Plus::$assets . 'images/fonts-manager/upload-font.png' . '" class="provider-logo-img">';
					break;
			}

			return '';
		}

		 /**
		  * Description
		  *
		  * @since     1.0.0
		  */
		public function column_status( $item ) {
			switch ( $item['status'] ) {
				case 'published':
					return '<span class="published"><span class="dashicons dashicons-yes"></span> Published</span>';
					break;
				default:
					return '<span class="unpublished"><span class="dashicons dashicons-no"></span> UnPublished</span>';
					break;
			}
		}

		public function column_cb( $item ) {
			return sprintf(
				'<label><input type="checkbox" name="bulk-actions[]" value="%s" />' . esc_attr__( 'Select for bulk actions', 'kata-plus' ) . '</label>',
				$item['ID']
			);
		}

		public function column_default( $item, $column_name ) {
			switch ( $column_name ) {
				case 'name':
					return $item[ $column_name ];
				default:
					return print_r( $item, true ); // Show the whole array for troubleshooting purposes
			}
		}

		protected function get_table_classes() {
			return array( 'widefat', 'fixed', 'kata-font-manager-main-table' );
		}

		public function process_bulk_action() {

			// If the delete bulk action is triggered
			if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
				 || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
			) {
				$_POST['bulk-actions'] = !isset( $_POST['bulk-actions'] ) ? [] : $_POST['bulk-actions'];
				$delete_ids = esc_sql( $_POST['bulk-actions'] );

				$error_count   = 0;
				$success_count = 0;
				// loop over the array of record IDs and delete them
				foreach ( $delete_ids as $id ) {
					if ( ! self::delete_font( $id ) ) {
						$error_count++;
					} else {
						$success_count++;
					}
				}
				if ( $error_count ) {
					$class   = 'notice notice-warning';
					$message = "Sorry, we couldn't find $error_count's font!";
					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
				}
				if ( $success_count ) {
					$class   = 'notice notice-success';
					$message = "The $success_count's font was deleted successfully";
					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
				}
			} elseif ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-unpublished' )
			|| ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-unpublished' )
			) {
				$_POST['bulk-actions'] = !isset( $_POST['bulk-actions'] ) ? [] : $_POST['bulk-actions'];
				$delete_ids = esc_sql( $_POST['bulk-actions'] );

				$error_count   = 0;
				$success_count = 0;
				// loop over the array of record IDs and delete them
				foreach ( $delete_ids as $id ) {
					if ( ! self::change_font_status( $id, 'unpublished' ) ) {
						$error_count++;
					} else {
						$success_count++;
					}
				}
				if ( $error_count ) {
					$class   = 'notice notice-warning';
					$message = "Sorry, we couldn't find $error_count's font!";
					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
				}
				if ( $success_count ) {
					$class   = 'notice notice-success';
					$message = "The $success_count's font was changed status to unpublished successfully";
					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
				}
			} elseif ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-published' )
			|| ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-published' )
			) {

				$_POST['bulk-actions'] = !isset( $_POST['bulk-actions'] ) ? [] : $_POST['bulk-actions'];
				$fonts_ids     = esc_sql( $_POST['bulk-actions'] );
				$error_count   = 0;
				$success_count = 0;
				// loop over the array of record IDs and delete them
				foreach ( $fonts_ids as $id ) {
					if ( ! self::change_font_status( $id, 'published' ) ) {
						$error_count++;
					} else {
						$success_count++;
					}
				}
				if ( $error_count ) {
					$class   = 'notice notice-warning';
					$message = "Sorry, we couldn't find $error_count's font!";
					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
				}
				if ( $success_count ) {
					$class   = 'notice notice-success';
					$message = "The $success_count's font was changed status to published successfully";
					printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
				}
			}
		}

		/**
		 * Record Count
		 *
		 * @since   1.0.0
		 */
		public function column_name( $item ) {

			$nonce   = wp_create_nonce( 'delete-action' . $item['ID'] );
			$actions = array(
				'edit'   => sprintf( '<a href="?page=kata-plus-fonts-manager&action=edit&font_id=%s&_wpnonce=%s&source=%s">%s</a>', $item['ID'], $nonce, $item['source'], __( 'Edit', 'kata-plus' ) ),
				'delete' => sprintf( '<a href="?page=kata-plus-fonts-manager&action=delete&font_id=%s&_wpnonce=%s">%s</a>', $item['ID'], $nonce, __( 'Delete', 'kata-plus' ) ),
			);
			if ($item['source'] == 'typekit' || $item['source'] == 'custom-font') {
				$item['name'] = explode(', ', $item['name'])[0];
			} elseif ( $item['source'] == 'upload-font' ) {
				if ( ! empty( $item['url'] ) ) {
					$fontNames = json_decode($item['name']);
					foreach(json_decode($item['url']) as $extension => $data):
						foreach ($data as $key => $url) {
							$fontName = $fontNames->$extension->$key;
							$font_family = '<span class="font-family-name">' . $fontName . '</span>';
							return sprintf(
								'%s %s',
								$font_family,
								$this->row_actions( $actions )
							);
						}
					endforeach;
				}
				return '';
			}
			$font_family = '<span class="font-family-name">' . $item['name'] . '</span>';
			return sprintf(
				'%s %s',
				$font_family,
				$this->row_actions( $actions )
			);
		}

		public function get_sortable_columns() {

			$sortable_columns = array(
				'name' => array( 'name', true ),
			);

			return $sortable_columns;
		}

		public function prepare_items() {
			$this->process_bulk_action();
			$columns  = $this->get_columns();
			$hidden   = $this->get_hidden_columns();
			$sortable = $this->get_sortable_columns();
			$data     = $this->get_fonts();

			usort( $data, array( &$this, 'sort_data' ) );

			$perPage     = 60;
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

		private function sort_data( $a, $b ) {
			// Set defaults
			$orderby = 'created_at';
			$order   = 'desc';
			// If orderby is set, use this as the sort column
			if ( ! empty( $_GET['orderby'] ) ) {
				$orderby = $_GET['orderby'];
			}
			// If order is set use this as the order
			if ( ! empty( $_GET['order'] ) ) {
				$order = $_GET['order'];
			}
			$result = strcmp( $a[ $orderby ], $b[ $orderby ] );
			if ( $order === 'asc' ) {
				return $result;
			}
			return -$result;
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
			include Kata_Plus_Pro_FontsManager_Main_Page_Controller::$dir . 'views/main.php';
			return;
		}

	} //Class
endif;
