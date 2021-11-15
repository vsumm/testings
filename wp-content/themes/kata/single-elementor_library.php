<?php
/**
 * The template for displaying all single posts
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

do_action( 'kata_single_before_loop' );

while ( have_posts() ) :
	the_post();

	do_action( 'kata_single_before_the_content' );

	the_content();

	do_action( 'kata_single_after_the_content' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

	do_action( 'kata_single_after_comments' );
endwhile; // End of the loop.

do_action( 'kata_single_after_loop' );

get_footer();
