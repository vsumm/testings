<?php

/**
 * Course Builder.
 * @requires learnpress plugin
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Plus_Pro_Single_Course_Builder' ) ) {
	class Kata_Plus_Pro_Single_Course_Builder extends Kata_Plus_Pro_Builders_Base {
		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Single_Course_Builder
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance() {
			if (self::$instance === null) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Global definitions.
		 *
		 * @since   1.0.0
		 */
		public function definitions() {
			/**
			 * Remove default Template
			 */
			add_action( 'kata_page_before_loop', array( $this, 'remove_learnPress_single_course_template' ) );
			$this->name            = esc_html__( 'Single Course', 'kata-plus' );
			$this->action          = 'kata_single_course';
			$this->default_content = json_decode('', true);
		}

		/**
		 * Remove LearnPress Single Course Template
		 */
		public function remove_learnPress_single_course_template() {
			// remove_filter( 'the_content', array( LP_Page_Controller::instance(), 'single_content' ), 10000 );
			if( 'lp_course' == get_post_type() ) {
				do_action( 'kata_single_course' );
				add_action( 'elementor/frontend/before_enqueue_styles', [$this, 'enqueue_styles'] );
			}
		}

		/**
		 * Enqueue Style for single course template
		 */
		public function enqueue_styles() {
			wp_enqueue_style( 'kata-plus-lp-single-builder', Kata_Plus::$assets . 'css/frontend/single-course.css', [], Kata_Plus_Pro::$version );
		}


	} // end class

	Kata_Plus_Pro_Single_Course_Builder::get_instance();
}
