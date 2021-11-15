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

?>

<div class="kata-default-post">
	<div class="container">
		<div class="row">
			<div <?php echo esc_html( post_class() ); ?>>
				<div class="kata-post-details">
					<div class="kata-row">
						<div class="kata-post-thumbnail">
							<?php Kata_Template_Tags::post_thumbnail(); ?>
						</div>
					</div>
					<div class="post-content-header">
						<div class="row">                                                          
							<div class="kata-post-default-meta">
								<div class="kata-post-categories">
									<?php Kata_Template_Tags::post_categories(); ?>
								</div> 
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
				<div class="kata-row">
					<div class="kata-post-content">
						<?php the_content(); ?>
						<div class="kt-clear"></div>
						<?php if ( has_tag() ) : ?>    
							<div class="kata-post-tags">
								<span><?php esc_html__( 'Tags : ', 'kata' ); ?></span> <?php Kata_Template_Tags::post_tags(); ?>
							</div>
						<?php endif; ?>
						<div class="kata-post-social-share">
							<span class="kata-post-social-share-title"><?php esc_html__( 'Share : ', 'kata' ); ?></span>
							<?php Kata_Template_Tags::social_share(); ?>
						</div>
						<?php
						if ( comments_open() ) {
							comments_template();
						}
						?>
					</div>				
				</div>
			</div>
		</div>
	</div>
</div>
