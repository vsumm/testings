<?php

/**
 * Content Slider module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Plugin;

$settings                          = $this->get_settings();
$attrs                             = '';
$cntsliders                        = $settings['cntsliders'];
$settings['inc_owl_arrow']         = $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
$settings['inc_owl_pag']           	= $settings['inc_owl_pag'] == 'true' ? 'true' : 'false';
$settings['inc_owl_loop']          = $settings['inc_owl_loop'] == 'true' ? 'true' : 'false';
$settings['inc_owl_autoplay']      = $settings['inc_owl_autoplay'] == 'true' ? 'true' : 'false';
$settings['inc_owl_center']        = $settings['inc_owl_center'] == 'true' ? 'true' : 'false';
$settings['inc_owl_vert']          = $settings['inc_owl_vert'] == 'true' ? 'true' : 'false';
$animateout                        = $settings['inc_owl_vert'] == 'true' ? 'fadeOutUp' : '';
$animatein                         = $settings['inc_owl_vert'] == 'true' ? 'fadeInUp' : '';
$settings['inc_owl_rtl']           = $settings['inc_owl_rtl'] == 'true' ? 'true' : 'false';
if ( empty( $settings['inc_owl_item_tablet'] ) && $settings['inc_owl_item'] == '1' ) {
	$settings['inc_owl_item_tablet'] = $settings['inc_owl_item'];
} else if ( empty( $settings['inc_owl_item_tablet'] ) && $settings['inc_owl_item'] > '1' ) {
	$settings['inc_owl_item_tablet'] = '2';
}
if ( empty( $settings['inc_owl_item_mobile'] ) && $settings['inc_owl_item'] == '1' ) {
	$settings['inc_owl_item_mobile'] = $settings['inc_owl_item'];
} else if ( empty( $settings['inc_owl_item_mobile'] ) && $settings['inc_owl_item'] > '1' ) {
	$settings['inc_owl_item_mobile'] = '1';
}
$settings['inc_owl_stgpad_tablet'] = $settings['inc_owl_stgpad_tablet'] ? $settings['inc_owl_stgpad_tablet'] : '0';
$settings['inc_owl_stgpad_mobile'] = $settings['inc_owl_stgpad_mobile'] ? $settings['inc_owl_stgpad_mobile'] : '0';
$settings['inc_owl_margin_tablet'] = $settings['inc_owl_margin_tablet'] ? $settings['inc_owl_margin_tablet'] : '0';
$vertical_bullet  				   = (!empty($settings['vertical_bullet'])) ? 'vertical-bullet' : '';
$settings['inc_owl_margin_mobile'] = $settings['inc_owl_margin_mobile'] ? $settings['inc_owl_margin_mobile'] : '0';
$classes                           = $settings['inc_owl_pag_num'];
$classes                           .= $settings['progress_bar'] == 'true' ? ' dots-and-num' : '';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<?php if ($cntsliders) : ?>
	<div
	class="kata-plus-content-slider kata-owl owl-carousel owl-theme <?php echo esc_attr($classes . ' ' . $vertical_bullet); ?>"
	data-inc_owl_item="<?php echo esc_attr($settings['inc_owl_item']); ?>"
	data-inc_owl_item_tab_landescape="<?php echo $settings['inc_owl_item_tab_landescape'] ? esc_attr( $settings['inc_owl_item_tab_landescape'] ) : esc_attr( $settings['inc_owl_item_tablet'] ); ?>"
	data-inc_owl_itemtab="<?php echo esc_attr($settings['inc_owl_item_tablet']); ?>"
	data-inc_owl_itemmob="<?php echo esc_attr($settings['inc_owl_item_mobile']); ?>"
	data-inc_owl_spd="<?php echo esc_attr($settings['inc_owl_spd']); ?>"
	data-inc_owl_smspd="<?php echo esc_attr($settings['inc_owl_smspd']); ?>"
	data-inc_owl_stgpad="<?php echo esc_attr($settings['inc_owl_stgpad']); ?>"
	data-inc_owl_stgpadtab="<?php echo esc_attr($settings['inc_owl_stgpad_tablet']); ?>"
	data-inc_owl_stgpadmob="<?php echo esc_attr($settings['inc_owl_stgpad_mobile']); ?>"
	data-inc_owl_margin="<?php echo esc_attr($settings['inc_owl_margin']); ?>"
	data-inc_owl_margintab="<?php echo esc_attr($settings['inc_owl_margin_tablet']); ?>"
	data-inc_owl_marginmob="<?php echo esc_attr($settings['inc_owl_margin_mobile']); ?>"
	data-inc_owl_arrow="<?php echo esc_attr($settings['inc_owl_arrow']); ?>"
	data-inc_owl_pag="<?php echo esc_attr($settings['inc_owl_pag']); ?>"
	data-inc_owl_loop="<?php echo esc_attr($settings['inc_owl_loop']); ?>"
	data-inc_owl_rtl="<?php echo esc_attr($settings['inc_owl_rtl']); ?>"
	data-inc_owl_autoplay="<?php echo esc_attr($settings['inc_owl_autoplay']); ?>"
	data-inc_owl_center="<?php echo esc_attr($settings['inc_owl_center']); ?>"
	data-inc_owl_vert="<?php echo esc_attr($settings['inc_owl_vert']); ?>" data-animatein="<?php echo esc_attr($animatein); ?>" data-animateout="<?php echo esc_attr($animateout); ?>"
	data-inc_owl_prev="<?php echo base64_encode(Kata_Plus_Pro_Helpers::get_icon('', $settings['inc_owl_prev'], '', '')); ?>"
	data-inc_owl_nxt="<?php echo base64_encode(Kata_Plus_Pro_Helpers::get_icon('', $settings['inc_owl_nxt'], '', '')); ?>"
	data-inc_thumbs="false">
		<?php foreach ($cntsliders as $cntslider) { ?>
			<div class="kata-plus-cntslider <?php echo esc_attr($cntslider['_id']); ?>">
				<div class="inner-content">
					<?php if (empty($cntslider['cntslider_item']) && !empty($cntslider['cntslider_html'])) : ?>
						<div class="custom-html">
							<?php echo wp_kses($cntslider['cntslider_html'], wp_kses_allowed_html('post')); ?>
						</div>
					<?php else : ?>
						<?php
							if( get_page_by_title($cntslider['cntslider_item'], OBJECT, 'elementor_library') ) {
								echo Plugin::instance()->frontend->get_builder_content_for_display(get_page_by_title($cntslider['cntslider_item'], OBJECT, 'elementor_library')->ID);
							} else {
								echo __( 'Please Choose your desired templates for content slider', 'kata-plus');
							}
						?>
						<div class="custom-html">
							<?php echo wp_kses($cntslider['cntslider_html'], wp_kses_allowed_html('post')); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php if ($settings['progress_bar'] == 'true') { ?>
		<div class="kata-owl-progress-bar">
			<div class="kata-progress-bar-inner dbg-color"></div>
		</div>
	<?php } ?>
<?php endif; ?>


<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
