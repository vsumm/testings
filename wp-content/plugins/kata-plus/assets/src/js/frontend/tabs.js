(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetTabsHandler = function ($scope, $) {
        $('ul.kata-plus-tabs-item').each(function () {
            // For each set of tabs, we want to keep track of
            // which tab is active and its associated content
            var $active, $content, $links = $(this).find('li').find('a'),
                hash = window.location.hash.replace('#', '');

            // If the location.hash matches one of the links, use that as the active tab.
            // If no match is found, use the first link as the initial active tab.
            $active = $($links.filter('[href="' + location.hash + '"]')[0] || $links[0]);
            $active.parent('li').addClass('active').siblings().removeClass('active');
            $('.kata-plus-tabs-content[id="' + hash + '"]').fadeIn().siblings().fadeOut();
            $('.kata-plus-tabs-content[id="' + hash + '"]').addClass('active').siblings().removeClass('active');

            $content = $($active[0].hash);

            $(this).on('click', 'li a', function (e) {
                console.log(1);
                e.preventDefault();
            });

            // Bind the click event handler
            $(this).on('click', 'li', function (e) {
                // Make the old tab inactive.
                var $this = $(this),
                    $wrap = $this.closest('.kata-plus-tabs'),
                    hash = $this.find('a').attr('href').replace('#', '');

                // Tabs and contents
                $this.addClass('active').siblings().removeClass('active');
                $wrap.find('.kata-plus-tabs-content[id="' + hash + '"]').show().siblings().hide();
                $wrap.find('.kata-plus-tabs-content[id="' + hash + '"]').addClass('active').siblings().removeClass('active');

                // Prevent the anchor's default click action
                e.preventDefault();
            });
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/kata-plus-tabs.default', WidgetTabsHandler);
    });
})(jQuery);