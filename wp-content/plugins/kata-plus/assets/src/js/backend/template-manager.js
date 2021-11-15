/**
 * Builder.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */
'use strict';
var Kata_Plus_Template_manager = (function ($) {
    /**
     * Global variables.
     *
     * @since	1.0.0
     */
    var modal = '';
    var onetime = false;
    var TemplateOneTime = false;

    return {
        /**
         * Init.
         *
         * @since	1.0.0
         */
        init: function () {
            if (onetime === false) {
                modal = jQuery('#kata-elementor-template-library-modal');
                this.load();
                onetime = true;
            }
        },
        load: function () {
            var TemplateManagerButtonScript = jQuery('#tmpl-elementor-add-section');
            var Text = TemplateManagerButtonScript.text();
            var button = '<div class="elementor-add-section-area-button kata-elementor-add-template-button" title="Add Kata Template"><i></i></div>';
            Text = Text.replace('<div class="elementor-add-section-drag-title">', button + '<div class="elementor-add-section-drag-title">');
            TemplateManagerButtonScript.text(Text);


            jQuery(document).on('click', '#kata-elementor-template-library-modal .elementor-templates-modal__header__close i', function () {
                jQuery('#kata-elementor-template-library-modal').css('display', 'none');
            });

            jQuery(document).on('click', '.kata-plus-elementor-add-template-button', function () {
                // Scrollbar
                console.log(1);
                $('#kt-library-modal .dialog-message dialog-lightbox-message').niceScroll({
                    cursorcolor: "#aaa", // change cursor color in hex
                    cursoropacitymin: 0, // change opacity when cursor is inactive (scrollabar "hidden" state), range from 1 to 0
                    cursoropacitymax: 1, // change opacity when cursor is active (scrollabar "visible" state), range from 1 to 0
                    cursorwidth: "7px", // cursor width in pixel (you can also write "5px")
                    cursorborder: "none", // css definition for cursor border
                    cursorborderradius: "5px", // border radius in pixel for cursor
                    scrollspeed: 60, // scrolling speed
                    mousescrollstep: 40, // scrolling speed with mouse wheel (pixel)
                    hwacceleration: true, // use hardware accelerated scroll when supported
                    gesturezoom: true, // (only when boxzoom=true and with touch devices) zoom activated when pinch out/in on box
                    grabcursorenabled: true, // (only when touchbehavior=true) display "grab" icon
                    autohidemode: true, // how hide the scrollbar works, possible values:
                    spacebarenabled: true, // enable page down scrolling when space bar has pressed
                    railpadding: {
                        top: 0,
                        right: 1,
                        left: 0,
                        bottom: 1
                    }, // set padding for rail bar
                    disableoutline: true, // for chrome browser, disable outline (orange highlight) when selecting a div with nicescroll
                    horizrailenabled: false, // nicescroll can manage horizontal scroll
                    railalign: 'right', // alignment of vertical rail
                    railvalign: 'bottom', // alignment of horizontal rail
                    enablemousewheel: true, // nicescroll can manage mouse wheel events
                    enablekeyboard: true, // nicescroll can manage keyboard events
                    smoothscroll: true, // scroll with ease movement
                    cursordragspeed: 0.3, // speed of selection when dragged with cursor
                });
            });

            jQuery(document).on('click', '#kata-elementor-template-library-modal .elementor-template-library-menu-item', function () {
                modal.find('.elementor-template-library-menu-item').removeClass('elementor-active')
                jQuery(this).toggleClass('elementor-active');
                modal.find('.elementor-template-library-template').removeClass('active');
                if (jQuery(this).data('tab') == 'blocks') {
                    modal.find('.elementor-template-library-template[data-type="block"]').addClass('active');
                } else if (jQuery(this).data('tab') == 'pages') {
                    modal.find('.elementor-template-library-template[data-type="page"]').addClass('active');
                } else {
                    modal.find('.elementor-template-library-template[data-subtype="' + jQuery(this).data('tab') + '"]').addClass('active');
                }
            });

            jQuery(document).on('click', '#kata-elementor-template-library-modal .elementor-template-library-template .elementor-template-library-template-preview', function (e) {
                e.preventDefault();
                var preview = jQuery(this).parents('.elementor-template-library-template').data('preview');
                modal.find('.dialog-header.dialog-lightbox-header').removeClass('active');
                modal.find('.dialog-header.dialog-lightbox-header.live-preview').addClass('active');
                modal.find('.dialog-content #elementor-template-library-templates').css('display', 'none');
                modal.find('.dialog-content #elementor-template-library-preview').append('<iframe src="' + preview + '"></iframe>');
                modal.find('.dialog-content #elementor-template-library-preview').css('display', 'block');
            });

            jQuery(document).on('click', '#kata-elementor-template-library-modal #elementor-template-library-header-preview-back', function (e) {
                e.preventDefault();
                modal.find('.dialog-header.dialog-lightbox-header').addClass('active');
                modal.find('.dialog-header.dialog-lightbox-header.live-preview').removeClass('active');
                modal.find('.dialog-content #elementor-template-library-templates').css('display', 'block');
                modal.find('.dialog-content #elementor-template-library-preview').html('');
                modal.find('.dialog-content #elementor-template-library-preview').css('display', 'none');
            });

            // jQuery(document).on('click', '#kata-elementor-template-library-modal .elementor-template-library-template-insert', function (e) {
            //     var id = jQuery(this).parents('.elementor-template-library-template').data('id');
            //     $e.components.get('library').manager.requestTemplateContent('remote', id, {
            //         data: {
            //             with_page_settings: true,
            //         },
            //         success: function success(data) {
            //             // console.log(this.view.model);
            //             // Clone the `modalConfig.importOptions` because it deleted during the closing.
            //             var importOptions = jQuery.extend({}, $e.components.get('library').manager.modalConfig.importOptions);
            //             importOptions.withPageSettings = true; // Hide for next open.
            //             var models = Backbone.Collection.extend({
            //                 model: $e.components.get('library').manager.getTemplatesCollection()
            //             });
            //             console.log(models);

            //             $e.run('document/elements/import', {
            //                 model: models,
            //                 data: data,
            //                 options: importOptions
            //             });
            //             jQuery('#kata-elementor-template-library-modal').css('display', 'none');
            //         },
            //         error: function error(data) {
            //             self.showErrorDialog(data);
            //         },
            //         complete: function complete() {
            //             jQuery('#kata-elementor-template-library-modal').css('display', 'none');
            //         }
            //     });
            //     // jQuery.ajax({
            //     //     type: "post",
            //     //     url: ajaxurl,
            //     //     dataType: "json",
            //     //     data: {
            //     //         action: 'kata_plus_get_template_data',
            //     //         template_id: id,
            //     //     },
            //     //     success: function success(data) {
            //     //         // Clone `self.modalConfig` because it deleted during the closing.
            //     //         var _importOptions = {
            //     //             attributes: kataTemplates[id],
            //     //             cid: ''
            //     //         };
            //     //         // $e.components.get('library').insertTemplate()
            //     //         // $t = new elementorModules.common.views.modal.Layout()
            //     //         var importOptions = jQuery.extend({}, _importOptions);

            //     //         // Hide for next open.
            //     //         jQuery('#kata-elementor-template-library-modal').css('display', 'none');

            //     //         $e.run('document/elements/create', {
            //     //             model: {
            //     //                 elType: 'section'
            //     //             },
            //     //             container: {
            //     //                 content: data.content,
            //     //                 page_settings: []
            //     //             },
            //     //             columns: 1,
            //     //             options: {
            //     //                 at: 'at',
            //     //                 // BC: Deprecated since 2.8.0 - use `$e.hooks`.
            //     //                 trigger: {
            //     //                     beforeAdd: 'section:before:drop',
            //     //                     afterAdd: 'section:after:drop'
            //     //                 }
            //     //             }
            //     //         }); // Create the element in column.

            //     //         // $e.run('document/elements/import', {
            //     //         //     model: {},
            //     //         //     data: data,
            //     //         //     options: importOptions
            //     //         // });

            //     //         // elementor.channels.data.trigger('template:before:insert', 'remote');

            //     //         // elementor.getPreviewView().addChildModel(data.content, importOptions);

            //     //         // elementor.channels.data.trigger('template:after:insert', 'remote');

            //     //         // if (options.withPageSettings) {
            //     //         //     elementor.settings.page.model.setExternalChange(data.page_settings);
            //     //         // }
            //     //     },
            //     //     error: function error(data) {
            //     //         self.showErrorDialog(data);
            //     //     },
            //     //     complete: function complete() {
            //     //         jQuery('#kata-elementor-template-library-modal').css('display', 'none');
            //     //     }
            //     // });

            // });

            // var InsertTemplateHandler;
            // InsertTemplateHandler = Marionette.Behavior.extend({
            //     ui: {
            //         insertButton: '.elementor-template-library-template-insert.kata-plus-insert-template'
            //     },
            //     events: {
            //         'click @ui.insertButton': 'onInsertButtonClick'
            //     },
            //     onInsertButtonClick: function onInsertButtonClick() {
            //         console.log('ok');

            //         var args = {
            //             model: this.view.model
            //         };

            //         if ('remote' === args.model.get('source') && !elementor.config.library_connect.is_connected) {
            //             $e.route('library/connect', args);
            //             return;
            //         }

            //         $e.run('library/insert-template', args);
            //     }
            // });
            // module.exports = InsertTemplateHandler;

            jQuery(document).on('input', '#kata-elementor-template-library-modal #elementor-template-library-filter-text', function () {
                var search = jQuery(this).val();
                var type = jQuery('#kata-elementor-template-library-modal #kt-library-menu .elementor-active').data('tab');
                if (type == 'blocks') {
                    if (!search) {
                        modal.find('.elementor-template-library-template[data-type="block"]').addClass('active');
                    } else {
                        modal.find('.elementor-template-library-template[data-type="block"]').removeClass('active');
                        modal.find('.elementor-template-library-template[data-type="block"] .elementor-template-library-template-name:contains("' + search + '")').parents('.elementor-template-library-template').addClass('active');
                    }
                } else if (type == 'pages') {
                    if (!search) {
                        modal.find('.elementor-template-library-template[data-type="page"]').addClass('active');
                    } else {
                        modal.find('.elementor-template-library-template[data-type="page"]').removeClass('active');
                        modal.find('.elementor-template-library-template[data-type="page"] .elementor-template-library-template-name:contains("' + search + '")').parents('.elementor-template-library-template').addClass('active');
                    }
                } else {
                    if (!search) {
                        modal.find('.elementor-template-library-template[data-subtype="' + type + '"]').addClass('active');
                    } else {
                        modal.find('.elementor-template-library-template[data-subtype="' + type + '"]').removeClass('active');
                        modal.find('.elementor-template-library-template[data-subtype="' + type + '"] .elementor-template-library-template-name:contains("' + search + '")').parents('.elementor-template-library-template').addClass('active');
                    }
                }
            })
        }
    }
})(jQuery);

jQuery(document).on('ready', function () {
    Kata_Plus_Template_manager.init();
});

jQuery(window).on('load', function () {
    jQuery(elementor.$preview.contents()).on('click', '.kata-elementor-add-template-button', function () {
        jQuery('#kata-elementor-template-library-modal').css('display', 'block');
        if (typeof (kata_plus_this_page_name) != 'undefined') {
            jQuery('#kata-elementor-template-library-modal .elementor-template-library-menu-item.kata-header-menu-item-' + kata_plus_this_page_name).trigger('click');
        }
    })
});