<?php
/**
 * The template for displaying search results
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div <?php post_class( 'kata-default-post kata-default-loop loop-two' ); ?>>
	<div class="kata-post-details">            
		<div class="post-content-header">
			<div class="row">
				<?php
				if ( has_post_thumbnail() ) {
					?>
				<div class="col-md-4">
					<div class="kata-post-thumbnail">
						<?php Kata_Helpers::image_resize_output( get_post_thumbnail_id(), array( '300', '300' ) ); ?>
					</div>
				</div>
					<?php
				}
				$content_class = has_post_thumbnail() ? 'col-md-5' : 'col-md-9';
				?>
				<div class="<?php echo esc_attr( $content_class ); ?>">
					<div class="kata-post-categories">
						<?php Kata_Template_Tags::post_categories(); ?>
					</div>                                          
					<div class="kata-post-content-wrap">
						<div class="kata-post-title-wrap">
							<h2 class="kata-post-title-loop-two">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php the_title(); ?> </a>
							</h2>
						</div>	                     
						<div class="kata-post-excerpt">                                
							<p><?php echo esc_html( Kata_Template_Tags::excerpt( 15 ) ); ?></p>
						</div>	    
					</div>                                     
				</div>
				<div class="col-md-3">
					<div class="kata-post-default-meta">
						<div class="kata-post-date-wrap">
							<span><?php echo esc_html__( 'Date:', 'kata' ); ?></span>
							<?php Kata_Template_Tags::post_date(); ?>
						</div>
						<div class="kata-post-author-wrap">
							<span><?php echo esc_html__( 'Author:', 'kata' ); ?></span>
							<?php Kata_Template_Tags::post_author(); ?>
						</div>
					</div>
				</div>
			</div>	
		</div>	
	</div>
</div>
