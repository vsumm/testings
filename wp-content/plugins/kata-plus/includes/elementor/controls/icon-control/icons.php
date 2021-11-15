<?php

/**
 * Icons.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

add_action('current_screen', 'kata_plus_icons_current_screen');
add_action('elementor/editor/footer', 'kata_plus_icons');

function kata_plus_icons_current_screen($current_screen)
{
	if ($current_screen->base == 'kata_page_kata-plus-theme-options' || $current_screen->base == 'nav-menus') {
		add_action('admin_footer', 'kata_plus_icons');
	}
}

function kata_plus_icons() {
	$fonts = require_once Kata_Plus::$assets_dir . 'fonts/svg-icons.php';
	if ( ! class_exists( 'Kata_Plus_Pro' ) ) {
		unset( $fonts['7-stroke'] );
	}
?>
	<div id="kata-icons-dialog" class="kata-dialog kata-icons-dialog">
		<h5 class="kata-dialog-header">
			<span><?php esc_html_e('Add Icon', 'kata-plus'); ?></span>
			<span class="kata-dialog-close-btn"><i class="ti-close"></i></span>
			<?php do_action( 'kata_plus_add_icon_set' ); ?>
		</h5> <!-- .kata-dialog-header -->
		<div class="kata-dialog-body">
			<ul class="kata-icons">
				<!-- Search icons -->
				<div class="kata-search-icons">
					<input type="text" placeholder="<?php esc_html_e('Search', 'kata-plus'); ?>">
				</div>
				<!-- Filter icons -->
				<ul class="kata-filter-icons">
					<?php do_action('kata-icon-box-filter-icons-before') ?>
					<?php
					$i = 1;
					foreach ($fonts as $font_family => $title) {
						if ($font_family != '.' && $font_family != '..') {
							$class = $i == 1 ? 'class=active' : '';
					?>
							<li <?php echo esc_attr( $class ) ?> data-name="<?php echo esc_attr($font_family); ?>"><a href="#"><?php echo esc_html($title); ?></a></li>
					<?php
						$i++;
						}
					}
					?>
					<?php do_action('kata-icon-box-filter-icons-after')
					?>
				</ul>

				<!-- Icons -->
				<div class="search-result icons-wrap"></div>
				<div class="icons-wrap">
					<?php
					$i = 1;
					foreach ($fonts as $font_family => $title) {
						if ($font_family != '.' && $font_family != '..') {
							$style = $i == 1 ? 'block' : 'none';
							echo '<ul class="icon-pack-wrap" data-pack="' . $font_family . '" style="display:' . esc_attr( $style ) . ';">';
							$dir = '7-stroke' == $font_family && class_exists('Kata_Plus_Pro') ? Kata_Plus_Pro::$assets_dir : Kata_Plus::$assets_dir;
							$dir .= 'fonts/svg-icons/' . $font_family;
							if ( file_exists( $dir ) ) {
								if ( $handle = opendir( $dir ) ) {
									while (false !== ( $entry = readdir( $handle ) ) ) {
										$entry = str_replace( '.svg', '', $entry );
										$name  = str_replace( [' ', '-'], '_', $entry );
										if ( $entry != '.' && $entry != '..' ) {
											$icon = Kata_Plus_Helpers::get_icon_url( $entry, $font_family );
											echo '
											<li data-font-family="' . $font_family . '" data-name="' . $font_family . '/' . $entry . '">
												<input type="radio" name="icon" data-name="' . $font_family . '/' . $entry . '" id="' . $name . '" value="' . $name . '">
												<label><img class="lozad" data-src="' . $icon . '" style="width: 20px;" title="' . $title . '" alt="' . $title . '"></label>
											</li>';
										}
									}
									closedir( $handle );
								}
							}
							echo '</ul>';
							$i++;
						}
					}
					?>
					<?php // do_action('kata-icon-box-results')
					?>
					<div class="icons-management-area hidden">
						<div class="sections">

							<div class="section management-section">
								<?php do_action('kata-icon-box-management-section'); ?>
							</div>
							<div class="section add-new-icon-pack-modal-section hidden">
								<?php echo '<div class="kata-new-pack-form-wrap hidden"><input type="text" placeholder="' . __('Please enter new icon pack name') . '" class="kata-new-pack-name" data-required="' . __('Please fill the above field','kata-plus') . '"><span class="kata-new-pack-back-step">' . __('Back', 'kata-plus') . '</span><span class="kata-new-pack-next-step">' . __('Next', 'kata-plus') . '</span><span class="kata-new-pack-message"></span></div>'; ?>
							</div>
							<div class="section add-new-icon-pack-section">
								<?php do_action('kata-icon-box-add-new-icon-pack-section'); ?>
							</div>
							<div class="section icon-pack-section">
								<?php do_action('kata-icon-box-icon-pack-section'); ?>
							</div>
						</div>
					</div>
				</div>
			</ul>
		</div> <!-- .kata-dialog-body -->

	</div> <!-- .kata-dialog -->
<?php
}
