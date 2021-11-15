<?php
/**
 * Register new elementor widget.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Plugin;

class Kata_Plus_Pro_Testimonials_Vertical_Widget {
	/**
	 * Constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function __construct() {
		$this->actions();
	}

	/**
	 * Add Actions.
	 *
	 * @since   1.0.0
	 * @access  private
	 */
	private function actions() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'scripts' ], 0 );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ], 0 );
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'preview_styles' ], 0 );
	}

	/**
	 * On Widgets Registered
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function on_widgets_registered() {
		$this->dependencies();
		$this->register_widget();
	}

	/**
	 * Load dependencies.
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function dependencies() {
		Kata_Plus_Pro_Autoloader::load( dirname( __FILE__ ) . '/template', 'config' );
	}

	/**
	 * Register Widget
	 *
	 * @since   1.0.0
	 * @access  private
	 */
	private function register_widget() {
		Plugin::instance()->widgets_manager->register_widget_type( new Kata_Plus_Pro_Testimonials_Vertical() );
	}

	/**
	 * Register scripts.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function scripts() {	
		wp_register_script( 'kata-plus-testimonials-vertical', Kata_Plus::$assets . 'js/frontend/testimonials-vertical.js', [ 'jquery' ], Kata_Plus_Pro::$version, true );		
	}

	/**
	 * Register frontend styles.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function frontend_styles() {
		wp_register_style( 'kata-plus-testimonials-vertical', Kata_Plus::$assets . 'css/frontend/testimonials-vertical.css', [], Kata_Plus_Pro::$version );
	}
	
	/**
	* Enqueue preview styles.
	*
	* @since   1.0.0
	* @access  public
	*/
	public function preview_styles() {
		wp_enqueue_style( 'kata-plus-fullpage', Kata_Plus::$assets . 'css/libraries/fullpage.css', [], Kata_Plus_Pro::$version );
		wp_enqueue_style( 'kata-plus-testimonials-vertical', Kata_Plus::$assets . 'css/frontend/testimonials-vertical.css', [], Kata_Plus_Pro::$version );
	}
}

new Kata_Plus_Pro_Testimonials_Vertical_Widget();
