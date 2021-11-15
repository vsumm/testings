/**
 *
 * ClimaxThemes live customizer
 *
 * @author ClimaxThemes
 * @link http://climaxthemes.com
 *
 */
(function ($) {
	'use strict';

	if (typeof (wp) == 'undefined' ||
		typeof (wp.customize) == 'undefined') {
		return false;
	}

	// var SData = {};
	var lastStyler = false;
	// Start new customize changes
	var KataCreateCss = function (selectors, $selector, $val) {
		if (!$val.trim()) {
			return '';
		}
		if (selectors[$selector]) {
			switch ($selector) {
				case 'desktop':
				case 'desktophover':
				case 'desktopphover':
				case 'desktopbefore':
				case 'desktopafter':
					return selectors[$selector] + '{ ' + $val + ' }';
					break;
				case 'laptop':
				case 'laptophover':
				case 'laptopphover':
				case 'laptopbefore':
				case 'laptopafter':
					return '@media screen and (max-width:' + ElementorBreakPoints.laptop + 'px){ ' + selectors[$selector] + '{' + $val + ' }}';
					break;
				case 'tablet':
				case 'tablethover':
				case 'tabletphover':
				case 'tabletbefore':
				case 'tabletafter':
					return '@media screen and (max-width:' + ElementorBreakPoints.tablet + 'px){ ' + selectors[$selector] + '{' + $val + ' }}';
					break;
				case 'tabletlandscape':
				case 'tabletlandscapehover':
				case 'tabletlandscapephover':
				case 'tabletlandscapebefore':
				case 'tabletlandscapeafter':
					return '@media screen and (max-width:' + ElementorBreakPoints.tabletlandscape + 'px){ ' + selectors[$selector] + '{' + $val + ' }}';
					break;
				case 'mobile':
				case 'mobilehover':
				case 'mobilephover':
				case 'mobilebefore':
				case 'mobileafter':
					return '@media screen and (max-width:' + ElementorBreakPoints.mobile + 'px){ ' + selectors[$selector] + '{' + $val + ' }}';
					break;
				case 'smallmobile':
				case 'smallmobilehover':
				case 'smallmobilephover':
				case 'smallmobilebefore':
				case 'smallmobileafter':
					return '@media screen and (max-width:' + ElementorBreakPoints.smallmobile + 'px){ ' + selectors[$selector] + '{' + $val + ' }}';
					break;
			}
		}
	}

	$(document).on('ready', function () {
		wp.customize.bind('save', function () {
			$.ajax({
				type: 'post',
				url: ajaxurl + '?action=kata_plus_styler_save_customizer_form',
				data: $('#customize-controls').serialize(),
				dataType: "json",
				success: function () {
					// console.log('');
				}
			});
		});

		jQuery('.styler-wrap .top-bar span.close').on('click', function () {
			if (lastStyler != false) {
				lastStyler.find('input[data-customize-setting-link]').trigger('input').trigger('change');
			}
		});
		jQuery(document).on('click', '.styler-dialog-btn', function () {
			if (lastStyler != false) {
				lastStyler.find('input[data-customize-setting-link]').trigger('input').trigger('change');
			}
		})

		var UpdateAction = false;
		$(document).on('input', '#customize-theme-controls .styler-dialog-btn input[data-setting]', function () {
			if (UpdateAction == true) {
				return;
			}

			UpdateAction = true;

			setTimeout(() => {
				jQuery(this).trigger('change');
				UpdateAction = false;
			}, 200);

		});
		$(document).on('input', '#customize-theme-controls .styler-dialog-btn input[data-setting]', function () {
			var val = jQuery(this).val();
			val = val.replace(/[\\]/g, '');
			val = val.replace(/undefined/g, '');
			jQuery(this).val(val);
		});
		$(document).on('input', '#customize-theme-controls .styler-dialog-btn input[data-customize-setting-link]', function () {
			var val = jQuery(this).val();
			val = val.replace(/[\\]/g, '');
			val = val.replace(/undefined/g, '');
			jQuery(this).val(val);
		});
		$(document).on('change', '#customize-theme-controls .styler-dialog-btn input[data-setting]', function () {
			lastStyler = $(this).parent();

			var stringToSlug = function (str) {
					str = $.trim(str);
					str = str.replace(/[^a-z0-9-]/gi, '-').replace(/-+/g, '_').replace(/^-|-$/g, '');
					return str.toLowerCase();
				},

				id = stringToSlug($(this).siblings('input[data-customize-setting-link]').attr('data-customize-setting-link')),
				out = '';

			var selectors = $(this).parent('.styler-dialog-btn').data('selector');
			$(this).siblings('input[data-setting]').each(function () {
				if ($(this).val()) {
					// SData[$(this).data('setting')] = $(this).val();
					out += KataCreateCss(selectors, $(this).data('setting'), $(this).val());
				}
			});
			out = out + KataCreateCss(selectors, $(this).data('setting'), $(this).val());

			// SData[$(this).data('setting')] = $(this).val();
			// console.log(SData);
			out = out.replace(/[\\]/g, '');
			out = out.replace(/undefined/g, '');
			$(this).siblings('input[data-customize-setting-link]').val(out);
			// Live CSS output
			$('body').find('iframe').contents().find('head').find('#CUSTOM_STYLE_' + id).remove();
			$('body').find('iframe').contents().find('head').append('<style id="CUSTOM_STYLE_' + id + '"></style>');
			$('body').find('iframe').contents().find('head').find('#CUSTOM_STYLE_' + id).html(out);
		});

		$('.devices-wrapper').find('.devices').find('button.active').each(function (index, element) {
			var $this = $(this),
				device = $this.attr('data-device'),
				$wrap = $this.closest('.devices-wrapper');
			$wrap.append('<i id="selected-device" class="eicon-device-' + device + '"></i>');
		});

		$('.devices-wrapper').find('#selected-device').on('click', function (e) {
			var $this = $(this);
			$this.closest('.devices-wrapper').find('.devices').fadeToggle(1);
		});

		$(document).on('click', function (e) {
			if (e.target.id != 'selected-device' && $('.devices-wrapper').find('.devices').css('display') == 'block') {
				$('.devices-wrapper').find('#selected-device').trigger('click');
			}
		});

		$('.devices-wrapper').find('button[type="button"]').on('click', function () {
			var $this = $(this),
				$wrap = $this.closest('.devices-wrapper'),
				device = $this.attr('data-device');
			$wrap.find('#selected-device').attr('class', 'eicon-device-' + device);
		});


	});
})(jQuery); // End jquery