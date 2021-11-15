<?php
// don't load directly.
if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

?>
<form method="post" class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-add-new-wrap" id="dashboard-widgets">
	<input type="hidden" value="upload-icon" name="source">

	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager'); ?>"><?php echo esc_html__('Font Manager', 'kata-plus'); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager&action=add_new_font'); ?>"><?php echo esc_html__('Add New Font', 'kata-plus'); ?></a></span>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__('Upload Icon', 'kata-plus'); ?></span>
	</h1>
	<div class="col col-10">
		<div class="icon-pack-name">
			<input type="text" placeholder="Icon Pack Name" required="required" name="icon-pack-name">
		</div>
		<div id="poststuff">
			<div id="plupload-upload-ui" class="hide-if-no-js">
				<div id="drag-drop-area">
					<div class="drag-drop-inside">
						<p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
						<p><?php _ex('or', 'Uploader: Drop font files here - or - Select Files'); ?></p>
						<p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
						<p class="allowed-files">Allowed Files: <span>selection.json from icomoon zip or svg Icons</span></p>
					</div>
				</div>
			</div>
			<div class="upload-font-result"></div>
		</div>
	</div>

	<div class="kata-plus-fonts-manager-submit-content">
		<input type="submit" class="button" value="<?php echo esc_html__('Save', 'kata-plus'); ?>">
	</div>

</form>