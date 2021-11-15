<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @author ClimaxThemes
 * @package Kata
 * @since 1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * Page title
 */
Kata_Helpers::title_archive_output( 'kt-blog-posts', 'blog' );

do_action( 'kata_index_before_loop' );

if ( Kata_Helpers::advance_mode() ) {
	do_action( 'kata_blog' );
} else {
	get_template_part( 'template-parts/loops/loop-default' );
}

do_action( 'kata_index_after_loop' );
get_footer();
