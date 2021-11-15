<?php
/**
 * Footer template.
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

if ( class_exists( 'Kata_Plus_Builders_Base' ) ) {
	return;
}

if ( ! function_exists( 'kata_footer' ) ) {
	/**
	 * Kata Footer.
	 */
	function kata_footer() {
		$fotbotlttext = get_theme_mod( 'kata_footer_bottom_left_custom_text', '' );
		$fotbotrttext = get_theme_mod( 'kata_footer_bottom_right_custom_text', '' );
		$footer_buttom = get_theme_mod( 'kata_footer_bottom_area', true );
		$menu = has_nav_menu( 'kt-foot-menu' );
		?> <?php
		if ( $fotbotlttext || $fotbotrttext || is_active_sidebar( 'kata-footr-sidebar-1' ) || is_active_sidebar( 'kata-footr-sidebar-2' ) || is_active_sidebar( 'kata-footr-sidebar-3' ) || $menu ) : ?>
			<div id="kata-footer" class="kata-footer" role="contentinfo">
				<div class="container">
					<?php if ( is_active_sidebar( 'kata-footr-sidebar-1' ) || is_active_sidebar( 'kata-footr-sidebar-2' ) || is_active_sidebar( 'kata-footr-sidebar-3' ) ) : ?>
						<div class="row">
							<?php if ( get_theme_mod( 'kata_footer_widget_area', true ) ) { ?>
								<div class="col-md-4">
									<?php
									if ( is_active_sidebar( 'kata-footr-sidebar-1' ) ) :
										dynamic_sidebar( 'kata-footr-sidebar-1' );
									endif;
									?>
								</div>
								<div class="col-md-4">
									<?php
									if ( is_active_sidebar( 'kata-footr-sidebar-2' ) ) :
										dynamic_sidebar( 'kata-footr-sidebar-2' );
									endif;
									?>
								</div>
								<div class="col-md-4">
									<?php
									if ( is_active_sidebar( 'kata-footr-sidebar-3' ) ) :
										dynamic_sidebar( 'kata-footr-sidebar-3' );
									endif;
									?>
								</div>
							<?php } ?>
						</div>
					<?php endif; ?>
					<?php if ( true == $footer_buttom ) : ?>
						<?php if ( $fotbotlttext || $fotbotrttext || has_nav_menu( 'kt-foot-menu' ) ) : ?>
							<div id="kata-footer-bot" class="kata-footer-bot">
								<div class="container">
									<div class="row">
										<?php do_action( 'kata_footer_bottom_template' ); ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php
		endif;
	}

	add_action( 'kata_footer', 'kata_footer' );
}
