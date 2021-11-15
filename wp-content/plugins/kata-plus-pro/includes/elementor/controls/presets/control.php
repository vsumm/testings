<?php

/**
 * Presets Control Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Base_Data_Control;
use Elementor\Plugin;

class Kata_Plus_Pro_Elementor_Presets_Control extends Base_Data_Control
{
    /**
     * Control type name.
     *
     * @since   1.0.0
     */
    public function get_type()
    {
        return 'kata_plus_presets';
    }


    /**
     * Control HTML structure.
     *
     * @since   1.0.0
     */
    public function content_template()
    {
        $control_uid = $this->get_control_uid();
?>
        <div class="elementor-control-field kata-plus-control-presets">
            <div class="kt-presets-wrapper">
                <div class="kt-presets">
                    <# if (!window.KataPlusPresets || !window.KataPlusPresets[data.element] || window.KataPlusPresets[data.element].length===0) { #>
                        <div class="kata-plus-element-presets-loading">
                            <?php echo __('Loading...', 'kata-plus'); ?>
                        </div>
                        <div class="kata-plus-element-presets-empty">
                            <?php echo __('No Presets Found!', 'kata-plus'); ?>
                        </div>
                        <# } #>

                        <# if (window.KataPlusPresets && window.KataPlusPresets[data.element]) { #>
                            <# _.each( window.KataPlusPresets[data.element], function( preset ) { #>
                                <div class="kt-preset-item" data-preset-id='{{{preset.id}}}'>
                                    <i class="ti-check"></i>
                                    <# if (preset.thumbnail) { #>
                                    <figure>
                                        <img src="{{{preset.thumbnail}}}" alt="{{{preset.title}}}">
                                        <figcaption>{{{preset.title}}}</figcaption>
                                    </figure>
                                    <# } #>
                                </div>
                            <# } ); #>
                        <# } #>
                </div>
            </div>
        </div>
<?php
    }
}

Plugin::$instance->controls_manager->register_control('kata_plus_presets', new Kata_Plus_Pro_Elementor_Presets_Control());
