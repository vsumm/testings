<?php
/**
 * Food Menu view.
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
$items		= $settings['fm_items'];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
?>
<div class="kata-food-menu-wrap" id="<?php echo( $this->get_id() ); ?>">
<?php
if ( $items ) {
	$accordion             = ( $settings['fm_accordion'] == 'yes' ) ? 'true' : 'false';
	$classes               = ( $settings['fm_accordion'] == 'yes' ) ? ' hidden' : '';
	$kata_accordion_open   = ( $settings['fm_stays_open'] == 'yes' ) ? ' kata-accordion-open' : '';
	$show_desc             = ( $settings['fm_desc'] == 'yes' ) ? ' hidden' : '';
	$image_size            = $settings['fm_image_size'];
	foreach ( $items as $index => $item ) {
		$fm_name_setting_key     = $this->get_repeater_setting_key( 'fm_name', 'fm_items', $index );
		$fm_txt_setting_key      = $this->get_repeater_setting_key( 'fm_txt', 'fm_items', $index );
		$fm_cs_price_setting_key = $this->get_repeater_setting_key( 'fm_cs_price', 'fm_items', $index );
		$fm_cs_badge_setting_key = $this->get_repeater_setting_key( 'fm_cs_badge', 'fm_items', $index );
		$this->add_inline_editing_attributes( $fm_name_setting_key );
		$this->add_inline_editing_attributes( $fm_txt_setting_key );
		$this->add_inline_editing_attributes( $fm_cs_price_setting_key );
		$oicon  = 'font-awesome/minus3';
		$cicon  = 'font-awesome/plus2';
		$name   = $item['fm_name'];
		$txt    = $item['fm_txt'];
		$cs_txt = $item['fm_cs_price'];
		$fm_cs_badge = $item['fm_cs_badge'];
		$image  = $item['fm_image'];
		?>
			<div class="kata-food-menu" data-accordion="<?php echo $accordion; ?>">
				<?php if ( $image ) : ?>
					<div class="kata-food-menu-image"><?php echo wp_get_attachment_image( $image['id'], $image_size ); ?></div>
				<?php endif; ?>
				<div class="kata-food-menu-btn elementor-inline-editing" data-cicon="<?php echo $cicon; ?>" data-oicon="<?php echo $oicon; ?>" <?php echo $this->get_render_attribute_string( $fm_name_setting_key ); ?>><?php echo esc_attr( $name ); ?>
				<?php
				if ( $accordion == 'true' && $show_desc ) {
					$_icon = ( $kata_accordion_open != '' ) ? $oicon : $cicon;
					echo Kata_Plus_Pro_Helpers::get_icon( '', $_icon, '', '' );
				}
				?>
				</div>
				<?php if ( $show_desc ) : ?>
					<div class="kata-food-menu-content
					<?php
					echo ( $kata_accordion_open != '' ) ? $kata_accordion_open : $classes;
					$kata_accordion_open = '';
					?>
					">
						<p <?php echo $this->get_render_attribute_string( $fm_txt_setting_key ); ?>><?php echo wp_kses( $txt, wp_kses_allowed_html( 'post' ) ); ?></p>                    
					</div>
				<?php endif; ?>
				<?php
				if ( $cs_txt ) {
					echo '<span class="kata-food-menu-price elementor-inline-editing" ' . $this->get_render_attribute_string( $fm_cs_price_setting_key ) . '>' . wp_kses( $cs_txt, wp_kses_allowed_html( 'post' ) ) . '<span class="currency-symbol">' . wp_kses( $settings['currency_symbol'], wp_kses_allowed_html( 'post' ) ) . '</span></span>';
				}
				if ( $fm_cs_badge ) {
					echo '<span class="kata-food-menu-badge elementor-inline-editing" ' . $this->get_render_attribute_string( $fm_cs_price_setting_key ) . '>' . wp_kses( $fm_cs_badge, wp_kses_allowed_html( 'post' ) ) . '</span>';
				}
				?>

			<?php foreach ( $settings['fm_item_elements'] as $element ) : ?>
				<div class="elementor-repeater-item-<?php echo esc_attr( $element['_id'] ); ?>"></div>
			<?php endforeach ?>

			<?php foreach ( $settings['fm_item_icons'] as $icon ) : ?>
				<?php if ( $icon['fm_icon'] ) : ?>            
					<?php if ( $icon['fm_has_link'] == 'yes' ) : ?>
						<?php $url = Kata_Plus_Pro_Helpers::get_link_attr( $icon['fm_link'] ); ?>
						<a href="<?php echo esc_url( $url->src, Kata_Plus_Pro_Helpers::ssl_url() ); ?>" class="kata-plus-food-menu-item-icon" <?php echo $url->rel . $url->target; ?>>
							<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $icon['fm_icon'], 'elementor-repeater-item-' . esc_attr( $icon['_id'] ), 'data-item-id="' . isset( $icon['styler_item_icon']['citem'] ) ? esc_attr( $icon['styler_item_icon']['citem'] ) : '' . '"' ); ?>
						</a>
					<?php else : ?>
						<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $icon['fm_icon'], 'kata-plus-food-menu-item-icon elementor-repeater-item-' . esc_attr( $icon['_id'] ), 'data-item-id="' . isset( $icon['styler_item_icon']['citem'] ) ? esc_attr( $icon['styler_item_icon']['citem'] ) : '' . '"' ); ?>
					<?php endif ?>
				<?php endif; ?>
			<?php endforeach ?>

			<div class="clearfix"></div>
			</div>
		<?php
	}
}
?>
<div class="clearfix"></div>
</div>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
