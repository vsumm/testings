<?php
/**
 * Food Menu Toggle view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings	= $this->get_settings();
$items		= $settings['fm_items'];


if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

	<div class="kata-plus-food-menu-toggle">
			<div class="left-side-food">
			<?php
			$tab_items = 0;
			if ( $items ) {
				$show_desc	= ( $settings['fm_desc'] == 'yes' ) ? ' hidden' : '';
				$image_size	= $settings['fm_image_size'];
				foreach ( $items as $index => $item ) {
					$tab_items ++;
					$active = $tab_items == 1 ? ' active' : '';
					$fm_name_setting_key     = $this->get_repeater_setting_key( 'fm_name', 'fm_items', $index );
					$fm_txt_setting_key      = $this->get_repeater_setting_key( 'fm_txt', 'fm_items', $index );
					$fm_cs_price_setting_key = $this->get_repeater_setting_key( 'fm_cs_price', 'fm_items', $index );
					$this->add_inline_editing_attributes( $fm_name_setting_key );
					$this->add_inline_editing_attributes( $fm_txt_setting_key );
					$this->add_inline_editing_attributes( $fm_cs_price_setting_key );
					$name   = $item['fm_name'];
					$txt    = $item['fm_txt'];
					$cs_txt = $item['fm_cs_price'];
					$image  = $item['fm_image'];
					?>
						<div class="kata-food-menu<?php echo esc_attr( $active ); ?>" data-item="<?php echo esc_attr( $tab_items ); ?>">							
							<div class="kata-food-menu-btn elementor-inline-editing" <?php echo $this->get_render_attribute_string( $fm_name_setting_key ); ?>><?php echo esc_attr( $name ); ?></div>
							<?php if ( $show_desc ) : ?>
								<div class="kata-food-menu-content">
									<p <?php echo $this->get_render_attribute_string( $fm_txt_setting_key ); ?>><?php echo wp_kses( $txt, wp_kses_allowed_html( 'post' ) ); ?></p>                    
								</div>
							<?php endif; ?>
							<?php							
							if ( $cs_txt ) {
								echo '<span class="kata-food-menu-price elementor-inline-editing" ' . $this->get_render_attribute_string( $fm_cs_price_setting_key ) . '>' . wp_kses( $cs_txt, wp_kses_allowed_html( 'post' ) ) . '<span class="currency-symbol">' . wp_kses( $settings['currency_symbol'], wp_kses_allowed_html( 'post' ) ) . '</span></span>';
							}
							echo '</div>';
					}
				}
			?>
		</div>

		<div class="right-side-food">
			<?php if ( $items ): 
				$tab_item = 0;?>
				<?php foreach ( $items as $item ): 
					$tab_item ++; ?>
					<?php if ( $item['fm_image'] ) : ?>
					<div class="image-content" data-item="<?php echo esc_attr( $tab_item ); ?>">
						<div class="kata-food-menu-image">
							<?php if ( $item['fm_image']['id'] ): ?>
								<?php echo wp_get_attachment_image( $item['fm_image']['id'], $image_size ); ?>
							<?php else: ?>
								<img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/placeholder.png'?>">
							<?php endif; ?>
						</div>
						<div class="image-details">
							<div class="image-title">
								<?php echo esc_html( $item['image_title'] ); ?>
							</div>
							<div class="image-link">
								<?php 								
									$target = ( !empty( $item['image_link']['is_external'] ) ) ? 'target=_blank' : '';
									$nofollow = ( !empty( $item['image_link']['nofollow'] ) ) ? 'rel=nofollow' : '';
								?>
								<a href="<?php echo esc_url( $item['image_link']['url'] );?>" <?php echo esc_attr( $target ); ?> <?php echo esc_attr( $nofollow ); ?>><?php echo esc_html( $item['link_title'] ); ?></a>
							</div>
						</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>	
			<?php endif; ?>
		</div>
	</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
