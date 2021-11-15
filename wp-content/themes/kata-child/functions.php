<?php 
add_action( 'wp_enqueue_scripts', 'kata_child_enqueue_styles' );
function kata_child_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
}
