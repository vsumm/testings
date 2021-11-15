<?php
/**
* Kata Elementor Optimizer
*
*
* @author  ClimaxThemes
* @package Kata Plus
* @since   1.0.0
*/

use Elementor\Plugin;

class Kata_Plus_Pro_Elementor_Optimizer {


	public function __construct () {

		if ( true == get_theme_mod( 'kata_elementor_performance_google_fonts', false ) ) {
			// Remove google fontes from elementor
			add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
		}
		if ( true == get_theme_mod( 'kata_elementor_performance_fontawesome', false ) ) {
			// Remove FontAwesome from elementor
			add_action( 'elementor/frontend/after_register_styles', [$this, 'remove_font_awesome_elementor'], 20 );
		}
		if ( true == get_theme_mod( 'kata_elementor_performance_pro_js', false ) ) {
			// Remove Elementor Pro JS files.
			add_action( 'wp_enqueue_scripts', [ $this, 'remove_elementor_pro_js' ], 20 );
		}
		
		if ( true == get_theme_mod( 'kata_elementor_performance_editor_js', false ) ) {
			// Remove Elementor Editor JS for logged in users.
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 999999 );
		}
		
		if ( true == get_theme_mod( 'kata_elementor_performance_animations', false ) ) {
			// Remove Elementor Editor JS for logged in users.
			add_action( 'elementor/frontend/after_enqueue_styles', [$this, 'remove_style_elementor'], 20 );
		}
		
		if ( true == get_theme_mod( 'kata_elementor_performance_prallax_motions', false ) ) {
			// Remove Elementor Editor JS for logged in users.
			add_action( 'elementor/frontend/after_register_scripts', [ $this, 'after_register_scripts' ], 999999 );
		}
		
		if ( true == get_theme_mod( 'kata_elementor_performance_frontend_scripts', false ) ) {
			// Remove Elementor Editor JS for logged in users.
			add_action( 'elementor/frontend/after_register_scripts', [$this, 'remove_elementor_js'], 20 );
		}

		if ( false == get_theme_mod( 'kata_wordpress_performance_jquery_migrate', false ) ) {
			// Remove jQuery Migrate for logged in users.
			add_action( 'wp_default_scripts', [$this, 'remove_wp_jquery_migrate'] );
		}
		
		if ( true == get_theme_mod( 'kata_wordpress_performance_wp_emojis', false ) ) {
			add_action( 'init', [$this, 'disable_wp_emojis'] );
		}

		add_action( 'wp_enqueue_scripts', [$this, 'manage_scripts'], 999999 );

