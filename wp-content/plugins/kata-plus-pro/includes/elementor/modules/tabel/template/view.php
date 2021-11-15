<?php

/**
 * Courses module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Utils;

$settings = $this->get_settings();
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
?>
<div class="kata-plus-table-wrap">
	<table class="kata-plus-table">
		<thead>
			<tr class="kt-table-header-item">
				<?php
					if ( $settings['header_items'] ) {
						foreach ( $settings['header_items'] as $key => $value ) {
							?>
							<th class="kt-table-header-item" colspan="<?php echo esc_attr( $value['header_item_size'] ) ?>"><?php echo esc_html( $value['header_item'] ); ?></th>
							<?php
						}
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				if ( $settings['body_items'] ) {
					foreach ( $settings['body_items'] as $key => $item ) {
						$body_item_link	= Kata_Plus_Pro_Helpers::get_link_attr( $item['body_item_link'] );
						$start_url 		= $body_item_link->src ? '<a ' . $body_item_link->src . $body_item_link->rel . $body_item_link->target . '>' : '';
						$end_url 		= $body_item_link->src ? '</a>' : '';
						$icon_at_start 	= $item['body_item_link_icon'] && 'start' == $item['body_item_link_icon_pos'] ? Kata_Plus_Pro_Helpers::get_icon( '', $item['body_item_link_icon'], '', '' ) : '';
						$icon_at_end 	= $item['body_item_link_icon'] && 'end' == $item['body_item_link_icon_pos'] ? Kata_Plus_Pro_Helpers::get_icon( '', $item['body_item_link_icon'], '', '' ) : '';
						if( 'yes' === $item['start_row'] ) {
							echo '<tr>';
						}
						echo '
						<' . $item['body_item_tag'] . ' colspan="' . esc_attr( $item['body_item_size'] ) . '">
							' . $start_url . $icon_at_start . wp_kses_post( $item['body_item'] ) . $icon_at_end . $end_url . '
						</' . $item['body_item_tag'] . '>';
						if( 'yes' === $item['end_row'] ) {
							echo '</tr>';
						}
					}
				}
			?>

		</tbody>
	</table>
</div>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
