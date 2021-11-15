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
			<option value="">Default</option>
			<option value="uppercase">Upper case</option>
			<option value="lowercase">Lower case</option>
			<option value="capitalize">Capitalize</option>
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
	<input type="hidden" value="typekit" name="source">
	<input type="hidden" value="<?php echo $current_font['ID']; ?>" name="font_id">
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&controller=settings' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Settings', 'kata-plus' ); ?></a>
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&action=add_new_font' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Add New Font', 'kata-plus' ); ?></a>
	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager'); ?>"><?php echo esc_html__('Font Manager', 'kata-plus'); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><a href="#"><?php echo esc_html__('Edit Font', 'kata-plus'); ?></a></span>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__('Typekit', 'kata-plus'); ?></span>
	</h1>

	<div class="kata-plus-action-box typekit">
		<div>
			<input type="text" class="kata-plus-search-box" name="url" value="<?php echo $current_font['url']; ?>" id="kata_plus_pro_fonts_manager_typekit_id_box" placeholder="<?php echo esc_attr__('Typekit ID or Stylesheet URL ', 'kata-plus'); ?>">
		</div>
		<div>
			<input type="text" class="kata-plus-preview-text-box" id="kata_plus_pro_fonts_manager_preview_text" placeholder="<?php echo get_option('kata.plus.fonts_manager.font.preview.text', 'Create your awesome website, fast and easy.'); ?>">
		</div>
		<div class="kata-plus-preview-font-size-wrap">
			<b id="kata_plus_pro_fonts_manager_preview_text_font_size"><?php echo get_option('kata.plus.fonts_manager.font.preview.size', 13); ?> px</b>
			<input type="range" min="8" max="100" value="<?php echo get_option('kata.plus.fonts_manager.font.preview.size', 13); ?>">
		</div>
	</div>

	<div id="poststuff" class="fonts-manager-stuff">
		<div id="postbox-container" class="postbox-container">
			<div class="meta-box-sortables ui-sortable" id="normal-sortables">
				<div class="postbox" id="kata-plus-fonts-manager-add-font-table">
					<div title="Click to toggle" class="handlediv"><br></div>
					<h3 class="hndle"><span><?php echo esc_html__('Font Preview', 'kata-plus'); ?></span></h3>
					<div class="inside has-footer css-selector-wrap">
						<div id="font_preview_wrap"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="poststuff" class="fonts-manager-stuff">
		<div id="postbox-container" class="postbox-container">
			<div class="meta-box-sortables ui-sortable" id="normal-sortables">
				<div class="postbox hidden">
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


				<div class="postbox ">
					<div title="Click to toggle" class="handlediv"><br></div>
					<h3 class="hndle"><span><?php echo esc_html__('Other Options', 'kata-plus'); ?></span></h3>
					<div class="inside">
						<div class="row">
							<div class="col table">
								<label class="block-label"><?php echo esc_html__('Font status', 'kata-plus'); ?></label>
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

	<div class="kata-plus-fonts-manager-submit-content">
		<input type="submit" class="button button-block" value="<?php echo esc_html__('Update', 'kata-plus'); ?>">
	</div>

</form>
<script>
	jQuery(document).ready(function() {
		jQuery('#font_preview_wrap').html('<div class="lds-ripple"><div></div><div></div></div>');
		setTimeout(function() {
			jQuery('#kata_plus_pro_fonts_manager_typekit_id_box').trigger('input');
		}, 500);
	});
</script>