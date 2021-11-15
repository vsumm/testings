<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$grid = false;

$base = new Essential_Grid_Base();
$nav_skin = new Essential_Grid_Navigation();
$wa = new Essential_Grid_Widget_Areas();
$meta = new Essential_Grid_Meta();

$isCreate = $base->getGetVar('create', 'true');

$esg_color_picker_presets = ESGColorpicker::get_color_presets();

$title = esc_attr__('Create New Grid', ESG_TEXTDOMAIN);
$save = esc_attr__('Save Grid', ESG_TEXTDOMAIN);

$layers = false;

if (intval($isCreate) > 0) {
	//currently editing
	$grid = Essential_Grid::get_essential_grid_by_id(intval($isCreate));
	if (!empty($grid)) {
		$title = esc_attr__('Settings', ESG_TEXTDOMAIN);
		$layers = $grid['layers'];
	}
} else {
	$editAlias = $base->getGetVar('alias', false);
	if ($editAlias) {
		$grid = Essential_Grid::get_essential_grid_by_handle($editAlias);
		if (!empty($grid)) {
			$title = esc_attr__('Settings', ESG_TEXTDOMAIN);
			$layers = $grid['layers'];
		}
	}
}

$postTypesWithCats = $base->getPostTypesWithCatsForClient();
$jsonTaxWithCats = $base->jsonEncodeForClientSide($postTypesWithCats);

$base = new Essential_Grid_Base();

$pages = get_pages(array('sort_column' => 'post_name'));

$post_elements = $base->getPostTypesAssoc();

$postTypes = $base->getVar($grid, array('postparams', 'post_types'), 'post');
$categories = $base->setCategoryByPostTypes($postTypes, $postTypesWithCats);

$selected_pages = explode(',', $base->getVar($grid, array('postparams', 'selected_pages'), '-1', 's'));

$columns = $base->getVar($grid, array('params', 'columns'), '');
$columns = $base->set_basic_colums($columns);

$mascontent_height = $base->getVar($grid, array('params', 'mascontent-height'), '');
$mascontent_height = $base->set_basic_mascontent_height($mascontent_height);

$columns_width = $base->getVar($grid, array('params', 'columns-width'), '');
$columns_width = $base->set_basic_colums_width($columns_width);

$columns_height = $base->getVar($grid, array('params', 'columns-height'), '');
$columns_height = $base->set_basic_colums_height($columns_height);

$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-0'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-1'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-2'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-3'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-4'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-5'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-6'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-7'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-8'), '');
$columns_advanced[] = $base->getVar($grid, array('params', 'columns-advanced-rows-9'), '');

$nav_skin_choosen = $base->getVar($grid, array('params', 'navigation-skin'), 'minimal-light');
$navigation_skins = $nav_skin->get_essential_navigation_skins();
$navigation_skin_css = $base->jsonEncodeForClientSide($navigation_skins);

$entry_skins = Essential_Grid_Item_Skin::get_essential_item_skins();
$entry_skin_choosen = $base->getVar($grid, array('params', 'entry-skin'), '0');

$grid_animations = $base->get_grid_animations();
$start_animations = $base->get_start_animations();
$grid_item_animations = $base->get_grid_item_animations();
$hover_animations = $base->get_hover_animations();
$grid_animation_choosen = $base->getVar($grid, array('params', 'grid-animation'), 'fade');
$grid_start_animation_choosen = $base->getVar($grid, array('params', 'grid-start-animation'), 'reveal');
$grid_item_animation_choosen = $base->getVar($grid, array('params', 'grid-item-animation'), 'none');
$grid_item_animation_other = $base->getVar($grid, array('params', 'grid-item-animation-other'), 'none');
$hover_animation_choosen = $base->getVar($grid, array('params', 'hover-animation'), 'fade');

if(intval($isCreate) > 0) //currently editing, so default can be empty
	$media_source_order = $base->getVar($grid, array('postparams', 'media-source-order'), '');
else
	$media_source_order = $base->getVar($grid, array('postparams', 'media-source-order'), array('featured-image'));

$media_source_list = $base->get_media_source_order();

$custom_elements = $base->get_custom_elements_for_javascript();

$all_image_sizes = $base->get_all_image_sizes();
$all_media_filters = $base->get_all_media_filters();

$meta_keys = $meta->get_all_meta_handle();

// INIT POSTER IMAGE SOURCE ORDERS
if (intval($isCreate) > 0) {
	//currently editing, so default can be empty
	$poster_source_order = $base->getVar($grid, array('params', 'poster-source-order'), '');
	if ($poster_source_order == '') { //since 2.1.0
		$poster_source_order = $base->getVar($grid, array('postparams', 'poster-source-order'), '');
	}
} else {
	$poster_source_order = $base->getVar($grid, array('postparams', 'poster-source-order'), array('featured-image'));
}

$poster_source_list = $base->get_poster_source_order();

$esg_default_skins = $nav_skin->get_default_navigation_skins();

?>

