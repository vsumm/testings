<?php
// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( class_exists( 'ReduxFramework_Extension_Kata_Styler' ) ) {
    class ReduxFramework_Extension_Kata_Styler {

        protected $parent;
        public static $theInstance;

        public function __construct( $parent ) {
            $this->parent = $parent;
            $this->field_name = 'kata_styler';
            self::$theInstance = $this;

            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, [ &$this, 'overload_field_path' ] );
        }

        /**
         *
         * Get instance of class
         *
         * @return object
         *
         */
        public function getInstance() {
            return self::$theInstance;
        }

        /**
         *
         * Extension file path
         *
         * @return string
         *
         */
        public function overload_field_path($field) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '.php';
        }
    }
}