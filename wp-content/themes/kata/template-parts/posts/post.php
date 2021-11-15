<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

if ( is_active_sidebar( 'kata-left-sidebar' ) && is_active_sidebar( 'kata-right-sidebar' ) ) {
	$kata_content_class = 'col-lg-6';
} elseif ( is_active_sidebar( 'kata-left-sidebar' ) || is_active_sidebar( 'kata-right-sidebar' ) ) {
	$kata_content_class = 'col-lg-9';
} else {
	$kata_content_class = 'col-lg-12';
}

$kata_post_single_thumbnail	= get_theme_mod( 'kata_post_single_thumbnail', '1' );
$kata_post_single_categories = get_theme_mod( 'kata_post_single_categories', '1' );
$kata_post_single_title		= get_theme_mod( 'kata_post_single_title', '1' );
$kata_post_single_date		= get_theme_mod( 'kata_post_single_date', '1' );
$kata_post_single_author	= get_theme_mod( 'kata_post_single_author', '1' );
$kata_post_single_tags		= get_theme_mod( 'kata_post_single_tags', '1' );
$kata_post_single_socials	= get_theme_mod( 'kata_post_single_socials', '1' );
?>
<article <?php echo esc_html( post_class() ); ?>>
	<div class="container">
		<div class="row">
			<?php if ( is_active_sidebar( 'kata-left-sidebar' ) ) { ?>
			<div class="col-lg-3 kata-sidebar kata-left-sidebar" role="complementary">
				<?php dynamic_sidebar( 'kata-left-sidebar' ); ?>
			</div>
			<?php } ?>
			<div class="kata-default-loop-content-single <?php echo esc_attr( $kata_content_class ); ?>" role="main">
				<div class="kata-default-post">
					<div class="kata-post-details">
						<?php if ( $kata_post_single_thumbnail ) : ?>
							<div class="kata-post-thumbnail">
								<?php Kata_Template_Tags::post_thumbnail(); ?>
							</div>
						<?php endif; ?>
						<div class="post-content-header">
							<?php if( $kata_post_single_categories || $kata_post_single_title ) : ?>
								<div class="kata-post-title-wrap">
									<?php if ( $kata_post_single_categories ) : ?>
										<div class="kata-post-categories">
											<?php Kata_Template_Tags::post_categories(); ?>
										</div>
									<?php endif; ?>
									<?php if ( $kata_post_single_title ) : ?>
										<header>
											<div class="kata-post-title">
												<h1> <?php the_title(); ?></h1>
											</div>
										</header>
									<?php endif; ?>
								</div>
							<?php endif; ?>
							<?php if( $kata_post_single_date || $kata_post_single_author ) : ?>
								<div class="kata-post-default-meta">
									<?php if( $kata_post_single_author) : ?>
										<div class="kata-post-author-wrap">
											<?php Kata_Template_Tags::post_author( 'a', 'avatar', '42' ); ?>
										</div>
									<?php endif; ?>
									<?php if( $kata_post_single_date ) : ?>
										<div class="kata-post-date-wrap">
											<?php Kata_Template_Tags::post_date(); ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="kata-row">
						<div class="kata-post-content">
							<?php the_content(); ?>
							<div class="kt-clear"></div>
							<?php wp_link_pages(); ?>
						</div>
						<?php if ( has_tag() && $kata_post_single_tags ) : ?>
							<div class="kata-post-tags">
								<span><?php echo esc_html__( 'Tags', 'kata' ); ?></span> <?php Kata_Template_Tags::post_tags(); ?>
							</div>
						<?php endif; ?>
						<?php Kata_Template_Tags::author_box() ?>
						<?php
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						?>
					</div>
				</div>
			</div>
			<?php if ( is_active_sidebar( 'kata-right-sidebar' ) ) { ?>
			<div class="col-lg-3 kata-sidebar kata-right-sidebar" role="complementary">
				<?php dynamic_sidebar( 'kata-right-sidebar' ); ?>
			</div>
			<?php } ?>
		</div>
	</div>
</article>
