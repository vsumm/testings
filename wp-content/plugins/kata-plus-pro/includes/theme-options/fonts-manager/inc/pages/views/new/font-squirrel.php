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
		<select name="font_selectors[_SELECTOR_ID_][variant]" class="kata-plus-fonts-manager-add-new-font-selector-select kata-plus-fonts-manager-add-new-font-selector-select-variant"></select>
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
<form method="post" class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-add-new-wrap">
	<input type="hidden" value="font-squirrel" name="source">

	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager' ); ?>"><?php echo esc_html__( 'Font Manager', 'kata-plus' ); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&action=add_new_font' ); ?>"><?php echo esc_html__( 'Add New Font', 'kata-plus' ); ?></a></span>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__( 'Squirrel', 'kata-plus' ); ?></span>
	</h1>

	<div class="kata-plus-fonts-manager-add-new-font-squirrel-wrap">
		<div class="col col-7">
			<ul id="kata-plus-fonts-manager-add-font-table">
				<?php foreach ( Kata_plus_FontsManager_Add_New_Font_Squirrel_Helper::get_fonts_list() as $font ) : ?>
					<?php $n = str_replace( ' ', '_', $font['family_name'] ); ?>
					<li>
						<input type="radio" required="" name="fontname" value="<?php echo $font['family_name']; ?>" data-source="font-squirrel" id="input_<?php echo $n; ?>" class="fontname">
						<label for="input_<?php echo $n; ?>"><?php echo $font['family_name']; ?></label>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="col col-3">
			<div class="kata-plus-fonts-manager-font-family">
				<div class="title">
					Font Family:
				</div>
				<div class="name">
					<?php echo esc_html__( 'Choose once', 'kata-plus' ); ?>
				</div>
			</div>

			<div id="poststuff">
				<div id="postbox-container" class="postbox-container">
					<div class="meta-box-sortables ui-sortable" id="normal-sortables">
						<div class="postbox">
							<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Live Preview</span></h3>
							<div class="inside" id="live_preview_content">
							</div>
						</div>

						<div class="postbox">
							<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Font Variants</span></h3>
							<div class="inside" id="fonts_manager_font_variants">
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
	<div id="poststuff" class="fonts-manager-stuff">
		<div id="postbox-container" class="postbox-container">
			<div class="meta-box-sortables ui-sortable" id="normal-sortables">
				<div class="postbox ">
					<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Selectors and Sizes</span></h3>
					<div class="inside has-footer css-selector-wrap">
						<div class="row postbox-container-footer">
							<div class="button" id="add-new-section">
								<span aria-hidden="true" class="dashicons dashicons-plus"></span><?php echo esc_html__( 'Add new selector', 'kata-plus' ); ?>
							</div>
						</div>
					</div>
				</div>


				<div class="postbox ">
					<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Other Options</span></h3>
					<div class="inside">
					<div class="row">
							<div class="col table">
								<label class="block-label">Font status</label>
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
		<input type="submit" class="button" value="<?php echo esc_html__( 'Save Data', 'kata-plus' ); ?>">
	</div>

</form>
