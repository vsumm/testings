<?php
/**
 * Categories List view.
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
$layout   = $settings['layout'];
$c        = ! empty( $settings['post_counts'] != 'no' ) ? '1' : '0';
$h        = ! empty( $settings['hierarchy'] != 'no' ) ? '1' : '0';
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>
<ul class="kata-plus-categories-list">
	<?php
	$args = [
		'orderby'      => 'name',
		'show_count'   => $c,
		'hierarchical' => $h,
		'title_li'     => '',
	];
	if ( $layout == 'list' ) {
		wp_list_categories( $args );
	} else {
		wp_dropdown_categories( $args );
	}
	?>
</ul>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