<!-- LEFT SETTINGS -->
<h2 class="topheader"><?php echo $title; ?><a target="_blank" class="esg-help-button esg-btn esg-red" href="https://www.themepunch.com/support-center/essential-grid/#documentation"><i class="material-icons">help</i><?php esc_html_e('Help Center', ESG_TEXTDOMAIN); ?></a></h2>
<div class="eg-pbox esg-box esg-box-min-width">
	<div class="esg-box-title"><span><?php esc_html_e('Layout Composition', ESG_TEXTDOMAIN); ?></span><div class="eg-pbox-arrow"></div></div>
	<div class="esg-box-inside esg-box-inside-layout">

		<!-- MENU -->
		<div id="eg-create-settings-menu">
			<ul>
				<li class="eg-menu-placeholder"></li>
				<li id="esg-naming-tab" class="selected-esg-setting" data-toshow="eg-create-settings"><i class="eg-icon-cog"></i><p><?php esc_html_e('Naming', ESG_TEXTDOMAIN); ?></p></li>
				<li id="esg-source-tab" class="selected-source-setting" data-toshow="esg-settings-posts-settings"><i class="eg-icon-folder"></i><p><?php esc_html_e('Source', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-grid-settings"><i class="eg-icon-menu"></i><p><?php esc_html_e('Grid Settings', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-filterandco-settings"><i class="eg-icon-shuffle"></i><p><?php esc_html_e('Nav-Filter-Sort', ESG_TEXTDOMAIN); ?></p></li>
				<li id="esg-skins-tab" class="" data-toshow="esg-settings-skins-settings"><i class="eg-icon-droplet"></i><p><?php esc_html_e('Skins', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-animations-settings"><i class="eg-icon-tools"></i><p><?php esc_html_e('Animations', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-lightbox-settings"><i class="eg-icon-search"></i><p><?php esc_html_e('Lightbox', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-ajax-settings"><i class="eg-icon-ccw-1"></i><p><?php esc_html_e('Ajax', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-spinner-settings"><i class="eg-icon-back-in-time"></i><p><?php esc_html_e('Spinner', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-api-settings"><i class="eg-icon-magic"></i><p><?php esc_html_e('API/JavaScript', ESG_TEXTDOMAIN); ?></p></li>
				<li class="" data-toshow="esg-settings-cookie-settings"><i class="eg-icon-eye"></i><p><?php esc_html_e('Cookies', ESG_TEXTDOMAIN); ?></p></li>
				<div class="clear"></div>
			</ul>
		 </div>

		<!--
		NAMING
		-->
		<div id="eg-create-settings" class="esg-settings-container active-esc">
			<div class="">
				<div class="eg-cs-tbc-left">
					<esg-llabel><span><?php esc_html_e('Naming', ESG_TEXTDOMAIN); ?></span></esg-llabel>
				</div>
				<div class="eg-cs-tbc">
					<?php if($grid !== false){ ?>
					<input type="hidden" name="eg-id" value="<?php echo $grid['id']; ?>" />
					<?php } ?>
					<div><label for="name" class="eg-tooltip-wrap" title="<?php esc_attr_e('Name of the grid', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Title', ESG_TEXTDOMAIN); ?></label> <input type="text" name="name" value="<?php echo $base->getVar($grid, 'name', '', 's'); ?>" /> *</div>
					<div class="div13"></div>
					<div><label for="handle" class="eg-tooltip-wrap" title="<?php esc_attr_e('Technical alias without special chars and white spaces', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Alias', ESG_TEXTDOMAIN); ?></label> <input type="text" name="handle" value="<?php echo $base->getVar($grid, 'handle', '', 's'); ?>" /> *</div>
					<div class="div13"></div>
					<div><label for="shortcode" class="eg-tooltip-wrap" title="<?php esc_attr_e('Copy this shortcode to paste it to your pages or posts content', ESG_TEXTDOMAIN); ?>" ><?php esc_html_e('Shortcode', ESG_TEXTDOMAIN); ?></label> <input type="text" name="shortcode" value="" readonly="readonly" /></div>
					<div class="div13"></div>
					<div><label for="id" class="eg-tooltip-wrap" title="<?php esc_attr_e('Add a unique ID to be able to add CSS to certain Grids', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('CSS ID', ESG_TEXTDOMAIN); ?></label> <input type="text" name="css-id" id="esg-id-value" value="<?php echo $base->getVar($grid, array('params', 'css-id'), '', 's'); ?>" /></div>
				</div>
			</div>
		</div>

		<!--
		SOURCE
		-->
		<div id="esg-settings-posts-settings" class="esg-settings-container">
			<div class="">
				<form id="eg-form-create-posts">
					<div class="">
						<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Source', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc ">
							<label for="shortcode" class="eg-tooltip-wrap" title="<?php esc_attr_e('Choose source of grid items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Based on', ESG_TEXTDOMAIN); ?></label><!--
							--><div class="esg-staytog"><input type="radio" name="source-type" value="post" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'source-type'), 'post'), 'post'); ?>><span class="eg-tooltip-wrap" title="<?php esc_attr_e('Items from Posts, Custom Posts', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Post, Pages, Custom Posts', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
							--><div class="esg-staytog"><input type="radio" name="source-type" value="custom" class="esg-source-choose-wrapper" <?php echo checked($base->getVar($grid, array('postparams', 'source-type'), 'post'), 'custom'); ?> ><span class="eg-tooltip-wrap" title="<?php esc_attr_e('Items from the Media Gallery (Bulk Selection, Upload Possible)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Custom Grid (Editor Below)', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
							--><div class="esg-staytog"><input type="radio" name="source-type" value="stream" class="esg-source-choose-wrapper" <?php echo checked($base->getVar($grid, array('postparams', 'source-type'), 'post'), 'stream'); ?>><span class="eg-tooltip-wrap" title="<?php esc_attr_e('Fetches dynamic streams from several sources ', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
							--><?php if(array_key_exists('nggdb', $GLOBALS) ){ ?>
								<div class="esg-staytog"><input type="radio" name="source-type" value="nextgen" class="esg-source-choose-wrapper" <?php echo checked($base->getVar($grid, array('postparams', 'source-type'), 'post'), 'nextgen'); ?>><span class="eg-tooltip-wrap" title="<?php esc_attr_e('Fetches NextGen Galleries and Albums ', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('NextGen Gallery', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div>
							<?php } ?>
							<?php if( function_exists('wp_rml_dropdown') ){ ?>
								<div class="esg-staytog"><input type="radio" name="source-type" value="rml" class="esg-source-choose-wrapper" <?php echo checked($base->getVar($grid, array('postparams', 'source-type'), 'post'), 'rml'); ?>><span class="eg-tooltip-wrap" title="<?php esc_attr_e('Fetches Real Media Library Galleries and Folders', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Real Media Library', ESG_TEXTDOMAIN); ?></span></div>
							<?php } ?>
							<?php do_action('essgrid_grid_source',$base,$grid); ?>
						</div>
					</div>

					<div id="custom-sorting-wrap" class="esg-display-none">
						<ul id="esg-custom-li-sorter" class="esg-margin-0">
						</ul>
					</div>
					<div id="post-pages-wrap">
						<div class="">
							<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Type and Category', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
							<div class="eg-cs-tbc">
								<label for="post_types" class="eg-tooltip-wrap" title="<?php esc_attr_e('Select Post Types (multiple selection possible)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Post Types', ESG_TEXTDOMAIN); ?></label><!--
								--><select name="post_types" size="5" multiple="multiple">
									<?php
									$selectedPostTypes = array();
									$post_types = $base->getVar($grid, array('postparams', 'post_types'), 'post');
									if(!empty($post_types))
										$selectedPostTypes = explode(',',$post_types);
									else
										$selectedPostTypes = array('post');

									if(!empty($post_elements)){
										// 3.0.12
										$foundOne = false;
										foreach($post_elements as $handle => $name){
											if(!$foundOne && in_array($handle, $selectedPostTypes)) {
												$foundOne = true;
											}
										}
										$postTypeCount = 0;
										foreach($post_elements as $handle => $name){
											if($postTypeCount === 0 && !$foundOne) {
												$selected = ' selected';
											} else {
												$selected = in_array($handle, $selectedPostTypes) ? ' selected' : '';
											}
											?>
											<option value="<?php echo $handle; ?>"<?php echo $selected; ?>><?php echo $name; ?></option>
											<?php
											$postTypeCount++;
										}
									}
									?>
								</select>

								<div id="eg-post-cat-wrap">
									<div class="div13"></div>
									<label for="post_category" class="eg-tooltip-wrap" title="<?php esc_attr_e('Select Categories and Tags (multiple selection possible)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Post Categories', ESG_TEXTDOMAIN); ?></label><!--
									--><select id="post_category" name="post_category" size="7" multiple="multiple" >
										<?php
										$selectedCats = array();
										$post_cats = $base->getVar($grid, array('postparams', 'post_category'), '');
										if(!empty($post_cats))
											$selectedCats = explode(',',$post_cats);
										else
											$selectedCats = array();
										
										foreach ($categories as $handle => $cat) {
											$isDisabled = strpos($handle, 'option_disabled_') !== false;
											if(!$isDisabled) {
												$selected = in_array($handle, $selectedCats) ? ' data-selected="true"' : '';
											} else {
												$selected = '';
											}
											?>
											<option value="<?php echo $handle; ?>"<?php echo $selected; ?><?php echo $isDisabled ? ' disabled="disabled"' : ''; ?>><?php echo $cat; ?></option>
											<?php
										}
										?>
									</select>
								</div>
								<div class="div15"></div>
								<label>&nbsp;</label><a class="esg-btn esg-purple eg-clear-taxonomies" href="javascript:void(0);"><?php esc_html_e('Clear Categories', ESG_TEXTDOMAIN); ?></a>
								<div class="div5"></div>
								<label for="category-relation"><?php esc_html_e('Category Relation', ESG_TEXTDOMAIN); ?></label><!--
								--><input type="radio" value="OR" name="category-relation" <?php checked($base->getVar($grid, array('postparams', 'category-relation'), 'OR'), 'OR'); ?> class=""><span class="eg-tooltip-wrap" title="<?php esc_attr_e('Post need to be in one of the selected categories/tags', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('OR', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
								--><input type="radio" value="AND" name="category-relation" <?php checked($base->getVar($grid, array('postparams', 'category-relation'), 'OR'), 'AND'); ?>><span class="eg-tooltip-wrap" title="<?php esc_attr_e('Post need to be in all categories/tags selected', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('AND', ESG_TEXTDOMAIN); ?></span>
								<div class="div13"></div>

								<div id="eg-additional-post">
									<label for="additional-query" class="eg-tooltip-wrap" title="<?php esc_attr_e('Please use it like \'year=2012&monthnum=12\'', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Additional Parameters', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="text" name="additional-query" class="eg-additional-parameters esg-w-305" value="<?php echo $base->getVar($grid, array('postparams', 'additional-query'), ''); ?>" />
									<div><label></label><?php esc_html_e('Please use it like \'year=2012&monthnum=12\' or \'post__in=array(1,2,5)&post__not_in=array(25,10)\'', ESG_TEXTDOMAIN); ?>&nbsp;-&nbsp;
									<?php _e('For a full list of parameters, please visit <a href="https://codex.wordpress.org/Class_Reference/WP_Query" target="_blank">this</a> link', ESG_TEXTDOMAIN); ?></div>
								</div>
							</div>
						</div>
					</div>

					<div id="set-pages-wrap">
						<div class="">
							<div class="eg-cs-tbc-left">
								<esg-llabel><span><?php esc_html_e('Pages', ESG_TEXTDOMAIN); ?></span></esg-llabel>
							</div>
							<div class="eg-cs-tbc">
								<label for="pages" class="eg-tooltip-wrap" title="<?php esc_attr_e('Additional filtering on pages,Start to type a page title for pre selection', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select Pages', ESG_TEXTDOMAIN); ?></label><!--
								--><input type="text" id="pages" value="" name="search_pages"> <a class="esg-btn esg-purple" id="button-add-pages" href="javascript:void(0);"><i class="material-icons">add</i></a>
								<div id="pages-wrap">
									<?php
									if(!empty($pages)){
										foreach($pages as $page){
											if(in_array($page->ID, $selected_pages)){
												?>
												<div class="esg-page-list-element-wrap"><div class="esg-page-list-element" data-id="<?php echo $page->ID; ?>"><?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?></div><div class="esg-btn esg-red del-page-entry"><i class="eg-icon-trash"></i></div></div>
												<?php
											}
										}
									}
									?>
								</div>
								<select name="selected_pages" multiple="true" class="esg-display-none">
									<?php
									if (!empty($pages)) {
										foreach ($pages as $page) { ?>
											<option value="<?php echo $page->ID; ?>"<?php echo (in_array($page->ID, $selected_pages)) ? ' selected' : ''; ?>><?php echo str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')'; ?></option>
										<?php
										}
									}
									?>
								</select>
							</div>
						</div>

					</div>

					<div id="aditional-pages-wrap">
						<div class="">
							<div class="eg-cs-tbc-left">
								<esg-llabel><span><?php esc_html_e('Options', ESG_TEXTDOMAIN); ?></span></esg-llabel>
							</div>
							<div class="eg-cs-tbc">
								<?php
								$max_entries = intval($base->getVar($grid, array('postparams', 'max_entries'), '-1'));
								?>
								<label for="pages" class="eg-tooltip-wrap" title="<?php esc_attr_e('Defines a posts limit, use only numbers, -1 will disable this option, use only numbers', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Maximum Posts', ESG_TEXTDOMAIN); ?></label><!--
								--><input type="number" value="<?php echo $max_entries; ?>" name="max_entries">
								<div class="div13"></div>
								<?php
								$max_entries_preview = intval($base->getVar($grid, array('postparams', 'max_entries_preview'), '20'));
								?>

								<label for="pages" class="eg-tooltip-wrap" title="<?php esc_attr_e('Defines a posts limit, use only numbers, -1 will disable this option, use only numbers', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Maximum Posts Preview', ESG_TEXTDOMAIN); ?></label><!--
								--><input type="number" value="<?php echo $max_entries_preview; ?>" name="max_entries_preview">

							</div>
						</div>

					</div>

					<div id="all-stream-wrap">
						<div id="external-stream-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Service', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc ">
									<label for="shortcode" class="eg-tooltip-wrap" title="<?php esc_attr_e('Choose source of grid items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Provider', ESG_TEXTDOMAIN); ?></label><!--
										--><div class="esg-staytog"><input type="radio" name="stream-source-type" value="youtube" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'stream-source-type'), 'instagram'), 'youtube'); ?>><span class="inplabel"><?php esc_html_e('YouTube', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
										--><div class="esg-staytog"><input type="radio" name="stream-source-type" value="vimeo" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'stream-source-type'), 'instagram'), 'vimeo'); ?>><span class="inplabel"><?php esc_html_e('Vimeo', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
										--><div class="esg-staytog"><input type="radio" name="stream-source-type" value="instagram" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'stream-source-type'), 'instagram'), 'instagram'); ?>><span class="inplabel"><?php esc_html_e('Instagram', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
										--><div class="esg-staytog"><input type="radio" name="stream-source-type" value="flickr" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'stream-source-type'), 'instagram'), 'flickr'); ?>><span class="inplabel"><?php esc_html_e('Flickr', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
										--><div class="esg-staytog"><input type="radio" name="stream-source-type" value="facebook" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'stream-source-type'), 'instagram'), 'facebook'); ?>><span class="inplabel"><?php esc_html_e('Facebook', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
										--><div class="esg-staytog"><input type="radio" name="stream-source-type" value="twitter" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'stream-source-type'), 'instagram'), 'twitter'); ?>><span class="inplabel"><?php esc_html_e('Twitter', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div><!--
										--><div class="esg-staytog"><input type="radio" name="stream-source-type" value="behance" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'stream-source-type'), 'instagram'), 'behance'); ?>><span class="inplabel"><?php esc_html_e('Behance', ESG_TEXTDOMAIN); ?></span><div class="space18"></div></div>
									<div id="eg-source-youtube-message"><label></label><span class="description"><?php esc_html_e('The "YouTube Stream" content source is used to display a full stream of videos from a channel/playlist.', ESG_TEXTDOMAIN); ?></span></div>
									<div id="eg-source-vimeo-message"><label></label><span class="description"><?php esc_html_e('The "Vimeo Stream" content source is used to display a full stream of max 60 videos from a user/album/group/channel.', ESG_TEXTDOMAIN); ?></span></div>
								</div>
							</div>

						</div>

						<div id="youtube-external-stream-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('API', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in the YouTube API key', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('API Key', ESG_TEXTDOMAIN); ?></label><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'youtube-api'), ''); ?>" name="youtube-api" id="youtube-api"><div class="space18"></div><!--
									--><span class="description"><?php _e('Find information about the YouTube API key <a target="_blank" href="https://developers.google.com/youtube/v3/getting-started#before-you-start">here</a>', ESG_TEXTDOMAIN); ?></span>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label  class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in the ID of the YouTube channel', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Channel ID', ESG_TEXTDOMAIN); ?></label><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'youtube-channel-id'), ''); ?>" name="youtube-channel-id" id="youtube-channel-id"><div class="space18"></div><!--
									--><span class="description"><?php _e('See how to find the Youtube channel ID <a target="_blank" href="https://support.google.com/youtube/answer/3250431?hl=en">here</a>', ESG_TEXTDOMAIN); ?></span>
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Display the channel videos or playlist', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Source', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="radio" name="youtube-type-source" value="channel" class="" <?php checked($base->getVar($grid, array('postparams', 'youtube-type-source'), 'channel'), 'channel'); ?>><span class="inplabel"><?php esc_html_e('Channel', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="youtube-type-source" value="playlist_overview" <?php checked($base->getVar($grid, array('postparams', 'youtube-type-source'), 'channel'), 'playlist_overview'); ?> > <span class="inplabel"><?php esc_html_e('Overview Playlists', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="youtube-type-source" value="playlist" <?php checked($base->getVar($grid, array('postparams', 'youtube-type-source'), 'channel'), 'playlist'); ?> > <span class="inplabel"><?php esc_html_e('Single Playlist', ESG_TEXTDOMAIN); ?></span>

									<div id="eg-external-source-youtube-playlist-wrap">
										<div class="div13"></div>
										<?php $youtube_playlist = $base->getVar($grid, array('postparams', 'youtube-playlist'), '');
										?>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the playlist you want to pull the data from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select Playlist', ESG_TEXTDOMAIN); ?></label><input type="hidden" name="youtube-playlist" value="<?php echo $youtube_playlist; ?>"><!--
										--><select name="youtube-playlist-select" id="youtube-playlist-select"></select>
									</div>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Image Sizes', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the Grid Items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Grid Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="youtube-thumb-size">
										<option value='default' <?php selected( $base->getVar($grid, array('postparams', 'youtube-thumb-size'), 'default'), 'default');?>><?php esc_html_e('Default (120px)', ESG_TEXTDOMAIN);?></option>
										<option value='medium' <?php selected( $base->getVar($grid, array('postparams', 'youtube-thumb-size'), 'default'), 'medium');?>><?php esc_html_e('Medium (320px)', ESG_TEXTDOMAIN);?></option>
										<option value='high' <?php selected( $base->getVar($grid, array('postparams', 'youtube-thumb-size'), 'default'), 'high');?>><?php esc_html_e('High (480px)', ESG_TEXTDOMAIN);?></option>
										<option value='standard' <?php selected( $base->getVar($grid, array('postparams', 'youtube-thumb-size'), 'default'), 'standard');?>><?php esc_html_e('Standard (640px)', ESG_TEXTDOMAIN);?></option>
										<option value='maxres' <?php selected( $base->getVar($grid, array('postparams', 'youtube-thumb-size'), 'default'), 'maxres');?>><?php esc_html_e('Max. Res. (1280px)', ESG_TEXTDOMAIN);?></option>
									</select>
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the lightbox, links, etc.', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Full Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="youtube-full-size">
										<option value='default' <?php selected( $base->getVar($grid, array('postparams', 'youtube-full-size'), 'default'), 'default');?>><?php esc_html_e('Default (120px)', ESG_TEXTDOMAIN);?></option>
										<option value='medium' <?php selected( $base->getVar($grid, array('postparams', 'youtube-full-size'), 'default'), 'medium');?>><?php esc_html_e('Medium (320px)', ESG_TEXTDOMAIN);?></option>
										<option value='high' <?php selected( $base->getVar($grid, array('postparams', 'youtube-full-size'), 'default'), 'high');?>><?php esc_html_e('High (480px)', ESG_TEXTDOMAIN);?></option>
										<option value='standard' <?php selected( $base->getVar($grid, array('postparams', 'youtube-full-size'), 'default'), 'standard');?>><?php esc_html_e('Standard (640px)', ESG_TEXTDOMAIN);?></option>
										<option value='maxres' <?php selected( $base->getVar($grid, array('postparams', 'youtube-full-size'), 'default'), 'maxres');?>><?php esc_html_e('Max. Res. (1280px)', ESG_TEXTDOMAIN);?></option>
									</select>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Details', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Stream this number of videos. -1 to stream all available videos', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Count', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'youtube-count'), '12'); ?>" name="youtube-count">
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Keep stream result cached (recommended)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream Cache (sec)', ESG_TEXTDOMAIN); ?></label><!--
									--><div class="cachenumbercheck">
										<input id="youtube-transient-sec" type="number" value="<?php echo $base->getVar($grid, array('postparams', 'youtube-transient-sec'), '86400'); ?>" name="youtube-transient-sec"><div class="space18"></div><a id="clear_cache_youtube" class="esg-btn esg-purple eg-clear-cache" href="javascript:void(0);" data-clear="youtube-transient-sec">Clear Cache</a><div class="space18"></div><!--
										--><span class="importantlabel showonsmallcache description"><?php esc_html_e('Small cache intervals may influence the loading times negatively.', ESG_TEXTDOMAIN); ?></span>
									</div>
								</div>
							</div>

						</div> <!-- End YouTube Stream -->

						<div id="vimeo-external-stream-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Source of Vimeo videos', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Videos of', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="radio" name="vimeo-type-source" value="user" class="" <?php checked($base->getVar($grid, array('postparams', 'vimeo-type-source'), 'user'), 'user'); ?>><span class="inplabel"><?php esc_html_e('User', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="vimeo-type-source" value="album" <?php checked($base->getVar($grid, array('postparams', 'vimeo-type-source'), 'user'), 'album'); ?>><span class="inplabel"><?php esc_html_e('Album', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="vimeo-type-source" value="group" <?php checked($base->getVar($grid, array('postparams', 'vimeo-type-source'), 'user'), 'group'); ?>><span class="inplabel"><?php esc_html_e('Group', ESG_TEXTDOMAIN); ?>	</span><div class="space18"></div><!--
									--><input type="radio" name="vimeo-type-source" value="channel" <?php checked($base->getVar($grid, array('postparams', 'vimeo-type-source'), 'user'), 'channel'); ?>><span class="inplabel"><?php esc_html_e('Channel', ESG_TEXTDOMAIN); ?></span>
									<div class="div13"></div>
									<div id="eg-external-source-vimeo-user-wrap" class="eg-external-source-vimeo">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('ID of the user', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('User', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'vimeo-username'), ''); ?>" name="vimeo-username">
									</div>
									<div id="eg-external-source-vimeo-group-wrap" class="eg-external-source-vimeo">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('ID of the group', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Group', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'vimeo-groupname'), ''); ?>" name="vimeo-groupname">
									</div>
									<div id="eg-external-source-vimeo-album-wrap" class="eg-external-source-vimeo">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('The ID of the album', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Album ID', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'vimeo-albumid'), ''); ?>" name="vimeo-albumid">
									</div>
									<div id="eg-external-source-vimeo-channel-wrap" class="eg-external-source-vimeo">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('ID of the channel', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Channel', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'vimeo-channelname'), ''); ?>" name="vimeo-channelname">
									</div>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Image Sizes', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the Grid Items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Grid Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="vimeo-thumb-size">
										<option value='thumbnail_small' <?php selected( $base->getVar($grid, array('postparams', 'vimeo-thumb-size'), 'thumbnail_small'), 'thumbnail_small');?>><?php esc_html_e('Small (100px)', ESG_TEXTDOMAIN);?></option>
										<option value='thumbnail_medium' <?php selected( $base->getVar($grid, array('postparams', 'vimeo-thumb-size'), 'thumbnail_small'), 'thumbnail_medium');?>><?php esc_html_e('Medium (200px)', ESG_TEXTDOMAIN);?></option>
										<option value='thumbnail_large' <?php selected( $base->getVar($grid, array('postparams', 'vimeo-thumb-size'), 'thumbnail_small'), 'thumbnail_large');?>><?php esc_html_e('Large (640px)', ESG_TEXTDOMAIN);?></option>
									</select>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Details', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Display this number of videos', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Count', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'vimeo-count'), '12'); ?>" name="vimeo-count">
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Keep stream result cached (recommended)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream Cache (sec)', ESG_TEXTDOMAIN); ?></label><!--
									--><div class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'vimeo-transient-sec'), '86400'); ?>" name="vimeo-transient-sec"><div class="space18"></div><a id="clear_cache_vimeo"  class="esg-btn esg-purple eg-clear-cache" href="javascript:void(0);" data-clear="vimeo-transient-sec">Clear Cache</a><div class="space18"></div><!--
										--><span class="importantlabel showonsmallcache description"><?php esc_html_e('Small cache intervals may influence the loading times negatively.', ESG_TEXTDOMAIN); ?></span>
									</div>
								</div>
							</div>

						</div><!-- End Vimeo Stream -->


						<div id="instagram-external-stream-wrap">
							<div class=" instagram_user">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc stream-api-settings">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Choose Instagram Token Source', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Token Source', ESG_TEXTDOMAIN); ?></label><!--
									--><select class="eg-select-with-subcontrols" data-container=".instagram-token-source" name="instagram-token-source">
											<option value='account' <?php selected( $base->getVar($grid, array('postparams', 'instagram-token-source'), 'account'), 'account');?>><?php esc_html_e('From Account', ESG_TEXTDOMAIN);?></option>
											<option value='manual' <?php selected( $base->getVar($grid, array('postparams', 'instagram-token-source'), 'account'), 'manual');?>><?php esc_html_e('Manual', ESG_TEXTDOMAIN);?></option>
										</select>
									<div class="div13"></div>

									<div class="instagram-token-source instagram-token-source-account esg-display-none">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Connected Instagram Account', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Connected To', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'instagram-connected-to'), ''); ?>" name="instagram-connected-to" placeholder="<?php esc_html_e('Not yet Connected', ESG_TEXTDOMAIN);?>" disabled >
										<div class="div13"></div>

										<a id="instagram_connect_account" class="esg-btn esg-btn-save-goto esg-purple eg-instagram-connect-account" href="<?php echo Essential_Grid_Instagram::get_login_url(); ?>">Connect an Instagram Account</a><div class="space18"></div><!--
										--><span class="description"><?php esc_html_e('You will be redirected to Instagram and then back to the grid settings page. Your current settings will be auto saved.', ESG_TEXTDOMAIN);?></span>
									</div>

									<div class="instagram-token-source instagram-token-source-manual esg-display-none">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in the Facebook Instagram API key', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('API Key', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'instagram-api-key'), ''); ?>" name="instagram-api-key"><div class="space18"></div><!--
										--><span class="description"><?php _e('Please check this <a target="_blank" href="https://www.themepunch.com/faq/instagram-stream-setup-instructions-with-access-token/">FAQ</a> on how to generate your Instagram Access Token in Facebook manually.', ESG_TEXTDOMAIN); ?></span>
									</div>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Details', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Display this number of photos', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Count', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'instagram-count'), '12'); ?>" name="instagram-count">
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Keep stream result cached (recommended)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream Cache (sec)', ESG_TEXTDOMAIN); ?></label><!--
									--><div class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'instagram-transient-sec'), '86400'); ?>" name="instagram-transient-sec"><div class="space18"></div><a id="clear_cache_instagram"  class="esg-btn esg-purple eg-clear-cache" href="javascript:void(0);" data-clear="instagram-transient-sec">Clear Cache</a><div class="space18"></div><!--
										--><span class="importantlabel showonsmallcache description"><?php esc_html_e('Please use no cache smaller than 1800 seconds or Instagram might ban your IP temporarily.', ESG_TEXTDOMAIN); ?></span>
									</div>
								</div>
							</div>

						</div><!-- End Instagram Stream -->

						<div id="flickr-external-stream-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('API', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in your Flickr API Key', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Flickr API Key', ESG_TEXTDOMAIN); ?></label><!--
									--><input class="esg-w-335" type="text" value="<?php echo $base->getVar($grid, array('postparams', 'flickr-api-key'), ''); ?>" name="flickr-api-key"><div class="space18"></div><!--
									--><span class="description"><?php _e('Read <a target="_blank" href="http://weblizar.com/get-flickr-api-key/">here</a> how to get your Flickr API key', ESG_TEXTDOMAIN); ?></span>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the flickr streaming source?', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Source', ESG_TEXTDOMAIN); ?></label><!--
									--><span class="inplabel"><input type="radio" name="flickr-type" value="publicphotos" class="" <?php checked($base->getVar($grid, array('postparams', 'flickr-type'), 'publicphotos'), 'publicphotos'); ?>> <?php esc_html_e('User Public Photos', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><span class="inplabel"><input type="radio" name="flickr-type" value="photosets" <?php checked($base->getVar($grid, array('postparams', 'flickr-type'), 'publicphotos'), 'photosets'); ?>> <?php esc_html_e('User Album', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><span class="inplabel"><input type="radio" name="flickr-type" value="gallery" <?php checked($base->getVar($grid, array('postparams', 'flickr-type'), 'publicphotos'), 'gallery'); ?>> <?php esc_html_e('Gallery', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><span class="inplabel"><input type="radio" name="flickr-type" value="group" <?php checked($base->getVar($grid, array('postparams', 'flickr-type'), 'publicphotos'), 'group'); ?>> <?php esc_html_e('Groups\' Photos', ESG_TEXTDOMAIN); ?></span><div class="space18"></div>
									<div class="div13"></div>
									<div id="eg-external-source-flickr-sources">
										<div id="eg-external-source-flickr-publicphotos-url-wrap">
											<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put the URL of the flickr User', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Flickr User Url', ESG_TEXTDOMAIN); ?></label><!--
											--><input type="text" class="esg-w-335" value="<?php echo $base->getVar($grid, array('postparams', 'flickr-user-url')); ?>" name="flickr-user-url">
										</div>
										<div id="eg-external-source-flickr-photosets-wrap">
											<div class="div13"></div>
											<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the photoset you want to pull the data from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select Photoset', ESG_TEXTDOMAIN); ?></label><input type="hidden" name="flickr-photoset" value="<?php echo $base->getVar($grid, array('postparams', 'flickr-photoset'), ''); ?>"><!--
											--><select class="esg-w-335" name="flickr-photoset-select">
											</select>
										</div>
										<div id="eg-external-source-flickr-gallery-url-wrap">
											<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put the URL of the flickr Gallery', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Flickr Gallery Url', ESG_TEXTDOMAIN); ?></label><!--
											--><input type="text" class="esg-w-335" value="<?php echo $base->getVar($grid, array('postparams', 'flickr-gallery-url')); ?>" name="flickr-gallery-url">
										</div>
										<div id="eg-external-source-flickr-group-url-wrap">
											<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put the URL of the flickr Group', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Flickr Group Url', ESG_TEXTDOMAIN); ?></label><!--
											--><input type="text" class="esg-w-335" value="<?php echo $base->getVar($grid, array('postparams', 'flickr-group-url')); ?>" name="flickr-group-url">
										</div>
									</div>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Image Sizes', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the Grid Items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Grid Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="flickr-thumb-size">
										<option value='Square' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Square');?>><?php esc_html_e('Square (75px)', ESG_TEXTDOMAIN);?></option>
										<option value='Large Square' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Large Square');?>><?php esc_html_e('Large Square (150px)', ESG_TEXTDOMAIN);?></option>
										<option value='Thumbnail' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Thumbnail');?>><?php esc_html_e('Thumbnail (100px)', ESG_TEXTDOMAIN);?></option>
										<option value='Small' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Small');?>><?php esc_html_e('Small (240px)', ESG_TEXTDOMAIN);?></option>
										<option value='Small 320' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Small 320');?>><?php esc_html_e('Small (320px)', ESG_TEXTDOMAIN);?></option>
										<option value='Medium' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Medium');?>><?php esc_html_e('Medium (500px)', ESG_TEXTDOMAIN);?></option>
										<option value='Medium 640' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Medium 640');?>><?php esc_html_e('Medium (640px)', ESG_TEXTDOMAIN);?></option>
										<option value='Medium 800' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Medium 800');?>><?php esc_html_e('Medium (800px)', ESG_TEXTDOMAIN);?></option>
										<option value='Large' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Large');?>><?php esc_html_e('Large (1024px)', ESG_TEXTDOMAIN);?></option>
										<option value='Original' <?php selected( $base->getVar($grid, array('postparams', 'flickr-thumb-size'), 'Small 320'), 'Original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
									</select>
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the lightbox, links, etc.', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Full Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="flickr-full-size">
										<option value='Square' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Square');?>><?php esc_html_e('Square (75px)', ESG_TEXTDOMAIN);?></option>
										<option value='Large Square' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Large Square');?>><?php esc_html_e('Large Square (150px)', ESG_TEXTDOMAIN);?></option>
										<option value='Thumbnail' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Thumbnail');?>><?php esc_html_e('Thumbnail (100px)', ESG_TEXTDOMAIN);?></option>
										<option value='Small' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Small');?>><?php esc_html_e('Small (240px)', ESG_TEXTDOMAIN);?></option>
										<option value='Small 320' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Small 320');?>><?php esc_html_e('Small (320px)', ESG_TEXTDOMAIN);?></option>
										<option value='Medium' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Medium');?>><?php esc_html_e('Medium (500px)', ESG_TEXTDOMAIN);?></option>
										<option value='Medium 640' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Medium 640');?>><?php esc_html_e('Medium (640px)', ESG_TEXTDOMAIN);?></option>
										<option value='Medium 800' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Medium 800');?>><?php esc_html_e('Medium (800px)', ESG_TEXTDOMAIN);?></option>
										<option value='Large' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Large');?>><?php esc_html_e('Large (1024px)', ESG_TEXTDOMAIN);?></option>
										<option value='Original' <?php selected( $base->getVar($grid, array('postparams', 'flickr-full-size'), 'Medium 800'), 'Original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
									</select>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Details', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Stream this number of photos', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Count', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'flickr-count'), '12'); ?>" name="flickr-count">
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Keep stream result cached (recommended)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream Cache (sec)', ESG_TEXTDOMAIN); ?></label><!--
									--><div class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'flickr-transient-sec'), '86400'); ?>" name="flickr-transient-sec"><div class="space18"></div><a id="clear_cache_flickr"  class="esg-btn esg-purple eg-clear-cache" href="javascript:void(0);" data-clear="flickr-transient-sec">Clear Cache</a><div class="space18"></div><!--
										--><span  class="importantlabel showonsmallcache description"><?php esc_html_e('Small cache intervals may influence the loading times negatively.', ESG_TEXTDOMAIN); ?></span>
									</div>
								</div>
							</div>

						</div><!-- End Flickr Stream -->

						<div id="facebook-external-stream-wrap">
							<div class="">
								<div class="eg-cs-tbc-left">
									<esg-llabel><span><?php esc_html_e('API', ESG_TEXTDOMAIN); ?></span></esg-llabel>
								</div>
								<div class="eg-cs-tbc stream-api-settings">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Choose Facebook Token Source', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Token Source', ESG_TEXTDOMAIN); ?></label><!--
									--><select class="eg-select-with-subcontrols" data-container=".facebook-token-source" name="facebook-token-source">
										<option value='account' <?php selected( $base->getVar($grid, array('postparams', 'facebook-token-source'), 'account'), 'account');?>><?php esc_html_e('From Account', ESG_TEXTDOMAIN);?></option>
										<option value='manual' <?php selected( $base->getVar($grid, array('postparams', 'facebook-token-source'), 'account'), 'manual');?>><?php esc_html_e('Manual', ESG_TEXTDOMAIN);?></option>
									</select>
									<div class="div13"></div>

									<div class="facebook-token-source facebook-token-source-account esg-display-none">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Connected Facebook Account', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Connected To', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'facebook-connected-to'), ''); ?>" name="facebook-connected-to" placeholder="<?php esc_attr_e('Not yet Connected', ESG_TEXTDOMAIN);?>" disabled >
										<div class="div13"></div>

										<a id="facebook_connect_account" class="esg-btn esg-btn-save-goto esg-purple eg-facebook-connect-account" href="<?php echo Essential_Grid_Facebook::get_login_url(); ?>">Connect Facebook Account</a><div class="space18"></div><!--
										--><span class="description"><?php esc_html_e('You will be redirected to Facebook and then back to the grid settings page. Your current settings will be auto saved.', ESG_TEXTDOMAIN);?></span>
									</div>

									<div class="facebook-token-source facebook-token-source-manual esg-display-none">
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in the Access Token', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Access Token', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'facebook-access-token'), ''); ?>" name="facebook-access-token"><div class="space18"></div><!--
										--><span class="description"><?php esc_html_e('Please <a target="_blank" href="https://www.themepunch.com/faq/essential-grid-facebook-stream/">generate</a> your Access Facebook Token and get Page ID.', ESG_TEXTDOMAIN); ?></span>
										<div class="div13"></div>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in Facebook Page ID', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Page ID', ESG_TEXTDOMAIN); ?></label><!--
										--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'facebook-page-id'), ''); ?>" name="facebook-page-id"><div class="space18"></div>
									</div>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Display a pages photo album or timeline', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Source', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="radio" name="facebook-type-source" value="album" class="" <?php checked($base->getVar($grid, array('postparams', 'facebook-type-source'), 'timeline'), 'album'); ?>><span class="inplabel"><?php esc_html_e('Album', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="facebook-type-source" value="timeline" <?php checked($base->getVar($grid, array('postparams', 'facebook-type-source'), 'timeline'), 'timeline'); ?> > <span class="inplabel"><?php esc_html_e('Timeline', ESG_TEXTDOMAIN); ?>	</span>
									<div id="eg-external-source-facebook-album-wrap">
										<div class="div13"></div>
										<?php $facebook_album = $base->getVar($grid, array('postparams', 'facebook-album'), '');?>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the album you want to pull the data from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select Album', ESG_TEXTDOMAIN); ?></label><input type="hidden" name="facebook-album" value="<?php echo $facebook_album; ?>"><!--
										--><select name="facebook-album-select"></select>
									</div>
								</div>
							</div>


							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Details', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Stream this number of posts', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Count (100 max)', ESG_TEXTDOMAIN); ?></label>
									<input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'facebook-count'), '12'); ?>" name="facebook-count">
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Keep stream result cached (recommended)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream Cache (sec)', ESG_TEXTDOMAIN); ?></label><!--
									--><div class="cachenumbercheck">
										<input type="number"  value="<?php echo $base->getVar($grid, array('postparams', 'facebook-transient-sec'), '86400'); ?>" name="facebook-transient-sec"><div class="space18"></div><a id="clear_cache_facebook"  class="esg-btn esg-purple eg-clear-cache" href="javascript:void(0);" data-clear="facebook-transient-sec">Clear Cache</a><div class="space18"></div><!--
										--><span  class="importantlabel showonsmallcache description"><?php esc_html_e('Small cache intervals may influence the loading times negatively.', ESG_TEXTDOMAIN); ?></span>
									</div>
								</div>
							</div>

						</div><!-- End Facebook Stream -->

						<div id="twitter-external-stream-wrap">
							<div class="eg-cs-tbc-left">
								<esg-llabel><span><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span></esg-llabel>
							</div>
							<div class="eg-cs-tbc">
								<label class="eg-new-label eg-tooltip-wrap"
									   title="<?php esc_attr_e('Put in the Twitter Account to stream from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Twitter Account Name @', ESG_TEXTDOMAIN); ?></label><!--
							--><input type="text"
									  value="<?php echo $base->getVar($grid, array('postparams', 'twitter-user-id'), ''); ?>"
									  name="twitter-user-id">
								<div class="div13"></div>
								<label class="eg-new-label eg-tooltip-wrap"
									   title="<?php esc_attr_e('Include or Exclude tweets with no tweetpic inside', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Text Tweets', ESG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" class="" name="twitter-image-only"
									  value="false" <?php checked($base->getVar($grid, array('postparams', 'twitter-image-only'), 'true'), 'false'); ?>><span
										class="inplabel eg-tooltip-wrap"
										title="<?php esc_attr_e('Include text only tweets in stream', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Include', ESG_TEXTDOMAIN); ?></span>
								<div class="space18"></div><!--
							--><input type="radio" name="twitter-image-only"
									  value="true" <?php checked($base->getVar($grid, array('postparams', 'twitter-image-only'), 'true'), 'true'); ?>>
								<span class='inplabel eg-tooltip-wrap'
									  title="<?php esc_attr_e('Exclude text only tweets from stream', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Exclude', ESG_TEXTDOMAIN); ?></span>
								<div class="div13"></div>
								<label class="eg-new-label eg-tooltip-wrap"
									   title="<?php esc_attr_e('Exclude or Include retweets in stream?', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Retweets', ESG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="twitter-include-retweets" value="on"
									  class="" <?php checked($base->getVar($grid, array('postparams', 'twitter-include-retweets'), 'on'), 'on'); ?>><span
										class="inplabel eg-tooltip-wrap"
										title="<?php esc_attr_e('Include retweets in stream', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Include', ESG_TEXTDOMAIN); ?></span>
								<div class="space18"></div><!--
							--><input type="radio" name="twitter-include-retweets"
									  value="off" <?php checked($base->getVar($grid, array('postparams', 'twitter-include-retweets'), 'on'), 'off'); ?>>
								<span class="inplabel eg-tooltip-wrap"
									  title="<?php esc_attr_e('Exclude retweets from stream', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Exclude', ESG_TEXTDOMAIN); ?></span>
								<div class="div13"></div>
								<label class="eg-new-label eg-tooltip-wrap"
									   title="<?php esc_attr_e('Exclude or Include replies in stream?', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Replies', ESG_TEXTDOMAIN); ?></label><!--
							--><input type="radio" name="twitter-exclude-replies" value="off"
									  class="" <?php checked($base->getVar($grid, array('postparams', 'twitter-exclude-replies'), 'on'), 'off'); ?>><span
										class="inplabel eg-tooltip-wrap"
										title="<?php esc_attr_e('Include replies in stream', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Include', ESG_TEXTDOMAIN); ?></span>
								<div class="space18"></div><!--
							--><input type="radio" name="twitter-exclude-replies"
									  value="on" <?php checked($base->getVar($grid, array('postparams', 'twitter-exclude-replies'), 'on'), 'on'); ?>>
								<span class="inplabel eg-tooltip-wrap"
									  title="<?php esc_attr_e('Exclude replies from stream', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Exclude', ESG_TEXTDOMAIN); ?></span>
							</div>
							<div class="eg-cs-tbc-left">
								<esg-llabel><span><?php esc_html_e('Details', ESG_TEXTDOMAIN); ?></span></esg-llabel>
							</div>
							<div class="eg-cs-tbc">
								<label class="eg-new-label eg-tooltip-wrap"
									   title="<?php esc_attr_e('Stream this number of posts', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Count', ESG_TEXTDOMAIN); ?></label><!--
							--><input type="number"
									  value="<?php echo $base->getVar($grid, array('postparams', 'twitter-count'), '12'); ?>"
									  name="twitter-count">
								<div class="div13"></div>
								<label class="eg-new-label eg-tooltip-wrap"
									   title="<?php esc_attr_e('Keep stream result cached (recommended)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream Cache (sec)', ESG_TEXTDOMAIN); ?></label><!--
							-->
								<div class="cachenumbercheck">
									<input type="number"
										   value="<?php echo $base->getVar($grid, array('postparams', 'twitter-transient-sec'), '86400'); ?>"
										   name="twitter-transient-sec">
									<div class="space18"></div>
									<a id="clear_cache_twitter" class="esg-btn esg-purple eg-clear-cache" href="javascript:void(0);"
									   data-clear="twitter-transient-sec">Clear Cache</a>
									<div class="space18"></div><!--
							  --><span class="importantlabel showonsmallcache description"><?php esc_html_e('Small cache intervals may influence the loading times negatively.', ESG_TEXTDOMAIN); ?></span>
								</div>
							</div>
						</div><!-- End Twitter Stream -->

						<div id="behance-external-stream-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('API', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in the Behance API key', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('API Key', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'behance-api'), ''); ?>" name="behance-api" id="behance-api"><div class="space18"></div><!--
									--><span class="description"><?php esc_html_e('The public Behance API is not accepting new clients.

If you are a current API user you will still be able to fetch the data though.', ESG_TEXTDOMAIN); ?></span>
								</div>
							</div>

							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Stream', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">

									<label  class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in the ID of the Behance channel', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Behance User ID', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="text"  value="<?php echo $base->getVar($grid, array('postparams', 'behance-user-id'), ''); ?>" name="behance-user-id" id="behance-user-id"><div class="space18"></div><!--
									--><span class="description"><?php esc_html_e('Find the Behance User ID in the URL of her/his projects page.', ESG_TEXTDOMAIN); ?></span>
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Source of Behance Images', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Show', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="radio" name="behance-type" value="projects" class="" <?php checked($base->getVar($grid, array('postparams', 'behance-type'), 'projects'), 'projects'); ?>><span class="inplabel"><?php esc_html_e('Projects Overview', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="behance-type" value="project" <?php checked($base->getVar($grid, array('postparams', 'behance-type'), 'overview'), 'project'); ?>><span class="inplabel"><?php esc_html_e('Single Project', ESG_TEXTDOMAIN); ?></span>
									<div id="eg-external-source-behance-project-wrap">
										<div class="div13"></div>
										<?php $behance_project = $base->getVar($grid, array('postparams', 'behance-project'), '');?>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the project you want to pull the data from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select project', ESG_TEXTDOMAIN); ?></label><input type="hidden" name="behance-project" value="<?php echo $behance_project; ?>"><!--										--><select name="behance-project-select" id="behance-project-select"></select>

									</div>
								</div>
							</div>


							<div id="eg-external-source-behance-projects-images-wrap" class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Image Sizes', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the Grid Items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Grid Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="behance-projects-thumb-size">
										<option value='115' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-thumb-size'), '202'), '115');?>><?php esc_html_e('115px wide', ESG_TEXTDOMAIN);?></option>
										<option value='202' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-thumb-size'), '202'), '202');?>><?php esc_html_e('202px wide', ESG_TEXTDOMAIN);?></option>
										<option value='230' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-thumb-size'), '202'), '230');?>><?php esc_html_e('230px wide', ESG_TEXTDOMAIN);?></option>
										<option value='404' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-thumb-size'), '202'), '404');?>><?php esc_html_e('404px wide', ESG_TEXTDOMAIN);?></option>
										<option value='original' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-thumb-size'), '202'), 'original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
									</select>
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the lightbox, links, etc.', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Full Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="behance-projects-full-size">
										<option value='115' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-full-size'), '202'), '115');?>><?php esc_html_e('115px wide', ESG_TEXTDOMAIN);?></option>
										<option value='202' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-full-size'), '202'), '202');?>><?php esc_html_e('202px wide', ESG_TEXTDOMAIN);?></option>
										<option value='230' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-full-size'), '202'), '230');?>><?php esc_html_e('230px wide', ESG_TEXTDOMAIN);?></option>
										<option value='404' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-full-size'), '202'), '404');?>><?php esc_html_e('404px wide', ESG_TEXTDOMAIN);?></option>
										<option value='original' <?php selected( $base->getVar($grid, array('postparams', 'behance-projects-full-size'), '202'), 'original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
									</select>
								</div>
							</div>
							<div id="eg-external-source-behance-project-images-wrap" class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Image Sizes', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the Grid Items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Grid Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="behance-project-thumb-size">
										<option value='disp' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-thumb-size'), 'max_1240'), 'disp');?>><?php esc_html_e('Disp', ESG_TEXTDOMAIN);?></option>
										<option value='max_1200' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-thumb-size'), 'max_1240'), 'max_1200');?>><?php esc_html_e('Max. 1200px', ESG_TEXTDOMAIN);?></option>
										<option value='max_1240' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-thumb-size'), 'max_1240'), 'max_1240');?>><?php esc_html_e('Max. 1240px', ESG_TEXTDOMAIN);?></option>
										<option value='original' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-thumb-size'), 'max_1240'), 'original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
									</select>
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the lightbox, links, etc.', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Full Image Size', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="behance-project-full-size">
										<option value='disp' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-full-size'), 'max_1240'), 'disp');?>><?php esc_html_e('Disp', ESG_TEXTDOMAIN);?></option>
										<option value='max_1200' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-full-size'), 'max_1240'), 'max_1200');?>><?php esc_html_e('Max. 1200px', ESG_TEXTDOMAIN);?></option>
										<option value='max1240' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-full-size'), 'max_1240'), 'max_1240');?>><?php esc_html_e('Max. 1240px', ESG_TEXTDOMAIN);?></option>
										<option value='original' <?php selected( $base->getVar($grid, array('postparams', 'behance-project-full-size'), 'max_1240'), 'original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
									</select>
								</div>
							</div>


							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Details', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Stream this number of posts', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Count', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'behance-count'), '12'); ?>" name="behance-count">
									<div class="div13"></div>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Keep stream result cached (recommended)', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Stream Cache (sec)', ESG_TEXTDOMAIN); ?></label><!--
									--><div class="cachenumbercheck">
										<input type="number" value="<?php echo $base->getVar($grid, array('postparams', 'behance-transient-sec'), '86400'); ?>" name="behance-transient-sec"><div class="space18"></div><a  id="clear_cache_behance"  class="esg-btn esg-purple eg-clear-cache" href="javascript:void(0);" data-clear="behance-transient-sec">Clear Cache</a><div class="space18"></div><!--
										--><span  class="importantlabel showonsmallcache description"><?php esc_html_e('Small cache intervals may influence the loading times negatively.', ESG_TEXTDOMAIN); ?></span>
									</div>
								</div>
							</div>

						</div> <!-- End behance Stream -->

						<div id="dribbble-external-stream-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('API', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Put in the dribbble API key', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('API Key', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="text" value="<?php echo $base->getVar($grid, array('postparams', 'dribbble-api'), ''); ?>" name="dribbble-api" id="dribbble-api"><div class="space18"></div><!--
									--><span class="description"><?php _e('Find information about the dribbble API key <a target="_blank" href="https://developers.google.com/dribbble/v3/getting-started#before-you-start">here</a>', ESG_TEXTDOMAIN); ?></span>
								</div>
							</div>

						</div>

					</div>
					<?php
				if(array_key_exists('nggdb', $GLOBALS) ){
					$nextgen = new Essential_Grid_Nextgen(); ?>
					<div id="all-nextgen-wrap">
						<div id="nextgen-source-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('NextGen', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<label for="shortcode" class="eg-tooltip-wrap" title="<?php esc_attr_e('Choose source of grid items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Source', ESG_TEXTDOMAIN); ?></label><!--
									--><input type="radio" name="nextgen-source-type" value="gallery" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'nextgen-source-type'), 'gallery'), 'gallery'); ?>><span class="inplabel"><?php esc_html_e('Gallery', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="nextgen-source-type" value="album" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'nextgen-source-type'), 'gallery'), 'album'); ?>><span class="inplabel"><?php esc_html_e('Album', ESG_TEXTDOMAIN); ?></span><div class="space18"></div><!--
									--><input type="radio" name="nextgen-source-type" value="tags" class="esg-source-choose-wrapper" <?php checked($base->getVar($grid, array('postparams', 'nextgen-source-type'), 'gallery'), 'tags'); ?>><span class="inplabel"><?php esc_html_e('Tags', ESG_TEXTDOMAIN); ?></span>
								</div>
							</div>
						</div>

						<div id="eg-nextgen-tags-wrap" class="nextgen-source">
							<div id="nextgen-source-wrap">
								<div class="">
									<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Tags', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
									<div class="eg-cs-tbc">
										<?php $nextgen_tags = $base->getVar($grid, array('postparams', 'nextgen-tags'), '');
											  $nextgen_tags_list = $nextgen->get_tag_list($nextgen_tags);
										?>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the tags you want to pull the data from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select Tags', ESG_TEXTDOMAIN); ?></label><!--
										--><select multiple name="nextgen-tags" id="nextgen-tags"><?php echo implode("", $nextgen_tags_list); ?></select>
									</div>
								</div>
							</div>
						</div>
						<div id="eg-nextgen-gallery-wrap" class="nextgen-source">
							<div id="nextgen-source-wrap">
								<div class="">
									<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Gallery', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
									<div class="eg-cs-tbc">
										<?php $nextgen_gallery = $base->getVar($grid, array('postparams', 'nextgen-gallery'), '');
											  $nextgen_galleries = $nextgen->get_gallery_list($nextgen_gallery);
										?>
										<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the gallery you want to pull the data from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select Gallery', ESG_TEXTDOMAIN); ?></label><!--
										--><select name="nextgen-gallery" id="nextgen-gallery"><?php echo implode("", $nextgen_galleries); ?></select>
									</div>
								</div>

							</div>
						</div>

						<div id="eg-nextgen-album-wrap" class="nextgen-source">
							<div id="nextgen-source-wrap">
							<div class="">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Album', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc">
									<?php $nextgen_album = $base->getVar($grid, array('postparams', 'nextgen-album'), '');
										  $nextgen_albums = $nextgen->get_album_list($nextgen_album);
									?>
									<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('Select the album you want to pull the data from', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Select Album', ESG_TEXTDOMAIN); ?></label><!--
									--><select name="nextgen-album" id="nextgen-album"><?php echo implode("", $nextgen_albums); ?></select>
								</div>
							</div>
						</div>
					</div>

					<div class="">
						<div class="eg-cs-tbc-left">
							<esg-llabel><span><?php esc_html_e('Image Sizes', ESG_TEXTDOMAIN); ?></span></esg-llabel>
						</div>
						<div class="eg-cs-tbc">
							<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the Grid Items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Grid Image Size', ESG_TEXTDOMAIN); ?></label><!--
							--><select name="nextgen-thumb-size">
								<option value='thumb' <?php selected( $base->getVar($grid, array('postparams', 'nextgen-thumb-size'), 'thumb'), 'thumb');?>><?php esc_html_e('Thumb', ESG_TEXTDOMAIN);?></option>
								<option value='original' <?php selected( $base->getVar($grid, array('postparams', 'nextgen-thumb-size'), 'thumb'), 'original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
							</select>
							<div class="div13"></div>
							<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the lightbox, links, etc.', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Full Image Size', ESG_TEXTDOMAIN); ?></label><!--
							--><select name="nextgen-full-size">
								<option value='thumb' <?php selected( $base->getVar($grid, array('postparams', 'nextgen-full-size'), 'thumb'), 'thumb');?>><?php esc_html_e('Thumb', ESG_TEXTDOMAIN);?></option>
								<option value='original' <?php selected( $base->getVar($grid, array('postparams', 'nextgen-full-size'), 'thumb'), 'original');?>><?php esc_html_e('Original', ESG_TEXTDOMAIN);?></option>
							</select>
						</div>
					</div>
				</div>
			<?php }

			if( function_exists("wp_rml_dropdown") ){
				$selected_rml = $base->getVar($grid, array('postparams', 'rml-source-type'), '-1');
				$selected_rml = intval($selected_rml);
				$rml_items = wp_rml_dropdown($selected_rml,array(RML_TYPE_COLLECTION),true); 
			?>
				<div id="all-rml-wrap">
					<div id="rml-source-wrap">
						<div class="">
							<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Real Media Library', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
							<div class="eg-cs-tbc">
								<label for="shortcode" class="eg-tooltip-wrap" title="<?php esc_attr_e('Choose source of grid items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Source', ESG_TEXTDOMAIN); ?></label><!--
								--><select id="rml-source-type" name="rml-source-type"><?php echo $rml_items; ?></select><span class="inplabel"> <?php esc_html_e('Select Folder or Gallery', ESG_TEXTDOMAIN); ?></span>
							</div>
						</div>
					</div>

					<div class="">
						<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Image Sizes', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc">
							<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the Grid Items', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Grid Image Size', ESG_TEXTDOMAIN); ?></label><!--
							--><select name="rml-thumb-size"><?php echo Essential_Grid_Rml::option_list_image_sizes($base->getVar($grid, array('postparams', 'rml-thumb-size'), 'original')); ?></select>
							<div class="div13"></div>
							<label class="eg-new-label eg-tooltip-wrap" title="<?php esc_attr_e('For images that appear inside the lightbox, links, etc.', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Full Image Size', ESG_TEXTDOMAIN); ?></label><!--
							--><select name="rml-full-size"><?php echo Essential_Grid_Rml::option_list_image_sizes($base->getVar($grid, array('postparams', 'rml-full-size'), 'original')); ?></select>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php do_action('essgrid_grid_source_options',$base,$grid); ?>
					<div id="media-source-order-wrap">
						<div class="">
							<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Media Source', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
							<div class="eg-cs-tbc">
								<div class="esg-msow-inner">
									<div class="esg-msow-inner-container">
										<div class="eg-tooltip-wrap" title="<?php esc_attr_e('Set default order of used media', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Item Media Source Order', ESG_TEXTDOMAIN); ?></div>
										<div id="imso-list" class="eg-media-source-order-wrap eg-media-source-order-wrap-additional">
											<?php
											if(!empty($media_source_order)){
												foreach($media_source_order as $media_handle){
													if(!isset($media_source_list[$media_handle])) continue;
													?>
													<div id="imso-<?php echo $media_handle; ?>" class="eg-media-source-order esg-blue esg-btn"><i class="eg-icon-<?php echo $media_source_list[$media_handle]['type']; ?>"></i><span><?php echo $media_source_list[$media_handle]['name']; ?></span><input class="eg-get-val" type="checkbox" name="media-source-order[]" checked="checked" value="<?php echo $media_handle; ?>" /></div>
													<?php
													unset($media_source_list[$media_handle]);
												}
											}

											if(!empty($media_source_list)){
												foreach($media_source_list as $media_handle => $media_set){
													?>
													<div id="imso-<?php echo $media_handle; ?>" class="eg-media-source-order esg-purple esg-btn"><i class="eg-icon-<?php echo $media_set['type']; ?>"></i><span><?php echo $media_set['name']; ?></span><input class="eg-get-val" type="checkbox" name="media-source-order[]" value="<?php echo $media_handle; ?>" /></div>
													<?php
												}
											}
											?>
										</div>
									</div>
									<div id="poster-media-source-container" class="eg-poster-media-source-container">
										<div class="eg-tooltip-wrap" title="<?php esc_attr_e('Set the default order of Poster Image Source', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Optional Audio/Video Image Order', ESG_TEXTDOMAIN); ?></div>
										<div id="pso-list" class="eg-media-source-order-wrap eg-media-source-order-wrap-additional">
											<?php
											if(!empty($poster_source_order)){
												foreach($poster_source_order as $poster_handle){
													if(!isset($poster_source_list[$poster_handle])) continue;
													?>
													<div id="pso-<?php echo $poster_handle; ?>" class="eg-media-source-order esg-purple esg-btn"><i class="eg-icon-<?php echo $poster_source_list[$poster_handle]['type']; ?>"></i><span><?php echo $poster_source_list[$poster_handle]['name']; ?></span><input class="eg-get-val" type="checkbox" name="poster-source-order[]" checked="checked" value="<?php echo $poster_handle; ?>" /></div>
													<?php
													unset($poster_source_list[$poster_handle]);
												}
											}

											if(!empty($poster_source_list)){
												foreach($poster_source_list as $poster_handle => $poster_set){
													?>
													<div id="pso-<?php echo $poster_handle; ?>" class="eg-media-source-order esg-purple esg-btn"><i class="eg-icon-<?php echo $poster_set['type']; ?>"></i><span><?php echo $poster_set['name']; ?></span><input class="eg-get-val" type="checkbox" name="poster-source-order[]" value="<?php echo $poster_handle; ?>" /></div>
													<?php
												}
											}
											?>
										</div>
									</div>
									<div><?php esc_html_e('First Media Source will be loaded as default. In case one source does not exist, next available media source in this order will be used', ESG_TEXTDOMAIN); ?></div>
								</div>
							</div>
						</div>
					</div>

					<div id="media-source-sizes">
						<div class="">
							<div class="eg-cs-tbc-left">
								<esg-llabel><span><?php esc_html_e('Source Size', ESG_TEXTDOMAIN); ?></span></esg-llabel>
							</div>
							<div class="eg-cs-tbc eg-cs-tbc-padding-top">

								<div>
									<!-- DEFAULT IMAGE SOURCE -->
									<label class="eg-tooltip-wrap" title="<?php esc_attr_e('Desktop Grid Image Source Size', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Desktop Image Source Type', ESG_TEXTDOMAIN); ?></label><!--
									--><?php $image_source_type = $base->getVar($grid, array('postparams', 'image-source-type'), 'full');?><select name="image-source-type">
										<?php
										foreach($all_image_sizes as $handle => $name){
											?>
											<option <?php selected($image_source_type, $handle); ?> value="<?php echo $handle; ?>"><?php echo $name; ?></option>
											<?php
										}
										?>
									</select>
								</div>
								<div class="div13"></div>

								<!-- DEFAULT IMAGE SOURCE -->
								<label class="eg-tooltip-wrap" title="<?php esc_attr_e('Mobile Grid Image Source Size', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Mobile Image Source Type', ESG_TEXTDOMAIN); ?></label><!--
								--><?php $image_source_type = $base->getVar($grid, array('postparams', 'image-source-type-mobile'), $image_source_type);?><select name="image-source-type-mobile">
									<?php
									foreach($all_image_sizes as $handle => $name){
										?>
										<option <?php selected($image_source_type, $handle); ?> value="<?php echo $handle; ?>"><?php echo $name; ?></option>
										<?php
									}
									?>
								</select>
							</div>

						</div>


					</div>
					<?php $enable_media_filter = get_option('tp_eg_enable_media_filter', 'false');
					if ($enable_media_filter!="false"){ ?>
						<div id="media-source-filter">
							<div class="esg-container">
								<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Media Filter', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
								<div class="eg-cs-tbc eg-cs-tbc-padding-bottom">
									<div class="esg-msow-inner">
										<div class="esg-display-none">
											<?php
											$media_filter_type = $base->getVar($grid, array('postparams', 'media-filter-type'), 'none');
											?>
											<select id="media-filter-type" name="media-filter-type">
												<?php
												foreach($all_media_filters as $handle => $name){
													?>
													<option <?php selected($media_filter_type, $handle); ?> value="<?php echo $handle; ?>"><?php echo $name; ?></option>
													<?php
												}
												?>
											</select>
										</div>
										<div id="inst-filter-grid">
											<?php
												foreach($all_media_filters as $handle => $name){
													$selected = $media_filter_type === $handle ? "selected" : "";
													?>
													<div data-type="<?php echo $handle; ?>" class="inst-filter-griditem <?php echo $selected; ?>"><div class="ifgname"><?php echo $name; ?></div><div class="inst-filter-griditem-img <?php echo $handle; ?>"></div><div class="inst-filter-griditem-img-noeff"></div></div>
													<?php
												}
												?>
										</div>
									</div>
								</div>
							</div>

						</div>
					<?php } ?>
					<div id="media-source-default-templates">
						<div class="">
							<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Default Source', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
							<?php
							$default_img = $base->getVar($grid, array('postparams', 'default-image'), 0, 'i');
							$var_src = '';
							if($default_img > 0){
								$img = wp_get_attachment_image_src($default_img, 'full');
								if($img !== false){
									$var_src = $img[0];
								}
							}
							?>
							<div class="eg-cs-tbc">
								<label class="eg-tooltip-wrap" title="<?php esc_attr_e('Image will be used if no criteria are matching so a default image will be shown', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Default Image', ESG_TEXTDOMAIN); ?></label><!--
								--><div class="esg-btn esg-purple eg-default-image-add" data-setto="eg-default-image"><?php esc_html_e('Choose Image', ESG_TEXTDOMAIN); ?></div><!--
								--><div class="esg-btn  esg-red  eg-default-image-clear" data-setto="eg-default-image"><?php esc_html_e('Remove Image', ESG_TEXTDOMAIN); ?></div><!--
								--><input type="hidden" name="default-image" value="<?php echo !empty($default_img) ? $default_img : ""; ?>" id="eg-default-image" /><!--
								--><div class="eg-default-image-container"><img id="eg-default-image-img" class="image-holder-wrap-div<?php echo ($var_src == '') ? ' esg-display-none' : ''; ?>" src="<?php echo $var_src; ?>" /></div>
							</div>
						</div>
					</div>

					<div class=" default-posters notavailable" id="eg-youtube-default-poster">
						<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('YouTube Poster', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc">
							<?php
							$youtube_default_img = $base->getVar($grid, array('postparams', 'youtube-default-image'), 0, 'i');
							$var_src = '';
							if($youtube_default_img > 0){
								$youtube_img = wp_get_attachment_image_src($youtube_default_img, 'full');
								if($youtube_img !== false){
									$var_src = $youtube_img[0];
								}
							}
							?>
							<label class="eg-tooltip-wrap" title="<?php esc_attr_e('Set the default posters for the different video sources', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Default Poster', ESG_TEXTDOMAIN); ?></label><!--
							--><div class="esg-btn esg-purple eg-youtube-default-image-add" data-setto="eg-youtube-default-image"><?php esc_html_e('Choose Image', ESG_TEXTDOMAIN); ?></div><!--
							--><div class="esg-btn esg-red eg-youtube-default-image-clear" data-setto="eg-youtube-default-image"><?php esc_html_e('Remove Image', ESG_TEXTDOMAIN); ?></div>
							<input type="hidden" name="youtube-default-image" value="<?php echo !empty($youtube_default_img) ? $youtube_default_img : '' ; ?>" id="eg-youtube-default-image" /><!--
							--><div class="eg-default-image-container"><img id="eg-youtube-default-image-img" class="image-holder-wrap-div<?php echo ($var_src == '') ? ' esg-display-none' : ''; ?>" src="<?php echo $var_src; ?>" /></div>
						</div>
					</div>

					<div class=" default-posters notavailable" id="eg-vimeo-default-poster">
						<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('Vimeo Poster', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc">
							<?php
							$vimeo_default_img = $base->getVar($grid, array('postparams', 'vimeo-default-image'), 0, 'i');
							$var_src = '';
							if($vimeo_default_img > 0){
								$vimeo_img = wp_get_attachment_image_src($vimeo_default_img, 'full');
								if($vimeo_img !== false){
									$var_src = $vimeo_img[0];
								}
							}
							?>
							<label class="eg-tooltip-wrap" title="<?php esc_attr_e('Set the default posters for the different video sources', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Default Poster', ESG_TEXTDOMAIN); ?></label><!--
							--><div class="esg-btn esg-purple eg-vimeo-default-image-add"  data-setto="eg-vimeo-default-image"><?php esc_html_e('Choose Image', ESG_TEXTDOMAIN); ?></div><!--
							--><div class="esg-btn esg-red eg-vimeo-default-image-clear"  data-setto="eg-vimeo-default-image"><?php esc_html_e('Remove Image', ESG_TEXTDOMAIN); ?></div>
							<input type="hidden" name="vimeo-default-image" value="<?php echo !empty($vimeo_default_img) ? $vimeo_default_img : ''; ?>" id="eg-vimeo-default-image" /><!--
							--><div class="eg-default-image-container"><img id="eg-vimeo-default-image-img" class="image-holder-wrap-div<?php echo ($var_src == '') ? ' esg-display-none' : ''; ?>" src="<?php echo $var_src; ?>" /></div>
						</div>
					</div>

					<div class=" default-posters notavailable" id="eg-html5-default-poster">

						<div class="eg-cs-tbc-left"><esg-llabel><span><?php esc_html_e('HTML5 Poster', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
						<div class="eg-cs-tbc">
							<?php
							$html_default_img = $base->getVar($grid, array('postparams', 'html-default-image'), 0, 'i');
							$var_src = '';
							if($html_default_img > 0){
								$html_img = wp_get_attachment_image_src($html_default_img, 'full');
								if($html_img !== false){
									$var_src = $html_img[0];
								}
							}
							?>
							<label class="eg-tooltip-wrap" title="<?php esc_attr_e('Set the default posters for the different video sources', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Default Poster', ESG_TEXTDOMAIN); ?></label><!--
							--><div class="esg-btn esg-purple eg-html-default-image-add"  data-setto="eg-html-default-image"><?php esc_html_e('Choose Image', ESG_TEXTDOMAIN); ?></div><!--
							--><div class="esg-btn esg-red eg-html-default-image-clear"  data-setto="eg-html-default-image"><?php esc_html_e('Remove Image', ESG_TEXTDOMAIN); ?></div>
							<input type="hidden" name="html-default-image" value="<?php echo !empty($html_default_img) ? $html_default_img : ''; ?>" id="eg-html-default-image" /><!--
							--><div class="eg-default-image-container"><img id="eg-html-default-image-img" class="image-holder-wrap-div<?php echo ($var_src == '') ? ' esg-display-none' : ''; ?>" src="<?php echo $var_src; ?>" /></div>
						</div>
					</div>
					<div id="gallery-wrap"></div>
				</form>
			</div>
		</div>
		<?php
			require_once('elements/grid-settings.php');
		?>


		<div id="custom-element-add-elements-wrapper">
			<div class="">
				<div class="eg-cs-tbc-left">
					<esg-llabel><span><?php esc_html_e('Add Items', ESG_TEXTDOMAIN); ?></span></esg-llabel>
				</div>
				<div class="eg-cs-tbc">
					<label class="eg-tooltip-wrap" title="<?php esc_attr_e('Add element to Custom Grid', ESG_TEXTDOMAIN); ?>"><?php esc_html_e('Add', ESG_TEXTDOMAIN); ?></label><!--
					--><div class="esg-btn esg-purple esg-open-edit-dialog" id="esg-add-new-custom-youtube-top"><i class="eg-icon-youtube-squared"></i><?php esc_html_e('You Tube', ESG_TEXTDOMAIN); ?></div><!--
					--><div class="esg-btn esg-purple esg-open-edit-dialog" id="esg-add-new-custom-vimeo-top"><i class="eg-icon-vimeo-squared"></i><?php esc_html_e('Vimeo', ESG_TEXTDOMAIN); ?></div><!--
					--><div class="esg-btn esg-purple esg-open-edit-dialog" id="esg-add-new-custom-html5-top"><i class="eg-icon-video"></i><?php esc_html_e('Self Hosted Media', ESG_TEXTDOMAIN); ?></div><!--
					--><div class="esg-btn esg-purple esg-open-edit-dialog" id="esg-add-new-custom-image-top"><i class="eg-icon-picture-1"></i><?php esc_html_e('Image(s)', ESG_TEXTDOMAIN); ?></div><!--
					--><div class="esg-btn esg-purple esg-open-edit-dialog" id="esg-add-new-custom-soundcloud-top"><i class="eg-icon-soundcloud"></i><?php esc_html_e('Sound Cloud', ESG_TEXTDOMAIN); ?></div><!--
					--><div class="esg-btn esg-purple esg-open-edit-dialog" id="esg-add-new-custom-text-top"><i class="eg-icon-font"></i><?php esc_html_e('Simple Content', ESG_TEXTDOMAIN); ?></div><!--
					--><div class="esg-btn esg-purple esg-open-edit-dialog" id="esg-add-new-custom-blank-top"><i class="eg-icon-cancel"></i><?php esc_html_e('Blank Item', ESG_TEXTDOMAIN); ?></div>
				</div>
			</div>

		</div>

		<div class="save-wrap-settings">
			<div class="sws-toolbar-button"><a class="esg-btn esg-green" href="javascript:void(0);" id="eg-btn-save-grid"><i class="rs-icon-save-light"></i><?php echo $save; ?></a></div>
			<div class="sws-toolbar-button"><a class="esg-btn esg-purple esg-refresh-preview-button"><i class="eg-icon-arrows-ccw"></i><?php esc_html_e('Refresh Preview', ESG_TEXTDOMAIN); ?></a></div>
			<div class="sws-toolbar-button"><a class="esg-btn esg-blue" href="<?php echo self::getViewUrl(Essential_Grid_Admin::VIEW_OVERVIEW); ?>"><i class="eg-icon-cancel"></i><?php esc_html_e('Close', ESG_TEXTDOMAIN); ?></a></div>
			<div class="sws-toolbar-button"><?php if($grid !== false){ ?> <a class="esg-btn esg-red" href="javascript:void(0);" id="eg-btn-delete-grid"><i class="eg-icon-trash"></i><?php esc_html_e('Delete Grid', ESG_TEXTDOMAIN); ?></a><?php } ?></div>
		</div>
		<script>
			jQuery('document').ready(function() {
				punchgs.TweenLite.fromTo(jQuery('.save-wrap-settings'),1,{autoAlpha:0,x:50},{autoAlpha:1,x:0,ease:punchgs.Power3.easeInOut,delay:2});
				jQuery.each(jQuery('.sws-toolbar-button'),function(ind,elem) {
					punchgs.TweenLite.fromTo(elem,0.7,{x:50},{x:0,ease:punchgs.Power3.easeInOut,delay:2.2+(ind*0.15)});
				})

				jQuery('.sws-toolbar-button').on('mouseenter', function () {
					punchgs.TweenLite.to(jQuery(this),0.3,{x:-150,ease:punchgs.Power3.easeInOut});
				});
				jQuery('.sws-toolbar-button').on('mouseleave', function () {
					punchgs.TweenLite.to(jQuery(this),0.3,{x:0,ease:punchgs.Power3.easeInOut});
				});
			});
		</script>
	</div>
</div>

<div class="clear"></div>

<?php
if(intval($isCreate) == 0){ 
	//currently editing
	echo '<div id="eg-create-step-3">';
}
?>

<div class="esg-editor-space"></div>
<h2><?php esc_html_e('Editor / Preview', ESG_TEXTDOMAIN); ?></h2>
<form id="eg-custom-elements-form-wrap">
	<div id="eg-live-preview-wrap">
		<?php
		Essential_Grid_Global_Css::output_global_css_styles_wrapped();
		?>
		<div id="esg-preview-wrapping-wrapper">
			<?php
			if($base->getVar($grid, array('postparams', 'source-type'), 'post') == 'custom'){
				$layers = @$grid['layers']; //no stripslashes used here

				if(!empty($layers)){
					foreach($layers as $layer){
						?>
						<input class="eg-remove-on-reload" type="hidden" name="layers[]" value="<?php echo htmlentities($layer); ?>" />
						<?php
					}
				}
			}
			?>
		</div>
	</div>
</form>
<?php
if(intval($isCreate) == 0){ 
	//currently editing
	echo '</div>';
}

Essential_Grid_Dialogs::post_meta_dialog(); //to change post meta informations
Essential_Grid_Dialogs::edit_custom_element_dialog(); //to change post meta informations
Essential_Grid_Dialogs::custom_element_image_dialog(); //to change post meta informations

?>
<script type="text/javascript">
	try{
		jQuery('.mce-notification-error').remove();
		jQuery('#wpbody-content >.notice').remove();
	} catch(e) {

	}

	window.ESG = window.ESG === undefined ? {F:{}, C:{}, ENV:{}, LIB:{}, V:{}, S:{}, DOC:jQuery(document), WIN:jQuery(window)} : window.ESG;
	ESG.LIB.COLOR_PRESETS	= <?php echo (!empty($esg_color_picker_presets)) ? 'JSON.parse('. $base->jsonEncodeForClientSide($esg_color_picker_presets) .')' : '{}'; ?>;

	// EARLY ACCESS TO SELECTED SOURE TYPE
	ESG.C.sourceType = jQuery('input[name="source-type"]');
	ESG.S.STYPE = jQuery('input[name="source-type"]:checked').val();

	var eg_jsonTaxWithCats = <?php echo $jsonTaxWithCats; ?>;
	var pages = [
		<?php
		if(!empty($pages)){
			$first = true;
			foreach($pages as $page){
				echo (!$first) ? ",\n" : "\n";
				echo '{ value: '.$page->ID.', label: "'.str_replace('"', '', $page->post_title).' (ID: '.$page->ID.')" }';
				$first = false;
			}
		}
		?>
	];

	function esg_grid_create_ready_function() {
		AdminEssentials.setInitMetaKeysJson(<?php echo $base->jsonEncodeForClientSide($meta_keys); ?>);
		AdminEssentials.initCreateGrid(<?php echo ($grid !== false) ? '"update_grid"' : ''; ?>);
		AdminEssentials.set_default_nav_skin(<?php echo $navigation_skin_css; ?>);
		AdminEssentials.get_default_nav_originals(<?php echo $base->jsonEncodeForClientSide($esg_default_skins); ?>);
		AdminEssentials.initSlider();
		AdminEssentials.initAutocomplete();
		AdminEssentials.initTabSizes();
		AdminEssentials.set_navigation_layout();
		AdminEssentials.checkDepricatedSkins();
		setTimeout(function() {
			AdminEssentials.createPreviewGrid();
		},500);

		AdminEssentials.initSpinnerAdmin();
		AdminEssentials.setInitCustomJson(<?php echo $base->jsonEncodeForClientSide($custom_elements); ?>);
	}
	var esg_grid_create_ready_function_once = false
	if (document.readyState === "loading") 
		document.addEventListener('readystatechange',function(){
			if ((document.readyState === "interactive" || document.readyState === "complete") && !esg_grid_create_ready_function_once) {
				esg_grid_create_ready_function_once = true;
				esg_grid_create_ready_function();
			}
		});
	else {
		esg_grid_create_ready_function_once = true;
		esg_grid_create_ready_function();
	}
	
</script>

<?php

echo '<div id="navigation-styling-css-wrapper">'."\n";
$skins = Essential_Grid_Navigation::output_navigation_skins();
echo $skins;
echo '</div>';

?>

<div id="esg-template-wrapper" class="esg-display-none">

</div>
