import $ from "jquery";

/**
 *
 *  Manages how the sidebar operates on different screen widths
 *
 */

$(function () {

    let mobileView = false;
    let sidebarExtended = false;
    let mobileWidth = 768;

    let sidebarToggle = $('.top-bar-toggle');
    let width = $(window).width();
    let overlay = $('.overlay');

    let sidebar = $('.sidebar');
    let content = $('.content');

    // Add transition to sidebar after page load
    sidebar.addClass('sidebar--transition');
    content.addClass('content--transition');

    // Set mobileView on init
    mobileView = width < mobileWidth;

    // Set sidebarExtended to true if not in mobile mode
    if (!mobileView) {
        sidebarExtended = true;
    }

    $(window).resize(function () {
        width = $(window).width();

        mobileView = width < mobileWidth;

        if (mobileView) {
            content.css("paddingLeft", '15px');
            shrinkSidebar();
            sidebarToggle.removeClass("top-bar-toggle--active");
            sidebarExtended = false;
            overlay.hide();
        } else {
            content.css("paddingLeft", '255px');
            extendSidebar();
            sidebarExtended = true;
            sidebarToggle.removeClass("top-bar-toggle--active");
        }

    });

    sidebarToggle.click(function () {

        if (sidebarExtended) {
            content.css("paddingLeft", '20px');
            shrinkSidebar();
            sidebarExtended = false;
            if (mobileView) {
                sidebarToggle.removeClass("top-bar-toggle--active");
                overlay.fadeOut(200);
            }
        }
        else {
            extendSidebar();
            if (mobileView) {
                sidebarToggle.addClass("top-bar-toggle--active");
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

});