		if ( ! is_admin() && true == get_theme_mod( 'kata_wordpress_performance_query_var_strings', false ) ) {
			add_filter( 'style_loader_src', [$this, 'remove_cssjs_ver'], 10, 2 );
			add_filter( 'script_loader_src', [$this, 'remove_cssjs_ver'], 10, 2 );
		}
	}

	/**
	*
	* Remove CSS and JS
	*
	* you can change page or what scripts remove, its just a example
	*
	*/
	public function after_register_scripts() {
		// remove parallax motion
		wp_deregister_script( 'kata-jquery-enllax' );
		wp_dequeue_script( 'kata-jquery-enllax' );
	}

	/**
	*
	* Remove CSS and JS
	*
	* you can change page or what scripts remove, its just a example
	*
	*/
	public function enqueue_scripts () {
		// remove editor scripts from frontend
		if ( ! Plugin::$instance->editor->is_edit_mode() && ! is_user_logged_in() ) {
			wp_dequeue_script( 'elementor-common' );
			wp_dequeue_style( 'elementor-common' );
			wp_dequeue_script( 'jquery-ui-draggable' );
			wp_dequeue_script( 'backbone-marionette' );
			wp_dequeue_script( 'backbone-radio' );
			wp_dequeue_script( 'elementor-common-modules' );
			wp_dequeue_script( 'elementor-dialog' );
			wp_dequeue_script( 'elementor-app' );
			wp_dequeue_script( 'elementor-app-loader' );
			wp_dequeue_script( 'kata-nicescroll-script' );
		}
	}

	/**
	*
	* Remove Elementor JS
	*
	* improtant: this remove defaults Elementor JS and some its
	* required for each function. Disabe each and test for dont
	* broke your website functions
	*
	*/
	public function remove_elementor_js() {
		if ( is_front_page() ) {
			wp_deregister_script( 'elementor-frontend' );

			wp_register_script(
				'elementor-frontend',
				ELEMENTOR_ASSETS_URL . 'js/frontend.min.js',
				[
					'elementor-frontend-modules',
					//'elementor-dialog', //Just comment if you want dont load this JS in page
					'elementor-waypoints',
					//'swiper', //Example: disable if you dont use slider os others similars in your page
					//'share-link', //Example: disable if you dont use share links in your page
				],
				ELEMENTOR_VERSION,
				true
			);
		}
	}

	/**
	*
	* Remove Elementor PRO JS
	*
	* improtant: this remove defaults Elementor PRO JS and some its
	* required for each function. Disabe each and test for dont
	* broke your website functions
	*
	*/
	public function remove_elementor_pro_js() {
		if ( is_front_page() && defined( 'ELEMENTOR_PRO_URL' ) ) {
			wp_deregister_script( 'elementor-pro-frontend' );

			wp_enqueue_script(
				'elementor-pro-frontend',
				ELEMENTOR_PRO_URL . 'assets/js/frontend.min.js',
				[
					'elementor-frontend-modules',
					'elementor-sticky', //Remove if you dont use element sticky in your page
				],
				ELEMENTOR_PRO_VERSION,
				true
			);
		}
	}

	/**
	*
	* Remove Font Awesome icons by Elementor
	*
	* Important: this remove all font awesome icons from Elementor
	* use SVG icons for best performance
	*
	*/
	public function remove_font_awesome_elementor() {
		foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
			wp_deregister_style( 'elementor-icons-fa-' . $style );
		}
	}

	/**
	*
	* Remove others Elementor styles
	*
	* Important: this remove defaults styles from Elementor
	* Disabe each and test for dont broke your website functions
	*
	*/
	public function remove_style_elementor() {
		wp_dequeue_style( 'elementor-animations' ); //Example: disable if you dont use animations in you page
	}

	/**
	*
	* Remove CSS and JS if is front page (home)
	*
	* you can change page or what scripts remove, its just a example
	*
	*/
	public function manage_scripts() {
		// Remove Elementor icons if you dont use
		if ( true == get_theme_mod( 'kata_elementor_performance_icons', false ) ) {
			wp_deregister_style( 'elementor-icons' );
		}

		if ( true == get_theme_mod( 'kata_wordpress_performance_wp_block_library', false ) ) {
			if ( ! is_single() ) {
				// Remove WordPress Block Library if you dont use
				wp_deregister_style( 'wp-block-library' );
				// Remove WordPress Block Library theme if you dont use
				wp_deregister_style( 'wp-block-library-theme' );
			}
		}
	}

	/**
	*
	* Disable WordPress emojis
	*
	*/
	public function disable_wp_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	/**
	*
	* Remove jQuery migrate from WordPress
	* IMPORTANT: WP 5.5 removed jQuery migrate by default
	* if you use this version remove this function
	*
	*/
	public function remove_wp_jquery_migrate( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];
			if ( $script->deps ) {
				$script->deps = array_diff( $script->deps, array(
					'jquery-migrate'
				) );
			}
		}
	}


	/**
	*
	* Remove WordPress query strings
	*
	*/
	public function remove_cssjs_ver( $src ) {
		if( strpos( $src, '?ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}

}

new Kata_Plus_Pro_Elementor_Optimizer;