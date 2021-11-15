<?php
// don't load directly.
if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}
?>
<div class="wrap kata-plus-fonts-manager-wrap">

	<a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager'); ?>" class="hide-if-no-js page-title-action"><?php echo esc_html__('Font Family(s)', 'kata-plus'); ?></a>
	<a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager&action=add_new_font'); ?>" class="hide-if-no-js page-title-action"><?php echo esc_html__('Add New', 'kata-plus'); ?></a>
	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager'); ?>"><?php echo esc_html__('Font Manager', 'kata-plus'); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__('Settings', 'kata-plus'); ?></span>
	</h1>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder">
			<div id="post-body-content">
				<div>
					<form method="post">
						<div class="row table">
							<div id="poststuff">
								<div id="postbox-container" class="postbox-container">
									<div id="normal-sortables">
										<div class="postbox">
											<div title="Click to toggle" class="handlediv"><br></div>
											<h3 class="hndle"><span><?php echo esc_html__('Alternative Fonts', 'kata-plus'); ?></span></h3>
											<div class="inside has-footer" style="display: block;">

												<input type="text" id="font_alternative_text" name="font_alternative_text" value="<?php echo get_option('kata.plus.fonts_manager.alternative.fonts', 'Arial, Roboto, Sans-serif'); ?>" class="kata-plus-fonts-manager-add-new-font-selector-input full">
												<div class="row postbox-container-footer">
													<label for="font_alternative_text"><?php echo esc_html__('Preview text to display font variants.', 'kata-plus'); ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row table">
							<div id="poststuff">
								<div id="postbox-container" class="postbox-container">
									<div id="normal-sortables">
										<div class="postbox">
											<div title="Click to toggle" class="handlediv"><br></div>
											<h3 class="hndle"><span><?php echo esc_html__('Font Preview Text', 'kata-plus'); ?></span></h3>
											<div class="inside has-footer" style="display: block;">

												<input type="text" id="font_preview_text" name="font_preview_text" value="<?php echo get_option('kata.plus.fonts_manager.font.preview.text', 'Create your awesome website, fast and easy.'); ?>" class="kata-plus-fonts-manager-add-new-font-selector-input full">
												<div class="row postbox-container-footer">
													<label for="font_preview_text"><?php echo esc_html__('Preview text to display font variants.', 'kata-plus'); ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="poststuff">
								<div id="postbox-container" class="postbox-container">
									<div id="normal-sortables">
										<div class="postbox">
											<div title="Click to toggle" class="handlediv"><br></div>
											<h3 class="hndle"><span>Font Preview Size</span></h3>
											<div class="inside has-footer" style="display: block;">
												<input type="text" id="font_preview_font_size" name="font_preview_font_size" value="<?php echo get_option('kata.plus.fonts_manager.font.preview.size', 13); ?>" class="kata-plus-fonts-manager-add-new-font-selector-input full">
												<div class="row postbox-container-footer">
													<label for="font_preview_font_size"><?php echo esc_html__('Enter font size for preview text in pixels unit.', 'inc-plus'); ?></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="poststuff">
								<div id="postbox-container" class="postbox-container">
									<div id="normal-sortables">
										<div class="postbox">
											<div title="Click to toggle" class="handlediv"><br></div>
											<h3 class="hndle"><span><?php echo esc_html__('Fonts Directory', 'inc-plus'); ?></span></h3>
											<div class="inside has-footer" style="display: block;">
												<input type="text" id="fonts_directory" value="~/wp-content/uploads/kata/fonts/" disabled="disabled" name="fonts_directory" class="kata-plus-fonts-manager-add-new-font-selector-input full">
												<div class="row postbox-container-footer">
													<label for="fonts_directory">
														<?php echo esc_html__('Fonts directory and permissions.', 'inc-plus'); ?> <span class="success"><?php echo esc_html__('Writable', 'inc-plus'); ?></span>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="kata-plus-fonts-manager-submit-content">
							<input type="submit" class="button" value="<?php echo esc_html__('Save Data', 'kata-plus'); ?>">
						</div>
					</form>
					<div class="row table">
						<div id="poststuff">
							<div id="postbox-container" class="postbox-container">
								<div id="normal-sortables">
									<div class="postbox">
										<form method="post">
											<div title="Click to toggle" class="handlediv"><br></div>
											<h3 class="hndle"><span><?php esc_html_e('Clear Cache', 'kata-plus'); ?></span></h3>
											<div class="inside has-footer" style="display: block;">
												<div class="font-export-options">
													<span><?php echo esc_html__('The allocated space is to preview fonts.', 'inc-plus'); ?></span>
													<p>
														<?php echo __('Allocated Space', 'kata-plus'); ?>:
														<span>
															<?php
																$path = Kata_Plus_Pro::$upload_dir . '/temp/';
																$cacheSize = $cachedFiles = 0;
																foreach (glob($path . '*.html') as $file) {
																	$cachedFiles++;
																	$cacheSize += (filesize($file));
																}

																echo $cacheSize ? number_format($cacheSize / 1024 , 1) : 0;
																echo 'KB';
															?>
														</span>
													</p>
													<p>
														<?php echo __('Cached Files', 'kata-plus'); ?>:
														<span>
															<?php
																echo $cachedFiles;
															?>
														</span>
													</p>
													<input type="hidden" name="settingsAction" value="clearCache">
												</div>
												<div class="row postbox-container-footer">
													<div class="button" id="exportFonts">
														<span aria-hidden="true" class="dashicons dashicons-trash"></span>
														<?php echo esc_html__('Clear Cache', 'kata-plus'); ?>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div id="poststuff">
							<div id="postbox-container" class="postbox-container">
								<div id="normal-sortables">
									<div class="postbox">
										<form method="post">
											<div title="Click to toggle" class="handlediv"><br></div>
											<h3 class="hndle"><span><?php esc_html_e('Export', 'kata-plus'); ?></span></h3>
											<div class="inside has-footer" style="display: block;">
												<div class="font-export-options">
													<span><?php echo esc_html__('For Export Fonts-Manager Data, Click On "Export" Button.', 'inc-plus'); ?></span>
													<input type="hidden" name="settingsAction" value="export">
												</div>
												<div class="row postbox-container-footer">
													<div class="button" id="exportFonts">
														<span aria-hidden="true" class="dashicons dashicons-upload"></span>
														<?php echo esc_html__('Export', 'kata-plus'); ?>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>


						<div id="poststuff">
							<div id="postbox-container" class="postbox-container">
								<div id="normal-sortables">
									<div class="postbox">
										<form method="post">
											<div title="Click to toggle" class="handlediv"><br></div>
											<h3 class="hndle"><span><?php esc_html_e('Import', 'kata-plus'); ?></span></h3>
											<div class="inside has-footer" style="display: block;">
												<div class="fonts-manager-import-options">
													<input type="hidden" name="settingsAction" value="import">
													<textarea name="fonts_manager_import_settings" class="kata-plus-fonts-manager-add-new-font-selector-input full" rows="3"></textarea>
												</div>
												<div class="row postbox-container-footer">
													<div class="button" id="importFonts">
														<span aria-hidden="true" class="dashicons dashicons-download"></span>
														<?php echo esc_html__('Import Fonts', 'kata-plus'); ?>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>