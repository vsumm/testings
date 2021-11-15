(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetAccordionHandler = function ($scope, $) {

        $('.kata-accordion').on('click', function () {
            var $this = $(this);
            if ($this.hasClass('active')) {
                $this.removeClass('active');
                $this.find('.kata-accordion-content').slideUp()
            } else {
                $this.find('.kata-accordion-content').slideDown().parent('.kata-accordion').siblings().find('.kata-accordion-content').slideUp();
                $this.addClass('active').siblings().removeClass('active');
            }
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/kata-plus-accordion-toggle.default', WidgetAccordionHandler);
    });
})(jQuery);