<?php
/**
* Fast mode Template 2
* @author  ClimaxThemes
* @package Kata Plus
* @since   1.0.0
*/
$kata_options = get_option( 'kata_options' )['fast-mode'];
$address = isset( $kata_options['site-address'] ) && ! empty( $kata_options['site-address'] ) ? $kata_options['site-address'] : '37 Wintergreen Ave. White Rock, BC V4B 0V6';
$phone   = isset( $kata_options['site-phone'] ) && ! empty( $kata_options['site-phone'] ) ? $kata_options['site-phone'] : '+123456789';
?>

<div id="kt-fst-mod-5" class="kt-fst-mod-wrapper">
	<h1 id="page-title" class="chose-bussiness-type"><?php echo esc_html__( 'Contact Information', 'kata-plus' ); ?></h1>
	<div class="kt-fst-mod-inner-wrapper">
		<div class="kt-fst-get-info-row">
			<div class="kt-fst-get-info">
				<label for="site-address"><?php echo esc_html__( 'Address', 'kata-plus' ) ?></label>
				<input type="text" id="site-address" value="<?php echo esc_attr( $address ); ?>">
			</div>
			<div class="kt-fst-get-info">
				<label for="site-phone"><?php echo esc_html__( 'Phone', 'kata-plus' ) ?></label>
				<input type="text" id="site-phone" value="<?php echo esc_attr( $phone ); ?>">
            </div>
			<div class="kt-fst-get-info full-width">
                <label for="site-socials"><?php echo esc_html__( 'Socials', 'kata-plus' ) ?></label>
                <div class="kt-social-field-group">
                    <input type="text" id="site-socials" class="site-socials" placeholder="<?php echo esc_attr('https://instagram.com/katademos') ?>" value="">
                </div>
                <div class="kt-social-field-add"><?php echo Kata_Plus_Helpers::get_icon( '', 'eicons/plus', '', '' ); ?></div>
                <div class="kt-social-field-minus"><?php echo Kata_Plus_Helpers::get_icon( '', 'font-awesome/minus3', '', '' ); ?></div>
			</div>
		</div>
	</div>
</div>
<div class="kt-fst-mod-footer-area kt-fst-mod-5">
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=4' ) );?>" class="prev-step"><?php echo Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-left', '', '' ) . __( 'Back', 'kata-plus'); ?></a>
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=6&site-phone=' . $phone . '&site-address=' . $address . '/' ) );?>" class="next-step"><?php echo __( 'Next', 'kata-plus') . Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-right', '', '' ); ?></a>
</div>
