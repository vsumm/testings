<?php
/**
 * @package   Essential_Grid
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/essential/
 * @copyright 2020 ThemePunch
 */

if( !defined( 'ABSPATH') ) exit();

$c_grids = new Essential_Grid();
$item_skin = new Essential_Grid_Item_Skin();
$item_ele = new Essential_Grid_Item_Element();
$nav_skin = new Essential_Grid_Navigation();
$metas = new Essential_Grid_Meta();
$fonts = new ThemePunch_Fonts();

$grids = $c_grids->get_essential_grids();
$skins = $item_skin->get_essential_item_skins();
$elements = $item_ele->get_essential_item_elements();
$navigation_skins = $nav_skin->get_essential_navigation_skins();
$custom_metas = $metas->get_all_meta();
$custom_fonts = $fonts->get_all_fonts();

$token = wp_create_nonce("Essential_Grid_actions");

$import_data = false;
if (isset($_FILES['import_file'])) {
	if ($_FILES['import_file']['error'] > 0) {
		echo '<div class="error"><p>'.esc_attr__('Invalid file or file size too big.', ESG_TEXTDOMAIN).'</p></div>';
	} else {
		$file_name = $_FILES['import_file']['name'];
		$ext = explode(".", $file_name);
		$file_ext = strtolower(end($ext));
		$file_size = $_FILES['import_file']['size'];
		if ($file_ext == "json") {
			$encode_data = file_get_contents($_FILES['import_file']['tmp_name']);
			$import_data = json_decode($encode_data, true);
		}else {
			echo '<div class="error"><p>'.esc_attr__('Invalid file or file size too big.', ESG_TEXTDOMAIN).'</p></div>';
		}
	}
}

function esg_sort_grids_alphabetical_callback($a, $b)
{
	if (is_object($a) && is_object($b)) {
		$a_name = $a->name;
		$b_name = $b->name;
	} else if (is_array($a) && is_array($b)) {
		$a_name = $a['name'];
		$b_name = $b['name'];
	} else {
		return 0;
	}
	$a_name = strtolower(strval($a_name));
	$b_name = strtolower(strval($b_name));
	if ($a_name > $b_name) {
		return 1;
	} else if ($a_name < $b_name) {
		return -1;
	}
	return 0;
}

function esg_sort_grids_alphabetical($ar)
{
	$ar;
	if (!is_array($ar) || empty($ar)) {
		return $ar;
	}
	$arr = $ar;
	usort($arr, 'esg_sort_grids_alphabetical_callback'); // anonomous functions not backwards compatible
	return $arr;
}

