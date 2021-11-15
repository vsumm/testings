<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page.
 *
 * @package Kata
 */

get_header();

do_action( 'kata_page_before_loop' );

if ( ! did_action( 'elementor/loaded' ) || ! class_exists( 'Kata_Plus_Pro' ) ) {
	get_template_part( 'template-parts/404.tpl' );
} else {
	do_action( 'kata_404' );
}

do_action( 'kata_page_after_loop' );

get_footer();

