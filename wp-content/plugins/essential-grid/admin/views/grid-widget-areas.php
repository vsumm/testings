<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2021 ThemePunch
 * @since 1.0.6
 */
 
if( !defined( 'ABSPATH') ) exit();

?>
<h2 class="topheader"><?php esc_html_e('Custom Widgets', ESG_TEXTDOMAIN); ?></h2>

<div id="eg-grid-widget-areas-wrapper">
	<?php
	$wa = new Essential_Grid_Widget_Areas();
	$sidebars = $wa->get_all_sidebars();
	
	if(is_array($sidebars) && !empty($sidebars)){
		foreach($sidebars as $handle => $name){
			?>
			<div class="eg-pbox esg-box esg-box-grid-widget-area">
				<h3 class="box-closed"><span class="esg-font-w-400"><?php esc_html_e('Handle:', ESG_TEXTDOMAIN); ?></span><span>eg-<?php echo $handle; ?> </span><div class="eg-pbox-arrow"></div></h3>
				<div class="esg-box-inside">
					<input type="hidden" name="esg-widget-area-handle[]" value="<?php echo $handle; ?>" />
					<div class="eg-custommeta-row">
						<div class="eg-cus-row-l"><label><?php esc_html_e('Name:', ESG_TEXTDOMAIN); ?></label><input type="text" name="esg-widget-area-name[]" value="<?php echo @$name; ?>"></div>
					</div>
					
					<div class="eg-widget-area-save-wrap-settings">
						<a class="esg-btn esg-blue eg-widget-area-edit" href="javascript:void(0);"><?php esc_html_e('Edit', ESG_TEXTDOMAIN); ?></a>
						<a class="esg-btn  eg-widget-area-delete" href="javascript:void(0);"><?php esc_html_e('Remove', ESG_TEXTDOMAIN); ?></a>
					</div>
				</div>
			</div>
			<?php
		}
	}
	?>
</div>
<a class="esg-btn esg-blue" id="eg-widget-area-add" href="javascript:void(0);"><?php esc_html_e('Add New Widget Area', ESG_TEXTDOMAIN); ?></a>
<?php Essential_Grid_Dialogs::widget_areas_dialog(); ?>
<script type="text/javascript">
	jQuery(function(){
		AdminEssentials.initWidgetAreas();
	});
</script>
