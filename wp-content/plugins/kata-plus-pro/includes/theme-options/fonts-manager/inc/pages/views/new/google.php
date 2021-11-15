<?php
// * don't load directly.
if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}
?>
<div class="kata-plus-fonts-manager-css-selector-row-hidden">
	<div class="col table">
		<label class="block-label">CSS Selector</label>
		<input type="text" name="font_selectors[_SELECTOR_ID_][selector]" class="kata-plus-fonts-manager-add-new-font-selector-input" value=".font-_SELECTOR_ID_">
		<select name="font_selectors[_SELECTOR_ID_][variant]" class="kata-plus-fonts-manager-add-new-font-selector-select kata-plus-fonts-manager-add-new-font-selector-select-variant"></select>
		<select name="font_selectors[_SELECTOR_ID_][font_case]" class="kata-plus-fonts-manager-add-new-font-selector-select">
			<option value=""><?php echo esc_attr__('Default', 'kata-plus'); ?></option>
			<option value="uppercase"><?php echo esc_attr__('Upper case', 'kata-plus'); ?></option>
			<option value="lowercase"><?php echo esc_attr__('Lower case', 'kata-plus'); ?></option>
			<option value="capitalize"><?php echo esc_attr__('Capitalize', 'kata-plus'); ?></option>
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
		<div class="remove-selector" onclick="$(this).parent().parent().remove();"><span class="dashicons dashicons-no-alt"></span></div>
	</div>
