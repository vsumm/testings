<?php

// don't load directly.
if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

if (!class_exists('Kata_plus_FontsManager_Add_New_Font_Upload_Icon_Helper')) :
	/**
	 * Kata_plus_FontsManager_Add_New_Font_Upload_Icon_Helper.
	 *
	 * @author   ClimaxThemes
	 * @package  Kata Plus
	 * @since    1.0.0
	 */
	class Kata_plus_FontsManager_Add_New_Font_Upload_Icon_Helper
	{

		/**
		 * Instance of this class.
		 *
		 * @since     1.0.0
		 * @access     private
		 * @var     Kata_plus_FontsManager_Add_New_Font_Upload_Icon_Helper
		 */
		private static $instance;

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
		 * Define the core functionality of the FontsManager_Add_New_Page_Presenter.
		 *
		 * Load the dependencies.
		 *
		 * @since     1.0.0
		 */
		function __construct()
		{
			$this->scripts();
			$this->actions();
			define('ALLOW_UNFILTERED_UPLOADS', true);
		}

		/**
		 * Description
		 *
		 * @since     1.0.0
		 */
		public function actions()
		{ }

		/**
		 * Scripts
		 *
		 * @since     1.0.0
		 */
		public function scripts()
		{
			wp_enqueue_script('postbox');
			wp_enqueue_script('kata-plus-fonts-manager-listnav', Kata_Plus::$assets . '/js/libraries/jquery-listnav.js', null, Kata_Plus_Pro::$version, true);

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
					'action'      => 'kata_plus_pro_fonts_manager_upload_icon',            // the ajax action name
				),
			);

			// we should probably not apply this filter, plugins may expect wp's media uploader...
			$plupload_init = apply_filters('plupload_init', $plupload_init);
			?>

			<script type="text/javascript">
				jQuery(document).ready(function($) {

					// create the uploader and pass the config from above
					var uploader = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>);

					// checks if browser supports drag and drop upload, makes some css adjustments if necessary
					uploader.bind('Init', function(up) {
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
						var hundredmb = 100 * 1024 * 1024,
							max = parseInt(up.settings.max_file_size, 10);

						plupload.each(files, function(file) {
							if (max > hundredmb && file.size > hundredmb && up.runtime != 'html5') {
								// file size error?

							} else {

								// a file was added, you may want to update your DOM here...
								console.log(file);
							}
						});

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
							$('#kata-plus-fonts-manager-add-font-table').before(
								'<div class="notice notice-info" style="display:block !important;"><p><strong>' + objData.message + '</strong></p></div>'
							);
							return false;
						}
						$('.kata-plus-extensions-wrap').find('.' + objData.extension).addClass('active');
						$('.upload-font-result').find('.font-pack[data-pack-hash="' + objData.hash + '"]').remove();
						$('.upload-font-result').append(objData.html);

						if ($('.kata-plus-extensions-wrap').find('.active').length === 3 && $('.kata-plus-extensions-wrap').data('update') === 'yes') {
							// $('#plupload-upload-ui').slideUp(1000);
							// $('.kata-plus-extensions-wrap').delay( 900 ).slideUp();
							// $('.kata-plus-fonts-manager-submit-content input').trigger('click');

						}

						// this is your ajax response, update the DOM with it or something...
						// console.log(response);

					});

				});
			</script>
<?php

			wp_add_inline_script(
				'kata-plus-fonts-manager-listnav',
				'jQuery(function($){
				postboxes.add_postbox_toggles();

				// Upload Media
				$(".font-file-entry").each(function() {
					var $widgetContainer = $(this);

					$widgetContainer.find(".kata-add-media-upload").off().on("click", function (e) {
						e.preventDefault();

						var $addImageBtn = $(this);
						var $deleteImageBtn = $addImageBtn.siblings(".kata-remove-media-upload");
						var $imageContainer = $addImageBtn.siblings(".kata-preview-media-upload");
						var $inputMediaUpload = $addImageBtn.siblings("input.kata-input-media-upload");
						var value = $inputMediaUpload.val();

						value = value ? value : "";

						// Create a new media frame
						var frame = wp.media({
							multiple: false,
							drop_element:"drag-drop-area",
							library:{type:["font","application"]}
						});

						// Open the modal on click
						frame.open();

						// When an image is selected in the media frame...
						frame.on("select", function () {
							// Get media attachment details from the frame state
							var attachment = frame.state().get("selection").first().toJSON();
							// Send the attachment URL to our custom image input field.
							$widgetContainer.find("input").val(attachment.url);
						});
					});

					// Delete image link
					$widgetContainer.find(".kata-remove-media-upload").off().on("click", function (event) {
						event.preventDefault();
						var $deleteImageBtn = $(this);
						var $imageContainer = $deleteImageBtn.siblings(".kata-preview-media-upload");
						var $inputMediaUpload = $deleteImageBtn.siblings("input.kata-input-media-upload");
						// Clear out the preview image
						$imageContainer.html("").hide();
						// Hide the delete image link
						$deleteImageBtn.hide();
						// Delete the image id from the hidden input
						$inputMediaUpload.val("").trigger("change");
					});
				});
			});'
			);
		}
	} //Class
	Kata_plus_FontsManager_Add_New_Font_Upload_Icon_Helper::get_instance();
endif;
