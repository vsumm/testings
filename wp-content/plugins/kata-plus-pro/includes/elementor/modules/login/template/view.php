<?php
/**
 * Login module view.
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
$livelogin	= $settings['livelogin'] == 'yes' ? true : false;
$layout		= $settings['layout'] ? $settings['layout'] : '';
$custom_dashboard_link = !empty($settings['custom_dashboard_link']) ? esc_url($settings['custom_dashboard_link']) : '';
$custom_profile_link = !empty($settings['custom_profile_link']) ? esc_url($settings['custom_profile_link']) : '';
$settings['text'] = ! is_user_logged_in() ? $settings['text'] : $settings['welcom_text'];
$user_data = wp_get_current_user();
$have_username = Kata_Plus_Helpers::string_is_contain( $settings['text'], '{{username}}' );
$settings['text'] = $have_username ? str_replace( '{{username}}', $user_data->data->user_nicename, $settings['text'] ) : $settings['text'];
switch ($layout) {
	case 'modal':
		?>
		<div class="kt-login-open-as <?php echo esc_attr( $layout ); ?>">
			<a href="#" class="kt-toggle-wrapper kata-lazyload">
				<?php
				if ($settings['toggleplaceholder']) :
					switch ($settings['toggleplaceholder']) {
						case 'image':
							if ($settings['image']['id']) {
								if (Kata_Plus_Pro_Helpers::string_is_contain($settings['image']['url'], 'svg')) {
									$svg_size = '';
									if( isset( $settings['image_custom_dimension']['width'] ) || isset( $settings['image_custom_dimension']['height'] ) ) {
										$svg_size = Kata_Plus_Pro_Helpers::svg_resize($settings['image_size'], $settings['image_custom_dimension']['width'], $settings['image_custom_dimension']['height']);
									}
									Kata_Plus_Pro_Helpers::get_attachment_svg_path($settings['image']['id'], $settings['image']['url'], $svg_size);
								} else {
									echo Kata_Plus_Pro_Helpers::get_attachment_image_html($settings);
								}
							}
							break;

						case 'icon':
						default:
							echo Kata_Plus_Pro_Helpers::get_icon('', $settings['placeholder_icon'], '', '');
							break;
					}
				endif; 
				echo '<span class="kt-login-toggle-text">' . wp_kses($settings['text'], wp_kses_allowed_html('post')) . '</span>';
				?>
			</a>
			<div class="kt-login-wrapper"><?php Kata_Plus_Frontend::login( $livelogin , $custom_dashboard_link , $custom_profile_link); ?></div>
			<div class="kt-login-overlay" style="display:none;"></div>
			<div class="kt-close-overlay" style="display:none;"><a href="#" class="kt-close-login-modal"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', 'themify/close' ); ?></a></div>
		</div>
		<?php
	break;
	case 'toggle':
		?>
			<div class="kata-plus-content-toggle">
				<a href="#" class="kata-plus-content-toggle-click">
					<div class="kt-login-open-as kata-lazyload">
						<?php
						if ($settings['toggleplaceholder']) :
							switch ($settings['toggleplaceholder']) {
								case 'image':
									if ($settings['image']['id']) {
										if (Kata_Plus_Pro_Helpers::string_is_contain($settings['image']['url'], 'svg')) {
											$svg_size = '';
											if( isset( $settings['image_custom_dimension']['width'] ) || isset( $settings['image_custom_dimension']['height'] ) ) {
												$svg_size = Kata_Plus_Pro_Helpers::svg_resize($settings['image_size'], $settings['image_custom_dimension']['width'], $settings['image_custom_dimension']['height']);
											}
											Kata_Plus_Pro_Helpers::get_attachment_svg_path($settings['image']['id'], $settings['image']['url'], $svg_size);
										} else {
											echo Kata_Plus_Pro_Helpers::get_attachment_image_html($settings);
										}
									}
									break;

								case 'icon':
								default:
									echo Kata_Plus_Pro_Helpers::get_icon('', $settings['placeholder_icon'], '', '');
									break;
							}
						endif;
						echo '<span class="kt-login-toggle-text">' . wp_kses_post( $settings['text'] ) . '</span>';
						?>
					</div>
				</a>
				<?php Kata_Plus_Frontend::login( $livelogin , $custom_dashboard_link , $custom_profile_link, 'kata-plus-content-toggle-content-wrap' ); ?>
			</div>
		<?php
	break;

	default:
		Kata_Plus_Frontend::login( $livelogin , $custom_dashboard_link , $custom_profile_link);
		break;
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
