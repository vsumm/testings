<?php

/**
 * Masonry Grid module view.
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

$settings		= $this->get_settings_for_display();
$this->add_inline_editing_attributes('load_more_text');
$random         = md5(microtime());
$grid_mode      = $settings['mode'];
$posts_per_page = $settings['posts_per_page'] ? $settings['posts_per_page'] : -1;
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
if ($grid_mode == 'all_posts') {
	// Posts
	$args  = array(
		'post_type'      => 'kata_grid',
		'post_status'    => 'publish',
		'order'          => 'DESC',
		'posts_per_page' => $posts_per_page,
	);
	$posts = new WP_Query($args);
} else {
	$categories_mode = $settings['categories_mode'];
	if ($categories_mode == 'all') {
		if ($settings['show_posts'] == 'all') {
			$args  = array(
				'post_type'      => 'kata_grid',
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'posts_per_page' => $posts_per_page,
			);
			$posts = new WP_Query($args);
		} else {
			$args = array(
				'post_type'      => 'kata_grid',
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'post__in'       => $settings['posts'],
				'posts_per_page' => $posts_per_page,
			);

			$posts = new WP_Query($args);
		}
	} else {
		$cats  = $settings['categories'];
		$args  = array(
			'post_type'      => 'kata_grid',
			'post_status'    => 'publish',
			'order'          => 'DESC',
			'grid_category'  => implode(',', $cats),
			'posts_per_page' => $posts_per_page,
		);
		$posts = new WP_Query($args);
	}
}
if ($grid_mode != 'all_posts' && $settings['categories_mode'] == 'custom') {
	$cats  = $settings['categories'];
	$terms = [];
	foreach ($cats as $c) {
		$terms[] = get_term_by('slug', $c, 'grid_category');
	}
} else {
	$terms = get_terms('grid_category');
}
if (isset($posts)) :
?>
	<div class="kata-plus-masonry-grid-wrap<?php echo esc_attr(' layout-' . $settings['layout']); ?>">
		<div class="kata-plus-masonry-content">
			<?php if ($settings['show_categories'] == 'yes') : ?>
				<div class="filters masonry-category-filters">
					<span data-filter="*" class="cat-item dbg-color-h active"><?php echo esc_html__('All', 'kata-plus'); ?></span>
					<?php foreach ($terms as $term) : ?>
						<span data-filter=".<?php echo $term->slug; ?>" class="cat-item dbg-color-h"><?php echo $term->name; ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif ?>
			<div class="kata-plus-masonry-grid<?php echo esc_attr($settings['show_modal']) == 'modal' ? ' ms-lightgallery' : ''; ?>">
				<div class="kata-filter-view<?php echo esc_attr($settings['show_modal']) == 'modal' ? ' ms-lightgallery' : ''; ?>"></div>
				<?php
				switch ($settings['layout']) {
					case '1':
						if ($posts->have_posts()) :
							$i = $j = 1;
							while ($posts->have_posts()) :
								$post            = $posts->the_post();
								$category_detail = wp_get_object_terms(get_the_ID(), 'grid_category');
								$cats            = ['all'];
								foreach ($category_detail as $cd) {
									$cats[] = $cd->slug;
								}
								if (($i % 3 == 1) && $i == 1) {
									echo '<div class="kata-ms-grid-row kata-masonry-grid-row' . esc_attr($j) . '">';
									if ($j >= 3) {
										$j = 1;
									} else {
										$j++;
									}
								}
								?>
								<div class="ms-grid-item animate <?php echo esc_attr(implode(' ', $cats)); ?>" <?php echo $settings['show_modal'] == 'modal' ? ' id="' . esc_attr(uniqid('ms-grid-item-', false)) . '"' : ''; ?>>
									<a href="<?php the_permalink(); ?>">
										<div class="masonry-image" title="<?php the_title(); ?>" <?php echo $settings['show_modal'] == 'modal' ? 'data-src="' . get_the_post_thumbnail_url() . '"' : ''; ?>>
											<div class="grid-overlay"></div>
											<?php
											if (has_post_thumbnail()) :
												$alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ? 'alt=' . get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) . '' : '';
												if ($i == 1 && $j == 2) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['293', '293']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 2 && $j == 2) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['627', '313']) . '" data-class="grid-wide" ' . esc_attr($alt) . '>';
												} elseif ($i == 3 && $j == 2) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['293', '293']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 1 && $j == 3) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['627', '313']) . '" data-class="grid-wide" ' . esc_attr($alt) . '>';
												} elseif ($i == 2 && $j == 3) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['293', '293']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 3 && $j == 3) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['293', '293']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 1 && $j == 1) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['293', '293']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 2 && $j == 1) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['293', '293']) . '"  data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 3 && $j == 1) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['627', '313']) . '"  data-class="grid-wide" ' . esc_attr($alt) . '>';
												}
											endif;
											?>
										</div>
									</a>
									<div class="ms-grid-content-wrap">
										<?php if ($settings['show_title'] == 'yes') : ?>
											<h4 class="masonry-title df-color-h"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<?php endif; ?>
										<?php if ($settings['show_date'] == 'yes' || $settings['show_item_categories'] == 'yes') : ?>
											<div class="masonry-post-meta">
												<?php if ($settings['show_date'] == 'yes') : ?>
													<span class="masonry-date"><?php echo get_the_date(); ?> - </span>
												<?php endif ?>
												<?php if ($settings['show_item_categories'] == 'yes') : ?>
													<span class="masonry-item-category"><?php echo str_replace('rel="tag"', 'rel="tag" class="df-color-h"', get_the_term_list(get_the_ID(), 'grid_category', '', ',', '')); ?></span>
												<?php endif ?>
											</div>
										<?php endif; ?>
										<?php if ($settings['show_excerpt'] == 'yes') : ?>
											<p class="masonry-excerpt"><?php echo Kata_Template_Tags::excerpt(15); ?></p>
										<?php endif; ?>
									</div>
									<?php foreach ($settings['posts_icons'] as $icon) : ?>
										<?php $attr = isset($icon['styler_nav_post_icon']['citem']) ? 'data-item-id=' . $icon['styler_nav_post_icon']['citem'] . '' : ''; ?>
										<?php if ($icon['post_has_link'] == 'yes') : ?>
											<?php $url = Kata_Plus_Pro_Helpers::get_link_attr($icon['post_link']); ?>
											<a <?php echo $url->src; ?> <?php echo $url->rel . $url->target; ?>>
												<?php echo Kata_Plus_Pro_Helpers::get_icon('', $icon['post_icon'], 'kata-plus-masonry-post-icon elementor-repeater-item-' . $icon['_id'], $attr); ?>
											</a>
										<?php else : ?>
											<?php echo Kata_Plus_Pro_Helpers::get_icon('', $icon['post_icon'], 'kata-plus-masonry-post-icon open-modal elementor-repeater-item-' . $icon['_id'], $attr); ?>
										<?php endif ?>
									<?php endforeach ?>
									<?php $attr = isset($element['styler_nav_post_element']['citem']) ? esc_attr($element['styler_nav_post_element']['citem']) : ''; ?>
									<?php foreach ($settings['posts_elements'] as $element) : ?>
										<div class="open-modal elementor-repeater-item-<?php echo esc_attr($element['_id']); ?>" data-item-id="<?php echo esc_attr($attr); ?>"></div>
									<?php endforeach ?>
								</div>
								<?php
								if ((($posts->current_post + 1) == ($posts->post_count)) || (($i % 3 == 0) && $i > 1)) {
									echo '</div>';
								}
								if ($i >= 3) {
									$i = 1;
								} else {
									$i++;
								}
							endwhile;
						else:
							echo '<h5>' . __( 'You need portfolio item to use this widget.', 'kata-plus' ) . '</h5>';
							echo '<p>' . __( 'Please create a new portfolio and also add the featured image to be previewed in the widget', 'kata-plus' ) . '</p>';
						endif;
						wp_reset_postdata();
						break;
					case '2':
						if ($posts->have_posts()) :
							$i     = $j = 0;
							$inner = false;
							$odd   = $even = false;
							while ($posts->have_posts()) :
								$i++;
								$post            = $posts->the_post();
								$category_detail = wp_get_object_terms(get_the_ID(), 'grid_category');
								$cats            = ['all'];
								foreach ($category_detail as $cd) {
									$cats[] = $cd->slug;
								}
								if ($j === 0) {
									echo '<div class="kata-ms-grid-row kata-masonry-grid-row1">';
									$odd  = true;
									$even = false;
								} elseif ($j === 2) {
									echo '<div class="kata-ms-grid-row kata-masonry-grid-row2">';
									$odd  = false;
									$even = true;
								}
								?>

								<div class="ms-grid-item animate <?php echo esc_attr(implode(' ', $cats)); ?>" <?php echo $settings['show_modal'] == 'modal' ? ' id="' . esc_attr(uniqid('ms-grid-item-', false)) . '"' : ''; ?>>
									<a href="<?php the_permalink(); ?>">
										<div class="masonry-image" title="<?php the_title(); ?>" <?php echo $settings['show_modal'] == 'modal' ? 'data-src="' . get_the_post_thumbnail_url() . '"' : ''; ?>>
											<div class="grid-overlay"></div>
											<?php
											if (has_post_thumbnail()) :
												$alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ? 'alt=' . get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) . '' : '';
												if ($i == 1 && $j == 0) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['455', '425']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 2 && $j == 3 && $odd == 1) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['950', '445']) . '" data-class="grid-wide" ' . esc_attr($alt) . '>';
												} elseif ($i == 1 && $j == 2) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['455', '425']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 2 && $j == 3 && $even == 1) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['455', '425']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												} elseif ($i == 3 && $j == 3) {
													echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize(get_post_thumbnail_id(), ['455', '425']) . '" data-class="grid-normal" ' . esc_attr($alt) . '>';
												}
											endif;
											?>
										</div>
									</a>
									<div class="ms-grid-content-wrap">
										<?php if ($settings['show_date'] == 'yes' || $settings['show_item_categories'] == 'yes') : ?>
											<div class="masonry-post-meta">
												<?php if ($settings['show_date'] == 'yes') : ?>
													<span class="masonry-date"><?php echo get_the_date(); ?> - </span>
												<?php endif ?>
												<?php if ($settings['show_item_categories'] == 'yes') : ?>
													<span class="masonry-item-category"><?php echo get_the_term_list(get_the_ID(), 'grid_category', '', ',', ''); ?></span>
												<?php endif ?>
											</div>
										<?php endif; ?>
										<?php if ($settings['show_title'] == 'yes') : ?>
											<h4 class="masonry-title df-color-h"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<?php endif; ?>
										<?php if ($settings['show_excerpt'] == 'yes') : ?>
											<p class="masonry-excerpt"><?php echo Kata_Template_Tags::excerpt(15); ?></p>
										<?php endif; ?>
										<?php foreach ($settings['posts_icons'] as $icon) : ?>
											<?php if ($icon['post_has_link'] == 'yes') : ?>
												<?php $url = Kata_Plus_Pro_Helpers::get_link_attr($icon['post_link']); ?>
												<a href="<?php echo esc_url($url->src, Kata_Plus_Pro_Helpers::ssl_url()); ?>" <?php echo $url->rel . $url->target; ?>>
													<?php echo Kata_Plus_Pro_Helpers::get_icon('', $icon['post_icon'], 'kata-plus-masonry-post-icon elementor-repeater-item-' . $icon['_id'], 'data-item-id="' . isset($icon['styler_nav_post_icon']['citem']) ? $icon['styler_nav_post_icon']['citem'] : '' . '"'); ?>
												</a>
											<?php else : ?>
												<?php echo Kata_Plus_Pro_Helpers::get_icon('', $icon['post_icon'], 'kata-plus-masonry-post-icon open-modal elementor-repeater-item-' . $icon['_id'], 'data-item-id="' . isset($icon['styler_nav_post_icon']['citem']) ? $icon['styler_nav_post_icon']['citem'] : '' . '"'); ?>
											<?php endif ?>
										<?php endforeach ?>
										<?php foreach ($settings['posts_elements'] as $element) : ?>
											<div class="open-modal elementor-repeater-item-<?php echo esc_attr($element['_id']); ?>" data-item-id="<?php echo isset($element['styler_nav_post_element']['citem']) ? esc_attr($element['styler_nav_post_element']['citem']) : ''; ?>"></div>
										<?php endforeach ?>
									</div>
								</div>
								<?php
								$j = 3;
								if ($even && $i === 3) {
									echo '</div>';
									$i = 0;
									$j = 0;
								} elseif ($odd && $i === 2) {
									echo '</div>';
									$j = 2;
									$i = 0;
								}
								if (($posts->current_post + 1) == $posts->post_count) {
									echo '</div>';
								}

								?>
								<?php

							endwhile;
						else:
							echo '<h3>' . __( 'You need portfolio item to use this widget.', 'kata-plus' ) . '</h3>';
							echo '<p>' . __( 'Please create a new portfolio and also add the featured image to be previewed in the widget', 'kata-plus' ) . '</p>';
						endif;
						wp_reset_postdata();
						break;
				}
				?>
			</div>
		</div>
		<?php if ($settings['load_more'] == 'yes') : ?>
			<?php
			$text = !empty($settings['load_more_text']) ? $settings['load_more_text'] : '';
			$url  = Kata_Plus_Pro_Helpers::get_link_attr($settings['load_more_link']);
			?>
			<?php if ($text) : ?>
				<div class="kata-plus-masonry-button-wrapper">
					<a href="<?php echo esc_url($url->src, Kata_Plus_Pro_Helpers::ssl_url()); ?>" class="kata-button" <?php echo $url->rel . $url->target; ?>>
						<?php if ($settings['load_more_icon_position'] == 'before') : ?>
							<?php if ($settings['load_more_icon']) : ?>
								<span class="kata-plus-button-icon kata-plus-align-icon-left">
									<?php echo Kata_Plus_Pro_Helpers::get_icon('', $settings['load_more_icon'], '', 'aria-hidden="true"'); ?>
								</span>
							<?php endif ?>
						<?php endif ?>
						<span <?php echo $this->get_render_attribute_string('servcbx_desc'); ?>><?php echo $settings['load_more_text']; ?></span>
						<?php if ($settings['load_more_icon_position'] == 'after') : ?>
							<?php if ($settings['load_more_icon']) : ?>
								<?php echo Kata_Plus_Pro_Helpers::get_icon('', $settings['load_more_icon'], '', 'aria-hidden="true"'); ?>
							<?php endif ?>
						<?php endif ?>
					</a>
				</div>
			<?php endif; ?>
		<?php endif ?>
	</div>
<?php
endif;
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
