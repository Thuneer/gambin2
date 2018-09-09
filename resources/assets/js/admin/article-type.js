import $ from 'jquery';

/**
 *
 *  Handles changing between the two article types
 *
 */

$(function() {

    $('#regular').click(function () {
       console.log("regular");
        $('.form__group--summernote').show();
        $('#pagebuilder-container').hide();
    });

    $('#pagebuilder').click(function () {
        console.log("pagebuilder");
        $('.form__group--summernote').hide();
        $('#pagebuilder-container').show();

    });

});