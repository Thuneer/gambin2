import $ from "jquery";

/**
 *
 *  Display image information in a modal when user clicks an image in media section
 *
 */

$(function () {


    // Adds media details to modal when clicking images

    $(document).on('click', '.grid__item', function () {
        addMediaDetails($(this).find('.imageInfo'));
    });

    $(document).on('click', '.list__link,.list__edit', function () {

        let element = $(this).parent().parent().find('.imageInfo');
        addMediaDetails(element);

    });

    $(document).on('click', '.list-dropdown__edit', function () {

        let element = $(this).parent().parent().parent().find('.imageInfo');
        addMediaDetails(element);

    });

    // Activates edit mode when user clicks the pencil next to name, title, or alt attribute
    $('.media-details__edit').click(function () {

        activateEditMode($(this).next().attr('data-column'));

    });

    // Deactivates edit mode when user clicks red cross in edit node
    $('.media-details__error').click(function () {

        deactivateEditMode($(this).prev().attr('data-column'));

    });

    // Adds the correct id to delete modal when user clicks delete button inside modal
    $('.media-details__delete').click(function () {

        let id = $('#detailsId').attr('data-details-id');
        $('#deleteModalIds').val(id);

    });

    // Starts editing table when user clicks check mark in edit mode
    $('.media-details__check').click(function () {

        let column = $(this).attr('data-column');
        let value = $(this).parent().parent().find('.media-details__input').val();
        editMedia(column, value);

    });

    // Sends ajax request to edit a column with a given value
    function editMedia(column, value) {

        let id = $('#detailsId').attr('data-details-id');

        $.ajax({
            url: '/admin/media/' + id + '/edit',
            data: {
                column: column,
                value: value
            },
            headers: {
                'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
            },
            type: 'POST',
            success: function (data) {

                let capColumn = capitalize(column);
                $('#media' + capColumn).text(data[column]);
                $('#media' + capColumn + 'Input').val(data[column]);
                deactivateEditMode(column);

                let listItemWithId = $('[data-id="' + id + '"]');
                listItemWithId.attr('data-' + column, value);

                // If the user changed name, then set the name in the list
                if (column === 'name') {
                    listItemWithId.parent().find('.list__title').html(value);
                }

            },
            error: function () {
                window.location.href = '/admin/media'
            }
        });

    }

    // Capitalizes a string
    function capitalize(s)
    {
        return s && s[0].toUpperCase() + s.slice(1);
    }

    // Adds all the data to the modal from the element data attributes
    function addMediaDetails(element) {
        $('#detailsId').attr('data-details-id', element.attr('data-id'));

        $('.media-details__img').prop('src', '/' + element.attr('data-path'));
        $('#mediaName').text(element.attr('data-name') === '' ? '-' : element.attr('data-name'));
        $('#mediaNameInput').val(element.attr('data-name'));
        $('#mediaTitle').text(element.attr('data-title') === '' ? '-' : element.attr('data-title'));
        $('#mediaTitleInput').val(element.attr('data-title'));
        $('#mediaAlt').text(element.attr('data-alt') === '' ? '-' : element.attr('data-alt'));
        $('#mediaAltInput').val(element.attr('data-alt'));
        $('#mediaExtension').text(element.attr('data-extension'));
        $('#mediaResolution').text(element.attr('data-resX') + ' x ' + element.attr('data-resY'));
        $('#mediaSize').text(element.attr('data-size'));
        $('#mediaPath').text(APP_URL + '/' + element.attr('data-path'));
    }

    // Activates edit mode when uer clicks edit on name, title, ot alt attribute
    function activateEditMode(column) {
        let check = $('[data-column="' + column +'"]');

        check.parent().parent().find('.media-details__input').show();
        check.parent().parent().find('.media-details__text').hide();
        check.css('display', 'inline-block');
        check.parent().find('.media-details__error').css('display', 'inline-block');
        check.prev().hide();
    }

    // Deactivates edit mode for name, title or alt attribute
    function deactivateEditMode(column) {

        let check = $('[data-column="' + column +'"]');

        check.parent().parent().find('.media-details__input').hide();
        check.parent().parent().find('.media-details__text').show();
        check.next().hide();
        check.hide();
        check.parent().find('.media-details__edit').show();

    }

});