(function ($) {

	/**
	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var WidgetDarkModeHandler = function ($scope, $) {
		var wpDarkMode = {"config":{"brightness":100,"contrast":90,"sepia":10},"enable_preset":false,"customize_colors":false,"colors":{"bg":"#000","text":"#dfdedb","link":"#e58c17"},"enable_frontend":true,"enable_backend":true,"enable_os_mode":true,"excludes":"rs-fullwidth-wrap,.mejs-container","includes":"","is_excluded":false,"remember_darkmode":false,"default_mode":false,"keyboard_shortcut":true,"images":"","is_pro_active":false,"is_ultimate_active":false,"pro_version":0,"is_elementor_editor":false,"is_block_editor":false,"frontend_mode":false};
		const is_saved = localStorage.getItem('wp_dark_mode_active');
	
		if ((is_saved && is_saved != 0) || (!is_saved && wpDarkMode.default_mode)) {
			const isCustomColor = parseInt('');
	
			if (!isCustomColor) {
				//remove preload css
				if (document.getElementById('pre_css')) {
					document.getElementById('pre_css').remove();
				}
				DarkMode.enable();
			}
		}
	}

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/kata-plus-darkmode-switcher.default', WidgetDarkModeHandler);
	});

})(jQuery);