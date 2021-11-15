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
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>
<div class="kata-plus-shop-categories">
	<?php
	$args = [
		'taxonomy'		=> 'product_cat',
		'orderby'		=> 'name',
		'show_count'	=> '1',
		'hierarchical'	=> '1',
		'title_li'		=> '',
	];
	if ( $layout == 'list' ) {
		wp_list_categories( $args );
	} elseif ( $layout == 'dropdown' ) {
		wp_dropdown_categories( $args );
	} elseif ( $layout == 'inline' ){
		$product_categories = get_terms( 'product_cat', $args );

		if( !empty( $product_categories ) ){
			foreach ($product_categories as $key => $category) {
				echo '<span class="inline-cat-item"><a href="'.get_term_link($category).'" >';
				echo $category->name;
				echo '</a></span>';
			}
		}
	}
	?>
</div>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
