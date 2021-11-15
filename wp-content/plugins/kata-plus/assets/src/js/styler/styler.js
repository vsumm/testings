/**
 * Styler.
 *
 * @author  Kata
 * @package	Kata Plus
 * @since	1.0.0
 */
"use strict";

var StylerCore = (function ($) {
	var $dialog,
		$action,
		$btn,
		$data,
		$platform,
		$serialized_data,
		$clipboard,
		$pickers = {},
		$pickr_data,
		$UpdateAction = false,
		$loaded = false,
		KeyStep = 1,
		$dontUpdate = false,
		$dontTrigger = false,
		$elementor;

	return {
		/**
		 * Init.
		 *
		 * @since	1.0.0
		 */
		init: function (dialog, button, elementor) {
			jQuery(document).trigger("styler:before:init");
			$dialog = dialog;
			$btn = button;
			$elementor = elementor;
			$action = "";
			$platform = "desktop";
			this.preload();
			if ($action == "before" || $action == "after") {
				$dialog.find(".css-content-par").removeClass("hidden");
			} else {
				if (!$dialog.find(".css-content-par").hasClass("hidden")) {
					$dialog.find(".css-content-par").addClass("hidden");
				}
			}
			setTimeout(() => {
				this.fix_scrollbar();
			}, 100);
		},
		get_platform: function () {
			return $platform;
		},
		rgbA_to_hexA: function (rgba) {
			var rgba = rgba.match(/.*?[rgb|rgba]\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\).*?/i);

			let r = (+rgba[1]).toString(16),
				g = (+rgba[2]).toString(16),
				b = (+rgba[3]).toString(16),
				a = "";

			if (typeof rgba[4] != "undefined") {
				a = Math.round(+rgba[4] * 255).toString(16);
			}

			if (r.length == 1) r = "0" + r;
			if (g.length == 1) g = "0" + g;
			if (b.length == 1) b = "0" + b;
			if (a.length == 1) a = "0" + a;

			return "#" + r + g + b + a;
		},

		/**
		 * PreLoad.
		 *
		 * @since	1.0.0
		 */
		preload: function () {
			jQuery(document).trigger("styler:before:preload");
			if (jQuery("#e-responsive-bar-switcher").length) {
				$dialog.find(".content").getNiceScroll().hide();
				// $platform = jQuery('.elementor-panel-footer-sub-menu').find('.elementor-panel-footer-sub-menu-item.active').attr('data-device-mode');
				jQuery("#e-responsive-bar-switcher").find(".e-responsive-bar-switcher__option").each(function (index, element) {
					if (jQuery(this).prop("checked")) {
						$platform = jQuery(this).attr("value");
					}
				});
				$dialog.find(".platforms").find("[data-name]").each(function () {
					jQuery(this).removeClass("active");
				});

				$dialog.find(".platforms").find('[data-name="' + $platform + '"]').addClass("active");
				var i = $dialog.find(".platforms").find('[data-name="' + $platform + '"]').find("i");
				$dialog.find(".platforms").siblings(".selected-platform").html(i.clone());
			}
			if (!$loaded) {
				jQuery.fn.styler_upload = function () {
					return this.each(function () {
						if (jQuery(this).hasClass("inited")) {
							return;
						}
						jQuery(document).on("click", ".styler-wrap", function () {
							jQuery(document).off("click", ".styler-wrap");
							jQuery(".kata-plus-color-picker .pcr-swatches").each(function () {
								if (jQuery(this).find(".kata-plus-color-picker-add-color").length < 1) {
									jQuery(this).append( '<div class="kata-plus-color-picker-add-color" aria-label="add color swatch"><i class="eicon-plus"></i></div>' );
								}
							});
						});

						var en = jQuery(this),
							button = en.find("a"),
							input = en.find("input"),
							extensions = ["jpg", "gif", "png", "svg", "jpeg"],
							wp_media_frame;

						en.addClass("inited");

						button.on("click", function (e) {
							e.preventDefault();

							var $imgContainer = jQuery(this).parent();
							if (typeof wp === "undefined" || !wp.media || !wp.media.gallery) {
								return;
							}

							if (wp_media_frame) {
								wp_media_frame.open();
								return;
							}

							wp_media_frame = wp.media({
								title: button.data("frame-title"),
								library: {
									type: button.data("upload-type"),
								},
								button: {
									text: button.data("insert-title"),
								},
							});

							wp_media_frame.on("select", function () {
								var attachment = wp_media_frame.state().get("selection").first();
								$imgContainer.css(
									"background-image",
									"url(" + attachment.attributes.url + ")"
								);
								input.val(attachment.attributes.url).trigger("input");
								$imgContainer.find(".remove").removeClass("hidden");
							});

							wp_media_frame.open();
						});

						// Delete image link
						button.siblings(".remove").on("click", function (event) {
							event.preventDefault();
							var $imgContainer = jQuery(this).parent();
							let $imgIdInput = jQuery(this).parent().siblings("input");

							// Clear out the preview image
							$imgContainer.css("background-image", "");

							// Delete the image id from the hidden input
							jQuery(this).addClass("hidden");
							$imgIdInput.val("").trigger("input");
						});
					});
				};
			}
			// Scrollbar
			$dialog.find(".content").niceScroll({
				cursorcolor: "#aaa",
				cursoropacitymin: 0,
				cursoropacitymax: 1,
				cursorwidth: "7px",
				cursorborder: "none",
				cursorborderradius: "5px",
				scrollspeed: 60,
				mousescrollstep: 40,
				hwacceleration: !0,
				gesturezoom: !0,
				grabcursorenabled: !0,
				autohidemode: !0,
				spacebarenabled: !0,
				railpadding: {
					top: 0,
					right: 1,
					left: 0,
					bottom: 1,
				},
				disableoutline: !0,
				horizrailenabled: !1,
				railalign: "right",
				railvalign: "bottom",
				enablemousewheel: !0,
				enablekeyboard: !0,
				smoothscroll: !0,
				cursordragspeed: 0.3,
			});
			jQuery(document).on("click", ".widget-control-save", function (e) {
				e.preventDefault();
				setTimeout(() => {
					var slc = $btn.attr("data-title");
					jQuery('.styler-dialog-btn[data-title="' + slc + '"]').trigger("click");
				}, 2000);
			});

			// Apply Dialog Title
			$dialog
				.find(".top-bar > strong")
				.html(
					(jQuery("#elementor-panel-header-title").length > 0
						? jQuery("#elementor-panel-header-title").html().replace("Edit ", "")
						: "Styler") +
						" - " +
						$btn.data("title")
				);

			$dialog.find(".actions span").each(function () {
				jQuery(this).removeClass("active");
			});

			// Active First Action
			$dialog.find(".actions span").first().addClass("active");

			// Active First Tab
			$dialog.find(".content .styler-tab").removeClass("active");
			$dialog.find(".content .styler-tab").first().addClass("active");
			$dialog.find('.kata-important-btn[data-task="important"]').removeClass("active");

			// Apply Upload Buttons
			$dialog.find(".styler_upload").each(function () {
				jQuery(this).styler_upload();
			});

			// Active Responsive
			if ($dialog.hasClass("slideout")) {
				$dialog
					.find(".platforms")
					.find('[data-name="' + $platform + '"]')
					.trigger("click");
			}

			// Active First Section
			$dialog.find(".left-side ul li").each(function () {
				jQuery(this).removeClass("active");
			});
			$dialog.find(".left-side ul li").first().addClass("active");

			// Fix Background Images
			$dialog.find(".image-container").css("background-image", "").find(".remove").addClass("hidden");

			// Fix Custom Selects
			$dialog.find(".custom-select").each(function () {
				jQuery(this)
					.find("span[data-name]")
					.each(function () {
						jQuery(this).removeClass("active");
					});
			});

			this.show_dialog();

			jQuery(document).trigger("styler:after:preload");
		}, // PRELOAD

		/**
		 * Show Styler Dialog.
		 *
		 * @since	1.0.0
		 */
		show_dialog: function () {
			// Show Dialog
			$dialog.find(".container ").addClass("loading");
			$dialog.removeClass("slideout");
			$dialog.removeClass("hidden");
			$dialog.addClass("show");
			setTimeout(() => {
				this.fix_scrollbar();
			}, 100);
			this.reset();
			setTimeout(() => {
				this.load();
			}, 10);
		},

		/**
		 * Run in first step. (once)
		 *
		 * @since	1.0.0
		 */
		once_load: function () {
			jQuery(document).trigger("styler:before:once_load");
			// jQuery("#elementor-panel-footer-responsive").find(".eicon-device-responsive").trigger("click");
			var DataInput = $btn.find('input[data-setting="' + $platform + $action + '"]');
			// WP Color Picker Default Color
			if (jQuery(".wp-picker-default").length) {
				jQuery(".wp-picker-default").bind("click", function (e) {
					e.preventDefault();
					jQuery(this).siblings("label").find("input.color-picker").val("").trigger("change");
					return false;
				});
			}

			// Remove Box Shadow
			jQuery(document).on("click", ".remove-box-shadow", function () {
				if (jQuery(".remove-box-shadow").length === 1) {
					jQuery(".styler-wrap .mlti-bx-sh-wrp").addClass("hidden");
					StylerCore.fix_scrollbar();
					jQuery(".styler-wrap .mlti-bx-sh-wrp")
						.find(".multi-box-shadow-color")
						.css("background", "");
					jQuery(".styler-wrap .mlti-bx-sh-wrp").find(".pcr-button").css("color", "transparent");
					jQuery(".styler-wrap .mlti-bx-sh-wrp input").each(function () {
						jQuery(this).val("");
					});
					jQuery('.styler-wrap input[name="box-shadow[x]"]')
						.val(jQuery('.styler-wrap input[name="box-shadow[x]"]').val())
						.trigger("input");
					return;
				}
				jQuery(this).parents(".multi-box-shadow").remove();
				jQuery('.styler-wrap input[name="box-shadow[x]"]')
					.val(jQuery('.styler-wrap input[name="box-shadow[x]"]').val())
					.trigger("input");
				StylerCore.fix_scrollbar();
			});
			var StyleDefaultColors = [
				"#000000",
				"#FFFFFF",
				"rgba(244, 67, 54, 1)",
				"rgba(233, 30, 99, 0.95)",
				"rgba(156, 39, 176, 0.9)",
				"rgba(103, 58, 183, 0.85)",
			];
			jQuery(document).on("click", ".kata-plus-color-picker-add-color", function () {
				var $this = $(this),
					$wrap = $this.closest(".pcr-swatches"),
					$items = $wrap.find(".pcr-swatch");

				jQuery(this).parents(".kata-plus-color-picker").find("input.pcr-save").trigger("click");
				setTimeout(function () {
					StyleDefaultColors.push($wrap.find(".pcr-swatch:last-child").css("color"));
					localStorage.setItem("PreDefineColors", JSON.stringify(StyleDefaultColors));
				}, 1000);
			});

			// Add Box Shadow
			jQuery(document).on("click", ".add-box-shadow", function () {
				if (jQuery(this).parent().hasClass("bxh-mini-wrp")) {
					if (jQuery(".styler-wrap .mlti-bx-sh-wrp").hasClass("hidden")) {
						jQuery(".styler-wrap .mlti-bx-sh-wrp").removeClass("hidden");
					}
					StylerCore.fix_scrollbar();
					return;
				}
				var $wrp = jQuery(this).parents(".multi-box-shadow").clone();
				var number = 1 + Math.floor(Math.random() * 500);
				$wrp.find(".pickr").after('<div class="color-picker-input"></div>');
				$wrp.find(".pickr").remove();
				var html = $wrp
					.html()
					.replace(/multi-box-shadow\[(.*?)\]/g, "multi-box-shadow[" + number + "]");
				jQuery(this)
					.parents(".multi-box-shadow")
					.after(
						'<div class="form-group multi-box-shadow remote bxsh-' +
							number +
							'">' +
							html +
							"</div>"
					);

				var $input = jQuery(".bxsh-" + number).find('.color-picker-wrap input[type="hidden"]');
				var $pickr_data_cloned = $pickr_data;
				$pickr_data_cloned.el = ".bxsh-" + number + " .color-picker-input";
				const newPicker = new Pickr($pickr_data_cloned);
				$pickers[number] = newPicker;
				newPicker
					.on("change", (instance) => {
						var $color = instance.toHEXA().toString(0).replace(/ /g, "");
						$input.val($color).trigger("input");
						if ($input.parents(".multi-box-shadow").length) {
							$input
								.parents(".multi-box-shadow")
								.find(".multi-box-shadow-color")
								.css("background", $color);
						}
						$input.siblings(".pickr").find("button").css("color", $color);
					})
					.on("clear", (instance) => {
						if ($input.parents(".multi-box-shadow").length) {
							$input
								.parents(".multi-box-shadow")
								.find(".multi-box-shadow-color")
								.css("background", "");
						}
						$input.val("").trigger("input");
					});
				StylerCore.fix_scrollbar();
			});

			// Process Units
			$dialog.find("*[data-units]").each(function () {
				var units = jQuery(this).data("units").split(",");
				var Unit = jQuery(this).data("unit") != "undefined" ? jQuery(this).data("unit") : "px";
				var output = '<div class="units-selector">';
				jQuery.each(units, function (index, unit) {
					if (unit == Unit) {
						output += '<span data-name="' + unit + '" class="active">' + unit + "</span>";
					} else {
						output += '<span data-name="' + unit + '">' + unit + "</span>";
					}
				});
				output += "</div>";
				if (jQuery(this).hasClass("inline-inputs")) {
					jQuery(this).append(output);
				} else {
					jQuery(this).after(output);
				}
			});

			console.log("Welcome To Kata Styler, Be Careful What You Do ;)");

			var KeyStepChanged = false;

			$(document).on("styler:before:load", function () {
				if ($dialog.hasClass("show")) {
					$elementor && $elementor.saveValue($btn.find("input"));
				}
			});

			// Important Button
			$(document).on("click", '.styler-wrap .kata-important-btn[data-task="important"]', function (e) {
				e.preventDefault();
				if (jQuery(this).hasClass("active")) {
					jQuery(this).removeClass("active");
				} else {
					jQuery(this).addClass("active");
				}
				var field = $(this).data("field");
				var trigger = $(this).data("trigger");
				if (typeof trigger != "undefined") {
					$dialog.find('[name="' + trigger + '"]').trigger("input");
				} else {
					$dialog.find('[name="' + field + '"]').trigger("input");
				}
			});

			$(".collapse-row .btn-cle").on("click", function () {
				if ($(this).parent().hasClass("show")) {
					$(this).parent().css("height", "10px");
					$(this).parent().removeClass("show");
				} else {
					$(this)
						.parent()
						.css("height", $(this).parent()[0].scrollHeight + 5 + "px");
					$(this).parent().addClass("show");
				}
			});

			// Use background color as color foreground
			$(document).on("input", "#use-background-color-as-color", function () {
				if ($(this).val() == "yes") {
					$(this).siblings('input[name="-webkit-background-clip"]').val("text");
					$(this)
						.siblings('input[name="-webkit-text-fill-color"]')
						.val("transparent")
						.trigger("input");
				} else {
					$(this).siblings('input[name="-webkit-background-clip"]').val("");
					$(this).siblings('input[name="-webkit-text-fill-color"]').val("").trigger("input");
				}
			});

			$(document).on("input change", 'input[name="-webkit-background-clip"]', function () {
				if ($(this).val() == "text") {
					$(this).siblings("#use-background-color-as-color").val("yes").trigger("input");
				} else {
					$(this).siblings("#use-background-color-as-color").val("no").trigger("input");
				}
			});

			// Wheel Input
			jQuery(".styler-wrap input[data-unit]").bind("mousewheel DOMMouseScroll", function (e) {
				e.preventDefault();
				if (!$(this).is(":focus")) {
					return;
				}

				if (
					(typeof e.originalEvent.wheelDelta != "undefined" &&
						e.originalEvent.wheelDelta / 120 > 0) ||
					(typeof e.originalEvent.deltaY != "undefined" && e.originalEvent.deltaY < 0)
				) {
					var val = jQuery(this).val();
					var num = parseFloat(val);
					var regex = new RegExp(num, "g");
					var txt = val.replace(regex, "");
					if (isNaN(num)) {
						num = 0;
					} else {
						num = Math.round((num + KeyStep) * 100) / 100;
					}

					jQuery(this)
						.val(num + txt)
						.trigger("input");
				} else {
					var val = jQuery(this).val();
					var num = parseFloat(val);
					var regex = new RegExp(num, "g");
					var txt = val.replace(regex, "");
					if (isNaN(num)) {
						num = 0;
					} else {
						num = Math.round((num - KeyStep) * 100) / 100;
					}
					jQuery(this)
						.val(num + txt)
						.trigger("input");
				}
				return false;
			});

			//
			jQuery(document).on("keydown", ".styler-wrap input[data-unit]", function (e) {
				var _rangeInput = jQuery(this).siblings(".range-wrap").find('input[type="range"]');
				if (_rangeInput.length) {
					if (typeof _rangeInput.attr("step") != "undefined") {
						KeyStep = parseFloat(_rangeInput.attr("step"));
						KeyStepChanged = true;
					}
				}
				switch (e.which) {
					case 16: // Shift
						KeyStep = 10;
						break;
					case 18: // Alt
						KeyStep = 0.1;
						break;
					case 17: // CTRL
						KeyStep = 100;
						break;
					case 38: // up
						var val = jQuery(this).val();
						var num = parseFloat(val);
						var regex = new RegExp(num, "g");
						var txt = val.replace(regex, "");
						if (isNaN(num)) {
							num = 0;
						} else {
							num = Math.round((num + KeyStep) * 100) / 100;
						}

						jQuery(this)
							.val(num + txt)
							.trigger("input");
						break;
					case 40: // down
						var val = jQuery(this).val();
						var num = parseFloat(val);
						var regex = new RegExp(num, "g");
						var txt = val.replace(regex, "");
						if (isNaN(num)) {
							num = 0;
						} else {
							num = Math.round((num - KeyStep) * 100) / 100;
						}
						jQuery(this)
							.val(num + txt)
							.trigger("input");
						break;
					default:
						return;
				}
				e.preventDefault();
			});

			jQuery(document).on("keyup", ".styler-wrap input[data-unit]", function (e) {
				switch (e.which) {
					case 16: // Shift
						KeyStep = 1;
						break;
					case 18: // Alt
						KeyStep = 1;
						break;
					case 17: // CTRL
						KeyStep = 1;
						break;
					case 38: // up
						if (KeyStepChanged === true) {
							KeyStepChanged = false;
							KeyStep = 1;
						}
						jQuery(this).trigger("input");
						break;
					case 40: // down
						if (KeyStepChanged === true) {
							KeyStepChanged = false;
							KeyStep = 1;
						}
						jQuery(this).trigger("input");
						break;
					default:
						KeyStep = 1;
						return;
				}
				e.preventDefault();
			});

			// More Menu
			$dialog.find(".more-menu-btn").on("click", function () {
				if ($dialog.find(".top-bar .actions-menu").css("display") == "block") {
					$dialog.find(".top-bar .actions-menu").css("display", "none");
					$dialog.find(".top-bar .actions-menu").attr("data-display", "none");
				} else {
					$dialog.find(".top-bar .actions-menu").attr("data-display", "block");
					$dialog.find(".top-bar .actions-menu").css("display", "block");
				}
			});

			jQuery(document).mouseup(function (e) {
				if (
					!jQuery(e.target).hasClass("selected-platform") &&
					!jQuery(e.target).parent().hasClass("selected-platform")
				) {
					var platformsContainer = $dialog.find(".top-bar .platforms");
					if (!platformsContainer.is(e.target) && platformsContainer.has(e.target).length === 0) {
						platformsContainer.css("display", "none");
						$dialog.find(".selected-platform").removeClass("active");
						$dialog.find(".selected-platform").attr("data-active", "deactive");
					}
				}

				if (
					!jQuery(e.target).hasClass("more-menu-btn") &&
					!jQuery(e.target).parent().hasClass("more-menu-btn")
				) {
					var moreMenuContainer = $dialog.find(".top-bar .actions-menu");
					if (!moreMenuContainer.is(e.target) && moreMenuContainer.has(e.target).length === 0) {
						$dialog.find(".top-bar .actions-menu").css("display", "none");
						$dialog.find(".top-bar .actions-menu").attr("data-display", "none");
					}
				}
			});

			// close Action
			$dialog.find(".actions-menu li").on("click", function () {
				var $this = $(this),
					$wrap = $this.closest(".actions-menu");
				$wrap.hide();
				$wrap.removeClass("active");
				$wrap.attr("data-display", "none");
			});
			$dialog.find(".platforms li").on("click", function () {
				var $this = $(this),
					$wrap = $this.closest(".platforms");
				$wrap.hide();
				$dialog.find(".selected-platform").removeClass("active");
				$dialog.find(".selected-platform").attr("data-active", "deactive");
			});
			// minimize Action
			$dialog.find(".top-bar .minimize").on("click", function () {
				var $this = $(this),
					$wrap = $this.closest(".styler-wrap");
				$wrap.toggleClass("active");
				$this.toggleClass("active");
				$wrap.find(".container").slideToggle("fast");
				setTimeout(() => {
					jQuery(".styler-wrap .content").getNiceScroll().resize();
					if ($this.hasClass("active")) {
						$this.attr("data-tooltip", "Restore");
					} else {
						$this.attr("data-tooltip", "Minimize");
					}
				}, 100);
			});

			// Copy Action
			$dialog.find(".top-bar .kata-copy").on("click", function () {
				$clipboard = {};
				$btn.find("input").each(function () {
					if ($(this).data("setting") != "citem" && $(this).data("setting") != "cid") {
						$clipboard[jQuery(this).data("setting")] = jQuery(this).val();
					}
				});

				localStorage.setItem("StylerCopiedStyles", JSON.stringify($clipboard));
				$clipboard = {};
				$dialog.find(".top-bar > strong").html($dialog.find(".top-bar > strong").html() + " - Styles have been copied!");
				setTimeout(function () {
					$dialog.find(".top-bar > strong").html((jQuery("#elementor-panel-header-title").length > 0 ? jQuery("#elementor-panel-header-title").html().replace("Edit ", "") : "") + " - " + $btn.data("title") );
				}, 1000);
			});

			// Pase Action
			$dialog.find(".top-bar .kata-paste").on("click", function () {
				var $this = $(this);
				$clipboard = JSON.parse(localStorage.getItem("StylerCopiedStyles"));
				jQuery.each($clipboard, function (key, value) {
					if ($this.data("setting") != "citem" && $this.data("setting") != "cid") {
						$btn.find('input[data-setting="' + key + '"]').val(value).trigger("input");
						$btn.find('input[data-setting="cid"]').trigger("styler_input");
					}
				});
				StylerCore.init($dialog, $btn, $elementor);

				$dialog.find(".top-bar > strong").html($dialog.find(".top-bar > strong").html() + " - Styles have been pasted!");
				setTimeout(function () {
					$dialog.find(".top-bar > strong").html((jQuery("#elementor-panel-header-title").length > 0 ? jQuery("#elementor-panel-header-title").html().replace("Edit ", "") : "") + " - " + $btn.data("title") );
				}, 1000);
			});

			// Reset Button
			$dialog.find(".top-bar .kata-reset").on("click", function () {
				$btn.find("input").each(function () {
					StylerCore.reset();
					if ($(this).data("setting") != "citem" && $(this).data("setting") != "cid") {
						jQuery(this).val("").trigger("input");
					}
				});

				StylerCore.init($dialog, $btn, $elementor);
				$dialog.find(".top-bar > strong").html($dialog.find(".top-bar > strong").html() + " - Styles have been reset!");
				setTimeout(function () {
					$dialog.find(".top-bar > strong").html( (jQuery("#elementor-panel-header-title").length > 0 ? jQuery("#elementor-panel-header-title").html().replace("Edit ", "") : "") + " - " + $btn.data("title") );
				}, 1000);

				$btn.find('input[data-setting="cid"]').trigger("styler_input");
			});

			// Unit Selector
			jQuery(document).on("click", ".styler-wrap .units-selector span", function () {
				var multiInput = false;
				if (jQuery(this).parent().parent().hasClass("inline-inputs")) {
					var input = jQuery(this).parent().parent().find("input");
					multiInput = true;
				} else {
					var input = jQuery(this).parent().siblings("input");
				}

				var unit = jQuery(this).data("name");
				input.data("unit", unit);

				if (unit == "%" && input.prev().hasClass("range-wrap")) {
					input.prev().find('[type="range"]').attr("max", "100");
					var val = input.val().replace("em", "").replace("px", "");
					if (val > 100) {
						input.val(100);
					}
				} else {
					input.prev().find('[type="range"]').attr("max", "500");
				}
				if (multiInput === true) {
					input.each(function () {
						if (jQuery(this).val()) {
							jQuery(this)
								.val(Math.round(parseFloat(jQuery(this).val()) * 100) / 100 + unit)
								.trigger("input");
						}
					});
				} else {
					if (input.val()) {
						input.val(Math.round(parseFloat(input.val()) * 100) / 100 + unit).trigger("input");
					}
				}

				jQuery(this).parent().find("span").removeClass("active");
				jQuery(this).addClass("active");
			});

			// Range slider
			$dialog.find('input[type="range"]').each(function () {
				if (typeof jQuery(this).attr("max") == "undefined") {
					jQuery(this).attr("max", 500);
				}
				jQuery(this).on("input", function () {
					var $range_input = jQuery(this).closest("label").children('input[type="text"]');
					var unit = "px";
					if (typeof $range_input.data("unit") !== "undefined") {
						unit = $range_input.data("unit") == "" ? "" : $range_input.data("unit");
					}
					$range_input.val(jQuery(this).val() + unit).trigger("input");
				});

				jQuery(this)
					.closest("label")
					.children("input")
					.on("input", function () {
						var $range_input = jQuery(this)
							.closest("label")
							.find(".range-wrap")
							.children('input[type="range"]');
						if (isNaN(Math.round(parseFloat(jQuery(this).val()) * 100) / 100)) {
							$range_input.val(0);
						} else {
							$range_input.val(Math.round(parseFloat(jQuery(this).val()) * 100) / 100);
						}
					});

				jQuery(this)
					.closest("label")
					.children("input")
					.on("change", function () {
						var $range_input = jQuery(this)
							.closest("label")
							.find(".range-wrap")
							.children('input[type="range"]');
						if (isNaN(Math.round(parseFloat(jQuery(this).val()) * 100) / 100)) {
							$range_input.val(0);
						} else {
							$range_input.val(Math.round(parseFloat(jQuery(this).val()) * 100) / 100);
						}
					});
			});

			// Background Position
			$dialog.find('form *[name="background-position"]').on("change", function () {
				if ($(this).val() == "custom") {
					$dialog.find(".background-position-custom-wrap").removeClass("hidden");
				} else {
					$dialog.find(".background-position-custom-wrap").addClass("hidden");
					$dialog.find(".background-position-custom-wrap input").val("").trigger("input");
				}
			});

			// Background Size
			$dialog.find('form *[name="background-size"]').on("change", function () {
				if ($(this).val() == "custom") {
					$dialog.find(".background-size-custom-wrap").removeClass("hidden");
				} else {
					$dialog.find(".background-size-custom-wrap").addClass("hidden");
					$dialog.find(".background-size-custom-wrap input").val("").trigger("input");
				}
			});

			// Left Side
			$dialog.find(".left-side li").each(function () {
				jQuery(this).removeClass("active");
			});
			$dialog.find(".left-side li").first().addClass("active");

			// Properties : Normal | Hover | Parent Hover | Before | After
			$dialog.find(".actions span").each(function () {
				jQuery(this).on("click", function () {
					if (typeof jQuery(this).attr("data-name") != "undefined") {
						$dontUpdate = true;
						$dialog.find(".actions span").each(function () {
							jQuery(this).removeClass("active");
						});
						jQuery(this).addClass("active");
						$action = jQuery(this).attr("data-name");
						DataInput = $btn.find('input[data-setting="' + $platform + $action + '"]');
						StylerCore.reset(false);

						if (DataInput.val().trim()) {
							var items = DataInput.val().trim().split(";");
							var placeholderItems = $btn
								.find('input[data-setting="' + $platform + "placeholder" + '"]')
								.val()
								.trim()
								.split(";");
							StylerCore.setupFormPlaceholder(placeholderItems);
							StylerCore.setupForm(items);
						}

						if ($action == "before" || $action == "after") {
							$dialog.find(".css-content-par").removeClass("hidden");
						} else {
							if (!$dialog.find(".css-content-par").hasClass("hidden")) {
								$dialog.find(".css-content-par").addClass("hidden");
							}
						}

						$dontUpdate = false;
					}
					StylerCore.fix_scrollbar();
				});
			});

			jQuery(document).on("click", "#elementor-panel-footer-responsive", function () {
				jQuery("#e-responsive-bar-switcher")
					.find(".e-responsive-bar-switcher__option")
					.each(function (index, element) {
						if (jQuery(this).prop("checked")) {
							$platform = jQuery(this).attr("value");
							jQuery(this).trigger("click");
						}
					});
			});

			jQuery(document).on("click", ".styler-dialog-btn", function () {
				setTimeout(function () {
					jQuery('[aria-selected="true"]').children('input[type="radio"]').trigger("click");
				}, 200);
			});

			// Actions | Desktop | Mobile | Tablet
			$dialog.find(".top-bar .platforms li").each(function () {
				jQuery(this).on("click", function () {
					// Fix responsive js error
					if (typeof $btn != "object") {
						return;
					}
					if (typeof jQuery(this).attr("data-name") != "undefined") {
						$platform = jQuery(this).attr("data-name");
						$dontUpdate = true;
						var i = jQuery(this).find("i");
						jQuery(this).parents(".platforms").siblings(".selected-platform").html(i.clone());

						$dialog.find(".top-bar .platforms li").each(function () {
							jQuery(this).removeClass("active");
						});
						jQuery(this).addClass("active");
						StylerCore.reset(false);
						// jQuery('.styler-wrap .platforms [data-name].active')
						var DataInput = $btn.find('input[data-setting="' + $platform + $action + '"]');
						if (DataInput.val()) {
							var items = DataInput.val().split(";");
							var placeholderItems = $btn.find('input[data-setting="' + $platform + "placeholder" + '"]').val().trim().split(";");
							StylerCore.setupFormPlaceholder(placeholderItems);
							StylerCore.setupForm(items);
						}
						if ($action == "before" || $action == "after") {
							$dialog.find(".css-content-par").removeClass("hidden");
						}

						$dontUpdate = false;
						if ($dontTrigger == false) {
							if (jQuery("#e-responsive-bar-switcher__option-" + $platform).length) {
								jQuery("#e-responsive-bar-switcher__option-" + $platform).trigger("click");
							}
						}
					}
					StylerCore.fix_scrollbar();
				});
			});

			// Platforms
			jQuery("#e-responsive-bar-switcher").find(".e-responsive-bar-switcher__option").on("click", function () {
				$dontTrigger = true;
				$dialog.find( '.top-bar .platforms li[data-name="' + jQuery(this).children('input[type="radio"]').attr("value") + '"]' ).trigger("click");
				$dontTrigger = false;
			});
			

			// Close
			$dialog.find(".top-bar span.close").on("click", function () {
				if (typeof elementor != "undefined") {
					$elementor && $elementor.saveValue($btn.find("input"));
					elementor.$previewContents
						.find(
							".elementor-element.elementor-element-edit-mode.elementor-widget .elementor-widget-container"
						)
						.each(function () {
							if (jQuery(this).children(":first").hasClass("ui-resizable")) {
								jQuery(this).children(":first").resizable("destroy");
								jQuery(this).children(":first").removeClass("ui-resizable");
							}
						});
				}
				jQuery(".styler-wrap").removeClass("show");
				jQuery(".styler-wrap").addClass("hidden");
			});

			// Color Picker
			if ($dialog.find(".color-picker").length) {
				$dialog.find(".color-picker").each(function () {
					jQuery(this).parents(".wp-picker-container").find(".wp-picker-clear").val("Clear");
				});
			}

			// Process Inputs
			jQuery(document).on("input", ".styler-wrap .content input", function () {
				if ($UpdateAction == true) {
					return;
				}

				$UpdateAction = true;

				setTimeout(() => {
					jQuery(this).trigger("finalChange");
					$UpdateAction = false;
				}, 250);
			});

			var timer;
			jQuery(document).on("finalChange", ".styler-wrap .content input", function () {
				if (typeof jQuery(this).data("unit") !== "undefined") {
					clearTimeout(timer);
					timer = setTimeout(
						function (f) {
							var val = jQuery(f).val().replace("-", "");
							val = val.replace(".", "");
							if ( !val.replace(/\d+/g, "") && !isNaN(parseInt(jQuery(f).val())) && jQuery(f).data("unit") ) {
								var unit = jQuery(f).data("unit") ? jQuery(f).data("unit") : "";
								jQuery(f).val(jQuery(f).val().toString() + unit).trigger("input");
							}
						},
					700, this );
				}
				if (typeof jQuery(this).parents(".inline-inputs").find(".connect-all") !== "undefined") {
					if (jQuery(this).parents(".inline-inputs").find(".connect-all").hasClass("active")) {
						jQuery(this)
							.parents(".inline-inputs")
							.find("input[type=text]")
							.val(jQuery(this).val())
							.trigger("change");
					}
				}
				StylerCore.process_data();
			});

			// jQuery(document).on("blur", ".styler-wrap .content input", function () {
			//     if (typeof jQuery(this).data("unit") !== "undefined") {
			//         if (!jQuery(this).val().replace(/\d+/g, "") && !isNaN(parseInt(jQuery(this).val()))) {
			//             jQuery(this).val(jQuery(this).val() + jQuery(this).data("unit")).trigger("input");
			//         }
			//     }
			//     if (typeof jQuery(this).parents(".inline-inputs").find(".connect-all") !== "undefined") {
			//         if (jQuery(this).parents(".inline-inputs").find(".connect-all").hasClass("active")) {
			//             jQuery(this).parents(".inline-inputs").find("input[type=text]").val(jQuery(this).val()).trigger("change");
			//         }
			//     }
			//     StylerCore.process_data();
			// });

			// Process SelectBoxes
			jQuery(document).on("input", ".styler-wrap .content select", function () {
				if ($UpdateAction == true) {
					return;
				}

				$UpdateAction = true;

				setTimeout(() => {
					jQuery(this).trigger("finalChange");
					$UpdateAction = false;
				}, 250);
			});

			jQuery(document).on("finalChange", ".styler-wrap .content select", function () {
				StylerCore.process_data();
			});

			// Process TextAreas
			jQuery(document).on("input", ".styler-wrap .content textarea", function () {
				if ($UpdateAction == true) {
					return;
				}

				$UpdateAction = true;

				setTimeout(() => {
					jQuery(this).trigger("finalChange");
					$UpdateAction = false;
				}, 250);
			});

			jQuery(document).on("finalChange", ".styler-wrap .content textarea", function () {
				StylerCore.process_data();
			});

			// Process Switcher
			$(document).on('click', '.switcher-wrap input[type="checkbox"]', function () {
				if ($(this).prop('checked')) {
					$(this).val('none');
				} else {
					$(this).val();
				}
			});

			// Custom Selects
			jQuery(".styler-wrap .custom-select span[data-name]").on("click", function () {
				var parent = jQuery(this).parent();
				if (jQuery(this).hasClass("active")) {
					jQuery(this).removeClass("active");
					parent.siblings('input[type="hidden"]').val("").trigger("input");
				} else {
					parent.find("span[data-name]").removeClass("active");
					jQuery(this).addClass("active");
					parent.siblings('input[type="hidden"]').val(jQuery(this).data("name")).trigger("input");
				}
			});
			jQuery(document).ready(function () {
				// Fix color picker changes in styler
				jQuery(".styler-wrap .color-picker-input").each(function () {
					if (typeof Pickr != "undefined") {
						var $input = jQuery(this).parents(".color-picker-wrap").find('input[type="hidden"]');
						// var $default = $input.val().trim() ? $input.val() : '#f7f8f9';
						// var PreDefineColors = ['#000000', '#FFFFFF', 'rgba(244, 67, 54, 1)', 'rgba(233, 30, 99, 0.95)', 'rgba(156, 39, 176, 0.9)', 'rgba(103, 58, 183, 0.85)'];
						var PreDefineColors = JSON.parse(localStorage.getItem("PreDefineColors"));
						if (typeof ElementorConfig == "object") {
							if (typeof ElementorConfig.schemes.items.color.items != "undefined") {
								var $swatches = ["#000000", "#FFFFFF"];
								jQuery.each(
									ElementorConfig.schemes.items.color.items,
									function (index, item) {
										$swatches[index + 1] = item.value;
									}
								);
							}
						}
						if (Array.isArray(PreDefineColors) && PreDefineColors[0] != "") {
							var $swatches = PreDefineColors;
						} else {
							var $swatches = [
								"#000000",
								"#FFFFFF",
								"rgba(244, 67, 54, 1)",
								"rgba(233, 30, 99, 0.95)",
								"rgba(156, 39, 176, 0.9)",
								"rgba(103, 58, 183, 0.85)",
							];
						}
						$pickr_data = {
							el: ".styler-wrap .color-picker-input",
							theme: "classic",
							// theme: 'monolith',
							position: "bottom-start",
							default: null,
							appClass: "kata-plus-color-picker",
							swatches: $swatches,
							components: {
								palette: true,
								preview: true,
								opacity: true,
								hue: true,
								interaction: {
									save: true,
									hex: true,
									rgba: true,
									cmyk: true,
									input: true,
									clear: true,
								},
							},
						};
						var number = 501 + Math.floor(Math.random() * 1000);
						const pickr = Pickr.create($pickr_data);
						$pickers[number] = pickr;
						pickr.on("change", (instance) => {
							var $color = instance.toHEXA().toString(0).replace(/ /g, "");
							$input.val($color).trigger("input");
							if ($input.parents(".multi-box-shadow").length) {
								$input.parents(".multi-box-shadow").find(".multi-box-shadow-color").css("background", $color);
							}
							$input.siblings(".pickr").find("button").css("color", $color);
						}).on("clear", (instance) => {
							if ($input.parents(".multi-box-shadow").length) {
								$input.parents(".multi-box-shadow").find(".multi-box-shadow-color").css("background", "");
							}
							$input.val("").trigger("input");
						}).on("save", (color, instance) => {
							if (color) {
								var $color = color.toHEXA().toString(0).replace(/ /g, "");
								var color_exists = false;
								jQuery.each(instance._swatchColors, function (i, v) {
									if (v.color.toHEXA() == $color) {
										color_exists = true;
									}
								});
								if (!color_exists) {
									instance.addSwatch($color);
								}
							} else {
								instance.setColor(null, true);
							}
						}).on("show", (color, instance) => {
							if ($input.val().trim()) {
								instance.setColor($input.val(), true);
							}
							$('.pcr-type[data-type="RGBA"]').on("click", function () {
								var rgba = $(".pcr-result").val();
								if (rgba) {
									rgba = rgba.replace("rgba(", "");
									rgba = rgba.replace(")", "");
									var ar = rgba.split(", ");
									ar[3] = parseFloat(ar[3]).toFixed(3);
									rgba = "rgba(" + ar.join(", ") + ")";
									$(".pcr-result").val(rgba);
								}
							});
						}).on("clear", (color, instance) => {
							instance.setColor(null, true);
						});
					} else {
						jQuery(this).wpColorPicker({
							defaultColor: true,
							change: function change(a) {
								setTimeout(function () {
									StylerCore.process_data();
								}, 100);
							},
							clear: function clear(a) {
								setTimeout(function () {
									StylerCore.process_data();
								}, 100);
							},
						});
					}
				});
			});

			jQuery(".styler-wrap .left-side li").each(function () {
				jQuery(this).on("click", function () {
					if (typeof jQuery(this).attr("data-name") != "undefined") {
						var name = jQuery(this).attr("data-name");
						jQuery(".styler-wrap .content .styler-tab").each(function () {
							jQuery(this).removeClass("active");
						});
						jQuery('.styler-wrap .content .styler-tab[data-name="' + name + '"]').addClass(
							"active"
						);

						jQuery(".styler-wrap .left-side li").each(function () {
							jQuery(this).removeClass("active");
						});
						jQuery(this).addClass("active");
						const container = document.querySelector(".styler-wrap .content");
						container.scrollTop = 0;
					}

					StylerCore.fix_scrollbar();
				});
			});

			// Mini - Full Version
			jQuery(".styler-wrap .mini-full").on("click", function () {
				if (jQuery(this).hasClass("active")) {
					jQuery(".styler-wrap").removeClass("mini");
					jQuery(this).removeClass("active");
				} else {
					jQuery(".styler-wrap").addClass("mini");
					jQuery(this).addClass("active");
				}
				jQuery(".styler-wrap .content").getNiceScroll().resize();
			});

			// Close Btn
			jQuery(".styler-wrap .button-cancel").on("click", function () {
				jQuery(".styler-wrap").removeClass("show");
				jQuery(".styler-wrap").addClass("hidden");
			});

			//  Connect All
			jQuery(document).on("click", ".styler-wrap .connect-all", function () {
				if (jQuery(this).hasClass("active")) {
					jQuery(this).removeClass("active");
				} else {
					jQuery(this).addClass("active");
				}
			});

			// Platforms
			jQuery(document).on("mousedown", ".selected-platform", function (e) {
				if (jQuery(".styler-wrap .platforms.kata-dropdown").css("display") != "none") {
					jQuery(".styler-wrap .platforms.kata-dropdown").css("display", "none");
					jQuery(this).removeClass("active");
					jQuery(this).attr("data-active", "deactive");
				} else {
					jQuery(".styler-wrap .platforms.kata-dropdown").css("display", "block");
					jQuery(this).addClass("active");
					jQuery(this).attr("data-active", "active");
				}
				e.preventDefault();
			});

			// Left Tabs
			jQuery(document).on("click", ".styler-wrap .styler-tabs-items span", function () {
				jQuery(this)
					.siblings("span")
					.each(function () {
						jQuery(this).removeClass("active");
					});

				jQuery(this).addClass("active");

				var name = jQuery(this).data("tab");

				setTimeout(function () {
					jQuery(".content").getNiceScroll().resize();
				}, 100);

				jQuery(this).parent().siblings(".styler-inner-tab").removeClass("active");
				jQuery(this)
					.parent()
					.siblings('.styler-inner-tab[data-name="' + name + '"]')
					.addClass("active");
				if (name == "normal") {
					$clipboard = jQuery("#styler-background-color2-option").val();
					jQuery(this).parent().data("clipboard", $clipboard);
					jQuery("#styler-background-color2-option").val("").trigger("input");
				} else if (name == "gradient") {
					$clipboard = jQuery(this).parent().data("clipboard");
					if (typeof $clipboard == "undefined") {
						$clipboard = "";
					}
					if ($clipboard && jQuery("#styler-background-color2-option").val() != $clipboard) {
						jQuery("#styler-background-color2-option").val($clipboard).trigger("input");
						jQuery(this).parent().data("clipboard", "");
					}
				}
			});

			jQuery(".styler-trash-btn").each(function () {
				var TrashBtn = jQuery(this);
				jQuery(this)
					.siblings(".styler-dialog-btn")
					.find('input[type="hidden"]')
					.each(function () {
						if (jQuery(this).val().trim()) {
							TrashBtn.removeClass("hidden");
						}
						jQuery(this).on("change", function () {
							TrashBtn.removeClass("hidden");
						});
					});
			});

			setTimeout(function () {
				// Draggable
				jQuery(".styler-wrap").draggable({
					handle: ".top-bar",
					stop: function () {
						if (jQuery(this).css("top") < "0") {
							jQuery(this).css("top", "0");
						}
					},
				});
			}, 1000);

			jQuery(document).trigger("styler:after:once_load");
		},

		load: function () {
			jQuery(document).trigger("styler:before:load");
			$platform = jQuery(".platforms.kata-dropdown").find("li.active").data("name");
			if (typeof $btn == "undefined") {
				alert(
					"we cannot identify on which Styler you clicked! Please click on the same Styler again."
				);
				return;
			}
			var DataInput = $btn.find('input[data-setting="' + $platform + $action + '"]');

			if (DataInput.val().trim()) {
				var items = DataInput.val().trim().split(";");
				var placeholderItems = $btn
					.find('input[data-setting="' + $platform + "placeholder" + '"]')
					.val()
					.trim()
					.split(";");
				this.setupFormPlaceholder(placeholderItems);
				this.setupForm(items);
			}

			if (!$loaded) {
				$loaded = true;
				this.once_load();
			}

			StylerCore.fix_scrollbar();
			$dialog.find(".container ").removeClass("loading");
			jQuery(document).trigger("styler:after:load");
		},

		/**
		 * Reset Data
		 *
		 * @since	1.0.0
		 */
		reset: function (DU = true) {
			if (DU) {
				$dontUpdate = true;
			}

			$dialog = jQuery(".styler-wrap");
			$dialog.find(".color-picker").val("").trigger("change").trigger("input");
			jQuery(".styler-wrap .mlti-bx-sh-wrp").addClass("hidden");
			jQuery(".styler-wrap .display-flex-options").addClass("hidden");
			$dialog.find('div.color-picker-wrap input[type="hidden"]').each(function () {
				if (jQuery(this).val().trim()) {
					jQuery(this).siblings(".pickr").find("button").css("color", jQuery(this).val());
				} else {
					jQuery(this).siblings(".pickr").find("button").css("color", "transparent");
				}
			});

			jQuery(".styler-wrap .multi-box-shadow.remote").each(function () {
				if (jQuery(".styler-wrap .multi-box-shadow").length > 1) {
					jQuery(this).remove();
				}
			});

			$dialog.find("input").not('[type="button"]').val("");
			$dialog.find("form").trigger("reset");
			$dialog.find('input[type="range"]').each(function () {
				jQuery(this).prop("value", 0);
			});

			$dialog.find('.kata-important-btn[data-task="important"]').removeClass("active");
			$dialog.find(".image-container").css("background-image", "").find(".remove").addClass("hidden");
			$dialog.find(".custom-select").each(function () {
				jQuery(this).find("span").removeClass("active");
			});

			if (jQuery(".wp-picker-clear").length) {
				$dialog.find(".wp-picker-clear").each(function () {
					$(this).trigger("click");
				});
			}

			if (DU) {
				$dontUpdate = false;
			}
		},

		/**
		 * Fix Scrollbar
		 *
		 * @since	1.0.0
		 */
		fix_scrollbar: function () {
			$dialog.find(".content").getNiceScroll().show();
			$dialog.find(".content").getNiceScroll().resize();
		},

		/**
		 * Destroy Styler
		 *
		 * @since	1.0.0
		 */
		destroy: function () {
			if ($dialog) {
				jQuery.each($pickers, function (key, picker) {
					picker.hide();
				});
				$elementor && $elementor.saveValue($btn.find("input"));
				elementor.$previewContents
					.find(
						".elementor-element.elementor-element-edit-mode.elementor-widget .elementor-widget-container"
					)
					.each(function () {
						if (jQuery(this).hasClass("ui-resizable")) {
							jQuery(this).children(":first").resizable("destroy");
						}
					});
				jQuery(".styler-wrap").removeClass("show");
				jQuery(".styler-wrap").addClass("hidden");
				this.reset();
			}
			$btn = "";
			$elementor = "";
			$action = "";
		},

		/**
		 * Styler Settings
		 *
		 * @since	1.0.0
		 */
		StylerSettings: function (Dialog, cid) {
			if (!localStorage.getItem(cid)) {
				var fields = {};
				fields.cid = cid;
				fields.margin = fields.padding = fields.border = fields.border_radius = fields.width = false;
				localStorage.setItem(cid, JSON.stringify(fields));
			}
			if (localStorage.getItem(cid)) {
				if (typeof localStorage.getItem(cid) == "string") {
					fields = JSON.parse(localStorage.getItem(cid));
				}
			}
			if (typeof fields != "object") {
				return;
			}
			/**
			 * Padding & Margin Connect All Field Button
			 */
			Dialog.find(".connect-all").on("click", function () {
				if (cid !== CURRENTCID) {
					return;
				}
				var $this = $(this),
					$controlWrapper = $this.closest(".group-input"),
					control = $controlWrapper.data("name");

				setTimeout(() => {
					if ($this.hasClass("active")) {
						fields[control] = true;
					} else {
						fields[control] = false;
					}
					localStorage.setItem(cid, JSON.stringify(fields));
				}, 200);
			});

			/**
			 * Range Sliders Suffix
			 */
			Dialog.find(".units-selector")
				.children("span")
				.on("click", function () {
					if (cid !== CURRENTCID) {
						return;
					}
					var $this = $(this),
						$wrap = $this.closest(".units-selector"),
						option = $wrap.prev().attr("name"),
						data = $this.data("name");

					setTimeout(() => {
						fields[option] = data;
						localStorage.setItem(cid, JSON.stringify(fields));
					}, 200);
				});
		},

		/**
		 * Setup PlaceHolder
		 *
		 * @since	1.0.0
		 */
		setupFormPlaceholder: function (items) {
			$dontUpdate = true;
			jQuery.each(items, (index, item) => {
				item = item.split(/:(?![^(]*\))(?![^"']*["'](?:[^"']*["'][^"']*["'])*[^"']*$)|;/g);
				var important = false;
				if (typeof item[1] != "undefined" && item[1].indexOf("!important") > -1) {
					important = true;
					item[1] = item[1].replace(" !important", "");
					$dialog.find('.kata-important-btn[data-field="' + item[0] + '"]').addClass("active");
				}

				if (item[0] == "color") {
					$dialog.find('form *[name="placeholder-color"]').val(item[1].trim()).trigger("change");
				}
			});
			$dontUpdate = false;
		},

		/**
		 * Setup Styler Data
		 *
		 * @since	1.0.0
		 */
		setupForm: function (items) {
			$dontUpdate = true;
			$dialog.find('.styler-tabs-items span[data-tab="normal"]').addClass("active");
			$dialog.find('.styler-tabs-items span[data-tab="gradient"]').removeClass("active");
			$dialog.find('.styler-inner-tab[data-name="normal"]').addClass("active");
			$dialog.find('.styler-inner-tab[data-name="gradient"]').removeClass("active");
			$dialog.find(".css-content-par").addClass("hidden");
			jQuery.each(items, (index, item) => {
				item = item.split(/:(?![^(]*\))(?![^"']*["'](?:[^"']*["'][^"']*["'])*[^"']*$)|;/g);
				var important = false;
				if (typeof item[1] != "undefined" && item[1].indexOf("!important") > -1) {
					important = true;
					item[1] = item[1].replace(" !important", "");
					$dialog.find('.kata-important-btn[data-field="' + item[0] + '"]').addClass("active");
				}

				if (item[0] == "display" && item[1] == "flex") {
					if (item[1] == "flex" || item[1] == "inline-flex") {
						jQuery(".styler-wrap .display-flex-options").removeClass("hidden");
					} else {
						jQuery(".styler-wrap .display-flex-options").addClass("hidden");
					}
				}
				if (item[0] == "background-image" && item[1] == "none") {
					if ( item[1].indexOf("none") >= 0 ) {
						$dialog.find('.switcher-wrap input[type="checkbox"]').val(item[1]);
						$dialog.find('.switcher-wrap input[type="checkbox"][value="none"]').trigger('click');
					}
				}
				if (item[0] == "background-image") {
					if (item[1].indexOf("url") >= 0 && item[1].indexOf(")") >= 0) {
						var url = item[1].split("url(")[1].split(")")[0];

						$dialog
							.find('form *[name="' + item[0] + '"]')
							.siblings(".image-container")
							.find(".remove")
							.removeClass("hidden");
						$dialog
							.find('form *[name="' + item[0] + '"]')
							.siblings(".image-container")
							.css("background-image", "url(" + url + ")");
						$dialog.find('form *[name="' + item[0] + '"]').val(url);
					}

					if (item[1].indexOf("gradient") >= 0) {
						var lg = item[1].match(/linear-gradient\((.*)\)/);
						item[1] = lg[1].match(/rgba\(.*?\)|#\w+|\w+\s\w+|\w+|-\w+/g);

						jQuery.each(item[1], function (index, val) {
							if (index == 0) {
								$dialog.find('form *[name="angel"]').val(val);
							} else {
								if (index === 1) {
									index = "";
								}
								$dialog.find('form *[name="background-color' + index + '"]').val(val);
							}
						});
						$dialog.find('.styler-tabs-items span[data-tab="normal"]').removeClass("active");
						$dialog.find('.styler-tabs-items span[data-tab="gradient"]').addClass("active");
						$dialog.find('.styler-inner-tab[data-name="normal"]').removeClass("active");
						$dialog.find('.styler-inner-tab[data-name="gradient"]').addClass("active");
					}
				} else if (item[0] == "-webkit-background-clip") {
					if (item[1] == "text") {
						$("#use-background-color-as-color").val("yes");
					} else {
						$("#use-background-color-as-color").val("no");
					}
					$dialog.find('form *[name="' + item[0] + '"]').val(item[1]);
				} else if (item[0] == "placeholder-color") {
					// $dialog.find('form *[name="' + item[0] + '"]').val(item[1]);
				} else if (item[0] == "background-position") {
					var BackgroundPositions = {
						"left top": 1,
						"left center": 1,
						"left bottom": 1,
						"right top": 1,
						"right center": 1,
						"right bottom": 1,
						"center top": 1,
						"center center": 1,
						"center bottom": 1,
					};

					if (typeof BackgroundPositions[item[1]] != "undefined") {
						$dialog.find('form *[name="' + item[0] + '"]').val(item[1]);
					} else {
						var positions = item[1].indexOf("calc") >= 0 ? item[1] : item[1].split(" ");
						$dialog.find(".background-position-custom-wrap").removeClass("hidden");
						$dialog.find('form *[name="background-position"]').val("custom");
						if (item[1].indexOf("calc") >= 0) {
							$dialog.find('form *[name="background-position-x"]').val(positions);
						} else {
							$dialog.find('form *[name="background-position-x"]').val(positions[0]);
							$dialog.find('form *[name="background-position-y"]').val(positions[1]);
						}
					}
				} else if (item[0] == "background-size") {
					var BackgroundSizes = {
						"": 1,
						"auto": 1,
						"cover": 1,
						"contain": 1,
						"inherit": 1,
						"initial": 1,
					};
					if (typeof BackgroundSizes[item[1]] != "undefined") {
						$dialog.find('form *[name="' + item[0] + '"]').val(item[1]);
					} else {
						var Sizes = item[1].split(" ");
						$dialog.find(".background-size-custom-wrap").removeClass("hidden");
						$dialog.find('form *[name="background-size"]').val("custom");
						$dialog.find('form *[name="background-size-x"]').val(Sizes[0]);
						$dialog.find('form *[name="background-size-y"]').val(Sizes[1]);
					}
				} else if (item[0] == "backdrop-filter") {
					var filters = item[1].split(" ");
					jQuery.each(filters, (index, item) => {
						var filter = item.split("(");
						filter[1] = filter[1].replace(")", "");
						$dialog.find('form *[name="backdrop-filter\\[' + filter[0] + '\\]"]').val(filter[1]);
					});
				} else if (item[0] == "filter") {
					var filters = item[1].split(" ");
					jQuery.each(filters, (index, item) => {
						var filter = item.split("(");
						filter[1] = filter[1].replace(")", "");
						$dialog.find('form *[name="filter\\[' + filter[0] + '\\]"]').val(filter[1]);
					});
				} else if (item[0] == "transform") {
					var transforms = item[1].split(") ");
					jQuery.each(transforms, (index, item) => {
						var transform = item.split("(");
						transform[1] = transform[1].replace(")", "");
						if (transform[0] == "translate") {
							transform[1] = transform[1].split(",");
							$dialog
								.find('form *[name="f_transform\\[translate-x\\]"]')
								.val(transform[1][0].trim());
							$dialog
								.find('form *[name="f_transform\\[translate-y\\]"]')
								.val(transform[1][1].trim());
						} else if (transform[0] == "skew") {
							transform[1] = transform[1].split(",");
							$dialog
								.find('form *[name="f_transform\\[skew-x\\]"]')
								.val(transform[1][0].trim());
							$dialog
								.find('form *[name="f_transform\\[skew-y\\]"]')
								.val(transform[1][1].trim());
						} else {
							$dialog
								.find('form *[name="f_transform\\[' + transform[0] + '\\]"]')
								.val(transform[1].trim());
						}
					});
				} else if (item[0] == "box-shadow") {
					if (jQuery.trim(item[1]).search(",") > 0) {
						var RGBAColors = item[1].match(/([rgb|rgba].*?\(.*?\).*?)/g);
						if (RGBAColors) {
							jQuery.each(RGBAColors, function (index, color) {
								var hexColor = StylerCore.rgbA_to_hexA(color);
								item[1] = item[1].replace(color, hexColor);
							});
						}

						var MultiBoxShadow = jQuery.trim(item[1]).split(",");
						var boxShadow = jQuery.trim(MultiBoxShadow[0]).split(" ");

						$dialog.find('form *[name="box-shadow\\[x\\]"]').val(boxShadow[0]);
						$dialog.find('form *[name="box-shadow\\[y\\]"]').val(boxShadow[1]);

						if (boxShadow.length > 4) {
							$dialog.find('form *[name="box-shadow\\[blur\\]"]').val(boxShadow[2]);
							$dialog.find('form *[name="box-shadow\\[spread\\]"]').val(boxShadow[3]);
							$dialog.find('form *[name="box-shadow\\[color\\]"]').val(boxShadow[4]);
						} else {
							$dialog.find('form *[name="box-shadow\\[blur\\]"]').val(boxShadow[2]);
							$dialog.find('form *[name="box-shadow\\[spread\\]"]').val("");
							$dialog.find('form *[name="box-shadow\\[color\\]"]').val(boxShadow[3]);
						}

						jQuery.each(MultiBoxShadow, function (index, value) {
							if (index !== 0) {
								if (index === 1) {
									var number = "first";
								} else {
									var $wrp = jQuery(".styler-wrap .multi-box-shadow").first().clone();
									$wrp.find(".pickr").after('<div class="color-picker-input"></div>');
									$wrp.find(".pickr").remove();
									var number = 1 + Math.floor(Math.random() * 500);
									var html = $wrp
										.html()
										.replace(
											/multi-box-shadow\[(.*?)\]/g,
											"multi-box-shadow[" + number + "]"
										);
									jQuery(".styler-wrap .multi-box-shadow")
										.last()
										.after(
											'<div class="form-group multi-box-shadow remote bxsh-' +
												number +
												'">' +
												html +
												"</div>"
										);

									var $input = jQuery(".bxsh-" + number).find(
										'.color-picker-wrap input[type="hidden"]'
									);
									if (!$pickr_data) {
										var boxShadow = jQuery.trim(value).split(" ");
										var $swatches = [
											"#000000",
											"#FFFFFF",
											"rgba(244, 67, 54, 1)",
											"rgba(233, 30, 99, 0.95)",
											"rgba(156, 39, 176, 0.9)",
											"rgba(103, 58, 183, 0.85)",
										];
										if (typeof ElementorConfig != "undefined") {
											if (
												typeof ElementorConfig.schemes.items.color.items !=
												"undefined"
											) {
												$swatches = ["#000000", "#FFFFFF"];
												jQuery.each(
													ElementorConfig.schemes.items.color.items,
													function (index, item) {
														$swatches[index + 1] = item.value;
													}
												);
											}
										}
										var $defaultColor = "";
										if (boxShadow[4] == "inset") {
											$defaultColor = boxShadow[3];
										} else if (boxShadow[5] == "inset") {
											$defaultColor = boxShadow[4];
										} else if (boxShadow.length > 4) {
											$defaultColor = boxShadow[4];
										} else {
											$defaultColor = boxShadow[3];
										}
										$pickr_data = {
											el: ".styler-wrap .color-picker-input",
											theme: "classic",
											// theme: 'monolith',
											position: "bottom-start",
											default: $defaultColor,
											appClass: "kata-plus-color-picker",
											swatches: $swatches,
											components: {
												palette: true,
												preview: true,
												opacity: true,
												hue: true,
												interaction: {
													save: true,
													hex: true,
													rgba: true,
													cmyk: true,
													input: true,
													clear: true,
												},
											},
										};
									}
									var $pickr_data_cloned = $pickr_data;
									$pickr_data_cloned.el = ".bxsh-" + number + " .color-picker-input";
									const newPicker = new Pickr($pickr_data_cloned);
									$pickers[number] = newPicker;
									$dialog = jQuery(".styler-wrap");
									newPicker
										.on("change", (instance) => {
											var $color = instance.toHEXA().toString(0).replace(/ /g, "");
											$input.val($color).trigger("input");
											if ($input.parents(".multi-box-shadow").length) {
												$input
													.parents(".multi-box-shadow")
													.find(".multi-box-shadow-color")
													.css("background", $color);
											}
											$input.siblings(".pickr").find("button").css("color", $color);
										})
										.on("save", (color, instance) => {
											if (color) {
												var $color = color.toHEXA().toString(0).replace(/ /g, "");
												var color_exists = false;
												jQuery.each(instance._swatchColors, function (i, v) {
													if (v.color.toHEXA() == $color) {
														color_exists = true;
													}
												});
												if (!color_exists) {
													instance.addSwatch($color);
												}
											} else {
												instance.setColor(null, true);
											}
										})
										.on("clear", (instance) => {
											if ($input.parents(".multi-box-shadow").length) {
												$input
													.parents(".multi-box-shadow")
													.find(".multi-box-shadow-color")
													.css("background", "");
											}
											$input.val("").trigger("input");
										});
								}

								var boxShadow = jQuery.trim(value).split(" ");
								var $defaultColor = "";
								if (boxShadow[4] == "inset") {
									$defaultColor = boxShadow[3];
								} else if (boxShadow[5] == "inset") {
									$defaultColor = boxShadow[4];
								} else if (boxShadow.length > 4) {
									$defaultColor = boxShadow[4];
								} else {
									$defaultColor = boxShadow[3];
								}

								jQuery(".styler-wrap")
									.find(".multi-box-shadow.bxsh-" + number + " .multi-box-shadow-color")
									.css("background", $defaultColor);
								jQuery(".styler-wrap")
									.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[x\\]"]')
									.val(boxShadow[0]);
								jQuery(".styler-wrap")
									.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[y\\]"]')
									.val(boxShadow[1]);

								if (boxShadow[4] == "inset") {
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[blur\\]"]')
										.val(boxShadow[2]);
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[spread\\]"]'
										)
										.val("");
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[color\\]"]'
										)
										.val($defaultColor);
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[mode\\]"]')
										.val(boxShadow[4]);
								} else if (boxShadow[5] == "inset") {
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[blur\\]"]')
										.val(boxShadow[2]);
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[spread\\]"]'
										)
										.val(boxShadow[3]);
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[color\\]"]'
										)
										.val($defaultColor);
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[mode\\]"]')
										.val(boxShadow[5]);
								} else if (boxShadow.length > 4) {
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[blur\\]"]')
										.val(boxShadow[2]);
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[spread\\]"]'
										)
										.val(boxShadow[3]);
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[color\\]"]'
										)
										.val($defaultColor);
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[mode\\]"]')
										.val("");
								} else {
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[blur\\]"]')
										.val(boxShadow[2]);
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[spread\\]"]'
										)
										.val("");
									jQuery(".styler-wrap")
										.find(
											'form *[name="multi-box-shadow\\[' + number + '\\]\\[color\\]"]'
										)
										.val($defaultColor);
									jQuery(".styler-wrap")
										.find('form *[name="multi-box-shadow\\[' + number + '\\]\\[mode\\]"]')
										.val("");
								}
							}
						});
						jQuery(".styler-wrap .mlti-bx-sh-wrp").removeClass("hidden");
					} else {
						var boxShadow = jQuery.trim(item[1]).split(" ");
						$dialog.find('form *[name="box-shadow\\[x\\]"]').val(boxShadow[0]);
						$dialog.find('form *[name="box-shadow\\[y\\]"]').val(boxShadow[1]);

						if (boxShadow.length > 4) {
							$dialog.find('form *[name="box-shadow\\[blur\\]"]').val(boxShadow[2]);
							$dialog.find('form *[name="box-shadow\\[spread\\]"]').val(boxShadow[3]);
							$dialog.find('form *[name="box-shadow\\[color\\]"]').val(boxShadow[4]);
						} else {
							$dialog.find('form *[name="box-shadow\\[blur\\]"]').val(boxShadow[2]);
							$dialog.find('form *[name="box-shadow\\[spread\\]"]').val("");
							$dialog.find('form *[name="box-shadow\\[color\\]"]').val(boxShadow[3]);
						}
					}
				} else if (item[0] == "content") {
					item[1] = item[1].replace(/\"/g, "");
					$dialog.find('form *[name="' + item[0] + '"]').val(item[1]);
				} else if (item[0] == "font-family") {
					// item[1] = item[1].replace(/\"/g, '');
					$dialog.find('form *[name="' + item[0] + '"]').val(item[1]);
				} else {
					$dialog.find('form *[name="' + item[0] + '"]').val(item[1]);
				}
				// $btn.find('input[data-setting="cid"]').trigger('styler_input');
			});

			jQuery('.styler-wrap input[type="range"]').each(function () {
				var val = jQuery(this).parent().siblings("input").val();
				val = val.trim() ? val : 0;
				jQuery(this).prop("value", Math.round(parseFloat(val) * 100) / 100);
			});

			if ($action == "before" || $action == "after") {
				$dialog.find(".css-content-par").removeClass("hidden");
			} else {
				$dialog.find(".css-content-par").addClass("hidden");
			}
			$dialog.find(".units-selector").each(function () {
				var multiInput = false;
				var unitsSelector = jQuery(this);
				if (jQuery(this).parent().hasClass("inline-inputs")) {
					var input = jQuery(this).parent().find("input");
					multiInput = true;
				} else {
					var input = jQuery(this).siblings("input");
				}
				if (multiInput === true) {
					input.each(function () {
						var inputUnit = jQuery(this).val()
							? jQuery(this).val().replace(/\d+/g, "")
							: jQuery(this).data("unit");
						if (inputUnit) {
							unitsSelector.find("[data-name]").removeClass("active");
							unitsSelector.find('[data-name="' + inputUnit + '"]').addClass("active");
						}
					});
				} else {
					var inputUnit = input.val() ? input.val().replace(/\d+/g, "") : input.data("unit");
					if (inputUnit) {
						unitsSelector.find("[data-name]").removeClass("active");
						unitsSelector.find('[data-name="' + inputUnit + '"]').addClass("active");
					}
				}
			});

			if (localStorage.getItem($btn.data("cid"))) {
				if (localStorage.getItem($btn.data("cid")).indexOf("object") > 0) {
					var fields = {};
					fields.cid = $btn.data("cid");
					fields.margin = fields.padding = fields.border = fields.border_radius = false;
					localStorage.setItem($btn.data("cid"), JSON.stringify(fields));
				}
			}

			/**
			 * Default Settings
			 */
			var $settings = JSON.parse(localStorage.getItem($btn.data("cid")));
			if ($settings) {
				/**
				 * Connect All
				 */
				if ($settings.margin) {
					if (
						!$dialog
							.find('.group-input[data-name="margin"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="margin"]')
							.find(".connect-all")
							.addClass("active");
					}
				} else {
					if (
						$dialog
							.find('.group-input[data-name="margin"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="margin"]')
							.find(".connect-all")
							.removeClass("active");
					}
				}
				if ($settings.padding) {
					if (
						!$dialog
							.find('.group-input[data-name="padding"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="padding"]')
							.find(".connect-all")
							.addClass("active");
					}
				} else {
					if (
						$dialog
							.find('.group-input[data-name="padding"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="padding"]')
							.find(".connect-all")
							.removeClass("active");
					}
				}
				if ($settings.border) {
					if (
						!$dialog
							.find('.group-input[data-name="border"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="border"]')
							.find(".connect-all")
							.addClass("active");
					}
				} else {
					if (
						$dialog
							.find('.group-input[data-name="border"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="border"]')
							.find(".connect-all")
							.removeClass("active");
					}
				}
				if ($settings.border_radius) {
					if (
						!$dialog
							.find('.group-input[data-name="border-radius"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="border-radius"]')
							.find(".connect-all")
							.addClass("active");
					}
				} else {
					if (
						$dialog
							.find('.group-input[data-name="border-radius"]')
							.find(".connect-all")
							.hasClass("active")
					) {
						$dialog
							.find('.group-input[data-name="border-radius"]')
							.find(".connect-all")
							.removeClass("active");
					}
				}
				/**
				 * Renge Slider Suffix
				 */
				if ($settings["width"]) {
					$dialog
						.find('input[name="width"]')
						.next(".units-selector")
						.children('[data-name="' + $settings["min-width"] + '"]')
						.trigger("click");
				}
				if ($settings["min-width"]) {
					$dialog
						.find('input[name="min-width"]')
						.next(".units-selector")
						.children('[data-name="' + $settings["min-width"] + '"]')
						.trigger("click");
				}
				if ($settings["max-width"]) {
					$dialog
						.find('input[name="max-width"]')
						.next(".units-selector")
						.children('[data-name="' + $settings["max-width"] + '"]')
						.trigger("click");
				}
				if ($settings["height"]) {
					$dialog
						.find('input[name="height"]')
						.next(".units-selector")
						.children('[data-name="' + $settings["height"] + '"]')
						.trigger("click");
				}
				if ($settings["min-height"]) {
					$dialog
						.find('input[name="min-height"]')
						.next(".units-selector")
						.children('[data-name="' + $settings["min-height"] + '"]')
						.trigger("click");
				}
				if ($settings["max-height"]) {
					$dialog
						.find('input[name="max-height"]')
						.next(".units-selector")
						.children('[data-name="' + $settings["max-height"] + '"]')
						.trigger("click");
				}
			}

			setTimeout(function () {
				jQuery(".styler-wrap .color-picker").each(function () {
					if (jQuery(this).val()) {
						jQuery(this).siblings(".pickr").find("button").css("color", jQuery(this).val());
					}
				});
			}, 500);

			jQuery(document).on("click", ".pcr-result", function () {
				jQuery(this).select();
			});

			// Custom Selects
			jQuery(".styler-wrap .custom-select").each(function () {
				var input = jQuery(this).siblings('input[type="hidden"]').first();
				jQuery(this).find("span[data-name]").removeClass("active");
				if (input.val()) {
					jQuery(this)
						.find('span[data-name="' + input.val() + '"]')
						.addClass("active");
				}
			});

			this.fix_scrollbar();
			$dontUpdate = false;
		}, // Setup Form

		/**
		 * Process Data to save
		 *
		 * @since	1.0.0
		 */
		process_data: function () {
			if (typeof $btn == "undefined") {
				return false;
			}
			if ($dontUpdate === true) {
				return false;
			}
			$serialized_data = jQuery(".styler-wrap .content").serializeArray();
			var $inline_style = "";
			if (typeof $btn == "undefined" || !$btn) {
				return;
			}
			$platform = jQuery(".platforms.kata-dropdown").find("li.active").data("name");
			var DataInput = $btn.find('input[data-setting="' + $platform + $action + '"]');
			$data = {};
			jQuery.each($serialized_data, function (i, field) {
				if (jQuery.trim(field.value)) {
					$data[field.name] = field.value;
				}
			});

			if ($action == "before" || $action == "after") {
				if (typeof $data["content"] != "undefined") {
					$data["content"] = $data["content"].replace(/"/g, "");
					$data["content"] = $data["content"].replace(/'/g, "");
					$data["content"] = $data["content"].replace(/[\\]/g, "");
					if ($data["content"].indexOf('"') < 0) {
						$data["content"] = "'" + $data["content"] + "'";
					}
				} else if (Object.keys($data).length >= 1) {
					$data["content"] = "''";
				} else {
					$data["content"] = "";
				}
			}

			var boxShadow = false;
			jQuery.each($data, function (field_name, field_value) {
				var importantBtn = $('.kata-important-btn[data-field="' + field_name + '"]');
				if (importantBtn.length == 0) {
					importantBtn = $('.kata-important-btn[data-trigger="' + field_name + '"]');
				}
				var important = "";
				if (importantBtn.length && importantBtn.hasClass("active")) {
					important = " !important";
				}

				if (field_name.indexOf("display") >= 0) {
					if (field_value == "flex" || field_value == "inline-flex") {
						jQuery(".styler-wrap .display-flex-options").removeClass("hidden");
					} else {
						jQuery(".styler-wrap .display-flex-options").addClass("hidden");
					}
					StylerCore.fix_scrollbar();
				}

				// animation
				if ( field_name == "animation-name" ) {
					if ( field_value ) {
						let InputRange = jQuery('.animation-duration').find('input[type="range"]').val();
						let InputRangeVal = jQuery('.animation-duration').find('input[name="animation-duration"]').val();
						let TriggerVal = jQuery('[name="--triggeranimation"] :selected').val();
						if ( InputRangeVal == '' ) {
							jQuery('.animation-duration').find('input[type="range"]').val('1000');
							jQuery('.animation-duration').find('input[name="animation-duration"]').val('1000ms');
						}
						if ( TriggerVal == '' ) {
							jQuery('[name="--triggeranimation"] option[value="onscreen"]').prop('selected', true);
							jQuery('[name="--triggeranimation"] :selected').val('onscreen');
						}
						$inline_style = $inline_style + '--triggeranimation:onscreen;animation-duration:1000ms;';
					}
				}

				if (field_name.indexOf("box-shadow") >= 0) {
					if (
						boxShadow == false &&
						typeof $data["box-shadow[x]"] != "undefined" &&
						typeof $data["box-shadow[y]"] != "undefined" &&
						typeof $data["box-shadow[blur]"] != "undefined"
					) {
						if (typeof $data["box-shadow[mode]"] == "undefined") {
							$data["box-shadow[mode]"] = " ";
						}
						if (typeof $data["box-shadow[color]"] == "undefined") {
							$data["box-shadow[color]"] = " ";
						}

						var multiBoxShadow = "";
						var multiBoxShadowObj = {};
						var counter = {};
						var counterID = 0;
						jQuery( '.styler-wrap input[name^="multi-box-shadow"], .styler-wrap select[name^="multi-box-shadow"]' ).each(function (i) {
							var name = jQuery(this).attr("name");
							name = name.replace(/multi-box-shadow\[(.*?)\].*/g, "$1");
							var index = jQuery(this)
								.attr("name")
								.replace(/multi-box-shadow\[(.*?)\]\[(.*?)\]/g, "$2");
							if (typeof counter[name] == "undefined") {
								counter[name] = counterID;
								counterID++;
							}

							if (typeof multiBoxShadowObj[counter[name]] == "undefined") {
								multiBoxShadowObj[counter[name]] = {};
							}
							multiBoxShadowObj[counter[name]][index] = jQuery(this).val();
						});

						jQuery.each(multiBoxShadowObj, function (index, value) {
							if (value.x && value.y && value.blur && value.color) {
								if (typeof value.mode == "undefined" || value.mode == null) {
									value.mode = "";
								}
								if (value.spread) {
									multiBoxShadow =
										multiBoxShadow +
										", " +
										value.x +
										" " +
										value.y +
										" " +
										value.blur +
										" " +
										value.spread +
										" " +
										value.color +
										" " +
										value.mode;
								} else {
									multiBoxShadow =
										multiBoxShadow +
										", " +
										value.x +
										" " +
										value.y +
										" " +
										value.blur +
										" " +
										value.color +
										" " +
										value.mode;
								}
							}
						});
						if (typeof $data["box-shadow[spread]"] != "undefined") {
							$inline_style =
								$inline_style +
								"box-shadow:" +
								" " +
								$data["box-shadow[x]"] +
								" " +
								$data["box-shadow[y]"] +
								" " +
								$data["box-shadow[blur]"] +
								" " +
								$data["box-shadow[spread]"] +
								" " +
								$data["box-shadow[color]"] +
								" " +
								$data["box-shadow[mode]"] +
								multiBoxShadow +
								important +
								";";
						} else {
							$inline_style =
								$inline_style +
								"box-shadow:" +
								" " +
								$data["box-shadow[x]"] +
								" " +
								$data["box-shadow[y]"] +
								" " +
								$data["box-shadow[blur]"] +
								" " +
								$data["box-shadow[color]"] +
								" " +
								$data["box-shadow[mode]"] +
								multiBoxShadow +
								important +
								";";
						}

						boxShadow = true;
					}
				} else if (field_name.indexOf("text-shadow") >= 0) {
					if (
						boxShadow == false &&
						typeof $data["text-shadow[x]"] != "undefined" &&
						typeof $data["text-shadow[y]"] != "undefined" &&
						typeof $data["text-shadow[blur]"] != "undefined" &&
						typeof $data["text-shadow[color]"] != "undefined"
					) {
						$inline_style =
							$inline_style +
							"text-shadow: " +
							" " +
							$data["text-shadow[x]"] +
							" " +
							$data["text-shadow[y]"] +
							" " +
							$data["text-shadow[blur]"] +
							" " +
							$data["text-shadow[color]"] +
							important +
							";";
						boxShadow = true;
					}
				} else if (field_name.indexOf("backdrop-filter") >= 0) {
					var fname = field_name.replace("backdrop-filter[", "").replace("]", "");
					if ($inline_style.indexOf("backdrop-filter:") >= 0) {
						$inline_style = $inline_style.replace(
							"backdrop-filter:",
							"backdrop-filter:" + fname + "(" + field_value + ") "
						);
					} else {
						$inline_style =
							$inline_style +
							"backdrop-filter:" +
							fname +
							"(" +
							field_value +
							")" +
							important +
							";";
					}
				} else if (field_name.indexOf("filter") >= 0) {
					var fname = field_name.replace("filter[", "").replace("]", "");
					if ($inline_style.indexOf("filter:") >= 0) {
						$inline_style = $inline_style.replace(
							"filter:",
							"filter:" + fname + "(" + field_value + ") "
						);
					} else {
						$inline_style =
							$inline_style + "filter:" + fname + "(" + field_value + ")" + important + ";";
					}
				} else if (field_name == "text-transform") {
					if (field_value) {
						$inline_style = $inline_style + field_name + ":" + field_value + important + ";";
					}
				} else if (field_name.indexOf("f_transform") >= 0) {
					var set = true;
					var fname = field_name.replace("f_transform[", "").replace("]", "");
					if (fname == "translate-x") {
						fname = "translate";
						if (typeof $data["f_transform[translate-y]"] == "undefined") {
							field_value = field_value + ", 0px";
						} else {
							field_value = field_value + ", " + $data["f_transform[translate-y]"];
						}
					} else if (fname == "skew-x") {
						fname = "skew";
						if (typeof $data["f_transform[skew-y]"] == "undefined") {
							field_value = field_value + ", 0deg";
						} else {
							field_value = field_value + ", " + $data["f_transform[skew-y]"];
						}
					} else if (fname == "skew-y") {
						if (typeof $data["f_transform[skew-x]"] == "undefined") {
							fname = "skew";
							field_value = "0deg, " + field_value;
						} else {
							set = false;
						}
					} else if (fname == "translate-y") {
						if (typeof $data["f_transform[translate-x]"] == "undefined") {
							fname = "translate";
							field_value = "0px, " + field_value;
						} else {
							set = false;
						}
					}
					if (set) {
						$inline_style = $inline_style.replace(/text-transform/g, "text-trans");
						if ($inline_style.indexOf("transform:") >= 0) {
							$inline_style = $inline_style.replace(
								"transform:",
								"transform:" + fname + "(" + field_value + ") "
							);
						} else {
							$inline_style =
								$inline_style +
								"transform:" +
								fname +
								"(" +
								field_value +
								")" +
								important +
								";";
						}
						$inline_style = $inline_style.replace(/text-trans/g, "text-transform");
					}

					// $inline_style = $inline_style + 'transform:' + fname + '(' + field_value + ')' + important + ';';
				} else if (field_name == "background-image") {
					$data[field_name] = "url(" + field_value + ")";
					$inline_style =
						$inline_style + field_name + ": url(" + field_value + ")" + important + ";";
				} else if (field_name == "background-image-none") {
					if ($data[field_name] == "none") {
						$inline_style = $inline_style + "background-image:" + field_value + ";";
					}
				} else if (field_name == "placeholder-color") {
					$btn.find('input[data-setting="' + $platform + "placeholder" + '"]').val("color: " + field_value + important + ";").trigger("input").trigger("styler_input");
				} else if ( field_name == "background-position-y" || field_name == "background-position-x" || field_name == "background-position" ) {
					if ($data["background-position"] == "custom") {
						if (
							typeof $data["background-position-x"] != "undefined" &&
							typeof $data["background-position-y"] != "undefined"
						) {
							var bpd = $data["background-position-x"] + " " + $data["background-position-y"];
							$inline_style = $inline_style.replace(/background-position:(.*);/i, "");
							$inline_style = $inline_style + "background-position:" + bpd + important + ";";
						} else if (typeof $data["background-position-x"] != "undefined") {
							var bpd = $data["background-position-x"];
							$inline_style = $inline_style.replace(/background-position:(.*);/i, "");
							$inline_style = $inline_style + "background-position:" + bpd + important + ";";
						}
					} else {
						$inline_style = $inline_style.replace(/background-position:(.*);/i, "");
						$inline_style =
							$inline_style + "background-position:" + field_value + important + ";";
					}
				} else if ( field_name == "background-size" || field_name == "background-x" || field_name == "background-y" ) {
					if ($data["background-size"] == "custom") {
						if (
							typeof $data["background-size-x"] != "undefined" &&
							typeof $data["background-size-y"] != "undefined"
						) {
							var bpd = $data["background-size-x"] + " " + $data["background-size-y"];
							$inline_style = $inline_style.replace(/background-size:(.*);/i, "");
							$inline_style = $inline_style + "background-size:" + bpd + important + ";";
						} else if (typeof $data["background-size-x"] != "undefined") {
							var bpd = $data["background-size-x"];
							$inline_style = $inline_style.replace(/background-size:(.*);/i, "");
							$inline_style = $inline_style + "background-size:" + bpd + important + ";";
						}
					} else {
						$inline_style = $inline_style.replace(/background-size:(.*);/i, "");
						$inline_style = $inline_style + "background-size:" + field_value + important + ";";
					}
				}
				// Gradient data
				else if (field_name == "background-color2" || field_name == "angel") {
					if (field_value) {
						if (field_name == "background-color2") {
							if ($data["background-color"]) {
								var angel = $data["angel"] ? $data["angel"] : "90deg";
								$inline_style = $inline_style + "background-image: linear-gradient(" + angel + ", " + $data["background-color"] + ", " + field_value + ")" + important + ";";
							} else {
								$inline_style = $inline_style + "background-color: " + field_value + important + ";";
							}
						} else {
							var angel = field_value ? field_value : "90deg";
							if ( !$data["background-image"] && $data["background-color"] && $data["background-color2"] ) {
								$inline_style = $inline_style + "background-image: linear-gradient(" + angel + ", " + $data["background-color"] + ", " + $data["background-color2"] + ") " + important + ";";
							}
						}
					}
				} else if (field_name == "font-family") {
					if (field_value) {
						$inline_style = $inline_style + field_name + ":" + field_value + important + ";";
					}
				} else {
					if (field_value) {
						$inline_style = $inline_style + field_name + ":" + field_value + important + ";";
					}
				}
			});
			DataInput.val($inline_style).trigger("input").trigger("styler_input");
			if (typeof elementor != "undefined") {
				$btn.find('input[type="hidden"]').each(function () {
					//  Add Miss Data
					if (!jQuery(this).val().trim()) {
						jQuery(this).val("outline: notset;").trigger("input").trigger("styler_input");
					}
				});
			}

			$dialog.find(".wp-color-result").each(function () {
				var $color = $(this).siblings(".wp-picker-input-wrap").find("#styler-color-option").val();
				if (typeof $color != "undefined") {
					$(this).css("background-color", $color);
				}
			});
		},
	};
})(jQuery);

