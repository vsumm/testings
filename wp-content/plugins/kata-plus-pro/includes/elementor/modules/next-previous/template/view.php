<?php

/**
 * Post Next/Previous module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.

if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Plugin;

$settings = $this->get_settings();

if (class_exists('Kata_Plus_Pro_Elementor') && isset($settings['parallax']) && isset($settings['parallax_speed']) && isset($settings['parallax_mouse_speed'])) {
	Kata_Plus_Pro_Elementor::start_parallax($settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed']);
}

$next_post 		= get_next_post();
$prev_post 		= get_previous_post();

$next_icon     = Kata_Plus_Pro_Helpers::get_icon('', $settings['next_icon'], '', '') ? Kata_Plus_Pro_Helpers::get_icon('', $settings['next_icon'], '', '') : '';
$previous_icon = Kata_Plus_Pro_Helpers::get_icon('', $settings['previous_icon'], '', '') ? Kata_Plus_Pro_Helpers::get_icon('', $settings['previous_icon'], '', '') : '';

if (get_post_type() == 'kata_plus_builder') {

	$width	= isset($settings['thumbnail_dimension']['width']) ? 'width=' . $settings['thumbnail_dimension']['width'] . '' : '';
	$height	= isset($settings['thumbnail_dimension']['height']) ? 'height=' . $settings['thumbnail_dimension']['height'] . '' : '';
?>
	<div class="kata-plus-next-previous-post">
		<div class="row">
			<div class="next-previous-post previous-post align-left col-md-6">
				<?php
				if ($settings['show_thumbnail']) {
				?>
					<div class="prev-post-thumbnail-wrapper kata-lazyload">
						<a href="#">
							<img <?php echo esc_attr($width) . ' ' . esc_attr($height) ?> src="<?php echo Kata_Plus::$assets . 'images/frontend/featured-image.png'; ?>" alt="<?php the_title(); ?>">
						</a>
					</div>
				<?php
				}?>
				<?php echo $previous_icon; ?>
				<div class="prev-post-content-wrapper">
					<div class="prev-post-label"><?php echo $settings['prev_post_label']; ?></div>
					<h3 class="prev-post-title">
						<a href="#"><?php echo __('Deadline | Hollywood Entertainment Breaking News', 'kata-plus-pro'); ?></a>
					</h3>
				</div>
			</div>
			<div class="next-previous-post next-post align-right col-md-6">
				<?php
				if ($settings['show_thumbnail']) {
				?>
					<div class="next-post-thumbnail-wrapper kata-lazyload">
						<a href="#">
							<img <?php echo esc_attr($width) . ' ' . esc_attr($height) ?> src="<?php echo Kata_Plus::$assets . 'images/frontend/featured-image.png'; ?>" alt="<?php the_title(); ?>">
						</a>
					</div>
				<?php
				}?>
				<?php echo $next_icon; ?>
				<div class="next-post-content-wrapper">
					<div class="next-post-label"><?php echo $settings['next_post_label']; ?></div>
					<h3 class="next-post-title">
						<a href="#"><?php echo __('Every Country Music That Creates Excitement', 'kata-plus-pro'); ?></a>
					</h3>
				</div>
			</div>
		</div>
	</div>
<?php
} else { ?>
	<div class="kata-plus-next-previous-post">
		<div class="row">
			<div class="previous-post align-left col-md-6">
				<?php
				if (!empty($prev_post->ID)) {
					if ($settings['show_thumbnail']) {
						echo '<div class="prev-post-thumbnail-wrapper kata-lazyload">';
						echo '<a href="' . get_the_permalink($prev_post->ID) . '">';
						Kata_Plus_Helpers::image_resize_output(get_post_thumbnail_id($prev_post->ID), [$settings['thumbnail_dimension']['width'], $settings['thumbnail_dimension']['height']]);
						echo '</a>';
						echo '</div>';
					}
					echo $previous_icon;
					echo '<div class="prev-post-content-wrapper">';
					echo '<div class="prev-post-label">' . $settings['prev_post_label'] . '</div>';
					echo '<h3 class="prev-post-title"><a href="' . get_the_permalink($prev_post->ID) . '">' . get_the_title($prev_post->ID) . '</a></h3>';
					echo '</div>';
				}
				?>
			</div>
			<div class="next-post align-right col-md-6">
				<?php
				if (!empty($next_post->ID)) {
					if ($settings['show_thumbnail']) {
						echo '<div class="next-post-thumbnail-wrapper kata-lazyload">';
						echo '<a href="' . get_the_permalink($next_post->ID) . '">';
						Kata_Plus_Helpers::image_resize_output(get_post_thumbnail_id($next_post->ID), [$settings['thumbnail_dimension']['width'], $settings['thumbnail_dimension']['height']]);
						echo '</a>';
						echo '</div>';
					}
					echo $next_icon;
					echo '<div class="next-post-content-wrapper">';
					echo '<div class="next-post-label">' . $settings['next_post_label'] . '</div>';
					echo '<h3 class="next-post-title"><a href="' . get_the_permalink($next_post->ID) . '">' . get_the_title($next_post->ID) . '</a></h3>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>
<?php
}
if (class_exists('Kata_Plus_Pro_Elementor') && isset($settings['parallax'])) {
	Kata_Plus_Pro_Elementor::end_parallax($settings['parallax']);
}
if (isset($settings['custom_css'])) {
	Kata_Plus_Elementor::module_custom_css_editor($settings['custom_css']);
}
