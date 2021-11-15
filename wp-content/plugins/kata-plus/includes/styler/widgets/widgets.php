<?php

/**
 * Styler control for Widgets.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Styler_Widget_Field')) {
    class Styler_Widget_Field
    {
        public static function field($self, $field_id, $field_title, $field_variable, $styler_selectors)
        {
            $styler_data = get_option('styler_styles_' . $field_id, false);
            ?>
            <div class="w-col-sm-12 custom-widgets-kata-styler">
                <label for="<?php echo esc_html( $self->get_field_id($field_id) ); ?>"><?php echo esc_html(ucfirst($field_title)); ?>:</label>
                <a href="#" class="styler-dialog-btn" data-title="<?php echo esc_attr($field_title); ?>" data-selector='<?php echo isset($styler_selectors) ? json_encode($styler_selectors) : ''; ?>'>
                    <?php
                        foreach (Kata_Styler::fields() as $field) {
                            $val = isset($styler_data[$field]) ? $styler_data[$field] : '';
                            echo '<input type="hidden" name="styler[' . $field_id . '][' . $field . ']" value="' . $val . '" data-setting="' . $field . '">';
                        }
                        echo "<input type='hidden' name='styler[$field_id][selectors]' value='" . json_encode($styler_selectors) . "' >";
                        ?>
                    <img src="<?php echo Kata_Plus::$assets . 'images/styler-icon.svg'; ?>">
                </a>
            </div>
<?php
        }
    }

    add_action( 'wp_ajax_save-widget', function() {
        $styler = sanitize_text_field( $_POST['styler'] );
        if ( isset( $styler ) ) {
            $styler = $styler;
            foreach ( $styler as $name => $value ) {
                if ( strpos( $name, 'styler_' ) !== false ) {
                    update_option( 'styler_styles_'.$name, $value );
                }
            }
        }
    }, 1 );
}
