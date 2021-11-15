<?php

/**
 * Kata_Plus_Pro FontsManager.
 *
 * @author     ClimaxThemes
 * @package    Kata Plus
 * @since      1.0.0
 */

// don't load directly.
if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

if (!class_exists('Kata_Plus_Pro_FontsManager')) :
	class Kata_Plus_Pro_FontsManager
	{

		/**
		 * The directory of the file.
		 *
		 * @access  public
		 * @var     string
		 */
		public static $dir;

		/**
		 * Instance of this class.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      Kata_Plus_Pro_FontsManager
		 */
		private static $instance;

		/**
		 * There is fonts_manager ?
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      boolean
		 */
		public static $is_fonts_manager = false;

		/**
		 * Define the core functionality of the KataPlus FontsManager.
		 *
		 * Load the dependencies.
		 *
		 * @since     1.0.0
		 */
		function __construct()
		{
			$this->definitions();
			$this->actions();
			$this->dependencies();
		}

		/**
		 * check_is_fonts_manager
		 *
		 * @since     1.0.0
		 */
		public function check_is_fonts_manager()
		{
			$screen = get_current_screen();
			if (in_array($screen->id, array('kata_page_kata-plus-fonts-manager'))) {
				self::$is_fonts_manager = true;
			}
		}

		/**
		 * scripts
		 *
		 * @since     1.0.0
		 */
		public function scripts()
		{
			$screen = get_current_screen();
			if (in_array($screen->id, array('kata_page_kata-plus-fonts-manager'))) {
				self::$is_fonts_manager = true;
				wp_enqueue_script('kata-plus-fonts-manager-js', Kata_Plus::$assets . 'js/backend/fonts-manager.js', 'jquery', Kata_Plus_Pro::$version, true);
			}
			wp_enqueue_script('plupload-all');
		}

		public function kata_plus_pro_custom_upload_mimes($mimes = array())
		{
			$refer = @$_SERVER['HTTP_REFERER'];
			if (self::$is_fonts_manager || strpos($refer, '?page=kata-plus-fonts-manager') !== false) {
				// Add a key and value for the CSV file type
				$mimes          = [];
				$mimes['ttf']   = 'application/x-font-ttf|application/octet-stream|font/ttf';
				$mimes['ttf']   = 'application/x-font-ttf|application/octet-stream|font/ttf';
				$mimes['otf']   = 'application/x-font-opentype';
				$mimes['eot']   = 'application/vnd.ms-fontobject|application/octet-stream|application/x-vnd.ms-fontobject';
				$mimes['svg']   = 'image/svg+xml|application/octet-stream|image/x-svg+xml';
				$mimes['json']   = 'application/json';
				$mimes['woff']  = 'font/woff|application/font-woff|application/x-font-woff|application/octet-stream';
				$mimes['woff2'] = 'font/woff2|application/octet-stream|font/x-woff2';
			}
			return $mimes;
		}

		public function fixWPCheckFiletypeAndExt($data, $file, $filename, $mimes)
		{

			if (!empty($data['ext']) && !empty($data['type'])) {
				return $data;
			}

			$registered_file_types = [
				'ttf'   => 'application/x-font-ttf|application/octet-stream|font/ttf',
				'eot'   => 'application/vnd.ms-fontobject|application/octet-stream|application/x-vnd.ms-fontobject',
				'otf'   => 'application/x-font-opentype',
				'json'   => 'application/json',
				'svg'   => 'image/svg+xml|application/octet-stream|image/x-svg+xml',
				'woff'  => 'font/woff|application/font-woff|application/x-font-woff|application/octet-stream',
				'woff2' => 'font/woff2|application/octet-stream|font/x-woff2',
			];
			$filetype              = wp_check_filetype($filename, $mimes);
			if (!isset($registered_file_types[$filetype['ext']])) {
				return $data;
			}

			return array(
				'ext'             => $filetype['ext'],
				'type'            => $filetype['type'],
				'proper_filename' => $data['proper_filename'],
			);
		}

		public function change_upload_dir($param)
		{
			$refer = @$_SERVER['HTTP_REFERER'];
			if (self::$is_fonts_manager || strpos($refer, '?page=kata-plus-fonts-manager') !== false) {
				$mydir         = '/kata/fonts';
				$param['path'] = $param['basedir'] . $mydir;
				$param['url']  = $param['baseurl'] . $mydir;
			}
			return $param;
		}

		/**
		 * Enqueue Style
		 *
		 * @since     1.0.0
		 */
		public function enqueue_style()
		{
			if (self::$is_fonts_manager) {
				wp_enqueue_style('kata-plus-fonts-manager', Kata_Plus::$assets . 'css/backend/fonts-manager.css', null, Kata_Plus_Pro::$version, false);
				if ( is_rtl() ) {
					wp_enqueue_style('kata-plus-fonts-manager-rtl', Kata_Plus::$assets . 'css/backend/fonts-manager-rtl.css', null, Kata_Plus_Pro::$version, false);
				}
			}
		}

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance()
		{
			if (self::$instance === null) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Add actions.
		 *
		 * @since   1.0.0
		 */
		public function actions()
		{
			add_action('current_screen', [$this, 'check_is_fonts_manager'], 100);
			add_action('admin_enqueue_scripts', [$this, 'scripts']);
			add_action('admin_enqueue_scripts', [$this, 'enqueue_style']);

			if (self::$is_fonts_manager) {
				add_filter('upload_mimes', [$this, 'kata_plus_pro_custom_upload_mimes']);
				add_filter('upload_dir', [$this, 'change_upload_dir']);
				add_filter('wp_check_filetype_and_ext', [$this, 'fixWPCheckFiletypeAndExt'], 10, 4);
			}
			
			add_action('wp_ajax_kata_plus_pro_fonts_manager_font_preview', ['Kata_Plus_Pro_FontsManager_Helpers', 'render_font_preview']);
			add_action('wp_ajax_kata_plus_pro_fonts_manager_get_font_data', ['Kata_Plus_Pro_FontsManager_Helpers', 'get_font_data_html']);
			add_action('wp_ajax_kata_plus_pro_get_font_data_by_typekit_id', ['Kata_Plus_Pro_FontsManager_Helpers', 'get_typekit_data_html']);
			add_action('wp_ajax_kata_plus_pro_get_font_data_by_custom_font_id', ['Kata_Plus_Pro_FontsManager_Helpers', 'get_custom_font_data_html']);
			add_action('wp_head', [$this, 'render_fonts_manager_fonts_in_footer'], 100);
			add_action('kata_plus_pro_fonts_manager_render_view_start', [$this, 'get_header']);
			add_action('kata_plus_pro_fonts_manager_render_view_end', [$this, 'get_footer']);
			add_action('wp_ajax_kata_plus_pro_fonts_manager_fonts_upload', [$this, 'upload_fonts']);
			add_action('wp_ajax_kata_plus_pro_fonts_manager_upload_icon', [$this, 'upload_icons']);
			add_action('wp_ajax_fonts-manager-change-font-preview-font-size', [$this, 'change_preview_font_size']);
			add_action('kata-icon-box-filter-icons-after', [$this, 'upload_icon_menu_list_v2'], 10);
			add_action('kata-icon-box-management-section', [$this, 'upload_icon_menu_list'], 10);
			add_action('kata-icon-box-add-new-icon-pack-section', [$this, 'upload_new_icon_pack_content'], 10);
			add_action('kata-icon-box-icon-pack-section', [$this, 'upload_icon_icons_list'], 10);
			add_action('wp_ajax_kata_plus_pro_delete_icon_pack', [$this, 'delete_icon_pack'], 10);
			add_action('wp_ajax_kata_plus_pro_delete_icon_from_pack', [$this, 'delete_icon_from_pack'], 10);
			add_action('wp_ajax_kata_plus_pro_update_icon_pack_name', [$this, 'update_icon_pack_name'], 10);
			add_action('wp_ajax_kata_plus_pro_new_icon_pack', [$this, 'new_icon_pack'], 10);
			add_filter('kata-get-icon-dir', [$this, 'get_icon_dir'], 10, 1);
			add_filter('pre_handle_404', [$this, 'fix_wrong_svg_request'], 10, 1);
			add_action(
				'admin_head',
				function () {
					$screen = get_current_screen();
					if (self::$is_fonts_manager && $screen->id == 'kata_page_kata-plus-fonts-manager') {
						do_action('kata_plus_control_panel');
					}
				},
				100
			);
		}

		/**
		 * Fix Wrong Requested SVG URL
		 *
		 * @since     1.0.0
		 */
		public function fix_wrong_svg_request($preempt)
		{
			$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$extension = preg_replace('/.*[.](.*?)/is', '$1', basename($actual_link));
			if (strtolower($extension) == 'svg') {
				$actual_link = str_replace('.svg/', '.svg', $actual_link);
				$icon = realpath(preg_replace('#' . Kata_Plus::$assets . 'fonts/svg-icons/.*?/' . '#i', Kata_Plus_Pro::$upload_dir . '/icons/', $actual_link));
				if ($icon) {
					header("HTTP/1.1 200 OK");
					header('Content-type: image/svg+xml');
					echo file_get_contents($icon);
					die();
				}
			}
			return $preempt;
		}


		/**
		 * Fix SVG Icons path
		 *
		 * @since     1.0.0
		 */
		public function get_icon_dir($file)
		{
			if (!is_file($file)) {
				if (is_file(Kata_Plus_Pro::$upload_dir . '/icons/' . basename($file))) {
					$file = realpath(Kata_Plus_Pro::$upload_dir . '/icons/' . basename($file));
				}
			}
			return $file;
		}

		/**
		 * Delete Icon Pack via Ajax Request
		 *
		 * @since     1.0.0
		 */
		public function delete_icon_pack()
		{
			if (!is_admin()) {
				return;
			}
			$id = esc_attr($_REQUEST['id']);
			global $wpdb;
			try {
				update_option('kata-fonts-manager-last-update', time());
				return $wpdb->delete(
					$wpdb->prefix . Kata_Plus_Pro::$fonts_table_name,
					['ID' => $id],
					['%d']
				);
			} catch (\Throwable $th) {
				wp_send_json_error([
					'status' => 'error',
					'message' => __('The Icon Pack Does not Exists!', 'kata-plus')
				]);
				wp_die();
			}

			wp_send_json([
				'status' => 'success',
			]);
			wp_die();
		}

		/**
		 * Delete Icon From Icon Pack via Ajax Request
		 *
		 * @since     1.0.0
		 */
		public function delete_icon_from_pack()
		{
			if (!is_admin()) {
				return;
			}
			$id = esc_attr($_REQUEST['id']);
			$key = esc_attr($_REQUEST['key']);
			global $wpdb;
			$sql = "SELECT * FROM " . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE ID=" . $id;
			$result = $wpdb->get_results($sql, 'ARRAY_A');
			$current_font = current($result);
			if (!$current_font || $current_font['source'] != 'upload-icon') {
				wp_send_json([
					'status' => 'error',
				]);
				wp_die();
			}
			$saved_icons = json_decode($current_font['selectors'], true);
			if (isset($saved_icons[$key])) {
				$icon_pack_name = $current_font['name'];
				unset($saved_icons[$key]);
				Kata_Plus_Pro_FontsManager_Helpers::edit_font($id, 'upload-icon', '', $icon_pack_name, '', '', $saved_icons, 'head', 'published');
			}

			wp_send_json([
				'status' => 'success',
			]);
			wp_die();
		}

		/**
		 * Delete Icon From Icon Pack via Ajax Request
		 *
		 * @since     1.0.0
		 */
		public function update_icon_pack_name()
		{
			if (!is_admin()) {
				return;
			}
			$id = esc_attr($_REQUEST['id']);
			$name = esc_attr($_REQUEST['name']);
			global $wpdb;
			$sql = "SELECT * FROM " . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE ID=" . $id;
			$result = $wpdb->get_results($sql, 'ARRAY_A');
			$current_font = current($result);
			if (!$current_font || $current_font['source'] != 'upload-icon') {
				wp_send_json([
					'status' => 'error',
				]);
				wp_die();
			}

			$saved_icons = json_decode($current_font['selectors'], true);
			if (!$saved_icons) {
				$saved_icons = @gzuncompress(base64_decode($current_font['selectors']));
				$saved_icons = json_decode($saved_icons, true);
				if (!$saved_icons) {
					$saved_icons = [];
				}
			}
			Kata_Plus_Pro_FontsManager_Helpers::edit_font($id, 'upload-icon', '', $name, '', '', $saved_icons, 'head', 'published');
			wp_send_json([
				'status' => 'success',
			]);
			wp_die();
		}

		/**
		 * New Icon Pack
		 *
		 * @since     1.0.0
		 */
		public function new_icon_pack()
		{
			if (!is_admin()) {
				return;
			}

			global $wpdb;

			$icon_pack_name = esc_attr($_REQUEST['name']);
			$sql    = 'SELECT * FROM ' . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE name='". $icon_pack_name ."'";
			$result = $wpdb->get_results( $sql, 'ARRAY_A' );
			if($result) {
				wp_send_json([
					'status' => 'error',
					'message' => __('Entered icon name is exist! please enter an other icon name.', 'kata-plus')
				]);
				wp_die();
			}


			$id = Kata_Plus_Pro_FontsManager_Helpers::add_new_font(
				'upload-icon',
				'',
				$icon_pack_name,
				'',
				'',
				[],
				'head',
				'published'
			);
			$editHash = md5(microtime());
			$html  = '<li data-id="' . $id . '" data-delete-message="' . __('Are you sure for deleting this icon pack?', 'kata-plus') . '" data-name="' . strtolower(str_replace(' ', '_', $icon_pack_name)) . $id . '">';
			$html .= '<a href="#">' . $icon_pack_name . '</a>';
			$html .= '<div class="buttons-wrap">';
			$html .= '<span class="delete-icon-pack">' . __('Delete', 'kata-plus') . '</span>';
			$html .= '<span class="edit-icon-pack ' . $editHash . '">' . __('Edit', 'kata-plus') . '</span>';
			$html .= '</div>';
			$html .= '</li>';

			$menuHtml  = '<li data-id="' . $id . '" data-name="' . strtolower(str_replace(' ', '_', $icon_pack_name)) . $id . '">';
			$menuHtml .= '<a href="#">' . $icon_pack_name . '</a>';
			$menuHtml .= '</li>';


			$iconWrapHtml  = '<ul class="icon-pack-wrap" data-delete-message="' . __('Are you sure for deleting this icon?', 'kata-plus') . '" data-pack="' . strtolower(str_replace(' ', '_', $icon_pack_name)) . $id . '">';
			$iconWrapHtml .= '<span class="save-and-close-edit-area" data-id="' . $id . '" data-pack="' . strtolower(str_replace(' ', '_', $icon_pack_name)) . $id . '">' . __('Save & Close') . '</span>';
			$iconWrapHtml .= '<input type="text" value="' . $icon_pack_name . '" class="icon-pack-name">';
			$iconWrapHtml .= '</ul>';

			wp_send_json([
				'status' => 'success',
				'hash' => $editHash,
				'html' => $html,
				'iconWrapHtml' => $iconWrapHtml,
				'menuHtml' => $menuHtml
			]);
			wp_die();
		}

		/**
		 * Render Uploaded Icons List in Icon Box Results
		 *
		 * @since     1.0.0
		 */
		public function upload_icon_icons_list()
		{
			global $wpdb;

			$sql = 'SELECT * FROM ' . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE source='upload-icon'";

			if (!empty($_REQUEST['orderby'])) {
				$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
				$sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
			} else {
				$sql .= ' ORDER BY ' . esc_sql('created_at') . ' ASC';
			}
			$wpdb->hide_errors();
			$result = $wpdb->get_results($sql, 'ARRAY_A');

			foreach ($result as  $pack) {
				$icons = json_decode($pack['selectors'], true);
				if (!$icons) {
					$icons = @gzuncompress(base64_decode($pack['selectors']));
					$icons = json_decode($icons, true);
					if (!$icons) {
						$icons = [];
					}
				}
				$title = $pack['name'];
				$font_family = esc_attr(strtolower(str_replace(' ', '_', $pack['name']))) . $pack['ID'];
				echo '<ul class="icon-pack-wrap" data-delete-message="' . __('Are you sure for deleting this icon?', 'kata-plus') . '" data-pack="' . $font_family . '">';
				echo '<span class="save-and-close-edit-area" data-id="' . $pack['ID'] . '" data-pack="' . $font_family . '">' . __('Save & Close') . '</span>';
				echo '<input type="text" value="' . $pack['name'] . '" class="icon-pack-name">';
				foreach ($icons as $icon) {
					$entry = str_replace('.svg', '', basename($icon['path']));
					$name  = str_replace([' ', '-'], '_', $entry);
					$icon['path'] = str_replace(Kata_Plus_Pro::$upload_dir, Kata_Plus_Pro::$upload_dir_url, $icon['path']);
					echo '
					<li data-font-family="' . $font_family . '" data-name="' . $font_family . '/' . $entry . '">
						<span class="remove-icon" data-key="' . $icon['key'] . '" data-id="' .  $pack['ID'] . '">×</span>
						<input type="radio" name="icon" data-name="' . $font_family . '/' . $entry . '" id="' . $name . '" value="' . $name . '">
						<label><img class="lozad" data-src="' . $icon['path'] . '" style="width: 20px;" title="' . $title . '" alt="' . $title . '"></label>
					</li>';
				}
				echo '</ul>';
			}
		}

		/**
		 * Render Uploaded Icons List in Icon Box Results
		 *
		 * @since     1.0.0
		 */
		public function upload_new_icon_pack_content()
		{
			$plupload_init = array(
				'runtimes'            => 'html5,silverlight,flash,html4',
				'browse_button'       => 'plupload-browse-button',
				'container'           => 'plupload-upload-ui',
				'drop_element'        => 'drag-drop-area',
				'file_data_name'      => 'async-upload',
				'multiple_queues'     => true,
				'max_file_size'       => wp_max_upload_size() . 'b',
				'url'                 => admin_url('admin-ajax.php'),
				'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
				'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
				'filters'             => array(
					array(
						'title'      => __('Allowed Files'),
						'extensions' => 'json,svg',
					),
				),
				'multipart'           => true,
				'urlstream_upload'    => true,

				// additional post data to send to our ajax hook
				'multipart_params'    => array(
					'_ajax_nonce' => wp_create_nonce('fonts-upload'),
					'action'      => 'kata_plus_pro_fonts_manager_upload_icon',
				),
			);
			// we should probably not apply this filter, plugins may expect wp's media uploader...
			$plupload_init = apply_filters('plupload_init', $plupload_init);
?>
			<div id="plupload-upload-ui" class="hide-if-no-js">
				<div id="drag-drop-area">
					<div class="drag-drop-inside">
						<p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
						<p><?php _ex('or', 'Uploader: Drop font files here - or - Select Files'); ?></p>
						<p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
						<p class="allowed-files"><?php echo __('Allowed Files', 'kata-plus'); ?>: <span><?php echo __('"*.json" like "selection.json" & "SVG" Icon Images', 'kata-plus'); ?></span></p>
						<input type="hidden" id="uploaded-icons-pack-id">
						<input type="hidden" id="uploaded-icons-pack-family">
					</div>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {

					// create the uploader and pass the config from above
					var uploader = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>);

					// checks if browser supports drag and drop upload, makes some css adjustments if necessary
					uploader.bind('Init', function(up) {
						var icon_pack_id = jQuery('#plupload-upload-ui #uploaded-icons-pack-id').val();
						var icon_pack_family = jQuery('.section.icon-pack-section .icon-pack-wrap.active .icon-pack-name').val();
						if (icon_pack_id) {
							up.settings.multipart_params['pack_id'] = icon_pack_id;
							up.settings.multipart_params['fontfamily'] = icon_pack_family;
						}
						var uploaddiv = $('#plupload-upload-ui');

						if (up.features.dragdrop) {
							uploaddiv.addClass('drag-drop');
							$('#drag-drop-area')
								.bind('dragover.wp-uploader', function() {
									uploaddiv.addClass('drag-over');
								})
								.bind('dragleave.wp-uploader, drop.wp-uploader', function() {
									uploaddiv.removeClass('drag-over');
								});

						} else {
							uploaddiv.removeClass('drag-drop');
							$('#drag-drop-area').unbind('.wp-uploader');
						}
					});

					uploader.init();

					// a file was added in the queue
					uploader.bind('FilesAdded', function(up, files) {
						var icon_pack_id = jQuery('#plupload-upload-ui #uploaded-icons-pack-id').val();
						var icon_pack_family = jQuery('.kata-icons-dialog .section.icon-pack-section .icon-pack-wrap.active input.icon-pack-name').val();
						if (icon_pack_id) {
							up.settings.multipart_params['pack_id'] = icon_pack_id;
							up.settings.multipart_params['fontfamily'] = icon_pack_family;
						}
						up.refresh();
						up.start();
					});

					// a file was uploaded
					uploader.bind('FileUploaded', function(up, file, response) {
						if (typeof(response.response) == 'undefined') {
							return false;
						}
						var objData = JSON.parse(response.response);
						if (typeof(objData.message) != 'undefined') {
							$('.add-new-icon-pack-section').before(
								'<div class="notice notice-info" style="display:block !important;"><p><strong>' + objData.message + '</strong></p></div>'
							);
							return false;
						}
						$('.icon-pack-wrap.active .icon-pack-name').after(objData.html);
						jQuery('#kata-icons-dialog .icons-management-area').getNiceScroll().resize();
					});

				});
			</script>
<?php
		}

		/**
		 * Render Uploaded Icons List in Icon Box Menu
		 *
		 * @since     1.0.0
		 */
		public function upload_icon_menu_list()
		{
			global $wpdb;

			$sql = 'SELECT * FROM ' . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE source='upload-icon'";

			if (!empty($_REQUEST['orderby'])) {
				$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
				$sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
			} else {
				$sql .= ' ORDER BY ' . esc_sql('created_at') . ' ASC';
			}
			$wpdb->hide_errors();
			$result = $wpdb->get_results($sql, 'ARRAY_A');
			echo '<div class="kata-back-wrap"><a href="#">' . __('Back', 'kata-plus') . '</a></div>';
			echo '<div class="kata-new-pack-wrap"><a href="#">' . __('New Pack', 'kata-plus') . '</a></div>';
			echo '<ul class="kata-icon-packs-list">';
			foreach ($result as  $pack) {
				echo '<li class="icon-pack-wrapper" data-id="' . $pack['ID'] . '" data-delete-message="' . __('Are you sure for deleting this icon pack?', 'kata-plus') . '" data-name="' . esc_attr(strtolower(str_replace(' ', '_', $pack['name']))) . $pack['ID'] . '">';
				echo '<a href="#">' . esc_html($pack['name']) . '</a>';
				echo '<div class="buttons-wrap">';
				echo '<span class="delete-icon-pack">' . __('Delete', 'kata-plus') . '</span>';
				echo '<span class="edit-icon-pack">' . __('Edit', 'kata-plus') . '</span>';
				echo '</div>';
				echo '</li>';
			}
			echo '</ul>';
		}

		/**
		 * Render Uploaded Icons List in Icon Box Menu
		 *
		 * @since     1.0.0
		 */
		public function upload_icon_menu_list_v2()
		{
			global $wpdb;

			$sql = 'SELECT * FROM ' . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE source='upload-icon'";

			if (!empty($_REQUEST['orderby'])) {
				$sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
				$sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
			} else {
				$sql .= ' ORDER BY ' . esc_sql('created_at') . ' ASC';
			}
			$wpdb->hide_errors();
			$result = $wpdb->get_results($sql, 'ARRAY_A');
			if($result) {
				echo '<li data-name="uploaded-icons">';
			} else {
				echo '<li data-name="uploaded-icons" class="hidden">';
			}

			echo '<div class="styler-tooltip more-menu-btn" data-tooltip="More">' . __( 'Custom', 'kata-plus' ) . '<i class="eicon-ellipsis-v"></i></div>';
			echo '<ul class="kata-icon-packs-menu">';
			foreach ($result as  $pack) {
				echo '<li data-id="' . $pack['ID'] . '" data-name="' . esc_attr(strtolower(str_replace(' ', '_', $pack['name']))) . $pack['ID'] . '">';
				echo '<a href="#">' . esc_html($pack['name']) . '</a>';
				echo '</li>';
			}
			echo '</ul>';
			echo '</li>';

		}

		/**
		 * Upload Fonts
		 *
		 * @since     1.0.0
		 */
		public function change_preview_font_size()
		{
			if (!is_admin()) {
				wp_die();
			}

			if (isset($_REQUEST['fontSize'])) {
				update_option('kata.plus.fonts_manager.font.preview.size', $_REQUEST['fontSize']);
			}
			die();
		}

		/**
		 * Upload Fonts
		 *
		 * @since     1.0.0
		 */
		public function upload_fonts()
		{
			if (!is_admin()) {
				wp_die();
			}
			check_ajax_referer('fonts-upload');

			$extension = preg_replace('/.*[.](.*?)/is', '$1', $_FILES['async-upload']['name']);
			$fontname  = str_replace('.' . $extension, '', $_FILES['async-upload']['name']);
			if ($extension == 'woff2') {
				$status = wp_handle_upload(
					$_FILES['async-upload'],
					array(
						'test_form' => true,
						'action'    => 'kata_plus_pro_fonts_manager_fonts_upload',
						'extension' => $extension,
					)
				);

				$fontProperties = $status['url'];
				$html = '
				<div class="font-pack has-iframe" data-pack-hash="' . md5($fontProperties) . '" data-font-pack="' . $fontname . '" data-extension="' . $extension . '">
					<input type="hidden" name="url[' . $extension . '][' . md5($fontProperties) . ']" value="' . $status['url'] . '">
					<label>Font Family <input type="text" name="fontname[' . $extension . '][' . md5($fontProperties) . ']" value="' . $fontname . '" required="required"></label>
					<label>Font Style <input type="text" name="font_style[' . $extension . '][' . md5($fontProperties) . ']" value="normal" required="required"></label>
					<label>Font Weight <input type="text" name="font_weight[' . $extension . '][' . md5($fontProperties) . ']" value="normal" required="required"></label>
					<span class="font-extenstion">' . $extension . '</span>
				</div>';
				$data  = [
					'extension' => $extension,
					'html'      => $html,
					'hash'      => md5($fontProperties),
				];

				header('Content-Type: application/json');
				echo json_encode($data);
				die();
			}
			require realpath(static::$dir . 'inc/vendor/autoload.php');
			$font      = \FontLib\Font::load($_FILES['async-upload']['tmp_name']);
			try {
				$font->parse();
			} catch (\Throwable $th) {
				header('Content-Type: application/json');
				echo json_encode(['message' => esc_attr__('Selected file is corrupted!', 'kata-plus')]);
				die();
			}

			$status = wp_handle_upload(
				$_FILES['async-upload'],
				array(
					'test_form' => true,
					'action'    => 'kata_plus_pro_fonts_manager_fonts_upload',
					'extension' => $extension,
				)
			);
			// and output the results or something...
			$fontProperties = $extension . $font->getFontName() . $font->getFontSubfamily() . $font->getFontWeight();

			$src  = admin_url('admin-ajax.php') . '?action=kata_plus_pro_fonts_manager_font_preview&font-family=' . $font->getFontName() . '&source=upload-font&single-line=true&font-weight=' . str_replace('"', '', $font->getFontWeight()) . '&font-style=' . str_replace(['"', 'regular'], ['', 'normal'], strtolower($font->getFontSubfamily()));
			$_src = $src . '&url-' . $extension . '=' . $status['url'];
			$html = '<div class="font-pack has-iframe" data-pack-hash="' . md5($fontProperties) . '" data-font-pack="' . $font->getFontName() . '" data-extension="' . $extension . '">
			<input type="hidden" name="url[' . $extension . '][' . md5($fontProperties) . ']" value="' . $status['url'] . '">
				<iframe src="' . $_src . '" frameborder="0" style="width: 100%;display: block;position: relative;padding: 10px;border: none;margin-top: 0px;height: 60px;padding-top: 0;"></iframe>
				<div class="font-pack-footer">
					<h3>' . $font->getFontName() . '</h3>
					<span class="font-style">Font Style: ' . $font->getFontSubfamily() . '</span>
					<span class="font-weight">Font Weight: ' . $font->getFontWeight() . '</span>
					<span class="font-extenstion">' . $extension . '</span>
				</div>
			</div>';

			$html .= '<input type="hidden" name="fontname[' . $extension . '][' . md5($fontProperties) . ']" value="' . $font->getFontName() . '">';
			$html .= '<input type="hidden" name="font_style[' . $extension . '][' . md5($fontProperties) . ']" value="' . $font->getFontSubfamily() . '">';
			$html .= '<input type="hidden" name="font_weight[' . $extension . '][' . md5($fontProperties) . ']" value="' . $font->getFontWeight() . '">';
			$data  = [
				'extension' => $extension,
				'html'      => $html,
				'hash'      => md5($fontProperties),
			];

			header('Content-Type: application/json');
			wp_send_json($data);
			wp_die();
		}

		/**
		 * Upload Icons
		 *
		 * @since     1.0.0
		 */
		public function upload_icons()
		{
			if (!is_admin()) {
				wp_die();
			}

			$output = '';
			$saved_icons = [];
			$extension = preg_replace('/.*[.](.*?)/is', '$1', $_FILES['async-upload']['name']);
			switch ($extension) {
				case 'json':
					$selections  = file_get_contents($_FILES['async-upload']['tmp_name']);
					$selections = json_decode($selections);
					if (!isset($selections->icons)) {
						header('Content-Type: application/json');
						echo json_encode(['message' => esc_attr__('Selected Json file is not valid!', 'kata-plus')]);
						die();
					}
					$font_family = esc_attr($_POST['fontfamily']);
					$packID = esc_attr($_POST['pack_id']);
					if (isset($_POST['pack_id'])) {
						global $wpdb;
						$sql = "SELECT * FROM " . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE ID=" . esc_attr($_REQUEST['pack_id']);
						$result = $wpdb->get_results($sql, 'ARRAY_A');
						$current_font = current($result);

						$saved_icons = json_decode($current_font['selectors'], true);
						if(!$saved_icons) {
							$saved_icons = @gzuncompress(base64_decode($current_font['selectors']));
							$saved_icons = json_decode($saved_icons, true);
							if(!$saved_icons) {
								$saved_icons = [];
							}
						}
						$icon_pack_name = $current_font['name'];
					}

					foreach ($selections->icons as $icon) {
						$key = $time = md5(microtime());
						$icon_name = $icon->properties->name;
						$content = '';

						if (isset($_POST['pack_id'])) {
							if (isset($icon->paths)) {
								if(!is_array($icon->paths)) {
									$icon->paths = json_decode($icon->paths);
								}

								$content = $this->generate_svg($icon->paths, $icon_name, $selections->preferences->fontPref->metrics->emSize);
								if (!is_dir(Kata_Plus_Pro::$upload_dir . '/icons')) {
									mkdir(Kata_Plus_Pro::$upload_dir . '/icons');
								}
								$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $icon_name . '.svg';
								if (file_exists($destiny)) {
									$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $key . '-' . $icon_name . '.svg';
									$icon_name =  $key . '-' . $icon_name;
								}
								file_put_contents($destiny, $content);
								$saved_icons = array_merge([
									$time => [
										"name" => $icon_name,
										"path" => $destiny,
										"key" => $key
									]
								], $saved_icons);
								// $content = '<label><img class="lozad" src="' . $destiny_url . '" data-src="' . $destiny_url . '" style="width: 20px;" title="' . $icon_name . '" alt="' . $icon_name . '"></label>';
								// $content .= '<textarea style="display:none;" name="icons[' . $time . '][icon]">' . htmlspecialchars($content) . '</textarea>';
							} else {
								if (!is_array($icon->icon->paths)) {
									$icon->icon->paths = json_decode($icon->icon->paths);
								}
								$content = $this->generate_svg($icon->icon->paths, $icon_name, $selections->preferences->fontPref->metrics->emSize);
								if (!is_dir(Kata_Plus_Pro::$upload_dir . '/icons')) {
									mkdir(Kata_Plus_Pro::$upload_dir . '/icons');
								}
								$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $icon_name . '.svg';
								if (file_exists($destiny)) {
									$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $key . '-' . $icon_name . '.svg';
									$icon_name =  $key . '-' . $icon_name;
								}
								file_put_contents($destiny, $content);
								$saved_icons = array_merge([
									$time => [
										"name" => $icon_name,
										"path" => $destiny,
										"key" => $key
									]
								], $saved_icons);
							}
						} else {
							$content = $this->generate_svg($icon->icon->paths, $icon_name, $selections->preferences->fontPref->metrics->emSize);
						}

						$font_family  = str_replace([' ', '-'], '_', $font_family);
						$output .= '<li data-font-family="' . $font_family . '" data-name="' . $font_family . '/' . $icon_name . '">';
						$output .= '<input type="radio" name="icon" data-name="' . $font_family . '/' . $icon_name . '" id="' . $name . '" value="' . $name . '">';
						$output .= '<label><span class="remove-icon" data-key="' . $time . '" data-id="' .  $packID . '">×</span>';
						$output .= $content;
						$output .= '<input type="text" name="icons[' . $time . '][name]" value="' . $icon_name . '">';
						$output .= '</label></li>';
					}
					if (isset($_POST['pack_id'])) {
						$saved_icons = base64_encode(gzcompress(json_encode($saved_icons, true)));
						Kata_Plus_Pro_FontsManager_Helpers::edit_font(
							esc_html($_POST['pack_id']),
							'upload-icon',
							'',
							$icon_pack_name,
							'',
							'',
							$saved_icons,
							'head',
							'published'
						);
					}
					break;
				case 'svg':
					$font_family = esc_attr($_POST['fontfamily']);
					$packID = esc_attr($_POST['pack_id']);
					$time = md5(microtime());
					$content  = file_get_contents($_FILES['async-upload']['tmp_name']);
					$content .= '<textarea style="display:none;" name="icons[' . $time . '][icon]">' . htmlspecialchars($content) . '</textarea>';
					$icon_name = str_replace('.svg', '', $_FILES['async-upload']['name']);
					$name  = str_replace([' ', '-'], '_', $icon_name);
					$font_family  = str_replace([' ', '-'], '_', $font_family);
					if (isset($_POST['pack_id'])) {

						global $wpdb;
						$sql = "SELECT * FROM " . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE ID=" . esc_attr($_REQUEST['pack_id']);
						$result = $wpdb->get_results($sql, 'ARRAY_A');
						$current_font = current($result);
						$saved_icons = json_decode($current_font['selectors'], true);
						$icon_pack_name = $current_font['name'];

						if (!is_dir(Kata_Plus_Pro::$upload_dir . '/icons')) {
							mkdir(Kata_Plus_Pro::$upload_dir . '/icons');
						}
						$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $icon_name . '.svg';
						if (file_exists($destiny)) {
							$destiny = Kata_Plus_Pro::$upload_dir . '/icons/' . $time . '-' . $icon_name . '.svg';
							$icon_name =  $time . '-' . $icon_name;
						}
						file_put_contents($destiny, file_get_contents($_FILES['async-upload']['tmp_name']));
						$saved_icons = array_merge([
							$time => [
								"name" => $icon_name,
								"path" => $destiny,
								"key" => $time
							]
						], $saved_icons);
						Kata_Plus_Pro_FontsManager_Helpers::edit_font(esc_html($_POST['pack_id']), 'upload-icon', '', $font_family, '', '', $saved_icons, 'head', 'published');
					}

					$output .= '<li data-font-family="' . $font_family . '" data-name="' . $font_family . '/' . $icon_name . '">';
					$output .= '<input type="radio" name="icon" data-name="' . $font_family . '/' . $icon_name . '" id="' . $name . '" value="' . $name . '">';
					$output .= '<label><span class="remove-icon" data-key="' . $time . '" data-id="' .  $packID . '">×</span>';
					$output .= $content;
					$output .= '<input type="text" name="icons[' . $time . '][name]" value="' . $icon_name . '">';
					$output .= '</label></li>';
					break;

				default:
					exit();
					break;
			}
			$data  = [
				'extension' => $extension,
				'html'      => $output,
				'hash'      => md5(time()),
			];

			header('Content-Type: application/json');
			wp_send_json($data);
			wp_die();

			exit;
		}

		/**
		 * Generate SVG Content from Icomoon Paths
		 *
		 * @since     1.0.0
		 */
		public function generate_svg($paths, $icon_name = 'SVG Icon', $emSize = '1024')
		{
			$svg = '';
			$svg .= "<svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" width=\"$emSize\" height=\"$emSize\" viewBox=\"0 0 $emSize $emSize\">\n";
			$svg .= "\t" . $icon_name . "\n";
			$svg .= "\t<path d=\"" . implode(" ", $paths) . "\"/>\n";
			$svg .= "</svg>\n";
			return $svg;
		}

		/**
		 * Get FontsManager Header
		 *
		 * @since     1.0.0
		 */
		public static function get_header()
		{
			do_action('kata_plus_pro_fonts_manager_before_header');
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'inc/pages/views', 'header');
		}

		/**
		 * Get FontsManager Footer
		 *
		 * @since     1.0.0
		 */
		public static function get_footer()
		{
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'inc/pages/views', 'footer');
		}


		/**
		 * Render the fonts in head
		 *
		 * @since     1.0.0
		 */
		public static function render_fonts_manager_fonts()
		{

			$fonts = Kata_Plus_Pro_FontsManager_Helpers::get_fonts();
			// $styles = '<style id="kata-plus-fonts-manager-styles">';
			$styles = '';
			$links  = '';
			foreach ($fonts as $font) {
				switch ($font['source']) {
					case 'google':
						$variants = is_array($font['variants']) ? $font['variants'] : json_decode($font['variants'], true);
						$subsets  = is_array($font['subsets']) ? $font['subsets'] : json_decode($font['subsets'], true);
						$variants = is_array($variants) ? implode(',', $variants) : '';
						$subsets  = is_array($variants) ? implode(',', $subsets) : '';

						$links .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . $font['name'] . ':' . $variants . '&amp;' . $subsets . '">' . PHP_EOL;
						break;
					case 'typekit':
					case 'custom-font':
						$links .= '<link rel="stylesheet" href="' . $font['url'] . '">' . PHP_EOL;
						break;
					case 'upload-font':
						$fontNames       = json_decode($font['name']);
						$fontSubfamilies = json_decode($font['subsets']);
						$fontWeights     = json_decode($font['variants']);
						foreach (json_decode($font['url']) as $extension => $data) :
							foreach ($data as $key => $url) {
								$fontName                       = $fontNames->$extension->$key;
								$fontSubfamily                  = $fontSubfamilies->$extension->$key;
								$fontWeight                     = $fontWeights->$extension->$key;
								$src                            = '';
								($extension == 'ttf') ? $src  = 'url(' . $url . ") format('truetype')" : false;
								($extension == 'otf') ? $src  = 'url(' . $url . ") format('opentype')" : false;
								($extension == 'eot') ? $src  = "url('" . $url . "');\n\tsrc: url('" . $url . "?#iefix') format('embedded-opentype')" : false;
								($extension == 'woff') ? $src = 'url(' . $url . ") format('woff')" : false;
								($extension == 'woff2') ? $src = 'url(' . $url . ") format('woff2')" : false;
								$styles                        .= '@font-face {
									font-family: "' . $fontName . '";
									font-style: ' . $fontSubfamily . ';
									font-weight: ' . $fontWeight . ';
									src: ' . $src . ';
								}';
							}
						endforeach;
						break;
				}
				$styles .= '/* Start */' . PHP_EOL;
				$styles .= '/* Font   : `' . $font['name'] . '` */' . PHP_EOL;
				$styles .= '/* Source : `' . $font['source'] . '` */' . PHP_EOL;
				$styles .= Kata_Plus_Pro_FontsManager_Helpers::generate_font_css($font) . PHP_EOL;
				$styles .= '/* End */' . PHP_EOL;
			}

			$view_ports_data = get_option('kata.plus.fonts_manager.font.size');

			if (isset($view_ports_data['viewport']) && is_array($view_ports_data['viewport'])) {
				foreach ($view_ports_data['viewport'] as $viewport => $selector) {
					$styles .= $viewport . "{
                        font-size: {$selector['desktop']}{$view_ports_data['unit'][$selector['id']]}
                    }";
					if ($selector['desktop']) {
						$styles .= <<<Css
                            @media only screen and (max-width: Device_Desktop) {
                                {$viewport} {
                                    font-size: {$selector['desktop']}{$view_ports_data['unit'][$selector['id']]}
                                }
                            }
Css;
					}

					if ($selector['tablet']) {
						$styles .= <<<Css
                            @media only screen and (max-width: Device_Tablet) {
                                {$viewport} {
                                    font-size: {$selector['tablet']}{$view_ports_data['unit'][$selector['id']]}
                                }
                            }
Css;
					}

					if ($selector['mobile']) {
						$styles .= <<<Css
                            @media only screen and (max-width: Device_Mobile) {
                                {$viewport} {
                                    font-size: {$selector['mobile']}{$view_ports_data['unit'][$selector['id']]}
                                }
                            }
Css;
					}
				}
			}
			// $styles .= '</style>';
			$styles = str_replace(
				[
					'Device_Desktop',
					'Device_Tablet',
					'Device_Mobile',
					'font-size: px;',
				],
				[
					Kata_Plus_Pro_FontsManager_Helpers::$viewport_breakpoints['desktop'][1] . 'px',
					Kata_Plus_Pro_FontsManager_Helpers::$viewport_breakpoints['tablet'][1] . 'px',
					Kata_Plus_Pro_FontsManager_Helpers::$viewport_breakpoints['mobile'][1] . 'px',
					'',
				],
				$styles
			);

			$styles = Kata_Plus_Pro_Helpers::cssminifier($styles);

			if ($styles) {
				if (get_option('kata-fonts-manager-file', false)) {
					if (get_option('kata-fonts-manager-last-update', false) == get_option('kata-fonts-manager-time', 'nothing')) {
						if ($css_file_url = get_option('kata-fonts-manager')) {
							wp_enqueue_style('kata-fonts-manager', $css_file_url);
						}
					} else {
						if (file_exists(Kata_Plus_Pro::$upload_dir . '/kata-fonts-manager.css')) {
							@unlink(Kata_Plus_Pro::$upload_dir . '/kata-fonts-manager.css');
						}
						$filename = Kata_Plus_Pro::$upload_dir . '/kata-fonts-manager.css';
						$fileUrl = Kata_Plus_Pro::$upload_dir_url . '/kata-fonts-manager.css';

						file_put_contents($filename, $styles);
						update_option('kata-fonts-manager', $fileUrl);
						update_option('kata-fonts-manager-time', get_option('kata-fonts-manager-last-update', time()));
						update_option('kata-fonts-manager-last-update', get_option('kata-fonts-manager-time'));
						update_option('kata-fonts-manager-file', $filename);
						wp_enqueue_style('kata-fonts-manager', $fileUrl);
					}
				} else {

					if (file_exists(Kata_Plus_Pro::$upload_dir . '/kata-fonts-manager.css')) {
						@unlink(Kata_Plus_Pro::$upload_dir . '/kata-fonts-manager.css');
					}
					$filename = Kata_Plus_Pro::$upload_dir . '/kata-fonts-manager.css';
					$fileUrl = Kata_Plus_Pro::$upload_dir_url . '/kata-fonts-manager.css';
					file_put_contents($filename, $styles);
					update_option('kata-fonts-manager', $fileUrl);
					update_option('kata-fonts-manager-time', get_option('kata-fonts-manager-last-update', time()));
					update_option('kata-fonts-manager-last-update', get_option('kata-fonts-manager-time'));
					update_option('kata-fonts-manager-file', $filename);
					wp_enqueue_style('kata-fonts-manager', $fileUrl);
				}
			}
			echo PHP_EOL;
			echo $links;
			echo PHP_EOL;
		}

		/**
		 * Render the fonts in footer
		 *
		 * @since     1.0.0
		 */
		public static function render_fonts_manager_fonts_in_footer()
		{

			$fonts  = Kata_Plus_Pro_FontsManager_Helpers::get_fonts();
			$styles = '<style id="kata-plus-fonts-manager-styles-body">';
			$links  = '';
			foreach ($fonts as $font) {

				$variants = is_array($font['variants']) ? $font['variants'] : json_decode($font['variants'], true);
				$subsets  = is_array($font['subsets']) ? $font['subsets'] : json_decode($font['subsets'], true);
				$variants = (is_array($variants) || is_object($variants)) ? @implode(',', $variants) : '';
				$subsets  = (is_array($subsets) || is_object($subsets)) ? @implode(',', $subsets) : '';

				switch ($font['source']) {
					case 'google':
						$i = "'";
						$my = ''.$i.'<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . $font['name'] . ':' . $variants . '&amp;' . $subsets . '">'.$i.'';
						$links .= "<script>
						document.addEventListener('DOMContentLoaded', function() {
							jQuery('body').append(" . $my . ");
						}, false)
						</script>";
						// $links .= '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . $font['name'] . ':' . $variants . '&amp;' . $subsets . '">' . PHP_EOL;
						break;
					case 'typekit':
					case 'custom-font':
						$links .= '<link rel="stylesheet" href="' . $font['url'] . '">' . PHP_EOL;
						break;
					case 'upload-font':
						$url = json_decode($font['url']);
						$name = json_decode($font['name']);
						$subsets = json_decode($font['subsets']);
						$variants = json_decode($font['variants']);
						foreach ($url as $t => $i) {
							$key = key($i);
							$styles .= '@font-face {
								font-family: "' . $name->$t->$key . '";
								font-style: ' . $subsets->$t->$key . ';
								font-weight: ' . $variants->$t->$key . ';
								src: url("' . $i->$key . '") format("'. $t.'");
							}';
						}
						break;
				}
				$styles .= '/* Start */' . PHP_EOL;
				$styles .= '/* Font   : `' . $font['name'] . '` */' . PHP_EOL;
				$styles .= '/* Source : `' . $font['source'] . '` */' . PHP_EOL;
				$styles .= Kata_Plus_Pro_FontsManager_Helpers::generate_font_css($font) . PHP_EOL;
				$styles .= '/* End */' . PHP_EOL;
			}

			$view_ports_data = get_option('kata.plus.fonts_manager.font.size');

			if (isset($view_ports_data['viewport']) && is_array($view_ports_data['viewport'])) {
				foreach ($view_ports_data['viewport'] as $viewport => $selector) {
					$styles .= $viewport . "{
                        font-size: {$selector['desktop']}{$view_ports_data['unit'][$selector['id']]}
                    }";
					if ($selector['desktop']) {
						$styles .= <<<Css
                            @media only screen and (max-width: Device_Desktop) {
                                {$viewport} {
                                    font-size: {$selector['desktop']}{$view_ports_data['unit'][$selector['id']]}
                                }
                            }
Css;
					}

					if ($selector['tablet']) {
						$styles .= <<<Css
                            @media only screen and (max-width: Device_Tablet) {
                                {$viewport} {
                                    font-size: {$selector['tablet']}{$view_ports_data['unit'][$selector['id']]}
                                }
                            }
Css;
					}

					if ($selector['mobile']) {
						$styles .= <<<Css
                            @media only screen and (max-width: Device_Mobile) {
                                {$viewport} {
                                    font-size: {$selector['mobile']}{$view_ports_data['unit'][$selector['id']]}
                                }
                            }
Css;
					}
				}
			}
			$styles .= '</style>';
			$styles  = str_replace(
				[
					'Device_Desktop',
					'Device_Tablet',
					'Device_Mobile',
					'font-size: px;',
				],
				[
					Kata_Plus_Pro_FontsManager_Helpers::$viewport_breakpoints['desktop'][1] . 'px',
					Kata_Plus_Pro_FontsManager_Helpers::$viewport_breakpoints['tablet'][1] . 'px',
					Kata_Plus_Pro_FontsManager_Helpers::$viewport_breakpoints['mobile'][1] . 'px',
					'',
				],
				$styles
			);

			$styles = Kata_Plus_Pro_Helpers::cssminifier($styles);

			echo PHP_EOL;
			echo $links;
			echo $styles;
			echo PHP_EOL;
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions()
		{
			self::$dir = Kata_Plus_Pro::$dir . 'includes/theme-options/fonts-manager/';
			if (is_admin()) {
				if (isset($_GET['page']) && $_GET['page'] == 'kata-plus-fonts-manager') {
					self::$is_fonts_manager = true;
				} else {
					$_SERVER['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
					$refer = @$_SERVER['HTTP_REFERER'];
					if (strpos($refer, '?page=kata-plus-fonts-manager') !== false) {
						self::$is_fonts_manager = true;
					}
				}
			}
		}

		/**
		 * Load dependencies.
		 *
		 * @since   1.0.0
		 */
		public function dependencies()
		{
			// Functions
			Kata_Plus_Pro_Autoloader::load(self::$dir . 'inc', 'helpers', 'fonts-manager');
			// FontsManager Core
			include self::$dir . 'inc/bootstrap.php';
		}
	} //Class
	Kata_Plus_Pro_FontsManager::get_instance();
