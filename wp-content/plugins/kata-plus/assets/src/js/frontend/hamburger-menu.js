(function ($) {

    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetHamburgerMenuHandler = function ($scope, $) {

        $('.kata-plus-hamburger-menu').find('.open-icon').on('click', function () {
            var $this = $(this),
                $wrap = $this.closest('.kata-plus-hamburger-menu'),
                $hamburger_template = $wrap.find('.kata-hamburger-menu-template');
            $hamburger_template.fadeIn('fast').addClass('open-hamburger');
            $this.fadeOut('slow').siblings().hide();
        });

        $('.kata-plus-hamburger-menu').find('.close-icon').on('click', function () {
            var $this = $(this),
                $wrap = $this.closest('.kata-plus-hamburger-menu'),
                $hamburger_template = $wrap.find('.kata-hamburger-menu-template');
            $hamburger_template.fadeOut('fast').removeClass('open-hamburger');
            $this.fadeOut('slow').siblings().fadeIn('slow');
        });
        $('.kata-hamburger-menu-template').find('.close-icon').on('click', function () {
            var $this = $(this),
                $wrap = $this.closest('.kata-plus-hamburger-menu');
            setTimeout(function () {
                $this.fadeIn('slow');
                $wrap.children('.icons-wrap').find('.close-icon').fadeOut('slow').siblings().fadeIn('slow');
            }, 1);
        });

        $('.kata-hamburger-slide').find('.open-icon').on('click', function () {
            var $this = $(this),
                $wrap = $this.closest('.kata-plus-hamburger-menu'),
                data_id = $wrap.data('id');
            $wrap.addClass('activated-hamburger-menu');
        });
        $('.kata-hamburger-slide').find('.close-icon').on('click', function () {
            var $this = $(this),
                $wrap = $this.closest('.kata-plus-hamburger-menu'),
                data_id = $wrap.data('id');
            $wrap.removeClass('activated-hamburger-menu');
        });

        $(document).keydown(function(e) {
            var code = e.keyCode || e.which;
            if (code == 27) $(".close-icon").trigger('click');
        });
        $(document).scroll(function() {
            if ( ! $('.kata-sticky-box').hasClass('sticky') ) {
                $('.kata-hamburger-menu-template').each(function (index, element) {
                    if( $(this).hasClass('open-hamburger') ) {
                        $(this).find('.close-icon').trigger('click');
                    }
                });
            }
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/kata-plus-hamburger-menu.default', WidgetHamburgerMenuHandler);
    });

})(jQuery);