// (function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
'use strict';
Object.defineProperty(exports, "__esModule", {
    value: true
});
var CustomPresets = elementor.modules.controls.BaseData.extend({
    excludeControls: [
        /* Elementor controls */
        'text', 'number', 'textarea', 'icon', 'icons', 'url', 'media', 'gallery', 'wysiwyg', 'date_time',
    ],
    widgetType: '',
    syncing: false,

    ui: function ui() {
        var ui = elementor.modules.controls.BaseMultiple.prototype.ui.apply(this, arguments);

        ui.presetItems = '.kata-plus-elementorelement-custom-presets';
        ui.presetItem = '.kata-plus-elementorelement-custom-presets-item';
        ui.presetAddBtn = '.kata-plus-elementorelement-custom-presets-add-btn';
        ui.presetDeleteBtn = '.kata-plus-elementorelement-custom-presets-item-delete';
        ui.presetApplyBtn = '.kata-plus-elementorelement-custom-presets-item-apply';
        ui.presetInput = '.kata-plus-elementorelement-custom-presets-input';
        ui.presetInputWrapper = '.kata-plus-elementorelement-custom-presets-input-wrapper';

        return ui;
    },

    events: function events() {
        return _.extend(elementor.modules.controls.BaseMultiple.prototype.events.apply(this, arguments), {
            'click @ui.presetAddBtn ': 'onAddPreset',
            'click @ui.presetDeleteBtn': 'onDeletePreset',
            'click @ui.presetApplyBtn': 'onApplyPreset'
        });
    },

    onReady: function onReady() {
        this.widgetType = this.settingsModel().get('widgetType');

        window.kataPlusCustomPresets = window.kataPlusCustomPresets || {};

        this.loadPresets(this.widgetType);

        elementor.channels.data.bind('kata_plus_elementor:presets:sync', this.onPresetsSync.bind(this));
    },

    onPresetsSync: function onPresetsSync(element) {
        var _this = this;

        if (this.syncing) {
            return;
        }

        this.syncing = true;

        var presets = window.kataPlusCustomPresets || {};

        window.kataPlusCustomPresets = {};

        this.loadPresets(this.widgetType, function () {
            _this.syncing = false;
        }, function () {
            _this.syncing = false;
            window.kataPlusCustomPresets = presets;
        });
    },

    loadPresets: function loadPresets(widget, successCallback, errorCallback) {
        var _this2 = this;

        if (this.isPresetDataLoaded()) {
            this.ui.presetItems.removeClass('loading');

            return;
        }

        this.ui.presetItems.addClass('loading');

        wp.ajax.post('kata_plus_elementor_element_custom_presets', {
            '_ajax_nonce': window.kata_plus_elementor_editor.element_custom_presets_nonce,
            'element': widget
        }).done(function (data) {
            if (successCallback) {
                successCallback();
            }

            _this2.setPresets(data);
            _this2.setValue(null);
            _this2.ui.presetItems.removeClass('loading');

            _this2.render();
        }).fail(function () {
            if (errorCallback) {
                errorCallback();
            }

            _this2.setPresets([]);
            _this2.ui.presetItems.removeClass('loading');
        });
    },

    getPresets: function getPresets() {
        if (!window.kataPlusCustomPresets) {
            return [];
        }

        return jQuery.extend(true, [], window.kataPlusCustomPresets[this.widgetType]) || [];
    },

    setPresets: function setPresets(presets) {
        window.kataPlusCustomPresets[this.widgetType] = presets;
    },

    setPreset: function setPreset(preset) {
        var presets = window.kataPlusCustomPresets[this.widgetType];

        if (!presets) {
            window.kataPlusCustomPresets[this.widgetType] = [preset];

            return;
        }

        presets.unshift(preset);
    },

    isPresetDataLoaded: function isPresetDataLoaded() {
        if (window.kataPlusCustomPresets[this.widgetType]) {
            return true;
        }

        return false;
    },

    onApplyPreset: function onApplyPreset(e) {
        var $applyBtn = jQuery(e.target).closest(this.ui.presetApplyBtn);
        var id = jQuery(e.target).closest(this.ui.presetItem).data('preset-id');

        var preset = _.find(window.kataPlusCustomPresets[this.widgetType], {
            id: id.toString()
        });

        if (!preset) {
            return;
        }

        preset = jQuery.extend(true, {}, preset);

        $applyBtn.tipsy('hide');

        this.applyPreset(this.elementDefaultSettings(), preset);
        this.setValue(null);
    },

    onAddPreset: function onAddPreset(e) {
        var _this3 = this;

        var title = jQuery(e.target).closest(this.ui.presetInputWrapper).find(this.ui.presetInput).val();

        if (!title || title.trim().length === 0) {
            return;
        }

        var settings = jQuery.extend(true, {}, this.settingsModel().attributes);

        delete settings['kata_plus_elementor_presets'];
        delete settings['kata_plus_elementor_custom_presets'];

        var data = {
            title: title,
            content: JSON.stringify(settings),
            element_type: this.settingsModel().get('widgetType'),
            elementor_version: window.elementor.config.version,
            domain: window.location.hostname
        };

        this.ui.presetAddBtn.attr('disabled', 'disabled');

        this.ui.presetAddBtn.find('.fa').removeClass('fa-plus-circle').addClass('fa-spin fa-spinner');

        wp.ajax.post('kata_plus_elementor_store_custom_preset', {
            '_ajax_nonce': window.kata_plus_elementor_editor.store_custom_preset_nonce,
            'data': data
        }).done(function (data) {
            _this3.ui.presetAddBtn.removeAttr('disabled');

            _this3.ui.presetAddBtn.find('.fa').removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-plus-circle');

            _this3.hideToolTip();
            _this3.setPreset(data);
            _this3.render();
        }).fail(function () {
            _this3.ui.presetAddBtn.removeAttr('disabled');

            _this3.ui.presetAddBtn.find('.fa').removeClass('fa-spin').removeClass('fa-spinner').addClass('fa-plus-circle');
        });
    },

    onDeletePreset: function onDeletePreset(e) {
        var _this4 = this;

        var translations = window.kata_plus_elementor_editor;
        var dialog = null;
        var $presetItem = jQuery(e.target).closest(this.ui.presetItem);
        var preset = _.findWhere(this.getPresets(), {
            id: $presetItem.data('preset-id').toString()
        });

        var options = {
            id: 'elementor-fatal-error-dialog',
            headerMessage: preset.title,
            message: translations.dialog_delete_preset_msg,
            position: {
                my: 'center center',
                at: 'center center'
            },
            strings: {
                confirm: translations.delete,
                cancel: translations.cancel
            },
            onConfirm: function onConfirm() {
                _this4.deletePreset(preset, dialog);
            },
            onCancel: function onCancel() {
                dialog.hide();
            },
            hide: {
                onBackgroundClick: false,
                onButtonClick: false
            }
        };

        dialog = window.elementor.dialogsManager.createWidget('confirm', options);

        this.hideToolTip();

        dialog.show();
    },

    deletePreset: function deletePreset(preset, dialog) {
        var _this5 = this;

        var translations = window.kata_plus_elementor_editor;

        dialog.setMessage(translations.deleting + ' <span class="fa fa-spin fa-spinner"></span>');

        wp.ajax.post('kata_plus_elementor_delete_custom_preset', {
            '_ajax_nonce': window.kata_plus_elementor_editor.delete_custom_preset_nonce,
            'id': preset.id,
            'element_type': preset.element_type
        }).done(function () {
            var cacheIndex = _.findIndex(window.kataPlusCustomPresets[_this5.widgetType], {
                id: preset.id
            });

            window.kataPlusCustomPresets[_this5.widgetType].splice(cacheIndex, 1);

            _this5.render();

            dialog.hide();
        }).fail(function () {
            dialog.setMessage(translations.dialog_delete_preset_error_msg);
        });
    },

    settingsModel: function settingsModel() {
        var currentVersion = window.elementor.config.version;
        var compareVersions = window.elementor.helpers.compareVersions;


        if (compareVersions(currentVersion, '2.8.0', '<')) {
            return this.elementSettingsModel;
        }

        return this.container.settings;
    },

    applyPreset: function applyPreset() {
        var settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        var preset = arguments[1];

        var presetSettings = JSON.parse(preset.content);

        for (var setting in presetSettings) {
            if (this.model.get('name') === setting) {
                continue;
            }

            var control = this.settingsModel().controls[setting];

            if (typeof control === 'undefined') {
                continue;
            }

            if (this.excludeControls.indexOf(control.type) >= 0) {
                continue;
            }

            if (control.is_repeater) {
                settings[setting] = new window.Backbone.Collection(this.getRepeaterSetting(control, setting, presetSettings), {
                    model: _.partial(this.createRepeaterItemModel, _, _, control.fields)
                });

                continue;
            }

            settings[setting] = presetSettings[setting];
        }

        // Keep local settings.
        settings['kata_plus_elementor_presets'] = null;
        settings['kata_plus_elementor_custom_presets'] = this.settingsModel().get('kata_plus_elementor_custom_presets');

        this.applyPresetSettings(settings);
    },

    applyPresetSettings: function applyPresetSettings(settings) {
        var currentVersion = window.elementor.config.version;
        var compareVersions = window.elementor.helpers.compareVersions;


        if (compareVersions(currentVersion, '2.8.0', '<')) {
            for (var setting in this.settingsModel().controls) {
                this.settingsModel().set(setting, settings[setting]);
            }

            return;
        }

        this.settingsModel().set(settings);

        this.container.view.renderUI();
        this.container.view.renderHTML();
    },

    getRepeaterSetting: function getRepeaterSetting(control, setting, presetSettings) {
        var repeaterCurrentSettings = this.settingsModel().get(setting);
        var repeaterPresetSettings = jQuery.extend(true, [], presetSettings[setting]);
        var repeaterSettings = [];

        if (!repeaterCurrentSettings.models) {
            return;
        }

        for (var i = 0; i < repeaterCurrentSettings.models.length; i++) {
            var model = repeaterCurrentSettings.models[i];
            var modelSettings = {};

            for (var attr in model.controls) {
                if (this.excludeControls.indexOf(model.controls[attr].type) >= 0) {
                    modelSettings[attr] = model.get(attr);

                    continue;
                }

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

        return new window.elementorModules.editor.elements.models.BaseSettings(attrs, options);
    },

    elementDefaultSettings: function elementDefaultSettings() {
        var self = this,
            controls = self.settingsModel().controls,
            settings = {};

        jQuery.each(controls, function (controlName, control) {
            if (self.excludeControls.indexOf(control.type) >= 0) {
                settings[controlName] = self.settingsModel().get(controlName);

                return;
            }

            settings[controlName] = control.default;
        });

        return settings;
    },

    hideToolTip: function hideToolTip() {
        jQuery.each(jQuery(this.ui.presetDeleteBtn.selector), function () {
            jQuery(this).tipsy('hide');
        });

        jQuery.each(jQuery(this.ui.presetApplyBtn.selector), function () {
            jQuery(this).tipsy('hide');
        });
    },

    onBeforeDestroy: function onBeforeDestroy() {
        elementor.channels.data.unbind('kata_plus_elementor:presets:sync');
    }
});

exports.default = CustomPresets;