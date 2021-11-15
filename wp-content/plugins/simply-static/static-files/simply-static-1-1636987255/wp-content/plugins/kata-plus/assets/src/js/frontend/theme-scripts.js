/**
 * Theme Scripts.
 *
 * @author  ClimaxThemes
 * @package	Kata Plus
 * @since	1.0.0
 */
'use strict';

var Kata_Plus_Scripts = (function ($) {
	/**
	 * Global variables.
	 *
	 * @since	1.0.0
	 */
	var $window = $(window);
	var content = '';
	var runOnceTime = false;
	var onetime = false;
	var TemplateOneTime = false;
	return {
		/**
		 * Init.
		 *
		 * @since	1.0.0
		 */
		init: function (elementorPreview) {
			if (onetime === false) {
				this.Gdpr();
				this.PostMeta();
				onetime = true;
			}
			if (runOnceTime == false) {
				runOnceTime = true;
				this.backToTop();
				this.Animations();
			}
			if (elementorPreview == false) {
				this.FullPageSlider();
			}
		},

		/**
		 * Svg Fixer.
		 *
		 * @since	1.0.0
		 */
		Animations: function () {
			$('[class*="elementor-widget-kata"] *:not(.kata-onscreen-animloaded)').each(function (index, element) {
				const $this = $(this);
				if( $this.css('--triggeranimation') == 'pageloaded' ) {
					if (!$this.hasClass('kata-onscreen-animloaded')) {
						$(this).addClass('kata-onscreen-animloaded');
					}
				}
				if ( $this.css('--triggeranimation') ) {
					$this.closest('.elementor-widget-container').addClass('kata-anim');
				}	
			});
			$(window).on('scroll', function () {
				$('[class*="elementor-widget-kata"] *:not(.kata-onscreen-animloaded)').each(function (index, element) {
					const $this = $(this);
					if( $this.css('--triggeranimation') == 'onscreen' ) {
						if (!$this.hasClass('kata-onscreen-animloaded')) {
							var offset = $(this).offset(),
							  top = Math.round(offset.top - 500);
							if ($(window).scrollTop() >= top) {
							  $(this).addClass('kata-onscreen-animloaded');
							}
						}
					}		
				});
			});
		},

		/**
		 * Full Page Slider.
		 *
		 * @since	1.0.0
		 */
		FullPageSlider: function () {
			var $fullpageslider = $('.kata-full-page-slider');
			if ($fullpageslider.length > 0) {
				var data = $fullpageslider.data();
				$fullpageslider.fullpage({
					licenseKey: '87258B1C-E97F4235-86313F6C-156D94A6',
					sectionSelector: '.elementor-top-section',
					navigation: data.navigation,
					navigationPosition: data.navigationPosition,
					scrollingSpeed: data.scrollingSpeed,
					loopBottom: data.loopBottom,
					loopTop: data.loopTop,
					fixedElements: '.kata-header-wrap, .kata-footer, .kata-page-title',
					css3: true,
					scrollingSpeed: 700,
					autoScrolling: true,
					fitToSection: true,
					fitToSectionDelay: 1000,
					easing: 'easeInOutCubic',
					easingcss3: 'ease',
				});
			}
		},

		/**
		 * Gdpr.
		 *
		 * @since	1.0.0
		 */
		Gdpr: function () {
			$('.kata-gdpr-box').find('.gdpr-button-agree').find('button').on('click', function (e) {

				$('.kata-gdpr-box').addClass('hide');
				e.preventDefault();
				$.ajax({
					url: kata_plus_localize.ajax.url,
					type: 'POST',
					data: {
						nonce: kata_plus_localize.ajax.nonce,
						action: 'set_cookie',
						gdprcookie: 'true',
					},
				});
			});
		},

		/**
		 * postmeta fixer.
		 *
		 * @since	1.0.0
		 */
		PostMeta: function () {
			$('.kata-post-metadata').each(function (index, element) {
				if ($(this).html() == '') {
					$(this).remove();
				}
			});
		},

		/**
		 * Get Query String Value.
		 *
		 * @since	1.0.0
		 */
		getQueryStringValue: function (key) {
			return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
		},

		/**
		 * Check element in viewport.
		 *
		 * @since	1.0.0
		 */
		inViewport: function (e) {
			return ($window.scrollTop() + $window.height()) >= e.offset().top - 1000;
		},

		/**
		 * Back to top button.
		 *
		 * @since	1.0.0
		 */
		backToTop: function () {
			$(window).on('scroll', function () {
				100 < $(this).scrollTop() ? $('.scrollup').fadeIn() : $('.scrollup').fadeOut()
			});
			$('.scrollup').on('click', function () {
				return $('html, body').animate({
					scrollTop: 0
				}, 700), !1
			});
		},
	};
})(jQuery);

// Check Backend or Frontend
if (Kata_Plus_Scripts.getQueryStringValue('elementor-preview')) {
	// Elementor preview
	jQuery(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
			Kata_Plus_Scripts.init(true);
		});
	});
} else {
	// Frontend
	jQuery(document).ready(function () {
		Kata_Plus_Scripts.init(false);
	});
}