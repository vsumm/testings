/**
 *
 * ClimaxThemes live Elementor
 *
 * @author ClimaxThemes
 * @link http://climaxthemes.com
 *
 */
(function ($) {
    'use strict';
    jQuery(window).on('elementor:init', function () {

        if (typeof (elementor) == 'undefined') {
            return false;
        }

        // var SData = {};
        var InInput = false;
        var StylesToSave = {
            'css': {},
            'change': false
        };
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };

        // Start new customize changes
        var KataCreateCss = function (selectors, $selector, $val) {
            return;
            // console.log($selector);
            switch ($selector) {
                case 'desktop':
                case 'desktophover':
                case 'desktopphover':
                case 'desktopbefore':
                case 'desktopafter':
                    // return selectors[$selector] + '{ ' + $val + ' }';
                    break;
                case 'laptop':
                case 'laptophover':
                case 'laptopphover':
                case 'laptopbefore':
                case 'laptopafter':
                    return '@media(max-width:1367px){ ' + selectors[$selector] + '{' + $val + ' }}';
                    break;
                case 'tablet':
                case 'tablethover':
                case 'tabletphover':
                case 'tabletbefore':
                case 'tabletafter':
                    console.log(selectors[$selector]);

                    return '@media(max-width:769px){ ' + selectors[$selector] + '{' + $val + ' }}';
                    break;
                case 'tabletlandscape':
                case 'tabletlandscapehover':
                case 'tabletlandscapephover':
                case 'tabletlandscapebefore':
                case 'tabletlandscapeafter':
                    return '@media(max-width:1025px){ ' + selectors[$selector] + '{' + $val + ' }}';
                    break;
                case 'mobile':
                case 'mobilehover':
                case 'mobilephover':
                case 'mobilebefore':
                case 'mobileafter':
                    // return '@media(max-width:481px){ ' + selectors[$selector] + '{' + $val + ' }}';
                    break;
                case 'smallmobile':
                case 'smallmobilehover':
                case 'smallmobilephover':
                case 'smallmobilebefore':
                case 'smallmobileafter':
                    return '@media(max-width:361px){ ' + selectors[$selector] + '{' + $val + ' }}';
                    break;
            }
        }

        // jQuery(document).on('DOMSubtreeModified', 'input[data-setting]', function (e) {
        //     console.log(jQuery(this));
        // });

        // // elementor.settings.page.model.on('change',
        // elementor.channels.editor.on('status:change', function (hasChanges) {
        //     // var Input = jQuery('input.kata-plus-res-inputs[data-setting]').first();
        //     // Input.val(Input.val()).trigger('st_input');
        // });
        // elementor.saver.on('after:save', function () {
        //     $.ajax({
        //         type: 'post',
        //         url: ajaxurl + '?action=kata_plus_styler_save_elementor_form',
        //         data: {
        //             postID: getUrlParameter('post')
        //         },
        //         dataType: "json",
        //         success: function () {
        //             // console.log('');
        //         }
        //     });
        // });

        jQuery(document).on('ready', function () {
            return;
            jQuery(document).on('click', '.styler-dialog-btn', function () {
                InInput = true;
                setTimeout(function () {
                    InInput = false;
                }, 400);

                var currentCID = jQuery(this).find('input[data-setting="citem"]').val();
                if (currentCID != jQuery(this).data('cid')) {
                    currentCID = jQuery(this).data('cid');
                    jQuery(this).find('input[data-setting="citem"]').val(currentCID).trigger('styler_input');
                }

                // var body = elementor.$previewContents.find('body').get(0);
                // jQuery(body).keydown(function (e) {
                //     if (e.which === 90 && e.ctrlKey) {
                //         console.log('control + z');
                //     }
                // });
                jQuery(this).find('input[data-setting="cid"]').val(elementor.$previewContents.find('.elementor-element-editable').data('model-cid'));
            });

            jQuery(document).on('styler_input', 'input.kata-plus-res-inputs[data-setting]', function (e) {
                return;
                if (jQuery(this).parents('.elementor-repeater-fields').length) {
                    return;
                }
                e.preventDefault();
                var cid = jQuery('#elementor-preview-iframe').contents().find('.elementor-element-editable').data('model-cid');
                var self = jQuery(this);

                StylesToSave['css'][cid] = '';

                // lastStyler = jQuery(this).parent();
                var wrapperID = jQuery('#elementor-preview-iframe').contents().find('.elementor-element-editable').data('id');

                var wrapper = '#elementor .elementor-element.elementor-element-' + wrapperID;

                var currentCID = jQuery(this).siblings('input[data-setting="citem"]').val();
                if (currentCID != jQuery(this).parent().data('cid')) {
                    currentCID = jQuery(this).parent().data('cid');
                    jQuery(this).siblings('input[data-setting="citem"]').val(currentCID);
                }
                // var currentCID = jQuery(this).parent('input[data-setting="citem"]').data('cid');
                var currentItemClasses = jQuery('#elementor-preview-iframe').contents().find('[data-item-id="' + currentCID + '"]').first().attr('class');
                var currentID = false;
                if (currentItemClasses) {
                    var classes = currentItemClasses.split(' ');
                    for (var i = 0; i < classes.length; i++) {
                        if (classes[i].indexOf('elementor-repeater-item-') === 0) {
                            currentID = classes[i].replace('elementor-repeater-item-', '');
                        }
                    }
                }

                currentItemClasses = jQuery('#elementor-preview-iframe').contents().find('[data-item-id="' + currentCID + '"]').first().attr('class');
                currentID = false;
                if (currentItemClasses) {
                    var classes = currentItemClasses.split(' ');
                    for (var i = 0; i < classes.length; i++) {
                        if (classes[i].indexOf('elementor-repeater-item-') === 0) {
                            currentID = classes[i].replace('elementor-repeater-item-', '');
                        }
                    }
                }
                var current_item = '.elementor-repeater-item-' + currentID;

                var selectors = jQuery(this).parent('.styler-dialog-btn').data('selector'),
                    out = "";

                $.each(selectors, function (k, v) {

                    selectors[k] = v.replace(/\{{WRAPPER}}/g, wrapper);
                    selectors[k] = selectors[k].replace(/\{{CURRENT_ITEM}}/g, current_item);
                })
                var devices = [
                    // 'desktop',
                    'laptop',
                    'tabletlandscape',
                    // 'tablet',
                    // 'mobile',
                    'smallmobile',
                    // 'desktophover',
                    // 'desktopphover',
                    // 'desktopbefore',
                    // 'desktopafter',
                    'laptophover',
                    'laptopphover',
                    'laptopbefore',
                    'laptopafter',
                    'tabletlandscapehover',
                    'tabletlandscapephover',
                    'tabletlandscapebefore',
                    'tabletlandscapeafter',
                    // 'tablethover',
                    // 'tabletphover',
                    // 'tabletbefore',
                    // 'tabletafter',
                    // 'mobilehover',
                    // 'mobilephover',
                    // 'mobilebefore',
                    // 'mobileafter'
                ];
                $.each(devices, function (key, device) {
                    var $i = self.siblings('input[data-setting="' + device + '"]');
                    if ($i.length != 0 && $i.val().trim()) {
                        out += KataCreateCss(selectors, $i.data('setting'), $i.val());
                    }
                });

                out = out + KataCreateCss(selectors, jQuery(this).data('setting'), jQuery(this).val());
                elementor.$previewContents.find('#CUSTOM_STYLE_' + currentCID).remove();
                elementor.$previewContents.find('head').append('<style id="CUSTOM_STYLE_' + currentCID + '"></style>');
                elementor.$previewContents.find('#CUSTOM_STYLE_' + currentCID).html(out);
                return;
            });

            jQuery(document).on('styler_repeater_input', 'input.kata-plus-res-inputs[data-setting]', function (e) {
                return;
                e.preventDefault();
                var cid = jQuery('#elementor-preview-iframe').contents().find('.elementor-element-editable').data('model-cid');
                var self = jQuery(this);

                StylesToSave['css'][cid] = '';

                // lastStyler = jQuery(this).parent();
                var currentID = false;
                var currentCID = jQuery(this).siblings('input[data-setting="citem"]').val();
                var wrapperID = jQuery('#elementor-preview-iframe').contents().find('.elementor-element-editable').data('id');
                var currentItemClasses = jQuery('#elementor-preview-iframe').contents().find('[data-item-id="' + currentCID + '"]').first().attr('class');
                var wrapper = '.elementor-element.elementor-element-' + wrapperID;
                // console.log(jQuery('#elementor-preview-iframe').contents().find('[data-item-id="' + currentCID + '"]').first().attr('class'));

                if (currentCID != jQuery(this).parent().data('cid')) {
                    currentCID = jQuery(this).parent().data('cid');
                    currentItemClasses = jQuery('#elementor-preview-iframe').contents().find('[data-item-id="' + currentCID + '"]').first().attr('class');
                    jQuery(this).siblings('input[data-setting="citem"]').val(currentCID);
                }
                var self = jQuery(this);
                if (typeof (currentItemClasses) == 'undefined') {
                    setTimeout(function () {
                        // currentItemClasses = elementor.$previewContents.find('[data-item-id="' + currentCID + '"]').first().attr('class');
                        self.trigger('styler_repeater_input');
                    }, 1000);
                    return;
                }

                if (currentItemClasses) {
                    var classes = currentItemClasses.split(' ');
                    for (var i = 0; i < classes.length; i++) {
                        if (classes[i].indexOf('elementor-repeater-item-') === 0) {
                            currentID = classes[i].replace('elementor-repeater-item-', '');
                        }
                    }
                }

                var current_item = '.elementor-repeater-item-' + currentID;
                var selectors = jQuery(this).parent('.styler-dialog-btn').data('selector'),
                    out = "";

                $.each(selectors, function (k, v) {
                    selectors[k] = v.replace(/\{{WRAPPER}}/g, wrapper);
                    selectors[k] = selectors[k].replace(/\{{CURRENT_ITEM}}/g, current_item);
                })
                var devices = [
                    'laptop',
                    'tabletlandscape',
                    'smallmobile',
                    'laptophover',
                    'laptopphover',
                    'laptopbefore',
                    'laptopafter',
                    'tabletlandscapehover',
                    'tabletlandscapephover',
                    'tabletlandscapebefore',
                    'tabletlandscapeafter',
                ];
                $.each(devices, function (key, device) {
                    var $i = self.siblings('input[data-setting="' + device + '"]');
                    if ($i.length != 0 && $i.val().trim()) {
                        out += KataCreateCss(selectors, $i.data('setting'), $i.val());
                    }
                });

                out = out + KataCreateCss(selectors, jQuery(this).data('setting'), jQuery(this).val());
                elementor.$previewContents.find('#CUSTOM_STYLE_' + currentCID).remove();
                elementor.$previewContents.find('head').append('<style id="CUSTOM_STYLE_' + currentCID + '"></style>');
                elementor.$previewContents.find('#CUSTOM_STYLE_' + currentCID).html(out);
            });
        });
    });
})(jQuery); // End jquery

