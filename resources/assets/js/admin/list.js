import $ from 'jquery';

/**
 *
 *  Mostly click events related to the list / table displaying data
 *
 */

$(function () {

    let checkboxesChecked = 0;

    // Sets the text and id in the delete modal when user clicks delete button
    $(document).on('click', '.list__delete', function () {

        let id = $(this).parent().parent().find('.list-id').val();
        let name = $(this).parent().parent().find('.list-name').val();

        $('#deleteModalText').html('Are you sure you want to delete ' + '<b>' + name + '</b>?');
        $('#deleteModalIds').val(id);

    });

    // Sets the text and id in the delete modal when user clicks delete button on mobile devices
    $(document).on('click', '.list-dropdown__delete', function () {

        let id = $(this).parent().parent().parent().find('.list-id').val();
        let name = $(this).parent().parent().parent().find('.list-name').val();

        $('#deleteModalText').html('Are you sure you want to delete ' + '<b>' + name + '</b>?');
        $('#deleteModalIds').val(id);

    });


    // Selects all checkboxes when user clicks the checkbox next to table headers
    $('#bulkCheckbox').click(function () {

        let checkboxes = $('.list__checkbox');

        if ($(this).is(':checked')) {

            checkboxes.each(function (index, element) {

                $(element).prop('checked', true);
                checkboxesChecked = ++index;

            });

            if(checkboxes.length > 0)
                $('#deleteBulkBtn').prop('disabled', false);

        } else {

            checkboxes.each(function (index, element) {

                $(element).prop('checked', false);
                checkboxesChecked = 0;
                $('#deleteBulkBtn').prop('disabled', true);

            });

        }

    });

    // Selects a row when user clicks a checkbox
    $('.list__checkbox').click(function () {

        if ($(this).is(':checked')) {
            checkboxesChecked++;
        } else {
            checkboxesChecked--;
        }

        if (checkboxesChecked === 0) {
            $('#deleteBulkBtn').prop('disabled', true);
        } else {
            $('#deleteBulkBtn').prop('disabled', false);
        }

    });

    // Deletes selected rows when the delete bulk button is clicked
    $('#deleteBulkBtn').click(function () {

        let checkboxes = $('.list__checkbox:checkbox:checked');
        let name = '';
        let text = '';
        let ids = '';

        if (checkboxes.length === 1) {
            name = $(checkboxes[0]).parent().parent().find('.list-name').val();
            text += `Are you sure you want to delete <b> ${name} </b> ?`;
        }
        else
            text += `<div class="delete-modal__title">Are you sure you want to the delete the following:</div><ul class="delete-modal__list">`;

        checkboxes.each(function (index, element) {

            ids += $(element).parent().parent().find('.list-id').val();
            name = $(element).parent().parent().find('.list-name').val();

            if (index < 5 && checkboxes.length > 1) {
                text += `<li>${name}</li>`;
            }

            if (checkboxes.length > index + 1) {
                console.log(checkboxes.length + ' - ' + index);
                ids += ',';
            }

        });

        if (checkboxes.length > 1) {
            text += `</ul>`;
        }

        if (checkboxes.length > 5) {
            if (checkboxes.length === 6)
                text += 'and ' + (checkboxes.length - 5) + ' other?';
            else
                text += 'and ' + (checkboxes.length - 5) + ' others?';
        }

        $('#deleteModalIds').val(ids);

        $('#deleteModalText').html(text);

    });

    // Hovering over table headers shows sort arrows
    $('.list__sort-btn').hover(function () {

        let arrow = $(this).next();

        if (arrow.hasClass('list__sort-arrow--active')) {

            if (arrow.hasClass('list__sort-arrow--up')) {
                arrow.removeClass('list__sort-arrow--up');
            }
            else {
                arrow.addClass('list__sort-arrow--up');
            }

        } else {
            arrow.removeClass('list__sort-arrow--hidden');
        }


    }, function () {

        let arrow = $(this).next();

        if (arrow.hasClass('list__sort-arrow--active')) {

            if (arrow.hasClass('list__sort-arrow--up')) {
                arrow.removeClass('list__sort-arrow--up');
            }
            else {
                arrow.addClass('list__sort-arrow--up');
            }


        } else {
            arrow.addClass('list__sort-arrow--hidden');
        }

    });

    // Slides down search on mobile devices
    $('.search-mobile__toggle').click(function () {

        $('.search-mobile').slideToggle(200);

    });

    // Shows more table data by clicking dropdown button in mobile mode
    $(document).on('click', '.list-dropdown__show', function () {

        let dropdown = $(this).parent().parent().next();

        $('.list-dropdown').each(function (index, element) {

            if (!dropdown.is($(element))) {

                $(element).hide();

            }

        });

        dropdown.fadeToggle(100);

    });

});