<?php

/**
 * Install Plugins Output.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}
?>

<div class="kata-install-plugins-wrapper">
	<div class="kata-container">
		<div class="kata-row">
			<?php if (!isset($_GET['included_plugins'])) : ?>
				<div class="plugins-content"></div>
				<style>
					.plugins-content {
						width: 100%;
						display: -webkit-box;
						display: -ms-flexbox;
						display: flex;
						-ms-flex-wrap: wrap;
						flex-wrap: wrap;
					}
				</style>
				<script>
					var plugins_page = "<?php echo admin_url('plugins.php'); ?>";
					var last_page = "<?php echo admin_url('plugins.php'); ?>";
					jQuery(document).ready(function() {
						jQuery.fn.outerHTML = function() {
							return jQuery('<div />').append(this.eq(0).clone()).html();
						};
						jQuery('<div class="preloader-parent" style="position: relative;"><div class="lds-ripple kata-plus-fonts-manager-loading" style="position: relative;"> <div></div> <div></div> </div></div>').appendTo('.plugins-content');
						jQuery('.kp-menu-item').on('click',function(){
							jQuery(this).siblings().find('a').css('pointer-events','none');
						});
						if (window.location.search == '?page=kata-plus-plugins') {
							jQuery('.kp-menu-item:first-child a').trigger('click');
						} else {
							jQuery.ajax({
								type: 'get',
								url: plugins_page,
								success: function(response) {
									setTimeout(function () {
										var $response = jQuery(response);
										jQuery('.plugins-content').html($response.find('.wrap').html());
										jQuery('.kp-menu-item').find('a').removeAttr('style');
									}, 1000);
								}
							});
						}
					});
					jQuery(document).on('click', '.upload', function(e) {
						// e.preventDefault();	

						if (jQuery('div.upload-plugin-wrap').css('display') == 'block') {
							jQuery('div.upload-plugin-wrap').css('display', 'none');
							jQuery('div.upload-plugin').css('display', 'none');
						} else {
							jQuery('div.upload-plugin').css('display', 'block');
							jQuery('div.upload-plugin-wrap').css('display', 'block');
						}
						return false;
					})
					jQuery(document).on('click', '.plugin-version-author-uri a, .elementor-plugins-gopro', function() {
						if (!jQuery(this).hasClass('.open-plugin-details-modal')) {
							window.open(jQuery(this).attr('href'), '_blank');
						}
					});
					jQuery(document).on('click', '.plugins-content a, .kata-plus-plugins-header-wrap a', function() {
						var $href = jQuery(this).attr('href');
						last_page = $href;
						var adminPage = '<?php echo admin_url(); ?>';

						if ($href.search('http') > -1) {
							if ($href.search(adminPage) == -1) {
								return false;
							}
						}

						if (jQuery(this).parent().hasClass('kp-menu-item')) {
							jQuery(this).parent().siblings('.kp-menu-item').each(function() {
								jQuery(this).removeClass('active');
							});
							jQuery(this).parent().addClass('active');
						} else {
							jQuery('.kp-menu-item').on('click', function(e) {
								jQuery(this).addClass('active').siblings().removeClass('active');
							});
						}

						jQuery('<div class="preloader-parent"><div class="lds-ripple kata-plus-fonts-manager-loading"> <div></div> <div></div> </div></div>').appendTo('.plugins-content');
						jQuery.ajax({
							type: 'get',
							url: last_page,
							success: function(response) {
								setTimeout(function () {
									var $response = jQuery(response);
									var $content = $message = "";
									if ($response.find('#message').length) {
										$message = $response.find('#message').outerHTML();
									}
									$content = $response.find('.wrap');
									if ($response.find('.plugin-install-tab-featured').length) {
										$content = $response.find('.plugin-install-tab-featured');
									} else if ($response.find('.plugin-install-tab-popular').length) {
										$content = $response.find('.plugin-install-tab-popular');
									} else if ($response.find('.plugin-install-tab-search').length) {
										$content = $response.find('.plugin-install-tab-search');
									} else if ($response.find('.plugin-install-tab-recommended').length) {
										$content = $response.find('.plugin-install-tab-recommended');
									} else if ($response.find('.plugin-install-tab-favorites').length) {
										$content = $response.find('.plugin-install-tab-favorites');
									} else if ($response.find('.upload-plugin').length) {
										$content = $response.find('.upload-plugin');
									} else if ($response.find('.kata-row').length) {
										$content = $response.find('.kata-row');
									} else if (!$content.length) {
										jQuery('.plugins-content').find('.kata-plus-fonts-manager-loading').remove();
										var win = window.open($href, '_blank');
										if (win) {
											win.focus();
										} else {
											alert('Please allow popups!');
										}

										return false;
									}
									jQuery('.plugins-content').html($message + $content.html());
									jQuery('.plugins-content').find('.kata-plus-fonts-manager-loading').remove();
									jQuery('.kp-menu-item').find('a').removeAttr('style');
								}, 1000);
							}
						});

						return false;
					})
					jQuery(document).on('change', '.plugins-content input', function() {
						var $type = jQuery(this).attr('type');
						if ($type == 'text' || $type == 'search') {
							jQuery(this).parents('form').first().trigger('submit');
						}
					})
					jQuery(document).on('submit', '.plugins-content form', function() {
						jQuery('<div class="preloader-parent"><div class="lds-ripple kata-plus-fonts-manager-loading"> <div></div> <div></div> </div></div>').appendTo('.plugins-content');
						var $type = jQuery(this).attr('method');
						if ($type == 'post') {
							var $data = new FormData(this);
						} else {
							var $data = new jQuery(this).serialize();
						}

						if (typeof(jQuery(this).attr('action')) != 'undefined') {
							last_page = jQuery(this).attr('action');
						}
						jQuery.ajax({
							type: $type,
							url: last_page,
							contentType: false, //this is requireded please see answers above
							processData: false, //this is requireded please see answers above
							data: $data,
							success: function(response) {
								setTimeout(function () {
									var $response = jQuery(response);
									var $content = "";
									if ($response.find('.wrap').length) {
										$content = $response.find('.wrap').html();
									} else if ($response.find('.upload-plugin').length) {
										$content = $response.find('.upload-plugin').html();
									}
									if (!$content) {
										jQuery('.plugins-content').find('.kata-plus-fonts-manager-loading').remove();
									} else {
										jQuery('.plugins-content').find('.kata-plus-fonts-manager-loading').remove();
										jQuery('.plugins-content').html($content);
									}
									jQuery('.kp-menu-item').find('a').removeAttr('style');
								}, 1000);
							}
						});
						return false;
					})
				</script>
			<?php else : ?>
				<?php
				$tgmpa_list_table = new TGM_Plugin_Activation();
				$tgmpa_list_table->install_plugins_page();
				?>
			<?php endif; ?>
		</div> <!-- end .kata-row -->
	</div> <!-- end .container -->
</div> <!-- .kata-importer -->