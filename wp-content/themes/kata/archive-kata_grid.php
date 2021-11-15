<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Kata
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * Page title.
 */
Kata_Helpers::title_archive_output( 'kt-archive-posts', 'archive' );

do_action( 'kata_index_before_loop' );

if ( did_action( 'elementor/loaded' ) && class_exists( 'Kata_Plus_Pro' ) ) {
	do_action( 'kata_archive_portfolio' );
}

do_action( 'kata_index_after_loop' );
get_footer();
