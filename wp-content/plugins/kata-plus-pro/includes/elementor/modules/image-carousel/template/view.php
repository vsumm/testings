<?php
/**
 * Image Carousel module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

use Elementor\Group_Control_Image_Size;

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings                          	= $this->get_settings();
$settings['inc_owl_arrow']         	= $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
$settings['inc_owl_pag']           	= $settings['inc_owl_pag'] == 'true' && $settings['inc_owl_pag_num'] != 'dots-and-num' ? 'true' : 'false';
$settings['inc_owl_loop']          	= $settings['inc_owl_loop'] == 'true' ? 'true' : 'false';
$settings['inc_owl_autoplay']      	= $settings['inc_owl_autoplay'] == 'true' ? 'true' : 'false';
$settings['inc_owl_center']        	= $settings['inc_owl_center'] == 'true' ? 'true' : 'false';
$settings['inc_owl_vert']          	= $settings['inc_owl_vert'] == 'true' ? 'true' : 'false';
$settings['inc_owl_rtl']           	= $settings['inc_owl_rtl'] == 'true' ? 'true' : 'false';
$animateout                        	= $settings['inc_owl_vert'] == 'true' ? 'fadeOutUp' : '';
$animatein                         	= $settings['inc_owl_vert'] == 'true' ? 'fadeInUp' : '';
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
$settings['inc_owl_stgpad_tablet'] 	= $settings['inc_owl_stgpad_tablet'] ? $settings['inc_owl_stgpad_tablet'] : '0';
$settings['inc_owl_stgpad_mobile'] 	= $settings['inc_owl_stgpad_mobile'] ? $settings['inc_owl_stgpad_mobile'] : '0';
$settings['inc_owl_margin_tablet'] 	= $settings['inc_owl_margin_tablet'] ? $settings['inc_owl_margin_tablet'] : '0';
$settings['inc_owl_margin_mobile'] 	= $settings['inc_owl_margin_mobile'] ? $settings['inc_owl_margin_mobile'] : '0';
$settings['inc_owl_thumbnail']		= $settings['inc_owl_thumbnail'] == 'true' ? ' data-inc_thumbs=' . $settings['inc_owl_thumbnail'] . ' data-inc_thumbimage=true data-inc_thumbContainerClass=owl-thumbs data-inc_thumbItemClass=owl-thumb-item' : '';
$uniqid								= uniqid();
$classes                           	= $settings['inc_owl_pag_num'];
$classes                          .= $settings['kata_plus_grid_show_modal'] == 'yes' ? ' lightgallery' : '';
$classes                          .= $settings['kata_plus_stairs_carousel'] == 'yes' ? ' kata-stairs-carousel' : '';
$classes                          .= $settings['kata_plus_stairs_carousel'] == 'yes' ? $settings['stairs_style']: '';
$gallery                           = $settings['gallery'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if ( $gallery ) { ?>
	<div class="kata-image-carousel kata-owl owl-carousel owl-theme <?php echo esc_attr( $classes ); ?>"
	data-inc_owl_item="<?php echo $settings['kata_plus_stairs_carousel'] != 'yes' ? esc_attr( $settings['inc_owl_item'] ) : '2'; ?>"
	data-inc_owl_item_tab_landescape="<?php echo $settings['kata_plus_stairs_carousel'] != 'yes' ? esc_attr( $settings['inc_owl_item_tab_landescape'] ) : '2'; ?>"
	data-inc_owl_itemtab="<?php echo $settings['kata_plus_stairs_carousel'] != 'yes' ? esc_attr( $settings['inc_owl_item_tablet'] ) : '1'; ?>"
	data-inc_owl_itemmob="<?php echo $settings['kata_plus_stairs_carousel'] != 'yes' ? esc_attr( $settings['inc_owl_item_mobile'] ) : '1'; ?>"
	data-inc_owl_spd="<?php echo esc_attr( $settings['inc_owl_spd'] ); ?>"
	data-inc_owl_smspd="<?php echo esc_attr( $settings['inc_owl_smspd'] ); ?>"
	data-inc_owl_stgpad="<?php echo esc_attr( $settings['inc_owl_stgpad'] ); ?>"
	data-inc_owl_stgpadtab="<?php echo esc_attr( $settings['inc_owl_stgpad_tablet'] ); ?>"
	data-inc_owl_stgpadmob="<?php echo esc_attr( $settings['inc_owl_stgpad_mobile'] ); ?>"
	data-inc_owl_margin="<?php echo esc_attr( $settings['inc_owl_margin'] ); ?>"
	data-inc_owl_margintab="<?php echo esc_attr( $settings['inc_owl_margin_tablet'] ); ?>"
	data-inc_owl_marginmob="<?php echo esc_attr( $settings['inc_owl_margin_mobile'] ); ?>"
	data-inc_owl_arrow="<?php echo esc_attr( $settings['inc_owl_arrow'] ); ?>"
	data-inc_owl_pag="<?php echo esc_attr( $settings['inc_owl_pag'] ); ?>"
	data-inc_owl_loop="<?php echo esc_attr( $settings['inc_owl_loop'] ); ?>"
	data-inc_owl_autoplay="<?php echo esc_attr( $settings['inc_owl_autoplay'] ); ?>"
	data-inc_owl_center="<?php echo $settings['kata_plus_stairs_carousel'] != 'yes' ? esc_attr( $settings['inc_owl_center'] ) : true; ?>"
	data-animatein="<?php echo esc_attr( $animatein ); ?>"
	data-animateout="<?php echo esc_attr( $animateout ); ?>"
	data-inc_owl_prev="<?php echo base64_encode( Kata_Plus_Pro_Helpers::get_icon( '', $settings['inc_owl_prev'], '', '' ) ); ?>"
	data-inc_owl_nxt="<?php echo base64_encode( Kata_Plus_Pro_Helpers::get_icon( '', $settings['inc_owl_nxt'], '', '' ) ); ?>"
	data-inc_owl_rtl="<?php echo esc_attr( $settings['inc_owl_rtl'] ); ?>"
	<?php echo ' ' . esc_attr( $settings['inc_owl_thumbnail'] ) . ' '; ?>
	data-slider-id="<?php echo esc_attr($uniqid); ?>">
		<?php foreach ( $gallery as $image ) : ?>
			<div class="kata-image-carousel-img" data-src="<?php echo esc_attr( $image['url'] ); ?>">
				<figure>
					<img class="kata-image-carousel-single-image" src="<?php echo Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumbnail', $settings ); ?>" data-thumb-size="<?php echo Kata_Plus_Pro_Helpers::image_resize( $image['id'], [ $settings['thumbs_size']['width'], $settings['thumbs_size']['height'] ] ) ?>" alt="<?php echo esc_attr( get_post_meta( $image['id'], '_wp_attachment_image_alt', true ) ); ?>">
					<?php if (wp_get_attachment_caption( $image['id'] )) { ?>
					<figcaption><?php echo wp_get_attachment_caption( $image['id'] ); ?></figcaption>
					<?php } ?>
				</figure>
				<?php foreach ( $settings['carousel_posts_elements'] as $element ) : ?>
					<div class="elementor-repeater-item-<?php echo esc_attr( $element['_id'] ); ?>" data-item-id="<?php echo isset( $element['styler_carousel_nav_post_element']['citem'] ) ? esc_attr( $element['styler_carousel_nav_post_element']['citem'] ) : ''; ?>"></div>
				<?php endforeach ?>
				<?php foreach ( $settings['carousel_posts_icons'] as $icon ) : ?>
					<?php if ( $icon['carousel_post_icon'] ) : ?>
						<?php if ( $icon['carousel_post_has_link'] == 'yes' ) : ?>
							<?php $url = Kata_Plus_Pro_Helpers::get_link_attr( $icon['carousel_post_link'] ); ?>
							<a href="<?php echo esc_url( $url->src, Kata_Plus_Pro_Helpers::ssl_url() ); ?>" class="kata-plus-carousel-post-icon" <?php echo $url->rel . $url->target; ?>><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $icon['carousel_post_icon'], 'elementor-repeater-item-' . esc_attr( $icon['_id'] ), '' ); ?></a>
						<?php else : ?>
							<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $icon['carousel_post_icon'], 'kata-plus-carousel-post-icon elementor-repeater-item-' . esc_attr( $icon['_id'] ), 'data-item-id="' . isset( $icon['styler_carousel_nav_post_icon']['citem'] ) ? esc_attr( $icon['styler_carousel_nav_post_icon']['citem'] ) : '' . '"' ); ?>
						<?php endif ?>
					<?php endif; ?>
				<?php endforeach ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if ( $settings['inc_owl_pag_num'] == 'dots-and-num') { ?>
		<div class="kata-owl-progress-bar"><div class="kata-progress-bar-inner dbg-color"></div></div>
	<?php } ?>
<?php
}
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
