<?php
/**
* Fast mode Template 3
* @author  ClimaxThemes
* @package Kata Plus
* @since   1.0.0
*/

require_once ABSPATH . '/wp-admin/includes/translation-install.php';
$kata_options = get_option( 'kata_options' )['fast-mode'];
$logo = isset( $kata_options['site-logo'] ) && ! empty( $kata_options['site-logo'] ) ? 'style="background-image: url(' . wp_get_attachment_url( $kata_options['site-logo'] ) . ');"' : '';
$logo_id = isset( $kata_options['site-logo'] ) && ! empty( $kata_options['site-logo'] ) ? $kata_options['site-logo'] : '';
$icon = isset( $kata_options['site-icon'] ) && ! empty( $kata_options['site-icon'] ) ? 'style="background-image: url(' . wp_get_attachment_url( $kata_options['site-icon'] ) . ');"' : '';
$icon_id = isset( $kata_options['site-icon'] ) && ! empty( $kata_options['site-icon'] ) ? $kata_options['site-icon'] : '';
?>

<div id="kt-fst-mod-3" class="kt-fst-mod-wrapper">
	<h1 id="page-title" class="chose-bussiness-type"><?php echo esc_html__( 'Logo & Icon', 'kata-plus' ); ?></h1>
	<div class="kt-fst-mod-inner-wrapper">
		<div class="kt-fst-get-info-row">
			<div class="kt-fst-get-info site-logo-icon site-icon">
				<p><?php echo esc_html__( 'Site Icon', 'kata-plus' ); ?></p>
				<div class="image-place-holder" <?php echo $icon ?>></div>
				<a href="#" class="change-image" data-frame-title="<?php echo esc_attr( 'Upload Site Icon', 'kata-plus' ); ?>" data-insert-title="<?php echo esc_attr( 'Set as site icon', 'kata-plus' ); ?>"><?php echo esc_html__( 'Change', 'kata-plus' ); ?></a>
                <i><?php echo esc_html__( 'Site Icons should be square.', 'kata-plus' ); ?></i>
                <i><?php echo esc_html__( 'Recommended size: 512 × 512 pixels.', 'kata-plus' ); ?></i>
			</div>
			<div class="kt-fst-get-info site-logo-icon site-logo">
				<p><?php echo esc_html__( 'Logo', 'kata-plus' ); ?></p>
				<div class="image-place-holder" <?php echo $logo ?>></div>
				<a href="#" class="change-image" data-frame-title="<?php echo esc_attr( 'Upload Logo', 'kata-plus' ); ?>" data-insert-title="<?php echo esc_attr( 'Set as site logo', 'kata-plus' ); ?>"><?php echo esc_html__( 'Change', 'kata-plus' ); ?></a>
			</div>
		</div>
	</div>
</div>
<div class="kt-fst-mod-footer-area kt-fst-mod-3">
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=2' ) );?>" class="prev-step"><?php echo Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-left', '', '' ) . __( 'Back', 'kata-plus'); ?></a>
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=4&site-icon=' . $icon_id . '&site-logo=' . $logo_id . '/' ) );?>" class="next-step"><?php echo __( 'Next', 'kata-plus') . Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-right', '', '' ); ?></a>
</div>
