<?php
/**
 * FontsManager_Edit_Page_Presenter.
 *
 * @author      author
 * @package     package
 * @since       1.0.0
 */

// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if ( ! class_exists( 'FontsManager_Edit_Page_Presenter' ) ) :
    class FontsManager_Edit_Page_Presenter extends WP_List_Table {

        /**
        * Instance of this class.
        *
        * @since     1.0.0
        * @access     private
        * @var     FontsManager_Edit_Page_Presenter
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
        * Define the core functionality of the FontsManager_Edit_Page_Presenter.
        *
        * Load the dependencies.
        *
        * @since     1.0.0
        */
        function __construct() {
            $this->definitions();
            $this->actions();

            if ( ! self::get_font() ) {
                echo("<script>location.href = '" . admin_url( 'admin.php?page=kata-plus-fonts-manager&404' ) . "';</script>");
                exit();
            }
        }

        /**
         * Add actions.
         *
         * @since	1.0.0
         */
        public function actions() {
            //add_filter( 'set-screen-option', [ $this, 'set_screen' ], 10, 3 );
        }

        /**
         * Global definitions.
         *
         * @since	1.0.0
         */
        public function definitions() {

        }

         /**
         * Description
         *
         * @since     1.0.0
         */
        public static function get_font() {
            global $wpdb;

            $sql = "SELECT * FROM " . $wpdb->prefix . Kata_Plus_Pro::$fonts_table_name . " WHERE ID=". esc_attr($_REQUEST['font_id']);
            $result = $wpdb->get_results( $sql, 'ARRAY_A');
            return current( $result );
        }


        /**
         * Render
         *
         * @since     1.0.0
         */
        public function render () {
            switch ($_REQUEST['source']) {
                case 'google':
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'functions/helpers' , 'google' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'views/edit' , 'google' );
                break;
                case 'font-squirrel':
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'functions/helpers' , 'font-squirrel' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'views/edit' , 'font-squirrel' );
                break;
                case 'typekit':
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'functions/helpers' , 'typekit' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'views/edit' , 'typekit' );
                break;
                case 'upload-font':
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'functions/helpers' , 'upload-font' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'views/edit' , 'upload-font' );
                break;
                case 'upload-icon':
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'functions/helpers' , 'upload-icon' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'views/edit' , 'upload-icon' );
                break;
                case 'custom-font':
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'functions/helpers' , 'custom-font' , '' , 'helper' );
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'views/edit' , 'custom-font' );
                break;
                default:
                    Kata_Plus_Pro_Autoloader::load( Kata_Plus_Pro_FontsManager_Edit_Page_Controller::$dir . 'views', '404');
                break;
            }
            return;
        }

    } //Class
endif;