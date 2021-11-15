<?php
/**
 * Styler control for meta box.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'save_post', 'kata_styler_save_post_meta_box' );

function kata_styler_save_post_meta_box( $post_id = '' ) {
	if ( empty( $post_id ) || wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
		return;
	}

	$css  = '';
	$keys = [
		'kata_styler_page_title' => Kata_Styler::output( 'html body' ),
		'styler_body'            => Kata_Styler::output( 'html body' ),
		'styler_content'         => Kata_Styler::output( '#kata-site.kata-site' ),
	];

	foreach ( $keys as $key => $selectors ) {
		$values = get_post_meta( $post_id, $key, true );

		if ( is_array( $values ) ) {
			foreach ( $values as $key => $value ) {
				if ( !$value ) {
					continue;
				}
				switch ( $key ) {
					case 'desktop':
					case 'desktophover':
					case 'desktopphover':
					case 'desktopbefore':
					case 'desktopafter':
						$css .= $selectors[ $key ] . '{' . $value . '}';
						break;
					case 'laptop':
					case 'laptophover':
					case 'laptopphover':
					case 'laptopbefore':
					case 'laptopafter':
						$css .= '@media screen and (max-width:1366px) {' . $selectors[ $key ] . '{' . $value . '} }';
						break;
					case 'tablet':
					case 'tablethover':
					case 'tabletphover':
					case 'tabletbefore':
					case 'tabletafter':
						$css .= '@media screen and (max-width:768px) {' . $selectors[ $key ] . '{' . $value . '} }';
						break;
					case 'tabletlandscape':
					case 'tabletlandscapehover':
					case 'tabletlandscapephover':
					case 'tabletlandscapebefore':
					case 'tabletlandscapeafter':
						$css .= '@media screen and (max-width:1024px) {' . $selectors[ $key ] . '{' . $value . '} }';
						break;
					case 'mobile':
					case 'mobilehover':
					case 'mobilephover':
					case 'mobilebefore':
					case 'mobileafter':
						$css .= '@media screen and (max-width:560px) {' . $selectors[ $key ] . '{' . $value . '} }';
						break;
					case 'smallmobile':
					case 'smallmobilehover':
					case 'smallmobilephover':
					case 'smallmobilebefore':
					case 'smallmobileafter':
						$css .= '@media screen and (max-width:470px) {' . $selectors[ $key ] . '{' . $value . '} }';
						break;
				}
			}
		}
	}

	if ( $css ) {
		// erise unnecessary css
		$css = Kata_Styler::unnecessary_css_erise( $css );
		update_post_meta( $post_id, 'kata_page_dynamic_css', $css );
	}
}

if ( class_exists( 'RWMB_Field' ) ) {
	if ( ! class_exists( 'RWMB_Styler_Field' ) ) {
		class RWMB_Styler_Field extends RWMB_Multiple_Values_Field {
			public static function html( $meta, $args ) {
				ob_start();
				?>
				<div class="w-col-sm-12 custom-kata-styler">
					<a href="#" class="styler-dialog-btn" data-selector="" data-title="<?php echo esc_attr( $args['name'] ); ?>" data-fields="<?php echo isset( $args['styler_fields'] ) ? $args['styler_fields'] : ''; ?>">
						<?php
						foreach ( Kata_Styler::fields() as $field ) {
							$val = isset( $meta[0][ $field ] ) ? $meta[0][ $field ] : '';
							echo '<input type="hidden" name="' . $args['id'] . '[' . $field . ']" value="' . $val . '" data-setting="' . $field . '">';
						}
						?>
						<img src="<?php echo Kata_Plus::$assets . 'images/styler-icon.svg'; ?>">
					</a>
				</div>
				<?php
				return ob_get_clean();
			}

			public static function save( $new, $old, $post_id, $field ) {
				if ( empty( $field['id'] ) || ! $field['save_field'] ) {
					return;
				}

				$name    = $field['id'];
				$storage = $field['storage'];

				$storage->delete( $post_id, $name );
				$storage->update( $post_id, $name, $new );
			}

		}
	}
}

add_action(
	'wp_enqueue_scripts',
	function() {
		wp_register_style( 'kata-plus-meta-theme-styles', false );
		wp_enqueue_style( 'kata-plus-meta-theme-styles' );
		wp_add_inline_style( 'kata-plus-meta-theme-styles', get_post_meta( get_the_ID(), 'kata_page_dynamic_css', true ) );
	},
	9999
);
