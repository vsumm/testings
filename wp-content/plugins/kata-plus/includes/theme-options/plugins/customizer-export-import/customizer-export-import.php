<?php

define( 'CEI_VERSION', '0.9.1' );
define( 'CEI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CEI_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

/* Classes */
require_once CEI_PLUGIN_DIR . 'classes/class-cei-core.php';

/* Actions */
add_action( 'plugins_loaded', 'CEI_Core::load_plugin_textdomain' );
add_action( 'customize_controls_print_scripts', 'CEI_Core::controls_print_scripts' );
add_action( 'customize_controls_enqueue_scripts', 'CEI_Core::controls_enqueue_scripts' );
add_action( 'customize_register', 'CEI_Core::init', 999999 );
add_action( 'customize_register', 'CEI_Core::register' );
