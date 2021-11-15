(function () {
    function r(e, n, t) {
        function o(i, f) {
            if (!n[i]) {
                if (!e[i]) {
                    var c = "function" == typeof require && require;
                    if (!f && c) return c(i, !0);
                    if (u) return u(i, !0);
                    var a = new Error("Cannot find module '" + i + "'");
                    throw ((a.code = "MODULE_NOT_FOUND"), a);
                }
                var p = (n[i] = {
                    exports: {},
                });
                e[i][0].call(
                    p.exports,
                    function (r) {
                        var n = e[i][1][r];
                        return o(n || r);
                    },
                    p,
                    p.exports,
                    r,
                    e,
                    n,
                    t
                );
            }
            return n[i].exports;
        }
        for (var u = "function" == typeof require && require, i = 0; i < t.length; i++) o(t[i]);
        return o;
    }
    return r;
})()(
    {
        1: [
            function (require, module, exports) {
                "use strict";

                (function ($, window) {
                    var kata_plus_elementor = window.kata_plus_elementor || {};

                    var Editor = function Editor() {
                        var self = this;

                        function initControls() {
                            self.controls = {
                                presets: require("./controls/presets").default,
                            };

                            for (var control in self.controls) {
                                elementor.addControlView("kata_plus_" + control, self.controls[control]);
                            }
                        }

                        function initTemplateLibrary() {
                            self.templates = require("./template-library/manager");

                            self.templates.init();

                            var event = "preview:loaded";
                            var compareVersions = window.elementor.helpers.compareVersions;

                            if (compareVersions(window.elementor.config.version, "2.8.5", ">")) {
                                event = "document:loaded";
                            }

                            elementor.on(event, function () {
                                if (
                                    elementor.$previewContents.find(
                                        ".kata-plus-elementor-add-template-button"
                                    ).length > 0
                                ) {
                                    return;
                                }

                                var button =
                                    '<div\n          class="elementor-add-section-area-button kata-plus-elementor-add-template-button kata-elementor-add-template-button"\n          title="Add KataPlus Template">\n    <i></i>      \n        </div>';
                                elementor.$previewContents
                                    .find(".elementor-add-new-section .elementor-add-template-button")
                                    .after(button)
                                    .find("~ .kata-plus-elementor-add-template-button")
                                    .on("click", function () {
                                        $e.run("kata-plus-elementor-library/open");
                                        setTimeout(() => {
                                            $(
                                                "#kt-library-modal #elementor-template-library-header-menu"
                                            ).niceScroll({
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
                                                    bottom: 1,
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
                                        }, 200);
                                    });
                            });
                        }

                        function bindEvents() {
                            $e.hooks.data.on("element:after:reset:style", onElementAfterResetStyle);
                            $e.hooks.data.on("element:before:reset:style", onElementBeforeResetStyle);

                            $(".kata-plus-presets-sync span").off("click", "**");

                            $(document).on("click", ".kata-plus-presets-sync span", function () {
                                var _this = this;

                                if ($(this).find("i").hasClass("eicon-animation-spin")) {
                                    return;
                                }

                                $(this).find("i").addClass("eicon-animation-spin");

                                wp.ajax
                                    .post("kata_plus_sync_libraries", {
                                        _ajax_nonce: $(this).data("nonce"),
                                        library: "presets",
                                    })
                                    .done(function () {
                                        $(_this).find("i").removeClass("eicon-animation-spin");
                                        $e.hooks.data.trigger(
                                            "KataPlus:presets:sync",
                                            $(_this).data("element")
                                        );
                                    })
                                    .fail(function () {
                                        return $(_this).find("i").removeClass("eicon-animation-spin");
                                    });
                            });
                        }

                        function onElementAfterResetStyle(model) {
                            if (model.get("elType") !== "widget") {
                                return;
                            }

                            resetElementPresets(model);

                            $e.hooks.data.trigger("KataPlus:element:after:reset:style", model);
                        }

                        function onElementBeforeResetStyle(model) {
                            $e.hooks.data.trigger("KataPlus:element:before:reset:style", model);
                        }

                        function resetElementPresets(model) {
                            var controls = model.get("settings").controls;

                            if (!controls.kata_plus_presets) {
                                return;
                            }

                            model.setSetting("kata_plus_presets", null);
                        }

                        function onElementorInit() {
                            initControls();
                            bindEvents();
                            initTemplateLibrary();
                        }

                        $(window).on("elementor:init", onElementorInit);
                    };

                    kata_plus_elementor.editor = new Editor();
                    window.kata_plus_elementor = kata_plus_elementor;
                })(jQuery, window);
            },
            {
                "./template-library/manager": 5,
                "./controls/presets": 18,
            },
        ],
        2: [
            function (require, module, exports) {
                "use strict";

                var InsertTemplateHandler;

                InsertTemplateHandler = Marionette.Behavior.extend(
                    {
                        ui: {
                            insertButton: ".elementor-template-library-template-insert",
                        },

                        events: {
                            "click @ui.insertButton": "onInsertButtonClick",
                        },

                        onInsertButtonClick: function onInsertButtonClick() {
                            var autoImportSettings =
                                elementor.config.document.remoteLibrary.autoImportSettings;

                            // Check Settings
                            if (!autoImportSettings && this.view.model.get("hasPageSettings")) {
                                InsertTemplateHandler.showImportDialog(this.view.model);
                                return;
                            }

                            // Import Template
                            kata_plus_elementor.editor.templates.importTemplate(this.view.model, {
                                withPageSettings: autoImportSettings,
                            });
                        },
                    },
                    {
                        dialog: null,
                        showImportDialog: function showImportDialog(model) {
                            var dialog = InsertTemplateHandler.getDialog();

                            dialog.onConfirm = function () {
                                kata_plus_elementor.editor.templates.importTemplate(model, {
                                    withPageSettings: true,
                                });
                            };

                            dialog.onCancel = function () {
                                kata_plus_elementor.editor.templates.importTemplate(model);
                            };

                            dialog.show();
                        },

                        initDialog: function initDialog() {
                            InsertTemplateHandler.dialog = elementorCommon.dialogsManager.createWidget(
                                "confirm",
                                {
                                    id: "elementor-insert-template-settings-dialog",
                                    headerMessage: elementor.translate("import_template_dialog_header"),
                                    message:
                                        elementor.translate("import_template_dialog_message") +
                                        "<br>" +
                                        elementor.translate("import_template_dialog_message_attention"),
                                    strings: {
                                        confirm: elementor.translate("yes"),
                                        cancel: elementor.translate("no"),
                                    },
                                }
                            );
                        },

                        getDialog: function getDialog() {
                            if (!InsertTemplateHandler.dialog) {
                                InsertTemplateHandler.initDialog();
                            }

                            return InsertTemplateHandler.dialog;
                        },
                    }
                );

                module.exports = InsertTemplateHandler;
            },
            {},
        ],
        3: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryTemplateModel = require("../models/template"),
                    TemplateLibraryCollection;

                TemplateLibraryCollection = Backbone.Collection.extend({
                    model: TemplateLibraryTemplateModel,
                });

                module.exports = TemplateLibraryCollection;
            },
            {
                "../models/template": 6,
            },
        ],
        4: [
            function (require, module, exports) {
                "use strict";

                Object.defineProperty(exports, "__esModule", {
                    value: true,
                });

                var _createClass = (function () {
                    function defineProperties(target, props) {
                        for (var i = 0; i < props.length; i++) {
                            var descriptor = props[i];
                            descriptor.enumerable = descriptor.enumerable || false;
                            descriptor.configurable = true;
                            if ("value" in descriptor) descriptor.writable = true;
                            Object.defineProperty(target, descriptor.key, descriptor);
                        }
                    }
                    return function (Constructor, protoProps, staticProps) {
                        if (protoProps) defineProperties(Constructor.prototype, protoProps);
                        if (staticProps) defineProperties(Constructor, staticProps);
                        return Constructor;
                    };
                })();

                var _get = function get(object, property, receiver) {
                    if (object === null) object = Function.prototype;
                    var desc = Object.getOwnPropertyDescriptor(object, property);
                    if (desc === undefined) {
                        var parent = Object.getPrototypeOf(object);
                        if (parent === null) {
                            return undefined;
                        } else {
                            return get(parent, property, receiver);
                        }
                    } else if ("value" in desc) {
                        return desc.value;
                    } else {
                        var getter = desc.get;
                        if (getter === undefined) {
                            return undefined;
                        }
                        return getter.call(receiver);
                    }
                };

                function _classCallCheck(instance, Constructor) {
                    if (!(instance instanceof Constructor)) {
                        throw new TypeError("Cannot call a class as a function");
                    }
                }

                function _possibleConstructorReturn(self, call) {
                    if (self === void 0) {
                        throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    }
                    return call && (typeof call === "object" || typeof call === "function") ? call : self;
                }

                function _inherits(subClass, superClass) {
                    if (typeof superClass !== "function" && superClass !== null) {
                        throw new TypeError(
                            "Super expression must either be null or a function, not " + typeof superClass
                        );
                    }
                    subClass.prototype = Object.create(superClass && superClass.prototype, {
                        constructor: {
                            value: subClass,
                            enumerable: false,
                            writable: true,
                            configurable: true,
                        },
                    });
                    if (superClass)
                        Object.setPrototypeOf
                            ? Object.setPrototypeOf(subClass, superClass)
                            : (subClass.__proto__ = superClass);
                }

                var TemplateLibraryLayoutView = require("./views/library-layout");

                var _class = (function (_elementorModules$com) {
                    _inherits(_class, _elementorModules$com);

                    function _class() {
                        _classCallCheck(this, _class);

                        return _possibleConstructorReturn(
                            this,
                            (_class.__proto__ || Object.getPrototypeOf(_class)).apply(this, arguments)
                        );
                    }

                    _createClass(_class, [
                        {
                            key: "__construct",
                            value: function __construct(args) {
                                this.docLibraryConfig = elementor.config.document.remoteLibrary;

                                _get(
                                    _class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype),
                                    "__construct",
                                    this
                                ).call(this, args);
                                if (typeof kata_plus_this_page_name != "undefined") {
                                    this.setDefaultRoute("templates/" + kata_plus_this_page_name);
                                } else {
                                    this.setDefaultRoute("templates/content");
                                }
                            },
                        },
                        {
                            key: "getNamespace",
                            value: function getNamespace() {
                                return "kata-plus-elementor-library";
                            },
                        },
                        {
                            key: "getModalLayout",
                            value: function getModalLayout() {
                                return TemplateLibraryLayoutView;
                            },
                        },
                        {
                            key: "defaultTabs",
                            value: function defaultTabs() {
                                return {
                                    "templates/header": {
                                        title: "Header",
                                        filter: {
                                            source: "header",
                                        },
                                    },
                                    "templates/footer": {
                                        title: "Footer",
                                        filter: {
                                            source: "footer",
                                        },
                                    },
                                    "templates/content": {
                                        title: "Content",
                                        filter: {
                                            source: "content",
                                        },
                                    },
                                    "templates/blog": {
                                        title: "Blog",
                                        filter: {
                                            source: "blog",
                                        },
                                    },
                                    "templates/single": {
                                        title: "Single",
                                        filter: {
                                            source: "single",
                                        },
                                    },
                                    "templates/hero": {
                                        title: "Hero",
                                        filter: {
                                            source: "hero",
                                        },
                                    },
                                    "templates/pricing": {
                                        title: "Pricing",
                                        filter: {
                                            source: "pricing",
                                        },
                                    },
                                    "templates/gallery": {
                                        title: "Gallery",
                                        filter: {
                                            source: "gallery",
                                        },
                                    },
                                    "templates/portfolio": {
                                        title: "Portfolio",
                                        filter: {
                                            source: "portfolio",
                                        },
                                    },
                                    "templates/icon": {
                                        title: "Icon Box",
                                        filter: {
                                            source: "icon",
                                        },
                                    },
                                    "templates/calltoaction": {
                                        title: "Call To Action",
                                        filter: {
                                            source: "calltoaction",
                                        },
                                    },
                                    "templates/slider": {
                                        title: "Slider",
                                        filter: {
                                            source: "slider",
                                        },
                                    },
                                    "templates/banner": {
                                        title: "Banner",
                                        filter: {
                                            source: "banner",
                                        },
                                    },
                                    "templates/accordion": {
                                        title: "Accordion",
                                        filter: {
                                            source: "accordion",
                                        },
                                    },
                                    "templates/carousel": {
                                        title: "Carousel",
                                        filter: {
                                            source: "carousel",
                                        },
                                    },
                                    "templates/counter": {
                                        title: "Counter",
                                        filter: {
                                            source: "counter",
                                        },
                                    },
                                    "templates/contact": {
                                        title: "Contact",
                                        filter: {
                                            source: "contact",
                                        },
                                    },
                                    "templates/team": {
                                        title: "Team",
                                        filter: {
                                            source: "team",
                                        },
                                    },
                                    /* "templates/megamenu": {
                                        title: "Mega Menu",
                                        filter: {
                                            source: "megamenu",
                                        },
                                    }, */
                                };
                            },
                        },
                        {
                            key: "defaultRoutes",
                            value: function defaultRoutes() {
                                var _this2 = this;

                                return {
                                    import: function _import() {
                                        _this2.manager.layout.showImportView();
                                    },
                                    preview: function preview(args) {
                                        _this2.manager.layout.showPreviewView(args.model);
                                    },
                                };
                            },
                        },
                        {
                            key: "defaultCommands",
                            value: function defaultCommands() {
                                return Object.assign(
                                    _get(
                                        _class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype),
                                        "defaultCommands",
                                        this
                                    ).call(this),
                                    {
                                        open: this.show,
                                    }
                                );
                            },
                        },
                        {
                            key: "getTabsWrapperSelector",
                            value: function getTabsWrapperSelector() {
                                return "#elementor-template-library-header-menu";
                            },
                        },
                        {
                            key: "renderTab",
                            value: function renderTab(tab) {
                                this.manager.setScreen(this.tabs[tab].filter);
                                jQuery(
                                    "#kt-library-modal #elementor-template-library-header-menu"
                                ).niceScroll({
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
                                        bottom: 1,
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
                            },
                        },
                        {
                            key: "activateTab",
                            value: function activateTab(tab) {
                                $e.routes.saveState("kata-plus-elementor-library");

                                _get(
                                    _class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype),
                                    "activateTab",
                                    this
                                ).call(this, tab);
                            },
                        },
                        {
                            key: "open",
                            value: function open() {
                                _get(
                                    _class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype),
                                    "open",
                                    this
                                ).call(this);

                                if (!this.manager.layout) {
                                    this.manager.layout = this.layout;
                                }

                                return true;
                            },
                        },
                        {
                            key: "close",
                            value: function close() {
                                if (
                                    !_get(
                                        _class.prototype.__proto__ || Object.getPrototypeOf(_class.prototype),
                                        "close",
                                        this
                                    ).call(this)
                                ) {
                                    return false;
                                }

                                this.manager.modalConfig = {};

                                return true;
                            },
                        },
                        {
                            key: "show",
                            value: function show(args) {
                                this.manager.modalConfig = args;

                                if (
                                    args.toDefault ||
                                    !$e.routes.restoreState("kata-plus-elementor-library")
                                ) {
                                    $e.route(this.getDefaultRoute());
                                }
                            },
                        },
                    ]);

                    return _class;
                })($e.modules.ComponentModalBase);

                exports.default = _class;
            },
            {
                "./views/library-layout": 11,
            },
        ],
        5: [
            function (require, module, exports) {
                "use strict";

                var _typeof =
                    typeof Symbol === "function" && typeof Symbol.iterator === "symbol"
                        ? function (obj) {
                              return typeof obj;
                          }
                        : function (obj) {
                              return obj &&
                                  typeof Symbol === "function" &&
                                  obj.constructor === Symbol &&
                                  obj !== Symbol.prototype
                                  ? "symbol"
                                  : typeof obj;
                          };

                var _component = require("./component");

                var _component2 = _interopRequireDefault(_component);

                function _interopRequireDefault(obj) {
                    return obj && obj.__esModule
                        ? obj
                        : {
                              default: obj,
                          };
                }

                var TemplateLibraryCollection = require("./collections/templates"),
                    TemplateLibraryManager;

                TemplateLibraryManager = function TemplateLibraryManager() {
                    this.modalConfig = {};

                    var self = this,
                        templateTypes = {};
                    var deleteDialog,
                        errorDialog,
                        templatesCollection,
                        config = {},
                        filterTerms = {};

                    var registerDefaultTemplateTypes = function registerDefaultTemplateTypes() {
                        var data = {
                            saveDialog: {
                                description: elementor.translate("save_your_template_description"),
                            },
                            ajaxParams: {
                                success: function success(successData) {
                                    $e.route("kata-plus-elementor-library/templates/my-templates", {
                                        onBefore: function onBefore() {
                                            if (templatesCollection) {
                                                var itemExist = templatesCollection.findWhere({
                                                    template_id: successData.template_id,
                                                });

                                                if (!itemExist) {
                                                    templatesCollection.add(successData);
                                                }
                                            }
                                        },
                                    });
                                },
                                error: function error(errorData) {
                                    self.showErrorDialog(errorData);
                                },
                            },
                        };

                        _.each(["page", "section", elementor.config.document.type], function (type) {
                            var safeData = jQuery.extend(true, {}, data, {
                                saveDialog: {
                                    title: elementor.translate("save_your_template", [
                                        elementor.translate(type),
                                    ]),
                                },
                            });

                            self.registerTemplateType(type, safeData);
                        });
                    };

                    var registerDefaultFilterTerms = function registerDefaultFilterTerms() {
                        filterTerms = {
                            text: {
                                callback: function callback(value) {
                                    value = value.toLowerCase();

                                    if (this.get("title").toLowerCase().indexOf(value) >= 0) {
                                        return true;
                                    }

                                    return _.any(this.get("tags"), function (tag) {
                                        return tag.toLowerCase().indexOf(value) >= 0;
                                    });
                                },
                            },
                            type: {},
                            subtype: {},
                            favorite: {},
                            plugins: {
                                callback: function callback(value) {
                                    return _.isEqual(value.split(","), this.get("plugins"));
                                },
                            },
                        };
                    };

                    this.init = function () {
                        registerDefaultTemplateTypes();

                        registerDefaultFilterTerms();

                        this.component = $e.components.register(
                            new _component2.default({
                                manager: this,
                            })
                        );

                        elementor.addBackgroundClickListener("libraryToggleMore", {
                            element: ".elementor-template-library-template-more",
                        });
                    };

                    this.getTemplateTypes = function (type) {
                        if (type) {
                            return templateTypes[type];
                        }

                        return templateTypes;
                    };

                    this.registerTemplateType = function (type, data) {
                        templateTypes[type] = data;
                    };

                    this.importTemplate = function (templateModel, options) {
                        var checkInactivePlugins =
                            arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;

                        var self = this;
                        var inactivePlugins = templateModel.get("inactive_plugins") || {};
                        options = options || {};

                        if (inactivePlugins.length && checkInactivePlugins) {
                            /**
                             * @todo Make strings translation ready.
                             */
                            return elementorCommon.dialogsManager
                                .createWidget("confirm", {
                                    headerMessage: "Missing Required Plugin(s)",
                                    message:
                                        "This template requires <b>" +
                                        inactivePlugins +
                                        "</b> plugin(s) to be installed and activated. Clicking on <b>Continue</b> button, will import the template but some elements and settings may be missing.",
                                    strings: {
                                        confirm: "Continue",
                                    },
                                    defaultOption: "confirm",
                                    onConfirm: function onConfirm() {
                                        args.model = templateModel;
                                        $e.run("library/insert-template", {
                                            model: templateModel,
                                            withPageSettings: true,
                                        });
                                    },
                                })
                                .show();
                        }

                        self.layout.showLoadingView();

                        self.requestTemplateContent(
                            templateModel.get("source"),
                            templateModel.get("template_id"),
                            {
                                data: {
                                    with_page_settings: options.withPageSettings,
                                },
                                success: function success(data) {
                                    var importOptions = jQuery.extend({}, self.modalConfig.importOptions);
                                    importOptions.withPageSettings = options.withPageSettings; // Hide for next open.
                                    self.layout.hideLoadingView();

                                    self.layout.hideModal();

                                    $e.run("document/elements/import", {
                                        model: templateModel,
                                        data: data,
                                        options: importOptions,
                                    });
                                },
                                error: function error(data) {
                                    self.showErrorDialog(data);
                                },
                                complete: function complete() {
                                    self.layout.hideLoadingView();
                                },
                            }
                        );
                    };

                    this.requestTemplateContent = function (source, id, ajaxOptions) {
                        var options = {
                            unique_id: id,
                            data: {
                                source: source,
                                edit_mode: true,
                                display: true,
                                template_id: id,
                            },
                        };

                        if (ajaxOptions) {
                            jQuery.extend(true, options, ajaxOptions);
                        }

                        return elementorCommon.ajax.addRequest(
                            "kata_plus_elementor_get_template_data",
                            options
                        );
                    };

                    this.markAsFavorite = function (templateModel, favorite) {
                        var options = {
                            data: {
                                source: templateModel.get("source"),
                                template_id: templateModel.get("template_id"),
                                favorite: favorite,
                            },
                        };

                        return elementorCommon.ajax.addRequest("mark_template_as_favorite", options);
                    };

                    this.getErrorDialog = function () {
                        if (!errorDialog) {
                            errorDialog = elementorCommon.dialogsManager.createWidget("alert", {
                                id: "elementor-template-library-error-dialog",
                                headerMessage: elementor.translate("an_error_occurred"),
                            });
                        }

                        return errorDialog;
                    };

                    this.getTemplatesCollection = function () {
                        return templatesCollection;
                    };

                    this.getConfig = function (item) {
                        if (item) {
                            return config[item] ? config[item] : {};
                        }

                        return config;
                    };

                    this.requestLibraryData = function (options) {
                        if (templatesCollection && !options.forceUpdate) {
                            if (options.onUpdate) {
                                options.onUpdate();
                            }

                            return;
                        }

                        if (options.onBeforeUpdate) {
                            options.onBeforeUpdate();
                        }

                        var ajaxOptions = {
                            data: {},
                            success: function success(data) {
                                templatesCollection = new TemplateLibraryCollection(data.templates);

                                if (data.config) {
                                    config = data.config;
                                }

                                if (options.onUpdate) {
                                    options.onUpdate();
                                }
                            },
                        };

                        if (options.forceSync) {
                            ajaxOptions.data.sync = true;
                        }

                        elementorCommon.ajax.addRequest("kata_plus_elementor_get_library_data", ajaxOptions);
                    };

                    this.getFilter = function (name) {
                        return elementor.channels.templates.request("filter:" + name);
                    };

                    this.setFilter = function (name, value, silent) {
                        elementor.channels.templates.reply("filter:" + name, value);

                        if (!silent) {
                            elementor.channels.templates.trigger("filter:change");
                        }
                    };

                    this.getFilterTerms = function (termName) {
                        if (termName) {
                            return filterTerms[termName];
                        }

                        return filterTerms;
                    };

                    this.setScreen = function (args) {
                        elementor.channels.templates.stopReplying();

                        self.setFilter("source", args.source, true);
                        self.setFilter("type", args.type, true);
                        self.setFilter("subtype", args.subtype, true);

                        self.showTemplates();
                    };

                    this.loadTemplates = function (_onUpdate) {
                        self.requestLibraryData({
                            onBeforeUpdate: self.layout.showLoadingView.bind(self.layout),
                            onUpdate: function onUpdate() {
                                self.layout.hideLoadingView();

                                if (_onUpdate) {
                                    _onUpdate();
                                }
                            },
                        });
                    };

                    this.showTemplates = function () {
                        // The tabs should exist in DOM on loading.
                        self.layout.setHeaderDefaultParts();

                        self.loadTemplates(function () {
                            var templatesToShow = self.filterTemplates();

                            self.layout.showTemplatesView(new TemplateLibraryCollection(templatesToShow));
                        });
                    };

                    this.filterTemplates = function () {
                        var activeSource = self.getFilter("source");
                        return templatesCollection.filter(function (model) {
                            if (activeSource !== model.get("source")) {
                                return false;
                            }

                            var typeInfo = templateTypes[model.get("type")];

                            return !typeInfo || typeInfo.showInLibrary !== false;
                        });
                    };

                    this.showErrorDialog = function (errorMessage) {
                        if (
                            (typeof errorMessage === "undefined" ? "undefined" : _typeof(errorMessage)) ===
                            "object"
                        ) {
                            var message = "";

                            _.each(errorMessage, function (error) {
                                message += "<div>" + error.message + ".</div>";
                            });

                            errorMessage = message;
                        } else if (errorMessage) {
                            errorMessage += ".";
                        } else {
                            errorMessage = "<i>&#60The error message is empty&#62</i>";
                        }

                        self.getErrorDialog()
                            .setMessage(
                                elementor.translate("templates_request_error") +
                                    '<div id="elementor-template-library-error-info">' +
                                    errorMessage +
                                    "</div>"
                            )
                            .show();
                    };
                };

                module.exports = new TemplateLibraryManager();
            },
            {
                "./collections/templates": 3,
                "./component": 4,
            },
        ],
        6: [
            function (require, module, exports) {
                "use strict";

                module.exports = Backbone.Model.extend({
                    defaults: {
                        template_id: 0,
                        title: "",
                        source: "",
                        type: "",
                        subtype: "",
                        author: "",
                        thumbnail: "",
                        url: "",
                        export_link: "",
                        tags: [],
                    },
                });
            },
            {},
        ],
        7: [
            function (require, module, exports) {
                "use strict";

                module.exports = Marionette.ItemView.extend({
                    template: "#tmpl-elementor-template-library-header-actions",

                    id: "elementor-template-library-header-actions",

                    ui: {
                        import: "#elementor-template-library-header-import i",
                        sync: "#elementor-template-library-header-sync i",
                        save: "#elementor-template-library-header-save i",
                    },

                    events: {
                        "click @ui.import": "onImportClick",
                        "click @ui.sync": "onSyncClick",
                        "click @ui.save": "onSaveClick",
                    },

                    onImportClick: function onImportClick() {
                        $e.route("kata-plus-elementor-library/import");
                    },

                    onSyncClick: function onSyncClick() {
                        var self = this;
                        self.ui.sync.addClass("eicon-animation-spin");
                        kata_plus_elementor.editor.templates.requestLibraryData({
                            onUpdate: function onUpdate() {
                                self.ui.sync.removeClass("eicon-animation-spin");
                                $e.routes.refreshContainer("kata-plus-elementor-library");
                            },
                            forceUpdate: true,
                            forceSync: true,
                        });
                    },

                    onSaveClick: function onSaveClick() {
                        $e.route("kata-plus-elementor-library/save-template");
                    },
                });
            },
            {},
        ],
        8: [
            function (require, module, exports) {
                "use strict";

                module.exports = Marionette.ItemView.extend({
                    template: "#tmpl-elementor-template-library-header-back",
                    id: "elementor-template-library-header-preview-back",
                    events: {
                        click: "onClick",
                    },
                    onClick: function onClick() {
                        $e.routes.restoreState("kata-plus-elementor-library");
                    },
                });
            },
            {},
        ],
        9: [
            function (require, module, exports) {
                "use strict";

                module.exports = Marionette.ItemView.extend({
                    template: "#tmpl-elementor-template-library-header-menu",
                    id: "elementor-template-library-header-menu",
                    templateHelpers: function templateHelpers() {
                        return {
                            tabs: $e.components.get("kata-plus-elementor-library").getTabs(),
                        };
                    },
                });
            },
            {},
        ],
        10: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryInsertTemplateBehavior = require("../../../behaviors/insert-template");

                module.exports = Marionette.ItemView.extend({
                    template: "#tmpl-kata-plus-elementor-template-library-header-preview",
                    id: "elementor-template-library-header-preview",
                    behaviors: {
                        insertTemplate: {
                            behaviorClass: TemplateLibraryInsertTemplateBehavior,
                        },
                    },
                });
            },
            {
                "../../../behaviors/insert-template": 2,
            },
        ],
        11: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryHeaderActionsView = require("./parts/header-parts/actions"),
                    TemplateLibraryHeaderMenuView = require("./parts/header-parts/menu"),
                    TemplateLibraryHeaderPreviewView = require("./parts/header-parts/preview"),
                    TemplateLibraryHeaderBackView = require("./parts/header-parts/back"),
                    TemplateLibraryCollectionView = require("./parts/templates"),
                    // TemplateLibraryImportView = require('./parts/import'),
                    TemplateLibraryPreviewView = require("./parts/preview");

                module.exports = elementorModules.common.views.modal.Layout.extend({
                    getModalOptions: function getModalOptions() {
                        return {
                            id: "kt-library-modal",
                            className: "dialog-widget dialog-lightbox-widget dialog-type-buttons dialog-type-lightbox elementor-templates-modal kt-library-modal",
                        };
                    },

                    getLogoOptions: function getLogoOptions() {
                        return {
                            title: "Template Library",
                            click: function click() {
                                $e.run("kata-plus-elementor-library/open", {
                                    toDefault: true,
                                });
                            },
                        };
                    },

                    getTemplateActionButton: function getTemplateActionButton(templateData) {
                        var viewId =
                            "#tmpl-elementor-template-library-" +
                            (templateData.isPro ? "get-pro-button" : "insert-button");

                        var template = Marionette.TemplateCache.get(viewId);

                        return Marionette.Renderer.render(template);
                    },

                    setHeaderDefaultParts: function setHeaderDefaultParts() {
                        var headerView = this.getHeaderView();

                        headerView.tools.show(new TemplateLibraryHeaderActionsView());
                        headerView.menuArea.show(new TemplateLibraryHeaderMenuView());

                        this.showLogo();
                    },

                    showTemplatesView: function showTemplatesView(templatesCollection) {
                        this.modalContent.show(
                            new TemplateLibraryCollectionView({
                                collection: templatesCollection,
                            })
                        );
                    },

                    showImportView: function showImportView() {
                        this.getHeaderView().menuArea.reset();

                        // this.modalContent.show(new TemplateLibraryImportView());
                    },

                    showPreviewView: function showPreviewView(templateModel) {
                        this.modalContent.show(
                            new TemplateLibraryPreviewView({
                                url: templateModel.get("url"),
                            })
                        );

                        var headerView = this.getHeaderView();

                        headerView.menuArea.reset();

                        headerView.tools.show(
                            new TemplateLibraryHeaderPreviewView({
                                model: templateModel,
                            })
                        );

                        headerView.logoArea.show(new TemplateLibraryHeaderBackView());
                    },
                });
            },
            {
                "./parts/header-parts/actions": 7,
                "./parts/header-parts/back": 8,
                "./parts/header-parts/menu": 9,
                "./parts/header-parts/preview": 10,
                "./parts/preview": 12,
                "./parts/templates": 14,
            },
        ],
        12: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryPreviewView;

                TemplateLibraryPreviewView = Marionette.ItemView.extend({
                    template: "#tmpl-elementor-template-library-preview",

                    id: "elementor-template-library-preview",

                    ui: {
                        iframe: "> iframe",
                    },

                    onRender: function onRender() {
                        this.ui.iframe.attr("src", this.getOption("url"));
                    },
                });

                module.exports = TemplateLibraryPreviewView;
            },
            {},
        ],
        13: [
            function (require, module, exports) {
                "use strict";
                var TemplateLibraryTemplatesEmptyView;
                TemplateLibraryTemplatesEmptyView = Marionette.ItemView.extend({
                    id: "elementor-template-library-templates-empty",
                    template: "#tmpl-elementor-template-library-templates-empty",
                    ui: {
                        title: ".elementor-template-library-blank-title",
                        message: ".elementor-template-library-blank-message",
                    },
                    modesStrings: {
                        empty: {
                            title: elementor.translate("templates_empty_title"),
                            message: elementor.translate("templates_empty_message"),
                        },
                        noResults: {
                            title: elementor.translate("templates_no_results_title"),
                            message: elementor.translate("templates_no_results_message"),
                        },
                        noFavorites: {
                            title: elementor.translate("templates_no_favorites_title"),
                            message: elementor.translate("templates_no_favorites_message"),
                        },
                    },

                    getCurrentMode: function getCurrentMode() {
                        if (elementor.templates.getFilter("text")) {
                            return "noResults";
                        }

                        if (elementor.templates.getFilter("favorite")) {
                            return "noFavorites";
                        }

                        return "empty";
                    },

                    onRender: function onRender() {
                        var modeStrings = this.modesStrings[this.getCurrentMode()];
                        var message = modeStrings.message;

                        this.ui.title.html(modeStrings.title);
                        this.ui.message.html(message);
                    },
                });

                module.exports = TemplateLibraryTemplatesEmptyView;
            },
            {},
        ],
        14: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryTemplateLocalView = require("../template/local"),
                    TemplateLibraryTemplateRemoteView = require("../template/remote"),
                    TemplateLibraryCollectionView;

                TemplateLibraryCollectionView = Marionette.CompositeView.extend({
                    template: "#tmpl-kata-plus-elementor-template-library-templates",

                    id: "elementor-template-library-templates",

                    childViewContainer: "#elementor-template-library-templates-container",

                    reorderOnSort: true,

                    emptyView: function emptyView() {
                        var EmptyView = require("./templates-empty");

                        return new EmptyView();
                    },

                    ui: {
                        textFilter: "#elementor-template-library-filter-text",
                        selectFilter: ".elementor-template-library-filter-select",
                        myFavoritesFilter: "#elementor-template-library-filter-my-favorites",
                        orderInputs: ".elementor-template-library-order-input",
                        orderLabels: "label.elementor-template-library-order-label",
                    },

                    events: {
                        "input @ui.textFilter": "onTextFilterInput",
                        "change @ui.selectFilter": "onSelectFilterChange",
                        "change @ui.myFavoritesFilter": "onMyFavoritesFilterChange",
                        "mousedown @ui.orderLabels": "onPluginsLabelsClick",
                    },

                    comparators: {
                        title: function title(model) {
                            return model.get("title").toLowerCase();
                        },
                        popularityIndex: function popularityIndex(model) {
                            var popularityIndex = model.get("popularityIndex");

                            if (!popularityIndex) {
                                popularityIndex = model.get("date");
                            }

                            return -popularityIndex;
                        },
                        trendIndex: function trendIndex(model) {
                            var trendIndex = model.get("trendIndex");

                            if (!trendIndex) {
                                trendIndex = model.get("date");
                            }

                            return -trendIndex;
                        },
                    },

                    getChildView: function getChildView(childModel) {
                        return TemplateLibraryTemplateRemoteView;
                        return TemplateLibraryTemplateLocalView;
                    },

                    initialize: function initialize() {
                        this.listenTo(elementor.channels.templates, "filter:change", this._renderChildren);
                    },

                    filter: function filter(childModel) {
                        var filterTerms = kata_plus_elementor.editor.templates.getFilterTerms(),
                            passingFilter = true;

                        jQuery.each(filterTerms, function (filterTermName) {
                            var filterValue = elementor.templates.getFilter(filterTermName);

                            if (!filterValue) {
                                return;
                            }

                            if (this.callback) {
                                var callbackResult = this.callback.call(childModel, filterValue);

                                if (!callbackResult) {
                                    passingFilter = false;
                                }

                                return callbackResult;
                            }

                            var filterResult = filterValue === childModel.get(filterTermName);

                            if (!filterResult) {
                                passingFilter = false;
                            }

                            return filterResult;
                        });

                        return passingFilter;
                    },

                    order: function order(by, reverseOrder) {
                        var comparator = this.comparators[by] || by;

                        if (reverseOrder) {
                            comparator = this.reverseOrder(comparator);
                        }

                        this.collection.comparator = comparator;

                        this.collection.sort();
                    },

                    reverseOrder: function reverseOrder(comparator) {
                        if (typeof comparator !== "function") {
                            var comparatorValue = comparator;

                            comparator = function comparator(model) {
                                return model.get(comparatorValue);
                            };
                        }

                        return function (left, right) {
                            var l = comparator(left),
                                r = comparator(right);

                            if (undefined === l) {
                                return -1;
                            }

                            if (undefined === r) {
                                return 1;
                            }

                            if (l < r) {
                                return 1;
                            }
                            if (l > r) {
                                return -1;
                            }
                            return 0;
                        };
                    },

                    addSourceData: function addSourceData() {
                        var isEmpty = this.children.isEmpty();
                        var source = "remote";

                        this.$el.attr("data-template-source", isEmpty ? "empty" : source);
                    },

                    setFiltersUI: function setFiltersUI() {
                        var $filters = this.$(this.ui.selectFilter);

                        $filters.select2({
                            placeholder: elementor.translate("category"),
                            allowClear: true,
                            width: 150,
                        });
                    },

                    setMasonrySkin: function setMasonrySkin() {
                        var masonry = new elementorModules.utils.Masonry({
                            container: this.$childViewContainer,
                            items: this.$childViewContainer.children(),
                        });

                        this.$childViewContainer.imagesLoaded(masonry.run.bind(masonry));
                    },

                    toggleFilterClass: function toggleFilterClass() {
                        this.$el.toggleClass(
                            "elementor-templates-filter-active",
                            !!(
                                elementor.templates.getFilter("text") ||
                                elementor.templates.getFilter("favorite")
                            )
                        );
                    },

                    onRender: function onRender() {
                        this.setFiltersUI();
                    },

                    onRenderCollection: function onRenderCollection() {
                        this.addSourceData();

                        this.toggleFilterClass();

                        this.setMasonrySkin();
                    },

                    onBeforeRenderEmpty: function onBeforeRenderEmpty() {
                        this.addSourceData();
                    },

                    onTextFilterInput: function onTextFilterInput() {
                        elementor.templates.setFilter("text", this.ui.textFilter.val());
                    },

                    onSelectFilterChange: function onSelectFilterChange(event) {
                        var $select = jQuery(event.currentTarget),
                            filterName = $select.data("elementor-filter");

                        elementor.templates.setFilter(filterName, $select.val());
                    },

                    onMyFavoritesFilterChange: function onMyFavoritesFilterChange() {
                        elementor.templates.setFilter("favorite", this.ui.myFavoritesFilter[0].checked);
                    },

                    onOrderLabelsClick: function onOrderLabelsClick(event) {
                        var $clickedInput = jQuery(event.currentTarget.control),
                            toggle;

                        if (!$clickedInput[0].checked) {
                            toggle = $clickedInput.data("default-ordering-direction") !== "asc";
                        }

                        $clickedInput.toggleClass("elementor-template-library-order-reverse", toggle);

                        this.order(
                            $clickedInput.val(),
                            $clickedInput.hasClass("elementor-template-library-order-reverse")
                        );
                    },

                    onPluginsLabelsClick: function onPluginsLabelsClick(event) {
                        var $clickedInput = jQuery(event.currentTarget.control);

                        elementor.templates.setFilter("plugins", $clickedInput.val());
                    },
                });

                module.exports = TemplateLibraryCollectionView;
            },
            {
                "../template/local": 16,
                "../template/remote": 17,
                "./templates-empty": 13,
            },
        ],
        15: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryInsertTemplateBehavior = require("../../behaviors/insert-template"),
                    TemplateLibraryTemplateView;

                TemplateLibraryTemplateView = Marionette.ItemView.extend({
                    className: function className() {
                        var classes = "elementor-template-library-template",
                            source = this.model.get("source");
                        source = "remote";

                        classes += " elementor-template-library-template-" + source;

                        classes += " elementor-template-library-template-" + this.model.get("subtype");

                        if (this.model.get("isPro")) {
                            classes += " elementor-template-library-pro-template";
                        }

                        return classes;
                    },

                    ui: function ui() {
                        return {
                            previewButton: ".elementor-template-library-template-preview",
                        };
                    },

                    events: function events() {
                        return {
                            "click @ui.previewButton": "onPreviewButtonClick",
                        };
                    },

                    behaviors: {
                        insertTemplate: {
                            behaviorClass: TemplateLibraryInsertTemplateBehavior,
                        },
                    },
                });

                module.exports = TemplateLibraryTemplateView;
            },
            {
                "../../behaviors/insert-template": 2,
            },
        ],
        16: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryTemplateView = require("./base"),
                    TemplateLibraryTemplateLocalView;

                TemplateLibraryTemplateLocalView = TemplateLibraryTemplateView.extend({
                    template: "#tmpl-elementor-template-library-template-local",

                    ui: function ui() {
                        return _.extend(TemplateLibraryTemplateView.prototype.ui.apply(this, arguments), {
                            morePopup: ".elementor-template-library-template-more",
                            toggleMore: ".elementor-template-library-template-more-toggle",
                            toggleMoreIcon: ".elementor-template-library-template-more-toggle i",
                        });
                    },

                    events: function events() {
                        return _.extend(TemplateLibraryTemplateView.prototype.events.apply(this, arguments), {
                            "click @ui.toggleMore": "onToggleMoreClick",
                        });
                    },

                    onToggleMoreClick: function onToggleMoreClick() {
                        this.ui.morePopup.show();
                    },

                    onPreviewButtonClick: function onPreviewButtonClick() {
                        open(this.model.get("url"), "_blank");
                    },
                });

                module.exports = TemplateLibraryTemplateLocalView;
            },
            {
                "./base": 15,
            },
        ],
        17: [
            function (require, module, exports) {
                "use strict";

                var TemplateLibraryTemplateView = require("./base"),
                    TemplateLibraryTemplateRemoteView;

                TemplateLibraryTemplateRemoteView = TemplateLibraryTemplateView.extend({
                    template: "#tmpl-kata-plus-elementor-template-library-template-remote",

                    ui: function ui() {
                        return jQuery.extend(
                            TemplateLibraryTemplateView.prototype.ui.apply(this, arguments),
                            {
                                favoriteCheckbox: ".elementor-template-library-template-favorite-input",
                            }
                        );
                    },

                    events: function events() {
                        return jQuery.extend(
                            TemplateLibraryTemplateView.prototype.events.apply(this, arguments),
                            {
                                "change @ui.favoriteCheckbox": "onFavoriteCheckboxChange",
                            }
                        );
                    },

                    onPreviewButtonClick: function onPreviewButtonClick() {
                        $e.route("kata-plus-elementor-library/preview", {
                            model: this.model,
                        });
                    },

                    onFavoriteCheckboxChange: function onFavoriteCheckboxChange() {
                        var isFavorite = this.ui.favoriteCheckbox[0].checked;

                        this.model.set("favorite", isFavorite);

                        elementor.templates.markAsFavorite(this.model, isFavorite);

                        if (!isFavorite && elementor.templates.getFilter("favorite")) {
                            elementor.channels.templates.trigger("filter:change");
                        }
                    },
                });

                module.exports = TemplateLibraryTemplateRemoteView;
            },
            {
                "./base": 15,
            },
        ],
        18: [
            function (require, module, exports) {
                "use strict";

                Object.defineProperty(exports, "__esModule", {
                    value: true,
                });
                var Presets = elementor.modules.controls.BaseData.extend({
                    syncing: false,

                    ui: function ui() {
                        var ui = elementor.modules.controls.BaseMultiple.prototype.ui.apply(this, arguments);

                        ui.presetItems = ".kt-presets";
                        ui.presetItem = ".kt-preset-item";

                        return ui;
                    },

                    events: function events() {
                        return _.extend(
                            elementor.modules.controls.BaseMultiple.prototype.events.apply(this, arguments),
                            {
                                "click @ui.presetItem ": "onPresetClick",
                            }
                        );
                    },

                    onReady: function onReady() {
                        window.KataPlusPresets = window.KataPlusPresets || {};

                        this.loadPresets(this.settingsModel().get("widgetType"));

                        $e.hooks.data.on(
                            "KataPlus:element:after:reset:style",
                            this.onElementAfterResetStyle.bind(this)
                        );
                        $e.hooks.data.on(
                            "KataPlus:element:before:reset:style",
                            this.onElementBeforeResetStyle.bind(this)
                        );
                        $e.hooks.data.on("KataPlus:presets:sync", this.onPresetsSync.bind(this));
                    },

                    onElementAfterResetStyle: function onElementAfterResetStyle(model) {
                        if (model.id !== this.container.model.id) {
                            return;
                        }

                        if (this.isRendered) {
                            this.render();
                        }
                    },

                    onElementBeforeResetStyle: function onElementBeforeResetStyle(model) {
                        if (model.id !== this.container.model.id) {
                            return;
                        }

                        this.applyPresetSettings(this.elementDefaultSettings());
                    },

                    onPresetClick: function onPresetClick(e) {
                        var $preset = jQuery(e.currentTarget);
                        $preset.addClass("active").siblings().removeClass("active");

                        var preset = _.find(this.getPresets(), {
                            id: $preset.data("preset-id"),
                        });

                        this.applyPreset(this.elementDefaultSettings(), preset);
                    },

                    onPresetsSync: function onPresetsSync(element) {
                        var _this = this;

                        if (this.syncing) {
                            return;
                        }

                        this.syncing = true;

                        var presets = window.KataPlusPresets || {};

                        window.KataPlusPresets = {};

                        this.loadPresets(
                            this.settingsModel().get("widgetType"),
                            function () {
                                _this.syncing = false;
                            },
                            function () {
                                _this.syncing = false;
                                window.KataPlusPresets = presets;
                            }
                        );
                    },

                    settingsModel: function settingsModel() {
                        var currentVersion = window.elementor.config.version;
                        var compareVersions = window.elementor.helpers.compareVersions;

                        if (compareVersions(currentVersion, "2.8.0", "<")) {
                            return this.elementSettingsModel;
                        }

                        return this.container.settings;
                    },

                    applyPreset: function applyPreset() {
                        var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
                        var preset = arguments[1];

                        for (var setting in preset.widget.settings) {
                            if (this.model.get("name") === setting) {
                                continue;
                            }

                            var control = this.settingsModel().controls[setting];

                            if (typeof control === "undefined") {
                                continue;
                            }

                            if (control.is_repeater) {
                                settings[setting] = new window.Backbone.Collection(
                                    this.getRepeaterSetting(control, setting, preset),
                                    {
                                        model: _.partial(this.createRepeaterItemModel, _, _, control.fields),
                                    }
                                );

                                continue;
                            }

                            settings[setting] = preset.widget.settings[setting];
                        }

                        // Keep local settings.
                        settings["kata_plus_presets"] = this.settingsModel().get("kata_plus_presets");

                        this.applyPresetSettings(settings);
                    },

                    applyPresetSettings: function applyPresetSettings(settings) {
                        var currentVersion = window.elementor.config.version;
                        var compareVersions = window.elementor.helpers.compareVersions;

                        if (compareVersions(currentVersion, "2.8.0", "<")) {
                            for (var setting in this.settingsModel().controls) {
                                this.settingsModel().set(setting, settings[setting]);
                            }

                            return;
                        }

                        this.settingsModel().set(settings);

                        this.container.view.renderUI();
                        this.container.view.renderHTML();
                        this.setValue(null);
                    },

                    getRepeaterSetting: function getRepeaterSetting(control, setting, preset) {
                        var repeaterCurrentSettings = this.settingsModel().get(setting);
                        var repeaterPresetSettings = jQuery.extend(true, [], preset.widget.settings[setting]);
                        var repeaterSettings = [];

                        if (!repeaterCurrentSettings.models) {
                            return;
                        }

                        for (var i = 0; i < repeaterCurrentSettings.models.length; i++) {
                            var model = repeaterCurrentSettings.models[i];
                            var modelSettings = {};

                            for (var attr in model.controls) {
                                if (i > repeaterPresetSettings.length - 1) {
                                    modelSettings[attr] = model.get(attr);

                                    continue;
                                }

                                modelSettings[attr] = repeaterPresetSettings[i][attr];
                            }

                            repeaterSettings.push(modelSettings);
                        }

                        return repeaterSettings;
                    },

                    createRepeaterItemModel: function createRepeaterItemModel(attrs, options, fields) {
                        options = options || {};

                        options.controls = fields;

                        if (!attrs._id) {
                            attrs._id = elementor.helpers.getUniqueID();
                        }

                        return new window.elementorModules.editor.elements.models.BaseSettings(
                            attrs,
                            options
                        );
                    },

                    elementDefaultSettings: function elementDefaultSettings() {
                        var self = this,
                            controls = self.settingsModel().controls,
                            settings = {};

                        jQuery.each(controls, function (controlName, control) {
                            settings[controlName] = control.default;
                        });

                        return settings;
                    },

                    loadPresets: function loadPresets(widget, successCallback, errorCallback) {
                        var _this2 = this;

                        if (this.isPresetDataLoaded()) {
                            if (this.getPresets().length === 0) {
                                return;
                            }

                            if (this.ui.presetItem.length === 0) {
                                this.render();
                            }

                            return;
                        }

                        this.ui.presetItems.addClass("loading");

                        wp.ajax
                            .post("kata_plus_element_presets", {
                                "_ajax_nonce": kata_plus_elementor.element_presets_nonce,
                                "element": widget,
                            })
                            .done(function (data) {
                                if (successCallback) {
                                    successCallback();
                                }

                                _this2.ui.presetItems.removeClass("loading");
                                _this2.setPresets(data);
                                _this2.setValue(null);
                                _this2.render();
                            })
                            .fail(function () {
                                if (errorCallback) {
                                    errorCallback();
                                }

                                _this2.ui.presetItems.removeClass("loading");
                                _this2.setPresets([]);
                            });
                    },

                    getPresets: function getPresets() {
                        if (!window.KataPlusPresets) {
                            return [];
                        }

                        return window.KataPlusPresets[this.settingsModel().get("widgetType")] || [];
                    },

                    setPresets: function setPresets(presets) {
                        window.KataPlusPresets[this.settingsModel().get("widgetType")] = presets;
                    },

                    isPresetDataLoaded: function isPresetDataLoaded() {
                        if (window.KataPlusPresets[this.settingsModel().get("widgetType")]) {
                            return true;
                        }

                        return false;
                    },

                    onBeforeDestroy: function onBeforeDestroy() {
                        $e.hooks.data.off("KataPlus:element:after:reset:style");
                        $e.hooks.data.off("KataPlus:presets:sync");
                    },
                });

                exports.default = Presets;
            },
            {},
        ],
    },
    {},
    [1]
);