function kata_styler_checkup(cid) {
    return;
    setTimeout(function () {
        if (jQuery('#elementor-control-citem-' + cid).val().trim() && jQuery('#elementor-control-citem-' + cid).parents('.elementor-repeater-fields').length) {
            var $citem = jQuery('body').find('#elementor-control-citem-' + cid);
            if ($citem.val() != $citem.parent().data('cid')) {

                // $citem.val($citem.parent().data('cid')).trigger('input');
                setTimeout(function () {
                    currentItemClasses = jQuery('#elementor-preview-iframe').contents().find('[data-item-id="' + cid + '"]').first().attr('class');
                    var currentID = false;
                    if (currentItemClasses) {
                        var classes = currentItemClasses.split(' ');
                        for (var i = 0; i < classes.length; i++) {
                            if (classes[i].indexOf('elementor-repeater-item-') === 0) {
                                currentID = classes[i].replace('elementor-repeater-item-', '');
                            }
                        }
                    }

                    if (currentID) {
                        $citem.siblings('data[data-setting="rp"]').val(currentID).trigger('input');
                    }
                    jQuery('#elementor-control-laptop-' + cid).trigger('styler_repeater_input');
                }, 3000);
            } else if (!$citem.siblings('input[data-setting="rp"]').val().trim()) {
                elementor & elementor.saver.saveEditor({
                    status: 'autosave',
                    onSuccess: function onSuccess() {
                        jQuery('#elementor-control-laptop-' + cid).trigger('styler_repeater_input');
                    }
                });
                // jQuery('#elementor-control-laptop-' + cid).trigger('styler_repeater_input');
            }
        } else {
            var $citem = jQuery('body').find('#elementor-control-citem-' + cid);
            if ($citem.val() != $citem.parent().data('cid')) {
                $citem.val($citem.parent().data('cid'));
                jQuery('#elementor-control-laptop-' + cid).trigger('styler_input');
            }
        }
    }, 100);
}