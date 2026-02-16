(function ($) {
    "use strict";

    var tpj = jQuery;
    var revapi24;

    // Preloader //
    jQuery(window).on('load', function () {
        jQuery("#status").fadeOut();
        jQuery("#preloader").delay(350).fadeOut("slow");
    });

    // on ready function //
    jQuery(document).ready(function ($) {

        function quick_search() {
            'use strict';
            /* Quik search in header on click function */
            var quikSearch = $("#quik-search-btn");
            var quikSearchRemove = $("#quik-search-remove");

            quikSearch.on('click', function () {
                $('.dez-quik-search').animate({ 'width': '100%' });
                $('.dez-quik-search').delay(500).css({ 'left': '0' });
            });

            quikSearchRemove.on('click', function () {
                $('.dez-quik-search').animate({ 'width': '0%', 'right': '0' });
                $('.dez-quik-search').css({ 'left': 'auto' });
            });
            /* Quik search in header on click function End*/
        }
        quick_search();

        // ===== Scroll to Top ==== // 
        $(window).scroll(function () {
            if ($(this).scrollTop() >= 100) {
                $('#return-to-top').fadeIn(200);
            } else {
                $('#return-to-top').fadeOut(200);
            }
        });
        $('#return-to-top').on('click', function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
        });

        // sidebar submenu menu js Start //
        (function ($) {
            $(document).ready(function () {
                $('#mynavi li.active').addClass('open').children('ul').show();
                $('#mynavi li.has-sub>a').on('click', function () {
                    $(this).removeAttr('href');
                    var element = $(this).parent('li');
                    if (element.hasClass('open')) {
                        element.removeClass('open');
                        element.find('li').removeClass('open');
                        element.find('ul').slideUp(200);
                    }
                    else {
                        element.addClass('open');
                        element.children('ul').slideDown(200);
                        element.siblings('li').children('ul').slideUp(200);
                        element.siblings('li').removeClass('open');
                        element.siblings('li').find('li').removeClass('open');
                        element.siblings('li').find('ul').slideUp(200);
                    }
                });

            });
        })(jQuery);

        // sidebar submenu menu js End //

        // nice select //
        // $('select').niceSelect();


        // ------ cursor js ---------- //
        var $circleCursor = $('.cursor');

        function moveCursor(e) {
            var t = e.clientX + "px",
                n = e.clientY + "px";

            TweenMax.to($circleCursor, .2, {
                left: t,
                top: n,
                ease: 'Power1.easeOut'
            });
        }
        $(window).on('mousemove', moveCursor);

        // simple zoom
        function zoomCursor(e) {
            TweenMax.to($circleCursor, .1, {
                scale: 3,
                ease: 'Power1.easeOut'
            });
            $($circleCursor).removeClass('cursor-close');
        }
        $('a, .zoom-cursor').on('mouseenter', zoomCursor);

        // close
        function closeCursor(e) {
            TweenMax.to($circleCursor, .1, {
                scale: 3,
                ease: 'Power1.easeOut'
            });
            $($circleCursor).addClass('cursor-close');
        }
        $('.trigger-close').on('mouseenter', closeCursor);

        // default
        function defaultCursor(e) {
            TweenLite.to($circleCursor, .1, {
                scale: 1,
                ease: 'Power1.easeOut'
            });
            $($circleCursor).removeClass('cursor-close');
        }

        $('a, .zoom-cursor, .trigger-close, .trigger-plus').on('mouseleave', defaultCursor);



    });

})(jQuery);	