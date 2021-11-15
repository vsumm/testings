<?php
/**
 * Banner module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings				= $this->get_settings_for_display();
$this->add_inline_editing_attributes( 'banner_title' );
$this->add_inline_editing_attributes( 'banner_subtitle' );
$this->add_inline_editing_attributes( 'banner_button_txt' );
$image         	= $settings['img'];
$shapes        	= $settings['banner_shapes'];
$button_txt    	= $settings['banner_button_txt'];
$title         	= $settings['banner_title'];
$subtitle      	= $settings['banner_subtitle'];
$title_tag     	= $settings['banner_title_tag'];
$subtitle_tag  	= $settings['banner_subtitle_tag'];
$banner_tag    	= $settings['banner_tag'];
$image_tag     	= $settings['image_tag'];
$des_tag       	= $settings['description_tag'];
$btn_link      	= $settings['button_link'];
$btn_target    	= ! empty( $btn_link['is_external'] ) ? 'target="_blank"' : '';
$btn_rel       	= ! empty( $btn_link['nofollow'] ) ? 'rel="nofollow"' : '';
$banner_link	= Kata_Plus_Helpers::get_link_attr( $settings['banner_link'] );
$image_size    	= $settings['img_size']['width'] == '' || $settings['img_size']['height'] == '' ? 'full' : array( $settings['img_size']['width'], $settings['img_size']['height'] );

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
?>

	<?php echo '<' . $banner_tag . ' class="kata-banner-wrap">'; ?>

		<?php if ( $banner_link->src ): echo '<a ' . $banner_link->src . ' ' . $banner_link->rel . ' ' . $banner_link->target . ' class="kata-banner-link"></a>'; endif; ?>
		<?php echo '<' . $des_tag . ' class="kata-banner-description">'; ?>
				<?php
				if ( !empty($title) ) {
					echo '<' . $title_tag . ' class="kata-banner-title elementor-inline-editing" ' . $this->get_render_attribute_string( 'banner_title' ) . '>' . esc_html( $title ) . '</' . $title_tag . '>';
				}

				if ( !empty($subtitle) ) {
					echo '<' . $subtitle_tag . ' class="kata-banner-subtitle elementor-inline-editing" ' . $this->get_render_attribute_string( 'banner_subtitle' ) . '>' . esc_html( $subtitle ) . '</' . $subtitle_tag . '>';
				}

				if ( $settings['banner_button_icon'] ) {
					$btn_icon = Kata_Plus_Helpers::get_icon( '', $settings['banner_button_icon'] );
				}

				if ( $button_txt && $btn_link['url'] ) {
					echo '<a href="' . $btn_link['url'] . '" ' . $btn_rel . ' ' . $btn_target . ' class="kata-banner-button elementor-inline-editing" ' . $this->get_render_attribute_string( 'banner_button_txt' ) . '>' . ( ! empty( $btn_icon ) ? $btn_icon : '' ) . '' . esc_html( $button_txt ) . '</a>';
				} else if ( $button_txt ) {
					echo '<span class="kata-banner-button elementor-inline-editing" ' . $this->get_render_attribute_string( 'banner_button_txt' ) . '>' . ( ! empty( $btn_icon ) ? $btn_icon : '' ) . '' . esc_html( $button_txt ) . '</span>';
				}

				?>
		<?php echo '</' . $des_tag . '>'; ?>

		<?php echo '<' . $image_tag . ' class="kata-banner-img kata-lazyload">';

				if ( ! empty( $image['id'] ) ) {
					Kata_Plus_Helpers::image_resize_output( $image['id'], $image_size );
				} else {
					echo '<img src="' . ELEMENTOR_ASSETS_URL . 'images/placeholder.png' . '">';
				}

			?>

		<?php echo '</' . $image_tag . '>'; ?>

		<?php
		if ( $shapes ) {
			foreach ( $shapes as $shape ) {
				echo '<span class="elementor-repeater-item-' . esc_attr( $shape['_id'] ) . ' kata-banner-shape" data-item-id="' . isset( $shape['shape_sk']['citem'] ) ? esc_attr( $shape['shape_sk']['citem'] ) : '' . '"></span>';
			}
		}
		?>
	<?php echo '</' . $banner_tag . '>'; ?>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
