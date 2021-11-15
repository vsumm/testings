<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 *
 * Styler control for elementor
 *
 * @author Kata
 * @link  https://climaxthemes.com/kata/
 */
if ( ! class_exists( 'Kata_Styler_Elementor_Control' ) ) {
	class Kata_Styler_Elementor_Control extends \Elementor\Control_Base_Multiple {
		/**
		 *
		 * Control type name
		 *
		 * @return string
		 */
		public function get_type() {
			return 'kata_styler';
		}

		/**
		 *
		 * Control enqueue live assets
		 *
		 * @return string
		 */
		public function enqueue() {
			Kata_Styler::enqueue();
		}

		/**
		 *
		 * Control HTML structure
		 *
		 * @return string
		 */
		public function content_template() {

			$control_uid = $this->get_control_uid();
			$inputs      = Kata_Styler::fields();
			?>
				<div class="elementor-control-field">
					<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
					<div class="elementor-control-input-wrapper">
						<div class="styler-dialog-btn <?php echo esc_attr( $this->get_control_uid( 'styler-btn' ) ); ?>" data-title="{{ data.label }}" data-cid="{{data._cid}}" data-selector="{{ data.styler_selectors }}">
						<?php
						foreach ( $inputs as $n ) {
							if($n != 'citem'){
								echo '<input type="hidden" id="' . esc_attr( $this->get_control_uid( $n ) ) . '" value="" class="kata-plus-res-inputs" data-setting="' . esc_attr( $n ) . '"/>';
							}
						}
							echo '<input type="hidden" id="' . esc_attr( $this->get_control_uid( 'citem' ) ) . '" value="{{data._cid}}" class="kata-plus-res-inputs" data-setting="citem"/>';
						?>

						<img src="<?php echo Kata_Plus::$assets . 'images/styler-icon.svg'; ?>">
						</div>
					</div>
				</div>
				<# if ( data.description ) { #>
				<div class="elementor-control-field-description">{{ data.description }}</div>
				<# } #>
			<?php

		}
	}
}
