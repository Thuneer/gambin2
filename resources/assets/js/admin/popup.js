import $ from "jquery";

/**
 *
 *  Popup modal
 *
 */

$(function () {

    let bodyElement = $('body');

    // Hides the popup
    $('[data-pophide]').click(function () {

        let id = $(this).data('pophide');

        let popup = $(document).find('#' + id);
        let overlay = popup.find('.popup__overlay');
        let main = popup.find('.popup__main');

        popup.fadeOut(150);
        overlay.fadeOut(150);
        main.fadeOut(250);

        bodyElement.removeClass('popup-open');
        bodyElement.trigger("popup-close");
    });

    // Shows the popup
    $(document).on('click', '[data-popshow]', function (e) {

        e.preventDefault();

        let id = $(this).data('popshow');

        let popup = $(document).find('#' + id);
        let overlay = popup.find('.popup__overlay');
        let main = popup.find('.popup__main');

        popup.fadeIn(250);
        overlay.fadeIn(250);
        main.fadeIn(250);

        bodyElement.addClass('popup-open');

    });

    // Hides popup when user clicks outside it
    $('.popup__overlay').click(function () {

        $(this).parent().fadeOut(250);
        $(this).fadeOut(250);
        $(this).next().fadeOut(250);

        bodyElement.removeClass('popup-open');
        bodyElement.trigger("popup-close");
    });

});