</div>
<form method="post" class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-add-new-wrap">
	<input type="hidden" value="google" name="source">
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&controller=settings' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Settings', 'kata-plus' ); ?></a>

	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager'); ?>"><?php echo esc_html__('Font Manager', 'kata-plus'); ?></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager&action=add_new_font'); ?>"><?php echo esc_html__('Add New Font', 'kata-plus'); ?></a></span>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__('Google', 'kata-plus'); ?></span>
	</h1>

	<div class="kata-plus-action-box">
		<div>
			<input type="text" class="kata-plus-search-box" id="kata_plus_pro_fonts_manager_search_box" placeholder="<?php echo esc_attr__('Search...', 'kata-plus'); ?>">
		</div>
		<div>
			<input type="text" class="kata-plus-preview-text-box" id="kata_plus_pro_fonts_manager_preview_text" placeholder="<?php echo get_option('kata.plus.fonts_manager.font.preview.text', 'Create your awesome website, fast and easy.'); ?>">
		</div>
		<div class="kata-plus-preview-font-size-wrap">
			<b id="kata_plus_pro_fonts_manager_preview_text_font_size"><?php echo get_option('kata.plus.fonts_manager.font.preview.size', 13); ?> px</b>
			<input type="range" min="8" max="100" value="<?php echo get_option('kata.plus.fonts_manager.font.preview.size', 13); ?>">
		</div>
		<div>
			<div class="kata-plus-fonts-manager-categories-select" id="kata_plus_pro_fonts_manager_google_categories">
				<strong><?php echo esc_attr__('Categories', 'kata-plus'); ?></strong>
				<ul>
					<?php
					$categories = [
						'serif'       => 'Serif',
						'sans-serif'  => 'Sans Serif',
						'display'     => 'Display',
						'handwriting' => 'Handwriting',
						'monospace'   => 'Monospace',
					];
					$_CAT       = isset($_GET['cat']) ? explode(',', $_GET['cat']) : [];
					foreach ($categories as $slug => $name) {
						if (in_array($slug, $_CAT)) {
							$checked = ' checked="checked"';
						} else {
							$checked = '';
						}
						echo '<li>
									<label>
									<input type="checkbox" name="cat" value="' . $slug . '"' . $checked . '>
									' . $name . '
									</label>
								</li>
							';
					}
					?>
					<li class="kata-plus-google-categories-go" data-url="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager&action=add_new_font&source=google&step=2'); ?>"><?php echo esc_attr__('Go', 'kata-plus'); ?></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="kata-plus-fonts-manager-add-new-google-wrap">
		<div class="col col-10">
			<div class="kata-plus-view-type" id="kata_plus_pro_change_fonts_view_type">
				<div class="kata-plus-alphabet-filter">
					<?php $alphas = range('A', 'Z'); ?>
					<select id="kata_plus_pro_alphabet_filter_select">
						<?php foreach ($alphas as $alpha) : ?>
							<option value="<?php echo $alpha; ?>"><?php echo $alpha; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<span data-id="grid" class="active">
					<span class="dashicons dashicons-screenoptions"></span>
					<?php echo esc_attr__('Grid', 'kata-plus'); ?>
				</span>
				<span data-id="list">
					<span class="dashicons dashicons-menu-alt3"></span>
					<?php echo esc_attr__('List', 'kata-plus'); ?>
				</span>

				<strong class="search-results-count"></strong>
			</div>
		</div>
		<div class="col col-7">
			<div id="kata-plus-fonts-manager-add-font-table">
				<div class="search-result"></div>
				<div class="clear"></div>
				<div class="font-results">
					<div class="kata-plus-fonts-manager-inner-page" data-page="1">
						<?php
						if (isset($_GET['fontsPage'])) {
							$page = $_GET['fontsPage'];
						} else {
							$page = 1;
						}

						$start      = (($page - 1) * 6) + 1;
						$end        = $page * 6;
						$total      = count(Kata_plus_FontsManager_Add_New_Google_Helper::$fonts_list); // total items in array
						$limit      = 6; // per page
						$totalPages = ceil($total / $limit); // calculate total pages
						$page       = max($page, 1); // get 1 page when $_GET['page'] <= 0
						$page       = min($page, $totalPages); // get last page when $_GET['page'] > $totalPages
						$offset     = ($page - 1) * $limit;
						if ($offset < 0) {
							$offset = 0;
						}

						$fonts_list = array_slice(Kata_plus_FontsManager_Add_New_Google_Helper::$fonts_list, $offset, $limit);
						?>

						<?php foreach ($fonts_list as $item) : ?>
							<?php $n = str_replace(' ', '_', $item->family); ?>
							<div class="font-box">
								<iframe class="lozad" data-src="<?php echo admin_url('admin-ajax.php') . '?action=kata_plus_pro_fonts_manager_font_preview&single-line=true&font-family=' . $item->family . '&source=google&font-size=' . get_option('kata.plus.fonts_manager.font.preview.size', 25); ?>" frameborder="0"></iframe>
								<div class="font-box-footer">
									<span class="font-name-category">
										<b><?php echo $item->family; ?></b>
										<strong><?php echo $item->category; ?></strong>
									</span>
									<span class="font-styles-count"><?php echo sprintf('%s ' . esc_attr__('Styles', 'kata-plus'), count($item->variants)); ?></span>
									<label for="input_<?php echo $n; ?>">
										<input type="radio" required="" name="fontname" value="<?php echo $item->family; ?>" data-source="google" id="input_<?php echo $n; ?>" class="fontname">
										<?php echo esc_attr__('Select the font to import', 'kata-plus'); ?>
									</label>
								</div>
							</div>
						<?php endforeach; ?>
						<div class="clear"></div>
					</div>
					<div class="fonts-pagination-result"></div>

					<div class="clear"></div>
					<div class="lds-ripple kata-plus-fonts-manager-loading" style="display:none;">
						<div></div>
						<div></div>
					</div>
					<?php
					$link           = admin_url('admin.php?page=kata-plus-fonts-manager&action=add_new_font&source=google&step=2&fontsPage=%d');
					$pagerContainer = '<div class="kata-plus-fonts-manager-pagination">';
					if ($totalPages != 0) {
						// if ($page == 1) {
						// 	$pagerContainer .= '';
						// } elseif ($totalPages == $page) {
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page first">First</a>', 1);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page prev">Prev</a>', $page - 1);

						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 13) . '</a>', $page - 13);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 12) . '</a>', $page - 12);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 11) . '</a>', $page - 11);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 10) . '</a>', $page - 10);
						// 	$pagerContainer .= '<a class="kata-plus-page">...</a>';
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($totalPages) . '</a>', $totalPages);

						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 2) . '</a>', $page - 2);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 1) . '</a>', $page - 1);
						// } else {
						// 	if ($page > 3) {
						// 		$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page first">First</a>', 1);
						// 	}
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page prev">Prev</a>', $page - 1);
						// 	if ($page > 2) {
						// 		$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 2) . '</a>', $page - 2);
						// 	}
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page - 1) . '</a>', $page - 1);
						// }

						// if ($totalPages > $page) {
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page active">' . ($page) . '</a>', $page);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page + 1) . '</a>', $page + 1);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page + 2) . '</a>', $page + 2);
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($page + 3) . '</a>', $page + 3);
						// 	$pagerContainer .= '<a class="kata-plus-page">...</a>';
						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page">' . ($totalPages) . '</a>', $totalPages);
						// } else {

						// 	$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page active">' . ($page) . '</a>', $page);
						// }


						// $pagerContainer .= ' <span> page <strong>' . $page . '</strong> from ' . $totalPages . '</span>';
						if ($page == $totalPages) {
							$pagerContainer .= '';
						} else {
							$pagerContainer .= sprintf('<a href="' . $link . '" class="kata-plus-page next hidden" style="display:none;">Next</a>', $page + 1);
						}
					}
					$pagerContainer .= '</div>';

					echo $pagerContainer;
					?>

				</div>
			</div>
		</div>

		<div class="col col-3">
			<div class="fonts-manager-sticky">
				<div class="kata-plus-fonts-manager-font-family">
					<div class="title">
						Font Family:
					</div>
					<div class="name">
						<?php echo esc_html__('Choose once', 'kata-plus'); ?>
					</div>
				</div>

				<div id="poststuff">
					<div id="postbox-container" class="postbox-container">
						<div class="meta-box-sortables ui-sortable" id="normal-sortables">
							<div class="postbox">
								<div title="Click to toggle" class="handlediv"><br></div>
								<h3 class="hndle"><span><?php echo esc_attr__('Font Variants', 'kata-plus'); ?></span></h3>
								<div class="inside" id="fonts_manager_font_variants">
								</div>
							</div>

							<div class="postbox">
								<div title="Click to toggle" class="handlediv"><br></div>
								<h3 class="hndle"><span><?php echo esc_attr__('Font Subsets', 'kata-plus'); ?></span></h3>
								<div class="inside" id="fonts_manager_font_subsets">
								</div>
							</div>

							<div class="postbox ">
								<div title="Click to toggle" class="handlediv"><br></div>
								<h3 class="hndle"><span><?php echo esc_attr__('Other Options', 'kata-plus'); ?></span></h3>
								<div class="inside">
									<div class="row">
										<div class="col table">
											<label class="block-label"><?php echo esc_attr__('Font status', 'kata-plus'); ?></label>
											<select name="font_status" class="kata-plus-fonts-manager-add-new-font-selector-select">
												<option value="published"><?php echo esc_attr__('Published', 'kata-plus'); ?></option>
												<option value="unpublished"><?php echo esc_attr__('Unpublished', 'kata-plus'); ?></option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="kata-plus-fonts-manager-submit-content">
								<input type="submit" class="button button-block" value="<?php echo esc_html__('Save The Font', 'kata-plus'); ?>">
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
				<div class="postbox hidden">
					<div title="Click to toggle" class="handlediv"><br></div>
					<h3 class="hndle"><span>Selectors and Sizes</span></h3>
					<div class="inside has-footer css-selector-wrap">
						<div class="row postbox-container-footer">
							<div class="button" id="add-new-section">
								<span aria-hidden="true" class="dashicons dashicons-plus"></span><?php echo esc_html__('Add new selector', 'kata-plus'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<div id="fonts_box_html" style="display:none">
	<div class="font-box" data-src="<?php echo admin_url('admin-ajax.php') . '?action=kata_plus_pro_fonts_manager_font_preview&single-line=true&source=google&font-size=' . get_option('kata.plus.fonts_manager.font.preview.size', 25) . '&font-family='; ?>">
		<div class="font-box-footer">
			<span class="font-name-category">
				<b></b>
				<strong></strong>
			</span>
			<span class="font-styles-count"></span>
			<label>
				<input type="radio" required="" name="fontname" value="" data-source="google" class="fontname">
				<?php echo esc_attr__('Select the font to import', 'kata-plus'); ?>
			</label>
		</div>
	</div>
</div>