/**
 * Setup Styler For Elementor
 *
 * @since	1.0.0
 */
var CURRENTCID;
var LoadedButtons = [];
jQuery(window).on("elementor:init", function () {
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

	var Btn;
	var Elementor_Kata_Styler = elementor.modules.controls.BaseData.extend(
		{
			onReady: function () {
				if (typeof LoadedButtons[this.model.cid] != "undefined") {
					return;
				}

				LoadedButtons[this.model.cid] = true;
				var self = this,
					cid = this.model.cid,
					Dialog = jQuery(".styler-wrap");
				jQuery(document).on( "click", ".styler-dialog-btn.elementor-control-styler-btn-" + cid, function () {
						Btn = jQuery(this);
						StylerCore.init(Dialog, Btn, self);
						CURRENTCID = cid;
						StylerCore.StylerSettings(Dialog, cid);
					}
				);
			},

			saveValue: function (inputs) {
				var obj = {};
				if (inputs) {
					this.ui.input = inputs;
				}
				this.ui.input.each(function (e) {
					var en = jQuery(this);
					obj[en.data("setting")] = en.val();
				});
				this.setValue(obj);
			},

			onBeforeDestroy: function () {
				StylerCore.destroy();
				this.saveValue();
			},

			applySavedValue: function applySavedValue() {
				var values = this.getControlValue(),
					inputs = this.$("[data-setting]"),
					self = this;

				_.each(values, function (value, key) {
					var input = inputs.filter(function () {
						return key === this.dataset.setting;
					});

					self.setInputValue(input, value);
				});
			},

			getControlValue: function getControlValue(key) {
				var values = this.container.settings.get(this.model.get("name"));

				if (!jQuery.isPlainObject(values)) {
					return {};
				}

				if (key) {
					var value = values[key];

					if (undefined === value) {
						value = "";
					}

					return value;
				}

				return elementorCommon.helpers.cloneObject(values);
			},

			setValue: function setValue(key, value) {
				if (typeof value == "undefined") {
					return;
				}
				var values = this.getControlValue();
				if ("object" === (typeof key === "undefined" ? "undefined" : _typeof(key))) {
					_.each(key, function (internalValue, internalKey) {
						values[internalKey] = internalValue;
					});
				} else {
					values[key] = value;
				}

				this.setSettingsModel(values);
			},

			updateElementModel: function updateElementModel(value, input) {
				var key = input.dataset.setting;
				this.setValue(key, value);
			},

			onDestroy: function onDestroy() {
				if (this.contextMenu) {
					this.contextMenu.destroy();
				}
			},
			setSettingsModel: function setSettingsModel(value) {
				var key = this.model.get("name");
				var $settings = {};
				$settings[key] = value;
				$e.run("document/elements/settings", {
					container: this.options.container,
					settings: $settings,
					options: {
						external: true,
						debounce: false,
					},
				});
				this.triggerMethod("filter:change");
			},
		},
		{
			// Static live methods
			getStyleValue: function getStyleValue(placeholder, controlValue) {
				if (!_.isObject(controlValue)) {
					return ""; // invalid
				}
				return controlValue[placeholder.toLowerCase()];
			},
		}
	);
	elementor.addControlView("kata_styler", Elementor_Kata_Styler);
});

/**
 * Setup Styler In Other Areas
 *
 * @since	1.0.0
 */
jQuery(window).ready(function () {
	if (typeof elementor != "undefined") {
		return;
	}
	var Dialog = jQuery(".styler-wrap");
	if (jQuery(".styler-dialog-btn").length) {
		jQuery(document).on("click", ".styler-dialog-btn", function () {
			jQuery(document).trigger("stylerLoad:before");
			jQuery("#elementor-panel-footer-responsive").find(".eicon-device-responsive").trigger("click");
			var Btn = jQuery(this);
			Dialog.find(".top-bar > strong").html( (jQuery("#elementor-panel-header-title").length > 0 ? jQuery("#elementor-panel-header-title").html().replace("Edit ", "") : "Styler") + " - " + Btn.data("title") );
			Dialog.find(".actions span").each(function () {
				jQuery(this).removeClass("active");
			});

			Dialog.find(".actions span").first().addClass("active");
			jQuery(".styler-wrap .content .styler-tab").removeClass("active");
			jQuery(".styler-wrap .content .styler-tab").first().addClass("active");
			StylerCore.init(Dialog, Btn, false);
		});
	}
});
