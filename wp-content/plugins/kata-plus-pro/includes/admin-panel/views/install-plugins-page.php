<?php

/**
 * Plugin Page.
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
<div class="kata-admin kata-install-plusins-page wrap about-wrap">
	<?php $this->header(); ?>
	<div class="kata-plus-plugins-header-wrap">
		<div class="kp-menu-item active">
			<a href="<?php echo admin_url('plugins.php?plugin_status=all'); ?>"><?php echo __('Installed Plugins', 'kata-plus'); ?></a>
		</div>
		<div class="kp-menu-item included_plugins">
			<a href="<?php echo admin_url('admin.php?page=kata-plus-plugins&included_plugins=true'); ?>"><?php echo __('Bundled Plugins', 'kata-plus'); ?></a>
		</div>
		<div class="kp-menu-item">
			<a href="<?php echo admin_url('plugin-install.php?tab=upload'); ?>"><?php echo __('Upload Plugin', 'kata-plus'); ?></a>
		</div>
		<?php if (!is_multisite()) : ?>
			<div class="kp-menu-item">
				<a href="<?php echo admin_url('plugin-install.php'); ?>"><?php echo __('New Plugin', 'kata-plus'); ?></a>
			</div>
		<?php endif; ?>
	</div>
	<?php Kata_Plus_Autoloader::load(Kata_Plus_Install_Plugins::$dir . 'core', 'install-plugins-output'); ?>
</div> <!-- end .kata-admin -->

<?php if (isset($_GET['plugin_status']) && $_GET['plugin_status'] == 'update') : ?>
	<script>
		jQuery(document).ready(function() {
			jQuery('.kata-plus-plugins-header-wrap .kp-menu-item.included_plugins a').trigger('click');
		})
	</script>

<?php endif; ?>
<?php
do_action('kata_plus_control_panel');
