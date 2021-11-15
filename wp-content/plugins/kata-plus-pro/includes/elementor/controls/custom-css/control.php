<?php
/**
 * Icon Control Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Base_Data_Control;
use Elementor\Plugin;

class Custom_Code_Elementor extends Base_Data_Control {
	/**
	 * Control type name.
	 *
	 * @since   1.0.0
	 */
	public function get_type() {
		return 'kata_plus_custom_code';
	}


	/**
	 * Control enqueue live assets.
	 *
	 * @since   1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'kata-plus-custom-code', Kata_Plus_Pro::$assets . 'css/libraries/codemirror.css', [], Kata_Plus_Pro::$version );
		wp_enqueue_script( 'kata-plus-custom-code', Kata_Plus_Pro::$assets . 'js/libraries/codemirror.js', [ 'jquery' ], Kata_Plus_Pro::$version, false );
		wp_enqueue_script( 'kata-plus-custom-code-css', Kata_Plus_Pro::$assets . 'js/libraries/codemirror-css.js', [ 'jquery' ], Kata_Plus_Pro::$version, false );
		wp_enqueue_script( 'kata-plus-custom-code-close-bracket', Kata_Plus_Pro::$assets . 'js/libraries/codemirror-autoclosebracket.js', [ 'jquery' ], Kata_Plus_Pro::$version, false );
		wp_enqueue_script( 'kata-plus-custom-code-customize', Kata_Plus_Pro::$assets . 'js/backend/codemirror-customize.js', [ 'jquery' ], Kata_Plus_Pro::$version, false );
	}

	/**
	 * Control HTML structure.
	 *
	 * @since   1.0.0
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="kata-custom-css-field">
				<form>
					<textarea id="<?php echo esc_attr( $control_uid ); ?>" class="elementor-input-style" rows="{{ data.rows }}" data-setting="{{ data.name }}" placeholder="{{ data.placeholder }}"></textarea>
				</form>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{ data.description }}</div>
		<# } #>
		<?php
	}
}

Plugin::$instance->controls_manager->register_control( 'kata_plus_custom_code', new Custom_Code_Elementor() );
