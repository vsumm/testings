<?php
/**
  * Kata_Plus_Pro_FontsManager_Main_Page_Controller.
  *
  * @author     ClimaxThemes
  * @package	Kata Plus
  * @since	    1.0.0
  */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
if ( ! class_exists( 'Kata_Plus_Pro_FontsManager_Main_Page_Controller' ) ) :

    class Kata_Plus_Pro_FontsManager_Main_Page_Controller {

        /**
		 * The directory of the file.
		 *
		 * @access	public
		 * @var		string
		 */
        public static $dir;

        /**
         * Instance of this class.
         *
         * @since    1.0.0
         * @access   private
         * @var      Kata_Plus_Pro_FontsManager
         */
         private static $instance;

         /**
         * Provides access to a single instance of a module using the singleton pattern.
         *
         * @since   1.0.0
         * @return	object
         */
        public static function get_instance() {
            if ( self::$instance === null ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Load the dependencies.
         *
         * @since     1.0.0
         */
        function __construct() {
            $this->definitions();
            $this->actions();
        }

        /**
         * Global definitions.
         *
         * @since	1.0.0
         */
        public function definitions() {
            self::$dir		= Kata_Plus_Pro_FontsManager::$dir . 'inc/pages/';
        }

        /**
         * Load dependencies.
         *
         * @since	1.0.0
         */
        public function dependencies() {
            // Main Presenter
            Kata_Plus_Pro_Autoloader::load( self::$dir . 'presenter', 'main');
        }

         /**
         * actions
         *
         * @since     1.0.0
         */
        public function actions () {
        }


        /**
         * Render the view.
         *
         * @since	1.0.0
         */
        public static function presenter() {
            do_action('kata_plus_pro_fonts_manager_render_view_start');
            Kata_Plus_Pro_Autoloader::load( self::$dir . 'presenter', 'main' );
            $presenter = new FontsManager_Main_Page_Presenter;
            $presenter->render();
            do_action('kata_plus_pro_fonts_manager_render_view_end');
            return;
        }

    } //Class
    Kata_Plus_Pro_FontsManager_Main_Page_Controller::get_instance();
endif;