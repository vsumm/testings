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

	if ( ! did_action( 'elementor/loaded' ) || ! class_exists( 'Kata_Plus_Pro' ) ) {
		Kata_Helpers::single_template();
	} else {
		do_action( 'kata_single_post' );
	}

	do_action( 'kata_single_after_the_content' );

endwhile; // End of the loop.

do_action( 'kata_single_after_loop' );

get_footer();
