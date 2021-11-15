/**
 * Full Site Editor.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */
'use strict';
var Kata_Plus_Full_Site_Editor = (function ($) {
    /**
     * Global variables.
     *
     * @since	1.0.0
     */
    var onetime = false;

    return {
        /**
         * Init.
         *
         * @since	1.0.0
         */
        init: function () {
            if (onetime === false) {
                this.FullSiteEdit();
                onetime = true;
            }
        },

        /**
         * Elementor Full Site Edit
         *
         * @author ClimaxThemes
         * @since 1.0.0
         */
        FullSiteEdit: function () {
            $('.elementor').each(function (index, element) {
                var $template = $(this),
                    urlbase = window.location.href;

                $template.append('<div class="kata-full-site-edit"><i class="eicon-edit"></i><span>Edit</span></div>');
            });
            $(document).on('click', '.kata-full-site-edit', function () {
                var $template = $(this),
                    $templateWrap = $template.closest('.elementor');
                elementorCommon.api.internal('panel/state-loading');
                elementorCommon.api.run('editor/documents/switch', {
                    id: $templateWrap.data('elementor-id')
                }).finally(function () {
                    setTimeout(function () {
                        $('.elementor').each(function (index, element) {
                            var $template = $(this),
                                urlbase = window.location.href;
                            $template.append('<div class="kata-full-site-edit"><i class="eicon-edit"></i><span>Edit</span></div>');
                        });
                    }, 2000);
                    return elementorCommon.api.internal('panel/state-ready');
                });
            });
        },
    }
})(jQuery);

jQuery(document).on('ready', function () {
    Kata_Plus_Full_Site_Editor.init();
});