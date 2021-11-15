<?php
/**
  * Kata_Plus_Pro_FontsManager_Page_Controller.
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
if ( ! class_exists( 'Kata_Plus_Pro_FontsManager_Page_Controller' ) ) :

    class Kata_Plus_Pro_FontsManager_Page_Controller {

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
         * Render the view.
         *
         * @since	1.0.0
         */
        public static function presenter() {
            $controller = isset( $_REQUEST['controller'] ) ? $_REQUEST['controller'] : '';
            do_action('kata_plus_pro_fonts_manager_render_view_start');
            switch ( strtolower( $controller ) ) {
                case 'settings':
                    Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions/helpers' , 'settings' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( self::$dir . 'views' , 'settings' );
                break;
                case 'font-squirrel':
                    Kata_Plus_Pro_Autoloader::load( self::$dir . 'functions/helpers' , 'font-squirrel' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( self::$dir . 'views/new' , 'font-squirrel' );
                break;
                default:
                    Kata_Plus_Pro_Autoloader::load( self::$dir . 'views', '404' );
                break;
            }
            do_action('kata_plus_pro_fonts_manager_render_view_end');
        }

    } //Class
    Kata_Plus_Pro_FontsManager_Page_Controller::get_instance();
endif;