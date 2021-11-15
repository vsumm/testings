<?php
// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

?>
<div class="kata-plus-fonts-manager-css-selector-row-hidden">
	<div class="col table">
		<label class="block-label">CSS Selector</label>
		<input type="text" name="font_selectors[_SELECTOR_ID_][selector]" class="kata-plus-fonts-manager-add-new-font-selector-input" value=".font-_SELECTOR_ID_">
		<input type="text" name="font_selectors[_SELECTOR_ID_][variant]"  class="kata-plus-fonts-manager-add-new-font-selector-input" placeholder="Font variant (Bold)">
		<select name="font_selectors[_SELECTOR_ID_][font_case]" class="kata-plus-fonts-manager-add-new-font-selector-select">
			<option value=""><?php echo esc_html__( 'Default', 'kata-plus' ); ?></option>
			<option value="uppercase"><?php echo esc_html__( 'Upper case', 'kata-plus' ); ?></option>
			<option value="lowercase"><?php echo esc_html__( 'Lower case', 'kata-plus' ); ?></option>
			<option value="capitalize"><?php echo esc_html__( 'Capitalize', 'kata-plus' ); ?></option>
		</select>
	</div>
	<div class="col table">
		<label class="block-label">Font Sizes (Optional)</label>
		<input type="number" name="font_selectors[_SELECTOR_ID_][font_sizes][general]" placeholder="General" class="kata-plus-fonts-manager-add-new-font-selector-input">
		<input type="number" name="font_selectors[_SELECTOR_ID_][font_sizes][desktop]" placeholder="Desktop" class="kata-plus-fonts-manager-add-new-font-selector-input">
		<input type="number" name="font_selectors[_SELECTOR_ID_][font_sizes][tablet]" placeholder="Tablet" class="kata-plus-fonts-manager-add-new-font-selector-input">
		<input type="number" name="font_selectors[_SELECTOR_ID_][font_sizes][mobile]" placeholder="Mobile" class="kata-plus-fonts-manager-add-new-font-selector-input">
		<select name="font_selectors[_SELECTOR_ID_][font_sizes][unit]" id="" class="kata-plus-fonts-manager-add-new-font-selector-select">
			<option value="px">px</option>
			<option value="em">em</option>
			<option value="rem">rem</option>
			<option value="%">%</option>
		</select>
		<div class="remove-selector" onclick=$(this).parent().parent().remove();><span class="dashicons dashicons-no-alt"></span></div>
	</div>
</div>
<form method="post" class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-add-new-wrap" id="dashboard-widgets">
	<input type="hidden" value="upload-font" name="source">

	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager' ); ?>"><?php echo esc_html__( 'Font Manager', 'kata-plus' ); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&action=add_new_font' ); ?>"><?php echo esc_html__( 'Add New Font', 'kata-plus' ); ?></a></span>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__( 'Upload Font', 'kata-plus' ); ?></span>
	</h1>
	<div class="col col-10">
		<div id="poststuff">
			<div id="plupload-upload-ui" class="hide-if-no-js">
				<div class="kata-plus-extensions-wrap" data-update="yes">
					<span class="otf extension">otf</span>
					<span class="ttf extension">ttf</span>
					<span class="eot extension">eot</span>
					<span class="woff extension">woff</span>
					<span class="woff2 extension">woff2</span>
				</div>
				<div id="drag-drop-area">
				<div class="drag-drop-inside">
					<p class="drag-drop-info"><?php _e( 'Drop files here' ); ?></p>
					<p><?php _ex( 'or', 'Uploader: Drop font files here - or - Select Files' ); ?></p>
					<p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e( 'Select Files' ); ?>" class="button" /></p>
					<p class="allowed-files">Allowed Files: <span>otf, ttf, eot, woff,woff2</span></p>
				</div>
				</div>
			</div>
			<div class="upload-font-result"></div>
		</div>
	</div>

	<div class="hidden">
		<div class="col col-10">
			<div id="poststuff">
				<div id="postbox-container" class="postbox-container">
					<div class="meta-box-sortables ui-sortable" id="normal-sortables">
						<div class="postbox ">
							<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?php echo esc_html__( 'Selectors and Sizes', 'kata-plus' ); ?></span></h3>
							<div class="inside has-footer css-selector-wrap">
								<div class="row postbox-container-footer">
									<div class="button" id="add-new-section">
										<span aria-hidden="true" class="dashicons dashicons-plus"></span><?php echo esc_html__( 'Add new selector', 'kata-plus' ); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="postbox ">
							<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?php echo esc_html__( 'Other Options', 'kata-plus' ); ?></span></h3>
							<div class="inside">
							<div class="row">
									<div class="col table">
										<label class="block-label"><?php echo esc_html__( 'Font status', 'kata-plus' ); ?></label>
										<select name="font_status" class="kata-plus-fonts-manager-add-new-font-selector-select">
											<option value="published"><?php echo __('Published', 'kata-plus'); ?></option>
											<option value="unpublished"><?php echo __('Unpublished', 'kata-plus'); ?></option>
										</select>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="kata-plus-fonts-manager-submit-content">
		<input type="submit" class="button" value="<?php echo esc_html__( 'Save', 'kata-plus' ); ?>">
	</div>

</form>
