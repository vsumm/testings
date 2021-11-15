<?php
// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Styler control for redux customizer
 *
 */
if ( ! class_exists( 'Redux_Customizer_Control_kata_styler' ) ) {
	class Redux_Customizer_Control_kata_styler extends Redux_Customizer_Control {
		public $type = 'redux-kata_styler';
	}
}