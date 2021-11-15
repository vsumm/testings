<?php
/**
 * Header template.
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

if ( class_exists( 'Kata_Plus_Builders_Base' ) ) {
	return;
}

if ( ! function_exists( 'kata_header_tpl' ) ) {
	/**
	 * Header Template Function
	 *
	 * @since   1.0.0
	 */
	function kata_header_tpl() {
		$kata_header_layout			= get_theme_mod( 'kata_header_layout', 'left' );
		$kata_mobile_header_layout	= get_theme_mod( 'kata_mobile_header_layout', 'left' );
		?>
		<div id="kata-header" class="kata-header kata-header-mobile-template-<?php echo esc_attr( $kata_mobile_header_layout ); ?> kata-header-template-<?php echo esc_attr( $kata_header_layout ); ?>" role="banner">
			<div class="container">
				<div class="row">
					<?php do_action( 'kata_header_template' ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	add_action( 'kata_header', 'kata_header_tpl' );
}
