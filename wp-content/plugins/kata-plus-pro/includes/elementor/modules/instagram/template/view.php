<?php
/**
 * Instagram module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings   = $this->get_settings();
$element_id = $this->get_id();

$posts			= $owl_class = $carousel_data = $like_comments = '';
$overlay		= ( $settings['overlay_active'] == 'show' ) ? '<div class="kata-instagram-overlay"></div>' : '';
$icon			= ( $settings['custom_icon'] == 'show' && ! empty( $settings['icon'] ) ) ? '<div class="instagram-ci-sec">' . Kata_Plus_Pro_Helpers::get_icon( '', $settings['icon'], '', '' ) . '</div>' : '';
$access_token	= $settings['access_token'];
$path			= Kata_Plus_Pro::$upload_dir . '/instagram/' . $access_token;
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if( $access_token ) {
	// get media data
	$media_data = json_decode( Kata_Plus_Pro_Instagram_API::get_media_data( $access_token ) );
	if ( isset( $media_data->error->message ) ) {
		echo '<h3>' . $media_data->error->message . '</h3>';
		return;
	}
	if ( $settings['update_images'] == 'update' || ( ! file_exists( $path ) && ! file_exists( $path . '/instagram-1.jpg' ) ) ) {
		Kata_Plus_Pro_Helpers::rmdir($path);
		Kata_Plus_Pro_Helpers::mkdir($path);
		$i = 0;
		// save settings
		Kata_Plus_Pro_Helpers::wrfile($path . '\settings.json', json_encode($media_data));

		foreach( $media_data->data as $value ) {
			++$i;
			if (!file_exists(Kata_Plus_Pro::$upload_dir . '/instagram')) {
				mkdir(Kata_Plus_Pro::$upload_dir . '/instagram', 0777);
			}
			if (file_exists(Kata_Plus_Pro::$upload_dir . '/instagram')) {
				if (!function_exists('download_url')) {
					require_once ABSPATH . 'wp-admin/includes/file.php';
				}

				// Now you can use it!
				if( $settings['hashtag'] ) {
					if( Kata_Plus_Pro_Helpers::string_is_contain( $value->caption, $settings['hashtag'] ) ) {
						$tmp_file = download_url( $value->media_url );
					}
				} else {
					$tmp_file = download_url( $value->media_url );
				}


				// Sets file final destination.
				$filepath = $path . '/instagram-' . $i . '.jpg';

				// Copies the file to the final destination and deletes temporary file.
				copy($tmp_file, $filepath);
				@unlink($tmp_file);

				if ( $i >= $settings['post_count'] ) {
					break;
				}
			}
		}
	}

	$insta_path_url = Kata_Plus_Pro::$upload_dir_url . '/instagram/' . $access_token;
	$insta_path_dir = Kata_Plus_Pro::$upload_dir . '/instagram/' . $access_token;
	$insta_settings = json_decode(Kata_Plus_Pro_Helpers::rfile($path . '\settings.json'));
	$insta_settings = isset( $insta_settings->data ) ? $insta_settings->data : '';
	if ( $insta_settings ) {
		for ( $j = 1; $j <= sizeof( $insta_settings ); ++$j ) {
			if( file_exists( $insta_path_dir . '/instagram-' . $j . '.jpg' ) ) {
				$posts       .= '<li class="instagram-column' . esc_attr( $settings['column'] . ' instagram-column-tablet-' . $settings['column_tablet'] . ' instagram-column-mobile-' . $settings['column_mobile'] ) . '">';
				$target_blank = ($settings['target_blank'] == 'on') ? ' target="_blank"' : '';
				if ( $settings['link_to_post'] == 'on' && isset( $insta_settings[$j]->caption ) ) {
					$posts .= '<a href="' . esc_url($insta_settings[$j]->permalink) . ' "' . esc_attr($target_blank) . '>';
				}
				$caption	= $settings['show_description'] == 'show' && isset( $insta_settings[$j]->caption ) ? '<p class="instagram-description-sec">' . $insta_settings[$j]->caption . '</p>' : '';
				$alt		= $settings['show_description'] == 'show' && isset( $insta_settings[$j]->caption ) ? 'alt=' . esc_attr($insta_settings[$j]->caption) . '' : 'alt';
				$posts .= '<img src="' . esc_url($insta_path_url . '/instagram-' . $j . '.jpg') . '" ' . esc_attr($alt) . '> ' . wp_kses_post( $overlay ) . wp_kses_post( $icon ) . wp_kses_post( $caption );
				if ($settings['link_to_post'] == 'on' && isset( $insta_settings[$j]->caption )) {
					$posts .= '</a>';
				}
				$posts .= '</li>';
			}
	
			if ($j >= $settings['post_count']) {
				break;
			}
		}
	}
	$owl_classe = '';
	$classes    = $settings['inc_owl_pag_num'] == 'true' ? 'dots-num' : '';
	if ($settings['carousel'] == 'on') {
		$owl_classe = ' carousel-type';
		$dots       = $settings['inc_owl_pag_num'] == 'true' ? ' dots-num' : '';
		$owl_class  = ' class="kata-owl owl-carousel owl-theme' . $dots . '" ';
		// Carousel Settings
		$settings['inc_owl_arrow']                 = $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
		$settings['inc_owl_pag']                   = $settings['inc_owl_pag'] == 'true' ? 'true' : 'false';
		$settings['inc_owl_loop']                  = $settings['inc_owl_loop'] == 'true' ? 'true' : 'false';
		$settings['inc_owl_autoplay']              = $settings['inc_owl_autoplay'] == 'true' ? 'true' : 'false';
		$settings['inc_owl_center']                = $settings['inc_owl_center'] == 'true' ? 'true' : 'false';
		$settings['inc_owl_vert']                  = $settings['inc_owl_vert'] == 'true' ? 'true' : 'false';
		$animateout                                = $settings['inc_owl_vert'] == 'true' ? 'fadeOutUp' : '';
		$animatein                                 = $settings['inc_owl_vert'] == 'true' ? 'fadeInUp' : '';
		$settings['inc_owl_rtl']                   = $settings['inc_owl_rtl'] == 'true' ? 'true' : 'false';
		$settings['inc_owl_item_tablet']           = $settings['inc_owl_item_tablet'] ? $settings['inc_owl_item_tablet'] : '2';
		$settings['inc_owl_item_mobile']           = $settings['inc_owl_item_mobile'] ? $settings['inc_owl_item_mobile'] : '1';
		$settings['inc_owl_stgpad_tablet']['size'] = $settings['inc_owl_stgpad_tablet']['size'] ? $settings['inc_owl_stgpad_tablet']['size'] : '0';
		$settings['inc_owl_stgpad_mobile']['size'] = $settings['inc_owl_stgpad_mobile']['size'] ? $settings['inc_owl_stgpad_mobile']['size'] : '0';
		$settings['inc_owl_margin_tablet']['size'] = $settings['inc_owl_margin_tablet']['size'] ? $settings['inc_owl_margin_tablet']['size'] : '0';
		$settings['inc_owl_margin_mobile']['size'] = $settings['inc_owl_margin_mobile']['size'] ? $settings['inc_owl_margin_mobile']['size'] : '0';
		$slide_speed                               = $settings['inc_owl_spd']['size'];
		$carousel_data                             = '
			data-inc_owl_item="' . esc_attr($settings['inc_owl_item']) . '"
			data-inc_owl_itemtab="' . esc_attr($settings['inc_owl_item_tablet']) . '"
			data-inc_owl_itemmob="' . esc_attr($settings['inc_owl_item_mobile']) . '"
			data-inc_owl_spd="' . esc_attr($slide_speed) . '"
			data-inc_owl_smspd="' . esc_attr($settings['inc_owl_smspd']['size']) . '"
			data-inc_owl_stgpad="' . esc_attr($settings['inc_owl_stgpad']['size']) . '"
			data-inc_owl_stgpadtab="' . esc_attr($settings['inc_owl_stgpad_tablet']['size']) . '"
			data-inc_owl_stgpadmob="' . esc_attr($settings['inc_owl_stgpad_mobile']['size']) . '"
			data-inc_owl_margin="' . esc_attr($settings['inc_owl_margin']['size']) . '"
			data-inc_owl_margintab="' . esc_attr($settings['inc_owl_margin_tablet']['size']) . '"
			data-inc_owl_marginmob="' . esc_attr($settings['inc_owl_margin_mobile']['size']) . '"
			data-inc_owl_arrow="' . esc_attr($settings['inc_owl_arrow']) . '"
			data-inc_owl_pag="' . esc_attr($settings['inc_owl_pag']) . '"
			data-inc_owl_loop="' . esc_attr($settings['inc_owl_loop']) . '"
			data-inc_owl_autoplay="' . esc_attr($settings['inc_owl_autoplay']) . '"
			data-inc_owl_center="' . esc_attr($settings['inc_owl_center']) . '"
			data-animatein="' . esc_attr($animatein) . '"
			data-animateout="' . esc_attr($animateout) . '"
			data-inc_owl_prev="' . base64_encode(Kata_Plus_Pro_Helpers::get_icon('', $settings['inc_owl_prev'], '', '')) . '"
			data-inc_owl_nxt="' . base64_encode(Kata_Plus_Pro_Helpers::get_icon('', $settings['inc_owl_nxt'], '', '')) . '"
			data-inc_owl_rtl="' . esc_attr($settings['inc_owl_rtl']) . '"';
	}
	echo '
	<div class="kata-instagram ' . esc_attr($classes . ' ' . $owl_classe) . '" id="' . esc_attr($element_id) . '">
		<ul' . $owl_class . $carousel_data . '>' . $posts . '</ul>
	</div>';

}

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}