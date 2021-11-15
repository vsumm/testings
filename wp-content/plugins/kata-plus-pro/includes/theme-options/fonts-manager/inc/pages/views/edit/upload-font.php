<?php
// don't load directly.
if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}
$current_font = FontsManager_Edit_Page_Presenter::get_font();
?>
<div class="kata-plus-fonts-manager-css-selector-row-hidden">
	<div class="col table">
		<label class="block-label">CSS Selector</label>
		<input type="text" name="font_selectors[_SELECTOR_ID_][selector]" class="kata-plus-fonts-manager-add-new-font-selector-input" value=".font-_SELECTOR_ID_">
		<input type="text" name="font_selectors[_SELECTOR_ID_][variant]" class="kata-plus-fonts-manager-add-new-font-selector-input" placeholder="Font variant (Bold)">
		<select name="font_selectors[_SELECTOR_ID_][font_case]" class="kata-plus-fonts-manager-add-new-font-selector-select">
			<option value=""><?php echo esc_html__('Default', 'kata-plus'); ?></option>
			<option value="uppercase"><?php echo esc_html__('Upper case', 'kata-plus'); ?></option>
			<option value="lowercase"><?php echo esc_html__('Lower case', 'kata-plus'); ?></option>
			<option value="capitalize"><?php echo esc_html__('Capitalize', 'kata-plus'); ?></option>
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
<form method="post" class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-edit-wrap upload-font" id="dashboard-widgets">
	<input type="hidden" value="upload-font" name="source">
	<input type="hidden" value="<?php echo $current_font['ID']; ?>" name="font_id">
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&controller=settings' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Settings', 'kata-plus' ); ?></a>
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&action=add_new_font' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Add New Font', 'kata-plus' ); ?></a>
	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager'); ?>"><?php echo esc_html__('Font Manager', 'kata-plus'); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__('Edit Font', 'kata-plus'); ?></span>
	</h1>

	<div class="col col-10" id="kata-plus-fonts-manager-add-font-table">
		<div id="poststuff">
			<div id="plupload-upload-ui" class="hide-if-no-js">
				<div id="drag-drop-area">
					<div class="drag-drop-inside">
						<p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
						<p><?php _ex('or', 'Uploader: Drop font files here - or - Select Files'); ?></p>
						<p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
						<p class="allowed-files">Allowed Files: <span>ttf, eot, woff</span></p>
					</div>
				</div>

				<div class="kata-plus-action-box">
					<div class="kata-plus-preview-font-size-wrap">
						<b id="kata_plus_pro_fonts_manager_preview_text_font_size"><?php echo get_option('kata.plus.fonts_manager.font.preview.size', 13); ?> px</b>
						<input type="range" min="8" max="100" value="<?php echo get_option('kata.plus.fonts_manager.font.preview.size', 13); ?>">
					</div>
					<div>
						<input type="text" class="kata-plus-preview-text-box" id="kata_plus_pro_fonts_manager_preview_text" placeholder="<?php echo get_option('kata.plus.fonts_manager.font.preview.text', 'Create your awesome website, fast and easy.'); ?>">
					</div>
				</div>

			</div>
			<div class="upload-font-result">
				<?php

				$fontNames = json_decode($current_font['name']);
				$fontSubfamilies = json_decode($current_font['subsets']);
				$fontWeights = json_decode($current_font['variants']);
				$html = '';

				foreach (json_decode($current_font['url']) as $extension => $data) :
					foreach ($data as $key => $url) {
						$fontName = $fontNames->$extension->$key;
						$fontSubfamily = $fontSubfamilies->$extension->$key;
						$fontWeight = $fontWeights->$extension->$key;
						$src = admin_url('admin-ajax.php') . '?action=kata_plus_pro_fonts_manager_font_preview&font-family=' . $fontName . '&source=upload-font&single-line=true&font-weight=' . str_replace('"', '', $fontWeight) . '&font-style=' . str_replace(['"', 'regular'], ['', 'normal'], strtolower($fontSubfamily));
						$_src =  $src . '&url-' . $extension . '=' . $url;
						$html .= '<div class="font-pack has-iframe" data-pack-hash="' . $key . '" data-font-pack="' . $fontName . '" data-extension="' . $extension . '">
						<span class="remove">x</span>
						<input type="hidden" name="url[' . $extension . '][' . $key . ']" value="' . $url . '">
							<iframe src="' . $_src . '" frameborder="0" style="width: 100%;display: block;position: relative;padding: 10px;border: none;margin-top: 0px;height: 60px;padding-top: 0;"></iframe>
							<div class="font-pack-footer">
								<h3>' . $fontName . '</h3>
								<span class="font-style">Font Style: ' . $fontSubfamily . '</span>
								<span class="font-weight">Font Weight: ' . $fontWeight . '</span>
								<span class="font-extenstion">' . $extension . '</span>
							</div>
						</div>';
						$html .= '<input type="hidden" name="fontname[' . $extension . '][' . $key . ']" value="' . $fontName . '">';
						$html .= '<input type="hidden" name="font_style[' . $extension . '][' . $key . ']" value="' . $fontSubfamily . '">';
						$html .= '<input type="hidden" name="font_weight[' . $extension . '][' . $key . ']" value="' . $fontWeight . '">';
					}
				endforeach;

				echo $html;

				?>
			</div>
		</div>
	</div>

	<div class="hidden">
		<div class="col col-10">
			<div id="poststuff">
				<div id="postbox-container" class="postbox-container">
					<div class="meta-box-sortables ui-sortable" id="normal-sortables">
						<div class="postbox ">
							<div title="Click to toggle" class="handlediv"><br></div>
							<h3 class="hndle"><span><?php echo esc_html__('Selectors and Sizes', 'kata-plus'); ?></span></h3>
							<div class="inside has-footer css-selector-wrap">
								<div class="row postbox-container-footer">
									<div class="button" id="add-new-section">
										<span aria-hidden="true" class="dashicons dashicons-plus"></span><?php echo esc_html__('Add new selector', 'kata-plus'); ?>
									</div>
								</div>
							</div>
						</div>

						<div class="postbox">
							<div title="Click to toggle" class="handlediv"><br></div>
							<h3 class="hndle"><span><?php echo esc_html__('Other Options', 'kata-plus'); ?></span></h3>
							<div class="inside">
								<div class="row">
									<div class="col table">
										<label class="block-label">Font status</label>
										<select name="font_status" class="kata-plus-fonts-manager-add-new-font-selector-select">
											<option <?php echo $current_font['status'] == 'published' ? ' selected="selected"' : ''; ?> value="published">Published</option>
											<option <?php echo $current_font['status'] == 'unpublished' ? ' selected="selected"' : ''; ?> value="unpublished">Unpublished</option>
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
		<input type="submit" class="button" value="<?php echo esc_html__('Update', 'kata-plus'); ?>">
	</div>

</form>