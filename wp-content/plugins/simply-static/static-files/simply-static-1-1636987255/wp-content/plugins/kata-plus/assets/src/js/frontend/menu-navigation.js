(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */

    var WidgetMenuNavigationHandler = function ($scope, $) {
        if ($.fn.superfish) {
            $('.kata-menu-navigation').superfish({
                delay: 500, // one second delay on mouseout
                animation: {
                    opacity: 'show',
                    height: 'show'
                }, // fade-in and slide-down animation
                speed: 'fast', // faster animation speed
                autoArrows: false // disable generation of arrow mark-up
            });
        }
        // mega menu
        if ($('.menu-item-object-kata_mega_menu').length > 0) {
            $('.menu-item-object-kata_mega_menu').each(function (index, element) {
                var $this = $(this);
                $this.closest('.kata-header-wrap').addClass('have-mega-menu');
                $this.closest('.kata-sticky-header-wrap').addClass('have-mega-menu');
            });
            // $('.mega-menu-content').each(function () {
            //     if ($(this).hasClass('kata-mega-full-width')) {
            //         var $this = $(this);
            //         var isVisible = $this.is(':visible');
            //         if (!isVisible) {
            //             $this.show(); // must be visible to get .position
            //         }
            //         var leftPos = this.getBoundingClientRect().left + window.scrollX;
            //         if (!isVisible) {
            //             $this.hide();
            //         }
            //         $(this).css({
            //             'width': $('body').width() + 'px',
            //             'left': -leftPos,
            //         });
            //     }
            // });
        }
        // vertical menu
        if ($scope.find('.kata-menu-vertical').length > 0) {
            $scope.find('.kata-menu-vertical').find('.menu-item-has-children').find('.parent-menu-icon').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    $wrap = $this.closest('.menu-item-has-children'),
                    $submenu = $wrap.children('.sub-menu');
                console.log($submenu);
                $this.toggleClass('submenu-close-icon');
                setTimeout(function () {
                    if ($this.hasClass('submenu-close-icon')) {
                        $submenu.slideDown();
                    } else {
                        $submenu.slideUp();
                    }
                }, 1);

            });
        }
        // responsive close
        $('.kata-responsive-menu-wrap').find('.cm-ham-close-icon').on('click', function () {
            var $this = $(this),
                $wrap = $this.closest('.kata-responsive-menu-wrap');
            if ($wrap.css('left') == '0px') {
                $wrap.css('left', '-110%');
            }
        });
        // responsive open
        $('.kata-menu-wrap').find('.cm-ham-open-icon').on('click', function () {
            var $this = $(this),
                $wrap = $this.closest('.kata-menu-wrap'),
                $menu = $wrap.find('.kata-responsive-menu-wrap');
            if ($menu.css('left') < '0') {
                $menu.css('left', '0');
            }
        });
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/kata-plus-menu-navigation.default', WidgetMenuNavigationHandler);
    });
})(jQuery);