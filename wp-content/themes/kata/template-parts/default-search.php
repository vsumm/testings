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

<section id="primary" class="content-area">
	<main id="main" class="site-main search-page">
		<?php do_action( 'kata_search_before_loop' ); ?>
		<div class="row">
			<div class="col-md-12">
				<?php
				if ( have_posts() ) :
					?>
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );
					endwhile;
					?>
					<div class="kata-pagination">
						<?php the_posts_pagination(); ?>
					</div>
					<?php
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
				?>
			</div>
		</div>
		<?php do_action( 'kata_search_after_loop' ); ?>
	</main><!-- #main -->
</section><!-- #primary -->
<?php
get_footer();
