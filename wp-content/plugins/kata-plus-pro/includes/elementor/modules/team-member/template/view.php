<?php
/**
 * Team Member module view.
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
use Elementor\Group_Control_Image_Size;

$settings = $this->get_settings_for_display();
$this->add_inline_editing_attributes( 'team_name' );
$this->add_inline_editing_attributes( 'team_job' );
$this->add_inline_editing_attributes( 'team_desc' );
$this->add_inline_editing_attributes( 'custom_text_readmore' );

$team_name            = $settings['team_name'];
$team_job             = $settings['team_job'];
$team_desc            = $settings['team_desc'];
$shapes               = $settings['shape'];
$team_link_type       = $settings['team_link_type'];
$custom_text_readmore = $settings['custom_text_readmore'];
$url                  = Kata_Plus_Pro_Helpers::get_link_attr( $settings['team_url'] );
$socials              = $settings['team_socials'];
$source               = $settings['team_source'];
$social_wrap          = $team_content = '';

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
}

$tilt     = '';
$classes  = '';
$classes .= $source == 'yes' ? $settings['column'] : '';
$classes .= $settings['team_tilt_effect'] == 'yes' ? ' kata-plus-tilt ' : '';
$tilt    .= $settings['team_tilt_effect'] == 'yes' ? ' data-glare=' . $settings['team_tilt_effect_glare'] . '' : '';
$tilt    .= $settings['team_tilt_effect'] == 'yes' ? ' data-scale=' . $settings['team_tilt_effect_scale'] . '' : '';

if ( $source == 'yes' ) {
	if ( ! empty( $settings['posts_array'][0] ) ) {
		foreach ( $settings['posts_array'] as $key => $value ) {
			if ( ! empty( $value ) ) {
				$posts[] = $value;
			}
		}
	} else {
		$posts = '';
	}
	$args = array(
		'post_type'   => 'kata_team_member',
		'post_status' => 'publish',
		'post__in'    => $posts,
	);

	$query = new \WP_Query( $args );
	echo '<div class="row">';
	while ( $query->have_posts() ) :
		$query->the_post();
		$thumbnail_url    = get_the_post_thumbnail_url();
		$content          = get_the_content();
		$team_name_post   = get_the_title();
		$team_job_post    = get_post_meta( get_the_ID(), 'team_job', true );
		$team_desc_post   = get_the_content();
		$team_social_post = get_post_meta( get_the_ID(), 'team_social', true ); ?>

		<div class="kata-plus-team-member team-member-post <?php echo esc_attr( $classes ); ?>" <?php echo esc_attr( $tilt ); ?>>
			<?php
			if ( $team_link_type == 'wrap' ) {
				echo '<a href="' . get_the_permalink() . '">';
			}
			?>
			<?php if ( $thumbnail_url ) { ?>
				<div class="img-warp kata-plus-team-img kata-lazyload">
					<?php if ( $settings['team_image_overlay'] ) { ?>
						<div class="team-member-image-overlay"></div>
					<?php } ?>
					<?php echo Kata_Plus_Pro_Helpers::get_image_srcset( get_post_thumbnail_id( get_the_ID() ), 'full', '', array( 'alt' => get_post_meta( get_the_ID(), 'team_name', true ) ) ); ?>
				</div>
			<?php } ?>
			<?php if ( $team_name_post || $team_job_post || $team_desc_post ) { ?>
				<div class="kata-plus-team-memcontent">
					<?php
					if ( $team_name_post ) {
						?>
						<?php if ( $team_link_type == 'title' && ! empty( $url->src ) ) { ?>
							<a href="<?php echo esc_url( $url->src, Kata_Plus_Pro_Helpers::ssl_url() ); ?>" class="team-member-url" <?php echo $url->rel . $url->target; ?>>
							<?php
						}
						if ( $team_link_type == 'title' ) {
							echo '<a href="' . get_the_permalink() . '">';
						}
						?>
						<h4><?php echo wp_kses_post( $team_name_post ); ?></h4>
						<?php
						if ( $team_link_type == 'title' ) {
							echo '</a>';
						}
					}
					?>

					<?php if ( $team_job_post ) { ?>
						<h5><?php echo wp_kses_post( $team_job_post ); ?></h5>
					<?php } ?>

					<?php if ( $team_desc_post ) { ?>
						<p><?php echo wp_kses_post( $team_desc_post ); ?></p>
					<?php } ?>

					<?php if ( $team_link_type == 'more' && ! empty( $url->src ) ) { ?>
						<a href="<?php echo esc_url( $url->src, Kata_Plus_Pro_Helpers::ssl_url() ); ?>" class="team-member-url" <?php echo $url->rel . $url->target; ?> >
							<span <?php echo $this->get_render_attribute_string( 'custom_text_readmore' ); ?>><?php echo wp_kses_post( $custom_text_readmore ); ?></span>
						</a>
					<?php } ?>
				</div>
			<?php } ?>
			<?php
			echo '<div class="team-member-footer">';
			if ( $team_social_post ) {
				echo '<div class="kata-plus-team-social">';
					echo '<div class="kata-plus-team-social-in">';
				foreach ( $team_social_post as $social_item ) {
					$social_class = 'font-awesome/' . strtolower( $social_item[0] );
					?>
					<a href="<?php echo esc_attr( $social_item[1] ); ?>">
						<?php echo Kata_Plus_Pro_Helpers::get_icon( '', $social_class ); ?>
					</a>
					<?php
				}
					echo '</div>';
				echo '</div>';
			}
			if ( $team_link_type == 'more' ) {
				echo '<a href="' . get_the_permalink() . '" class="kt-team-member-button team-member-url">';
				echo $settings['icon_position'] == 'before' && $settings['team_link_icon'] != '' ? '<span class="kata-team-button-icon-wrapper"">' . Kata_Plus_Pro_helpers::get_icon( '', $settings['team_link_icon'] ) . '</span>' : '';
				echo '<span ' . $this->get_render_attribute_string( 'custom_text_readmore' ) . '>' . wp_kses_post( $custom_text_readmore ) . '</span>';
				echo $settings['icon_position'] == 'after' && $settings['team_link_icon'] != '' ? '<span class="kata-team-button-icon-wrapper"">' . Kata_Plus_Pro_helpers::get_icon( '', $settings['team_link_icon'] ) . '</span>' : '';
				echo '</a>';
			}
			echo '</div>';
			// Shape
			if ( $shapes ) {
				foreach ( $shapes as $value ) {
					?>
					<div class="elementor-repeater-item-<?php echo esc_attr( $value['_id'] ); ?>" data-item-id="<?php echo isset( $value['add_shape']['citem'] ) ? esc_attr( $value['add_shape']['citem'] ) : ''; ?>"></div>
				<?php } ?>
				<?php
			}
			if ( $team_link_type == 'wrap' ) {
				echo '</a>';
			}
			?>

		</div>

		<?php
	endwhile;
	echo '</div>';
	wp_reset_postdata();
} else {
	// Socails
	if ( $socials ) {
		$social_wrap     .= '<div class="kata-plus-team-social">';
			$social_wrap .= '<div class="kata-plus-team-social-in">';
		foreach ( $socials as $social ) {
			$social_link  = $social['team_social_link']['url'] != '' ? $social['team_social_link']['url'] : '#';
			$attr         = $social['team_social_link']['is_external'] != '' ? 'target=_blank' : '';
			$aclass       = substr( $social['team_social_icon'], 6 );
			$attr        .= $social['team_social_link']['nofollow'] != '' ? ' rel=nofollow' : '';
			$attr        .= $social['team_social_name'] ? ' title=' . $social['team_social_name'] . '' : '';
			$social_wrap .= '<a href="' . esc_attr( $social_link ) . '" class="kata-plus elementor-repeater-item-' . esc_attr( $social['_id'] ) . ' ' . esc_attr( $aclass ) . '" ' . esc_attr( $attr ) . '>';
			if ( $social['team_social_icon'] ) {
				$social_wrap .= Kata_Plus_Pro_Helpers::get_icon( '', $social['team_social_icon'], '', '' );
			}
			$social_wrap .= '</a>';
		}
			$social_wrap .= '</div>';
		$social_wrap     .= '</div>';
	}

	// team name and job
	if ( $team_name || $team_job || $team_desc ) {
		$team_content     .= ( $team_link_type == 'wrap' ) ? '<a href="' . esc_url( $url->src, Kata_Plus_Pro_Helpers::ssl_url() ) . '" class="team-member-url" ' . $url->rel . ' ' . $url->target . '>' : '';
		$team_content     .= '<div class="kata-plus-team-memcontent">';
			$team_content .= ( $team_link_type == 'title' && ! empty( $url->src ) ) ? '<a href="' . esc_url( $settings['team_url']['url'], Kata_Plus_Pro_Helpers::ssl_url() ) . '" class="team-member-url" ' . $url->rel . ' ' . $url->target . '>' : '';
			$team_content .= $team_name ? '<h4 ' . $this->get_render_attribute_string( 'team_name' ) . '>' . wp_kses( $team_name, wp_kses_allowed_html( 'post' ) ) . '</h4>' : '';
			$team_content .= ( $team_link_type == 'title' && ! empty( $url->src ) ) ? '</a>' : '';
			$team_content .= $team_job ? '<h5 ' . $this->get_render_attribute_string( 'team_job' ) . '>' . wp_kses( $team_job, wp_kses_allowed_html( 'post' ) ) . '</h5>' : '';
			$team_content .= $team_desc ? '<p ' . $this->get_render_attribute_string( 'team_desc' ) . '>' . wp_kses( $team_desc, wp_kses_allowed_html( 'post' ) ) . '</p>' : '';
		$team_content     .= '</div>';
		$team_content     .= ( $team_link_type == 'wrap' ) ? '</a>' : '';
	}

	if ( $team_name || $team_job ) :
		?>
		<div class="kata-plus-team-member <?php echo esc_attr( $classes ); ?>"  <?php echo esc_attr( $tilt ); ?>>
			<?php
			echo ( $team_link_type == 'wrap' ) ? '<a href="' . esc_url( $settings['team_url']['url'], Kata_Plus_Pro_Helpers::ssl_url() ) . '" class="team-member-url" ' . $url->rel . ' ' . $url->target . '>' : '';
			// Team Image
			echo '<div class="img-warp kata-plus-team-img kata-lazyload">';
			if ( $settings['team_image_overlay'] ) {
				echo '<div class="team-member-image-overlay"></div>';
			}
			if ( Kata_Plus_Pro_Helpers::string_is_contain( $settings['image']['url'], 'svg' ) ) {
				$svg_size = Kata_Plus_Pro_Helpers::svg_resize( $settings['image_size'], $settings['image_custom_dimension']['width'], $settings['image_custom_dimension']['height'] );
				Kata_Plus_Pro_Helpers::get_attachment_svg_path( $settings['image']['id'], $settings['image']['url'], $svg_size );
			} else {
				echo Kata_Plus_Helpers::get_attachment_image_html( $settings );
			}
			echo '</div>';

			echo ( $team_link_type == 'wrap' ) ? '</a>' : '';
			echo wp_kses( $team_content, wp_kses_allowed_html( 'post' ) );
			echo '<div class="team-member-footer">';
			echo wp_kses( $social_wrap, wp_kses_allowed_html( 'post' ) );

			if ( $team_link_type == 'more' ) {
				echo '<a ' . $url->src . $url->rel . $url->target . ' class="kt-team-member-button team-member-url">';
				echo $settings['icon_position'] == 'before' && $settings['team_link_icon'] != '' ? '<span class="kata-team-button-icon-wrapper"">' . Kata_Plus_Pro_helpers::get_icon( '', $settings['team_link_icon'] ) . '</span>' : '';
				echo '<span ' . $this->get_render_attribute_string( 'custom_text_readmore' ) . '>' . wp_kses( $custom_text_readmore, wp_kses_allowed_html( 'post' ) ) . '</span>';
				echo $settings['icon_position'] == 'after' && $settings['team_link_icon'] != '' ? '<span class="kata-team-button-icon-wrapper"">' . Kata_Plus_Pro_helpers::get_icon( '', $settings['team_link_icon'] ) . '</span>' : '';
				echo '</a>';
			}
			echo '</div>';

			// Shape
			if ( $shapes ) {
				foreach ( $shapes as $value ) {
					?>
					<div class="elementor-repeater-item-<?php echo esc_attr( $value['_id'] ); ?>" data-item-id="<?php echo isset( $value['add_shape']['citem'] ) ? esc_attr( $value['add_shape']['citem'] ) : ''; ?>"></div>
				<?php } ?>
			<?php } ?>
		</div>
		<?php
	endif;
}

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
