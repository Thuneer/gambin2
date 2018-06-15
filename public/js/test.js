import jQuery from 'jquery';

jQuery( document ).ready(function($) {

    let tr = $('tbody tr');


    tr.each(function (index, element) {

        let arrow = $(this).find('.list__dropdown-icon');

        if (arrow.length !== 0) {

            let dropdown = $(this).next();

            arrow.click(function () {

                dropdown.toggleClass('list__dropdown--hidden');

            });

        }

    });


    

    $('.list__delete').click(function () {


        let id =  $(this).parent().parent().find('.list-id').val();
        let name = $(this).parent().parent().find('.list-name').val();
        console.log(id);
        //$(this).parent().find('#deleteModalText').html("ddd");
        $('#deleteModalText').html('Are you sure you want to delete ' + '<b>' + name + '</b>?');

        
    });



});
import jQuery from 'jquery';

jQuery(document).ready(function ($) {

    let sidebar = $('.sidebar');
    let content = $('.content');
    let toggle = $('.top-bar-toggle');
    let width = $(window).width();

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
            content.css("paddingLeft", '20px');
            shrinkSidebar();
            toggle.removeClass("top-bar-toggle--active");
            sidebarExtended = false;
        } else {
            content.css("paddingLeft", '250px');
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
            }
        }
        else {
            extendSidebar();
            if (mobileView)
                toggle.addClass("top-bar-toggle--active");
            else
                content.css("paddingLeft", '250px');

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
import jQuery from 'jquery';

jQuery( document ).ready(function($) {

let userContainer = $('.user-top__container');
let dropdown = $('.user-top__dropdown');
let icon = $('.user-top__icon');


userContainer.hover(function () {

    $('.user-top__dropdown').slideToggle(200);
    icon.toggleClass('user-top__icon--flipped');

});


});