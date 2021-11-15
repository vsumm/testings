<?php
/**
 * Right sidebar.
 *
 * @author ClimaxThemes
 * @package Kata
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'kata-right-sidebar' ) ) {
	return;
}
?>

<div id="kata-right-sidebar" class="kata-sidebar">
	<?php dynamic_sidebar( 'kata-right-sidebar' ); ?>
</div>
