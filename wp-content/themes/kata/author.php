<?php
/**
 * The template for displaying author pages
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
Kata_Helpers::title_archive_output( 'kt-author-posts', 'author' );

do_action( 'kata_index_before_loop' );

if ( ! did_action( 'elementor/loaded' ) || ! class_exists( 'Kata_Plus_Pro' ) ) {
	get_template_part( 'template-parts/loops/loop-default' );
} else {
	do_action( 'kata_author' );
}

do_action( 'kata_index_after_loop' );
get_footer();
