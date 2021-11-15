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

class Kata_Task_Process_Widget {
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
		require_once dirname( __FILE__ ) . '/template/config.php';
	}

	/**
	 * Register Scripts.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function scripts() {
		wp_register_script( 'kata-plus-owlcarousel', Kata_Plus::$assets . 'js/libraries/owlcarousel.js', [ 'jquery' ], Kata_Plus_Pro::$version, true );		
		wp_register_script( 'kata-plus-owl', Kata_Plus::$assets . 'js/frontend/kata-owl.js', [ 'jquery' ], Kata_Plus_Pro::$version, true );				
	}

	/**
	 * Register Widget
	 *
	 * @since   1.0.0
	 * @access  private
	 */
	private function register_widget() {
		Plugin::instance()->widgets_manager->register_widget_type( new Kata_Task_Process() );
	}	

	/**
	 * Register frontend styles.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function frontend_styles() {
		wp_enqueue_style( 'kata-plus-owlcarousel', Kata_Plus::$assets . 'css/libraries/owlcarousel.css', [], Kata_Plus_Pro::$version );
		wp_enqueue_style( 'kata-plus-owl', Kata_Plus::$assets . 'css/frontend/kata-owl.css', [], Kata_Plus_Pro::$version );
		wp_register_style( 'kata-plus-task-process', Kata_Plus::$assets . 'css/frontend/task-process.css', [], Kata_Plus_Pro::$version );
	}

	/**
	 * Enqueue preview styles.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function preview_styles() {
		wp_enqueue_style( 'kata-plus-owlcarousel', Kata_Plus::$assets . 'css/libraries/owlcarousel.css', [], Kata_Plus_Pro::$version );
		wp_enqueue_style( 'kata-plus-owl', Kata_Plus::$assets . 'css/frontend/kata-owl.css', [], Kata_Plus_Pro::$version );
		wp_enqueue_style( 'kata-plus-task-process', Kata_Plus::$assets . 'css/frontend/task-process.css', [], Kata_Plus_Pro::$version );
	}
}

new Kata_Task_Process_Widget();