endif;
class fontAttributes
{

	// --- ATTRIBUTES ---

	/**
	 *  @access private
	 *  @var string
	 */
	private $_fileName = null;                    // Name of the truetype font file


	/**
	 *  @access private
	 *  @var string
	 */
	private $_copyright = null;                    // Copyright


	/**
	 *  @access private
	 *  @var string
	 */
	private $_fontFamily = null;                    // Font Family


	/**
	 *  @access private
	 *  @var string
	 */
	private $_fontSubFamily = null;                    // Font SubFamily


	/**
	 *  @access private
	 *  @var string
	 */
	private $_fontIdentifier = null;                    // Font Unique Identifier


	/**
	 *  @access private
	 *  @var string
	 */
	private $_fontName = null;                    // Font Name


	/**
	 *  @access private
	 *  @var string
	 */
	private $_fontVersion = null;                    // Font Version


	/**
	 *  @access private
	 *  @var string
	 */
	private $_postscriptName = null;                    // Postscript Name


	/**
	 *  @access private
	 *  @var string
	 */
	private $_trademark = null;                    // Trademark



	// --- OPERATIONS ---
	private function _returnValue($inString)
	{
		if (ord($inString) == 0) {
			if (function_exists('mb_convert_encoding')) {
				return mb_convert_encoding($inString, 'UTF-8', 'UTF-16');
			} else {
				return str_replace(chr(00), '', $inString);
			}
		} else {
			return $inString;
		}
	}   //  function _returnValue()

