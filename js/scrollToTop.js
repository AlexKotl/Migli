/**
 * Created on 9/15/14.
 */

$.fn.scrollToTop = function () {

    var that = this;

    var option = {
        scrollOpacity: function () {
            if ($(window).scrollTop() <= 450) {
                $(that).fadeOut('fast')
            } else {
                $(that).fadeIn('fast')
            }
        },
        init: function () {
            $(that).on('click', function (e) {
                e.stopPropagation();
                $('html, body').animate({scrollTop:100},0,function(){$(this).animate({scrollTop:0},300)});
                option.scrollOpacity();
            });

            $(window).scroll(function (e) {
                e.preventDefault();
                option.scrollOpacity();
            });
        }
    }

    return option.init();
}
