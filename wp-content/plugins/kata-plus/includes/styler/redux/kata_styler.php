<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ReduxFramework_kata_styler' ) ) {
	class ReduxFramework_kata_styler extends ReduxFramework_Extension_Kata_Styler {


		public function __construct( $field = [], $value = '', $parent ) {

			$this->parent = $parent;
			$this->field  = $field;
			$this->value  = $value;
		}

		/**
		 *
		 * HTML output styler option
		 *
		 * @return string
		 */
		public function render() {

			echo '<div class="redux-kata-styler" data-id="' . $this->field['id'] . '">';

			echo '<a href="#" class="styler-dialog-btn" data-title="' . $this->field['title'] . '"  data-title="' . @$this->field['styler_fields'] . '" data-selector=\'' . json_encode( $this->field['output'] ) . '\'>';
			foreach ( Kata_Styler::fields() as $field ) {
				echo '<input type="hidden" name="' . $this->field['name'] . $this->field['name_suffix'] . '[' . $field . ']' . '" value="' . ( empty( $this->value[ $field ] ) ? '' : $this->value[ $field ] ) . '" data-setting="' . $field . '">';
			}
			?>

			<img src="<?php echo Kata_Plus::$assets . 'images/styler-icon.svg'; ?>">
			<?php

			echo '</a>';
			echo '</div>';
		}

		/**
		 *
		 * CSS output
		 *
		 * @return string
		 */
		public function output() {

			if ( ! empty( $this->value ) ) {
				if ( ! empty( $this->field['output'] ) && is_array( $this->field['output'] ) ) {
					foreach ( $this->field['output'] as $k => $v ) {
						if ( ! empty( $this->value[ $k ] ) ) {

							if ( $k === 'tablet' ) {
								 $this->parent->outputCSS .= '@media screen and (max-width:768px){' . str_replace( '(tablet-)', '', $v ) . '{' . $this->value[ $k ] . '}}';
							} elseif ( $k === 'tabletlandscape' ) {
								 $this->parent->outputCSS .= '@media screen and (max-width:1024px){' . str_replace( '(tabletlandscape-)', '', $v ) . '{' . $this->value[ $k ] . '}}';
							} elseif ( $k === 'mobile' ) {
								 $this->parent->outputCSS .= '@media screen and (max-width:560px){' . str_replace( '(mobile-)', '', $v ) . '{' . $this->value[ $k ] . '}}';
							} elseif ( $k === 'smallmobile' ) {
								 $this->parent->outputCSS .= '@media screen and (max-width:470px){' . str_replace( '(smallmobile-)', '', $v ) . '{' . $this->value[ $k ] . '}}';
							} elseif ( $k === 'laptop' ) {
								 $this->parent->outputCSS .= '@media screen and (max-width:1366px){' . str_replace( '(laptop-)', '', $v ) . '{' . $this->value[ $k ] . '}}';
							} else {
								 $this->parent->outputCSS .= $v . '{' . $this->value[ $k ] . '}';
							}
						}
					}
				}
			}
		}

	}
}
