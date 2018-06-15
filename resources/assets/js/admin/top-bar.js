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