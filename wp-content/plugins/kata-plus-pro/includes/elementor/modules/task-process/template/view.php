<?php
/**
 * Task Process Toggle view.
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
$tasks    = $settings['tasks'];
$carousel = $settings['carousel'];
$settings['inc_owl_arrow']                 = $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
$settings['inc_owl_pag']                   = $settings['inc_owl_pag'] == 'true' && $settings['inc_owl_pag_num'] != 'dots-and-num' ? 'true' : 'false';
$settings['inc_owl_loop']                  = $settings['inc_owl_loop'] == 'true' ? 'true' : 'false';
$settings['inc_owl_autoplay']              = $settings['inc_owl_autoplay'] == 'true' ? 'true' : 'false';
$settings['inc_owl_center']                = $settings['inc_owl_center'] == 'true' ? 'true' : 'false';
$settings['inc_owl_vert']                  = $settings['inc_owl_vert'] == 'true' ? 'true' : 'false';
$animateout                                = $settings['inc_owl_vert'] == 'true' ? 'fadeOutUp' : '';
$animatein                                 = $settings['inc_owl_vert'] == 'true' ? 'fadeInUp' : '';
$settings['inc_owl_rtl']                   = $settings['inc_owl_rtl'] == 'true' ? 'true' : 'false';
$settings['inc_owl_item_tablet']           = $settings['inc_owl_item_tablet'] ? $settings['inc_owl_item_tablet'] : '2';
$settings['inc_owl_item_mobile']           = $settings['inc_owl_item_mobile'] ? $settings['inc_owl_item_mobile'] : '1';
$settings['inc_owl_stgpad_tablet']['size'] = $settings['inc_owl_stgpad_tablet']['size'] ? $settings['inc_owl_stgpad_tablet']['size'] : '0';
$settings['inc_owl_stgpad_mobile']['size'] = $settings['inc_owl_stgpad_mobile']['size'] ? $settings['inc_owl_stgpad_mobile']['size'] : '0';
$settings['inc_owl_margin_tablet']['size'] = $settings['inc_owl_margin_tablet']['size'] ? $settings['inc_owl_margin_tablet']['size'] : '0';
$settings['inc_owl_margin_mobile']['size'] = $settings['inc_owl_margin_mobile']['size'] ? $settings['inc_owl_margin_mobile']['size'] : '0';
$slide_speed                               = $settings['inc_owl_spd']['size'];
$classes                                   = $settings['inc_owl_pag_num'];


if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

if ( $tasks ) { ?>

	<?php if ( $carousel ) { ?>

	<div
	class="kata-plus-task-process-wrapper kata-owl owl-carousel owl-theme <?php echo esc_attr( $classes ); ?>"
	data-inc_owl_item="<?php echo esc_attr( $settings['inc_owl_item'] ); ?>"
	data-inc_owl_itemtab="<?php echo esc_attr( $settings['inc_owl_item_tablet'] ); ?>"
	data-inc_owl_itemmob="<?php echo esc_attr( $settings['inc_owl_item_mobile'] ); ?>"
	data-inc_owl_spd="<?php echo esc_attr( $slide_speed ); ?>"
	data-inc_owl_smspd="<?php echo esc_attr( $settings['inc_owl_smspd']['size'] ); ?>"
	data-inc_owl_stgpad="<?php echo esc_attr( $settings['inc_owl_stgpad']['size'] ); ?>"
	data-inc_owl_stgpadtab="<?php echo esc_attr( $settings['inc_owl_stgpad_tablet']['size'] ); ?>"
	data-inc_owl_stgpadmob="<?php echo esc_attr( $settings['inc_owl_stgpad_mobile']['size'] ); ?>"
	data-inc_owl_margin="<?php echo esc_attr( $settings['inc_owl_margin']['size'] ); ?>"
	data-inc_owl_margintab="<?php echo esc_attr( $settings['inc_owl_margin_tablet']['size'] ); ?>"
	data-inc_owl_marginmob="<?php echo esc_attr( $settings['inc_owl_margin_mobile']['size'] ); ?>"
	data-inc_owl_arrow="<?php echo esc_attr( $settings['inc_owl_arrow'] ); ?>"
	data-inc_owl_pag="<?php echo esc_attr( $settings['inc_owl_pag'] ); ?>"
	data-inc_owl_loop="<?php echo esc_attr( $settings['inc_owl_loop'] ); ?>"
	data-inc_owl_autoplay="<?php echo esc_attr( $settings['inc_owl_autoplay'] ); ?>"
	data-inc_owl_center="<?php echo esc_attr( $settings['inc_owl_center'] ); ?>"
	data-animatein="<?php echo esc_attr( $animatein ); ?>"
	data-animateout="<?php echo esc_attr( $animateout ); ?>"
	data-inc_owl_prev="<?php echo base64_encode( Kata_Plus_Pro_Helpers::get_icon( '', $settings['inc_owl_prev'], '', '' ) ); ?>"
	data-inc_owl_nxt="<?php echo base64_encode( Kata_Plus_Pro_Helpers::get_icon( '', $settings['inc_owl_nxt'], '', '' ) ); ?>"
	data-inc_owl_rtl="<?php echo esc_attr( $settings['inc_owl_rtl'] ); ?>"
	>
		<?php foreach ( $tasks as $task ): ?>
			<div class="kata-plus-task-process <?php echo ' elementor-repeater-item-' . esc_attr( $task['_id'] ); ?>">
		 		<div class="task-process-number">
					<span class="dbg-color process-number"><?php echo esc_html( $task['number'] ); ?></span>
				</div>

				<div class="task-process">
					<<?php echo $task['title_tag']; ?> class="task-process-title"><?php echo esc_html( $task['title'] ); ?></<?php echo $task['title_tag']; ?>>
					<<?php echo $task['content_tag']; ?> class="task-process-content"><?php echo esc_html( $task['content'] ); ?></<?php echo $task['content_tag']; ?>>
				</div>
			</div>
		<?php endforeach; ?>

		</div>
		<?php if ( $settings['inc_owl_pag_num'] == 'dots-and-num') { ?>
			<div class="kata-owl-progress-bar"><div class="kata-progress-bar-inner dbg-color"></div></div>
		<?php } ?>

		<?php } else { ?>
			<div class="kata-plus-task-process-wrapper">
				<?php foreach ( $tasks as $task ): ?>
					<div class="kata-plus-task-process task-process-normal">
			 			<div class="task-process-number">
							<span class="dbg-color"><?php echo esc_html( $task['number'] ); ?></span>
						</div>

						<div class="task-process">
							<<?php echo $task['title_tag']; ?> class="task-process-title"><?php echo esc_html( $task['title'] ); ?></<?php echo $task['title_tag']; ?>>
							<<?php echo $task['content_tag']; ?> class="task-process-content"><?php echo esc_html( $task['content'] ); ?></<?php echo $task['content_tag']; ?>>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php } ?>
	<?php
}

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
