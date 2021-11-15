<?php
/**
 * Recipes view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings		= $this->get_settings();
$column			= $settings['column'];
$post_count		= $settings['post_count'];
$terms			= $settings['categories'];
$term_tax		= get_terms( 'kata_recipe_category' );
$term_tax_size	= sizeof( $term_tax );
$terms_items	= ! empty( $terms ) ? sizeof( $terms ) : '';
$tax_items		= sizeof( $term_tax );
$cat_title		= '';
$counter		= 0;

$settings['inc_owl_arrow']                 = $settings['inc_owl_arrow'] == 'true' ? 'true' : 'false';
$settings['inc_owl_pag']                   = $settings['inc_owl_pag'] == 'true' ? 'true' : 'false';
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
$classes                                   = $settings['inc_owl_pag_num'] == 'true' ? 'dots-num' : '';


if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>

<div class="kata-plus-recipes">
	<?php
	if ( $settings['cat_nav'] == 'yes' ) {
		if ( $terms ) { ?>
			<div class="kata-recipes-title-box">
				<span class="kata-recipes-title"><?php echo esc_html__( 'Recipes', 'kata-plus' ) ?></span>
				<span class="recipes-title-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', 'themify/angle-right', '', '' ) ?></span>
				<?php
				if ( $terms_items == $tax_items ) {
					$cat_title = 'All';
				} else {
					for ( $i = 0; $i < $term_tax_size; $i++ ) {
						@$terms[ $i ];
					}
				}
				echo $cat_title ? '<span class="recipes-terms-name">' . esc_html( $cat_title ) . '</span>' : '';
				$comma_terms = implode( ', ', $terms );
				if ( $terms_items != $tax_items ) {
					echo '<span class="recipes-terms-name">' . esc_html( $comma_terms ) . '</span> ';
				} ?>
			</div>
			<?php
		}
	}
	$args = array(
		'post_type'      => 'kata_recipe',
		'post_status'    => 'publish',
		'posts_per_page' => $post_count,
		'tax_query'      => array(
			array(
				'taxonomy' => 'kata_recipe_category',
				'field'    => 'slug',
				'terms'    => $terms,
			),
		),
	);
	$query = new \WP_Query( $args ); ?>
	<?php if ( $settings['carousel'] == 'yes' ) { ?>
		<div class="kata-owl owl-carousel owl-theme <?php echo esc_attr( $classes ); ?>"
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
		data-inc_owl_rtl="<?php echo esc_attr( $settings['inc_owl_rtl'] ); ?>">
	<?php } ?>

		<?php if ( $query->have_posts() ) :
			// start row
			if ( $settings['carousel'] != 'yes' ) { ?>
				<div class="row">
			<?php } ?>

			<?php
			// loop
			while ( $query->have_posts() ) :
				$counter++;
				$query->the_post();
				$thumbnail_url = get_the_post_thumbnail_url();
				$title         = get_the_title();
				$terms_tax     = get_the_term_list( get_the_ID(), 'kata_recipe_category', '<li class="terms-item">', ', ', '</li>' ); ?>

				<?php if ( $settings['carousel'] != 'yes' ) { ?>
					<div class="col-md-<?php echo esc_attr__( $column ); ?>">
				<?php } ?>

					<article class="kata-recipes-item">
						<?php
						if ( $thumbnail_url ) { ?>
								<div class="recipes-img">
									<a href="<?php the_permalink(); ?>">
										<?php echo Kata_Plus_Pro_Helpers::get_image_srcset( get_post_thumbnail_id( get_the_ID() ), 'full', '', array( 'alt' => get_post_meta( get_the_ID(), 'recipes_name', true ) ) ); ?>
									</a>
								</div>
							<?php
						}
						?>

						<?php

						if ( $terms_tax || $title ) {
							?>
							<div class="recipes-det">
								<div class="recipes-cat">
									<ul><?php echo $terms_tax; ?></ul>
								</div>

								<a href="<?php the_permalink(); ?>" class="recipes-title">
									<h4>
										<?php echo esc_html( $title ); ?>
									</h4>
								</a>
							</div>
							<?php
						}
						?>
					</article>

				<?php if ( $settings['carousel'] != 'yes' ) { ?>
					</div>
				<?php } ?>

				<?php
			endwhile; ?>
			<?php

			// end row
			if ( $settings['carousel'] != 'yes' ) { ?>
				</div>
			<?php } ?>
			<?php
		else :
			esc_html_e( 'Please first create a category for the Recipe and then proceed', 'kata-plus' );
		endif;

	if ( $settings['carousel'] ) { ?>
		</div>
	<?php }
	wp_reset_postdata();
	?>
</div>
<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
