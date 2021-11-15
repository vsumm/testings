<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

?>
<div id="esg-libary-wrapper">
	<div id="eg_library_header_part">
		<h2 class="topheader"><?php esc_html_e('Template Library', ESG_TEXTDOMAIN); ?></h2>

		<div id="esg-close-template"></div>

		<div class="esg-library-switcher">
			<div id="esg-library-filter-buttons-wrapper" class="esg-display-inline-block">
				<span class="esg-btn esg_library_filter_button selected" data-type="temp_all"><?php esc_html_e('All Grids', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_even"><?php esc_html_e('Even', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_masonry"><?php esc_html_e('Masonry', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_fullscreen"><?php esc_html_e('Full Screen', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_fullwidth"><?php esc_html_e('Full Width', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_loadmore"><?php esc_html_e('Load More', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_clients"><?php esc_html_e('Clients', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_pricetables"><?php esc_html_e('Price Tables', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_variablecolumns"><?php esc_html_e('Variable Columns', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_woocommerce"><?php esc_html_e('Woo Commerce', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_filterdropdown"><?php esc_html_e('Filter Dropdown', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg_library_filter_button" data-type="temp_streams"><?php esc_html_e('Streams', ESG_TEXTDOMAIN); ?></span>
				<span class="esg-btn esg-purple esg_library_filter_button esg_libr_new_udpated" data-type="temp_newupdate"><?php esc_html_e('New / Updated', ESG_TEXTDOMAIN); ?></span>
			</div>

			<div class="esg-btn esg-red esg-reload-shop esg-display-inline-block-i esg-f-right"><i class="eg-icon-arrows-ccw"></i><?php esc_html_e('Update Library', ESG_TEXTDOMAIN); ?></div>

		</div>
	</div>

	<!-- THE GRID BASE TEMPLATES -->
	<div id="esg-library-grids" class="esg-library-groups">
		<!-- TEMPLATES WILL BE ADDED OVER AJAX -->
	</div>
</div>


<div id="dialog_import_library_grid_from" title="<?php esc_html_e('Import Library Grid', ESG_TEXTDOMAIN); ?>" class="dialog_import_library_grid_from esg-display-none">
	<form action="<?php //echo RevSliderBase::$url_ajax; ?>" enctype="multipart/form-data" method="post" name="esg-import-template-from-server" id="esg-import-template-from-server">
		<input type="hidden" name="action" value="revslider_ajax_action">
		<input type="hidden" name="client_action" value="import_slider_online_template_slidersview">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("Essential_Grid_actions"); ?>">
		<input type="hidden" name="uid" class="esg-uid" value="">
		<input type="hidden" name="page-creation" class="esg-page-creation" value="false">
	</form>
</div>

<div id="dialog_import_library_grid_info" title="<?php esc_html_e('Importing Status', ESG_TEXTDOMAIN); ?>" class="dialog_import_library_grid_info esg-display-none">
	<!-- ADD INFOS HERE ON DEMAND -->
	<div class="esg_logo_rotating">
		<div class="import-spinner">
			<div>
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<div id="install-grid-counter-wrapper"><span id="install-grid-counter"></span></div>
	<div id="nowinstalling_label"><?php esc_html_e('Now Installing', ESG_TEXTDOMAIN); ?></div>
	<div id="import_dialog_box_action"></div>
	<div id="import_dialog_box"></div>
</div>

<div id="esg-premium-benefits-dialog" class="esg-display-none">
	<div class="esg-premium-benefits-dialogtitles" id="esg-wrong-purchase-code-title">
		<span class="oppps-icon"></span>
		<span class="benefits-title-right">
			<span class="esg-premium-benefits-dialogtitle"><?php esc_html_e('Ooops... Wrong Purchase Code!', ESG_TEXTDOMAIN); ?></span>
			<span class="esg-premium-benefits-dialogsubtitle"><?php _e('Maybe just a typo? (Click <a target="_blank" href="https://revolution.themepunch.com/direct-customer-benefits/#productactivation">here</a> to find out how to locate your Essential Grid purchase code.)', ESG_TEXTDOMAIN); ?></span>
		</span>
	</div>
	<div class="esg-premium-benefits-dialogtitles esg-display-none" id="esg-plugin-update-feedback-title">
		<span class="oppps-icon-red"></span>
		<span class="benefits-title-right">
			<span class="esg-premium-benefits-dialogtitle"><?php esc_html_e('Plugin Activation Required'); ?></span>
			<span class="esg-premium-benefits-dialogsubtitle"><?php _e('In order to download the <a target="_blank" href="https://account.essential-grid.com/licenses/pricing/">latest update</a> instantly', ESG_TEXTDOMAIN); ?></span>
		</span>
	</div>
	<div class="esg-premium-benefits-dialogtitles esg-display-none" id="esg-plugin-download-template-feedback-title">
		<span class="oppps-icon"></span>
		<span class="benefits-title-right">
			<span class="esg-premium-benefits-dialogtitle"><?php esc_html_e('Plugin Activation Required'); ?></span>
			<span class="esg-premium-benefits-dialogsubtitle"><?php _e('In order to gain instant access to the entire <a target="_blank" href="https://www.essential-grid.com">Grid Library</a>', ESG_TEXTDOMAIN); ?></span>
		</span>
	</div>

	<div id="basic_premium_benefits_block">
		<div class="esg-premium-benefits-block rspb-withborder">
			<h3><i class="big_present"></i><?php esc_html_e('If you purchased a theme that bundled Essential Grid', ESG_TEXTDOMAIN); ?></h3>
			<ul>
				<li><?php esc_html_e('No activation needed to use / create grids with Essential Grid', ESG_TEXTDOMAIN); ?></li>
				<li><?php esc_html_e('Update manually through your theme', ESG_TEXTDOMAIN); ?></li>
				<li><?php _e('Access our <a target="_blank" class="rspb_darklink" href="https://www.themepunch.com/support-center/#support">FAQ database</a> and <a target="_blank" class="rspb_darklink" href="https://www.youtube.com/playlist?list=PLSCdqDWVMJPNjFD1dYYw7GiclPyCfY-z7">video tutorials</a> for help', ESG_TEXTDOMAIN); ?></li>
			</ul>
		</div>
		<div class="esg-premium-benefits-block">
			<h3><i class="big_diamond"></i><?php esc_html_e('Activate Essential Grid for', ESG_TEXTDOMAIN); ?> <span class="instant_access"></span> <?php esc_html_e('to ...', ESG_TEXTDOMAIN); ?></h3>
			<ul>
				<li><?php _e('<a target="_blank" href="https://www.themepunch.com/faq/how-to-update-essential-grid/">Update</a> to the latest version directly from your dashboard', ESG_TEXTDOMAIN); ?></li>
				<li><?php _e('<a target="_blank" href="https://themepunch.support/">Support</a> ThemePunch ticket desk', ESG_TEXTDOMAIN); ?></li>
				<li><?php _e('<a target="_blank" href="https://www.essential-grid.com">Library</a> with tons of free premium grids', ESG_TEXTDOMAIN); ?></li>
			</ul>
		</div>
		<a target="_blank" class="get_purchase_code" href="https://account.essential-grid.com/licenses/pricing/"><?php esc_html_e('GET A PURCHASE CODE', ESG_TEXTDOMAIN); ?></a>
	</div>
</div>

<script type="text/javascript">
	var initGridLibraryRoutine_once = false
	if (document.readyState === "loading") 
		document.addEventListener('readystatechange',function(){
			if ((document.readyState === "interactive" || document.readyState === "complete") && !initGridLibraryRoutine_once) {
				initGridLibraryRoutine_once = true;
				AdminEssentials.initGridLibraryRoutine();
			}
		});
	else {
		initGridLibraryRoutine_once = true;
		AdminEssentials.initGridLibraryRoutine();
	}
</script>
