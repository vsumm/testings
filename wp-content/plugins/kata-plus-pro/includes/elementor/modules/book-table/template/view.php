<?php
/**
 * Book Table view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings();

$this->add_inline_editing_attributes( 'bt_txt_p' );

$res_id        = $settings['res_id'];
$people_icon   = $settings['bt_icon_p'];
$people_title  = $settings['bt_txt_p'];
$calendar_icon = $settings['bt_icon_c'];
$time_icon     = $settings['bt_icon_t'];
$bt_txt        = $settings['bt_txt_b'];
$layout        = $settings['layout'];
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
$out = ''; ?>

<div class="kata-book-table">
	<form action="https://www.opentable.com/s?" method="get">
		<div class="kata-plus-book-table <?php echo esc_attr( $layout ); ?>">
			<div class="kata-plus-book-table-input-wrapper kata-plus-book-table-people">
				<span class="placehoder-icon people-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $people_icon, '', '' ); ?></span>
				<input type="number" name="people" min="1" max="100" value="2">
				<span class="people-title elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'bt_txt_p' ); ?>><?php echo wp_kses( $people_title, wp_kses_allowed_html( 'post' ) ); ?></span>
				<div class="updown">
					<span class="numbers num-plus"><?php echo Kata_Plus_Pro_Helpers::get_icon( 'themify', 'plus', '', '' ); ?></span>
					<span class="numbers num-sub"><?php echo Kata_Plus_Pro_Helpers::get_icon( 'themify', 'minus' ); ?></span>
				</div>
			</div>
			<div class="kata-plus-book-table-input-wrapper kata-plus-book-table-date">
				<span class="placehoder-icon calendar-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $calendar_icon, '', '' ); ?></span>
				<input type="text" class="datepicker" placeholder="<?php echo esc_attr__( 'Select Date', 'kata-plus' ); ?>">
				<span class="arrow"><?php echo Kata_Plus_Pro_Helpers::get_icon( 'themify', 'angle-down', '', '' ); ?></span>
			</div>
			<div class="kata-plus-book-table-input-wrapper kata-plus-book-table-time">
				<span class="placehoder-icon time-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $time_icon, '', '' ); ?></span>
				<select name="time">
					<?php
					$inc   = 30 * 60;
					$start = ( strtotime( '00:00:00' ) );
					$end   = ( strtotime( '11:59PM' ) );
					$out   = '';
					for ( $i = $start; $i <= $end; $i += $inc ) {
						$time      = date( 'g:i a', $i );
						$timeValue = date( 'g:ia', $i );
						$default   = '7:00pm';
						$selected  = ( $timeValue == $default ) ? ' selected=selected' : '';
						echo '<option value="' . esc_attr( $timeValue ) . '"' . esc_attr( $selected ) . '>';
						echo (string) $time;
						echo '</option>';
					}
					?>
				</select>
				<span class="arrow"><?php echo Kata_Plus_Pro_Helpers::get_icon( 'themify', 'angle-down', '', '' ); ?></span>
			</div>
			<div class="kata-plus-book-table-input-wrapper kata-plus-book-table-btn">
				<input type="submit" value="<?php echo esc_attr( $bt_txt ); ?>">
			</div>
			<input type="hidden" name="RestaurantID" class="RestaurantID" value="<?php echo esc_attr( $res_id ); ?>">
			<input type="hidden" name="rid" class="rid" value="<?php echo esc_attr( $res_id ); ?>">
			<input type="hidden" name="GeoID" class="GeoID" value="15">
			<input type="hidden" name="txtDateFormat" class="txtDateFormat" value="MM/dd/yyyy">
			<input type="hidden" name="RestaurantReferralID" class="RestaurantReferralID" value="<?php echo esc_attr( $res_id ); ?>">
		</div>
	</form>
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
