<?php
// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
?>
<div class="wrap kata-plus-fonts-manager-wrap">
	
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&controller=settings' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Settings', 'kata-plus' ); ?></a>
	<a href="<?php echo admin_url( 'admin.php?page=kata-plus-fonts-manager&action=add_new_font' ); ?>" class="hide-if-no-js page-title-action left"><?php echo esc_html__( 'Add New Font', 'kata-plus' ); ?></a>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder">
			<div id="post-body-content">
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

