<?php
/**
 * Carousel Grid module view.
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

$settings				= $this->get_settings_for_display();
$this->add_inline_editing_attributes( 'carousel_load_more_text' );

$random                                    = md5( microtime() );
$grid_mode                                 = $settings['carousel_mode'];
$settings['inc_owl_arrow']                 = $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
$settings['inc_owl_pag']                   = $settings['inc_owl_pag'] == 'true' && $settings['inc_owl_pag_num'] != 'dots-and-num' ? 'true' : 'false';
$settings['inc_owl_loop']                  = $settings['inc_owl_loop'] == 'true' ? 'true' : 'false';
$settings['inc_owl_autoplay']              = $settings['inc_owl_autoplay'] == 'true' ? 'true' : 'false';
$settings['inc_owl_center']                = $settings['inc_owl_center'] == 'true' ? 'true' : 'false';
$settings['inc_owl_vert']                  = $settings['inc_owl_vert'] == 'true' ? 'true' : 'false';
$animateout                                = $settings['inc_owl_vert'] == 'true' ? 'fadeOutUp' : '';
$animatein                                 = $settings['inc_owl_vert'] == 'true' ? 'fadeInUp' : '';
$settings['inc_owl_rtl']                   = $settings['inc_owl_rtl'] == 'true' ? 'true' : 'false';
if ( empty( $settings['inc_owl_item_tablet'] ) && $settings['inc_owl_item'] == '1' ) {
	$settings['inc_owl_item_tablet'] = $settings['inc_owl_item'];
} else if ( empty( $settings['inc_owl_item_tablet'] ) && $settings['inc_owl_item'] > '1' ) {
	$settings['inc_owl_item_tablet'] = '2';
}
if ( empty( $settings['inc_owl_item_mobile'] ) && $settings['inc_owl_item'] == '1' ) {
	$settings['inc_owl_item_mobile'] = $settings['inc_owl_item'];
} else if ( empty( $settings['inc_owl_item_mobile'] ) && $settings['inc_owl_item'] > '1' ) {
	$settings['inc_owl_item_mobile'] = '1';
}
$settings['inc_owl_stgpad_tablet']['size'] = $settings['inc_owl_stgpad_tablet']['size'] ? $settings['inc_owl_stgpad_tablet']['size'] : '0';
$settings['inc_owl_stgpad_mobile']['size'] = $settings['inc_owl_stgpad_mobile']['size'] ? $settings['inc_owl_stgpad_mobile']['size'] : '0';
$settings['inc_owl_margin_tablet']['size'] = $settings['inc_owl_margin_tablet']['size'] ? $settings['inc_owl_margin_tablet']['size'] : '0';
$settings['inc_owl_margin_mobile']['size'] = $settings['inc_owl_margin_mobile']['size'] ? $settings['inc_owl_margin_mobile']['size'] : '0';
$slide_speed                               = $settings['inc_owl_spd']['size'];
$classes                                   = $settings['inc_owl_pag_num'];

if ( $grid_mode == 'all_posts' ) {
	// Posts
	$args  = array(
		'post_type'   => 'kata_grid',
		'post_status' => 'publish',
		'order'       => 'DESC',
	);
	$posts = new WP_Query( $args );
} else {
	$categories_mode = $settings['carousel_categories_mode'];
	if ( $categories_mode == 'all' ) {
		if ( $settings['carousel_show_posts'] == 'all' ) {
			$args  = array(
				'post_type'   => 'kata_grid',
				'post_status' => 'publish',
				'order'       => 'DESC',
			);
			$posts = new WP_Query( $args );
		} else {
			$args  = array(
				'post_type'   => 'kata_grid',
				'post_status' => 'publish',
				'order'       => 'DESC',
				'post__in'    => $settings['carousel_posts'],
			);
			$posts = new WP_Query( $args );
		}
	} else {
		$cats  = $settings['carousel_categories'];
		$args  = array(
			'post_type'     => 'kata_grid',
			'post_status'   => 'publish',
			'order'         => 'DESC',
			'grid_category' => implode( ',', $cats ),
		);
		$posts = new WP_Query( $args );
	}
}

if ( $grid_mode != 'all_posts' && $settings['carousel_categories_mode'] == 'custom' ) {
	$cats  = $settings['carousel_categories'];
	$terms = [];
	foreach ( $cats as $c ) {
		$terms[] = get_term_by( 'slug', $c, 'grid_category' );
	}
} else {
	$terms = get_terms( 'grid_category' );
}

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}
if ( isset( $posts ) ) :
	?>
	<div class="kata-plus-carousel-grid-wrap">
		<?php if ( $settings['carousel_show_categories'] == 'yes' ) : ?>
		<div class="carousel-categories owl-filter-bar">
			<span class="item cat-item dbg-color-h" data-owl-filter="*" data-id="<?php echo $random; ?>"><?php echo esc_html__( 'All', 'kata-plus' ); ?></span>
			<?php
				$options = [];
			foreach ( $terms as $term ) :
				?>
			<span class="item cat-item dbg-color-h" data-owl-filter=".<?php echo esc_attr( $term->slug ); ?>" data-id="<?php echo $random; ?>"><?php echo $term->name; ?></span>
			<?php endforeach; ?>
		</div>
		<?php endif ?>
	<div class="hidden" id="<?php echo $random; ?>_cloned"></div>
	<div
	class="kata-plus-carousel-grid kata-owl owl-carousel owl-theme <?php echo esc_attr( $classes ); ?> <?php echo $settings['carousel_show_modal'] == 'modal' ? ' lightgallery' : ''; ?> "
	data-inc_owl_item="<?php echo esc_attr( $settings['inc_owl_item'] ); ?>"
	data-inc_owl_item_tab_landescape="<?php echo $settings['inc_owl_item_tab_landescape'] ? esc_attr( $settings['inc_owl_item_tab_landescape'] ) : esc_attr( $settings['inc_owl_item_tablet'] ); ?>"
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


	<?php
	if ( $posts->have_posts() ) :
		while ( $posts->have_posts() ) :
			$post            = $posts->the_post();
			$category_detail = wp_get_object_terms( get_the_ID(), 'grid_category' );
			$s2              = '';
			foreach ( $category_detail as $cd ) {
				$s2 .= esc_attr( $cd->slug . ' ' );
			}
			?>
			<div class="item grid-item <?php echo esc_attr( $s2 ); ?>">
				<a href="<?php the_permalink(); ?>">
					<div class="carousel-image kata-lazyload" title="<?php the_title(); ?>" <?php echo $settings['carousel_show_modal'] == 'modal' ? 'data-src="' . get_the_post_thumbnail_url() . '"' : ''; ?>>
						<div class="grid-overlay"></div>
						<?php
						$thumbnail_width  = $settings['thumbnail_size']['width'] ? $settings['thumbnail_size']['width'] : '450';
						$thumbnail_height = $settings['thumbnail_size']['height'] ? $settings['thumbnail_size']['height'] : '450';
						$alt              = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ? ' alt=' . get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) . '' : '';
						echo '<img src="' . Kata_Plus_Pro_Helpers::image_resize( get_post_thumbnail_id(), [ $thumbnail_width, $thumbnail_height ] ) . '"' . esc_attr( $alt ) . '>';
						?>
					</div>
				</a>
				<div class="content-wrapper">
					<?php if ( $settings['carousel_show_date'] == 'yes' || $settings['carousel_show_item_categories'] == 'yes' ) : ?>
						<div class="carousel-post-meta">
							<?php if ( $settings['carousel_show_date'] == 'yes' ) : ?>
								<span class="carousel-date"><?php echo get_the_date(); ?> - </span>
							<?php endif ?>
							<?php if ( $settings['carousel_show_item_categories'] == 'yes' ) : ?>
								<span class="carousel-item-category"><?php echo str_replace( 'rel="tag"', 'rel="tag" class="df-color-h"', get_the_term_list( get_the_ID(), 'grid_category', '', '<span class="separator">' . $settings['categories_seperator'] . '</span>', '' ) ); ?></span>
							<?php endif ?>
						</div>
					<?php endif ?>
					<?php if ( $settings['carousel_show_title'] == 'yes' ) : ?>
						<h4 class="carousel-title df-color-h"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<?php endif ?>
					<?php if ( $settings['carousel_show_excerpt'] == 'yes' ) : ?>
						<p class="carousel-excerpt"><?php echo Kata_Template_Tags::excerpt( 15 ); ?></p>
					<?php endif ?>
					<?php foreach ( $settings['carousel_posts_icons'] as $icon ) : ?>
						<?php if ( $icon['carousel_post_icon'] ) : ?>
							<?php if ( $icon['carousel_post_has_link'] == 'yes' ) : ?>
								<?php $url = Kata_Plus_Pro_Helpers::get_link_attr( $icon['carousel_post_link'] ); ?>
								<a <?php echo $url->src; ?> class="kata-plus-carousel-post-icon" <?php echo $url->rel . $url->target; ?>>
									<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $icon['carousel_post_icon'], 'elementor-repeater-item-' . esc_attr( $icon['_id'] ) . '', 'data-item-id="' . isset( $icon['styler_carousel_nav_post_icon']['citem'] ) ? esc_attr( $icon['styler_carousel_nav_post_icon']['citem'] ) : '' . '"' ); ?>
								</a>
							<?php else : ?>
								<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $icon['carousel_post_icon'], 'kata-plus-carousel-post-icon open-modal elementor-repeater-item-' . esc_attr( $icon['_id'] ), 'data-item-id="' . isset( $icon['styler_carousel_nav_post_icon']['citem'] ) ? $icon['styler_carousel_nav_post_icon']['citem'] : '' . '"' ); ?>
							<?php endif ?>
						<?php endif ?>
					<?php endforeach ?>
					<?php
					foreach ( $settings['carousel_posts_elements'] as $element ) :
						?>
						<div class="gele open-modal elementor-repeater-item-<?php echo esc_attr( $element['_id'] ); ?>" data-item-id="<?php echo isset( $element['styler_carousel_nav_post_element']['citem'] ) ? esc_attr( $element['styler_carousel_nav_post_element']['citem'] ) : ''; ?>"></div>
						<?php if( $element['showeletitle'] == 'yes' ) { ?>
							<span class="gtitle open-modal elementor-repeater-item-<?php echo esc_attr( $element['_id'] ); ?>" data-item-id="<?php echo isset( $element['styler_carousel_nav_post_element']['citem'] ) ? esc_attr( $element['styler_carousel_nav_post_element']['citem'] ) : ''; ?>">
								<?php echo $element['carousel_nav_post_element_title']; ?>
							</span>
						<?php } ?>
					<?php endforeach ?>
				</div>
			</div>
			<?php
		endwhile;
	else:
		echo '<h5>' . __( 'You need portfolio item to use this widget.', 'kata-plus' ) . '</h5>';
		echo '<p>' . __( 'Please create a new portfolio and also add the featured image to be previewed in the widget', 'kata-plus' ) . '</p>';
	endif;
	wp_reset_postdata();
	?>
</div>

	<?php if ( $settings['inc_owl_pag_num'] == 'dots-and-num' ) { ?>
	<div class="kata-owl-progress-bar"><div class="kata-progress-bar-inner dbg-color"></div></div>
	<?php } ?>

<div class="content-slider-num"></div>
	<?php if ( $settings['carousel_load_more'] == 'yes' ) : ?>
		<?php
		$text = ! empty( $settings['carousel_load_more_text'] ) ? $settings['carousel_load_more_text'] : '';
		$url  = Kata_Plus_Pro_Helpers::get_link_attr( $settings['carousel_load_more_link'] );
		?>
		<?php if ( $text ) : ?>
		<div class="kata-plus-carousel-button-wrapper">
			<a href="<?php echo esc_url( $url->src, Kata_Plus_Pro_Helpers::ssl_url() ); ?>"  class="kata-button" <?php echo $url->rel . $url->target; ?>>
				<?php if ( $settings['carousel_load_more_icon_position'] == 'before' ) : ?>
					<?php if ( $settings['carousel_load_more_icon'] ) : ?>
						<span class="kata-plus-align-icon-left">
							<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['carousel_load_more_icon'], '', 'aria-hidden="true"' ); ?>
						</span>
					<?php endif ?>
				<?php endif ?>

				<span <?php echo $this->get_render_attribute_string( 'carousel_load_more_text' ); ?><?php echo $this->get_render_attribute_string( 'servcbx_desc' ); ?>><?php echo $settings['carousel_load_more_text']; ?></span>

				<?php if ( $settings['carousel_load_more_icon_position'] == 'after' ) : ?>
					<?php if ( $settings['carousel_load_more_icon'] ) : ?>
						<span class="kata-plus-button-icon kata-plus-align-icon-right">
							<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $settings['carousel_load_more_icon'], '', 'aria-hidden="true"' ); ?>
						</span>
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
