/**
 * Header Builder.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */
'use strict';

jQuery(document).ready(function () {
    // Add New Row
    jQuery(jQuery('#elementor-preview-iframe')).on('load', function () {
        var $elementorPreviewIframe = jQuery('#elementor-preview-iframe').contents();
        $elementorPreviewIframe.find('.elementor-add-section-drag-title').html("Add new row");
        $elementorPreviewIframe.find('.elementor-add-section-button').attr('title', 'Add New 3 Column Section');
        $elementorPreviewIframe.find("body").on("click", ".elementor-add-section-button", function () {
            jQuery(this).parents('.elementor-add-section').find('ul.elementor-select-preset-list li.elementor-column[data-structure="30"]').trigger('click');
            return false;
        });
        $elementorPreviewIframe.find("body").on("click", ".elementor-editor-element-add", function () {
            jQuery(this).parents('.elementor-section').siblings('.elementor-add-section').find('ul.elementor-select-preset-list li.elementor-column[data-structure="30"]').trigger('click');
            return false;
        });
    })
});
var Kata_Plus_Header_Builder_Template_manager = (function ($) {
    /**
     * Global variables.
     *
     * @since	1.0.0
     */
    var content = '';
    var layout = false;
    var onetime = false;
    var TemplateOneTime = false;

    return {
        /**
         * Init.
         *
         * @since	1.0.0
         */
        init: function () {
            return false;
            if (onetime === false) {
                this.setupTemplateManagerInit();
                onetime = true;
            }
        },
        setupTemplateManagerInit: function () {

            var headerMenu = $('#tmpl-kt-library-menu'),
                headerMenuTemplate = headerMenu.text() + '\n<div class="elementor-template-library-menu-item kata-header-menu-item-header" data-template-source="remote" data-template-type="block">Kata Header</div>';

            headerMenu.text(headerMenuTemplate);

            $('#elementor-preview-iframe').contents().find('body').html();
            $(document).ajaxComplete(function (event, request, settings) {
                if (settings.data.indexOf('action=elementor_ajax') !== -1 && settings.data.indexOf('get_library_data') !== -1) {
                    setTimeout(Kata_Plus_Header_Builder_Template_manager.addFilterInit, 100);
                }
            });
        },
        addFilterInit: function () {
            content = elementor.templates.getLayout().modalContent;
            content.listenTo(content, 'show', function () {
                var filter = content.$el.find('#elementor-template-library-filter-toolbar-remote');
                if (!filter.length) {
                    return;
                }
                var input = content.$el.find('#elementor-template-library-filter-text'),
                    filteredContent = false,
                    query = 'Kata Header';

                $(document).on('click', '.elementor-template-library-menu-item', function () {
                    var this_ = $(this);
                    setTimeout(function (this_) {
                        $('#kt-library-menu').find('.elementor-template-library-menu-item').each(function () {
                            if (this_.html() != $(this).html()) {
                                $(this).removeClass('elementor-active');
                            }
                        });
                    }, 400, this_);

                    if ($(this).hasClass('kata-header-menu-item-header')) {
                        filteredContent = !filteredContent;
                        filter.find('.kata-template-library-filter-button').removeClass('kata-template-library-filter-active');
                        input.data('query', 'kata header');
                        input.trigger('input');
                    }
                });

                input.on('input', function (e) {
                    if ($(this).data('query') != 'kata header') {
                        return false;
                    }
                    if (filteredContent) {
                        e.stopPropagation();
                        if (input.val()) {
                            elementor.templates.setFilter('text', query + ' - ' + input.val());
                        } else {
                            elementor.templates.setFilter('text', query);
                        }
                    } else {
                        e.stopPropagation();
                        elementor.templates.setFilter('text', input.val());
                    }
                });
            });
        },
    }
})(jQuery);

jQuery(document).on('ready', function () {
    Kata_Plus_Header_Builder_Template_manager.init();
});