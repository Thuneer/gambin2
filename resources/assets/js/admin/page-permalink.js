import $ from "jquery";

$(function () {

    // PERMALINK
    $('#permalink-edit').click(function (e) {
        e.preventDefault();
        showEdit();
    });

    $('#permalink-add').click(function (e) {
        e.preventDefault();
        getPermalink();
    });


    $('#permalink-remove').click(function (e) {
        e.preventDefault();
        hideEdit();
    });

    let permaFlag = true;

    $("#page-title").focus(function() {})
        .blur(function() {
            if (permaFlag) {
                getPermalink();
            }
        });

    function showEdit() {
        $('#permalink-add').show();
        $('#permalink-remove').show();
        $('.permalink__input').show();
        $('#permalink-edit').hide();
    }

    function hideEdit() {
        $('#permalink-add').hide();
        $('#permalink-remove').hide();
        $('.permalink__input').hide();
        $('#permalink-edit').show();
    }

    function clearURL() {
        $('.permalink__url').text('');
    }

    function getPermalink() {

        $.ajax({
            url: '/admin/pages/permalink',
            data: {
                permalink: $('.permalink__input').val(),
                title: $('#page-title').val(),
                parent: $('#parent-select').val(),
                id: $('#page-id').val()
            },
            headers: {
                'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
            },
            type: 'GET',
            success: function (data) {

                console.log(data);
                $('.permalink__url').text(data['full']);
                hideEdit();
                permaFlag = false;
                $('.permalink__input').attr('value', data['semi']);

            },
            error: function (data) {
                clearURL();
                hideEdit();
                console.log(data);
            }
        });

    }

});