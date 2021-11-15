<?php
/**
 * Blog product module view.
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

$product_thumbnail_float			= $settings['product_thumbnail_float'];
if ( $product_thumbnail_float == 'none' ){
	$product_repeaters			= $settings['product_repeaters'];
}else{
	$product_repeaters			= $settings['product_repeaters_2'];
}

$product_columns					= $settings['product_columns'] ? absint( $settings['product_columns'] ) : 2;
$product_columns_tablet			= $settings['product_columns_tablet'] ? absint( $settings['product_columns_tablet'] ) : '';
$product_columns_mobile			= $settings['product_columns_mobile'] ? absint( $settings['product_columns_mobile'] ) : '';
$product_per_page				= $settings['product_per_page'];

$start_mete_wrapper				= isset( $settings['start_mete_wrapper'] ) ? $settings['start_mete_wrapper'] : '';
$end_mete_wrapper				= isset( $settings['end_mete_wrapper'] ) ? $settings['end_mete_wrapper'] : '';

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
	switch ( $product_columns ) {
		case 1:
			$post_class = 'product-columns-1 ';
			break;
		case 2:
			$post_class = 'product-columns-2 ';
			break;
		case 3:
			$post_class = 'product-columns-3 ';
			break;
		case 4:
			$post_class = 'product-columns-4 ';
			break;
		case 5:
			$post_class = 'product-columns-5 ';
			break;
		case 6:
			$post_class = 'product-columns-6 ';
			break;
	}

	switch ( $product_columns_tablet ) {
		case 1:
			$post_class_tablet = 'product-columns-t-1 ';
			break;
		case 2:
			$post_class_tablet = 'product-columns-t-2 ';
			break;
		case 3:
			$post_class_tablet = 'product-columns-t-3 ';
			break;
		case 4:
			$post_class_tablet = 'product-columns-t-4 ';
			break;
		case 5:
			$post_class_tablet = 'product-columns-t-5 ';
			break;
		case 6:
			$post_class_tablet = 'product-columns-t-6 ';
			break;
	}

	switch ( $product_columns_mobile ) {
		case 1:
			$post_class_mobile = 'product-columns-m-1 ';
			break;
		case 2:
			$post_class_mobile = 'product-columns-m-2 ';
			break;
		case 3:
			$post_class_mobile = 'product-columns-m-3 ';
			break;
		case 4:
			$post_class_mobile = 'product-columns-m-4 ';
			break;
		case 5:
			$post_class_mobile = 'product-columns-m-5 ';
			break;
		case 6:
			$post_class_mobile = 'product-columns-m-6 ';
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
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $product_per_page,
		'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
		'orderby'        => $settings['query_order_by'],
		'order'          => $settings['query_order'],
		'tax_query'		=> [
			'relation'	=> 'OR',
			[
				'taxonomy'	=> 'product_cat',
				'field'		=> 'slug',
				'terms'		=> $query_categories,
			],
			[
				'taxonomy'	=> 'product_tag',
				'field'		=> 'slug',
				'terms'		=> $query_tags,
			]
		]
	]
);

// start copy
if ( $settings['enable_carousel'] ) {
	?>
	<div
	class="kata-plus-product-wrap kata-owl owl-carousel owl-theme <?php echo esc_attr( $carousel_classes ); ?>"
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
	echo '<div class="kata-plus-product-wrap row">';
}

if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		global $product;
		?>
		<div <?php post_class( 'kata-plus-product ' . $post_class . $post_class_tablet . $post_class_mobile ); ?>>
			<div class="kata-plus-product-item">
				<?php
				if ($settings['product_thumbnail_float'] == 'none') {
					foreach ( $product_repeaters as $index => $product_repeater ) :
						switch ( $product_repeater['product_repeater_select'] ) {
							case 'title':
								echo '<' . esc_attr( $product_repeater['products_title_tag'] ) . ' class="kata-plus-product-title"><a href="' . get_permalink( $product->get_id() ) . '">' . $product->get_title() . '</a></' . esc_attr( $product_repeater['products_title_tag'] ) . '>';
							break;
							case 'excerpt':
								echo '<p class="kata-plus-product-excerpt">' . Kata_Template_Tags::excerpt( $product_repeater['excerpt_length']['size'] ) . '</p>';
							break;
							case 'thumbnail':
								$thumbnail_size = 'custom' !== $product_repeater['thumbnail_size'] ? $product_repeater['thumbnail_size'] : [$product_repeater['products_thumbnail_custom_size']['width'], $product_repeater['products_thumbnail_custom_size']['height']];
								echo '<div class="kata-plus-product-thumbnail-wrapper kata-lazyload">';
									Kata_Helpers::image_resize_output( get_post_thumbnail_id(), $thumbnail_size );
								echo '</div>';
							break;
							case 'categories':
								if ( $product_repeater['start_mete_wrapper'] == 'yes' ){
									echo '<div class="kata-plus-product-metadata">';
								}
								if ( isset( $product_repeater['product_cat_icon'] ) ) {
									echo '<span class="kata-plus-product-categories">' . Kata_Plus_Pro_Helpers::get_icon( '', $product_repeater['product_cat_icon'], 'df-fill' ) .  get_the_term_list( get_the_ID(), 'product_cat',  '', '<span class="separator">' . $product_repeater['terms_seperator'] . '</span>', '') .'</span>';
								}
								if ( $product_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
							case 'tags':
								if ( $product_repeater['start_mete_wrapper'] == 'yes' ) {
									echo '<div class="kata-plus-product-metadata">';
								}
								echo '<span class="kata-plus-product-tags">' . Kata_Plus_Pro_Helpers::get_icon( '', $product_repeater['product_tag_icon'], 'df-fill' ) . get_the_term_list( get_the_ID(), 'product_tag',  '', '<span class="separator">' . $product_repeater['terms_seperator'] . '</span>', '') . '</span>';
								if ( $product_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
							case 'price':
								echo '<div class="kata-plus-product-price-wrapper">' . $product->get_price_html() . '</div>';
							break;
							case 'add_to_cart':
								echo '<div class="kata-plus-product-add-to-cart-wrapper"><a href="' . $product->add_to_cart_url() . '">' . $product->add_to_cart_text() . '</a></div>';
							break;
							case 'date':
								if ( $product_repeater['start_mete_wrapper'] == 'yes' ) {
									echo '<div class="kata-plus-product-metadata">';
								}
								echo Kata_Template_Tags::post_date( Kata_Plus_Pro_Helpers::get_icon( '', $product_repeater['product_date_icon'], 'df-fill' ), 'kata-plus-product-date' );
								if ( $product_repeater['end_mete_wrapper'] == 'yes' ) {
									echo '</div>';
								}
							break;
						}
					endforeach;
				}else{
					if ($settings['product_thumbnail_float'] == 'left') {
						echo '<div class="row">';
							$thumbnail_size = 'custom' !== $product_repeater['thumbnail_size'] ? $product_repeater['thumbnail_size'] : [$product_repeater['products_thumbnail_custom_size']['width'], $product_repeater['products_thumbnail_custom_size']['height']];
							echo '<div class="kata-plus-product-thumbnail-wrapper kata-lazyload kata-plus-product-thumbnail-position-' . esc_attr( $product_thumbnail_float ) . ' col-sm-4">';
							Kata_Helpers::image_resize_output(get_post_thumbnail_id(), $thumbnail_size);
							echo '</div>';
							echo '<div class="kata-plus-product-content-wrapper col-sm-8">';
								foreach ($product_repeaters as $index => $product_repeater) :
									switch ($product_repeater['product_repeater_select_2']) {
										case 'title':
											echo '<' . esc_attr($product_repeater['products_title_tag']) . ' class="kata-plus-product-title"><a href="' . get_permalink($product->get_id()) . '">' . $product->get_title() . '</a></' . esc_attr($product_repeater['products_title_tag']) . '>';
										break;
										case 'excerpt':
											echo '<p class="kata-plus-product-excerpt">' . Kata_Template_Tags::excerpt($product_repeater['excerpt_length']['size']) . '</p>';
										break;
										case 'categories':
											if ($product_repeater['start_mete_wrapper'] == 'yes') {
												echo '<div class="kata-plus-product-metadata">';
											}
											echo '<span class="kata-plus-product-categories">' . Kata_Plus_Pro_Helpers::get_icon('', $product_repeater['product_cat_icon'], 'df-fill') .  get_the_term_list(get_the_ID(), 'product_cat',  '', '<span class="separator">' . $product_repeater['terms_seperator'] . '</span>', '') . '</span>';
											if ($product_repeater['end_mete_wrapper'] == 'yes') {
												echo '</div>';
											}
										break;
										case 'tags':
											if ($product_repeater['start_mete_wrapper'] == 'yes') {
												echo '<div class="kata-plus-product-metadata">';
											}
											echo '<span class="kata-plus-product-tags">' . Kata_Plus_Pro_Helpers::get_icon('', $product_repeater['product_tag_icon'], 'df-fill') . get_the_term_list(get_the_ID(), 'product_tag',  '', '<span class="separator">' . $product_repeater['terms_seperator'] . '</span>', '') . '</span>';
											if ($product_repeater['end_mete_wrapper'] == 'yes') {
												echo '</div>';
											}
										break;
										case 'price':
											echo '<div class="kata-plus-product-price-wrapper">' . $product->get_price_html() . '</div>';
										break;
										case 'add_to_cart':
											echo '<div class="kata-plus-product-add-to-cart-wrapper"><a href="' . $product->add_to_cart_url() . '">' . $product->add_to_cart_text() . '</a></div>';
										break;
										case 'date':
											if ($product_repeater['start_mete_wrapper'] == 'yes') {
												echo '<div class="kata-plus-product-metadata">';
											}
											echo Kata_Template_Tags::post_date(Kata_Plus_Pro_Helpers::get_icon('', $product_repeater['product_date_icon'], 'df-fill'), 'kata-plus-product-date');
											if ($product_repeater['end_mete_wrapper'] == 'yes') {
												echo '</div>';
											}
										break;
									}
								endforeach;
							echo '</div>';
						echo '</div>';
					}elseif ($settings['product_thumbnail_float'] == 'right') {
						echo '<div class="row">';
							echo '<div class="kata-plus-product-content-wrapper col-sm-8">';
								foreach ($product_repeaters as $index => $product_repeater) :
									switch ($product_repeater['product_repeater_select_2']) {
										case 'title':
											echo '<' . esc_attr($product_repeater['products_title_tag']) . ' class="kata-plus-product-title"><a href="' . get_permalink($product->get_id()) . '">' . $product->get_title() . '</a></' . esc_attr($product_repeater['products_title_tag']) . '>';
											break;
										case 'excerpt':
											echo '<p class="kata-plus-product-excerpt">' . Kata_Template_Tags::excerpt($product_repeater['excerpt_length']['size']) . '</p>';
											break;
										case 'categories':
											if ($product_repeater['start_mete_wrapper'] == 'yes') {
												echo '<div class="kata-plus-product-metadata">';
											}
											echo '<span class="kata-plus-product-categories">' . Kata_Plus_Pro_Helpers::get_icon('', $product_repeater['product_cat_icon'], 'df-fill') .  get_the_term_list(get_the_ID(), 'product_cat',  '', '<span class="separator">' . $product_repeater['terms_seperator'] . '</span>', '') . '</span>';
											if ($product_repeater['end_mete_wrapper'] == 'yes') {
												echo '</div>';
											}
										break;
										case 'tags':
											if ($product_repeater['start_mete_wrapper'] == 'yes') {
												echo '<div class="kata-plus-product-metadata">';
											}
											echo '<span class="kata-plus-product-tags">' . Kata_Plus_Pro_Helpers::get_icon('', $product_repeater['product_tag_icon'], 'df-fill') . get_the_term_list(get_the_ID(), 'product_tag',  '', '<span class="separator">' . $product_repeater['terms_seperator'] . '</span>', '') . '</span>';
											if ($product_repeater['end_mete_wrapper'] == 'yes') {
												echo '</div>';
											}
										break;
										case 'price':
											echo '<div class="kata-plus-product-price-wrapper">' . $product->get_price_html() . '</div>';
										break;
										case 'add_to_cart':
											echo '<div class="kata-plus-product-add-to-cart-wrapper"><a href="' . $product->add_to_cart_url() . '">' . $product->add_to_cart_text() . '</a></div>';
										break;
										case 'date':
											if ($product_repeater['start_mete_wrapper'] == 'yes') {
												echo '<div class="kata-plus-product-metadata">';
											}
											echo Kata_Template_Tags::post_date(Kata_Plus_Pro_Helpers::get_icon('', $product_repeater['product_date_icon'], 'df-fill'), 'kata-plus-product-date');
											if ($product_repeater['end_mete_wrapper'] == 'yes') {
												echo '</div>';
											}
										break;
									}
								endforeach;
							echo '</div>';
							$thumbnail_size = 'custom' !== $product_repeater['thumbnail_size'] ? $product_repeater['thumbnail_size'] : [$product_repeater['products_thumbnail_custom_size']['width'], $product_repeater['products_thumbnail_custom_size']['height']];
							echo '<div class="kata-plus-product-thumbnail-wrapper kata-lazyload kata-plus-product-thumbnail-position-' . esc_attr( $product_thumbnail_float ) . ' col-sm-4">';
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

	// product Pagination
	if ( $settings['product_pagination'] && ! $settings['enable_carousel'] ) {
		echo '<div class="kata-plus-product-pagination">';
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
					'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer product', 'kata-plus-plus' ) ),
					'next_text'    => sprintf( '%1$s <i></i>', __( 'Older product', 'kata-plus-plus' ) ),
					'add_args'     => false,
					'add_fragment' => '',
				)
			);
		echo '</div>';
	}
	wp_reset_postdata();
endif;

echo '</div> <!-- kata-plus-product-wrap -->';
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