?>
	<h2 class="topheader"><?php echo esc_html(get_admin_page_title()); ?></h2>
	<div id="eg-global-settings-menu">
		<ul>
			<li class="eg-menu-placeholder"></li>
			<li class="selected-esg-setting" data-toshow="esg-import-settings"><i class="material-icons">publish</i><p><?php echo esc_html_e('Import', ESG_TEXTDOMAIN); ?></p></li>
			<li data-toshow="esg-export-settings"><i class="material-icons">get_app</i><p><?php echo esc_html_e('Export', ESG_TEXTDOMAIN); ?></p></li>
			<li data-toshow="esg-demo-datas"><i class="material-icons">style</i><p><?php echo esc_html_e('Demo Datas', ESG_TEXTDOMAIN); ?></p></li>
		</ul>
	</div>
	<div id="eg-grid-export-import-wrapper" class="esg-box">
		<div id="esg-demo-datas" class="esg-settings-container">
			<?php
			$add_cpt = apply_filters('essgrid_set_cpt', get_option('tp_eg_enable_custom_post_type', 'true'));
			if($add_cpt == 'true' || $add_cpt === true){
				?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Full Demo ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<div class="esg-btn esg-green" id="esg-import-demo-posts"><?php esc_html_e('Import Full Demo Data', ESG_TEXTDOMAIN); ?></div>
					</div>
				</div>
				<?php
			}
			?>
			<div> 
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Social Demo ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">
					<div class="esg-btn esg-purple" id="esg-import-demo-posts-210"><?php esc_html_e('Import Social Media Demo Grids', ESG_TEXTDOMAIN); ?></div>
				</div>
			</div>
			<div> 
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Skins ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">
					<a href="<?php echo admin_url('admin.php'); ?>?page=essential-grid-item-skin" class="esg-btn esg-purple" id="esg-download-skins"><?php esc_html_e('Download Fresh Skins', ESG_TEXTDOMAIN); ?></a>
				</div>
			</div>
		</div>
		<form id="esg-export-settings" class="esg-settings-container" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>?action=Essential_Grid_request_ajax">
			<input type="hidden" name="client_action" value="export_data">
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<?php if(!empty($grids)) { ?>
				<div>
					<!-- BASIC SETTINGS -->
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Grids ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input  type="checkbox" name="export-grids" checked="checked" /><span><?php esc_html_e('All', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php 
									$allGrids = esg_sort_grids_alphabetical( $grids );
									foreach($allGrids as $grid) {
									?>
										<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-grids-id[]" value="<?php echo $grid->id; ?>" checked="checked" /><?php echo $grid->name; echo ' [ ' . $grid->handle . ' ]'; ?></div></li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
			<?php if(!empty($skins)){ ?>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Skins ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-skins" checked="checked" /><span><?php esc_html_e('All', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									$allSkins = esg_sort_grids_alphabetical( $skins );
									foreach($allSkins as $skin){
									?>
										<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" /><?php echo $skin['name']; ?></div></li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
			<?php if(!empty($elements)){ ?>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Elements', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-elements" checked="checked" /><span><?php esc_html_e('All', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									$allElements = esg_sort_grids_alphabetical( $elements );
									foreach($allElements as $element){
									?>
										<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-elements-id[]" checked="checked" value="<?php echo $element['id']; ?>" /><?php echo $element['name']; ?></div></li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
			<?php if(!empty($navigation_skins)){ ?>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Navigation Skins', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-navigation-skins" checked="checked" /><span><?php esc_html_e('All', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
								<?php
								$allNavs = esg_sort_grids_alphabetical( $navigation_skins );
								foreach($allNavs as $skin){
								?>
									<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-navigation-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" /><?php echo $skin['name']; ?></div></li>
								<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
			<?php if(!empty($custom_metas)){ ?>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Custom Metas', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-custom-meta" checked="checked" /><span><?php esc_html_e('All', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									$allMetas = esg_sort_grids_alphabetical( $custom_metas );
									foreach($allMetas as $meta){
										$type = ($meta['m_type'] == 'link') ? 'egl-' : 'eg-';
									?>
										<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-custom-meta-handle[]" checked="checked" value="<?php echo $meta['handle']; ?>" /><?php echo $type; ?><?php echo $meta['handle']; ?></div></li>
									<?php } ?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Others', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="export-global-styles" checked="checked" /><span><?php esc_html_e('Global Styles', ESG_TEXTDOMAIN); ?></span></div></li>
						</ul>
					</div>
				</div>
				<div>
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Export', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<input type="submit" id="eg-export-selected-settings" class="esg-btn esg-purple" value="<?php esc_attr_e('Export Selected', ESG_TEXTDOMAIN); ?>" />
					</div>
				</div>
		</form>
		
		<?php 
		$is_open = 'closed';
		$is_vis = 'display:none;';
		if($import_data !== false && !empty($import_data)){
			$is_open = 'open';
			$is_vis = '';
			?>
		<form id="esg-import-settings" class="esg-settings-container active-esc">
				<?php
				if(isset($import_data['grids']) && is_array($import_data['grids']) && !empty($import_data['grids'])){
					foreach($import_data['grids'] as $d_grid){
						?>
						<input type="hidden" name="data-grids[]" value="<?php echo htmlentities(json_encode($d_grid, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['skins']) && is_array($import_data['skins']) && !empty($import_data['skins'])){
					foreach($import_data['skins'] as $d_skin){
						?>
						<input type="hidden" name="data-skins[]" value="<?php echo htmlentities(json_encode($d_skin, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['elements']) && is_array($import_data['elements']) && !empty($import_data['elements'])){
					foreach($import_data['elements'] as $d_elements){
						?>
						<input type="hidden" name="data-elements[]" value="<?php echo htmlentities(json_encode($d_elements, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['navigation-skins']) && is_array($import_data['navigation-skins']) && !empty($import_data['navigation-skins'])){
					foreach($import_data['navigation-skins'] as $d_navigation_skins){
						?>
						<input type="hidden" name="data-navigation-skins[]" value="<?php echo htmlentities(json_encode($d_navigation_skins, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['custom-meta']) && is_array($import_data['custom-meta']) && !empty($import_data['custom-meta'])){
					foreach($import_data['custom-meta'] as $d_custom_meta){
						?>
						<input type="hidden" name="data-custom-meta[]" value="<?php echo htmlentities(json_encode($d_custom_meta, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['punch-fonts']) && is_array($import_data['punch-fonts']) && !empty($import_data['punch-fonts'])){
					foreach($import_data['punch-fonts'] as $d_punch_fonts){
						?>
						<input type="hidden" name="data-punch-fonts[]" value="<?php echo htmlentities(json_encode($d_punch_fonts, true)); ?>" />
						<?php
					}
				}
				if(isset($import_data['global-css'])){
					?>
					<input type="hidden" name="data-global-css" value="<?php echo htmlentities(json_encode($import_data['global-css'], true)); ?>" />
					<?php
				}
				?>
			<?php
		}else{
			?>
		<form id="esg-import-settings" method="post" class="esg-settings-container active-esc" enctype="multipart/form-data">
			<?php
		}
		?>
		<?php 
		if($import_data !== false && !empty($import_data)){
		?>
			<?php
			if(!empty($import_data['grids'])){ ?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Grids ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input  type="checkbox" name="import-grids" checked="checked" /><span><?php esc_html_e('Grids', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($import_data['grids'] as $grid_values){
										?>
										<li>
											<div class="eg-li-intern-wrap">
												<input class="eg-get-val" type="checkbox" name="import-grids-id[]" value="<?php echo $grid_values['id']; ?>" checked="checked" />
												<?php echo $grid_values['name']; ?>
												<?php
												if(!empty($grids)){
													foreach($grids as $grid){
														if($grid->handle == $grid_values['handle']){
															//already exists in database, ask to append or overwrite
															?>
															<span class="esg-f-right">
																<input type="radio" name="grid-overwrite-<?php echo $grid_values['id']; ?>" checked="checked" value="append" /> <?php esc_html_e('Append as New', ESG_TEXTDOMAIN); ?><div class="space18"></div><!--
																--><input type="radio" name="grid-overwrite-<?php echo $grid_values['id']; ?>" value="overwrite" /> <?php esc_html_e('Overwrite Existing', ESG_TEXTDOMAIN); ?>
															</span>
															<div class="esg-clearfix"></div>
															<?php
															break;
														}
													}
												}
												?>
											</div>
										</li>
										<?php
									}
									?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($import_data['skins'])){ ?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Skins ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>	
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="import-skins" checked="checked" /><span><?php esc_html_e('Skins', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($import_data['skins'] as $skin){
										?>
										<li>
											<div class="eg-li-intern-wrap">
												<input class="eg-get-val" type="checkbox" name="import-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" />
												<?php echo $skin['name']; ?>
												<?php
												if(!empty($skins)){
													foreach($skins as $e_skin){
														if($skin['handle'] == $e_skin['handle']){
															//already exists in database, ask to append or overwrite
															?>
															<span class="esg-f-right">
																<input type="radio" name="skin-overwrite-<?php echo $skin['id']; ?>" checked="checked" value="append" /> <?php esc_html_e('Append as New', ESG_TEXTDOMAIN); ?><div class="space18"></div><!--
																--><input type="radio" name="skin-overwrite-<?php echo $skin['id']; ?>" value="overwrite" /> <?php esc_html_e('Overwrite Existing', ESG_TEXTDOMAIN); ?>
															</span>
															<div class="esg-clearfix"></div>
															<?php
															break;
														}
													}
												}
												?>
											</div>
										</li>
										<?php
									}
									?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($import_data['elements'])){ ?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Elements ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>	
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="import-elements" checked="checked" /><span><?php esc_html_e('Elements', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($import_data['elements'] as $element){
										?>
										<li>
											<div class="eg-li-intern-wrap">
												<input class="eg-get-val" type="checkbox" name="import-elements-id[]" checked="checked" value="<?php echo $element['id']; ?>" />
												<?php echo $element['name']; ?>
												<?php
												if(!empty($elements)){
													foreach($elements as $e_element){
														if($element['handle'] == $e_element['handle']){
															//already exists in database, ask to append or overwrite
															?>
															<span class="esg-f-right">
																<input type="radio" name="element-overwrite-<?php echo $element['id']; ?>" checked="checked" value="append" /> <?php esc_html_e('Append as New', ESG_TEXTDOMAIN); ?><div class="space18"></div><!--
																--><input type="radio" name="element-overwrite-<?php echo $element['id']; ?>" value="overwrite" /> <?php esc_html_e('Overwrite Existing', ESG_TEXTDOMAIN); ?>
															</span>
															<div class="esg-clearfix"></div>
															<?php
															break;
														}
													}
												}
												?>
											</div>
										</li>
										<?php
									}
									?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($import_data['navigation-skins'])){ ?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Navigation Skins ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="import-navigation-skins" checked="checked" /><span><?php esc_html_e('Navigation Skins', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($import_data['navigation-skins'] as $skin){
										?>
										<li>
											<div class="eg-li-intern-wrap">
												<input class="eg-get-val" type="checkbox" name="import-navigation-skins-id[]" checked="checked" value="<?php echo $skin['id']; ?>" />
												<?php echo $skin['name']; ?>
												<?php
												if(!empty($navigation_skins)){
													foreach($navigation_skins as $e_nav_skins){
														if($skin['handle'] == $e_nav_skins['handle']){
															//already exists in database, ask to append or overwrite
															?>
															<span class="esg-f-right">
																<input type="radio" name="nav-skin-overwrite-<?php echo $skin['id']; ?>" checked="checked" value="append" /> <?php esc_html_e('Append as New', ESG_TEXTDOMAIN); ?><div class="space18"></div><!--
																--><input type="radio" name="nav-skin-overwrite-<?php echo $skin['id']; ?>" value="overwrite" /> <?php esc_html_e('Overwrite Existing', ESG_TEXTDOMAIN); ?>
															</span>
															<div class="esg-clearfix"></div>
															<?php
															break;
														}
													}
												}
												?>
											</div>
										</li>
										<?php
									}
									?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($import_data['custom-meta'])){ ?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Custom Meta ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="import-custom-meta" checked="checked" /><span><?php esc_html_e('Custom Meta', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($import_data['custom-meta'] as $custom_meta){
										?>
										<li>
											<div class="eg-li-intern-wrap">
												<input class="eg-get-val" type="checkbox" name="import-custom-meta-handle[]" checked="checked" value="<?php echo $custom_meta['handle']; ?>" />
												<?php echo $custom_meta['handle']; ?>
												<?php
												if(!empty($custom_metas)){
													foreach($custom_metas as $e_custom_meta){
														if($custom_meta['handle'] == $e_custom_meta['handle']){
															//already exists in database, ask to append or overwrite
															?>
															<span class="esg-f-right">
																<input type="radio" name="custom-meta-overwrite-<?php echo $custom_meta['handle']; ?>" checked="checked" value="append" /> <?php esc_html_e('Append as New', ESG_TEXTDOMAIN); ?><div class="space18"></div><!--
																--><input type="radio" name="custom-meta-overwrite-<?php echo $custom_meta['handle']; ?>" value="overwrite" /> <?php esc_html_e('Overwrite Existing', ESG_TEXTDOMAIN); ?>
															</span>
															<div class="esg-clearfix"></div>
															<?php
															break;
														}
													}
												}
												?>
											</div>
										</li>
										<?php
									}
									?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($import_data['punch-fonts'])){ ?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Punch Fonts ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li><div class="eg-li-intern-wrap"><input type="checkbox" name="import-punch-fonts" checked="checked" /><span><?php esc_html_e('Punch Fonts', ESG_TEXTDOMAIN); ?></span><span class="eg-amount-of-lis"></span></div>
								<ul class="eg-ie-sub-ul">
									<?php
									foreach($import_data['punch-fonts'] as $punch_font){
										?>
										<li>
											<div class="eg-li-intern-wrap">
												<input class="eg-get-val" type="checkbox" name="import-punch-fonts-handle[]" checked="checked" value="<?php echo $punch_font['handle']; ?>" />
												<?php echo $punch_font['handle']; ?>
												<?php
												if(!empty($custom_fonts)){
													foreach($custom_fonts as $e_custom_font){
														if($punch_font['handle'] == $e_custom_font['handle']){ //already exists in database, ask to append or overwrite
															?>
															<span class="esg-f-right">
																<input type="radio" name="punch-fonts-overwrite-<?php echo $punch_font['handle']; ?>" checked="checked" value="append" /> <?php esc_html_e('Append as New', ESG_TEXTDOMAIN); ?><div class="space18"></div><!--
																--><input type="radio" name="punch-fonts-overwrite-<?php echo $punch_font['handle']; ?>" value="overwrite" /> <?php esc_html_e('Overwrite Existing', ESG_TEXTDOMAIN); ?>
															</span>
															<div class="esg-clearfix"></div>
															<?php
															break;
														}
													}
												}
												?>
											</div>
										</li>
										<?php
									}
									?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
			<?php if(!empty($import_data['global-css'])){ ?>
				<div> 
					<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Global CSS ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
					<div class="eg-cs-tbc eg-cs-tbc-padding">
						<ul>
							<li>
								<div class="eg-li-intern-wrap">
									<input class="eg-get-val" type="checkbox" name="import-global-styles" checked="checked"/><!--
									--><span><?php esc_html_e('Global Styles', ESG_TEXTDOMAIN); ?></span>
									<span class="esg-f-right">
										<input type="radio" name="global-styles-overwrite" checked="checked" value="append" /> <?php esc_html_e('Append as New', ESG_TEXTDOMAIN); ?><div class="space18"></div><!--
										--><input type="radio" name="global-styles-overwrite" value="overwrite" /> <?php esc_html_e('Overwrite Existing', ESG_TEXTDOMAIN); ?>
									</span>
									<div class="esg-clearfix"></div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			<?php } ?>
			<div>
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Import ', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">
					<div id="esg-import-data" class="esg-btn esg-purple" /><?php esc_html_e('Import Selected Data', ESG_TEXTDOMAIN); ?>
				</div>
			</div>
		<?php
		}else{ ?>
			<div>
				<div class="eg-cs-tbc-left"><esg-llabel><span><?php echo esc_html_e('Select File', ESG_TEXTDOMAIN); ?></span></esg-llabel></div>
				<div class="eg-cs-tbc eg-cs-tbc-padding">
					<input type="file" name="import_file" />
					<div class="div13"></div>
					<input type="submit" class="esg-btn esg-purple" id="esg-read-file-import" value="<?php esc_attr_e('Read Selected File', ESG_TEXTDOMAIN); ?>" />
				</div>
			</div>
		<?php } ?>
		</form>
	</div>
	<script type="text/javascript">
		jQuery('document').ready(function () {
			try {
				jQuery('.mce-notification-error').remove();
				jQuery('#wpbody-content >.notice').remove();
			} catch (e) {
			}

			var buffer = [];
			var inExports = jQuery('#eg-global-settings-menu').find('li[data-toshow="esg-export-settings"]');
			jQuery(document).on('click', '#eg-global-settings-menu li', function () {
				jQuery('#eg-global-settings-menu .selected-esg-setting').removeClass('selected-esg-setting');
				this.classList.add('selected-esg-setting');

				var aes = jQuery('.active-esc'),
						newaes = jQuery('#' + this.dataset.toshow);

				punchgs.TweenLite.to(aes, 0.1, {autoAlpha: 0});
				aes.removeClass("active-esc");

				punchgs.TweenLite.fromTo(newaes, 0.3, {autoAlpha: 0}, {autoAlpha: 1, overwrite: "all"});
				newaes.addClass("active-esc");
			}).on('keydown', function (e) {
				// 3.0.12
				// easter egg to clear the export selections
				// type "deselect" and then type the enter key
				if (!inExports.hasClass('selected-esg-setting')) {
					buffer = [];
					return;
				}
				buffer.push(e.which.toString());
				var found = buffer.join('') === '686983697669678413';
				if (found || buffer.length > 17) {
					buffer = [];
				}
				if (found) {
					// easter egg found
					jQuery('#eg-grid-export-import-wrapper').find('input[type="checkbox"]').prop('checked', false).change();
				}
			});
		});

		jQuery(function () {
			AdminEssentials.initImportExport();
		});
	</script>
