import jQuery from 'jquery';
import hoverIntent from 'jquery-hoverintent';

jQuery( document ).ready(function($) {

let userContainer = $('.user-top__container');
let dropdown = $('.user-top__dropdown');
let icon = $('.user-top__icon');


userContainer.hoverIntent(function () {

    $('.user-top__dropdown').slideToggle(200);
    icon.toggleClass('user-top__icon--flipped');

});


});