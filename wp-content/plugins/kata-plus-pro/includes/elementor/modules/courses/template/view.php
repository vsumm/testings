<?php
/**
 * Blog course module view.
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

$course_thumbnail_float			= $settings['course_thumbnail_float'];
if ( $course_thumbnail_float == 'none' ){
	$course_repeaters			= $settings['course_repeaters'];
}else{
	$course_repeaters			= $settings['course_repeaters_2'];
}

$course_columns					= $settings['course_columns'] ? absint( $settings['course_columns'] ) : 2;
$course_columns_tablet			= $settings['course_columns_tablet'] ? absint( $settings['course_columns_tablet'] ) : '';
$course_columns_mobile			= $settings['course_columns_mobile'] ? absint( $settings['course_columns_mobile'] ) : '';
$course_per_page				= $settings['course_per_page'];

// Carousel Settings variables
$carousel_classes							= $settings['enable_carousel'] ? ' kata-owl owl-carousel owl-theme ' . $settings['inc_owl_pag_num'] : '';
$settings['inc_owl_arrow']					= $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
$settings['inc_owl_pag']					= $settings['inc_owl_pag'] == 'true' && $settings['inc_owl_pag_num'] != 'dots-and-num' ? 'true' : 'false';
$settings['inc_owl_loop']					= $settings['inc_owl_loop'] == 'true' ? 'true' : 'false';
$settings['inc_owl_autoplay']				= $settings['inc_owl_autoplay'] == 'true' ? 'true' : 'false';
$settings['inc_owl_center']					= $settings['inc_owl_center'] == 'yes' ? 'true' : 'false';
$settings['inc_owl_vert']					= $settings['inc_owl_vert'] == 'true' ? 'true' : 'false';
$animateout									= $settings['inc_owl_vert'] == 'true' ? 'fadeOutUp' : '';
$animatein									= $settings['inc_owl_vert'] == 'true' ? 'fadeInUp' : '';
$settings['inc_owl_rtl']					= $settings['inc_owl_rtl'] == 'true' ? 'true' : 'false';
$settings['inc_owl_item_tablet']			= $settings['inc_owl_item_tablet'] ? $settings['inc_owl_item_tablet'] : '2';
$settings['inc_owl_item_mobile']			= $settings['inc_owl_item_mobile'] ? $settings['inc_owl_item_mobile'] : '1';
$settings['inc_owl_stgpad_tablet']['size']	= $settings['inc_owl_stgpad_tablet']['size'] ? $settings['inc_owl_stgpad_tablet']['size'] : '0';
$settings['inc_owl_stgpad_mobile']['size']	= $settings['inc_owl_stgpad_mobile']['size'] ? $settings['inc_owl_stgpad_mobile']['size'] : '0';
$settings['inc_owl_margin_tablet']['size']	= $settings['inc_owl_margin_tablet']['size'] ? $settings['inc_owl_margin_tablet']['size'] : '0';
$settings['inc_owl_margin_mobile']['size']	= $settings['inc_owl_margin_mobile']['size'] ? $settings['inc_owl_margin_mobile']['size'] : '0';
$slide_speed								= $settings['inc_owl_spd']['size'];

$post_class_mobile = '';
$post_class_tablet = '';

if ( $settings['enable_carousel'] ) {
	$post_class = '';
} else {
	switch ( $course_columns ) {
		case 1:
			$post_class = 'course-columns-1 ';
			break;
		case 2:
			$post_class = 'course-columns-2 ';
			break;
		case 3:
			$post_class = 'course-columns-3 ';
			break;
		case 4:
			$post_class = 'course-columns-4 ';
			break;
		case 5:
			$post_class = 'course-columns-5 ';
			break;
		case 6:
			$post_class = 'course-columns-6 ';
			break;
	}

	switch ( $course_columns_tablet ) {
		case 1:
			$post_class_tablet = 'course-columns-t-1 ';
			break;
		case 2:
			$post_class_tablet = 'course-columns-t-2 ';
			break;
		case 3:
			$post_class_tablet = 'course-columns-t-3 ';
			break;
		case 4:
			$post_class_tablet = 'course-columns-t-4 ';
			break;
		case 5:
			$post_class_tablet = 'course-columns-t-5 ';
			break;
		case 6:
			$post_class_tablet = 'course-columns-t-6 ';
			break;
	}

	switch ( $course_columns_mobile ) {
		case 1:
			$post_class_mobile = 'course-columns-m-1 ';
			break;
		case 2:
			$post_class_mobile = 'course-columns-m-2 ';
			break;
		case 3:
			$post_class_mobile = 'course-columns-m-3 ';
			break;
		case 4:
			$post_class_mobile = 'course-columns-m-4 ';
			break;
		case 5:
			$post_class_mobile = 'course-columns-m-5 ';
			break;
		case 6:
			$post_class_mobile = 'course-columns-m-6 ';
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

$the_query = new \WP_Query(
	[
		'post_type'			=> 'lp_course',
		'post_status'		=> 'publish',
		'posts_per_page'	=> $course_per_page,
		'paged'				=> get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
		'course_category'	=> $category_name,
		'course_tag'		=> $tag_name,
		'orderby'			=> $settings['query_order_by'],
		'order'				=> $settings['query_order'],
	]
);

// start copy
if ( $settings['enable_carousel'] ) {
	?>
	<div class="kata-plus-course-wrap<?php echo esc_attr( $carousel_classes ); ?>"
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
<?php
} else {
	echo '<div class="kata-plus-course-wrap row">';
}

if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		global $course;
		?>
		<div <?php post_class( 'kata-plus-course ' . $post_class . $post_class_tablet . $post_class_mobile ); ?>>
			<div class="kata-plus-course-item">
				<?php
				if ( $settings['course_thumbnail_float'] == 'none' ) {
					foreach ( $course_repeaters as $index => $course_repeater ) :
						switch ( $course_repeater['course_repeater_select'] ) {
							case 'title':
								echo '<' . esc_attr( $course_repeater['courses_title_tag'] ) . ' class="kata-plus-course-title"><a href="' . get_permalink( $course->get_id() ) . '">' . $course->get_title() . '</a></' . esc_attr( $course_repeater['courses_title_tag'] ) . '>';
							break;
							case 'excerpt':
								echo '<p class="kata-plus-course-excerpt">' . Kata_Template_Tags::excerpt( $course_repeater['excerpt_length']['size'] ) . '</p>';
							break;
							case 'thumbnail':
								$thumbnail_size = 'custom' !== $course_repeater['thumbnail_size'] ? $course_repeater['thumbnail_size'] : [$course_repeater['courses_thumbnail_custom_size']['width'], $course_repeater['courses_thumbnail_custom_size']['height']];
								echo '<div class="kata-plus-course-thumbnail-wrapper kata-lazyload">';
									Kata_Helpers::image_resize_output( get_post_thumbnail_id(), $thumbnail_size );
								echo '</div>';
							break;
							case 'categories':
								if ( $course_repeater['start_mete_wrapper'] == 'yes' ){
									echo '<div class="kata-plus-course-metadata">';
								}
								echo '<span class="kata-plus-course-categories">' . Kata_Plus_Pro_Helpers::get_icon( '', $course_repeater['course_category_icon'], 'df-fill' ) .  get_the_term_list( get_the_ID(), 'course_category',  '', '<span class="separator">' . $course_repeater['terms_seperator'] . '</span>', '' ) .'</span>';
								if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
							case 'tags':
								if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
									echo '<div class="kata-plus-course-metadata">';
								}
								echo '<span class="kata-plus-course-tags">' . Kata_Plus_Pro_Helpers::get_icon( '', $course_repeater['course_tag_icon'], 'df-fill' ) . get_the_term_list( get_the_ID(), 'course_tag',  '', '<span class="separator">' . $course_repeater['terms_seperator'] . '</span>', '' ) . '</span>';
								if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
							case 'price':
								if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
									echo '<div class="kata-plus-course-metadata">';
								}
								if ( $course->get_price_html() ) {
									echo '<span class="kata-plus-course-price">';
										echo Kata_Plus_Pro_Helpers::get_icon( '', $course_repeater['course_price_icon'], 'df-fill' );
										if ( $course->has_sale_price() ) {
											echo '<span class="origin-price"> ' . $course->get_origin_price_html() . '</span>';
										}
										echo '<span class="price">' . esc_html( $course->get_price_html() ) . '</span>';
									echo '</span>';
								}
								if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
							case 'date':
								if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
									echo '<div class="kata-plus-course-metadata">';
								}
								echo Kata_Template_Tags::post_date( Kata_Plus_Pro_Helpers::get_icon( '', $course_repeater['course_date_icon'], 'df-fill' ), 'kata-plus-course-date' );
								if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
							case 'teacher':
								if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
									echo '<div class="kata-plus-course-metadata">';
								}
								Kata_Template_Tags::post_author(Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_teacher_icon'], 'df-fill' ), $course_repeater['course_teacher_symbol'], $course_repeater['avatar_size']);
								if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
						}
					endforeach;
				} else {
					if ( $settings['course_thumbnail_float'] == 'left' ) {
						echo '<div class="row">';
							$thumbnail_size = 'custom' !== $course_repeater['thumbnail_size'] ? $course_repeater['thumbnail_size'] : [$course_repeater['courses_thumbnail_custom_size']['width'], $course_repeater['courses_thumbnail_custom_size']['height']];
							echo '<div class="kata-plus-course-thumbnail-wrapper kata-lazyload kata-plus-course-thumbnail-position-' . esc_attr( $course_thumbnail_float ) . ' col-sm-4">';
							Kata_Helpers::image_resize_output( get_post_thumbnail_id(), $thumbnail_size );
							echo '</div>';
							echo '<div class="kata-plus-course-content-wrapper col-sm-8">';
								foreach ( $course_repeaters as $index => $course_repeater ) :
									switch ( $course_repeater['course_repeater_select_2'] ) {
										case 'title':
											echo '<' . esc_attr( $course_repeater['courses_title_tag']) . ' class="kata-plus-course-title"><a href="' . get_permalink( $course->get_id()) . '">' . $course->get_title() . '</a></' . esc_attr( $course_repeater['courses_title_tag']) . '>';
										break;
										case 'excerpt':
											echo '<p class="kata-plus-course-excerpt">' . Kata_Template_Tags::excerpt( $course_repeater['excerpt_length']['size']) . '</p>';
										break;
										case 'categories':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											echo '<span class="kata-plus-course-categories">' . Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_category_icon'], 'df-fill' ) .  get_the_term_list(get_the_ID(), 'course_category',  '', '<span class="separator">' . $course_repeater['terms_seperator'] . '</span>', '' ) . '</span>';
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'tags':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											echo '<span class="kata-plus-course-tags">' . Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_tag_icon'], 'df-fill' ) . get_the_term_list(get_the_ID(), 'course_tag',  '', '<span class="separator">' . $course_repeater['terms_seperator'] . '</span>', '' ) . '</span>';
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'price':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											if ( $course->get_price_html()) {
												echo '<span class="kata-plus-course-price">';
												echo Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_price_icon'], 'df-fill' );
												if ( $course->has_sale_price()) {
													echo '<span class="origin-price"> ' . $course->get_origin_price_html() . '</span>';
												}
												echo '<span class="price">' . esc_html( $course->get_price_html()) . '</span>';
												echo '</span>';
											}
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'date':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											echo Kata_Template_Tags::post_date( Kata_Plus_Pro_Helpers::get_icon( '', $course_repeater['course_date_icon'], 'df-fill' ), 'kata-plus-course-date' );
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'teacher':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											Kata_Template_Tags::post_author(Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_teacher_icon'], 'df-fill' ), $course_repeater['course_teacher_symbol'], $course_repeater['avatar_size']);
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
									}
								endforeach;
							echo '</div>';
						echo '</div>';
					}elseif ( $settings['course_thumbnail_float'] == 'right' ) {
						echo '<div class="row">';
							echo '<div class="kata-plus-course-content-wrapper col-sm-8">';
								foreach ( $course_repeaters as $index => $course_repeater) :
									switch ( $course_repeater['course_repeater_select_2']) {
										case 'title':
											echo '<' . esc_attr( $course_repeater['courses_title_tag']) . ' class="kata-plus-course-title"><a href="' . get_permalink( $course->get_id()) . '">' . $course->get_title() . '</a></' . esc_attr( $course_repeater['courses_title_tag']) . '>';
											break;
										case 'excerpt':
											echo '<p class="kata-plus-course-excerpt">' . Kata_Template_Tags::excerpt( $course_repeater['excerpt_length']['size']) . '</p>';
											break;
										case 'categories':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											echo '<span class="kata-plus-course-categories">' . Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_category_icon'], 'df-fill' ) .  get_the_term_list(get_the_ID(), 'course_category',  '', '<span class="separator">' . $course_repeater['terms_seperator'] . '</span>', '' ) . '</span>';
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'tags':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											echo '<span class="kata-plus-course-tags">' . Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_tag_icon'], 'df-fill' ) . get_the_term_list(get_the_ID(), 'course_tag',  '', '<span class="separator">' . $course_repeater['terms_seperator'] . '</span>', '' ) . '</span>';
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'price':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											if ( $course->get_price_html()) {
												echo '<span class="kata-plus-course-price">';
												echo Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_price_icon'], 'df-fill' );
												if ( $course->has_sale_price()) {
													echo '<span class="origin-price"> ' . $course->get_origin_price_html() . '</span>';
												}
												echo '<span class="price">' . esc_html( $course->get_price_html()) . '</span>';
												echo '</span>';
											}
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'date':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											echo Kata_Template_Tags::post_date(Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_date_icon'], 'df-fill' ), 'kata-plus-course-date' );
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
										case 'teacher':
											if ( $course_repeater['start_mete_wrapper'] == 'yes' ) {
												echo '<div class="kata-plus-course-metadata">';
											}
											Kata_Template_Tags::post_author(Kata_Plus_Pro_Helpers::get_icon('', $course_repeater['course_teacher_icon'], 'df-fill' ), $course_repeater['course_teacher_symbol'], $course_repeater['avatar_size']);
											if ( $course_repeater['end_mete_wrapper'] == 'yes' ) {
												echo '</div>';
											}
										break;
									}
								endforeach;
							echo '</div>';
							$thumbnail_size = 'custom' !== $course_repeater['thumbnail_size'] ? $course_repeater['thumbnail_size'] : [$course_repeater['courses_thumbnail_custom_size']['width'], $course_repeater['courses_thumbnail_custom_size']['height']];
							echo '<div class="kata-plus-course-thumbnail-wrapper kata-lazyload kata-plus-course-thumbnail-position-' . esc_attr( $course_thumbnail_float ) . ' col-sm-4">';
							Kata_Helpers::image_resize_output(get_post_thumbnail_id(), $thumbnail_size);
							echo '</div>';
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
		<?php
	endwhile;

	// course Pagination
	if ( $settings['course_pagination'] && ! $settings['enable_carousel'] ) {
		echo '<div class="kata-plus-course-pagination">';
			echo paginate_links(
				array(
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'total'        => $the_query->max_num_pages,
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'format'       => '?paged=%#%',
					'show_all'     => false,
					'type'         => 'plain',
					'end_size'     => 2,
					'mid_size'     => 1,
					'prev_next'    => false,
					'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer course', 'kata-plus-plus' ) ),
					'next_text'    => sprintf( '%1$s <i></i>', __( 'Older course', 'kata-plus-plus' ) ),
					'add_args'     => false,
					'add_fragment' => '',
				)
			);
		echo '</div>';
	}
	wp_reset_postdata();
endif;

echo '</div> <!-- kata-plus-course-wrap -->';
?>

<?php if ( $settings['inc_owl_pag_num'] == 'dots-and-num' ) { ?>
	<div class="kata-owl-progress-bar"><div class="kata-progress-bar-inner dbg-color"></div></div>
	<?php
}
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
// end copy