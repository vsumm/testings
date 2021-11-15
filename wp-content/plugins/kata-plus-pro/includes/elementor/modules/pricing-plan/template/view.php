<?php
/**
 * Pricing Plan module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;

$settings	= $this->get_settings_for_display();
$this->add_inline_editing_attributes( 'pricing_plan_subtitle' );
$this->add_inline_editing_attributes( 'pricing_plan_price' );
$this->add_inline_editing_attributes( 'pricing_plan_currency' );
$this->add_inline_editing_attributes( 'pricing_plan_desc' );
$this->add_inline_editing_attributes( 'pricing_plan_button_text' );

$space    	= ' ';
$price    	= $settings['pricing_plan_price'];
$currency	= $settings['pricing_plan_currency'];
$title    	= $settings['pricing_plan_title'];
$subtitle 	= $settings['pricing_plan_subtitle'];
$desc     	= $settings['pricing_plan_desc'];
$icon_type	= $settings['pricing_plan_icon_type'];
$url      	= Kata_Plus_Pro_Helpers::get_link_attr( $settings['pricing_plan_link'] );


if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<?php if ( $title || $desc ) : ?>
	<?php if ( ! empty ( $url->src ) && $settings['pricing_plan_button'] !== 'yes' ) { ?>
		<a href="<?php echo esc_url( $settings['pricing_plan_link']['url'], Kata_Plus_Pro_Helpers::ssl_url() ); ?>" <?php echo $url->rel . '  ' . $url->target; ?>>
	<?php } ?>
		<div class="kata-plus-pricing-plan">
			<?php if ( $title || $subtitle || $desc || $price ) { ?>
				<div class="kata-plus-pricing-plan-cntt">
					<?php if ( ! empty( $settings['image']['url'] ) || ! empty( $settings['pricing_plan_icon'] ) ) { ?>
						<!-- icon -->
						<div class="kata-plus-pricing-plan-icon-wrap kata-lazyload <?php echo esc_attr( $icon_type ); ?>">
							<?php
							if ( ! empty( $settings['pricing_plan_icon'] ) && $icon_type == 'simplei' ) {
								echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['pricing_plan_icon'], 'pricing-plan-item-icon', '' );
							} elseif ( isset( $settings['image']['url'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['image']['url'], 'svg' ) && $icon_type == 'imagei' ) {
								echo Kata_Plus_Pro_Helpers::get_image_srcset( $settings['image']['id'], 'full' );
							} elseif ( ! empty( $settings['image']['id'] ) && ! Kata_Plus_Pro_Helpers::string_is_contain( $settings['image']['url'], 'svg' ) && $icon_type == 'imagei' ) {
								echo '<div class="pricing-plan-item-image kata-lazyload">';
								echo Kata_Plus_Pro_Helpers::get_attachment_image_html( $settings, 'image' );
								echo '</div>';
							} elseif ( ! empty( $settings['image']['id'] ) && Kata_Plus_Pro_Helpers::string_is_contain( $settings['image']['url'], 'svg' ) && $icon_type == 'svg' ) {
								$svg_size = '';
								if ( isset( $settings['image_size'] ) || isset( $settings['image_custom_dimension']['width'] ) || isset( $settings['image_custom_dimension']['height'] ) ) {
									$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['image_size'], $settings['image_custom_dimension']['width'], $settings['image_custom_dimension']['height'] );
								}
								Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['image']['id'], $settings['image']['url'], $svg_size );
							}
							?>
						</div>
					<?php } ?>
					<?php if ( $title ) { ?>
						<h3 class="kata-plus-pricing-plan-title elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'pricing_plan_title' ); ?>><?php echo wp_kses( $title, wp_kses_allowed_html( 'post' ) ); ?></h3>
					<?php } ?>
					<?php if ( $price ) { ?>
						<div class="kata-plus-pricing-plan-price df-color">
							<span class="currency elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'pricing_plan_currency' ); ?>><?php echo wp_kses( $currency, wp_kses_allowed_html( 'post' ) ); ?></span>
							<span class="price elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'pricing_plan_price' ); ?>><?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?></span>
							<?php if ( $subtitle ) { ?>
								<span class="kata-plus-pricing-plan-subtitle elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'pricing_plan_subtitle' ); ?>><?php echo wp_kses( $subtitle, wp_kses_allowed_html( 'post' ) ); ?></span>
							<?php } ?>
						</div>
					<?php } ?>
					<?php if ( $desc ) { ?>
						<p class="kata-plus-pricing-plan-description elementor-inline-editing" <?php echo $this->get_render_attribute_string( 'pricing_plan_desc' ); ?>><?php echo wp_kses( $desc, wp_kses_allowed_html( 'post' ) ); ?></p>
					<?php } ?>
				</div>
			<?php } ?>

			<?php if ( $settings['pricing_items'] ) : ?>
				<div class="pricing-plan-items">
					<?php foreach ( $settings['pricing_items'] as $index => $Item ) : ?>
						<?php
							$pricing_plan_item_text_setting_key = $this->get_repeater_setting_key( 'pricing_plan_item_text', 'pricing_items', $index );
							$this->add_inline_editing_attributes( $pricing_plan_item_text_setting_key );
							$Item['pricing_plan_negative_item'] = $Item['pricing_plan_negative_item'] == 'yes' ? ' negative' : '';
						?>
						<?php if ( $Item['pricing_plan_item_has_link'] == 'yes' ) : ?>
							<?php $url = Kata_Plus_Pro_Helpers::get_link_attr( $Item['pricing_plan_item_link'] ); ?>
							<div class="elementor-repeater-item-<?php echo esc_attr( $Item['_id'] ) ?>">
								<a href="<?php echo esc_url( $Item['pricing_plan_item_link']['url'], Kata_Plus_Pro_Helpers::ssl_url() ); ?>" class="kata-plus-pricing-plan-icon-link" <?php echo $url->rel . ' ' . $url->target; ?>>								
									<div class="kata-plus-pricing-plan-text<?php echo esc_attr( $Item['pricing_plan_negative_item'] ); ?>">
										<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $Item['pricing_plan_item_icon'], ' kata-plus-pricing-plan-icon', '' ); ?>
										<?php echo wp_kses_post( $Item['pricing_plan_item_text'] ); ?>
									</div>
								</a>							
							</div>
	
						<?php else : ?>                        
							<div class="elementor-repeater-item-<?php echo esc_attr( $Item['_id'] ) ?>">							
								<div class="kata-plus-pricing-plan-text<?php echo esc_attr( $Item['pricing_plan_negative_item'] ); ?>">
									<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $Item['pricing_plan_item_icon'], ' kata-plus-pricing-plan-icon', '' ); ?>
									<?php echo wp_kses_post( $Item['pricing_plan_item_text'] ); ?>
								</div>
							</div>
						<?php endif ?>
	
					<?php endforeach ?>
				</div>
			<?php endif; ?>
			<?php if ( $settings['pricing_plan_button'] == 'yes' ) : ?>
				<?php
				$text = ! empty( $settings['pricing_plan_button_text'] ) ? $settings['pricing_plan_button_text'] : '';
				$url  = Kata_Plus_Pro_Helpers::get_link_attr( $settings['pricing_plan_button_link'] );
				?>
				<?php if ( $text ) : ?>
				<div class="kata-plus-pricing-plan-button-wrapper">
					<a href="<?php echo esc_url( $settings['pricing_plan_button_link']['url'], Kata_Plus_Pro_Helpers::ssl_url() ); ?>"  class="kata-plus-pricing-plan-button" <?php echo $url->rel . ' ' . $url->target; ?>>
							<?php if ( $settings['pricing_plan_button_icon_position'] == 'before' ) : ?>
								<?php if ( $settings['pricing_plan_button_icon'] ) : ?>
								<span class="kata-plus-button-icon kata-plus-align-icon-left">
									<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['pricing_plan_button_icon'], '', 'aria-hidden="true"' ); ?>
								</span>
							<?php endif ?>
						<?php endif ?>

						<span <?php echo $this->get_render_attribute_string( 'pricing_plan_button_text' ); ?>><?php echo $settings['pricing_plan_button_text']; ?></span>

							<?php if ( $settings['pricing_plan_button_icon_position'] == 'after' ) : ?>
								<?php if ( $settings['pricing_plan_button_icon'] ) : ?>
								<span class="kata-plus-button-icon kata-plus-align-icon-right">
									<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['pricing_plan_button_icon'], '', 'aria-hidden="true"' ); ?>
								</span>
							<?php endif ?>
						<?php endif ?>				
					</a>
				</div>
			<?php endif; ?>
		<?php endif ?>
		</div>
	<?php if ( ! empty ( $url->src ) && $settings['pricing_plan_button'] !== 'yes' ) { ?>
		</a>
	<?php } ?>

	<?php
endif;

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
