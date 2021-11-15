<?php

/**
 * Timeline module view.
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
use Elementor\Plugin;

$settings	= $this->get_settings_for_display();
$alignment	= $settings['alignment'];
$blocks		= $settings['timeline_item'];
$space		= ' ';
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<?php if ($blocks) : ?>
	<div class="kata-plus-timeline <?php echo esc_attr($alignment); ?>">
		<?php
		foreach ($blocks as $block) :
			$date_array = explode(' ', $block['date']);
			$classes = $block['_id'] . $space . $block['block_pos'];
		?>
			<div class="content-wrap elementor-repeater-item-<?php echo esc_attr($classes); ?>">
				<?php if ($block['icon']) { ?>
					<div class="kata-plus-tli">
						<?php echo Kata_Plus_Pro_Helpers::get_icon('', $block['icon'], '', ''); ?>
					</div>
				<?php } ?>
				<?php if ($block['elementor_tpl_id']) { ?>
					<div class="inner-content">
						<?php echo Plugin::instance()->frontend->get_builder_content_for_display(get_page_by_title($block['elementor_tpl_id'], OBJECT, 'elementor_library')->ID); ?>
						<?php if ($block['date']) { ?>
							<?php if ($block['show_time'] == 'yes') { ?>
								<p class="kata-plus-tld"><?php echo esc_html($date_array[0] . ' ' . $date_array[1]); ?></p>
							<?php } else { ?>
								<p class="kata-plus-tld"><?php echo esc_html($date_array[0]); ?></p>
							<?php } ?>
						<?php } ?>
					</div>
				<?php } ?>

			</div>
		<?php endforeach; ?>
	</div>
<?php
endif;

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