	/**
	 *  @access public
	 *  @return integer
	 */
	public function getCopyright()
	{
		return $this->_returnValue($this->_copyright);
	}   //  function getCopyright()


	/**
	 *  @access public
	 *  @return integer
	 */
	public function getFontFamily()
	{
		return $this->_returnValue($this->_fontFamily);
	}   //  function getFontFamily()


	/**
	 *  @access public
	 *  @return integer
	 */
	public function getFontSubFamily()
	{
		return $this->_returnValue($this->_fontSubFamily);
	}   //  function getFontSubFamily()


	/**
	 *  @access public
	 *  @return integer
	 */
	public function getFontIdentifier()
	{
		return $this->_returnValue($this->_fontIdentifier);
	}   //  function getFontIdentifier()


	/**
	 *  @access public
	 *  @return integer
	 */
	public function getFontName()
	{
		return $this->_returnValue($this->_fontName);
	}   //  function getFontName()


	/**
	 *  @access public
	 *  @return integer
	 */
	public function getFontVersion()
	{
		return $this->_returnValue($this->_fontVersion);
	}   //  function getFontVersion()


	/**
	 *  @access public
	 *  @return integer
	 */
	public function getPostscriptName()
	{
		return $this->_returnValue($this->_postscriptName);
	}   //  function getPostscriptName()


