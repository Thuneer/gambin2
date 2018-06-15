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
                overlay.hide();
            }
        }
        else {
            extendSidebar();
            if (mobileView) {
                toggle.addClass("top-bar-toggle--active");
                overlay.show();
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


    $(document).on('click', '.grid__item', function () {

        let item = $(this).find('[data-info]').data('info');

        $('.media-details__img').css('background-image', 'url(' + '/' + item.path + ')');
        $('#mediaName').html(item.name);
        $('#mediaSize').html(item.size);
        $('#mediaExtension').html(item.extension);
        $('#mediaUpdated').html(item.updated);

    });

});