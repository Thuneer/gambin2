import $ from 'jquery';
import hoverIntent from 'jquery-hoverintent';

/**
 *
 *  Top bar
 *
 */

$(function () {

    let userContainer = $('.user-top__container');
    let icon = $('.user-top__icon');

    userContainer.hoverIntent(function () {

        $('.user-top__dropdown').slideToggle(200);
        icon.toggleClass('user-top__icon--flipped');

    });

});