<?php
// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
?>
<div class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-add-new-wrap">

	<h1 class="wp-heading-inline">
		<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager' ); ?>"><a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager' ); ?>"><?php echo esc_html__( 'Font Manager', 'kata-plus' ); ?></a></a>
		<span class="dashicons dashicons-arrow-right-alt2"></span>
		<span><?php echo esc_html__( 'Add New Font', 'kata-plus' ); ?></span>
	</h1>

	<div id="kata-plus-fonts-manager-stuff">
		<div id="kata-plus-fonts-manager-body" class="metabox-holder">
			<div id="kata-plus-fonts-manager-body-content">
				<div class="meta-box-sortables ui-sortable">
					<form method="post">
						<?php
							$this->prepare_items();
							$this->display();
						?>
					</form>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		jQuery("table.wp-list-table #the-list tr").each(function() {
			jQuery(this).css('cursor','pointer');
			jQuery(this).on('hover', function() {
				jQuery(this).find('input[name="source"]').trigger('focus');
			})
			jQuery(this).on('click', function() {
				jQuery(this).find('input[name="source"]').prop('checked', true);
				jQuery(this).parents('form').first().trigger('submit');
			})
		});
	});
</script>
