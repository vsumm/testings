<?php
/**
 * Styler Kirki Control Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Styler_Control_Kirki' ) ) {
	add_action(
		'customize_register',
		function( $wp_customize ) {
			class Kata_Styler_Control_Kirki extends Kirki_Control_Base {
				public $type = 'kata_styler';
				public function render_content() {
					$styler_data = get_option('styler_' . $this->id ,false);
					?>
					<div class="kirki-kata-styler" data-id="<?php echo esc_attr( $this->id ); ?>">
						<span class="customize-control-title">
							<?php echo esc_html( $this->label ); ?>
						</span>
						<a href="#" class="styler-dialog-btn" data-title="<?php echo esc_attr( $this->label ); ?>"  data-selector='<?php echo json_encode( $this->choices['fields'] ); ?>'>
						<input type="hidden" data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>">
							<?php
							$styler_data = get_option('styler_' . $this->id, false);
							foreach ( kata_Styler::fields() as $field ) {
								echo '<input type="hidden" name="styler_' . $this->id . '[' . $field . ']' . '" value="' . ( empty( $styler_data[ $field ] ) ? '' : str_replace( '\\', '', $styler_data[ $field ] ) ) . '" data-setting="' . $field . '">';
							}
							?>
							<img src="<?php echo Kata_Plus::$assets . 'images/styler-icon.svg'; ?>">
						</a>
					</div>
					<?php
				}

			}
			// Register our custom control with Kirki
			add_filter(
				'kirki_control_types',
				function( $controls ) {
					$controls['kata_styler'] = 'Kata_Styler_Control_Kirki';
					return $controls;
				}
			);
		}
	);
}
