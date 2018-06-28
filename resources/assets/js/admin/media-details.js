import jQuery from "jquery";

(function ($) {

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

    $('.media-details__edit').click(function () {

        activeEdit($(this).next().attr('data-column'));

    });

    $('.media-details__error').click(function () {

        deactivateEdit($(this).prev().attr('data-column'));

    });

    $('.media-details__delete').click(function () {

        let id = $('#detailsId').attr('data-details-id');
        $('#deleteModalIds').val(id);

    });

    $("body").on("popup-close", function () {
    });

    $('.media-details__check').click(function () {

        let column = $(this).attr('data-column');
        let value = $(this).parent().parent().find('.media-details__input').val();
        editMedia(column, value);

    });

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
                deactivateEdit(column);

                let test = $('[data-id="' + id + '"]');
                test.attr('data-' + column, value);

                if (column === 'name')
                    test.parent().find('.list__title').html(value);


            },
            error: function (data) {
                window.location.href = '/admin/media'
            }
        });

    }

    function capitalize(s)
    {
        return s && s[0].toUpperCase() + s.slice(1);
    }

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

    function activeEdit(column) {
        let check = $('[data-column="' + column +'"]');

        check.parent().parent().find('.media-details__input').show();
        check.parent().parent().find('.media-details__text').hide();
        check.css('display', 'inline-block');
        check.parent().find('.media-details__error').css('display', 'inline-block');
        check.prev().hide();
    }

    function deactivateEdit(column) {

        let check = $('[data-column="' + column +'"]');

        check.parent().parent().find('.media-details__input').hide();
        check.parent().parent().find('.media-details__text').show();
        check.next().hide();
        check.hide();
        check.parent().find('.media-details__edit').show();

    }

}(jQuery));