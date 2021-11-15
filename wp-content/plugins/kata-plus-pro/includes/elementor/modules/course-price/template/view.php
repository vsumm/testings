<?php
/**
 * Date module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings	= $this->get_settings_for_display();
$price		= get_post_meta( Kata_Plus_Pro_Helpers::get_latest_course_id(), '_lp_price', true );
$sale_price	= get_post_meta( Kata_Plus_Pro_Helpers::get_latest_course_id(), '_lp_sale_price', true );
$sale_price	= $settings['title'];
$symbol   	= $settings['symbol'];
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-plus-course-price">
	<?php if ( $symbol ) { ?>
		<div class="kata-plus-course-price-icon-wrap kata-lazyload <?php echo esc_attr( $symbol ); ?>">
			<?php
			if ( ! empty( $settings['course_price_icon'] ) && $symbol == 'icon' ) {
				echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['course_price_icon'], '', '' );
			} elseif ( isset($settings['course_price_image']['url']) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_price_image']['url'], 'svg' ) && $symbol == 'imagei' ) {
				echo Kata_Plus_Pro_Helpers::get_image_srcset( $settings['course_price_image']['id'], 'full' );
			} elseif ( ! empty( $settings['course_price_image']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_price_image']['url'], 'svg' ) && $symbol == 'imagei' ) {
				echo Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'course_price_image' );
			} elseif ( ! empty( $settings['course_price_image']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['course_price_image']['url'], 'svg' ) && $symbol == 'svg' ) {
				$svg_size = '';
				if ( isset( $settings['course_price_image_custom_dimension']['width'] ) || isset( $settings['course_price_image_custom_dimension']['height'] ) ) {
					$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['course_price_image_size'], $settings['course_price_image_custom_dimension']['width'], $settings['course_price_image_custom_dimension']['height'] );
				}
				Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['course_price_image']['id'], $settings['course_price_image']['url'], $svg_size );
			}
			?>
		</div>
	<?php } ?>
	<?php if( $sale_price ): ?>
		<h5 class="price-title"><?php echo esc_html( $sale_price ); ?></h5>
	<?php endif; ?>
	<div class="course-price">
		<?php if( $sale_price ) : ?>
			<span class="sale-price"><?php echo learn_press_format_price( $sale_price, true ); ?></span>
		<?php endif; ?>
		<span class="origin-price"><?php echo learn_press_format_price( $price, true ); ?></span>
	</div>
<div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
