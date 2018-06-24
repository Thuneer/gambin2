import jQuery from 'jquery';

jQuery(document).ready(function ($) {

    let tr = $('tbody tr');
    let checkboxesChecked = 0;


    tr.each(function (index, element) {

        let arrow = $(this).find('.list__dropdown-icon');

        if (arrow.length !== 0) {

            let dropdown = $(this).next();

            arrow.click(function () {

                dropdown.toggleClass('list__dropdown--hidden');

            });

        }

    });


    $(document).on('click', '.list__delete', function () {


        let id = $(this).parent().parent().find('.list-id').val();
        let name = $(this).parent().parent().find('.list-name').val();
        console.log(id);
        //$(this).parent().find('#deleteModalText').html("ddd");
        $('#deleteModalText').html('Are you sure you want to delete ' + '<b>' + name + '</b>?');
        $('#deleteModalIds').val(id);


    });


    $('.search-mobile__toggle').click(function () {

        $('.search-mobile').slideToggle(200);

    });

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

        console.log(checkboxesChecked);

    });


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


    $(document).on('click', '.list-dropdown__icon', function () {

        let dropdown = $(this).parent().parent().next();


        $('.list-dropdown').each(function (index, element) {

            if (!dropdown.is($(element))) {

                $(element).hide();

            }

        });

        dropdown.fadeToggle(100);

    });


});