	/**
	 *  @access public
	 *  @return integer
	 */
	public function getTrademark()
	{
		return $this->_returnValue($this->_trademark);
	}   //  function getTrademark()


	/**
	 *  Convert a big-endian word or longword value to an integer
	 *
	 *  @access private
	 *  @return integer
	 */
	private function _UConvert($bytesValue, $byteCount)
	{
		$retVal     = 0;
		$bytesLength = strlen($bytesValue);
		for ($i = 0; $i < $bytesLength; $i++) {
			$tmpVal  = chr($bytesValue[$i]);
			$t       = pow(256, ($byteCount - $i - 1));
			$retVal += $tmpVal * $t;
		}

		return $retVal;
	}   //  function UConvert()


	/**
	 *  Convert a big-endian word value to an integer
	 *
	 *  @access private
	 *  @return integer
	 */
	private function _USHORT($stringValue)
	{
		return $this->_UConvert($stringValue, 2);
	}


	/**
	 *  Convert a big-endian word value to an integer
	 *
	 *  @access private
	 *  @return integer
	 */
	private function _ULONG($stringValue)
	{
		return $this->_UConvert($stringValue, 4);
	}


	/**
	 *  Read the Font Attributes
	 *
	 *  @access private
	 *  @return integer
	 */
	private function readFontAttributes()
	{
		$fontHandle = fopen($this->_fileName, 'rb');

		// Read the file header
		$TT_OFFSET_TABLE = fread($fontHandle, 12);

		$uMajorVersion = $this->_USHORT(substr($TT_OFFSET_TABLE, 0, 2));
		$uMinorVersion = $this->_USHORT(substr($TT_OFFSET_TABLE, 2, 2));
		$uNumOfTables  = $this->_USHORT(substr($TT_OFFSET_TABLE, 4, 2));
		// $uSearchRange   = $this->_USHORT(substr($TT_OFFSET_TABLE,6,2));
		// $uEntrySelector = $this->_USHORT(substr($TT_OFFSET_TABLE,8,2));
		// $uRangeShift    = $this->_USHORT(substr($TT_OFFSET_TABLE,10,2));
		// Check is this is a true type font and the version is 1.0
		if ($uMajorVersion != 1 || $uMinorVersion != 0) {
			fclose($fontHandle);
			throw new Exception($this->_fileName . ' is not a Truetype font file');
		}

		// Look for details of the name table
		$nameTableFound = false;
		for ($t = 0; $t < $uNumOfTables; $t++) {
			$TT_TABLE_DIRECTORY = fread($fontHandle, 16);
			$szTag              = substr($TT_TABLE_DIRECTORY, 0, 4);
			if (strtolower($szTag) == 'name') {
				// $uCheckSum  = $this->_ULONG(substr($TT_TABLE_DIRECTORY,4,4));
				$uOffset = $this->_ULONG(substr($TT_TABLE_DIRECTORY, 8, 4));
				// $uLength    = $this->_ULONG(substr($TT_TABLE_DIRECTORY,12,4));
				$nameTableFound = true;
				break;
			}
		}

		if (!$nameTableFound) {
			fclose($fontHandle);
			throw new Exception('Can\'t find name table in ' . $this->_fileName);
		}

		// Set offset to the start of the name table
		fseek($fontHandle, $uOffset, SEEK_SET);

		$TT_NAME_TABLE_HEADER = fread($fontHandle, 6);

		// $uFSelector     = $this->_USHORT(substr($TT_NAME_TABLE_HEADER,0,2));
		$uNRCount       = $this->_USHORT(substr($TT_NAME_TABLE_HEADER, 2, 2));
		$uStorageOffset = $this->_USHORT(substr($TT_NAME_TABLE_HEADER, 4, 2));

		$attributeCount = 0;
		for ($a = 0; $a < $uNRCount; $a++) {
			$TT_NAME_RECORD = fread($fontHandle, 12);

			$uNameID = $this->_USHORT(substr($TT_NAME_RECORD, 6, 2));
			if ($uNameID <= 7) {
				// $uPlatformID    = $this->_USHORT(substr($TT_NAME_RECORD,0,2));
				$uEncodingID = $this->_USHORT(substr($TT_NAME_RECORD, 2, 2));
				// $uLanguageID    = $this->_USHORT(substr($TT_NAME_RECORD,4,2));
				$uStringLength = $this->_USHORT(substr($TT_NAME_RECORD, 8, 2));
				$uStringOffset = $this->_USHORT(substr($TT_NAME_RECORD, 10, 2));

				if ($uStringLength > 0) {
					$nPos = ftell($fontHandle);
					fseek($fontHandle, $uOffset + $uStringOffset + $uStorageOffset, SEEK_SET);
					$testValue = fread($fontHandle, $uStringLength);

					if (trim($testValue) > '') {
						switch ($uNameID) {
							case 0:
								if ($this->_copyright == null) {
									$this->_copyright = $testValue;
									$attributeCount++;
								}
								break;
							case 1:
								if ($this->_fontFamily == null) {
									$this->_fontFamily = $testValue;
									$attributeCount++;
								}
								break;
							case 2:
								if ($this->_fontSubFamily == null) {
									$this->_fontSubFamily = $testValue;
									$attributeCount++;
								}
								break;
							case 3:
								if ($this->_fontIdentifier == null) {
									$this->_fontIdentifier = $testValue;
									$attributeCount++;
								}
								break;
							case 4:
								if ($this->_fontName == null) {
									$this->_fontName = $testValue;
									$attributeCount++;
								}
								break;
							case 5:
								if ($this->_fontVersion == null) {
									$this->_fontVersion = $testValue;
									$attributeCount++;
								}
								break;
							case 6:
								if ($this->_postscriptName == null) {
									$this->_postscriptName = $testValue;
									$attributeCount++;
								}
								break;
							case 7:
								if ($this->_trademark == null) {
									$this->_trademark = $testValue;
									$attributeCount++;
								}
								break;
						}
					}
					fseek($fontHandle, $nPos, SEEK_SET);
				}
			}
			if ($attributeCount > 7) {
				break;
			}
		}

		fclose($fontHandle);
		return true;
	}




	/**
	 *  @access constructor
	 *  @return void
	 */
	function __construct($fileName = '')
	{

		if ($fileName == '') {
			throw new Exception('Font File has not been specified');
		}

		$this->_fileName = $fileName;

		if (!file_exists($this->_fileName)) {
			throw new Exception($this->_fileName . ' does not exist');
		} elseif (!is_readable($this->_fileName)) {
			throw new Exception($this->_fileName . ' is not a readable file');
		}

		return $this->readFontAttributes();
	}   //  function constructor()


}   /* end of class fontAttributes */
