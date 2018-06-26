import jQuery from 'jquery';

jQuery(document).ready(function ($) {

    let sidebar = $('.sidebar');
    let content = $('.content');
    let toggle = $('.top-bar-toggle');
    let width = $(window).width();
    let overlay = $('.overlay');

    let mobileView = false;
    let sidebarExtended = false;
    let mobileWidth = 768;

// Set mobileView on init
    mobileView = width < mobileWidth;

// Set sidebarExtended to true if not in mobile mode
    if (!mobileView)
        sidebarExtended = true;

    $(window).resize(function () {
        width = $(window).width();

        mobileView = width < mobileWidth;

        if (mobileView) {
            content.css("paddingLeft", '15px');
            shrinkSidebar();
            toggle.removeClass("top-bar-toggle--active");
            sidebarExtended = false;
            overlay.hide();
        } else {
            content.css("paddingLeft", '255px');
            extendSidebar();
            sidebarExtended = true;
            toggle.removeClass("top-bar-toggle--active");
        }

    });

    toggle.click(function () {

        if (sidebarExtended) {
            content.css("paddingLeft", '20px');
            shrinkSidebar();
            sidebarExtended = false;
            if (mobileView) {
                toggle.removeClass("top-bar-toggle--active");
                overlay.fadeOut(200);
            }
        }
        else {
            extendSidebar();
            if (mobileView) {
                toggle.addClass("top-bar-toggle--active");
                overlay.fadeIn(200);
            }

            else
                content.css("paddingLeft", '255px');

            sidebarExtended = true;
        }

    });

    function extendSidebar() {
        sidebar.css("left", "0");
    }

    function shrinkSidebar() {
        sidebar.css("left", "-230px");
    }


    // Init all Bootstrap 4 tooltips
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });


    // Add transition to sidebar after page load
    sidebar.addClass('sidebar--transition');
    content.addClass('content--transition');


    $('[data-pophide]').click(function () {

        let id = $(this).data('pophide');

        let popup = $(document).find('#' + id);
        let overlay = popup.find('.popup__overlay');
        let main = popup.find('.popup__main');

        popup.fadeOut(150);
        overlay.fadeOut(150);
        main.fadeOut(250);

        $('body').removeClass('popup-open');
        $("body").trigger("popup-close");
    });

    $('[data-popshow]').click(function () {

        let id = $(this).data('popshow');

        let popup = $(document).find('#' + id);
        let overlay = popup.find('.popup__overlay');
        let main = popup.find('.popup__main');

        popup.fadeIn(250);
        overlay.fadeIn(250);
        main.fadeIn(250);

        $('body').addClass('popup-open');


    });

    $('.popup__overlay').click(function () {

        $(this).parent().fadeOut(250);
        $(this).fadeOut(250);
        $(this).next().fadeOut(250);

        $('body').removeClass('popup-open');
        $("body").trigger("popup-close");
    });


});