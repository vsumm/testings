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

class Kata_Plus_Pro_comparison_slider_Widget {
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
		Plugin::instance()->widgets_manager->register_widget_type( new Kata_Plus_Pro_comparison_slider() );
	}

	/**
	 * Register scripts.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function scripts() {
		wp_register_script( 'kata-plus-juxtapose', Kata_Plus::$assets . 'js/libraries/juxtapose.js', [ 'jquery' ], Kata_Plus_Pro::$version, true );
		wp_register_script( 'kata-plus-comparison-slider', Kata_Plus::$assets . 'js/frontend/comparison-slider.js', [ 'jquery' ], Kata_Plus_Pro::$version, true );
	}

	/**
	 * Register frontend styles.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function frontend_styles() {
		wp_register_style( 'kata-plus-juxtapose', Kata_Plus::$assets . 'css/libraries/juxtapose.css', [], Kata_Plus_Pro::$version );
		wp_register_style( 'kata-plus-comparison-slider-css', Kata_Plus::$assets . 'css/frontend/comparison-slider.css', [], Kata_Plus_Pro::$version );
	}

	/**
	 * Enqueue preview styles.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function preview_styles() {
		wp_enqueue_style( 'kata-plus-juxtapose', Kata_Plus::$assets . 'css/libraries/juxtapose.css', [], Kata_Plus_Pro::$version );
		wp_enqueue_style( 'kata-plus-comparison-slider', Kata_Plus::$assets . 'css/frontend/comparison-slider.css', [], Kata_Plus_Pro::$version );
	}
}

new Kata_Plus_Pro_comparison_slider_Widget();
