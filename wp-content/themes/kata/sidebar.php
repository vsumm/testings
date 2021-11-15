<?php
/**
 * Left sidebar.
 *
 * @author ClimaxThemes
 * @package Kata
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'kata-left-sidebar' ) ) {
	return;
}
?>

<div id="kata-left-sidebar" class="kata-sidebar">
	<?php dynamic_sidebar( 'kata-left-sidebar' ); ?>
</div>
