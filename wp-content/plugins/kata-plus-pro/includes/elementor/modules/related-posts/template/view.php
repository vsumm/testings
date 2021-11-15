<?php
/**
 * Related Posts module view.
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

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

$post_columns			= $settings['post_columns'] ? absint( $settings['post_columns'] ) : 2;
$post_columns_tablet	= $settings['post_columns_tablet'] ? absint( $settings['post_columns_tablet'] ) : '';
$post_columns_mobile	= $settings['post_columns_mobile'] ? absint( $settings['post_columns_mobile'] ) : '';
$post_per_page			= $settings['post_per_page'];

// Carousel Settings variables
$carousel_classes							= $settings['enable_carousel'] ? ' kata-owl owl-carousel owl-theme ' . $settings['inc_owl_pag_num'] : '';
$settings['inc_owl_arrow']					= $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
$settings['inc_owl_pag']					= $settings['inc_owl_pag'] == 'true' && $settings['inc_owl_pag_num'] != 'dots-and-num' ? 'true' : 'false';
$settings['inc_owl_loop']					= $settings['inc_owl_loop'] == 'true' ? 'true' : 'false';
$settings['inc_owl_autoplay']				= $settings['inc_owl_autoplay'] == 'true' ? 'true' : 'false';
$settings['inc_owl_center']					= $settings['inc_owl_center'] == 'yes' ? 'true' : 'false';
$settings['active_item']					= isset( $settings['active_item'] ) && $settings['inc_owl_center'] !== 'true' ? $settings['active_item'] : 'none';
$settings['inc_owl_vert']					= $settings['inc_owl_vert'] == 'true' ? 'true' : 'false';
$animateout									= $settings['inc_owl_vert'] == 'true' ? 'fadeOutUp' : '';
$animatein									= $settings['inc_owl_vert'] == 'true' ? 'fadeInUp' : '';
$settings['inc_owl_rtl']					= $settings['inc_owl_rtl'] == 'true' ? 'true' : 'false';
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
$settings['inc_owl_stgpad_tablet']['size']	= $settings['inc_owl_stgpad_tablet']['size'] ? $settings['inc_owl_stgpad_tablet']['size'] : '0';
$settings['inc_owl_stgpad_mobile']['size']	= $settings['inc_owl_stgpad_mobile']['size'] ? $settings['inc_owl_stgpad_mobile']['size'] : '0';
$settings['inc_owl_margin_tablet']['size']	= $settings['inc_owl_margin_tablet']['size'] ? $settings['inc_owl_margin_tablet']['size'] : '0';
$settings['inc_owl_margin_mobile']['size']	= $settings['inc_owl_margin_mobile']['size'] ? $settings['inc_owl_margin_mobile']['size'] : '0';
$slide_speed								= $settings['inc_owl_spd']['size'];
$x = 'yes' == $settings['first_post'] ? 1 : '';
$j = 1;
$post_class_mobile = '';
$post_class_tablet = '';

if ( $settings['enable_carousel'] ) {
	$post_class = '';
} else {
	switch ( $post_columns ) {
		case 1:
			$post_class = 'posts-columns-1 ';
			break;
		case 2:
			$post_class = 'posts-columns-2 ';
			break;
		case 3:
			$post_class = 'posts-columns-3 ';
			break;
		case 4:
			$post_class = 'posts-columns-4 ';
			break;
		case 5:
			$post_class = 'posts-columns-5 ';
			break;
		case 6:
			$post_class = 'posts-columns-6 ';
			break;
	}
	switch ( $post_columns_tablet ) {
		case 1:
			$post_class_tablet = 'posts-columns-t-1 ';
			break;
		case 2:
			$post_class_tablet = 'posts-columns-t-2 ';
			break;
		case 3:
			$post_class_tablet = 'posts-columns-t-3 ';
			break;
		case 4:
			$post_class_tablet = 'posts-columns-t-4 ';
			break;
		case 5:
			$post_class_tablet = 'posts-columns-t-5 ';
			break;
		case 6:
			$post_class_tablet = 'posts-columns-t-6 ';
			break;
	}
	switch ( $post_columns_mobile ) {
		case 1:
			$post_class_mobile = 'posts-columns-m-1 ';
			break;
		case 2:
			$post_class_mobile = 'posts-columns-m-2 ';
			break;
		case 3:
			$post_class_mobile = 'posts-columns-m-3 ';
			break;
		case 4:
			$post_class_mobile = 'posts-columns-m-4 ';
			break;
		case 5:
			$post_class_mobile = 'posts-columns-m-5 ';
			break;
		case 6:
			$post_class_mobile = 'posts-columns-m-6 ';
			break;
	}
}

// Query variables
$query_categories = $settings['query_categories'];
$last_category    = end( $query_categories );
$category_name    = '';
foreach ( $query_categories as $key => $value ) {
	$category_name .= $value;
	if ( $value != $last_category ) {
		$category_name .= ', ';
	}
}
$query_tags = $settings['query_tags'];
$last_tag   = end( $query_tags );
$tag_name   = '';
foreach ( $query_tags as $key => $value ) {
	$tag_name .= $value;
	if ( $value != $last_tag ) {
		$tag_name .= ', ';
	}
}

if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
	$paged = get_query_var('page');
} else {
	$paged = 1;
}

if ( 'most_liked' == $settings['query_order_by'] ) {
	if( $settings['post_pagination'] && ! $settings['enable_carousel'] ) {
		$the_query = new \WP_Query(
			[
				'post_type'      	=> 'post',
				'post_status'    	=> 'publish',
				'posts_per_page' 	=> $post_per_page,
				'paged'          	=> $paged,
				'category_name'  	=> $category_name,
				'tag'            	=> $tag_name,
				'meta_key'			=> '_zilla_likes',
				'orderby'			=> [
					'meta_value_num' => $settings['query_order'],
				],
				'post__not_in'		=> [get_the_ID()],
				'tax_query'			=> [
					'relation' => 'OR',
					[
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => wp_get_post_categories( get_the_ID(), ['fields' => 'slugs'] ),
					],
					[
						'taxonomy' => 'tag',
						'field'    => 'slug',
						'terms'    => wp_get_post_tags( get_the_ID(), ['fields' => 'slugs'] ),
					],
				],
			]
		);
	} else {
		$the_query = new \WP_Query(
			[
				'post_type'			=> 'post',
				'post_status'		=> 'publish',
				'posts_per_page' 	=> $post_per_page,
				'category_name'		=> $category_name,
				'tag'				=> $tag_name,
				'meta_key'			=> '_zilla_likes',
				'orderby'			=> [
					'meta_value_num' => $settings['query_order'],
				],
				'post__not_in'		=> [get_the_ID()],
				'tax_query'			=> [
					'relation' => 'OR',
					[
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => wp_get_post_categories( get_the_ID(), ['fields' => 'slugs'] ),
					],
					[
						'taxonomy' => 'tag',
						'field'    => 'slug',
						'terms'    => wp_get_post_tags( get_the_ID(), ['fields' => 'slugs'] ),
					],
				],
			]
		);
	}
} else if ( 'most_viewed' == $settings['query_order_by'] ) {
	if( $settings['post_pagination'] && ! $settings['enable_carousel'] ) {
		$the_query = new \WP_Query(
			[
				'post_type'      	=> 'post',
				'post_status'    	=> 'publish',
				'posts_per_page' 	=> $post_per_page,
				'paged'          	=> $paged,
				'category_name'  	=> $category_name,
				'tag'            	=> $tag_name,
				'meta_key'			=> 'kata_post_view',
				'post__not_in'		=> [get_the_ID()],
				'tax_query'			=> [
					'relation' => 'OR',
					[
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => wp_get_post_categories( get_the_ID(), ['fields' => 'slugs'] ),
					],
					[
						'taxonomy' => 'tag',
						'field'    => 'slug',
						'terms'    => wp_get_post_tags( get_the_ID(), ['fields' => 'slugs'] ),
					],
				],
				'orderby'			=> [
					'meta_value_num' => $settings['query_order'],
				],
			]
		);
	} else {
		$the_query = new \WP_Query(
			[
				'post_type'			=> 'post',
				'post_status'		=> 'publish',
				'posts_per_page' 	=> $post_per_page,
				'category_name'		=> $category_name,
				'tag'				=> $tag_name,
				'meta_key'			=> 'kata_post_view',
				'category__in'		=> wp_get_post_categories( get_the_ID() ),
				'post__not_in'		=> [get_the_ID()],
				'orderby'			=> [
					'meta_value_num' => $settings['query_order'],
				],
			]
		);
	}
} else {
	if( $settings['post_pagination'] && ! $settings['enable_carousel'] ) {
		$the_query = new \WP_Query(
			[
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => $post_per_page,
				'paged'          => $paged,
				'category_name'  => $category_name,
				'tag'            => $tag_name,
				'orderby'        => $settings['query_order_by'],
				'order'          => $settings['query_order'],
				'post__not_in'	 => [get_the_ID()],
				'tax_query' => [
					'relation' => 'AND',
					[
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => wp_get_post_categories( get_the_ID(), ['fields' => 'slugs'] ),
					],
					[
						'taxonomy' => 'tag',
						'field'    => 'slug',
						'terms'    => wp_get_post_tags( get_the_ID(), ['fields' => 'slugs'] ),
					],
				],
			]
		);
	} else {
		$the_query = new \WP_Query(
			[
				'post_type'			=> 'post',
				'post_status'		=> 'publish',
				'posts_per_page'	=> $post_per_page,
				'category_name'		=> $category_name,
				'tag'				=> $tag_name,
				'orderby'			=> $settings['query_order_by'],
				'order'				=> $settings['query_order'],
				'post__not_in'		=> [get_the_ID()],
				'tax_query' => [
					'relation' => 'AND',
					[
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => wp_get_post_categories( get_the_ID(), ['fields' => 'slugs'] ),
					],
					[
						'taxonomy' => 'tag',
						'field'    => 'slug',
						'terms'    => wp_get_post_tags( get_the_ID(), ['fields' => 'slugs'] ),
					],
				],
			]
		);
	}
}

if ( ! $the_query->posts ) {
	$the_query = new WP_Query(
		[
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $post_per_page,
			'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			'post__not_in'   => [get_the_ID()], 
			'orderby'        => $settings['query_order_by'],
			'order'          => $settings['query_order'],
		]
	);
}

// start copy
if ( $settings['enable_carousel'] ) {
	?>
	<div
	class="kata-blog-posts<?php echo esc_attr( $carousel_classes ); ?>"
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
	data-inc_owl_prev="<?php echo base64_encode( Kata_Plus_Helpers::get_icon( '', $settings['inc_owl_prev'], '', '' ) ); ?>"
	data-inc_owl_nxt="<?php echo base64_encode( Kata_Plus_Helpers::get_icon( '', $settings['inc_owl_nxt'], '', '' ) ); ?>"
	data-inc_owl_rtl="<?php echo esc_attr( $settings['inc_owl_rtl'] ); ?>"
	data-active-item="<?php echo esc_attr( $settings['active_item'] ); ?>"
>
<?php
} else {
	echo '<div class="kata-blog-posts">';
}

if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		global $post;
		if ( $x == 1 ) {
			++$x;
			?>
			<div <?php post_class( 'kata-blog-post kata-first-post posts-columns-1' ); ?>>
				<?php
				foreach ( $settings['post_repeaters_2'] as $index => $post_repeater ) :
					$post_repeater['date_format_1'] = 'yes' == $post_repeater['custom_date_format'] && isset( $post_repeater['date_format_1'] ) && ! empty( $post_repeater['date_format_1'] ) ? $post_repeater['date_format_1'] : '';
					$post_repeater['date_format_2'] = 'yes' == $post_repeater['custom_date_format'] && isset( $post_repeater['date_format_2'] ) && ! empty( $post_repeater['date_format_2'] ) ? $post_repeater['date_format_2'] : '';
					$post_repeater['date_format_3'] = 'yes' == $post_repeater['custom_date_format'] && isset( $post_repeater['date_format_3'] ) && ! empty( $post_repeater['date_format_3'] ) ? $post_repeater['date_format_3'] : '';
					switch ( $post_repeater['post_repeater_select_2'] ) {
						case 'title':
							echo '<' . esc_attr( $post_repeater['posts_title_tag'] ) . ' class="kata-post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></' . esc_attr( $post_repeater['posts_title_tag'] ) . '>';
						break;
						case 'excerpt':
							echo '<p class="kata-post-excerpt">' . Kata_Template_Tags::excerpt( $post_repeater['excerpt_length']['size'] ) . '</p>';
						break;
						case 'thumbnail':
							if ( has_post_thumbnail( get_the_ID() ) ) {
								$post_repeater['posts_thumbnail_custom_size']['width'] = $post_repeater['posts_thumbnail_custom_size']['width'] ? $post_repeater['posts_thumbnail_custom_size']['width'] : 150;
								$post_repeater['posts_thumbnail_custom_size']['height'] = $post_repeater['posts_thumbnail_custom_size']['height'] ? $post_repeater['posts_thumbnail_custom_size']['height'] : 150;
								$thumbnail_size = 'custom' !== $post_repeater['thumbnail_size'] ? $post_repeater['thumbnail_size'] : [$post_repeater['posts_thumbnail_custom_size']['width'], $post_repeater['posts_thumbnail_custom_size']['height']];
								$video = Kata_Plus_Helpers::video_player( Kata_Plus_Helpers::get_meta_box( 'kata_post_video', get_the_ID() ) ) ? Kata_Plus_Helpers::video_player( Kata_Plus_Helpers::get_meta_box( 'kata_post_video', get_the_ID() ) ) : '';
								echo '<div class="kata-post-thumbnail kata-lazyload"' . $video . '>';
									echo '<a href="' . get_the_permalink() . '">';
										Kata_Plus_Helpers::image_resize_output( get_post_thumbnail_id(), $thumbnail_size );
									echo '</a>';
								echo '</div>';
							}
						break;
						case 'post_format':
							if ( class_exists( 'Kata_Plus_Helpers' ) ) {
								$post_format_icons = [
									'gallery'	=> $post_repeater['post_format_gallery_icon'],
									'link'		=> $post_repeater['post_format_link_icon'],
									'image'		=> $post_repeater['post_format_image_icon'],
									'quote'		=> $post_repeater['post_format_quote_icon'],
									'status'	=> $post_repeater['post_format_status_icon'],
									'video'		=> $post_repeater['post_format_video_icon'],
									'aside'		=> $post_repeater['post_format_aside_icon'],
									'standard'	=> $post_repeater['post_format_standard_icon'],
								];
								Kata_Plus_Helpers::post_format_icon( $post_format_icons );
							}
						break;
						case 'categories':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_categories( $post_repeater['terms_separator'], Kata_Plus_Helpers::get_icon( '', $post_repeater['post_category_icon'], 'df-fill' ) );
							}
						break;
						case 'tags':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_tags( $post_repeater['terms_separator'], Kata_Plus_Helpers::get_icon( '', $post_repeater['post_tag_icon'], 'df-fill' ) );
							}
						break;
						case 'date':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_date( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_date_icon'], 'df-fill' ), $post_repeater['date_format_1'], $post_repeater['date_format_2'], $post_repeater['date_format_3'] );
							}
						break;
						case 'comments':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_comments_number( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_comments_icon'], 'df-fill' ) );
							}
						break;
						case 'author':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_author( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_author_icon'], 'df-fill' ), $post_repeater['post_author_symbol'], $post_repeater['avatar_size'] );
							}
						break;
						case 'time_to_read':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_time_to_read( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_time_to_read_icon'], 'df-fill' ) );
							}
						break;
						case 'share_post':
							Kata_Template_Tags::social_share( 'toggle', $post_repeater['share_post_icon'] );
						break;
						case 'share_post_counter':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_share_count( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_share_post_counter_icon'], 'df-fill' ) );
							}
						break;
						case 'post_like':
							if ( function_exists( 'zilla_likes' ) ) {
								zilla_likes();
							}
						break;
						case 'post_view':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_view( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_view_icon'], 'df-fill' ) );
							}
						break;
						case 'read_more':
							echo '<a href="' . get_the_permalink() . '" class="kata-post-readmore">' . wp_kses_post( $post_repeater['read_more_text'] ) . '</a>';
						break;
						case 'start_content_wrapper':
							echo '<div class="kata-post-content">';
						break;
						case 'end_content_wrapper':
							echo '</div>';
						break;
						case 'start_meta_data_wrapper':
							echo '<div class="kata-post-metadata">';
						break;
						case 'end_meta_data_wrapper':
							echo '</div>';
						break;
					}
				endforeach;
				?>
			</div>
			<?php
			continue;
		} else {
			if ( $j == 1 && ! $settings['enable_carousel'] ) {
				?><div class="ktbl-post-wrapper row"><?php
			} ?>
			<div <?php post_class( 'kata-blog-post ' . $post_class . $post_class_tablet . $post_class_mobile ); ?>>
				<?php
				foreach ( $settings['post_repeaters'] as $index => $post_repeater ) :
					$post_repeater['date_format_1'] = 'yes' == $post_repeater['custom_date_format'] && isset( $post_repeater['date_format_1'] ) && ! empty( $post_repeater['date_format_1'] ) ? $post_repeater['date_format_1'] : '';
					$post_repeater['date_format_2'] = 'yes' == $post_repeater['custom_date_format'] && isset( $post_repeater['date_format_2'] ) && ! empty( $post_repeater['date_format_2'] ) ? $post_repeater['date_format_2'] : '';
					$post_repeater['date_format_3'] = 'yes' == $post_repeater['custom_date_format'] && isset( $post_repeater['date_format_3'] ) && ! empty( $post_repeater['date_format_3'] ) ? $post_repeater['date_format_3'] : '';
					switch ( $post_repeater['post_repeater_select'] ) {
						case 'title':
							echo '<' . esc_attr( $post_repeater['posts_title_tag'] ) . ' class="kata-post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></' . esc_attr( $post_repeater['posts_title_tag'] ) . '>';
						break;
						case 'excerpt':
							echo '<p class="kata-post-excerpt">' . Kata_Template_Tags::excerpt( $post_repeater['excerpt_length']['size'] ) . '</p>';
						break;
						case 'thumbnail':
							if ( has_post_thumbnail( get_the_ID() ) ) {
								$post_repeater['posts_thumbnail_custom_size']['width'] = $post_repeater['posts_thumbnail_custom_size']['width'] ? $post_repeater['posts_thumbnail_custom_size']['width'] : 150;
								$post_repeater['posts_thumbnail_custom_size']['height'] = $post_repeater['posts_thumbnail_custom_size']['height'] ? $post_repeater['posts_thumbnail_custom_size']['height'] : 150;
								$thumbnail_size = 'custom' !== $post_repeater['thumbnail_size'] ? $post_repeater['thumbnail_size'] : [$post_repeater['posts_thumbnail_custom_size']['width'], $post_repeater['posts_thumbnail_custom_size']['height']];
								$video = Kata_Plus_Helpers::video_player( Kata_Plus_Helpers::get_meta_box( 'kata_post_video', get_the_ID() ) ) ? Kata_Plus_Helpers::video_player( Kata_Plus_Helpers::get_meta_box( 'kata_post_video', get_the_ID() ) ) : '';
								echo '<div class="kata-post-thumbnail kata-lazyload"' . $video . '>';
									echo '<a href="' . get_the_permalink() . '">';
										Kata_Plus_Helpers::image_resize_output( get_post_thumbnail_id(), $thumbnail_size );
									echo '</a>';
								echo '</div>';
							}
						break;
						case 'post_format':
							if ( class_exists( 'Kata_Plus_Helpers' ) ) {
								$post_format_icons = [
									'gallery'	=> $post_repeater['post_format_gallery_icon'],
									'link'		=> $post_repeater['post_format_link_icon'],
									'image'		=> $post_repeater['post_format_image_icon'],
									'quote'		=> $post_repeater['post_format_quote_icon'],
									'status'	=> $post_repeater['post_format_status_icon'],
									'video'		=> $post_repeater['post_format_video_icon'],
									'aside'		=> $post_repeater['post_format_aside_icon'],
									'standard'	=> $post_repeater['post_format_standard_icon'],
								];
								Kata_Plus_Helpers::post_format_icon( $post_format_icons );
							}
						break;
						case 'categories':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_categories( $post_repeater['terms_separator'], Kata_Plus_Helpers::get_icon( '', $post_repeater['post_category_icon'], 'df-fill' ) );
							}
						break;
						case 'tags':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_tags( $post_repeater['terms_separator'], Kata_Plus_Helpers::get_icon( '', $post_repeater['post_tag_icon'], 'df-fill' ) );
							}
						break;
						case 'date':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_date( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_date_icon'], 'df-fill' ), $post_repeater['date_format_1'], $post_repeater['date_format_2'], $post_repeater['date_format_3'] );
							}
						break;
						case 'comments':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_comments_number( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_comments_icon'], 'df-fill' ) );
							}
						break;
						case 'author':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_author( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_author_icon'], 'df-fill' ), $post_repeater['post_author_symbol'], $post_repeater['avatar_size'] );
							}
						break;
						case 'time_to_read':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_time_to_read( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_time_to_read_icon'], 'df-fill' ) );
							}
						break;
						case 'share_post':
							Kata_Template_Tags::social_share( 'toggle', $post_repeater['share_post_icon'] );
						break;
						case 'share_post_counter':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_share_count( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_share_post_counter_icon'], 'df-fill' ) );
							}
						break;
						case 'post_like':
							if ( function_exists( 'zilla_likes' ) ) {
								zilla_likes();
							}
						break;
						case 'post_view':
							if ( class_exists( 'Kata_Template_Tags' ) ) {
								Kata_Template_Tags::post_view( Kata_Plus_Helpers::get_icon( '', $post_repeater['post_view_icon'], 'df-fill' ) );
							}
						break;
						case 'read_more':
							echo '<a href="' . get_the_permalink() . '" class="kata-post-readmore">' . wp_kses_post( $post_repeater['read_more_text'] ) . '</a>';
						break;
						case 'start_content_wrapper':
							echo '<div class="kata-post-content">';
						break;
						case 'end_content_wrapper':
							echo '</div>';
						break;
						case 'start_meta_data_wrapper':
							echo '<div class="kata-post-metadata">';
						break;
						case 'end_meta_data_wrapper':
							echo '</div>';
						break;
					}
				endforeach;
				?>
			</div>
			<?php
			if ( ! $settings['enable_carousel'] ) {
				++$j;
				if ( $the_query->found_posts < $post_per_page && ( $j - 1 ) == $the_query->found_posts && 'yes' != $settings['first_post'] ) {
					echo '</div>';
				} else if ( $the_query->found_posts <= $post_per_page && $j == $the_query->found_posts && 'yes' == $settings['first_post'] ) {
					echo '</div>';
				} else if ( ( $j - 1 ) == $post_per_page && 'yes' != $settings['first_post'] ) {
					echo '</div>';
				} else if ( $j == $post_per_page && 'yes' == $settings['first_post'] ) {
					echo '</div>';
				} else if ( $j < $post_per_page && ( $the_query->current_post + 1 ) == $the_query->post_count && 'yes' == $settings['first_post'] ) {
					echo '</div>';
				} else if ( $j < $post_per_page && ( $the_query->current_post + 1 ) == $the_query->post_count && 'yes' != $settings['first_post'] ) {
					echo '</div>';
				} else if ( $j <= $post_per_page && ( $the_query->current_post + 1 ) == $the_query->post_count && 'yes' != $settings['first_post'] ) {
					echo '</div>';
				} else if ( $post_per_page == -1 && ( $the_query->current_post + 1 ) == $the_query->post_count && 'yes' == $settings['first_post'] ) {
					echo '</div>';
				} else if ( $post_per_page == -1 && ( $the_query->current_post + 1 ) == $the_query->post_count && 'yes' != $settings['first_post'] ) {
					echo '</div>';
				}
			}
		}
	endwhile;

	// post Pagination
	if ( $settings['post_pagination'] && ! $settings['enable_carousel'] ) {
		echo '<div class="kata-post-pagination">';
			echo paginate_links(
				array(
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'total'        => $the_query->max_num_pages,
					'current'      => max( 1, $paged ),
					'format'       => '?paged=%#%',
					'show_all'     => false,
					'type'         => 'plain',
					'end_size'     => 2,
					'mid_size'     => 1,
					'prev_next'    => false,
					'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer post', 'kata-plus-plus' ) ),
					'next_text'    => sprintf( '%1$s <i></i>', __( 'Older post', 'kata-plus-plus' ) ),
					'add_args'     => false,
					'add_fragment' => '',
				)
			);
		echo '</div>';
	}
	wp_reset_query();
	wp_reset_postdata();
endif;

echo '</div> <!-- kata-plus-post-wrap -->';
?>

<?php if ( $settings['inc_owl_pag_num'] == 'dots-and-num' ) { ?>
	<div class="kata-owl-progress-bar">
		<div class="kata-progress-bar-inner dbg-color"></div>
	</div>
	<?php
}
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
// end copy