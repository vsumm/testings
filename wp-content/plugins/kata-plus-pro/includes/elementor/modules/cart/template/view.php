<?php
/**
 * Cart Toggle view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings = $this->get_settings_for_display();
$icon     = $settings['icon'];
$this->add_inline_editing_attributes( 'headercart' );

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>
<div class="kata-plus-cart-wrap">
	<div class="kata-cart-icon-wrap"><span class="count dbg-color"></span><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['icon'], '', '' ); ?></div>
	<div class="kata-plus-cart">
		<div class="cart-items-count count">
			<span class="count"></span>
			<span class="elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'headercart' ); ?>>
				<?php echo wp_kses( $settings['headercart'], wp_kses_allowed_html( 'post' ) ); ?>
			</span>
		</div>
		<div class="widget_shopping_cart_content">
			<?php
			if ( get_post_type() != 'kata_plus_builder' && function_exists('woocommerce_mini_cart') ) {
				woocommerce_mini_cart();
			}
			?>
		</div>
	</div>
</div>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
