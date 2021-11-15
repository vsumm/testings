<?php
// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
$current_font = FontsManager_Edit_Page_Presenter::get_font();
$font_data    = Kata_Plus_Pro_FontsManager_Helpers::get_font_data( 'google', $current_font['name'] );
?>
<div class="kata-plus-fonts-manager-css-selector-row-hidden">
	<div class="col table">
		<label class="block-label">CSS Selector</label>
		<input type="text" name="font_selectors[_SELECTOR_ID_][selector]" class="kata-plus-fonts-manager-add-new-font-selector-input" value=".font-_SELECTOR_ID_">
		<select name="font_selectors[_SELECTOR_ID_][variant]" class="kata-plus-fonts-manager-add-new-font-selector-select kata-plus-fonts-manager-add-new-font-selector-select-variant">
		<?php
		if ( $current_font['variants'] ) {
			$variants = json_decode( $current_font['variants'] );
			if ( ! is_array( $variants ) ) {
				$variant = [];
			}
			foreach ( $font_data->variants as $variant ) {

				echo '<option value="' . $variant . '">';
				echo $variant;
				echo '</option>';
			}
		}
		?>
		</select>
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
<form method="post" class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-add-new-wrap">
	<input type="hidden" value="google" name="source">
	<input type="hidden" value="<?php echo $current_font['name']; ?>" name="fontname">
	<input type="hidden" value="<?php echo $current_font['ID']; ?>" name="font_id">
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&controller=settings' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Settings', 'kata-plus' ); ?></a>
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&action=add_new_font' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Add New Font', 'kata-plus' ); ?></a>
	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager' ); ?>"><?php echo esc_html__( 'Font Manager', 'kata-plus' ); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__( 'Edit Font', 'kata-plus' ); ?></span>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__( 'Edit Font', 'kata-plus' ); ?> <?php echo $current_font['name']; ?></span>
	</h1>

	<div class="kata-plus-fonts-manager-wrap kata-plus-fonts-manager-add-new-google-wrap">
		<div class="col">
			<div class="kata-plus-fonts-manager-font-family">
				<div class="title">
					Font Family:
				</div>
				<div class="name">
					<?php echo $current_font['name']; ?>
				</div>
			</div>

			<div id="poststuff">
				<div id="postbox-container" class="postbox-container">
					<div class="meta-box-sortables ui-sortable" id="normal-sortables">
						<div class="postbox">
							<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?php echo esc_html__( 'Live Preview', 'kata-plus' ); ?></span></h3>
							<div class="inside" id="live_preview_content">
							<?php $src = admin_url( 'admin-ajax.php' ) . '?action=kata_plus_pro_fonts_manager_font_preview&font-family=' . $current_font['name'] . '&source=' . $current_font['source']; ?>
								<iframe src="<?php echo $src; ?>" onload="this.style.height = this.contentWindow.document.body.offsetHeight + 'px'" ></iframe>
							</div>
						</div>

						<div class="postbox">
							<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?php echo esc_html__( 'Font Variants', 'kata-plus' ); ?></span></h3>
							<div class="inside" id="fonts_manager_font_variants">
							<?php
							if ( $current_font['variants'] ) {
								$variants = json_decode( $current_font['variants'] );
								if ( ! is_array( $variants ) ) {
									$variant = [];
								}
								foreach ( $font_data->variants as $variant ) {

									$checked = '';
									if ( in_array( $variant, $variants ) ) {
										$checked = 'checked="checked"';
									}
									echo '<label>';
									echo '<input type="checkbox" name="variants[]" ' . $checked . 'value="' . $variant . '">';
									echo $variant;
									echo '</label>';
								}
							}
							?>
							</div>
						</div>

						<div class="postbox">
							<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span><?php echo esc_html__( 'Font Subsets', 'kata-plus' ); ?></span></h3>
							<div class="inside" id="fonts_manager_font_subsets">
							<?php
							if ( $current_font['subsets'] ) {
								$subsets = json_decode( $current_font['subsets'] );
								if ( ! is_array( $subsets ) ) {
									$subsets = [];
								}
								foreach ( $font_data->subsets as $subset ) {

									$checked = '';
									if ( in_array( $subset, $subsets ) ) {
										$checked = 'checked="checked"';
									}
									echo '<label>';
									echo '<input type="checkbox" name="subsets[]" ' . $checked . 'value="' . $subset . '">';
									echo $subset;
									echo '</label>';
								}
							}
							?>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
	<div id="poststuff" class="fonts-manager-stuff hidden">
		<div id="postbox-container" class="postbox-container">
			<div class="meta-box-sortables ui-sortable" id="normal-sortables">
				<div class="postbox ">
					<div title="Click to toggle" class="handlediv"><br></div><h3 class="hndle"><span>Selectors and Sizes</span></h3>
					<div class="inside has-footer css-selector-wrap">
						<?php
							$selectors = json_decode( $current_font['selectors'] );
							$counter   = 0;
						?>

						<?php foreach ( $selectors as $selector ) : ?>

							<div class="row css-selector-row">
								<div class="col table">
									<label class="block-label">CSS Selector</label>
									<input type="text" name="font_selectors[<?php echo $counter; ?>][selector]" class="kata-plus-fonts-manager-add-new-font-selector-input" value="<?php echo $selector->selector; ?>">
									<select name="font_selectors[<?php echo $counter; ?>][variant]" class="kata-plus-fonts-manager-add-new-font-selector-select kata-plus-fonts-manager-add-new-font-selector-select-variant">
									<?php
									if ( $current_font['variants'] ) {
										$variants = json_decode( $current_font['variants'] );
										if ( ! is_array( $variants ) ) {
											$variant = [];
										}
										foreach ( $font_data->variants as $variant ) {

											$checked = '';
											if ( in_array( $variant, $variants ) ) {
												$selected = '';
												if ( $variant == $selector->variant ) {
													$selected = ' selected="selected"';
												}
												echo '<option value="' . $variant . '"' . $checked . '> ' . $variant . '</option>';
											}
										}
									}
									?>
									</select>

									<select name="font_selectors[<?php echo $counter; ?>][font_case]"  class="kata-plus-fonts-manager-add-new-font-selector-select">
										<option<?php echo $selector->font_case == '' ? 'selected="selected"' : ''; ?> value="">Default</option>
										<option<?php echo $selector->font_case == 'uppercase' ? ' selected="selected"' : ''; ?> value="uppercase">Upper case</option>
										<option<?php echo $selector->font_case == 'lowercase' ? ' selected="selected"' : ''; ?> value="lowercase">Lower case</option>
										<option<?php echo $selector->font_case == 'capitalize' ? ' selected="selected"' : ''; ?> value="capitalize">Capitalize</option>
									</select>
								</div>
								<div class="col table">
									<label class="block-label">Font Sizes (Optional)</label>
									<input type="number" name="font_selectors[<?php echo $counter; ?>][font_sizes][general]" placeholder="General" value="<?php echo $selector->font_sizes->general; ?>" class="kata-plus-fonts-manager-add-new-font-selector-input">
									<input type="number" name="font_selectors[<?php echo $counter; ?>][font_sizes][desktop]" placeholder="Desktop" value="<?php echo $selector->font_sizes->desktop; ?>" class="kata-plus-fonts-manager-add-new-font-selector-input">
									<input type="number" name="font_selectors[<?php echo $counter; ?>][font_sizes][tablet]" placeholder="Tablet" value="<?php echo $selector->font_sizes->tablet; ?>" class="kata-plus-fonts-manager-add-new-font-selector-input">
									<input type="number" name="font_selectors[<?php echo $counter; ?>][font_sizes][mobile]" placeholder="Mobile" value="<?php echo $selector->font_sizes->mobile; ?>" class="kata-plus-fonts-manager-add-new-font-selector-input">
									<select name="font_selectors[<?php echo $counter; ?>][font_sizes][unit]" class="kata-plus-fonts-manager-add-new-font-selector-select">
										<option <?php echo $selector->font_sizes->unit == 'px' ? ' selected="selected"' : ''; ?> value="px">px</option>
										<option <?php echo $selector->font_sizes->unit == 'em' ? ' selected="selected"' : ''; ?> value="em">em</option>
										<option <?php echo $selector->font_sizes->unit == 'rem' ? ' selected="selected"' : ''; ?> value="rem">rem</option>
										<option <?php echo $selector->font_sizes->unit == '%' ? ' selected="selected"' : ''; ?> value="%">%</option>
									</select>
									<div class="remove-selector" onclick=$(this).parent().parent().remove();><span class="dashicons dashicons-no-alt"></span></div>
								</div>
							</div>
							<?php $counter++; ?>
						<?php endforeach ?>
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

	<div class="kata-plus-fonts-manager-submit-content">
		<input type="submit" class="button" value="<?php echo esc_html__( 'Update', 'kata-plus' ); ?>">
	</div>

</form>
