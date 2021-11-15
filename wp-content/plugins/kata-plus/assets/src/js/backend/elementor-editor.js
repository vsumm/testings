/**
 * Theme Scripts.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus Lite
 * @since	1.0.0
 */
"use strict";

var Kata_Plus_Lite_Scripts = (function ($) {
    /**
     * Global variables.
     *
     * @since	1.0.0
     */
    var $window = $(window);
    var content = "";
    var layout = false;
    var runOnceTime = false;

    return {
        /**
         * Init.
         *
         * @author ClimaxThemes
         * @since	1.0.0
         */
        init: function () {
            this.PageTitle();
            this.DarkORLight();
            this.applyDataDeviceMode();
            this.addOtherResponsiveSeizes();
            this.ElementorPerfectScrollBar();
            this.ProWidgets();
            this.ClearInstagramCache();
            this.pageOptions();
        },

        /**
         * Editor Page Title Display
         *
         * @author ClimaxThemes
         * @since 1.0.0
         */
        PageTitle: function () {
            var $elementor_panel_footer = $("#tmpl-elementor-panel-footer-content"),
                title = elementor.settings.page.model.attributes.post_title;
            if (title.indexOf("Kata ") != "-1") {
                title = title.replace("Kata ", "");
            }
            var page_title = '<div class="kata-page-name"> Editing: <span>' + title + "</span> </div>";
            $elementor_panel_footer.text($elementor_panel_footer.text() + page_title);
        },

        /**
         * Dark and light mode detector
         *
         * @author ClimaxThemes
         * @since 1.0.0
         */
        DarkORLight: function () {
            $(document).on(
                "change",
                '.elementor-control-ui_theme select[data-setting="ui_theme"]',
                function () {
                    if ($(this).find("option:selected").attr("value") == "dark") {
                        if ($("#kata-elementor-admin-light-css").length > 0) {
                            console.log($("#kata-elementor-admin-light-css"));
                            var url = $("#kata-elementor-admin-light-css").attr("href");
                            url = url.replace("elementor-editor.css", "elementor-editor-dark.css");
                            $("#kata-elementor-admin-light-css").after(
                                '<link rel="stylesheet" id="kata-elementor-admin-dark-css" href="' +
                                    url +
                                    '" media="all">'
                            );
                            setTimeout(function () {
                                $("#kata-elementor-admin-light-css").remove();
                            }, 100);
                        }
                    } else if ($(this).find("option:selected").attr("value") == "light") {
                        if ($("#kata-elementor-admin-dark-css").length > 0) {
                            console.log($("#kata-elementor-admin-dark-css"));
                            var url = $("#kata-elementor-admin-dark-css").attr("href");
                            url = url.replace("elementor-editor-dark.css", "elementor-editor.css");
                            $("#kata-elementor-admin-dark-css").after(
                                '<link rel="stylesheet" id="kata-elementor-admin-light-css" href="' +
                                    url +
                                    '" media="all">'
                            );
                            setTimeout(function () {
                                $("#kata-elementor-admin-dark-css").remove();
                            }, 100);
                        }
                    } else {
                        if (
                            $(this).find("option:selected").attr("value") == "auto" &&
                            window.matchMedia("(prefers-color-scheme: dark)").matches
                        ) {
                            if ($("#kata-elementor-admin-light-css").length > 0) {
                                var url = $("#kata-elementor-admin-light-css").attr("href");
                                url = url.replace("elementor-editor.css", "elementor-editor-dark.css");
                                $("#kata-elementor-admin-light-css").after(
                                    '<link rel="stylesheet" id="kata-elementor-admin-dark-css" href="' +
                                        url +
                                        '" media="all">'
                                );
                                setTimeout(function () {
                                    $("#kata-elementor-admin-light-css").remove();
                                }, 100);
                            }
                        } else {
                            if ($("#kata-elementor-admin-dark-css").length > 0) {
                                console.log($("#kata-elementor-admin-dark-css"));
                                var url = $("#kata-elementor-admin-dark-css").attr("href");
                                url = url.replace("elementor-editor-dark.css", "elementor-editor.css");
                                $("#kata-elementor-admin-dark-css").after(
                                    '<link rel="stylesheet" id="kata-elementor-admin-light-css" href="' +
                                        url +
                                        '" media="all">'
                                );
                                setTimeout(function () {
                                    $("#kata-elementor-admin-dark-css").remove();
                                }, 100);
                            }
                        }
                    }
                }
            );
        },

        applyDataDeviceMode: function () {
            $window.on("load", function () {
                jQuery(document).on("click", ".e-responsive-bar-switcher__option", function () {
                    var $this = jQuery(this),
                        $input = $this.children('[type="radio"]');

                    $this.attr("aria-selected", "true").siblings().attr("aria-selected", "false");
                    setTimeout(function () {
                        jQuery("#elementor-preview-iframe")
                            .contents()
                            .find("body")
                            .attr("data-elementor-device-mode", $input.attr("value"));
                    }, 300);
                });
            });
        },

        addOtherResponsiveSeizes: function () {
            $window.on("load", function () {
                elementorFrontend.config.responsive.breakpoints.smallmobile = {
                    label: "Small Mobile",
                    value: 320,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.breakpoints.mobile = {
                    label: "Mobile",
                    value: 480,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.breakpoints.tablet = {
                    label: "Tablet",
                    value: 768,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.breakpoints.tabletlandscape = {
                    label: "Tablet Landscape",
                    value: 1024,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.breakpoints.laptop = {
                    label: "Laptop",
                    value: 1366,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.activeBreakpoints.smallmobile = {
                    label: "Small Mobile",
                    value: 320,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.activeBreakpoints.mobile = {
                    label: "Mobile",
                    value: 480,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.activeBreakpoints.tablet = {
                    label: "Tablet",
                    value: 768,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.activeBreakpoints.tabletlandscape = {
                    label: "Tablet Landscape",
                    value: 1024,
                    direction: "max",
                    is_enabled: true,
                };
                elementorFrontend.config.responsive.activeBreakpoints.laptop = {
                    label: "Laptop",
                    value: 1366,
                    direction: "max",
                    is_enabled: true,
                };

                var smallmobile =
                        '<label id="e-responsive-bar-switcher__option-smallmobile" class="e-responsive-bar-switcher__option" for="e-responsive-bar-switch-smallmobile" data-tooltip="Small Mobile <br> Settings added for the base device will apply to all breakpoints unless edited" original-title=""> <input type="radio" name="breakpoint" id="e-responsive-bar-switch-smallmobile" value="smallmobile"> <i class="eicon-device-smallmobile" aria-hidden="true"></i> <span class="screen-reader-text">Small Mobile &lt;br&gt; Settings added for the base device will apply to all breakpoints unless edited</span> </label>',
                    tabletlandscape =
                        '<label id="e-responsive-bar-switcher__option-tabletlandscape" class="e-responsive-bar-switcher__option" for="e-responsive-bar-switch-tabletlandscape" data-tooltip="Tablet Landscape <br> Settings added for the base device will apply to all breakpoints unless edited" original-title=""> <input type="radio" name="breakpoint" id="e-responsive-bar-switch-tabletlandscape" value="tabletlandscape"> <i class="eicon-device-tabletlandscape" aria-hidden="true"></i> <span class="screen-reader-text">Tablet Landscape &lt;br&gt; Settings added for the base device will apply to all breakpoints unless edited</span> </label>',
                    laptop =
                        '<label id="e-responsive-bar-switcher__option-laptop" class="e-responsive-bar-switcher__option" for="e-responsive-bar-switch-laptop" data-tooltip="Laptop <br> Settings added for the base device will apply to all breakpoints unless edited" original-title=""> <input type="radio" name="breakpoint" id="e-responsive-bar-switch-laptop" value="laptop"> <i class="eicon-device-laptop" aria-hidden="true"></i> <span class="screen-reader-text">Laptop &lt;br&gt; Settings added for the base device will apply to all breakpoints unless edited</span> </label>';
                $('[for="e-responsive-bar-switch-desktop"]').after(laptop);
                $('[for="e-responsive-bar-switch-tablet"]').before(tabletlandscape);
                $('[for="e-responsive-bar-switch-mobile"]').after(smallmobile);

                jQuery('[for="e-responsive-bar-switch-smallmobile"]').on("click", function () {
                    jQuery(".e-responsive-bar__input-width").val("320");
                    jQuery(".e-responsive-bar__input-height").val("568");
                    setTimeout(function () {
                        jQuery("#elementor-preview-responsive-wrapper").attr(
                            "style",
                            "--e-editor-preview-width:320px;--e-editor-preview-height:568px;width: var(--e-editor-preview-width); height: var(--e-editor-preview-height);"
                        );
                        jQuery("#elementor-preview-responsive-wrapper").resizable({
                            minWidth: 300,
                            width: 320,
                            maxWidth: 320,
                            height: 568,
                            maxHeight: 768,
                            minHeight: 568,
                        });
                    }, 100);
                });
                jQuery('[for="e-responsive-bar-switch-mobile"]').on("click", function () {
                    jQuery(".e-responsive-bar__input-width").val("480");
                    jQuery(".e-responsive-bar__input-height").val("667");
                    setTimeout(function () {
                        jQuery("#elementor-preview-responsive-wrapper").attr(
                            "style",
                            "--e-editor-preview-width:480px;--e-editor-preview-height:667px;width: var(--e-editor-preview-width); height: var(--e-editor-preview-height);"
                        );
                        jQuery("#elementor-preview-responsive-wrapper").resizable({
                            minWidth: 321,
                            width: 480,
                            maxWidth: 480,
                            height: 667,
                            maxHeight: 768,
                            minHeight: 667,
                        });
                    }, 100);
                });
                jQuery('[for="e-responsive-bar-switch-tablet"]').on("click", function () {
                    jQuery(".e-responsive-bar__input-width").val("768");
                    jQuery(".e-responsive-bar__input-height").val("1024");
                    setTimeout(function () {
                        jQuery("#elementor-preview-responsive-wrapper").attr(
                            "style",
                            "--e-editor-preview-width:768px;--e-editor-preview-height:1024px;width: var(--e-editor-preview-width); height: var(--e-editor-preview-height);"
                        );
                        jQuery("#elementor-preview-responsive-wrapper").resizable({
                            minWidth: 481,
                            width: 768,
                            maxWidth: 768,
                            height: 1024,
                            maxHeight: 1024,
                            minHeight: 768,
                        });
                    }, 100);
                });
                jQuery('[for="e-responsive-bar-switch-tabletlandscape"]').on("click", function () {
                    setTimeout(function () {
                        jQuery(".e-responsive-bar__input-width").val("1024");
                        jQuery(".e-responsive-bar__input-height").val("768");
                        jQuery("#elementor-preview-responsive-wrapper").attr(
                            "style",
                            "--e-editor-preview-width:1024px;--e-editor-preview-height:768px;width: var(--e-editor-preview-width); height: var(--e-editor-preview-height);"
                        );
                        jQuery("#elementor-preview-responsive-wrapper").resizable({
                            minWidth: 769,
                            width: 1024,
                            maxWidth: 1024,
                            height: 768,
                            maxHeight: 768,
                            minHeight: 640,
                        });
                    }, 100);
                });
                jQuery('[for="e-responsive-bar-switch-laptop"]').on("click", function () {
                    setTimeout(function () {
                        jQuery(".e-responsive-bar__input-width").val("1366");
                        jQuery(".e-responsive-bar__input-height").val("1024");
                        jQuery("#elementor-preview-responsive-wrapper").attr(
                            "style",
                            "--e-editor-preview-width:1366px;--e-editor-preview-height:1024px;width: var(--e-editor-preview-width); height: var(--e-editor-preview-height);"
                        );
                        jQuery("#elementor-preview-responsive-wrapper").resizable({
                            minWidth: 1025,
                            width: 1366,
                            maxWidth: 1366,
                            height: 1024,
                            maxHeight: 1024,
                            minHeight: 1024,
                        });
                    }, 100);
                });
                jQuery('[for="e-responsive-bar-switch-desktop"]').on("click", function () {
                    setTimeout(function () {
                        jQuery("#elementor-preview-responsive-wrapper").attr(
                            "style",
                            "--e-editor-preview-width:100%;--e-editor-preview-height:100%;width: var(--e-editor-preview-width); height: var(--e-editor-preview-height);"
                        );
                    }, 100);
                });
            });
        },

        ElementorPerfectScrollBar: function () {
            $window.on("load", function () {
                var ps = new PerfectScrollbar("#elementor-panel-content-wrapper");
                ps.destroy();
                $("#elementor-panel-content-wrapper").niceScroll({
                    cursorcolor: "#ccc", // change cursor color in hex
                    cursoropacitymin: 0, // change opacity when cursor is inactive (scrollabar "hidden" state), range from 1 to 0
                    cursoropacitymax: 1, // change opacity when cursor is active (scrollabar "visible" state), range from 1 to 0
                    cursorwidth: "6px", // cursor width in pixel (you can also write "5px")
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
                        bottom: 0,
                    }, // set padding for rail bar
                    disableoutline: true, // for chrome browser, disable outline (orange highlight) when selecting a div with nicescroll
                    horizrailenabled: false, // nicescroll can manage horizontal scroll
                    railalign: "right", // alignment of vertical rail
                    railvalign: "bottom", // alignment of horizontal rail
                    enablemousewheel: true, // nicescroll can manage mouse wheel events
                    enablekeyboard: true, // nicescroll can manage keyboard events
                    smoothscroll: true, // scroll with ease movement
                    cursordragspeed: 0.3, // speed of selection when dragged with cursor
                });
            });
        },

        ProWidgets: function () {
            if (KataPlusPro) {
                return;
            }
            elementor.widgetsCache = JSON.stringify(elementor.widgetsCache);
            var ProWidgets = JSON.stringify(KataProWidgets);
            ProWidgets = ProWidgets.replace('{"kata-plus-', '{"kata-plus-');
            ProWidgets = ProWidgets.replace("}}", "}");
            elementor.widgetsCache = elementor.widgetsCache.replace(
                ',"kata-plus-text"',
                "," + ProWidgets + ',"kata-plus-text"'
            );
            elementor.widgetsCache = elementor.widgetsCache.replaceAll('},{"kata-plus', '},"kata-plus');
            elementor.widgetsCache = JSON.parse(elementor.widgetsCache);

            $(document).on("click", '.elementor-element:not([draggable="true"])', function (e) {
                var $this = $(this),
                    $msg = $("#elementor-element--promotion__dialog");
                if (e.currentTarget.className == "elementor-element") {
                    console.log(e.currentTarget.offsetParent.id);
                    if (
                        e.currentTarget.offsetParent.id == "elementor-panel-category-kata_plus_elementor" ||
                        e.currentTarget.offsetParent.id ==
                            "elementor-panel-category-kata_plus_elementor_blog_and_post" ||
                        e.currentTarget.offsetParent.id ==
                            "elementor-panel-category-kata_plus_elementor_header"
                    ) {
                        $msg.find(".dialog-buttons-wrapper").html(
                            '<a href="https://my.climaxthemes.com/buy/" target="_blank" class="kata-plus-pro-button dialog-button dialog-action dialog-buttons-action elementor-button elementor-button-success">Kata Pro</a>'
                        );
                    } else {
                        $msg.find(".dialog-buttons-wrapper").html(
                            '<button class="dialog-button dialog-action dialog-buttons-action elementor-button elementor-button-success">See it in Action</button>'
                        );
                    }
                }
            });
        },

        /**
         * Fetch Instagram Images.
         *
         * @author ClimaxThemes
         * @since	1.0.0
         */
        ClearInstagramCache: function () {
            elementor.channels.editor.on("clearinstagramcache", function (view) {
                var changed = view.elementSettingsModel,
                    spiner =
                        '<span class="elementor-state-icon" style="display: inline-block;"> <i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i> </span>';
                $('[data-event="clearinstagramcache"]').prepend(spiner);
                if (changed.attributes.update_images == "updated") {
                    $('input[data-setting="update_images"]').val("update").trigger("input");
                }
                if (changed.attributes.update_images == "update") {
                    $e.internal("document/save/set-is-modified", {
                        status: true,
                        force: true,
                    });
                    $e.internal("document/save/save", {
                        force: true,
                        onSuccess: function () {
                            $('input[data-setting="update_images"]').val("updated").trigger("input");
                            $e.run("document/save/publish", {
                                force: true,
                            });
                            elementor.reloadPreview();
                        },
                    });
                }
            });
        },

        /**
         * Page Options.
         *
         * @author ClimaxThemes
         * @since	1.0.0
         */
        pageOptions: function () {
            elementor.channels.editor.on("applychanges", function (view) {
                var changed = view.container.settings,
                    spiner =
                        '<span class="elementor-state-icon" style="display: inline-block;"> <i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i> </span>';
                $('[data-event="applychanges"]').prepend(spiner);
                $e.internal("document/save/set-is-modified", {
                    status: true,
                    force: true,
                });
                $e.internal("document/save/save", {
                    force: true,
                    onSuccess: function () {
                        $.ajax({
                            action: "save_builder",
                            complete: function () {
                                $e.run("document/save/publish");
                                elementor.reloadPreview();
                                elementor.once("preview:loaded", function () {
                                    console.log(1);
                                    $e.route("panel/page-settings/settings");
                                    console.log(2);
                                });
                            },
                        });
                    },
                });
            });
        },
    };
})(jQuery);

// Frontend
jQuery(document).ready(function () {
    Kata_Plus_Lite_Scripts.init();
});
