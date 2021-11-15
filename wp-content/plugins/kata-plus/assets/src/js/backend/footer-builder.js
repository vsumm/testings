/**
 * Footer Builder.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */
'use strict';

var Kata_Plus_Footer_Builder_Template_manager = (function ($) {
    /**
     * Global variables.
     * 
     * @since	1.0.0
     */
    var content = '';
    var onetime = false;

    return {
        /**
         * Init.
         * 
         * @since	1.0.0
         */
        init: function () {
            if (onetime === false) {
                this.setupTemplateManagerInit();
                onetime = true;
            }
        },
        setupTemplateManagerInit: function () {

            var footerMenu = $('#tmpl-kt-library-menu'),
                footerMenuTemplate = footerMenu.text() + '\n<div class="elementor-template-library-menu-item kata-header-menu-item-footer" data-template-source="remote" data-template-type="block">Kata Footer</div>';

            footerMenu.text(footerMenuTemplate);

            $('#elementor-preview-iframe').contents().find('body').html();
            $(document).ajaxComplete(function (event, request, settings) {
                if (settings.data.indexOf('action=elementor_ajax') !== -1 && settings.data.indexOf('get_library_data') !== -1) {
                    setTimeout(Kata_Plus_Footer_Builder_Template_manager.addFilterInit, 100);
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
                    query = 'Kata Footer';

                $(document).on('click', '.elementor-template-library-menu-item', function () {
                    var this_ = $(this);
                    setTimeout(function (this_) {
                        $('#kt-library-menu').find('.elementor-template-library-menu-item').each(function () {
                            if (this_.html() != $(this).html()) {
                                $(this).removeClass('elementor-active');
                            }
                        });
                    }, 400, this_);

                    if ($(this).hasClass('kata-header-menu-item-footer')) {
                        filteredContent = !filteredContent;
                        filter.find('.kata-template-library-filter-button').removeClass('kata-template-library-filter-active');
                        input.data('query', 'kata footer');
                        input.trigger('input');
                    }
                });

                input.on('input', function (e) {
                    if ($(this).data('query') != 'kata footer') {
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

$(document).on('ready', function () {
    Kata_Plus_Footer_Builder_Template_manager.init();
});